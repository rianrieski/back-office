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
        Schema::create('pegawai_cuti', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pegawai_id');
            $table->unsignedTinyInteger('jenis_cuti_id');
            $table->date('tanggal_awal_cuti');
            $table->date('tanggal_akhir_cuti');
            $table->string('alasan');
            $table->string('alamat_cuti');
            $table->string('no_telepon_cuti',15);
            $table->unsignedBigInteger('atasan_pertama_id')->nullable(true);
            $table->date('tanggal_approve_ap')->comment('ap : atasan_pertama , ak : atasan kedua')->nullable(true);
            $table->unsignedBigInteger('atasan_kedua_id')->nullable(true);
            $table->date('tanggal_approve_ak')->comment('ap : atasan_pertama , ak : atasan kedua')->nullable(true);
            $table->date('tanggal_penolakan_cuti')->nullable(true)->nullable(true);
            $table->unsignedTinyInteger('status_pengajuan_cuti_id')->nullable(true);
            $table->string('alasan_penolakan_cuti')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_cuti');
    }
};
