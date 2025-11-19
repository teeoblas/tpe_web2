<?php

class UserModel
{
    private $db;

    function __construct()
    {

        $this->db = new PDO('mysql:host=localhost;dbname=db_concesionaria;charset=utf8', 'root', '');
    }

    public function get($id)
    {
        $query = $this->db->prepare('SELECT * FROM usuarios WHERE id_usuario = ?');
        $query->execute([$id]);
        $user = $query->fetch(PDO::FETCH_OBJ);

        return $user;
    }

    public function getByUser($user)
    {
        $query = $this->db->prepare('SELECT * FROM usuarios WHERE usuario = ?');
        $query->execute([$user]);
        $user = $query->fetch(PDO::FETCH_OBJ);

        return $user;
    }

    public function getAll()
    {
        $query = $this->db->prepare('SELECT * FROM usuarios');
        $query->execute();


        $users = $query->fetchAll(PDO::FETCH_OBJ);

        return $users;
    }


    function insert($name, $password, $rol = 'usuario')
    {
        $query = $this->db->prepare("INSERT INTO usuarios(usuario, contraseña, rol) VALUES(?,?,?)");
        $query->execute([$name, $password, $rol]);



        return $this->db->lastInsertId();
    }
}