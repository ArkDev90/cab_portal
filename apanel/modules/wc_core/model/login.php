<?php

class login extends wc_model {



	private $validation = array();



	public function getUserAccess($username, $password) {

		$cab_user_query		= $this->db->setTable(PRE_TABLE . '_users')

									->setFields("username id, '" . PRE_TABLE . "_users' user_table, username, password, companycode, groupname, CONCAT(firstname, ' ', middlename, ' ', lastname) name, 1 apanel_user, '' client_id")

									->setWhere("username = '$username'")

									->buildSelect(false);



		$client_user_query	= $this->db->setTable('client_user cu')

									->setFields("cu.id, 'client_user' user_table, username, password, cu.companycode, user_type groupname, CONCAT(fname, ' ', mname, ' ', lname) name, 0 apanel_user, client_id")

									->innerJoin('client c ON c.id = cu.client_id AND c.companycode = cu.companycode')

									->setWhere("username = '$username' and c.status <> 'Terminated'")

									->buildSelect(false);



		$gsa_user_query		= $this->db->setTable('gsa_user')

									->setFields("id, 'gsa_user' user_table, username, password, companycode, user_type groupname, CONCAT(fname, ' ', mname, ' ', lname) name, 0 apanel_user, 0 client_id")

									->setWhere("username = '$username'")

									->buildSelect(false);



		$temp_company_user	= $this->db->setTable('client')

									->setFields("'', 'client' user_table, temp_username username, temp_password password, companycode, 'Temp Admin' groupname, '' name, 0 apanel_user, id client_id")

									->setWhere("temp_username = '$username'")

									->buildSelect(false);



		$result = $this->db->setTable("($cab_user_query UNION $client_user_query UNION $gsa_user_query UNION $temp_company_user) a")

							->setFields("id, user_table, client_id, username, password, companycode, groupname, name, apanel_user")

							->runSelect(false)

							->setLimit(1)

							->getResult();



		if ($result) {

			foreach ($result as $row) {

				if (password_verify($password, $row->password)) {

					return array('id' => $row->id, 'user_table' => $row->user_table, 'client_id' => $row->client_id, 'username' => $row->username, 'apanel_user' => $row->apanel_user, 'companycode' => $row->companycode, 'groupname' => $row->groupname, 'name' => $row->name);

				}

			}

			return false;

		} else {

			return false;

		}

	}



	public function checkLockedAccount($username) {

		$result = $this->db->setTable(PRE_TABLE . '_users')

							->setFields('locktime')

							->setWhere("username = '$username' AND locktime >= NOW()")

							->setLimit(1)

							->runSelect(false)

							->getRow();



		return $result;

	}

	

	public function getGSAClientList($username) {

		$result = $this->db->setTable('gsa_user gu')

							->setFields('client_id, c.name')

							->innerJoin('gsa_user_client guc ON guc.gsa_user_id = gu.id AND guc.companycode = gu.companycode')

							->innerJoin('client c ON c.id = guc.client_id AND c.companycode = guc.companycode')

							->setWhere("username = '$username'")

							->runSelect(false)

							->getResult();



		return $result;

	}

	

}