<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->unique()->constrained('users')->nullOnDelete();
            $table->string('no_rm', 20)->unique();
            $table->string('nik', 16)->unique();
            $table->string('name', 150);
            $table->enum('gender', ['L', 'P']);
            $table->string('birth_place', 100)->nullable();
            $table->date('birth_date');
            $table->enum('blood_type', ['A', 'B', 'AB', 'O', '-'])->default('-');
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->text('allergy')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
