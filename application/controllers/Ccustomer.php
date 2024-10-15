<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Ccustomer extends CI_Controller {
    public $menu;
    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->library('lcustomer');
        $this->load->model('Customers');
        $this->load->helper('lang_helper');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->company_id = decodeBase64UrlParameter($_GET['id']);
        $this->auth->check_admin_auth();
    }



    public function index() {
         $encodedId = isset($_GET['id']) ? $_GET['id'] : null;
         $encoded_adminId = $this->session->userdata('unique_id');
         $id = decodeBase64UrlParameter($encodedId);
         if(empty($id)){
             redirect(base_url());
         }
        $decodedId = decodeBase64UrlParameter($encodedId);
        $content   = $this->lcustomer->customer_add_form($encoded_adminId);
        $this->template->full_admin_html_view($content);
    }




    
 public function add_customertype_new() {
$this->form_validation->set_rules('new_customer_type', 'Customer Type', 'required');
$this->form_validation->set_message('required', 'The {field} field is required.');
    $response = array();
    if ($this->form_validation->run() == FALSE) {
         $response['status'] = 'failure';
        $response['msg'] = validation_errors();
    } else {
         $this->load->model('Customers');
        $postData = $this->input->post('new_customer_type');
        $data = $this->Customers->add_customertype_new($postData);
        $response['status'] = 'success';
       $response['msg']    = 'Customer Type has been added successfully';
        $response['data'] = $data;
    }
        echo json_encode($response);
}
    public function transaction_list() {
        $CI =  & get_instance();
        $CI->load->model('Web_settings');
        $CI->load->model('Customers');
        $setting_detail         = $CI->Web_settings->retrieve_setting_editdata();
        $supplier1              = $this->Customers->transaction_customer();
        $currency_details       = $CI->Web_settings->retrieve_setting_editdata();
        $data['customer_info']  = $supplier1;
        $data['currency']       = $currency_details[0]['currency'];
        $data['setting_detail'] = $setting_detail;
        $content                = $CI->parser->parse('report/transaction_list_customer', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function add_customer_csv() {
        $CI   =  & get_instance();
        $data = array(
            'title' => display('add_customer_csv'),
        );
        $content = $CI->parser->parse('customer/add_customer_csv', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function customer_search_item() {
        $customer_id = $this->input->post('customer_id');
        $content     = $this->lcustomer->customer_search_item($customer_id);
        $this->template->full_admin_html_view($content);
    }




    
    public function getCustomerDatas() {
        $encodedId      = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId      = decodeBase64UrlParameter($encodedId);
        $limit          = $this->input->post('length');
        $start          = $this->input->post('start');
        $search         = $this->input->post('search')['value'];
        $orderField     = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
        $orderDirection = $this->input->post('order')[0]['dir'];
        $totalItems     = $this->Customers->getTotalCustomers($search, $decodedId);
        $items          = $this->Customers->getPaginatedCustomers($limit, $start, $orderField, $orderDirection, $search, $decodedId);
        $data           = [];
        $i              = $start + 1;
        foreach ($items as $item) {
            $edit   = '<a href="' . base_url('Ccustomer/customer_update_form?id=' . $encodedId. '&customer_id=' . $item['customer_id']) . '" class="btnclr btn btn-sm" style="background-color:#424f5c; margin-right: 5px;"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            $delete = '<a href="' . base_url('Ccustomer/customer_delete?id=' . $encodedId. '&customer_id=' . $item['customer_id']) . '" class="btn btn-sm btn-danger" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
            $row = [
                "customer_id"     => $i,
                "customer_name"   => $item['customer_name'],
                "customer_type"   => $item['customer_type'],
                "billing_address" => $item['billing_address'],
                "customer_mobile" => $item['customer_mobile'],
                "primary_email"   => $item['primary_email'],
                "city"            => $item['city'],
                "state"           => $item['state'],
                "zip"             => $item['zip'],
                "country"         => $item['country'],
                'created_admin'   => $decoded_admin,
                "created_date"    => $item['created_date'],
                "currency_type"   => $item['currency_type'],
                "credit_limit"    => $item['credit_limit'],
                'action'          => $edit . $delete,
            ];
            $data[] = $row;
            $i++;
        }
        $response = [
            "draw"            => $this->input->post('draw'),
            "recordsTotal"    => $totalItems,
            "recordsFiltered" => $totalItems,
            "data"            => $data,
        ];
        echo json_encode($response);
    }






    public function manage_customer() {
        $id = decodeBase64UrlParameter($_GET['id']);
        if(empty($id)){
            redirect(base_url());
        }
        $this->load->model('Companies');
        $this->load->model('Web_settings');
        $setting_detail         = $this->Web_settings->retrieve_setting_editdata();
        $data['setting_detail'] = $setting_detail;
        $content                = $this->load->view('customer/customer', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function CheckCustomerList() {
        $this->load->model('Customers');
        $postData = $this->input->post();
        $data     = $this->Customers->getCustomerList($postData);
        echo json_encode($data);
    }
    public function insert_customer() {
        $this->form_validation->set_rules('customer_name', 'Customer Name', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('address2', 'Billing Address', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('payment', 'Payment Term', 'required');
        $this->form_validation->set_rules('previous_balance', 'Credit Limit', 'required');
        $this->form_validation->set_rules('tax_status', 'Sales Tax', 'required');
        $this->form_validation->set_rules('email', 'Primary Email', 'required|valid_email');
        $this->form_validation->set_rules('phone', 'Business Phone', 'required');
        $this->form_validation->set_rules('contact', 'Contact Person', 'required');
        $this->form_validation->set_rules('country', 'Country', 'required');
        $this->form_validation->set_rules('zip', 'Zip', 'required');
        $this->form_validation->set_message('alpha_space', 'The {field} field should only contain alphabets and spaces.');
        $response = array();
        if ($this->form_validation->run() == FALSE) {
        $response['status'] = 'failure';
        $response['msg'] = validation_errors();
      
         }
    
    else {
        $vouchar_no = $this->auth->generator(10);
        $company_id = decodeBase64UrlParameter($this->input->post('enc_company_id'));
        $data       = array(
            'customer_name'     => $this->input->post('customer_name', TRUE),
            'billing_address'   => $this->input->post('address', TRUE),
            'shipping_address'  => $this->input->post('address2', TRUE),
            'customer_mobile'   => $this->input->post('mobile', TRUE),
            'currency_type'     => $this->input->post('currency1', TRUE),
            'bussiness_phone'   => $this->input->post('phone', TRUE),
            'fax'               => $this->input->post('fax', TRUE),
            'contact_person'    => $this->input->post('contact', TRUE),
            'city'              => $this->input->post('city', TRUE),
            'customer_type'     => $this->input->post('customer_type', TRUE),
            'state'             => $this->input->post('state', TRUE),
            'zip'               => $this->input->post('zip', TRUE),
            'country'           => $this->input->post('country', TRUE),
            'primary_email'     => $this->input->post('email', TRUE),
            'secondary_email' => $this->input->post('emailaddress', TRUE),
            'credit_limit'      => $this->input->post('previous_balance', TRUE),
            'open_balance'      => $this->input->post('open_balance', TRUE),
            'status'            => 1,
            'create_by'         => $company_id,
            'created_admin'    => $this->session->userdata('unique_id', TRUE), 
            'payment_terms'     => $this->input->post('payment', TRUE),
            'tax_status'        => $this->input->post('tax_status', TRUE),
            'sales_tax'         => $this->input->post('tax', TRUE),
            'tax_percent'       => $this->input->post('taxes', TRUE),
            'created_date'      =>date('Y-m-d H:i:s'),
            'is_deleted'        => 0,
        );
       $result      = $this->db->insert('customer_information', $data);
        $customer_id = $this->db->insert_id();
         if($result)
            {   $response['admin'] = $this->input->post('admin_id', TRUE);
                $response['status'] = 'success';
                $response['msg']    = 'Customer has been added successfully';
            }else{
                $response['status'] = 'failure';
                $response['msg']    = 'Failed to add customer. Please try again.';
            }
    }
     echo json_encode($response);
    }

    function uploadCsv_Customer() {
        $filename = $_FILES['upload_csv_file']['name'];
        $ext      = substr(strrchr($filename, '.'), 1);
        if ($ext == 'csv') {
            $count = 0;
            $fp    = fopen($_FILES['upload_csv_file']['tmp_name'], 'r') or die("can't open file");
            if (($handle = fopen($_FILES['upload_csv_file']['tmp_name'], 'r')) !== FALSE) {
                while ($csv_line = fgetcsv($fp, 1024)) {
                    for ($i = 0, $j = count($csv_line); $i < $j; $i++) {
                        $insert_csv                     = array();
                        $insert_csv['customer_name']    = (!empty($csv_line[0]) ? $csv_line[0] : null);
                        $insert_csv['customer_address'] = (!empty($csv_line[1]) ? $csv_line[1] : '');
                        $insert_csv['address2']         = (!empty($csv_line[2]) ? $csv_line[2] : '');
                        $insert_csv['customer_mobile']  = (!empty($csv_line[3]) ? $csv_line[3] : '');
                        $insert_csv['currency_type']    = (!empty($csv_line[4]) ? $csv_line[4] : '');
                        $insert_csv['phone']            = (!empty($csv_line[5]) ? $csv_line[5] : '');
                        $insert_csv['fax']              = (!empty($csv_line[6]) ? $csv_line[6] : '');
                        $insert_csv['contact']          = (!empty($csv_line[7]) ? $csv_line[7] : '');
                        $insert_csv['city']             = (!empty($csv_line[8]) ? $csv_line[8] : '');
                        $insert_csv['state']            = (!empty($csv_line[9]) ? $csv_line[9] : '');
                        $insert_csv['zip']              = (!empty($csv_line[10]) ? $csv_line[10] : '');
                        $insert_csv['country']          = (!empty($csv_line[11]) ? $csv_line[11] : '');
                        $insert_csv['email_address']    = (!empty($csv_line[12]) ? $csv_line[12] : '');
                        $insert_csv['customer_email']   = (!empty($csv_line[13]) ? $csv_line[13] : '');
                        $insert_csv['payment_terms']    = (!empty($csv_line[14]) ? $csv_line[14] : '');
                        $insert_csv['sales_tax']        = (!empty($csv_line[15]) ? $csv_line[15] : '');
                        $insert_csv['tax_percent']      = (!empty($csv_line[16]) ? $csv_line[16] : '');
                        $insert_csv['credit_limit']     = (!empty($csv_line[17]) ? $csv_line[17] : '');
                        $insert_csv['open_balance']     = (!empty($csv_line[18]) ? $csv_line[18] : '');
                    }
                    $customerdata = array(
                        'customer_name'    => $insert_csv['Customer Name'],
                        'customer_address' => $insert_csv['Customer Address'],
                        'address2'         => $insert_csv['Address 2'],
                        'customer_mobile'  => $insert_csv['Mobile Number'],
                        'currency_type'    => $insert_csv['Currency Type'],
                        'phone'            => $insert_csv['Phone'],
                        'fax'              => $insert_csv['Fax'],
                        'contact'          => $insert_csv['Contact'],
                        'city'             => $insert_csv['City'],
                        'state'            => $insert_csv['State'],
                        'zip'              => $insert_csv['Zipcode'],
                        'country'          => $insert_csv['Country'],
                        'email_address'    => $insert_csv['Primary Email'],
                        'customer_email'   => $insert_csv['Secondary Email'],
                        'payment_terms'    => $insert_csv['Payment Terms'],
                        'sales_tax'        => $insert_csv['Sales Tax'],
                        'tax_percent'      => $insert_csv['Tax Percentage'],
                        'open_balance'     => $insert_csv['Open Balance'],
                        'credit_limit'     => $insert_csv['Credit Limit'],
                        'status'           => 1,
                        'create_by'        => $this->session->userdata('user_id'),
                    );
                    if ($count > 0) {
                        $this->db->insert('customer_information', $customerdata);
                        $customer_id = $this->db->insert_id();
                        if ($coa->HeadCode != NULL) {
                            $headcode = $coa->HeadCode + 1;
                        } else {
                            $headcode = "102030001";
                        }
                        $c_acc          = $customer_id . '-' . $insert_csv['customer_name'];
                        $createby       = $this->session->userdata('user_id');
                        $createdate     = date('Y-m-d H:i:s');
                        $transaction_id = $this->auth->generator(10);
                        $customer_coa   = [
                            'HeadCode'         => $headcode,
                            'HeadName'         => $c_acc,
                            'PHeadName'        => 'Customer Receivable',
                            'HeadLevel'        => '4',
                            'IsActive'         => '1',
                            'IsTransaction'    => '1',
                            'IsGL'             => '0',
                            'HeadType'         => 'A',
                            'IsBudget'         => '0',
                            'IsDepreciation'   => '0',
                            'customer_id'      => $customer_id,
                            'DepreciationRate' => '0',
                            'CreateBy'         => $createby,
                            'CreateDate'       => $createdate,
                        ];
                        $cosdr = array(
                            'VNo'        => $transaction_id,
                            'Vtype'      => 'PR Balance',
                            'VDate'      => date("Y-m-d"),
                            'COAID'      => $headcode,
                            'Narration'  => 'Customer debit For Transaction No' . $transaction_id,
                            'Debit'      => $insert_csv['credit_limit'],
                            'Credit'     => 0,
                            'IsPosted'   => 1,
                            'CreateBy'   => $this->session->userdata('user_id'),
                            'CreateDate' => date('Y-m-d H:i:s'),
                            'IsAppove'   => 1,
                        );
                        $this->db->insert('acc_coa', $customer_coa);
                        if ($insert_csv['credit_limit'] > 0) {
                            $this->db->insert('acc_transaction', $cosdr);
                        }
                    }
                    $count++;
                }
            }
            $this->db->select('*');
            $this->db->from('customer_information');
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $json_customer[] = array('label' => $row->customer_name, 'value' => $row->customer_id);
            }
            $cache_file   = './my-assets/js/admin_js/json/customer.json';
            $customerList = json_encode($json_customer);
            file_put_contents($cache_file, $customerList);
            fclose($fp) or die("can't close file");
            $this->session->set_userdata(array('message' => display('successfully_added')));
            redirect(base_url('Ccustomer/manage_customer'));
        } else {
            $this->session->set_userdata(array('error_message' => 'Please Import Only Csv File'));
            redirect(base_url('Ccustomer/manage_customer'));
        }
    }
    public function customer_update_form() {
        $content = $this->lcustomer->customer_edit_data();
        $this->template->full_admin_html_view($content);
    }
    public function customer_update() {
    $this->form_validation->set_rules('customer_name', 'Customer Name', 'required');
    $this->form_validation->set_rules('city', 'City', 'required');
    $this->form_validation->set_rules('address2', 'Billing Address', 'required');
    $this->form_validation->set_rules('state', 'State', 'required');
    $this->form_validation->set_rules('customer_type', 'Customer Type', 'required');
    $this->form_validation->set_rules('payment', 'Payment Term', 'required');
    $this->form_validation->set_rules('previous_balance', 'Credit Limit', 'required');
    $this->form_validation->set_rules('tax_status', 'Sales Tax', 'required');
    $this->form_validation->set_rules('email', 'Primary Email', 'required|valid_email');
    $this->form_validation->set_rules('phone', 'Business Phone', 'required');
    $this->form_validation->set_rules('contact', 'Contact Person', 'required');
    $this->form_validation->set_rules('country', 'Country', 'required');
    $this->form_validation->set_rules('zip', 'Zip', 'required');
    $this->form_validation->set_message('alpha_space', 'The {field} field should only contain alphabets and spaces.');
     $response = array();
    if ($this->form_validation->run() == FALSE) {
        $response['status'] = 'failure';
        $response['msg'] = validation_errors();
    } else {
        $this->load->model('Customers');
        $customer_id = $this->input->post('customer_id', TRUE);
        $old_headnam = $customer_id . '-' . $this->input->post('oldname', TRUE);
        $c_acc       = $customer_id . '-' . $this->input->post('customer_name', TRUE);
        $data        = array(
            'customer_name'    => $this->input->post('customer_name', TRUE),
            'billing_address' => $this->input->post('address', TRUE),
            'shipping_address'         => $this->input->post('address2', TRUE),
            'customer_mobile'  => $this->input->post('mobile', TRUE),
            'bussiness_phone'            => $this->input->post('phone', TRUE),
            'currency_type'    => $this->input->post('currency1', TRUE),
            'fax'              => $this->input->post('fax', TRUE),
            'contact_person'          => $this->input->post('contact', TRUE),
            'credit_limit'     => $this->input->post('previous_balance', TRUE),
            'tax_status'       => $this->input->post('tax_status', TRUE),
            'city'             => $this->input->post('city', TRUE),
            'state'            => $this->input->post('state', TRUE),
            'zip'              => $this->input->post('zip', TRUE),
            'customer_type'    => $this->input->post('customer_type', TRUE),
            'country'          => $this->input->post('country', TRUE),
            'primary_email'   => $this->input->post('email', TRUE),
            'secondary_email'    => $this->input->post('emailaddress', TRUE),
            'modified_by'      =>decodeBase64UrlParameter($this->input->post('admin_id', TRUE)),
            'modified_date'   => date('Y-m-d H:i:s'),
            'payment_terms'    => $this->input->post('payment', TRUE),
            'sales_tax'        => $this->input->post('tax', TRUE),
            'tax_percent'      => $this->input->post('taxes', TRUE),
            'credit_limit'     => $this->input->post('previous_balance', TRUE),
            'open_balance'     => $this->input->post('open_balance', TRUE),
            'customer_id'      => $this->input->post('customer_id', TRUE),
        );
        $result = $this->Customers->update_customer($data, $customer_id);

       if($result)
            {   $response['admin'] = $this->input->post('admin_id', TRUE);
                $response['status'] = 'success';
                $response['msg']    = 'Customer has been updated successfully';
            }else{
                $response['status'] = 'failure';
                $response['msg']    = 'Failed to update customer. Please try again.';
            }
        }
             echo json_encode($response);
    }




    public function customer_delete() {
        $customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : null;
        $this->load->model('Customers');
        $invoiceinfo = $this->db->select('*')->from('invoice')->where('customer_id', $customer_id)->get()->num_rows();
        if ($invoiceinfo > 0) {
            $this->session->set_userdata(array('error_message' => 'Sorry !! You can not delete this Customer.This Customer already Engaged in calculation system!'));
            redirect(base_url('Ccustomer/manage_customer?id=' . $_GET['id']));
        } else {
            $customerinfo  = $this->db->select('customer_name')->from('customer_information')->where('customer_id', $customer_id)->get()->row();
            $customer_head = $customer_id . '-' . $customerinfo->customer_name;
            $this->Customers->delete_customer($customer_id, decodeBase64UrlParameter($_GET['id']),decodeBase64UrlParameter($_GET['admin']));
            $this->session->set_userdata(array('message' => display('successfully_delete')));
            redirect(base_url('Ccustomer/manage_customer?id=' . $_GET['id']));
        }
    }



    
    public function exportCSV() {
        $this->load->model('Customers');
        $filename = 'customer_' . date('Ymd') . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");
        $usersData = $this->Customers->customer_csv_file();
        $file      = fopen('php://output', 'w');
        $header    = array('CustomerName', 'Email', 'Address', 'Mobile');
        fputcsv($file, $header);
        foreach ($usersData as $line) {
            fputcsv($file, $line);
        }
        fclose($file);
        exit;
    }
}