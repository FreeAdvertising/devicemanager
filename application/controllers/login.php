<?php

	defined("BASEPATH") or die;

	class Login extends CI_Controller {
		public function __construct(){
			parent::__construct();

			$this->load->model("login_model");
			//$this->load->library("form_validation");
			$this->load->helper("form");
		}

		public function index(){
			if(false === $this->hydra->isAuthenticated()){
				$postdata = $this->input->post();
				$authdata = array(
					"password" => $this->electroheart->encrypt($postdata["password"]),
					"username" => $postdata["username"],
					);

				if($this->hydra->isIPExternal()){
					$authdata["secret_question_answer"] = $this->electroheart->encrypt($postdata["secret_question"]);
				}
				
				if(false === $this->login_model->authenticate($authdata)){
					$this->session->set_flashdata("model_save_fail", "Sorry! We couldn't log you in with those credentials.");
				}
			}

			return redirect(referer_url());
		}
	}

?>