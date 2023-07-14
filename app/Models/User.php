<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

use \Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements HasMedia,MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, InteractsWithMedia, RevisionableTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'balance',
        'cashback',
        'tariff_id',
        'fname',
        'surname',
        'settings',
        'social_id',
        'address',
        'city',
        'fio',
        'ref_id',
        //Integration
        'id_orx'
        //
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'settings' => 'array',
    ];

    public function recipients()
    {
        return $this->hasMany('App\Models\Recipient', 'user_id', 'id');
    }

    public function ref()
    {
        return $this->hasOne('App\Models\User', 'id', 'ref_id');
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

    public function setting(string $name, $default = null)
    {
        if(!$this->settings) $this->settings = [];

        if (array_key_exists($name, $this->settings)) {
            return $this->settings[$name];
        }    return $default;
    }

    public function settings(array $revisions, bool $save = true) : self
    {
        $this->settings = array_merge($this->settings, $revisions);
        if ($save) {
            $this->save();
        }
        return $this;
    }

    public function parcelStatusCount($status=0)
    {
        return $this->hasMany('App\Models\Parcel', 'user_id', 'id')->where('status',$status)->count();
    }

    public function parcelActiveCount($status=0)
    {
        return $this->hasMany('App\Models\Parcel', 'user_id', 'id')->count();
    }

    public function tariffObj()
    {
        return $this->belongsTo(Setting::class, 'tariff_id', 'id');
    }

    public function getTariffAttribute()
    {
      
    }

    public function getPAttribute() {
        $p1 = substr($this->phone, 0, 1);
        $p2 = substr($this->phone, 1, 3);
        $p3 = substr($this->phone, 4, 3);
        $p4 = substr($this->phone, 7, 2);
        $p5 = substr($this->phone, 9, 2);

        return "+{$p1} ({$p2}) {$p3}-{$p4}-{$p5}";
    }
}
