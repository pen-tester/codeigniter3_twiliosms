<?php
//sms_campaign
//smscampaign ::client_id

//jgkgtY71aRqyiMdscmIQ6T3GRHBO3XDGc0Pylh25db4R5lgDO3RcKs4HGhrOkMMc ;;api key

	include_once(APPPATH."libraries/podio/vendor/autoload.php");
//appid=18100291;
//app_token=ca29046ada8e42a5acf54a9ba0f02072

	function init_podio(){
		$appid="18100291";
		$app_token="ca29046ada8e42a5acf54a9ba0f02072";
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
		$appid="18100291";
		$attrs = array(
			"fields"=> array(
				"property-address-map"=>"650 Townsend St., San Francisco, CA 94103",
				"type-of-property"=>100,
				"bedrooms"=>10,
				"bathrooms"=>100
			)
		);
		PodioItem::create( $appid, $attrs);
	}
?>
