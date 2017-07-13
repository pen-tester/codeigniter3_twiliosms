<?php
class Users_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
        public function add_user()
        {
        	$data = array(
			        'firstname' => $this->input->post('first_name'),
			        'lastname' => $this->input->post('last_name'),
			        'email'=>$this->input->post('email'),
			        'password'=>hash ( "sha256", $this->input->post('password'))
			);

			$this->db->insert('users', $data);
        }

        public function get_user($user, $password){
        	$pwd=hash("sha256", $password);
        	$query = $this->db->get_where('users', array('email'=>$user, 'password'=>$pwd));
        	foreach ($query->result_array() as $row)
			{
				return $row;
			}
			return null;

        }

}
