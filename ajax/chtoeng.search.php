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

		$resultString .= '<div class="row"><div class="small-6 columns small-centered dictionaryList"><p class="result-title"><span><b>Source: ' . $index. '</b></span></p><p class="result-definition">';

		foreach ($eng as $index => $meaning) {
			$resultString .= '' . $meaning . ';&nbsp&nbsp&nbsp';
		}

		$resultString .= '</p>';
		$resultString .= '<p id="ce_' . $index . '-' . $result['id'] .'"><a class="reportbug" rel="ce_' . $index . '-' . $result['id'] .'" href="#">Report a bug</a></p>';
		$resultString .= '</div></div>';
	}
} else {
	$resultString .= '<div class="large-6 columns large-centered"><label>No result found.</label></div>';
}

echo $resultString;
die; 