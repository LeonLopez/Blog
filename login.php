<?php 
ini_set("error_reporting","E_ALL & ~E_NOTICE");
session_start();
require 'config.php';
$db = mysqli_connect($dbhost,$dbuser,$dbpassword,$dbdatabase);
if($_POST['submit']){
    $sql = "select * from logins where username='".$_POST['username']."' and password='".$_POST['password']."';";
    $result = $db->query($sql);
    $numrows = $result->num_rows;
    if($numrows==1){
        $row = mysqli_fetch_assoc($result);
        
        $_SESSION['USERNAME']=$row['username'];
        $_SESSION['USERID']=$row['id'];
        header("Location:".$config_basedir);
    }else{
        header("Location:".$config_basedir."/login.php?error=1");
    }
}else{
    require 'header.php';
    if($_GET['error']){
        echo "Incorrect login please try again!";
    }

?>
<form action="<?php echo $_SERVER['SCRIPT_NAME'];?>" method="post">
<table>
<tr>
<td>Username</td>
<td><input type="text" name="username"></td>
</tr>
<tr>
<td>Password</td>
<td><input type="password" name="password"></td>
</tr>
<tr>
<td></td>
<td><input type="submit" name="submit" value="Login!"></td>
</tr>
</table>
</form>
<?php 
}
require 'footer.php';
?>