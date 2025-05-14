<?php
include("includes/db.php");

$modo_edicion = false;
$proveedor_editar = null;

// Añadir nuevo proveedor
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['añadir'])) {
    $nombre = $_POST['nombre'];
    $contacto = $_POST['contacto'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    $stmt = $conn->prepare("INSERT INTO proveedores (nombre, contacto, telefono, direccion) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $contacto, $telefono, $direccion);
    $stmt->execute();
    $stmt->close();

    header("Location: proveedores.php");
    exit();
}

// Eliminar proveedor
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $conn->query("DELETE FROM proveedores WHERE id = $id");
    header("Location: proveedores.php");
    exit();
}

// Cargar proveedor para edición
if (isset($_GET['editar'])) {
    $id_editar = intval($_GET['editar']);
    $result = $conn->query("SELECT * FROM proveedores WHERE id = $id_editar");
    if ($result && $result->num_rows > 0) {
        $proveedor_editar = $result->fetch_assoc();
        $modo_edicion = true;
    }
}

// Guardar cambios en proveedor editado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardar'])) {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $contacto = $_POST['contacto'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    $stmt = $conn->prepare("UPDATE proveedores SET nombre = ?, contacto = ?, telefono = ?, direccion = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $nombre, $contacto, $telefono, $direccion, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: proveedores.php");
    exit();
}

// Obtener proveedores
$resultado = $conn->query("SELECT * FROM proveedores ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Proveedores - Empresa Informática</title>
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
                <li><a href="clientes.php">Clientes</a></li>
                <li class="active"><a href="proveedores.php">Proveedores</a></li>
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
                    <input type="hidden" name="id" value="<?= $proveedor_editar['id'] ?>">
                <?php endif; ?>
                <input type="text" name="nombre" placeholder="Nombre empresa" required value="<?= $modo_edicion ? htmlspecialchars($proveedor_editar['nombre']) : '' ?>">
                <input type="text" name="contacto" placeholder="Persona de contacto" value="<?= $modo_edicion ? htmlspecialchars($proveedor_editar['contacto']) : '' ?>">
                <input type="text" name="telefono" placeholder="Teléfono" value="<?= $modo_edicion ? htmlspecialchars($proveedor_editar['telefono']) : '' ?>">
                <input type="text" name="direccion" placeholder="Dirección" value="<?= $modo_edicion ? htmlspecialchars($proveedor_editar['direccion']) : '' ?>">
                <button type="submit" name="<?= $modo_edicion ? 'guardar' : 'añadir' ?>" class="btn primary">
                    <?= $modo_edicion ? '💾 Guardar Cambios' : '➕ Añadir Proveedor' ?>
                </button>
                <?php if ($modo_edicion): ?>
                    <a href="proveedores.php" class="btn" style="background: gray;">❌ Cancelar</a>
                <?php endif; ?>
            </form>
            <div class="user-info">
                <img src="images/usuario.jpg" alt="Usuario" class="user-img">
                <span class="username">Ainhoa Roco</span>
            </div>
        </header>

        <!-- Tabla de proveedores -->
        <section class="proveedores-table">
        <input type="text" class="search-input" placeholder="Buscar..." 
       style="margin-bottom: 10px; padding: 6px; width: 100%; max-width: 400px;">

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre empresa</th>
                        <th>Contacto</th>
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
                        <td><?= htmlspecialchars($row['contacto']) ?></td>
                        <td><?= htmlspecialchars($row['telefono']) ?></td>
                        <td><?= htmlspecialchars($row['direccion']) ?></td>
                        <td>
                            <a href="?editar=<?= $row['id'] ?>" class="edit-btn">✏️ Editar</a>
                            <a href="?eliminar=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar este proveedor?')" class="delete-btn">❌ Eliminar</a>
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

