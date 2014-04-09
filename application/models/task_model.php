<?php
	defined("BASEPATH") or die;
	
	class Task_model extends CI_Model {
		/**
		 * Auto-executed
		 */
		public function __construct(){
			return parent::__construct();
		}

		public function getRecord($id = 0){
			if($id > 0){
				
			}
		}

		/**
		 * Get devices for the "add task" view so users can associate an issue
		 * with a specific device
		 * @return array
		 */
		public function getMyDevices(){
			//admins should be able to create tickets for any device in the 
			//database, other users should only be able to create tickets for
			//devices they currently have checked out
			if($this->hydra->get("gid") === 2){ //admins
				$sql = "SELECT 
						ar.device_id,
						IF(d.name IS NULL, d.uuid, d.name) as name
						FROM device_manager_assignments_rel ar
						LEFT JOIN device_manager_devices d ON d.device_id = ar.device_id
						WHERE checked_in = 0
						GROUP BY d.uuid";
			}else {
				$sql = "SELECT 
						ar.device_id,
						IF(d.name IS NULL, d.uuid, d.name) as name
						FROM device_manager_assignments_rel ar
						LEFT JOIN device_manager_devices d ON d.device_id = ar.device_id
						WHERE userid = ? AND checked_in = 0
						GROUP BY d.uuid";
			}

			$query = $this->db->query($sql, array($this->hydra->get("id")));

			if($query->num_rows() > 0){
				return $query->result_object();
			}

			return array();
		}

		/**
		 * Get all maintenance task categories
		 * @return array
		 */
		public function getTaskCategories(){
			$return = array();

			$query = $this->db->query("SELECT category_id, name FROM device_manager_maintenance_task_categories");

			if($query->num_rows() > 0){
				return $query->result_object();
			}

			return $return;
		}

		/**
		 * Add a new maintenance task to the database
		 * @param  array $data Post data
		 * @return bool
		 */
		public function insert($data){
			if(isset($data["uuid"])){
				$id = $this->product->getDeviceID(UUID::convert($data["uuid"]));
				$data["device_id"] = $id;
			}

			$query = $this->db->query("INSERT INTO device_manager_maintenance_tasks 
				(`device_id`, `created_by`, `description`, `date`) VALUES 
				(?, ?, ?, NOW())", array(
						$data["device_id"],
						$this->hydra->get("id"),
						$data["desc"],
					));

			return $query;
		}
	}
?>