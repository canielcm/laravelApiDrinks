<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Home;

class HomeController extends Controller
{
    public function index()
    {
        // $home = home::all();
        $home = Home::all();
        return $home;
    }

    public function store(Request $request)
    {
        $homeChecker = Home::select("*")->where([['city', "=", $request->city], ['address', "=", $request->address]])->get();
        if (count($homeChecker)>0) {
            return response()->json(['messaje' => 'home already exists', 'data'=>$homeChecker[0]], Response::HTTP_OK);
        } else {
            $home = new Home();
            $home->city = $request->city;
            $home->address = $request->address;
            $home->description = $request->description;

            $home->save();
            return response()->json(['messaje' => 'home added', 'data'=>$home], Response::HTTP_OK);
        }
    }

    public function show(Request $request)
    {
        // $category = Category::find($request->id_category);
        $home = Home::find($request->id);
        return $home;
    }
    public function showByAddress(Request $request)
    {
        // $category = Category::find($request->id_category);
        $home = Home::select("*")->where([['city', "=", $request->city], ['address', "=", $request->address]])->get();
        return $home[0];
    }
}
