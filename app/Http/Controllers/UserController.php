<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validator\Rules\Password;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{


    public function login(Request $req){
        $credentials = $req->validate([
            'name' => ['requiered'],
            'password' => ['requiered'],      
        ]);
        $recordar =($req->has('remember') ? true : false);
        if (Auth::attempt($credentials,$recordar)){
            $req->session()->regenerate();

            return redirect()->intended(route('home')
                );
        }
        return redirect(route('login'))->withInput()
            ->withErrors([
            'name' => 'Las credenciales introducidas no son corretas.'
        ]);     
        
    }
  
    public function register(Request $req){
        //valida los datos
        $validated = $req->validate([
            "email" => ["requiered", "email", "
                 unique:App\Models\User,email", "
                 max:150"],
            "name" => ["requiered", "
                 unique:App\Models\User,name","max:30"],
            "password" => ["requiered", Password::min(6
                )->mixedCase()->numbers()]
        ]);

        //Genera al usuario

        $user = new User();

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['
             password']);
    
        try{
            //guarda y autentica
            $user->save();
            Auth::login($user);
        }catch(\Exceprion $e){
            return back()->withInput()->withErrors(["
                exception" => (config('app.debug') ==
                   true ? $e->getMessage() : "Se ha producido un error
                  al registrar la solicitud.")]);
        }
        return redirect(route('home'));
    
    }

    public function logout(Request $req){
        Auth::logout();

        $req->session()->invalidate();

        $req->session()->regenerateToken();

        return redirect(route('login'));
    }

}

