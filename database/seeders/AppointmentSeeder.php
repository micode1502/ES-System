<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Support\Str;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::pluck('id')->toArray();
        $doctors = Doctor::pluck('name')->toArray();
        for($i = 0; $i <= 5; $i++){
            $patientId = $patients[array_rand($patients)];
            Appointment::create([
                'patient_id' => $patientId,
                'doctor' => $doctors[array_rand($doctors)],
                'date' => '2023-01-01',
                'start' => '12:00:00'
            ]);
        }
    }
}
