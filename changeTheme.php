<?php
    // setting the theme
    session_start();
    if (isset($_POST["dark"])) {
        setcookie("theme", "dark", time() + 3600 * 24 * 30);
    } else if (isset($_POST["light"])) {
        setcookie("theme", "light", time() + 3600 * 24 * 30 );
    }

    header("Location: profile.php");