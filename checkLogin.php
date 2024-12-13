<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
try {
    if (isset($_POST['submitLogin'])) {
        require_once "getAllTestsFunction.php";
        require_once "profileDataPreparation.php";

        $isUserFound = false;

        // searching of transferred user

        foreach ($newUsersArr as $name => $user) {
            if ($_POST["email"] == $user["email"] && password_verify($_POST["password"], $user["password"])) {
                // if user found - sucsessful log in
                $_SESSION["username"] = $user["username"];
                $_SESSION["loginStatus"] = "Вхід успішно виконано";
                $_SESSION['isLogin'] = true;
                $isUserFound = true;
                break;
            }
        }

        if (!$isUserFound) {
            // if user didn't found - wrong e-mail or password
            throw new Exception("Неправильна пошта або пароль");
        }
    }
} catch (Exception $e) {
    $_SESSION["loginStatus"] = $e->getMessage();
    $_SESSION['isLogin'] = false;
    header("Location: login.php");
}
