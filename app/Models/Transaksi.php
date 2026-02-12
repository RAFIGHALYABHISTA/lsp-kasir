<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    //
    protected $table = 'transaksi';
    protected $fillable = ['tanggal_transaksi','total', 'customer_id' ];
    protected $casts = [
        'tanggal_transaksi' => 'datetime',
    ];

    public function transaksiDetails()
    {
        return $this->hasMany(TransaksiDetail::class, 'transaksi_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class, 'transaksi_id');
    }
}
