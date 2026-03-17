<?php
require_once __DIR__ . '/Database.php';

class Ticket 
{
  public static function all(): array
  {
    // Traemos los tickets con el nombre de su categoría usando un JOIN
    $sql = "SELECT t.id, t.asunto, t.prioridad, t.estado, t.usuario, t.fecha_creacion, c.nombre as categoria 
            FROM tickets t 
            LEFT JOIN categorias c ON t.categoria_id = c.id 
            ORDER BY t.fecha_creacion DESC";
    $stmt = Database::pdo()->query($sql);
    return $stmt->fetchAll();
  }

  public static function find(int $id): ?array
  {
    // Buscamos un ticket específico con su categoría para el panel de detalle
    $sql = "SELECT t.*, c.nombre as categoria 
            FROM tickets t 
            LEFT JOIN categorias c ON t.categoria_id = c.id 
            WHERE t.id = :id";
    $stmt = Database::pdo()->prepare($sql);
    $stmt->execute([':id' => $id]);

    $row = $stmt->fetch();
    return $row ?: null;
  }

  public static function create(array $data): void
  {
    $asunto = trim($data['asunto'] ?? '');
    if ($asunto === '') {
      throw new Exception("El asunto del ticket es obligatorio.");
    }

    $sql = "INSERT INTO tickets (asunto, descripcion, usuario, prioridad, categoria_id, estado) 
            VALUES (:asunto, :descripcion, :usuario, :prioridad, :categoria_id, 'Abierta')";
    
    $stmt = Database::pdo()->prepare($sql);
    $stmt->execute([
      ':asunto'      => $asunto,
      ':descripcion' => $data['descripcion'] ?? '',
      ':usuario'     => $data['usuario'] ?? 'Anónimo',
      ':prioridad'   => $data['prioridad'] ?? 'Media',
      ':categoria_id'=> $data['categoria_id'] ?? null
    ]);
  }

  public static function updateEstado(int $id, string $nuevoEstado): void
  {
    $estadosValidos = ['Abierta', 'En curso', 'Resuelta'];
    if (!in_array($nuevoEstado, $estadosValidos)) {
      throw new Exception("Estado no válido.");
    }

    $sql = "UPDATE tickets SET estado = :estado WHERE id = :id";
    $stmt = Database::pdo()->prepare($sql);
    $stmt->execute([
      ':id'     => $id,
      ':estado' => $nuevoEstado
    ]);
  }

  public static function delete(int $id): void
  {
    $sql = "DELETE FROM tickets WHERE id = :id";
    $stmt = Database::pdo()->prepare($sql);
    $stmt->execute([':id' => $id]);
  }
}
