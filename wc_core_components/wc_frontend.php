<?php

class backend {



	private $module_link = '';

	private $module_folder = '';

	private $module_file = '';

	private $module_function = '';

	private $args = array();



	public function __construct() {

		// AUTOLOADER

		function autoload_function($class) {

			if (file_exists("system/$class.php")) {

				require_once "system/$class.php";

			} else if (defined('MODULE_PATH') && file_exists(MODULE_PATH . "/model/$class.php")) {

				require_once MODULE_PATH . "/model/$class.php";

			} else {

				$dir = new RecursiveDirectoryIterator(PRE_PATH . CORE_COMPONENTS . 'system');

				foreach (new RecursiveIteratorIterator($dir) as $file){

					if (strpos($file , $class . '.php') !== false) {

						include_once $file;

						break;

					}

				}

			}

		}

		spl_autoload_register('autoload_function');

		$this->session = new session();

	}



	public function getSession() {

		$login = $this->session->get('login');

		$companycode	= (isset($login['companycode']))	? $login['companycode']	: 'CAB';

		$groupname		= (isset($login['groupname']))		? $login['groupname']	: '';

		$username		= (isset($login['username']))		? $login['username']	: '';

		$name			= (isset($login['name']))			? $login['name']		: '';

		$client_id		= (isset($login['client_id']))		? $login['client_id']	: '';

		$id				= (isset($login['id']))				? $login['id']			: '';

		$user_table		= (isset($login['user_table']))		? $login['user_table']	: '';

		define('COMPANYCODE', $companycode);

		define('GROUPNAME', $groupname);

		define('USERNAME', $username);

		define('USER_NAME', $name);

		define('USER_ID', $id);

		define('USER_TABLE', $user_table);

		define('CLIENT_ID', $client_id);

	}



	public function checkAccessType($array, $access) {

		foreach ($array as $value) {

			if (strpos($access, $value) !== false) {

				return true;

			}

		}

		return false;

	}



	public function getModulePath() {

		$subfolders	= explode('/', SUB_FOLDER);

		$subfolder	= $subfolders[0];

		$this->getSession();

		$db			= new db();

		$url		= new url();

		$session	= new session();

		$input		= new input();



		$folders	= array(

			'login',

			'forgot',

			'register',

			'notification'

		);



		if (in_array($subfolder, $folders)) {

			$this->module_folder = 'wc_core';

			$this->module_file = $subfolder;

			$this->module_function = isset($subfolders[1]) ? $subfolders[1] : 'index';

			$this->args = isset($subfolders[2]) ? array($subfolders[2]) : array();

			define('MODULE_URL', BASE_URL . $subfolder);

			define('MODULE_TASK', $subfolder);

			define('MODULE_NAME', 'Login');

		} else if ($subfolder != '' && $subfolder != 'ajax') {

			$paths = $db->setTable(PRE_TABLE . '_modules')

						->setFields('module_name, module_group, module_link, folder, file, default_function')

						->setWhere("'" . SUB_FOLDER . "/' LIKE module_link AND active")

						->runSelect(false)

						->getRow();

			

			if ($paths) {

				$this->module_link = $paths->module_link;

				$this->module_folder = $paths->folder;

				$this->module_file = $paths->file;

				$link_args = explode('/', rtrim($paths->module_link, '/'));

				$args = explode('/', rtrim(SUB_FOLDER, '/'));

				$module_url = array();

				$this->module_function = $paths->default_function;

				foreach ($link_args as $key => $value) {

					if ($value == '%' && isset($args[$key])) {

						$this->module_function = $args[$key];

					}

					unset($args[$key]);

				}

				$this->args = $args;

				define('MODULE_URL', BASE_URL . str_replace('%', '', $paths->module_link));

			} else if (DEBUGGING) {

				echo '<p><b>Unable to find Path in Database:</b> ' . SUB_FOLDER . '</p>';

				exit();

			}

		} else {

			$this->module_folder = 'home';

			$this->module_file = 'home';

			$this->module_function = ($subfolder == 'ajax') ? 'ajax' : 'index';

			unset($subfolders[0]);

			$this->args = $subfolders;

			define('MODULE_URL', BASE_URL);

		}

		$result = $db->setTable('client')

						->setFields('name, permitdate, permitvalidity, code, email')

						->setWhere("id = '" . CLIENT_ID . "'")

						->runSelect()

						->getRow();

		

		$companyname = ($result) ? $result->name : '';
		$permitdate = ($result) ? $result->permitdate : '';//larkus
		$permitvalidity = ($result) ? $result->permitvalidity : '';//larkus
		$email = ($result) ? $result->email : '';//larkus
		
		$code = ($result) ? $result->code : '';//larkus

		define('COMPANY_NAME', $companyname);
		define('PERMIT_DATE', $permitdate);//larkus
		define('PERMIT_VALIDITY', $permitvalidity);//larkus
		define('COMPANY_EMAIL', $email);//larkus
		define('CODE', $code);//larkus

		define('MODULE_PATH', 'apanel/modules/' . $this->module_folder);

		return MODULE_PATH . '/' . PAGE_TYPE . '/controller/' . $this->module_file . '.php';

	}



	public function getPage() {

		$page = explode('/', str_replace(str_replace('%', '', $this->module_link), '', SUB_FOLDER));

		if (in_array($page[0], array('add', 'view', 'edit', 'delete', 'listing', 'print'))) {

			return $page[0];

		} else if ($page[0] == 'ajax') {

			return (isset($page[1])) ? $page[1] : false;

		} else {

			return false;

		}

	}



	public function loadModule() {

		$path = $this->getModulePath();

		if (file_exists($path)) {

			require_once $path;

			$controller = new controller;

			if (method_exists($controller,$this->module_function)) {

				call_user_func_array(array($controller, $this->module_function), $this->args);

			} else if (DEBUGGING) {

				echo '<p><b>Unable to find Controller Function:</b> ' . $this->module_function . '()</p>';

			} else {

				echo 'show 404';

			}

		} else if (DEBUGGING) {

			echo '<p><b>Unable to find Controller File:</b> ' . $path . '</p>';

			exit();

		} else {

			echo 'show 404';

		}

	}



}

$backend	= new backend();

$url		= new url();

$access		= new access();

$input		= new input();

$allowed	= array(

	'login',

	'login/ajax/verify_login',

	'forgot',

	'forgot/ajax/ajax_reset_pw',

	'register',

	'notification',

	'register/ajax/ajax_update_client',

	'register/ajax/ajax_register_user',

	'register/ajax/ajax_check_username'

);



define('MODAL', $input->post('modal'));

if (SUB_FOLDER == 'logout') {

	$access->logoutUser();

	$url->redirect(BASE_URL);

} else if ($access->isUser() || in_array(SUB_FOLDER, $allowed)) {

	$backend->loadModule();

} else if ($access->isApanelUser()) {

	$url->redirect(BASE_URL . 'apanel');

} else {

	if ($input->isPost) {

		header('Content-type: application/json');

		echo json_encode(

				array(

					'show_login_form' => true

				)

			);

	} else {

		$access->logoutUser();

		$redirect_url = $input->get('redirect');

		$redirect = (BASE_URL == FULL_URL) ? '' : '?redirect=' . (($redirect_url) ? $redirect_url : base64_encode(FULL_URL) );

		$url->redirect(BASE_URL . 'login' . $redirect);

	}

}