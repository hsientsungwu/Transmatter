<?php
header("Content-Type: text/plain; charset=UTF-8"); 

class StarDictImport {
	private $dict_name;
	private $dict_zip;
	private $dict_folder;
	private $dict_table;
	private $dict_info;
	private $dict_idx;
	private $dict_file;
	private $dict_type = 'ce';
	private $version;

	public function execute($zip = null, $name = null, $table = null, $version = null) {

		$this->dict_zip = $_SERVER['DOCUMENT_ROOT'] . '/resources/import_zip/' . $zip;

		if (!file_exists($this->dict_zip)) return array('success' => false, 'message' => 'Zip file not found');

		if ($this->dict_zip && $table && $name) {
			// Assign parameters to class variable
			$this->dict_folder = $_SERVER['DOCUMENT_ROOT'] . '/resources/import_dict/';
			$this->dict_table = $table;
			$this->dict_name = $name;
			$this->version = $version;

			// Perform unzip 
			if ($this->unzip()) {
				//  assign dictionary files
				$this->dict_info = $this->dict_folder . str_replace('.zip', '', $zip) . '/' . $name . '.ifo';
				$this->dict_idx  = $this->dict_folder . str_replace('.zip', '', $zip) . '/' . $name . '.idx';
				$this->dict_file = $this->dict_folder . str_replace('.zip', '', $zip) . '/' . $name . '.dict.dz';

				if (!$this->isTableExists()) $this->createImportTable();

				$result = $this->import();

				if ($result != 0) {
					$this->addToDictionary();
					return array('success' => true, 'message' => 'Total of ' . $result . ' records imported');
				} else {
					return array('success' => true, 'message' => 'Unzip successfully but failed to import');
				}
			} else {
				return array('success' => false, 'message' => 'Unable to perform unzip aciton');
			}
		} else {
			return 'Insufficient Information';
		}
	}

	public function close () {
		$this->dict_name = '';
		$this->dict_zip = '';
	 	$this->dict_folder = '';
	 	$this->dict_table = '';
	 	$this->dict_info = '';
	 	$this->dict_idx = '';
	 	$this->dict_file = '';
	}

	protected function unzip() {
		if (!is_dir($this->dict_folder)) {
		    mkdir($this->dict_folder);
		}

		$zipArchive = new ZipArchive();
		$result = $zipArchive->open($this->dict_zip);
		
		if ($result === TRUE) {
		    $zipArchive ->extractTo($this->dict_folder);
		    $zipArchive ->close();
		    return true;
		} else {
		    return false;
		}
	}

	protected function import() {
		if (!file_exists($this->dict_info)) return false;
		if (!file_exists($this->dict_idx)) return false;
		if (!file_exists($this->dict_file)) return false;

		global $dbFacile;
		$dbFacile->execute('set names utf8');

		$idx_file = $this->dict_idx;
		$info_file = $this->dict_info;
		$dict_file = $this->dict_file;

		$dic_info = array();
		foreach(file($info_file) as $v) {
			$v = split("=",trim($v));
			if ($v[0] == "bookname") $dic_info["fcaption"] = trim($v[1]);
			if ($v[0] == "sametypesequence") $dic_info["fmarkup"] = $v[1];
			if ($v[0] == "description") $dic_info["fcomment"] = $v[1];
		}

		$fd_idx = gzopen($idx_file,"rb");
		$fd_dict = gzopen($dict_file,"rb");
		$count = 0;

		do {
			// Read until \0
			$word = ""; 
			$max_word = 255;

			while (true) {
				$ch = gzread($fd_idx,1);
				if ($ch == "\0" || gzeof($fd_idx) || $max_word-- <= 0) break;
				$word .= $ch;
			}

			// Read offset from index
			$start = @unpack("I",strrev(gzread($fd_idx,4))); $start=$start[1];
			$len = @unpack("I",strrev(gzread($fd_idx,4))); $len=$len[1];

			// Read article text
			gzseek($fd_dict,$start);
			$text = @gzread($fd_dict,$len);

			if ($this->dict_name == 'eng-ch-eng-buddhist') {
				$word = $this->formatText($word);

				$data = array(
					"tch" => $text,
					"eng" => $word,
				);
			} else {
				$text = $this->formatText($text);

				$data = array(
					"tch" => $word,
					"eng" => $text,
				);
			}
				
			$dbFacile->insert($data, $this->dict_type . '_' .$this->dict_table);
			$count++;
		} while (!gzeof($fd_idx));

		gzclose($fd_idx);
		gzclose($fd_dict);

		return $count;
	}

	protected function formatText($text) {
		if ($this->dict_name) {
			$result = explode("\n", $text);
			return json_encode($result);
		}

		return $text;
	}

	protected function isTableExists() {
		global $dbFacile;

		$result = $dbFacile->fetchCell('SELECT COUNT(*) as count FROM information_schema.tables WHERE table_name = ?', array($this->dict_table.'_'.$this->dict_table));

		return ($result >= 1 ) ? true : false;
	}

	protected function createImportTable() {
		global $dbFacile;

		$query = 
			"CREATE TABLE  `hwu1986_translation`.`" . $this->dict_type . "_" .  $this->dict_table ."` (
			`id` INT( 25 ) NOT NULL AUTO_INCREMENT ,
			`tch` VARCHAR( 256 ) CHARACTER SET utf8 NOT NULL ,
			`eng` VARCHAR( 256 ) COLLATE utf8_unicode_ci NOT NULL ,
			PRIMARY KEY (  `id` )
			) ENGINE = MYISAM DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;";
	
		$dbFacile->execute($query);
	}

	protected function addToDictionary() {
		global $dbFacile;

		$result = $dbFacile->fetchRow('SELECT * FROM Dictionary WHERE name = ?', array($this->dict_name));

		if ($result) {
			$data = array(
				'version' => $this->version,
				'imported_date' => date('Y-m-d H:i:s')
			);

			$dbFacile->update($data, 'dictionary');
		} else {
			$data = array(
				'name' => $this->dict_table,
				'table_name' => $this->dict_type . "_" . $this->dict_table,
				'version' => $this->version,
				'type' => TranslationType::CHTOENG,
				'created_date' => date('Y-m-d H:i:s'),
				'imported_date' => date('Y-m-d H:i:s')
			);

			$dbFacile->insert($data, 'Dictionary');
		}
	}
}