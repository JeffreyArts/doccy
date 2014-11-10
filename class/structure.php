<?php
class Structure {
	function getAllTypes() {
		global $pdo;

		$qry = 'SELECT * FROM `structure_type`';
		$i=0;
		foreach ($pdo->query($qry) as $row) {
			$tmp[$i]['id'] 			= $row['id'];	
			$tmp[$i]['name'] 		= $row['name'];	
			$i++;
		}
		return $tmp;
	}

	function getAllProjects() {
		global $pdo;

		$qry = 'SELECT * FROM `structure_project`';
		$i=0;
		foreach ($pdo->query($qry) as $row) {
			$tmp[$i]['id'] 			= $row['id'];	
			$tmp[$i]['name'] 		= $row['name'];	
			$tmp[$i]['description'] = $row['description'];	
			$i++;
		}
		return $tmp;
	}
}
?>