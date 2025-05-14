<?php
$conn = new mysqli("localhost", "root", "", "informatic");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener productos
$productos_resultado = $conn->query("SELECT * FROM productos");
$productos = [];
while ($row = $productos_resultado->fetch_assoc()) {
    $productos[] = $row;
}

// Obtener clientes
$clientes_resultado = $conn->query("SELECT * FROM clientes");
$clientes = [];
while ($row = $clientes_resultado->fetch_assoc()) {
    $clientes[] = $row;
}

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['crear_factura'])) {
    $cliente_id = (int)$_POST['cliente_id'];
    $fecha = $_POST['fecha'];
    $total = (float)$_POST['total'];

    $stmt = $conn->prepare("INSERT INTO ventas (cliente, fecha, total) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Error al preparar la consulta de la factura: " . $conn->error);
    }
    $stmt->bind_param("isd", $cliente_id, $fecha, $total);
    $stmt->execute();
    $factura_id = $stmt->insert_id;
    $stmt->close();

    foreach ($_POST['productos'] as $producto_id => $cantidad) {
        if ($cantidad < 1) continue;

        $producto_id = (int)$producto_id;
        $cantidad = (int)$cantidad;

        $producto_result = $conn->query("SELECT * FROM productos WHERE id = $producto_id");
        $producto = $producto_result->fetch_assoc();

        $precio_unitario = (float)$producto['pvp'];
        $total_linea = $cantidad * $precio_unitario;

        $stmt_linea = $conn->prepare("INSERT INTO lineas_factura_venta (factura_id, producto_id, cantidad, precio_unitario, total) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt_linea) {
            die("Error al preparar la consulta de línea de factura: " . $conn->error);
        }
        $stmt_linea->bind_param("iiidd", $factura_id, $producto_id, $cantidad, $precio_unitario, $total_linea);
        $stmt_linea->execute();
        $stmt_linea->close();

        $nuevo_stock = (int)$producto['cantidad'] - $cantidad;
        $conn->query("UPDATE productos SET cantidad = $nuevo_stock WHERE id = $producto_id");
    }

    header("Location: listar_facturas_venta.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Factura de Venta</title>
    <link rel="stylesheet" href="factura_venta.css">
</head>
<body class="factura-venta-body">

<!-- Menú lateral -->
<aside class="sidebar">
    <div class="sidebar-header">
        <img src="images/logo.jpg" alt="Logo Empresa">
    </div>
    <nav>
        <ul>
               <li><a href="main.php">Inicio</a></li>
            <li><a href="clientes.php">Clientes</a></li>
            <li><a href="proveedores.php">Proveedores</a></li>
            <li><a href="productos.php">Productos</a></li>
            <li><a href="empleados.php">Empleados</a></li>
            <li class="active"><a href="factura_venta.php">Facturas de Venta</a></li>
            <li><a href="factura_compra.php">Facturas de Compra</a></li>
            <li><a href="listar_facturas_venta.php">Listado de Facturas de Venta</a></li>
          <li><a href="listar_facturas_compra.php">Listado de Facturas de Compra</a></li>
        </ul>
    </nav>
     <button class="logout" onclick="window.location.href='logout.php'">Salir</button>
</aside>

<!-- Contenido principal -->
<div class="content">
    <div class="top-bar">
        <h2>Crear Factura de Venta</h2>
    </div>

    <form method="POST">
        <label for="cliente_id">Cliente:</label>
        <select name="cliente_id" required>
            <option value="">Seleccione un cliente</option>
            <?php foreach ($clientes as $cliente): ?>
                <option value="<?= $cliente['id'] ?>">
                    <?= htmlspecialchars($cliente['nombre']) . " " . htmlspecialchars($cliente['apellidos']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <br><br>
        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" required value="<?= date('Y-m-d') ?>">

        <h2>Productos</h2>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?= htmlspecialchars($producto['nombre']) ?></td>
                        <td>
                            <input type="number" name="productos[<?= $producto['id'] ?>]" min="0" max="<?= $producto['cantidad'] ?>" value="0">
                        </td>
                        <td class="precio"><?= number_format($producto['pvp'], 2) ?> €</td>
                        <td><span class="total_producto">0.00 €</span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <br>
        <h3>Total factura: <span id="total_factura">0.00 €</span></h3>
        <input type="hidden" name="total" id="total_input" value="0">

        <br>
        <input type="submit" name="crear_factura" value="Crear Factura">
    </form>
</div> <!-- Fin del contenido -->

<script>
    function actualizarTotal() {
        let totalFactura = 0;
        document.querySelectorAll('tbody tr').forEach(row => {
            const cantidadInput = row.querySelector('input[type="number"]');
            const precioTexto = row.querySelector('.precio').textContent.replace(' €', '');
            const precio = parseFloat(precioTexto);
            const cantidad = parseInt(cantidadInput.value) || 0;
            const totalLinea = cantidad * precio;
            row.querySelector('.total_producto').textContent = totalLinea.toFixed(2) + ' €';
            totalFactura += totalLinea;
        });
        document.getElementById('total_factura').textContent = totalFactura.toFixed(2) + ' €';
        document.getElementById('total_input').value = totalFactura.toFixed(2);
    }

    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('input', actualizarTotal);
    });

    actualizarTotal();
</script>

</body>
</html>

