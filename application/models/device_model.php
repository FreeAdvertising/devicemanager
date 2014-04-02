<?php
	defined("BASEPATH") or die;
	
	class Device_model extends CI_Model {
		public function __construct(){
			return parent::__construct();
		}

		public function getDevice(UUID $uuid, $limit = 0){
			$query = $this->db->query("SELECT *, IF(name IS NULL, uuid, name) as device_name FROM device_manager_devices WHERE uuid = ? ORDER BY device_id", $uuid->get());

			if($query->num_rows() > 0){
				$return = $query->row();
				$return->current_owner = $this->_getUser($query->row()->location, $query->row()->last_checkedout_by);
				$return->apps = $this->getApps($query->row()->device_id, $limit);
				$return->uuid = $uuid; //$uuid is already an instance of \UUID
				$return->reserved = $this->_isReserved($query->row()->device_id);
			}

			return $return;
		}

		public function getReservationList(UUID $uuid){
			$query = $this->db->query("SELECT u.username, r.date FROM device_manager_reservations_rel r 
				LEFT JOIN device_manager_devices d ON r.device_id = d.device_id
				LEFT JOIN users u ON r.userid = u.userid
				WHERE d.uuid = ? 
				ORDER BY r.date", $uuid->get());

			return $query->result_object();
		}

		private function _isReserved($id){
			$query = $this->db->query("SELECT `date`, `userid` FROM device_manager_reservations_rel WHERE device_id = ? AND userid = ? ", array((int) $id, $this->hydra->get("id")));

			return (sizeof($query->result_object()) > 0);
		}

		private function _getUser($location, $lastcheckout){
			$user = null;

			if($lastcheckout > 0 && $location > 0){
				//someone is using this device
				$query = $this->db->query("SELECT username FROM users WHERE userid = ? LIMIT 1", (int) $lastcheckout)->row();

				$user = $query->username;
			}

			return $user;
		}

		public function getApps($id = 0, $limit = 0){
			if($id > 0){
				$query = $this->db->query("SELECT t.name, tr.version, t.app_id FROM device_manager_tracked_applications_rel tr 
					LEFT JOIN device_manager_tracked_applications t ON tr.app_id = t.app_id
					WHERE tr.device_id = ? ORDER BY t.name ". ($limit > 0 ? "LIMIT ". $limit : ""), array($id));
			}else {
				//get ALL apps, not just ones that are associated to the UUID
				$query = $this->db->query("SELECT name, app_id FROM device_manager_tracked_applications ORDER BY app_id");
			}

			return $query->result_object();
		}

		public function check_in(UUID $uuid){
			if($uuid){
				$id = $this->product->getDeviceID($uuid);
				$user = $this->hydra->get("id");

				$query = $this->db->query("DELETE FROM device_manager_assignments_rel WHERE userid = ? AND device_id = ?", array($user, $id));

				//boolean query result, no need for type checking
				return $query;
			}

			return false;
		}

		public function check_out(UUID $uuid){
			if($uuid){
				$id = $this->product->getDeviceID($uuid);
				$user = $this->hydra->get("id");

				$query = $this->db->query("INSERT INTO device_manager_assignments_rel(`userid`, `device_id`, `date`) VALUES(?, ?, NOW())", array($user, $id));

				//boolean query result, no need for type checking
				return $query;
			}

			return false;
		}

		public function reserve(UUID $uuid){
			if($uuid){
				$id = $this->product->getDeviceID($uuid);
				$user = $this->hydra->get("id");

				$query = $this->db->query("INSERT INTO device_manager_reservations_rel(`userid`, `device_id`, `date`) VALUES(?, ?, NOW())", array($user, $id));

				//boolean query result, no need for type checking
				return $query;
			}

			return false;
		}

		public function cancel_reservation(UUID $uuid){
			if($uuid){
				$id = $this->product->getDeviceID($uuid);
				$user = $this->hydra->get("id");

				$query = $this->db->query("DELETE FROM device_manager_reservations_rel WHERE userid = ? AND device_id = ?", array($user, $id));

				//boolean query result, no need for type checking
				return $query;
			}

			return false;
		}
	}

?>