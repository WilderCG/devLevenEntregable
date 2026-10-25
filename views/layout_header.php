<?php
// views/layout_header.php
// Cabecera HTML común para las páginas privadas de DevLevel
$u = $_SESSION['usuario'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevLevel - Plataforma de Desarrollo</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f9f9f9; color: #333; }
        header { background-color: #2c3e50; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        header h1 { margin: 0 0 10px 0; font-size: 22px; }
        .user-info { font-size: 14px; background-color: #34495e; padding: 10px; border-radius: 4px; }
        nav { margin-top: 10px; }
        nav a { color: #41b883; text-decoration: none; font-weight: bold; margin-right: 15px; }
        nav a:hover { text-decoration: underline; }
        .container { background-color: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<header>
    <h1>DevLevel v1 - Panel de Control</h1>
    <?php if ($u): ?>
        <div class="user-info">
            <strong>Desarrollador/a:</strong> <?= e($u['nombre']) ?> |
            <strong>Rol:</strong> <?= e($u['rol']) ?> |
            <strong>Nivel:</strong> <?= e((string)$u['nivel']) ?> |
            <strong>XP Acumulada:</strong> <?= e((string)$u['puntos']) ?> XP
        </div>
        <nav>
            <a href="dashboard.php">Inicio / Tareas</a>
            <a href="logout.php" style="color: #e74c3c;">Cerrar Sesión</a>
        </nav>
    <?php endif; ?>
</header>

<div class="container">