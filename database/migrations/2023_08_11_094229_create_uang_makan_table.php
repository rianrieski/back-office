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
        Schema::create('uang_makan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('golongan_id')->nullable()->constrained('golongan')->nullOnDelete();
            $table->unsignedBigInteger('nominal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uang_makan');
    }
};
