<?php if (isset($ticket)): ?>
    <div class="card p-3">
        <h2>Asunto: <?= htmlspecialchars($ticket['asunto']) ?></h2>
        <hr>
        <p><strong>Descripción:</strong> <?= htmlspecialchars($ticket['descripcion']) ?></p>
        <p><strong>Usuario:</strong> <?= htmlspecialchars($ticket['usuario']) ?></p>
        <p><strong>Prioridad:</strong> <?= htmlspecialchars($ticket['prioridad']) ?></p>

        <div>
            <label for="cambio-estado">Gestión de Estado:</label>
            <select id="cambio-estado" class="form-select select-trello"
                onchange="cambiarEstado(<?= $ticket['id'] ?>, this.value)">
                <?php
                $estados = ['Abierta', 'En curso', 'Resuelta'];
                foreach ($estados as $est):
                ?>
                    <option value="<?= $est ?>" <?= ($ticket['estado'] == $est) ? 'selected' : '' ?>>
                        <?= $est ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    </div>
<?php else: ?>
    <p>No se encontró el ticket.</p>
<?php endif; ?>