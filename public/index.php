<?php
// index.php
require_once __DIR__ . '/../app/TicketController.php';

// Capturamos la acción de la URL, por defecto será 'index'
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Instanciamos el controlador de Tickets (Helpdesk)
$controller = new TicketController();

// Verificamos si el método existe en la clase TicketController
if (!method_exists($controller, $action)) {
    header("HTTP/1.0 404 Not Found");
    echo "Error: La acción '" . htmlspecialchars($action) . "' no existe en el controlador de tickets.";
    exit;
}

// Ejecutamos la acción (index, show, create, store, updateEstado o delete)
$controller->$action();
