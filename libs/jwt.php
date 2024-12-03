<?php

function crearJWT($datos) {
    $encabezado = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    $datos = json_encode($datos);

    $encabezado = base64_encode($encabezado);
    $encabezado = str_replace(['+', '/', '='], ['-', '_', ''], $encabezado);
    $datos = base64_encode($datos);
    $datos = str_replace(['+', '/', '='], ['-', '_', ''], $datos);

    $firma = hash_hmac('sha256', $encabezado . '.' . $datos, 'claveSecreta', true);
    $firma = base64_encode($firma);
    $firma = str_replace(['+', '/', '='], ['-', '_', ''], $firma);

    return $encabezado . '.' . $datos . '.' . $firma;
}

function validarJWT($jwt) {
    $partes = explode('.', $jwt);
    if (count($partes) !== 3) {
        return null;
    }

    list($encabezado, $datos, $firma) = $partes;

    $firmaValida = hash_hmac('sha256', $encabezado . '.' . $datos, 'claveSecreta', true);
    $firmaValida = base64_encode($firmaValida);
    $firmaValida = str_replace(['+', '/', '='], ['-', '_', ''], $firmaValida);

    if ($firma !== $firmaValida) {
        return null;
    }

    $datos = json_decode(base64_decode($datos));
    if ($datos->exp < time()) {
        return null;
    }

    return $datos;
}
