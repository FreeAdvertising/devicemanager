<?php
	defined("BASEPATH") or die;

	/**
	 * Log device history actions to the database
	 */
	class History {
		/**
		 * Add an action to the device's history
		 * @param  UUID   $uuid
		 * @param  string Method in which the History::record method was called
		 * @param  string A value to record
		 * @return mixed
		 */
		public static function record(UUID $uuid, $method){
			try{
				$ci = get_instance();
				$user = $ci->hydra->get("id");
				$id = $ci->product->getDeviceID($uuid);
				$_data = array();

				//build the data query
				switch($method){
					case "cancel_reservation":
						$_data = array("device_manager_reservations_rel", "res_id");
						break;

					case "reserve":
						$_data = array("device_manager_reservations_rel", "res_id");
						break;

					case "add_application":
						$_data = array("device_manager_tracked_applications_rel", "app_id");
						break;

					case "check_in":
						$_data = array("device_manager_assignments_rel", "ass_id");
						break;

					case "check_out":
						$_data = array("device_manager_assignments_rel", "ass_id");
						break;

					default:
						throw new Exception("Method argument required");
				}

				$query = $ci->db->query(sprintf("SELECT %s FROM %s WHERE device_id = ? %s",
						$_data[1],
						$_data[0],
						($accept_user ? " AND userid = ?" : "")
					), array(
						$id,
						$user,
					));

				//add data from the above query to the history table
				if($query->num_rows() > 0){
					return $ci->db->query("INSERT INTO device_manager_history (`rel_id`, `type`) VALUES (?, ?)", array($query->row()->$_data[1], $method));
				}

				return false;
			}catch(Exception $e){
				echo $e->getMessage();
			}
		}

		/**
		 * Add an action to the device's history
		 * @param  int $task_id
		 * @param  string Method in which the History::recordTask method was called
		 * @param  string A value to record
		 * @return mixed
		 */
		public static function recordTask($task_id, $method, $value){
			$ci = get_instance();		
			
			return $ci->db->query("INSERT INTO device_manager_history (`rel_id`, `type`, `value`) VALUES (?, ?, ?)", array($task_id, $method, $value));
		}

		/**
		 * Purge all records for a specific UUID
		 * @param  UUID   $uuid
		 * @return bool
		 */
		public static function purge(UUID $uuid){
			return true;
		}

		/**
		 * Retrieve all historical data for the given UUID
		 * @param  mixed   $uuid
		 * @return array
		 */
		public static function get(UUID $uuid){
			$ci = get_instance();
			$id = $ci->product->getDeviceID($uuid);
			
			//rewrite #4: use a temporary table (so temporary it gets destroyed 
			//every time you hit /history)
			$ci->db->query("DROP TABLE IF EXISTS `temp_device_manager_history`");

			$sql = "CREATE TEMPORARY TABLE `temp_device_manager_history`";
			$sql .= sprintf("SELECT userid, ass_id as rel_id, `date` FROM device_manager_assignments_rel WHERE device_id = %d ", $id);
			$sql .= sprintf("UNION SELECT userid, res_id as rel_id, `date` FROM device_manager_reservations_rel WHERE device_id = %d ", $id);
			$sql .= sprintf("UNION SELECT created_by as userid, task_id as rel_id, `date` FROM device_manager_maintenance_tasks WHERE device_id = %d ", $id);

			$ci->db->query($sql);

			$temp = $ci->db->query("SELECT * FROM temp_device_manager_history ORDER BY `date` DESC");
			$list = new GenericList($temp->result_object(), "associative");

			//determine child history items and set special properties
			$list->loop(function($item, $oos){
				$_ci = $oos->indexOf(0);

				$meta = $_ci->db->query("SELECT type, value FROM device_manager_history WHERE rel_id = ? ORDER BY hist_id", array($item->rel_id));

				$item->data = new GenericList($meta->result_object(), "associative");

				$item->data->loop(function($current, $oos){
					$_ci = $oos->indexOf(0);
					$parent = $oos->indexOf(1);

					$status = new Generic();
					$status->set("action", History::_parseAction($current->type));
					$status->set("value", History::_parseAction($current->value));
					$status->set("username", $_ci->product->getUser($parent->userid)->name);
					$status->set("date", $parent->date);

					if(is_null($status->value)){
						$status->setError("this->value not set or was NULL");
					}

					$current->data = $status;
				}, array($_ci, $item));
			}, array($ci));

			return $list;
		}

		/**
		 * Transform an internal method name into a human readable string
		 * @param  string $action Action/method name
		 * @return string
		 */
		public static function _parseAction($action){
			switch($action){
				case "do_manage_task": 
					$output = "Assigned user/status updated"; break;
				case "do_insert": 
					$output = "Task created"; break;
				case "check_out": 
					$output = "Device checked out";  break;
				case "check_in": 
					$output = "Device checked in"; break;
				default: 
					$output = $action;
			}

			return $output;
		}
	}

?>