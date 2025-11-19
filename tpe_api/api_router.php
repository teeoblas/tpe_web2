<?php
require_once './libs/router/router.php';
require_once './libs/jwt/jwt.middleware.php';

// --- Controladores y Middlewares de Seguridad ---
require_once './app/middlewares/guard-api.middleware.php';
require_once './app/controllers/auth-api.controller.php';

// --- Controladores de Recursos ---
require_once './app/controllers/marca-api.controller.php';
require_once './app/controllers/cars-api.controller.php';
require_once './app/controllers/comentarios-api.controller.php';


// instancio el router
$router = new Router();

// Middleware: se ejecuta siempre para intentar decodificar el token
$router->addMiddleware(new JWTMiddleware());


// --- Endpoints de Autenticación ---
$router->addRoute('auth/login', 'GET', 'AuthApiController', 'login');


// --- Endpoints Públicos (solo lectura, GET) ---

// RUTAS PARA MARCAS
// (Miembro A - Implementada) Ruta para obtener todas las marcas (con ordenamiento)
$router->addRoute('marcas', 'GET', 'MarcaApiController', 'getMarcas');

// (Miembro B - Comentada) Ruta para obtener una marca por ID
$router->addRoute('marcas/:id', 'GET', 'MarcaApiController', 'getMarca');

// RUTAS PARA CARS
// (Miembro A - Implementada) Ruta para obtener todos los vehiculos (con ordenamiento)
$router->addRoute('cars', 'GET', 'CarsApiController', 'getCars');

// (Miembro B - Comentada) Ruta para obtener un vehiculo por ID
$router->addRoute('cars/:id', 'GET', 'CarsApiController', 'getCar');

// RUTAS PARA COMENTARIOS
// (Miembro A) Ruta para obtener todos los comentarios (con ordenamiento)
$router->addRoute('comentarios', 'GET', 'ComentarioApiController', 'getComentarios');
// (Miembro B)Ruta para obtener un comentario por ID
$router->addRoute('comentarios/:id', 'GET', 'ComentarioApiController', 'getComentario');


// --- Guardia de Seguridad ---
// A partir de esta línea, todas las rutas que se definan
// requerirán un token válido y el rol 'administrador'
$router->addMiddleware(new GuardMiddleware());

// --- Endpoints Protegidos (escritura: POST, PUT, DELETE) ---

// RUTAS PARA CARS
// (Miembro A) Ruta para modificar un vehiculo
$router->addRoute('cars/:id', 'PUT', 'CarsApiController', 'updateCar');

// (Miembro B) Ruta para insertar un vehiculo
$router->addRoute('cars', 'POST', 'CarsApiController', 'insertCar');

// (Opcional) Ruta para eliminar un vehiculo
$router->addRoute('cars/:id', 'DELETE', 'CarsApiController', 'deleteCar');

// RUTAS PARA MARCAS
// (Miembro A Ruta para modificar una marca)
$router->addRoute('marcas/:id', 'PUT', 'MarcaApiController', 'updateMarca');

// (Miembro B) Ruta para insertar una marca
$router->addRoute('marcas', 'POST', 'MarcaApiController', 'insertMarca');

// (Opcional) Ruta para eliminar una marca
$router->addRoute('marcas/:id', 'DELETE', 'MarcaApiController', 'deleteMarca');


// RUTAS PARA COMENTARIOS
// (Miembro A) Ruta para modificar un comentario
$router->addRoute('comentarios/:id', 'PUT', 'ComentarioApiController', 'updateComentario');

//(Miembro B) Ruta para insertar un comentario
$router->addRoute('comentarios', 'POST', 'ComentarioApiController', 'insertComentario');

// (Opcional) Ruta para eliminar un comentario
$router->addRoute('comentarios/:id', 'DELETE', 'ComentarioApiController', 'deleteComentario');


// rutea la petición
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);

