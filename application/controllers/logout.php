<?php

	defined("BASEPATH") or die;

	class Logout extends CI_Controller {
		public function __construct(){
			parent::__construct();
		}

		public function index(){
			$this->session->sess_destroy();
			
			return redirect(base_url());
		}
	}

?>