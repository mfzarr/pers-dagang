<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create pembelian table
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id('id_pembelian'); // Primary key
            $table->string('no_transaksi_pembelian')->unique();
            $table->date('tanggal_pembelian');

            $table->unsignedBigInteger('supplier');
            $table->foreign('supplier')
                ->references('id_supplier')
                ->on('supplier')
                ->onDelete('cascade');

            $table->unsignedBigInteger('id_perusahaan');
            $table->foreign('id_perusahaan')
                ->references('id_perusahaan')
                ->on('perusahaan')
                ->onDelete('cascade');

            $table->decimal('total', 15, 2)->default(0);
            $table->decimal('total_dibayar', 15, 2)->default(0);
            $table->string('tipe_pembayaran')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        // Create pembelian_detail table
        Schema::create('pembelian_detail', function (Blueprint $table) {
            $table->id('id_pembelian_detail');

            // Add id_pembelian as foreign key
            $table->unsignedBigInteger('id_pembelian');
            $table->foreign('id_pembelian')
                ->references('id_pembelian')
                ->on('pembelian')
                ->onDelete('cascade');

            // Add id_produk as foreign key
            $table->unsignedBigInteger('id_produk');
            $table->foreign('id_produk')
                ->references('id_produk')
                ->on('produk')
                ->onDelete('cascade');

            $table->integer('qty');
            $table->decimal('harga', 15, 2);
            $table->decimal('sub_total_harga', 15, 2)->virtualAs('qty * harga');
            $table->decimal('dibayar', 15, 2)->default(0);
            $table->timestamps();
        });

        // Create pelunasan_pembelian table
        Schema::create('pelunasan_pembelian', function (Blueprint $table) {
            $table->id('id_pelunasan');

            $table->unsignedBigInteger('id_pembelian');
            $table->foreign('id_pembelian')
                ->references('id_pembelian')
                ->on('pembelian')
                ->onDelete('cascade');

            $table->unsignedBigInteger('id_produk');
            $table->foreign('id_produk')
                ->references('id_produk')
                ->on('produk')
                ->onDelete('cascade');


            $table->decimal('total_pelunasan', 15, 2);
            $table->date('tanggal_pelunasan');
            $table->timestamps();
        });

        // Trigger to update total_dibayar on pembelian table
        DB::unprepared('
            CREATE TRIGGER after_pelunasan_insert AFTER INSERT ON pelunasan_pembelian
            FOR EACH ROW
            BEGIN
                UPDATE pembelian
                SET total_dibayar = (
                    SELECT IFNULL(SUM(total_pelunasan), 0)
                    FROM pelunasan_pembelian
                    WHERE id_pembelian = NEW.id_pembelian
                )
                WHERE id_pembelian = NEW.id_pembelian;

                IF (SELECT total FROM pembelian WHERE id_pembelian = NEW.id_pembelian) 
                   <= (SELECT total_dibayar FROM pembelian WHERE id_pembelian = NEW.id_pembelian) THEN
                    UPDATE pembelian SET status = "Lunas"
                    WHERE id_pembelian = NEW.id_pembelian;
                ELSE
                    UPDATE pembelian SET status = "Belum Lunas"
                    WHERE id_pembelian = NEW.id_pembelian;
                END IF;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_pelunasan_insert');
        Schema::dropIfExists('pelunasan_pembelian');
        Schema::dropIfExists('pembelian_detail');
        Schema::dropIfExists('pembelian');
    }
};
