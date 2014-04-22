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
		public static function get_OLD($uuid){
			$ci = get_instance();
			$id = $ci->product->getDeviceID($uuid);
			$return = array();

			$query = $ci->db->query("SELECT rr.*, ar.*, h.type as action, IF(rr.date, rr.date, ar.date) as `date`, ar.date as ar_date, rr.date as rr_date, u.username
				FROM
				    device_manager_history h
				        LEFT JOIN
				    device_manager_assignments_rel AS ar ON ar.ass_id = h.rel_id
				        LEFT JOIN
				    device_manager_reservations_rel AS rr ON rr.res_id = h.rel_id
				        LEFT JOIN
				    users AS u ON IF(ar.userid, ar.userid, rr.userid) = u.userid
				WHERE (IF(rr.date, rr.date, ar.date) BETWEEN CURDATE() - INTERVAL 6 MONTH AND CURDATE()) AND ar.device_id = ?
				ORDER BY h.hist_id DESC, ar.date DESC
				LIMIT 100
				", array($id));
			$results = $query->result_object();
			var_dump($results);

			for($i = 0; $i < sizeof($results); $i++){
				$results[$i]->action = self::_parseAction($results[$i]->action);
			}

			return $results;
		}

		/**
		 * Retrieve all historical data for the given UUID
		 * @param  mixed   $uuid
		 * @return array
		 */
		public static function get(UUID $uuid){
			$ci = get_instance();
			$id = $ci->product->getDeviceID($uuid);
			
			//determine sources
			$assignments_query = $ci->db->query("SELECT userid, ass_id as rel_id, `date` FROM device_manager_assignments_rel WHERE device_id = ?", array($id));
			$reservations_query = $ci->db->query("SELECT userid, res_id as rel_id, `date` FROM device_manager_reservations_rel WHERE device_id = ?", array($id));

			//combine results into one god-like array
			$results = array_merge($assignments_query->result_object(), $reservations_query->result_object());
			
			//determine child history items and set special properties
			for($i = 0, $obj = $results; $i < sizeof($obj); $i++){
				$meta_query = $ci->db->query("SELECT type, value FROM device_manager_history WHERE rel_id = ? ORDER BY hist_id", array($obj[$i]->rel_id));
				unset($obj[$i]->rel_id);
				
				$obj[$i]->data = $meta_query->result_object();

				//process raw method names into human readable action names
				for($j = 0; $j < sizeof($obj[$i]->data); $j++){
					$status = new Generic();
					$status->set("action", self::_parseAction($obj[$i]->data[$j]->type));
					$status->set("value", self::_parseAction($obj[$i]->data[$j]->value));
					$status->set("username", $ci->product->getUser($obj[$i]->userid)->name);
					$status->set("date", $obj[$i]->date);

					if(is_null($status->value)){
						$status->setError("this->value not set or was NULL");
					}

					$obj[$i]->data[$j] = $status;
				}
			}

			return $results;
		}

		/**
		 * Transform an internal method name into a human readable string
		 * @param  string $action Action/method name
		 * @return string
		 */
		private static function _parseAction($action){
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