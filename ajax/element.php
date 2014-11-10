<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/ajax/project_check.php');

// Post Request ?
if (!empty($_POST) && is_numeric($_POST['element_id'])) {

	switch ($_POST['action']) {
		case 'create':
			# code...
			break;
		case 'get':
			$element = new StructureElement($_POST['element_id']);
			echo json_encode($element);
			break;
		case 'update':
			# code...
			break;
		
		default:
			print 'DEF';
			break;
	}

// Geen post request, dan gewoon de pagina laten zien.
} else {

	echo 'invalid request';

}
?>
