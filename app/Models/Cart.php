<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table="carts";
    protected $filltable=[
        'user_id',
        'drink_id',
        'amount'
    ];

    public function drinks(){
        return $this->hasMany('App\Models\Drink');
    }

    public function users(){
        return $this->belongsToMany('App\Models\User');
    }
}
