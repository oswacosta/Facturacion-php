<?php
// detalle_factura_venta.php
$conn = new mysqli("localhost", "root", "", "informatic");

if (isset($_GET['id'])) {
    $factura_id = intval($_GET['id']);

    // Obtener la información de la factura
    $query_factura = "
        SELECT v.id, v.fecha, v.total, c.nombre AS cliente, c.apellidos
        FROM ventas v
        JOIN clientes c ON v.cliente = c.id
        WHERE v.id = ?
    ";
    $stmt = $conn->prepare($query_factura);
    $stmt->bind_param("i", $factura_id);
    $stmt->execute();
    $factura = $stmt->get_result()->fetch_assoc();

    // Obtener los productos de la factura (líneas de factura)
    $query_productos = "
        SELECT p.nombre AS producto, lf.cantidad, lf.precio_unitario, lf.total
        FROM lineas_factura_venta lf
        JOIN productos p ON lf.producto_id = p.id
        WHERE lf.factura_id = ?
    ";
    $stmt_productos = $conn->prepare($query_productos);
    $stmt_productos->bind_param("i", $factura_id);
    $stmt_productos->execute();
    $productos = $stmt_productos->get_result();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Factura de Venta</title>
    <link rel="stylesheet" href="detalle_factura_compra.css">
</head>
<body>

    <h2>Detalle de Factura #<?= $factura['id'] ?></h2>
    <p><strong>Cliente:</strong> <?= $factura['cliente'] ?> <?= $factura['apellidos'] ?></p>
    <p><strong>Fecha:</strong> <?= $factura['fecha'] ?></p>
    <p><strong>Total:</strong> <?= number_format($factura['total'], 2) ?> €</p>

    <h3>Productos de la factura:</h3>

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
            <?php while ($producto = $productos->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($producto['producto']) ?></td>
                    <td><?= $producto['cantidad'] ?></td>
                    <td><?= number_format($producto['precio_unitario'], 2) ?> €</td>
                    <td><?= number_format($producto['total'], 2) ?> €</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <br>
    <a href="listar_facturas_venta.php">Volver al listado de facturas</a>

</body>
</html>
