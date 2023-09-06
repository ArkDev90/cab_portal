<?php
class operations_model extends wc_model {

	public function __construct() {
		parent::__construct();
		$this->log = new log();
	}

	public function saveOperation($data) {
		$result = $this->db->setTable('nature_of_operation')
		->setValues($data)
		->runInsert();
		
		if ($result) {
			$this->log->saveActivity("Create Nature of Operation [{$data['title']}]");
		}

		return $result;
	}

	public function getNatureById($fields, $id) {
		return $this->db->setTable('nature_of_operation')
						->setFields($fields)
						->setWhere("id = '$id'")
						->setLimit(1)
						->runSelect()
						->getRow();
	}

	public function getNatureOperation() {
		$result = $this->db->setTable('nature_of_operation')
		->setFields('title, entereddate, id')
		->setOrderBy('id') 
		->runPagination();

		return $result;
	}

	public function updateNatureofOperation($data, $id) {
		$result = $this->db->setTable('nature_of_operation')
							->setValues($data)
							->setWhere("id = '$id'")
							->setLimit(1)
							->runUpdate();

		if ($result) {
			$this->log->saveActivity("Update Nature of Operation [$id]");
		}

		return $result;
	}

	public function deleteNatureofOperation($id) {
			$result =  $this->db->setTable('nature_of_operation')
								->setWhere("id = '$id'")
								->setLimit(1)
								->runDelete();

			//echo $this->db->getQuery();
		
			if ($result) {
				$this->log->saveActivity("Delete Nature of Operation [$id]");
			}
			
		return $result;
	}

	public function checkTitle($title) {
		$result = $this->db->setTable('nature_of_operation')
							->setFields('title')
							->setWhere("title = '$title'")
							->setLimit(1)
							->runSelect(false)
							->getRow();

		if ($result) {
			return false;
		} else {
			return true;
		}
	}
}
