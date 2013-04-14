<?php

function getCSVForCedict() {
	header("Content-Type: text/html; charset=utf-8");
	ini_set('error_reporting', E_ALL);

	$filepath = "/resources/cedict.txt";

	$opts = array( 
	        'http' => array( 
	            'method'=>"GET", 
	            'header'=>"Content-Type: text/html; charset=utf-8" 
	        ) 
	    ); 

	$context = stream_context_create($opts); 

	if (file_exists($filepath)) {
	    //echo "The file $filepath exists";
	} else {
	    //echo "The file $filepath does not exist";
	}

	$wordsArray = array();

	$file_handle = fopen($filepath, "r");

	while (!feof($file_handle)) {
	   $line = fgets($file_handle);
	   $wordsArray[] = $line;
	}
	fclose($file_handle);

	$count = 0;

	$formattedWord = array();

	foreach ($wordsArray as $lineOfWord) { 
		$word = array();

		$splitWord = explode(' ', $lineOfWord);

		$word['tc'] = $splitWord[0];
		$word['sc'] = $splitWord[1];

		$splitWord = explode('/', $lineOfWord);

		for ($i = 1; $i < count($splitWord)-1; $i++) {
			$word['eng'][] = $splitWord[$i];
		}

		$formattedWord[] = $word;
		$count++;
	}

	$headers = "tc, sc, eng";
	$num = 0;
	$file = '';
	$file = '"' . str_replace(',', '","', $headers) . '"';
	$file .= "\r\n";

	foreach ($formattedWord as $post) {
		$post['tc'] = str_replace("\"", "'", $post['tc']);
		$post['sc'] = str_replace("\"", "'", $post['tc']);

		$data = array($post['tc'], $post['sc']);

		foreach ($post['eng'] as $index => $eng) {
			$post['eng'][$index] = str_replace("\"", "'", $eng);
		}

		$data[] = json_encode(($post['eng']));

		$file .= '%' . implode('%,%', $data) . '%';
		$file .= "$$";

		$num++;
	}

	header('Cache-Control: public');
	header("Pragma: public");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
	header('Content-Encoding: UTF-8');
	header('Content-type: text/csv; charset=UTF-8');
	header("Content-Disposition: attachment; filename=\"dictionary.csv\"");
	print("\xEF\xBB\xBF" . $file);
}

function crawlCdictWeb($key) {
	if ($key == '') die;

	header("Content-Type: text/html; charset=utf-8");

	$url = "http://cdict.net/?q={$key}";

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("content-type: application/x-www-form-urlencoded; charset=UTF-8"));
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

			return $sources;
		}
	}

	return false;
}