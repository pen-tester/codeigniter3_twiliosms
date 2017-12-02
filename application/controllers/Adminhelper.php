<?php

class Adminhelper extends CI_Controller {
    public $username;
    public $userid;
    public $userrole;

        public function __construct()
        {
            // Construct our parent class
            parent::__construct();
            $this->load->library('session');
            $this->load->helper('url');
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->database();
            $this->load->helper('result');

           // $this->load->library('token');
            $this->username = $this->session->userdata("username");
            $this->userid = $this->session->userdata("email");
            $this->userrole = (int) $this->session->userdata("role");


            header("Content-Type: application/json; charset=UTF-8");

            if(!$this->session->has_userdata('logged_in') || $this->userrole != 1000){
                    $result = new MessageResult();
                    $result->status="error";
                    $result->code=0; //Not logged in
                    $result->errors=array("Not Logged in");
                    echo (json_encode($result)); 
                    die;
            }                


        }

        public function listusers(){
            
            $this->load->model("users_model");
            $result = new MessageResult();
            $result->result = $this->users_model->listusers();

            echo (json_encode($result));   
        }

        public function update_member_info(){
          $leads = $this->input->post("leads");
          $result = new MessageResult();
          $this->load->model("users_model");
          $res = $this->users_model->update_userinfo($leads);
          $result->result=$res;
          echo (json_encode($result));           
        }        

        public function deleteuser(){
            $this->load->model("users_model");
            $userid = $this->input->post("userid");
            $result = new MessageResult();
            $result->result = $this->users_model->delete_user($userid);     
            echo (json_encode($result));       
        }

        public function list_smstemplates(){
            $this->load->model("smscontent_model");
            $result = new MessageResult();
            $result->result = $this->smscontent_model->list_smstemplates();

            echo (json_encode($result));              
        }

        public function get_sms_info(){
            $id = $this->input->post("id");
             $this->load->model("smscontent_model");
            $result = new MessageResult();
            $result->result = $this->smscontent_model->get_sms($id);

            echo (json_encode($result));            
        }

        public function updatesms(){
            $leads = $this->input->post("leads");
             $this->load->model("smscontent_model");
            $result = new MessageResult();
            $result->result = $this->smscontent_model->updatesms($leads);

            echo (json_encode($result));              
        }
}

