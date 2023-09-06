<?php
class user_mgt_model extends wc_model {

	public function __construct() {
		parent::__construct();
		$this->log = new log();
	}

	public function saveUser($data, $nature) {
		$data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
		$result = $this->db->setTable(PRE_TABLE . '_users')
							->setValues($data)
							->runInsert();
		
		if ($result) {
			$this->updateUserNatureOnCreate($nature, $data['username']);
			$this->log->saveActivity("Create User [{$data['username']}]");
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

	public function getUserInfo($username) {
		$result = $this->db->setTable(PRE_TABLE . '_users')
							->setFields('firstname, middlename, lastname, email, birthdate, username, registrationdate, question, answer, checktime, phone, country, address')
							->setWhere("username = '$username'")
							->setLimit(1)
							->runSelect()
							->getRow();

		return $result;
	}

	public function updateUserNatureOnCreate($nature, $username) {
		$data['nature_id'] = $nature;
		$data['username'] = $username;

		$this->db->setTable(PRE_TABLE . '_users_nature')
							->setWhere("username = '$username'")
							->runDelete();

		$result = $this->db->setTable(PRE_TABLE . '_users_nature')
							->setValuesFromPost($data)
							->runInsert();

		return $result;
	}

	public function updateUserNature($nature, $username) {
		$result = $this->db->setTable('wc_users_nature')
		->setWhere("username = '$username'")
		->runDelete();

		if ($result) {
			$nature['username'] = $username;

			$result = $this->db->setTable('wc_users_nature')
			->setValuesFromPost($nature)
			->runInsert();
		}
		
		if ($result) {
			$this->log->saveActivity("Update User Nature of Operation");
		}
		return $result;
	}

	public function getUserDetails($fields, $username) {
		$result = $this->db->setTable('wc_users')
		->setFields($fields)
		->setWhere("username = '$username'") 
		->runSelect()
		->getRow();
		return $result;
	}

	public function getUserPassword($username) {
		$result = $this->db->setTable('wc_users')
		->setFields('password')
		->setWhere("username = '$username'") 
		->runSelect()
		->getRow();
		//var_dump($username, $result);
		return $result;
	}

	public function editUserPassword($username, $password) {
		$data['password'] = password_hash($password, PASSWORD_BCRYPT);
		$result = $this->db->setTable('wc_users')
							->setValues($data)
							->setWhere("username = '$username'")
							->setLimit(1)
							->runUpdate();

		if ($result) {
			$this->log->saveActivity("Update User Password [$username]");
		}

		return $result;
	}

	public function getCheckUserNature($username) {
		$result = $this->db->setTable('nature_of_operation n')
		->leftJoin(PRE_TABLE . "_users_nature wun ON wun.nature_id = n.id AND wun.username = '$username'")
		->setFields('n.id, title, nature_id')
		->setOrderBy('n.id')
		->runSelect()
		->getResult();

		return $result;
	}

	public function getAirtypeList() {
		$result = $this->db->setTable('nature_of_operation')
							->setFields('id, title')
							->runSelect()
							->getResult();

		return $result;
	}

	public function getSecQuestionList() {
		$result = $this->db->setTable(PRE_TABLE . '_option')
							->setFields('code ind, value val')
							->setWhere("type = 'sec_question'")
							->runSelect(false)
							->getResult();

		return $result;
	}

	public function getCountryList() {
		$result = $this->db->setTable('country')
							->setFields('id ind, country val')
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
		$result = $this->db->setTable(PRE_TABLE . '_users')
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

	public function getUserPagination($sort, $search) {
		$condition = '';
		$condition .= $this->generateSearch($search, array('code' , 'name'));
		$sort		= ($sort) ? $sort : 'username';
		$fields = array(
			'username',
			'password',
			'email',
			'stat',
			'is_login',
			'useragent',
			'wu.groupname groupname',
			'firstname',
			'lastname',
			'middlename',
			'phone',
			'mobile'
		);
		$result = $this->db->setTable(PRE_TABLE . "_users wu")
							->innerJoin(PRE_TABLE . "_user_group wug ON wug.groupname = wu.groupname AND wug.companycode = wu.companycode")
							->setFields($fields)
							->setOrderBy($sort)
							->runPagination();

		return $result;
	}

	public function getGroupList($search = '') {
		$condition = '';
		if ($search) {
			$condition = " groupname = '$search'";
		}
		$result = $this->db->setTable(PRE_TABLE . '_user_group')
						->setFields('groupname ind, groupname val')
						->setWhere($condition)
						->setOrderBy('groupname')
						->runSelect()
						->getResult();

		return $result;
	}

	public function saveUserCSV($values) {
		foreach ($values as $key => $row) {
			$values[$key]['password'] = password_hash($row['password'], PASSWORD_BCRYPT);
		}

		$result = $this->db->setTable(PRE_TABLE . '_users')
							->setValues($values)
							->runInsert();

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