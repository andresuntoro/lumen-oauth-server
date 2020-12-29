<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


class ExampleController extends Controller
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
        // echo "HAI";
        $bearerToken = $request->bearerToken();

        // $tokenId = (new \Lcobucci\JWT\Parser())->parse($bearerToken)->getHeader('jti');

        // return \Laravel\Passport\Token::find($tokenId)->client;
        $data = array(
            'id' => $request->client_id, 
            'name' => $request->client_name, 
        );
        return response()->json(array(
            'status_code' => 200,
            'status_name' => 'Auth Granted!',
            'data' => $data,
        ), 200);
    }

    //
}
