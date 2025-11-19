<?php
require_once './app/models/cars.model.php';


class CarsApiController
{
    private $model;

    public function __construct()
    {
        $this->model = new carsModel();
    }




    // Miembro A : Obtiene todos los vehiculos cumpliendo con el requisito de ordenamiento.

    public function getCars($req, $res)
    {

        // requisito ordenamiento
        $sort = $req->query->sort ?? null;
        $order = $req->query->order ?? 'ASC';

        //Pedimos los vehiculos al modelo
        $cars = $this->model->getCars($sort, $order);

        //Respuesta 200 OK
        return $res->json($cars);
    }


    // Miembro A : PUT.

    public function updateCar($req, $res)
    {
        // 1. Obtener el ID vehiculo
        $idCar = $req->params->id;
        $car = $this->model->getCarsById($idCar);

        // 2. verificamos si existe (Manejo 404)
        if (!$car) {
            return $res->json("El vehiculo con el id=$idCar no existe", 404);
        }

        // 3. Validar los datos del body 
        if (
            empty($req->body->modelo) ||
            empty($req->body->año) ||
            !isset($req->body->kilometraje) || // puede ser 0
            empty($req->body->version) ||
            empty($req->body->motorizacion) ||
            empty($req->body->categoria) ||
            empty($req->body->id_marca)
        ) {
            // Manejo de 400 
            return $res->json('Faltan datos obligatorios', 400);
        }

        // 4. Obtener los datos del body
        $modelo = $req->body->modelo;
        $año = $req->body->año;
        $kilometraje = $req->body->kilometraje;
        $version = $req->body->version;
        $motorizacion = $req->body->motorizacion;
        $categoria = $req->body->categoria;
        $id_marca = $req->body->id_marca;

        // 5. Llamar al modelo para actualizar
        $this->model->updateCars($idCar, $modelo, $año, $kilometraje, $version, $motorizacion, $categoria, $id_marca);

        // 6. Devolvemos el vehiculo actualizado con código 200
        $carActualizado = $this->model->getCarsById($idCar);
        return $res->json($carActualizado, 200);
    }


    //Miembro B : Obtiene un vehiculo por su ID. 
    public function getCar($req, $res)
    {

        // 1. Obtener el ID
        $idCar = $req->params->id;

        // 2. Pedir al modelo
        $car = $this->model->getCarsById($idCar);

        // 3. Manejo 404
        if (!$car) {
            return $res->json("El vehiculo con el id=$idCar no existe", 404);
        }

        // 4. Responder 200 OK
        return $res->json($car);

    }


    //Miembro B : Inserta un nuevo vehiculo. 
    public function insertCar($req, $res)
    {
        // 1. Validar datos del body (Manejo 400)
        if (
            empty($req->body->modelo) ||
            empty($req->body->año) ||
            !isset($req->body->kilometraje) ||
            empty($req->body->version) ||
            empty($req->body->motorizacion) ||
            empty($req->body->categoria) ||
            empty($req->body->id_marca)
        ) {
            return $res->json('Faltan datos obligatorios', 400);
        }

        // 2. Obtener datos del body
        $modelo = $req->body->modelo;
        $año = $req->body->año;
        $kilometraje = $req->body->kilometraje;
        $version = $req->body->version;
        $motorizacion = $req->body->motorizacion;
        $categoria = $req->body->categoria;
        $id_marca = $req->body->id_marca;

        // 3. Llamar al modelo para insertar
        $newCarId = $this->model->addCars($modelo, $año, $kilometraje, $version, $motorizacion, $categoria, $id_marca);

        // 4. Devolver el nuevo vehiculo con código 201 (Created)
        $nuevoCar = $this->model->getCarsById($newCarId);
        return $res->json($nuevoCar, 201);

    }


    //Opcional : Eliminar un vehiculo.
    public function deleteCar($req, $res)
    {
        $idCar = $req->params->id;
        $car = $this->model->getCarsById($idCar);

        if (!$car) {
            return $res->json("El vehiculo con el id=$idCar no existe", 404);
        }


        $this->model->deleteCars($idCar);

        // respuesta para un delete : 200
        return $res->json("El vehiculo con el id=$idCar se eliminó", 200);

    }
}