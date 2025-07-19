<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterestNot extends Model
{
    use HasFactory;
    protected $table = "not_interests";
    protected $fillable = [
        'user_id',
        'not_interest_user_id',
        'status',
    ];
    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'not_interest_user_id');
    }

}
