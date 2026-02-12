<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['nama', 'no_telepon', 'alamat', 'email'];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
