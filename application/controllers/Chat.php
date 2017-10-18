<?php

class Chat extends CI_Controller {

        public function __construct()
        {
            // Construct our parent class
            parent::__construct();
            $this->load->library('session');
            $this->load->helper('url');
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->model('smsmsg_model');
            $this->load->database();
            $this->load->helper('twilio');
                if(!$this->session->has_userdata('logged_in')){
                        redirect("users/login");
                }                
           // $this->load->library('token');
        }

        public function index(){
                $data['title']="Chat with customer";
                $data['menuid']="actions";
                $data['submenuid']=2;                 
                
                //Display the contents.
                $this->load->view('templates/header', $data);
                $this->load->view('chat/index', $data);
                $this->load->view('templates/footer');             

        }
 
        
}

