<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $primaryKey ='produk_id';
    protected $table ='produks';
    protected $fillable = [
        'nama_produk', 'harga', 'stok', 'image'
    ];    

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class, 'produk_id', 'produk_id');
    }
}
