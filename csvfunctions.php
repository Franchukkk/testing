<?php

// function of writing some data in csv file
function writeCsv($fileName, $data, $mode = "a") {
    $csvFile = fopen($fileName, $mode);
    $is2dArray = true;
    foreach ($data as $row) {
        if (is_array($row)) {
            fputcsv($csvFile, $row);
        } else {
            $is2dArray = false;
        }
    }
    if (!$is2dArray) {
        fputcsv($csvFile, $data);
    }
    fclose($csvFile);
}

// function of reading a csv file and returning it's data
function readCsv($fileName, $mode = "r") {
    $data = [];
    try {
        if (!file_exists($fileName)) {
            throw new Exception("File does not exist: $fileName");
        }

        $csvFile = fopen($fileName, $mode);
        while (($line = fgetcsv($csvFile)) !== false) {
            $data[] = $line;
        }

        fclose($csvFile);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    return $data;
}
