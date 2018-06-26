var listas = ['#lista_campi', '#lista_cursos', '#lista_setores'];

function deletarItem(event){
	event.target.parentElement.remove();
	submeterForm();
}

function makeItem(id, nome){
	let divItem = jQuery('<li class="item"></li>');
	divItem.attr('data-id', id);

	let botaoDeletar = jQuery('<button type="button" class="deletar"><span class="dashicons dashicons-no"></span></button>');
	botaoDeletar.click(event => deletarItem(event));

	divItem.append(botaoDeletar);
	divItem.append(' ');
	divItem.append('<div class="nome">' + nome + '</div>');

	return divItem;
}

function addItemToLista(listaSelector, id, nome){
	if (!listas.some(lista => isIdInLista(id, lista))){
		jQuery(listaSelector).append(makeItem(id, nome));
	}
}

function getIdsItems(listaSelector){
	return jQuery.map(jQuery(listaSelector).find('.item'), x => $(x).attr('data-id'));
}

function isIdInLista(itemId, listaSelector){
	return jQuery.inArray(itemId, getIdsItems(listaSelector)) !== -1
}

function getSelectedSite(selectSelector){
	let selecionado = jQuery(selectSelector).find(':selected');
	let selecionadoId = selecionado.val();
	let selecionadoNome = selecionado.text();
	return {
		id: selecionadoId,
		nome: selecionadoNome
	}
}

function adicionarCampus(botao){
	$(botao).prop('disabled', true);
	let campusSelecionado = getSelectedSite('#novo_campus');
	addItemToLista('#lista_campi', campusSelecionado.id, campusSelecionado.nome);
	submeterForm();
}

function adicionarCurso(botao){
	$(botao).prop('disabled', true);
	let cursoSelecionado = getSelectedSite('#novo_curso');
	addItemToLista('#lista_cursos', cursoSelecionado.id, cursoSelecionado.nome);
	submeterForm();
}

function adicionarSetor(botao){
	$(botao).prop('disabled', true);
	let setorSelecionado = getSelectedSite('#novo_setor');
	addItemToLista('#lista_setores', setorSelecionado.id, setorSelecionado.nome);
	submeterForm();
}

function submeterForm(){
	setLoading(true);

	let formAction = jQuery('.sites-ifc > form').attr('action');

	jQuery.post(
		formAction,
		{
			action: 'ifc_admin_menu_sites',
			campi: getIdsItems('#lista_campi'),
			cursos: getIdsItems('#lista_cursos'),
			setores: getIdsItems('#lista_setores'),
		}
	)
		.done(() => window.location.reload())
		.fail(() => setLoading(false));

	return false;
}

function setLoading(isLoading){
	let spinner = $('#sites_ifc_spinner');
	if (isLoading){
		spinner.show();
	} else {
		spinner.hide();
	}
}