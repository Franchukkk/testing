<?php
session_start();
require_once 'themeFunction.php';
themeFunction();

if (isset($_SESSION['isLogin']) && $_SESSION['isLogin']) {
    header("Location: profile.php");
}

if (isset($_SESSION["error"])) {
    echo $_SESSION["error"];
    unset($_SESSION["error"]);
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
</head>
<body>

    <form action="checkRegistration.php" method="POST" class="form">
        <div class="container">
            <h1>Зареєструйтесь</h1>
            <label for="username"><b>Username</b></label>
            <input type="text" name="username" id="username" value="<?= $_POST["username"] ?? '' ?>" placeholder="Username" required>
            <label for="email"><b>Email</b></label>
            <input type="text" name="email" id="email" value="<?= $_POST["userEmail"] ?? '' ?>" placeholder="Email" required>
            <label for="psw"><b>Password</b></label>
            <input type="text" name="password" id="psw" placeholder="Password" required>
            <label for="psw-repeat"><b>Repeat Password</b></label>
            <input type="text" name="confirmPassword" id="psw-repeat" placeholder="Confirm password" required>
            <a class="to-register" href="login.php">Увійти?</a>
            <input class="registerbtn" type="submit" name="submitRegistration">
        </div>

    </form>
</body>
</html>

