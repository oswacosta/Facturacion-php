<?php
session_start(); // Inicia la sesión para acceder a las variables de sesión

// Si la sesión no tiene un usuario, se mostrará 'Invitado' como nombre de usuario
// Puedes modificar esta lógica más adelante si quieres agregar autenticación en el futuro.
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Página Principal - Empresa Informática</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="main-body">
    <header>
        <div class="logo">
            <img src="images/logo.jpg" alt="Logo Empresa">
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Buscar productos...">
        </div>
        <div class="user-info">
            <img src="images/usuario.jpg" alt="Usuario" class="user-img">
            <!-- Verificamos si $_SESSION['usuario'] está definida y mostramos el nombre de usuario -->
            <span class="username"><?= isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Invitado' ?></span>
        </div>
    </header>

   <nav class="menu">
    <button onclick="location.href='productos.php'">Productos</button>
    <button onclick="location.href='proveedores.php'">Proveedores</button>
    <button onclick="location.href='clientes.php'">Clientes</button>
    <button onclick="location.href='factura_venta.php'">Facturas de Venta</button>
    <button onclick="location.href='factura_compra.php'">Facturas de Compra</button>
    <button onclick="location.href='empleados.php'">Empleados</button>
    <button onclick="location.href='logout.php'" class="logout">Salir</button>
</nav>

    <main id="content">
        <div class="background-overlay">
            <!-- Muestra un saludo dependiendo si hay un usuario en la sesión o no -->
            <h1 class="welcome-title"><?= isset($_SESSION['usuario']) ? 'Bienvenida, ' . $_SESSION['usuario'] : 'Bienvenida, Invitado' ?></h1>
            <p class="company-description">
                Esta es la plataforma interna de gestión de nuestra empresa informática.  
                Desde aquí puedes administrar productos, clientes, compras, ventas y empleados.  
            </p>
        </div>
    </main>
</body>
</html>
