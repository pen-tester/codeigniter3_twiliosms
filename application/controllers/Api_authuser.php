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

        public function upload_csv(){
            $result = new MessageResult();

            if($_FILES["csv"]["error"] == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["csv"]["tmp_name"];
                    // basename() may prevent filesystem traversal attacks;
                    // further validation/sanitation of the filename may be appropriate
                    $name = basename($_FILES["csv"]["name"]);
                    //move_uploaded_file($tmp_name, "data/$name");
            }else{
                $result->status='error';
                $result->errors="No Files";
                echo (json_encode($result));    
                return;  
            }

            $this->load->model("phone_model");
            $row = 0;
            $csvkeys=array();
            if (($handle = fopen($tmp_name, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                   // echo "<p> $num fields in line $row: <br /></p>\n";
                    $row++;
                    if($row==1){
                        $csvkeys = $data;
                        continue;
                    }

                    $num = min(count($data), count($csvkeys));
                    $leads =array();
                    for ($c=0; $c < $num; $c++) {
                        if($csvkeys[$c]!="" && $csvkeys[$c]!=null){
                            $leads[$csvkeys[$c]] =$data[$c];
                        }
                    }
                    $leads["userid"] = $this->userid;
                    $this->phone_model->insert_phone($leads);
                }
                fclose($handle);
            }
            $result->result=$_FILES["csv"];
            echo (json_encode($result));              

        }

        public function list_phones($page=0, $limit=50){
            $this->load->model("phone_model");
            $page = (int)$page;
            $limit = (int) $limit;
            $result = new MessageResult();
            $all = ($this->userrole ==1000)?1:0;
            $result->result= $this->phone_model->list_phones($this->userid , $page, $limit, $all);
            echo (json_encode($result));              
        }

        public function get_total_number_of_phones(){
            $this->load->model("phone_model");
            $result = new MessageResult();
            $all =  ($this->userrole ==1000)?1:0;
            $result->result=(array) $this->phone_model->get_total_number_of_phones($this->userid , $all);
            echo (json_encode($result));             
        }

        public function delete_allphones(){
            $this->load->model("phone_model");
            $result = new MessageResult();
            $all =  ($this->userrole ==1000)?1:0;
            $result->result=(array) $this->phone_model->delete_allphones($this->userid , $all);
            echo (json_encode($result));              
        }
}



