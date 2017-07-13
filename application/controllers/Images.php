<?php
class Images extends CI_Controller {
        public function __construct()
        {
            // Construct our parent class
            parent::__construct();
            $this->load->helper('url');
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->model('images_model');
            $this->load->database();
            $this->load->library('session');
                if(!$this->session->has_userdata('logged_in')){
                        redirect("users/login");
                }            
           // $this->load->library('token');
        }

         public function list()
        {
            $data['title']='Gif List';
            $data['menuid']='gif';
            $data['subid']='list';
            $data['images'] = $this->images_model->get_images();
            $this->load->view('templates/mainheader', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('images/list', $data);
            $this->load->view('templates/footer', $data);
        }   
        
         public function add()
        {
            $data['title']='Add Gif';
            $data['menuid']='gif';
            $data['subid']='add';
            $data['error'] = '';
            $this->form_validation->set_rules('smscontent', 'Content', 'required');
            if (empty($_FILES['image']['name']))
            {
                $this->form_validation->set_rules('image', 'Image File', 'required');
            }            //$this->form_validation->set_rules('userfile', 'Document', 'required');
            //when the above line is active the upload does not go through

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('templates/mainheader', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('images/add', $data);
                $this->load->view('templates/footer', $data);
            }
            else
            {
                if(isset($_FILES['image'])){
                  $errors= array();
                  $file_name = $_FILES['image']['name'];
                  $file_size =$_FILES['image']['size'];
                  $file_tmp =$_FILES['image']['tmp_name'];
                  $file_type=$_FILES['image']['type'];
                  $tmp=explode('.',$file_name);
                  $file_ext=strtolower(end($tmp));
                  $newfile = $this->get_newfilename().".".$file_ext;
                  
                  $expensions= array("jpeg","jpg","png" ,"gif");
                  
                  if(in_array($file_ext,$expensions)=== false){
                     $errors[]="extension not allowed, please choose a JPEG or PNG file.";
                  }
                  
                  if($file_size > 2097152){
                     $errors[]='File size must be excately 2 MB';
                  }
                  
                  if(empty($errors)==true){
                    if(move_uploaded_file($file_tmp,"assets/images/gifs/".$newfile)){
                         $this->images_model->add_image($newfile);
                         redirect("/images/list");
                    }
                     
                  }else{
                    $data['error'] = $errors;
                     $this->load->view('templates/mainheader', $data);
                    $this->load->view('templates/sidebar', $data);
                    $this->load->view('images/add', $data);
                    $this->load->view('templates/footer', $data);                    
                  }
               }                 
            }      

        }    

        public function delete($id){
            $this->images_model->delete_image($id);
            redirect("/images/list");
        }     

        public function get_newfilename(){
            $filename = date("Y_m_d_H_i_s"); 
            return $filename;
        }
}

