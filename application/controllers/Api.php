<?php
class Api extends CI_Controller {
        public function __construct()
        {
            // Construct our parent class
            parent::__construct();
            $this->load->helper('url');
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->model('phone_model');
            $this->load->model('smsmsg_model');
            $this->load->model('archive_model');
            $this->load->database();
            $this->load->helper('twilio');
            $this->load->library('session');
            if(!$this->session->has_userdata('logged_in')){
                    redirect("/users/login");
            }  
           // $this->load->library('token');
           // header("Access-Control-Allow-Origin: *");
           // header("Access-Control-Allow-Methods: POST, GET");
           // header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
            header("Content-Type: application/json; charset=UTF-8");
        }


        public function sendsms($option='0'){
            $phones = $this->phone_model->get_allphones();

            $rep_arr=array("+","(",")","-","_"," ");
            $respond=array();

            $index=(int)$option;


            $this->load->model("smscontent_model");
            $contents = $this->smscontent_model->list_smstemplates();
            if(count($contents)<=$index) {
              echo "error for index";
            }
            


            foreach ($phones as $row) {
              $snd_msg = $contents[$index]["msg"];
               $usrname = $row["firstname"];
               $usr_index = strpos($usrname, " ");
               if($usr_index!=false)  $usrname = ucfirst(strtolower(substr($usrname, 0, $usr_index)));
               else $usrname = ucfirst(strtolower($usrname));

               $addr=ucfirst(strtolower($row["address"]));
               $pieces = explode(" ", $addr);
               $counts = sizeof($pieces);
               for($i=0;$i<$counts; $i++){
                   $pieces[$i]=ucfirst(strtolower($pieces[$i]));
               }
               $addr=implode(" ",$pieces);

               $cityname=ucfirst(strtolower($row["city"]));
               $pieces = explode(" ", $cityname);
               $counts = sizeof($pieces);
               for($i=0;$i<$counts; $i++){
                   $pieces[$i]=ucfirst(strtolower($pieces[$i]));
               }
               $cityname=implode(" ",$pieces);
               //Set the owner of representive.
               $type = $row["leadtype"];

             //  $snd_msg = sprintf($msg, $usrname,$type, $addr );
                // $snd_msg= sprintf($this->msg[$index], $usrname, $addr, $cityname);

               $snd_msg = str_replace("%name", $usrname, $snd_msg);
               $snd_msg = str_replace("%addr", $addr, $snd_msg);
               $snd_msg = str_replace("%city", $cityname, $snd_msg);
               $snd_msg = str_replace("<br>", "\r\n", $snd_msg);
               //echo $snd_msg;

               for($p_ind=0;$p_ind<10; $p_ind++){
                 $phonenum = str_replace($rep_arr, "", $row["phone".($p_ind)]);
                 if($phonenum == "") continue;
                 $phonenum = "+1".$phonenum;
                 $row["phone"] = $phonenum;

                 $sms=null;
                 $status="success";
                 try{
                    $sms = send_Sms($phonenum, $snd_msg);  
                     $this->smsmsg_model->insert_sms($phonenum, "+17273501397", $snd_msg,1);
                     $this->archive_model->insert_phone($row);
                 }
                 catch(Exception $ex){
                    $status="failed";
                    $sms=$ex->getMessage();
                 }
                 $res = array();
                 $res["Number"]=$phonenum;
                 if($status=="success")$res["MessgeID"] = $sms->sid; else $res["MessgeID"]=$sms;
                 $res["Status"] = $status;
                 array_push($respond, $res);
                 // $respond = $respond."\nNumber:".$phonenum."Result:Success\n";      
               }
            }

            echo (json_encode($respond));

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
                     $this->smsmsg_model->insert_sms($phone, "+17273501397", $msg,1);
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
//list_chat_new
        public function list_chat($phone=""){
          if($phone==""){
            $phone=$this->input->post("phone");
          }
          $chats = $this->smsmsg_model->list_chat($phone);

          echo (json_encode($chats));

        }
        public function list_chat_new($phone="",$id=""){
          if($phone==""){
            $phone=$this->input->post("phone");
            $id= $this->input->post("id");
          }
          $chats = $this->smsmsg_model->list_newchat($phone,$id);

          echo (json_encode($chats));

        }
         //Basic authentification()
         /*
         public function sendsms()
        {
               if (empty($this->input->server('PHP_AUTH_USER')))
               {
                   header('HTTP/1.0 401 Unauthorized');
                   header('HTTP/1.1 401 Unauthorized');
                   header('WWW-Authenticate: Basic realm="My Realm"');
                   echo 'You must login to use this service'; // User sees this if hit cancel
                   die();
                }

                $username = $this->input->server('PHP_AUTH_USER');
                $password = $this->input->server('PHP_AUTH_PW');
        }   
        */
        
}

