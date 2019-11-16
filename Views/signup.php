<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo FRONT_CSS; ?>estilos.css">
    <script src="https://kit.fontawesome.com/21dd680c2a.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo FRONT_CSS; ?>style.css">
    <title>MoviePass</title>
</head>

<?php
include_once(VIEWS_PATH . "nav.php");
?>
<br><br><br><br>

<body class="home">
    <!-- Sign up form -->
    <section class="signup">
        <div class="container">
            <div class="signup-content">
                <div class="signup-form">
                    <h2 class="form-title">Registrarse</h2>
                    <form action="<?php echo FRONT_ROOT ?>User/signUp" method="post" class="register-form" id="register-form">
                        <div class="form-group">
                            <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="text" name="user" id="name" placeholder="Usuario" required pattern="[A-Za-z0-9]{1,15}" title="Solo letras o números (máximo 15 caracteres)" />
                        </div>
                        <div class="form-group">
                            <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="password" id="password" placeholder="Contraseña" required pattern="[A-Za-z0-9]{4,}" title="Solo letras o números (mínimo 4 caracteres)" />
                        </div>
                        <div class="form-group">
                            <label for="email"><i class="zmdi zmdi-email"></i></label>
                            <input type="email" name="email" id="email" placeholder="Email" required />
                        </div>
                        <div class="form-group">
                            <label for="firstname"><i class="zmdi zmdi-email"></i></label>
                            <input type="text" name="firstname" id="firstname" placeholder="Nombre" required />
                        </div>
                        <div class="form-group">
                            <label for="lastname"><i class="zmdi zmdi-email"></i></label>
                            <input type="text" name="lastname" id="lastname" placeholder="Apellido" required>
                        </div>
                        <div class="form-group">
                            <label for="lastname"><i class="zmdi zmdi-email"></i></label>
                            <input type="number" name="dni" id="dni" placeholder="DNI" required>
                        </div>
                        <div class="form-group form-button">
                            <input type="submit" name="signup" id="signup" class="form-submit" value="Registrarse" />
                        </div>
                    </form>
                </div>
                <div class="signup-image">
                    <figure><img src="<?php echo FRONT_ROOT; ?>Views/img/logo.png" alt="sing up image"></figure>
                    <a href="<?php echo FRONT_ROOT ?>User/logInForm" class="signup-image-link">Ya estoy registrado</a>
                </div>
            </div>
        </div>
    </section>

    <?php

    include_once(VIEWS_PATH . "footer.php");
