<?php
require_once './app/models/user.model.php';
require_once './libs/jwt/jwt.php';

class AuthApiController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login($request, $response)
    {

        $authorization = $request->authorization;


        $auth = explode(' ', $authorization);
        if (count($auth) != 2 || $auth[0] !== 'Basic') {            
            header("WWW-Authenticate: Basic realm='Get a token'");
            return $response->json("Autenticación no valida", 401);
        }

        $auth = base64_decode($auth[1]);
        $user_pass = explode(":", $auth);
        if (count($user_pass) != 2) {

            return $response->json("Autenticación no valida", 401);
        }

        $user = $user_pass[0];
        $password = $user_pass[1];
        
        // Buscar el usuario en la DB
        $userFromDB = $this->userModel->getByUser($user);


        if (!$userFromDB || !password_verify($password, $userFromDB->contraseña)) {
            return $response->json("Usuario o contraseña incorrecta", 401);
        }


        $payload = [

            'sub' => $userFromDB->id_usuario,
            'usuario' => $userFromDB->usuario,
            'roles' => [$userFromDB->rol],
            'exp' => time() + 3600
        ];

        return $response->json(createJWT($payload));
    }
}