<?php

namespace App\Http\Controllers;

use App\Http\Resources\CityCollectionResource;
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::all();
        return new CityCollectionResource($cities);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show($city_name)
    {
        $city = City::where('name', $city_name)->first();

        if (is_null($city)) {
            return response()->json('Data not found', 404);
        }
        return new CityResource($city);
    }
}
