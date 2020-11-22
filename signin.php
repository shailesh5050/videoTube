<?php 
require_once('includes/config.php');
require_once('includes/classes/formSenetizer.php');
require_once('includes/classes/Constants.php');
require_once('includes/classes/Account.php');
$account = new Account($con);
if (isset($_POST['submitButton'])) {
    $username = formSenetizer::senetizedFormUsername($_POST['username']);
    $password = formSenetizer::senetizedFormPassword($_POST['password']);
    $wasSuccessfull = $account->login($username,$password );
    if($wasSuccessfull){
        $_SESSION['userLogged'] = $username;
        header("location:index.php");
    }

   
}
function getInputValue($name){
    if(isset($_POST[$name])){
        echo $_POST[$name];
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>videoTube</title>

    <!--Custome Style sheet--->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!---Bootstrap--->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!----Jquery------->
    <script src="assets/js/jquery.min.js"></script>
    <!----Bootstrap js------->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!---Custom js----->
    <script src="assets/js/app.js"></script>
</head>

<body>

    <div class="signInContainer">
        <div class="column" id="signInCol">
            <div class="header">
            <img src="assets/images/icons/VideoTubeLogo.png" alt="" srcset="">
            <h3>Sign up</h3>
            <span>to continue VideoTube</span>
            </div>
            <div class="loginForm">
                <form action="signin.php" method="POST">
                <?php echo $account->getError(Constants::$loginError); ?>
                <input type="text" name="username" placeholder="Username" autocomplete="off" value="<?php getInputValue('username'); ?>">
                <input type="password" name="password" placeholder="Password" value="<?php getInputValue('password'); ?>">
                
                <input type="submit" name="submitButton" value="Login">
                </form>
            </div>
            <a href="signUp.php" class="signInMessage">Need an account ? sign Up here !</a>
        </div>
    </div>
</body>

</html>