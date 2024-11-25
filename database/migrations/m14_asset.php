<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id('id_assets');
            $table->string('nama_asset');
            $table->decimal('harga_perolehan', 15, 2);
            $table->decimal('nilai_sisa', 15, 2);
            $table->integer('masa_manfaat'); // in years
            $table->timestamps();

            $table->foreignId('id_perusahaan');
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('assets');
    }
};

