

window.button = {
	'class' : 'btn-primary',
	'function' : 'btn-success',
	'string' : 'btn-info'
}


if ( $("#json").length > 0 ) {
	window.elementsList = jQuery.parseJSON( $("#json").text() );
}




if ( $("#console_buttons").length > 0 ) {
	if (!window.elementsList) {
		alert('Probleem met laden Json')
	}
} 



$('#ajax_content').on('click', '#console_buttons [data-elementid]', function(e){
	$current_html_element = $(this);
	id = $current_html_element.attr('data-elementid')

	postData = {'action' : 'get', 'element_id' : id};
	$.ajax({
		url: 'ajax/element.php',       
		type: "POST",
        data : postData
	}).done(function( json ) {
		var new_data = jQuery.parseJSON( json );
		$current_html_element.addClass('extend'); // Zorg ervoor dat het html element gelijk opent

		newOpenClass($current_html_element);

		if (new_data.children != 'undefined') {
			$(new_data.children).each(function(index, item) {
				if (item.type_id == 3) {
					console.log('Functie: ' + item.name + ' - ' + $(this).find('.func_container'));
					addFunction(item,$(this).find('.func_container'))
				}
			});
		}
		//$( "#ajax_content" ).html( html );
	});

	/*$html = '<div class="col-lg-6 col-sm-12">' +
				'<div class="panel panel-default" data-elementid="' + $id + '">' +
					'<div class="panel-heading">'+
	  					'<h3 class="panel-title">' +  $(this).text() + '</h3>' +
	  				'</div>' +
	  				'<div class="panel-body">' +
	  				'</div>' +
  				'</div>' +
			'</div>';
	$('#console_view').append($html);*/
	/*$new_panel = $('.panel[data-elementid=' + $id + '] .panel-body');

	$panel_html = '<table>' +
					'<thead>' +
						'<tr>'+
		  					'<th>Naam</th>' +
		  					'<th>Type</th>' +
		  					'<th>button</th>' +
		  				'</tr>' +
	  				'</thead><tbody></tbody></table>';
	$new_panel.append($panel_html);
	$new_panel_table = $('.panel[data-elementid=' + $id + '] .panel-body tbody');
	$.each(window.elementsList[$id].children,function( index, value ){
		$tmp =	'<tr>' +
					'<td>' +  value.name +'</td>' +
					'<td>' +  value.type_name +'</td>' +
					'<td><button class="btn '+ value.type_name +'">Uitvoeren</button></td>' +
				'</tr>';
		$new_panel_table.append($tmp);
	});*/
	

	add2console("--- " + window.elementsList[$id].name + " --------------------------------------------------");
	//addConsoleButtons(window.elementsList[$id].children)
	
});




/**
 * Displays an element in HTML
 * @param  {JQuery obj} $element 
 * @param  {string} target   class, id or other html selector
 * @return {boolean}         true on success
 */
function displayElement($element,target) {
	if ($element.type_name == 'class') {
		addClass($element,target);
	}
	if ($element.type_id == 3)  // Function
	{
		displayFunction($element,target);
	}
}

function addClass($element,target) {
	element_id = $element.id;
	html_name = $element.name;
	$(target).append('<div data-elementid="' + element_id +'" class="classButton"><header><h1 class="title">' + html_name +'</h1></header></div>')
}

function addFunction($element,target) {
	element_id = $element.id;
	html_name = $element.name;
	$(target).append('<div data-elementid="' + element_id +'" class="functionItem"><span class="name">' + html_name +'</span></div>');
}


function newOpenClass(target) {
	$(target).addClass('loaded'); // Zo kun je later checken of de classs al eerder is geladen of niet.
	$(target).append('<section><div class="var_container"><h2 class="header">Variabelen</h2></div><div class="func_container"><h2 class="Header">Functies</h2></div></section>');
}


function add2console($value) {
	$('#console_log').prepend("<span>" + $value + "</span><br />");

}

function addConsoleButtons($target) {
	$.each($target,function( index, value ){
		//value.name
		console.log(index + ": " + value );

		var button = window.button[value.type_name];
	

	// define HTML
		var html = '<button class="btn-xs ' + button + '" data-elementid="' + value.id + '">' + value.name + '</button>';
		$('#console_buttons').append(html);
		add2console("Laad: " + value.type_name + ' - ' + value.name);
	});
};
//	add2console("#console_buttons","Startup: Basiselementen geladen.");
