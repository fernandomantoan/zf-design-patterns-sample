function exibe_div(div_id, button)
{
	var button = $(button);
	var div = $('#' + div_id);
	if (div.css('display') != 'block')
	{
		button.html('- Cancelar');
		div.show();
	}
	else
	{
		button.html('+ Adicionar Item');
		div.hide();
	}
}
function processa_devolucao(url_controller)
{
	var input_data = $('#data_devolvida');
	var input_valor = $('#valor_pago');
	var id = $('#id');
	var carregando = $('#carregando');
	var botao = $('#submitbutton');
	if (input_data.val().length == 10)
	{
		$.ajax({
			type:"POST",
			url:url_controller,
			data:"id=" + id.val() + "&data=" + input_data.val(),
			dataType:"json",
			beforeSend: function()
			{
				carregando.show();
				botao.attr('disabled', 'disabled');
			},
			success: function(dados)
			{
				carregando.hide();
				if (dados.valor == '')
				{
					input_valor.val('');
					botao.attr('disabled', 'disabled');
				}
				else
				{
					input_valor.val(dados.valor);
					botao.attr('disabled', '');
				}
			}
		});
	}
}
function deletar(url)
{
	if (window.confirm('Deseja realmente excluir este registro?'))
	{
		return true;
	}
	return false;
}