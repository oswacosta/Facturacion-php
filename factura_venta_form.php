<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Factura de Venta</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <!-- Formulario de creación de factura de venta -->
    <h1>Crear Factura de Venta</h1>
    <form method="POST" action="factura_venta.php">
        <label for="cliente_id">Cliente:</label>
        <select name="cliente_id" required>
            <?php while ($cliente = $clientes_resultado->fetch_assoc()) { ?>
                <option value="<?= $cliente['id'] ?>"><?= htmlspecialchars($cliente['nombre']) ?> <?= htmlspecialchars($cliente['apellidos']) ?></option>
            <?php } ?>
        </select>

        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" required>

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
                <?php while ($producto = $productos_resultado->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($producto['nombre']) ?></td>
                        <td>
                            <input type="number" name="productos[<?= $producto['id'] ?>]" min="1" max="<?= $producto['cantidad'] ?>" value="1">
                        </td>
                        <td><?= number_format($producto['pvp'], 2) ?> €</td>
                        <td>
                            <span class="total_producto"><?= number_format($producto['pvp'], 2) ?> €</span>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h3>Total: <span id="total_factura">0.00 €</span></h3>

        <button type="submit" name="crear_factura">Crear Factura</button>
    </form>

    <script>
        // Función para calcular el total de la factura
        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('input', function () {
                let totalFactura = 0;
                document.querySelectorAll('tbody tr').forEach(row => {
                    const cantidad = row.querySelector('input').value;
                    const precioUnitario = parseFloat(row.querySelector('td:nth-child(3)').textContent.replace(' €', ''));
                    const totalProducto = cantidad * precioUnitario;
                    row.querySelector('.total_producto').textContent = totalProducto.toFixed(2) + ' €';
                    totalFactura += totalProducto;
                });
                document.getElementById('total_factura').textContent = totalFactura.toFixed(2) + ' €';
            });
        });
    </script>

</body>
</html>
