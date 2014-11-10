/*

Cookie setten nadat een ajax request is uitgevoerd zodat de url onthouden kan worden bij een refresh.

 */

$('body').on('click','a[href*=ajax]', function(e){
	e.preventDefault();
	var url = $(this).attr('href');
	
	// Uitzonderingen voor standaard ajax request
	if (!$(this).hasClass('delete')) {
		$.ajax({
			url: url,
       		async: false
		}).done(function( html ) {
			$( "#ajax_content" ).html( html );
			if ( $("#json").length > 0 ) {
				window.elementsList = jQuery.parseJSON( $("#json").text() );
				//addConsoleButtons(window.elementsList);
			} 
		});
	}
});

$('#ajax_content').on('click', '.btn[value=add]', function(e){
	$container = $(this).parent('.add-input').parent();
	$input_fields = $container.children('.input-fields');
	var url = $(this).attr('data-form');

	$.ajax({
		url: url
	}).done(function( html ) {
		id  = parseInt($input_fields.find('.param_number').text().slice(-1)); // Get the last number which is the id
		html = html.replace(/1/gi, id+1);
		console.log(id);
		$input_fields.append( html );

	});

});

$('#ajax_content').on('submit', 'form', function(e){
	form = $(this);
	var url = form.attr('action');
	postData = form.serializeArray();
	$.ajax({
		url: url,       
		type: "POST",
        data : postData
	}).done(function( json ) {
		var new_data = jQuery.parseJSON( json );
		if (typeof new_data.alert == "string") {
			addAlert(new_data.alert);
			
		}
		//$( "#ajax_content" ).html( html );
	});
    return false;
});

$('#ajax_content').on('click', '.delete', function(e){
	e.preventDefault();
	var url = $(this).attr('href');

	if (confirm('Are you sure ?')) {
	   $.ajax({
			url: url,
       		async: false
		}).done(function( json ) {
			ajax_data = jQuery.parseJSON( json );
			if (typeof ajax_data.alert == "string") {
				addAlert(ajax_data.alert);
			}
		}
		);

		if (ajax_data.success == 1) {
   			 $(this).parent('li').remove();
   		}

	} else {
	    // Do nothing!
	}
});


$('#ajax_content').on('change', 'input, textarea, select', function(e){
	if ($('*[type=submit]').attr('disabled') == 'disabled') {
		$('*[type=submit]').removeAttr('disabled');
	}
});

$('#ajax_content').on('change', '[name=type_id]', function(e){

	type = $(this).children("option").filter(":selected").text();

	if (type == 'functie') {
		additional_fields = '#functie_eigenschappen';
	} else if (type=='string' || type=='integerer' || type=='array') {
		additional_fields = '#var_eigenschappen';
	}

	$(window.open_fields).addClass('hidden');

	if (additional_fields) {
		$(additional_fields).removeClass('hidden');
	
		window.open_fields = additional_fields;
		delete additional_fields;
	}
});

$('document').ready(function(){
	if ($('.general-alert-message').length > 0) {
		$('.general-alert-message .alert').delay(3000).fadeOut('slow');
	}


	/* Toggle een input aan of uit naar aanleiding van de inhoud van een selectbox
	if ($('.show_type_class').length > 0) {
		$('[name=type_id]').on('change',function(){
			if ($(this).val() != 1) {
				$('.show_type_class').removeClass('hidden');
			} else {
				if (!$('.show_type_class').hasClass('hidden')) {
					$('.show_type_class').addClass('hidden');
				}
			}
		});
	}*/
});

function addAlert($html) {

	$('.general-alert-message').html($html);
	$('.general-alert-message .alert').show();
	$('.general-alert-message .alert').delay(3000).fadeOut('slow');
}