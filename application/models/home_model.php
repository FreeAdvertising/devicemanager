<?php
	defined("BASEPATH") or die;
	
	class Home_model extends CI_Model {
		public function __construct(){
			return parent::__construct();
		}

		public function getData(){
			//get values for "There are currently X users using X devices and X waiting."
			$_output = array();

			$query = $this->db->query("SELECT COUNT(ass_id) as count FROM device_manager_assignments_rel WHERE checked_in = 0");
			$_output[] = $query->row()->count;

			$query = $this->db->query("SELECT COUNT(ass_id) as count FROM device_manager_assignments_rel WHERE checked_in = 0");
			$_output[] = $query->row()->count;

			$query = $this->db->query("SELECT COUNT(res_id) as count FROM device_manager_reservations_rel WHERE checked_in = 0");
			$_output[] = $query->row()->count;

			return $_output;			
		}

		public function getMyReservations(){
			$id = $this->hydra->get("id");

			$query = $this->db->query("SELECT IF(d.name IS NULL, d.uuid, d.name) as name, d.uuid, r.date FROM device_manager_reservations_rel r 
				LEFT JOIN device_manager_devices d ON r.device_id = d.device_id
				LEFT JOIN users u ON r.userid = u.userid
				WHERE u.userid = ? AND r.checked_in = 1
				ORDER BY r.date
				", $id);

			return $query->result_object();
		}

		public function getMyDevices(){
			$id = $this->hydra->get("id");

			$query = $this->db->query("SELECT 
				ar.device_id,
				IF(d.name IS NULL, d.uuid, d.name) as name,
				d.uuid
				FROM device_manager_assignments_rel ar
				LEFT JOIN device_manager_devices d ON d.device_id = ar.device_id
				WHERE userid = ? AND checked_in = 0
				GROUP BY d.uuid
				", array($id));

			if($query->num_rows() > 0){
				return $query->result_object();
			}

			return array();
		}
	}

?>