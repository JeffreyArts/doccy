<?php
/****************************

Eerste parameter verwijderen, ook wanneer er een 2e parameter is

*////////////////////////////////*/
class StructureElement {

	public $id;
	public $parent_id;
	public $name;
	public $type_id;
	public $type_name;
	public $description;
	public $children;
	public $parameter;
	public $return;

	function __construct($data=false) {

		if (is_array($data)) {
			$this->setElement($data);
		}
		if (is_numeric($data)) {
			$this->id = $data;
			$array = $this->loadElement();
		}
	}

	private function loadElement() {
		global $pdo;

	// Load element properties
		$qry = "SELECT 
				`element`.`id` 			as 'id',
				`element`.`type_id` 	as 'type_id',
				`type`.`name` 			as 'type_name',
				`element`.`parent_id` 	as 'parent_id',
				`element`.`name` 		as 'name',
				`element`.`description` as 'description'
					
				FROM `structure_element` AS `element`
				LEFT JOIN `structure_type` AS `type` ON `element`.`type_id` = `type`.`id`
				WHERE `element`.`id` =  '$this->id' 
				LIMIT 0,1; ";


		foreach ($pdo->query($qry) as $row) 
		{
			$this->setElement($row);
		}
		unset ($qry);
		if ($this->type_id == 3) 
		{
		// Load element->parameter properties
			$qry = "SELECT `name`, `type`, `description` FROM `structure_element_parameter` 
					WHERE `element_id` =  '$this->id'; ";

			$i=1;
			foreach ($pdo->query($qry) as $row) {
				$this->parameter[$i]['name'] = $row['name'];
				$this->parameter[$i]['type'] = $row['type'];
				$this->parameter[$i]['description'] = $row['description'];
				$i++;
			}
			unset ($qry);

		// Load element->return properties
			$qry = "SELECT `name`, `type`, `description` FROM `structure_element_return` 
					WHERE `element_id` =  '$this->id'; ";

			$i=1;
			foreach ($pdo->query($qry) as $row) 
			{
				$this->return[$i]['name'] = $row['name'];
				$this->return[$i]['type'] = $row['type'];
				$this->return[$i]['description'] = $row['description'];
				$i++;
			}
			unset ($qry);
		}

	// Load parent element properties
		$qry = "SELECT 
				`element`.`id` 			as 'id',
				`element`.`type_id` 	as 'type_id',
				`type`.`name` 			as 'type_name',
				`element`.`parent_id` 	as 'parent_id',
				`element`.`name` 		as 'name',
				`element`.`description` as 'description'
					
				FROM `structure_element` AS `element`
				LEFT JOIN `structure_type` AS `type` ON `element`.`type_id` = `type`.`id`
				WHERE `element`.`parent_id` =  '$this->id' 
				";
		foreach ($pdo->query($qry) as $row) 
		{
			$tmp = new StructureElement($row);
			$this->setChild($tmp);
		}
	}



	public function saveElement() {
		global $pdo;
		$pdo_prepare[':type_id'] = $this->type_id; 
		$pdo_prepare[':parent_id'] = $this->parent_id; 
		$pdo_prepare[':name'] = $this->name; 
		$pdo_prepare[':description'] = $this->description; 


		$set_value = '';
		foreach ($pdo_prepare as $k=> $v) {
			if (empty($v)) { unset($pdo_prepare[$k]); } else {
				$set_value .= "`".str_replace(':','',$k)."` = ".$k.", ";
			}
		}
		$set_value = rtrim($set_value, ", ");

		$pdo_prepare[':id'] = $this->id; 

		$qry = "UPDATE `structure_element` 
				SET ".$set_value."
				WHERE `id` = :id;"; 
		$statement = $pdo->prepare($qry);
		if (!$statement->execute($pdo_prepare)) {
			$error = true;
		}

		// Add parameters when available
		if (isset($this->parameter)) 
		{
			unset($pdo_prepare);
			$qry = "DELETE FROM `structure_element_parameter` WHERE `element_id` = " . $this->id; 
			$pdo->query($qry); 

			$pdo_prepare[':element_id'] =  $this->id; 

			foreach ($this->parameter as $k=>$v) 
			{
				if (!empty($v['name'])) 
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
		}

		// Add returns when available
		if (isset($this->return)) {

			unset($pdo_prepare);
			$qry = "DELETE FROM `structure_element_return` WHERE `element_id` = " . $this->id; 
			$pdo->query($qry); 

			foreach ($this->return as $k=>$v) 
			{
				$pdo_prepare[':name'] = $v['name'];
				$pdo_prepare[':type'] = $v['type'];
				$pdo_prepare[':description'] = $v['description'];

				$qry = "INSERT INTO `structure_element_return` 
							(`element_id`,`name`,`type`,`description`) 
							VALUES (" . $this->id . ", :name, :type, :description);"; 
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




	public function deleteElement() 
	{
		if ($this->hasChildren()) 
		{
			return false;
		}

		global $pdo;

		
		$pdo->query("DELETE FROM `structure_element` WHERE `structure_element`.`id` = " . $this->id);
		$pdo->query("DELETE FROM `structure_element_return` WHERE `element_id` = " . $this->id);
		$pdo->query("DELETE FROM `structure_element_parameter` WHERE `element_id` = " . $this->id);
	
		return true;
		
	}

	public function setElement($arr) {

		if (isset($arr['type_id']) && is_numeric($arr['type_id'])) {
			$this->type_id = $arr['type_id'];
		}
		if (isset($arr['type_name'])) {
			$this->type_name = $arr['type_name'];
		}

		if (isset($arr['parent_id']) && is_numeric($arr['parent_id'])) {
			$this->parent_id = $arr['parent_id'];
		}

		if (isset($arr['description'])) {
			$this->description = $arr['description'];
		}

		if (isset($arr['id'])) {
			$this->id = $arr['id'];
		}

		if (isset($arr['name'])) {
			$this->name = $arr['name'];
		}

		if ($arr['type_id'] == 3) {
		// Parameters check
			unset($this->parameter);

			$i=1;
			while (isset($arr['parameter_name_'.$i]) && !empty($arr['parameter_name_'.$i])) 
			{
				$this->parameter[$i]['name'] = $arr['parameter_name_'.$i];
				$this->parameter[$i]['description'] = $arr['parameter_description_'.$i];
				$this->parameter[$i]['type'] = $arr['parameter_type_'.$i];
				$i++;
			}
			if (is_array($this->parameter)) {
				$this->parameter = array_values($this->parameter);
			}
		// Return check
			unset($this->return);

			$i=1;
			while (isset($arr['return_name_'.$i]) && !empty($arr['return_name_'.$i])) 
			{
				if (!empty($arr['return_name_'.$i])) 
				{
					$this->return[$i]['name'] = $arr['return_name_'.$i];
					$this->return[$i]['description'] = $arr['return_description_'.$i];
					$this->return[$i]['type'] = $arr['return_type_'.$i];
				}
				$i++;
			}	

			if (is_array($this->return)) {
				$this->return = array_values($this->return);
			}
		}

		return true;
	}


	public function setChild($object) {
		if (!is_object($object)) {
			return false;
		} else {
			$this->children[] = $object;
		}
	}

	public function hasChildren() {
		if (is_array($this->children)) {
			return true;
		} else {
			return false;
		}

	}


	public function hasParent() {
		if ($this->parent_id > 0) {
			return true;
		} else {
			return false;
		}
	}
	public function getAll() {
		$tmp = array(
			'id'			=> $this->id,
			'type_id'		=> $this->type_id,
			'parent_id'		=> $this->parent_id,
			'name'			=> $this->name,
			'type_name'		=> $this->type_name,
			'description'	=> $this->description
		);

		if (isset($this->parameter)) {
			$tmp['parameter'] = $this->parameter;
		} 
		if (isset($this->return)) {
			$tmp['return'] = $this->return;
		}
		if (isset($this->hasChildren)) {
			$tmp['children'] = $this->children;
		}

		return $tmp;
	}
	public function get($value) {
		return $this->$value;
	}




}
?>