<?php

use App\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login',function(Request $request){
    $data= $request->validate([
        'email' => 'required',
        'password' => 'required',
    ]);

    $user = User::whereEmail($request->email)->first();
    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response([
            'email' => ['The provided credentials are incorrect.'],
        ], 404);
    }
    return $user->createToken('my-token')->plainTextToken;
});

