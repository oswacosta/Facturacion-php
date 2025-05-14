<?php
// detalle_factura_compra.php
$conn = new mysqli("localhost", "root", "", "informatic");

$factura_id = $_GET['id'] ?? 0;

// Obtener datos de la factura
$stmt = $conn->prepare("
  SELECT f.numero_factura, f.fecha, f.observaciones, f.total, p.nombre AS proveedor
  FROM facturas_compras f
  JOIN proveedores p ON f.proveedor_id = p.id
  WHERE f.id = ?
");
$stmt->bind_param("i", $factura_id);
$stmt->execute();
$result = $stmt->get_result();
$factura = $result->fetch_assoc();

if (!$factura) {
    echo "Factura no encontrada.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Detalle de Factura de Compra</title>
  <style>
    table, th, td { border: 1px solid black; border-collapse: collapse; padding: 5px; }
  </style>
   <link rel="stylesheet" href="detalle_factura_compra.css">
</head>
<body>
  <h2>Detalle de Factura de Compra #<?= htmlspecialchars($factura_id) ?></h2>


  <p><strong>Proveedor:</strong> <?= htmlspecialchars($factura['proveedor']) ?></p>
  <p><strong>Número de Factura:</strong> <?= htmlspecialchars($factura['numero_factura']) ?></p>
  <p><strong>Fecha:</strong> <?= htmlspecialchars($factura['fecha']) ?></p>
  <p><strong>Total:</strong> <?= number_format($factura['total'], 2) ?> €</p>
  <p><strong>Observaciones:</strong><br><?= nl2br(htmlspecialchars($factura['observaciones'])) ?></p>

  <h3>Productos incluidos:</h3>
  <table>
    <tr>
      <th>Producto</th>
      <th>Cantidad</th>
      <th>Precio Unitario</th>
      <th>Total Línea</th>
    </tr>
    <?php
    $query = "
      SELECT p.nombre, l.cantidad, l.precio_unitario, l.total_linea
      FROM lineas_factura_compra l
      JOIN productos p ON l.producto_id = p.id
      WHERE l.factura_id = $factura_id
    ";
    $resultado = $conn->query($query);
    while ($linea = $resultado->fetch_assoc()):
    ?>
    <tr>
      <td><?= htmlspecialchars($linea['nombre']) ?></td>
      <td><?= htmlspecialchars($linea['cantidad']) ?></td>
      <td><?= number_format($linea['precio_unitario'], 2) ?> €</td>
      <td><?= number_format($linea['total_linea'], 2) ?> €</td>
    </tr>
    <?php endwhile; ?>
  </table>

  <br>

  
  <a href="listar_facturas_compra.php">Volver al listado de facturas</a>
</body>
</html>
