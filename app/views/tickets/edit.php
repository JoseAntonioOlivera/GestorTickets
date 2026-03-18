<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Editar Incidencia | Helpdesk</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="body-formulario">

<div class="contenedor-formulario">
  <div class="tarjeta-form shadow">
    <h1>📝 Editar Incidencia #<?= (int)$ticket['id'] ?></h1>

    <?php if (isset($error) && $error !== ''): ?>
      <div class="alerta-error">
        ⚠️ <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="post" action="index.php?action=update">
      <!-- ID Oculto -->
      <input type="hidden" name="id" value="<?= (int)$ticket['id'] ?>">

      <div class="campo">
        <label>Asunto de la incidencia</label>
        <input type="text" name="asunto" value="<?= htmlspecialchars($ticket['asunto']) ?>" required>
      </div>

      <div class="campo">
        <label>Descripción detallada</label>
        <textarea name="descripcion"><?= htmlspecialchars($ticket['descripcion']) ?></textarea>
      </div>

      <div style="display: flex; gap: 15px;">
        <div class="campo" style="flex: 1;">
          <label>Prioridad</label>
          <select name="prioridad" class="select-trello">
            <?php foreach (['Baja', 'Media', 'Alta', 'Urgente'] as $p): ?>
              <option value="<?= $p ?>" <?= $ticket['prioridad'] == $p ? 'selected' : '' ?>><?= $p ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="campo" style="flex: 1;">
          <label>Estado</label>
          <select name="estado" class="select-trello">
            <?php foreach (['Abierta', 'En curso', 'Resuelta'] as $e): ?>
              <option value="<?= $e ?>" <?= $ticket['estado'] == $e ? 'selected' : '' ?>><?= $e ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="campo">
        <label>Usuario solicitante</label>
        <input type="text" name="usuario" value="<?= htmlspecialchars($ticket['usuario']) ?>">
      </div>

      <div class="acciones-form">
        <button type="submit" class="btn-guardar">Actualizar Incidencia</button>
        <a href="index.php?action=index" class="btn-cancelar">Volver al panel</a>
      </div>
    </form>
  </div>
</div>

</body>
</html>
