<?php
// Componente reutilizable para mostrar alertas de sesión 
if (isset($_SESSION['mensaje_flash'])) {
    $flash = $_SESSION['mensaje_flash'];
    unset($_SESSION['mensaje_flash']); 
    
    $colorFondo = ($flash['tipo'] === 'exito') ? '#d4edda' : '#d1ecf1';
    $colorTexto = ($flash['tipo'] === 'exito') ? '#155724' : '#0c5460';
    $colorBorde = ($flash['tipo'] === 'exito') ? '#c3e6cb' : '#bee5eb';
    ?>
    <div style="background-color: <?= $colorFondo ?>; color: <?= $colorTexto ?>; border: 1px solid <?= $colorBorde ?>; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
        <strong>Información:</strong> <?= e($flash['texto']) ?>
    </div>
    <?php
}
