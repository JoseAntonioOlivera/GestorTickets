<!DOCTYPE html>
<html lang="es-ES">

<head>
  <meta charset="UTF-8">
  <title>Helpdesk | Mesa de Ayuda</title>
  <link rel="stylesheet" href="../../Trello/css/style.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <style>
    /* Estructura de dos columnas: Lista y Detalle */
    .layout-helpdesk {
      display: flex;
      gap: 20px;
      height: 85vh;
      padding: 20px;
    }

    .panel-lista {
      flex: 1;
      overflow-y: auto;
      background: #ebedf0;
      border-radius: 8px;
      padding: 15px;
    }

    .panel-detalle {
      flex: 2;
      background: white;
      border-radius: 8px;
      border: 1px solid #ccc;
      padding: 20px;
    }

    /* Estilo de los tickets en la lista */
    .ticket-item {
      background: white;
      border-radius: 5px;
      padding: 12px;
      margin-bottom: 10px;
      cursor: pointer;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
      border-left: 5px solid #0079bf;
    }

    .ticket-item:hover {
      background: #f4f5f7;
    }

    .prioridad-Alta {
      border-left-color: #eb5a46;
    }

    .prioridad-Baja {
      border-left-color: #61bd4f;
    }
  </style>
</head>

<body>
  <header class="cabecera">
    <h1 class="titulo-tablero">Gestor de Incidencias</h1>
    <a href="index.php?action=create" class="btn-trello"><span>+</span> Nueva Incidencia</a>
  </header>

  <div class="layout-helpdesk">
    <!-- COLUMNA IZQUIERDA: LISTADO -->
    <div class="panel-lista" id="lista-tickets">
      <h3>Incidencias Reportadas</h3>
      <?php foreach ($tickets as $t): ?>
        <div class="ticket-item prioridad-<?= $t['prioridad'] ?>" onclick="verDetalle(<?= $t['id'] ?>)">
          <small class="text-muted"><?= $t['categoria'] ?> | #<?= $t['id'] ?></small>
          <h4 style="margin: 5px 0;"><?= htmlspecialchars($t['asunto']) ?></h4>
          <span class="badge-estado"><?= $t['estado'] ?></span>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- COLUMNA DERECHA: DETALLE -->
    <div class="panel-detalle" id="contenedor-detalle">
      <p style="text-align:center; color:#666; margin-top:100px;">
        Selecciona una incidencia de la lista para ver los detalles.
      </p>
    </div>
  </div>

  <script>
    function verDetalle(id) {
      $.ajax({
        url: 'index.php?action=show',
        method: 'GET',
        data: {
          id: id
        },
        success: function(html) {
          $('#contenedor-detalle').html(html);
        },
        error: function() {
          alert("Error al cargar el detalle del ticket");
        }
      });
    }

    function cambiarEstado(id, nuevoEstado) {
      $.ajax({
        url: 'index.php?action=updateEstado',
        method: 'POST',
        data: {
          id: id,
          estado: nuevoEstado
        },
        success: function(html) {
          console.log("Estado cambiado correctamente.");
          actualizarListaIzquierda();
        },
        error: function() {
          alert("Error al cargar el detalle del ticket");
        }
      });
    }

    function actualizarListaIzquierda() {
      $.ajax({
        url: 'index.php?action=index',
        method: 'GET',
        success: function(html) {
          let nuevaLista = $(html).find('#lista-tickets').html();
          $('#lista-tickets').html(nuevaLista);

          console.log("Lista de la izquierda actualizada sin recargar.");
        }
      });
    }
  </script>
</body>

</html>