<?php
include("includes/db.php");

$modo_edicion = false;
$empleado_editar = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['añadir'])) {
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $puesto = $_POST['puesto'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO empleados (nombre, dni, puesto, telefono, email) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nombre, $dni, $puesto, $telefono, $email);
    $stmt->execute();
    $stmt->close();

    header("Location: empleados.php");
    exit();
}

if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $conn->query("DELETE FROM empleados WHERE id = $id");
    header("Location: empleados.php");
    exit();
}

if (isset($_GET['editar'])) {
    $id_editar = intval($_GET['editar']);
    $result = $conn->query("SELECT * FROM empleados WHERE id = $id_editar");
    if ($result && $result->num_rows > 0) {
        $empleado_editar = $result->fetch_assoc();
        $modo_edicion = true;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardar'])) {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $puesto = $_POST['puesto'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE empleados SET nombre = ?, dni = ?, puesto = ?, telefono = ?, email = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $nombre, $dni, $puesto, $telefono, $email, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: empleados.php");
    exit();
}

$resultado = $conn->query("SELECT * FROM empleados ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Empleados</title>
    <link rel="stylesheet" href="empleados.css">
</head>
<body class="empleados-body">
    <aside class="sidebar">
        <img src="images/logo.jpg" alt="Logo Empresa">
        <ul>
               <li><a href="main.php">Inicio</a></li>
            <li><a href="clientes.php">Clientes</a></li>
            <li><a href="proveedores.php">Proveedores</a></li>
            <li><a href="productos.php">Productos</a></li>
            <li class="active"><a href="empleados.php">Empleados</a></li>
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
                    <input type="hidden" name="id" value="<?= $empleado_editar['id'] ?>">
                <?php endif; ?>
                <input type="text" name="nombre" placeholder="Nombre" required value="<?= $modo_edicion ? htmlspecialchars($empleado_editar['nombre']) : '' ?>">
                <input type="text" name="dni" placeholder="DNI" value="<?= $modo_edicion ? htmlspecialchars($empleado_editar['dni']) : '' ?>">
                <input type="text" name="puesto" placeholder="Puesto" value="<?= $modo_edicion ? htmlspecialchars($empleado_editar['puesto']) : '' ?>">
                <input type="text" name="telefono" placeholder="Teléfono" value="<?= $modo_edicion ? htmlspecialchars($empleado_editar['telefono']) : '' ?>">
                <input type="email" name="email" placeholder="Email" value="<?= $modo_edicion ? htmlspecialchars($empleado_editar['email']) : '' ?>">
                <button type="submit" name="<?= $modo_edicion ? 'guardar' : 'añadir' ?>" class="btn primary">
                    <?= $modo_edicion ? '💾 Guardar' : '➕ Añadir Empleado' ?>
                </button>
                <?php if ($modo_edicion): ?>
                    <a href="empleados.php" class="btn cancel">❌ Cancelar</a>
                <?php endif; ?>
            </form>
        </header>

        <section class="empleaados-table">
        <input type="text" class="search-input" placeholder="Buscar..." 
       style="margin-bottom: 10px; padding: 6px; width: 100%; max-width: 400px;">

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>DNI</th>
                        <th>Puesto</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['nombre']) ?></td>
                        <td><?= htmlspecialchars($row['dni']) ?></td>
                        <td><?= htmlspecialchars($row['puesto']) ?></td>
                        <td><?= htmlspecialchars($row['telefono']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td>
                            <a href="?editar=<?= $row['id'] ?>" class="edit-btn">✏️</a>
                            <a href="?eliminar=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar este empleado?')" class="delete-btn">❌</a>
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

