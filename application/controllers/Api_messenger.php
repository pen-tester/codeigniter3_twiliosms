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

        public function get_numbers_users(){
           $result = new MessageResult();
           $count = $this->messenger_model->get_numbers_users();
           $result->result=array("total"=>$count);
           echo (json_encode($result));           
        }

        public function get_recent_chatusers($page=0, $entry=5){
           $page = (int)$page;
           $result = new MessageResult();
           $users = $this->messenger_model->get_recent_chatuser($page);
           $result->result=$users;
           echo (json_encode($result));          
        }


        public function get_list_newsms($page='0',$entries='10'){
          $search = $this->input->post("search");
          $grades = $this->input->post("grades");
          $star = $this->input->post("star");

          if($search==null) $search="";
          if($grades == null) $grades=array();
          if($star == null) $star="-1";
          $page = (int)$page;
          $entries = (int)$entries;
          $result = new MessageResult();
          $search = preg_replace( "/[^0-9 A-Za-z\.\+]/", '', $search);
          $sms_list = $this->messenger_model->get_list_newsms_bypage($page,$search, $grades,$star, $entries);
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

        public function get_var(){
          $varname = $this->input->post("varname");
          $result = new MessageResult();
          $this->load->model("variable_model");
          $val = $this->variable_model->get_var($varname);
          $result->result=$val["valreplace"];
          echo (json_encode($result));          
        }

        public function insert_var(){
          $varname = $this->input->post("varname");
          $varval = $this->input->post("varval");
          $result = new MessageResult();
          $this->load->model("variable_model");
          $data["search"] = $varname;
          $data["valreplace"] = $varval;
          $val = $this->variable_model->insert_var($data);
          $result->result=$val;
          echo (json_encode($result));          
        }      

        public function get_member_info(){
          $phone = $this->input->post("phone");
          $result = new MessageResult();
          $this->load->model("archive_model");
          $res = $this->archive_model->get_userinfo($phone);
          $result->result=$res;
          echo (json_encode($result)); 
        }  

        public function update_member_info(){
          $leads = $this->input->post("leads");
          $result = new MessageResult();
          $this->load->model("archive_model");
          $res = $this->archive_model->update_userinfo($leads);
          $result->result=$res;
          echo (json_encode($result));           
        }

        public function load_message(){
          $phone = $this->input->post("phone");
          $cur_id = (int)$this->input->post("id");
          $result = new MessageResult();
          $this->load->model("messenger_model");
          $res = $this->messenger_model->load_message($phone,$cur_id);
          $result->result=$res;
          echo (json_encode($result));            
        }
}

