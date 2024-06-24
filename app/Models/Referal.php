<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referal extends Model
{
    use HasFactory;

    public function friend() {
        return $this->hasOne(User::class, 'id', 'friend_id');
    }
}
