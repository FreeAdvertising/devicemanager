<?php
	defined("BASEPATH") or die;
	
	class Reservations_model extends CI_Model {
		public function __construct(){
			return parent::__construct();
		}

		public function getUsers(){
			$query = $this->db->query("SELECT * FROM users");

			return $query->result_object();
		}
	}

?>