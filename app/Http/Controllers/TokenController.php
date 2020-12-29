<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


class TokenController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        // dd($request);
        $bearerToken = $request->bearerToken();
        $data = array(
            'id' => $request->client_id, 
            'name' => $request->client_name, 
        );
        return response()->json(array(
            'status_code' => 200,
            'status_name' => 'Token Valid',
            'data' => $data,
        ), 200);
    }

    //
}
