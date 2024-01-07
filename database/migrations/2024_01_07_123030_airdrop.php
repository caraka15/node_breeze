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
        Schema::create('airdrops', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('link')->nullable();
            $table->string('frekuensi');
            $table->boolean('sudah_dikerjakan')->default(false);
            $table->boolean('selesai')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airdrops');
    }
};
