<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_path extends Model
{
    use HasFactory;

    protected $table = 'category_path';

    protected $primaryKey = ['category_id', 'path_id'];
}
