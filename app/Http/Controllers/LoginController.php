<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;

        $user->save();

        return response()->json(
            [
                'code' => 200,
                'message' => 'Editado con exito',
            ]
        );
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        // Elimina el producto
        $user->delete();
        // Retorna una respuesta exitosa
        return response()->json(['message' => 'Usuario eliminado con éxito'], 200);
    }

    public function getUsers()
    {
        $users = User::all();
        return $users;
    }

    public function login(Request $request)
    {
        // Extrae las credenciales de la solicitud (email y password) 
        // y las guarda en un array
        $credentials = [
            "email" => $request->email,
            "password" => $request->password
        ];

        try {
            // Intenta autenticar al usuario con las 
            // credenciales proporcionadas
            if (Auth::attempt($credentials)) {
                // Si la autenticación es exitosa 
                // devuelve una respuesta JSON con un 
                // mensaje de éxito y código de estado 200
                return response()->json(['message' => 'Autenticacion satisfactoria'], 200);
            } else {
                // Si la autenticación falla
                // devuelve una respuesta JSON 
                // con un mensaje de error y código de estado 400
                return response()->json(['message' => 'Error de autenticacion'], 400);
            }
        } catch (\Exception $e) {
            // Si ocurre una excepción durante el 
            // proceso de autenticación  captura la excepción 
            //  y devuelve una respuesta JSON
            // con un mensaje de error y código de estado 500
            return response()->json(['error' => 'Error en el servidor: ' . $e->getMessage()], 500);
        }
    }



    public function register(Request $request)
    {

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;

        $user->password = Hash::make($request->password);
        $user->save();

        Auth::login($user);

        return response()->json(
            [
                'code' => 200,
                'message' => 'Registrado con exito',
            ]
        );
    }
}
