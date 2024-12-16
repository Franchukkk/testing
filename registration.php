<?php
require_once 'checkRegistration.php';

if (isset($_SESSION['isLogin']) && $_SESSION['isLogin']) {
    header("Location: profile.php");
}

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

    <form action="" method="POST" class="form">

        <div class="container">
            <h1>Зареєструйтесь</h1>
            <span><?= $errorRegister ? $errorRegister  : '' ?></span><br>
            <label for="username"><b>Username</b></label>
            <input type="text" name="username" id="username" value="<?= $_POST["username"] ?? '' ?>" placeholder="Username" required>
            <label for="username"><b>Phone number</b></label>
            <input type="text" name="phone" id="phone" value="<?= $_POST["phone"] ?? '' ?>" placeholder="Phone number" required>
            <label for="email"><b>Email</b></label>
            <input type="text" name="email" id="email" value="<?= $_POST["email"] ?? '' ?>" placeholder="Email" >
            <label for="psw"><b>Password</b></label>
            <input type="text" name="password" id="psw" placeholder="Password" >
            <label for="psw-repeat"><b>Repeat Password</b></label>
            <input type="text" name="confirmPassword" id="psw-repeat" placeholder="Confirm password">
            <a class="to-register" href="login.php">Увійти?</a>
            <input class="registerbtn" type="submit" name="submitRegistration">
        </div>

    </form>
</body>
</html>

