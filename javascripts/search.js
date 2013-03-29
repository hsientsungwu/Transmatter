$(document).ready(function(){
	
	$('#id_searchform').submit(function(e) {
		e.preventDefault();

		var key = $('#id_key').val();
		console.log(key);

		if (key != '') {
			$.ajax({
			  	type: "POST",
			  	url: "search.php",
			  	data: "key="+key,
			  	datatype: "HTML",
			  	success: function(html) {
			  		if (html) {
			  			$('.result-message').html("");
			  			$('.results').html(html);
			  		} else {
			  			$('.result-message').html("No result found");
			  		}
			  	},
			  	error: function() {
			  		$('.result-message').html("Unable to retrieve result from the server");
			  	}
			});
		} else {
			$('.result-message').html("Search key cannot be blank");
		}
	});
});