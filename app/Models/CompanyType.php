<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyType extends Model
{
    protected $fillable = ['name', 'status'];
    protected $primaryKey = 'ctid';
    public function users()
    {
        return $this->hasMany(User::class, 'company_type_id', 'ctid');
    }
    
}