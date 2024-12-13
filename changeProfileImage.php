<?php

session_start();
require_once 'csvfunctions.php';

// Function that updates profile avatar
function updateImg($file) {
    try {
        // validation by image size and type
        if ($file['size'] >= 5000000 || !in_array($file['type'], ['image/png', 'image/jpeg'])) {
            throw new Exception("Завеликий розмір файлу або невірний тип");
        }

        // generation of image src
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $destination = "img/" . $_SESSION["username"] . "." . $ext;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new Exception("Помилка при завантаженні файлу");
        }

        // writing avatar src in a csv file

        $csvFile = 'csv/usersAvatars.csv';
        $updated = false;
        $rows = [];

        if (file_exists($csvFile)) {
            $rows = array_map('str_getcsv', file($csvFile));
        }

        foreach ($rows as &$row) {
            if ($row[0] === $_SESSION["username"]) {
                $row[1] = $destination;
                $updated = true;
                break;
            }
        }

        if (!$updated) {
            $rows[] = [$_SESSION["username"], $destination];
        }

        writeCsv($csvFile, $rows, "w");
        $_SESSION["successufulLoad"] = true;
    } catch (Exception $e) {
        $_SESSION["imgErr"] = $e->getMessage();
        $_SESSION["successufulLoad"] = false;
    } finally {
        header("Location: profile.php");
    }
}

updateImg($_FILES['profileImage']);

?>
