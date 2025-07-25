<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $primaryKey = 'gid';
    protected $table = 'galleries';
    protected $fillable = ['user_id','image_path'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
