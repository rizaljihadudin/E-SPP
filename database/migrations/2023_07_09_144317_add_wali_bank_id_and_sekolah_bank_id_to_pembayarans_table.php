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
        Schema::table('pembayarans', function (Blueprint $table) {
            //
            $table->foreignId('bank_wali_id')->nullable()->after('wali_id');
            $table->foreignId('bank_sekolah_id')->nullable()->after('bank_wali_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropColumn('bank_wali_id');
            $table->dropColumn('bank_sekolah_id');
        });
    }
};
