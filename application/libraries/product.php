<?php
	defined("BASEPATH") or die;

	/**
	 * Product-specific helper methods and constants
	 */
	class Product {
		/**
		 * Values here are index values from the form
		 */
		const DEVICE_AVAILABLE   = 1;
		const DEVICE_CHECKED_OUT = 2;
		const DEVICE_MAINTENANCE = 3;
		const DEVICE_RESERVED    = 4;

		const DEVICE_OS_OSX      = 1;
		const DEVICE_OS_WINDOWS  = 2;
		const DEVICE_OS_LINUX    = 3;

		const DEVICE_RAM_1GB     = 1;
		const DEVICE_RAM_2GB     = 2;
		const DEVICE_RAM_4GB     = 3;
		const DEVICE_RAM_8GB     = 4;
		const DEVICE_RAM_12GB    = 5;
		const DEVICE_RAM_16GB    = 6;
		const DEVICE_RAM_32GB    = 7;
		const DEVICE_RAM_OTHER   = 8;

		const DEVICE_HDD_128     = 1;
		const DEVICE_HDD_256     = 2;
		const DEVICE_HDD_500     = 3;
		const DEVICE_HDD_512     = 4;
		const DEVICE_HDD_750     = 5;
		const DEVICE_HDD_1000    = 6;
		const DEVICE_HDD_OTHER   = 7;

		const DEVICE_TYPE_LAPTOP     = 1;
		const DEVICE_TYPE_DESKTOP    = 2;
		const DEVICE_TYPE_SERVER     = 3;
		const DEVICE_TYPE_PERIPHERAL = 4;

		const TASK_STATUS_AVAILABLE   = 0;
		const TASK_STATUS_MAINTENANCE = 1;
		const TASK_STATUS_UNAVAILABLE = 2;
		const TASK_STATUS_INVALID     = 3;

		/**
		 * Specific limits and lengths
		 */
		const DEVICE_MAX_TRACKED_APPS = 5; //DEPRECATED
		const MAX_SHORT_LIST = 5;

		private $_options;
		private $_dateFormat = "F jS, Y";
		private $_version = "1.0.0b1";

		/**
		 * Create the object
		 */
		public function __construct(){
			$this->_options = new Generic();
			$this->_options->set("RAM", array(
					self::DEVICE_RAM_1GB   => 1,
					self::DEVICE_RAM_2GB   => 2,
					self::DEVICE_RAM_4GB   => 4,
					self::DEVICE_RAM_8GB   => 8,
					self::DEVICE_RAM_12GB  => 12,
					self::DEVICE_RAM_16GB  => 16,
					self::DEVICE_RAM_32GB  => 32,
					self::DEVICE_RAM_OTHER => null,
				));

			$this->_options->set("HDD", array(
					self::DEVICE_HDD_128   => 128,
					self::DEVICE_HDD_256   => 256,
					self::DEVICE_HDD_500   => 500,
					self::DEVICE_HDD_512   => 512,
					self::DEVICE_HDD_750   => 750,
					self::DEVICE_HDD_1000  => "> 1024",
					self::DEVICE_HDD_OTHER => null,
				));

			$this->_options->set("TYPE", array(
					self::DEVICE_TYPE_SERVER       => "SERVER",
					self::DEVICE_TYPE_LAPTOP       => "LAPTOP",
					self::DEVICE_TYPE_DESKTOP      => "DESKTOP",
					self::DEVICE_TYPE_PERIPHERAL   => "PERIPHERAL",
				));

			$this->_options->set("OS", array(
					self::DEVICE_OS_OSX     => "OSX",
					self::DEVICE_OS_WINDOWS => "WIN",
					self::DEVICE_OS_LINUX   => "LIN",
				));

			$this->_options->set("TSTAT", array(
				self::TASK_STATUS_AVAILABLE   => "Available",
				self::TASK_STATUS_UNAVAILABLE => "Unavailable",
				self::TASK_STATUS_MAINTENANCE => "Servicing",
				self::TASK_STATUS_INVALID     => "Invalid",
				));
		}

		/**
		 * Map the status code (integer) to a string
		 * @param  int $id
		 * @return string
		 */
		public function get_status($data){
			if((int) $data->checkout_status === 1){
				return self::DEVICE_AVAILABLE;
			}

			if((int) $data->checkout_status === self::DEVICE_CHECKED_OUT){
				return self::DEVICE_CHECKED_OUT;
			}

			if((int) $data->reserved_status === 0){
				return self::DEVICE_RESERVED;
			}

			// if($id === self::DEVICE_MAINTENANCE)
			// 	return "info";

			return self::DEVICE_CHECKED_OUT;
		}

		/**
		 * Map OS code (integer) to a string
		 * @param  int $id
		 * @return string
		 */
		public function get_os($key){
			$os_map = array(
				//LIST_VALUE, $_options->OS VALUE
					1 => 1,
					2 => 1,
					3 => 1,
					4 => 1,
					5 => 2,
					6 => 2,
					7 => 3,
					8 => 3					 
				);
			
			return $this->_options->OS[$os_map[$key]];
		}

		public function get_ram($key){
			return $this->_options->RAM[$key];
		}

		public function get_hdd($key){
			return $this->_options->HDD[$key];
		}

		public function get_type($key){
			return $this->_options->TYPE[$key];	
		}

		public function get_location($key){
			if($key == -1){
				return "IT";
			}

			$ci = get_instance();
			$query = $ci->db->query("SELECT username FROM users WHERE userid = ? LIMIT 1", array((int) $key));

			if($query->num_rows() === 1){
				return $query->row()->username;
			}
		}

		public function get_task_status($key){
			return $this->_options->TSTAT[$key];
		}

		public function getDeviceID(UUID $uuid){
			if($uuid){
				$ci = get_instance();
				$query = $ci->db->query("SELECT device_id FROM device_manager_devices WHERE uuid = ?", array($uuid->get()));

				if(isset($query->row()->device_id))
					return (int) $query->row()->device_id;
			}

			return false;
		}

		public function getPagination(){
			$ci = get_instance();
			$segments = $ci->uri->segment_array();
			$output = array();

			foreach($segments as $k => $v){
				$output[$k] = new Generic();
				$output[$k]->set("href", sprintf("/%s", $v));
				$output[$k]->set("text", $v);

			}

			$output = array_values($output); //reset array

			return $output;
		}

		public function isCheckedOutByUser(UUID $uuid){
			$ci = get_instance();
			$id = $this->getDeviceID($uuid);
			$user = $ci->hydra->get("id");
			
			$query = $ci->db->query("SELECT ass_id FROM device_manager_assignments_rel WHERE userid = ? AND device_id = ? AND checked_in = 0 LIMIT 1", array($user, $id));

			if($query->row()){
				return true;
			}

			return false;
		}

		public function isCheckedOutByOther(UUID $uuid){
			$ci = get_instance();
			$id = $this->getDeviceID($uuid);

			$query = $ci->db->query("SELECT ass_id FROM device_manager_assignments_rel WHERE device_id = ? AND checked_in = 0", array($id));
			
			if($query->num_rows() > 0){
				return true;
			}

			return false;
		}

		public function getUser($id = 0){
			if($id > 0){
				$ci = get_instance();
				$query = $ci->db->query("SELECT username as `name`, group_id as `group` FROM users WHERE userid = ? LIMIT 1", array($id));

				if($query->num_rows()){
					return $query->row();
				}

				return false;
			}else {
				$user = new Generic();
				$user->name = "IT";
				$user->group = 0;
				
				return $user;
			}
		}

		public function getCheckoutDate(UUID $uuid){
			if($uuid){
				$ci = get_instance();
				$id = $this->getDeviceID($uuid);

				$query = $ci->db->query("SELECT `date` FROM device_manager_assignments_rel WHERE device_id = ? AND checked_in = 0 ORDER BY `date` DESC", array($id));

				if($query->num_rows() > 0){
					$results = $query->result_object();

					return $results[0]->date;
				}
			}

			return false;
		}

		public function getCheckinDate(UUID $uuid){
			if($uuid){
				$ci = get_instance();
				$id = $this->getDeviceID($uuid);

				$query = $ci->db->query("SELECT `date` FROM device_manager_assignments_rel WHERE device_id = ? AND checked_in = 1 ORDER BY `date` DESC", array($id));

				if($query->num_rows() > 0){
					$results = $query->result_object();

					return $results[0]->date;
				}
			}

			return false;
		}

		public function getDefaultDateFormat(){
			return $this->_dateFormat;
		}

		public function getVersion(){
			return $this->_version;
		}

		public function convertMySQLDate($mysqldate = null){
			return date($this->getDefaultDateFormat(), strtotime($mysqldate));
		}
	}

?>