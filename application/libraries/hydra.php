<?php
	defined("BASEPATH") or die;

	/**
	 * Used to wrap some common functions that determine user permissions
	 */
	class Hydra {
		private $_data;
		private $_internal_ip;

		public function __construct(){
			$ci = get_instance();
			$ci->load->config("product");

			$tmp = $ci->session->all_userdata();

			$this->_data = new Generic();
			$this->_data->set("ip", $tmp["ip_address"]);
			$this->_data->set("u_id", (isset($tmp["user"]) ? (int) $tmp["user"]->id : 0));
			$this->_data->set("u_name", (isset($tmp["user"]) ? $tmp["user"]->username : null));
			$this->_data->set("u_data_exists", (isset($tmp["user"]) ? true : false));
			$this->_data->set("u_gid", (isset($tmp["user"]) ? (int) $tmp["user"]->group_id : 0));
			$this->_data->set("u_product_name", $ci->config->item("product_name"));
			$this->_data->set("u_company_name", $ci->config->item("company_name"));
			$this->_data->set("u_valid_domain", $ci->config->item("valid_domain"));

			//set the internal IP address manually in the config file
			$this->_internal_ip = $ci->config->item("internal_ip");
		}

		public function isAuthenticated(){
			if($this->_data->u_data_exists){
				if($this->_data->u_id > 0 && false === is_null($this->_data->u_name)){
					return true;
				}
			}

			return false;
		}

		public function isIPExternal(){
			if(IS_DEV){
				return false;
			}

			return ($this->_internal_ip != $this->_data->ip);
		}

		public function isAdmin(){
			if(IS_DEV){
				return true;
			}

			if(false === $this->isIPExternal()){
				if($this->_data->u_gid === 2){
					return true;
				}
			}

			return false;
		}

		public function get($key = null){
			if(false === is_null($key)){
				$_tmp_key = "u_". $key;

				if(isset($this->_data->{$_tmp_key})){
					return $this->_data->{$_tmp_key};
				}
			}

			return false;
		}
	}

?>