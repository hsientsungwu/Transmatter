<?php
header("Content-Type: text/html; charset=utf-8");

require $_SERVER['DOCUMENT_ROOT'] . "/config.php";
/*
$query = "SET NAMES 'utf8'";

$db->ExecuteSQL($query);
*/
$query = "SELECT * FROM ce WHERE tc LIKE '%我%'";

$results = $db->ExecuteSQL($query);
?>

<html>
	<head>
		<title>Steve's Autocomplete Dictionary</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
		<script type="text/javascript" src="/js/jqueryui/jquery-ui-1.10.2.custom.min.js"></script>
		<script type="text/javascript" src="/js/application.js"></script>
		<link rel="stylesheet" href="/css/jqueryui/ui-lightness/jquery-ui-1.10.2.custom.min.css">
	</head>
	<body>
		<?php
			foreach ($results as $result) {
				$eng = json_decode($result['eng']);

				echo '<p>' . $result['tc'] . ' - ' . implode(', ', $eng) . '</p>';
			}
		?>
	</body>
</html>