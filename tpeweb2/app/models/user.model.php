<?php

class UserModel
{
    private $db;

    function __construct()
    {
        // 1. abro conexión con la DB
        $this->db = new PDO('mysql:host=localhost;dbname=db_concesionaria;charset=utf8', 'root', '');
    }

    public function get($id_usuario)
    {
        $query = $this->db->prepare('SELECT * FROM usuarios WHERE id_usuario = ?');
        $query->execute([$id_usuario]);
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
        // 2. ejecuto la consulta SQL (SELECT * FROM tareas)
        $query = $this->db->prepare('SELECT * FROM usuarios');
        $query->execute();

        // 3. obtengo los resultados de la consulta
        $users = $query->fetchAll(PDO::FETCH_OBJ);

        return $users;
    }



    function insert($name, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = $this->db->prepare("INSERT INTO usuarios(usuario, contraseña) VALUES(?,?)");
        $query->execute([$name, $hashedPassword]);

        return $this->db->lastInsertId();
    }
}