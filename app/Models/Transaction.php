<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'count',
        'tenge',
        'type',
        'order',
        'outgo',
        'parcel_id',
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function parcel()
    {
        return $this->belongsTo(Parcel::class);
    }

    public function parcels()
    {
        return $this->belongsToMany(Parcel::class, 'transaction_parcels');
    }
}
