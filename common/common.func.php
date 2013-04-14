<?php

function getDefaultDictionaries($type = TranslationType::CHTOENG) {
	global $dbFacile;

	$dictionaries = $dbFacile->fetchRows('SELECT id, name, table_name, format FROM Dictionary WHERE type = ?', array($type));

	return $dictionaries;
}