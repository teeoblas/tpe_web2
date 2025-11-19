<?php

class ComentarioModel
{
    private $db;

    function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=db_concesionaria;charset=utf8', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function get($id)
    {
        $query = $this->db->prepare('SELECT * FROM comentarios WHERE id_comentario = ?');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    
    //Obtiene todos los comentarios, con ordenamiento.
     
    public function getAll($sort, $order)
    {
        // 1. Validamos los campos de ordenamiento
        $allowedSorts = ['id_comentario', 'comentario', 'puntaje', 'id_vehiculo_fk'];
        $sortColumn = in_array(strtolower($sort), $allowedSorts) ? $sort : 'id_comentario'; // Columna por defecto

        $orderDir = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC'; // Dirección por defecto

        // 2. Ejecuto la consulta SQL
        $queryStr = "SELECT * FROM comentarios ORDER BY $sortColumn $orderDir";
        $query = $this->db->prepare($queryStr);
        $query->execute();

        // 3. Obtengo los resultados
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    
    //Opcional - Filtro :  Obtiene todos los comentarios para un vehiculo específico
    public function getAllByVehiculo($id_vehiculo)
    {
        $query = $this->db->prepare('SELECT * FROM comentarios WHERE id_vehiculo_fk = ?');
        $query->execute([$id_vehiculo]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    
    //Inserta un nuevo comentario
    function insert($comentario, $puntaje, $id_vehiculo_fk)
    {
        $query = $this->db->prepare("INSERT INTO comentarios(comentario, puntaje, id_vehiculo_fk) VALUES(?,?,?)");
        $query->execute([$comentario, $puntaje, $id_vehiculo_fk]);
        return $this->db->lastInsertId();
    }

    
    //Elimina un comentario por ID
    function remove($id)
    {
        $query = $this->db->prepare('DELETE from comentarios WHERE id_comentario = ?');
        $query->execute([$id]);
        return $query->rowCount(); // Devuelve la cantidad de filas afectadas
    }

    
    //Actualiza un comentario por ID (solo comentario y puntaje)
     
    function update($id, $comentario, $puntaje)
    {
        $query = $this->db->prepare("
            UPDATE comentarios 
            SET comentario = ?, puntaje = ?
            WHERE id_comentario = ?
        ");
        $query->execute([$comentario, $puntaje, $id]);
        return $query->rowCount(); // Devuelve la cantidad de filas afectadas
    }
}