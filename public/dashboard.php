<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/datos.php';
require_once __DIR__ . '/../src/auth.php';
require_once __DIR__ . '/../src/utilidades.php';

// Verificamos que esté logueado (cualquiera de los 3 roles puede entrar)
verificarAcceso([ROL_JUNIOR, ROL_SENIOR, ROL_MANAGER]);

$usuario = $_SESSION['usuario'];

// Capturamos el mensaje flash si existe y lo borramos de la sesión
$mensajeFlash = $_SESSION['mensaje_flash'] ?? null;
unset($_SESSION['mensaje_flash']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>DevLevel - Dashboard</title>
</head>
<body>
    <h1>Bienvenido/a, <?= e($usuario['nombre']) ?></h1>
    <p>
        <strong>Rol:</strong> <?= e($usuario['rol']) ?> | 
        <strong>Nivel:</strong> <?= e((string)$usuario['nivel']) ?> | 
        <strong>Puntos XP:</strong> <?= e((string)$usuario['puntos']) ?>
    </p>
    <p><a href="logout.php">Cerrar sesión</a></p>

    <?php if ($mensajeFlash): ?>
        <div style="background-color: #e0f7fa; padding: 10px; border: 1px solid #00838f; margin-bottom: 15px;">
            <p><?= e($mensajeFlash['texto']) ?></p>
        </div>
    <?php endif; ?>

    <h2>Catálogo de Tareas Disponibles</h2>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Puntos XP</th>
                <th>Nivel Mínimo</th>
                <th>Dificultad</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tareasIniciales as $tarea): ?>
                <?php 
                    // Un Junior solo ve tareas adaptadas a su nivel actual
                    $puedeHacerla = $usuario['nivel'] >= $tarea['nivel_minimo'];
                ?>
                <tr>
                    <td><?= e((string)$tarea['id']) ?></td>
                    <td><?= e($tarea['titulo']) ?></td>
                    <td><?= e((string)$tarea['puntos']) ?> XP</td>
                    <td>Nivel <?= e((string)$tarea['nivel_minimo']) ?></td>
                    <td><?= e($tarea['dificultad']) ?></td>
                    <td>
                        <?php if ($puedeHacerla): ?>
                            <form method="POST" action="completar_tarea.php">
                                <input type="hidden" name="tarea_id" value="<?= e((string)$tarea['id']) ?>">
                                <button type="submit">Completar Tarea</button>
                            </form>
                        <?php else: ?>
                            <span style="color: gray;">Bloqueada (requiere Nivel <?= e((string)$tarea['nivel_minimo']) ?>)</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
