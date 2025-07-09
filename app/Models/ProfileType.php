<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProfileType extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'status'];
    protected $primaryKey = 'ptid';

    public function users()
    {
        return $this->hasMany(User::class, 'profile_for', 'ptid');
    }

}