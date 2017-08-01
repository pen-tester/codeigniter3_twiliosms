<?php
class Customers extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->library('session');
                $this->load->model('customers_model');
                $this->load->helper('url_helper');
                $this->load->helper('form');
                if(!$this->session->has_userdata('logged_in')){
                        redirect("users/login");
                }    
             
        }


        public function index($page=0)
        {

                $data['customers'] = $this->customers_model->get_customers($page);
                $data['count_customers'] =$this->customers_model->get_rows_customer();
                $data['current_page'] = $page;

                $data['title']="Customers";
                $data['menuid']="actions";
                $data['submenuid']=0;                 
                
                //Display the contents.
                $this->load->view('templates/header', $data);
                $this->load->view('customers/index', $data);
                $this->load->view('templates/footer'); 
     
        }

        public function delete()
        {
               $sess_id = $this->session->userdata('logged_in');

                 if(empty($sess_id) || $sess_id != TRUE)
                          redirect("/pages/view");

                 $no = $this->input->post("customer_no");
                if($this->customers_model->delete_customer($no)){
                        redirect("/customers/index");
                }
               
                else{
                        redirect("/customers/fail");
                }
               
        }

        public function add()
        {
                $sess_id = $this->session->userdata('logged_in');

                if(empty($sess_id) || $sess_id != TRUE)
                          redirect("/pages/view");

                        $data['title']="Add customer";
                        $this->load->view('templates/header', $data);
                        $this->load->view('customers/add', $data);
                        $this->load->view('templates/footer');   
                    

        }

        public function edit()
        {
                 $sess_id = $this->session->userdata('logged_in');

                if(empty($sess_id) || $sess_id != TRUE)
                          redirect("/pages/view");
                $data['title']="Edit customer";

                $no = $this->input->post("customer_no");

                $customers = $this->customers_model->get_condition_customer($no);
                $data['customer'] = $customers[0];
                $data['title']="Edit customer";
                $data['menuid']="actions";
                $data['submenuid']=0; 
                $this->load->view('templates/header', $data);
                $this->load->view('customers/edit', $data);
                $this->load->view('templates/footer');  
        }

        public function addrecord(){
                 $sess_id = $this->session->userdata('logged_in');

                if(empty($sess_id) || $sess_id != TRUE)
                          redirect("/pages/view");

                $name = $this->input->post("cus_name");
                $phonenum = $this->input->post("cus_num");
                $note = $this->input->post("cus_note");
                $addr = $this->input->post("cus_addr");
                $city = $this->input->post("cus_city");
                $state = $this->input->post("cus_state");
                $zip = $this->input->post("cus_zip");

               if($this->customers_model->insert_customer($name, $phonenum,$note,$addr,$city,$state,$zip)){
                        redirect("/customers/index");
               }
                else{
                        redirect("/customers/fail");
                }
                

        }

        public function editrecord(){
                 $sess_id = $this->session->userdata('logged_in');

                if(empty($sess_id) || $sess_id != TRUE)
                          redirect("/pages/view");

                $no =$this->input->post("cus_no");
                $name = $this->input->post("cus_name");
                $phonenum = $this->input->post("cus_num");
                $note = $this->input->post("cus_note");
                $addr = $this->input->post("cus_addr");
                $city = $this->input->post("cus_city");
                $state = $this->input->post("cus_state");
                $zip = $this->input->post("cus_zip");

               if($this->customers_model->update_customer($no,$name, $phonenum,$note,$addr,$city,$state,$zip)){
                        redirect("/customers/index");
               }
                else{
                        redirect("/customers/fail");
                }
                

        }
 
}