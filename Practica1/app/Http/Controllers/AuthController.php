<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /* public function principal()
    {
        return view('templates/app');
    } */

    public function showRegisterForm()
    {
        return view('templates/register');
    }
    

    public function register(Request $request)
    {
        #dd($request->all());
        $validatedData = $request->validate([
            'name' => 'required|min:2|max:80',
            'lastname_p' => 'required|min:2|max:50',
            'lastname_m' => 'required|min:2|max:50',
            'age' => 'required|numeric',
            'birthdate' => 'required|date',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|min:10|max:10|unique:users,phone',
            'password' => 'required|min:8|confirmed',
        ]);

        // Crear el nuevo usuario
        $user = User::create([
            'name' => $validatedData['name'],
            'lastname_p' => $validatedData['lastname_p'],
            'lastname_m' => $validatedData['lastname_m'],
            'age' => $validatedData['age'],
            'birthdate' => $validatedData['birthdate'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'password' => Hash::make($validatedData['password']),
            'active' => true,
        ]);

        /* $user = new User();
        $user->name = $request->name;
        $user->lastname_p = $request->lastname_p;
        $user->lastname_m = $request->lastname_m;
        $user->age = $request->age;
        $user->birthdate = $request->birthdate;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->active = true; */
        $user->save();

        // Redireccionar al usuario a la página de app (principal)
        return redirect()->route('/');
    }
}
