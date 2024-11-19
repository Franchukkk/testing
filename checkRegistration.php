<?php
session_start();

if (isset($_POST["submitRegistration"])) {
    $stream = fopen("csv/users.csv", "a+");
//    $_SESSION["email"] = $_POST["email"];

    $usersData = [];
    while ($row = fgetcsv($stream)) {
        $usersData[] = $row;
    }

    $newUsersArr = [];

    foreach ($usersData as $user) {
        if ($user[0] == $_POST["username"]) {
            $_SESSION["error"] = "Користувач із таким юзернеймом вже існує";
            fclose($stream);
            header("Location: registration.php");
        } else if ($user[1] == $_POST["email"]) {
            $_SESSION["error"] = "Користувач із такою поштою вже існує";
            fclose($stream);
            header("Location: registration.php");
        }
    }


    if ($_POST["password"] == $_POST["confirmPassword"]) {
        $_SESSION['username'] = $_POST["username"];
//        $_SESSION["password"] = $_POST["password"];
        fputcsv($stream, [
            $_POST["username"],
            $_POST["email"],
            password_hash($_POST["password"], PASSWORD_BCRYPT, ["cost" => 12])
        ]);

        fclose($stream);
        header("Location: login.php");
    } else {
        $_SESSION["error"] = "Паролі не співпадають";
        header("Location: registration.php");
    }
}