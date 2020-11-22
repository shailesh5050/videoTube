<?php 
require_once('includes/header.php');
require_once('includes/classes/VideoPlayer.php');
?>                
<?php

if(!isset($_GET['id'])){
    header("location:index.php");
}
$video = new Video($con,$_GET['id'],$userLoggedInObj);

$video->increaseViews();
?>

<div class="watchLeftColumn">
<?php 
$videoPlayer = new VideoPlayer($video);
echo $videoPlayer->create(true);

?>
</div>
<div class="suggestions">
    
</div>
<?php require_once('includes/footer.php') ?> 
           