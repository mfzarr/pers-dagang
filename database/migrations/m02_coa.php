<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('coa_kelompok', function (Blueprint $table) {
            $table->id();
            $table->string('kelompok_akun');
            $table->string('nama_kelompok_akun');
            $table->string('header_akun')->nullable();
        });

        Schema::create('coa', function (Blueprint $table) {
            $table->id('id_coa');
            $table->string('kode');
            $table->string('nama_akun');
            $table->string('kelompok_akun');
            $table->string('posisi_d_c');
            $table->boolean('saldo_awal')->default(0);
            $table->unsignedBigInteger('id_perusahaan');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coa');
        Schema::dropIfExists('coa_kelompok');
    }
};
