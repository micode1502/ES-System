<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\Payment;
use Illuminate\Support\Str;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::pluck('id')->toArray();
        for($i = 0; $i <= 5; $i++){
            $patientId = $patients[array_rand($patients)];
            Payment::create([
                'patient_id' => $patientId,
                'city' => 'Ciudad' . str::random(5),
                'state' => 'Estado' . str::random(5),
                'postal_code' => '12345',
                'payment_method' => 'Credit Card',
                'amount' => 100.00,
                'status' => rand(0,1) ? true : false,
            ]);
        }
    }
}
