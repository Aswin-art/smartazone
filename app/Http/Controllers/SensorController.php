<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class SensorController extends Controller
{
    public function updateLogHiker(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id'   => 'nullable|integer',
            'mountain_id'  => 'nullable|integer',
            'heart_rate'   => 'nullable|numeric|min:0|max:250',
            'stress_level' => 'nullable|numeric|min:0|max:100',
            'spo2'         => 'nullable|numeric|min:0|max:100',
            'latitude'     => 'nullable|numeric|between:-90,90',
            'longitude'    => 'nullable|numeric|between:-180,180',
            'timestamp'    => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors(),
            ], 422);
        }

        try {
            $id = DB::table('mountain_hiker_logs')->insertGetId([
                'booking_id'   => $request->input('booking_id'),
                'mountain_id'  => $request->input('mountain_id'),
                'heart_rate'   => $request->input('heart_rate'),
                'stress_level' => $request->input('stress_level'),
                'spo2'         => $request->input('spo2'),
                'latitude'     => $request->input('latitude'),
                'longitude'    => $request->input('longitude'),
                'timestamp'    => $request->input('timestamp') ?? now(),
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
