<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientCollectionResource;
use App\Http\Resources\ClientResource;
use App\Models\City;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class ClientController extends Controller
{

    public function index($user_id)
    {
        $clients = Client::where('user_id', $user_id)->get();

        if ($clients->isEmpty()) {
            return response()->json('Data not found', 404);
        }
        return new ClientCollectionResource($clients);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($user_id, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'city' => "required|string|max:255"
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $city = City::where('name', $request->city)->first();

        if (is_null($city)) {
            return response()->json('Data not found', 404);
        }
        //    return response()->json($request);

        $client = Client::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'height' => $request->height,
            'weight' => $request->weight,
            'user_id' => $user_id,
            'city_id' => $city->id
        ]);

        return response()->json(['Client created successfully', new ClientResource($client)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($user_id, $name)
    {
        $clients = Client::where('user_id', $user_id)->where('name', $name)->get();
     
        if ($clients->isEmpty()) {
            return response()->json('Data not found', 404);
        }
        return new ClientCollectionResource($clients);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update($user_id, $client_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'city_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::find($user_id);
        $client = Client::find($client_id);

        if (is_null($user) || is_null($client)) {
            return response()->json('Data not found', 404);
        }

        if ($user->id != $client->user_id) {
            return response()->json('Invalid user', 404);
        }

        $city = City::where('id', $request->city_id)->get();

        if ($city->isEmpty()) {
            return response()->json('City not found', 404);
        }

        $client->height = $request->height;
        $client->weight = $request->weight;
        $client->city_id = $request->city_id;

        $client->save();

        return response()->json(['Client updated successfully', new ClientResource($client)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id, $client_id)
    {
        $user = User::find($user_id);
        $client = Client::find($client_id);

        if (is_null($user) || is_null($client)) {
            return response()->json('Data not found', 404);
        }

        if ($user->id != $client->user_id) {
            return response()->json('Invalid user', 404);
        }

        $client->delete();
        return response()->json('Client deleted successfully');
    }
}
