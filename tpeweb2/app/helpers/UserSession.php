<?php

class UserSession
{

    // Inicia la sesión si aún no está activa
    public static function start()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    // Verifica si hay un usuario autenticado
    public static function activeUser()
    {
        self::start();
        return isset($_SESSION['id_usuario']);
    }

    // Devuelve el nombre de usuario si hay sesión
    public static function getActiveUsername()
    {
        self::start();
        return $_SESSION['usuario'] ?? null;
    }

    // Cierra la sesión
    public static function end()
    {
        self::start();
        session_destroy();
    }
}
