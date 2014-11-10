<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/ajax/project_check.php');


$types    = Structure::getAllTypes();

$elements = $project->getElements();
$elements->setTreeArray();
$classes  = $elements->getAllClasses();

include($_SERVER['DOCUMENT_ROOT']."/page/console.php");

?>