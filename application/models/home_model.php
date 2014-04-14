<?php
	defined("BASEPATH") or die;
	
	class Home_model extends CI_Model {
		public function __construct(){
			return parent::__construct();
		}

		public function getData(){
			//get values for "There are currently X users using X devices and X waiting."
			$_output = array();

			$query = $this->db->query("SELECT COUNT(ass_id) as count FROM device_manager_assignments_rel WHERE checked_in = 0");
			$_output[] = $query->row()->count;

			$query = $this->db->query("SELECT COUNT(ass_id) as count FROM device_manager_assignments_rel WHERE checked_in = 0");
			$_output[] = $query->row()->count;

			$query = $this->db->query("SELECT COUNT(res_id) as count FROM device_manager_reservations_rel WHERE checked_in = 0");
			$_output[] = $query->row()->count;

			return $_output;			
		}

		public function getMyReservations(){
			$id = $this->hydra->get("id");

			$query = $this->db->query("SELECT IF(d.name IS NULL, d.uuid, d.name) as name, d.uuid, r.date FROM device_manager_reservations_rel r 
				LEFT JOIN device_manager_devices d ON r.device_id = d.device_id
				LEFT JOIN users u ON r.userid = u.userid
				WHERE u.userid = ? AND r.checked_in = 1
				ORDER BY r.date
				", $id);

			return $query->result_object();
		}

		public function getMyDevices(){
			$id = $this->hydra->get("id");

			$query = $this->db->query("SELECT 
				ar.device_id,
				IF(d.name IS NULL, d.uuid, d.name) as name,
				d.uuid
				FROM device_manager_assignments_rel ar
				LEFT JOIN device_manager_devices d ON d.device_id = ar.device_id
				WHERE userid = ? AND checked_in = 0
				GROUP BY d.uuid
				", array($id));

			if($query->num_rows() > 0){
				return $query->result_object();
			}

			return array();
		}

		/**
		 * Get the list of maintenance tasks for both administrators and staff
		 * @return array
		 */
		public function getMaintenanceTasks(){
			$output = array();

			$staff_query = $this->db->query("SELECT 
				t.task_id, 
				t.date,
				t.description,
				t.status,
				d.uuid
				FROM device_manager_maintenance_tasks t 
				LEFT JOIN device_manager_devices d ON d.device_id = t.device_id
				WHERE t.created_by = ? AND t.status < ?
				ORDER BY t.status DESC, t.date DESC
				LIMIT ?
				", array(
					$this->hydra->get("id"),
					Product::TASK_STATUS_COMPLETE,
					Product::MAX_SHORT_LIST,
					));
			
			if($staff_query->num_rows() > 0){
				$output = $staff_query->result_object();
			}

			return $output;
		}

		public function getMyStats(){
			$user = $this->hydra->get("id");
			$output = new Generic();

			//get total number of records created by the user in the Freepass
			//application
			$freepass_records_created_query = $this->db->query("SELECT COUNT(record_id) as num_records FROM records WHERE user_id = ?", array($user));
			$output->set("fp_records_created", (int) $freepass_records_created_query->row()->num_records);

			//get total number of device manager tasks created by user
			$dm_tasks_created_query = $this->db->query("SELECT COUNT(task_id) as num_tasks FROM device_manager_maintenance_tasks WHERE created_by = ?", array($user));
			$output->set("dm_tasks_created", (int) $dm_tasks_created_query->row()->num_tasks);

			//get number of devices owned by user
			$dm_num_owned_query = $this->db->query("SELECT COUNT(ass_id) as num_owned FROM device_manager_assignments_rel WHERE userid = ?", array($user));
			$output->set("dm_devices_owned", (int) $dm_num_owned_query->row()->num_owned);

			//get invalid ticket ratio (i.e. requests that wasted time)
			$dm_tasks_closed = $this->db->query("SELECT COUNT(task_id) as num_invalid FROM device_manager_maintenance_tasks WHERE created_by = ? AND status = ?", array($user, Product::TASK_STATUS_INVALID));
			$tasks_invalid = (int) $dm_tasks_closed->row()->num_invalid;
			$output->set("dm_invalid_task_ratio", number_format(($tasks_invalid/$output->dm_tasks_created) * 100, 0) ."%");

			//get completed ticket ratio (i.e. successful support requests)
			$dm_tasks_closed = $this->db->query("SELECT COUNT(task_id) as num_closed FROM device_manager_maintenance_tasks WHERE created_by = ? AND status = ?", array($user, Product::TASK_STATUS_COMPLETE));
			$tasks_closed = (int) $dm_tasks_closed->row()->num_closed;
			$output->set("dm_completed_task_ratio", number_format(($tasks_closed/$output->dm_tasks_created) * 100, 0) ."%");

			return $output;
		}

		public function getUserStats(){
			$output = new Generic();

			//get user with best completed task ratio
			$dm_best_task_ratio_query = $this->db->query("SELECT
				* from users WHERE userid = 1 LIMIT ?
				", array(1
					));
			$output->set("best_ratio", $dm_best_task_ratio_query->row()->username);
			$output->set("worst_ratio", $dm_best_task_ratio_query->row()->username);
			$output->set("most_tickets", $dm_best_task_ratio_query->row()->username);
			$output->set("most_records", $dm_best_task_ratio_query->row()->username);
			$output->set("most_devices", $dm_best_task_ratio_query->row()->username);

			return $output;
		}
	}

?>