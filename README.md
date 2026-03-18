1) Panel de incidencias (Helpdesk) con “lista + detalle” sin recargar

Contexto empresarial: mesa de ayuda interna: empleados reportan incidencias y el técnico las gestiona.

Objetivo del ejercicio: crear un panel que liste incidencias y permita ver el detalle y cambiar el estado sin recargar la página.

Debe incluir…

jQuery + AJAX para:

    • Cargar la lista de incidencias al entrar.
    • Mostrar el detalle de una incidencia al hacer clic (panel lateral o modal).
    • Cambiar el estado (abierta/en curso/resuelta) y refrescar la fila afectada.

PHP + JSON (sí):

    • GET /api/incidencias_listar.php → devuelve JSON con incidencias.
    • GET /api/incidencia_detalle.php?id=... → devuelve JSON con detalle.
    • POST /api/incidencia_estado.php → recibe id y estado, devuelve JSON ok/error.
