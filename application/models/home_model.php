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

			//get total number of device manager tasks created by user
			$dm_tasks_created_query = $this->db->query("SELECT COUNT(task_id) as num_tasks FROM device_manager_maintenance_tasks WHERE created_by = ?", array($user));
			$output->set("dm_tasks_created", (int) $dm_tasks_created_query->row()->num_tasks);

			//get number of devices owned by user
			$dm_num_owned_query = $this->db->query("SELECT COUNT(ass_id) as num_owned FROM device_manager_assignments_rel WHERE userid = ?", array($user));
			$output->set("dm_devices_owned", (int) $dm_num_owned_query->row()->num_owned);

			//get invalid ticket ratio (i.e. requests that wasted time)
			$dm_tasks_closed = $this->db->query("SELECT COUNT(task_id) as num_invalid FROM device_manager_maintenance_tasks WHERE created_by = ? AND status = ?", array($user, Product::TASK_STATUS_INVALID));
			$tasks_invalid = (int) $dm_tasks_closed->row()->num_invalid;
			$_tmp = ($tasks_invalid === 0 ? 0 : number_format(($tasks_invalid/$output->dm_tasks_created) * 100, 0));
			$output->set("dm_invalid_task_ratio", $_tmp ."%");

			//get completed ticket ratio (i.e. successful support requests)
			$dm_tasks_closed = $this->db->query("SELECT COUNT(task_id) as num_closed FROM device_manager_maintenance_tasks WHERE created_by = ? AND status = ?", array($user, Product::TASK_STATUS_COMPLETE));
			$tasks_closed = (int) $dm_tasks_closed->row()->num_closed;
			$_tmp = ($tasks_closed === 0 ? 0 : number_format(($tasks_closed/$output->dm_tasks_created) * 100, 0));
			$output->set("dm_completed_task_ratio", $_tmp ."%");

			return $output;
		}

		public function getUserStats(){
			$output = new Generic();
			$list = new GenericList(array("best_ratio" => null, "worst_ratio" => null, "most_tickets" => null, "most_devices" => null), "associative");

			$most_devices = $this->db->query("SELECT COUNT(ar.device_id) as count, u.username FROM device_manager_assignments_rel ar LEFT JOIN users u ON u.userid = ar.userid WHERE ar.checked_in = 0 GROUP BY u.userid ORDER BY count LIMIT 1");
			$list->modify("most_devices", sprintf("%s (%d)", $most_devices->row()->username, (int) $most_devices->row()->count));

			$most_tickets = $this->db->query("SELECT COUNT(task_id) AS count, u.username FROM device_manager_maintenance_tasks t LEFT JOIN users u ON u.userid = t.created_by ORDER BY count LIMIT 1");
			$list->modify("most_tickets", sprintf("%s (%d)", $most_tickets->row()->username, (int) $most_tickets->row()->count));

			//get raw usage data and process it into the required format (who
			//has the best completed/total and worst invalid/total ratios in this
			//case)
			$all_user_ratios = $this->db->query(
				"SELECT 
					(SELECT 
							COUNT(task_id)
						FROM
							device_manager_maintenance_tasks t
						WHERE
							t.status = 4 AND t.created_by = u.userid) as completed_count,
					(SELECT 
							COUNT(task_id)
						FROM
							device_manager_maintenance_tasks t
						WHERE
							t.status = 3 AND t.created_by = u.userid) as invalid_count,
					(SELECT 
							COUNT(task_id)
						FROM
							device_manager_maintenance_tasks t
						WHERE
							t.created_by = u.userid) as total_count,
					u.username
				FROM
					users u
				ORDER BY completed_count DESC
			");

			$ratios = new GenericList($all_user_ratios->result_object());

			$best = $ratios->sort("completed_count", "asc")->limit(1)->dump();
			$worst = $ratios->sort("invalid_count", "asc")->limit(1)->dump();

			$list->modify("best_ratio", $best->username);
			$list->modify("worst_ratio", $worst->username);

			return $list;
		}
	}

?>