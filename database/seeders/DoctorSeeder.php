<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use Illuminate\Support\Str;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            Doctor::create([
                'name' => 'Doctor ' . Str::random(5), 
                'lastname' => 'Doctor ' . Str::random(5), 
                'specialty' => 'Dueño ' . Str::random(5), 
                'type_document' => rand(0,1) == 1 ? true : false,
                'document' => mt_rand(1000000, 9999999),
                'phone' => mt_rand(10000000, 99999999),
                'email' => 'doctor' . $i . '@gmail.com',
                'address' => 'Calle ' . Str::random(5)
            ]);
        }
    }
}
