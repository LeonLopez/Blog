<?php 
ini_set("error_reporting","E_ALL & ~E_NOTICE");
session_start();
require 'config.php';
$db = mysqli_connect($dbhost,$dbuser,$dbpassword,$dbdatabase);

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title><?php echo $config_blogname; ?> </title>
	<link rel="stylesheet" href="stylesheet.css" type="text/css" />
</head>
<body>
<div id="header">
<h1><?php echo $config_blogname;?></h1>
<a href="index.php">Home</a>|
<a href="viewcat.php">Categories</a>|
<?php 
if(isset($_SESSION['USERNAME'])==TRUE){
    echo "<a href='logout.php'>logout</a>|";
    echo "<a href='addentry.php'>add entry</a>|";
    echo "<a href='addcat.php'>add category</a>";
}else{
    echo "<a href='login.php'>login</a>";
   
}
?>
</div>

<div id="main">
	

