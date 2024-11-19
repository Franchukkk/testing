

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
</head>
<body>
    <?php
        session_start();
        require_once 'createUsersArr.php';
        require_once 'themeFunction.php';
        themeFunction();
    ?>
    <div class="header-line">
        <form action="changeTheme.php" method="POST">
    <!--        <input type="hidden" name="current_file" value="--><?php //echo htmlspecialchars($_SERVER['PHP_SELF']); ?><!--">-->
            <input type="submit" name="light" value="🌞 Світла">
            <input type="submit" name="dark" value="🌙 Темна">
        </form>
    </div>
    <div class="container-profile">

        <div class="profile-container">
            <div class="profile-image">
                <img src="<?= $newUsersArr[$_SESSION["username"]]['imagePath'] ?? 'img/profile-default.webp' ?>" alt="Фото користувача" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
            </div>
            <?= $_SESSION["imgErr"] ?? ''?>
            <?php unset($_SESSION["imgErr"]); ?>

            <?php if (isset($_SESSION["successufulLoad"]) && !$_SESSION["successufulLoad"]) { ?>
                <form class="imgForm" action="changeProfileImage.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="profileImage" id="">
                    <input type="submit" value="send">
                </form>
            <?php } else {?>
                <form action="deleteProfileImg.php" method="POST">
                    <input type="submit" name="deleteImg" value="Вибрати інше зображення">
                </form>
            <?php } ?>

            <h1>Данні про акаунт</h1>
            <div class="profile-info">
                <b>Ваш юзернейм: <?=  $_SESSION["username"] ?? 'невідома' ?></b> <br>
                <b>Ваша пошта: <?=  $newUsersArr[$_SESSION["username"]]["email"] ?? 'невідома' ?></b>
                <div class="btns">
                    <a class="start-test" href="index.php">Пройти тест</a>
                    <form action="logout.php" method="POST">
                        <input type="submit" name="logout" value="Вийти з акаунта" class="button">
                    </form>

                </div>
            </div>



            <h2>Данні про проходження останнього тесту:</h2>
            <?php

            function getAllTests($file, $email) {
                if (!file_exists($file)) return null;

                $results = [];
                foreach (file($file) as $line) {
                    $data = str_getcsv($line);
                    if ($data[1] === $email) {
                        for ($i = 3; $i < count($data); $i++) {
                            if (isset($data[$i])) {
                                $testResult = json_decode(trim($data[$i], '"'), true);
                                if ($testResult) {
                                    $results[] = $testResult;
                                }
                            }
                        }
                        break;
                    }
                }

                return $results;
            }
            var_dump ($newUsersArr);
            $tests = getAllTests('csv/users.csv', $newUsersArr[$_SESSION["username"]]["email"]);

            ?>

            <div class="test-info">
                <?php if ($tests) { ?>
                    <h3>Результати ваших тестів:</h3><br>
                    <?php foreach ($tests as $test) { ?>
                        <div class="test-result">
                            <p>Ви відповіли правильно на <?= $test["correctAnswers"] ?> із 10 питань.</p>
                            <p>Відсоток правильних відповідей: <?= $test["percentage"] ?> %.</p>
                            <p>Оцінка: <?= $test["score"] ?> балів.</p>
                            <p>Дата проходження тесту: <?= $test["testDate"] ?></p>
                            <p>Час проходження тесту: <?= $test["testDuration"] ?></p>
                            <br>
                            <hr>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p>Немає даних про ваші тести</p>
                <?php } ?>
            </div>


        </div>
    </div>


</body>
</html>
