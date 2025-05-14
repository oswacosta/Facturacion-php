<?php
include("includes/db.php");

$modo_edicion = false;
$cliente_editar = null;

// Añadir nuevo cliente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['añadir'])) {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    $stmt = $conn->prepare("INSERT INTO clientes (nombre, apellidos, telefono, direccion) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $apellidos, $telefono, $direccion);
    $stmt->execute();
    $stmt->close();

    header("Location: clientes.php");
    exit();
}

// Eliminar cliente
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $conn->query("DELETE FROM clientes WHERE id = $id");
    header("Location: clientes.php");
    exit();
}

// Cargar cliente para edición
if (isset($_GET['editar'])) {
    $id_editar = intval($_GET['editar']);
    $result = $conn->query("SELECT * FROM clientes WHERE id = $id_editar");
    if ($result && $result->num_rows > 0) {
        $cliente_editar = $result->fetch_assoc();
        $modo_edicion = true;
    }
}

// Guardar cambios en cliente editado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardar'])) {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    $stmt = $conn->prepare("UPDATE clientes SET nombre = ?, apellidos = ?, telefono = ?, direccion = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $nombre, $apellidos, $telefono, $direccion, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: clientes.php");
    exit();
}

// Obtener todos los clientes
$resultado = $conn->query("SELECT * FROM clientes ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clientes - Empresa Informática</title>
    <link rel="stylesheet" href="clientes.css">
</head>
<body class="clientes-body">
    <!-- Menú lateral -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="images/logo.jpg" alt="Logo Empresa">
        </div>
        <nav>
            <ul>
                <li><a href="main.php">Inicio</a></li>
                <li class="active"><a href="clientes.php">Clientes</a></li>
                <li><a href="proveedores.php">Proveedores</a></li>
                <li><a href="productos.php">Productos</a></li>
                <li><a href="empleados.php">Empleados</a></li>
                 <li><a href="factura_venta.php">Facturas de Venta</a></li>
        <li><a href="factura_compra.php">Facturas de Compra</a></li>
        <li><a href="listar_facturas_venta.php">Listado de Facturas de Venta</a></li>
          <li><a href="listar_facturas_compra.php">Listado de Facturas de Compra</a></li>
            </ul>
        </nav>
        <button class="logout">Salir</button>
    </aside>

    <!-- Contenido principal -->
    <main class="content">
        <header class="top-bar">
            <form method="POST" style="display: flex; gap: 10px; align-items: center;">
                <?php if ($modo_edicion): ?>
                    <input type="hidden" name="id" value="<?= $cliente_editar['id'] ?>">
                <?php endif; ?>
                <input type="text" name="nombre" placeholder="Nombre" required value="<?= $modo_edicion ? htmlspecialchars($cliente_editar['nombre']) : '' ?>">
                <input type="text" name="apellidos" placeholder="Apellidos" value="<?= $modo_edicion ? htmlspecialchars($cliente_editar['apellidos']) : '' ?>">
                <input type="text" name="telefono" placeholder="Teléfono" value="<?= $modo_edicion ? htmlspecialchars($cliente_editar['telefono']) : '' ?>">
                <input type="text" name="direccion" placeholder="Dirección" value="<?= $modo_edicion ? htmlspecialchars($cliente_editar['direccion']) : '' ?>">
                <button type="submit" name="<?= $modo_edicion ? 'guardar' : 'añadir' ?>" class="btn primary">
                    <?= $modo_edicion ? '💾 Guardar Cambios' : '➕ Añadir Cliente' ?>
                </button>
                <?php if ($modo_edicion): ?>
                    <a href="clientes.php" class="btn" style="background: gray;">❌ Cancelar</a>
                <?php endif; ?>
            </form>
            <div class="user-info">
                <img src="images/usuario.jpg" alt="Usuario" class="user-img">
                <span class="username">Ainhoa Roco</span>
            </div>
        </header>

        <!-- Tabla de clientes -->
        <section class="client-table">
        <input type="text" class="search-input" placeholder="Buscar..." 
       style="margin-bottom: 10px; padding: 6px; width: 100%; max-width: 400px;">

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $resultado->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['nombre']) ?></td>
                        <td><?= htmlspecialchars($row['apellidos']) ?></td>
                        <td><?= htmlspecialchars($row['telefono']) ?></td>
                        <td><?= htmlspecialchars($row['direccion']) ?></td>
                        <td>
                            <a href="?editar=<?= $row['id'] ?>" class="edit-btn">✏️ Editar</a>
                            <a href="?eliminar=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar este cliente?')" class="delete-btn">❌ Eliminar</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
<script src="./script.js"></script>