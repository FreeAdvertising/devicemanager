<?php
	defined("BASEPATH") or die;
	
	class Add_application_model extends CI_Model {
		public function __construct(){
			return parent::__construct();
		}

		public function insert($data){
			$query = $this->db->query("INSERT INTO device_manager_tracked_applications(`name`, `description`) VALUES(?, ?)", array(
					$data["name"],
					$data["desc"],
				));

			return $query;
		}

		public function assoc($data, $uuid){
			$dev_id = $this->product->getDeviceID($uuid);

			$query = $this->db->query("INSERT INTO 
				device_manager_tracked_applications_rel(`device_id`, `app_id`, `version`) 
				VALUES(?, ?, ?)", array(
						$dev_id,
						$data["app_id"],
						$data["version"],
					));

			return $query;
		}
	}

?>