<?php

require_once "config.php";

class Model {

    protected $db;

    public function __construct() {
        try {
            // Conexión inicial sin base de datos
            $this->db = new PDO("mysql:host=" . MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Crear base de datos si no existe
            $this->db->exec("CREATE DATABASE IF NOT EXISTS `" . MYSQL_DB . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");

            // Conectarse a la base de datos
            $this->db = new PDO("mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DB . ";charset=utf8mb4", MYSQL_USER, MYSQL_PASS);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Llamar al método deploy para crear tablas y datos iniciales si no existen
            $this->deploy();

        } catch (PDOException $e) {
            die("Error en la conexión: " . $e->getMessage());
        }
    }

    public function deploy() {
        try {
            // Verificar si hay tablas existentes
            $query = $this->db->query("SHOW TABLES");
            $tables = $query->fetchAll(PDO::FETCH_COLUMN);

            if (empty($tables)) {
                // Crear tablas y datos iniciales
                $sql = <<<SQL
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Base de datos: `db_iconnect`

-- Estructura de tabla para la tabla `categoria`
CREATE TABLE `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcado de datos para la tabla `categoria`
INSERT INTO `categoria` (`id`, `nombre`) VALUES
(1, 'Alta'),
(2, 'Media'),
(3, 'Baja');

-- Estructura de tabla para la tabla `telefonos`
CREATE TABLE `telefonos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modelo` varchar(30) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` int(15) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `img` varchar(10000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcado de datos para la tabla `telefonos`
INSERT INTO `telefonos` (`id`, `modelo`, `descripcion`, `precio`, `categoria_id`, `img`) VALUES
(1, 'Xiaomi Redmi 13C', 'PANTALLA LCD 6,74" HD+ 90 Hz...', 260000, 3, 'https://github.com/.../xiaomi%2013c.jpg'),
(2, 'Xiaomi Note 13 Pro', 'PANTALLA Panel AMOLED de 6,67 pulgadas...', 700000, 2, 'https://github.com/.../xiaomi%20note%2013%20pro.jpg');

-- Estructura de tabla para la tabla `usuarios`
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcado de datos para la tabla `usuarios`
INSERT INTO `usuarios` (`id`, `usuario`, `password`) VALUES
(1, 'webadmin', '$2y$10\$kFQrQCEOnb7F36hXY.eU.eNBcA3.3AmVnujtEAlR8EbqqT7Wse.Pi');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
SQL;

                // Ejecutar las consultas SQL
                $this->db->exec($sql);
            }
        } catch (PDOException $e) {
            die("Error al configurar la base de datos: " . $e->getMessage());
        }
    }
}
