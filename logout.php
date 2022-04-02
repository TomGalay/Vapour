<?php
    session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
    if (!isset($_SESSION["loggedin"])) {
        header("location: login.php");
        exit;
    }
    $_SESSION["loggedin"] = false;
    session_unset();
    session_destroy();
    header("location: login.php");
    exit;
?>