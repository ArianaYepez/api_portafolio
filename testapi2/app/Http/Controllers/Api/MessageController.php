<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{

    public function index()
    {
        $messages = Message::all();
        return $messages;
    }

    public function store(Request $request)
    {
        $message = new Message();
        $message->name = $request->name;
        $message->email = $request->email;
        $message->detail = $request->detail;

        $message->save();
    }

    public function show($id)
    {
        $message = Message::find($id);
        return $message;
    }

    public function update(Request $request, $id)
    {
        $message = Message::findOrFail($request->id);

        $message->name = $request->name;
        $message->email = $request->email;
        $message->detail = $request->detail;

        $message->save();
        return $message;
    }


    public function destroy($id)
    {
        $message = Message::destroy($id);
        return $message;
    }

    // Controlador login
    public function login(Request $request)
    {
        // Obtener las credenciales del formulario
        $email = $request->input('email');
        $password = $request->input('password');

        // Validar las credenciales
        $user = User::where('email', $email)->firstOrFail();
        //if (!Hash::check($password, $user->password)) {
        if(!md5($password) === $user->password) {
            return response()->json([
                'error' => 'Credenciales incorrectas'
            ], 401);
        }

        // Validar que el correo electrónico sea válido
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'error' => 'El correo electrónico no es válido'
            ], 422);
        }

        // Validar que la contraseña tenga al menos una longitud mínima
        if (strlen($password) < 8) {
            return response()->json([
                'error' => 'La contraseña debe tener al menos 8 caracteres'
            ], 422);
        }

        // Loguear al usuario
        auth()->login($user);

        // Devolver un JSON con la información del usuario
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'logged' => true
        ]);
    }

}
