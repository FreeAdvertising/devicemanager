<?php
	defined("BASEPATH") or die;
	
	class Device_model extends CI_Model {
		public function __construct(){
			return parent::__construct();
		}

		public function getDevice($uuid){
			$query = $this->db->query("SELECT * FROM device_manager_devices WHERE uuid = ? ORDER BY device_id", $uuid);

			if($query->num_rows() > 0){
				$return = $query->row();
				$return->current_owner = $this->_getUser($query->row()->location, $query->row()->last_checkedout_by);
			}

			return $return;
		}

		public function getReservationList($uuid){
			$query = $this->db->query("SELECT u.username, r.date FROM device_manager_reservations_rel r 
				LEFT JOIN device_manager_devices d ON r.device_id = d.device_id
				LEFT JOIN users u ON r.userid = u.userid
				WHERE d.uuid = ? 
				ORDER BY r.device_id", $uuid);

			return $query->result_object();
		}

		private function _getUser($location, $lastcheckout){
			$user = "None";

			if($lastcheckout > 0 && $location > 0){
				//someone is using this device
				$query = $this->db->query("SELECT username FROM users WHERE userid = ? LIMIT 1", (int) $lastcheckout)->row();

				$user = $query->username;
			}

			return $user;
		}

	}

?>