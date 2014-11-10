<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/ajax/project_check.php');

// Post Request ?
if (!empty($_POST)) {

	if (is_numeric($_POST['element_id'])) {
		$element = new StructureElement($_POST['element_id']);

		$element->setElement($_POST);

		if ($element->saveElement()) {
			$alert = 'element_update_success';
		} else {
			$alert = 'element_update_error';

		}

		$file = $_SERVER['DOCUMENT_ROOT'] . '/page/alert/'.$alert.'.php';
		if (file_exists($file)) {
			ob_start();
			include_once($file);
			$alert_html = ob_get_clean();
			$arr['alert'] = $alert_html;
		}
		
		echo json_encode($arr);
	}

// Geen post request, dan gewoon de pagina laten zien.
} else {

	$types    = Structure::getAllTypes();

	$elements = $project->getElements();
	$elements->setTreeArray();
	$classes  = $elements->getAllClasses();
	if (is_numeric($_GET['element_id'])) {
	    $element_id = $_GET['element_id'];
	} elseif (is_numeric($_POST['element_id'])) {
	    $element_id = $_POST['element_id'];
	} 

	$element = new StructureElement($element_id);

	include($_SERVER['DOCUMENT_ROOT']."/page/edit_element.php");
}
?>
