<?php

class Messenger extends CI_Controller {
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

            if(!$this->session->has_userdata('logged_in')){
                    redirect("users/login?redirect=".$this->input->server('REQUEST_URI'));
            }                
           // $this->load->library('token');
            $this->username = $this->session->userdata("username");
            $this->userid = $this->session->userdata("email");
            $this->userrole = (int) $this->session->userdata("role");
            $this->editsms = (int) $this->session->userdata("editsms");
        }

        public function index(){
                $data['title']="Home";
                $data['menuid']="messenger";
                $data['submenuid']=2;                 
                $data['favico']=true;
                //Display the contents.
                $this->load->view('templates/mheader', $data);
                $this->load->view('templates/authnav', $data);
                $this->load->view('messenger/index', $data);
                $this->load->view('templates/mfooter');             

        }
 
    public function chat($phonenumber=""){
        $this->load->model("archive_model");
        $data['title']="Chat with customer";
        $data['menuid']="chat";
        $data['submenuid']=2;     
        $data['phone']=$phonenumber;             
        $user= $this->archive_model->get_userinfo($phonenumber);   

        $fromuser=$phonenumber;
        if($user!=null && $user['firstname']!=null && $user['firstname']!=""){
            $fromuser = $user['firstname']." ".(($user['lastname']==null || $user['lastname']=="")?"":$user['lastname']);
        }  
        $data['username'] = $fromuser;
        $data['user'] = $user;
        //Display the contents.
        $this->load->view('templates/mheader', $data);
        $this->load->view('templates/authnav', $data);
        $this->load->view('messenger/chat', $data);
        $this->load->view('templates/mfooter');            
    }
        
    public function status(){
                $data['title']="Status";
                $data['menuid']="status";
                $data['submenuid']=2;                 
                
                //Display the contents.
                $this->load->view('templates/mheader', $data);
                $this->load->view('templates/authnav', $data);
                $this->load->view('messenger/status', $data);
                $this->load->view('templates/mfooter');          
    }
}

