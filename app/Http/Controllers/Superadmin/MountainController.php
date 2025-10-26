<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MountainController extends Controller
{
    public function index()
    {
        return view('dashboard.superadmin.mountains.index');
    }

    public function getData(Request $request)
    {
        $search = $request->search;
        $status = $request->status;
        $dateFrom = $request->dateFrom;
        $dateTo = $request->dateTo;
        $start = $request->start;
        $length = $request->length;
        $orderColumn = $request->order_column ?? 'created_at';
        $orderDir = $request->order_dir ?? 'desc';

        $query = DB::table('mountains')->select('*');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('subdomains', 'like', "%{$search}%");
            });
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        if (!empty($dateFrom)) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if (!empty($dateTo)) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $totalRecords = $query->count();

        if (!empty($orderColumn)) {
            $query->orderBy($orderColumn, $orderDir);
        }

        $mountains = $query->offset($start)->limit($length)->get();

        return response()->json([
            'data' => $mountains,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
        ]);
    }
    public function show($id)
    {
        $mountain = DB::table('mountains')->where('id', $id)->first();
        if (!$mountain) abort(404);

        $mountain->gallery = json_decode($mountain->gallery ?? '[]', true);
        $mountain->faq = json_decode($mountain->faq ?? '[]', true);
        $mountain->meta = json_decode($mountain->meta ?? '{}', true);

        $bookings = DB::table('mountain_bookings')
            ->join('users', 'mountain_bookings.user_id', '=', 'users.id')
            ->where('mountain_bookings.mountain_id', $id)
            ->select('mountain_bookings.*', 'users.name as user_name')
            ->get();

        $equipments = DB::table('mountain_equipments')->where('mountain_id', $id)->get();

        $equipmentRentals = DB::table('mountain_equipment_rentals')
            ->join('mountain_equipments', 'mountain_equipment_rentals.equipment_id', '=', 'mountain_equipments.id')
            ->where('mountain_equipment_rentals.mountain_id', $id)
            ->select('mountain_equipment_rentals.*', 'mountain_equipments.name as equipment_name')
            ->get();

        $sosSignals = DB::table('mountain_sos_signals')->where('mountain_id', $id)->get();
        $feedbacks = DB::table('mountain_feedbacks')->where('mountain_id', $id)->get();
        // $complaints = DB::table('mountain_complaints')->where('mountain_id', $id)->get();
        $hikerLogs = DB::table('mountain_hiker_logs')->where('mountain_id', $id)->get();

        $stats = [
            'total_bookings' => $bookings->count(),
            'total_equipment' => $equipments->count(),
            'total_rentals' => $equipmentRentals->count(),
            'total_feedback' => $feedbacks->count(),
            // 'total_complaints' => $complaints->count(),
            'total_sos' => $sosSignals->count(),
            'total_logs' => $hikerLogs->count(),
        ];

        return view('dashboard.superadmin.mountains.show', compact(
            'mountain',
            'bookings',
            'equipments',
            'equipmentRentals',
            'sosSignals',
            'feedbacks',
            // 'complaints',
            'hikerLogs',
            'stats'
        ));
    }


    public function edit($id)
    {
        $mountain = DB::table('mountains')->where('id', $id)->first();
        if (!$mountain) abort(404);
        $mountain->gallery_json = $this->toPrettyJson($mountain->gallery ?? '[]');
        $mountain->faq_json = $this->toPrettyJson($mountain->faq ?? '[]');
        $mountain->meta_json = $this->toPrettyJson($mountain->meta ?? '{}');
        return view('dashboard.superadmin.mountains.edit', compact('mountain'));
    }

    public function update(Request $request, $id)
    {
        $raw = $request->all();

        [$faqArr, $faqErr] = $this->decodeJsonArray($raw['faq'] ?? null, 'faq');
        $parseErrors = array_filter([$faqErr]);

        $validator = Validator::make([
            'name' => $raw['name'] ?? null,
            'location' => $raw['location'] ?? null,
            'subdomains' => $raw['subdomains'] ?? null,
            'description' => $raw['description'] ?? null,
            'status' => $raw['status'] ?? null,
            'content' => $raw['content'] ?? null,
            'faq' => $faqArr,
            'meta' => $raw['meta'] ?? null,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'subdomains' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'status' => ['required', Rule::in(['active', 'inactive', 'pending'])],
            'content' => ['nullable', 'string'],
            'faq' => ['nullable', 'array'],
            'faq.*.question' => ['required', 'string'],
            'faq.*.answer' => ['required', 'string'],
            'meta' => ['nullable', 'array'],
            'meta.elevation' => ['nullable', 'numeric'],
            'meta.difficulty' => ['nullable', Rule::in(['easy', 'moderate', 'hard', 'expert'])],
            'meta.estimated_duration' => ['nullable', 'string', 'max:255'],
            'banner_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'gallery.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if (!empty($parseErrors)) {
            foreach ($parseErrors as $err) {
                $validator->after(function ($v) use ($err) {
                    $v->errors()->add('json', $err);
                });
            }
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $payload = [
            'name' => $validated['name'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'updated_at' => now(),
        ];

        if (array_key_exists('subdomains', $raw)) {
            $payload['subdomains'] = $raw['subdomains'];
        }

        if (array_key_exists('content', $raw)) {
            $payload['content'] = $raw['content'] ?: null;
        }

        if (!is_null($faqArr)) {
            $payload['faq'] = json_encode($faqArr, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        if (!empty($validated['meta'])) {
            $payload['meta'] = json_encode($validated['meta'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        if ($request->hasFile('banner_image')) {
            $path = $request->file('banner_image')->store('mountains/banner', 'public');
            $payload['banner_image_url'] = Storage::url($path);
        }

        $galleryUrls = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('mountains/gallery', 'public');
                $galleryUrls[] = Storage::url($path);
            }
            $payload['gallery'] = json_encode($galleryUrls, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        DB::table('mountains')->where('id', $id)->update($payload);

        return redirect()->route('superadmin.mountains.index')
            ->with('success', 'Data gunung berhasil diperbarui.');
    }


    private function toPrettyJson($value): string
    {
        if (is_null($value) || $value === '') return '';
        if (is_array($value) || is_object($value)) {
            return json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
        $decoded = json_decode((string)$value, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
        return (string)$value;
    }

    private function decodeJsonArray($input, string $field): array
    {
        if (is_null($input) || $input === '') return [null, null];
        if (is_array($input)) return [$input, null];
        $decoded = json_decode($input, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return [$decoded, null];
        }
        return [null, "Field {$field} harus berupa JSON array yang valid."];
    }

    private function decodeJsonObject($input, string $field): array
    {
        if (is_null($input) || $input === '') return [null, null];
        if (is_array($input)) return [$input, null];
        $decoded = json_decode($input, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return [$decoded, null];
        }
        return [null, "Field {$field} harus berupa JSON object yang valid."];
    }


    public function deactivate(Request $request, $id)
    {
        DB::table('mountains')
            ->where('id', $id)
            ->update([
                'status' => 'inactive',
                'updated_at' => now()
            ]);

        return response()->json(['success' => true, 'message' => 'Gunung berhasil dinonaktifkan.']);
    }

    public function destroy($id)
    {
        DB::table('mountains')->where('id', $id)->delete();

        return response()->json(['success' => true, 'message' => 'Gunung berhasil dihapus.']);
    }
}
