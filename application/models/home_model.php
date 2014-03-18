<?php
	defined("BASEPATH") or die;
	
	class Home_model extends CI_Model {
		public function __construct(){
			return parent::__construct();
		}

		public function getRecords(){
			return array();
		}
	}

?>