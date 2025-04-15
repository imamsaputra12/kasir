<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->increments('penjualan_id');
            $table->integer('pelanggan_id')->unsigned()->nullable();
            $table->json('produk_id'); // Mengubah menjadi JSON untuk menyimpan banyak produk
            $table->string('kode_pembayaran')->unique();
            $table->date('tanggal_penjualan');
            $table->decimal('total_bayar', 10, 2);
            $table->decimal('jumlah_bayar', 10, 2)->default(0);
            $table->decimal('kembalian', 10, 2)->default(0);
            $table->enum('metode_pembayaran', ['cash', 'transfer', 'credit_card', 'e_wallet'])->default('cash');
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualans');
    }
}
