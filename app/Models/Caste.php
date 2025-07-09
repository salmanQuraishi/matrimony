<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Caste extends Model
{
    use HasFactory;

    protected $fillable = ['religionid', 'name', 'description', 'status'];
    protected $primaryKey = 'cid';

    public function religion()
    {
        return $this->belongsTo(Religion::class, 'religionid', 'rid');
    }
}
