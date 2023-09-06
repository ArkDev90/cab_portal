<?php
class register extends wc_model {

	public function getCountryList() {
		$result = $this->db->setTable('country')
							->setFields('id ind, country val')
							->runSelect()
							->getResult();

		return $result;
	}

	public function getClient($fields, $client_id) {
		$result = $this->db->setTable('client')
							->setFields($fields)
							->setWhere("id = '$client_id'")
							->setLimit(1)
							->runSelect()
							->getRow();

		return $result;
	}

	public function getCompanyNature($client_id) {
		$result = $this->db->setTable('client c')
							->setFields('n.title')
							->innerJoin('client_nature cn ON c.id = cn.client_id AND c.companycode = cn.companycode')
							->innerJoin('nature_of_operation n ON cn.nature_id = n.id AND cn.companycode = n.companycode')
							->setWhere("c.id = '$client_id'")
							->runSelect()
							->getResult();

		return $result;
	}

	public function registerUser($data, $client_id) {
		$data['client_id'] = $client_id;
		$data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
		$result = $this->db->setTable('client_user')
							->setValues($data)
							->runInsert();

		return ($result) ? $this->db->getInsertId() : $result;
	}

	public function updateClient($data, $client_id) {
		$result = $this->db->setTable('client')
							->setValues($data)
							->setWhere("id = '$client_id'")
							->setLimit(1)
							->runUpdate();

		return $result;
	}

	public function updateClientUser($data, $user_id) {
		$data['user_type'] = 'User';
		$result = $this->db->setTable('client_user')
							->setValues($data)
							->setWhere("id = '$user_id'")
							->setLimit(1)
							->runUpdate();

		return $result;
	}

	public function updateGSAUser($data, $user_id) {
		$data['user_type'] = 'GSA';
		$result = $this->db->setTable('gsa_user')
							->setValues($data)
							->setWhere("id = '$user_id'")
							->setLimit(1)
							->runUpdate();

		return $result;
	}

	public function clearTempUserAccess($client_id) {
		$data = array(
			'temp_username'	=> '',
			'temp_password'	=> ''
		);

		$result = $this->db->setTable('client')
							->setValues($data)
							->setWhere("id = '$client_id'")
							->setLimit(1)
							->runUpdate();

		return $result;
	}

}