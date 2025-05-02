<?php

namespace App\Http\Controllers;

use App\Docs\AuthDocs;
use Exception;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Anturi\Larastarted\Helpers\LogService;
use Anturi\Larastarted\Helpers\ResponseService;


/**
 * @group Sesion
 *
 * APIs Para manejar los estados de sesion.
 */

use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**
     * esta funcion sirve para crear un usuario. Actualmente no esta funcionando.
     * Se utiliza para crear un usuario de vez en cuando
     */

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|unique:users|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);
            // $user->assignRole('user');

            // DB::table('model_has_roles')->insert(["role_id" => "2", "model_id" => $user->id, 'model_type' =>"App\Models\User"]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(
                [
                    'user' => $user,
                    'accessToken' => $token,
                    'token_type' => 'Bearer',
                    'mensaje' => 'Usuario creado correctamente'
                ]
            );
        } catch (ValidationException $e) {

            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * @responseFile app/Docs/Responses/Auth/login.json
     *
     * Esta funcion sirve para iniciar sesion
     */
    public function login(Request $request)

    {
        try {

            $loginType = $request->has('email') ? 'email' : 'name';

            if (!Auth::attempt($request->only([$loginType, 'password'])))
                return response(['message' => 'unauthorized'], 403);

            $user = Auth::user();


            $time = 60 * 24;
            $user = User::where($loginType, $request[$loginType])->first();

            $tokenResult = $user->createToken('auth_token', ['*'], now()->addDays(2));
            $token = $tokenResult->plainTextToken;
            $cookie = cookie('jwt', $token, $time);
            return ResponseService::responseGet(['user' => $user, 'access_token' => $token, 'cookie' => $cookie]);
        } catch (Exception $e) {
            return $e;

            $message = $e->getMessage();
            $code = $e->getCode();
            return ResponseService::responseError($e);
            LogService::catchError($message, $code, 'fotos', 'AuthController', 144);
        }
    }
    /**
     * @authenticated Requiere autenticacion
     * esta funcion sirve para cerrar la sesión
     */
    public function logout()
    {
        try {

            $user = Auth::user();
            $cookie = Cookie::Forget('jwt');
            return response()->json([
                'message' => 'logout exitoso!'

            ])->withCookie($cookie);
        } catch (Exception $e) {

            $message = $e->getMessage();
            $code = $e->getCode();
            LogService::catchError($message, $code, 'fotos', 'AuthController', 164);
            return ResponseService::responseError($e);
        }
    }
}
