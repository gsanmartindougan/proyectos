<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aula Virtual</title>
    <link rel="stylesheet" href="./css/bootstrap.css">
</head>
<body>
<?php
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
$rolUsuario = $_SESSION['rol'];
$perfil = $_SESSION['rol'] == 1 ? "Profesor" : "Alumno";
$logo ='./img/logo.png';
//MENSAJES BURBUJA
$mensajes = fopen(__DIR__.'/mensajes_aula_virtual.csv', 'r');
$noLeido = 0;
//Burbuja de mensajes no leídos
while($burbuja = fgetcsv($mensajes)){
    if(($id == $burbuja[1])){
        if(!(filter_var($burbuja[2], FILTER_VALIDATE_BOOLEAN))){
            $noLeido++;
        }
    }
}
fclose($mensajes);
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <!--Logo nav-->
        <a class="navbar-brand" href="cabecera.php"><img src="<?=$logo?>" class="img-fluid" style="max-width: 100px;"></a>
        <!--Bienvenido-->
        <a class="nav-link">Bienvenido, <?=$nombreUsuario?> <?=$apellidoUsuario?></a>
        <!--Hamburguesa responsive nav-->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!--Perfil nav-->
                <li class="nav-item">
                    <a class="nav-link">Perfil: <?=$perfil?></a>
                </li>
                <!--Mensajes nav-->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Mensajes
                        <span class="badge bg-danger"><?=$noLeido?></span>
                    </a>
                    <!--Desplegable mensajes-->
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="bandeja_entrada.php">Bandeja de Entrada</a></li>
                        <li><a class="dropdown-item" href="bandeja_salida.php">Mensajes Enviados</a></li>
                    </ul>
                </li>
                <!--Cerrar sesión nav-->
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script src="./js/bootstrap.js"></script>
</body>
</html>