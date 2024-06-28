<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    protected $fillable = ['company_id'];
}
