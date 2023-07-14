<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use \Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipient extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, RevisionableTrait, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'fname',
        'surname',
        'country',
        'city',
        'pnum',
        'pby',
        'pdate',
        'phone',
        'address',
        'confirm',
        'fio',
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
        ->width(47)
        ->height(47);
        $this->addMediaConversion('mini-thumb')
        ->width(24)
        ->height(24);
    }
}
