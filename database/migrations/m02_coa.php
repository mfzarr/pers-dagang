<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Membuat tabel coa_kelompok
        Schema::create('coa_kelompok', function (Blueprint $table) {
            $table->id('id_kelompok_akun'); // Menggunakan bigInteger sebagai primary key
            $table->integer('kelompok_akun');
            $table->string('nama_kelompok_akun');
            $table->unsignedBigInteger('id_perusahaan');
            $table->timestamps();
    
            // Foreign key ke tabel 'perusahaan'
            $table->foreign('id_perusahaan')
                  ->references('id_perusahaan')
                  ->on('perusahaan')
                  ->onDelete('cascade');
    
            // Foreign key ke kolom 'kelompok_akun' di tabel yang sama
            // $table->foreign('header_akun')
            //       ->references('kelompok_akun')
            //       ->on('coa_kelompok')
            //       ->onDelete('set null');
        });         

        // Membuat tabel coa
        Schema::create('coa', function (Blueprint $table) {
            $table->id('id_coa');
            $table->integer('kode_akun')->length(4);
            $table->string('nama_akun');
            $table->unsignedBigInteger('kelompok_akun'); // Kolom ini digunakan untuk foreign key
            $table->string('posisi_d_c');
            $table->integer('saldo_awal')->default(0);
            $table->string('status')->default('manual'); // New column added here
            $table->unsignedBigInteger('id_perusahaan');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_perusahaan')
                  ->references('id_perusahaan')
                  ->on('perusahaan')
                  ->onDelete('cascade');

            // Foreign key ke kolom 'kelompok_akun' di tabel 'coa_kelompok'
            $table->foreign('kelompok_akun')
                  ->references('id_kelompok_akun')
                  ->on('coa_kelompok')
                  ->onDelete('cascade');
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
