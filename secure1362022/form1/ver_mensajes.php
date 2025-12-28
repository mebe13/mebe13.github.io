<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 🔒 Contraseña del panel
$clave = "mebe666"; // Puedes cambiarla

// 🛑 Comprobar acceso
if (!isset($_SESSION['acceso'])) {

    // Validar formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pass'])) {
        if ($_POST['pass'] === $clave) {
            $_SESSION['acceso'] = true;
            header("Location: ver_mensajes.php");
            exit;
        } else {
            echo '<p style="color:red;text-align:center;">❌ Contraseña incorrecta</p>';
        }
    }

    // Formulario de acceso
    echo '
    <form method="POST" style="text-align:center;margin-top:50px;font-family:sans-serif;">
        <input name="pass" placeholder="Contraseña de acceso" type="password" 
               style="padding:10px;border-radius:5px;border:1px solid #ccc;">
        <button type="submit" 
                style="padding:10px 20px;background:#0095ff;color:#fff;border:none;border-radius:5px;cursor:pointer;">
            Entrar
        </button>
    </form>';
    exit;
}

// 🔧 Conexión a la base de datos — IGUAL QUE EN EL FORMULARIO
$servername = "127.0.0.1";
$username   = "u558033723_mebe";
$password   = "BeMe2025!";   // ← CONTRASEÑA CORRECTA
$dbname     = "u558033723_formulario";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname, 3306);
if ($conn->connect_error) {
    die("<h3 style='color:red;font-family:sans-serif;'>❌ Error de conexión: " . $conn->connect_error . "</h3>");
}

$conn->set_charset("utf8mb4");

// 📩 Obtener mensajes
$query = "SELECT * FROM mensajes ORDER BY fecha DESC";
$result = $conn->query($query);

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8"/>
<title>Mensajes recibidos</title>
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
<meta name="description" content="Mensajes recibidos desde el formulario de contacto BeMe13."/>

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: #f5f5f5;
  padding: 20px;
}
h2 {
  color: #0095ff;
}
table {
  border-collapse: collapse;
  width: 100%;
  background: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 0 8px rgba(0,0,0,0.1);
}
th, td {
  border: 1px solid #ccc;
  padding: 10px;
  text-align: left;
}
th {
  background: #ff8400;
  color: white;
}
.logout {
  display:inline-block;
  margin-bottom:15px;
  background:#ff8400;
  color:#fff;
  text-decoration:none;
  padding:8px 18px;
  border-radius:5px;
}
</style>

</head>
<body>

<a class="logout" href="?salir=1">Cerrar sesión</a>
<h2>📩 Mensajes recibidos</h2>

<table>
<tr>
  <th>ID</th>
  <th>Nombre</th>
  <th>Email</th>
  <th>Mensaje</th>
  <th>Fecha</th>
</tr>

<?php
if ($result && $result->num_rows > 0):
    while($row = $result->fetch_assoc()):
?>
<tr>
  <td><?= $row['id'] ?></td>
  <td><?= htmlspecialchars($row['nombre']) ?></td>
  <td><?= htmlspecialchars($row['email']) ?></td>
  <td><?= nl2br(htmlspecialchars($row['mensaje'])) ?></td>
  <td><?= $row['fecha'] ?></td>
</tr>
<?php
    endwhile;
else:
?>
<tr>
  <td colspan="5" style="text-align:center;color:#777;">Sin mensajes por el momento…</td>
</tr>
<?php endif; ?>

</table>

</body>
</html>

<?php
// 🚪 Cerrar sesión
if (isset($_GET['salir'])) {
    session_destroy();
    header("Location: ver_mensajes.php");
    exit;
}

$conn->close();
?>
