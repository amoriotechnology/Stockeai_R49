<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Cron_model extends CI_Model {






    public function __construct() {

        parent::__construct();

    }
    

    public function getemailConfig()
    {
        $this->db->select('*');
        $this->db->from('email_config');
        $this->db->where('created_by', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    
    
   
    public function get_email_scheduled(){
            $todayDate = date('Y-m-d');
        $this->db->select('id, title, description, start, end,invoice_no,email_id');

        $this->db->from('schedule_list');
       $this->db->where('source', 'EMAIL');
        $this->db->where('start', $todayDate);
       

        $query = $this->db->get();
      
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
  



}

?>