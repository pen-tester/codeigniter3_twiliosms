<?php
//sms_campaign
//smscampaign ::client_id

//jgkgtY71aRqyiMdscmIQ6T3GRHBO3XDGc0Pylh25db4R5lgDO3RcKs4HGhrOkMMc ;;api key

	include_once(APPPATH."libraries/podio/vendor/autoload.php");
//appid=18100291;
//app_token=ca29046ada8e42a5acf54a9ba0f02072

	function init_podio(){
		$appid="20077644";
		$app_token="b228c7e339b443ec89ac05b38d64c1a9";
		$client_id="smscampaign";
		$api_key = "jgkgtY71aRqyiMdscmIQ6T3GRHBO3XDGc0Pylh25db4R5lgDO3RcKs4HGhrOkMMc";

		Podio::setup($client_id, $api_key);
		try {
		  Podio::authenticate_with_app($appid, $app_token);

		  // Authentication was a success, now you can start making API calls.
		  return true;
		}
		catch (PodioError $e) {
		  // Something went wrong. Examine $e->body['error_description'] for a description of the error.
		}
		return false;
	}

	function add_item_to_podio($params=array()){
		//			"external_id"=> "test_property_1000",
		$appid="20077644";
		$attrs = array(
			"fields"=> array(
				"property-address-map"=>"650 Townsend St., San Francisco, CA 94103",
				"type-of-property"=>1,
				"bedrooms"=>3,
				"bathrooms"=>3
			)
		);
		return PodioItem::create( $appid, $attrs);
	}
?>
