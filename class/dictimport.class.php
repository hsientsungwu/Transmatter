<?php
require $_SERVER['DOCUMENT_ROOT'] . "/config.php";

class DictImport {
	private $dict_name;
	private $dict_zip;
	private $dict_folder;
	private $dict_table;
	private $dict_info;
	private $dict_idx;
	private $dict_file;
	private $dict_type = 'stardict';
	private $directory;

	public function execute($zip = null, $name = null, $table = null) {
		
		$this->dict_zip = $_SERVER['DOCUMENT_ROOT'] . '/resources/import_zip/' . $zip;

		if (!file_exists($this->dict_zip)) return array('success' => false, 'message' => 'Zip file not found');

		if ($this->dict_zip && $table && $name) {
			$this->dict_folder = $_SERVER['DOCUMENT_ROOT'] . '/resources/import_dict/';
			$this->dict_table = $table;
			$this->dict_name = $name;

			if ($this->unzip()) {
				$this->dict_info = $this->dict_folder . str_replace('.zip', '', $zip) . '/' . $name . '.ifo';
				$this->dict_idx = $this->dict_folder . str_replace('.zip', '', $zip) . '/' . $name . '.idx';
				$this->dict_file = $this->dict_folder . str_replace('.zip', '', $zip) . '/' . $name . '.dict.dz';

				$result = $this->import();

				return array('success' => true, 'message' => 'Unzip successfully');
			} else {
				return array('success' => false, 'message' => 'Unable to perform unzip aciton');
			}
		} else {
			return 'Insufficient Information';
		}
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
		
		global $db;

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
			//echo $word."<br/>";

			// Read offset from index
			$start = unpack("I",strrev(gzread($fd_idx,4))); $start=$start[1];
			$len = unpack("I",strrev(gzread($fd_idx,4))); $len=$len[1];

			// Read article text
			gzseek($fd_dict,$start);
			$text = gzread ($fd_dict,$len);

			$data = array(
				"eng" => $word,
				"tc" => $text, 
				"sc" => ''
			);

			$db->insert($data, $this->dict_table);
			$count++;
		} while (!gzeof($fd_idx));
var_dump($count);
		gzclose($fd_idx);
		gzclose($fd_dict);
	}
}