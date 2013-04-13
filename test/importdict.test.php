<?php

require $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$dictimport = new DictImport();

$dictionaries = array(
	array(
		'name' => 'cdict-big5',
		'zip' => 'stardict-cdict-big5-2.4.2.zip',
		'table' => 'cdict-big5',
		'version' => '2.4.2'
	),
);

foreach ($dictionaries as $index => $dict) {
	$result[$index]['import'] = $dictimport->execute($dict['zip'], $dict['name'], $dict['table']);
	$dictimport->close();
}

print_r($result);
