<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/datos.php';
require_once __DIR__ . '/../src/auth.php';
require_once __DIR__ . '/../src/utilidades.php';

iniciarSesionSegura();

// Si ya está logueado, lo mandamos directo al panel
if (isset($_SESSION['usuario'])) {
    header('Location: dashboard.php');
    exit();
}

$error = '';
$usuarioPrecargado = $_COOKIE['devlevel_remember_user'] ?? '';

// Procesamos el envío del formulario mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username'] ?? '');
    $pass = $_POST['password'] ?? '';
    $recordar = isset($_POST['remember']);

    if ($user === '' || $pass === '') {
        $error = 'Por favor, rellena todos los campos.';
    } else {
        if (autenticarUsuario($user, $pass, $recordar, $usuarios)) {
            // Aplicamos patrón PRG: tras autenticar bien, redirigimos con GET
            header('Location: dashboard.php');
            exit();
        } else {
            $error = 'Usuario o contraseña incorrectos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>DevLevel - Login</title>
</head>
<body>
    <h1>Iniciar Sesión en DevLevel</h1>

    <?php if ($error !== ''): ?>
        <p style="color: red;"><?= e($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <div>
            <label for="username">Usuario:</label><br>
            <input type="text" id="username" name="username" value="<?= e($usuarioPrecargado) ?>">
        </div>
        <br>
        <div>
            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password">
        </div>
        <br>
        <div>
            <label>
                <input type="checkbox" name="remember" <?= $usuarioPrecargado !== '' ? 'checked' : '' ?>> Recordar mi usuario
            </label>
        </div>
        <br>
        <button type="submit">Entrar</button>
    </form>

    <hr>
    <p><strong>Cuentas de prueba:</strong></p>
    <ul>
        <li>Junior: <code>junior</code> / <code>Junior2026!</code></li>
        <li>Senior: <code>senior</code> / <code>Senior2026!</code></li>
        <li>Manager: <code>manager</code> / <code>Manager2026!</code></li>
    </ul>
</body>
</html>
