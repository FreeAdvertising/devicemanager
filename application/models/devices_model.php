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

		public function getRecords(){
			$query = $this->db->query("SELECT 
				d.device_id, 
				d.uuid, 
				d.name,
				d.status,
				d.location, 
				d.os, 
				IF(ar.ass_id AND ar.checked_in = 0, 2, 1) as checkout_status, 
				IF(rr.res_id AND rr.checked_in = 0, 4, 0) as reserved_status 
				#IF(mr.maint_id, 3, 1) as maintenance_status, 
				FROM device_manager_devices d 
				LEFT JOIN device_manager_assignments_rel ar ON ar.device_id = d.device_id 
				LEFT JOIN device_manager_reservations_rel rr ON rr.device_id = d.device_id 
				#LEFT JOIN device_manager_maintenance_rel mr ON mr.device_id = d.device_id 
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