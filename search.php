<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
sec_session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Search - LGFC</title>
        <link rel="stylesheet" href="styles/main.css" />
    </head>
    <body>
        <?php if (login_check($mysqli) == true) : ?>
<?php include_once 'header.php';?>
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>
        

        <form style="margin:5px 0 10px;text-align:center;" action="searchresults.php" 
                method="post" 
                name="search_form"> Search By: 
<select name="search_in">
  <option value="first">Inquiries</option>
  <option value="last">Contacts</option>
</select> 
<select name="search_by">
  <option value="first">First Name</option>
  <option value="last">Last Name</option>
  <option value="business">Business Name</option>
  <option value="phone">Phone</option>
  <option value="address">Address</option>
</select> 
            <input type="text" name="search" />
        <input type="submit" name="Submit" value="Search" /> 
        </form>




        <p>Return to the <a href="index.php">Home page</a>.</p>
<?php mysqli_close($mysqli); ?>
        <?php else : ?>
            <p>
                <span class="error">You are not authorized to access this page.</span> Please <a href="index.php">login</a>.
            </p>
        <?php endif; ?>
    </body>
</html>