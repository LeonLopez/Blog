<?php 
session_start();
require 'config.php';
$db = mysqli_connect($dbhost,$dbuser,$dbpassword,$dbdatabase);
if(isset($_SESSION['USERNAME'])==FALSE){
    header("Location:".$config_basedir);
}
if(isset($_GET['id'])){
    if(is_numeric($_GET['id'])==FALSE){
        $error=1;
    }
    if($error==1){
        header("Location:".$config_basedir);
    }
    else{
        $validentry=$_GET['id'];
    }
}
else{
    $validentry=0;
}
if($_POST['submit']){
    $sql = "update entries set cat_id=".$_POST['cat'].",subject='".$_POST['subject']."',body='".$_POST['body']."'where id=".$validentry.";";
    
    $db->query($sql);
    header("Location:".$config_basedir."/viewentry.php?id=".$validentry);
}else{

    require 'header.php';
    $entrysql = "select * from entries where id=".$validentry;
    $entryres = $db->query($entrysql);
    $entryrow = mysqli_fetch_assoc($entryres);
?>
<h1>Update entry</h1>
<form action="<?php echo $_SERVER['SCRIPT_NAME']."?id=".$validentry;?>" method="post">
<table>
<tr>
<td>Category</td>
<td>
<select name="cat">
<?php 
$sql = "select * from categories";
$result = $db->query($sql);
while($row = mysqli_fetch_assoc($result)){
    echo "<option value='".$row['id']."'";
    if($row['id']==$entryrow['cat_id']){
        echo " selected";
    }
    echo ">".$row['cat']."</option>";
}

?>
</select>
</td>
</tr>
<tr>
<td>Subject</td>
<td><input type="text" name="subject" value="<?php echo $entryrow['subject'];?>"></td>
</tr>
<tr>
<td>Body</td>
<td><textarea name="body" rows="10" cols="50"><?php echo $entryrow['body'];?></textarea></td>
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