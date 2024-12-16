<?php
    session_start();
    require_once "checkLogin.php";
    require_once 'profileDataPreparation.php';
    require_once 'getAllTestsFunction.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="profile.css">
    <?php
        if (isset($_COOKIE["theme"]) && $_COOKIE["theme"] == 'dark') {
    ?>
            <link rel="stylesheet" href="stylesNight.css">
    <?php
        }
    ?>
</head>
<body>
    <?php


        if (!$_SESSION["isLogin"]) {
            header("Location: login.php");
        }

//        themeFunction();

        require_once 'userTestsArr.php';
    ?>
    <div class="header-line">
        <form action="changeTheme.php" method="POST">
            <input type="submit" name="light" value="🌞 Світла">
            <input type="submit" name="dark" value="🌙 Темна">
        </form>
    </div>
    <div class="container-profile">

        <div class="profile-container" style='max-width: 1000px'>
            <div class="profile-image">
                <img src="<?= (getAvatarPath($_SESSION["username"])) ?? 'img/profile-default.webp' ?>" alt="Фото користувача" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
            </div>
            <?= $_SESSION["imgErr"] ?? ''?>
            <?php unset($_SESSION["imgErr"]); ?>

            <?php if (isset($_SESSION["successufulLoad"]) && !$_SESSION["successufulLoad"]) { ?>
                <form class="imgForm" action="changeProfileImage.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="profileImage" id="">
                    <input type="submit" value="send">
                </form>
            <?php } else {?>
                <form action="profile.php" method="POST">
                    <input type="submit" name="deleteImg" value="Вибрати інше зображення">
                </form>
            <?php } ?>

            <h1>Данні про акаунт</h1>
            <div class="profile-info">
                <b>Ваш юзернейм: <?=  $_SESSION["username"] ?? 'невідома' ?></b> <br>
                <b>Ваша пошта: <?=  $newUsersArr[$_SESSION["username"]]["email"] ?? 'невідома' ?></b><br>
                <b>Ваш телефон: <?=  $newUsersArr[$_SESSION["username"]]["phone"] ?? 'невідомий' ?></b>
                <div class="btns">
                    <?php if ($newUsersArr[$_SESSION["username"]]["email"] != "admin") { ?>
                    <a class="start-test" href="index.php">Пройти тест</a>
                    <?php } ?>
                    <form action="logout.php" method="POST">
                        <input type="submit" name="logout" value="Вийти з акаунта" class="button">
                    </form>

                </div>
            </div>

            <?php if ($newUsersArr[$_SESSION["username"]]["email"] != "admin") { ?>

            <h2>Данні про проходження останнього тесту:</h2>


            <div class="test-info">

                <?php
                    if (isset($tests)) { ?>
                    <h3>Результати ваших тестів:</h3><br>
                    <table border style='width: 100%'>
                        <tr>
                            <th>Правильні відповіді</th>
                            <th>Відсоток правильних відповідей</th>
                            <th>Оцінка</th>
                            <th>Дата проходження</th>
                            <th>Час проходження</th>
                        </tr>
                    <?php
                    $bestTest = null;
                    $bestScore = -1;

                    foreach ($tests as $test) {
                        if ($test["score"] > $bestScore) {
                            $bestScore = $test["score"];
                            $bestTest = $test;
                        }
                    }
                    foreach ($tests as $test) {

                        $isBest = ($test === $bestTest) ? 'best-result' : '';
                        ?>
                        <tr class="test-result <?= $isBest ?>">
                            <td><?= $test["correctAnswers"] ?></td>
                            <td><?= $test["percentage"] ?> %.</td>
                            <td><?= $test["score"] ?> балів.</td>
                            <td> <?= $test["testDate"] ?></td>
                            <td><?= $test["testDuration"] ?></td>

                        </tr>
                        <?php
                    }
                    ?>
                    </table>

                <?php } else { ?>
                    <p>Немає даних про ваші тести</p>
                <?php } ?>
            </div>

            <?php } else { ?>
                <h2>Результати тестів усіх користувачів:</h2>
                <table border>
                    <tr>
                        <th>Аватар</th>
                        <th>Юзернейм</th>
                        <th>Пошта</th>
                        <th>Номер телефону</th>
                        <th>Правильні відповіді</th>
                        <th>Відсоток правильних відповідей</th>
                        <th>Оцінка</th>
                        <th>Дата проходження</th>
                        <th>Час проходження</th>
                        <th>Дія</th>
                    </tr>
                    <?php foreach ($newUsersArr as $user) {
                        if (!empty(getAllTests('csv/usersResults.csv', $user["username"]))) {
                            // searching of the best result
                            $bestTest = array_reduce(getAllTests('csv/usersResults.csv', $user["username"]), function ($best, $current) {
                                return ($best === null || $current['score'] > $best['score']) ? $current : $best;
                            });
                            ?>
                            <tr>
                                <td>
                                    <img src="<?= getAvatarPath($user["username"]) ?? "img/profile-default.webp" ?>"
                                         style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;"
                                         width="100px">
                                </td>
                                <td><?= $user["username"] ?></td>
                                <td><?= $user["email"] ?></td>
                                <td><?= $user["phone"] ?></td>
                                <td><?= $bestTest['correctAnswers'] ?></td>
                                <td><?= $bestTest['percentage'] ?>%</td>
                                <td><?= $bestTest['score'] ?> балів</td>
                                <td><?= $bestTest['testDate'] ?></td>
                                <td><?= $bestTest['testDuration'] ?></td>
                                <td>
                                    <form action="returnAllUserTestResults.php" method="POST">
                                        <button type="submit" name="submit" value="<?= $user["email"] ?>">Всі результати</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td><img src="<?= getAvatarPath($user["username"]) ?? "img/profile-default.webp" ?>"
                                         style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;"
                                         width="100px"></td>
                                <td><?= $user["username"] ?></td>
                                <td><?= $user["email"] ?></td>
                                <td><?= $user["phone"] ?></td>
                                <td colspan="6">Результати тестів відсутні</td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </table>

            <?php } ?>

        </div>
    </div>


</body>
</html>
