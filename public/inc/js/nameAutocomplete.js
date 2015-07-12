//requires LINK to IdenfierAuto.php using files to have been specified earlier
	$('#studentName').autocomplete({
		source: function(req, add){
			req.task = 'getAutoname';
			$.getJSON(LINK + '?examID=' + EXAMID, req, function(data){
				var suggestions = [];
				$.each(data, function (i, val){
					suggestions.push(val);
				});
				add(suggestions);
			}, "JSON");//end json
		},
//set sid when name is selected
		select: function(event, ui){//happens when the id is selected
			$('#sid').val(ui.item.sid);
		}
	});//end autocomplete