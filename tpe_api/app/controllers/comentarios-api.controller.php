<?php
require_once './app/models/comentarios.model.php';
require_once './app/models/cars.model.php';

class ComentarioApiController
{
    private $model;
    private $carModel;

    public function __construct()
    {
        $this->model = new ComentarioModel();
        $this->carModel = new carsModel();
    }

    // MIEMBRO A  
    // GET /comentarios (con ordenamiento y filtro opcional)
    public function getComentarios($req, $res)
    {

        // (Opcional - Filtro para Parte B)
        // Verificamos si la consulta pide filtrar por vehiculo
        // ej: GET /comentarios?id_vehiculo=3
        if (isset($req->query->id_vehiculo)) {
            $id_vehiculo = $req->query->id_vehiculo;
            $comentarios = $this->model->getAllByVehiculo($id_vehiculo);
            return $res->json($comentarios);
        }

        // Miembro A - listado ordenado 
        // si no hay filtro se obtiene todo ordenado
        $sort = $req->query->sort ?? null;
        $order = $req->query->order ?? 'ASC';

        $comentarios = $this->model->getAll($sort, $order);
        return $res->json($comentarios);
    }

    // MIEMBRO A
    // PUT /comentarios/:id
    public function updateComentario($req, $res)
    {
        $idComentario = $req->params->id;
        $comentario = $this->model->get($idComentario);

        if (!$comentario) {
            return $res->json("El comentario con el id=$idComentario no existe", 404);
        }

        // Validamos el body
        if (
            empty($req->body->comentario) ||
            !isset($req->body->puntaje)
        ) {
            return $res->json('Faltan datos (comentario, puntaje)', 400);
        }

        // Validación extra
        $puntaje = (int) $req->body->puntaje;
        if ($puntaje < 1 || $puntaje > 5) {
            return $res->json('El puntaje debe ser entre 1 y 5', 400);
        }

        $this->model->update($idComentario, $req->body->comentario, $puntaje);

        $updatedComentario = $this->model->get($idComentario);
        return $res->json($updatedComentario, 201); // 201 o 200 OK
    }

    // MIEMBRO B
    // GET /comentarios/:id
    public function getComentario($req, $res)
    {

        $idComentario = $req->params->id;
        $comentario = $this->model->get($idComentario);

        if (!$comentario) {
            return $res->json("El comentario con el id=$idComentario no existe", 404);
        }

        return $res->json($comentario);

    }

    // MIEMBRO B 
    // POST /comentarios
    public function insertComentario($req, $res)
    {
        // Valida que vengan todos los datos necesarios en el body
        if (
            empty($req->body->comentario) ||
            !isset($req->body->puntaje) ||
            empty($req->body->id_vehiculo_fk)
        ) {
            return $res->json('Faltan datos (comentario, puntaje, id_vehiculo_fk)', 400);
        }

        // Verificamos que el auto exista
        $car = $this->carModel->getCarsById($req->body->id_vehiculo_fk);
        if (!$car) {
            return $res->json('El vehiculo (id_vehiculo_fk) no existe', 404);
        }

        // Validación extra
        $puntaje = (int) $req->body->puntaje;
        if ($puntaje < 1 || $puntaje > 5) {
            return $res->json('El puntaje debe ser entre 1 y 5', 400);
        }

        // Inserta el nuevo comentario
        $newCommentId = $this->model->insert($req->body->comentario, $puntaje, $req->body->id_vehiculo_fk);

        if ($newCommentId == false) {
            return $res->json('Error del servidor', 500);
        }

        $newComment = $this->model->get($newCommentId);
        return $res->json($newComment, 201);

    }

    // DELETE /comentarios/:id
    public function deleteComentario($req, $res)
    {

        $idComentario = $req->params->id;
        $comentario = $this->model->get($idComentario);

        if (!$comentario) {
            return $res->json("El comentario con el id=$idComentario no existe", 404);
        }

        $this->model->remove($idComentario);
        
        // respuesta para un delete : 200
        return $res->json("El comentario con el id=$idComentario se eliminó", 200);

    }
}