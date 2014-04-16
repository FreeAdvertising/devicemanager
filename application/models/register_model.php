<?php
	
	defined("BASEPATH") or die;

	class Register_model extends CI_Model {
		/**
		 * Close the form (display cannot_register instead) after the specified 
		 * end date
		 * @return boolean
		 */
		public function isFormActive(){
			$now = time();
			$end_date = mktime(0, 0, 0, 6, 1, 2014); //registration closes June 1st, 2014

			return ($now > $end_date);
		}


		/**
		 * Register a new user
		 * @param  array  $data Post data
		 * @return boolean
		 */
		public function do_register($data = array()){
			if(array_has_values($data)){
				$get = $this->db->query("SELECT COUNT(userid) as registered_users FROM users WHERE username = ? OR email = ?", array($data["username"], $data["email"]));

				$passwords_match = ($data["password"] === $data["conf-password"]);
				$valid_email = (strpos($data["email"], "@") > 0);
				$valid_email = ($valid_email && strpos($data["email"], "wearefree.ca") > 0); //check against our desired domain
				
				//there are no users with that email/username combination,
				//proceed with registration
				if($get->row()->registered_users == 0 && $passwords_match && $valid_email){
					$register_query = $this->db->query("INSERT INTO 
						users_quarantine(`username`, `password`, `email`, `group_id`, `is_reset`)
						VALUES(?, ?, ?, 1, 0)", array(
								$data["username"],
								sha1($data["password"]),
								$data["email"],
							));

					return $register_query;
				}
			}

			return false;
		}
	}


?>