<?php
	defined("BASEPATH") or die;

	class Reservations extends CI_Controller {
		public function __construct(){
			parent::__construct();

			$this->load->model("reservations_model");
		}

		public function index(){
			$data = new Generic;
			$data->set("template_path", base_url() ."application/views/global");
			$data->set("nav_path", base_url() ."index.php/");
			$data->set("page", $this->uri->segment(1));
			$data->set("subpage", $this->uri->segment(2));
			$data->set("isIPExternal", $this->hydra->isIPExternal());

			//set page specific data
			$data->set("users", $this->reservations_model->getUsers());
			$data->set("records", $this->reservations_model->getRecords());

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('reservations');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}
	}

?>