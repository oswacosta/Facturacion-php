<?php
session_start();
include("includes/db.php");

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed = hash('sha256', $password);

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ? AND contraseña = ?");
    $stmt->bind_param("ss", $email, $hashed);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $_SESSION['usuario'] = $email;
        header("Location: main.php");
        exit();
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Empresa Informática</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="login-body">
    <div class="login-container">
        <form method="POST">
            <h2>Iniciar Sesión</h2>
            <input type="email" name="email" placeholder="Correo Electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
            <?php if ($error): ?>
                <p style="color:red; margin-top:10px;"><?= $error ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
