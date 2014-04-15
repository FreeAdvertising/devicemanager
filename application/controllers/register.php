<?php

	defined("BASEPATH") or die;

	class Register extends CI_Controller {
		public function __construct(){
			parent::__construct();

			$this->load->helper("form");
			$this->load->model("register_model");
		}

		public function index(){
			$data = new Generic;
			$data->set("template_path", base_url() ."application/views/global");
			$data->set("nav_path", base_url() ."index.php/");
			$data->set("page", $this->uri->segment(1));
			$data->set("subpage", $this->uri->segment(2));
			$data->set("isIPExternal", $this->hydra->isIPExternal());

			//set specific page data
			$active = $this->register_model->isFormActive();

			//load the relevant views
			$this->load->view('header', $data);
			
			if($data->isIPExternal || $active){
				$this->load->view('cannot_register');
			}else {
				$this->load->view("form_register");
			}

			$this->load->view('footer', $data);
		}

		public function do_register(){
			if(false === $this->hydra->isAuthenticated()){
				$postdata = $this->input->post();
				
				if(false === $this->register_model->do_register($postdata)){
					$this->session->set_flashdata("model_save_fail", "There was an error processing the request and your account could not be created.");
				}else {
					$this->session->set_flashdata("model_save_success", "Your account was created but it must be approved by an administrator before you can login.  You will be notified via email when this is complete.");
				}
			}

			return redirect(referer_url());
		}
	}

?>