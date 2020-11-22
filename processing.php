<?php include('includes/header.php');
      include('includes/classes/VideoUploadData.php');
      include('includes/classes/VideoProcessor.php');
if(!isset($_POST['uploadButton'])){
    echo "No File is set";
    
}
    
        //Craete File Upload data
        $VideoUploadData=new VideoUploadData(
            $_FILES['videoFile'],
            $_POST['titleInput'],
            $_POST['descriptionInput'],
            $_POST['privacyInput'],
            $_POST['categoryInput'],
            $userLoggedInObj->getUsername()
        );

//Process Video Data
$VideoProcessor = new VideoProcessor($con);
$wasSuccessful = $VideoProcessor->upload($VideoUploadData);

//Check Upload was Successfull
if($wasSuccessful){
    
}
?>

<?php include('includes/footer.php'); ?>
