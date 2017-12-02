<?php
class Users_model extends CI_Model {

    public $keys= array("Name", "UsrId","Pwd", "editsms", "role", "active","created");

        public function __construct()
        {
                $this->load->database();
        }
        public function add_user()
        {
        	$data = array(
			        'Name' => $this->input->post('name'),
			        'UsrId'=>$this->input->post('email'),
			        'Pwd'=>hash ( "sha256", $this->input->post('password'))
			);
			$this->db->insert('tb_user', $data);
        }

        public function get_user($user, $password){
        	$pwd=hash("sha256", $password);
        	$query = $this->db->get_where('tb_user', array('UsrId'=>$user, 'Pwd'=>$pwd));
        	foreach ($query->result_array() as $row)
			{
				return $row;
			}
			return null;
        }

        public function delete_user($user){
            $this->db->where("UsrId", $user);
            $this->db->delete('tb_user');
            return $this->db->affected_rows();
        }

        public function listusers(){
            $this->db->select("Name, UsrId, editsms, active,created");
            $this->db->where("role", 1);
            $query=$this->db->get('tb_user');
            return $query->result_array();
        }

    public function update_userinfo($leads){
        $data = array();
        foreach ($this->keys as $key) {
            if(array_key_exists($key, $leads)==true){
                $data[$key] = $leads[$key];
            }
        }
        if(array_key_exists("Pwd", $leads) == true){
            $data["Pwd"] = hash("sha256", $leads["Pwd"]);
        }

        $this->db->where(array('UsrId'=>$leads["UsrId"]));
        $this->db->update("tb_user", $data);
        return $this->db->affected_rows();
    }

    public function insert_user($leads){
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

}
