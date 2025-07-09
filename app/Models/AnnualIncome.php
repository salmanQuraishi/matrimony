<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnualIncome extends Model
{
    use HasFactory;
    protected $fillable = ['range','status'];
    protected $table = 'annual_incomes';
    protected $primaryKey = 'aid';
    
    public function users()
    {
        return $this->hasMany(User::class, 'annual_income_id', 'aid');
    }

}
