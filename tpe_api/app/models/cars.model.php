<?php

class carsModel
{
    private $db;

    function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=db_concesionaria;charset=utf8', 'root', '');
    }
    public function getCars($sort = null, $order = 'ASC')
    {
        $columnasValidas = ['id_vehiculo', 'modelo', 'año', 'kilometraje', 'version', 'motorizacion', 'categoria', 'id_marca'];

        $sortColumn = null;
        if ($sort && in_array(strtolower($sort), $columnasValidas)) {
            $sortColumn = $sort;
        }


        $orderDir = strtoupper($order);
        if ($orderDir !== 'ASC' && $orderDir !== 'DESC') {
            $orderDir = 'ASC';
        }

        $sql = "SELECT * FROM vehiculos";

        if ($sortColumn) {
            $sql .= " ORDER BY $sortColumn $orderDir";
        }

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }


    function getCarsById($id)
    {
        $sentencia = $this->db->prepare("SELECT * FROM vehiculos WHERE id_vehiculo = ?");
        $sentencia->execute([$id]);

        $cars = $sentencia->fetch(PDO::FETCH_OBJ);
        return $cars;
    }


    function addCars($modelo, $año, $kilometraje, $version, $motorizacion, $categoria, $id_marca)
    {
        $sentencia = $this->db->prepare("INSERT INTO vehiculos(modelo, año, kilometraje, version, motorizacion, categoria, id_marca) VALUES(?,?,?,?,?,?,?)");
        $sentencia->execute([$modelo, $año, $kilometraje, $version, $motorizacion, $categoria, $id_marca]);

        //Devolvemos el ID para la respuesta
        return $this->db->lastInsertId();
    }


    public function deleteCars($id_vehiculo)
    {
        $sentencia = $this->db->prepare("DELETE FROM vehiculos WHERE id_vehiculo=?");
        $sentencia->execute(array($id_vehiculo));
    }


    public function updateCars($id_vehiculo, $modelo, $año, $kilometraje, $version, $motorizacion, $categoria, $id_marca)
    {
        $sentencia = $this->db->prepare("UPDATE vehiculos 
            SET modelo=?, año=?, kilometraje=?, version=?, motorizacion=?, categoria=?, id_marca=? 
            WHERE id_vehiculo=?");

        $sentencia->execute([$modelo, $año, $kilometraje, $version, $motorizacion, $categoria, $id_marca, $id_vehiculo]);
    }
}