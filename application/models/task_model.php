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
				$user = $this->hydra->get("id");
				$query = $this->db->query("SELECT 
					t.*, 
					d.meta_ram, d.meta_type, d.meta_hdd, d.uuid, d.os,
					IF(t.created_by = ? OR t.assignee = ?, 1, 0) as can_edit
					FROM device_manager_maintenance_tasks t
					LEFT JOIN device_manager_devices d ON d.device_id = t.device_id
					WHERE task_id = ?
					", array($user, $user, $id));

				if($query->num_rows() > 0){
					$return = $query->row();
					$return->categories = $this->_getCategories($id);
					$return->category_ids = $this->getTaskCategoryIDs($id);

					return $return;
				}
			}

			return null;
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
		 * Get all maintenance task categories - sans name property
		 * TODO: find a better way to do this...
		 * @return array
		 */
		public function getTaskCategoryIDs($task_id){
			$query = $this->db->query("SELECT c.category_id
				FROM device_manager_maintenance_task_categories_rel cr
				LEFT JOIN device_manager_maintenance_task_categories c ON c.category_id = cr.category_id
				LEFT JOIN device_manager_maintenance_tasks t ON t.task_id = cr.task_id
				WHERE cr.task_id = ?
				ORDER BY t.date, t.task_id 
				", array(
					$task_id,
					));

			if($query->num_rows() > 0){
				$raw = $query->result_object();
				$output = array();

				foreach($raw as $int){
					$output[] = (int) $int->category_id;
				}

				return $output;
			}

			return array();
		}

		/**
		 * Add a new maintenance task to the database
		 * @param  array $data Post data
		 * @return bool
		 */
		public function insert($data){
			//if UUID is set, this was called from the device/add_task view and
			//relies on the UUID to determine the device ID
			if(isset($data["uuid"])){
				$id = $this->product->getDeviceID(UUID::convert($data["uuid"]));

				//skip out of the fuction if an invalid UUID was passed
				if($id){
					$data["device_id"] = $id;
				}else {
					return false;
				}
			}

			//get max task ID because, for some reason, last_insert() returns a 
			//value that isn't actually in the DB..
			$max_task_query = $this->db->query("SELECT MAX(task_id) as max FROM device_manager_maintenance_tasks LIMIT 1");
			$_tmp = $max_task_query->row();
			$max_task_id = (int) $_tmp->max;

			$query = $this->db->query("INSERT INTO device_manager_maintenance_tasks 
				(`device_id`, `created_by`, `description`, `date`) VALUES 
				(?, ?, ?, NOW())", array(
						$data["device_id"],
						$this->hydra->get("id"),
						$data["desc"],
					));

			if($query){
				foreach($data["categories"] as $cat_id){
					$assoc_query = $this->db->query("INSERT INTO device_manager_maintenance_task_categories_rel (
						`device_id`, 
						`task_id`, 
						`category_id`
						) VALUES (
						?, 
						?, 
						?
						)", array(
							$data["device_id"],
							$max_task_id,
							$cat_id, 
						));
				}

				return $assoc_query;
			}

			return false;
		}

		/**
		 * Edit a task
		 * @param  array $data Post data
		 * @return bool
		 */
		public function edit($data){
			if(sizeof($data) > 0){
				//update the description and device id
				$query = $this->db->query("UPDATE device_manager_maintenance_tasks SET device_id = ?, description = ? WHERE task_id = ?",
					array(
						(int) $data["device_id"],
						$data["desc"],
						(int) $data["task_id"],
						));

				//delete all category associations so we can add the new ones
				$disassociate_categories_query = $this->db->query("DELETE FROM device_manager_maintenance_task_categories_rel WHERE task_id = ?", array($data["task_id"]));

				//add the new category associations
				foreach($data["categories"] as $cat_id){
					$assoc_query = $this->db->query("INSERT INTO device_manager_maintenance_task_categories_rel (
						`device_id`, 
						`task_id`, 
						`category_id`
						) VALUES (
						?, 
						?, 
						?
						)", array(
							(int) $data["device_id"],
							(int) $data["task_id"],
							(int) $cat_id, 
						));
				}

				return $assoc_query;
			}

			return false;
		}

		/**
		 * Get all categories for a task
		 * @param  integer $task_id
		 * @return array
		 */
		private function _getCategories($task_id){
			$query = $this->db->query("SELECT c.name, c.category_id
				FROM device_manager_maintenance_task_categories_rel cr
				LEFT JOIN device_manager_maintenance_task_categories c ON c.category_id = cr.category_id
				LEFT JOIN device_manager_maintenance_tasks t ON t.task_id = cr.task_id
				WHERE cr.task_id = ?
				ORDER BY t.date, t.task_id 
				", array(
					$task_id,
					));

			if($query->num_rows() > 0){
				return $query->result_object();
			}

			return array();
		}
	}
?>