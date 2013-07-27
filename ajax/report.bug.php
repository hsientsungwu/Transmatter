<?php

if (!$_POST['rel']) {
	echo 'Error occured.';
	die;
}

require $_SERVER['DOCUMENT_ROOT'] . "/config.php";

$raw = explode('-', $_POST['rel']);

if ($raw[0] && is_numeric($raw[1])) {
	$table = $raw[0];
	$wordId = $raw[1];

	$data = array('table' => $table, 'word_id' => $wordId, 'status' => 'pending');

	$result = $dbFacile->insert($data, 'word_bug');

	if ($result) {
		echo '錯誤已提交，感謝您的提報，請繼續支持本服務！';
	} else {
		echo '很抱歉，系統錯誤，錯誤無法提報';
	}
}

die;