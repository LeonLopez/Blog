<?php
ini_set("error_reporting","E_ALL & ~E_NOTICE");
require 'config.php';

if(isset($_GET['id'])==TRUE){
    if(is_numeric($_GET['id'])==FALSE){
        $error=1;
    }
    if($error==1){
        header("Location:".$config_basedir."/viewcat.php");
        
    }else{
        $validcat=$_GET['id'];
    }
}
else{
    $validcat=1;
}
require 'header.php';
$db = mysqli_connect($dbhost,$dbuser,$dbpassword,$dbdatabase);
$sql = "select * from categories";
$result = $db->query($sql);

while($row = mysqli_fetch_assoc($result)){
   
    if($row['id']==$validcat){
        echo "<strong>".$row['cat']."</strong><br/>";
        $entriessql = "select * from entries where cat_id=".$validcat." order by dateposted desc;";
        $entriesres = $db->query($entriessql);
        $numrows_entries = $entriesres->num_rows;
        echo "<ul>";
        if($numrows_entries==0){
            echo "<li>No entries!</li>";
            
        }else{
            while($entriesrow = mysqli_fetch_assoc($entriesres)){
                echo "<li>".date("D jS F Y g.iA",strtotime($entriesrow['dateposted']))."-<a href='viewentry.php?id=".$entriesrow['id']."'>".$entriesrow['subject']."</a></li>";
                
            }
        }
        echo "</ul>";
    }
    else{
        echo "<a href='viewcat.php?id=".$row['id']."'>".$row['cat']."</a><br/>";
    }
}
require 'footer.php';