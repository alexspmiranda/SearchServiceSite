// autocomplet : this function will be executed every time we change the text
function autoCompleteCat() {
	var min_length = 3; // min caracters to display the autocomplete
	var keyword = $('#pesquisa').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'busca.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#pesquisa_list_id').show();
				$('#pesquisa_list_id').html(data);
			}
		});
	} else {
		$('#pesquisa_list_id').hide();
	}
}

function autoCompleteCity() {
	var min_length = 3; // min caracters to display the autocomplete
	var keyword = $('#pesquisaCity').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'buscaCity.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#pesquisa_list_id_city').show();
				$('#pesquisa_list_id_city').html(data);
			}
		});
	} else {
		$('#pesquisa_list_id_city').hide();
	}
}

function set_item(item) {
	$('#pesquisa').val(item);
	$('#pesquisa_list_id').hide();
}

function set_itemCity(item) {
	$('#pesquisaCity').val(item);
	$('#pesquisa_list_id_city').hide();
}