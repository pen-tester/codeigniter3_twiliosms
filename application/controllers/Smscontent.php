<?php

class Smscontent extends CI_Controller {
    public $username;
    public $userid;
    public $userrole;
    public $editsms;

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
           // $this->load->library('token');
            $this->username = $this->session->userdata("username");
            $this->userid = $this->session->userdata("email");
            $this->userrole = (int) $this->session->userdata("role");
            $this->editsms = (int) $this->session->userdata("editsms");
            if(!$this->session->has_userdata('logged_in') || ($this->userrole!=1000 && ($this->editsms==null || $this->editsms!=1))){
                    redirect("users/login?redirect=".$this->input->server('REQUEST_URI'));
            }                

        }

        public function list(){
                $data['title']="Sms List";
                $data['menuid']="action";
                $data['submenuid']=2;                 
                
                //Display the contents.
                $this->load->view('templates/mheader', $data);
                $this->load->view('templates/authnav', $data);
                $this->load->view('smscontent/list', $data);
                $this->load->view('templates/mfooter');   
        }
}

