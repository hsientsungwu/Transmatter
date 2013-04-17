<?php 
header("Content-Type: text/html; charset=utf-8");
?>

<html>
	<head>
		<title>Steve's Autocomplete Dictionary</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
		  	<div class="small-6 small-centered columns">
		  		<h3 style="text-align: center;">Chinese English Translation</h3>
		  	</div>
		</div>
		
		<div class="row">
		    <div class="large-6 small-centered columns search-bar-container">
		    	<form id="id_searchform" >
			      	<div class="row collapse">
			        	<div class="small-10 columns">
			          		<input type="text" class="large" id="id_key" placeholder="Enter your search here ... ">
			        	</div>
			        <div class="small-2 columns">
			          	<a href="#" class="button prefix">SEARCH</a>
			        </div>
			    </form>
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