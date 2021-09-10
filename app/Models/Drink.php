<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drink extends Model
{
    use HasFactory;
    protected $table="drinks";
    protected $filltable=[
        'category_id',
        'amount',
        'description',
        'name',
        'brand',
        'price',
        'urlimg',
        'abv',
        'discount'
    ];
    public function category(){
        return $this->belongsTo('App\Models\Category');
    }
    public function carts(){
        return $this->belongsToMany('App\Models\Cart');
    }
    public function drinkPurchases(){
        return $this->belongsToMany('App\Models\DrinkPurchase');
    }
}
