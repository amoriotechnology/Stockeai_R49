<?php
error_reporting(1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Customers extends CI_Model {
    public function __construct() {
        parent::__construct();
         $this->load->helper('lang_helper');
        $this->company_id = decodeBase64UrlParameter($_GET['id']);
    }
    public function company_info_get_data($id) {
        $this->db->select('*');
        $this->db->from('customer_information');
        $this->db->where('customer_id', $id);
        $this->db->where('create_by', $this->session->userdata('user_id'));
        $query = $this->db->get();
        return $query->result_array();
    }
    public function company_invoice_data($id) {
        $this->db->select('*');
        $this->db->from('invoice');
        $this->db->where('customer_id', $id);
        $this->db->where('sales_by', $this->session->userdata('user_id'));
        $this->db->order_by('payment_due_date', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function customer_overall_amt_bal($id) {
        $this->db->select(
            "SUM(a.paid_amount) as total_paid_amount, SUM(a.due_amount) as total_due_amount,SUM(a.amount_pay_usd) as total_amount_pay_usd, SUM(a.due_amount_usd) as total_due_amount_usd"
        );
        $this->db->from('invoice a');
        $this->db->where('a.sales_by', $this->session->userdata('user_id'));
        $this->db->where('a.customer_id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function get_all_customers() {
        $this->db->select('*');
        $this->db->from('customer_information');
        $this->db->where('create_by', $this->session->userdata('user_id'));
        $query = $this->db->get();
        return $query->result_array();
    }
  public function getPaginatedCustomers($limit, $offset, $orderField, $orderDirection, $search, $Id) {
    $this->db->select('customer_id, customer_name, customer_type, billing_address, customer_mobile, primary_email, city, state, zip, country, created_date, currency_type, credit_limit');
    $this->db->from('customer_information');
    if ($search != "") {
       $this->db->group_start();
        $this->db->like('customer_name', $search);
        $this->db->or_like('primary_email', $search);
        $this->db->or_like('billing_address', $search);
        $this->db->or_like('customer_mobile', $search);
        $this->db->or_like('zip', $search);
        $this->db->or_like('currency_type', $search);
        $this->db->or_like('customer_type', $search);
        $this->db->or_like('state', $search);
        $this->db->or_like('city', $search);
        $this->db->or_like('country', $search);
        $this->db->group_end();
    }
    $this->db->where('is_deleted', 0);
    $this->db->where('create_by', $Id);
     $this->db->limit($limit, $offset);
    $this->db->order_by($orderField, $orderDirection);
    $query = $this->db->get();
     $result = $query->result_array();
    return $result;
}
 
    public function getTotalCustomers($search, $Id) {
        $this->db->select('customer_name');
        $this->db->from('customer_information');
        if ($search != "") {
            $this->db->or_like(array('customer_name' => $search, 'primary_email' => $search, 'billing_address' => $search, 'customer_mobile' => $search,
                'zip'                                    => $search, 'currency_type' => $search, 'customer_type'   => $search, 'state'           => $search, 'city' => $search, 'country' => $search));
        }
        $this->db->where('is_deleted', 0);
        $this->db->where('create_by', $Id);
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function count_customer() {
        $this->db->select('*');
        $this->db->from('customer_information');
        $this->db->where('create_by', $this->session->userdata('user_id'));
        $this->db->order_by('created_date', 'desc');
        $query = $this->db->get();
        
        if ($query === false) {
            return 0; 
        }
        
        return $query->num_rows();
    }

    public function get_customer_type() {
        $this->db->select('*');
        $this->db->from('customer_type');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function customer_list_count() {
        $this->db->select('*');
        $this->db->from('customer_information');
        $this->db->where('create_by', $this->session->userdata('user_id'));
        $this->db->order_by('create_date', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }
    public function get_payment_terms() {
        $this->db->select('*');
        $this->db->from('payment_terms');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function add_customertype_new($postData) {
        $data = array(
            'c_type'    => $postData,
            'create_by' => $this->company_id,
        );
        $this->db->insert('customer_type', $data);
        $this->db->select('*');
        $this->db->from('customer_type');
        $this->db->where('create_by', $this->company_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function customer_entry($data) 
    {   
        $this->db->insert('customer_information', $data);
        // echo $this->db->last_query();die();
        return $this->db->insert_id();
    }
    
    // Insert Payment
    public function payments_entry($data) 
    {
        $this->db->insert('payment', $data);
        return $this->db->insert_id();
    }

    // Fetch Payment data
    public function fetchpaymentdata($paymentid, $admin_comp_id) 
    {
        $this->db->select('*');
        $this->db->from('payment');
        $this->db->where('id', $paymentid);
        $this->db->where('create_by', $admin_comp_id);
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Update Payment
    public function update_payments($data, $paymentid)
    {
        $this->db->where('id', $paymentid);
        return $this->db->update('payment', $data);
    }

    //Update Customers
    public function update_customers($data, $customerid) 
    {
        $this->db->where('customer_id', $customerid);
        $this->db->update('customer_information', $data);
        return true;
    }


    public function all_customer($admin_id) {
        $this->db->select('*');
        $this->db->from('customer_information');
        $this->db->where('create_by', $admin_id);
        $this->db->where('is_deleted',0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    public function retrieve_company() {
        $this->db->select('*');
        $this->db->from('company_information');
        $this->db->where('create_by', $this->session->userdata('user_id'));
        $this->db->limit('1');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function retrieve_customer_editdata($customer_id) {
        $company_id = isset($_GET['id']) ? $_GET['id'] : null;
        $company_id= decodeBase64UrlParameter($company_id);
        $this->db->select('*');
        $this->db->from('customer_information');
        $this->db->where('customer_id', $customer_id);
        $this->db->where('create_by', $company_id);
        $query = $this->db->get();
   if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function customer_personal_data($id) {
        $this->db->select('*');
        $this->db->from('customer_information');
        $this->db->where('customer_id', $id);
        $this->db->where('create_by', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function customer_invoice_data($customer_id) {
        $this->db->select('*');
        $this->db->from('customer_ledger');
        $this->db->where('create_by', $this->session->userdata('user_id'));
        $this->db->where(array('customer_id' => $customer_id, 'receipt_no' => NULL, 'status' => 1));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }



    public function update_customer($data, $customer_id) {
        $this->db->where('customer_id', $customer_id);
        $this->db->update('customer_information', $data);
        $this->db->select('*');
        $this->db->from('customer_information');
        $this->db->where('create_by', $this->company_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    public function delete_invoicedetails($customer_id) {
        $this->db->where('customer_id', $customer_id);
        $this->db->where('create_by', $this->session->userdata('user_id'));
        $this->db->delete('invoice_details');
    }
    public function delete_invoic($customer_id) {
        $this->db->where('customer_id', $customer_id);
        $this->db->where('create_by', $this->session->userdata('user_id'));
        $this->db->delete('invoice');
    }




    public function delete_customer($customer_id, $created_by,$created_admin) {
       $this->db->set('is_deleted', 1);
              $this->db->set('modified_by', $created_admin);
                     $this->db->set('modified_date', date('Y-m-d H:i:s'));
$this->db->where('customer_id', $customer_id);
$this->db->where('create_by', $created_by);
$this->db->update('customer_information');
    $this->db->select('*');
        $this->db->from('customer_information');
        $this->db->where('create_by', $created_by);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $json_customer[] = array('label' => $row->customer_name, 'value' => $row->customer_id);
        }
        $cache_file   = './my-assets/js/admin_js/json/customer.json';
        $customerList = json_encode($json_customer);
        file_put_contents($cache_file, $customerList);
        return true;
    }




    
    public function headcode() {
        $query = $this->db->query("SELECT MAX(HeadCode) as HeadCode FROM acc_coa WHERE HeadLevel='4' And HeadCode LIKE '1020300%'");
        return $query->row();
    }
    public function customer_search($customer_id) {
        $query = $this->db->select('*')->from('customer_information')
            ->group_start()
            ->like('customer_name', $customer_id)
            ->or_like('customer_mobile', $customer_id)
            ->group_end()
            ->limit(30)
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    
}