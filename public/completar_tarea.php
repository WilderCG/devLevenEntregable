<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/datos.php';
require_once __DIR__ . '/../src/auth.php';
require_once __DIR__ . '/../src/gamificacion.php';
require_once __DIR__ . '/../src/utilidades.php';

verificarAcceso([ROL_JUNIOR, ROL_SENIOR]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Usamos filter_input para capturar de forma segura el entero recibido
    $idTarea = filter_input(INPUT_POST, 'tarea_id', FILTER_VALIDATE_INT);

    if ($idTarea !== false && $idTarea !== null) {
        // Buscamos la tarea en el catálogo
        foreach ($tareasIniciales as $t) {
            if ($t['id'] === $idTarea) {
                // Sumamos la experiencia y comprobamos el nivel/ascenso
                sumarPuntosYTarea($t['puntos']);
                break;
            }
        }
    }
}


header('Location: dashboard.php');
exit();
