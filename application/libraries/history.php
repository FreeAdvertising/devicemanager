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
				return $ci->db->query("INSERT INTO device_manager_history (`rel_id`, `type`) VALUES (?, ?)", array($query->row()->res_id, $method));
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
		 * @return Generic object
		 */
		public static function get(UUID $uuid){

		}
	}

?>