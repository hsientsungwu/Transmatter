<?php

include($_SERVER['DOCUMENT_ROOT'] . '/devicedetect.php');

header("Content-Type: text/html; charset=utf-8");
?>

<html>
	<head>
		<title>漢英 TransMatter</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
		<link rel="icon" href="/img/favicon.ico" type="image/x-icon">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
		<script type="text/javascript" src="/js/jqueryui/jquery-ui-1.10.2.custom.min.js"></script>
		<script type="text/javascript" src="/js/application.js"></script>
		<link rel="stylesheet" href="/css/jqueryui/ui-lightness/jquery-ui-1.10.2.custom.min.css">
		<meta charset="utf-8" />
  		<meta name="viewport" content="width=device-width" />
  		<link rel="stylesheet" href="css/foundation/normalize.css" />
  		<link rel="stylesheet" href="css/foundation/foundation.css" />
  		<link rel="stylesheet" href="css/dictionary_home.css" />
  		<script src="js/vendor/custom.modernizr.js"></script>
	</head>
	<body>
		<div class="row">
		  	<div class="small-6 small-centered columns" style="text-align:center;">
		  		<img src="/img/logo.png" />
		  	</div>
		</div>
		

		<div class="row">
		    <div class="small-6 small-centered columns search-bar-container">
		    	<form id="id_searchform" >
			      	<div class="row collapse">
			        	<div class="small-10 columns">
			          		<input type="text" class="x-large" id="id_key" placeholder="請輸入中文單字 ... ">
			        	</div>
			        	<div class="small-2 columns">
			          		<a href="#" id="id_searchButton" class="button prefix">搜尋</a>
			        	</div>
			        </div>
			    </form>

			    <div class="row">
			    	<div class="small-8 small-centered columns autocomplete-toggle">
			    		<span>自動補字</span>
						<div class="small-4 columns" id="id_autocomplete_toggle">
							<div class="switch tiny round">
							  	<input id="z" name="switch-autocomplete" type="radio" value="off">
							 	<label for="z" onclick="">關</label>
							  	<input id="z1" name="switch-autocomplete" type="radio" value="on" checked>
							  	<label for="z1" onclick="" style="right:11%;">開</label>
							  	<span></span>
							</div>
					    </div>
				    </div>
			    </div>
				    
		    </div>	    
		</div>
		<div class="row">
			<div class="small-6 small-centered columns">
				<div class="result-message"></div>
			</div>
			<div class="small-12 small-centered columns">
				<div class="results"></div>
		  	</div>
		</div>
	</body>
</html>