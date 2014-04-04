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
				$return->current_owner = $this->_getUser($uuid);
				$return->apps = $this->getApps($query->row()->device_id, $limit);
				$return->uuid = $uuid; //$uuid is already an instance of \UUID
				$return->reserved = $this->_isReserved($query->row()->device_id);
			}

			return $return;
		}

		public function getReservationList(UUID $uuid){
			$query = $this->db->query("SELECT u.username, r.date, u.userid FROM device_manager_reservations_rel r 
				LEFT JOIN device_manager_devices d ON r.device_id = d.device_id
				LEFT JOIN users u ON r.userid = u.userid
				WHERE d.uuid = ? AND r.checked_in = 1
				ORDER BY r.date", $uuid->get());
			
			return $query->result_object();
		}

		private function _isReserved($id){
			$query = $this->db->query("SELECT `date`, `userid` FROM device_manager_reservations_rel WHERE device_id = ? AND userid = ? AND checked_in = 0", array((int) $id, $this->hydra->get("id")));

			return (sizeof($query->result_object()) > 0);
		}

		private function _getUser($uuid){
			$user = null;
			$id = $this->product->getDeviceID($uuid);
			$query = $this->db->query("SELECT u.username as output FROM device_manager_assignments_rel ar LEFT JOIN users u ON u.userid = ar.userid WHERE checked_in = 0 AND device_id = ? LIMIT 1", array($id));

			if($query->num_rows() === 1){
				return $query->row()->output;
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

		public function getPastOwners(UUID $uuid, $limit = 1000){
			$return = array();

			if($uuid){
				$id = $this->product->getDeviceID($uuid);

				$query = $this->db->query("SELECT
						u.username,
						ar.date
						FROM device_manager_history h
						LEFT JOIN device_manager_assignments_rel ar ON h.rel_id = ar.ass_id
						LEFT JOIN users u ON u.userid = ar.userid
						WHERE ar.device_id = ? AND ar.checked_in = 1 AND h.type = 'check_out'
						GROUP BY u.username
						ORDER BY ar.ass_id ASC
						LIMIT ?
					",
					array(
						$id,
						$limit
					));

				$return = $query->result_object();
			}

			return $return;
		}

		public function check_in(UUID $uuid){
			if($uuid){
				$id = $this->product->getDeviceID($uuid);
				$user = $this->hydra->get("id");

				$query = $this->db->query("UPDATE device_manager_assignments_rel SET checked_in = 1 WHERE userid = ? AND device_id = ?", array($user, $id));

				//update location field
				$update_location = $this->db->query("UPDATE device_manager_devices SET location = '-1' WHERE device_id = ?", array($id));

				//check in date update
				$update_checkin_date = $this->db->query("UPDATE device_manager_assignments_rel SET date = NOW() WHERE device_id = ?", array($id));

				//boolean query result, no need for type checking
				return $query;
			}

			return false;
		}

		public function check_out(UUID $uuid){
			if($uuid){
				$id = $this->product->getDeviceID($uuid);
				$user = $this->hydra->get("id");

				$test = $this->db->query("SELECT ass_id FROM device_manager_assignments_rel WHERE userid = ? AND device_id = ?", array($user, $id));

				if($test->num_rows() === 0){
					$query = $this->db->query("INSERT INTO device_manager_assignments_rel(`userid`, `device_id`, `date`) VALUES(?, ?, NOW())", array($user, $id));
				}else {
					$query = $this->db->query("UPDATE device_manager_assignments_rel SET checked_in = 0 WHERE userid = ? AND device_id = ?", array($user, $id));
				}

				//remove user from the reservation list, if they are on it (flip the checked_in flag)
				$query = $this->db->query("UPDATE device_manager_reservations_rel SET checked_in = 1 WHERE userid = ? AND device_id = ?", array($user, $id));

				//update location field
				$update_location_query = $this->db->query("UPDATE device_manager_devices SET location = ? WHERE device_id = ?", array($user, $id));

				//remove user from reservation list if they are on it
				$remove_reservation_query = $this->db->query("UPDATE device_manager_reservations_rel SET checked_in = 0 WHERE device_id = ? AND userid = ?", array($id, $user));

				//boolean query result, no need for type checking
				return $query;
			}

			return false;
		}

		public function reserve(UUID $uuid){
			if($uuid){
				$id = $this->product->getDeviceID($uuid);
				$user = $this->hydra->get("id");
				$query = false;

				//only run the query when the user hasn't reserved the device already
				$query = $this->db->query("SELECT res_id FROM device_manager_reservations_rel WHERE userid = ? AND device_id = ?", array($user, $id));

				if($query->num_rows() === 0){
					$query = $this->db->query("INSERT INTO device_manager_reservations_rel(`userid`, `device_id`, `date`) VALUES(?, ?, NOW())", array($user, $id));
				}else {
					$query = $this->db->query("UPDATE device_manager_reservations_rel SET checked_in = 0 WHERE userid = ? AND device_id = ?", array($user, $id));
				}

				//boolean query result, no need for type checking
				return $query;
			}

			return false;
		}

		public function cancel_reservation(UUID $uuid){
			if($uuid){
				$id = $this->product->getDeviceID($uuid);
				$user = $this->hydra->get("id");
				$query = false;

				//only run the query when the user has reserved the device already
				$query = $this->db->query("SELECT res_id FROM device_manager_reservations_rel WHERE userid = ? AND device_id = ?", array($user, $id));

				if(sizeof($query->row()) > 0){
					//$query = $this->db->query("DELETE FROM device_manager_reservations_rel WHERE userid = ? AND device_id = ?", array($user, $id));
					$query = $this->db->query("UPDATE device_manager_reservations_rel SET checked_in = 0 WHERE userid = ? AND device_id = ?", array($user, $id));
				}

				//remove user from the reservation list, if they are on it (flip the checked_in flag)
				$query = $this->db->query("UPDATE device_manager_reservations_rel SET checked_in = 1 WHERE userid = ? AND device_id = ?", array($user, $id));

				//boolean query result, no need for type checking
				return $query;
			}

			return false;
		}
	}

?>