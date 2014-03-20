<?php
	defined("BASEPATH") or die;
	
	class Devices_model extends CI_Model {
		public function __construct(){
			return parent::__construct();
		}

		public function getRecords(){
			$query = $this->db->query("SELECT device_id, uuid, status, os FROM device_manager_devices ORDER BY device_id");

			if($query->num_rows() > 0){
				return $query->result_object();
			}

			return array();
		}
	}

?>