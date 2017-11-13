<?php
class Api_messenger extends CI_Controller {
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

        public function send_singlesms(){
          $phone = $this->input->post("phone");
          $msg= $this->input->post("content");
                 $result=array();

                 if($msg=="" || $phone==""){
                  $result["status"] = "error";
                  $result["msg"] = "parameters are required.";
                  $result["code"]="101";
                  echo json_encode($result);
                  return;
                 }
                 try{
                    $sms = send_Sms($phone, $msg);  
                     $this->smsmsg_model->insert_sms($phone, "+17273501397", $msg);
                 }
                 catch(Exception $ex){
                    $status="failed";
                    $sms=$ex->getMessage();
                    $result["status"] = "error";
                    $result["msg"] = $sms;
                    $result["code"]="101";
                    echo json_encode($result);
                    return;                    
                 }       
                    $result["status"] = "ok";
                    $result["msg"] = "successfully sent";
                    $result["code"]="1";
                    $result["result"] = $sms;
                    echo json_encode($result);
                    return;                       
        }

        public function get_numbers_newsms(){
           $result = new MessageResult();
           $count = $this->messenger_model->get_total_newsms();
           $result->result=array("total"=>$count);
           echo (json_encode($result));         
        }

        public function get_recent_chatusers(){
          
           $result = new MessageResult();
           $users = $this->messenger_model->get_recent_chatuser();
           $result->result=$users;
           echo (json_encode($result));          
        }


        public function get_list_newsms($page='0',$entries='10'){
          $page = (int)$page;
          $entries = (int)$entries;
          $result = new MessageResult();
          $sms_list = $this->messenger_model->get_list_newsms_bypage($page,$entries);
          $result->result=$sms_list;
          echo (json_encode($result));

        }
        public function get_list_recentnewsms(){
          $page = (int)$this->input->post("page");
          $entries = (int)$this->input->post("entry");;
          $curno= (int)$this->input->post("curno");;
          $result = new MessageResult();
          $sms_list = $this->messenger_model->get_list_recentnewsms($curno,$page,$entries);
          $result->result=$sms_list;
          echo (json_encode($result));
        }
        public function remove_message(){

          $id = (int)$this->input->post("id");
          $result = new MessageResult();
          $sms_list = $this->messenger_model->remove_message($id);
          $result->result=$sms_list;
          echo (json_encode($result));
        }
        public function update_message_readstatus(){
          $id = (int)$this->input->post("id");
          $phone = $this->input->post("phone");
          $result = new MessageResult();
          $data["id"]=$id;
          $data["phone"] = $phone;
          $data["readstatus"]=1;
          $sms_list = $this->messenger_model->update_message_readstatus($data);
          $result->result=$sms_list;
          echo (json_encode($result));          
        }
}

