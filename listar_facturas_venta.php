<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexión
$conn = new mysqli("localhost", "root", "", "informatic");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL
$query = "
    SELECT v.id, v.fecha, v.total, c.nombre, c.apellidos
    FROM ventas v
    JOIN clientes c ON v.cliente = c.id
    ORDER BY v.fecha DESC
";

$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Listado de Facturas de Venta</title>
  <link rel="stylesheet" href="listar_facturas_venta.css"> 
</head>
<body class="factura-venta-body">

<!-- Menú lateral -->
<aside class="sidebar">
        <img src="images/logo.jpg" alt="Logo Empresa">
        <ul>
          <li><a href="main.php">Inicio</a></li>
            <li><a href="clientes.php">Clientes</a></li>
            <li><a href="proveedores.php">Proveedores</a></li>
            <li><a href="productos.php">Productos</a></li>
            <li><a href="empleados.php">Empleados</a></li>
             <li><a href="factura_venta.php">Facturas de Venta</a></li>
        <li><a href="factura_compra.php">Facturas de Compra</a></li>
        <li class="active"><a href="listar_facturas_venta.php">Listado de Facturas de Venta</a></li>
          <li><a href="listar_facturas_compra.php">Listado de Facturas de Compra</a></li>
        </ul>
       <button class="logout" onclick="window.location.href='logout.php'">Salir</button>
    </aside>

<!-- Contenido principal -->
<div class="content">
  <div class="top-bar">
    <h2>Listado de Facturas de Venta</h2>
  </div>

  <table>
    <tr>
      <th>ID</th>
      <th>Cliente</th>
      <th>Fecha</th>
      <th>Total</th>
      <th>Detalle</th>
    </tr>

    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cliente = htmlspecialchars($row['nombre'] . ' ' . $row['apellidos']);
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$cliente}</td>
                    <td>{$row['fecha']}</td>
                    <td>{$row['total']} €</td>
                    <td><a href='detalle_factura_venta.php?id={$row['id']}'>Ver</a></td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No hay facturas de venta registradas.</td></tr>";
    }

    $conn->close();
    ?>
  </table>
</div>

</body>
</html>

