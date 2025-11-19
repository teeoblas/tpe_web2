<?php
require_once "app/models/marca.model.php";
require_once "app/views/marca.view.php";


class marcaController
{
    private $view;
    private $marcaModel;


    //instanciacion de modelo y vista 
    function __construct()
    {
        $this->marcaModel = new marcaModel();
        $this->view = new marcaView();
    }

    //funcion para mostrar las marcas
    public function getAllMarcas($request)
    {
        $user = $request->user;
        $marcas = $this->marcaModel->getAllMarcas();
        $this->view->displayMarcas($marcas, $user);
    }


    //funcion para mostrar la informacion de una marca
    public function getMarcaId($id_marca, $request)
    {
        $user = $request->user;
        $marca = $this->marcaModel->getMarcaById($id_marca);

        if ($marca) {
            $this->view->displayDetalleMarca($marca, $user);
        } else {
            return $this->view->showError('Marca no encontrada', $user);
        }
    }

    //funcion para agregar una marca
    public function addMarca($request)
    {
        if (!isset($_POST['marca']) || empty($_POST['marca'])) {
            return $this->view->showError('Error: falta completar la marca', $request->user);
        }

        if (!isset($_POST['info_general']) || empty($_POST['info_general'])) {
            return $this->view->showError('Error: falta completar la informacion general de la marca');
        }
        if (!isset($_POST['cant_concesionarias_ofi']) || empty($_POST['cant_concesionarias_ofi'])) {
            return $this->view->showError('Error: falta completar la cantidad de concesionarias oficiales');
        }
        if (!isset($_POST['post_venta']) || empty($_POST['post_venta'])) {
            return $this->view->showError('Error: falta completar post venta');
        }


        $marca = $_POST['marca'];
        $info_general = $_POST['info_general'];
        $cant_concesionarias_ofi = $_POST['cant_concesionarias_ofi'];
        $post_venta = $_POST['post_venta'];

        // 5. Llamada al Modelo para la Inserción
        $this->marcaModel->addMarca(
            $marca,
            $info_general,
            $cant_concesionarias_ofi,
            $post_venta
        );
        header('Location: ' . BASE_URL);
        die();
    }

    //funcion para mostrar el formulario de alta 
    public function showAddMarcaForm($request) // Debe aceptar $request si usa el header
    {
        $user = $request->user;

        $marcas = $this->marcaModel->getAllMarcas();


        $this->view->displayAddMarcaForm($marcas, $user);
    }

    //funcion para editar un vehiculo 
    public function updateMarca($id_marca, $request)
    {
        if (!isset($_POST['marca']) || empty($_POST['marca']))
            return $this->view->showError('Falta marca');
        if (!isset($_POST['info_general']) || empty($_POST['info_general']))
            return $this->view->showError('Falta informacion generals');


        $id_marca = $_POST['id_marca'];
        $marca = $_POST['marca'];
        $info_general = $_POST['info_general'];
        $cant_concesionarias_ofi = $_POST['cant_concesionarias_ofi'];
        $post_venta = $_POST['post_venta'];

        $this->marcaModel->updateMarca(
            $id_marca,
            $marca,
            $info_general,
            $cant_concesionarias_ofi,
            $post_venta

        );

        header('Location: ' . BASE_URL);
        die();
    }

    public function showEditForm($id_marca, $request)
    {
        $user = $request->user;
        $marca = $this->marcaModel->getMarcaById($id_marca);
        require './templates/marcas/form_editMarca.phtml';
    }


    function deleteMarca($id_marca)
    {
        $this->marcaModel->deleteMarca($id_marca);

        header('Location: ' . BASE_URL);
        die();
    }

}