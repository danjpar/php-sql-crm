<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
sec_session_start();
 
if (login_check($mysqli) == true) {
include_once 'protected_page.php';
} else {
include_once 'login.php';
}
?>

