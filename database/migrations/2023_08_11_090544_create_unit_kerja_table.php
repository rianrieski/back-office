<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('unit_kerja', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->foreignId('parent_id')->nullable()->constrained('unit_kerja')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('jenis_unit_kerja_id')->nullable()->constrained('jenis_unit_kerja')->cascadeOnUpdate()->nullOnDelete();
            $table->string('singkatan', 10)->nullable();
            $table->string('keterangan', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_kerja');
    }
};
