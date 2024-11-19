<!--<!doctype html>-->
<!--<html lang="en">-->
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <meta name="viewport" content="width=device-width, initial-scale=1.0">-->
<!--    <meta http-equiv="X-UA-Compatible" content="ie=edge">-->
<!--    <title>Document</title>-->
<!--</head>-->
<!--<body>-->
<!--<h1>Тест</h1>-->
<!---->
<?php
//session_start();
//require 'testInfo.php';
//
//$questionsPerPage = 3;
//
//if (!isset($_SESSION["shuffledQuestions"])) {
//    $_SESSION["userAnswers"] = [];
//    $_SESSION["timeOfStartingTest"] = time();
//}
//
//$isEndOfTest = isset($_POST["submitBtn"]) ? (int)$_POST["submitBtn"] : 0;
//
//if (!empty($_POST)) {
//    foreach ($_POST as $key => $value) {
//        if (strpos($key, 'answer_') === 0) {
//            $questionId = str_replace('answer_', '', $key);
//            $_SESSION["userAnswers"][$questionId] = $value;
//        }
//    }
//}
//
//$currentQuestions = array_slice($_SESSION["shuffledQuestions"], $isEndOfTest, $questionsPerPage);
//$totalQuestions = count($_SESSION["shuffledQuestions"]);
//
//$isTestComplete = $isEndOfTest + $questionsPerPage >= $totalQuestions;
//
//
//?>
<!---->
<!--<form action="--><?php //= $isTestComplete ? "results.php" : "index.php" ?><!--" method="POST">-->
<!--    --><?php //foreach ($currentQuestions as $question) { ?>
<!--        <p>--><?php //= $question["question"] ?><!--</p>-->
<!--        --><?php //foreach ($question["options"] as $option) { ?>
<!--            <label>-->
<!--                <input type="radio" name="answer_--><?php //= $question["id"] ?><!--" value="--><?php //= $option ?><!--">-->
<!--                --><?php //= $option ?>
<!--            </label>-->
<!--        --><?php //} ?>
<!--    --><?php //} ?>
<!---->
<!--    <button type="submit" name="submitBtn" value="--><?php //= $isEndOfTest + $questionsPerPage ?><!--">-->
<!--        --><?php //= $isTestComplete ? "Результати" : "Далі" ?>
<!--    </button>-->
<!--</form>-->
<!--</body>-->
<!--</html>-->

<?php
    session_start();
    require 'testInfo.php';
    require_once 'themeFunction.php';
    themeFunction();
    $_SESSION["timeOfStartingTest"] = time();
    if (!$_SESSION["isLogin"]) {
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
</head>
<body>

<a href="profile.php">Профіль</a>
<h1>Тест</h1>

<form action="calculateResults.php" method="POST">
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

