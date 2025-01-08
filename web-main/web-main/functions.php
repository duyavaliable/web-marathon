<?php
$filename = 'studentlist.csv';

if (!file_exists($filename)) {
    $header = ["studentID", "name", "gender", "birth_date"];
    $file = fopen($filename, 'w');
    fputcsv($file, $header);
    fclose($file);
}


function isUniqueID($studentID)
{
    global $filename;
    if (($handle = fopen($filename, "r")) !== FALSE) {
        fgetcsv($handle, 1000, ","); 
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[0] === $studentID) {
                fclose($handle);
                return false;
            }
        }
        fclose($handle);
    }
    return true;
}

function addStudent($data)
{
    global $filename;
    $file = fopen($filename, 'a');
    fputcsv($file, $data);
    fclose($file);
}


function deleteStudent($studentID)
{
    global $filename;
    $rows = array_map('str_getcsv', file($filename));
    $header = array_shift($rows);

    $updatedRows = array_filter($rows, function ($row) use ($studentID) {
        return $row[0] !== $studentID;
    });

    
    usort($updatedRows, function ($a, $b) {
        return $a[0] <=> $b[0];
    });

    $file = fopen($filename, 'w');
    fputcsv($file, $header);
    foreach ($updatedRows as $row) {
        fputcsv($file, $row);
    }
    fclose($file);
}
?>
