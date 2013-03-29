<?php 
header("Content-Type: text/html; charset=utf-8");
?>

<html>
	<head>
		<title>Steve's Dictionary</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
		<script type="text/javascript" src="javascripts/search.js"></script>
	</head>
	<body>
		<div class="search-bar-container">
			<form id="id_searchform" >
				<h4>Search word here:</h4>
				<input type="text" name="key" id="id_key" />
				<input type="submit" />
			</form>
		</div>
		<div class="result-container">
			<h4>Result:</h4>
			<div class="result-message"></div>
			<div class="results"></div>
		</div>
	</body>
</html>
