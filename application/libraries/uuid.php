<?php

	defined("BASEPATH") or die;

	class UUID {
		protected $value = "INVALIDID";

		public function __construct($uuid = null){
			$this->set($uuid);

			return $this;
		}

		public function set($val){
			if(false === is_null($val) && strlen($val) === 8){
				$this->value = strtoupper($val);
			}

			return false;
		}

		public function get(){
			return $this->value;
		}

		public function isInstance($uuid){
			return ($uuid instanceof self);
		}

		/**
		 * Convert a generic string to a UUID object
		 * @param  [type] $uuid
		 * @return [type]
		 */
		public function convert(){
			try {
				if(false === $this->isInstance($this->value)){
					$ci = get_instance();
					$query = $ci->db->query("SELECT device_id FROM device_manager_devices WHERE uuid = ? LIMIT 1", array($this->value));

					if(sizeof($query->result_object()) > 0){
						return $this;
					}
				}else {
					throw new Exception("Invalid UUID");
				}
			}catch(Exception $e){
				show_error($e->getMessage());
			}
		}

		public function __toString(){
			return $this->value;
		}
	}

?>