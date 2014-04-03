<?php
	defined("BASEPATH") or die;

	/**
	 * Log device history actions to the database
	 */
	class History {
		/**
		 * Add an action to the device's history
		 * @param  UUID   $uuid
		 * @param  [type] $type
		 * @return [type]
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

				$query = $ci->db->query(sprintf("SELECT %s FROM %s WHERE device_id = ? AND userid = ?",
						$_data[1],
						$_data[0]
					), array(
						$id,
						$user,
					));

				//add data from the above query to the history table
				if(sizeof($query->row()) > 0){
					return $ci->db->query("INSERT INTO device_manager_history (`rel_id`, `type`) VALUES (?, ?)", array($query->row()->$_data[1], $method));
				}

				return false;
			}catch(Exception $e){
				echo $e->getMessage();
			}
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
		public static function get($uuid){
			try {
				$ci = get_instance();
				$id = $ci->product->getDeviceID($uuid);
				$return = array();

				$query = $ci->db->query("SELECT type, rel_id FROM device_manager_history ORDER BY hist_id");

				//TODO: refactor to use an SQL join instead of all this crap?
				if($results = $query->result_object()){
					for($i = 0; $i < sizeof($results); $i++){
						$result = $results[$i]; //shortcut

						switch($result->type){
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
						}

						if(false === is_null($uuid)){
							$output = $ci->db->query(sprintf("SELECT * FROM %s WHERE device_id = ? GROUP BY device_id ORDER BY `date`",
								$_data[0]
							), array(
								$id,
							));
						}else {
							$output = $ci->db->query(sprintf("SELECT * FROM %s GROUP BY device_id ORDER BY `date`",
								$_data[0]
							));
						}

						$records = $output->result_object();

						if(($size = sizeof($records)) > 0){
							foreach($records as $key => $record){
								$properties = new Generic();
								$properties->set("record", $record);
								$properties->set("action", $result->type);

								if(isset($properties->record->userid)){
									$properties->set("user", $ci->product->getUser($properties->record->userid));
								}

								$return[] = $properties;
							}
						}

					} //endfor

					return $return;
				} //end num_rows
			}catch(Exception $e){
				die($e->getMessage());
			}
		}
	}

?>