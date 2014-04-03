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
			$ci = get_instance();
			$id = $ci->product->getDeviceID($uuid);
			$return = array();

			$query = $ci->db->query("SELECT h.type as action, IF(ar.ass_id, ar.date, rr.date) as `date`, u.username
				FROM
				    device_manager_history h
				        LEFT JOIN
				    device_manager_assignments_rel AS ar ON ar.ass_id = h.rel_id
				        LEFT JOIN
				    device_manager_reservations_rel AS rr ON rr.res_id = h.rel_id
				        LEFT JOIN
				    users AS u ON IF(ar.userid, ar.userid, rr.userid) = u.userid
				WHERE IF(ar.ass_id, ar.date, rr.date) BETWEEN CURDATE() - INTERVAL 6 MONTH AND CURDATE()
				ORDER BY hist_id DESC
				");

			return $query->result_object();
		}
	}

?>