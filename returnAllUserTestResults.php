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
            }

            echo "<table border>";
            echo "<tr>";
            echo "<th>Правильні відповіді</th>";
            echo "<th>Відсоток правильних відповідей</th>";
            echo "<th>Оцінка</th>";
            echo "<th>Дата проходження</th>";
            echo "<th>Час проходження</th>";
            echo "</tr>";
            foreach ($tests as $test) {

                $tableStyle = ($test["percentage"] == $bestPercentage) ? 'style="background-color: yellow;"' : '';
                echo "<tr $tableStyle>";
                echo '<td>' . $test["correctAnswers"] . '</td>';
                echo '<td>' . $test["percentage"] . ' %</td>';
                echo '<td>' . $test["score"] . ' балів</td>';
                echo '<td>' . $test["testDate"] . '</td>';
                echo '<td>' . $test["testDuration"] . '</td>';
                echo '</tr>';
            }
            echo "</table>";
        }
    }
}
echo "<a href='profile.php'>Назад у профіль</a>";
