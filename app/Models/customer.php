<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    use HasFactory;
    protected $fillable = ['firstName', 'lastName', 'email', 'phone', 'address','user_id','address'];

    function invoice()
    {
        return $this->hasMany(Invoice::class);
    }
}
