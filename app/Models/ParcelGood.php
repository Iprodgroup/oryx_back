<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use \Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParcelGood extends Model
{
    use HasFactory, RevisionableTrait, SoftDeletes;

    protected $fillable = [
        'parcel_id',
        'name',
        'currency',
        'price',
    ];
}
