<?php
	defined("BASEPATH") or die;

	class Device extends CI_Controller {
		public function __construct(){
			parent::__construct();

			$this->load->model("device_model");
		}

		public function index($uuid = null){
			if(is_null($uuid)){
				return show_error("You must provide a valid device ID.");
			}

			$data = new Generic;
			$data->set("template_path", base_url() ."application/views/global");
			$data->set("nav_path", base_url() ."index.php/");
			$data->set("page", $this->uri->segment(1));
			$data->set("subpage", $this->uri->segment(2));
			$data->set("isIPExternal", $this->hydra->isIPExternal());

			//set specific page data
			$data->set("device_info", $this->device_model->getDevice($uuid));
			$data->set("reservation_list", $this->device_model->getReservationList($uuid));

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('device');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}

		public function apps($uuid){
			die('test');
		}
	}

?>