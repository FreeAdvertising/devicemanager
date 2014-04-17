<?php
	defined("BASEPATH") or die;

	class Users extends CI_Controller {
		public function __construct(){
			parent::__construct();

			$this->load->model("users_model");
		}

		public function index(){
			if(false === $this->hydra->isAdmin()){
				show_error("You do not have permission to view this page.");
			}

			$data = new Generic;
			$data->set("template_path", base_url() ."application/views/global");
			$data->set("nav_path", base_url() ."index.php/");
			$data->set("records", $this->users_model->getUsers());
			$data->set("page", $this->uri->segment(1));
			$data->set("isIPExternal", $this->hydra->isIPExternal());

			//set specific page data
			$data->set("list", $this->users_model->getUsers());

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('users');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}

		public function insert(){
			if(false === $this->hydra->isAdmin()){
				show_error("You do not have permission to view this page.");
			}
			
			if($this->users_model->insert($this->input->post())){
				//setup a success message here
				$this->session->set_flashdata("model_save_success", "Item inserted successfully");
			}else {
				$this->session->set_flashdata("model_save_fail", "There was a problem saving the item");
			}

			return redirect(base_url(). "/users");
		}
	}

?>