<?php
require_once 'csvfunctions.php';

//returns all test results of a specific user by email
function getAllTests($file, $email) {
    $csvData = readCsv($file);
    if (empty($csvData)) return null;

    $results = [];

    foreach ($csvData as $data) {
        if ($data[0] == $email) {
            for ($i = 1; $i < count($data); $i++) {
                if (isset($data[$i])) {
                    $testResult = json_decode(trim($data[$i], '"'), true);
                    if (isset($testResult) && is_array($testResult)) {
                        foreach ($testResult as $key => $value) {
                            if (is_array($value)) {
                                $results[] = $value;
                            }
                        }
                    }
                }
            }
            break;
        }
    }

    return $results;
}
?>

