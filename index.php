<?php
require 'header.php';
$sql = "select entries.*,categories.cat from entries,categories where entries.cat_id=categories.id order by
    dateposted desc limit 1;";
$result = $db->query($sql);
$row = mysqli_fetch_assoc($result);

$commsql = "select name from comments where blog_id=".$row['id']." order by dateposted desc;";
$commresult = $db->query($commsql);
$numrows_comm = $commresult->num_rows;

$prevsql = "select entries.*,categories.cat from entries,categories where entries.cat_id=categories.id order by
    dateposted desc limit 1,5;";
$prevresult = $db->query($prevsql);
$numrows_prev = $prevresult->num_rows;

?>
<br>
<br>
<br>
<h2><a href="viewentry.php?id=<?php echo $row['id'];?>"><?php echo $row['subject'];?></a></h2><br/>
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
    echo "(<strong>".$numrows_comm."</strong>):comments:";
    $i=1;
    while(@$commrow=mysqli_fetch_assoc($commresult)){
        echo "<a href='viewentry.php?id=".$row['id']."#comment".$i."'>".$commrow['name']." </a>";
        $i++;
    }
    echo "</p>";
}
if($numrows_prev==0){
   echo "<p>No previous entries.</p>";
}else{
    echo "<ul>";
    while(@$prevrow=mysqli_fetch_assoc($prevresult)){
        echo "<li><a href='viewentry.php?id=".$prevrow['id']."'>".$prevrow['subject']."</a></li>";
    }
    echo "</ul>";
}
?>

<?php 
require 'footer.php';
?>