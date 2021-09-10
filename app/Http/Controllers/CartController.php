<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Cart;
use App\Models\Drink;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        //  $cart = DB::select('SELECT * FROM carts WHERE user_id = ?', [1]);
        $cart = Cart::all();
        return $cart;
    }

    public function store(Request $request)
    {
        $cartChechker = Cart::select('*')->where([["user_id","=", $request->user_id],["drink_id", "=",$request->drink_id]])->first();
        $drink = Drink::find($request->drink_id);
        if($cartChechker){
            $newAmount=$cartChechker->amount+$request->amount;
            if($newAmount<0){
                $newAmount=0;
            }
            if($newAmount>$drink->amount){
                $newAmount=$drink->amount;
            }
            $updated = Cart::where([["user_id","=", $request->user_id],["drink_id", "=",$request->drink_id]])
                ->update(['amount' => $newAmount]);
            $cart = Cart::select('*')->where([["user_id","=", $request->user_id],["drink_id", "=",$request->drink_id]])->first();
            return response()->json(['messaje'=>'Amount updated', 'data:'=>$cart],Response::HTTP_OK);
        }else{
            $cart = new Cart();
            $cart->user_id=$request->user_id;
            $cart->drink_id=$request->drink_id;
            $cart->amount=$request->amount;
    
            $cart->save();
            return response()->json(['messaje'=>'product added to cart'],Response::HTTP_OK);
        }

    }

    public function show(Request $request)
    {
        // $category = Category::find($request->id_category);
        $cart = Cart::join("drinks", "carts.drink_id", "=", "drinks.id")->select("carts.amount", "drink_id", "name","urlimg", "price", "discount")->where("user_id", $request->id_user)->get();

        return response()->json(['drinks'=>$cart],Response::HTTP_OK);
    }

    public function update(Request $request)
    {
        $updated = Cart::where([["user_id","=", $request->id_user],["drink_id", "=",$request->id_drink]])
                ->update(['amount' => $request->amount]);
        // $updated = DB::update('UPDATE carts SET amount=? WHERE user_id = ? AND drink_id = ?', [$request->amount, $request->id_user,$request->id_drink]);
        $cart = Cart::select('*')->where([["user_id","=", $request->id_user],["drink_id", "=",$request->id_drink]])->first();

        return response()->json(['messaje'=>'cart updated', 'data'=>$cart],Response::HTTP_OK);
    }

    public function destroy(Request $request)
    {
        $cart = Cart::where([["user_id","=", $request->id_user],["drink_id", "=",$request->id_drink]])->delete();
        return response()->json(['messaje'=>'cart product removed'],Response::HTTP_OK);
    }
}
