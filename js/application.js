$(document).ready(function(){
	$('#id_key').autocomplete({
		source: '/ajax/chtoeng.autocomplete.php', 
		minLength: 1
	});

	$('#id_key').bind('keypress', function(e) {
		var code = (e.keyCode ? e.keyCode : e.which);

		if(code == 27) { 
			console.log('asdf');
			$('#id_key').autocomplete("search");
			$('#id_key').autocomplete("close");
		}
	});

	$('#id_searchform').submit(function (e) {
		e.preventDefault();
		searchForWord();
	});

	$('#id_searchButton').bind('click', function(e){
		e.preventDefault();
		searchForWord();
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
		  		$('#'+rel).html("無法聯絡到字典資料庫");
		  	}
		});
	});

	$('input[name="switch-autocomplete"]').bind('click', function (e) {
		if ($(this).val() == 'off') {
			$('#id_key').autocomplete('disable');
		} else {
			$('#id_key').autocomplete('enable');
		}
	});

	function searchForWord() {
		$('.results').css({opacity: 0.25});

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
			  			$('.result-message').html("找不到任何關鍵字的翻譯");
			  		}
			  	},
			  	error: function() {
			  		$('.result-message').html("無法聯絡到字典資料庫");
			  	}
			});
		} else {
			$('.result-message').html("關鍵字不能是空白的");
		}

		$('.results').css({opacity: 1});
	}
});