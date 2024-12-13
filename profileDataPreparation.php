<?php

require_once 'csvfunctions.php';

if(isset($_POST['deleteImg'])){
    $_SESSION["successufulLoad"] = false;
    header("Location: profile.php");
}

//// array of all user's testing results
//$tests = getAllTests('csv/usersResults.csv', $_SESSION["username"]);


// creating of array with info about a logged user
$usersData = readCsv("csv/users.csv");

$newUsersArr = [];

foreach ($usersData as $user) {
    $imagePath = null;

    foreach ($user as $field) {
        if (strpos($field, 'img/') === 0) {
            $imagePath = $field;
            break;
        }
    }

    $newUsersArr[$user[0]] = [
        "username" => $user[0],
        "email" => $user[1],
        "password" => $user[2],
        "phone" => $user[3],
    ];
}

function getAvatarPath($username) {
    $csvFile = 'csv/usersAvatars.csv';

    try {
        if (!file_exists($csvFile)) {
            throw new Exception('img/profile-default.webp');
        }

        $rows = array_map('str_getcsv', file($csvFile));

        foreach ($rows as $row) {
            if ($row[0] === $username) {
                return $row[1];
            }
        }

        return null;
    } catch (Exception $e) {
        echo $e->getMessage();
        return null;
    }
}
