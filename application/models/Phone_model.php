<?php
class Phone_model extends CI_Model {

        public $keys=array("date_added",  "date_sent", "address", "city", "state", "firstname", "lastname", "owner_address", "owner_city", "owner_state", "phone0", "phone1", "phone2", "phone3", "phone4", "phone5", "phone6", "phone7", "phone8", "phone9", "leadtype", "userid");

        public function __construct()
        {
                $this->load->database();
        }
    
        public function get_allphones($all_flag = TRUE)
	{
                $this->db->from('tb_phone');
                $query = $this->db->get(); 
                return $query->result_array();
        }

        public function insert_phone($leads){
                $data = array();
                foreach ($this->keys as $key) {
                        if(array_key_exists($key, $leads)==true){
                        $data[$key] = $leads[$key];
                        }
                }
                $this->db->insert("tb_phone", $data);
        }        
}