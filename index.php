<?php require_once('includes/header.php') ?>                
<?php
if(isset($_SESSION['userLogged'])){
    echo "Welcome ".$userLoggedInObj->getName();
}else{
    echo "Welcome Guest";
}
?>
<?php require_once('includes/footer.php') ?> 
           