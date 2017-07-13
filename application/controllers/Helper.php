<?php
class Helper extends CI_Controller {
        public function __construct()
        {
            // Construct our parent class
            parent::__construct();
            $this->load->helper('url');
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->model('smsmsg_model');
            $this->load->database();
            $this->load->helper('twilio');
           // $this->load->library('token');
        }

        public function recsms(){
          /*$phoneNum = $this->input->get("From");
          $receiveNum = $this->input->get("To");
          $msg_body = $this->input->get("Body");  */   
          $phoneNum = $this->input->post("From");
          $receiveNum = $this->input->post("To");
          $msg_body = $this->input->post("Body");             
          $this->smsmsg_model->insert_sms($phoneNum, $msg_body);
          $msg=sprintf("From %s\n Msg\n %s", $phoneNum, $msg_body);
          send_Sms("+18136000015", $msg);
          send_Sms("+18134091896", $msg);

        }

        public function emailsms(){
          $_from=$_POST["From"];
          $_to=$_POST["To"];
          $_body= $_POST["Body"];

          /*
           * Setup email addresses and change it to your own
           */
          $from = 'webmaster@sms.probateproject.com';
          $to = 'andrew.lidev@yandex.com';
          $subject = 'Sms Received from '.$_from;
          $message = $_body;
          $headers = 'From:' . $from;
       
          /*
           * Test php mail function to see if it returns 'true' or 'false'
           * Remember that if mail returns true does not guarantee
           * that you will also receive the email
           */
          mail($to,$subject,$message, $headers);  
          header("content-type: text/xml");
          echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";          
          echo("<Response></Response>");
        }

        
}

