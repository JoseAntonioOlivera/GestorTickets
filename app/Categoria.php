<?php
require_once __DIR__ . '/Database.php';

class Categoria 
{
  /**
   * Obtiene todas las categorías para llenar los select de los formularios
   */
  public static function all(): array
  {
    $sql = "SELECT id, nombre FROM categorias ORDER BY nombre ASC";
    $stmt = Database::pdo()->query($sql);
    // Usamos FETCH_ASSOC para asegurar que los índices sean nombres de columnas
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Busca una categoría específica por su ID
   */
  public static function find(int $id): ?array
  {
    $sql = "SELECT id, nombre FROM categorias WHERE id = :id";
    $stmt = Database::pdo()->prepare($sql);
    $stmt->execute([':id' => $id]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ?: null;
  }

  /**
   * Permite crear nuevas categorías si lo necesitas en el futuro
   */
  public static function create(string $nombre): void
  {
    $nombre = trim($nombre);
    if ($nombre === '') {
      throw new Exception("El nombre de la categoría es obligatorio.");
    }

    $sql = "INSERT INTO categorias (nombre) VALUES (:nombre)";
    $stmt = Database::pdo()->prepare($sql);
    $stmt->execute([':nombre' => $nombre]);
  }
}
