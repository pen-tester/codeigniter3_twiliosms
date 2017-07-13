<?php
class Manage extends CI_Controller {
        public function __construct()
        {
            // Construct our parent class
            parent::__construct();
            $this->load->helper('url');
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->model('users_model');
            $this->load->database();
            $this->load->library('session');
                if(!$this->session->has_userdata('logged_in')){
                        redirect("users/login");
                }            
           // $this->load->library('token');
        }

         public function dashboard()
        {
            $data['title']='dashboard';
            $data['menuid']='gif';
            $data['subid']='list';
            $this->load->view('templates/mainheader', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('manage/dashboard', $data);
            $this->load->view('templates/footer', $data);
        }   
        
}

