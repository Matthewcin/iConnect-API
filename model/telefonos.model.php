<?php
require_once "./model/Model.php";

class CelularModel extends Model
{

    public function obtenerTodos($ordenarPor = null, $tipoOrden = 'ASC', $marca = null, $modelo = null, $precio = null)
    {
        $sql = "SELECT * FROM telefonos";
        $params = [];

        // Filtros condicionales
        if ($marca) {
            $params[] = "marca = '$marca'";
        }
        if ($modelo) {
            $params[] = "modelo = '$modelo'";
        }
        if ($precio) {
            $params[] = "precio = $precio";
        }

        if (!empty($params)) {
            $sql .= " WHERE " . implode(" AND ", $params);
        }

        // Ordenamiento
        $columnasPermitidas = ['id', 'marca', 'modelo', 'precio', 'descripcion'];
        if ($ordenarPor && in_array($ordenarPor, $columnasPermitidas)) {
            $sql .= " ORDER BY $ordenarPor " . ($tipoOrden === 'DESC' ? "DESC" : "ASC");
        }

        // Ejecución
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function obtener($id) {
        $sql = "SELECT * FROM telefonos WHERE id = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$id]); 
        $telefono=$query->fetch(PDO::FETCH_OBJ);
        return $telefono;
    }

    public function crear($marca, $modelo, $precio, $descripcion, $imagen)
    {
        $sql = "INSERT INTO telefonos (marca, modelo, precio, descripcion, imagen) 
                VALUES ('$marca', '$modelo', $precio, '$descripcion', '$imagen')";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $this->db->lastInsertId();
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM telefonos WHERE id = $id";
        $query = $this->db->prepare($sql);
        $query->execute();
    }

    public function actualizar($id, $marca, $modelo, $precio, $descripcion, $imagen)
    {
        $sql = "UPDATE telefonos 
                SET marca = '$marca', modelo = '$modelo', precio = $precio, descripcion = '$descripcion', imagen = '$imagen' 
                WHERE id = $id";
        $query = $this->db->prepare($sql);
        $query->execute();
    }
}
