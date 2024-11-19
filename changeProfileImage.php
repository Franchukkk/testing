<?php
//    session_start();
//    function updateImg ($file, $size, $allowedTypes = ['image/png', 'image/jpeg']) {
//
//        if ($file['size'] < 5000000 && in_array($file['type'], $allowedTypes)) {
////            file_put_contents('uploaded_image.jpg', file_get_contents($_FILES['profileImage']['tmp_name']));
//            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
//            $destination = "img/" . $_SESSION["username"] . "." . $ext;
//            $_SESSION["imageDirectory"] = $destination;
//            move_uploaded_file($file['tmp_name'], $destination);
//            $_SESSION["successufulLoad"] = true;
//        } else {
//            $_SESSION["imgErr"] = "Завеликий розмір файлу, чи невірний тип";
//            $_SESSION["successufulLoad"] = false;
//        }
//
//        header("Location: profile.php");
//    }
//
//    updateImg($_FILES['profileImage'], $_FILES['profileImage']['size']);

//



session_start();

function updateImg($file) {
    if ($file['size'] < 5000000 && in_array($file['type'], ['image/png', 'image/jpeg'])) {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $destination = "img/" . $_SESSION["username"] . "." . $ext;
        move_uploaded_file($file['tmp_name'], $destination);

        $csvFile = 'csv/users.csv';
        $rows = file($csvFile);
        $updatedRows = [];

        foreach ($rows as $row) {
            $data = str_getcsv($row);
            if ($data[0] == $_SESSION["username"]) {
                $data[] = $destination;
            }
            $updatedRows[] = implode(',', $data) . "\n";
        }

        file_put_contents($csvFile, implode('', $updatedRows));

        $_SESSION["successufulLoad"] = true;
    } else {
        $_SESSION["imgErr"] = "Завеликий розмір файлу, чи невірний тип";
        $_SESSION["successufulLoad"] = false;
    }

    header("Location: profile.php");
}

updateImg($_FILES['profileImage']);
?>


