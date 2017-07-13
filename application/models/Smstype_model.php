<?php
class Smstype_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();

        }
        public function add_smstype()
        {
        	$data = array(
			        'name' => $this->input->post('name'),
			        'count' => $this->input->post('count'),
                                'price' => $this->input->post('price')
			);

		$this->db->insert('smstype', $data);
        }

        public function get_smstypes(){
        	$query = $this->db->get('smstype');
                return $query->result_array();
        }

        public function delete_smstype($id){
                $this->db->delete('smstype', array('id' => $id));
        }

        public function get_smstype($id){
                $query = $this->db->get_where('smstype', array('id'=>$id));
                return $query->row();
        }

}
