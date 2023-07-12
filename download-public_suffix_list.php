<?php

exit;

$text = file_get_contents("https://publicsuffix.org/list/public_suffix_list.dat");

$lines = explode("\n", $text);
$array = [];

foreach ($lines as $line) {
    $line = trim($line);
    if ($line !== '' && strpos($line, '//') !== 0) {
        $array[] = $line;
    }
}

$jsonData = json_encode($array, JSON_PRETTY_PRINT);
$file = 'public_suffix_list.json';

if (file_put_contents($file, $jsonData)) {
    echo 'JSON file has been successfully saved.';
} else {
    echo 'Error occurred while saving JSON file.';
}

?>
