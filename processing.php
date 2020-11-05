<?php include('includes/header.php'); 
if(!isset($_POST['uploadButton'])){
    echo "No File is set";
    
}
    echo $_FILES['videoFile']["name"];
?>

<?php include('includes/footer.php'); ?>
