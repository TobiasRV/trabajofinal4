<body class="home">

<?php

    include_once(VIEWS_PATH . "header.php");
    include_once(VIEWS_PATH . "nav.php");

?>

<html>

<br>
<br>
<form id="signup" action="<?php echo FRONT_ROOT ?>User/signUp" method="POST">
    <input type="text" name="user" id="name" placeholder="User" required pattern="[A-Za-z0-9]{1,15}" title="Solo letras o números (máximo 15 caracteres)">
    <input type="password" name="password" id="password" placeholder="Password" required pattern="[A-Za-z0-9]{4,}" title="Solo letras o números (mínimo 4 caracteres)">
    <input type="text" name="firstname" id="firstname" placeholder="First Name" required >
    <input type="text" name="lastname" id="lastname" placeholder="Last Name" required >
    <input type="email" name="email" id="email" placeholder="Email" required>
    <button type="submit" id="login-submit">SIGN UP</button>
</form>

<br>
<a class="home-link" href=<?php echo FRONT_ROOT?>>Home</a>

</html>

<?php

include_once(VIEWS_PATH . "footer.php");