<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePelanggansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->increments('pelanggan_id');
            $table->string('nama_pelanggan');
            $table->text('alamat');
            $table->string('nomor_telepon');
            $table->decimal('latitude', 10, 7)->nullable();  // Add latitude
            $table->decimal('longitude', 10, 7)->nullable(); // Add longitude
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
        Schema::dropIfExists('pelanggans');
    }
}
