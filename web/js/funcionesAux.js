/**
 * Variable global que almacena el html de la imagen loader para el ajax
***/
var ajax_loader = "<img id='ajax_loader' />";
/**
 * Coloca en el tag la imagen del loader
 * @param tag : tag al que se le colocara la imagen
**/
function setAjaxLoader(tag){
	$(tag).html(ajax_loader);
}


/**
 * Funcion que chekea el maximo de checkbox seleccionados permitidos
 * @param cantidad : cantidad de checked permitidos
***/
function setMaxChecked(cantidad) {
	$('#formContent :input:checkbox').click(function(){
		var cantidadChecked = $('#formContent :input:checkbox:checked').length;
		if ( cantidadChecked >= cantidad){
	       	$("#formContent :checkbox:not(:checked)").prop("disabled", "disabled");
	   	} else {
	       	$("#formContent :checkbox").prop("disabled", "");
	   	}
	})
}

/**
 * Función que elimina un elemento de un array.
 * @param element : elemento a eliminar del array
 * @param array : array objetivo
***/
function deleteElementArray(element, array){
	var posBorrar=array.indexOf(element);
	array.splice(posBorrar, 1);
}

/**
 * Manejo de jquery-UI
 * Carga todos los botones de jQuery-UI
 **/
function cargarBotones(){
	$("a.button").button();
	$("button:submit").button();
	$("a.button-ui-plusthick").button({
            icons: {
                primary: "ui-icon-plusthick"
            }});
}
/**
 * Manejo de jquery-UI
 * Carga todos los botones de jQuery-UI
 * @param tag : dialogo en donde se cargan los botones
 **/
function cargarBotonesDialog(tag){
	$(tag+" a.button").button();
	$(tag+" button:submit").button();
	$(tag+" a.button-ui-plusthick").button({
            icons: {
                primary: "ui-icon-plusthick"
            }});
}
/** Objeto dialog **/
function Dialog() {
		this.modal = true;
		this.resizable = true;
		this.width = 400;
		this.height = 300;
		this.aumentar = function(){ this.width = this.width + 200; this.height = this.height + 200; }
		this.aumentarHorizontal = function () { this.width = this.width + 200; }
		this.close = function (event, ui) { return false; }
};

/**
 * Abre el dialogo en un determinado tag
 * @param tag : tag en donde se abrira el dialogo
 **/
function abrirDialogo(tag) {
	$(tag).dialog('open');
}
function cerrarDialogo (tag) {
	$(tag).dialog('close');
}

/**
 * Envia un form a la URL, con los DATOS y los muestra en el TAG
 * == SOLO AJAX W/DIALOG ==
 * @param tag : tag objetivo del ajax
 * @param datos : tag del formulario
 * @param url : url del action del formulario
 **/
function submitForm (tag,datos,url) {
	var data = $(tag+' '+datos).serialize()
	var request = $.ajax({
		url: url,
		data: data,
		type: "POST"
	});
	
	request.done(
		function(datos){
			$(tag).html(datos);
		}
	);

	$(tag).ajaxError(function(event, xhr, request, settings){
        $(tag).html(xhr.responseText );
    });
}