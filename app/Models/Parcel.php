<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use \Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parcel extends Model
{
    use HasFactory, RevisionableTrait, SoftDeletes;

    protected $fillable = [
        'user_id',
        'recipient_id',
        'name',
        'track',
        'status',
        'country',
        'country_out',
        'city',
        'prod_price',
        'pid',
        'weight',
        'date_out',

        'payed',
        'in_fio',
        'in_city',
        'in_address',
        'in_comment',
        'in_track',
        'in_date',
        'in_phone',
        'in_status',

        //Integration
        'integration_id'
        //
    ];

    protected $dates = [
        'date_out',
        'in_date',
    ];

    public function recipient()
    {
        return $this->hasOne('App\Models\Recipient', 'id', 'recipient_id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function goods()
    {
        return $this->hasMany('App\Models\ParcelGood', 'parcel_id', 'id');
    }

    public function country_out_object()
    {
        return $this->belongsTo(Setting::class, 'country_out', 'id');
    }

    public function getFromAttribute()
    {
        return $this->country_out_object()->first()->name ?? '';
    }

    public static function boot() {
        parent::boot();
        static::deleting(function($item) {
            $item->goods()->delete();
        });
    }

    public function scopeWithAndWhereHas($query, $relation, $constraint){
        return $query->whereHas($relation, $constraint)
                     ->with([$relation => $constraint]);
    }

    public function scopeWithAndWhereHasOr($query, $relation, $constraint){
        return $query->orWhereHas($relation, $constraint)
                     ->with([$relation => $constraint]);
    }
}
