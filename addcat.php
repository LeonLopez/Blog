<?php 
session_start();
require 'config.php';
$db = mysqli_connect($dbhost,$dbuser,$dbpassword,$dbdatabase);
if(isset($_SESSION['USERNAME'])==FALSE){
    header("Location:".$config_basedir);
}
if($_POST['submit']){
    $sql = "insert into categories(cat) values('".$_POST['cat']."');";
    $db->query($sql);
    header("Location:".$config_basedir."viewcat.php");
}else{
    
require 'header.php';

?>


<form action="<?php echo $_SERVER['SCRIPT_NAME'];?>" method="post">
<table>
<tr>
<td>Category</td>
<td><input type="text" name="cat"></td>
</tr>
<tr>
<td></td>
<td><input type="submit" name="submit" value="Add Entry!"></td>
</tr>
</table>
</form>
<?php 
}
require 'footer.php';
?>