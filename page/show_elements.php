<?php
$elements = $project->getElements();

$elements->setTreeArray();

if (is_array($elements->tree)) :?>

		<ul class="list-group elements_list">
		<?php foreach ($elements->tree as $tmp_element) :?>
			<li class="list-group-item">
				<h3><?=$tmp_element->name;?> <strong><?=$tmp_element->type_name;?></strong></h3>
					
				<p><?=$tmp_element->description;?></p>

				<a href="/ajax/edit_element.php?element_id=<?=$tmp_element->id;?>" class="edit"><button class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></button></a>
				<a href="/ajax/delete_element.php?element_id=<?=$tmp_element->id;?>" class="delete"><button class="btn btn-danger"><span class="glyphicon glyphicon glyphicon-trash"></span></button></a>

				</form>
				<?php if ($tmp_element->hasChildren()) :?>
					<ul class="list-group">
					<?php foreach ($tmp_element->children as $child_element) :?>
						<li class="list-group-item">
							<h4 data-id="<?=$tmp_element->id;?>" data-type="name"><?=$child_element->name;?> <strong><?=$child_element->type_name;?></strong></h4>
								
							<p data-id="<?=$tmp_element->id;?>" data-type="description"><?=$child_element->description;?></p>

							<a href="/ajax/edit_element.php?element_id=<?=$child_element->id;?>" class="edit"><button class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></button></a>
							<a href="/ajax/delete_element.php?element_id=<?=$child_element->id;?>" class="delete"><button class="btn btn-danger"><span class="glyphicon glyphicon glyphicon-trash"></span></button></a>

						</li>
					<?php endforeach;?>
					</ul>
				<?php endif;?>
			</li>
		<?php endforeach;?>
		</ul>
<?php else :?>
	Dit project heeft nog geen elementen.
<?php endif; ?>

