<?php

	defined("BASEPATH") or die;

	class UUID {
		/**
		 * The actual value of the UUID, i.e. T7HLMA08
		 * @var string
		 */
		protected static $value;

		/**
		 * Creates a new object based on the provided UUID
		 * @param string $uuid
		 */
		public function __construct($uuid = null){
			$this->set($uuid);

			return $this;
		}

		/**
		 * Set the value of the UUID object
		 * @param mixed $val
		 * @return mixed
		 */
		public function set($val){
			if(false === is_null($val) && strlen($val) === 8){
				$this->value = strtoupper($val);
			}

			return false;
		}

		/**
		 * Get the value of the UUID object
		 * @return mixed
		 */
		public function get(){
			if(isset($this->value))
				return $this->value;

			return false;
		}

		/**
		 * Determine if the given value is an instance of the __CLASS__
		 * @param  mixed  $uuid
		 * @return boolean
		 */
		public function isInstance($uuid){
			return ($uuid instanceof self);
		}

		/**
		 * Convert a generic string to a UUID object
		 * @param  string $uuid
		 * @return UUID object
		 */
		public static function convert($toConvert){
			try {
				if(false === self::isInstance(self::$value)){
					$ci = get_instance();
					$query = $ci->db->query("SELECT device_id FROM device_manager_devices WHERE uuid = ? LIMIT 1", array($toConvert));
					
					if($query->num_rows() > 0){
						return new UUID($toConvert);
					}
				}else {
					throw new Exception("Invalid UUID");
				}
			}catch(Exception $e){
				show_error($e->getMessage());
			}
		}

		/**
		 * Return the string value of the UUID
		 * @return string
		 */
		public function __toString(){
			return $this->get();
		}
	}

?>