<?php
	defined("BASEPATH") or die;
	
	class Devices_model extends CI_Model {
		public function __construct(){
			return parent::__construct();
		}

		public function getUsers(){
			$query = $this->db->query("SELECT 
					    u.username,
					    u.userid,
					    (SELECT 
				            COUNT(ar.device_id)
				        FROM
				            device_manager_assignments_rel ar
				        WHERE
				            ar.userid = u.userid AND ar.checked_in = 0) as count
					FROM
					    users u
					ORDER BY count DESC , u.userid
					");

			return $query->result_object();
		}

		//this query will require further testing with more data to confirm
		//the parameters are correct (specifically, the GROUP BY statement)
		public function getRecords(){
			$return = array();
			$query = $this->db->query("SELECT 
				d.device_id, 
				d.uuid, 
				d.name,
				#d.status,
				d.location, 
				d.os 
				#IF(ar.checked_in = 1, 1, 2) as checkout_status, 
				#IF(rr.res_id AND rr.checked_in = 0, 4, 0) as reserved_status 
				#IF(mr.maint_id, 3, 1) as maintenance_status, 
				FROM device_manager_devices d 
				#LEFT JOIN device_manager_assignments_rel ar ON ar.device_id = d.device_id 
				#LEFT JOIN device_manager_reservations_rel rr ON rr.device_id = d.device_id 
				#LEFT JOIN device_manager_maintenance_rel mr ON mr.device_id = d.device_id 
				#GROUP BY ar.userid, d.name
				ORDER BY d.device_id
				");

			if($results = $query->result_object()){
				for($i = 0; $i < sizeof($results); $i++){
					//add/override view-specific properties
					$results[$i]->current_owner = $this->_getUser(UUID::convert($results[$i]->uuid), "userid");
					$results[$i]->checkout_status = $this->_getAssignmentStatus(UUID::convert($results[$i]->uuid));
					$results[$i]->reserved_status = $this->_getReservedStatus(UUID::convert($results[$i]->uuid));
				}
			}

			return $results;
		}

		private function _getAssignmentStatus(UUID $uuid){
			if($uuid){
				$id = $this->product->getDeviceID($uuid);

				$query = $this->db->query("SELECT
						ar.checked_in
						FROM device_manager_assignments_rel ar
						WHERE ar.device_id = ? AND ar.checked_in = 0
						GROUP BY ar.ass_id
						LIMIT 1
					", array(
						$id,
						));

				if(sizeof($result = $query->row()) > 0){
					return (int) $result->checked_in;
				}
			}

			return Product::DEVICE_CHECKED_OUT;
		}

		private function _getReservedStatus(UUID $uuid){
			if($uuid){
				$id = $this->product->getDeviceID($uuid);

				$query = $this->db->query("SELECT
						rr.checked_in
						FROM device_manager_reservations_rel rr
						WHERE rr.device_id = ? AND rr.checked_in = 0
						GROUP BY rr.res_id
						LIMIT 1
					", array(
						$id,
						));

				echo "<pre>";
				var_dump($query->result_object());
				echo "</pre>";

				if(sizeof($result = $query->row()) > 0){
					return (int) $result->checked_in;
				}
			}

			return Product::DEVICE_CHECKED_OUT;
		}

		private function _getUser(UUID $uuid, $column = "username"){
			$user = null;
			$id = $this->product->getDeviceID($uuid);
			$query = $this->db->query(sprintf("SELECT u.%s as output FROM device_manager_assignments_rel ar LEFT JOIN users u ON u.userid = ar.userid WHERE checked_in = 0 AND device_id = ? LIMIT 1", $column), array($id));

			if($query->num_rows() === 1){
				return $query->row()->output;
			}

			return $user;
		}
	}

?>