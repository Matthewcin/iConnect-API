<?php

require_once 'app/view/json-view.php';
require_once 'app/libs/jwt.php';

class UserApiController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new UserModel();
        $this->view = new JSONView();
    }

    public function getToken() {
        // Obtener el encabezado de autorización
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? null;
        if (!$authHeader || !str_starts_with($authHeader, 'Basic ')) {
            return $this->view->response("Error: Credenciales inválidas", 400);
        }

        // Decodificar las credenciales
        $encodedCredentials = substr($authHeader, 6); // Quita "Basic "
        $decodedCredentials = base64_decode($encodedCredentials); // Decodifica en "usuario:password"
        $credentials = explode(':', $decodedCredentials);

        if (count($credentials) !== 2) {
            return $this->view->response("Error: Formato de credenciales incorrecto", 400);
        }

        [$email, $password] = $credentials;

        // Buscar usuario en la base de datos
        $user = $this->model->getUserByEmail($email);
        if (!$user || !password_verify($password, $user->password)) {
            return $this->view->response("Error: Usuario o contraseña incorrectos", 401);
        }

        // Crear el token JWT
        $tokenData = [
            'sub' => $user->id,
            'email' => $user->email,
            'role' => 'admin',
            'iat' => time(),
            'exp' => time() + 3600, 
        ];
        $token = crearJWT($tokenData);

        return $this->view->response(['token' => $token], 200);
    }
}