<?php

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', function (Request $request) {
    return User::create([
        'name' => $request['name'],
        'email' => $request['email'],
        'password' => $request['password'],
    ]);
});

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    } else {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
});

Route::post('/create', function (Request $request) {
    return Post::create([
        'naslov' => $request['naslov'],
        'opis' => $request['opis'],
        'pocetnaCena' => $request['pocetnaCena'],
        'userId' => $request['userId'],
    ]);
});
