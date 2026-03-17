<?php
require_once __DIR__ . '/Ticket.php';


class TicketController
{
  public function index(): void
  {
    // Obtenemos los tickets con sus categorías
    $tickets = Ticket::all();
    require __DIR__ . '/views/tickets/index.php';

  }

  // Carga el detalle del ticket para el panel derecho (Llamada AJAX)
public function show(): void
{
    header('Content-Type: application/json');

    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $ticket = Ticket::find($id);
    
    if (!$ticket) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Ticket no encontrado'
        ]);
        exit;
    }
    echo json_encode([
        'status' => 'success',
        'data' => $ticket
    ]);
    
    exit;
}


  public function create(): void
  {
    // Necesitarás cargar las categorías para el desplegable del formulario
    // $categorias = Categoria::all();
    $error = '';
    require __DIR__ . '/views/tickets/create.php';
  }

  public function store(): void
  {
    try {
      Ticket::create([
        'asunto'       => $_POST['asunto'] ?? '',
        'descripcion'  => $_POST['descripcion'] ?? '',
        'usuario'      => $_POST['usuario'] ?? '',
        'prioridad'    => $_POST['prioridad'] ?? 'Media',
        'categoria_id' => $_POST['categoria_id'] ?? null
      ]);

      header("Location: index.php?action=index");
      exit;
    } catch (Exception $e) {
      $error = $e->getMessage();
      require __DIR__ . '/views/tickets/create.php';
    }
  }

  public function updateEstado(): void
  {
    try {
      $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
      $nuevoEstado = isset($_POST['estado']) ? (string)$_POST['estado'] : '';

      Ticket::updateEstado($id, $nuevoEstado);
      echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
      echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit;
  }

  public function delete(): void
  {
    try {
      $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
      Ticket::delete($id);
      header("Location: index.php?action=index");
      exit;
    } catch (Exception $e) {
      echo "Error al borrar: " . $e->getMessage();
    }
  }
}
