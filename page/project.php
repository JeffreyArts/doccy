<?php
$project->getElements();

?>
<div class="row">
	<div class="col-lg-9">
		<h1>Huidig project: <strong>"<?=$project->name;?>"</strong></h1>
	</div>
	<div class="col-lg-3">
		<form action="/" method="post"><button name="close_project" id="close_project" value="<?=$project->id;?>" class="btn btn-danger btn-large">Sluit project <span class="glyphicon glyphicon-remove"></span></button></form>
	</div>
	<div class="col-lg-12">
		<h4><?=$project->description;?></h4><br />
	</div>
</div>

<div class="row">
	<div class="col-md-3">
		<ul class="nav nav-pills nav-stacked">
			<li>
				<a href="/ajax/show_elements.php" class="ajax">Show element list <span class="badge"><?=$project->number_of_elements();?></span></a>
				
			</li>
			<li>
				<a href="/ajax/console.php" class="ajax">Console</a>
			</li>
			<li>
				<a href="/ajax/add_element.php" class="ajax">Add element</a>
			</li>
		</ul>
	</div>
	<div class="col-md-9">
		<div class="well" id="ajax_content">
			<?php include_once('ajax/add_element.php');?>
		</div>
	</div>
</div>
