<?php
// Configuración de la base de datos
define('DB_HOST', '127.0.0.1');               // Servidor
define('DB_NAME', 'db_concesionaria');        // Nombre de la base de datos
define('DB_USER', 'root');                    // Usuario
define('DB_PASS', '');                        // Contraseña

// URL base del proyecto
define('BASE_URL', 'http://localhost/tpeweb2/');

function getPDO()
{
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ];
    return new PDO($dsn, DB_USER, DB_PASS, $options);
}
?>
