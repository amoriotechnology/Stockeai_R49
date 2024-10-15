<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Web_settings extends CI_Model
{
    private $table = "language";
    private $phrase = "phrase";
    public function __construct()
    {
        parent::__construct();
    }
    public function Fetchemailattachment($id = null)
    {
        $this->db->select('*');
        $this->db->from('email_data');
        $this->db->where('id', $id);
        $this->db->where('created_by', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    public function update_notification_status($notification_id)
    {
        $this->db->where('id', $notification_id);
        $this->db->update('schedule_list', array('bell_notification' => 0));
        return $this->db->affected_rows() > 0;
    }
    public function schedule_alert($data)
    {
        $existing_record = $this->db->where('unique_id', $data['unique_id'])->where('menu', $data['menu'])
            ->where('created_by', $data['created_by'])->get('notification')->row();
        if ($existing_record) {
            $this->db->where('unique_id', $data['unique_id'])->where('menu', $data['menu'])
                ->where('created_by', $data['created_by'])->update('notification', $data);
        } else {
            $this->db->insert('notification', $data);
        }
        return true;
    }
    public function show_all_bell_notification()
    {
        $todayDate = date('Y-m-d');
        $this->db->select('*');
        $this->db->from('schedule_list');
        $this->db->where('created_by', $this->session->userdata('user_id'));
        $this->db->where('start', $todayDate);
        $this->db->where('bell_notification', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    public function searchAllData($postData = null)
    {
        $this->db->select('ws.*, pi.*, ci.*');
        $this->db->from('web_setting ws');
        $this->db->join('product_information pi', 'ws.create_by = pi.created_by', 'left');
        $this->db->join('company_information ci', 'ci.company_id = pi.created_by', 'left');
        $this->db->where('ws.agree_share', 'Yes');
        $this->db->like('pi.product_name', $postData);
        $query = $this->db->get();
        if ($query) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_info_data($postData)
    {
        $this->db->select('ws.*, pi.*, ci.*');
        $this->db->from('web_setting ws');
        $this->db->join('product_information pi', 'ws.create_by = pi.created_by', 'left');
        $this->db->join('company_information ci', 'ci.company_id = pi.created_by', 'left');
        $this->db->where('ws.agree_share', 'Yes');
        $this->db->like('pi.product_name', $postData);
        $query = $this->db->get();
        if (!$query) {
            $error = $this->db->error();
            log_message('error', 'Database error: ' . $error['message']);
            return false;
        }
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    public function retrieve_agentcheck()
    {
        $this->db->select('i.*, a.*');
        $this->db->from('invoice i');
        $this->db->join('agent a', 'a.agent_name=i.user_emp_id');
        $this->db->where('i.sales_by', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function retrieve_agentviewcheck($id = null)
    {
        $this->db->select('i.*, a.*');
        $this->db->from('invoice i');
        $this->db->join('agent a', 'a.agent_name=i.user_emp_id');
        $this->db->where('a.id', $id);
        $this->db->where('i.sales_by', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
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
    public function getCurrencyDetails()
    {
        $this->db->select('code, description, symbol');
        $this->db->from('currency');
        $query = $this->db->get();
        if ($query === false) {
            return false;
        }

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return false;
    }

    public function getStateDetails()
    {
        $this->db->select('state_name');
        $this->db->from('states');
        $query = $this->db->get();
        if ($query === false) {
            return false;
        }

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
       public function getCountryDetails()
    {
        $this->db->select('iso,iso3,nickname,id');
        $this->db->from('country');
        $query = $this->db->get();
        if ($query === false) {
            return false;
        }

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function get_employee_data()
    {
        $this->db->select('*');
        $this->db->from('employee_history');
        $this->db->where('create_by', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query === false) {
            return false;
        }

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    // insertDateforScheduleStatus - Madhu
    public function insertDateforScheduleStatus($admin_comp_id)
    {
        $this->db->select('*');
        $this->db->from('schedule_list');
        $this->db->where('schedule_status', 1);
        $this->db->where('source', 'CALENDER');
        $this->db->where('created_by', $admin_comp_id);
        $query = $this->db->get();
        if ($query === false) {
            return false;
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    // insertDateforSchedule - Madhu
    public function insertDateforSchedule($admin_comp_id)
    {
        $this->db->select('id, title, description, start, end');
        $this->db->from('schedule_list');
        $this->db->where('source', 'CALENDER');
        $this->db->where('created_by', $admin_comp_id);
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    public function calender_alert()
    {
        $todayDate = date('Y-m-d');
        $this->db->select('*');
        $this->db->from('schedule_list');
        $this->db->where('created_by', $this->session->userdata('user_id'));
        $this->db->where('start', $todayDate);
        $this->db->where('source', 'CALENDER');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    public function save_notifications($menu, $select_dates, $statuses, $select_sources, $emails, $companies, $unique_id, $user_id)
    {
        $existing_notifications = $this->db->get_where('notification', array('unique_id' => $unique_id))->result_array();
        if (!empty($existing_notifications)) {
            foreach ($existing_notifications as $notification) {
                if (in_array($notification['menu'], $menu)) {
                    $this->db->delete('notification', array('id' => $notification['id']));
                }
            }
        }
        $notifications = array();
        for ($i = 0; $i < count($menu); $i++) {
            if ($select_sources[$i] != 'Select Preferred Source') {
                $data = array(
                    'menu' => $menu[$i],
                    'unique_id' => $unique_id,
                    'notification_time' => $select_dates[$i],
                    'notification_source' => $select_sources[$i],
                    'created_by' => $user_id,
                );
                $notifications[] = $data;
            }
        }
        if (!empty($notifications)) {
            $this->db->insert_batch('notification', $notifications);
        }
        return true;
    }
    public function setting_for_notification()
    {
        $this->db->select('id');
        $this->db->from('schedule_list');
        $this->db->where('created_by', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    public function get_email_scheduled()
    {
        $todayDate = date('Y-m-d');
        $this->db->select('id, title, description, start, end,invoice_no');
        $this->db->from('schedule_list');
        $this->db->where('source', 'EMAIL');
        $this->db->where('start', $todayDate);
        $this->db->where('created_by', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    public function getDataForTodayEmailSchedule()
    {
        $this->db->select('*');
        $this->db->from('company_information');
        $this->db->where('company_id', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    public function getScheduleData()
    {
        $this->db->select('*');
        $this->db->from('scheduling');
        $this->db->where('created_by', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    public function sentemailretrieve_data()
    {
        $this->db->select('*');
        $this->db->from('email_data');
        $this->db->where('is_deleted', 0);
        $this->db->where('created_by', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    public function inboxretrieve_data()
    {
        $this->db->select('*');
        $this->db->from('email_inbox');
        $this->db->where('is_deletedinbox', 0);
        $this->db->where('created_by', $this->session->userdata('user_id'));
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    public function deleteemailretrieve_data()
    {
        $this->db->select('*');
        $this->db->from('email_data');
        $this->db->where('is_deleted', 1);
        $this->db->where('created_by', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    public function deleteInboxemailretrieve_data()
    {
        $this->db->select('*');
        $this->db->from('email_inbox');
        $this->db->where('is_deletedinbox', 1);
        $this->db->where('created_by', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    public function getInboxmessagedata($msg_id = null)
    {
        $this->db->select('*');
        $this->db->from('email_inbox');
        $this->db->where('id', $msg_id);
        $this->db->where('created_by', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    public function usersretrieve_data()
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
    public function update_invoice()
    {
        $this->db->select('*');
        $this->db->from('sales_invoice_settings');
        $this->db->where('invoice_template', 'Sales_Quote');
        $this->db->where('create_by', $_SESSION['user_id']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    public function ocean_remarks($company_id ="")
    {
        $this->db->select('*');
        $this->db->from('sales_invoice_settings');
        $this->db->where('invoice_template', 'Ocean_Export_Tracking');
        if($company_id !=""){
            $this->db->where('create_by', $company_id);
        }else{
            $this->db->where('create_by', $this->session->userdata('user_id'));
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    //vijila -05-08-2024
    public function roadtransport_remarks($adminid)
    {
        $this->db->select('*');
        $this->db->from('sales_invoice_settings');
        $this->db->where('invoice_template', 'Road_Transport');
        $this->db->where('create_by', $adminid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    public function retrieve_companysetting_editdata()
    {
        $this->db->select('*');
        $this->db->from('company_information');
        $this->db->where('company_id', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function retrieve_companyall_data()
    {
        $this->db->select('*');
        $this->db->from('company_information');
        $this->db->where('company_id', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    /* changed on 30-07-2024 -vijila */ 
    public function retrieve_setting_editdata($company_id='')
    {
        $this->db->select('*');
        $this->db->from('web_setting');
        if($company_id !=""){
            $this->db->where('create_by', $company_id);
        }else{
            $this->db->where('create_by', $this->session->userdata('user_id'));
        }
        $query = $this->db->get();
         if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function retrieve_user_data()
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('create_by', $_SESSION['user_id']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function retrieve_admin_data()
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('unique_id', $_SESSION['unique_id']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function retrieve_email_setting()
    {
        $uid = $_SESSION['user_id'];
        $this->db->select('*');
        $this->db->from('invoice_email');
        $this->db->where('uid', $uid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    public function retrieve_setting_new_sale_invoice()
    {
        $this->db->select('*');
        $this->db->from('sales_invoice_settings');
        $this->db->where('invoice_template', 'new_sale');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function update_setting($data)
    {
        $this->db->select('*');
        $this->db->from('web_setting');
        $this->db->where('create_by', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $this->db->where('create_by', $this->session->userdata('user_id'));
            $this->db->update('web_setting', $data);
        } else {
            $this->db->insert('web_setting', $data);
        }
    }
    public function admin_company()
    {
        $this->db->select('company_name');
        $this->db->from('company_information');
        $this->db->where('company_id', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    public function admin_user_mail_ids($company)
    {
        $this->db->select('*');
        $this->db->from('company_information');
        $this->db->where('company_name', $company);
        $this->db->where('company_id', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    public function invoice_desgn()
    {
        $purchase_id = date('YmdHis');
        $mysqltime = date('Y-m-d H:i:s');
        $fomdata = '';
        $this->db->select("*");
        $this->db->from('invoice_design');
        $this->db->where('uid', $_POST['uid']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            if ($fomdata['input'] == 'header') {
                $data = array(
                    'header' => $_POST['value'],
                    'uid' => $_POST['id'],
                );
                $this->db->insert('invoice_design', $data);
            }
            if ($_REQUEST['input'] == 'color') {
                $data = array(
                    'color' => $_POST['value'],
                    'uid' => $_POST['uid'],
                );
                $this->db->insert('invoice_design', $data);
            }
        } else {
            if ($fomdata['input'] == 'header') {
                $data = array(
                    'header' => $_POST['value']
                );
                $this->db->where('uid', $_POST['uid']);
                $this->db->update('invoice_design', $data);
            }
            if ($_REQUEST['input'] == 'color') {
                $data = array(
                    'color' => $_POST['value']
                );
                $this->db->where('uid', $_POST['uid']);
                $this->db->update('invoice_design', $data);
            }
        }
        return true;
    }
    public function update_invoice_set($decodedId)
    {
        $purchase_id = date('YmdHis');
        $fomdata = $this->input->post();

        // print_r($fomdata['form_type']); die();

        $mysqltime = date('Y-m-d H:i:s');
        if ($fomdata['form_type'] == 'Sales_Quote') {
            $this->db->select("*");
            $this->db->from('sales_invoice_settings');
            $this->db->where('user_id', $fomdata['uid']);
            $this->db->where('invoice_template', $fomdata['form_type']);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $data = array(
                    'Time'       => $mysqltime,
                    'account'    => $fomdata['acc'],
                    'remarks'    => $fomdata['remarks'],
                    'create_by'  =>  $decodedId,
                );
                $this->db->where('user_id', $decodedId);
                $this->db->where('invoice_template', $fomdata['form_type']);
                $this->db->update('sales_invoice_settings', $data);
            } else {
                $data = array(
                    'user_id'    => $decodedId,
                    'invoice_template' => $fomdata['form_type'],
                    'account'    =>  $fomdata['acc'],
                    'remarks'    => $fomdata['remarks'],
                    'Time'       => $mysqltime,
                    'create_by'  => $decodedId,
                );
                $this->db->insert('sales_invoice_settings', $data);
            }
        } else {
            $this->db->select('*');
            $this->db->from('sales_invoice_settings');
            $this->db->where('user_id', $decodedId);
            $this->db->where('invoice_template', $fomdata['form_type']);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $data = array(
                    'Time'       => $mysqltime,
                    'remarks'    => $fomdata['remarks'],
                    'create_by'  =>  $decodedId,
                );
                $this->db->where('user_id', $decodedId);
                $this->db->where('invoice_template', $fomdata['form_type']);
                $this->db->update('sales_invoice_settings', $data);
            } else {
                $data = array(
                    'user_id'   => $decodedId,
                    'invoice_template' => $fomdata['form_type'],
                    'remarks'   => $fomdata['remarks'],
                    'Time'      => $mysqltime,
                    'create_by' => $decodedId,
                );
                $this->db->insert('sales_invoice_settings', $data);
            }
        }
        return true;
    }





    public function update_invoice_setting($data)
    {
        $this->db->insert('invoice_settings', $data);
        return true;
    }
    public function update_user_setting($user_id, $data)
    {
        $this->db->where('user_id', $user_id);
        $this->db->update('users', $data);
        return true;
    }
    public function update_userlogin_setting($user_id, $data)
    {
        $this->db->where('user_id', $user_id);
        $this->db->update('user_login', $data);
        return true;
    }
    public function get_userlogin_setting($user_id)
    {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('user_login');
        return $query->row_array();
    }
    public function get_user_setting($user_id)
    {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('users');
        return $query->row_array();
    }
    public function app_settingsdata()
    {
        return $result = $this->db->select('*')
            ->from('app_setting')
            ->get()
            ->result_array();
    }
    public function languages()
    {
        if ($this->db->table_exists($this->table)) {
            $fields = $this->db->field_data($this->table);
            $i = 1;
            foreach ($fields as $field) {
                if ($i++ > 2)
                    $result[$field->name] = ucfirst($field->name);
            }
            if (!empty($result))
                return $result;
        } else {
            return false;
        }
    }
    public function currency_list()
    {
        $this->db->select('*');
        $this->db->from('currency_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    //changed on 30-07-2024 - Vijila
    public function bank_list($company_id ='')
    {
        $this->db->select('bank_id,bank_name');
        $this->db->from('bank_add');
       if($company_id !=""){
            $this->db->where('created_by', $company_id);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
   // created  by Ajith on 27-08-24
    public function get_data_sales( $decodedId ){
        $this->db->select('remarks , account');
        $this->db->from('sales_invoice_settings');
        $this->db->where('invoice_template', 'Sales_Quote');
        $this->db->where('create_by', $decodedId );
        $query = $this->db->get();
         if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    // created  by Ajith on 27-08-24
      public function get_data_ocean( $decodedId ){
        $this->db->select('remarks , account');
        $this->db->from('sales_invoice_settings');
        $this->db->where('invoice_template', 'Ocean_Export_Tracking');
        $this->db->where('create_by', $decodedId );
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    // created  by Ajith on 27-08-24
      public function get_data_roadtransport( $decodedId ){
        $this->db->select('remarks , account');
        $this->db->from('sales_invoice_settings');
        $this->db->where('invoice_template', 'Road_Transport');
        $this->db->where('create_by', $decodedId );
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
}
