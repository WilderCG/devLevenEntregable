<?php
declare(strict_types=1);

// Función para arrancar la sesión de forma segura y controlar la inactividad
function iniciarSesionSegura(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Comprobamos si ha pasado más del tiempo permitido sin tocar nada
    if (isset($_SESSION['ultimo_acceso'])) {
        $inactivo = time() - $_SESSION['ultimo_acceso'];
        if ($inactivo > SESSION_TIMEOUT) {
            // Si caducó, limpiamos todo y mandamos al login
            $_SESSION = [];
            session_destroy();
            header('Location: login.php?error=timeout');
            exit(); // Pongo el exit() porque si no PHP sigue ejecutando líneas por debajo
        }
    }
    // Actualizamos la hora de la última petición
    $_SESSION['ultimo_acceso'] = time();
}

// Comprueba si el usuario existe y si la contraseña coincide con el hash
function autenticarUsuario(string $usuarioIngresado, string $claveIngresada, bool $recordar, array $listaUsuarios): bool {
    foreach ($listaUsuarios as $u) {
        if ($u['username'] === $usuarioIngresado) {
            // Comprobamos la clave con password_verify (visto en la UD2)
            if (password_verify($claveIngresada, $u['password'])) {
                
                // Regeneramos el ID de la sesión por seguridad (evita Session Fixation)
                session_regenerate_id(true);

                // Guardamos los datos clave del usuario en la sesión
                $_SESSION['usuario'] = [
                    'id' => $u['id'],
                    'nombre' => $u['nombre'],
                    'username' => $u['username'],
                    'rol' => $u['rol'],
                    'puntos' => $u['puntos'],
                    'nivel' => $u['nivel']
                ];

                // Gestión de la cookie "Recordar usuario"
                if ($recordar) {
                    // La cookie dura 30 días (30 días * 24h * 60m * 60s)
                    setcookie('devlevel_remember_user', $usuarioIngresado, [
                        'expires' => time() + (30 * 24 * 60 * 60),
                        'path' => '/',
                        'httponly' => true, // Para que JavaScript no la pueda leer
                        'samesite' => 'Lax'
                    ]);
                } else {
                    // Si no marcó la casilla, borramos la cookie poniéndole fecha del pasado
                    setcookie('devlevel_remember_user', '', time() - 3600, '/');
                }

                return true;
            }
        }
    }
    return false;
}

// Función Guard sencilla para proteger páginas según el rol del usuario
function verificarAcceso(array $rolesPermitidos): void {
    iniciarSesionSegura();

    // Si no está logueado o su rol no está en la lista de permitidos, cortamos el paso
    if (!isset($_SESSION['usuario']) || !in_array($_SESSION['usuario']['rol'], $rolesPermitidos, true)) {
        http_response_code(403);
        echo "<h2>Error 403: No tienes permisos para ver esta página</h2>";
        echo "<a href='login.php'>Volver al Login</a>";
        exit();
    }
}
