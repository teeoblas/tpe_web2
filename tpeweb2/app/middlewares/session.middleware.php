<?php
class SessionMiddleware
{
    // En SessionMiddleware.php

    public function run($request)
    {
        if (isset($_SESSION['id_usuario'])) {
            $request->user = new StdClass();
            $request->user->id = $_SESSION['id_usuario'];
            $request->user->username = $_SESSION['usuario']; // <-- ¡Esta es la variable que usa el header!
        } else {
            $request->user = null;
        }
        return $request;
    }
}