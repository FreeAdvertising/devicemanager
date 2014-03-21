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

		const DEVICE_TYPE_SERVER     = 1;
		const DEVICE_TYPE_LAPTOP     = 2;
		const DEVICE_TYPE_DESKTOP    = 3;
		const DEVICE_TYPE_PERIPHERAL = 4;

		private $_dateFormat;
		private $_options;

		/**
		 * Create the object
		 */
		public function __construct(){
			$this->_dateFormat = "Y-m-d";

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
					self::DEVICE_HDD_1000  => 1024,
					self::DEVICE_HDD_OTHER => null,
				));

			$this->_options->set("TYPE", array(
					self::DEVICE_TYPE_SERVER       => "SERVER",
					self::DEVICE_TYPE_LAPTOP       => "LAPTOP",
					self::DEVICE_TYPE_DESKTOP      => "DESKTOP",
					self::DEVICE_TYPE_PERIPHERAL   => "PERIPHERAL",
				));
		}

		/**
		 * Map the status code (integer) to a string
		 * @param  int $id
		 * @return string
		 */
		public function get_status($id){
			$id = intval($id);

			if($id === self::DEVICE_AVAILABLE)
				return "success";

			if($id === self::DEVICE_CHECKED_OUT)
				return "danger";

			if($id === self::DEVICE_MAINTENANCE)
				return "info";

			if($id === self::DEVICE_RESERVED)
				return "warning";

			return "danger";
		}

		/**
		 * Map OS code (integer) to a string
		 * @param  int $id
		 * @return string
		 */
		public function get_os($id){
			$id = intval($id);

			if($id === self::DEVICE_OS_OSX)
				return "osx";

			if($id === self::DEVICE_OS_WINDOWS)
				return "win";

			if($id === self::DEVICE_OS_LINUX)
				return "lin";

			return "osx";
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

			//$query = $this->db->query("SELECT")
		}
	}

?>