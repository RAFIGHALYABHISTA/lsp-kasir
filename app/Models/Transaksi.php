<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    //
    protected $table = 'transaksi';
    protected $fillable = ['tanggal_transaksi','total' ];
    protected $casts = [
        'tanggal_transaksi' => 'datetime',
    ];

    public function transaksiDetails()
    {
        return $this->hasMany(TransaksiDetail::class, 'transaksi_id');
    }
}
