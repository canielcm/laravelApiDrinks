<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table="category";
    protected $filltable=[
        'name',
        'amount',
        'description'
    ];

    public function drinks(){
        return $this->hasMany('App\Models\Drink');
    }
}
