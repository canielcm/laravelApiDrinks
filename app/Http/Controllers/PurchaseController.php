<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Purchase;
use App\Models\DrinkPurchase;
use App\Models\Cart;
use App\Models\Drink;

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api'
    );
    }
    public function addPurchase(Request $request)
    {
        $purchase = new Purchase();
        $purchase->home_id = $request->home_id;
        $purchase->user_id = $request->user_id;

        $purchase->save();

        $cart = Cart::join("drinks", "carts.drink_id", "=", "drinks.id")->select("carts.amount", "drink_id", "name", "urlimg", "price", "discount")->where("user_id", $request->user_id)->get();

        foreach ($cart as $element) {
            $drinkPurchase = new DrinkPurchase();
            $drinkPurchase->drink_id = $element->drink_id;
            $drinkPurchase->purchase_id = $purchase->id;
            $drinkPurchase->amount = $element->amount;

            $drink = Drink::findOrFail($element->drink_id);
            $newAmount=$drink->amount - $element->amount;
            if($newAmount<0)$newAmount=0;
            $drink->amount = $newAmount;
            $drink->save();
            $drinkPurchase->save();
        }

        $purchaseDrinkVec = DrinkPurchase::where('purchase_id', $purchase->id)->get();
        $cart = Cart::where("user_id", "=", $request->user_id)->delete();
        return response()->json([
            'messaje' => 'purchase done',
            'data' => $purchase,
            'purchaseVec' => $purchaseDrinkVec,
        ], Response::HTTP_OK);
    }
    public function getPurchasesByCostumer(Request $request)
    {
        $purchases = Purchase::where('user_id', $request->user_id)->get();
        $vecPurchases = array();
        foreach ($purchases as $element) {
            $total=0;
            $tempVec = DrinkPurchase::join('drinks', 'drinks.id', '=', 'drink_purchases.drink_id')->select("drink_purchases.amount", "drink_id", "name", "urlimg", "price", "discount")->where('purchase_id', $element->id)->get();
            foreach ($tempVec as $e){
                $total=$total+ (($e->price*(1-($e->discount/100))))*$e->amount;
            }
            $tempObj = [
                'purchase_id' => $element->id,
                'purchase_date' => $element->created_at,
                'home_id' => $element->home_id,
                'user_id' => $element->user_id,
                'total'=>$total,
                'purchases' => $tempVec,
            ];
            array_push($vecPurchases, $tempObj);
        }
        return $vecPurchases;
    }
}
