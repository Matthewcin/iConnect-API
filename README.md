# Integrantes:

Mateo Planes
Thiago Ramos

# Descripción del proyecto
En este proyecto desarrollamos un sistema para gestionar información de teléfonos móviles. Los usuarios pueden acceder a detalles como modelos, descripciones, precios, imágenes y categorías relacionadas. Este sistema se basa en una API REST que permite gestionar teléfonos y proporciona funcionalidades CRUD (Crear, Leer, Actualizar, Eliminar). La API está diseñada para ser consumida desde un cliente CSR (Client-Side Rendering) o herramientas como Postman.

# Avances en el proyecto
Se desarrolló una API REST utilizando PHP y MySQL.
Todos los endpoints permiten realizar operaciones sobre la tabla de teléfonos:
Filtrar teléfonos por diferentes criterios.
Ordenar resultados en orden ascendente o descendente.
Crear, editar o eliminar registros (requiere autenticación).
La API implementa autenticación con token para proteger operaciones como inserción y edición.
Los tiempos de sesión están configurados para expirar automáticamente tras 90 segundos.

# Endpoints
1. Operaciones generales
api/telefonos (GET):
Retorna todos los teléfonos. Permite aplicar las siguientes consultas:
orderBy: modelo, precio, descripcion, categoria_id.
tipoOrder: ascendente, descendente.
Filtros: campos filtrables basados en los criterios del orderBy.
2. Operaciones específicas
api/telefonos/:ID (GET):
Obtiene un teléfono específico según el ID.
3. Operaciones protegidas (requieren autenticación)
api/telefonos (POST):
Inserta un nuevo teléfono. Requiere un token de autenticación válido.

api/telefonos/:ID (DELETE):
Elimina un teléfono por ID. Requiere un token válido.

api/telefonos/:ID (PUT):
Edita un teléfono por ID. Requiere un token válido.

4. Generar token
api/token (GET):
Obtiene un token de autenticación utilizando las credenciales:
Usuario: webadmin
Password: admin
(El token es válido durante 90 segundos.)
Requisitos para ejecutar el proyecto
Servidor local: XAMPP, WAMP u otro servidor compatible con PHP.
Base de datos: Importar el esquema SQL incluido en el proyecto.
Extensiones necesarias:
PDO para la conexión con la base de datos.
Extensión json habilitada en PHP.
