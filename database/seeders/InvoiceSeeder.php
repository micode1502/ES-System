<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Str;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payments = Payment::pluck('id')->toArray();
        for($i = 0; $i <= 5; $i++){
            $paymentId = $payments[array_rand($payments)];
            Invoice::create([
                'payment_id' => $paymentId,
                'number' => mt_rand(10000000, 99999999),
                'date' => '2023-01-01',
                'amount' => 100.00,
                'status' => rand(0,1) ? true : false,
            ]);
        }
    }
}
