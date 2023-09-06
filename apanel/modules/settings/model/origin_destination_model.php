<?php
class origin_destination_model extends wc_model {

	public function __construct() {
		parent::__construct();
		$this->log = new log();
	}

	public function saveOrigin($data) {
		$result = $this->db->setTable('origin_destination')
		->setValues($data)
		->runInsert();
		
		if ($result) {
			$this->log->saveActivity("Create Origin / Destination [{$data['title']}]");
		}

		return $result;
	}

	public function saveForm($data) {
		$result = $this->db->setTable('origin_destination_form')
		->setValuesFromPost($data)
		->runInsert();
		
		if ($result) {
			$this->log->saveActivity("Create Form");
		}

		return $result;
	}

	public function getOrigin($data,$sort) {
		if($sort != 'none' && $sort != ''){
			$condition = " AND odf.report_form_id = '$sort'";
		}else{
			$condition = '';
		}

		$data = array('od.id as id','od.title as title','od.code as code','od.type as type','ep.title as part','od.entereddate as entereddate');
		$result = $this->db->setTable('origin_destination as od')
							->leftJoin('earth_part as ep ON ep.id = od.part')
							->leftJoin("origin_destination_form odf ON odf.origin_destination_id = od.id")
							->setWhere("ep.id = od.part $condition")
							->setFields($data)
							->setGroupBy('od.id')
							->setOrderBy('title ASC')
							->runPagination();
							// echo $this->db->getQuery();
        return $result;
	}

	public function getFormList() {
		$result = $this->db->setTable('report_form')
                            ->setFields('id,title,code')
                            ->setOrderBy('id') 
                            ->runSelect()
	 						->getResult();

		return $result;
	}
	
	public function getFormId($origin_id) {
		$result = $this->db->setTable('report_form rf')
		->leftJoin("origin_destination_form as odf ON odf.report_form_id = rf.id AND origin_destination_id = '$origin_id'")
		->setFields('rf.id, title, odf.report_form_id')
		->setOrderBy('rf.id')
		->setGroupBy('title')
		->runSelect()
		->getResult();

		return $result;
	}

	public function getOriginById($fields, $id) {
		return $this->db->setTable('origin_destination')
						->setFields($fields)
						->setWhere("id = '$id'")
						->setLimit(1)
						->runSelect()
						->getRow();
	}

	public function getFormByCode($code) {
		return $this->db->setTable('origin_destination')
						->setFields('id')
						->setWhere("code = '$code'")
						->runSelect()
						->getRow();
	}

	public function updateOrigin($origin, $origin_id) {
		$result = $this->db->setTable('origin_destination_form')
		->setWhere("origin_destination_id = '$origin_id'")
		->runDelete();
		
		$result1 = $this->db->setTable('origin_destination')
							->setValues($origin)
							->setWhere("id = '$origin_id'")
							->setLimit(1)
							->runUpdate();
		
		return $result;
	}

	public function saveReportFormId($check, $origin_id) {
		// $marion = array('origin_destination_id', 'report_form_id');

		$array = array();
		
		foreach($check as $row => $val) :
			$rf['origin_destination_id'] = $origin_id;
			$rf['report_form_id']= $val;
			$array[] = $rf;
		endforeach;
		$result = $this->db->setTable('origin_destination_form')
		->setValues($array)
		->runInsert();

		return $result;
	}

	public function deleteOrigin($id) {
		$result =  $this->db->setTable('origin_destination')
							->setWhere("id = '$id'")
							->setLimit(1)
							->runDelete();
	
		if ($result) {
			$this->log->saveActivity("Delete Origin / Destination [$id]");
		}

	return $result;
    }
    
    public function getDomesticList($search = '') {
		$result = $this->db->setTable('earth_part')
						->setFields('id ind, title val')
						->setWhere('type = "Domestic"')
						->setOrderBy('title')
						->runSelect()
						->getResult();

		return $result;
	}
	
	public function getInternationalList($search = '') {

		$result = $this->db->setTable('earth_part')
						->setFields('id ind, title val')
						->setWhere('type = "International"')
						->setOrderBy('title')
						->runSelect()
						->getResult();

		return $result;
	}
	
	public function getReportForms($search = '') {
		$result = $this->db->setTable('report_form')
						->setFields('id ind, title val')
						->setOrderBy('title')
						->runSelect()
						->getResult();

		return $result;
	}

	public function getCheckedItems($id){
		$result = $this->db->setTable('origin_destination_form')
		->setFields('origin_destination_id, report_form_id')
		->setWhere("origin_destination_id = '$id'")
		->runSelect()
		->getResult();

return $result;
	}
	
}
