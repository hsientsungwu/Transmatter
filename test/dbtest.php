<?php
header("Content-Type: text/html; charset=utf-8");

require $_SERVER['DOCUMENT_ROOT'] . "/config.php";
/*
$query = "SET NAMES 'utf8'";

$db->ExecuteSQL($query);
*/
$query = "SELECT * FROM ce WHERE tc LIKE '%A%'";

$results = $db->ExecuteSQL($query);

print_r($results);