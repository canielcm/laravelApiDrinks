<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Drink;

class DrinkController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth:api'
    //     , ['except' => ['index', 'show']]
    // );
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$drink = Drink::all();
        $drink = Drink::join("category", "category.id", "=", "drinks.category_id")
            ->select("category.name as category", "drinks.name", "drinks.amount", "brand", "discount", "drinks.id", "price", "urlimg", "abv", "drinks.description")
            ->get();
        return $drink;
        // return response()->json([
        //     'message'=> "Query Success",
        //     'data'=> $drink
        // ],Response::HTTP_OK);
    }
    public function getByCategory(Request $request)
    {
        //$drink = Drink::all();
        $drink = Drink::join("category", "category.id", "=", "drinks.category_id")
            ->select("category.name as category", "drinks.name", "drinks.amount", "brand", "discount", "drinks.id", "price", "urlimg", "abv")->where('category.name',$request->category)
            ->get();
        return $drink;
        // return response()->json([
        //     'message'=> "Query Success",
        //     'data'=> $drink
        // ],Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $drink = new Drink();
        $drink->name = $request->name;
        $drink->amount = $request->amount;
        $drink->description = $request->description;
        $drink->category_id = $request->category_id;
        $drink->brand = $request->brand;
        $drink->price = $request->price;
        $drink->urlimg = $request->urlimg;
        $drink->abv = $request->abv;
        $drink->discount = $request->discount;

        $drink->save();
        return response()->json([
            'messaje' => 'drink added',
            'data' => $drink
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $drink = Drink::join("category", "category.id", "=", "drinks.category_id")
        ->select("category.name as category", "drinks.name", "drinks.amount", "brand", "discount", "drinks.id", "price", "urlimg", "abv", "drinks.description")->where("drinks.id", $request->id)
        ->get();
        return $drink;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $drink = Drink::findOrFail($request->id);
        if($request->name)$drink->name = $request->name;
        if($request->amount)$drink->amount = $request->amount;
        if($request->description)$drink->description = $request->description;
        if($request->category_id)$drink->category_id = $request->category_id;
        if($request->brand)$drink->brand = $request->brand;
        if($request->price)$drink->price = $request->price;
        if($request->urlimg)$drink->urlimg = $request->urlimg;
        if($request->abv)$drink->abv = $request->abv;
        if($request->discount)$drink->discount = $request->discount;

        $drink->save();
        return response()->json([
            'messaje' => 'drink updated',
            'data' => $drink
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $drink = Drink::destroy($request->id);
        return response()->json(['messaje'=>'drink removed'],Response::HTTP_OK);
    }
}
