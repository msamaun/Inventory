<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'unit_price', 'user_id', 'category_id','quantity','image'];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
