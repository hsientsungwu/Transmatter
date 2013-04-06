<?php

//header("Content-Type: text/html; charset=utf-8");
header("Content-Type: text/plain; charset=UTF-8"); 
ini_set('error_reporting', E_ALL);

$filepath = $_SERVER['DOCUMENT_ROOT'] . "/resources/newtaodict.txt";

$opts = array( 
        'http' => array( 
            'method'=>"GET", 
            'header'=>"Content-Type: text/plain; charset=utf-8" 
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

	$splitWord = explode('|', $lineOfWord);
	if (strlen(trim($splitWord[0])) == 0) continue;
	if (!isset($splitWord[1])) continue;
	
	$word['tc'] = $splitWord[0];
	$word['sc'] = ' ';
	$word['eng'] = $splitWord[1];

	$formattedWord[] = $word;
	$count++;
}

$num = 0;
$file = '';

foreach ($formattedWord as $post) {
	$post['eng'] = str_replace("\"", "", $post['eng']);
	$post['tc'] = trim($post['tc']);
	$post['eng1'][] = str_replace(array("\r\n", "\r", "\n"), "", $post['eng']);
	$data = array($post['tc'], $post['sc'], json_encode($post['eng']));

	$file .= '%'.$num.'%,%'.$post['tc'].'%,%%,%'.json_encode($post['eng1']).'%'."$$";

	//$file .= '%' . implode('%,%', $data) . '%';
	//$file .= "";

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
