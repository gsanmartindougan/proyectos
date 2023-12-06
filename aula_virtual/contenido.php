<?php
require_once "cabecera.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['nombre'], $_SESSION['apellido'], $_SESSION['rol'], $_SESSION['id'])) {
    header('Location: login.php');
    exit();
}
$id = $_SESSION['id'];
$nombreUsuario = $_SESSION['nombre'];
$apellidoUsuario = $_SESSION['apellido'];
$fecha = $_SESSION['fecha'];
$tipoMensaje = isset($_GET['tipo']) ? $_GET['tipo'] : '';
$titulo = ($tipoMensaje == 'enviados') ? 'Mensajes Enviados' : 'Mensajes Recibidos';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Mensaje - Nombre de la Plataforma</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body>
<?php
require_once "cabecera.php";
?>
<main class="container mt-4">
    <h1><?= $titulo ?></h1>
    <?php
    $mensaje = fopen('mensajes_aula_virtual.csv', 'r');
    $contenido = '';
    while ($text = fgetcsv($mensaje)) {
        //Mensajes enviados
        if (($tipoMensaje == 'enviados' && $text[0] == $id)&&($fecha == $text[4])) {
            $asunto = explode(' ', trim($text[3]));
            $contenido = $text[3];

            echo "<h3>Asunto: $asunto[0] $asunto[1]</h3>";
            echo "<p> Para: $text[1]</p>";
            echo "<p>Fecha: $text[4]</p>";
            echo "<hr>";
            echo "<p>$contenido</p>";
            echo "<hr>";
        }
        //Mensajes recibidos
        if(($tipoMensaje == 'recibidos' && $text[1] == $id)&&($fecha == $text[4])){
            $asunto = explode(' ', trim($text[3]));
            $contenido = $text[3];

            echo "<h3>Asunto: $asunto[0] $asunto[1]</h3>";
            echo "<p> De: $text[1]</p>";
            echo "<p>Fecha: $text[4]</p>";
            echo "<hr>";
            echo "<p>$contenido</p>";
            echo "<hr>";
        }
    }
    fclose($mensaje);
    ?>
</main>
</body>
</html>