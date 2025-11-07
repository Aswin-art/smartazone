<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Validation\Rule;

class SensorController extends Controller
{
    public function updateLogHiker(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id'   => 'required|integer',
            'mountain_id'  => 'required|integer',
            'device_id'    => 'required|integer',
            'heart_rate'   => 'nullable|numeric|min:0|max:250',
            'stress_level' => 'nullable|numeric|min:0|max:100',
            'spo2'         => 'nullable|numeric|min:0|max:100',
            'latitude'     => 'nullable|numeric|between:-90,90',
            'longitude'    => 'nullable|numeric|between:-180,180',
            'status'       => ['required', Rule::in(['TRUE', 'FALSE'])],
            'timestamp'    => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors(),
            ], 422);
        }

        try {
            $validated = $validator->validated();

            $id = DB::table('mountain_hiker_logs')->insertGetId([
                'booking_id'   => $validated['booking_id'],
                'mountain_id'  => $validated['mountain_id'],
                'device_id'    => $validated['device_id'],
                'heart_rate'   => $validated['heart_rate'] ?? null,
                'stress_level' => $validated['stress_level'] ?? null,
                'spo2'         => $validated['spo2'] ?? null,
                'latitude'     => $validated['latitude'] ?? null,
                'longitude'    => $validated['longitude'] ?? null,
                'status'       => $validated['status'],
                'timestamp'    => $validated['timestamp'] ?? now(),
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            $data = DB::table('mountain_hiker_logs')->where('id', $id)->first();

            return response()->json([
                'status'  => 'success',
                'message' => 'Data log berhasil disimpan.',
                'data'    => $data,
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
