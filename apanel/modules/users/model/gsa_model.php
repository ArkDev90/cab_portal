<?php
class gsa_model extends wc_model {

	public function __construct() {
		parent::__construct();
		$this->log = new log();
	}

	public function getGSAPagination($search) {
		$condition = '';
		$condition .= $this->generateSearch($search, array('company' , 'fname', 'fname', 'lname', 'email'));

		$result = $this->db->setTable('gsa_user')
							->setFields('id, company, fname, mname, lname, email, status')
							->setWhere($condition)
							->runPagination();

		return $result;
	}

	public function getGSA($fields, $gsa_user_id) {
		$result = $this->db->setTable('gsa_user')
							->setFields($fields)
							->setWhere("id = '$gsa_user_id'")
							->setLimit(1)
							->runSelect()
							->getRow();

		return $result;
	}

	public function saveGSA($data, $client, $nature) {
		$data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
		$result = $this->db->setTable('gsa_user')
							->setValues($data)
							->runInsert();

		if ($result) {
			$this->log->saveActivity("Create GSA User [{$data['username']}]");
			$gsa_user_id = $this->db->getInsertId();
			$this->saveGSAClient($nature, $nature, $gsa_user_id);
		}

		return $result;
	}

	public function updateGSA($data, $gsa_user_id) {
		$result = $this->db->setTable('gsa_user')
							->setValues($data)
							->setWhere("id = '$gsa_user_id'")
							->setLimit(1)
							->runUpdate();

		return $result;
	}

	public function getGSAClient($gsa_user_id) {
		$result = $this->db->setTable('gsa_user_client guc')
							->innerJoin('client c ON c.id = guc.client_id AND c.companycode = guc.companycode')
							->setFields('name')
							->setWhere("gsa_user_id = '$gsa_user_id'")
							->runSelect()
							->getResult();

		return $result;
	}

	public function saveGSAClient($client, $nature, $gsa_user_id) {
		$data = array(
			'gsa_user_id'	=> $gsa_user_id,
			'client_id'		=> $client
		);
		$result = $this->db->setTable('gsa_user_client')
							->setValuesFromPost($data)
							->runInsert();

		if ($result) {
			$this->saveGSANature($nature, $gsa_user_id);
		}

		return $result;
	}

	public function saveGSANature($nature, $gsa_user_id) {
		$data = array(
			'gsa_user_id'	=> $gsa_user_id,
			'nature_id'		=> $nature
		);
		$result = $this->db->setTable('gsa_user_nature')
							->setValuesFromPost($data)
							->runInsert();

		if ($result) {

		}

		return $result;
	}

	public function updateUser($data, $username) {
		if (isset($data['password']) && $data['password']) {
			$data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
		} else {
			unset($data['password']);
		}
		$result = $this->db->setTable(PRE_TABLE . '_users')
							->setValues($data)
							->setWhere("username = '$username'")
							->setLimit(1)
							->runUpdate();

		if ($result) {
			$this->log->saveActivity("Update User [$username]");
		}

		return $result;
	}

	public function deleteUsers($data) {
		$error_id = array();
		foreach ($data as $id) {
			$result =  $this->db->setTable(PRE_TABLE . '_users')
								->setWhere("username = '$id'")
								->setLimit(1)
								->runDelete();
		
			if ($result) {
				$this->log->saveActivity("Delete Item Type [$id]");
			} else {
				if ($this->db->getError() == 'locked') {
					$error_id[] = $id;
				}
			}
		}

		return $error_id;
	}

	public function getNatureList() {
		$result = $this->db->setTable('nature_of_operation')
							->setFields('id, title')
							->runSelect()
							->getResult();

		return $result;
	}

	public function getClientFromNature($nature) {
		$nature_list = "'" . implode("', '", $nature) . "'";

		$result	= $this->db->setTable('client c')
							->innerJoin('client_nature cn ON cn.client_id = c.id AND cn.companycode = c.companycode')
							->setFields('c.id, name')
							->setWhere("nature_id IN($nature_list)")
							->setGroupBy('c.id')
							->runSelect()
							->getResult();

		return $result;
	}

	public function resetPassword($username, $password) {
		$data['password'] = password_hash($password, PASSWORD_BCRYPT);

		$result = $this->db->setTable(PRE_TABLE . '_users')
							->setValues($data)
							->setWhere("username = '$username'")
							->setLimit(1)
							->runUpdate();

		if ($result) {
			$this->log->saveActivity("Update User Password [$username]");
		}

		return $result;
	}

	public function getUserEmail($username) {
		$result = $this->db->setTable(PRE_TABLE . '_users')
							->setFields('email')
							->setWhere("username = '$username'")
							->setLimit(1)
							->runSelect()
							->getRow();

		$email = '';

		if ($result) {
			$email = $result->email;
		}

		return $email;
	}

	public function checkUsername($username, $reference) {
		$result = $this->db->setTable('gsa_user')
							->setFields('username')
							->setWhere("username = '$username' AND username != '$reference'")
							->setLimit(1)
							->runSelect(false)
							->getRow();

		if ($result) {
			return false;
		} else {
			return true;
		}
	}

	public function getUserById($fields, $username) {
		return $this->db->setTable(PRE_TABLE . '_users')
						->setFields($fields)
						->setWhere("username = '$username'")
						->setLimit(1)
						->runSelect()
						->getRow();
	}

	public function checkExistingUser($data) {
		$item_types = "'" . implode("', '", $data) . "'";

		$result = $this->db->setTable(PRE_TABLE . '_users')
							->setFields('username')
							->setWhere("username IN ($item_types)")
							->runSelect()
							->getResult();
		
		return $result;
	}

	private function generateSearch($search, $array) {
		$temp = array();
		foreach ($array as $arr) {
			$temp[] = $arr . " LIKE '%" . str_replace(' ', '%', $search) . "%'";
		}
		return '(' . implode(' OR ', $temp) . ')';
	}

}