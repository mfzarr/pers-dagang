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
        // stok_barang migration
        Schema::create('stok_barang', function (Blueprint $table) {
            $table->id();

            // Change id_pembelian_barang to string to match no_transaksi_pembelian in pembelian
            $table->string("id_pembelian_barang");
            $table->foreign("id_pembelian_barang")
                ->references("no_transaksi_pembelian")
                ->on("pembelian")
                ->onDelete("cascade");

            // Define nama_barang to refer to id_barang in barang table
            $table->unsignedBigInteger("nama_barang");
            $table->foreign("nama_barang")
                ->references("id_barang")
                ->on("barang")
                ->onDelete("cascade");

            $table->bigInteger("stok");
            $table->bigInteger("harga_satuan");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_barang');
    }
};
