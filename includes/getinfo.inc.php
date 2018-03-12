<?php
include_once 'db_connect.php';
include_once 'functions.php';
sec_session_start();
if (login_check($mysqli) != true){
header("Location:./index.php");
}
else : ?>
<?php


if(!empty($_GET['contact'])) {
    $search = mysqli_real_escape_string($mysqli , $_GET['contact']);

    $stmt = $mysqli->prepare("SELECT * FROM list_contacts WHERE first_name LIKE '%".$search."%'");
    $stmt -> execute(array($search));
    $num = $stmt->num_rows;
}
if ($num == 0){
    echo "<p>Sorry, no results</p>";
} else {
    if ($num == 1){
            echo '<p>Please click the link to visit the page.</p>';
        } else {
            echo '<p>We have found '.$num.' that match your search. Please click a link to visit the page.</p>';
        }
        echo '<ul class="contacts">';
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            echo '<li><h3><a href="contacts.php?id='.$row['contact_id'].'">'.$row['phone'].$row['first_name'].$row['last_name'].$row['address'].$row['zip'].$row['note'].'</a></h3></li>';
        }
    echo '</ul>';
}


mysqli_close($mysqli);
?>
</body>
</html>
<?php endif; ?>
