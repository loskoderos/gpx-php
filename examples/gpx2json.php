<?php

use LosKoderos\GPX\GPXReader;

require '../vendor/autoload.php';

if (!isset($argv[1])) {
    echo "Dump GPX contents to prettified JSON\n";
    echo "Usage: php gpx2json.php <path/to/file.gpx>\n";
    exit(-1);
}

$reader = new GPXReader();
$gpx = $reader->readFromFile($argv[1]);
echo json_encode($gpx->toArray(), JSON_PRETTY_PRINT)."\n";
