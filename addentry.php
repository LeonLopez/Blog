<?php 
session_start();
require 'config.php';
$db = mysqli_connect($dbhost,$dbuser,$dbpassword,$dbdatabase);
if(isset($_SESSION['USERNAME'])==FALSE){
    header("Location:".$config_basedir);
}
if($_POST['submit']){
    $sql = "insert into entries(cat_id,dateposted,subject,body) values(".$_POST['cat'].",now(),'".$_POST['subject']."','".$_POST['body']."');";
    
    $db->query($sql);
    header("Location:".$config_basedir);
}else{

    require 'header.php';
?>

<h1>Add new entry</h1>
<form action="<?php echo $_SERVER['SCRIPT_NAME'];?>" method="post">
<table>
<tr>
<td>Category</td>
<td>
<select name="cat">
<?php 
$sql = "select * from categories";
$result = $db->query($sql);
while($row = mysqli_fetch_assoc($result)){
    echo "<option value='".$row['id']."'>".$row['cat']."</option>";
}
?>
</select>
</td>
</tr>
<tr>
<td>Subject</td>
<td><input type="text" name="subject"></td>
</tr>
<tr>
<td>Body</td>
<td><textarea name="body" rows="10" cols="50"></textarea></td>
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