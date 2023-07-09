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
        Schema::create('wali_banks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wali_id')->comment('wali id adalah primary key di user id');
            $table->foreignId('bank_id')->index();
            $table->string('nama_rekening');
            $table->string('nomor_rekening');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wali_banks');
    }
};
