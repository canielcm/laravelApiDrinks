<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Purchase;
use App\Models\DrinkPurchase;
use App\Models\Cart;

class PurchaseController extends Controller
{
    public function addPurchase(Request $request)
    {
        $purchase = new Purchase();
        $purchase->home_id = $request->home_id;
        $purchase->user_id = $request->user_id;
        
        $purchase->save();

        $cart = Cart::join("drinks", "carts.drink_id", "=", "drinks.id")->select("carts.amount", "drink_id", "name","urlimg", "price", "discount")->where("user_id", $request->user_id)->get();

        foreach ($cart as $element) {
            $drinkPurchase = new DrinkPurchase();
            $drinkPurchase->drink_id = $element->drink_id;
            $drinkPurchase->purchase_id = $purchase->id;
            $drinkPurchase->amount = $element->amount;

            $drinkPurchase->save();
        }

        $purchaseDrinkVec = DrinkPurchase::where('purchase_id', $purchase->id)->get();
        return response()->json([
            'messaje' => 'purchase done',
            'data' => $purchase,
            'purchaseVec'=>$purchaseDrinkVec,
        ], Response::HTTP_OK);
    }
}
