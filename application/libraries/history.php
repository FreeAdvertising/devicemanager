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
						$_data = ["device_manager_reservations_rel", "res_id"];
						break;

					case "reserve":
						$_data = ["device_manager_reservations_rel", "res_id"];
						break;

					case "add_application":
						$_data = ["device_manager_tracked_applications_rel", "app_id"];
						break;

					case "check_in":
						$_data = ["device_manager_assignments_rel", "ass_id"];
						break;

					case "check_out":
						$_data = ["device_manager_assignments_rel", "ass_id"];
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
		 * @param  UUID   $uuid
		 * @return array
		 */
		public static function get(UUID $uuid){
			try {
				$ci = get_instance();
				$id = $ci->product->getDeviceID($uuid);

				$query = $ci->db->query("SELECT type, rel_id FROM device_manager_history ORDER BY hist_id");

				if($results = $query->result_object()){
					for($i = 0; $i < sizeof($results); $i++){
						$result = $results[$i]; //shortcut

						switch($result->type){
							case "cancel_reservation":
								$_data = ["device_manager_reservations_rel", "res_id"];
								break;

							case "reserve":
								$_data = ["device_manager_reservations_rel", "res_id"];
								break;

							case "add_application":
								$_data = ["device_manager_tracked_applications_rel", "app_id"];
								break;

							case "check_in":
								$_data = ["device_manager_assignments_rel", "ass_id"];
								break;

							case "check_out":
								$_data = ["device_manager_assignments_rel", "ass_id"];
								break;

							default:
								throw new Exception("Method argument required");
						}

						$output = $ci->db->query(sprintf("SELECT * FROM %s WHERE device_id = ?",
							$_data[0]
						), array(
							$id,
						));

						$records = $output->result_object();
						$return = array();

						for($i = 0; $i < sizeof($records); $i++){
							$properties = new Generic();
							$properties->setProperties($records[$i]);
							$properties->set("action", $result->type);

							if(isset($properties->userid)){
								$properties->set("user", $ci->product->getUser($properties->userid));
							}

							$return[] = $properties;
						}

						return $return;
					}
				}
			}catch(Exception $e){
				echo $e->getMessage();
			}
		}
	}

?>