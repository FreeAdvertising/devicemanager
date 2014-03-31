<?php
	defined("BASEPATH") or die;
	
	class Devices_model extends CI_Model {
		public function __construct(){
			return parent::__construct();
		}

		public function getRecords(){
			$query = $this->db->query("SELECT 
				d.device_id, 
				d.uuid, 
				#d.status, 
				d.os, 
				IF(ar.ass_id, 2, 1) as checkout_status, 
				IF(rr.res_id, 4, 0) as reserved_status 
				#IF(mr.maint_id, 3, 1) as maintenance_status, 
				FROM device_manager_devices d 
				LEFT JOIN device_manager_assignments_rel ar ON ar.device_id = d.device_id 
				LEFT JOIN device_manager_reservations_rel rr ON rr.device_id = d.device_id 
				#LEFT JOIN device_manager_maintenance_rel mr ON mr.device_id = d.device_id 
				ORDER BY device_id");
			
			if($query->num_rows() > 0){
				return $query->result_object();
			}

			return array();
		}
	}

?>