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
        Schema::create('jasa', function (Blueprint $table) {
            $table->id('id_jasa');
            $table->string('nama', 50);
            $table->text('detail');
            $table->integer('harga');
            $table->timestamps();

            $table->foreignId('id_perusahaan');
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan')->onDelete('cascade');
        });

        Schema::create('jasa_detail', function (Blueprint $table) {
            $table->id('id_jasa_detail');
            $table->integer('kuantitas');

            $table->foreignId('id_jasa');
            $table->foreignId('id_barang');

            // Foreign key constraints
            $table->foreign('id_jasa')->references('id_jasa')->on('jasa')->onDelete('cascade');
            $table->foreign('id_barang')->references('id_barang')->on('barang')->onDelete('cascade');

            $table->timestamps();
        });

              
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jasa');
    }
};
