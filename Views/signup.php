<html>

<form id="signup" action="<?php echo FRONT_ROOT ?>/User/signUp" method="POST">
    <input type="text" name="user" id="name" placeholder="User" maxlength="15" required="required">
    <input type="password" name="password" id="password" placeholder="Password" required="required">
    <input type="text" name="firstname" id="firstname" placeholder="First Name" required="required">
    <input type="text" name="lastname" id="lastname" placeholder="Last Name" required="required">
    <input type="email" name="email" id="email" placeholder="Email" required="required">
    <button type="submit" id="login-submit">SIGN UP</button>
</form>



</html>