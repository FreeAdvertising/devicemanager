<?php
	defined("BASEPATH") or die;
	
	class Home_model extends CI_Model {
		public function __construct(){
			return parent::__construct();
		}

		public function getData(){
			//get values for "There are currently X users using X devices and X waiting."
			$_output = array();

			$query = $this->db->query("SELECT device_id FROM device_manager_devices WHERE status > 1");
			$_output[] = sizeof($query->result_object());

			$query = $this->db->query("SELECT device_id FROM device_manager_devices WHERE status > 1");
			$_output[] = sizeof($query->result_object());

			$query = $this->db->query("SELECT device_id FROM device_manager_devices WHERE status = 4");
			$_output[] = sizeof($query->result_object());

			return $_output;			
		}
	}

?>