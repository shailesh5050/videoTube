<?php
require_once('includes/config.php');
require_once('includes/classes/formSenetizer.php');
require_once('includes/classes/Constants.php');
require_once('includes/classes/Account.php');

$account = new Account($con);


if (isset($_POST['submitButton'])) {

    $fistName = formSenetizer::senetizedFormString($_POST['firstName']);
    $lastName = formSenetizer::senetizedFormString($_POST['lastName']);
    $userName = formSenetizer::senetizedFormUsername($_POST['userName']);
    $email = formSenetizer::senetizedFormEmail($_POST['email']);
    $email2 = formSenetizer::senetizedFormEmail($_POST['email2']);
    $password = formSenetizer::senetizedFormPassword($_POST['password']);
    $password2 = formSenetizer::senetizedFormString($_POST['password2']);
    $wasSuccessfull=$account->register($fistName, $lastName, $userName, $email, $email2, $password, $password2);
    if(!$wasSuccessfull){
        $_SESSION['userLogged'] = $userName;
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
                <form action="signUp.php" method="post" id="signInForm">



                    <input type="text" name="firstName" placeholder="First name" autocomplete="off"  value="<?php getInputValue('firstName'); ?>" required>
                    <?php echo $account->getError(Constants::$firstnameCharacters); ?>
                    <input type="text" name="lastName" placeholder="Last name" autocomplete="off" value="<?php getInputValue('lastName'); ?>" required>
                    <?php echo $account->getError(Constants::$lastnameCharacters); ?>
                    <input type="text" name="userName" placeholder="User name" autocomplete="off" value="<?php getInputValue('userName'); ?>" required>
                    <?php echo $account->getError(Constants::$UsernameCharacters); ?>
                    <?php echo $account->getError(Constants::$usernameTaken); ?>
                    <input type="text" name="email" placeholder="Email" autocomplete="off" value="<?php getInputValue('email'); ?>" required>
                    <?php echo $account->getError(Constants::$emailInvailid ); ?>
                    <input type="text" name="email2" placeholder="Confirm Email" autocomplete="off" value="<?php getInputValue('email2'); ?>" required>
                    <?php echo $account->getError(Constants::$emsilsDoNotMatch); ?>
                    <input type="password" name="password" placeholder="Password" autocomplete="off"  value="<?php getInputValue('password'); ?>" required>
                    <?php echo $account->getError(Constants::$PasswordNotAlphaNum); ?>
                    <?php echo $account->getError(Constants::$passwordCharacter); ?>
                    <input type="password" name="password2" placeholder="Confirm Password" autocomplete="off" value="<?php getInputValue('password2'); ?>" required>
                    <?php echo $account->getError(Constants::$emsilsDoNotMatch); ?>
                    <input type="submit" name="submitButton" value="SUBMIT">

                </form>
            </div>
            <a href="signIn.php" class="signInMessage">Already have an account ? sign here !</a>
        </div>
    </div>
</body>

</html>