<?php

require_once 'libs/router.php';
require_once 'controller/telefonos.controller.php';

// Crear la instancia del enrutador
$router = new Router();

// Definir las rutas
$router->addRoute('telefonos', 'GET', 'ControladorTelefonos', 'obtenerTodos');
$router->addRoute('telefonos/:id', 'GET', 'ControladorTelefonos', 'obtener');
$router->addRoute('telefonos', 'POST', 'ControladorTelefonos', 'agregar');
$router->addRoute('telefonos/:id', 'DELETE', 'ControladorTelefonos', 'eliminar');
$router->addRoute('telefonos/:id', 'PUT', 'ControladorTelefonos', 'actualizar');

// Modificar el enrutador para capturar parámetros dinámicos y pasarlos al controlador
$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);