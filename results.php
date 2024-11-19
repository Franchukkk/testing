<?php
    session_start();
    require_once 'themeFunction.php';
    themeFunction();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Результати</title>
</head>
<body>
    <a href="profile.php">В профіль</a>
    <h1>Результати</h1>

    <p>Ви відповіли правильно на <?= $_SESSION["correctAnswers"] ?> із <?= $_SESSION["totalQuestions"] ?> питань.</p>
    <p>Відсоток правильних відповідей: <?= $_SESSION["percentage"] ?> %.</p>
    <p>Оцінка: <?= $_SESSION["score"] ?> балів.</p>
    <p>Дата проходження тесту: <?= $_SESSION["testDate"] ?></p>
    <p>Час проходження тесту: <?= $_SESSION["testDuration"] ?></p>

</body>
</html>



