<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function specs()
    {
        return $this->hasMany(Spec::class);
    }
}
