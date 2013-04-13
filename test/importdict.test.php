<?php

require $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$dictimport = new DictImport();

$dictionaries = array(
	array(
		'name' => 'xdict-ce-utf8',
		'zip' => 'stardict-xdict-ce-utf8-2.4.2.zip',
		'table' => 'xdict-ce-utf8',
		'version' => '2.4.2'
	),
);

foreach ($dictionaries as $index => $dict) {
	$result[$index]['import'] = $dictimport->execute($dict['zip'], $dict['name'], $dict['table'], $dict['version']);
	$dictimport->close();
}

print_r($result);
