<?php
header("Content-Type: text/html; charset=utf-8");

$_POST['key'] = 'test';

if ($_POST['key'] == '') {
	echo ''; 
	die;
} 

$key = $_POST['key'];

$url = "http://cdict.net/?q={$key}";

$ch = curl_init($url);
$this_header = array("content-type: application/x-www-form-urlencoded; charset=UTF-8");

curl_setopt($ch, CURLOPT_HTTPHEADER, $this_header);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER,0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$html = curl_exec($ch);
curl_close($ch);

$doc = new DOMDocument();
$doc->loadHTML($html);

$pre = $doc->getElementsByTagName('pre');

if ($pre) {
	if ($pre->item(0)) {
		$sources = explode('資料來源', $pre->item(0)->nodeValue);
		var_dump($sources);
		die;
	}
} 

echo '';
die;