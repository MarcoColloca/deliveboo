<?php

namespace App\Models;

use App\Http\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory, HasSlug;


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    protected $fillable = ['name', 'slug', 'image', 'description', 'ingredients', 'price', 'visible', 'company_id'];
}
