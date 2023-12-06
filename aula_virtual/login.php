<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.css">
    <style>
        .oculto{
            display:none;
        }
    </style>
    <title>Página de login</title>
</head>
<body>
<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
    if((!(empty($_POST['usuario']))) && (!(empty($_POST['contraseña'])))){
        $usuario = htmlspecialchars(trim(strtolower($_POST['usuario'])));
        $contraseña = md5(htmlspecialchars(trim($_POST['contraseña'])));
        $csv = fopen('users_aula_virtual.csv', 'r');
        $encontrado ='';
        while($datos = fgetcsv($csv)){
            if(($usuario==$datos[1])&&($contraseña==$datos[2])){
                session_start();
                $_SESSION['nombre'] = $datos[3];
                $_SESSION['apellido'] = $datos[4];
                $_SESSION['rol'] = $datos[5];
                $_SESSION['id'] = $datos[0];
                $_SESSION["check"] = true ;
                break;
            }
        }
        fclose($csv);
        if(!isset($_SESSION["check"])){
            $class_form = 'was-validated'?>
                <p style="color:red">Algo ha ido mal con el usuario y contraseña proporcionados.</p>
        <?php
        }else{
            $class_form = 'oculto';
            require_once "cabecera.php";
        }
    }else{
        $usuario = htmlspecialchars(trim(strtolower($_POST['usuario'])));
    }
}else{
    $class_form = 'was-validated';
}
?>
<div class="container mt-5">
<div class="row justify-content-center">
<div class="col-md-6">
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" class="<?=$class_form?>">
        <div class="mb-3">
            <label for="usuario" class="form-label">Usuario:</label>
            <input type="text" id="usuario" name="usuario" value="<?= isset($usuario) ? "$usuario" : "" ?>" class="form-control" placeholder="Introduzca aquí su usuario" required>
            <div class="invalid-feedback">
                Por favor, introduzca un usuario.
            </div>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty(trim($_POST['usuario'], ' '))) { ?>
                <p style="color:red">Introduzca un usuario</p>
            <?php
                $errores[] = "Campo de usuario vacío";
            }
            ?>
        </div>

        <div class="mb-3">
            <label for="contraseña" class="form-label">Contraseña:</label>
            <input type="password" name="contraseña" id="contraseña" class="form-control" required>
            <div class="invalid-feedback">
                Por favor, introduzca una contraseña.
            </div>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty(trim($_POST['contraseña'], ' '))) { ?>
                <p style="color:red">Introduzca una contraseña</p>
            <?php
                $errores[] = "Campo de contraseña vacío";
            }
            ?>
        </div>

        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
</div>
</div>
</body>
</html>