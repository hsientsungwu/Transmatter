$(document).ready(function(){
	$('#id_key').autocomplete({
		source: '/ajax/chtoeng.autocomplete.php', 
		minLength: 1
	});

	$('#id_searchform').submit(function (e) {
		e.preventDefault();

		var key = $('#id_key').val();

		if (key != '') {
			$.ajax({
			  	type: "POST",
			  	url: "/ajax/chtoeng.search.php",
			  	data: "chtoeng=1&key="+key,
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

	$('.results').on('click', 'a.reportbug', function(e) {
		e.preventDefault();

		var rel = $(this).attr('rel');

		$.ajax({
		  	type: "POST",
		  	url: "/ajax/report.bug.php",
		  	data: "rel="+rel,
		  	datatype: "HTML",
		  	success: function(html) {
		  		$('#'+rel).html(html);
		  	},
		  	error: function() {
		  		$('#'+rel).html("Unable to retrieve result from the server");
		  	}
		});
	});
});