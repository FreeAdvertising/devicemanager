<?php
	defined("BASEPATH") or die;
	
	class Add_device_model extends CI_Model {
		public function __construct(){
			return parent::__construct();
		}

		public function getRecords(){
			return array();
		}

		public function insert($data){
			//if the device is created as "checked out", assign it to the user assigned as the location of the device
			if((int)$data["status"] === DEVICE_CHECKED_OUT){
				$data["last_checkedout_by"] = $data["location"];
			}

			$query = $this->db->query("INSERT INTO device_manager_devices(`uuid`, `meta_type`, `os`, `meta_ram`, `meta_hdd`, `location`, `status`, `last_checkedout_by`, `name`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)", array(
					strtoupper($data["uuid"]),
					$data["meta_type"],
					$data["os"],
					$data["meta_ram"],
					$data["meta_hdd"],
					$data["location"],
					$data["status"],
					$data["last_checkedout_by"],
					$data["name"],
				));

			return $query;
		}

		public function getUsers(){
			$query = $this->db->query("SELECT u.userid as id, u.username, g.name AS group_name FROM users u LEFT JOIN usergroups g ON u.group_id = g.group_id ORDER BY u.userid");

			return $query->result_object();
		}
	}

?>