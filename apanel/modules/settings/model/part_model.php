<?php
class part_model extends wc_model {

	public function __construct() {
		parent::__construct();
		$this->log = new log();
	}

	public function savePart($data) {
		$result = $this->db->setTable('earth_part')
		->setValues($data)
		->runInsert();
		
		if ($result) {
			$this->log->saveActivity("Create Part [{$data['title']}]");
		}

		return $result;
	}
	
	public function getPart() {
		$data = array(
			'id',
			'title','code','type','entereddate'
		);
		
		/* public function getPart() {
		$data = array(
			'id',
			'title','code','entereddate'
		); --BU 08.23.2019*/
        $result = $this->db->setTable('earth_part')
                            ->setFields($data)
                            ->runPagination();

        return $result;
	}

	public function getPartById($fields, $id) {
		return $this->db->setTable('earth_part')
						->setFields($fields)
						->setWhere("id = '$id'")
						->setLimit(1)
						->runSelect()
						->getRow();
	}

	public function updatePart($data, $id) {
		$result = $this->db->setTable('earth_part')
							->setValues($data)
							->setWhere("id = '$id'")
							->setLimit(1)
							->runUpdate();

		if ($result) {
			$this->log->saveActivity("Update Part [$id]");
		}

		return $result;
    }
    
    public function deletePart($id) {
		$result =  $this->db->setTable('earth_part')
							->setWhere("id = '$id'")
							->setLimit(1)
							->runDelete();
	
		if ($result) {
			$this->log->saveActivity("Delete Part [$id]");
		}

	return $result;
    }


}
