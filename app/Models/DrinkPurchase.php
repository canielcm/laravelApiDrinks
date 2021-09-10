<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrinkPurchase extends Model
{
    use HasFactory;
    protected $table="drink_purchases";
    protected $filltable=[
        'purchase_id',
        'drink_id',
        'amount'
    ];

    public function purchase(){
        return $this->belongsToMany('App\Models\Purchase');
    }
    public function drinks(){
        return $this->belongsToMany('App\Models\Drink');
    }
}
