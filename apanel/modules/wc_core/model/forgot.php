<?php
class forgot extends wc_model {

	public function resetPassword($username, $password) {
		$data['password'] = password_hash($password, PASSWORD_BCRYPT);

		$result = $this->db->setTable(PRE_TABLE . '_users')
							->setValues($data)
							->setWhere("username = '$username'")
							->setLimit(1)
							->runUpdate(false);

		return $result;
	}

}