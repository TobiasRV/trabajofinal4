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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>MoviePass</title>
</head>




<?php

include_once(VIEWS_PATH . "nav.php");
?>

<body class="home">
<br><br><br><br>
    
        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="<?php echo FRONT_ROOT; ?>Views/img/logo.png" alt="sing up image"></figure>
                        <a href="<?php echo FRONT_ROOT?>User/signUpForm" class="signup-image-link">Crear Cuenta</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Iniciar Sesión</h2>
                        <form action="<?php echo FRONT_ROOT ?>User/logIn" method="post" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="user" id="name" placeholder="Usuario" required="required" />
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="password" placeholder="Contraseña" required="required" />
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Recordarme</label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Ingresar" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
 

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>


    <?php if($msj != null){?>
        <script>swal({
    title: "Error!",
    text: "<?php echo $msj; ?>",
    icon: "warning",
    });</script>
    <?php } ?>
    <?php
    include_once(VIEWS_PATH . "footer.php");?>
