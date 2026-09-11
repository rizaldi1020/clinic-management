<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id')->constrained('bills')->cascadeOnDelete();
            $table->decimal('amount', 14, 2);
            $table->enum('payment_method', ['tunai', 'debit', 'kredit', 'transfer', 'qris', 'bpjs', 'asuransi'])->default('tunai');
            $table->dateTime('payment_date');
            $table->string('reference_number', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
