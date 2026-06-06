<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'countries';
    protected $fillable = ['name', 'shortname', 'phonecode'];

    public function users()
    {
        return $this->hasMany(User::class, 'country_id', 'id');
    }
}