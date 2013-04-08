<?php
header("Content-Type: text/html; charset=utf-8");

$text = "e;ei | e;ei | e;ei | ә;ә | ә;ә | �< a >
<<名詞>>
pl. a's, as
『數學』第一已知數

< A >
<<形容詞>>
第一流的; 最高等的, 最好的, 優秀的

< a >
((不定冠詞))
1 一個 (泛指單數, 不特定的人事物)
  a region 一個地區
  a person 一個人
2 (放在表示數量的限定詞 few, many 之前)
  only a few of the voters 選民當中的一部份而已
  a bit more rest";


$text = str_replace('�', "\n", $text);
$rows = explode("\n", $text);
$meaning = array();
$count = 0;
foreach ($rows as $row) {
	if (preg_match("/^< /", $row)) {
		$meaning[$count] = $string;
		$count++;
		$string = $row;
	} else {
		$string .= $row . "\n";
	}
}