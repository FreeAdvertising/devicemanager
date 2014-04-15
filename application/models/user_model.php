<?php
	defined("BASEPATH") or die;
	
	class User_model extends CI_Model {
		/**
		 * Build the object
		 */
		public function __construct(){
			return parent::__construct();
		}

		/**
		 * Resets the user's secret question answer
		 * TODO: build a User class, modify this class to only accept properties
		 * of that class (i.e. User $id)
		 * 
		 * @param  int $id The user's ID
		 * @return bool
		 */
		public function reset_secret_question($id){
			if(is_numeric($id) && $id > 0){
				return $this->db->query("UPDATE users SET secret_question_answer = ?, is_reset = 1 WHERE userid = ?", array(sprintf("Reset on %s", date("F jS, Y g:i:a")), $id));
			}

			return false;
		}

		/**
		 * Get data about a specific user
		 * TODO: build a User class, modify this class to only accept properties
		 * of that class (i.e. User $id)
		 * 
		 * @param  int $id The user's ID
		 * @return bool
		 */
		public function getUser($id){
			if(is_numeric($id) && $id > 0){
				$result = $this->db->query("SELECT username, secret_question_answer, group_id, userid FROM users WHERE userid = ?", array($id));

				return $result->result_object();
			}

			return false;
		}

		/**
		 * Get data about a specific user
		 * TODO: build a User class, modify this class to only accept properties
		 * of that class (i.e. User $id)
		 * 
		 * @param  int $id The user's ID
		 * @return bool
		 */
		public function getQuarantinedUser($id){
			if(is_numeric($id) && $id > 0){
				$result = $this->db->query("SELECT username, secret_question_answer, group_id, userid FROM users_quarantine WHERE userid = ?", array($id));

				return $result->result_object();
			}

			return false;
		}

		public function getGroups(){
			$result = $this->db->query("SELECT group_id, name FROM usergroups ORDER BY group_id");

			return $result->result_object();
		}

		public function modify($data, $id){
			if($id > 0 && is_numeric($id)){
				if($data["password"] != $data["conf-password"]){
					$this->session->set_flashdata("model_save_fail", "The Password and Confirm Password fields must match");

					return false;
				}

				if($data["password"] != "" && $data["conf-password"] != ""){
					$query = "UPDATE users SET password = ?, username = ?, secret_question_answer = ?, group_id = ?, is_reset = 0 WHERE userid = ?";
					$result = $this->db->query($query, array(sha1($data["password"]), $data["name"], $data["secret_question_answer"], (int) $data["group_id"], (int) $id));
				}else {
					$query = "UPDATE users SET username = ?, secret_question_answer = ?, group_id = ?, is_reset = 0  WHERE userid = ?";
					$result = $this->db->query($query, array($data["name"], $data["secret_question_answer"], (int) $data["group_id"], (int) $id));
				}

				if(false === $result){
					//set failure message here
					$this->session->set_flashdata("model_save_fail", "User update query failed");

					return false;
				}
			}else {
				//set failure message here
				$this->session->set_flashdata("model_save_fail", "Invalid user ID");

				return false;
			}

			return true;
		}

		public function insert($data){
			if($data["password"] != $data["conf-password"]){
				$this->session->set_flashdata("model_save_fail", "The Password and Confirm Password fields must match");

				return false;
			}

			if(sizeof($data) > 0){
				$query = "INSERT INTO users(`username`, `password`, `secret_question_answer`, `group_id`) VALUES(?, ?, ?, ?)";

				if(false === $this->db->query($query, array($data["name"], sha1($data["password"]), $data["secret_question_answer"], (int) $data["group_id"]))){
					//set failure message here
					$this->session->set_flashdata("model_save_fail", "Users insert query failed");

					return false;
				}
			}else {
				//set failure message here
				$this->session->set_flashdata("model_save_fail", "Not enough data");

				return false;
			}

			return true;
		}
	}

?>