<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;
    protected $table = 'user_notification';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'title', 'body', 'image', 'is_read'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
