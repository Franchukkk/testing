<?php
    session_start();

    if (isset($_POST['submitLogin'])) {
        require_once 'createUsersArr.php';

        foreach ($newUsersArr as $name => $user) {

            if ($_POST["email"] == $newUsersArr[$name]["email"] && password_verify($_POST["password"], $newUsersArr[$name]["password"])) {
                $_SESSION["username"] = $user["username"];
                echo $_SESSION["username"];

                $_SESSION["loginStatus"] = "Вхід успішно виконано";
                $_SESSION['isLogin'] = true;

                header("Location: login.php");
                die;
            } else {
                $_SESSION["loginStatus"] = "Неправильна пошта або пароль";
                $_SESSION['isLogin'] = false;
            }
        }
    }

    header("Location: login.php");