<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $table="purchases";
    protected $filltable=[
        'user_id',
        'home_id',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function home(){
        return $this->belongsTo('App\Models\Home');
    }

    public function drinkPurchases(){
        return $this->belongsToMany('App\Models\DrinkPurchase');
    }

}
