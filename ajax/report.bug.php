<?php

if (!$_POST['rel']) {
	echo 'Error occured.';
	die;
}

header("Content-Type: text/html; charset=utf-8");
require $_SERVER['DOCUMENT_ROOT'] . "/config.php";

$raw = explode('-', $_POST['rel']);

if ($raw[0] && is_numeric($raw[1])) {
	$table = $raw[0];
	$wordId = $raw[1];

	$data = array('table' => $table, 'word_id' => $wordId, 'status' => 'pending');

	$result = $dbFacile->insert($data, 'word_bug');

	if ($result) {
		echo 'Bug reported. Thank you for your input';
	} else {
		echo 'Error occured. ';
	}
}

die;