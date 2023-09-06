<?php
class aircrafts_model extends wc_model {

	public function __construct() {
		parent::__construct();
		$this->log = new log();
	}
	public function saveAircraft($data) {
		$result = $this->db->setTable('aircraft_type')
		->setValues($data)
		->runInsert();
		
		if ($result) {
			$this->log->saveActivity("Create Aircraft Type [{$data['title']}]");
		}

		return $result;
	}
	
	public function getAircraft($data) {
		$data = array('id','title','entereddate');
        $result = $this->db->setTable('aircraft_type')
                            ->setFields($data)
                            ->runPagination();

        return $result;
	}

	private function generateSearch($search, $array) {
		$temp = array();
		foreach ($array as $arr) {
			$temp[] = $arr . " LIKE '%" . str_replace(' ', '%', $search) . "%'";
		}
		return '(' . implode(' OR ', $temp) . ')';
	}

	public function getAircraftById($fields, $id) {
		return $this->db->setTable('aircraft_type')
						->setFields($fields)
						->setWhere("id = '$id'")
						->setLimit(1)
						->runSelect()
						->getRow();
	}
    
	public function updateAircraft($data, $id) {
		$result = $this->db->setTable('aircraft_type')
							->setValues($data)
							->setWhere("id = '$id'")
							->setLimit(1)
							->runUpdate();

		if ($result) {
			$this->log->saveActivity("Update Aircraft [$id]");
		}

		return $result;
	}

	public function deleteAircraft($id) {
		$result =  $this->db->setTable('aircraft_type')
							->setWhere("id = '$id'")
							->setLimit(1)
							->runDelete();
	
		if ($result) {
			$this->log->saveActivity("Delete Airtype Type [$id]");
		}

	return $result;
	}	
	
}
