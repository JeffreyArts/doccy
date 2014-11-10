<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/ajax/project_check.php');

// Post Request ?
if (!empty($_GET)) { 

	if (is_numeric($_GET['element_id'])) {

		$element = new StructureElement($_GET['element_id']);

		$element->deleteElement();

		if ($element->deleteElement()) {
			$arr['success'] = 1;
			$alert = 'element_delete_success';
		} else {
			$arr['success'] = 0;
			$alert = 'element_delete_error';
			if ( $element->hasChildren()) {
				$alert = 'element_delete_error_children';
			}
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
} else {
	include_once($_SERVER['DOCUMENT_ROOT'].'/page/show_elements.php');
}
?>