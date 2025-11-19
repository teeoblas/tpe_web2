<?php

class carsModel
{
    private $db;

    function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=db_concesionaria;charset=utf8', 'root', '');
    }
    public function getCars()
    {
        $sentencia = $this->db->prepare("SELECT id_vehiculo, modelo FROM vehiculos");
        $sentencia->execute();
        $cars = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $cars;
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