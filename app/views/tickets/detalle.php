<?php if (isset($ticket) && $ticket): ?>
    <div class="card p-3">
        <h2>Asunto: <?= htmlspecialchars($ticket['asunto']) ?></h2>
        <hr>
        <p><strong>Descripción:</strong> <?= htmlspecialchars($ticket['descripcion']) ?></p>
        <p><strong>Usuario:</strong> <?= htmlspecialchars($ticket['usuario']) ?></p>
        <p><strong>Prioridad:</strong> <?= htmlspecialchars($ticket['prioridad']) ?></p>

        <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
            <label for="cambio-estado" style="display: block; margin-bottom: 10px; font-weight: bold;">
                Gestión de Estado:
            </label>
            
            <select id="cambio-estado" class="select-trello" 
                    style="width: 100%; display: block;" 
                    onchange="cambiarEstado(<?= (int)$ticket['id'] ?>, this.value)">
                <?php
                $estados = ['Abierta', 'En curso', 'Resuelta'];
                foreach ($estados as $est):
                    $selected = ($ticket['estado'] == $est) ? 'selected' : '';
                ?>
                    <option value="<?= $est ?>" <?= $selected ?>>
                        <?= $est ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
<?php else: ?>
    <p style="padding: 20px; text-align: center; color: red;">
        ⚠️ Error: No se pudo cargar la información del ticket.
    </p>
<?php endif; ?>
