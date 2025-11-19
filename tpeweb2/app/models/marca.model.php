<?php
class marcaModel
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=db_concesionaria;charset=utf8', 'root', '');
    }

    public function getAllMarcas()
    {
        $query = $this->db->prepare("SELECT * FROM marca");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getMarcaById($id)
    {
        $query = $this->db->prepare("SELECT * FROM marca WHERE id_marca = ?");
        $query->execute([$id]);
        $marca = $query->fetch(PDO::FETCH_OBJ);
        return $marca;
    }
    function addMarca($marca, $info_general, $cant_concesionarias_ofi, $post_venta)
    {
       
        $sentencia = $this->db->prepare("INSERT INTO marca(marca, info_general, cant_concesionarias_ofi, post_venta) VALUES(?,?,?,?)");

        $sentencia->execute([$marca, $info_general, $cant_concesionarias_ofi, $post_venta]);
    }

    public function deleteMarca($id_marca)
    {
        $sentencia = $this->db->prepare("DELETE FROM marca WHERE id_marca=?");
        $sentencia->execute(array($id_marca));
    }

    public function updateMarca($id_marca, $marca, $info_general, $cant_concesionarias_ofi, $post_venta)
    {
        $sentencia = $this->db->prepare("UPDATE marca SET marca=?, info_general=?, cant_concesionarias_ofi=?, post_venta=? WHERE id_marca=?");
        $sentencia->execute([$marca, $info_general, $cant_concesionarias_ofi, $post_venta, $id_marca]);
    }

}

