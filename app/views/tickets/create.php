<!doctype html>
<html lang="es-ES">

<head>
  <meta charset="utf-8">
  <title>Nueva Incidencia | Helpdesk</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body class="body-formulario">

  <div class="contenedor-formulario">
    <div class="tarjeta-form shadow">
      <h1>🎫 Abrir Nueva Incidencia</h1>

      <?php if (isset($error) && $error !== ''): ?>
        <div class="alerta-error">
          ⚠️ <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>

      <form method="post" action="index.php?action=store">
        
        <div class="campo">
          <label>Asunto / Título corto</label>
          <input type="text" name="asunto"
            value="<?php echo isset($_POST['asunto']) ? htmlspecialchars($_POST['asunto']) : ''; ?>"
            placeholder="Ej: El monitor no enciende" required>
        </div>

        <div style="display: flex; gap: 15px;">
            <div class="campo" style="flex: 1;">
              <label>Categoría</label>
              <select name="categoria_id" class="select-trello">
                <option value="">Seleccionar...</option>
                <?php foreach ($categorias as $cat): ?>
                  <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nombre']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="campo" style="flex: 1;">
              <label>Prioridad</label>
              <select name="prioridad" class="select-trello">
                <option value="Baja">Baja</option>
                <option value="Media" selected>Media</option>
                <option value="Alta">Alta</option>
                <option value="Urgente">Urgente</option>
              </select>
            </div>
        </div>

        <div class="campo">
          <label>Usuario / Solicitante (Email o nombre)</label>
          <input type="text" name="usuario"
            value="<?php echo isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : ''; ?>"
            placeholder="Ej: juan@empresa.com">
        </div>

        <div class="campo">
          <label>Descripción detallada del problema</label>
          <textarea name="descripcion"
            placeholder="Explica qué sucede con el mayor detalle posible..."><?php echo isset($_POST['descripcion']) ? htmlspecialchars($_POST['descripcion']) : ''; ?></textarea>
        </div>

        <div class="acciones-form">
          <button type="submit" class="btn-guardar">Registrar Incidencia</button>
          <a href="index.php?action=index" class="btn-cancelar">Cancelar</a>
        </div>
      </form>
    </div>
  </div>

</body>

</html>
