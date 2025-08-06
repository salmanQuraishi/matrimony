<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebSetting extends Model
{
    
    use HasFactory;
    protected $table = 'settings';
    protected $fillable = ['id', 'title', 'email', 'mobile', 'address', 'logo', 'logo_dark', 'favicon'];

}