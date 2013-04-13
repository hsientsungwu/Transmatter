<?php
// configuration
require_once($_SERVER['DOCUMENT_ROOT'] . '/../configs/master_config.php');

// special functions
require_once($_SERVER['DOCUMENT_ROOT'] . '/common/chinese.convert.php');

// common functions
require_once($_SERVER['DOCUMENT_ROOT'] . '/common/crawler.func.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/common/import.func.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/common/db.func.php');

function __autoload($className) { 
	$classRoot = $_SERVER['DOCUMENT_ROOT'] . '/class/';
	
	// classes
	$class['dbMysqli']   = $classRoot . 'dbMysqli.class.php';
	$class['Dict']       = $classRoot . 'dict.class.php';
	$class['DictImport'] = $classRoot . 'dictimport.class.php';
	$class['DictSearch'] = $classRoot . 'dictsearch.class.php';

    if (file_exists($class[$className])) {
          require_once $class[$className]; 
          return true; 
    } 
      
    return false; 
}

$mysql = new MysqlSetting();
$dbFacile = new dbMysqli();
$dbFacile->open($mysql->database, $mysql->username, $mysql->password, $mysql->host);