<?php
    session_start();

    if($_POST['deleteImg']){
        $_SESSION["successufulLoad"] = false;
        header("Location: profile.php");
    }