<?php

require $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$dictimport = new StarDictImport();


$dictionaries = array(
	array(
		'name' => 'lazyworm-ce-big5',
		'zip' => 'stardict-lazyworm-ce-big5-2.4.2.zip',
		'table' => 'lazyworm-ce-big5',
		'version' => '2.4.2'
	),
);
/*
$dictionaries = array(
	array(
		'name' => 'eng-ch-eng-buddhist',
		'zip' => 'stardict-eng-ch-eng-buddhist-2.4.2.zip',
		'table' => 'eng-ch-eng-buddhist',
		'version' => '2.4.2'
	),
	array(
		'name' => 'xdict-ce-utf8',
		'zip' => 'stardict-xdict-ce-utf8-2.4.2.zip',
		'table' => 'xdict-ce-utf8',
		'version' => '2.4.2'
	),
	array(
		'name' => 'langdao-ce-big5',
		'zip' => 'stardict-langdao-ce-big5-2.4.2.zip',
		'table' => 'langdao-ce-big5',
		'version' => '2.4.2'
	),
	array(
		'name' => 'lazyworm-ce-big5',
		'zip' => 'stardict-lazyworm-ce-big5-2.4.2.zip',
		'table' => 'lazyworm-ce-big5',
		'version' => '2.4.2'
	),
);
*/
foreach ($dictionaries as $index => $dict) {
	$result[$index]['import'] = $dictimport->execute($dict['zip'], $dict['name'], $dict['table'], $dict['version']);
	$dictimport->close();
}

print_r($result);
