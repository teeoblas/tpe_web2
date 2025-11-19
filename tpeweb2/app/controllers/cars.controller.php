<?php
require_once "app/models/cars.model.php";
require_once "app/views/cars.view.php";
require_once 'app/models/marca.model.php';

class carsController
{
    private $model;
    private $view;
    private $marcaModel;


    //instanciacion de modelo y vista 
    function __construct()
    {
        $this->model = new carsModel();
        $this->view = new carsView();
        $this->marcaModel = new marcaModel();
    }

    //funcion para mostrar los vehiculos
    public function getCars($request)
    {
        // CORRECCIÓN 1: Definir $user extrayéndolo de $request
        $user = $request->user;

        $cars = $this->model->getCars();
        $this->view->displayCars($cars, $user);
    }

    //funcion para mostrar la informacion de un vehiculo 
    public function getCarsId($id_vehiculo, $request)
    {
        // CORRECCIÓN 2: Definir $user extrayéndolo de $request
        $user = $request->user;

        $car = $this->model->getCarsById($id_vehiculo);
        $this->view->displayCarsDetalle($car, $user);
    }



    //funcion para agregar vehiculos 
    public function addCars($request)
    {
        if (!isset($_POST['modelo']) || empty($_POST['modelo'])) {
            return $this->view->showError('Error: falta completar el modelo del vehiculo', $request->user);
        }

        if (!isset($_POST['año']) || empty($_POST['año'])) {
            return $this->view->showError('Error: falta completar el año del vehiculo');
        }
        if (!isset($_POST['kilometraje']) || empty($_POST['kilometraje'])) {
            return $this->view->showError('Error: falta completar kilometraje del vehiculo');
        }
        if (!isset($_POST['version']) || empty($_POST['version'])) {
            return $this->view->showError('Error: falta completar la version del vehiculo');
        }
        if (!isset($_POST['motorizacion']) || empty($_POST['motorizacion'])) {
            return $this->view->showError('Error: falta completar la motorizacion del vehiculo');
        }
        if (!isset($_POST['categoria']) || empty($_POST['categoria'])) {
            return $this->view->showError('Error: falta completar categoria del vehiculo');
        }

        $id_marca = $_POST['id_marca'];
        $modelo = $_POST['modelo'];
        $año = $_POST['año'];
        $kilometraje = $_POST['kilometraje'];
        $version = $_POST['version'];
        $motorizacion = $_POST['motorizacion'];
        $categoria = $_POST['categoria'];

        // 5. Llamada al Modelo para la Inserción
        $this->model->addCars(
            $modelo,
            $año,
            $kilometraje,
            $version,
            $motorizacion,
            $categoria,
            $id_marca
        );
        header('Location: ' . BASE_URL);
        die();
    }


    //funcion para mostrar el formulario de alta 
    public function showAddCarsForm($request) // Debe aceptar $request si usa el header
    {
        $user = $request->user;

        $marcas = $this->marcaModel->getAllMarcas();


        $this->view->displayAddCarsForm($marcas, $user);
    }

    //funcion para eliminar un vehiculo 
    function deleteCars($id_vehiculo)
    {
        $this->model->deleteCars($id_vehiculo);

        header('Location: ' . BASE_URL);
        die();
    }


    //funcion para editar un vehiculo 
    public function updateCars($id_vehiculo, $request)
    {
        if (!isset($_POST['modelo']) || empty($_POST['modelo']))
            return $this->view->showError('Falta modelo');
        if (!isset($_POST['año']) || empty($_POST['año']))
            return $this->view->showError('Falta año');

        $modelo = $_POST['modelo'];
        $año = $_POST['año'];
        $kilometraje = $_POST['kilometraje'];
        $version = $_POST['version'];
        $motorizacion = $_POST['motorizacion'];
        $categoria = $_POST['categoria'];
        $id_marca = $_POST['id_marca'];

        $this->model->updateCars(
            $id_vehiculo,
            $modelo,
            $año,
            $kilometraje,
            $version,
            $motorizacion,
            $categoria,
            $id_marca
        );

        header('Location: ' . BASE_URL);
        die();
    }





    //funcion de formulario de edicion de vehiculo 
    public function showEditForm($id_vehiculo, $request) // Debe aceptar $request si usa el header
    {
        $user = $request->user;

        $car = $this->model->getCarsById($id_vehiculo);
        $marcas = $this->marcaModel->getAllMarcas();

        require './templates/cars/form_editCar.phtml';
    }
}