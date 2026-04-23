<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NikahCard extends Model
{
    protected $fillable = [
        'user_id',
        'template_name',
        'template_path',
        'card_path',
        'card_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}