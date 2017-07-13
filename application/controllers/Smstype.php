<?php
class Smstype extends CI_Controller {
        public function __construct()
        {
            // Construct our parent class
            parent::__construct();
            $this->load->helper('url');
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->model('smstype_model');
            $this->load->database();
            $this->load->library('session');
                if(!$this->session->has_userdata('logged_in')){
                        redirect("users/login");
                }            
           // $this->load->library('token');
        }
        public function list(){
            $data['title']='Sms Type List';
            $data['menuid']='smstype';
            $data['subid']='list';
            $data['images'] = $this->smstype_model->get_smstypes();
            $this->load->view('templates/mainheader', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('smstypes/list', $data);
            $this->load->view('templates/footer', $data);            
        }
        public function add(){
            $data['title']='Add Sms Type';
            $data['menuid']='smstype';
            $data['subid']='add';
            
            $this->form_validation->set_rules('name', 'Description', 'required');
            $this->form_validation->set_rules('count', 'Number of Sms', 'required|integer');
            $this->form_validation->set_rules('price', 'Price', 'required|decimal');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('templates/mainheader', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('smstypes/add', $data);
                $this->load->view('templates/footer', $data);    
            }            
            else{
                $this->smstype_model->add_smstype();
                redirect("/smstype/list");
            }
        }
        public function delete($id){
            $this->smstype_model->delete_smstype($id);
            redirect("/smstype/list");
        }  
       
}

