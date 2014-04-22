<?php
	defined("BASEPATH") or die;

	/**
	 * Generic object class
	 */
	class Generic {
		private $_errors = array();

		public $hasError = false;

		public function __construct($properties = array()){		
			return $this;
		}

		public function toString(){
			return get_class($this);
		}

		public function get($key = null, $default = null){
			$ret = $default;

			if(false === $this->hasError){
				if(false === is_null($key)){
					if(isset($this->$key)){
						$ret = $this->$key;
					}
				}
			}else {
				$ret = $this->getError();
			}

			return $ret;
		}

		public function set($key, $value){
			$ret = (isset($this->$key) ? $this->$key : null);
			
			$this->$key = $value;
			
			return $ret;
		}

		public function setProperties($properties = array()){
			if(sizeof($properties) > 0 && (is_array($properties) || is_object($properties))){
				foreach($properties as $key => $value){
					$this->$key = $value;
				}

				return true;
			}

			return false;
		}

		public function getProperties($private = false){
			$ret = array();

			$properties = get_object_vars($this);

			foreach($properties as $key => $value){
				if(strpos($key, "_") === false && false === $private){
					$ret[] = array($key => $value);
				}else {
					$ret[] = array($key => $value);
				}
			}

			return $ret;
		}

		public function setError($error_msg){
			$ret = array("class" => $this->toString(), "error" => $error_msg);

			$this->_errors[] = $ret;

			$this->hasError = true;

			return $ret;
		}

		/**
		 * [Get ALL the errors]
		 * @return mixed
		 */
		public function getError(){
			if($this->hasError){
				return $this->_errors;
			}

			return false;
		}
	}

?>