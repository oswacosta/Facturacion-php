<?php
$conn = new mysqli("localhost", "root", "", "informatic");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Factura de Compra</title>
  <link rel="stylesheet" href="factura_compra.css">
</head>
<body class="factura-compra-body">

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
            <li><a href="factura_venta.php">Facturas de Venta</a></li>
            <li class="active"><a href="factura_compra.php">Facturas de Compra</a></li>
            <li><a href="listar_facturas_venta.php">Listado de Facturas de Venta</a></li>
          <li><a href="listar_facturas_compra.php">Listado de Facturas de Compra</a></li>
        </ul>
    </nav>
    <button class="logout" onclick="window.location.href='logout.php'">Salir</button>
</aside>

<!-- Contenido principal -->
<div class="content">
  <div class="top-bar">
    <h2>Registrar Factura de Compra</h2>
  </div>

  <!-- Formulario de Factura de Compra -->
  <form action="procesar_factura_compra.php" method="POST">
    <label>Proveedor:</label>
    <select name="proveedor_id" required>
      <?php
      // Obtener proveedores de la base de datos
      $result = $conn->query("SELECT id, nombre FROM proveedores");
      while ($row = $result->fetch_assoc()) {
          echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
      }
      ?>
    </select><br><br>

    <label>Número de Factura:</label>
    <input type="text" name="numero_factura" required><br><br>

    <label>Fecha:</label>
    <input type="date" name="fecha" required><br><br>

    <table id="productos">
      <tr>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio Unitario</th>
        <th></th>
      </tr>
      <tr>
        <td>
          <select name="producto_id[]">
            <?php
            ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
            // Obtener productos de la base de datos
            $result = $conn->query("SELECT id, nombre FROM productos");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
            }
            ?>
          </select>
        </td>
        <td><input type="number" name="cantidad[]" min="1" required></td>
        <td><input type="number" name="precio_unitario[]" step="0.01" required></td>
        <td><button type="button" onclick="eliminarFila(this)">Eliminar</button></td>
      </tr>
    </table><br>

    <button type="button" onclick="agregarFila()">Agregar producto</button><br><br>
    <label>Observaciones:</label><br>
    <textarea name="observaciones" rows="3" cols="50"></textarea><br><br>
    
    <input type="submit" value="Guardar Factura">
  </form>

</div> <!-- Fin del contenido -->

<script>
  function agregarFila() {
    const table = document.getElementById('productos');
    const newRow = table.rows[1].cloneNode(true);
    newRow.querySelectorAll('input').forEach(input => input.value = '');
    table.appendChild(newRow);
  }

  function eliminarFila(btn) {
    const row = btn.parentNode.parentNode;
    if (row.parentNode.rows.length > 2) {
      row.remove();
    }
  }
</script>

</body>
</html>


