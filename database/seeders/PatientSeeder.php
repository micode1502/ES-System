<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use Illuminate\Support\Str;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            Patient::create([
                'name' => 'Paciente ' . Str::random(5), 
                'lastname' => 'Paciente ' . Str::random(5), 
                'email' => 'paciente' . $i . '@gmail.com',
                'phone' => mt_rand(10000000, 99999999),
                'type_document' => rand(0,1) == 1 ? true : false,
                'document' => mt_rand(1000000, 9999999),
                'date_birth' => '1990-01-01',
                'gender' => rand(0,1) == 1 ? true : false,
                'address' => 'Calle ' . Str::random(5),
                'status' => rand(0,1) == 1 ? true : false,
            ]);
        }
    }
}
