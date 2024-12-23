<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presensi', function (Blueprint $table) {
            $table->id('id_presensi');
            $table->unsignedBigInteger('id_karyawan'); // Foreign key to the karyawan table
            $table->date('tanggal_presensi'); // The date of attendance
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha', 'terlambat']); // Status of the attendance
            $table->unsignedBigInteger('id_perusahaan'); // Foreign key to the perusahaan table
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawan')->onDelete('cascade');
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};
