<?php
session_start();

require_once "getAllTestsFunction.php";
require_once "profileDataPreparation.php";

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
    <?php
    if (isset($_COOKIE["theme"]) && $_COOKIE["theme"] == 'dark') {
        ?>
        <link rel="stylesheet" href="stylesNight.css">
        <?php
    }
    ?>
</head>
<body>
    <form action="profile.php" method="POST">
        <div class="container">
            <h1>Увійдіть</h1>
            <?php
                if (isset($_SESSION["loginStatus"])) {
                    echo $_SESSION["loginStatus"] . "<br>";
                    $_SESSION["loginStatus"] = '';
                }
            ?>
            <label for="email"><b>Email</b></label>
            <input type="text" name="email" id="email" value="<?= isset($_SESSION["username"]) ? $newUsersArr[$_SESSION["username"]]["email"] : ''?>" placeholder="email" required>
            <label for="psw"><b>Password</b></label>
            <input type="text" name="password" id="psw" placeholder="password" required>
            <a class="to-register" href="registration.php">Зареєструватися?</a>
            <input type="submit" name="submitLogin" class="registerbtn">
        </div>
    </form>

</body>
</html>
