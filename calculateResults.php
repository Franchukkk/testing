<?php
session_start();
require 'testInfo.php';
date_default_timezone_set("Europe/Kyiv");

$correctAnswers = 0;

foreach ($questions as $question) {
    $questionId = $question["id"];
    if (isset($_POST["answer_$questionId"]) && ($_POST["answer_$questionId"] == $question["answer"])) {
        $correctAnswers++;
    }
}

$stream = fopen("csv/users.csv", "r");
$usersData = [];
while ($row = fgetcsv($stream)) {
    $usersData[] = $row;
}
fclose($stream);

$newUsersArr = [];

foreach ($usersData as $user) {
    $newUsersArr[$user[0]]["username"] = $user[0];
    $newUsersArr[$user[0]]["email"] = $user[1];
    $newUsersArr[$user[0]]["password"] = $user[2];
}

$_SESSION["correctAnswers"] = $correctAnswers;
$_SESSION["totalQuestions"] = count($_SESSION["shuffledQuestions"]);
$_SESSION["percentage"] = ($correctAnswers / count($_SESSION["shuffledQuestions"])) * 100;
$_SESSION["score"] = round((($_SESSION["percentage"]) * 12) / 100);
$_SESSION["testDate"] = date("d.m.Y H:i:s");
$_SESSION["testDuration"] = gmdate("H:i:s", time() - $_SESSION["timeOfStartingTest"]);

//foreach ($usersData as &$user) {
//    if ($user[0] == $_SESSION["username"]) {
//        $user[] = [
//            "testDate" => $_SESSION["testDate"],
//            "correctAnswers" => $_SESSION["correctAnswers"],
//            "percentage" => $_SESSION["percentage"],
//            "score" => $_SESSION["score"],
//            "testDuration" => $_SESSION["testDuration"],
//        ];
//        break;
//    }
//}

foreach ($usersData as $index => $user) {  // Використовуємо індекс для доступу до елемента масиву
    if ($user[0] == $_SESSION["username"]) {
        // Створюємо асоціативний масив з результатами тесту
        $testResults = [
            "testDate" => $_SESSION["testDate"],
            "correctAnswers" => $_SESSION["correctAnswers"],
            "percentage" => $_SESSION["percentage"],
            "score" => $_SESSION["score"],
            "testDuration" => $_SESSION["testDuration"],
        ];

        // Додаємо результат тесту до кінця масиву $user
        $usersData[$index][] = json_encode($testResults);  // Використовуємо індекс для змінення даних
        break;
    }
}

// Перезаписуємо файл CSV
$stream = fopen("csv/users.csv", "w");
foreach ($usersData as $user) {
    fputcsv($stream, $user);  // Запис кожного користувача в CSV
}
fclose($stream);





$stream = fopen("csv/users.csv", "w");
foreach ($usersData as $user) {
    if (is_array(end($user))) {
        $user[count($user) - 1] = json_encode(end($user));
    }
    var_dump($user);
    fputcsv($stream, $user);
}
fclose($stream);

header("Location: results.php");
