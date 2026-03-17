<?php

class Database
{
  public static function pdo(): PDO
  {
    // “static” guarda el valor entre llamadas a esta función
    static $pdo = null;

    // Si ya existe la conexión, la devolvemos
    if ($pdo !== null) {
      return $pdo;
    }

    // Cargamos el array de configuración
    $c = require __DIR__ . '/../config/config.php';

    // Creamos el DSN (cadena de conexión)
    $dsn = "mysql:host=" . $c['host'] . ";dbname=" . $c['db'] . ";charset=" . $c['charset'];

    // Creamos PDO (la conexión)
    $pdo = new PDO($dsn, $c['user'], $c['pass']);

    // Si hay un error en SQL, PDO lanzará una excepción
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Al hacer fetch(), queremos arrays asociativos (['columna' => valor])
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $pdo;
  }
}

?>