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

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ensajes Enviados</title>
    <!-- Enlace a Bootstrap CSS (asegúrate de tener acceso a Internet o descargar el archivo) -->
    <link rel="stylesheet" href="./css/bootstrap.css">
</head>
<body>
<?php
require_once "cabecera.php";
?>
<main class="container mt-4">
    <h2>Mensajes Enviados</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Para</th>
                <th>Asunto</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $bandeja_salida = fopen('mensajes_aula_virtual.csv', 'r');
            $class = '';
            while($mensaje=fgetcsv($bandeja_salida)){
                if($id==$mensaje[0]){
                    //enviados
                    $_SESSION['fecha'] = $mensaje[4];
                    $leidoBool = filter_var($mensaje[2], FILTER_VALIDATE_BOOLEAN);
                    $leido = $leidoBool ? 'Sí' : 'No';
                    $asunto = explode(' ',trim($mensaje[3]));
                    //Para generar el asunto he utilizado las dos primeras palabras del mensaje.
                    ?>
                <tr>
                    <td><?=$mensaje[1]?></td>
                    <!--Lo de ?tipo=enviados lo saqué de chatGPT-->
                    <td><a href="contenido.php?tipo=enviados"><?=$asunto[0]?> <?=$asunto[1]?></a></td>
                    <td><?=$mensaje[4]?></td>
                </tr>
                <?php
                }
            }
            fclose($bandeja_salida);
            ?>
        </tbody>
    </table>
</main>
</body>
</html>
