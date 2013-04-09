<?php
require $_SERVER['DOCUMENT_ROOT'] . "/config.php";

class DictSearch {

	protected $key = '';
	protected $encodingType = 'tc';
	protected $results = array();
	protected $searchTypes = array();

	public function search($key) {
		if (!$key || strlen($key) == 0) return array('success' => false, 'message' => 'Invalid search key');

		$this->key = $key;

		if (empty($this->searchTypes)) $this->getDefaultSearchTypes();

		if (count($this->searchTypes)) {
			foreach ($this->searchTypes as $table) {
				$result = $this->getResult($table);
			}
		}
	}

	public function setSearchTypes($types) {
		if (is_array($types)) {
			$this->searchTypes = $types;
		}
	}

	public function addSearchType($type) {
		if (is_string($type)) {
			$this->searchTypes[] = $type;
		}
	}

	private function getSearchKeyEncoding($text) {
		/* Credit to Mark Baker from http://stackoverflow.com/users/324584/mark-baker */
		$test1 = iconv("UTF-8", "big5//TRANSLIT", $text);
		$test2 = iconv("UTF-8", "big5//IGNORE", $text);
		if ($test1 == $test2) {
		   $this->encodingType = 'tc';
		} else {
		   $test3 = iconv("UTF-8", "gb2312//TRANSLIT", $text);
		   $test4 = iconv("UTF-8", "gb2312//IGNORE", $text);
		   if ($test3 == $test4) {
		      $this->encodingType = 'sc';
		   } else {
		      $this->encodingType = 'eng';
		   }
		}
	}

	private function getResult($table) {
		global $db;

		$query = "SELECT * FROM {$table} WHERE tc = {$this->key}";
		$results = $db->ExecuteSQL($query);

		if ($results && count($results) && is_array($results)) {

			$formatResult = array();

			foreach ($results as $result) {
				$formatResult[$table][] = $result['eng'];
			}
		}
	}

	private function getDefaultSearchTypes() {
		global $db;

		$types = $db->Select('Dictionary');

		foreach ($types as $type) {
			$this->searchTypes[] = $types['name'];
		}
	}
}