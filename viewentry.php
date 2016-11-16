<?php
require 'config.php';
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
    $db = mysqli_connect($dbhost,$dbuser,$dbpassword,$dbdatabase);
    $sql = "insert into comments(blog_id,dateposted,name,comment) values(".$validentry.",now(),'".$_POST['name']."','".$_POST['comment']."');";
    $db->query($sql);
    header("Location:http://localhost".$_SERVER['SCRIPT_NAME']."?id=".$validentry);
}


require 'header.php';
if($validentry==0){
    $sql = "select entries.*,categories.cat from entries,categories where entries.cat_id=categories.id order by
    dateposted desc limit 1;";
    
}else{
    $sql = "select entries.*,categories.cat from entries,categories where entries.cat_id=categories.id and entries.id=".$validentry." order by
    dateposted desc limit 1;";
    
}
$result = $db->query($sql);
$row = mysqli_fetch_assoc($result);

$commsql = "select * from comments where blog_id=".$row['id']." order by dateposted desc;";
$commresult = $db->query($commsql);
$numrows_comm = $commresult->num_rows;

?>
<h2><?php echo $row['subject'];?></h2><br/>
<i>In <a href="viewcat.php?id=<?php echo $row['cat_id'];?>"><?php echo $row['cat'];?></a>-Posted on <?php echo date("D jS F Y g.iA",strtotime($row['dateposted']));?></i>
<?php 
if(isset($_SESSION['USERNAME'])==TRUE){
    echo "[<a href='updateentry.php?id=".$row['id']."'>edit</a>]";
}
?>
<p><?php echo nl2br($row['body']);?></p>
<?php 
if($numrows_comm==0){
    echo "<p>No comments.</p>";
}
else{
    
    $i=1;
    while($commrow = $commresult->fetch_assoc()){
        echo "<a name='comment".$i."'>";
        echo "<h3>Comment by ".$commrow['name']." on ".date("D jS F Y g.iA",strtotime($commrow['dateposted']))."</h3>";
        echo $commrow['comment'];
        $i++;
    }
   
}
?>

<h3>Leave a comment</h3>
<form action="<?php echo $_SERVER['SCRIPT_NAME']."?id=".$row['id'];?>" method="post">
<table>
<tr>
<td>Your name</td>
<td><input type="text" name="name"></td>
</tr>
<tr>
<td>Comments</td>
<td><textarea rows="10" cols="50" name="comment"></textarea></td>
</tr>
<tr>
<td></td>
<td><input type="submit" name="submit" value="Add comment"></td>
</tr>

</table>


</form>

<?php

require ("footer.php");

?>







