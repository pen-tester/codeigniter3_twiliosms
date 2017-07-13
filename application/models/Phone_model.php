<?php
class Phone_model extends CI_Model {

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
}