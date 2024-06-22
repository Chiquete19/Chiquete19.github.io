<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEDSA - LOGIN</title>
    <link rel="icon" href="logo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">

</head>

<body>
    <?php

    $error = false;
    $conexion = null;
    session_start();
    if (!empty($_POST["iniciar"])) {
        $usuario = strtolower($_POST["username"]);
        $password = $_POST["password"];
    
        try {
            $conexion = new mysqli("localhost", "root", "", "dedsa", "3306");
            $conexion->set_charset("utf8");
            $consulta = $conexion->prepare("SELECT usuario, contraseña, permisos FROM usuarios WHERE usuario = ? AND BINARY contraseña = ?");
            $consulta->bind_param("ss", $usuario, $password);
            $consulta->execute();
    
            $consulta->bind_result($usuarioResultado, $contraseñaResultado, $permisosResultado);
    
            if ($consulta->fetch()) {
                $_SESSION['usuario'] = $usuarioResultado;
                $_SESSION['permisos'] = $permisosResultado;
                header("location:admin/lanzarAdmin");
            } else {
                $error = true;
            }
    
            $consulta->close();
    
        } catch (\Throwable $th) {
            $error = true;
        }
    }
    

    ?>

    <div class="login-container">
        <img src="logo.png" alt="Dedsa">
        <form action="login" method="POST">
            <label for="username">NOMBRE DE USUARIO</label>
            <input type="text" id="username" name="username" placeholder="USUARIO" required>

            <label for="password">CONTRASEÑA</label>
            <input type="password" id="password" name="password" placeholder="CONTRASEÑA" required>

            <button class="button" name="iniciar" id="loginBtn" type="submit" value="INICIAR SESIÓN">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                    style="display:none;"></span>
                <span id="loginText">INICIO SESIÓN</span>
            </button>

            <?php
            if ($error) {
                echo '<div class="alert alert-danger">CONTRASEÑA Y/O USUARIO INVÁLIDOS</div>';
            }
            ?>

            <div class="forgot-password">
                <a href="#">¿OLVIDASTE TU CONTRASEÑA?</a>
            </div>
        </form>

        <div class="footer">
            <p>© 2023 Dedicados Operadora de Servicios SA de CV. <br> Todos los derechos reservados.</p>
        </div>
    </div>
    <script>
        document.getElementById("loginBtn").addEventListener("click", function (event) {
            // Obtener los valores de usuario y contraseña
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;

            // Verificar si los campos están vacíos
            if (username.trim() === "" || password.trim() === "") {
                // Si están vacíos, no realizar la animación y detener el envío del formulario
                event.preventDefault();
                return;
            }

            // Realizar la animación del spinner
            var btn = this;
            btn.querySelector("#loginText").style.display = "none";
            btn.querySelector(".spinner-border").style.display = "inline-block";

            // Simular una demora de 2 segundos antes de mostrar el texto de inicio de sesión nuevamente
            setTimeout(function () {
                btn.querySelector("#loginText").style.display = "inline-block";
                btn.querySelector(".spinner-border").style.display = "none";
            }, 2000);
        });
    </script>
</body>

</html>
