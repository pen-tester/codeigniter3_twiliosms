<?php
class Images_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();

        }
        public function add_image($filename)
        {
        	$data = array(
			        'filename' => $filename,
			        'sms' => $this->input->post('smscontent')
			);

		$this->db->insert('images', $data);
        }

        public function get_images(){
        	$query = $this->db->get('images');
                return $query->result_array();
        }

        public function delete_image($id){
                $this->db->delete('images', array('id' => $id));
        }

        public function get_image($id){
                $query = $this->db->get_where('images', array('id'=>$id));
                return $query->row();
        }

}
