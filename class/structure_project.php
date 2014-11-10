<?php
class StructureProject {

	public $id;
	public $name;
	public $description;

	private function loadCurrentProject() {
		global $pdo;
		
		if (is_numeric($this->id)) {
			$qry = "SELECT 
					`project`.`id` 			as 'id',
					`project`.`name` 		as 'name',
					`project`.`description` as 'description'
					
					FROM `structure_project` AS `project`
					WHERE `id` =  '$this->id' LIMIT 0,1;";
			if ($pdo->query($qry)) {
				foreach ($pdo->query($qry) as $row) {
					$this->id 			= $this->id;
					$this->name 		= $row['name'];
					$this->description 	= $row['description'];
				}
			} else {
				return false;
			}
		} else {
			return false;
		}

		$_SESSION['project_id'] = $this->id;
		return true;
	}


	public function setCurrentProject($id) {
		if (is_numeric($id)) {
			$this->id = $id;
			$this->loadCurrentProject();

			return true;
		} else {
			return false;
		}

	}

	public function number_of_elements() {
		return $this->element_list->number_of_elements();
	}

	private function checkId() {
		if (isset($this->id) && is_numeric($this->id)) {
			return true;
		} else {
			return false;
		}
	}

	public function getElements() {

	 	if ($this->checkId()) {
			global $pdo;

			$qry = "SELECT 
					`element`.`id` 			as 'id',
					`element`.`type_id` 	as 'type_id',
					`type`.`name` 			as 'type_name',
					`element`.`parent_id` 	as 'parent_id',
					`element`.`name` 		as 'name',
					`element`.`description` as 'description'
					
					FROM `structure_element` AS `element`
					LEFT JOIN `structure_type` AS `type` ON `element`.`type_id` = `type`.`id`
					WHERE `project_id` =  '$this->id' 
					ORDER BY id,parent_id;";

			$this->element_list = new StructureElements();
			
			$i=0;
			foreach ($pdo->query($qry) as $row) {
				//$tmp[$i]['id'] 			= $row['id'];	
				//$tmp[$i]['type_id'] 	= $row['type_id'];	
				//$tmp[$i]['type_name'] 	= $row['type_name'];	
				//$tmp[$i]['parent_id'] 	= $row['parent_id'];	
				//$tmp[$i]['name'] 		= $row['name'];	
				//$tmp[$i]['description'] = $row['description'];	
				$this->element_list->addElementFromArray($row['id'],$row);
				$i++;
			}
			return $this->element_list;
		} else {
			return false;
		}
	}

// Double function name (structureElement)
	public function saveElement($elementObject) {
	 	if ($this->checkId()) {
			global $pdo;

	 		if (is_object($elementObject)) 
	 		{
 				$arr = $elementObject->getAll();
 				if (is_array($arr)) 
 				{

					$insert = '`project_id`, ';
					$values = ':project_id, ';
					$pdo_prepare[':project_id'] = $this->id; 

					foreach ($arr as $k=>$v) 
					{
						if ($k=='type_id' || $k=='description' || $k=='name') 
						{
							$pdo_prepare[':'.$k] = $v;
							$insert .= "`" . $k . "`, ";
							$values .= ":" . $k . ", ";
						}
					}
					$insert = rtrim($insert,', ');
					$values = rtrim($values,', ');
					unset($k,$v);
					
					if (!empty($insert)) 
					{
						$qry = "INSERT INTO `structure_element` (".$insert.") VALUES (".$values.");"; 
						$statement = $pdo->prepare($qry);

						if (!$statement->execute($pdo_prepare)) 
						{
							$error = true;
						}

							$element_id = $pdo->lastInsertId();

							// Add parameters when available
							if (isset($elementObject->parameter)) 
							{
								unset($pdo_prepare);
								$pdo_prepare[':element_id'] = $element_id; 

								foreach ($elementObject->parameter as $k=>$v) 
								{
									$pdo_prepare[':name'] = $v['name'];
									$pdo_prepare[':type'] = $v['type'];
									$pdo_prepare[':description'] = $v['description'];

									$qry = "INSERT INTO `structure_element_parameter` 
												(`element_id`,`name`,`type`,`description`) 
												VALUES (:element_id, :name, :type, :description);"; 

									$statement = $pdo->prepare($qry);

									if (!$statement->execute($pdo_prepare)) 
									{
										$error = true;
									}
								}
							}

							// Add results when available
							if (isset($elementObject->return)) {

								unset($pdo_prepare);
								$pdo_prepare[':element_id'] = $element_id; 

								foreach ($elementObject->return as $k=>$v) {
									$pdo_prepare[':name'] = $v['name'];
									$pdo_prepare[':type'] = $v['type'];
									$pdo_prepare[':description'] = $v['description'];

									$qry = "INSERT INTO `structure_element_return` 
												(`element_id`,`name`,`type`,`description`) 
												VALUES (:element_id, :name, :type, :description);"; 
									$statement = $pdo->prepare($qry);
									if (!$statement->execute($pdo_prepare)) {
										$error = true;
									}
								}
							}

						if (!$error) {
							return true;
						} else {
							return false;
						}
					}
				
				}

				/*	*/
	 			
	 		} else {
	 			return false;
	 		}
	 	} else {
	 		return false;
	 	}
	}

}
?>