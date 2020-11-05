<?php include("includes/config.php") ?>
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
    <div id="pageContainer">
        <!---Top Header--->
        <div id="mastHeadContainer" class="">
            <!---Menu Bars---->
            <button class="showHide"><img src="assets/images/icons/menu.png" alt=""></button>
            <!---Site Logo ---->
            <a href="index.php" class="logoContainer">
            <img src="assets/images/icons/VideoTubeLogo.png" alt="VideoTube" title="VideoTube">
            </a>

            <!--Search Box----->
            <div class="searchBarContainer">
                <form action="search.php" method="get">
                    <input type="text" placeholder="Search..." class="searchBar">
                    <button class="searchButton"><img src="assets/images/icons/search.png" alt=""></button>
                </form>
            </div>
            <div class="rightIcons">
                <a href="upload.php">
                    <img src="assets/images/icons/upload.png" alt="" srcset="">
                </a>
                
                <a href="#">
                    <img src="assets/images/profilePictures/default.png" alt="" srcset="">
                </a>
            </div>
        </div>

        <!---sideBar--->
        <div id="sideNavContainer" style="display: none;">


        </div>

        <!---Main Section--->
        <div id="mainSectionContainer">

            <div class="mainContentContainer" id="mainContentContainer">
