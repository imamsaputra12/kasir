<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('produks', function (Blueprint $table) {
        $table->increments('produk_id');
        $table->string('nama_produk');
        $table->decimal('harga');
        $table->integer('stok');
        $table->string('image')->nullable();  // Add this line for storing image path
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
        Schema::dropIfExists('produks');
    }
}
