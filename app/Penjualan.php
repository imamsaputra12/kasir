<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $primaryKey ='penjualan_id';
    protected $table ='penjualans';
    protected $fillable =[
        'pelanggan_id','produk_id','kode_pembayaran','tanggal_penjualan','total_bayar','jumlah_bayar','kembalian','metode_pembayaran','status'
    ];

    // app/Models/Penjualan.php
public function pelanggan()
{
    return $this->belongsTo(Pelanggan::class, 'pelanggan_id', 'pelanggan_id');
}


public function produk()
{
    return $this->belongsTo(Produk::class, 'produk_id', 'produk_id');
}

}
