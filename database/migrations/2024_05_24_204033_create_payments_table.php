<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedSmallInteger('patient_id');
            $table->string('city', 70);
            $table->string('state', 70);
            $table->string('postal_code', 14);
            $table->string('payment_method', 70);
            $table->decimal('amount', total:8, places:2);
            $table->tinyInteger('status')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
