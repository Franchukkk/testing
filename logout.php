<?php
    session_start();
    if (isset($_POST["logout"])) {
        $_SESSION['isLogin'] = false;
        $_SESSION["imageDirectory"] = null;

        header("Location: login.php");
    }