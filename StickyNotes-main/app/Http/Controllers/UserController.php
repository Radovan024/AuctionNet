<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function createUser(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = $this->userRepository->register($validatedData);
        Auth::login($user);
        $userId = $this->userRepository->getUser($request->email);
        return redirect(route('dashboard', ['userId' => $userId]));
    }

    public function updateProfile(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'newEmail' => 'required|email'
        ]);

        $userId = $request->userId;
        $this->userRepository->updateUser($userId, $validatedData);
        return redirect(route('profile', ['userId' => $userId]));
    }

    public function loginUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = $this->userRepository->login($request->email);
        $userId = $this->userRepository->getUser($request->email);

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            if ($user->id == 1) {
                return redirect(route('adminDashboard', ['userId' => $userId]));
            } else {
                return redirect(route('dashboard', ['userId' => $userId]));
            }
        } else {
            return redirect(route('signIn'))->withErrors([
                'error' => 'The provided credentials do not match our records.',
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('welcome'));
    }
}
