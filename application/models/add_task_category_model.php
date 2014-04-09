<?php
	defined("BASEPATH") or die;
	
	class Add_task_category_model extends CI_Model {
		public function __construct(){
			return parent::__construct();
		}

		public function insert($data){
			$query = $this->db->query("INSERT INTO device_manager_maintenance_task_categories(`name`, `description`) VALUES(?, ?)", array(
					$data["name"],
					$data["description"],
				));

			return $query;
		}
	}

?>