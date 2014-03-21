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

		public function getMyReservations(){
			$id = $this->hydra->get("id");

			$query = $this->db->query("SELECT IF(d.name IS NULL, d.uuid, d.name) as name, d.uuid, r.date FROM device_manager_reservations_rel r 
				LEFT JOIN device_manager_devices d ON r.device_id = d.device_id
				LEFT JOIN users u ON r.userid = u.userid
				WHERE u.userid = ? 
				ORDER BY r.date", $id);

			return $query->result_object();
		}
	}

?>