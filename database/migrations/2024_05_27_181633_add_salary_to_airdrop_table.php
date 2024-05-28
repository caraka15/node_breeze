<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('airdrops', function (Blueprint $table) {
            // Ubah tipe kolom dari decimal ke integer
            $table->integer('salary')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *a
     * @return void
     */
    public function down()
    {
        Schema::table('airdrops', function (Blueprint $table) {
            // Kembalikan tipe kolom ke decimal
            $table->integer('salary')->nullable();
        });
    }
};
