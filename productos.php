<?php
include("includes/db.php");

$modo_edicion = false;
$producto_editar = null;

// Añadir producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['añadir'])) {
    $nombre = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $iva = $_POST['iva'];
    $pvp = $_POST['pvp'];
    $almacen = $_POST['almacen'];
    $cantidad = $_POST['cantidad'];

    $stmt = $conn->prepare("INSERT INTO productos (nombre, tipo, iva, pvp, almacen, cantidad) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssddsi", $nombre, $tipo, $iva, $pvp, $almacen, $cantidad);
    $stmt->execute();
    $stmt->close();

    header("Location: productos.php");
    exit();
}

// Eliminar producto
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $conn->query("DELETE FROM productos WHERE id = $id");
    header("Location: productos.php");
    exit();
}

// Cargar para editar
if (isset($_GET['editar'])) {
    $id_editar = intval($_GET['editar']);
    $result = $conn->query("SELECT * FROM productos WHERE id = $id_editar");
    if ($result && $result->num_rows > 0) {
        $producto_editar = $result->fetch_assoc();
        $modo_edicion = true;
    }
}

// Guardar cambios
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardar'])) {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $iva = $_POST['iva'];
    $pvp = $_POST['pvp'];
    $almacen = $_POST['almacen'];
    $cantidad = $_POST['cantidad'];

    $stmt = $conn->prepare("UPDATE productos SET nombre = ?, tipo = ?, iva = ?, pvp = ?, almacen = ?, cantidad = ? WHERE id = ?");
    $stmt->bind_param("ssddsii", $nombre, $tipo, $iva, $pvp, $almacen, $cantidad, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: productos.php");
    exit();
}

$resultado = $conn->query("SELECT * FROM productos ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <link rel="stylesheet" href="productos.css">
</head>
<body class="productos-body">
    <aside class="sidebar">
        <img src="images/logo.jpg" alt="Logo Empresa">
        <ul>
               <li><a href="main.php">Inicio</a></li>
            <li><a href="clientes.php">Clientes</a></li>
            <li><a href="proveedores.php">Proveedores</a></li>
            <li class="active"><a href="productos.php">Productos</a></li>
            <li><a href="empleados.php">Empleados</a></li>
             <li><a href="factura_venta.php">Facturas de Venta</a></li>
        <li><a href="factura_compra.php">Facturas de Compra</a></li>
        <li><a href="listar_facturas_venta.php">Listado de Facturas de Venta</a></li>
          <li><a href="listar_facturas_compra.php">Listado de Facturas de Compra</a></li>
        </ul>
        <button class="logout">Salir</button>
    </aside>

    <main class="content">
        <header class="top-bar">
            <form method="POST">
                <?php if ($modo_edicion): ?>
                    <input type="hidden" name="id" value="<?= $producto_editar['id'] ?>">
                <?php endif; ?>
                <input type="text" name="nombre" placeholder="Nombre" required value="<?= $modo_edicion ? htmlspecialchars($producto_editar['nombre']) : '' ?>">
                <input type="text" name="tipo" placeholder="Tipo" value="<?= $modo_edicion ? htmlspecialchars($producto_editar['tipo']) : '' ?>">
                <input type="number" step="0.01" name="iva" placeholder="IVA (%)" value="<?= $modo_edicion ? htmlspecialchars($producto_editar['iva']) : '' ?>">
                <input type="number" step="0.01" name="pvp" placeholder="PVP (€)" value="<?= $modo_edicion ? htmlspecialchars($producto_editar['pvp']) : '' ?>">
                <input type="text" name="almacen" placeholder="Almacén" value="<?= $modo_edicion ? htmlspecialchars($producto_editar['almacen']) : '' ?>">
                <input type="number" name="cantidad" placeholder="Cantidad" value="<?= $modo_edicion ? htmlspecialchars($producto_editar['cantidad']) : '' ?>">
                <button type="submit" name="<?= $modo_edicion ? 'guardar' : 'añadir' ?>" class="btn primary">
                    <?= $modo_edicion ? '💾 Guardar' : '➕ Añadir Producto' ?>
                </button>
                <?php if ($modo_edicion): ?>
                    <a href="productos.php" class="btn cancel">❌ Cancelar</a>
                <?php endif; ?>
            </form>
        </header>

        <section class="productos-table">
        <input type="text" class="search-input" placeholder="Buscar..." 
       style="margin-bottom: 10px; padding: 6px; width: 100%; max-width: 400px;">

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>IVA</th>
                        <th>PVP</th>
                        <th>Almacén</th>
                        <th>Cantidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['nombre']) ?></td>
                        <td><?= htmlspecialchars($row['tipo']) ?></td>
                        <td><?= htmlspecialchars($row['iva']) ?>%</td>
                        <td><?= htmlspecialchars($row['pvp']) ?> €</td>
                        <td><?= htmlspecialchars($row['almacen']) ?></td>
                        <td><?= htmlspecialchars($row['cantidad']) ?></td>
                        <td>
                            <a href="?editar=<?= $row['id'] ?>" class="edit-btn">✏️</a>
                            <a href="?eliminar=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar este producto?')" class="delete-btn">❌</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
<script src="./script.js"></script>

