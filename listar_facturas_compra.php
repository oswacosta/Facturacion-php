<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Listado de Facturas de Compra</title>
<link rel="stylesheet" href="listar_facturas_compra.css">
</head>
<body class="factura-compra-body">
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
        <li><a href="listar_facturas_venta.php">Listado de Facturas de Venta</a></li>
          <li class="active"><a href="listar_facturas_compra.php">Listado de Facturas de Compra</a></li>
        </ul>
       <button class="logout" onclick="window.location.href='logout.php'">Salir</button>
    </aside>

  <div class="content">
    <div class="top-bar">
      <h2>Listado de Facturas de Compra</h2>
    </div>

    <table>
      <tr>
        <th>ID</th>
        <th>Número</th>
        <th>Proveedor</th>
        <th>Fecha</th>
        <th>Total</th>
        <th>Detalle</th>
      </tr>

      <?php
      $conn = new mysqli("localhost", "root", "", "informatic");
      $query = "
        SELECT f.id, f.numero_factura, f.fecha, f.total, p.nombre AS proveedor
        FROM facturas_compras f
        JOIN proveedores p ON f.proveedor_id = p.id
        ORDER BY f.fecha DESC
      ";
      $result = $conn->query($query);
      while ($row = $result->fetch_assoc()) {
          echo "<tr>
                  <td>{$row['id']}</td>
                  <td>{$row['numero_factura']}</td>
                  <td>{$row['proveedor']}</td>
                  <td>{$row['fecha']}</td>
                  <td>{$row['total']} €</td>
                  <td><a class='btn' href='detalle_factura_compra.php?id={$row['id']}'>Ver</a></td>
                </tr>";
      }
      ?>
    </table>
  </div>
</body>
</html>

