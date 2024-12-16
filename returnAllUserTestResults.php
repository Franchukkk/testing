<?php
session_start();

require_once "getAllTestsFunction.php";
require_once "profileDataPreparation.php";
require_once 'getAllTestsFunction.php';

if (isset($_POST["submit"])) {
    // creating a table with all users's testing results
    foreach ($newUsersArr as $user) {
        if ($user["email"] == $_POST["submit"]) {
            $tests = getAllTests("csv/usersResults.csv", $user["username"]);

            $bestPercentage = 0;
            foreach ($tests as $test) {
                if ($test["percentage"] > $bestPercentage) {
                    $bestPercentage = $test["percentage"];
                }
            } ?>

            <table border>
                <tr>
                    <th>Правильні відповіді</th>
                    <th>Відсоток правильних відповідей</th>
                    <th>Оцінка</th>
                    <th>Дата проходження</th>
                    <th>Час проходження</th>
                </tr>
            <?php
            foreach ($tests as $test) {
            ?>
                <tr <?= ($test["percentage"] == $bestPercentage) ? 'style="background-color: yellow;"' : '' ?>>
                <td> <?= $test["correctAnswers"] ?></td>
                <td> <?= $test["percentage"] ?> %</td>
                <td> <?= $test["score"] ?> балів</td>
                <td> <?= $test["testDate"] ?></td>
                <td> <?= $test["testDuration"] ?></td>
                </tr>
            <?php
            }

        }
    }
}
?>
</table>
<a href='profile.php'>Назад у профіль</a>

