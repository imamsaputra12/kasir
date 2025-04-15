<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $primaryKey ='pelanggan_id';
    protected $table ='pelanggans';
    protected $fillable = [
        'nama_pelanggan','alamat','nomor_telepon','latitude','longitude'
    ];

    // app/Models/Penjualan.php

public function penjualan()
{
    return $this->hasMany(Transaksi::class, 'pelanggan_id');
}

}
