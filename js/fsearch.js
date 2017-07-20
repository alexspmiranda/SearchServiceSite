function autoCompleteCat() {
	var min_length = 3;
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
	var min_length = 3; 
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

function autoCompleteCityHome() {
	var min_length = 3; 
	var keyword = $('#pesquisaestado').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'buscaCityHome.php',
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

function autoCompleteCatHome() {
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

function set_item(item) {
	$('#pesquisa').val(item);
	$('#pesquisa_list_id').hide();
}

function set_itemCity(item) {
	$('#pesquisaCity').val(item);
	$('#pesquisa_list_id_city').hide();
}

function set_itemCityHome(item) {
	$('#pesquisaestado').val(item);
	$('#pesquisa_list_id_city').hide();
}