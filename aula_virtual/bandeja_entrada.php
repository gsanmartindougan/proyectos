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
    <title>Mensajes - <?= $nombreUsuario?></title>
    <link rel="stylesheet" href="./css/bootstrap.css">
</head>
<body>

<main class="container mt-4">
    <h2>Bandeja de entrada</h2>
    <table class="table">
        <thead>
            <tr>
                <th>De</th>
                <th>Asunto</th>
                <th>Fecha</th>
                <th>Leído</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $bandeja_entrada = fopen('mensajes_aula_virtual.csv', 'r');
            $class = '';
            while($mensaje=fgetcsv($bandeja_entrada)){
                if($id==$mensaje[1]){
                    //recibidos
                    $_SESSION['fecha'] = $mensaje[4];
                    $leidoBool = filter_var($mensaje[2], FILTER_VALIDATE_BOOLEAN);
                    $leido = $leidoBool ? 'Sí' : 'No';
                    $asunto = explode(' ',trim($mensaje[3]));
                    //Para generar el asunto he utilizado las dos primeras palabras del mensaje.
                    ?>
                <tr>
                    <td><?=$mensaje[0]?></td>
                    <td><a href="contenido.php?tipo=recibidos"><?=$asunto[0]?> <?=$asunto[1]?></a></td>
                    <td><?=$mensaje[4]?></td>
                    <td><span class="<?=!$leidoBool?"badge bg-danger":"badge bg-success"; ?>"><?=$leido?></span></td>
                </tr>
                <?php
                }
            }
            fclose($bandeja_entrada);
            ?>
        </tbody>
    </table>
</main>
</body>
</html>