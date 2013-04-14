<?php

function searchForEnglish($key, $dictionaries = array()) {
	if (!$key || strlen($key) == 0) return false;

	global $dbFacile;
	$dbFacile->execute('set names utf8');
	$dictionaries = (!empty($dictionaries) ? $dictionaries : getDefaultDictionaries(TranslationType::CHTOENG));

	$dataResult = array();

	foreach ($dictionaries as $dictionary) {
		$result = $dbFacile->fetchRow('SELECT id, eng FROM `' . $dictionary['table_name'] . '` WHERE `tch` = ?', array($key));

		if (!empty($result)) {
			$dataResult[$dictionary['name']]['format'] = $dictionary['format'];
			$dataResult[$dictionary['name']]['english'] = $result['eng'];
			$dataResult[$dictionary['name']]['id'] = $result['id'];
		}
	}

	return $dataResult;
}

function searchForEnglishAutocomplete($key, $dictionaries = array()) {
	if (!$key || strlen($key) == 0) return false;

	global $dbFacile;
	$dbFacile->execute('set names utf8');
	$dictionaries = (!empty($dictionaries) ? $dictionaries : getDefaultDictionaries(TranslationType::CHTOENG));

	$dataResult = array();

	foreach ($dictionaries as $index => $dictionary) {
		$results = $dbFacile->fetchRows('SELECT id, tch FROM `' . $dictionary['table_name'] . '` WHERE `tch` LIKE ?', array('%'.$key.'%'));

		if (!empty($results)) {
			foreach ($results as $result) {
				$dataResult[$index]['id'] = $dictionary['id'];
				$dataResult[$index]['table'] = $dictionary['table_name'];
				$dataResult[$index]['tch'] = $result['tch']; 
			}
		}
	}

	return $dataResult;
}