<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\Player;

class AdminController extends Controller
{
    public function index() {
        $player = Player::withCount('games as games_played')->get();
        return view('pages.admin', ['players' => $player]);
    }

    public function login() {
        if(Auth::user())
            return redirect("/admin");
        else
            return view("pages.login");
    }

    public function doLogin(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails())
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => $validator->errors()->first()
            ], 400);

        if(Auth::attempt($request->only('username', 'password'))) {
            $user = Auth::user();
            return response()->json([
                'status' => true,
                'data' => $user,
                'message' => "Authenticated"
            ]);
        }
        else
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => "Invalid credentials"
            ], 401);
    }

    public function doLogout() {
        Auth::logout();

        return response()->json([
            'status' => true,
            'data' => null,
            'message' => "Logged Out"
        ]);
    }
}
