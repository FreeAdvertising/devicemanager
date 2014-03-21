<?php
	defined("BASEPATH") or die;

	/**
	 * Product-specific helper methods and constants
	 */
	class Product {
		const DEVICE_AVAILABLE   = 1;
		const DEVICE_CHECKED_OUT = 2;
		const DEVICE_MAINTENANCE = 3;
		const DEVICE_RESERVED    = 4;

		const DEVICE_OS_OSX      = 1;
		const DEVICE_OS_WINDOWS  = 2;
		const DEVICE_OS_LINUX    = 3;

		private $_dateFormat;

		/**
		 * Create the object
		 */
		public function __construct(){
			$this->_dateFormat = "Y-m-d";
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

		public function get_ram(){

		}

		public function get_hdd(){

		}

		public function get_type(){
			
		}
	}

?>