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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nik',16);
            $table->string('nip',18);
            $table->string('nama_depan',20);
            $table->string('nama_belakang',20);
            $table->enum('jenis_kelamin',['L','P']);
            $table->unsignedTinyInteger('agama_id');
            $table->enum('golongan_darah',['O-','O+','A+','A-','B+','B-','AB-','AB+']);
            $table->unsignedTinyInteger('jenis_kawin_id');
            $table->string('tempat_lahir',50);
            $table->date('tanggal_lahir');
            $table->string('email_kantor',50);
            $table->string('email_pribadi',50);
            $table->string('no_telp',13);
            $table->unsignedTinyInteger('jenis_pegawai_id');
            $table->unsignedTinyInteger('status_pegawai_id');
            $table->boolean('status_dinas');
            $table->string('tanggal_berhenti')->nullable(true);
            $table->string('tanggal_wafat')->nullable(true);
            $table->unsignedBigInteger('media_kartu_pegawai_id')->nullable(true);
            $table->string('no_bpjs',13);
            $table->string('no_taspen',50)->nullable(true);
            $table->string('npwp',16)->nullable(true);
            $table->string('no_enroll',50)->nullable(true)->comment('no_urut_finger');
            $table->unsignedBigInteger('media_foto_id')->nullable(true);

            $table->timestamps();
            $table->foreign('agama_id')->references('id')->on('agama')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('jenis_kawin_id')->references('id')->on('jenis_kawin')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('jenis_pegawai_id')->references('id')->on('jenis_pegawai')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('status_pegawai_id')->references('id')->on('status_pegawai')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('media_kartu_pegawai_id')->references('id')->on('media')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('media_foto_id')->references('id')->on('media')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
