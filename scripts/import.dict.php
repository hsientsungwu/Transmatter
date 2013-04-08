<?php

require $_SERVER['DOCUMENT_ROOT'] . '/class/dictimport.class.php';
header("Content-Type: text/html; charset=utf-8");

$dictionaries = array(
	array(
		'zip' => 'stardict-cdict-big5-2.4.2.zip',
		'name' => 'cdict-big5',
		'table' => 'cdict-big5'
	),
);

$dictimport = new DictImport();

foreach ($dictionaries as $dict) {
	$result = $dictimport->execute($dict['zip'], $dict['name'], $dict['table']);

	echo '<p><label>' . $dict['zip'] . '</label><br/>';
	echo '<label>Status : ' . ($result['success'] ? 'Success' : 'Failed') . '</label><br/>'; 
	echo '<label>Message : ' . $result['message'] . '</label></p>';
}
