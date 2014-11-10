<?php

if (isset($_POST) && is_array($_POST)) {
	if (isset($_POST['close_project'])) {
		
		$alert = 'project_closed';
		$tmp_projectnaam = $project->name;
		unset($project);
		unset($_SESSION['project_id']);

	} elseif (isset($_POST['load_project'])) {
		
		if (is_numeric($_POST['project_id'])) {
			if (!empty($_POST['project_id'])) {
				if ($project->setCurrentProject($_POST['project_id'])) {
					$alert = 'project_loaded';
				}
			} else {
					$alert = 'project_empty';
			}
		}
	} 

} 
?>