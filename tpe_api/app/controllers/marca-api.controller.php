<?php
// 1. Incluimos el modelo de marca
require_once './app/models/marca.model.php';

// 2. Cambiamos el nombre de la clase
class MarcaApiController
{
    private $model;

    public function __construct()
    {
        $this->model = new marcaModel();
    }



    // Miembro A : Obtiene todas las marcas, cumpliendo con el requisito obligatorio de ORDENAMIENTO.

    public function getMarcas($req, $res)
    {

        // Miembro A: ordenado por cualquier campo

        // 1. Obtenemos los parámetros de query 'sort' y 'order'
        $sort = $req->query->sort ?? null;
        $order = $req->query->order ?? 'ASC';

        // 2. Pedimos las marcas al modelo, pasándole el ordenamiento
        $marcas = $this->model->getAllMarcas($sort, $order);

        // 3. Respondemos con 200 OK
        return $res->json($marcas);
    }


    //Miembro A : PUT.
    public function updateMarca($req, $res)
    {
        // 1. Obtener el ID de la marca 
        $idMarca = $req->params->id;
        $marca = $this->model->getMarcaById($idMarca);

        // 2. Verificar que la marca exista (Manejo de 404)
        if (!$marca) {
            return $res->json("La marca con el id=$idMarca no existe", 404);
        }

        // 3. Validar los datos del body 
        if (
            empty($req->body->marca) ||
            empty($req->body->info_general) ||
            empty($req->body->cant_concesionarias_ofi) ||
            empty($req->body->post_venta)
        ) {
            // Manejo de 400 
            return $res->json('Faltan datos obligatorios', 400);
        }

        // 4. Obtener los datos del body
        $nombreMarca = $req->body->marca;
        $info = $req->body->info_general;
        $concesionarias = $req->body->cant_concesionarias_ofi;
        $postVenta = $req->body->post_venta;

        // 5. Llamar al modelo para actualizar
        $this->model->updateMarca($idMarca, $nombreMarca, $info, $concesionarias, $postVenta);

        // 6. Devolver la marca actualizada con código 200
        $marcaActualizada = $this->model->getMarcaById($idMarca);
        return $res->json($marcaActualizada, 200);
    }



    //Miembro B : obtiene una marca por su ID.
    public function getMarca($req, $res)
    {

        // 1. Obtener el ID
        $idMarca = $req->params->id;

        // 2. Pedir al modelo
        $marca = $this->model->getMarcaById($idMarca);

        // 3. Manejar 404
        if (!$marca) {
            return $res->json("La marca con el id=$idMarca no existe", 404);
        }

        // 4. Responder 200 OK
        return $res->json($marca);

    }


    //Miembro B : Inserta una nueva marca.
    public function insertMarca($req, $res)
    {
        // 1. Validar datos del body (Manejo de 400)
        if (
            empty($req->body->marca) ||
            empty($req->body->info_general) ||
            empty($req->body->cant_concesionarias_ofi) ||
            empty($req->body->post_venta)
        ) {
            return $res->json('Faltan datos obligatorios', 400);
        }

        // 2. Obtener datos del body
        $nombreMarca = $req->body->marca;
        $info = $req->body->info_general;
        $concesionarias = $req->body->cant_concesionarias_ofi;
        $postVenta = $req->body->post_venta;

        // 3. Llamar al modelo para insertar
        $newMarcaId = $this->model->addMarca($nombreMarca, $info, $concesionarias, $postVenta);

        // 4. Devolver la nueva marca con código 201 (Created)
        $nuevaMarca = $this->model->getMarcaById($newMarcaId);
        return $res->json($nuevaMarca, 201);

    }

    
    // Opcional Eliminar una marca.
    public function deleteMarca($req, $res)
    {
        $idMarca = $req->params->id;
        $marca = $this->model->getMarcaById($idMarca);

        if (!$marca) {
            return $res->json("La marca con el id=$idMarca no existe", 404);
        }

        $this->model->deleteMarca($idMarca);

        // respuesta para un delete : 200
        return $res->json("La marca con el id=$idMarca se eliminó", 200);
        
    }
}