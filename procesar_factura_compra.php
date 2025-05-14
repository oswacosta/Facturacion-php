<?php
$conn = new mysqli("localhost", "root", "", "informatic");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$proveedor_id = $_POST['proveedor_id'];
$numero_factura = $_POST['numero_factura'];
$fecha = $_POST['fecha'];
$observaciones = $_POST['observaciones'];

$producto_ids = $_POST['producto_id'];
$cantidades = $_POST['cantidad'];
$precios = $_POST['precio_unitario'];

$total_factura = 0;
for ($i = 0; $i < count($producto_ids); $i++) {
    $total_factura += $cantidades[$i] * $precios[$i];
}

// Insertar en facturas_compras
$stmt = $conn->prepare("INSERT INTO facturas_compras (proveedor_id, numero_factura, fecha, observaciones, total) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    die("Error al preparar la factura: " . $conn->error);
}
$stmt->bind_param("isssd", $proveedor_id, $numero_factura, $fecha, $observaciones, $total_factura);
$stmt->execute();
$factura_id = $stmt->insert_id;
$stmt->close();

// Insertar líneas
$stmt_linea = $conn->prepare("INSERT INTO lineas_factura_compra (factura_id, producto_id, cantidad, precio_unitario, total_linea) VALUES (?, ?, ?, ?, ?)");
if (!$stmt_linea) {
    die("Error al preparar la línea de factura: " . $conn->error);
}

for ($i = 0; $i < count($producto_ids); $i++) {
    $total_linea = $cantidades[$i] * $precios[$i];
    $stmt_linea->bind_param("iiidd", $factura_id, $producto_ids[$i], $cantidades[$i], $precios[$i], $total_linea);
    $stmt_linea->execute();

    // Actualizar stock
    $conn->query("UPDATE productos SET cantidad = cantidad + {$cantidades[$i]} WHERE id = {$producto_ids[$i]}");
}
$stmt_linea->close();

// ✅ Redirigir al listado
header("Location: listar_facturas_compra.php");
exit();
