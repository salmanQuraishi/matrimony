<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobType extends Model
{
    protected $fillable = ['name', 'status'];
    protected $primaryKey = 'jtid';
    public function users()
    {
        return $this->hasMany(User::class, 'job_type_id', 'jtid');
    }

}