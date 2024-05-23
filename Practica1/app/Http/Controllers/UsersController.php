<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function read()
    {
        $users = User::all();

        return view('templates/read', compact('users'));
    }

    public function edit(Request $request)
    {
        $user = User::find($request->id);

        if ($user) {
            return view('templates/edit', compact('user'));
        } else {
            return redirect()->route('templates/read')->with('error', 'El usuario no ha sido encontrado.');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:80',
            'lastname_p' => 'required|min:2|max:50',
            'lastname_m' => 'required|min:2|max:50',
            'age' => 'required|numeric',
            'birthdate' => 'required|date',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'phone' => 'required|numeric|min_digits:10|max_digits:10|unique:users,phone,' . $request->id,
        ]);

        $user = User::find($request->id); //Buscar user con tal id

        if ($user) {
            $user->name = $request->name;
            $user->lastname_p = $request->lastname_p;
            $user->lastname_m = $request->lastname_m;
            $user->age = $request->age;
            $user->birthdate = $request->birthdate;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->active = $request->active;
            // Solo actualizar la contraseña si se proporciona una nueva
            if ($request->filled('password')) {
                $request->validate([
                    'password' => 'required|min:8|confirmed',
                ]);
                $user->password = bcrypt($request->password);
            }
            $user->save(); //Guardamos
            return redirect()->route('read')->with('mensaje', 'Cambios guardados del usuario.');
        } else {
            return redirect()->route('read')->with('error', 'El usuario no ha sido encontrado.');
        }
        return redirect()->route('read');
    }
}
