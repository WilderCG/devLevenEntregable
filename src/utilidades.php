<?php
declare(strict_types=1);

// Función corta para evitar ataques XSS al imprimir variables en el HTML
function e(string $texto): string {
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

// Redirección del patrón PRG (Post-Redirect-Get) con mensaje temporal
function redirigirConMensaje(string $paginaDestino, string $tipo, string $textoMensaje): void {
    $_SESSION['mensaje_flash'] = [
        'tipo' => $tipo,
        'texto' => $textoMensaje
    ];
    header("Location: $paginaDestino");
    exit();
}
