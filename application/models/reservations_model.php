<?php
	defined("BASEPATH") or die;
	
	class Reservations_model extends CI_Model {
		public function __construct(){
			return parent::__construct();
		}

		public function getUsers(){
			$query = $this->db->query("SELECT username, userid, (SELECT COUNT(device_id) FROM device_manager_devices WHERE location = userid) as count FROM users ORDER BY count DESC, userid");

			return $query->result_object();
		}

		public function getRecords(){
			$query = $this->db->query("SELECT 
				d.device_id, 
				d.name, 
				d.uuid, 
				d.os, 
				d.location,
				'nope' as status 
				FROM device_manager_assignments_rel a 
				LEFT JOIN device_manager_devices d ON d.device_id = a.device_id
				GROUP BY d.uuid
				ORDER BY d.device_id
				");

			if($query->num_rows() > 0){
				return $query->result_object();
			}

			return array();
		}
	}

?>