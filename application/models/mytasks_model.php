<?php
	defined("BASEPATH") or die;
	
	class Mytasks_model extends CI_Model {
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
		public function getCreatedByUsers(){
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
					WHERE (SELECT 
				            COUNT(t.device_id)
				        FROM
				            device_manager_maintenance_tasks t
				        WHERE
				            t.created_by = u.userid) > 0
					ORDER BY count DESC , u.userid
					");

			return $query->result_object();
		}

		/**
		 * Get all users and how many devices they currently have checked out
		 * @return array
		 */
		public function getAssigneeUsers(){
			$query = $this->db->query("SELECT 
						u.username,
						u.userid,
						(SELECT 
							COUNT(t.task_id)
						FROM
							device_manager_maintenance_tasks t
						WHERE
							t.assignee = u.userid) as count
					FROM
						users u
					WHERE (SELECT 
							COUNT(t.task_id)
						FROM
							device_manager_maintenance_tasks t
						WHERE
							t.assignee = u.userid) > 0
					ORDER BY count DESC, u.userid
					");

			return $query->result_object();
		}

		/**
		 * Get all devices and the count of issues/device
		 * @return array
		 */
		public function getDevices(){
			$query = $this->db->query("SELECT 
					    IF(d.name IS NOT NULL, d.name, d.uuid) as name,
					    d.device_id,
					    (SELECT 
				            COUNT(t.device_id)
				        FROM
				            device_manager_maintenance_tasks t
				        WHERE
				            t.device_id = d.device_id) as count
					FROM
					    device_manager_devices d
					WHERE (SELECT 
				            COUNT(t.device_id)
				        FROM
				            device_manager_maintenance_tasks t
				        WHERE
				            t.device_id = d.device_id) > 0
					ORDER BY count DESC , d.device_id
					");

			return $query->result_object();
		}

		/**
		 * Get all maintenance tasks from the database
		 * @return array
		 */
		public function getRecords(){
			$return = array();
			$user = $this->hydra->get("id");

			$sql = "SELECT 
						task_id, device_id, assignee, created_by, description, status 
					FROM device_manager_maintenance_tasks 
					WHERE created_by = ? OR assignee = ?
					ORDER BY status";

			$query = $this->db->query($sql, array($user, $user));

			if($query->num_rows() > 0){
				return $query->result_object();
			}

			return $return;
		}
	}

?>