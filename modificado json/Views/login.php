<body class="home">

<?php

    include_once(VIEWS_PATH . "header.php");
    include_once(VIEWS_PATH . "nav.php");
?>

<html>
<br>
<br>
<form id="login" action="<?php echo FRONT_ROOT ?>User/logIn" method="POST">
    <div class="container">
        <input type="text" name="user" id="name" placeholder="User" required="required">
        <input type="password" name="password" id="password" placeholder="Password" required="required">
        <button type="submit" id="login-submit">LOGIN</button> 
    </div>
</form>

<br>
<a class="home-link" href=<?php echo FRONT_ROOT?>>Home</a>

</html>

<?php
include_once(VIEWS_PATH . "footer.php");

