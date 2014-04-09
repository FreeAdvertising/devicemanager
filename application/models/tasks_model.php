<?php
	defined("BASEPATH") or die;
	
	class Tasks_model extends CI_Model {
		/**
		 * Auto-executed
		 */
		public function __construct(){
			return parent::__construct();
		}

		/**
		 * Get all users, and how many tasks they have created, for filtering
		 * the task list
		 * @return array
		 */
		public function getUsers(){
			$query = $this->db->query("SELECT 
					    u.username,
					    u.userid,
					    (SELECT 
				            COUNT(t.device_id)
				        FROM
				            device_manager_maintenance_tasks t
				        WHERE
				            t.created_by = u.userid) as count
					FROM
					    users u
					ORDER BY count DESC , u.userid
					");

			return $query->result_object();
		}

		/**
		 * Get all maintenance tasks from the database
		 * @return array
		 */
		public function getRecords(){
			$return = array();

			$query = $this->db->query("SELECT task_id, device_id, assignee, created_by, description, status FROM device_manager_maintenance_tasks ORDER BY device_id, assignee");

			if($query->num_rows() > 0){
				return $query->result_object();
			}

			return $return;
		}
	}

?>