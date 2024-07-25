<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Availability;
use App\Models\Doctor;
use Illuminate\Support\Str;

class AvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = Doctor::pluck('id')->toArray();
        for($i = 0; $i <= 5; $i++){
            $doctorId = $doctors[array_rand($doctors)];
            Availability::create([
                'doctor_id' => $doctorId,
                'day' => rand(1,7),
                'hour_start' => '02:00',
                'duration' => rand(1,2)
            ]);
        }
    }
}
