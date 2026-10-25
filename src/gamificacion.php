<?php
declare(strict_types=1);

// Devuelve el nivel numérico según los puntos XP acumulados (basado en la tabla del tema)
function obtenerNivelPorXP(int $xp): int {
    if ($xp >= 700) {
        return 5;
    } elseif ($xp >= 450) {
        return 4;
    } elseif ($xp >= 250) {
        return 3;
    } elseif ($xp >= 100) {
        return 2;
    } else {
        return 1;
    }
}

// Suma los puntos de la tarea completada y gestiona el ascenso si llega a los 450 XP
function sumarPuntosYTarea(int $puntosGanados): void {
    $_SESSION['usuario']['puntos'] += $puntosGanados;
    $puntosTotales = $_SESSION['usuario']['puntos'];

    // Actualizamos el nivel
    $_SESSION['usuario']['nivel'] = obtenerNivelPorXP($puntosTotales);

    // Si era Junior y ya superó los 450 XP, lo ascendemos a Senior automáticamente
    if ($_SESSION['usuario']['rol'] === ROL_JUNIOR && $puntosTotales >= UMBRAL_SENIOR_XP) {
        $_SESSION['usuario']['rol'] = ROL_SENIOR;
        
        // Mensaje de alegría para el usuario 
        $_SESSION['mensaje_flash'] = [
            'tipo' => 'exito',
            'texto' => '¡Genial! Has alcanzado los ' . $puntosTotales . ' XP y has ascendido automáticamente a DEVELOPER_SENIOR.'
        ];
    } else {
        $_SESSION['mensaje_flash'] = [
            'tipo' => 'info',
            'texto' => '¡Tarea completada! Has ganado ' . $puntosGanados . ' XP.'
        ];
    }
}