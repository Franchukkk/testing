<?php
    $stream = fopen("csv/users.csv", "r");
    $usersData = [];
    while ($row = fgetcsv($stream)) {
        $usersData[] = $row;
    }

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
            "imagePath" => $imagePath
        ];
    }
