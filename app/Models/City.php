<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $primaryKey = 'cityid';
    protected $table = 'city';
    protected $fillable = ['title', 'state_id', 'status'];

    public function users()
    {
        return $this->hasMany(User::class, 'city_id', 'cityid');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'sid');
    }
}