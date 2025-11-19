<?php
class marcaModel
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=db_concesionaria;charset=utf8', 'root', '');
    }


    //Miembro A - Obligatorio y Opcional
    public function getAllMarcas($sort = null, $order = 'ASC')
    {
        // 1. Lista blanca de columnas válidas para ordenar
        $columnasValidas = ['id_marca', 'marca', 'info_general', 'cant_concesionarias_ofi'];

        // 2. Validar el parámetro $sort
        $sortColumn = null;
        if ($sort && in_array(strtolower($sort), $columnasValidas)) {
            $sortColumn = $sort;
        }

        // 3. Validar el parámetro $order
        $orderDir = strtoupper($order);
        if ($orderDir !== 'ASC' && $orderDir !== 'DESC') {
            $orderDir = 'ASC';
        }

        // 4. Construir la consulta SQL dinámicamente
        $sql = "SELECT * FROM marca";

        if ($sortColumn) {
            // Si hay un campo de sort válido, lo agregamos
            $sql .= " ORDER BY $sortColumn $orderDir";
        }
        // Si no se pasa un sort válido, simplemente devuelve todos sin ordenar (o con el orden natural de la DB)

        // 5. Ejecutar y devolver
        $query = $this->db->prepare($sql);
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

        // Devolver el ID es necesario para la respuesta 201
        return $this->db->lastInsertId();
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