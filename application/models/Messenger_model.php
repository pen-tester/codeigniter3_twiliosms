<?php
class Messenger_model extends CI_Model {

    public function __construct()
    {
            $this->load->database();
    }
    
    public function get_smsmsg($all_flag = TRUE)
	{
        $this->db->from('tb_recsms');
        $this->db->where(array("FromNum !="=>"+17273501397"));
        $this->db->or_where("FromNum is null");
        $this->db->order_by("No", "desc");
        $this->db->limit(150, 0);
        $query = $this->db->get();
        return $query->result_array();
        /*
        if ($all_flag === TRUE)
        {
                $this->db->from('tb_recsms');
                $this->db->order_by("No", "desc");
                $this->db->limit(10, 0);
                $query = $this->db->get(); 
                return $query->result_array();
                /*
                $query = $this->db->get('tb_recsms');
                return $query->result_array();
               
        }

        $query = $this->db->get_where('tb_recsms', array('NewSms' => 0));
        return $query->row_array();
        */
	}

    public function get_total_newsms(){
        $querytxt = "select count(*) as total from tb_recsms where status=0";
        $query = $this->db->query($querytxt);
        $row = $query->row();
        return $row->total;
    }

    public function get_list_newsms_bypage($page=0,$entries=10){
        $querytxt =sprintf("select * from tb_recsms where status=0 order by No desc limit %d offset %d", $entries, $page*$entries);
        $query = $this->db->query($querytxt);
        return $query->result_array();   
    }

    public function get_list_recentnewsms($cur_no=0, $page=0,$entries=10){
        $querytxt =sprintf("select * from tb_recsms where status=0 and No>%d order by No desc limit %d offset %d",$cur_no, $entries, $page*$entries);
        $query = $this->db->query($querytxt);
        return $query->result_array();   
    }

    public function list_chat($phone){
        $querytxt= sprintf("select * from tb_recsms where PhoneNum='%s' or FromNum='%s' order by No desc", $phone, $phone);
        $query=$this->db->query($querytxt);
        return $query->result_array();

    }
    public function list_newchat($phone,$id){
        $querytxt= sprintf("select * from tb_recsms where (PhoneNum='%s' or FromNum='%s') and No>%d order by No desc", $phone, $phone, $id);
        $query=$this->db->query($querytxt);
        return $query->result_array();

    }    

    public function insert_sms($phoneNum,$fromNum,$msg_body){

       date_default_timezone_set('US/Eastern');
     //  echo date_default_timezone_get();
       $currenttime = date('m/d/Y H:i:s');
      
        //$recTime =  date('m/d/Y h:i:s a', time());
        $recTime =  $currenttime;

        $data = array(
                'PhoneNum' => $phoneNum,
                'FromNum'=>$fromNum,
                'RecTime' => $recTime,
                'Content' => $msg_body
        );

        $this->db->insert('tb_recsms', $data);
        //send_Sms("+17274872339", $msg);
        //send_Sms("+8615714254213", $msg);
        //send_Sms("+8618242423147", $msg);
        // Create connection
    
    }

    public function remove_message($id){
        $this->db->where(array("No"=>$id));
        $this->db->delete("tb_recsms");
        return $this->db->affected_rows();
    }
}