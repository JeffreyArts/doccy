<?php
class StructureElements {
	private $elements;
	public $tree;

	private function checkElementsList() {
		if (!is_array($this->elements)) {
			return false;
		} else {
			return true;
		}
	}	


	public function addElementFromArray($id,$array) {
		$this->elements[$id] = new StructureElement($array);
	}

	public function number_of_elements() {
		return count($this->elements);
	}

	public function getAllClasses() {
		if (!$this->checkElementsList()) { return false; }
		
		foreach ($this->elements as $v) {
			if ($v->type_id==1) {
				$arr[] = $v;
			}
		}

		if (is_array($arr)) {
			return $arr;
		} else {
			return false;
		}

	}

	public function setTreeArray() {
		if (!$this->checkElementsList()) { return false; }

		foreach ($this->elements as $v) {
			if (isset($new_arr[$v->parent_id])) {
				$new_arr[$v->parent_id]->setChild($v);
			} else {
				$new_arr[$v->id] = $v;
			}
		}

		//print "<pre>".print_r($new_arr,1)."</pre>";

		$this->tree = $new_arr;
	}

	/*public function getTreeLevel($lvl) {
		if (is_numeric($lvl) && $lvl <= $this->levels) {
			return $this->tree[$lvl];
		}
	}*/
}
?>