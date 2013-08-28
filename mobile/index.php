<?php

header("Content-Type: text/html; charset=utf-8");
?>

<html>
	<head>
		<title>漢英 TransMatter | Mobile</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
		<link rel="icon" href="/img/favicon.ico" type="image/x-icon">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
		<script type="text/javascript" src="/js/jqueryui/jquery-ui-1.10.2.custom.min.js"></script>
		<script type="text/javascript" src="/js/mobile.js"></script>
		<link rel="stylesheet" href="/css/jqueryui/ui-lightness/jquery-ui-1.10.2.custom.min.css">
		<meta charset="utf-8" />
  		<meta name="viewport" content="width=device-width" />
  		<link rel="stylesheet" href="/css/foundation/normalize.css" />
  		<link rel="stylesheet" href="/css/foundation/foundation.css" />
  		<link rel="stylesheet" href="/css/dictionary_home.css" />
  		<script src="/js/vendor/custom.modernizr.js"></script>
	</head>
	<body>
		<div class="row">
		  	<div class="large-12 large-centered columns" style="text-align:center;">
		  		<img src="/img/logo.png" />
		  	</div>
		</div>

    	<form id="id_searchform" >
	      	<div class="row">
	        	<div class="large-12 columns">
	          		<input type="text" class="large" id="id_key" placeholder="請輸入中文單字 ... " style="height:50px;">
	        	</div>
	        </div>
	        <div class="row">
	        	<div class="large-12 columns">
	          		<a href="#" id="id_searchButton" class="large button prefix">搜尋</a>
	        	</div>
	        </div>
	    </form>

		<div class="row">
			<div class="large-12 columns">
				<div class="result-message"></div>
			</div>
		</div>
		<div class="row">
			<div class="large-12 columns">
				<div class="results"></div>
		  	</div>
		</div>
	</body>
</html>