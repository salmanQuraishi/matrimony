<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $primaryKey = 'sid';
    protected $table = 'state';
    protected $fillable = ['name', 'status'];

    public function users()
    {
        return $this->hasMany(User::class, 'state_id', 'sid');
    }
}