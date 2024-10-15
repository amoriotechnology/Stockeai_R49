<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class User extends CI_Controller {
    public $user_id;
    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->library('lusers');
        $this->load->library('session');
        $this->load->model('Userm');
        $this->auth->check_admin_auth();
    }
    #=============Super Admin Edit and Delete User admin===============#
    public function superadmin_user_edit($unique_id) {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Userm');
       $userdata_get_info = $CI->Userm->userdata_get_info($unique_id);
       $data['userdata_get_info'] =  $userdata_get_info;
        $content = $this->load->view('users/superadmin_user_edit', $data, true);
        $this->template->full_admin_html_view($content);
    }
     public function superadmin_user_delete($unique_id) {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
   $date = date('Y-m-d H:i:s');
$update_data = array(
    'is_deleted' => 1,
	'modified_date' => $date
);
$this->db->where('unique_id', $unique_id);
$delete_users = $this->db->update('users', $update_data);
$delete_user_login = $this->db->update('user_login', $update_data);
$company_assign_role = $this->db->update('company_assignrole', $update_data);  
           if ($delete_users && $delete_user_login && $company_assign_role) {
            $CI->session->set_flashdata('message', 'Deleted successfully.');
            redirect('user/adadmin_index');
        } else {
            $CI->session->set_flashdata('error', 'Failed to Delete.');
            redirect('user/adadmin_index');
        }
    }
    #=============Super Admin Edit Manage Company===============#
    public function superadmin_company_edit($cid) {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Web_settings');
        $CI->load->model('Companies');
        $setting_detail = $CI->Web_settings->retrieve_setting_editdata();
        $editcompany_info   = $CI->Companies->superadmin_companyedit_data($cid);
        $currency_table      = $CI->Web_settings->getCurrencyDetails();
        $data['currency_table'] = $currency_table;
        $data['setting_detail'] =  $setting_detail;
        $data['editcompany_info'] =  $editcompany_info;
         $content = $this->load->view('users/superadmin_company_edit', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function superadmin_company_delete($cid) {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Web_settings');
        $CI->load->model('Companies');
        $setting_detail = $CI->Web_settings->retrieve_setting_editdata();
        $deletecompany_info = $CI->Companies->superadmin_companydelete_data($cid);
        if ($deletecompany_info !== false) {
            $CI->session->set_flashdata('message', 'Company deleted successfully.');
            redirect('user/managecompany');
        } else {
            $CI->session->set_flashdata('error', 'Failed to delete company.');
            redirect('user/managecompany');
        }
    }
#=============User Manage Company===============#
   public function managecompany()
   {   
        $this->load->model('Companies');
        $this->load->model('Web_settings');
        $setting_detail = $this->Web_settings->retrieve_setting_editdata();
        $data['setting_detail'] =  $setting_detail;
        $content = $this->load->view('users/mange_company', $data, true);
        $this->template->full_admin_html_view($content);
    }
    #==============User page load============#
    public function notificationEmail($id = null)
   {    
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Companies');
        $cl=$CI->Companies->companyList($id);
        $paymentReminder = $cl[0]['payment_reminder_date'];
        $dueDate = $cl[0]['due_date'];
        $s_fees = $cl[0]['subscription_fees'];
        $currency = $cl[0]['currency'];
        $reminderEmail = $cl[0]['mail'];
        $company_id = $cl[0]['company_id'];
        $cal = $dueDate - $paymentReminder;
        $final_date = date('Y-m-' . $cal);
        $current_date = date('Y-m-d');
        $currentFinalDate = new DateTime($final_date);
        $nextBillingDate = clone $currentFinalDate;
        $currentYear = date('Y', strtotime($current_date));
        $currentMonth = date('m', strtotime($current_date));
        $nextBillingDate->setDate($currentYear, $currentMonth + 1, $cal);
        $nextBillingPeriod = $nextBillingDate->format('Y-m-d');
        if($final_date == $current_date){
            $config = array(
              'protocol' => 'smtp',
              'smtp_host' => 'ssl://smtp.googlemail.com',
              'smtp_user' => 'madhu.amoriotech@gmail.com',
              'smtp_pass' => 'qpyu nlvg xnsy ovro',
              'smtp_port' => 465,
              'smtp_timeout' => 30,
              'charset' => 'utf-8',
              'newline' => '\r\n',
              'mailtype' => 'html',
            );
            $this->load->library('email');
            $this->email->initialize($config);
            $this->email->set_newline("\r\n");
            $this->email->set_crlf("\r\n");
            $this->email->from('madhu.amoriotech@gmail.com', 'Stockeai');
            $this->email->to($reminderEmail);
            $this->email->subject('Stockeai billing reminder.');
            $this->email->message('Stockeai billing reminder');
            $file_location = FCPATH . 'uploads/Pdf/'.$cl[0]['files']; 
            if(!empty($cl[0]['files'])){
               $file_location = FCPATH . 'uploads/Pdf/'.$cl[0]['files']; 
               $this->email->attach($file_location);
            }
            if ($this->email->send()) {
                echo "<script>alert('Email Send successfully');</script>"; 
                $data = array(
                    'status' => 'Success',
                    'notification_sent_date' => $final_date,
                    'company_id' => $company_id,
                    'created_date' => $final_date,
                    'invoice_number' => $this->Invoicegenerator(10),
                    'bill_period' => $nextBillingPeriod
                );
            $this->db->insert('bill_history', $data);
            }else{
                echo "<script>alert('Email Send Failed !!!!!');</script>";
                echo 'Error sending email: ' . $this->email->print_debugger();
            }   
        } else if ($final_date > $current_date) {
            $config = array(
              'protocol' => $protocol,
              'smtp_host' => $domain_name,
              'smtp_user' => $stm_user,
              'smtp_pass' => $stm_pass,
              'smtp_port' => 465,
              'smtp_timeout' => 30,
              'charset' => 'utf-8',
              'newline' => '\r\n',
              'mailtype' => 'html',
            );
            $this->load->library('email');
            $this->email->initialize($config);
            $this->email->set_newline("\r\n");
            $this->email->set_crlf("\r\n");
            $this->email->from($stm_user, 'Stockeai');
            $this->email->to($reminderEmail);
            $this->email->subject('Your subscription payment is past due');
            $this->email->message('Your subscription payment is past due. Please proceed to subscribe to continue your service.');
            if ($this->email->send()) {
                echo "<script>alert('Email Send successfully');</script>"; 
            }else{
                echo "<script>alert('Email Send Failed !!!!!');</script>";
                echo 'Error sending email: ' . $this->email->print_debugger();
            }   
        }
   }
   public function adadmin_index()
   {
        $content = $this->lusers->adadmin_index_data();
        $this->template->full_admin_html_view($content);
   }
    public function adadmin()
    {
    $content = $this->lusers->useraddforms();
        $this->template->full_admin_html_view($content);
    }
    public function index() {
        $content = $this->lusers->index();
        $this->template->full_admin_html_view($content);
    }
    public function insert_admin_user()
    {
        $this->form_validation->set_rules('companyid', 'Company Name', 'required');
        $this->form_validation->set_rules('user_name', 'User name', 'trim|required');
        $this->form_validation->set_rules('admin_password', 'Password', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $response['status'] = 'failure';
            $response['msg']    = validation_errors();
        } else {
            $company_id     = $this->input->post('companyid',true);
            $username       = $this->input->post('user_name',true);
            $email_id       = $this->input->post('email',true);
            $num_str = sprintf("%03d", mt_rand(1, 999));
            $password = md5("gef" . $this->input->post('admin_password',true));
            $uid=$_SESSION['user_id'];
            $data = array( 
                'unique_id'  =>    "AD".$company_id.$num_str, 
                'create_by'     => $uid,
                );
                $insert=$this->db->insert('users',$data);
                $sql='insert into user_login(
                                          `user_id`,
                                          `username`,
                                          `unique_id`,
                                          `password`,
                                          `user_type`,
                                          `email_id`,
                                          `cid`,
                                          `u_type`,
                                          `create_by`
            )values(
                "'.$company_id.'",
            "'.$_POST['user_name'].'",
            "'."AD".$company_id.$num_str.'", 
            "'.$password.'",
            "2",
            "'.$email_id.'",
            "'.$company_id.'",
            "2",
            "'.$uid.'")';
            $query=$this->db->query($sql);
            if($query)
            {
                $response['status'] = 'success';
                $response['msg']    = 'Admin has been added successfully';
            }else{
                $response['status'] = 'failure';
                $response['msg']    = 'Failed to add admin. Please try again.';
            }
        }
        echo json_encode($response);
    }
    public function insertedit_admin_user()
    {
       $this->load->library('form_validation');
        $this->load->helper('url');
        $this->form_validation->set_rules('user_name', 'User Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $response['status'] = 'failure';
            $response['msg']    = validation_errors();
        } else {
            $unique_id = $this->input->post('unique_id', true);
            if ($unique_id) {
                $user_name = $this->input->post('user_name', true);
                $email_id = $this->input->post('email', true);
                $this->load->database();
                $data = array(
                    'username' => $user_name,
                    'email_id' => $email_id,
                     'modified_date' => date('Y-m-d H:i:s')
                );
                $this->db->where('unique_id', $unique_id);
                $res = $this->db->update('user_login', $data);
                $response['status'] = 'success';
                $response['msg']    = 'Admin user has been updated successfully';
            } else {
                $response['status'] = 'failure';
                $response['msg']    = 'Unique ID is required';
            }
        }
        echo json_encode($response);
    }
    // Change By Ajith on 28/08/2024
    public function company_insert_branch(){
        $uid = $this->input->post('decodedId',TRUE);
        $url=$this->input->post('url',TRUE);
        $url_st=$this->input->post('url_st',TRUE);
        $url_lctx=$this->input->post('url_lctx',TRUE);
        $url_sstx=$this->input->post('url_sstx',TRUE);
        $c_id=$this->input->post('company_id',TRUE);
        $this->db->where('company_id',$c_id,TRUE);
        $this->db->delete('company_information');
        $this->db->where('company_id',$c_id,TRUE);
        $this->db->delete('url');
        $this->db->where('company_id',$c_id,TRUE);
        $this->db->delete('url_st');
        $this->db->where('company_id',$c_id,TRUE);
        $this->db->delete('url_lctx');
        $this->db->where('company_id',$c_id,TRUE);
        $this->db->delete('url_sstx');
        $data = array(
            'company_name'    =>$this->input->post('company_name',true),
            'email' => $this->input->post('email',true),
            'address'      => $this->input->post('address',true),
            'mobile'   => $this->input->post('mobile',true),
            'website'  => $this->input->post('website',true),
            'c_city'      => $this->input->post('c_city',true),
            'c_state'      => $this->input->post('c_state',true),
            'Bank_Name'      => $this->input->post('Bank_Name',true),
            'Account_Number'      => $this->input->post('Account_Number',true),
            'Bank_Routing_Number'      => $this->input->post('Bank_Routing_Number',true),
            'Bank_Address'      => $this->input->post('Bank_Address',true),
            'Federal_Pin_Number'      => $this->input->post('Federal_Pin_Number',true),
            'st_tax_id'      => $this->input->post('statetx',true),
            'lc_tax_id'      => $this->input->post('localtx',true),
            'State_Sales_Tax_Number'      => $this->input->post('State_Sales_Tax_Number',true),
            'create_by'     => $uid,
            'status'     => 0
        );
        $insert=  $this->db->insert('company_information',$data); 
        $insert_id = $this->db->insert_id();
        $user_name=$this->input->post('user_name',TRUE);
        $password=$this->input->post('password',TRUE);
        $pin_number=$this->input->post('pin_number',TRUE);
        if($url){
        for ($i = 0, $n = count($url); $i < $n; $i++) {
            $url1 = $url[$i];
            $user_name1 = $user_name[$i];
            $password1 = $password[$i];
            $pin_number1 = $pin_number[$i];
            $data = array(
            'url'         =>$url1,
            'user_name'         =>$user_name1,
            'password'         =>$password1,
            'create_by'     => $uid,
            'company_id'  =>$insert_id,
            'pin_number'         =>$pin_number1
            );
            $this->db->insert('url', $data);
        }
    }
        $user_name_st=$this->input->post('user_name_st',TRUE);
        $password_st=$this->input->post('password_st',TRUE);
        $pin_number_st=$this->input->post('pin_number_st',TRUE);
        if($url_st){
        for ($i = 0, $n = count($url_st); $i < $n; $i++) {
            $url_st1 = $url_st[$i];
            $user_name_st1 = $user_name_st[$i];
            $password_st1 = $password_st[$i];
            $pin_number_st1 = $pin_number_st[$i];
            $data = array(
            'url_st'         =>$url_st1,
            'user_name_st'    =>$user_name_st1,
            'password_st'         =>$password_st1,
            'create_by'     => $uid,
            'company_id'  =>$insert_id,
            'pin_number_st'         =>$pin_number_st1
            );
            $this->db->insert('url_st', $data);
        } 
    }
        $user_name_lctx=$this->input->post('user_name_lctx',TRUE);
        $password_lctx=$this->input->post('password_lctx',TRUE);
        $pin_number_lctx=$this->input->post('pin_number_lctx',TRUE);
        if($url_lctx){
        for ($i = 0, $n = count($url_lctx); $i < $n; $i++) {
            $url_lctx1 = $url_lctx[$i];
            $user_name_lctx1 = $user_name_lctx[$i];
            $password_lctx1 = $password_lctx[$i];
            $pin_number_lctx1 = $pin_number_lctx[$i];
            $data = array(
            'url_lctx'         =>$url_lctx1,
            'user_name_lctx'    =>$user_name_lctx1,
            'password_lctx'         =>$password_lctx1,
            'create_by'     => $uid,
            'company_id'  =>$insert_id,
            'pin_number_lctx'         =>$pin_number_lctx1
            );
            $this->db->insert('url_lctx', $data);
            } 
        }
        $user_name_sstx=$this->input->post('user_name_sstx',TRUE);
        $password_sstx=$this->input->post('password_sstx',TRUE);
        $pin_number_sstx=$this->input->post('pin_number_sstx',TRUE);
          if($url_sstx){
           for ($i = 0, $n = count($url_sstx); $i < $n; $i++) {
            $url_sstx1 = $url_sstx[$i];
            $user_name_sstx1 = $user_name_sstx[$i];
            $password_sstx1 = $password_sstx[$i];
            $pin_number_sstx1 = $pin_number_sstx[$i];
            $data = array(
            'url_sstx'         =>$url_sstx1,
            'user_name_sstx'    =>$user_name_sstx1,
            'password_sstx'         =>$password_sstx1,
            'create_by'     => $uid,
            'company_id'  =>$insert_id,
            'pin_number_sstx'         =>$pin_number_sstx1
            );
            $result =  $this->db->insert('url_sstx', $data);
                } 
            }
            $response['status'] = 'success';
            $response['msg'] = 'Company has been added successfully';
            echo json_encode($response);
        }

    // Change By Ajith on 28/08/2024
    public function company_update_branch($company_id){
 
        $uid = $this->input->post('decodedId',TRUE);
        $id=$company_id;
        $url=$this->input->post('url',TRUE);
        $url_st=$this->input->post('url_st',TRUE);
        $url_lctx=$this->input->post('url_lctx',TRUE);
        $url_sstx=$this->input->post('url_sstx',TRUE);
        $c_id=$this->input->post('company_id',TRUE);
        $this->db->where('company_id',$c_id,TRUE);
        $this->db->delete('company_information');
        $this->db->where('company_id',$c_id,TRUE);
        $this->db->delete('url');
        $this->db->where('company_id',$c_id,TRUE);
        $this->db->delete('url_st');
        $this->db->where('company_id',$c_id,TRUE);
        $this->db->delete('url_lctx');
        $this->db->where('company_id',$c_id,TRUE);
        $this->db->delete('url_sstx');
            $data = array(
                'company_id'   => $id,
                'company_name'    =>$this->input->post('company_name',true),
                'email' => $this->input->post('email',true),
                'address'      => $this->input->post('address',true),
                'mobile'   => $this->input->post('mobile',true),
                'website'  => $this->input->post('website',true),
                'c_city'      => $this->input->post('c_city',true),
                'c_state'      => $this->input->post('c_state',true),
                'Bank_Name'      => $this->input->post('Bank_Name',true),
                'Account_Number'      => $this->input->post('Account_Number',true),
                'Bank_Routing_Number'      => $this->input->post('Bank_Routing_Number',true),
                'Bank_Address'      => $this->input->post('Bank_Address',true),
                'Federal_Pin_Number'      => $this->input->post('Federal_Pin_Number',true),
                'st_tax_id'      => $this->input->post('statetx',true),
                'lc_tax_id'      => $this->input->post('localtx',true),
                'State_Sales_Tax_Number'      => $this->input->post('State_Sales_Tax_Number',true),
                'create_by'     => $uid,
                'status'     => 0
            );
            $insert=  $this->db->insert('company_information',$data);  
            $insert_id = $this->db->insert_id();
            $user_name=$this->input->post('user_name',TRUE);
            $password=$this->input->post('password',TRUE);
            $pin_number=$this->input->post('pin_number',TRUE);
            if($url){
            for ($i = 0, $n = count($url); $i < $n; $i++) {
                $url1 = $url[$i];
                $user_name1 = $user_name[$i];
                $password1 = $password[$i];
                $pin_number1 = $pin_number[$i];
                $data = array(
                    'company_id'   => $id,
                'url'         =>$url1,
                'user_name'         =>$user_name1,
                'password'         =>$password1,
                'create_by'     => $uid,
                'company_id'  =>$insert_id,
                'pin_number'         =>$pin_number1
                );
                $this->db->insert('url', $data);
            }
        }
                $user_name_st=$this->input->post('user_name_st',TRUE);
                $password_st=$this->input->post('password_st',TRUE);
                $pin_number_st=$this->input->post('pin_number_st',TRUE);
                if($url_st){
                for ($i = 0, $n = count($url_st); $i < $n; $i++) {
                    $url_st1 = $url_st[$i];
                    $user_name_st1 = $user_name_st[$i];
                    $password_st1 = $password_st[$i];
                    $pin_number_st1 = $pin_number_st[$i];
                    $data = array(
                        'company_id'   => $id,
                    'url_st'         =>$url_st1,
                    'user_name_st'    =>$user_name_st1,
                    'password_st'         =>$password_st1,
                    'create_by'     => $uid,
                    'company_id'  =>$insert_id,
                    'pin_number_st'         =>$pin_number_st1
                    );
                    $this->db->insert('url_st', $data);
                }}
                $user_name_lctx=$this->input->post('user_name_lctx',TRUE);
                $password_lctx=$this->input->post('password_lctx',TRUE);
                $pin_number_lctx=$this->input->post('pin_number_lctx',TRUE);
                if($url_lctx){
                for ($i = 0, $n = count($url_lctx); $i < $n; $i++) {
                    $url_lctx1 = $url_lctx[$i];
                    $user_name_lctx1 = $user_name_lctx[$i];
                    $password_lctx1 = $password_lctx[$i];
                    $pin_number_lctx1 = $pin_number_lctx[$i];
                    $data = array(
                        'company_id'   => $id,
                    'url_lctx'         =>$url_lctx1,
                    'user_name_lctx'    =>$user_name_lctx1,
                    'password_lctx'         =>$password_lctx1,
                    'create_by'     => $uid,
                    'company_id'  =>$insert_id,
                    'pin_number_lctx'         =>$pin_number_lctx1
                    );
                    $this->db->insert('url_lctx', $data);
                }
            }
                $user_name_sstx=$this->input->post('user_name_sstx',TRUE);
                $password_sstx=$this->input->post('password_sstx',TRUE);
                $pin_number_sstx=$this->input->post('pin_number_sstx',TRUE);
                if($url_sstx){
                for ($i = 0, $n = count($url_sstx); $i < $n; $i++) {
                    $url_sstx1 = $url_sstx[$i];
                    $user_name_sstx1 = $user_name_sstx[$i];
                    $password_sstx1 = $password_sstx[$i];
                    $pin_number_sstx1 = $pin_number_sstx[$i];
                    $data = array(
                        'company_id'   => $id,
                    'url_sstx'         =>$url_sstx1,
                    'user_name_sstx'    =>$user_name_sstx1,
                    'password_sstx'         =>$password_sstx1,
                    'create_by'     => $uid,
                    'company_id'  =>$insert_id,
                    'pin_number_sstx'         =>$pin_number_sstx1
                    );
                    $result = $this->db->insert('url_sstx', $data);
                }
            }
            $response['status'] = 'success';
            $response['msg'] = 'Company Updated has been added successfully';
            echo json_encode($response);
        }


public function company_insert(){
    $this->form_validation->set_rules('company_name', 'Company Name', 'required');
    $this->form_validation->set_rules('email', 'Company Email', 'required|valid_email');
    $this->form_validation->set_rules('mobile', 'Mobile', 'required');
    $this->form_validation->set_rules('c_city', 'City', 'required');
    $this->form_validation->set_rules('c_state', 'State', 'required');
    $this->form_validation->set_rules('address', 'Address', 'required');
    $this->form_validation->set_rules('website', 'Website', 'required');
    if (empty($_FILES['image']['name']))
    {
        $this->form_validation->set_rules('image', 'Logo', 'required');
    } 
    $this->form_validation->set_rules('payment_reminder_date', 'Payment Reminder Period', 'required');
    $this->form_validation->set_rules('currency', 'Currency', 'required');
    $this->form_validation->set_rules('due_date', 'Payment Due Date', 'required');
    $this->form_validation->set_rules('subscription_fees', 'Subscription Fees / Month', 'required');
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');
    $this->form_validation->set_rules('user_email', 'Email', 'required');
     $response = array();
     if ($this->form_validation->run() == FALSE) {
         $response['status'] = 'failure';
        $response['msg']    = validation_errors();
    } else {
        if ($_FILES['image']['name']) {
        $config['upload_path']    = 'my-assets/image/logo/';
        $config['allowed_types']  = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
        $config['encrypt_name']   = TRUE;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('image')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                redirect(base_url('Admin_dashboard/edit_profile'));
            } else {
            $data = $this->upload->data();
            $logo = $config['upload_path'].$data['file_name'];
            $config['image_library']  = 'gd2';
            $config['source_image']   = $logo;
            $config['create_thumb']   = false;
            $config['maintain_ratio'] = TRUE;
            $config['width']          = 200;
            $config['height']         = 200;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $logo =  $logo;
            }
        }
            $uid=$_SESSION['user_id'];
            $data = array(
                'company_name'          =>$this->input->post('company_name',true),
                'email'                 => $this->input->post('email',true),
                'c_city'                => $this->input->post('c_city',true),
                'c_state'               => $this->input->post('c_state',true),
                'address'               => $this->input->post('address',true),
                'mobile'                => $this->input->post('mobile',true),
                'website'               => $this->input->post('website',true),
                'user_name'             => $this->input->post('username',true),
                'password'              => $this->input->post('password',true),
                'payment_reminder_date' => $this->input->post('payment_reminder_date',true),
                'currency'              => $this->input->post('currency',true),
                'due_date'              => $this->input->post('due_date',true),
                'subscription_fees'     => $this->input->post('subscription_fees',true),
                'logo'       => $logo,
                'create_by'     => $uid,
                'status'     => 0,
                 'follow_up_mail'      => $this->input->post('mail',true),
                 'mail'      => $this->input->post('user_email',true),
                 'currency'      => $this->input->post('currency',true)
            );
            $company_id = $this->input->post('company_id');
            if (!empty($company_id)) {
                $this->db->where('company_id', $company_id);
                $this->db->update('company_information', $data);
            } else {
                $this->db->insert('company_information', $data);
            }
             $cid= $this->db->insert_id();
             $data1 = array(
                'create_by'     => $cid,
             );
             $this->db->insert('web_setting',$data1);
             $data2 = array(
                'create_by'     => $cid,
                 'uid'     => $cid
             );
             $this->db->insert('invoice_design',$data2);
             $num_str = sprintf("%03d", mt_rand(1, 999));
             $data = array(
               'unique_id'  =>   "AD".$cid.$num_str,
                'create_by'     => $uid,
                'user_id'     => $cid
            );
             $insert=$this->db->insert('users',$data);
             $data = array(
                'username'    =>$this->input->post('username',true),
                'password' => md5("gef" . $this->input->post('password',true)),
               'unique_id'  =>   "AD".$cid.$num_str,
                'user_type'      => 1+1,
                'u_type'      => 1+1,
                'security_code'   => $this->input->post('mobile',true),
                'email_id'  => $this->input->post('user_email',true),
                'status'       =>0,
                'cid'     => $cid,
                'user_id' =>$cid,
                'create_by'     => $uid,
            );
             $insert=$this->db->insert('user_login',$data);
             $data3 = array(
                'cid'     => $cid,
                'user_id' =>$cid,
                'create_by'     => $uid,
            );
            $insert=$this->db->insert('payslip_invoice_design',$data3);
            if($insert)
             {
                $response['status'] = 'success';
                $response['msg']    = 'Company has been added successfully';
             }else{
                $response['status'] = 'failure';
                $response['msg']    = 'Failed to add company. Please try again.';
             }
        }
        echo json_encode($response);
    }
public function update_company() {
    $this->form_validation->set_rules('company_name', 'Company Name', 'required');
    $this->form_validation->set_rules('email', 'Company Email', 'required|valid_email');
    $this->form_validation->set_rules('mobile', 'Mobile', 'required');
    $this->form_validation->set_rules('c_city', 'City', 'required');
    $this->form_validation->set_rules('c_state', 'State', 'required');
    $this->form_validation->set_rules('address', 'Address', 'required');
    $this->form_validation->set_rules('website', 'Website', 'required');
    $this->form_validation->set_rules('payment_reminder_date', 'Payment Reminder Period', 'required');
    $this->form_validation->set_rules('currency', 'Currency', 'required');
    $this->form_validation->set_rules('due_date', 'Payment Due Date', 'required');
    $this->form_validation->set_rules('subscription_fees', 'Subscription Fees / Month', 'required');
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');
    $this->form_validation->set_rules('user_email', 'Email', 'required');
    $response = array();
    if ($this->form_validation->run() == FALSE) {
        $response['status'] = 'failure';
        $response['msg'] = validation_errors();
    } else {
        $logo = $this->input->post('old_profileimage'); 
        if (!empty($_FILES['image']['name'])) {
            $config['upload_path'] = 'my-assets/image/logo/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('image')) {
                $data = $this->upload->data();
                $logo = $config['upload_path'] . $data['file_name'];
                $this->load->library('image_lib');
                $this->image_lib->initialize(array(
                    'image_library' => 'gd2',
                    'source_image' => $logo,
                    'create_thumb' => false,
                    'maintain_ratio' => TRUE,
                    'width' => 200,
                    'height' => 200
                ));
                $this->image_lib->resize();
            } else {
                $response['status'] = 'failure';
                $response['msg'] = $this->upload->display_errors();
                echo json_encode($response);
                return;
            }
        }
        $uid = $_SESSION['user_id'];
        $date = date('Y-m-d H:i:s');
        $data = array(
            'company_name' => $this->input->post('company_name', true),
            'email' => $this->input->post('email', true),
            'c_city' => $this->input->post('c_city', true),
            'c_state' => $this->input->post('c_state', true),
            'address' => $this->input->post('address', true),
            'mobile' => $this->input->post('mobile', true),
            'website' => $this->input->post('website', true),
            'user_name' => $this->input->post('username', true),
             'user_name' => $this->input->post('username', true),
            'password' => $this->input->post('password', true),
            'payment_reminder_date' => $this->input->post('payment_reminder_date', true),
            'currency' => $this->input->post('currency', true),
            'due_date' => $this->input->post('due_date', true),
            'subscription_fees' => $this->input->post('subscription_fees', true),
            'logo' => $logo,
            'status' => 0,
            'modified_date' =>$date,
            'modified_by'  => $uid,
            'follow_up_mail' => $this->input->post('mail', true),
            'mail' => $this->input->post('user_email', true)
        );
        $company_id = $this->input->post('company_id');
        if (!empty($company_id)) {
            $this->db->where('company_id', $company_id);
            $insert = $this->db->update('company_information', $data);
        }
        $data = array(
            'username'    =>$this->input->post('username',true),
            'password' => md5("gef" . $this->input->post('password',true)),
            'security_code'   => $this->input->post('mobile',true),
            'email_id'  => $this->input->post('user_email',true),
        );
         $user_id = $this->input->post('company_id');
         if (!empty($user_id)) {
             $this->db->where('user_id', $user_id);
             $insert = $this->db->update('user_login', $data);
         }
        if ($insert) {
            $response['status'] = 'success';
            $response['msg'] = 'Company has been updated successfully';
        } else {
            $response['status'] = 'failure';
            $response['msg'] = 'Failed to update company. Please try again.';
        }
    }
    echo json_encode($response);
}
public function add_user()
{
       $content = $this->lusers->ad_user();
        $this->template->full_admin_html_view($content);
    }
#==============Chnage Status=============#
  public function change_company_status($value, $id)
{
    $this->db->set('status', $value);
    $this->db->where('company_id', $id);
    $this->db->update('company_information');
    $this->db->set('status', $value);
    $this->db->where('cid', $id);
    $this->db->update('user_login');
    // Check if both updates were successful
    if ($this->db->affected_rows() > 0) {
        redirect('user/managecompany');
    }
}
    #===============User Search Item===========#
 public function company_edit($id){
  $sql='select * from company_information where company_id='.$id;
 $query=$this->db->query($sql);
$row=$query->result_array();  
  $sql='select * from user_login where cid='.$id;
 $query=$this->db->query($sql);
$row1=$query->result_array(); 
    $data=array(
        'company_info'=>$row,
        'user_info'=>$row1,
);
   $content = $this->lusers->company_edit_form($data);
 $this->template->full_admin_html_view($content);
 }
public function company_update()
{
}
public function insert_users()
{
$password=md5('gef'.$_POST['password']);
      $sql='select * from user_login
      where user_id='.$_SESSION['user_id'];
    $query=$this->db->query($sql);
    $row=$query->result_array();
     $cid=$row[0]['cid'];
$sql='SELECT * FROM `users` ORDER BY `id` DESC';
$query=$this->db->query($sql);
    $row=$query->result_array();
  $finalid=$row[0]['id']+1;
 $id=$this->db->insert_id();
    $num_str = sprintf("%03d", mt_rand(1, 999));
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $combinedValue = isset($_POST['employee_name']) ? $_POST['employee_name'] : ''; 
    $splitValues = explode(' ', $combinedValue);
    if (count($splitValues) >= 3) {
        $id = $splitValues[0];
        $first_name = $splitValues[1];
        $last_name = $splitValues[2];
        $data = array(
            'last_name' => $last_name,   
            'first_name' => $first_name,
            'employee_id' => $id,       
            'company_name' => $_SESSION['user_id'],
            'phone' => $_POST['phone'],
            'user_id' => $_SESSION['user_id'],
            'gender' => $_POST['gender'],
            'unique_id' => "UD" . $_SESSION['user_id'] . $num_str,
            'date_of_birth' => $_POST['Date'],
            'create_by' => $_SESSION['user_id']
        );
        $this->db->insert('users', $data);
    }
}
$data = array(
    'username' => $_POST['username'],
    'password' => $password,
    'unique_id' => 'UD' . $_SESSION['user_id'] . $num_str,
    'user_id' => $_SESSION['user_id'],
    'u_type' => 3,
    'email_id' => $_POST['email'],
    'cid' => $_SESSION['user_id']
);
$this->db->insert('user_login', $data);
$this->session->set_userdata(array('message' => display('successfully_added')));
    redirect('User/manage_user');
}
    public function user_search_item() {
        $user_id = $this->input->post('user_id');
        $content = $this->lusers->user_search_item($user_id);
        $this->template->full_admin_html_view($content);
    }
    #================Manage User===============#
    public function manage_user() {
        $content = $this->lusers->user_list();
        $this->template->full_admin_html_view($content);
    }
    #==============Add  Company and admin user==============#
    #==============Insert User==============#
    public function insert_user() {
        $this->load->library('upload');
        if (($_FILES['logo']['name'])) {
            $files = $_FILES;
            $config = array();
            $config['upload_path'] = 'assets/dist/img/profile_picture/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['max_size'] = '1000000';
            $config['max_width'] = '1024000';
            $config['max_height'] = '768000';
            $config['overwrite'] = FALSE;
            $config['encrypt_name'] = true;
            $this->upload->initialize($config);
              if (!$this->upload->do_upload('logo')) {
                $data['error_message'] = $this->upload->display_errors();
                $this->session->set_userdata($sdata);
                redirect('user');
            } else {
                $view = $this->upload->data();
                $logo = base_url($config['upload_path'] . $view['file_name']);
            }
        }
        $data = array(
            'user_id'    => $this->generator(15),
            'first_name' => $this->input->post('first_name',true),
            'last_name'  => $this->input->post('last_name',true),
            'email'      => $this->input->post('email',true),
            'password'   => md5("gef" . $this->input->post('password',true)),
            'user_type'  => $this->input->post('user_type',true),
            'logo'       => (!empty($logo)?$logo:base_url().'assets/dist/img/profile_picture/profile.jpg'),
            'status'     => 1
        );
        $this->lusers->insert_user($data);
        $this->session->set_userdata(array('message' => display('successfully_added')));
        if (isset($_POST['add-user'])) {
            redirect('User/manage_user');
        } elseif (isset($_POST['add-user-another'])) {
            redirect(base_url('User/manage_user'));
        }
    }
    #===============User update form================#
    public function user_update_form($user_id) {
        $user_id = $user_id;
        $content = $this->lusers->user_edit_data($user_id);
        $this->template->full_admin_html_view($content);
    }
    #===============User update===================#
    public function user_update() {
      $this->load->library('upload');
        if (($_FILES['logo']['name'])) {
            $files = $_FILES;
            $config = array();
            $config['upload_path'] = 'assets/dist/img/profile_picture/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['max_size'] = '1000000';
            $config['max_width'] = '1024000';
            $config['max_height'] = '768000';
            $config['overwrite'] = FALSE;
            $config['encrypt_name'] = true;
            $this->upload->initialize($config);
              if (!$this->upload->do_upload('logo')) {
                $sdata['error_message'] = $this->upload->display_errors();
                $this->session->set_userdata($sdata);
                redirect('user');
            } else {
                $view = $this->upload->data();
                $logo = base_url($config['upload_path'] . $view['file_name']);
            }
        }
        $user_id = $this->input->post('user_id');
        $data['user_id'] = $user_id;
        $data['logo']   = $logo;
        $this->Userm->update_user($data);
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('User/manage_user'));
    }
    #============User delete===========#
    public function user_delete($user_id) {
        $this->Userm->delete_user($user_id);
        $this->session->set_userdata(array('message' => display('successfully_delete')));
      redirect(base_url('User/manage_user'));
    }
    // Random Id generator
    public function generator($lenth) {
        $number = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "N", "M", "O", "P", "Q", "R", "S", "U", "V", "T", "W", "X", "Y", "Z", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        for ($i = 0; $i < $lenth; $i++) {
            $rand_value = rand(0, 61);
            $rand_number = $number["$rand_value"];
            if (empty($con)) {
                $con = $rand_number;
            } else {
                $con = "$con" . "$rand_number";
            }
        }
        return $con;
    }
    #============User delete===========#
    public function addusers() { 
         $content = $this->lusers->addusers();
        $this->template->full_admin_html_view($content);
    }
     public function edit_user($id)
     {
        $content = $this->lusers->edit_user($id);
            $this->template->full_admin_html_view($content);
     }
     public function Invoicegenerator($length) {
        $number = array("1", "2", "3", "4", "5", "6", "7", "8", "9");
        $con = "INV-"; 
        for ($i = 0; $i < $length; $i++) {
            $rand_value = rand(0, 8);
            $rand_number = $number[$rand_value];
            $con .= $rand_number;
        }
        return $con;
    }
    //company pagination
    public function getCompanyDatas(){
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $search = $this->input->post('search')['value'];
        $orderField = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
        $orderDirection = $this->input->post('order')[0]['dir'];
        $this->load->model('Companies');
        $totalItems = $this->Companies->getTotalCompanies($search);
        $items = $this->Companies->getPaginatedCompanies($limit, $start, $orderField, $orderDirection,$search);
        $data = array();
        $i =0;
        foreach ($items as $item) {
           $status = $item['status'];
           $company_status = ($status == 0) ? '<span style="color: red; font-weight: bold;">DEACTIVE</span>' : '<span style="color: green; font-weight: bold;">ACTIVE</span>';
            $i++;
            $row = array();
            $row['company_id'] = $i;
            $row['company_name']    = $item['company_name'];
            $row['email']           = $item['email'];
            $row['address']         = $item['address'];
            $row['mobile']          = $item['mobile'];
            $row['website']         = $item['website'];
            $cid                    = $item['company_id'];
            $status_url             = $item['status'] ==0 ? base_url('user/change_company_status/1/'.$cid) : base_url('user/change_company_status/0/'.$cid);
            $btn_status             = $item['status'] ==0 ? 'btn-success' : 'btn-danger';
            $btn_text               = $item['status'] ==0 ? 'Active' : 'Deactive';
            $row['status']          = $company_status." ".'<a href="'.$status_url.'" class="btn '.$btn_status.'" style="font-size:11px; width:68px;">'.$btn_text.'</a>';
            $edit                   ='<a href="'.base_url('user/superadmin_company_edit/'.$cid).'" class="btnclr btn  btn-sm" style="background-color:#424f5c; margin-right: 5px;"  ><i class="fa fa-pencil" aria-hidden="true"></i> </a>';                            
            $delete                 = '<a onclick="return confirm('.display('are_you_sure').')" href="'.base_url('user/superadmin_company_delete/').$cid.'" class="btnclr btn  btn-sm" style="background-color:#424f5c;"><i class="fa fa-trash-o" aria-hidden="true"></i> </a>';
            $row['action']         = $edit.' '.$delete;
            $data[] = $row;
        }
        $response = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $totalItems,
            "recordsFiltered" => $totalItems,
            "data" => $data,
        );
        echo json_encode($response);
    }
    //Admin pagination
    public function getAdminDatas() {
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $search = $this->input->post('search')['value'];
        $orderField = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
        $orderDirection = $this->input->post('order')[0]['dir'];
        $this->load->model('Companies');
        $totalItems = $this->Companies->getTotalAdmin($search);
        $items = $this->Companies->getPaginatedAdmin($limit, $start, $orderField, $orderDirection, $search);
        $data = array();
        $i = 0;
        foreach ($items as $item) {
         $i++;
        $edit = '<a href="' . base_url('user/superadmin_user_edit/' . $item['unique_id']) . '" class="btnclr btn btn-sm" style="background-color:#424f5c; margin-right: 5px;"><i class="fa fa-pencil" aria-hidden="true"></i></a>'; 
       $delete = '<a href="' . base_url('user/superadmin_user_delete/' . $item['unique_id']) . '" class="btnclr btn btn-sm" style="background-color:#424f5c; margin-right: 5px;"><i class="fa fa-trash" aria-hidden="true"></i></a>'; 
        $row = array(
            'company_id'=>$i,
        'company_name' => $item['company_name'],
        'username' => $item['username'],  
        'email_id' => $item['email_id'], 
        'action' => $edit.$delete,
        );
        $data[] = $row;
        }
        $response = array(
        "draw" => intval($this->input->post('draw')),
        "recordsTotal" => $totalItems,
        "recordsFiltered" => $totalItems,  
        "data" => $data,
        );
        echo json_encode($response);
    }
}