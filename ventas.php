<?php
include("includes/db.php");

$modo_edicion = false;
$venta_editar = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['añadir'])) {
    $cliente = $_POST['cliente'];
    $producto = $_POST['producto'];
    $cantidad = $_POST['cantidad'];
    $precio_unitario = $_POST['precio_unitario'];
    $total = $cantidad * $precio_unitario;
    $fecha = $_POST['fecha'];

    $stmt = $conn->prepare("INSERT INTO ventas (cliente, producto, cantidad, precio_unitario, total, fecha) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssidds", $cliente, $producto, $cantidad, $precio_unitario, $total, $fecha);
    $stmt->execute();
    $stmt->close();

    header("Location: ventas.php");
    exit();
}

if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $conn->query("DELETE FROM ventas WHERE id = $id");
    header("Location: ventas.php");
    exit();
}

if (isset($_GET['editar'])) {
    $id_editar = intval($_GET['editar']);
    $result = $conn->query("SELECT * FROM ventas WHERE id = $id_editar");
    if ($result && $result->num_rows > 0) {
        $venta_editar = $result->fetch_assoc();
        $modo_edicion = true;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardar'])) {
    $id = intval($_POST['id']);
    $cliente = $_POST['cliente'];
    $producto = $_POST['producto'];
    $cantidad = $_POST['cantidad'];
    $precio_unitario = $_POST['precio_unitario'];
    $total = $cantidad * $precio_unitario;
    $fecha = $_POST['fecha'];

    $stmt = $conn->prepare("UPDATE ventas SET cliente = ?, producto = ?, cantidad = ?, precio_unitario = ?, total = ?, fecha = ? WHERE id = ?");
    $stmt->bind_param("ssiddsi", $cliente, $producto, $cantidad, $precio_unitario, $total, $fecha, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ventas.php");
    exit();
}

$resultado = $conn->query("SELECT * FROM ventas ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ventas</title>
    <link rel="stylesheet" href="ventas.css">
</head>
<body class="ventas-body">
    <aside class="sidebar">
        <img src="images/logo.jpg" alt="Logo Empresa">
        <ul>
               <li><a href="main.php">Inicio</a></li>
            <li><a href="clientes.php">Clientes</a></li>
            <li><a href="proveedores.php">Proveedores</a></li>
            <li><a href="compras.php">Compras</a></li>
            <li><a href="productos.php">Productos</a></li>
            <li class="active"><a href="ventas.php">Ventas</a></li>
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
                    <input type="hidden" name="id" value="<?= $venta_editar['id'] ?>">
                <?php endif; ?>
                <input type="text" name="cliente" placeholder="Cliente" required value="<?= $modo_edicion ? htmlspecialchars($venta_editar['cliente']) : '' ?>">
                <input type="text" name="producto" placeholder="Producto" required value="<?= $modo_edicion ? htmlspecialchars($venta_editar['producto']) : '' ?>">
                <input type="number" name="cantidad" placeholder="Cantidad" required value="<?= $modo_edicion ? htmlspecialchars($venta_editar['cantidad']) : '' ?>">
                <input type="number" step="0.01" name="precio_unitario" placeholder="Precio Unidad (€)" required value="<?= $modo_edicion ? htmlspecialchars($venta_editar['precio_unitario']) : '' ?>">
                <input type="date" name="fecha" required value="<?= $modo_edicion ? htmlspecialchars($venta_editar['fecha']) : '' ?>">
                <button type="submit" name="<?= $modo_edicion ? 'guardar' : 'añadir' ?>" class="btn primary">
                    <?= $modo_edicion ? '💾 Guardar' : '➕ Añadir Venta' ?>
                </button>
                <?php if ($modo_edicion): ?>
                    <a href="ventas.php" class="btn cancel">❌ Cancelar</a>
                <?php endif; ?>
            </form>
        </header>

        <section class="ventas-table">
        <input type="text" class="search-input" placeholder="Buscar..." 
       style="margin-bottom: 10px; padding: 6px; width: 100%; max-width: 400px;">

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio U.</th>
                        <th>Total</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['cliente']) ?></td>
                        <td><?= htmlspecialchars($row['producto']) ?></td>
                        <td><?= $row['cantidad'] ?></td>
                        <td><?= number_format($row['precio_unitario'], 2) ?> €</td>
                        <td><?= number_format($row['total'], 2) ?> €</td>
                        <td><?= $row['fecha'] ?></td>
                        <td>
                            <a href="?editar=<?= $row['id'] ?>" class="edit-btn">✏️</a>
                            <a href="?eliminar=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar esta venta?')" class="delete-btn">❌</a>
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


