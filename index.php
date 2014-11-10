<?php

include_once('config.php');

session_start();
ob_start();

$project = new StructureProject;


include_once('post_handler.php');

/***************************************************************************/

if (isset($_SESSION['project_id']) && is_numeric($_SESSION['project_id'])) {
	$project->setCurrentProject($_SESSION['project_id']);
}


//$project->setCurrentProject(1);
//$project->addElement(array('type_id'=>2,'parent_id'=>1,'name'=>'getAllProjects','description'=>'Return array with all projects'));
#print "<pre>".print_r($project,1)."</pre>";


$above_content = ob_get_clean();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Software structure design tool</title>
	<link href="/css/bootstrap.min.css" rel="stylesheet">
	<link href="/css/site.css" rel="stylesheet">

	<script src="/js/jquery-1.9.1.js"></script>
</head>
<body>
	<div class="container">

				<?php if (isset($project->id) && is_numeric($project->id)) { 
				// Er is een project beschikbaar 
					
					include('page/project.php');
				
				} else {
				// Er moet eerst nog een project worden geselecteerd voor we kunnen beginnen. 
				$projects	= Structure::getAllProjects();	
					
					if (!isset($alert)) {
						$alert = 'load_project';
					}
					include('page/select_project.php');
				}
				?>
			<div class="general-alert-message">
				<?php
				$file = 'page/alert/'.$alert.'.php';

				if (file_exists($file)) {
					include_once($file);
				}
				?>
			</div>
	
	</div>
	<footer class="container">
		<?php 
			echo $above_content;
		?>
	</footer>
	
	<script src="/js/console.js"></script>
	<script src="/js/site.js"></script>
</body>
</html>