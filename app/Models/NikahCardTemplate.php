<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NikahCardTemplate extends Model
{
    protected $fillable = [
        'name',
        'function_name',
        'image_path',
        'status',
        'sort_order',
    ];
}