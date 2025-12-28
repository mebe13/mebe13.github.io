<?php
// Mostrar errores (para ver si algo falla)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 🔥 DATOS DE CONEXIÓN CORRECTOS (OPCIÓN 1)
$servername = "srv1709.hstgr.io";
$username   = "u558033723_mebeadmin";
$password   = "Meme_law130987";  // <-- PON AQUÍ TU CONTRASEÑA REAL
$dbname     = "u558033723_formulario2";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
}

echo "✅ Conexión correcta a formulario2";

// Si el formulario envía datos, procesarlos
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre  = $_POST['nombre']  ?? '';
    $email   = $_POST['email']   ?? '';
    $mensaje = $_POST['mensaje'] ?? '';

    // Seguridad
    $nombre  = $conn->real_escape_string($nombre);
    $email   = $conn->real_escape_string($email);
    $mensaje = $conn->real_escape_string($mensaje);

    // Insertar los datos
    $sql = "INSERT INTO formulario (nombre, email, mensaje)
            VALUES ('$nombre', '$email', '$mensaje')";

    if ($conn->query($sql) === TRUE) {
        echo "<br>📩 Datos guardados correctamente.";
    } else {
        echo "<br>⚠ Error al guardar: " . $conn->error;
    }
}

$conn->close();


