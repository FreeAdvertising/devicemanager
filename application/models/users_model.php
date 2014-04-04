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
			$query = $this->db->query("SELECT u.userid, u.username as name, u.secret_question_answer, u.is_reset, ug.name as group_name FROM users u LEFT JOIN usergroups ug ON u.group_id = ug.group_id ORDER BY name");

			return $query->result_object();
		}
	}

?>