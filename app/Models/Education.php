<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'educations';
    protected $primaryKey = 'eid';
    protected $fillable = ['name','status'];
    public function users()
    {
        return $this->hasMany(User::class, 'education_id', 'eid');
    }

}