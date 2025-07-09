<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Religion extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status'];
    protected $primaryKey = 'rid';

    public function castes()
    {
        return $this->hasMany(Caste::class, 'religionid', 'rid');
    }
    public function users()
    {
        return $this->hasMany(User::class, 'religion_id', 'rid');
    }

}
