<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';





if(isset($_POST['type']))
{
$type=$_POST['type'];
$sql_res=mysqli_query($mysqli, "select * from materials_list where type = '$type'");

while($row=mysqli_fetch_array($sql_res))
{
echo '<option value='.$row['Cost'].' name='.$row['ID'].' >'.$row['Name'].'</option>'; 
}

}else{
header("Location:./wood-fence.php");
}
?>