<?php
class Users_model extends CI_Model {

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

}
