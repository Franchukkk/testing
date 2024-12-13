<?php
// Processing of user test results
session_start();
require 'testInfo.php';
require_once "csvfunctions.php";
date_default_timezone_set("Europe/Kyiv");



$correctAnswers = 0;

foreach ($questions as $question) {
    $questionId = $question["id"];
    if (isset($_POST["answer_$questionId"]) && ($_POST["answer_$questionId"] == $question["answer"])) {
        $correctAnswers++;
    }
}

//Calculation of results

$_SESSION["correctAnswers"] = $correctAnswers;
$_SESSION["totalQuestions"] = count($_SESSION["shuffledQuestions"]);
$_SESSION["percentage"] = ($correctAnswers / count($_SESSION["shuffledQuestions"])) * 100;
$_SESSION["score"] = round((($_SESSION["percentage"]) * 12) / 100);
$_SESSION["testDate"] = date("d.m.Y H:i:s");
$_SESSION["testDuration"] = gmdate("H:i:s", time() - $_SESSION["timeOfStartingTest"]);

$newResult = [
    "testDate" => $_SESSION["testDate"],
    "correctAnswers" => $_SESSION["correctAnswers"],
    "percentage" => $_SESSION["percentage"],
    "score" => $_SESSION["score"],
    "testDuration" => $_SESSION["testDuration"],
];

// recording the results in a csv file

$filePath = "csv/usersResults.csv";
$usersResults = [];

try {
    $data = readCsv($filePath);

    if (empty($data)) {
        throw new Exception("Немає інформації у файлі $filePath");
    }

    $usersResults = [];
    foreach ($data as $row) {
        $username = $row[0];
        $results = isset($row[1]) ? json_decode($row[1], true) : [];
        $usersResults[$username] = $results;
    }
} catch (Exception $e) {
    error_log($e->getMessage());
}

$username = $_SESSION["username"];
if (!isset($usersResults[$username])) {
    $usersResults[$username] = [];
}
$usersResults[$username][] = $newResult;

$stream = fopen($filePath, "w");
echo "<pre>";

foreach ($usersResults as $user => $results) {
    writeCsv($filePath, [$user, json_encode($results)]);

}
fclose($stream);

header("Location: results.php");
