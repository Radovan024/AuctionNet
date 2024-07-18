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
    // Validacija podataka
    $request->validate([
        'naslov' => 'required|string|max:255',
        'opis' => 'required|string',
        'slika' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validacija za slike
        'pocetnaCena' => 'required|numeric',
        'userId' => 'required|integer',
    ]);

    // Upload slike
    $path = $request->file('slika')->store('slike', 'public'); // Čuva u storage/app/public/slike

    // Kreiranje posta sa putanjom do slike
    $post = Post::create([
        'naslov' => $request['naslov'],
        'opis' => $request['opis'],
        'slika' => $path,
        'pocetnaCena' => $request['pocetnaCena'],
        'userId' => $request['userId'],
    ]);

    return $post;
});

Route::get('/get/{id}', function ($id) {
    $post = Post::find($id);

    if (!$post) {
        return response()->json(['message' => 'Post not found'], 404);
    }

    return response()->json($post);
});
