<?php
// procesar_factura_venta.php
$conn = new mysqli("localhost", "root", "", "informatic");

$cliente_id = $_POST['cliente_id'];
$numero_factura = $_POST['numero_factura'];
$fecha = $_POST['fecha'];
$observaciones = $_POST['observaciones'];

$producto_ids = $_POST['producto_id'];
$cantidades = $_POST['cantidad'];
$precios = $_POST['precio_unitario'];

$total_factura = 0;

// 1. Calcular total de la factura
for ($i = 0; $i < count($producto_ids); $i++) {
    $total_factura += $cantidades[$i] * $precios[$i];
}

// 2. Insertar en facturas_ventas
$stmt = $conn->prepare("INSERT INTO facturas_ventas (cliente_id, numero_factura, fecha, observaciones, total) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("isssd", $cliente_id, $numero_factura, $fecha, $observaciones, $total_factura);
$stmt->execute();
$factura_id = $stmt->insert_id;

// 3. Insertar cada línea de producto
$stmt_linea = $conn->prepare("INSERT INTO lineas_factura_venta (factura_id, producto_id, cantidad, precio_unitario, total_linea) VALUES (?, ?, ?, ?, ?)");
for ($i = 0; $i < count($producto_ids); $i++) {
    $total_linea = $cantidades[$i] * $precios[$i];
    $stmt_linea->bind_param("iiidd", $factura_id, $producto_ids[$i], $cantidades[$i], $precios[$i], $total_linea);
    $stmt_linea->execute();

    // 4. Actualizar stock (restar)
    $conn->query("UPDATE productos SET cantidad = cantidad - {$cantidades[$i]} WHERE id = {$producto_ids[$i]}");
}

echo "Factura de venta registrada correctamente.";
?>
