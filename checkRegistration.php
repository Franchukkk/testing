<?php
session_start();
require_once "csvfunctions.php";
$errorRegister = false;
if (isset($_POST["submitRegistration"])) {
    $usersData = readCsv("csv/users.csv");
    try {
        // check if all fields are full
        if ($_POST["username"] == null || $_POST["password"] == null || $_POST["confirmPassword"] == null) {
            throw new Exception("Всі поля мають бути заповнені");
        } else {
            try {

                $newUsersArr = [];
                // if the user already registered
                foreach ($usersData as $user) {
                    if ($user[0] == $_POST["username"]) {
                        throw new Exception("такий користувач вже є");
                        break;
                    } else if ($user[1] == $_POST["email"]) {
                        throw new Exception("такий емейл вже є");
                        break;
                    }
                }

                //check if email and phone number are valid

                if (!preg_match('#^/\+?(\d{1,3})?[- ]?(\(?\d{1,4}\)?[- ]?)\(?\d{2,4}\)?[- ]?\d{2,4}[- ]?\d{2,4}[- ]?\d{0,4}$#', $_POST["phone"])) {
                    throw new Exception("невірний формат номера телефону");
                }

                if (!preg_match("#^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$#", $_POST["email"])) {
                    throw new Exception("невірний формат емейла");
                }



                if ($_POST["password"] == $_POST["confirmPassword"]) {
                    // if all data is ok - writing user into csv file
                    $_SESSION['username'] = $_POST["username"];

                    writeCsv("csv/users.csv", [
                        $_POST["username"],
                        $_POST["email"],
                        password_hash($_POST["password"], PASSWORD_BCRYPT, ["cost" => 12]),
                        $_POST["phone"],
                    ]);


                    header("Location: login.php");


                } else {
                    // if passwords does not same - throw an error
                    Throw new Exception("Паролі не співпадають");
                }
            } catch (Exception $e) {
                $errorRegister = $e->getMessage();
            }

        }
    } catch (Throwable $e) {
        $errorRegister = $e->getMessage();
    }

}