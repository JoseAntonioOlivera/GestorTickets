<!DOCTYPE html>
<html lang="es-ES">

<head>
  <meta charset="UTF-8">
  <title>Helpdesk | Mesa de Ayuda</title>
  <link rel="stylesheet" href="css/style.css">
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
    <!-- COLUMNA IZQUIERDA: LISTADO (Ahora vacío para llenarlo con AJAX) -->
    <div class="panel-lista" id="lista-tickets">
      <h3>Incidencias Reportadas</h3>
      <div id="contenedor-items">
        <!-- Aquí se inyectarán los tickets -->
      </div>
    </div>


    <!-- COLUMNA DERECHA: DETALLE -->
    <div class="panel-detalle" id="contenedor-detalle">
      <p style="text-align:center; color:#666; margin-top:100px;">
        Selecciona una incidencia de la lista para ver los detalles.
      </p>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      actualizarListaIzquierda();
    });

    function actualizarListaIzquierda() {
      $.ajax({
        url: 'index.php?action=getTicketsJson',
        method: 'GET',
        dataType: 'json',
        success: function(respuesta) {
          if (respuesta.status === 'success') {
            let html = '';
            respuesta.data.forEach(t => {
              html += `
                        <div class="ticket-item prioridad-${t.prioridad}" onclick="verDetalle(${t.id})">
                            <small class="text-muted">${t.categoria} | #${t.id}</small>
                            <h4 style="margin: 5px 0;">${t.asunto}</h4>
                            <span class="badge-estado">${t.estado}</span>
                        </div>`;
            });
            $('#contenedor-items').html(html);
          }
        },
        error: function() {
          console.log("Error al cargar la lista de tickets");
        }
      });
    }

    function verDetalle(id) {
      $.ajax({
        url: 'index.php?action=show',
        method: 'GET',
        data: {
          id: id
        },
        dataType: 'json',
        success: function(respuesta) {
          if (respuesta.status === 'success') {
            let t = respuesta.data;
            let opciones = ['Abierta', 'En curso', 'Resuelta'].map(e =>
              `<option value="${e}" ${t.estado === e ? 'selected' : ''}>${e}</option>`
            ).join('');

            let html = `
                    <div class="card p-3">
                        <h2>Asunto: ${t.asunto}</h2>
                        <hr>
                        <p><strong>Descripción:</strong> ${t.descripcion}</p>
                        <p><strong>Usuario:</strong> ${t.usuario || 'No asignado'}</p>
                        <p><strong>Prioridad:</strong> ${t.prioridad}</p>
                        <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                            <label style="display:block; margin-bottom:10px; font-weight:bold;">Estado:</label>
                            <select class="select-trello" onchange="cambiarEstado(${t.id}, this.value)">
                                ${opciones}
                            </select>
                        </div>
                    </div>`;
            $('#contenedor-detalle').html(html);
          }
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
        success: function() {
          // Refrescamos la lista para que el badge cambie
          actualizarListaIzquierda();
        }
      });
    }
  </script>
</body>

</html>