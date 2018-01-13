<?php
class Api_authuser extends CI_Controller {
  public $username;
  public $userid;
  public $email;
  public $userrole;
  public $editsms;  
        public function __construct()
        {
            // Construct our parent class
            parent::__construct();
            $this->load->helper('url');
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->model('phone_model');
            $this->load->model('smsmsg_model');
            $this->load->model('messenger_model');
            $this->load->database();
            $this->load->helper('twilio');
            $this->load->helper('predefined');
            $this->load->helper('result');
            $this->load->library('session');
           // $this->load->library('token');
           $this->username = $this->session->userdata("username");
           $this->email = $this->session->userdata("email");
           $this->userrole = (int) $this->session->userdata("role");
           $this->editsms = (int) $this->session->userdata("editsms");
           $this->userid = (int) $this->session->userdata("userid");

            if(!$this->session->has_userdata('logged_in')){
                   header("Content-Type: application/json; charset=UTF-8");
                   $result = new MessageResult();
                   $result->code=0;
                   $result->status="error";
                   $result->errors=array("Not logged_in");
                   echo json_encode($result);
                   die;
            }  
           // $this->load->library('token');
           // header("Access-Control-Allow-Origin: *");
           // header("Access-Control-Allow-Methods: POST, GET");
           // header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
            header("Content-Type: application/json; charset=UTF-8");
        }


        public function list_system_numbers(){
           $result = new MessageResult();
           $this->load->model("users_model");
           $rows = $this->users_model->get_current_smsnumbers();
            array_push( $rows, array( "twiliophone"=>"+12402211454"));
            array_push( $rows,array("twiliophone"=> "+19172439029"));

            $current_numbers = list_twilio_numbers();
            $res = array();
            foreach($current_numbers as $number){
                if(!in_array(array("twiliophone"=>$number->phoneNumber), $rows)) array_push($res, array("phone"=>$number->phoneNumber,"sid"=>$number->sid));
            }

           $result->result=$res;
           $result->additional_info=$rows;
           echo (json_encode($result));           
        }
        public function list_twilio_numbers(){
            $result = new MessageResult();
 
             $current_numbers = list_twilio_available_numbers();
             $res = array();
             foreach($current_numbers as $number){
                array_push($res, array("phone"=>$number->phoneNumber));
             }
 
            $result->result=$res;
            echo (json_encode($result));           
         }    
         
        public function get_current_number(){
            $result = new MessageResult();
 
            $this->load->model("users_model");
            $phone = $this->users_model->get_current_phonenumber($this->userid);
            $result->addtional_info=$this->userid;
            $result->result=$phone;
            echo (json_encode($result));  
        }

        public function get_current_callnumber(){
            $result = new MessageResult();
 
            $this->load->model("users_model");
            $phone = $this->users_model->get_current_callnumber($this->userid);
            $result->addtional_info=$this->userid;
            $result->result=$phone;
            echo (json_encode($result));  
        }

        public function update_userinfo(){
            $result = new MessageResult();
 
            $this->load->model("users_model");
            $leads = $this->input->post("leads");
            $leads["id"] = $this->userid;
            $sid = update_twilio_phonenumber($leads["twiliophone"], $leads["twilionumbersid"],$this->userid);

            if($sid==""){
                $leads["twiliophone"]=""; $leads["twilionumbersid"] ="";
            }


            $phone = $this->users_model->update_userinfobyid($leads);
            $result->result=$phone;
            $result->addtional_info =$leads;
            echo (json_encode($result));            
        }

        public function update_user(){
            $result = new MessageResult();
 
            $this->load->model("users_model");
            $leads = $this->input->post("leads");
            $leads["id"] = $this->userid;

            $phone = $this->users_model->update_userinfobyid($leads);
            $result->result=$phone;
            $result->addtional_info =$leads;
            echo (json_encode($result));            
        }        
}



