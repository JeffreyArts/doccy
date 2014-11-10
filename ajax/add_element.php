<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/ajax/project_check.php');

// Post Request ?
if (!empty($_POST)) {

    if (is_numeric($_POST['project_id']) && $_POST['form_type'] == "add_element") {
        $post = true;
        if ($project->setCurrentProject($_POST['project_id'])) {
            
            $element = new StructureElement;
            $element->setElement($_POST);
            if ($project->saveElement($element)) {
                $alert = 'element_add_success';
            } else {
                $alert = 'element_add_error';
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

// Geen post request, dan gewoon de pagina laten zien.
} 

if (!$post) {

    $types    = Structure::getAllTypes();

    $elements = $project->getElements();
    $elements->setTreeArray();
    $classes  = $elements->getAllClasses();

    include($_SERVER['DOCUMENT_ROOT']."/page/add_element.php");
}
?>