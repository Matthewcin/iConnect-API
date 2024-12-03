<?php
require_once "./view/json.view.php";
require_once "./model/telefonos.model.php";

class ControladorTelefonos
{
    private $model;
    private $vista;

    public function __construct()
    {
        $this->model = new CelularModel();
        $this->vista = new JSONView();
    }

    public function obtenerTodos($req, $res)
    {
        $categoria = $req->query->categoria ?? null;
        $precioMin = $req->query->precioMin ?? null;
        $precioMax = $req->query->precioMax ?? null;

        $telefonos = $this->model->obtenerTodos($categoria, $precioMin, $precioMax);
        return $this->vista->response($telefonos, 200);
    }

    public function obtener($req, $res) {
        // Capturar el ID desde los parámetros
        $id = $req->params->id;
    
        $telefono=$this->model->obtener($id);
        if(!$telefono)
            return $this->vista->response("El telefono a buscar no existe",404);

        return $this->vista->response($telefono,200);
    }

    public function agregar($req, $res)
    {
        $body = $req->body;

        // Validación adicional para los campos `descripcion` e `img`
        if (empty($body->marca) || empty($body->modelo) || empty($body->precio) || empty($body->categoria_id) || empty($body->descripcion) || empty($body->img)) {
            return $this->vista->response("Faltan campos obligatorios: marca, modelo, precio, categoria_id, descripcion, img.", 400);
        }

        $id = $this->model->crear($body->marca, $body->modelo, $body->precio, $body->descripcion, $body->categoria_id, $body->img ?? null);

        if (!$id) {
            return $this->vista->response("Error al crear el teléfono.", 500);
        }

        return $this->vista->response($this->model->obtener($id), 201);
    }

    public function eliminar($req, $res)
    {
        $id = $req->params->id;
        if (!isset($id) || empty($id)) {
            $res->send('El ID es requerido.', 400);
            return;
        }

        if (!$this->model->obtener($id)) {
            return $this->vista->response("El teléfono con ID $id no existe.", 404);
        }

        $this->model->eliminar($id);
        return $this->vista->response("Teléfono eliminado.", 200);
    }

    public function actualizar($req, $res)
    {
        $id = $req->params['id'];
        if (!isset($id) || empty($id)) {
            $res->send('El ID es requerido.', 400);
            return;
        }
        $telefonoExistente = $this->model->obtener($id);

        if (!$telefonoExistente) {
            return $this->vista->response("El teléfono con ID $id no existe.", 404);
        }

        $body = $req->body;
        if (empty($body->marca) || empty($body->modelo) || empty($body->precio) || empty($body->categoria_id)) {
            return $this->vista->response("Faltan campos obligatorios.", 400);
        }

        $this->model->actualizar($id, $body->marca, $body->modelo, $body->precio, $body->descripcion, $body->img ?? null);
        return $this->vista->response($this->model->obtener($id), 200);
    }
}
