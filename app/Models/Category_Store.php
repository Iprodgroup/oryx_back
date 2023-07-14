<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_Store extends Model
{
    use HasFactory;

    protected $connection = 'mysql_admin';
    protected $table = 'category_store';
}
