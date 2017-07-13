<?php
	use Twilio\Rest\Client;

	include_once(APPPATH."libraries/twilio/vendor/autoload.php");

	function get_TwilioConfig(){
		$stripe = array(
		  "id"      => "AC26d8a7eea1119f9543f9f76fcae64f7c",
		  "token" => "a3b39ed9276f493b4f7bb45100a61d9d"
		);
		return $stripe;
	}

	function send_twiliomultiplesms($images, $count, $number,$name){
		$number = "+1".$number;

		$config = get_TwilioConfig();
	    $auth_id = $config["id"];
	    $auth_token = $config["token"];

		$allcount = sizeof($images);
		$current_max = ($count>$allcount)? $allcount: $count;
		$rand_keys = array_rand($images, $current_max);

		$fromnumber="+12048085325";
		$addition_sms = "\n".$name." sent you this via sumbio.co! Hit back now!";

		if($current_max == 1){
			$image= $images[$rand_keys];
				$url="http://sumbio.co/assets/images/gifs/".$image["filename"];

				$client = new Client($auth_id, $auth_token);

				// Use the client to do fun stuff like send text messages!
			       $sms = $client->account->messages->create(

			            // the number we are sending to - Any phone number
			            $number,

			            array(
			                // Step 6: Change the 'From' number below to be a valid Twilio number 
			                // that you've purchased
			                'from' => $fromnumber, 

			                // the sms body
			                'body' => $image["sms"].$addition_sms,
			                
			                // Step 7: Add url(s) to the image media you want to send
			                'mediaUrl' => array($url)
			            )
			        );


		}else if($current_max>1){
			foreach($rand_keys as $sel_key){

				$image= $images[$sel_key];
				$url="http://sumbio.co/assets/images/gifs/".$image["filename"];

				$client = new Client($auth_id, $auth_token);

				// Use the client to do fun stuff like send text messages!
			       $sms = $client->account->messages->create(

			            // the number we are sending to - Any phone number
			            $number,

			            array(
			                // Step 6: Change the 'From' number below to be a valid Twilio number 
			                // that you've purchased
			                'from' => $fromnumber, 

			                // the sms body
			                'body' => $image["sms"],
			                
			                // Step 7: Add url(s) to the image media you want to send
			                'mediaUrl' => array($url)
			            )
			        );
			}

		}	

				$client = new Client($auth_id, $auth_token);

				// Use the client to do fun stuff like send text messages!
			       $sms = $client->account->messages->create(

			            // the number we are sending to - Any phone number
			            $number,

			            array(
			                // Step 6: Change the 'From' number below to be a valid Twilio number 
			                // that you've purchased
			                'from' => $fromnumber, 

			                // the sms body
			                'body' => $addition_sms
			                
			                // Step 7: Add url(s) to the image media you want to send
			                //'mediaUrl' => array($url)
			            )
			        );

	}
?>