<?php
	
	defined("BASEPATH") or die;

	class Login_model extends CI_Model {
		public function authenticate($data){
			if(sizeof($data) > 0){
				$decrypted = array(
					"password" => $this->electroheart->decrypt($data["password"]),
					"secret_question_answer" => (isset($data["secret_question_answer"]) ? $this->electroheart->decrypt($data["secret_question_answer"]) : ""),
					);
				
				if($this->hydra->isIPExternal()){
					$results = $this->db->query("SELECT username, userid as id, group_id FROM users WHERE username = ? AND password = ? AND secret_question_answer = ? LIMIT 1", array($data["username"], sha1($decrypted["password"]), $decrypted["secret_question_answer"]));
				}else {
					$results = $this->db->query("SELECT username, userid as id, group_id FROM users WHERE username = ? AND password = ? LIMIT 1", array($data["username"], sha1($decrypted["password"])));
				}

			
				if($results->num_rows() === 1){
					//start the session
					$tmp = $results->result_object();
					$this->session->set_userdata("user", $tmp[0]);

					return true;
				}
				

				return false;
			}

			return false;
		}
	}


?>