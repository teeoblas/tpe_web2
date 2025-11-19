<?php
session_start();
require_once "app/controllers/cars.controller.php";
require_once "app/controllers/marca.controller.php";

require_once 'app/controllers/auth.controller.php';
require_once './app/views/auth.view.php';

require_once './app/middlewares/session.middleware.php';
require_once './app/middlewares/guard.middleware.php';

require_once './app/helpers/UserSession.php';


define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

// Crear controladores y vistas
$carsController = new carsController();
$marcaController = new marcaController();
$authController = new AuthController();
$authView = new AuthView();

// Acción por defecto
$action = 'concesionaria';
if (!empty($_GET['action'])) {
    $action = $_GET['action'];
}

// Separar acción y parámetros
$params = explode('/', $action);

// Request y sesión
$request = new StdClass();
$request = (new SessionMiddleware())->run($request);

// Guard
$guard = new GuardMiddleware();
$estaLogueado = $guard->run($request);

$user = $request->user ?? null;

//header
require 'templates/layout/header.phtml';
// --- RUTEO ---
switch ($params[0]) {

    //muestra ambas tablas
    case 'concesionaria':
        $carsController->getCars($request);
        $marcaController->getAllMarcas($request);
        break;
    //muestra solo marcas
    case 'marcas':
        $marcaController->getAllMarcas($request);
        break;

    //muestra una marca con sus detalles
    case 'marca':
        if (!empty($params[1])) {
            $marcaController->getMarcaId($params[1], $request);
        } else {
            echo "ID de la marca no proporcionado";
        }
        break;
    //muestra tabla vehiculos
    case 'vehiculos':
        $carsController->getCars($request);
        break;

    //muestra un vehiculo con sus detalles
    case 'vehiculo':
        if (!empty($params[1])) {
            $carsController->getCarsId($params[1], $request);
        } else {
            echo "ID del vehículo no proporcionado";
        }
        break;

    //agrega un vehiculo
    case 'agregarCar':
        if ($estaLogueado) {
            $carsController->showAddCarsForm($request);
        } else {
            $authView->showError("Debes loguearte para realizar esa acción", $request->user);
        }
        break;

    //agrega una marca
    case 'agregarMarca':
        if ($estaLogueado) {
            $marcaController->showAddMarcaForm($request);
        } else {
            $authView->showError("Debes loguearte para realizar esa acción", $request->user);
        }
        break;

    //inserta vehiculo
    case 'insertarCar':
        if ($estaLogueado) {
            $carsController->addCars($request);
        } else {
            $authView->showError("Debes loguearte para realizar esa acción", $request->user);
        }
        break;
    //inserta marca
    case 'insertarMarca':
        if ($estaLogueado) {
            $marcaController->addMarca($request);
        } else {
            $authView->showError("Debes loguearte para realizar esa acción", $request->user);
        }
        break;

    //borra un vehiculo
    case 'borrarCar':
        if ($estaLogueado) {
            if (!empty($params[1])) {
                $carsController->deleteCars($params[1]);
            } else {
                echo "ID del vehículo no proporcionado";
            }
        } else {
            $authView->showError("Debes loguearte para realizar esa acción", $request->user);
        }
        break;

    //borra una marca
    case 'borrarMarca':
        if ($estaLogueado) {
            if (!empty($params[1])) {
                $marcaController->deleteMarca($params[1]);
            } else {
                echo "ID del vehículo no proporcionado";
            }
        } else {
            $authView->showError("Debes loguearte para realizar esa acción", $request->user);
        }
        break;

    //edita un vehiculo
    case 'editCar':
        if ($estaLogueado) {
            if (!empty($params[1])) {
                $id_vehiculo = $params[1];
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // si se envió el formulario -> actualizar
                    $carsController->updateCars($id_vehiculo, $request);
                } else {
                    // si es GET -> mostrar formulario
                    $carsController->showEditForm($id_vehiculo, $request);
                }
            } else {
                echo "Error: falta ID en la URL";
            }
        } else {
            $authView->showError("Debes loguearte para realizar esa acción", $request->user);
        }
        break;

    //edita una marca
    case 'editMarca':
        if ($estaLogueado) {
            if (!empty($params[1])) {
                $id_marca = $params[1];
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // si se envió el formulario -> actualizar
                    $marcaController->updateMarca($id_marca, $request);
                } else {
                    // si es GET -> mostrar formulario
                    $marcaController->showEditForm($id_marca, $request);
                }
            } else {
                echo "Error: falta ID en la URL";
            }
        } else {
            $authView->showError("Debes loguearte para realizar esa acción", $request->user);
        }
        break;

    //sessiones
    case 'login':
        $authController->showLogin($request);
        break;

    case 'do_login':
        $authController->doLogin($request);
        break;

    case 'logout':
        if ($estaLogueado) {
            $authController->logout($request);
        } else {
            $authView->showError("No estás logueado", $request->user);
        }
        break;

    default:
        echo "404 Page Not Found";
        break;
}
require 'templates/layout/footer.phtml';
