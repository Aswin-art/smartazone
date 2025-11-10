<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MountainDeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $devices = [];

        for ($i = 1; $i <= 10; $i++) {
            $devices[] = [
                'battery_level' => rand(40, 100),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('mountain_devices')->insert($devices);
    }
}
