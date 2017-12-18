<?php
class Archive_model extends CI_Model {
    public $keys= array("date_added", "date_sent", "firstname", "lastname", "phone", "contact", "email", "leadtype", "grade", "address", "city", "state", "zip", "owner_address", "owner_city", "owner_state", "called", "bed", "bath", "zillow_estimate", "year_built", "owe", "offer", "sqft", "lot_size", "central_ac", "ac_note", "roof", "garage", "pool", "repairs", "occupancy", "rent", "zillow_link", "note", "rate");

    public function __construct()
    {
            $this->load->database();
    }
    
    public function insert_phone($leads){
        $data = array();
        $this->db->where(array('phone'=>$leads["phone"]));
        $this->db->delete("tb_archive");
        foreach ($this->keys as $key) {
            if(array_key_exists($key, $leads)==true){
                $data[$key] = $leads[$key];
            }
        }
        $this->db->insert("tb_archive", $data);
    }

    public function update_userinfo($leads){
         if(array_key_exists("phone", $leads)==false)return -1;
        $data = array();
        $this->db->where(array('phone'=>$leads["phone"]));
        $query = $this->db->get("tb_archive");
        $rows = $query->result_array();
        foreach ($this->keys as $key) {
            if(array_key_exists($key, $leads)==true){
                $data[$key] = $leads[$key];
            }
        }
        if(count($rows)==0) $this->db->insert("tb_archive", $data);
        $this->db->where(array('phone'=>$leads["phone"]));
        $this->db->update("tb_archive", $data);
        return $this->db->affected_rows();
    }

    public function get_userinfo($phone){
        $this->db->where("phone",$phone);
        $query = $this->db->get("tb_archive");
       // $rows = $query->row();
        //return $row;
        $rows=$query->result_array();
        foreach ($rows as $row) {
            return $row;
        }
        return null;
    }

}