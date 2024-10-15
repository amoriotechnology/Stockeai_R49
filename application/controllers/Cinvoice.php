<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');
require_once 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class Cinvoice extends CI_Controller {
    private $id;

    function __construct() {
        parent::__construct();
        $this->load->model('Web_settings');
        $this->load->model('Customers');
        $this->load->model('Invoices'); 
        $this->load->model('Settings');
        $this->load->model('Products');
        $this->load->library('linvoice');
        $this->load->library('session');
        $this->load->model('Suppliers');
        $this->load->model('Hrm_model');
        $this->load->model('Products');
        $this->load->model('Categories');
        $this->load->model('Units');
        $this->load->model('Purchases');
        $this->load->library('form_validation');
        $encodedId = $_GET['id'];
        $this->admin_id = decodeBase64UrlParameter($encodedId);
    }
    public function bill_payment(){
        $CI = & get_instance();
        $this->load->model('Invoices');
        $data['company_info']= $this->Invoices->fetchCompanydata();
        $content = $CI->parser->parse('include/bill_history', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function bill_invoice($id = null){
        $CI = & get_instance();
        $this->load->model('Invoices');
        $company_info = $this->Invoices->company_bill_info($id);
        $currency = $this->Invoices->currenyDetails();
        $data = array(
         'company_info' => $company_info,
         'bill_id' => $company_info[0]['id'],
         'currency' => $currency[0]['icon']
        );
        $content = $CI->parser->parse('include/subscription_invoice', $data, true);
        $this->template->full_admin_html_view($content);
    }
    // Payment Edit for Expense - Surya
 public function payment_edit_exp(){
$tableData = $this->input->post('tableData');
  $this->db->where('payment_id',$tableData[0]['payment']);
        $this->db->delete('payment');
       foreach ($tableData as $item) {
 $data=array(
            'payment_id' => $item['payment'],
            'payment_date'  =>$item['date'],
            'reference_no' => $item['referenceNo'],
            'bank_name' => $item['bankName'],
            'total_amt' => $item['gtotal'],
            'amt_received' =>$item['amountPaid'],
            'balance' => $item['balanceamount'],
            'amt_paid' =>$item['amountPaid'],
            'details' => $item['detail'],
            'attachement' => $this->input->post('attachement'),
            'create_by'  => $this->session->userdata('user_id')
           );
           $this->db->insert('payment', $data);
           echo $this->db->last_query();
}
$data1=array(
  'paid_amount'  => $tableData[0]['t_amt_paid'],  
  'balance'  => $tableData[0]['t_bal_amt']   ,
    'payment_id' =>$tableData[0]['payment']   
);
$this->db->where('chalan_no',$tableData[0]['bill_bo']);

 $this->db->update('product_purchase', $data1);
   echo $this->db->last_query();
}
public function payment_edit_serv_pro(){
$tableData = $this->input->post('tableData');
  $this->db->where('payment_id',$tableData[0]['payment']);
        $this->db->delete('payment');
       foreach ($tableData as $item) {
 $data=array(
            'payment_id' => $item['payment'],
            'payment_date'  =>$item['date'],
            'reference_no' => $item['referenceNo'],
            'bank_name' => $item['bankName'],
            'total_amt' => $item['gtotal'],
            'amt_received' =>$item['amountPaid'],
            'balance' => $item['balanceamount'],
            'amt_paid' =>$item['amountPaid'],
            'details' => $item['detail'],
            'attachement' => $this->input->post('attachement'),
            'create_by'  => $this->session->userdata('user_id')
           );
           $this->db->insert('payment', $data);
    
}
$data1=array(
  'amount_paids'  => $tableData[0]['t_amt_paid'],  
  'balances'  => $tableData[0]['t_bal_amt'] ,
  'payment_id' =>$tableData[0]['payment']   
);
$this->db->where('bill_number',$tableData[0]['inv_no']);
 $this->db->update('service', $data1);

}
    #==============sale delete==============#
    public function sale_invoice_delete($invoice_id)
    {
         $payment_id = $this->db->select('payment_id')->from('invoice')->where('invoice_id',$invoice_id)->get()->row()->payment_id;
      $dataw['commercial_invoice_number'] = $this->input->post('commercial_invoice_number',TRUE);
         $result1 = $this->db->delete('payment',array('payment_id' => $payment_id));
         $result2 = $this->db->delete('invoice', array('invoice_id' => $invoice_id)); 
         $result3 = $this->db->delete('invoice_details', array('invoice_id' => $invoice_id)); 
         $result4 = $this->db->delete('product_details_history', array('invoice_id' => $invoice_id)); 
            $this->session->set_flashdata('show', display('successfully_delete'));
      redirect('Cinvoice/manage_invoice');
    }
    public function addBankName(){
        $this->load->model('Invoices');
        $BankNameData = $this->input->post('bank_name');
        $data = array(
         'bank_id'   => $this->auth->generator(10),
         'bank_name' => $BankNameData,
         'created_by' => $this->session->userdata('user_id')
        );
        $this->db->insert('bank_add', $data);
        $bank_data = $this->Invoices->insertBankName();
        echo json_encode($bank_data);
    }
    //For Create Sale - To Get All Supplier Block Number in Dropdown  - Surya
    public function supplier_block_info(){
        $supplier_block_no = $this->input->post('supplier_block_no',TRUE);
        $product_info = $CI->Invoices->get_product_supplier_block($supplier_block_no);
echo json_encode($product_info);
}
    public function insert_taxinfodata(){
        $CI = & get_instance();
        $data = array(
            'tax_id' => $this->auth->generator(10),
            'tax' => $this->input->post('tax'), 
            'description' => $this->input->post('description'),
            'state' => $this->input->post('state'),
            'tax_agency' => $this->input->post('tax_agency'),
            'account' => $this->input->post('account'),
            'show_taxonreturn' => $this->input->post('show_taxonreturn'),
            'status_type' => $this->input->post('status_type'),
            'created_by' => $this->session->userdata('user_id'),
        );
        $this->db->insert('tax_information', $data);
        $result = $this->db->select('*')->from('tax_information')->where('status_type','sales')->get()->result_array();
        echo json_encode($result);
    }
//For Create Sale - To show the Data based on selected Product Name / Block Number /Slab Number - Surya
public function fetch_info_based_on_selection() {
        $requestType = $this->input->post('requestType', TRUE); 
        $search_value = $this->input->post('search_value', TRUE); 
        $data = [];
        switch ($requestType) {
            case 'product_info':
                if (!empty($search_value)) {
                    list($product_name, $product_model) = explode('-', $search_value);
                    $data = $this->Invoices->product_search_item($product_name, $product_model);
                }
                break;
            case 'bundle_info':
                if (!empty($search_value)) {
                    $data = $this->Invoices->product_bundle_datas($search_value);
                }
                break;
            case 'supplier_block_info':
                if (!empty($search_value)) {
                    $data = $this->Invoices->get_product_supplier_block($search_value);
                }
                break;
            default:
                $data = ['error' => 'Invalid request type'];
                break;
        }
        echo json_encode($data);
    }
 //For Create Sale - To Get All Bundle Number in Dropdown  - Surya
public function bundle_info(){
       $bundle_no = $this->input->post('bundle_no',TRUE);
        $product_info = $CI->Invoices->product_bundle_datas($bundle_no);
echo json_encode($product_info);
}
// Update Payment in Edit sale  - Surya
public function payment_edit(){
  $tableData = $this->input->post('tableData');
  $this->db->where('payment_id',$tableData[0]['payment']);
  $this->db->delete('payment');
foreach ($tableData as $item) {
 $data=array(
            'payment_id' => $item['payment'],
            'payment_date'  =>$item['date'],
            'reference_no' => $item['referenceNo'],
            'bank_name' => $item['bankName'],
            'total_amt' => $item['gtotal'],
            'mode'    =>'Stockeai Payment',
            'balance' =>  str_replace('$', '', $item['balanceamount']) ,
            'amt_paid' =>$item['amountPaid'],
            'details' => $item['detail'],
            'attachement' => $this->input->post('attachement'),
            'create_by'  => $this->session->userdata('user_id')
           );
           $this->db->insert('payment', $data);    
}
$lastInsertedRow = $this->db->select('amt_paid, balance')
                                ->from('payment')
                                ->where('payment_id', $tableData[0]['payment'])
                                ->order_by('id', 'DESC')
                                ->limit(1)
                                ->get()
                                ->row();
    $lastAmtPaid = $lastInsertedRow ? $lastInsertedRow->amt_paid : null;
      $lastBalance = $lastInsertedRow ? str_replace('$', '', $lastInsertedRow->balance) : null;
$this->db->where('commercial_invoice_number', $tableData[0]['inv_no']);
$update_invoice = array(
    'paid_amount' => $lastAmtPaid,
    'due_amount'  => $lastBalance,
    'payment_id'  => $item['payment'],
);
$this->db->update('invoice', $update_invoice);
echo $this->db->last_query();
}
public function insert_proformataxinfo()
{
    $this->auth->check_admin_auth();
    $admin_comp_id = decodeBase64UrlParameter($this->input->post('admin_company_id'));
    $this->form_validation->set_rules('tax_percent', 'Tax Percent', 'required');
    $this->form_validation->set_rules('tax_state', 'State', 'required');
    $this->form_validation->set_rules('tax_agency', 'Tax Agency', 'required');
    $this->form_validation->set_rules('tax_account', 'Account', 'required');
    $this->form_validation->set_rules('show_taxonreturn', 'Show Tax On Return Line', 'required');
    $this->form_validation->set_error_delimiters('<br/>', '');
    $response = array();
    if ($this->form_validation->run() == FALSE) {
        $response['status'] = 'failure';
        $response['msg'] = validation_errors();
    } else {
        $taxData = array(
            'tax_id' => $this->auth->generator(10),
            'tax' => $this->input->post('tax_percent'), 
            'description' => $this->input->post('description'),
            'state' => $this->input->post('tax_state'),
            'tax_agency' => $this->input->post('tax_agency'),
            'account' => $this->input->post('tax_account'),
            'show_taxonreturn' => $this->input->post('show_taxonreturn'),
            'status_type' => $this->input->post('status_type'),
            'created_by' => $admin_comp_id,
        );
        $result = $this->Invoices->common_insertdata('tax_information', $taxData);
        $response = array(
            'status' => 'success',
            'msg' => 'Tax has been saved successfully.',
            'taxdata' => $this->Invoices->fetchTaxdata($admin_comp_id)
        );
    }
    echo json_encode($response);
}
// Insert Bank 
public function add_bank()
{
    $this->auth->check_admin_auth();
    $admin_comp_id = decodeBase64UrlParameter($this->input->post('admin_company_id'));
    $this->form_validation->set_rules('bank_name', 'Bank Name', 'required');
    $this->form_validation->set_rules('ac_name', 'Account Name', 'required');
    $this->form_validation->set_rules('ac_no', 'Account Number', 'required');
    $this->form_validation->set_rules('branch', 'Branch', 'required');
    $this->form_validation->set_error_delimiters('<br/>', '');
    $response = array();
    if ($this->form_validation->run() == FALSE) {
        $response['status'] = 'failure';
        $response['msg'] = validation_errors();
    } else {
        $coa = $this->Settings->headcode();
        $headcode = ($coa->HeadCode != NULL) ? $coa->HeadCode + 1 : "102010201";
        $createby = $admin_comp_id;
        $createdate = date('Y-m-d H:i:s');
        $data = array(
            'created_by' => $createby,
            'bank_id'    => $this->auth->generator(10),
            'bank_name'  => $this->input->post('bank_name', TRUE),
            'ac_name'    => $this->input->post('ac_name', TRUE),
            'ac_number'  => $this->input->post('ac_no', TRUE),
            'branch'     => $this->input->post('branch', TRUE),
            'country'    => $this->input->post('country', TRUE),
            'currency'   => $this->input->post('currency1', TRUE),
            'status'     => 1
        );
        $this->Invoices->common_insertdata('bank_add', $data);
        $bank_coa = array(
            'HeadCode'         => $headcode,
            'HeadName'         => $this->input->post('bank_name', TRUE),
            'PHeadName'        => 'Cash At Bank',
            'HeadLevel'        => '4',
            'IsActive'         => '1',
            'IsTransaction'    => '1',
            'IsGL'             => '0',
            'HeadType'         => 'A',
            'IsBudget'         => '0',
            'IsDepreciation'   => '0',
            'DepreciationRate' => '0',
            'CreateBy'         => $createby,
            'CreateDate'       => $createdate,
        );
        $this->Invoices->common_insertdata('acc_coa', $bank_coa);
        $response = array(
            'status'  => 'success',
            'msg'     => 'Bank has been saved successfully.',
            'bankdata' => $this->Settings->bank_entry($admin_comp_id)
        );
    }
    echo json_encode($response);
}
// Insert Payment
public function insertPayment()
{
    $this->auth->check_admin_auth();
    $admin_comp_id = decodeBase64UrlParameter($this->input->post('admin_company_id'));
    $response = array();
    $data = array(
        'payment_id'    => $this->input->post('payment_id',TRUE),
        'payment_date'  => $this->input->post('payment_date', TRUE),
        'reference_no'  => $this->input->post('ref_no', TRUE),
        'bank_name'     => $this->input->post('bank', TRUE),
        'total_amt'     => $this->input->post('amount_to_pay', TRUE),
        'amt_paid'      => $this->input->post('paid_amount', TRUE),
        'balance'       => $this->input->post('balance_modal', TRUE),
        'mode'          => 'Stockeai Payment',
        'status'        => 'Paid',
        'create_by'     => $admin_comp_id,
    );
   
        $upload_success = true;
        $paymentid      = '';
        if (!empty($_FILES['payment_attachement']['name'])) {
            $upload_data = file_upload('payment_attachement', 'payment', PAYMENT_IMG_PATH);
            if (isset($upload_data['upload_data']['file_name'])) {
                //$update_data = array('attachement' => $upload_data['upload_data']['file_name']);
                $data['attachement'] = $upload_data['upload_data']['file_name'];
                //$this->Customers->update_payments($update_data, $paymentid);
                
            } else {
                $upload_success = false;
                $upload_error = $upload_data['error'];
            }
        }
        if($upload_success ==true){
            $paymentid = $this->Customers->payments_entry($data);
        }
        if ($paymentid!="") {
            $paymentData = $this->Customers->fetchpaymentdata($paymentid, $admin_comp_id);
            if ($upload_success) {
                $response = array(
                    'status' => 'success',
                    'msg' => 'Payment has been added successfully.',
                    'paymentData' => $paymentData
                );
            } else {
                $response = array(
                    'status' => 'partial_success',
                    'msg' => 'File upload failed: ' . $upload_error,
                    'paymentData' => $paymentData
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'msg' => 'Failed to add payment. Please try again.'
            );
        }
    echo json_encode($response);
}
    
public function update_payment_data() {
  $editedData = $this->input->post();
$payment_date  = $this->input->post('payment_date',TRUE);
        $ref =$this->input->post('ref',TRUE);
  $b_name =$this->input->post('b_name',TRUE);
  $amt_paid=$this->input->post('amt_paid',TRUE);
    $bal=$this->input->post('bal',TRUE);
      $detail=$this->input->post('detail',TRUE);
        $payment_id=$this->input->post('payment_id',TRUE);
$data2 = array(
                'payment_date'        =>$payment_date,
               'details'  =>$detail,
                 'amt_received'             => $amt_paid,
                  'amt_paid'             => $amt_paid,
                 'balance'     =>$bal,
                 'bank_name'  => $b_name
                 );
                   $this->db->where('reference_no', $ref);
                     $this->db->where('payment_id', $payment_id);
                       $this->db->where('create_by', $this->session->userdata('user_id'));
                 $this->db->update('payment', $data2);
                echo $this->db->last_query();
  $response = array('success' => true); 
  header('Content-Type: application/json');
  echo json_encode($response);
}
// Edit Sale  - Bulk Payment Update - Surya
    public function bulk_payment(){
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $payment_id=$this->input->post('payment_id');
     
       $payment_unique=$this->input->post('payment_id_this_invoice');
 
        $payment_bulk = $CI->Invoices->bulk_payment();
       $payment_single = $CI->Invoices->bulk_payment_unique($payment_unique);
       echo  "success";
  }
    public function insert_truckinginfodata(){
        $CI = & get_instance();
        $data = array(
            'tax_id' => $this->auth->generator(10),
            'tax' => $this->input->post('tax'), 
            'description' => $this->input->post('description'),
            'state' => $this->input->post('state'),
            'tax_agency' => $this->input->post('tax_agency'),
            'account' => $this->input->post('account'),
            'show_taxonreturn' => $this->input->post('show_taxonreturn'),
            'status_type' => $this->input->post('status_type'),
            'created_by' => $this->session->userdata('user_id'),
        );
        $this->db->insert('tax_information', $data);
        $result = $this->db->select('*')->from('tax_information')->where('status_type','sales')->get()->result_array();
        echo json_encode($result);
    }
    #==============profarma delete - Madhu==============#
    public function profarmaDeleteInvoice()
    {
        $purchase_id = $this->input->post('id');
        $payment_id = $this->db->select('payment_id')->from('profarma_invoice')->where('purchase_id',$purchase_id)->get()->row()->payment_id;
        $data['purchase_id'] = $this->input->post('purchase_id',TRUE);
        $updateproforamadata = array('is_deleted' => 1);
        $result1 = $this->db->delete('payment', array('payment_id' => $payment_id)); 
        $result2 = $this->Invoices->update_proformaData($purchase_id, $updateproforamadata, 'profarma_invoice');
        $result3 = $this->Invoices->update_proformaData($purchase_id, $updateproforamadata, 'profarma_invoice_details');
        if ($result1 && $result2 && $result3) {
            $response = array(
                'status' => 'success',
                'msg'    => 'Proforma invoice has been deleted successfully!'
            );
        } else {
            $response = array(
                'status' => 'failure',
                'msg'    => 'Sorry !! Unable to delete the proforma invoice. Please try again!'
            );
        }
        echo json_encode($response);
    }
    #==============ocean_export delete==============#
       public function get_product_info(){
        $CI = & get_instance();
        $output = new stdClass;
        $output->csrfName = $this->security->get_csrf_token_name();
        $output->csrfHash = $this->security->get_csrf_hash();
        $output->pdt=$this->input->post('pdt');
        $output->data = "add";
        $product_nam=$this->input->post('product_nam');
        $product_model=$this->input->post('product_model');
        $CI->load->model('Invoices');
      $data=  $CI->Invoices->get_product_info($product_nam,$product_model);
        echo json_encode($data);
     }
    public function ocean_export_tracking_delete_form($ocean_export_tracking_id)
    {
        $data['ocean_export_tracking_id'] = $this->input->post('ocean_export_tracking_id',TRUE);
        $result = $this->db->delete('ocean_export_tracking', array('ocean_export_tracking_id' => $ocean_export_tracking_id)); 
        $this->session->set_flashdata('show', display('successfully_delete'));
        redirect('Cinvoice/manage_ocean_export_tracking');
    }
    #==============trucking_delete==============#
    public function trucking_delete_form($trucking_id)
    {
        $data['trucking_id'] = $this->input->post('trucking_id',TRUE);
        $result1 = $this->db->delete('sale_trucking', array('trucking_id' => $trucking_id)); 
        $result2 = $this->db->delete('sale_trucking_details', array('trucking_id' => $trucking_id)); 
        $this->session->set_flashdata('show', display('successfully_delete'));
        redirect('Cinvoice/manage_trucking');
    }
//For Create Sale - To insert Landing Cost  - Surya
public function service_invoice_details(){
$this->form_validation->set_rules('sp_qty[]', 'Quantity', 'required');
        $this->form_validation->set_rules('sp_rate[]', 'Rate', 'required');
$this->form_validation->set_message('required', 'The {field} field is required.');
   $response = array();
    if ($this->form_validation->run() == FALSE) {
         $response['status'] = 'failure';
        $response['msg'] = validation_errors();
    } else {
     $content = $this->Invoices->service_invoice_details($this->input->post('service_invoice',TRUE),decodeBase64UrlParameter($this->input->post('admin_company_id',TRUE)));
     $response['status'] = 'success';
       $response['msg']    = 'Landing Cost has been added successfully';
    }
        echo json_encode($response);
}
 public function best_sales_products() {
    $firststart= date('Y-m-d', strtotime('first day of january this year'));
$yearEnd = date('Y-m-d', strtotime('last day of december this year'));
          $this->db->select('a.create_by,b.date,a.product_name, count(*) as quantity');
         $this->db->from('invoice_details a');
         $this->db->join('invoice b', 'b.invoice_id = a.invoice_id');
         $this->db->where('a.create_by',$this->session->userdata('user_id'));
      $this->db->where('b.date >=', $firststart);
        $this->db->where('b.date <=', $yearEnd);
         $this->db->group_by('a.product_name', 'desc');
        $this->db->order_by('count(*)', 'desc');
         $this->db->limit(10);
     $query = $this->db->get();
       $rows = array();
  $result =  $query->result(); 
 foreach($result as $r) { 
     $rows['name'][]=$r->product_name;
         $rows['data'][] = $r->quantity;
}
$result = array();
array_push($result,$rows);
echo json_encode($result, JSON_NUMERIC_CHECK);
    }
    public function updateinvoicedesign($id,$uid)
    {
     $query='update invoice_design set template='.$id.' where uid='.$uid;
    $this->db->query($query);
    redirect($_SERVER['HTTP_REFERER']);
        redirect('cinvoice/updateinvoicedesign', 'refresh');
    }
    public function index() {
        $customer_details = $this->Invoices->pos_customer_setup(decodeBase64UrlParameter($_GET['id']));
        $payment_type= $this->Invoices->payment_type();
        $tax_data = $this->Invoices->get_taxDatadetails($_GET['id']);
        $currency_details = $this->Web_settings->retrieve_setting_editdata();
        $product_bundle = $this->Invoices->get_product_bundle();
        $supplier_block_no = $this->Invoices->get_product_supplier_block();
        $update_invoice_set = $this->Web_settings->update_invoice();
        $curn_info_default = $this->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
      $get_agent_data = $this->Invoices->get_agent_data();
        $bank_list          = $this->Web_settings->bank_list();
        $prodt = $this->Products->get_all_products($_GET['id']);
        $payment_terms_dropdown = $this->Suppliers->payment_terms_dropdown();
        $paytype=$this->Invoices->payment_type();
        $voucher_no = $this->Invoices->commercial_inv_number();
        $servic_provider = $this->Invoices->servic_provider_list();
        $setting_detail = $this->Web_settings->retrieve_setting_editdata();
        $designation = $this->Hrm_model->designation_dropdown(decodeBase64UrlParameter($_GET['id']));
        $PayType = $this->Hrm_model->paytype_dropdown(decodeBase64UrlParameter($_GET['id']));
        $bankData = $this->Hrm_model->bankdataDetails();
        $state_tx = $this->Hrm_model->state_tax(decodeBase64UrlParameter($_GET['id']));
        $get_info_city_tax = $this->Hrm_model->get_info_city_tax(decodeBase64UrlParameter($_GET['id']));
        $get_info_county_tax = $this->Hrm_model->get_info_county_tax(decodeBase64UrlParameter($_GET['id']));
        $getEmployeeData = $this->Hrm_model->employee_list($_GET['id']);
     
        $data = array(
            'supplier_block_no'=>$supplier_block_no,
            'curn_info_default' =>$curn_info_default[0]['currency_name'],
            'bundle' => $product_bundle,
            'currency'  =>$currency_details[0]['currency'],
            'title'         => display('add_new_invoice'),
           'servic_provider'=>$servic_provider,
            'tax'           => $taxfield1,
            'get_agent_data' =>  $get_agent_data,
            'payment_terms' => $payment_terms_dropdown,
            'product'       =>$prodt,
            'tax_data' => $tax_data,
            'customer_details'   => $customer_details,
            'bank_list'     => $bank_list,
            'voucher_no' => $voucher_no,
            'payment_typ'  =>$paytype,
            'update_invoice_set' =>$update_invoice_set,
            'setting_detail' => $setting_detail,
            'account' =>$update_invoice_set[0]->account,
            'remarks' =>  $update_invoice_set[0]->remarks,
            'desig' => $designation,
            'paytype' => $PayType,   
            'bank_data' => $bankData,
            'state_tx' => $state_tx,
            'get_info_city_tax' => $get_info_city_tax,
            'get_info_county_tax' => $get_info_county_tax,
            'emp_data' => $getEmployeeData
        );
        $invoiceForm = $this->parser->parse('invoice/add_invoice_form', $data, true);
        $this->template->full_admin_html_view($invoiceForm);
    }
    public function add_profarma_product_csv() {
        $CI = & get_instance();
        $data = array(
            'title' => display('add_product_csv')
        );
        $content = $CI->parser->parse('invoice/add_profarma_product_csv', $data, true);
        $this->template->full_admin_html_view($content);
    }
   public function uploadProformacsv()
    {
        $CI = & get_instance();
        $this->load->model('Products');
        $data['productdetails'] = $this->Products->get_profarma_product();
         $this->load->library('upload');
        $this->load->library('Csvimport');
        if (($_FILES['upload_csv_file']['name'])){
            $files = $_FILES;
            $config = array();
            $config['upload_path'] = './uploads';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = '1000';
            $this->upload->initialize($config);
              if (!$this->upload->do_upload('upload_csv_file')) {
                $data['error_message'] = $this->upload->display_errors();
                $this->session->set_userdata($data);
            } else {
                $file_data = $this->upload->data();
                $file_path =  './uploads/'.$file_data['file_name'];
            if ($this->csvimport->get_array($file_path)) {
                $csv_array = $this->csvimport->get_array($file_path);
                $this->session->set_userdata('file_path',  $csv_array);
                foreach ($csv_array as $row) {
                    $purchase_id = date('YmdHis');
                    $proforma_data = array(
                        'sales_by'     =>  $this->session->userdata('user_id'),
                        'purchase_id'=>$purchase_id,
                        'purchase_date'=>$row['Purchase Date'],
                        'chalan_no'=>$row['Invoice Number'],
                        'customer_id'=>$row['Customer Id'],
                        'pre_carriage'=>$row['Pre Carriage'],
                        'country_goods' => $row['Country of origin of goods'],
                        'country_destination' => $row['Country of final destination'],
                        'loading' => $row['Port of loading'],
                        'discharge' => $row['Port Of Discharge'],
                        'terms_payment' => $row['Terms of payment and delivery'],
                        'description_goods' => $row['Description goods'],
                        'gtotal' => $row['Grand Total'],
                        'amt_paid' => $row['Amount Paid'],
                        'bal_amt' => $row['Balance Amount'],
                        'ac_details' => $row['Account Details/Additional Information']
                    );
                     $this->db->insert('profarma_invoice', $proforma_data);
                    $product_id = $this->generator(10);
                    $data_invoice = array(
                        'product_id' => empty($product_id) ? $row['Product Id'] : $product_id,
                        'create_by'  =>  $this->session->userdata('user_id'),
                        'purchase_id'=>$purchase_id,
                        'quantity' => $row['Quantity'],
                        'rate' => $row['Rate'],
                        'total_amount' => $row['Total Amount'],
                        'thickness' => $row['Thickness'],
                        'description' => $row['Description'],
                        'supplier_block_no' => $row['Supplier Block No'],
                        'supplier_slab_no' => $row['Supplier Slab No'],
                        'gross_width' => $row['Gross Width'],
                        'gross_height' => $row['Gross Height'],
                        'gross_sq_ft' => $row['Gross Sq.Ft'],
                        'bundle_no' => $row['Bundle No'],
                        'net_width' => $row['Net Width'],
                        'net_height' => $row['Net Height'],
                        'net_sq_ft' => $row['Net Sq. Ft'],
                        'sales_amt_sq_ft' => $row['Sales Price per Sq.Ft'],
                        'sales_slab_amt' => $row['Sales Slab Price'],
                        'weight' => $row['Weight']
                    );
                     $this->db->insert('profarma_invoice_details', $data_invoice);
                }
                $data=array();
                $data=array(
                    'proforma_data' =>$proforma_data
                );
                $content = $this->load->view('invoice/add_profarma_product_csv', $data, true);
                $this->template->full_admin_html_view($content);
                $this->session->set_userdata(array('message'=>display('successfully_added')));
               redirect(base_url('Cinvoice/manage_profarma_invoice'));
             
            }else {
                $this->session->set_userdata(array('error_message'=>'Please Import Only Csv File'));
                redirect(base_url('Cinvoice/add_profarma_product_csv'));
            }
            $this->session->unset_userdata('file_path');
            unlink($file_path);
            }
        }
    }
    public function add_product_csv() {
        $CI = & get_instance();
        $this->load->model('Products');
        $data['productdetails'] = $this->Products->get_product();
        $content = $CI->parser->parse('invoice/add_product_csv', $data, true);
        $this->template->full_admin_html_view($content);
    }
   public function uploadCsv()
    {
        $CI = & get_instance();
        $this->load->model('Products');
        $data['productdetails'] = $this->Products->get_product();
        $this->load->library('upload');
        $this->load->library('Csvimport');
        if (($_FILES['upload_csv_file']['name'])){
            $files = $_FILES;
            $config = array();
            $config['upload_path'] = './uploads';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = '1000';
            $this->upload->initialize($config);
              if (!$this->upload->do_upload('upload_csv_file')) {
                $data['error_message'] = $this->upload->display_errors();
                $this->session->set_userdata($data);
            } else {
                $file_data = $this->upload->data();
                $file_path =  './uploads/'.$file_data['file_name'];
            if ($this->csvimport->get_array($file_path)) {
                $csv_array = $this->csvimport->get_array($file_path);
               
                $this->session->set_userdata('file_path',  $csv_array);
             
                foreach ($csv_array as $row) {
                    $insert_data = array(
                        'sales_by'     =>  $this->session->userdata('user_id'),
                        'invoice_id'=>$this->generator(10),
                        'date'=>$row['Sales Invoice date'],
                        'customer_id'=>$row['Customer Id'],
                        'commercial_invoice_number'=>$row['Invoice No'],
                        'container_no'=>$row['Container Number'],
                        'bl_no'=>$row['B/L No'],
                        'billing_address' => $row['Billing Address'],
                        'payment_terms' => $row['Payment Terms'],
                        'payment_due_date' => $row['Payment Due date'],
                        'etd' => $row['Estimated Time of Departure'],
                        'eta' => $row['Estimated Time of Arrival'],
                        'ac_details' => $row['Account Details/Additional Information'],
                        'remark' => $row['Remarks/Conditions'],
                        'shipping_address' => $row['Shipping Address'],
                        'payment_type' => $row['Payment Type'],
                    );
                    $this->db->insert('invoice', $insert_data);
                }
                $data=array();
                $data=array(
                    'insert_data' =>$insert_data
                );
                $content = $this->load->view('invoice/add_product_csv', $data, true);
                $this->template->full_admin_html_view($content);
                $this->session->set_userdata(array('message'=>display('successfully_added')));
                redirect(base_url('Cinvoice/manage_invoice'));
            }else {
                $this->session->set_userdata(array('error_message'=>'Please Import Only Csv File'));
                redirect(base_url('Cinvoice/add_product_csv'));
            }
            $this->session->unset_userdata('file_path');
            unlink($file_path);
            }
        }
}
public function uploadTablesalescsv()
    {
        $CI = & get_instance();
        $this->load->model('Products');
        $data['productdetails'] = $this->Products->get_product();
        $this->load->model('Purchases');
        $this->load->library('upload');
        $this->load->library('Csvimport');
        if (($_FILES['uploadproduct_csv_file']['name'])){
            $files = $_FILES;
            $config = array();
            $config['upload_path'] = './uploads';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = '1000';
            $this->upload->initialize($config);
              if (!$this->upload->do_upload('uploadproduct_csv_file')) {
                $data['error_message'] = $this->upload->display_errors();
                $this->session->set_userdata($data);
            } else {
                $file_data = $this->upload->data();
                $file_path =  './uploads/'.$file_data['file_name'];
            if ($this->csvimport->get_array($file_path)) {
                $csv_array = $this->csvimport->get_array($file_path);
             
                $this->session->set_userdata('file_path',  $csv_array);
                $i=0;
                foreach ($csv_array as $row) {
                $data_invoicecsv = array(
                    'create_by'     =>  $this->session->userdata('user_id'),
                    'tableid'=>$row['Table Id'],
                    'invoice_id'=>$row['Invoice Id'],
                    'product_id' =>$row['Product Id'],
                    'product_name' => $row['Product Name'],
                    'quantity' => $row['Quantity'],
                    'rate' => $row['Rate'],
                    'description' => $row['Description'],
                    'thickness' => $row['Thickness'],
                    'total_price' => $row['Total Price'],
                    'supplier_block_no' => $row['Supplier Block No'],
                    'supplier_slab_no' => $row['Supplier Slab No'],
                    'g_width' => $row['Gross Width'],
                    'g_height' => $row['Gross Height'],
                    'gross_sqft' => $row['Gross Sq.Ft'],
                    'bundle_no' => $row['Slab No'],
                    'n_width' => $row['Net Width'],
                    'n_height' => $row['Net Height'],
                    'net_sqft' => $row['Net Sq.Ft'],
                    'sales_price_sqft' => $row['SalesPrice per Sq.Ft'],
                    'sales_slab_price' => $row['Sales Slab Price'],
                    'weight' => $row['Weight'],
                    'status'  => 1,
                  
                );
             
                $this->db->insert('invoice_details', $data_invoicecsv);
            
                $i++;
                }           
                $content = $this->load->view('invoice/add_product_csv', $data_invoicecsv, true);
                $this->template->full_admin_html_view($content);
                $this->session->set_userdata(array('message'=>display('successfully_added')));
           
             }else {
                $this->session->set_userdata(array('error_message'=>'Please Import Only Csv File'));
              
            }
            $this->session->unset_userdata('file_path');
            unlink($file_path);
        }
    }
}

// Performa Payment History - Madhu
public function performapayment_history()
{
    $this->auth->check_admin_auth();
    $payment_id=$this->input->post('paymentIds');
    $customer_id=$this->input->post('customer_id');
    $current_in_id=$this->input->post('current_in_id');
    $overall_payment = $this->Invoices->get_cust_payment_overall_info($customer_id);
    $get_cust_payment = $this->Invoices->get_cust_payment_info($customer_id,$current_in_id);
    $payment_get = $this->Invoices->get_payment_info($payment_id);
    $amt_paid = $this->db->select('sum(amt_paid) as amt_paid')->from('payment')->where('payment_id',$payment_id)->get()->row()->amt_paid;
    $data=array(
        'overall'  => $overall_payment,
        'based_on_customer' => $get_cust_payment,
        'payment_get'  =>$payment_get,
        'amt_paid' =>  $amt_paid
    );
 
    echo json_encode($data);  
}

// Payment History - Madhu
public function payment_history()
{
    $this->auth->check_admin_auth();
    $payment_id=$this->input->post('makepaymentId');
    $customer_id=$this->input->post('customer_id');
    $current_in_id=$this->input->post('current_in_id');
    $overall_payment = $this->Invoices->get_cust_payment_overall_info($customer_id);
    $get_cust_payment = $this->Invoices->get_cust_payment_info($customer_id,$current_in_id);
    $payment_get = $this->Invoices->get_payment_info($payment_id);
    $amt_paid = $this->db->select('sum(amt_paid) as amt_paid')->from('payment')->where('payment_id',$payment_id)->get()->row()->amt_paid;
    $data=array(
        'overall'  => $overall_payment,
        'based_on_customer' => $get_cust_payment,
        'payment_get'  =>$payment_get,
        'amt_paid' =>  $amt_paid
    );
 
    echo json_encode($data);  
}
public function payment_history_trucking()
{
    $this->auth->check_admin_auth();
    $payment_id=$this->input->post('makepaymentId');
    $customer_id=$this->input->post('customer_id');
    $current_in_id=$this->input->post('current_in_id');
    $trucking_id=$this->input->post('trucking_id');
    $encodedId          = $this->input->post('admin_id');
    $admin_id           = decodeBase64UrlParameter($encodedId);
    $overall_payment = $this->Invoices->get_cust_payment_overall_info_trucking('',$admin_id,$trucking_id);
   // echo $this->db->last_query();
    $get_cust_payment = $this->Invoices->get_cust_payment_info($customer_id,$current_in_id);
   // echo $this->db->last_query();
    $payment_get = $this->Invoices->get_payment_info($payment_id);
   // echo $this->db->last_query();
    $amt_paid = $this->db->select('sum(amt_paid) as amt_paid')->from('payment')->where('payment_id',$payment_id)->get()->row()->amt_paid;
//echo $this->db->last_query();
    $data=array(
        'overall'  => $overall_payment,
        'based_on_customer' => $get_cust_payment,
        'payment_get'  =>$payment_get,
        'amt_paid' =>  $amt_paid
    );
 
    echo json_encode($data);  
}
public function makepay() 
{
    $this->auth->check_admin_auth();
    $bank_name = $CI->db->select('bank_name')->from('bank_add')->get()->result_array();
    $data = array(
       'bank_name' =>$bank_name
    );
    $content = $this->load->view('invoice/add_bank', $data, true);
    $this->template->full_admin_html_view($content);
}
 public function profarma_invoice() {

    $this->auth->check_admin_auth();

    $adminId = $this->input->get('id');
    $admin_comp_id = decodeBase64UrlParameter($adminId);

    $currency_details = $this->Web_settings->retrieve_setting_editdata();

    $update_invoice_set = $this->Web_settings->update_invoice();
    $setting_detail = $this->Web_settings->retrieve_setting_editdata();

    $curn_info_default = $this->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
    $category_list1= $this->Categories->category_list_product($adminId);
    $unit_list1     = $this->Units->unit_list();
    $all_supplier1 = $this->Purchases->select_all_supplier();
    $profarma_data = $this->Invoices->getAllProfarmadata();
    $country_code = $this->db->select('*')->from('country')->get()->result_array();
    $prodt = $this->Products->get_all_products($_GET['id']);
    $cutomerData = $this->Invoices->pos_customer_setup($admin_comp_id);
    $data=array(
        'curn_info_default' =>$curn_info_default[0]['currency_name'],
        'currency'  =>$currency_details[0]['currency'],
        'all_supplier'  => $all_supplier1,
        'category_list'=> $category_list1,
        'unit_list'    => $unit_list1,
        'customer' => $cutomerData,
        'product'       =>$prodt,
        'voucher_no' => $this->Invoices->profarma_voucher_no(),
        'update_invoice_set' =>$update_invoice_set,   
        'account' =>$update_invoice_set[0]->account,
        'remarks' =>  $update_invoice_set[0]->remarks,
        'country_code' => $country_code,
        'profarma_data' => $profarma_data,
        'setting_detail' => $setting_detail
   );

    $content = $this->load->view('invoice/profarma_invoice', $data, true);
    $this->template->full_admin_html_view($content);
}
    // Get Customer on email
    public function email($customer_id){
        $CI = & get_instance();
        $this->load->model('Invoices');
        $postData = $this->input->post();
        $data = $this->Invoices->get_customer_data($customer_id);
        $email_info = $CI->Invoices->get_email_data();
    $data1 = array(
    'customer_name'    => $data[0]['customer_name'],
    'customer_email'   => $data[0]['customer_email'],
    'email_subject'    => $email_info[0]['subject'],
    'email_greeting'   => $email_info[0]['greeting'],
    'email_message'    => $email_info[0]['message']
    );
    $invoiceList = $CI->parser->parse('invoice/invoice_email_html', $data1, true);
    $this->template->full_admin_html_view($invoiceList);
    }
    // Get Customer on email - Madhu
    public function get_customer()
    {
        $proformaId = $this->input->post('id'); 
        $singleProformadata = $this->Invoices->fetchSingleproformadata($proformaId);
        if ($singleProformadata) {
            echo json_encode([
                'status' => 'success',
                'data' => $singleProformadata
            ]);
        } else {
            echo json_encode([
                'status' => 'failure',
                'msg' => 'No data found for the provided Proforma ID'
            ]);
        }
    }
    // Send Email Function - Madhu
    public function sendemailProforma()
    {
        $tomail = $this->input->post('to_email');
        $r_tomail = explode(';', $tomail);
        $emailtoArray = array_map('trim', $r_tomail);
        $cc_email = $this->input->post('cc_email');
        $r_ccmail = explode(';', $cc_email);
        $emailccArray = array_map('trim', $r_ccmail);
        $subject = $this->input->post('subject');
        $message = $this->input->post('message');
        $data = array(
            'to' => $emailtoArray,
            'cc' => $emailccArray,
            'subject' => $subject,
            'message' => $message
        );
        if ($this->sendEmail($data)) {
            $response['status'] = 'success';
            $response['msg'] = 'Proforma invoice sent successfully';
        } else {
            $response['status'] = 'error';
            $response['msg'] = 'Failed to send proforma invoice';
        }
        echo json_encode($response);
    }
    public function Get_attachments(){
    $CI = & get_instance();
    $this->auth->check_admin_auth();
    $CI->load->model('Invoices');
        $inv_id = $this->input->post('rowinvoiceId');
        $getAttachmentData =  $CI->Invoices->retrieve_attachmentdata($inv_id);
        echo json_encode($getAttachmentData);
   }
    public function Get_oceanattachments(){
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $ocean_id = $this->input->post('rowoceanId');
        $getOceanAttachmentData = $CI->Invoices->retrieve_oceanattachmentdata($ocean_id);
        echo json_encode($getOceanAttachmentData); 
    }
    public function Get_oceanattachments_view(){
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $ocean_id = $this->input->post('ocean_id');
        $getOceanAttachmentDataView = $CI->Invoices->retrieve_oceanattachmentdata_view($ocean_id);
        echo json_encode($getOceanAttachmentDataView); 
    }
    public function Get_truckingattachments(){
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $truck_id = $this->input->post('rowTruckId');
        $getTruckingAttachmentData = $CI->Invoices->retrieve_truckingattachmentdata($truck_id);
        echo json_encode($getTruckingAttachmentData); 
    }
    public function Get_truckingattachments_view(){
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $truck_id = $this->input->post('trucking_id');
        $getOceanAttachmentDataView = $CI->Invoices->retrieve_truckingattachmentdata_view($truck_id);
        echo json_encode($getOceanAttachmentDataView); 
    }
    public function sendmail_with_attachments($invoice_id)
    {
      $CA = & get_instance();
      $CI = & get_instance();
      $CA->load->model('invoice_design');
      $CA->load->model('Web_settings');
      $CA->load->model('Invoices');
      $CI->load->model('invoice_content');
      $w = & get_instance();
        $w->load->model('Ppurchases');
      $sql='select * from invoice_content ';
      $query=$this->db->query($sql);
      $company_content= $CI->invoice_content->retrieve_info_data();
      $getAttach =  $CA->Invoices->retrieve_attach($invoice_id);
      $currency_details = $CI->Web_settings->retrieve_setting_editdata();
      $setting=  $CI->Web_settings->retrieve_setting_editdata();
      $company_info = $w->Ppurchases->retrieve_company();
      $this->session->set_userdata('image_email', base_url().(!empty($setting[0]['invoice_logo'])?$setting[0]['invoice_logo']:$company_info[0]['logo']));
      $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
    $uid=$_SESSION['user_id'];
    $sql='select c.* from company_information c join user_login as u on u.cid=c.company_id where u.user_id='.$uid;
    $query=$this->db->query($sql);
    $product_sql='select c.* from invoice i join customer_information c on c.customer_id=i.customer_id where i.invoice_id='.$invoice_id;
    $query=$this->db->query($product_sql);
    $customer_info=$query->result_array();
    $sql='select p.*, i.* from `invoice_details` i join invoice p on p.invoice_id=i.invoice_id where i.invoice_id="'.$invoice_id.'";';
    $query=$this->db->query($sql);
    $product_info=$query->result_array();
    $invoice_sql='select * from `invoice` i join invoice_details p on p.invoice_id=i.invoice_id';
    $query=$this->db->query($invoice_sql);
    $invoice_info=$query->result_array();
    $email_sql = 'SELECT * FROM `email_config`';
    $query = $this->db->query($email_sql);
    $email_info = $query->result_array();
    $sql='select * from invoice where invoice_id='.$invoice_id;
    $query=$this->db->query($sql);
    $invoice=$query->result_array();
    $dataw = $CA->invoice_design->retrieve_data();
    $data['curn_info_default'] = $curn_info_default[0]['currency_name'];
    $data['currency'] = $currency_details;
    $data['company_info']=(!empty($company_content)?$company_content:$company_info);
      $data['company_content']=(!empty($company_content)?$company_content:$company_info);
    $data['customer_info']=$customer_info;
    $data['product_info']=$product_info;
    $data['invoiceid']=$invoice_id;
    $data['invoice_info']=$invoice_info;
    $data['invoice'] = $invoice;
    $data['logo'] = $setting;
$data['attach'] = $getAttach;
    $data['head']=$dataw;
    $data['template'] = $dataw[0]['template'];
    $content = $this->load->view('pdf_attach_mail/new_sale', $data, true);
}
 public function getvendor_products() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $value = $this->input->post('value',TRUE);
        $content = $CI->Invoices->getvendor_products($value);
      echo json_encode($content);
    }
    public function performa_pdf($purchase_id) {
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $purchase_detail = $CI->Invoices->retrieve_profarma_invoice_editdata($purchase_id);
        // print_r($purchase_detail); die();
        $all_profarma = $CI->Invoices->all_profarma($purchase_id);
        $product_name = $this->db->select('*')->from('product_information')->where("product_id",$all_profarma[0]['product_id'])->get()->result_array();
      // print_r($product_name);die();
      $setting=  $CI->Web_settings->retrieve_setting_editdata();
        $profarma_details = $this->db->select('*')->from('profarma_invoice_details')->where("purchase_id",$purchase_detail[0]['purchase_id'])->get()->result_array();
        if (!empty($purchase_detail)) {
            $i = 0;
            foreach ($purchase_detail as $k => $v) {
                $i++;
                $purchase_detail[$k]['sl'] = $i;         
        }
    }
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $CII = & get_instance();
        $CC = & get_instance();
        $w = & get_instance();
        $w->load->model('Ppurchases');
        $company_info = $w->Ppurchases->retrieve_company();
         // print_r($company_info); exit();
        $CII->load->model('invoice_design');
        $CC->load->model('invoice_content');
        $CI1 = & get_instance();
        $CI1->load->model('Purchases');
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
        $all_supplier = $CI1->Purchases->select_all_supplier();
        $dataw = $CII->invoice_design->retrieve_data($this->session->userdata('user_id'));
       $datacontent = $CI->invoice_content->retrieve_data();
//  print_r($company_info);
//        print_r($datacontent); exit();
       $customer = $this->db->select('*')->from('customer_information')->where("customer_id",$purchase_detail[0]['customer_id'])->get()->result_array();
       // print_r($customer); die();
  //$prinfo = $this->db->select('*')->from('product_information')->where('product_id',$product_id)->get()->result_array();
        $data = array(
            'curn_info_default' =>$curn_info_default[0]['currency_name'],
            'currency'  =>$currency_details[0]['currency'],
            'header'=> $dataw[0]['header'],
            'logo'=>(!empty($setting[0]['invoice_logo'])?$setting[0]['invoice_logo']:base_url().$company_info[0]['logo']),  
            'color'=> $dataw[0]['color'],
            'template'=> $dataw[0]['template'],
            'all_supplier' => $all_supplier,
           // 'address'=>$datacontent[0]['address'],
            'cname'=>(!empty($datacontent[0]['company_name'])?$datacontent[0]['company_name']:$company_info[0]['company_name']),   
            'phone'=>(!empty($datacontent[0]['mobile'])?$datacontent[0]['mobile']:$company_info[0]['mobile']),   
            'email'=>(!empty($datacontent[0]['email'])?$datacontent[0]['email']:$company_info[0]['email']),   
            'reg_number'=>(!empty($datacontent[0]['reg_number'])?$datacontent[0]['reg_number']:$company_info[0]['reg_number']),  
            'website'=>(!empty($datacontent[0]['website'])?$datacontent[0]['website']:$company_info[0]['website']),   
            'address'=>(!empty($datacontent[0]['address'])?$datacontent[0]['address']:$company_info[0]['address']),   
            'customer_currency' => $customer[0]['currency_type'],
            'customer'      => $customer[0]['customer_name'],
            'tax' => $purchase_detail[0]['tax_details'],
            'company_info'=> (!empty($datacontent)?$datacontent:$company_info),
          //  'company_info'     => $datacontent,
                 'purchase_id'   => $purchase_detail[0]['purchase_id'],
            'chalan_no'     => $purchase_detail[0]['chalan_no'],
            'purchase_date'  => $purchase_detail[0]['purchase_date'],
            'billing_address'  => $purchase_detail[0]['billing_address'],
            'pre_carriage' => $purchase_detail[0]['pre_carriage'],
            'receipt'    =>  $purchase_detail[0]['receipt'],
            'country_goods'    =>  $purchase_detail[0]['country_goods'],
            'country_destination' =>  $purchase_detail[0]['country_destination'],
            'purchase_info' => $purchase_detail,
            'loading' =>  $purchase_detail[0]['loading'],
            'discharge'=>  $purchase_detail[0]['discharge'],
            'terms_payment'=>  $purchase_detail[0]['terms_payment'],
            'description_goods'=>  $purchase_detail[0]['description_goods'],
            'ac_details' =>  $purchase_detail[0]['ac_details'],
             'remarks' =>  $purchase_detail[0]['remarks'],
            'customer_name' => $purchase_detail[0]['customer_name'],
            'customer_id'   => $purchase_detail[0]['customer_id'],
         'purchase_info'   =>$purchase_detail,
                                                'tax_id'   => $purchase_detail[0]['tax_id']
        );
        $chapterList = $CI->parser->parse('invoice/profarma_invoice_html', $data, true);
        $this->template->full_admin_html_view( $chapterList);
        return $chapterList;
    }
   public function performa_print($purchase_id) {
           $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $purchase_detail = $CI->Invoices->retrieve_profarma_invoice_editdata($purchase_id);
        // print_r($purchase_detail); die();
        $all_profarma = $CI->Invoices->all_profarma($purchase_id);
     $product_name = $this->db->select('*')->from('product_information')->where("product_id",$all_profarma[0]['product_id'])->get()->result_array();
      // print_r($product_name);die();
        $profarma_details = $this->db->select('*')->from('profarma_invoice_details')->where("purchase_id",$purchase_detail[0]['purchase_id'])->get()->result_array();
        if (!empty($purchase_detail)) {
            $i = 0;
            foreach ($purchase_detail as $k => $v) {
                $i++;
                $purchase_detail[$k]['sl'] = $i;         
        }
    }
       $setting=  $CI->Web_settings->retrieve_setting_editdata();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $CII = & get_instance();
        $CC = & get_instance();
        $w = & get_instance();
        $w->load->model('Ppurchases');
        $company_info = $w->Ppurchases->retrieve_company();
         // print_r($company_info); exit();
        $CII->load->model('invoice_design');
        $CC->load->model('invoice_content');
        $CI1 = & get_instance();
        $CI1->load->model('Purchases');
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
        $all_supplier = $CI1->Purchases->select_all_supplier();
        $dataw = $CII->invoice_design->retrieve_data($this->session->userdata('user_id'));
       $datacontent = $CI->invoice_content->retrieve_data();
       //print_r($datacontent); exit();
       $customer = $this->db->select('*')->from('customer_information')->where("customer_id",$purchase_detail[0]['customer_id'])->get()->result_array();
       // print_r($customer); die();
  //$prinfo = $this->db->select('*')->from('product_information')->where('product_id',$product_id)->get()->result_array();
        $data = array(
            'curn_info_default' =>$curn_info_default[0]['currency_name'],
            'currency'  =>$currency_details[0]['currency'],
            'header'=> $dataw[0]['header'],
            'logo'=>(!empty($setting[0]['invoice_logo'])?$setting[0]['invoice_logo']:base_url().$company_info[0]['logo']),  
            'color'=> $dataw[0]['color'],
            'template'=> $dataw[0]['template'],
            'all_supplier' => $all_supplier,
            'address'=>$datacontent[0]['address'],
             'company_info'=> (!empty($datacontent)?$datacontent:$company_info),
           'cname'=>(!empty($datacontent[0]['company_name'])?$datacontent[0]['company_name']:$company_info[0]['company_name']),   
            'phone'=>(!empty($datacontent[0]['mobile'])?$datacontent[0]['mobile']:$company_info[0]['mobile']),   
            'email'=>(!empty($datacontent[0]['email'])?$datacontent[0]['email']:$company_info[0]['email']),   
            'reg_number'=>(!empty($datacontent[0]['reg_number'])?$datacontent[0]['reg_number']:$company_info[0]['reg_number']),  
            'website'=>(!empty($datacontent[0]['website'])?$datacontent[0]['website']:$company_info[0]['website']),   
            'address'=>(!empty($datacontent[0]['address'])?$datacontent[0]['address']:$company_info[0]['address']), 
            'customer_currency' => $customer[0]['currency_type'],
            'customer'      => $customer[0]['customer_name'],
            'tax' => $purchase_detail[0]['tax_details'],
                 'purchase_id'   => $purchase_detail[0]['purchase_id'],
            'chalan_no'     => $purchase_detail[0]['chalan_no'],
            'purchase_date'  => $purchase_detail[0]['purchase_date'],
            'billing_address'  => $purchase_detail[0]['billing_address'],
            'pre_carriage' => $purchase_detail[0]['pre_carriage'],
            'receipt'    =>  $purchase_detail[0]['receipt'],
            'country_goods'    =>  $purchase_detail[0]['country_goods'],
            'country_destination' =>  $purchase_detail[0]['country_destination'],
            'purchase_info' => $purchase_detail,
            'loading' =>  $purchase_detail[0]['loading'],
            'discharge'=>  $purchase_detail[0]['discharge'],
            'terms_payment'=>  $purchase_detail[0]['terms_payment'],
            'description_goods'=>  $purchase_detail[0]['description_goods'],
            'ac_details' =>  $purchase_detail[0]['ac_details'],
             'remarks' =>  $purchase_detail[0]['remarks'],
            'customer_name' => $purchase_detail[0]['customer_name'],
            'customer_id'   => $purchase_detail[0]['customer_id'],
         'purchase_info'   =>$purchase_detail,
         'tax_id'   => $purchase_detail[0]['tax_id']
        );
        $chapterList = $CI->parser->parse('invoice/profarma_invoice_print', $data, true);
        $this->template->full_admin_html_view( $chapterList);
        return $chapterList;
    }
    public function get_email_data(){
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
       // $value = $this->input->post('customer_name',TRUE);
        $email_info = $CI->Invoices->get_email_data();
        echo json_encode($email_info);
    }
    function pdf()
    {
        $this->load->library('pdf');
        $html = $this->load->view('purchase/trucking_invoice_html', [], true);
        $this->pdf->createPDF($html, 'mypdf', false);
    }
    public function sendmail()
    {
    //Load email library
$this->load->library('email');
$receiver_mail = $this->input->post('email_info',TRUE);
$name_email = $this->input->post('name_email',TRUE);
$subject_email = $this->input->post('subject_email',TRUE);
$message_email = $this->input->post('message_email',TRUE);
//SMTP & mail configuration
$config = array(
    'protocol'  => 'smtp',
    'smtp_host' => 'ssl://smtp.googlemail.com',
    'smtp_port' => 465,
    'smtp_user' => 'suryavenkatesh3093@gmail.com',
    'smtp_pass' => 'hdafyzlzbjqppnlq',
    'mailtype'  => 'text',
    'charset'   => 'utf-8'
);
$this->email->initialize($config);
$this->email->set_mailtype("html");
$this->email->set_newline("\r\n");
//Email content
$htmlContent = '<h1>Greeting from AmorioTech</h1>';
$htmlContent .= $name_email;
$htmlContent .= $message_email;
$this->email->to($receiver_mail);
$this->email->from('suryavenkatesh3093@gmail.com','AmorioTech');
$this->email->subject($subject_email);
$this->email->message($htmlContent);
//Send email
$this->email->send();
$data = "Message Sent Successfully";
echo json_encode($data);
    }
    public function getvendor(){
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $value = $this->input->post('value',TRUE);
        $vendor_info = $CI->Purchases->select_supplier($value);
        echo json_encode($vendor_info);
    }
    public function getvendorbyname(){
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $value = $this->input->post('value',TRUE);
        $vendor_info = $CI->Purchases->select_supplierbyname($value);
        echo json_encode($vendor_info);
    }
    //For sales - Get customer Information  - Surya
   public function getcustomer_data(){
      $value = $this->input->post('value',TRUE);
        $customer_info =$this->Invoices->getcustomer_data($value);
      echo json_encode($customer_info);
    }
    public function delete_trucking() {
        $this->db->where('trucking_id', $_GET['val']);
        $this->db->delete('sale_trucking');
        $this->db->where('sale_trucking_id', $_GET['val']);
        $this->db->delete('sale_trucking_id');
           $this->db->where('payment_id', $_GET['payment_id']);
    $this->db->delete('payment');
   }
   public function delete_ocean_export(){
    $this->db->where('booking_no', $_GET['val']);
    $this->db->delete('ocean_export_tracking');
}
public function delete_packing() {
    $this->db->where('expense_packing_id', $_GET['val']);
    $this->db->delete('expense_packing_list');
    $this->db->where('expense_packing_id', $_GET['val']);
    $this->db->delete('expense_packing_list_detail');
}
public function deleteprofarma(){
    $this->db->where('purchase_id', $_GET['val']);
    $this->db->delete('profarma_invoice');
    $this->db->where('purchase_id', $_GET['val']);
    $this->db->delete('profarma_invoice_details');
       $this->db->where('payment_id', $_GET['payment_id']);
    $this->db->delete('payment');
}
public function deletesale(){
    $this->db->where('invoice_id', $_GET['val']);
    $this->db->delete('invoice');
    $this->db->where('invoice_id', $_GET['val']);
    $this->db->delete('invoice_details');
    $this->db->where('payment_id', $_GET['payment_id']);
    $this->db->delete('payment');
}
    public function getcustomer_byID(){
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $value = $this->input->post('value',TRUE);
        $customer_info = $CI->Invoices->customerinfo_rpt($value);
        echo json_encode($customer_info);
    }
    //For Sale - To show the Payment Due Date based on selected Payment Term - Surya
    public function getdate(){
        $sales_invoice_date = $this->input->post('sales_invoice_date',TRUE);
        $days = $this->input->post('days',TRUE);
  if($days == "NaN"){
         echo date('Y-m-d');
       }else{
       $date= date('Y-m-d', strtotime($sales_invoice_date. ' +'.$days.' day'));
        echo json_encode($date);
       }
    }
    // Edit Quotation - Madhu
    public function profarma_invoice_update_form()
    {  
        $admin_id = decodeBase64UrlParameter($_GET['id']);
        $this->auth->check_admin_auth();
        $invoice_id = $this->input->get('quotation_id');
        $adminId = $this->input->get('id');
        $admin_comp_id = decodeBase64UrlParameter($adminId);
        $purchase_detail = $this->Invoices->retrieve_profarma_invoice_editdata($invoice_id, $admin_comp_id);
        //print_r($purchase_detail); exit;
        $edit_profarmadata = $this->Invoices->editAlldataprofarma();
        $customer_id = $purchase_detail[0]['customer_id'];
        if (!empty($purchase_detail)) {
            $i = 0;
            foreach ($purchase_detail as $k => $v) {
                $i++;
                $purchase_detail[$k]['sl'] = $i;
            }
        }
        $setting_detail = $this->Web_settings->retrieve_setting_editdata();

        $attachmentData = $this->Invoices->editAttachment($invoice_id, $admin_comp_id);
        
        $currency_details = $this->Web_settings->retrieve_setting_editdata();
        $curn_info_default = $this->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
        $customer = $this->Invoices->pos_customer_setup($admin_comp_id);
        $taxfield1 = $this->db->select('tax_id,tax')->from('tax_information')->get()->result_array();
        $prodt = $this->Products->get_all_products($_GET['id']);
        $bank_name = $this->db->select('bank_name')->from('bank_add')->get()->result_array();
        $data = array(
            'customer'  => $customer,
            'curn_info_default' =>$curn_info_default[0]['currency_name'],
            'currency'  =>$currency_details[0]['currency'],
            'title'         => 'Edit Profarma Invoice',
            'product'       =>$prodt,
            'all_tax' =>$taxfield1,
            'purchase_id'   => $purchase_detail[0]['purchase_id'],
            'chalan_no'     => $purchase_detail[0]['chalan_no'],
            'purchase_date'  => $purchase_detail[0]['purchase_date'],
            'billing_address'  => $purchase_detail[0]['billing_address'],
            'pre_carriage' => $purchase_detail[0]['pre_carriage'],
            'receipt'    =>  $purchase_detail[0]['receipt'],
            'country_goods'    =>  $purchase_detail[0]['country_goods'],
            'country_destination' =>  $purchase_detail[0]['country_destination'],
            'purchase_info' => $purchase_detail,
            'loading' =>  $purchase_detail[0]['loading'],
            'discharge'=>  $purchase_detail[0]['discharge'],
            'terms_payment'=>  $purchase_detail[0]['terms_payment'],
            'description_goods'=>  $purchase_detail[0]['description_goods'],
            'ac_details' =>  $purchase_detail[0]['ac_details'],
            'remarks' =>  $purchase_detail[0]['remarks'],
            'customer_name' => $purchase_detail[0]['customer_name'],
            'customer_id'   => $purchase_detail[0]['customer_id'],
            'total'         => $purchase_detail[0]['total_amount'],
            'thickness'   => $purchase_detail[0]['thickness'],
            'supplier_block_no'   => $purchase_detail[0]['supplier_block_no'],
            'supplier_slab_no'   => $purchase_detail[0]['supplier_slab_no'],
            'gross_width'   => $purchase_detail[0]['gross_width'],
            'gross_height'   => $purchase_detail[0]['gross_height'],
            'customer_gtotal' =>$purchase_detail[0]['customer_gtotal'],
            'bal_amt' =>$purchase_detail[0]['bal_amt'],
            'amt_paid' =>$purchase_detail[0]['amt_paid'],
            'tax_details' =>$purchase_detail[0]['tax_details'],
            'overall_total' =>$purchase_detail[0]['total'],
            'overall_gross' =>$purchase_detail[0]['overall_gross'],
            'overall_net' =>$purchase_detail[0]['overall_net'],
            'overall_total' =>$purchase_detail[0]['total'],
            'gtotal' =>$purchase_detail[0]['gtotal'],
            'gross_sq_ft'   => $purchase_detail[0]['gross_sq_ft'],
            'bundle_no'   => $purchase_detail[0]['bundle_no'],
            'slab_no'   => $purchase_detail[0]['slab_no'],
            'net_width'   => $purchase_detail[0]['net_width'],
            'net_height'   => $purchase_detail[0]['net_height'],
            'tax_id'   => $purchase_detail[0]['tax_id'],
            'paymentid'  =>$purchase_detail[0]['payment_id'],
            'purchase_info'   =>$purchase_detail,
            'description_goods'   => $purchase_detail[0]['description_goods'],
            'sales_amt_sq_ft'   => $purchase_detail[0]['sales_amt_sq_ft'],
            'sales_slab_amt'   => $purchase_detail[0]['sales_slab_amt'],
            'weight'   => $purchase_detail[0]['weight'],
            'origin'   => $purchase_detail[0]['origin'],
            'product_name'   => $purchase_detail[0]['product_name'],
            'edit_profarmadata' => $edit_profarmadata,
            'bank_name'  =>$bank_name,
            'tax_view' => $edit_profarmadata[0]['tax_id'],
            'taxView' => $edit_profarmadata[0]['tax'],
            'setting_detail' => $setting_detail,
            'viewattachments' => $attachmentData
        );
        $chapterList = $this->load->view('invoice/profarma_invoice_update', $data, true);
        $this->template->full_admin_html_view($chapterList);
    }    
    public function packing_list()
    {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $data=array();
        $content = $this->load->view('invoice/packing_list', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function availability()
    {
        $CI = & get_instance();
        $output = new stdClass;
        $output->csrfName = $this->security->get_csrf_token_name();
        $output->csrfHash = $this->security->get_csrf_hash();
        $output->pdt=$this->input->post('pdt');
        $output->data = "add";
        $product_nam=$this->input->post('product_nam');
        $product_model=$this->input->post('product_model');
        $CI->load->model('Invoices');
        $data=  $CI->Invoices->availability($product_nam,$product_model);
        echo json_encode($data);

     }
     public function product_id(){
        $CI = & get_instance();
        $output = new stdClass;
        $output->csrfName = $this->security->get_csrf_token_name();
        $output->csrfHash = $this->security->get_csrf_hash();
        $output->pdt=$this->input->post('pdt');
        $output->data = "add";
        $product_nam=$this->input->post('product_nam');
        $product_model=$this->input->post('product_model');
        $CI->load->model('Invoices');
      $data=  $CI->Invoices->product_id($product_nam,$product_model);
        echo json_encode($data);
       // die();
   // echo $pdt;
    //   print_r($json);
     }
        public function add_packing_list(){
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Products');
        $CI->load->model('Invoices');
        $CI->load->library('linvoice');
        $products=$CI->Products->get_all_products();
        $data=array();
        $CI->load->model('Units');
        $voucher_no = $CI->Invoices->packing_list_no();
        $unit_list     = $CI->Units->unit_list();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data=array(
          //  'curn_info_default' =>$curn_info_default[0]['currency_name'],
            'currency' => $currency_details[0]['currency'],
            'voucher_no' => $voucher_no,
            'products'=> $products,
            'unit_list'    => $unit_list,
            );
       // echo $content = $CI->linvoice->invoice_add_form();
        $content = $this->load->view('invoice/add_packing_list', $data, true);
        //$content='';
        $this->template->full_admin_html_view($content);
    }
    public function ocean_export_tracking(){
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
         $content = $CI->linvoice->ocean_export_tracking_add_form();
        $this->template->full_admin_html_view($content);
    }
          //Ocean Import Tracking Update Form
    public function ocean_export_tracking_update_form($purchase_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $content = $CI->linvoice->ocean_export_tracking_edit_data($purchase_id);
        $this->template->full_admin_html_view($content);
    }
      public function trucking(){
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
       // $data=array();
        $content = $CI->linvoice->trucking_add_form();
      //  $content = $this->load->view('invoice/trucking', $data, true);
        //$content='';
        $this->template->full_admin_html_view($content);
    }
    public function trucking1(){
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $data=array();
        $content = $CI->linvoice->trucking_add_form1();
       // $content = $this->load->view('purchase/trucking', $data, true);
        //$content='';
        $this->template->full_admin_html_view($content);
    }
      public function insert_trucking() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
         $CI->load->model('Invoices');
        $invoiceid=$CI->Invoices->trucking_entry();
        echo json_encode($invoiceid);
    }
     public function oceanimport() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $data=array();
       // echo $content = $CI->linvoice->invoice_add_form();
        $content = $this->load->view('invoice/oceanimport', $data, true);
        //$content='';
        $this->template->full_admin_html_view($content);
    }
    public function oceanexport() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $data=array();
       // echo $content = $CI->linvoice->invoice_add_form();
        $content = $this->load->view('invoice/oceanexport', $data, true);
        //$content='';
        $this->template->full_admin_html_view($content);
    }
 public function add_profarma_invoice()
 {
       $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
      //  $data=array();
        $CI->load->model('Invoices');
   $c=   $this->Invoices->add_profarma_invoice();
   //  print_r($c);
      $this->session->set_userdata(array('message' => display('successfully_added')));
      if (isset($_POST['add-purchase'])) {
        //  print_r($_POST['add-trucking']);
          redirect(base_url('Cinvoice/manage_profarma_invoice'));
          exit;
      } elseif (isset($_POST['add-trucking-another'])) {
         // print_r($_POST['add-trucking-another']);
          redirect(base_url('Cinvoice/trucking'));
          exit;
      }
 }   
    //Insert invoice
    public function insert_invoice() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $invoice_id = $CI->Invoices->invoice_entry();
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect(base_url('Cinvoice/invoice_inserted_data/'.$invoice_id));
    }
    // ================= manual sale insert ============================
    // ================= manual sale insert ============================
        public function insert_ocean_export() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $invoice_id=$CI->Invoices->ocean_export_entry();
         echo json_encode($invoice_id);
    }




    public function file_upload(){
        // $purchase_id = date('YmdHis');
        $booking_no = $this->input->post('booking_no',TRUE);
        // print_r($_FILES); die();
    if (isset($_FILES['files']) && !empty($_FILES['files'])) {
        $no_files = count($_FILES["files"]['name']);
        for ($i = 0; $i < $no_files; $i++) {
            if ($_FILES["files"]["error"][$i] > 0) {
                echo "Error: " . $_FILES["files"]["error"][$i] . "<br>";
            } else {
                if (file_exists('uploads/' . $_FILES["files"]["name"][$i])) {
                    echo 'File already exists : uploads/' . $_FILES["files"]["name"][$i];
                    return false;
                } else {
                    move_uploaded_file($_FILES["files"]["tmp_name"][$i], 'uploads/' . $_FILES["files"]["name"][$i]);
                    echo 'File successfully uploaded : uploads/' . $_FILES['files']['name'][$i] . ' ';
                   $data = array(
                        'attachment_id' => $booking_no,
                        'files' => $_FILES['files']['name'][$i],
                        'image_dir' => 'uploads/' . $_FILES['files']['name'][$i],
                        'created_by'=> $this->session->userdata('user_id'),
                        'sub_menu' => 'ocean_export_tracking',
                    );
                    $this->db->insert('attachments', $data);
                    // echo $this->db->last_query();
                }
            }
        }
    } else {
        echo 'Please choose at least one file';
    }
}
public function invoice_file_upload(){
    $invoice_id = $this->input->post('attachment_id',TRUE);
    // echo $invoice_id;
    echo $invoice_id; 
    if (isset($_FILES['files']) && !empty($_FILES['files'])) {
        $no_files = count($_FILES["files"]['name']);
        for ($i = 0; $i < $no_files; $i++) {
            if ($_FILES["files"]["error"][$i] > 0) {
                echo "Error: " . $_FILES["files"]["error"][$i] . "<br>";
            } else {
                if (file_exists('uploads/' . $_FILES["files"]["name"][$i])) {
                    echo 'File already exists : uploads/' . $_FILES["files"]["name"][$i];
                    return false;
                } else {
                    move_uploaded_file($_FILES["files"]["tmp_name"][$i], 'uploads/' . $_FILES["files"]["name"][$i]);
                    echo 'File successfully uploaded : uploads/' . $_FILES['files']['name'][$i] . ' ';
                    $data = array(
                        'attachment_id' => $invoice_id,
                        'files' => $_FILES['files']['name'][$i],
                        'image_dir' => 'uploads/' . $_FILES['files']['name'][$i],
                        'created_by'=> $this->session->userdata('user_id'),
                        'sub_menu' => 'invoice',
                    );
                    $this->db->insert('attachments', $data);
                    // echo $this->db->last_query();
                }
            }
        }
    } else {
        echo 'Please choose at least one file';
    }
}
public function trucking_file_upload(){
        // $purchase_id = date('YmdHis');
        $trucking_id = $this->input->post('attachment_id',TRUE);
        // print_r($_FILES); die();
    if (isset($_FILES['files']) && !empty($_FILES['files'])) {
        $no_files = count($_FILES["files"]['name']);
        for ($i = 0; $i < $no_files; $i++) {
            if ($_FILES["files"]["error"][$i] > 0) {
                echo "Error: " . $_FILES["files"]["error"][$i] . "<br>";
            } else {
                if (file_exists('uploads/' . $_FILES["files"]["name"][$i])) {
                    echo 'File already exists : uploads/' . $_FILES["files"]["name"][$i];
                    return false;
                } else {
                    move_uploaded_file($_FILES["files"]["tmp_name"][$i], 'uploads/' . $_FILES["files"]["name"][$i]);
                    echo 'File successfully uploaded : uploads/' . $_FILES['files']['name'][$i] . ' ';
                    $data = array(
                        'attachment_id' => $trucking_id,
                        'files' => $_FILES['files']['name'][$i],
                        'image_dir' => 'uploads/' . $_FILES['files']['name'][$i],
                        'created_by'=> $this->session->userdata('user_id'),
                        'sub_menu' => 'Sales Trucking',
                    );
                    $this->db->insert('attachments', $data);
                    // echo $this->db->last_query();
                }
            }
        }
    } else {
        echo 'Please choose at least one file';
    }
}
public function get_expense_datas(){
 $CI = & get_instance();
    $CI->auth->check_admin_auth();
       $product_nam=$this->input->post('product_nam');
        $product_model=$this->input->post('product_model');
          $bun_num=$this->input->post('bun_num');
        $CI->load->model('Invoices');
      $data=  $CI->Invoices->get_expense_datas($product_nam,$product_model,$bun_num);
        echo json_encode($data);
}
// Create / Edit Insert Function - Surya
public function manual_sales_insert() {
 
    $this->form_validation->set_rules('customer_name', 'Customer Name', 'required');
    $this->form_validation->set_rules('commercial_invoice_number', 'Invoice Number', 'required');
    $this->form_validation->set_rules('billing_address', 'Billing Address', 'required');
    $this->form_validation->set_rules('terms', 'Payment Terms', 'required');
    $this->form_validation->set_rules('payment_due_date', 'Payment Due Date', 'required');
    $this->form_validation->set_rules("thickness[]", "Thickness", "required|regex_match[/^\s*\d+(\.\d+)?\s*$/]");
    $this->form_validation->set_rules("supplier_block_no[]", "Supplier Block Number",  "required|regex_match[/^\s*\d+(\.\d+)?\s*$/]");
    $this->form_validation->set_rules("supplier_slab_no[]", "Supplier Slab No", "required|regex_match[/^\s*\d+(\.\d+)?\s*$/]");
    $this->form_validation->set_rules("gross_width[]", "Gross Width", "required|regex_match[/^\s*\d+(\.\d+)?\s*$/]");
    $this->form_validation->set_rules("gross_height[]", "Gross Height", "required|regex_match[/^\s*\d+(\.\d+)?\s*$/]");
    $this->form_validation->set_rules("bundle_no[]", "Bundle Number",  "required|regex_match[/^\s*\d+(\.\d+)?\s*$/]");
    $this->form_validation->set_rules("net_width[]", "Net Width",  "required|regex_match[/^\s*\d+(\.\d+)?\s*$/]");
    $this->form_validation->set_rules("net_height[]", "Net Height",  "required|regex_match[/^\s*\d+(\.\d+)?\s*$/]");
    if ($this->form_validation->run() == FALSE) {
        $response = [
            'status' => 'failure',
            'msg' => validation_errors()
        ];
        echo json_encode($response);
        return;
    }
    $invoice_id = $this->generator(10);
    $createdby = decodeBase64UrlParameter($this->input->post('admin_company_id'));
    $invoice_data = [
        'sales_by' => $createdby,
        'status' => 1,
        'customer_id' => $this->input->post('customer_name', TRUE),
        'date' => $this->input->post('invoice_date', TRUE),
        'commercial_invoice_number' => $this->input->post('commercial_invoice_number', TRUE),
        'billing_address' => $this->input->post('billing_address', TRUE),
        'container_no' => $this->input->post('container_no', TRUE),
        'bl_no' => $this->input->post('bl_no', TRUE),
        'gtotal' => $this->input->post('gtotal', TRUE),
        'gtotal_preferred_currency' => $this->input->post('customer_gtotal', TRUE),
        'total_amount' => $this->input->post('Over_all_Total', TRUE),
        'total_tax' => $this->input->post('tax_details', TRUE),
        'etd' => $this->input->post('etd', TRUE),
        'Port_of_discharge' => $this->input->post('Port_of_discharge', TRUE),
        'sc_emp_name' => $this->input->post('selected_text', TRUE),
        'user_emp_id' => $this->input->post('emp_id', TRUE),
        'eta' => $this->input->post('eta', TRUE),
        'payment_terms' => $this->input->post('terms', TRUE),
        'remark' => $this->input->post('remark', TRUE),
        'ac_details' => $this->input->post('ac_details', TRUE),
        'due_amount' => $this->input->post('balance', TRUE),
        'total_gross' => $this->input->post('total_gross', TRUE),
        'lc_cost_total' => $this->input->post('additional_cost', TRUE),
        'amount_pay_usd' => $this->input->post('paid_convert', TRUE),
        'due_amount_usd' => $this->input->post('bal_convert', TRUE),
        'total_net' => $this->input->post('total_net', TRUE),
        'paid_amount' => $this->input->post('amount_paid', TRUE),
        'payment_id' => $this->input->post('makepaymentId', TRUE),
        'total_weight' => $this->input->post('total_weight', TRUE),
        'payment_due_date' => $this->input->post('payment_due_date', TRUE),
        'shipping_address' => $this->input->post('shipping_address', TRUE),
        'payment_type' => $this->input->post('paytype', TRUE),
        'bank_id' => $this->input->post('bank', TRUE),
        'account_category' => $this->input->post('account_category', TRUE),
        'sub_category' => $this->input->post('sub_category', TRUE),
        'account_subcat' => $this->input->post('account_subcat', TRUE),
        'sales_admin'  =>$this->session->userdata('unique_id')
  ];
    $existing_invoice = $this->db->where('commercial_invoice_number', $this->input->post('commercial_invoice_number', TRUE))
    ->get('invoice')->row_array();
    if (!empty($existing_invoice)) {
       $this->db->where('commercial_invoice_number', $this->input->post('commercial_invoice_number', TRUE));
       $invoice_data['modified_admin']=$this->session->userdata('unique_id');
       $invoice_data['modified_by']=$createdby;
       $invoice_data['modified_date']=date('Y-m-d H:i:s');
       $this->db->update('invoice', $invoice_data);
   
       $invoice_id = $existing_invoice['invoice_id'];
    } else {
        $invoice_data['invoice_id']=$invoice_id;
        $this->db->insert('invoice', $invoice_data);
        
     
    }

    $this->db->where('invoice_id', $invoice_id);
    $this->db->delete('invoice_details');
    $product_id = $this->input->post('product_id', TRUE);
    $prodt = $this->input->post('prodt', TRUE);
    $desc = $this->input->post('description', TRUE);
    $thickness = $this->input->post('thickness', TRUE);
    $supplier_b_no = $this->input->post('supplier_block_no', TRUE);
    $supplier_slab_no = $this->input->post('supplier_slab_no', TRUE);
    $gross_width = $this->input->post('gross_width', TRUE);
    $gross_height = $this->input->post('gross_height', TRUE);
    $gross_sq_ft = $this->input->post('gross_sq_ft', TRUE);
    $bundle_no = $this->input->post('bundle_no', TRUE);
    $net_width = $this->input->post('net_width', TRUE);
    $net_height = $this->input->post('net_height', TRUE);
    $net_sq_ft = $this->input->post('net_sq_ft', TRUE);
    $cost_sq_ft = $this->input->post('cost_sq_ft', TRUE);
    $cost_sq_slab = $this->input->post('cost_sq_slab', TRUE);
    $sales_amt_sq_ft = $this->input->post('sales_amt_sq_ft', TRUE);
    $sales_slab_amt = $this->input->post('sales_slab_amt', TRUE);
    $slab_no = $this->input->post('slab_no', TRUE);
    $weight = $this->input->post('weight', TRUE);
    $origin = $this->input->post('origin', TRUE);
    $tableid = $this->input->post('tableid', TRUE);
    $total_amt = $this->input->post('total_amt', TRUE);
     $landing_cost = $this->input->post('l_cost', TRUE);
    $landing_cost_slab = $this->input->post('l_cost_slab', TRUE);
   $totalgross = $this->input->post('overall_gross', TRUE);
     $totalnet = $this->input->post('overall_net', TRUE);
    $total = $this->input->post('total', TRUE);
    for ($i = 0, $n = count($product_id); $i < $n; $i++) {
        $invoice_details_data = [
            'invoice_id' => $invoice_id,
            'product_id' => $product_id[$i],
             'description' => $desc[$i],
            'thickness' => $thickness[$i],
            'supplier_block_no' => $supplier_b_no[$i],
            'supplier_slab_no' => $supplier_slab_no[$i],
            'g_width' => $gross_width[$i],
            'g_height' => $gross_height[$i],
            'gross_sqft' => $gross_sq_ft[$i],
            'bundle_no' => $bundle_no[$i],
            'n_width' => $net_width[$i],
            'n_height' => $net_height[$i],
            'net_sqft' => $net_sq_ft[$i],
            'cost_sqft' => $cost_sq_ft[$i],
            'cost_slab' => $cost_sq_slab[$i],
            'sales_price_sqft' => $sales_amt_sq_ft[$i],
            'sales_slab_price' => $sales_slab_amt[$i],
            'slab_no' => $slab_no[$i],
            'weight' => $weight[$i],
            'origin' => $origin[$i],
            'tableid' => $tableid[$i],
            'total_price' => $total_amt[$i],
            'overall_total' => $total[$i],
            'overall_gross' => $totalgross[$i],
            'overall_net' => $totalnet[$i],
            'landing_cost' => $landing_cost[$i],
            'landing_cost_slab' =>$landing_cost_slab[$i],
            'created_by' => $createdby
        ];
        $this->db->insert('invoice_details', $invoice_details_data);
    
    }
  
   $eta =  date('Y-m-d', strtotime($this->input->post('eta', TRUE))); 
  $etd = date('Y-m-d', strtotime($this->input->post('etd', TRUE))); 
   $payment_due_date = date('Y-m-d', strtotime($this->input->post('payment_due_date', TRUE))); 
 // Code For Notification - Setting
   $adjusted_date = $this->Invoices->adjustDatesBasedOnNotifications($eta, $etd, $payment_due_date, $unique_id);
 if($adjusted_date['adjusted_eta'] && $adjusted_date['adjusted_eta_notification_source']){
        $data_eta=array(
             'unique_id'  =>$this->session->userdata('unique_id'),
             'invoice_no'       =>$this->input->post('commercial_invoice_number',TRUE),
             'title'     => 'SALE - NEW SALE - ETA',
             'description'   => 'Scheduled ETA for Invoice ' .$this->input->post('commercial_invoice_number',TRUE).' SALE',
             'created_by' => $this->session->userdata('user_id'),
             'start'    =>$adjusted_date['adjusted_eta'],
             'invoice_id' => $this->session->userdata('sale_2'),
             'bell_notification' => ($adjusted_date['adjusted_eta_notification_source'] === 'STOCKEAI') ? 1 : '',
             'source'  => $adjusted_date['adjusted_eta_notification_source'],
              'email_id'  => ($adjusted_date['adjusted_eta_notification_source'] === 'EMAIL') ? $company_email_id : '',
             'schedule_status' =>1,
             'create_date'   => date("Y-m-d")
        );
    }
        if($adjusted_date['adjusted_etd'] && $adjusted_date['adjusted_etd_notification_source']){
        $data_etd=array(
             'unique_id'  =>$this->session->userdata('unique_id'),
             'invoice_no'       =>$this->input->post('commercial_invoice_number',TRUE),
             'title'     => 'SALE - NEW SALE - ETD',
               'invoice_id' => $this->session->userdata('sale_2'),
              'description'   => 'Scheduled ETD for Invoice ' .$this->input->post('commercial_invoice_number',TRUE).' SALE',
              'created_by' => $this->session->userdata('user_id'),
               'bell_notification' => ($adjusted_date['adjusted_etd_notification_source'] === 'STOCKEAI') ? 1 : '',
              'source'  => $adjusted_date['adjusted_etd_notification_source'],
             'start'    =>$adjusted_date['adjusted_etd'],
              'email_id'  => ($adjusted_date['adjusted_eta_notification_source'] === 'EMAIL') ? $company_email_id : '',
             'schedule_status' =>1,
             'create_date'   => date("Y-m-d")
        );
    }
       if($adjusted_date['adjusted_payment_due_date'] && $adjusted_date['adjusted_payment_due_date_notification_source']){
        $data_adjusted_payment_due_date=array(
             'unique_id'  =>$this->session->userdata('unique_id'),
             'invoice_no'       =>$this->input->post('commercial_invoice_number',TRUE),
             'title'     => 'SALE - NEW SALE - PAYMENT DUE DATE',
              'invoice_id' => $this->session->userdata('sale_2'),
             'description'   => 'Scheduled Payment Due date for Invoice ' .$this->input->post('commercial_invoice_number',TRUE).' SALE',
              'created_by' => $this->session->userdata('user_id'),
              'source'  => $adjusted_date['adjusted_payment_due_date_notification_source'],
               'email_id'  => ($adjusted_date['adjusted_eta_notification_source'] === 'EMAIL') ? $company_email_id : '',
              'bell_notification' => ($adjusted_date['adjusted_payment_due_date_notification_source'] === 'STOCKEAI') ? 1 : '',
             'start'    =>$adjusted_date['adjusted_payment_due_date'],
             'schedule_status' =>1,
             'create_date'   => date("Y-m-d")
        );
    }
     if($adjusted_date['adjusted_eta']){
         $this->db->where('invoice_no',$this->input->post('commercial_invoice_number',TRUE));
         $this->db->where('title','SALE - NEW SALE - ETA');$this->db->delete('schedule_list');
         $this->db->insert('schedule_list', $data_eta);
       }
        if($adjusted_date['adjusted_etd']){
         $this->db->where('invoice_no',$this->input->post('commercial_invoice_number',TRUE));
         $this->db->where('title','SALE - NEW SALE - ETD');$this->db->delete('schedule_list');
         $this->db->insert('schedule_list', $data_etd);
       }
        if($adjusted_date['adjusted_payment_due_date']){
         $this->db->where('invoice_no',$this->input->post('commercial_invoice_number',TRUE));
         $this->db->where('title','SALE - NEW SALE - PAYMENT DUE DATE');$this->db->delete('schedule_list');
         $this->db->insert('schedule_list', $data_adjusted_payment_due_date);
       } 
if ($invoice_id != "") {
    if (!empty($_FILES['invoicefiles'])) {
        $fileCount = count($_FILES['invoicefiles']['name']);
        for ($i = 0; $i <= $fileCount; $i++) {
            $upload_data = multiple_file_upload('invoicefiles', $i, 'invoice', INVOICE_IMG_PATH);
            if ($upload_data['upload_data']['file_name'] != "") {
                $res = insertAttachments($invoice_id, $upload_data['upload_data']['file_name'], INVOICE_IMG_PATH, 'invoice', $this->session->userdata('unique_id'), $createdby);
            }
        }
    }
}

    $response = [
        'status' => 'success',
        'msg' => 'Invoice processed successfully.',
        'invoice_id' => $invoice_id,
        'invoice_no' => $this->input->post('commercial_invoice_number', TRUE)
    ];
  
    echo json_encode($response);
}
    public function getinvoiceDatas() {
        $encodedId      = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId      = decodeBase64UrlParameter($encodedId);
        $limit          = $this->input->post('length');
        $start          = $this->input->post('start');
        $search         = $this->input->post('search')['value'];
        $orderField     = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'] =='sl' ? 'created_date' : $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
        $orderDirection = $this->input->post('order')[0]['dir'];
          $date           = $this->input->post("date");
        $totalItems     = $this->Invoices->getTotalInvoices($search, $decodedId,$date);
        $items          = $this->Invoices->getPaginatedInvoices($limit, $start, $orderField, $orderDirection, $search, $decodedId,$date);
        $data           = [];
        $i              = $start + 1;
        foreach ($items as $item) {
            $edit   = '<a href="' . base_url('Cinvoice/invoice_update_form?id=' . $encodedId. '&invoice_id=' . $item['invoice_id']) . '" class="btnclr btn btn-sm" style="margin-right: 5px;"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            $delete = '<a style="margin-right: 5px;" onClick=deleteInvoicedata('.$item["invoice_id"].') class="btnclr btn btn-sm" ><i class="fa fa-trash" aria-hidden="true"></i></a>' ;
             $mail = '<a data-toggle="modal" data-target="#sendemailmodal" onClick=sendEmailproforma('.$item["invoice_id"].') class="btnclr btn btn-sm" style="margin-right: 5px;"><i class="fa fa-envelope" aria-hidden="true"></i></a>';
          
             $download = '<a href="' . base_url('Cinvoice/invoice_inserted_data?id=' . $encodedId. '&invoice_id=' . $item['invoice_id']) . '" class="btnclr btn btn-sm" ><i class="fa fa-download" aria-hidden="true"></i></a>';
         
             $row = [
                'sl'               => $i,
                "commercial_invoice_number"   => $item['commercial_invoice_number'],
                "invoice_id"   => $item['invoice_id'],
                "customer_id" => $item['customer_id'],
                "payment_terms" => $item['payment_terms'],
                "payment_due_date"   => $item['payment_due_date'],
                "payment_type"            => $item['payment_type'],
                "total_tax"           => $item['total_tax'],
                "gtotal"             => $item['gtotal'],
                "paid_amount"         => $item['paid_amount'],
                'due_amount'   => $item['due_amount'],
                "created_date"    => $item['created_date'],
                'action'          => $download .'&nbsp;'. $edit . $mail . $delete,
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
    //Delete Invoice  - From Index - Surya
            public function InvoiceDeleteInvoice(){
            $invoice_id = $this->input->post('id');
            $payment = $this->db->select('payment_id,commercial_invoice_number')->from('invoice')->where('invoice_id', $invoice_id)->get()->row_array();
            $data['invoice_id'] = $this->input->post('invoice_id', TRUE);
            $updateinvoicedata = array('is_deleted' => 1);
            $result1 = $this->db->delete('payment', array('payment_id' => $payment['payment_id']));
            $result2 = $this->Invoices->update_invoiceData($invoice_id, $updateinvoicedata, 'invoice');
            $result3 = $this->Invoices->update_invoiceData($invoice_id, $updateinvoicedata, 'invoice_details');
            $result4 = $this->db->delete('invoice_servide_details', array('invoice_id' => $payment['commercial_invoice_number']));
            if ($result1 && $result2 && $result3 && $result4) {
                $response = array(
                    'status' => 'success',
                    'msg'    => 'Invoice has been deleted successfully!',
                );
            } else {
                $response = array(
                    'status' => 'failure',
                    'msg'    => 'Sorry !! Unable to delete the  invoice. Please try again!',
                );
            }
            echo json_encode($response);
            }
    public function company_name() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
         $CI->load->model('Invoices');
        $companyid=$CI->Invoices->trucking_entry();
        echo json_encode($companyid);
    }
     public function setmail($email, $file_path, $id = null, $name = null) {
        $setting_detail = $this->db->select('*')->from('email_config')->get()->row();
        $subject = 'Purchase  Information';
        $message = strtoupper($name) . '-' . $id;
        $config = Array(
        'protocol'  => $setting_detail->protocol,
        'smtp_host' => $setting_detail->smtp_host,
        'smtp_port' => $setting_detail->smtp_port,
        'smtp_user' => $setting_detail->smtp_user,
        'smtp_pass' => $setting_detail->smtp_pass,
        'mailtype'  => 'html', 
        'charset'   => 'utf-8',
        'wordwrap'  => TRUE
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from($setting_detail->smtp_user);
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->attach($file_path);
        $check_email = $this->test_input($email);
        if (filter_var($check_email, FILTER_VALIDATE_EMAIL)) {
            if ($this->email->send()) {
               return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
    //Email testing for email
    public function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
//Insert Payment Terms - for Sales - Surya
// PHP Controller (insertPaymentTerms)
public function PaymentTerms() {
        $response = array();
        $postData = $this->input->post('new_payment_terms');
        
        $id = $this->input->post('admin_company_id'); 
        $data = $this->Invoices->add_payment_term($postData, decodeBase64UrlParameter($id));
        if ($data) {
            $response['status'] = 'success';
            $response['msg']    = 'Payment Term has been added successfully';
            $response['pterms'] = $data; 
        } else {
            $response['status'] = 'failure';
            $response['msg']    = 'Failed to add Payment Term. Please try again.';
        }
    echo json_encode($response);
}
  //For Passing Data to Create Sale Edit Page  - Surya
 public function invoice_update_form() {
        $invoice_id=$_GET['invoice_id'];
        $customer = $this->Invoices->pos_customer_setup($_GET['id']);
        $invoice_detail = $this->Invoices->retrieve_invoice_editdata($invoice_id);
        $getEmployeeData = $this->Hrm_model->get_employeeTypedata();
        $edit_files = $this->Invoices->getInvoiceEditfiles($invoice_id);
        $bank_list      = $this->Web_settings->bank_list();
        $currency_details = $this->Web_settings->retrieve_setting_editdata();
        $product_bundle = $this->Invoices->get_product_bundle();
        $supplier_block_no = $this->Invoices->get_product_supplier_block();
        $paytype=$this->Invoices->payment_type();
        $curn_info_default = $this->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
        $prodt = $this->Products->get_all_products($_GET['id']);
        $all_invoice = $this->Invoices->all_invoice($invoice_id);
        $servic_provider = $this->Invoices->servic_provider_list();
        $payment_terms_dropdown = $this->Suppliers->payment_terms_dropdown();
        $setting_detail = $this->Web_settings->retrieve_setting_editdata();
         $tax_data = $this->Invoices->get_taxDatadetails($_GET['id']);
       $get_agent_data = $this->Invoices->get_agent_data();
        $additional_cost_details = $this->Invoices->additional_cost_details($invoice_detail[0]['commercial_invoice_number']);
        $data = array(
                 'supplier_block_no'=>$supplier_block_no,
                  'bundle' => $product_bundle,
                    'servic_provider'=>$servic_provider,
                    'additional_cost' =>$additional_cost_details,
          'customer'  => $customer,
            'curn_info_default' =>$curn_info_default[0]['currency_name'],
            'currency'  =>$currency_details[0]['currency'],
            'title'           => display('invoice_edit'),
            'product'       =>$prodt,
                    'tax_data'        => $tax_data,
            'payment_term' => $payment_terms_dropdown,
             'invoice_all_data'=> $invoice_detail,
           'all_invoice' =>$all_invoice,
            'payment_type'  =>$paytype,
           'bank_list'       => $bank_list,
            'invoice_detail'=>$invoice_detail,
            'employee_info' =>  $getEmployeeData,
           'edit_files' => $edit_files,
            'setting_detail' => $setting_detail,
             'get_agent_data' =>  $get_agent_data
        );
         $invoiceForm = $this->parser->parse('invoice/edit_invoice_form', $data, true);
        $this->template->full_admin_html_view($invoiceForm);
        // $chapterList = $CI->parser->parse('invoice/edit_invoice_form', $data, true);
        // return $chapterList;
    }
    // invoice Update
    public function invoice_update() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $invoice_id = $CI->Invoices->update_invoice();
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('Cinvoice/manage_invoice'));
    }
       // purchase Update
    public function update_ocean_export() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $CI->Invoices->update_ocean_export();
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('Cinvoice/manage_ocean_export_tracking'));
        exit;
    }
    //Search Inovoice Item
    public function search_inovoice_item() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $customer_id = $this->input->post('customer_id',TRUE);
        $content     = $CI->linvoice->search_inovoice_item($customer_id);
        $this->template->full_admin_html_view($content);
    }
    //Manage invoice list
    public function manage_invoice() {
        $this->session->unset_userdata('invoiceid');
        $this->session->unset_userdata('nation');
    $date = $this->input->post("daterangepicker-field");
// echo $date; die();
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $CI->load->model('Invoices');
         $CI->load->model('Web_settings');
         $setting_detail = $CI->Web_settings->retrieve_setting_editdata();
        $sale = $CI->Invoices->newsale($date);
        $email_settings = $CI->Invoices->getEmailConfigdata();
        // $getAttachmentData =  $CI->Invoices->retrieve_attachmentdata();
        // print_r($getAttachmentData);
        // print_r($email_settings);
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        // print_r($currency_details);
        $data['currency']          = $currency_details[0]['currency'];
        $data = array(
            'sale' => $sale,
            'email_settings' => $email_settings,
          'setting_detail' => $setting_detail
        );
        // print_r($sale);
        $content = $this->load->view('invoice/invoice', $data, true);
        $this->template->full_admin_html_view($content);
    }
public function manage_profarma_invoice() 
{
    $this->session->unset_userdata('perfarma_invoice_id');
    $date = $this->input->post("daterangepicker-field");
    $this->auth->check_admin_auth();
    $setting_detail = $this->Web_settings->retrieve_setting_editdata();
    $invoice = $this->Invoices->get_profarma_invoice();
    $email_setting = $this->Web_settings->retrieve_email_setting();
    $sale = $this->Invoices->sample($date);
    $currency_details = $this->Web_settings->retrieve_setting_editdata();
    $curn_info_default = $this->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
    $profarmasearch = $this->Invoices->getprofarma_data();
    $data = array(
        'curn_info_default' =>$curn_info_default[0]['currency_name'],
        'currency' =>$currency_details[0]['currency'],
        'invoice'         =>  $invoice,
        'email_setting'  => $email_setting,
        'sale' => $sale,
        'profarmasearch' => $profarmasearch,
        'setting_detail' => $setting_detail
    );
    $content = $this->load->view('invoice/profarma_invoice_list', $data, true);
    $this->template->full_admin_html_view($content);
}
    public function get_setting() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $menu = $this->input->post('menu');
     $submenu = $this->input->post('submenu');
        $user=$this->session->userdata('user_id');
                $invoice = $CI->Invoices->get_setting($user,$menu,$submenu);
               $menu= $invoice[0]->menu; 
               $submenu=$invoice[0]->submenu;
               $set= $invoice[0]->setting;
$data=array(
'menu'=> $menu,
'submenu'=> $submenu,
'setting' => $set
);
echo json_encode($data);
    }
    public function setting() {
      //  echo "<script>alert(localStorage.getItem('states'))</script>";
        $output = $this->input->post();
        $user=$this->session->userdata('user_id');
$this->output->set_content_type('application/json')
     ->set_output(json_encode($output));
    // echo $output['content'];
  $split= explode("/",$output['page']) ;
$set=json_encode( $output['content']);
  $data=array(
'user' => $user,
'menu' => $split[0],
'submenu' => $split[1],
'setting' => $set
 );
 $this->db->select('*');
 $this->db->from('bootgrid_data');
 $this->db->where('user', $user);
 $this->db->where('menu', $split[0]);
 $this->db->where('submenu', $split[1]);
 $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $this->db->where('user', $user); 
            $this->db->where('menu', $split[0]); 
            $this->db->where('submenu', $split[1]); 
$this->db->set('setting',$set);
$this->db->update('bootgrid_data');
    }else{
 $this->db->insert('bootgrid_data', $data);
    }
   // 
}
    public function insert_packing_list() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $invoice_id=$CI->Invoices->packing_list_entry();
      echo json_encode($invoice_id);
        } 
        public function manage_packing_list() {
            $this->session->unset_userdata('packingid');
            $date = $this->input->post("daterange");
            $CI = & get_instance();
            $CA = & get_instance();
            $this->auth->check_admin_auth();
            $CI->load->library('linvoice');
            $CI->load->model('Invoices');
             $CA->load->model('Web_settings');
            $sale = $CI->Invoices->packing_list($date);
            $value = $this->linvoice->packing_invoice_list();
            $email_setting = $CA->Web_settings->retrieve_email_setting();
            // print_r($email_setting); die();
            $data = array(
                 'invoice'         =>  $value,
                 'email_setting' => $email_setting,
                  'sale' => $sale
            );
          //  print_r($sale);
            $content = $this->load->view('invoice/packing_list', $data, true);
            $this->template->full_admin_html_view($content);
        }
    public function packing_list_update_form($purchase_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $content = $CI->linvoice->packing_list_edit_data($purchase_id);
        $this->template->full_admin_html_view($content);
    } 
   /* public function manage_ocean_export_tracking() {
        $this->session->unset_userdata('oceanid');
        $CI = & get_instance();
        $CA = & get_instance();
        $date = $this->input->post("daterangepicker-field");
        $this->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $CI->load->model('Invoices');
        $sale = $CI->Invoices->ocean_export($date);
        $value = $this->linvoice->ocean_export_tracking_invoice_list();
        $email_setting = $CA->Web_settings->retrieve_email_setting();
        $email_settings = $CI->Invoices->getEmailConfigdata();
        $setting_detail = $CI->Web_settings->retrieve_setting_editdata();
        // print_r($email_setting); die();
        $data = array(
            'invoice'         =>  $value,
            'email_setting' => $email_setting, 
            'sale' => $sale,
            'email_settings' => $email_settings,
                       'setting_detail' => $setting_detail
        );
     //   print_r($sale);
        $content = $this->load->view('invoice/ocean_export_tracking_invoice_list', $data, true);
        $this->template->full_admin_html_view($content);
    }
*/
    public function manage_trucking() {
        $this->session->unset_userdata('truckid');
        $CI = & get_instance();
        $CA = & get_instance();
        $date = $this->input->post("daterangepicker-field");
        $this->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $CI->load->model('Invoices');
        $value = $this->linvoice->trucking_invoice_list();
        $sale = $CI->Invoices->sale_trucking($date);
        $email_setting = $CA->Web_settings->retrieve_email_setting();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
                $setting_detail = $CI->Web_settings->retrieve_setting_editdata();
        $email_settings = $CI->Invoices->getEmailConfigdata();
        $data = array(
            'currency' =>$currency_details[0]['currency'],
            'invoice'         =>  $value,
            'email_setting' => $email_setting,
            'sale' => $sale,
            'email_settings' => $email_settings,
                       'setting_detail' => $setting_detail
        );
        $content = $this->load->view('invoice/trucking_invoice_list', $data, true);
        $this->template->full_admin_html_view($content);
    }
        public function CheckInvoiceList(){
        // GET data
        $this->load->model('Invoices');
        $postData = $this->input->post();
        $data = $this->Invoices->getInvoiceList($postData);
        echo json_encode($data);
    } 
    public function CheckProfarmaInvoiceList(){
        // GET data
        $this->load->model('Invoices');
        $postData = $this->input->post();
        $data = $this->Invoices->getProfarmaInvoiceList($postData);
        echo json_encode($data);
    }
     public function CheckPackingList(){
        // GET data
        $this->load->model('Invoices');
        $postData = $this->input->post();
        $data = $this->Invoices->getPackingList($postData);
        echo json_encode($data);
    }
    public function index1()
    { $CI = & get_instance();
        $CI->load->model('Invoices','boot');
        $data['data'] = $this->boot->get_datas();
        print_r($data);
        die();
        $this->load->view('invoice/profarma_invoice_list',$data);
    }
     //Retrive right now inserted data to cretae html
    public function ocean_export_tracking_details_data($purchase_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
       $CI->load->library('linvoice');
    $content = $CI->linvoice->ocean_export_tracking_details_data($purchase_id);
     //   echo json_encode($content);
      $this->template->full_admin_html_view($content);
    }
      public function ocean_export_tracking_details_data_print($purchase_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
       $CI->load->library('linvoice');
        $content = $CI->linvoice->ocean_export_tracking_details_data_print($purchase_id);
       // echo json_encode($content);
      $this->template->full_admin_html_view($content);
    }
    //For Sales - Add Payment Type - Surya
  public function add_payment_type(){
     $this->form_validation->set_rules('new_payment_type', 'Payment Type', 'required');
    $response = array();
    if ($this->form_validation->run() == FALSE) {
        $response['status'] = 'failure';
        $response['msg'] = validation_errors();
    } else {
        $postData = $this->input->post('new_payment_type');
        $id = $this->input->post('admin_company_id'); // or however you are getting the ID
        $data = $this->Invoices->add_payment_type($postData, decodeBase64UrlParameter($id));
        if ($data) {
            $response['status'] = 'success';
            $response['msg']    = 'Payment Type has been added successfully';
            $response['pterms'] = $data; 
        } else {
            $response['status'] = 'failure';
            $response['msg']    = 'Failed to add Payment Type. Please try again.';
        }
    }
    echo json_encode($response);
    }


  // manager company changed by ajith on 28/08/2024
    public function add_state_tax_id() {
        $this->form_validation->set_rules('new_state_tax_id', 'New State Tax ID', 'required');
        $response = array();
        if ($this->form_validation->run() == FALSE) {
            $response['status'] = 'failure';
            $response['msg']    = validation_errors();
        } else {
            $postData  = $this->input->post('new_state_tax_id');
            $decodedId = $this->input->post('decodedId');
            $data      = $this->Invoices->add_state_tax_id($postData, $decodedId);
            if ($data) {
                $response['status']          = 'success';
                $response['msg']             = 'New State Tax ID has been added successfully';
                $response['get_statetaxid'] = $data;
            } else {
                $response['status'] = 'failure';
                $response['msg']    = 'Failed to add New State Tax ID. Please try again.';
            }
        }
        echo json_encode($response);
    }
   // manager company changed by ajith on 28/08/2024
    public function add_local_tax_id() {
        $this->form_validation->set_rules('new_local_tax_id', 'New Local Tax ID', 'required');
        $response = array();
        if ($this->form_validation->run() == FALSE) {
            $response['status'] = 'failure';
            $response['msg']    = validation_errors();
        } else {
            $postData  = $this->input->post('new_local_tax_id');
            $decodedId = $this->input->post('decodedId');
            $data      = $this->Invoices->add_local_tax_id($postData, $decodedId);
            if ($data) {
                $response['status']          = 'success';
                $response['msg']             = 'New Local Tax ID has been added successfully';
                $response['get_localtaxid'] = $data;
            } else {
                $response['status'] = 'failure';
                $response['msg']    = 'Failed to add New Local Tax ID. Please try again.';
            }
        }
        echo json_encode($response);
    }
 



    

      public function add_city_tax(){
        $this->load->model('Invoices');
        $postData = $this->input->post('new_city_tax');
        $data = $this->Invoices->add_city_tax($postData);
        echo json_encode($data);
    }
      public function add_paymentroll_type(){
        $this->load->model('Invoices');
        $payrollData = $this->input->post('new_payroll_type');
        $data = array(
         'payroll_type' => $payrollData,
         'created_by' => $this->session->userdata('user_id')
        );
        $this->db->insert('payroll_type', $data);
        $payroll_data = $this->Invoices->add_paymentroll_type();
        echo json_encode($payroll_data);
    }

    //Changed by Ajith
    public function add_employee_type() {
        $this->load->model('Invoices');  
        $payrollData = $this->input->post('employee_type');
        $id = $this->input->post('encodedId');
        if (!$payrollData || !$id) {
            $response['status'] = 'failure';
            $response['msg'] = 'Invalid data provided.';
            echo json_encode($response);
            return;
        }
        $postData = array(
            'employee_type' => $payrollData
        );
        $employee_data = $this->Invoices->add_employees_type($postData, $id);
        if ($employee_data) {
            $response['status'] = 'success';
            $response['msg'] = 'Employee Type has been added successfully';
            $response['get_employeetype'] = $employee_data; 
        } else {
            $response['status'] = 'failure';
            $response['msg'] = 'Failed to add Employee Type. Please try again.';
        }
        echo json_encode($response);
    }
    





      public function CheckOceanExportList(){
        // GET data
         $this->load->model('Invoices');
        $postData = $this->input->post();
        $data = $this->Invoices->getOceanExportList($postData);
        echo json_encode($data);
    } 
        public function CheckTruckingList(){
         $this->load->model('Invoices');
        $postData = $this->input->post();
        $data = $this->Invoices->getTruckingList($postData);
        echo json_encode($data);
     }
     public function select_bank_name(){
    }
          //Trucking Update Form
    public function trucking_update_form($purchase_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $content = $CI->linvoice->trucking_edit_data($purchase_id);
        $this->template->full_admin_html_view($content);
    } 
     public function packing_list_details_data($invoice_id) {
     // echo $invoice_id; die();
        $CI = & get_instance();
        $CC = & get_instance();
        $CA = & get_instance();
        $w = & get_instance();
        $w->load->model('Ppurchases');
        $company_info = $w->Ppurchases->retrieve_company();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $CA->load->model('invoice_design');
        $CC->load->model('invoice_content');
        $invoice_detail = $CI->Invoices->invoice_pdf($invoice_id);
        // print_r($invoice_detail); die();
        $all_invoice = $CI->Invoices->all_invoice($invoice_id);
         // print_r($all_invoice); die();
         $setting=  $CI->Web_settings->retrieve_setting_editdata();
          $dataw = $CA->invoice_design->retrieve_data($this->session->userdata('user_id'));
        $datacontent = $CC->invoice_content->retrieve_data();
        $customer = $this->db->select('*')->from('customer_information')->where("customer_id",$invoice_detail[0]['customer_id'])->get()->result_array();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
         $product_name = $this->db->select('*')->from('product_information')->where("product_id",$all_invoice[0]['product_id'])->get()->result_array();
        //  echo $this->db->last_query(); die();
          // print_r($product_name); die();
        $data=array(
            'curn_info_default' =>$curn_info_default[0]['currency_name'],
            'currency'  =>$currency_details[0]['currency'],
            'header'=> $dataw[0]['header'],
           'logo'=>(!empty($setting[0]['invoice_logo'])?$setting[0]['invoice_logo']:$company_info[0]['logo']), 
            'color'=> $dataw[0]['color'],
            'template'=> $dataw[0]['template'],
            'packing_id'  =>$invoice_detail[0]['packing_id'],
          'company'=> (!empty($datacontent)?$datacontent:$company_info), 
            'customer_currency'=> $customer[0]['currency_type'],
            'customername'=> $customer[0]['customer_name'],
            'mobile'=> $customer[0]['customer_mobile'],
            'customeraddress'=> $customer[0]['customer_address'],
             'all_invoice'=>$all_invoice,
               'invoice_detail'=>$invoice_detail
        );
        //   print_r($dataw[0]['color']);
       // echo $content = $CI->linvoice->invoice_add_form();
        $content = $this->load->view('invoice/packing_list_invoice_html', $data, true);
        //$content='';
        $this->template->full_admin_html_view($content);
    }
   public function packing_list_details_data_print($invoice_id) {
     // echo $invoice_id; die();
        $CI = & get_instance();
        $CC = & get_instance();
        $CA = & get_instance();
        $w = & get_instance();
        $w->load->model('Ppurchases');
        $company_info = $w->Ppurchases->retrieve_company();
        $CI->load->model('Invoices');
        $CA->load->model('invoice_design');
        $CC->load->model('invoice_content');
                $CI->load->model('Web_settings');
        $invoice_detail = $CI->Invoices->invoice_pdf($invoice_id);
        // print_r($invoice_detail); die();
        $all_invoice = $CI->Invoices->all_invoice($invoice_id);
         // print_r($all_invoice); die();
                  $setting=  $CI->Web_settings->retrieve_setting_editdata();
           $dataw = $CA->invoice_design->retrieve_data($this->session->userdata('user_id'));
        $datacontent = $CC->invoice_content->retrieve_data();
        $customer = $this->db->select('*')->from('customer_information')->where("customer_id",$invoice_detail[0]['customer_id'])->get()->result_array();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
         $product_name = $this->db->select('*')->from('product_information')->where("product_id",$all_invoice[0]['product_id'])->get()->result_array();
        //  echo $this->db->last_query(); die();
          // print_r($product_name); die();
           $data=array(
            'curn_info_default' =>$curn_info_default[0]['currency_name'],
            'currency'  =>$currency_details[0]['currency'],
            'header'=> $dataw[0]['header'],
          'logo'=>(!empty($setting[0]['invoice_logo'])?$setting[0]['invoice_logo']:$company_info[0]['logo']), 
            'color'=> $dataw[0]['color'],
            'template'=> $dataw[0]['template'],
            'packing_id'  =>$invoice_detail[0]['packing_id'],
          'company'=> (!empty($datacontent)?$datacontent:$company_info), 
            'customer_currency'=> $customer[0]['currency_type'],
            'customername'=> $customer[0]['customer_name'],
            'mobile'=> $customer[0]['customer_mobile'],
            'customeraddress'=> $customer[0]['customer_address'],
             'all_invoice'=>$all_invoice,
               'invoice_detail'=>$invoice_detail
        );
   //print_r($data);
       // echo $content = $CI->linvoice->invoice_add_form();
        $content = $this->load->view('invoice/packing_list_invoice_print', $data, true);
        //$content='';
        $this->template->full_admin_html_view($content);
    }
  //Retrive right now inserted data to cretae html
    public function invoice_inserted_data() {

        $invoice_id       = isset($_GET['invoice_id']) ? $_GET['invoice_id'] : null;
         
        $encodedId       = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId       = decodeBase64UrlParameter($encodedId);

        $CI = & get_instance();
        $CC = & get_instance();
        $CA = & get_instance();
        $w = & get_instance();
        $w->load->model('Ppurchases');
        $company_info = $w->Ppurchases->retrieve_company($decodedId);
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $CA->load->model('invoice_design');
        $CC->load->model('invoice_content');

 
        $invoice_detail = $CI->Invoices->invoice_pdf($invoice_id);
        $all_invoice = $CI->Invoices->all_invoice($invoice_id);
        $setting=  $CI->Web_settings->retrieve_setting_editdata(); 
         $dataw = $CA->invoice_design->retrieve_data($decodedId);
         $datacontent = $CC->invoice_content->retrieve_data($decodedId);
         $customer = $this->db->select('*')->from('customer_information')->where("customer_id",$invoice_detail[0]['customer_id'])->get()->result_array();
         $currency_details = $CI->Web_settings->retrieve_setting_editdata();
         $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
         $product_name = $this->db->select('*')->from('product_information')->where("product_id",$all_invoice[0]['product_id'])->get()->result_array();
        $data=array(
            'curn_info_default' =>$curn_info_default[0]['currency_name'],
            'currency'  =>$currency_details[0]['currency'],
            'header'=> $dataw[0]['header'],
            'logo'=>(!empty($setting[0]['invoice_logo'])?$setting[0]['invoice_logo']:$company_info[0]['logo']),   
            'color'=> $dataw[0]['color'],
           'template'=> $dataw[0]['template'],
            'invoice_id'      => $invoice_detail[0]['invoice_id'],
            'customer_id'     => $invoice_detail[0]['customer_id'],
            'customer_name'   => $invoice_detail[0]['customer_name'],
            'date'            => $invoice_detail[0]['date'],
            'commercial_invoice_number' => $invoice_detail[0]['commercial_invoice_number'],
            'billing_address' => $invoice_detail[0]['billing_address'],
            'container_no'=> $invoice_detail[0]['container_no'],
            'bl_no'=> $invoice_detail[0]['bl_no'],
            'company'=> (!empty($datacontent)?$datacontent:$company_info),     
            'customer_currency'=> $customer[0]['currency_type'],
            'customername'=> $customer[0]['customer_name'],
            'mobile'=> $customer[0]['customer_mobile'],
            'all_products'=>$product_name,
             'port_of_discharge' => $invoice_detail[0]['port_of_discharge'],
            'invoice_detail' => $invoice_detail[0]['invoice_details'],
            'invoice'         => $invoice_detail[0]['invoice'],
            'total_amount'    => $invoice_detail[0]['total_amount'],
            'paid_amount'     => $invoice_detail[0]['paid_amount'],
            'due_amount'      => $all_invoice[0]['due_amount'],
            'invoice_discount'=> $invoice_detail[0]['invoice_discount'],
            'total_discount'  => $invoice_detail[0]['total_discount'],
            'unit'            => $invoice_detail[0]['unit'],
            'tax'             => $invoice_detail[0]['tax'],
            'payment_terms'             => $invoice_detail[0]['payment_terms'],
            'number_of_days'  =>$invoice_detail[0]['number_of_days'],
            'etd'  =>$invoice_detail[0]['etd'],
            'eta'  =>$invoice_detail[0]['eta'],
            'all_tax' =>$taxfield1,
            'payment_due_date' =>$invoice_detail[0]['payment_due_date'],
            'taxes'          => $taxfield,
            'prev_due'        => $invoice_detail[0]['prevous_due'],
            'net_total'       => $invoice_detail[0]['prevous_due'] + $invoice_detail[0]['total_amount'],
            'shipping_cost'   => $invoice_detail[0]['shipping_cost'],
            'total_tax'       => $invoice_detail[0]['taxs'],
            'Port_of_discharge'       => $invoice_detail[0]['Port_of_discharge'],
            'invoice_all_data'=> $invoice_detail,
            'taxvalu'         => $taxinfo,
            'payment_type'  =>$paytype,
            'all_invoice'=>$all_invoice,
            'date'=> $all_invoice[0]['date'],
            'rate'=> $all_invoice[0]['rate'],
            'ac_details'=> $all_invoice[0]['ac_details'],
            'remark'=> $all_invoice[0]['remark'],
            'total'=> $all_invoice[0]['total_price'],
            'tax_details'=> $all_invoice[0]['total_tax'],
            'etd'=> $all_invoice[0]['etd'],
            'eta'=> $all_invoice[0]['eta'],
            'gtotal'       => $all_invoice[0]['gtotal'],
            'discount_type'   => $currency_details[0]['discount_type'],
            'bank_list'       => $bank_list,
            'bank_id'         => $invoice_detail[0]['bank_id'],
            'paytype'         => $invoice_detail[0]['payment_type'],
            'invoice_detail'=>$invoice_detail
        );
     $content = $this->load->view('invoice/new_invoice_pdf_html', $data, true);
    $this->template->full_admin_html_view($content);
    }
   
    // $dompdf = new Dompdf();
    // $dompdf->loadHtml($content);
    // $dompdf->setPaper('A4', 'portrait');
    // $dompdf->render();
    // $filename = 'invoice_' . $invoice_detail[0]['invoice_id'] . '.pdf';
    // if (empty($pdf)) {
    //     $dompdf->stream($filename, array('Attachment' => 0));
    // } else {
    //     return $content;
    // }
    // }



    
 



    public function invoice_inserted_data_print($invoice_id) {
  // echo $invoice_id; die();
        $CI = & get_instance();
        $CC = & get_instance();
        $CA = & get_instance();
        $w = & get_instance();
        $w->load->model('Ppurchases');
        $company_info = $w->Ppurchases->retrieve_company();
        $CI->load->model('Invoices');
        $CA->load->model('invoice_design');
        $CC->load->model('invoice_content');
        $CI->load->model('Web_settings');
        $invoice_detail = $CI->Invoices->invoice_pdf($invoice_id);
        // print_r($invoice_detail); die();
        $all_invoice = $CI->Invoices->all_invoice($invoice_id);
         $setting=  $CI->Web_settings->retrieve_setting_editdata();
         // print_r($all_invoice); die();
            $dataw = $CA->invoice_design->retrieve_data($this->session->userdata('user_id'));
        $datacontent = $CC->invoice_content->retrieve_data();
        $customer = $this->db->select('*')->from('customer_information')->where("customer_id",$invoice_detail[0]['customer_id'])->get()->result_array();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
         $product_name = $this->db->select('*')->from('product_information')->where("product_id",$all_invoice[0]['product_id'])->get()->result_array();
        //  echo $this->db->last_query(); die();
          // print_r($product_name); die();
        $data=array(
            'curn_info_default' =>$curn_info_default[0]['currency_name'],
            'currency'  =>$currency_details[0]['currency'],
            'header'=> $dataw[0]['header'],
         'logo'=>(!empty($setting[0]['invoice_logo'])?$setting[0]['invoice_logo']:$company_info[0]['logo']),  
            'color'=> $dataw[0]['color'],
            'template'=> $dataw[0]['template'],
     'invoice_id'      => $invoice_detail[0]['invoice_id'],
            'customer_id'     => $invoice_detail[0]['customer_id'],
            'customer_name'   => $invoice_detail[0]['customer_name'],
            'date'            => $invoice_detail[0]['date'],
            'commercial_invoice_number' => $invoice_detail[0]['commercial_invoice_number'],
            'billing_address' => $invoice_detail[0]['billing_address'],
            'container_no'=> $invoice_detail[0]['container_no'],
            'bl_no'=> $invoice_detail[0]['bl_no'],
             'company'=> (!empty($datacontent)?$datacontent:$company_info), 
            'customer_currency'=> $customer[0]['currency_type'],
            'customername'=> $customer[0]['customer_name'],
            'mobile'=> $customer[0]['customer_mobile'],
            'all_products'=>$product_name,
             'port_of_discharge' => $invoice_detail[0]['port_of_discharge'],
            'invoice_detail' => $invoice_detail[0]['invoice_details'],
            'invoice'         => $invoice_detail[0]['invoice'],
            'total_amount'    => $invoice_detail[0]['total_amount'],
           'paid_amount'     => $invoice_detail[0]['paid_amount'],
            'due_amount'      => $all_invoice[0]['due_amount'],
            'invoice_discount'=> $invoice_detail[0]['invoice_discount'],
            'total_discount'  => $invoice_detail[0]['total_discount'],
            'unit'            => $invoice_detail[0]['unit'],
            'tax'             => $invoice_detail[0]['tax'],
            'payment_terms'             => $invoice_detail[0]['payment_terms'],
            'number_of_days'  =>$invoice_detail[0]['number_of_days'],
            'etd'  =>$invoice_detail[0]['etd'],
            'eta'  =>$invoice_detail[0]['eta'],
            'all_tax' =>$taxfield1,
            'payment_due_date' =>$invoice_detail[0]['payment_due_date'],
            'taxes'          => $taxfield,
            'prev_due'        => $invoice_detail[0]['prevous_due'],
            'net_total'       => $invoice_detail[0]['prevous_due'] + $invoice_detail[0]['total_amount'],
            'shipping_cost'   => $invoice_detail[0]['shipping_cost'],
            'total_tax'       => $invoice_detail[0]['taxs'],
            'invoice_all_data'=> $invoice_detail,
            'taxvalu'         => $taxinfo,
            'payment_type'  =>$paytype,
            'all_invoice'=>$all_invoice,
            'date'=> $all_invoice[0]['date'],
            'rate'=> $all_invoice[0]['rate'],
            'ac_details'=> $all_invoice[0]['ac_details'],
            'remark'=> $all_invoice[0]['remark'],
            'total'=> $all_invoice[0]['total_price'],
            'tax_details'=> $all_invoice[0]['total_tax'],
            'etd'=> $all_invoice[0]['etd'],
            'eta'=> $all_invoice[0]['eta'],
            'gtotal'       => $all_invoice[0]['gtotal'],
            'discount_type'   => $currency_details[0]['discount_type'],
            'bank_list'       => $bank_list,
            'bank_id'         => $invoice_detail[0]['bank_id'],
            'paytype'         => $invoice_detail[0]['payment_type'],
            'invoice_detail'=>$invoice_detail
        );
    $content = $this->load->view('invoice/print_new_sale', $data, true);
    $this->template->full_admin_html_view($content);
    }
    public function sale_packing(){
        $CI = & get_instance();
        $CC = & get_instance();
        $CA = & get_instance();
        $w = & get_instance();
        $w->load->model('Ppurchases');
        $company_info = $w->Ppurchases->retrieve_company();
        $CI->load->model('Invoices');
        $CA->load->model('invoice_design');
        $CC->load->model('invoice_content');
        $company_info = $w->Ppurchases->retrieve_company();
        $packing_detail = $CI->Invoices->packing_pdf();
        // print_r($packing_detail); die();
        $data=array(
            'header'=> $dataw[0]['header'],
            'logo'=> $dataw[0]['logo'],
            'color'=> $dataw[0]['color'],
            'template'=> $dataw[0]['template'],
            'company'=> $company_info[0]['company_name'],
        );
    $content = $this->load->view('invoice/packing_list_invoice_html', $data, true);
    $this->template->full_admin_html_view($content);
    }
//  public function get_all_products() {
//       $CI = & get_instance();
//  $prodt = $CI->db->select('product_name,product_model,p_quantity')
//         ->from('product_information')
//         ->get()
//         ->result_array();
// echo json_encode($prodt);
//  }
    public function pos_invoice_inserted_data_manual() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $invoice_id = $this->input->post('invoice_id',TRUE);
        $url = $this->input->post('url',TRUE);
        $content = $CI->linvoice->pos_invoice_html_data_manual($invoice_id,$url);
        $this->template->full_admin_html_view($content);
    }
    //Retrive right now inserted data to cretae html
    public function pos_invoice_inserted_data($invoice_id) {
        // 
    }
//Min invoice data
     public function min_invoice_inserted_data($invoice_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $content = $CI->linvoice->min_invoice_html_data($invoice_id);
        $this->template->full_admin_html_view($content);
    }
    // Retrieve_product_data from expense
        public function retrieve_product_data() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $product_id  = $this->input->post('product_id',TRUE);
        $supplier_id = $this->input->post('supplier_id',TRUE);
        $product_info = $CI->Invoices->get_total_product($product_id, $supplier_id);
        echo json_encode($product_info);
    }
    //Retrieve_product_data from purchase order
      public function retrieve_product_data_from_po() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $product_id  = $this->input->post('product_id',TRUE);
        //$supplier_id = $this->input->post('supplier_id',TRUE);
        $product_info = $CI->Invoices->get_total_product_from_purchase_order($product_id);
        echo json_encode($product_info);
    }
    // Retrieve_product_data
    // public function retrieve_product_data() {
    //      echo "hello";return;
    //     $CI = & get_instance();
    //     $this->auth->check_admin_auth();
    //     $CI->load->model('Invoices');
    //     $product_id  = $this->input->post('product_id',TRUE);
    //     $supplier_id = $this->input->post('supplier_id',TRUE);
    //     $product_info = $CI->Invoices->get_total_product($product_id, $supplier_id);
    //     echo json_encode($product_info);
    // }
    //product info retrive by product id for invoice
    public function retrieve_product_data_inv() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $product_id = $this->input->post('product_id',TRUE);
        $product_info = $CI->Invoices->get_total_product_invoic($product_id);
        echo json_encode($product_info);
    }
    // Invoice delete
    public function invoice_delete($invoice_id) {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $result = $CI->Invoices->delete_invoice($invoice_id);
        if ($result) {
            $this->session->set_userdata(array('message' => display('successfully_delete')));
             redirect('Cinvoice/manage_invoice');
        }
    }
        public function autocompleteproductsearch(){
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $product_name   = $this->input->post('product_name',TRUE);
        $product_info   = $CI->Invoices->autocompletproductdata($product_name);
       if(!empty($product_info)){
        $list[''] = '';
        foreach ($product_info as $value) {
            $json_product[] = array('label'=>$value['product_name'].'('.$value['product_model'].')','value'=>$value['product_id']);
        } 
    }else{
        //$json_product[] = 'No Product Found';
        $json_product[] = 'Add New Product';
        }
        echo json_encode($json_product);
    }
    //AJAX INVOICE STOCKs
    public function product_stock_check($product_id) {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $purchase_stocks = $CI->Invoices->get_total_purchase_item($product_id);
        $total_purchase = 0;
        if (!empty($purchase_stocks)) {
            foreach ($purchase_stocks as $k => $v) {
                $total_purchase = ($total_purchase + $purchase_stocks[$k]['quantity']);
            }
        }
        $sales_stocks = $CI->Invoices->get_total_sales_item($product_id);
        $total_sales = 0;
        if (!empty($sales_stocks)) {
            foreach ($sales_stocks as $k => $v) {
                $total_sales = ($total_sales + $sales_stocks[$k]['quantity']);
            }
        }
        $final_total = ($total_purchase - $total_sales);
        return $final_total;
    }
//    =========== its for 1 increment =============
    function randomChange($myValue) {
        $random = rand(0, 1);
        if ($random > 0)
            return $myValue + 1;
        return $myValue - 1;
    }
    //This function is used to Generate Key
    public function generator($lenth) {
        $number = array("1", "2", "3", "4", "5", "6", "7", "8", "9");
        for ($i = 0; $i < $lenth; $i++) {
            $rand_value = rand(0, 8);
            $rand_number = $number["$rand_value"];
            if (empty($con)) {
                $con = $rand_number;
            } else {
                $con = "$con" . "$rand_number";
            }
        }
        return $con;
    }
    //customer previous due
     public function previous() {
         $CI = & get_instance();
        $CI->load->model('Customers');
        $customer_id = $this->input->post('customer_id',TRUE);
        $this->db->select("a.*,b.HeadCode,((select ifnull(sum(Debit),0) from acc_transaction where COAID= `b`.`HeadCode` AND IsAppove = 1)-(select ifnull(sum(Credit),0) from acc_transaction where COAID= `b`.`HeadCode` AND IsAppove = 1)) as balance");
         $this->db->from('customer_information a');
         $this->db->join('acc_coa b','a.customer_id = b.customer_id','left');
         $this->db->where('a.customer_id',$customer_id);
        $result = $this->db->get()->result_array();
       $balance = $result[0]['balance'];   
       $b = (!empty($balance)?$balance:0);                            
        if ($b){
           echo  $b;
        } else {
           echo  $b;
        }
    }
    public function customer_autocomplete(){
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $CI->load->model('Customers');
        $customer_id    = $this->input->post('customer_id',TRUE);
        $customer_info   = $CI->Customers->customer_search($customer_id);
          if($customer_info){
        $json_customer[''] = '';
        foreach ($customer_info as $value) {
            $json_customer[] = array('label'=>$value['customer_name'],'value'=>$value['customer_id']);
        }
         }else{
           $json_customer[] = 'No Record found';
        }
        echo json_encode($json_customer);
    }
    //csv excel 
     public function exportinvocsv() {
        // file name 
        $this->load->model('Invoices');
        $filename = 'sale_' . date('Ymd') . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");
        // get data 
        $invoicedata = $this->Invoices->invoice_csv_file();
        // file creation 
        $file = fopen('php://output', 'w');
        $header = array('invoice_no', 'invoice_id', 'customer_name', 'date', 'total_amount');
        fputcsv($file, $header);
        foreach ($invoicedata as $line) {
            fputcsv($file, $line);
        }
        fclose($file);
        exit;
    }
        public function getitemlist(){
             $this->load->model('Invoices');
                $prod=$this->input->post('product_name',TRUE);
                $catid=$this->input->post('category_id',TRUE);
                $getproduct = $this->Invoices->searchprod($catid,$prod);
                if(!empty($getproduct)){
                $data['itemlist']=$getproduct;
                $this->load->view('invoice/getproductlist', $data);  
                }
                else{
                    $title['title'] = 'Product Not found';
                    $this->load->view('invoice/productnot_found', $title);
                    }
        }
     public function trucking_details_data_print($purchase_id) {
            $CI = & get_instance();
            $CI->auth->check_admin_auth();
            $CI->load->library('linvoice');
            $content = $CI->linvoice->trucking_details_data_print($purchase_id);
            $this->template->full_admin_html_view($content);
        }
 //For Create Sale - To Get All Product in Dropdown  - Surya
public function product_info(){
       $product_model = $this->input->post('product_model',TRUE);
        $product_name = $this->input->post('product_name',TRUE);
        $product_info = $CI->Invoices->product_search_item($product_model, $product_name);
echo json_encode($product_info);
}


// Quotation Data Create - Madhu
public function performer_ins()
{
    $this->auth->check_admin_auth();
    $admin_comp_id = decodeBase64UrlParameter($this->input->post('admin_company_id'));
    $this->form_validation->set_rules('purchase_date', 'Purchase Date', 'required');
    $this->form_validation->set_rules('customer_id', 'Customer Name', 'required');
    $response = [];
    if ($this->form_validation->run() == FALSE) {
        $response['status'] = 'failure';
        $response['msg'] = validation_errors();
    } else {
        $purchase_id = date('YmdHis');
        $data = [
            'chalan_no' => $this->input->post('chalan_no', TRUE),
            'purchase_date' => $this->input->post('purchase_date', TRUE),
            'billing_address' => $this->input->post('billing_address', TRUE),
            'customer_id' => $this->input->post('customer_id', TRUE),
            'pre_carriage' => $this->input->post('pre_carriage', TRUE),
            'receipt' => $this->input->post('receipt', TRUE),
            'remarks' => $this->input->post('remark', TRUE),
            'tax_details' => $this->input->post('tax_details', TRUE),
            'total_gross' => $this->input->post('total_gross', TRUE),
            'total_net' => $this->input->post('total_net', TRUE),
            'total_weight' => $this->input->post('total_weight', TRUE),
            'gtotal' => $this->input->post('gtotal', TRUE),
            'total' => $this->input->post('Over_all_Total', TRUE),
            'payment_id' => $this->input->post('makepaymentId', TRUE),
            'customer_gtotal' => $this->input->post('customer_gtotal', TRUE),
            'country_goods' => $this->input->post('country_goods', TRUE),
            'country_destination' => $this->input->post('country_destination', TRUE),
            'loading' => $this->input->post('loading', TRUE),
            'discharge' => $this->input->post('discharge', TRUE),
            'terms_payment' => $this->input->post('terms_payment', TRUE),
            'description_goods' => $this->input->post('description_goods', TRUE),
            'amt_paid' => $this->input->post('amount_paid', TRUE),
            'bal_amt' => $this->input->post('balance', TRUE),
            'ac_details' => $this->input->post('ac_details', TRUE),
            'sales_by' => $admin_comp_id,
            'modified_admin' => $this->session->userdata('unique_id'),
            'modified_by' => $this->session->userdata('unique_id')
        ];
        $existing_invoice = $this->db->where('chalan_no', $this->input->post('chalan_no', TRUE))->get('profarma_invoice')->row_array();
     
        $existing_purchaseid = '';
        if (!empty($existing_invoice)) {
           $this->db->where('chalan_no', $this->input->post('chalan_no', TRUE));
           $data['modified_admin']=$this->session->userdata('unique_id');
           $data['modified_by']=$createdby;
           $data['modified_date']=date('Y-m-d H:i:s');
           $existing_purchaseid = $existing_invoice['purchase_id'];
           $this->db->update('profarma_invoice', $data);
        } else {
            $data['purchase_id'] = $purchase_id;
            $existing_purchaseid = $purchase_id;
            $proforma_insert_id = $this->Invoices->insert_profarmainvoice($data);
            // echo $this->db->last_query(); die();
        }
        $product_data = [
            'available_quantity' => $this->input->post('available_quantity', TRUE),
            'product_id' => $this->input->post('product_id', TRUE),
            'description' => $this->input->post('description', TRUE),
            'total_amt' => $this->input->post('total_amt', TRUE),
            'prodt' => $this->input->post('prodt', TRUE),
            'thickness' => $this->input->post('thickness', TRUE),
            'supplier_block_no' => $this->input->post('supplier_block_no', TRUE),
            'supplier_slab_no' => $this->input->post('supplier_slab_no', TRUE),
            'gross_width' => $this->input->post('gross_width', TRUE),
            'gross_height' => $this->input->post('gross_height', TRUE),
            'gross_sq_ft' => $this->input->post('gross_sq_ft', TRUE),
            'bundle_no' => $this->input->post('bundle_no', TRUE),
            'slab_no' => $this->input->post('slab_no', TRUE),
            'net_width' => $this->input->post('net_width', TRUE),
            'net_height' => $this->input->post('net_height', TRUE),
            'net_sq_ft' => $this->input->post('net_sq_ft', TRUE),
            'cost_sq_ft' => $this->input->post('cost_sq_ft', TRUE),
            'tableid' => $this->input->post('tableid', TRUE),
            'cost_sq_slab' => $this->input->post('cost_sq_slab', TRUE),
            'sales_amt_sq_ft' => $this->input->post('sales_amt_sq_ft', TRUE),
            'sales_slab_amt' => $this->input->post('sales_slab_amt', TRUE),
            'weight' => $this->input->post('weight', TRUE),
            'total' => $this->input->post('total', TRUE),
            'hold_product' =>  $this->input->post('hold_product', TRUE),
        ];
        $rowCount = count($product_data['product_id']);
        for ($i = 0; $i < $rowCount; $i++) {
            $proforma_details = [
                'purchase_id' => $purchase_id,
                'product_id' => isset($product_data['product_id'][$i]) ? $product_data['product_id'][$i] : null,
                'quantity' => isset($product_data['available_quantity'][$i]) ? $product_data['available_quantity'][$i] : 0,
                'description' => isset($product_data['description'][$i]) ? $product_data['description'][$i] : '',
                'tableid' => isset($product_data['tableid'][$i]) ? $product_data['tableid'][$i] : null,
                'thickness' => isset($product_data['thickness'][$i]) ? $product_data['thickness'][$i] : '',
                'supplier_block_no' => isset($product_data['supplier_block_no'][$i]) ? $product_data['supplier_block_no'][$i] : '',
                'supplier_slab_no' => isset($product_data['supplier_slab_no'][$i]) ? $product_data['supplier_slab_no'][$i] : '',
                'gross_width' => isset($product_data['gross_width'][$i]) ? $product_data['gross_width'][$i] : 0,
                'gross_height' => isset($product_data['gross_height'][$i]) ? $product_data['gross_height'][$i] : 0,
                'gross_sq_ft' => isset($product_data['gross_sq_ft'][$i]) ? $product_data['gross_sq_ft'][$i] : 0,
                'bundle_no' => isset($product_data['bundle_no'][$i]) ? $product_data['bundle_no'][$i] : '',
                'net_width' => isset($product_data['net_width'][$i]) ? $product_data['net_width'][$i] : 0,
                'net_height' => isset($product_data['net_height'][$i]) ? $product_data['net_height'][$i] : 0,
                'net_sq_ft' => isset($product_data['net_sq_ft'][$i]) ? $product_data['net_sq_ft'][$i] : 0,
                'cost_sq_ft' => isset($product_data['cost_sq_ft'][$i]) ? $product_data['cost_sq_ft'][$i] : 0,
                'cost_sq_slab' => isset($product_data['cost_sq_slab'][$i]) ? $product_data['cost_sq_slab'][$i] : 0,
                'sales_amt_sq_ft' => isset($product_data['sales_amt_sq_ft'][$i]) ? $product_data['sales_amt_sq_ft'][$i] : 0,
                'sales_slab_amt' => isset($product_data['sales_slab_amt'][$i]) ? $product_data['sales_slab_amt'][$i] : 0,
                'weight' => isset($product_data['weight'][$i]) ? $product_data['weight'][$i] : 0,
                'total_amount' => isset($product_data['total'][$i]) ? $product_data['total'][$i] : 0,
                'hold_product' => isset($product_data['hold_product'][$i]) ? $product_data['hold_product'][$i] : 0,
                'modified_by' => $this->session->userdata('unique_id'),
                'create_by' => $admin_comp_id,
                'status' => 1,
            ];
            $this->Invoices->insert_profarmadetails($proforma_details);
            // echo $this->db->last_query(); die();
        }
        // Insert Attchment
        if($existing_purchaseid!=""){
            if(!empty($_FILES['files'])){
                    $fileCount = count($_FILES['files']['name']);
                    for ($i = 0; $i <= $fileCount; $i++) {
                        $upload_data = multiple_file_upload('files',$i,'quotation',PROFORMA_IMG_PATH);
                        if($upload_data['upload_data']['file_name'] !=""){
                            $res = insertAttachments($existing_purchaseid, $upload_data['upload_data']['file_name'],PROFORMA_IMG_PATH,'quotation',$this->session->userdata('unique_id'),$admin_comp_id);
                        }
                    }
            }
        }

        
        $response['status'] = 'success';
        $response['msg'] = 'Proforma invoice created successfully';
    }
    echo json_encode($response);
}



// Add to cart
public function addCart()
{
    $CI = & get_instance();
    $this->auth->check_admin_auth();
    $content = $this->linvoice->add_cartitems();
    $this->template->full_admin_html_view($content);
}
public function fetchData()
    {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $items = $this->Invoices->items_insert();
        $content = $this->linvoice->dataCart();
        $this->template->full_admin_html_view($content);
    }
public function sales_tax() {
    $data['setting_detail']  = $this->Web_settings->retrieve_setting_editdata();
    $data['sales_tax'] = $this->Invoices->sales_tax();
    $content = $CI->parser->parse('report/tax_report', $data, true);
    $this->template->full_admin_html_view($content);
}
public function expense_tax() {
    $data['setting_detail']  = $this->Web_settings->retrieve_setting_editdata();
    $data['exp_tax'] = $this->Invoices->expense_tax();
    $data['ser_exp_tax'] = $this->Invoices->service_provider_expense_tax();
    $content = $CI->parser->parse('report/taxsable_expense', $data, true);
    $this->template->full_admin_html_view($content);
}
//To insert Customer from pop up Model - Madhu
public function instant_customer() 
{
    $this->auth->check_admin_auth();
    $admin_comp_id = decodeBase64UrlParameter($this->input->post('admin_company_id'));
    $this->form_validation->set_rules('customer_name', 'Customer Name', 'required|trim');
    $this->form_validation->set_rules('primary_email', 'Primary Email', 'required|valid_email');
    $this->form_validation->set_rules('business_mobile', 'Business Phone Number', 'required|numeric');
    $this->form_validation->set_rules('contact_person', 'Contact Person', 'required|trim');
    $this->form_validation->set_rules('preferred_currency', 'Preferred Currency', 'required');
    $this->form_validation->set_rules('sales_taxes', 'Sales Tax', 'required');
    $this->form_validation->set_rules('address2', 'Billing Address', 'required|trim');
    $this->form_validation->set_rules('cust_city', 'City', 'required|trim');
    $this->form_validation->set_rules('cust_state', 'State', 'required|trim');
    $this->form_validation->set_rules('cust_zip', 'Zip Code', 'required|numeric');
    $this->form_validation->set_rules('cust_country', 'Country', 'required');
    $this->form_validation->set_rules('payment_terms', 'Payment Terms', 'required');
    $this->form_validation->set_rules('previous_balance', 'Credit Limit', 'required|trim');
    $this->form_validation->set_error_delimiters('<br/>', '');
    $response = array();
    if ($this->form_validation->run() == FALSE) {
        $response['status'] = 'failure';
        $response['msg'] = validation_errors();
    } else {
        $t_status = empty($this->input->post('taxes', TRUE)) ? '0' : '1';
        $data = array(
            'customer_name' => $this->input->post('customer_name', TRUE),
            'billing_address' => $this->input->post('address2', TRUE),
            'shipping_address' => $this->input->post('address', TRUE),
            'customer_mobile' => $this->input->post('mobile', TRUE),
            'currency_type' => $this->input->post('preferred_currency', TRUE),
            'bussiness_phone' => $this->input->post('business_mobile', TRUE),
            'payment_terms' => $this->input->post('payment_terms', TRUE),
            'sales_tax' => $this->input->post('sales_taxes', TRUE),
            'tax_percent' => $this->input->post('taxes', TRUE) . "%",
            'tax_status' => $t_status,
            'fax' => $this->input->post('fax', TRUE),
            'contact_person' => $this->input->post('contact_person', TRUE),
            'city' => $this->input->post('cust_city', TRUE),
            'state' => $this->input->post('cust_state', TRUE),
            'zip' => $this->input->post('cust_zip', TRUE),
            'country' => $this->input->post('cust_country', TRUE),
            'primary_email' => $this->input->post('primary_email', TRUE),
            'secondary_email' => $this->input->post('emailaddress', TRUE),
            'credit_limit' => $this->input->post('previous_balance', TRUE),
            'customer_type' => $this->input->post('customer_type', TRUE),
            'status' => 2,
            'create_by' => $admin_comp_id,
            'created_admin' => $this->session->userdata('unique_id'),
            'modified_by' => $admin_comp_id,
            //'modified_admin' => $this->session->userdata('unique_id'),
        );
        $customerid = $this->Customers->customer_entry($data);

        if ($customerid && !empty($_FILES['customer_attachment']['name'])) {
            $upload_data = file_upload('customer_attachment', 'customer', CUSTOMER_IMG_PATH);
            if (!empty($upload_data['upload_data']['file_name'])) {
                $update_data = array('attachments' => $upload_data['upload_data']['file_name']);
                $this->Customers->update_customers($update_data, $customerid);
            }
        }
        $response = array(
            'status' => 'success',
            'msg' => 'Customer has been inserted successfully.',
            'customerdata' => $this->Customers->all_customer()
        );
    }
    echo json_encode($response);
}
public function newsale_with_attachment_stand($invoiceid)
  {
    $sql='select c.* from user_login  u
    join 
    company_information c
    on c.company_id=u.cid
     where u.user_id='.$_SESSION['user_id'];
    $query=$this->db->query($sql);
    $data['company_info']=$query->result_array();
        $sql='SELECT b.* from invoice a JOIN customer_information b on b.customer_id=a.customer_id
 WHERE a.invoice_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['customer_info']=$query->result_array();
      $sql='select b.* from invoice_details a join product_information b on a.product_id=b.product_id
 where a.invoice_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['product_info']=$query->result_array();
 $sql='select * from invoice_details where invoice_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['invoice_details']=$query->result_array();
$sql='select * from invoice where invoice_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['invoice']=$query->result_array();
    $content = $this->load->view('pdf_attach_mail/new_sale', $data, true);
  }
  public function newsale_with_attachment_cus($invoiceid)
  {
    $sql='select c.* from user_login  u
    join 
    company_information c
    on c.company_id=u.cid
     where u.user_id='.$_SESSION['user_id'];
    $query=$this->db->query($sql);
    $data['company_info']=$query->result_array();
        $sql='SELECT b.* from invoice a JOIN customer_information b on b.customer_id=a.customer_id
 WHERE a.invoice_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['customer_info']=$query->result_array();
      $sql='select b.* from invoice_details a join product_information b on a.product_id=b.product_id
 where a.invoice_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['product_info']=$query->result_array();
 $sql='select * from invoice_details where invoice_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['invoice_details']=$query->result_array();
$sql='select * from invoice where invoice_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['invoice']=$query->result_array();
    $sql='select * from invoice_email where uid='.$_SESSION['user_id'];;
    $query=$this->db->query($sql);
    $data['mail']= $query->result_array();
    $content = $this->load->view('pdf_attach_mail/new_sale', $data, true);
  }
  /////////////////////proforma//////////////////////////////////
  public function proforma_with_attachment_stand($invoiceid)
  {
    $sql='select c.* from user_login  u
    join 
    company_information c
    on c.company_id=u.cid
     where u.user_id='.$_SESSION['user_id'];
    $query=$this->db->query($sql);
    $data['company_info']=$query->result_array();
        $sql='SELECT b.* from profarma_invoice a JOIN customer_information b on b.customer_id=a.customer_id
 WHERE a.purchase_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['customer_info']=$query->result_array();
      $sql='select a.* from profarma_invoice_details a join product_information b on a.product_id=b.product_id
 where a.purchase_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['product_info']=$query->result_array();
 $sql='select * from profarma_invoice_details where purchase_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['invoice_details']=$query->result_array();
$sql='select * from profarma_invoice where purchase_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['invoice']=$query->result_array();
$content = $this->load->view('pdf_attach_mail/profarma', $data, true);
  }
public function proforma_with_attachment_cus($invoiceid)
  {
      $CA = & get_instance();
      $CI = & get_instance();
      $CA->load->model('invoice_design');
      $CA->load->model('invoice_content');
      $CA->load->model('Web_settings');
      $w = & get_instance();
      $w->load->model('Ppurchases');
      $dataw = $CA->invoice_design->proforma_data();
      $currency_details = $CI->Web_settings->retrieve_setting_editdata();
      $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
       $data['head']=$dataw;
    $sql='select c.* from user_login  u
    join
    company_information c
    on c.company_id=u.cid
     where u.user_id='.$_SESSION['user_id'];
    $query=$this->db->query($sql);
  $company_content= $CA->invoice_content->retrieve_info_data();
   $company_info = $w->Ppurchases->retrieve_company();
    $setting=  $CI->Web_settings->retrieve_setting_editdata();
     $this->session->set_userdata('image_email', base_url().(!empty($setting[0]['invoice_logo'])?$setting[0]['invoice_logo']:$company_info[0]['logo']));
        $sql='SELECT * from profarma_invoice a JOIN customer_information b on b.customer_id=a.customer_id
     WHERE a.purchase_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['customer_info']=$query->result_array();
      $sql='select a.*, b.*, c.* from profarma_invoice_details a join profarma_invoice b on a.purchase_id=b.purchase_id join product_information c on c.product_id=a.product_id where a.purchase_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['product_info']=$query->result_array();
 $sql='select * from profarma_invoice_details where purchase_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['invoice_details']=$query->result_array();
$sql='select * from profarma_invoice where purchase_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['invoice']=$query->result_array();
    $sql='select * from invoice_email where uid='.$_SESSION['user_id'];;
    $query=$this->db->query($sql);
    $data['mail']= $query->result_array();
    $data['template'] = $dataw[0]['template'];
    $data['curn_info_default'] = $curn_info_default[0]['currency_name'];
    $data['currency'] = $currency_details;
    $sql='select * from invoice_content ';
    $query=$this->db->query($sql);
   $data['company_info']=(!empty($company_content)?$company_content:$company_info);
      $data['company_content']=(!empty($company_content)?$company_content:$company_info);
    $data['logo'] = $setting;
    $content = $this->load->view('pdf_attach_mail/profarma', $data, true);
  }
  /////////////////////packing//////////////////////////////////
  public function packing_with_attachment_stand($invoiceid)
  {
$sql='select c.* from user_login  u
    join 
    company_information c
    on c.company_id=u.cid
     where u.user_id='.$_SESSION['user_id'];
    $query=$this->db->query($sql);
    $data['company_info']=$query->result_array();
      $sql='select b.* from sale_packing_list_detail a join product_information b on a.product_id=b.product_id
 where a.expense_packing_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['product_info']=$query->result_array();
 $sql='select * from sale_packing_list_detail where expense_packing_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['invoice_details']=$query->result_array();
$sql='select * from sale_packing_list where expense_packing_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['invoice']=$query->result_array();
    $content = $this->load->view('pdf_attach_mail/packing', $data, true);
  } 
  public function packing_with_attachment_cus($invoiceid)
  {
    $CA = & get_instance();
    $CI = & get_instance();
    $CA->load->model('invoice_design');
    $dataw = $CA->invoice_design->retrieve_data($this->session->userdata('user_id'));
  $sql='select c.* from user_login  u
    join
    company_information c
    on c.company_id=u.cid
     where u.user_id='.$_SESSION['user_id'];
    $query=$this->db->query($sql);
    $data['company_info']=$query->result_array();
    $sql='select * from sale_packing_list_detail a join product_information b on a.product_id=b.product_id
      where a.expense_packing_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['product_info']=$query->result_array();
    $sql='select * from sale_packing_list_detail where expense_packing_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['invoice_details']=$query->result_array();
    $sql='select * from sale_packing_list where expense_packing_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['invoice']=$query->result_array();
    $sql='SELECT * FROM sale_packing_list s JOIN invoice i JOIN customer_information c on c.customer_id=i.customer_id where s.expense_packing_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['customer_info']=$query->result_array();
    $sql='select * from invoice_email where uid='.$_SESSION['user_id'];;
    $query=$this->db->query($sql);
    $data['mail']= $query->result_array();
    $data['template'] = $dataw[0]['template'];
    $content = $this->load->view('pdf_attach_mail/packing', $data, true);
  }
  /////////////////////Ocean//////////////////////////////////
  public function ocean_with_attachment_stand($invoiceid)
  {
    $sql='select c.* from user_login u join company_information c on c.company_id=u.cid where u.user_id='.$_SESSION['user_id'];
    $query=$this->db->query($sql);
    $data['company_info']=$query->result_array();
    $sql='SELECT b.* from ocean_export_tracking a JOIN supplier_information b on b.supplier_id=a.supplier_id WHERE a.ocean_export_tracking_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['supplier_info']=$query->result_array();
    $sql='select * from ocean_export_tracking where ocean_export_tracking_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['ocean']=$query->result_array();
    $content = $this->load->view('pdf_attach_mail/ocean', $data, true);
  }
  public function ocean_with_attachment_cus($invoiceid)
  {
    $CA = & get_instance();
    $CI = & get_instance();
    $CA->load->model('invoice_design');
    $CA->load->model('invoice_content');
    $CA->load->model('Invoices');
     $w = & get_instance();
        $w->load->model('Ppurchases');
        $getOceanAttach =  $CA->Invoices->retrieve_ocean($invoiceid);
     $dataw = $CA->invoice_design->proforma_data();
   $sql='select c.* from user_login  u join company_information c on c.company_id=u.cid where u.user_id='.$_SESSION['user_id'];
    $query=$this->db->query($sql);
   $sql='select b.* from ocean_export_tracking a join supplier_information b on b.supplier_id=a.supplier_id WHERE a.ocean_export_tracking_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['supplier_info']=$query->result_array();
   $sql='select * from ocean_export_tracking where ocean_export_tracking_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['ocean']=$query->result_array();
    // print_r($data['ocean']); die();
//    echo($data['ocean'][0]['consignee']); die();
    $customer_name = $CI->db->select('*')->from('customer_information')->where('customer_id', $data['ocean'][0]['consignee'])->get()->result_array();
    $data['customername']= $customer_name;
    $sql='SELECT c.* from ocean_export_tracking i JOIN supplier_information c on c.supplier_id=i.supplier_id WHERE i.ocean_export_tracking_id ='.$invoiceid ;
    $query=$this->db->query($sql);
    $data['customer_info']=$query->result_array();
      $setting=  $CI->Web_settings->retrieve_setting_editdata();
      $this->session->set_userdata('image_email', base_url().(!empty($setting[0]['invoice_logo'])?$setting[0]['invoice_logo']:$company_info[0]['logo']));
    $sql='select * from invoice_content ';
    $query=$this->db->query($sql);
    // $company_content
      $company_content= $CA->invoice_content->retrieve_info_data();
   $company_info = $w->Ppurchases->retrieve_company();
     $data['company_info']=(!empty($company_content)?$company_content:$company_info);
      $data['company_content']=(!empty($company_content)?$company_content:$company_info);
 $this->session->set_userdata('image_email', base_url().(!empty($setting[0]['invoice_logo'])?$setting[0]['invoice_logo']:$company_info[0]['logo']));
   $sql='select * from invoice_email where uid='.$_SESSION['user_id'];;
    $query=$this->db->query($sql);
    $data['mail']= $query->result_array();
    $data['template'] = $dataw[0]['template'];
     $data['head']=$dataw;
         $data['logo'] = $setting;
         $data['ocean_attach'] = $getOceanAttach;
    $content = $this->load->view('pdf_attach_mail/ocean_export', $data, true);
}
  /////////////////////Trucking//////////////////////////////////
  public function trucking_with_attachment_stand($invoiceid)
  {
$sql='select c.* from user_login  u
    join 
    company_information c
    on c.company_id=u.cid
     where u.user_id='.$_SESSION['user_id'];
    $query=$this->db->query($sql);
    $data['company_info']=$query->result_array();
     $sql=' SELECT b.* FROM `sale_trucking` a join customer_information b on b.customer_id=a.bill_to where trucking_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['customer_info']=$query->result_array();  
  $sql='select * from sale_trucking_details where sale_trucking_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['sale_trucking_details']=$query->result_array();
$sql='select * from sale_trucking where trucking_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['sale_trucking']=$query->result_array();
    $sql='select * from sale_trucking_details where sale_trucking_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['sale_trucking_details']=$query->result_array();
$sql='select * from sale_trucking where trucking_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['sale_trucking']=$query->result_array();
$content = $this->load->view('pdf_attach_mail/trucking', $data, true);
  }
 public function trucking_with_attachment_cus($invoiceid)
  {
    $CA = & get_instance();
    $CI = & get_instance();
    $CA->load->model('invoice_design');
    $CI->load->model('Web_settings');
         $CI->load->model('invoice_content');
         $CI->load->model('Invoices');
          $w = & get_instance();
        $w->load->model('Ppurchases');
            $dataw = $CA->invoice_design->retrieve_data();
            $getTrucking =  $CI->Invoices->retrieve_trucking($invoiceid);
    $currency_details = $CI->Web_settings->retrieve_setting_editdata();
    $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
    $sql='select c.* from user_login  u
    join
    company_information c
    on c.company_id=u.cid
     where u.user_id='.$_SESSION['user_id'];
    $query=$this->db->query($sql);
    // echo $sql;
   $company_content= $CI->invoice_content->retrieve_info_data();
     $company_info = $w->Ppurchases->retrieve_company();
    $data['head']=$dataw;
   $data['company_info']=(!empty($company_content)?$company_content:$company_info);
      $data['company_content']=(!empty($company_content)?$company_content:$company_info);
     $this->session->set_userdata('image_email', base_url().$data['company_info'][0]['logo']);
    //  echo $data['company_info'][0]['logo'];  die();
   $sql=' SELECT * FROM `sale_trucking` a join customer_information b on b.customer_id=a.bill_to where trucking_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['customer_info']=$query->result_array();
   $sql='select * from sale_trucking_details where sale_trucking_id='.$invoiceid;
    $query=$this->db->query($sql);
    $data['sale_trucking_details']=$query->result_array();
    // print_r($data['sale_trucking_details']);
    $sql='select * from sale_trucking where trucking_id='.$invoiceid;
    $query=$this->db->query($sql);
      $setting=  $CI->Web_settings->retrieve_setting_editdata();
      $this->session->set_userdata('image_email', base_url().(!empty($setting[0]['invoice_logo'])?$setting[0]['invoice_logo']:$company_info[0]['logo']));
    $data['sale_trucking']=$query->result_array();
    $sql='select * from invoice_email where uid='.$_SESSION['user_id'];;
    $query=$this->db->query($sql);
    $data['mail']= $query->result_array();
    $data['template'] = $dataw[0]['template'];
    $data['curn_info_default'] = $curn_info_default[0]['currency_name'];
    $data['currency'] = $currency_details;
    // image_email
    $sql='select * from invoice_content ';
    $query=$this->db->query($sql);
    // $company_content
        $data['logo'] = $setting;
        $data['trucking'] = $getTrucking;
$content = $this->load->view('pdf_attach_mail/trucking', $data, true);
  }
// Quotation Index Page - Madhu
public function getQuotationData() 
{   
    $this->auth->check_admin_auth();
    $encodedId     = isset($_GET["id"]) ? $_GET["id"] : null;
    $decodedId     = decodeBase64UrlParameter($encodedId);
    $limit         = $this->input->post("length");
    $start         = $this->input->post("start");
    $search        = $this->input->post("search")["value"];
    $orderField    = $this->input->post("columns")[$this->input->post("order")[0]["column"]]["data"];
    $orderDirection = $this->input->post("order")[0]["dir"];
    $date           = $this->input->post("date");
    $items          = $this->Invoices->getPaginatedQuotation($limit,$start,$orderField,$orderDirection,$search,$decodedId,$date);
    $totalItems     = $this->Invoices->getTotalQuotation($search, $decodedId, $date);
    $data          = [];
    $i             = $start + 1;
    $edit          = "";
    $delete        = "";
    foreach ($items as $item) {
        $download =
        '<a href="' . base_url("Cinvoice/downloadQuotation?id=" . $encodedId . "&quotation_id=" . $item["purchase_id"]) .
            '" class="btnclr btn btn-sm" style="background-color:#424f5c; margin-right: 5px;"><i class="fa fa-download" aria-hidden="true"></i></a>';
        $mail =
        '<a data-toggle="modal" data-target="#sendemailmodal" onClick=sendEmailproforma('.$item["purchase_id"].') class="btnclr btn btn-sm" style="background-color:#424f5c; margin-right: 5px;"><i class="fa fa-envelope" aria-hidden="true"></i></a>';
        $edit =
        '<a href="' . base_url("Cinvoice/profarma_invoice_update_form?id=" . $encodedId . "&quotation_id=" . $item["purchase_id"]) .
            '" class="btnclr btn btn-sm" style="background-color:#424f5c; margin-right: 5px;"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
        $delete = '<a onClick=deleteProformadata('.$item["purchase_id"].') class="btnclr btn btn-sm" style="background-color:#424f5c; margin-right: 5px;"><i class="fa fa-trash" aria-hidden="true"></i></a>';
        $row = [
            'id'              => $i,
            "purchase_id"     => $item["purchase_id"],
            "pre_carriage"    => $item["pre_carriage"],
            "country_goods"   => $item["country_goods"],
            "country_destination"   => $item["country_destination"],
            "loading"            => $item["loading"],
            "discharge"           => $item["discharge"],
            "terms_payment"   => $item["terms_payment"],
            "description_goods"         => $item["description_goods"],
            "total_gross"      => $item["total_gross"],
            "amt_paid"      => $item["amt_paid"],
            "bal_amt"      => $item["bal_amt"],
            "total"      => $item["total"],
            "purchase_date"      => $item["purchase_date"],
            "customer_name"      => $item["customer_name"],
            "tax_details"      => $item["tax_details"],
            "gtotal"      => $item["gtotal"],
            "action"          => $download . $mail . $edit . $delete,
        ];
        $data[] = $row;
        $i++;
    }
    $response = [
        "draw"            => $this->input->post("draw"),
        "recordsTotal"    => $totalItems,
        "recordsFiltered" => $totalItems,
        "data"            => $data,
    ];
    echo json_encode($response);
}
// Trucking Index Page - Madhu
public function getTruckingData() 
{   
    $CI = & get_instance();
    $CI->auth->check_admin_auth();
    $CI->load->model('Invoices');
    $encodedId     = isset($_GET["id"]) ? $_GET["id"] : null;
    $decodedId     = decodeBase64UrlParameter($encodedId);
    $limit         = $this->input->post("length");
    $start         = $this->input->post("start");
    $search        = $this->input->post("search")["value"];
    $orderField    = $this->input->post("columns")[$this->input->post("order")[0]["column"]]["data"];
    $orderDirection = $this->input->post("order")[0]["dir"];
    $items          = $this->Invoices->getPaginatedTrucking($limit,$start,$orderField,$orderDirection,$search,$decodedId);
    $totalItems     = $this->Invoices->getTotalTrucking($search, $decodedId);
    $data          = [];
    $i             = $start + 1;
    $edit          = "";
    $delete        = "";
    foreach ($items as $item) {
        $download =
        '<a href="' . base_url("Cinvoice/downloadQuotation?id=" . $encodedId . "&quotation_id=" . $item["purchase_id"]) .
            '" class="btnclr btn btn-sm" style="background-color:#424f5c; margin-right: 5px;"><i class="fa fa-download" aria-hidden="true"></i></a>';
        $mail =
        '<a data-toggle="modal" data-target="#sendemailmodal" onClick=sendEmailproforma('.$item["purchase_id"].') class="btnclr btn btn-sm" style="background-color:#424f5c; margin-right: 5px;"><i class="fa fa-envelope" aria-hidden="true"></i></a>';
        $edit =
        '<a href="' . base_url("Cinvoice/profarma_invoice_update_form?id=" . $encodedId . "&quotation_id=" . $item["purchase_id"]) .
            '" class="btnclr btn btn-sm" style="background-color:#424f5c; margin-right: 5px;"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
        $delete = '<a onClick=deleteProformadata('.$item["purchase_id"].') class="btnclr btn btn-sm" style="background-color:#424f5c; margin-right: 5px;"><i class="fa fa-trash" aria-hidden="true"></i></a>';
        $row = [
            'id'              => $i,
            "trucking_id"     => $item["trucking_id"],
            "invoice_no"    => $item["invoice_no"],
            "invoice_date"   => $item["invoice_date"],
            "bill_to"   => $item["bill_to"],
            "shipment_company" => $item["shipment_company"],
            "delivery_date"           => $item["delivery_date"],
            "delivery_time_from"   => $item["delivery_time_from"],
            "delivery_time_to"   => $item["delivery_time_to"],
            "delivery_to"   => $item["delivery_to"],
            "tax"   => $item["tax"],
            "total_amt"   => $item["total_amt"],
            "amt_paid"   => $item["amt_paid"],
            "balance"   => $item["balance"],
            "remarks"   => $item["remarks"],
            "action"          => $download . $mail . $edit . $delete,
        ];
        $data[] = $row;
        $i++;
    }
    $response = [
        "draw"            => $this->input->post("draw"),
        "recordsTotal"    => $totalItems,
        "recordsFiltered" => $totalItems,
        "data"            => $data,
    ];
    echo json_encode($response);
}
// Common Email Function - Madhu
private function sendEmail($data)
{   
    $this->load->library('email');
    $config = array(
        'protocol' => 'smtp',
        'smtp_host' => 'mail.amoriotech.com',
        'smtp_port' => 465,
        'smtp_user' => 'sales@amoriotech.com',
        'smtp_pass' => 'Amorio@2022',
        'smtp_crypto' => 'ssl',
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'newline' => "\r\n"
    );
    $this->email->initialize($config);
    $this->email->from('sales@amoriotech.com', 'Stockeai');
    $this->email->to($data['to']);
    $this->email->cc($data['cc']);
    $this->email->subject($data['subject']);
    $this->email->message($data['message']);
    if ($this->email->send()) {
        return true;
    } else {
        return false; 
    }
}
// Download Quotation 
public function downloadQuotation()
{
    $admin_comp_id = decodeBase64UrlParameter($this->input->get('id'));
    $quotationId = $this->input->get('quotation_id');
    $data = array(
        'title' => 'Proforma Invoice',
        'quotation_id' => $quotationId
    );
    $content = $this->load->view('invoice/profarma_invoice_html', $data, true);
    $dompdf = new Dompdf();
    $dompdf->loadHtml($content);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream('proforma_invoice_' . $quotationId . '.pdf', array('Attachment' => 1));
}

}
