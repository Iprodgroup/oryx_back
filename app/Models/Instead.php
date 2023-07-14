<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instead extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'link',
        'price',
        'count',
        'size',
        'color',
        'delivery',
        'comment',
        'collebration',
        'status',
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
