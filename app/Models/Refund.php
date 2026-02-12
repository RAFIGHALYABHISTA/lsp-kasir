<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $table = 'refunds';
    protected $fillable = [
        'transaksi_id',
        'jumlah_refund',
        'status',
        'alasan',
        'keterangan',
        'tanggal_refund',
    ];

    protected $casts = [
        'tanggal_refund' => 'datetime',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
