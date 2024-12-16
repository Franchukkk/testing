<?php
    session_start();
    require 'testInfo.php';
    $_SESSION["timeOfStartingTest"] = time();
    if (!$_SESSION["isLogin"] || $_SESSION["username"] == "admin") {
        header("Location: login.php");
    }
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <?php
    if (isset($_COOKIE["theme"]) && $_COOKIE["theme"] == 'dark') {
        ?>
        <link rel="stylesheet" href="stylesNight.css">
        <?php
    }
    ?>
</head>
<body>

<a href="profile.php">Профіль</a>
<h1>Тест</h1>

<form action="calculateResults.php" method="POST">
<!--    writting all the questions and buttons to tick an answer-->
    <?php foreach ($_SESSION["shuffledQuestions"] as $question) { ?>
        <p><?= $question["question"] ?></p>
        <?php foreach ($question["options"] as $option) { ?>
            <label>
                <input type="radio" name="answer_<?= $question["id"] ?>" value="<?= $option ?>">
                <?= $option ?>
            </label>
        <?php } ?>
    <?php } ?>
    <br><br>
    <button type="submit" name="submitBtn">Результати</button>
</form>
</body>
</html>

