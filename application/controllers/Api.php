<?php
class Api extends CI_Controller {
        public $msg = array("Hey %s, I noticed a property at %s, is it yours?  I'm a local buyer here in the area and would be interested in purchasing it, of course if the timing is right.  Please let me know and have a great rest of your day! \n\nP.S. I found your number on whitepages, in case you're wondering. \n\nThanks, \nMax","Hi %s, I saw through county records you're the representative for %s in %s.  I'm a local investor and have been buying in that neighborhood for years.  I was wondering, is the house for sale? \n\nSincerely, \nMax");

        public function __construct()
        {
            // Construct our parent class
            parent::__construct();
            $this->load->helper('url');
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->model('phone_model');
            $this->load->database();
            $this->load->helper('twilio');
            $this->load->library('session');
            if(!$this->session->has_userdata('logged_in')){
                    redirect("/users/login");
            }  
           // $this->load->library('token');
        }


        public function sendsms($option='0'){
            $phones = $this->phone_model->get_allphones();

            $rep_arr=array("+","(",")","-","_"," ");
            $respond=array();

            $index=0;
            if($option == '0'){
                $index=0;
            }else{
                $index=1;
            }

            foreach ($phones as $row) {
               $usrname = $row["Name"];
               $usr_index = strpos($usrname, " ");
               if($usr_index!=false)  $usrname = ucfirst(strtolower(substr($usrname, 0, $usr_index)));
               else $usrname = ucfirst(strtolower($usrname));

               $addr=ucfirst(strtolower($row["Address"]));
               $pieces = explode(" ", $addr);
               $counts = sizeof($pieces);
               for($i=0;$i<$counts; $i++){
                   $pieces[$i]=ucfirst(strtolower($pieces[$i]));
               }
               $addr=implode(" ",$pieces);

               $cityname=ucfirst(strtolower($row["City"]));
               $pieces = explode(" ", $cityname);
               $counts = sizeof($pieces);
               for($i=0;$i<$counts; $i++){
                   $pieces[$i]=ucfirst(strtolower($pieces[$i]));
               }
               $cityname=implode(" ",$pieces);
               //Set the owner of representive.
               $type = $row["Type"];

             //  $snd_msg = sprintf($msg, $usrname,$type, $addr );
                 $snd_msg= sprintf($this->msg[$index], $usrname, $addr, $cityname);
               //echo $snd_msg;

               for($p_ind=0;$p_ind<5; $p_ind++){
                 $phonenum = str_replace($rep_arr, "", $row["Phone".($p_ind+1)]);
                 if($phonenum == "") continue;
                 $phonenum = "+1".$phonenum;

                 $sms=null;
                 $status="success";
                 try{
                    $sms = send_Sms($phonenum, $snd_msg);   
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

