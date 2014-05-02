<?php
	defined("BASEPATH") or die;
	
	class Modify_device_model extends CI_Model {
		private $_uuid;
		
		public function __construct(){
			return parent::__construct();
		}

		public function modify($data){
			$uuid = UUID::convert($data["uuid"]);
			$this->_uuid = $uuid;
			$device_id = $this->product->getDeviceID($uuid);

			$query = $this->db->query("UPDATE device_manager_devices SET 
					uuid = ?, 
					name = ?, 
					meta_type = ?, 
					meta_ram = ?, 
					meta_hdd = ?, 
					os = ?, 
					status = ?, 
					location = ? 
				WHERE 
					device_id = ?", 
				array(
					$data["uuid"],
					$data["name"],
					$data["meta_type"],
					$data["meta_ram"],
					$data["meta_hdd"],
					$data["os"],
					$data["status"],
					$data["location"],
					$device_id,
				));

			return $query;
		}

		public function getUUID(){
			return $this->_uuid;
		}
	}

?>