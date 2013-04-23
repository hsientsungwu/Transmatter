<?php

function searchForEnglish($key, $dictionaries = array()) {
	if (!$key || strlen($key) == 0) return false;

	global $dbFacile;
	$dictionaries = (!empty($dictionaries) ? $dictionaries : getDefaultDictionaries(TranslationType::CHTOENG));

	$dataResult = array();

	foreach ($dictionaries as $dictionary) {
		$result = $dbFacile->fetchRow('SELECT id, eng FROM `' . $dictionary['table_name'] . '` WHERE `tch` = ?', array($key));

		if (!empty($result)) {
			$dataResult[$dictionary['display_name']]['format'] = $dictionary['format'];
			$dataResult[$dictionary['display_name']]['english'] = $result['eng'];
			$dataResult[$dictionary['display_name']]['id'] = $result['id'];
		}
	}

	return $dataResult;
}

function searchForEnglishAutocomplete($key, $dictionaries = array()) {
	if (!$key || strlen($key) == 0) return false;

	global $dbFacile;
	$dictionaries = (!empty($dictionaries) ? $dictionaries : getDefaultDictionaries(TranslationType::CHTOENG));

	$dataResult = array();
	$searchedWords = array();
	foreach ($dictionaries as $index => $dictionary) {
		$results = $dbFacile->fetchRows('SELECT tch FROM `' . $dictionary['table_name'] . '` WHERE `tch` LIKE ? ORDER BY `tch` ASC LIMIT 20', array($key.'%'));

		if (count($results) > 0) {
			foreach ($results as $result) { 
				if (!in_array($result['tch'], $searchedWords)) {
					$dataResult[]['tch'] = $result['tch']; 
					$searchedWords[] = $result['tch'];
				}
			}
		}
	}

	return $dataResult;
}