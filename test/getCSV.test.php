<?php

	require $_SERVER['DOCUMENT_ROOT'] . "/config.php";

	ini_set('error_reporting', E_ALL);

	$filepath = $_SERVER['DOCUMENT_ROOT'] . "/resources/import_txt/cedict.txt";

	$opts = array( 
	        'http' => array( 
	            'method'=>"GET", 
	            'header'=>"Content-Type: text/html; charset=utf-8" 
	        ) 
	    ); 

	$context = stream_context_create($opts); 

	if (file_exists($filepath)) {
	   // echo "The file $filepath exists";
	} else {
	    ///	echo "The file $filepath does not exist";
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

		$word['tch'] = $splitWord[0];

		$splitWord = explode('/', $lineOfWord);

		for ($i = 1; $i < count($splitWord)-1; $i++) {
			$word['eng'][] = $splitWord[$i];
		}

		$formattedWord[] = $word;
		$count++;
	}

	$headers = "tch, eng";
	$num = 0;
	$file = '';
	$file = '"' . str_replace(',', '","', $headers) . '"';
	$file .= "\r\n";

	foreach ($formattedWord as $post) {
		$post['tch'] = str_replace("\"", "'", $post['tch']);

		//$data = array($post['tch']);

		foreach ($post['eng'] as $index => $eng) {
			$post['eng'][$index] = str_replace("\"", "'", $eng);
		}

		$data = array(
			'tch' => $post['tch'],
			'eng' => json_encode($post['eng'])
		);

		$dbFacile->insert($data, 'ce_cedict-utf8');
		//$data[] = json_encode(($post['eng']));

		/*
		$file .= '%' . implode('%,%', $data) . '%';
		$file .= "$$";
		*/
		$num++;
	}
/*
	header('Cache-Control: public');
	header("Pragma: public");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
	header('Content-Encoding: UTF-8');
	header('Content-type: text/csv; charset=UTF-8');
	header("Content-Disposition: attachment; filename=\"dictionary.csv\"");
	print("\xEF\xBB\xBF" . $file);
*/
