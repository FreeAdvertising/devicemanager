<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Home extends CI_Controller {
		public function __construct(){
			parent::__construct();
			
			$this->load->model("home_model");
		}
		
		public function index(){
			$data = new Generic;
			$data->set("template_path", base_url() ."application/views/global");
			$data->set("nav_path", base_url() ."index.php/");
			$data->set("page", $this->uri->segment(1));
			$data->set("isIPExternal", $this->hydra->isIPExternal());

			//set specific page data
			$data->set("data", $this->home_model->getData());
			$data->set("my_reservations", $this->home_model->getMyReservations());
			$data->set("my_devices", $this->home_model->getMyDevices());
			$data->set("tasks", $this->home_model->getMaintenanceTasks());
			$data->set("my_stats", $this->home_model->getMyStats());
			$data->set("user_stats", $this->home_model->getUserStats());

			//load the relevant views
			$this->load->view('header', $data);
			
			if($this->hydra->isAuthenticated()){
				$this->load->view('home');
			}else {
				$this->load->view("login", $data);
			}

			$this->load->view('footer', $data);
		}
	}

?>