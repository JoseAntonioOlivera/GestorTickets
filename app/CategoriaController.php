<?php
require_once __DIR__ . '/Categoria.php';

class CategoriaController
{
    // Carga la vista principal de categorías (si la tienes)
    public function index(): void
    {
        $categorias = Categoria::all();
        require __DIR__ . '/views/categorias/index.php';
    }

    // Devuelve las categorías en JSON (Útil para cargar selects dinámicamente)
    public function getCategoriasJson(): void
    {
        header('Content-Type: application/json');
        try {
            $categorias = Categoria::all();
            echo json_encode([
                'status' => 'success',
                'data' => $categorias
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }

    // Procesa el guardado de una nueva categoría
    public function store(): void
    {
        try {
            $nombre = $_POST['nombre'] ?? '';
            Categoria::create($nombre);
            
            header("Location: index.php?action=categorias_index");
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
            // Aquí cargarías de nuevo el formulario con el error
            require __DIR__ . '/views/categorias/create.php';
        }
    }
}
