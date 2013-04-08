<?php

require $_SERVER['DOCUMENT_ROOT'] . '/class/dictimport.class.php';

$dictimport = new DictImport();

$zip = 'stardict-cdict-big5-2.4.2.zip';
$folder = 'stardict-cdict-big5-2.4.2';
$table = 'stardict-cdict-big5-2.4.2';

$result = $dictimport->execute($zip, 'cdict-big5', 'cdict-big5');

var_dump($result);