<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
sec_session_start();
 
if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Secure Login: Log In</title>
        <link rel="stylesheet" href="styles/main.css" />
        <script src="js/jquery.js"></script>
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script> 
    </head>
    <body>
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        ?>
        <form action="includes/process_login.php" method="post" name="login_form">                      
            Email: <input type="text" name="email" id="email" class="login_now" />
            Password: <input type="password" 
                             name="password" class="login_now" 
                             id="password"/>
            <input id="login_button" type="button" 
                   value="Login" 
                   onclick="formhash(this.form, this.form.password);" /> 
        </form>
        <p>If you don't have a login, please <a href="register.php">register</a></p>
        <?php if ($logged == 'in') {
echo '<p>If you are done, please <a href="includes/logout.php">log out</a>.</p>';
} ?>
        <p>You are currently logged <?php echo $logged ?>.</p>
<script>
$(".login_now").keydown(function (e){
    if(e.keyCode == 13){
        $("#login_button").click();
    }
})
</script>
    </body>
</html>