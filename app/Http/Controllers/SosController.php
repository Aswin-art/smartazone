<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SosController extends Controller
{
    public function trigger(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id'  => 'required|integer|exists:mountain_devices,id',
            'lattitude'   => 'required|numeric|between:-90,90',
            'longitude'  => 'required|numeric|between:-180,180',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors(),
            ], 422);
        }

        DB::table('mountain_sos_signals')->insert([
            'device_id'  => $validator->validated()['device_id'],
            'lattitude'   => $validator->validated()['lattitude'],
            'longitude'  => $validator->validated()['longitude'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'SOS triggered successfully.',
        ]);

    }
}
