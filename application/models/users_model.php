<?php
	defined("BASEPATH") or die;
	
	class Users_model extends CI_Model {
		/**
		 * Build the object
		 */
		public function __construct(){
			return parent::__construct();
		}

		/**
		 * Get users all users to populate the users list
		 * @return object
		 */
		public function getUsers(){
			$output = array("users" => array(), "quarantined" => array());

			//get approved users
			$users_query = $this->db->query("SELECT u.userid, u.username as name, u.secret_question_answer, u.is_reset, ug.name as group_name FROM users u LEFT JOIN usergroups ug ON u.group_id = ug.group_id ORDER BY u.userid, name");

			if($users_query->num_rows() > 0)
				$output["users"] = $users_query->result_object();

			//get quarantined users (new registrants)
			$quarantined_query = $this->db->query("SELECT u.userid, u.username as name, u.secret_question_answer, u.is_reset, ug.name as group_name FROM users_quarantine u LEFT JOIN usergroups ug ON u.group_id = ug.group_id ORDER BY u.userid, name");

			if($quarantined_query->num_rows() > 0)
				$output["quarantined"] = $quarantined_query->result_object();

			return $output;
		}
	}

?>