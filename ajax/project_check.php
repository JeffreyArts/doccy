<?php 
if (!class_exists('Structure')) {
    include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
}
if (!isset($_SESSION)) {
	session_start();
}
if (!is_object($project)) {
    $project = new StructureProject;
    $project->setCurrentProject($_SESSION['project_id']);
}

include_once($_SERVER['DOCUMENT_ROOT'].'/post_handler.php');


if (!isset($project->id) || !is_numeric($project->id)) {
    print 'This page is not accesable.';
    die();
}
?>