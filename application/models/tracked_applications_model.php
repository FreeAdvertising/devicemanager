<?php
	
	defined("BASEPATH") or die;

	class Tracked_applications_model extends CI_Model {
		public function getApps(){
			$query = $this->db->query("SELECT name, app_id FROM device_manager_tracked_applications ORDER BY app_id");
			
			return $query->result_object();
		}
	}

?>