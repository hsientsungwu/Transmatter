<?php

if (!$_POST['chtoeng'] && $key != '') exit;

require $_SERVER['DOCUMENT_ROOT'] . "/config.php";

$key = mysql_escape_string($key);

$resultString = '<div class="large-12 columns large-centered searchKey"><h2>' . $key . '</h2></div>';

$results = searchForEnglish($key);

if (count($results) > 0) {
	foreach ($results as $index => $result) {
		if (empty($result)) continue;

		$eng = $result['english'];

		if ($result['format'] == DictionaryFormat::JSON) {
			$eng = json_decode($eng);
		}

		$resultString .= '<div class="small-4 columns dictionaryList">Source: <span>' . $index. '</span><ul>';

		foreach ($eng as $meaning) {
			$resultString .= '<li>' . $meaning . '</li>';
		}

		$resultString .= '</ul>';
		$resultString .= '<p id="ce_' . $index . '-' . $result['id'] .'"><a class="reportbug" rel="ce_' . $index . '-' . $result['id'] .'" href="#">Report a bug</a></p>';
		$resultString .= '</div>';
	}
} else {
	$resultString .= '<div class="large-6 columns large-centered"><label>No result found.</label></div>';
}

echo $resultString;
die; 