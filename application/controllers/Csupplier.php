<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Csupplier extends CI_Controller {

    public $supplier_id;

    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->library('auth');
        $this->load->library('lsupplier');
        $this->load->library('session');
        $this->load->model('Suppliers');
        $this->auth->check_admin_auth();
        $encodedId = isset($_GET['id']) ? $_GET['id'] : '';
        $this->admin_id   = decodeBase64UrlParameter($encodedId);
    }
    public function add_payment_terms(){
        $this->load->model('Suppliers');
        $postData = $this->input->post('new_payment_type');
        //  echo $postData;
        $data = $this->Suppliers->add_payment_terms($postData);
        echo json_encode($data);
    }
    public function index() {
        $content = $this->lsupplier->supplier_add_form();
        $this->template->full_admin_html_view($content);
    }

   


       
    public function insert_supplier() {
      
        $this->auth->check_admin_auth();
        $admin_comp_id = decodeBase64UrlParameter($this->input->post('admin_company_id'));
        $response = array();
        if($admin_comp_id==""){
            $response['status'] = 'failure';
            $response['msg'] = 'Invalid Details';
        }else{
            $this->form_validation->set_rules('sup_vendor_type', 'Vendor Type', 'trim|required');
            $this->form_validation->set_rules('ven_supplier_name', 'Company Name', 'trim|required');
            $this->form_validation->set_rules('ven_phone', 'Business Phone', 'trim|required');
            $this->form_validation->set_rules('ven_email', 'Primary Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('ven_service_provider', 'Tax Collected', 'required');
            $this->form_validation->set_rules('ven_currency', 'Preferred Currency', 'required');
            $this->form_validation->set_rules('ven_country', 'Country', 'required');
            $this->form_validation->set_rules('ven_terms', 'Payment terms', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                $response['status'] = 'failure';
                $response['msg'] = validation_errors();
            } else {
                $supplier_name  = $this->input->post('ven_supplier_name');
                $data = array(
                    'vendor_type'       => $this->input->post('sup_vendor_type',TRUE),
                    'supplier_name'     => $this->input->post('ven_supplier_name',TRUE),
                    'address'           => $this->input->post('ven_address',TRUE),
                    'mobile'            => $this->input->post('ven_mobile',TRUE),
                    'businessphone'     => $this->input->post('ven_phone',TRUE),
                    'contactperson'     => $this->input->post('ven_contact',TRUE),
                    'primaryemail'      => $this->input->post('ven_email',TRUE),
                    'secondaryemail'    => $this->input->post('ven_emailaddress',TRUE),
                    'taxcollected'      => $this->input->post('ven_service_provider',TRUE),
                    'credit_limit'      => $this->input->post('ven_previous_balance',TRUE),
                    'previous_balance'  => $this->input->post('ven_p_b',TRUE),
                    'fax'               => $this->input->post('ven_fax',TRUE),
                    'city'              => $this->input->post('ven_city',TRUE),
                    'state'             => $this->input->post('ven_state',TRUE),
                    'currency_type'     => $this->input->post('ven_currency',TRUE),
                    'zip'               => $this->input->post('ven_zip',TRUE),
                    'country'           => $this->input->post('ven_country',TRUE),
                    'details'           => $this->input->post('ven_details',TRUE),
                    'paymentterms'      => $this->input->post('payment_terms',TRUE),
                    'status'            => 1,
                    'created_date'      => date('Y-m-d H:i:s'),
                    'created_by'        => $admin_comp_id
                );
            
                $supplier_id =$this->Suppliers->insert_supplier($data);
                    //file upload
                if($supplier_id && $_FILES['ven_attachments']['name'] !=""){
                    $upload_data = file_upload('ven_attachments','supplier',SUPPLIER_IMG_PATH);
                    if($upload_data['upload_data']['file_name'] !=""){
                        $update_data = array('attachments'=>$upload_data['upload_data']['file_name']);
                        $res = $this->Suppliers->update_supplier($update_data,$supplier_id);
                        $response = array(
                            'status' =>'success',
                            'msg'    => 'Supplier has been inserted successfully.',
                            'result' => array('name' => $supplier_name, 'id' =>$admin_comp_id),
                        );
                    }
                }else{
                       $response = array(
                            'status' =>'success',
                            'msg'    => 'Supplier has been inserted successfully',
                            'result' => array('currency_type' => $this->input->post('ven_currency',TRUE),'supplier_id' => $supplier_id,'name' => $supplier_name, 'id' =>$admin_comp_id,'vendor_type' => $this->input->post('sup_vendor_type',TRUE),'vendor_add' => $this->input->post('ven_address',TRUE)),
                        );
                }
            }
        }
        echo json_encode($response);
    }
       
    public function manage_supplier() {
        $this->auth->check_admin_auth();
        $content =$this->lsupplier->supplier_list($this->admin_id);
        $this->template->full_admin_html_view($content);
    }

    
    //Supplier Update Form
    public function supplier_update_form($supplier_id) {
        $content = $this->lsupplier->supplier_edit_data($supplier_id);

        $this->template->full_admin_html_view($content);
    }

    // Supplier Update
    public function supplier_update() {
        $this->auth->check_admin_auth();
        $admin_comp_id = decodeBase64UrlParameter($this->input->post('admin_company_id'));
        $supplier_id   = $this->input->post('supplier_id');
        $supplier_detail = $this->Suppliers->retrieve_supplier_editdata($supplier_id);
        //print_r($supplier_detail); exit;
        $response = array();
        if($admin_comp_id=="" || $supplier_id ==""){
            $response['status'] = 'failure';
            $response['msg'] = 'Invalid Details';
        }else{
            $this->form_validation->set_rules('sup_vendor_type', 'Vendor Type', 'trim|required');
            $this->form_validation->set_rules('ven_supplier_name', 'Company Name', 'trim|required');
            $this->form_validation->set_rules('ven_phone', 'Business Phone', 'trim|required');
            $this->form_validation->set_rules('ven_email', 'Primary Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('ven_service_provider', 'Tax Collected', 'required');
            $this->form_validation->set_rules('ven_currency', 'Preferred Currency', 'required');
            $this->form_validation->set_rules('ven_country', 'Country', 'required');
            $this->form_validation->set_rules('payment_terms', 'Payment terms', 'required');
       
            $update_datas = array(
                'supplier_name' => $this->input->post('ven_supplier_name',TRUE),
                'address'       => $this->input->post('ven_address',TRUE),
                'mobile'        => $this->input->post('ven_mobile',TRUE),
                'businessphone' => $this->input->post('ven_phone',TRUE),
                'contactperson' => $this->input->post('ven_contact',TRUE),
                'primaryemail'   => $this->input->post('ven_email',TRUE),
                'secondaryemail' => $this->input->post('ven_emailaddress',TRUE),
                'fax'           => $this->input->post('ven_fax',TRUE),
                'city'          => $this->input->post('ven_city',TRUE),
                'state'         => $this->input->post('ven_state',TRUE),
                'zip'           => $this->input->post('ven_zip',TRUE),
                'country'       => $this->input->post('ven_country',TRUE),
                'details'       => $this->input->post('ven_details',TRUE),
                'currency_type' => $this->input->post('ven_currency',TRUE),
                'vendor_type'   => $this->input->post('sup_vendor_type',TRUE),
                'modified_by'   => $admin_comp_id,
                'taxcollected'  => $this->input->post('ven_service_provider',TRUE),
                'credit_limit'  => $this->input->post('ven_previous_balance',TRUE),
                'previous_balance'  => $this->input->post('ven_p_b',TRUE),
             );
            // print_r($data); exit;
            $result = $this->Suppliers->update_supplier($update_datas, $supplier_id);
           // echo $this->db->last_query();
            if ($result == TRUE) {
                if($supplier_id && $_FILES['ven_attachments']['name'] !=""){
                    $upload_data = file_upload('ven_attachments','supplier',SUPPLIER_IMG_PATH);
                    if($upload_data['upload_data']['file_name'] !=""){
                        $update_data = array('attachments'=>$upload_data['upload_data']['file_name']);
                        $res = $this->Suppliers->update_supplier($update_data,$supplier_id);
                        //unlink previous image
                        if($supplier_detail[0]['attachments'] !=""){
                            if(file_exists(SUPPLIER_IMG_PATH.$supplier_detail[0]['attachments'])){
                                unlink(SUPPLIER_IMG_PATH.$supplier_detail[0]['attachments']);
                            }
                        }
                        
                        $response = array(
                            'status' =>'success',
                            'msg'    => 'Supplier has been updated successfully.'
                        );
                    }else{
                        $response = array(
                            'status' =>'error',
                            'msg'    => $update_data['error']
                        );
                    }
                }else{
                    $response = array(
                        'status' =>'success',
                        'msg'    => 'Supplier has been updated successfully.'
                    );
                }
            }
            echo json_encode($response);
        }
    }

  

    // Supplier Delete from System
    public function supplier_delete() {
        $supplier_id = $this->input->post('id');
        $invoiceinfo = $this->db->select('*')->from('product_purchase')->where('supplier_id',$supplier_id)->get()->num_rows();
        if($invoiceinfo > 0){
            $response = array(
                'status'=>'failure',
                'msg'   => 'Sorry !! You can not delete this Supplier.This Supplier already Engaged in calculation system!'
            );
        }else{
            $up_data = array('is_deleted'=>1);
            $this->Suppliers->update_supplier($up_data, $supplier_id);
            $response = array(
                'status'=>'success',
                'msg'   => 'Supplier has been deleted successfully!'
            );
        }
        echo json_encode($response);
    }


    public function supplier_details($supplier_id) {
        $content = $this->lsupplier->supplier_detail_data($supplier_id);
        $this->supplier_id = $supplier_id;
        $this->template->full_admin_html_view($content);
    }

    //Supplier Ledger Book
   public function supplier_ledger() {
    $date = $this->input->post('daterangepicker-field',TRUE);
     $explode=explode(" to ",$date);
     $start=$explode[0];
     $end=$explode[1];

        $supplier_id = $this->input->post('supplier_id',TRUE);
        $page = $this->input->post('seg_3',TRUE);
        //  $pro_sup=$this->uri->segment(3);
        $pro_sup= str_replace('_', ' ', $page);
        $sup_id = $this->input->post('seg_4',TRUE);
        $sup_id=   str_replace("%20"," ",$sup_id);

        $content = $this->lsupplier->supplier_ledger($sup_id, $start,$end ,$pro_sup,$date);

        $this->template->full_admin_html_view($content);
    }

 public function supplier_ledger_report() {
        $config["base_url"] = base_url('Csupplier/supplier_ledger_report/');
        $config["total_rows"] = $this->Suppliers->count_supplier_product_info();
        $config["per_page"] = 100;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $sup_id = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
       // echo $page;die();
        $links = $this->pagination->create_links();
        
                     $pro_sup= str_replace('_', ' ', $page);
        $content = $this->lsupplier->supplier_ledger_report($links, $config["per_page"], $pro_sup,$sup_id);
        $this->template->full_admin_html_view($content);
    }

    // Supplier wise sales report details
    public function supplier_sales_details() {
        $start = $this->input->post('from_date',TRUE);
        $end = $this->input->post('to_date',TRUE);
        $supplier_id = $this->uri->segment(3);

        $content = $this->lsupplier->supplier_sales_details($supplier_id, $start, $end);
        $this->template->full_admin_html_view($content);
    }




    // search report 
    public function search_supplier_report() {
        $start = $this->input->post('from_date',TRUE);
        $end = $this->input->post('to_date',TRUE);

        $content = $this->lpayment->result_datewise_data($start, $end);
        $this->template->full_admin_html_view($content);
    }

    //Vendor Sales Details - Inside Vendor Create Page
    public function supplier_sales_details_all() {
        $id = decodeBase64UrlParameter($_GET['id']);
       $this->load->model('Web_settings');
       $data['id']=$id;
       $data['setting_detail'] = $this->Web_settings->retrieve_setting_editdata();
        $content                = $this->load->view('supplier/supplier_sales_details', $data, true);
        $this->template->full_admin_html_view($content);
    }
    //Vendor Sales Details - Index Page
  public function getProductDatas() {
        $encodedId     = isset($_GET["id"]) ? $_GET["id"] : null;
        $decodedId     = decodeBase64UrlParameter($encodedId);
        $limit         = $this->input->post("length");
        $start         = $this->input->post("start");
        $search        = $this->input->post("search")["value"];
        $orderField    = $this->input->post("columns")[
            $this->input->post("order")[0]["column"]
        ]["data"];
        $orderDirection = $this->input->post("order")[0]["dir"];
        $totalItems     = $this->Products->getTotalProducts($search, $decodedId);
        $items          = $this->Products->getPaginatedProducts(
            $limit,
            $start,
            $orderField,
            $orderDirection,
            $search,
            $decodedId
        );
        $sales_count   = $this->Products->sales_product_all();
        $expense_count = $this->Products->expense_product_all();
        $data          = [];
        $i             = $start + 1;
        $edit          = "";
        $delete        = "";
        foreach ($items as $item) {
            $total    = $item["p_quantity"];
            $sale_sum = false;
            $ex_sum   = false;
            if ($sales_count) {
                foreach ($sales_count as $sale) {
                    if ($item["product_id"] == $sale["product_id"]) {
                        $total -= $sale["available"];
                        $sale_sum = true;
                    }
                }
            }
            if ($expense_count) {
                foreach ($expense_count as $expense) {
                    if ($item["product_id"] == $expense["product_id"]) {
                        $total += $expense["available"];
                        $ex_sum = true;
                    }
                }
            }
            if ($ex_sum && $sale_sum) {
                $total =
                    $item["p_quantity"] -
                    $sale["available"] +
                    $expense["available"];
            }
            $edit =
            '<a href="' . base_url("Cproduct/product_update_form?id=" . $encodedId . "&product_id=" . $item["product_id"]) .
                '" class="btnclr btn btn-sm" style="background-color:#424f5c; margin-right: 5px;"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            $delete =
            '<a onclick="return confirm(' . display("are_you_sure") . ')" href="' . base_url("Cproduct/product_delete_form?id=" .
                $encodedId . "&product_id=" . $item["product_id"]) .
                '" class="btnclr btn btn-sm" style="background-color:#424f5c; margin-right: 5px;"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            $product_name =
            '<a href="' . base_url("Cproduct/product_view?id=" . $encodedId . "&product_id=" . $item["product_id"]) . '">' .
                $item["product_name"] .
                "</a>";
            $row = [
                "product_name"  => $product_name,
                "product_model" => $item["product_model"],
                "product_id"    => $item["product_id"],
                "inventry"      => $total,
                "category_name" => $item["category_name"],
                "unit"          => $item["unit"],
                "price"         => $item["price"],
                "supplier_name" => $item["supplier_name"],
                "country"       => $item["country"],
                "p_quantity"    => $item["p_quantity"],
                "action"        => $edit . $delete,
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


       

    // supplier ledger for supplier information 
    public function supplier_ledger_info($supplier_id) {
        $content = $this->lsupplier->supplier_ledger_info($supplier_id);
        $this->supplier_id = $supplier_id;
        $this->template->full_admin_html_view($content);
    }
// ============================= CSV SUPPLIER UPLOAD  ======================================
        //CSV Manufacturer Add From here
    function uploadCsv_Supplier()
    {
        $filename = $_FILES['upload_csv_file']['name'];
        
      //  $ext = end(explode('.', $filename));
        // $tmp = explode('.', $filename);
        //  $ext = end($tmp);
        $ext = substr(strrchr($filename, '.'), 1);
        if($ext == 'csv'){
        $count=0;
        $fp = fopen($_FILES['upload_csv_file']['tmp_name'],'r') or die("can't open file");

        if (($handle = fopen($_FILES['upload_csv_file']['tmp_name'], 'r')) !== FALSE)
        {
  
         while($csv_line = fgetcsv($fp,1024)){
                //keep this if condition if you want to remove the first row
                for($i = 0, $j = count($csv_line); $i < $j; $i++)
                {             
                    $insert_csv = array();
                    $insert_csv['Vendor Name'] = (!empty($csv_line[0])?$csv_line[0]:null);
                    $insert_csv['Mobile Number'] = (!empty($csv_line[3])?$csv_line[3]:'');
                    $insert_csv['Business Phone Number'] = (!empty($csv_line[3])?$csv_line[3]:'');
                    $insert_csv['Primary Email'] = (!empty($csv_line[1])?$csv_line[1]:'');
                    $insert_csv['Secondary Email'] = (!empty($csv_line[2])?$csv_line[2]:'');
                    $insert_csv['Contact'] = (!empty($csv_line[4])?$csv_line[4]:'');
                    $insert_csv['Fax'] = (!empty($csv_line[5])?$csv_line[5]:'');
                    $insert_csv['City'] = (!empty($csv_line[7])?$csv_line[7]:'');
                    $insert_csv['Address1'] = (!empty($csv_line[11])?$csv_line[11]:'');
                    $insert_csv['State'] = (!empty($csv_line[8])?$csv_line[8]:'');
                    $insert_csv['Zipcode'] = (!empty($csv_line[9])?$csv_line[9]:'');
                    $insert_csv['details'] = (!empty($csv_line[11])?$csv_line[11]:'');
                    $insert_csv['Previous Balance'] = (!empty($csv_line[13])?$csv_line[13]:'');
                        $insert_csv['Credit Limit'] = (!empty($csv_line[14])?$csv_line[14]:'');
                        $insert_csv['Country'] = (!empty($csv_line[10])?$csv_line[10]:'');
                    $insert_csv['terms'] = '';
                }
                $depid = date('Ymdis');
                $supplierdata = array(  
                    'created_by'       =>  $this->session->userdata('user_id'),
                    'supplier_name'  => $insert_csv['Vendor Name'],
                    'mobile'        => $insert_csv['Mobile Number'],
                    'primaryemail'      =>  $insert_csv['Primary Email'],
                    'secondaryemail'        =>  $insert_csv['Secondary Email'],
                    'contactperson'         =>  $insert_csv['Business Phone Number'],
                    'businessphone'       => $insert_csv['Contact'],
                    'fax'   =>  $insert_csv['Fax'],
                    'city' => $insert_csv['City'],
                    'state'           => $insert_csv['State'],
                    'zip'          => $insert_csv['Zipcode'],
                    'address'           => $insert_csv['details'],
                    'paymentterms'       => $insert_csv['terms'],
                    'previous_balance'       => $insert_csv['Previous Balance'],
                    'credit_limit'       => $insert_csv['Credit Limit'],
                    'country'       => $insert_csv['Country'],
                    'status'        => 1
                );
             //   print_r($supplierdata);die();

                if ($count > 0) {
                    $this->db->insert('supplier_information',$supplierdata);

                    $supplier_id    = $this->db->insert_id();
                    $transaction_id = $this->auth->generator(10);


                    $coa = $this->Suppliers->headcode();
                    if($coa->HeadCode!=NULL){
                        $headcode=$coa->HeadCode+1;
                    }
                    else{
                        $headcode="5020001";
                    }
                    $c_acc=$supplier_id.'-'.$insert_csv['supplier_name'];
                    $createby=$this->session->userdata('user_id');
                    $createdate=date('Y-m-d H:i:s');

                    $supplier_coa = [
                        'HeadCode'       => $headcode,
                        'HeadName'         => $c_acc,
                        'PHeadName'        => 'Account Payable',
                        'HeadLevel'        => '3',
                        'IsActive'         => '1',
                        'IsTransaction'    => '1',
                        'IsGL'             => '0',
                        'HeadType'         => 'L',
                        'IsBudget'         => '0',
                        'IsDepreciation'   => '0',
                        'supplier_id'      => $supplier_id,
                        'DepreciationRate' => '0',
                        'CreateBy'         => $createby,
                        'CreateDate'       => $createdate,
                    ];

                    $this->db->insert('acc_coa', $supplier_coa);
                    $headcode = $this->db->select('HeadCode')->from('acc_coa')->where('supplier_id',$supplier_id)->get()->row();

                    $previous = array(
                    'VNo'            =>  $transaction_id,
                    'Vtype'          =>  'Previous',
                    'VDate'          =>  date('Y-m-d'),
                    'COAID'          =>  $headcode->HeadCode,
                    'Narration'      =>  'Previous Balane For New Supplier',
                    'Debit'          =>  0,
                    'Credit'         =>  $insert_csv['previous_balance'],
                    'IsPosted'       =>  1,
                    'CreateBy'       =>  $this->session->userdata('user_id'),
                    'CreateDate'     =>  date('Y-m-d H:i:s'),
                    'IsAppove'       =>  1
                    ); 
                    
                    if($insert_csv['previous_balance'] > 0){
                        $this->db->insert('acc_transaction', $previous);
                    }
                }  
                $count++; 
            }
            
        }
            $this->db->select('*');
            $this->db->from('supplier_information');
            $this->db->where('status',1);
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $json_supplier[] = array('label'=>$row->supplier_name,'value'=>$row->supplier_id);
            }
            $cache_file = './my-assets/js/admin_js/json/supplier.json';
            $supplierlist = json_encode($json_supplier);
            file_put_contents($cache_file,$supplierlist);
            fclose($fp) or die("can't close file");
            $this->session->set_userdata(array('message'=>display('successfully_added')));
            redirect(base_url('Csupplier/manage_supplier'));
        }else{
            $this->session->set_userdata(array('error_message'=>'Please Import Only Csv File'));
            redirect(base_url('Csupplier/manage_supplier'));
        }
    
    }
     public function supplier_list() {

        $CI =& get_instance();

        $CI->load->model('Suppliers');

        $CI->load->model('Web_settings');
        $vendor = $CI->Suppliers->suppliers_list();
        $setting_detail = $CI->Web_settings->retrieve_setting_editdata();

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data['currency']          = $currency_details[0]['currency'];
        $data['total_supplier']    = $CI->Suppliers->count_supplier();

       
        $data['vendor_data']=$vendor;
                $data['setting_detail']=$setting_detail;

        $data['company_info']      = $CI->Suppliers->retrieve_company();


        $data['getsupplier']      = $CI->Suppliers->get_all_supplier();


              $content = $CI->parser->parse('report/vendor_info_report', $data, true);
        $this->template->full_admin_html_view($content);

    }
   
    public function supplier_advance(){
        $data['title'] = display('supplier_advance');
        $data['supplier_list'] = $this->Suppliers->supplier_list_advance();
        $content = $this->parser->parse('supplier/supplier_advance', $data, true);
        $this->template->full_admin_html_view($content); 
    }
    public function insert_supplier_advance(){
        $advance_type = $this->input->post('type',TRUE);
        if($advance_type ==1){
            $dr = $this->input->post('amount',TRUE);
            $tp = 'd';
        }else{
            $cr = $this->input->post('amount',TRUE);
            $tp = 'c';
        }
    
        $createby=$this->session->userdata('user_id');
        $createdate=date('Y-m-d H:i:s');
        $transaction_id=$this->auth->generator(10);
        $supplier_id = $this->input->post('supplier_id',TRUE);
        $supifo = $this->db->select('*')->from('supplier_information')->where('supplier_id',$supplier_id)->get()->row();
        $headn = $supplier_id.'-'.$supifo->supplier_name;
        $coainfo = $this->db->select('*')->from('acc_coa')->where('HeadName',$headn)->get()->row();
        $supplier_headcode = $coainfo->HeadCode;
        $supplier_accledger = array(
            'VNo'            =>  $transaction_id,
            'Vtype'          =>  'Advance',
            'VDate'          =>  date("Y-m-d"),
            'COAID'          =>  $supplier_headcode,
            'Narration'      =>  'supplier Advance For '.$supifo->supplier_name,
            'Debit'          =>  (!empty($dr)?$dr:0),
            'Credit'         =>  (!empty($cr)?$cr:0),
            'IsPosted'       => 1,
            'CreateBy'       => $this->session->userdata('user_id'),
            'CreateDate'     => date('Y-m-d H:i:s'),
            'IsAppove'       => 1
        );
        $cc = array(
            'VNo'            =>  $transaction_id,
            'Vtype'          =>  'Advance',
            'VDate'          =>  date("Y-m-d"),
            'COAID'          =>  1020101,
            'Narration'      =>  'Cash in Hand  For '.$supifo->supplier_name.' Advance',
            'Debit'          =>  (!empty($dr)?$dr:0),
            'Credit'         =>  (!empty($cr)?$cr:0),
            'IsPosted'       =>  1,
            'CreateBy'       =>  $this->session->userdata('user_id'),
            'CreateDate'     =>  date('Y-m-d H:i:s'),
            'IsAppove'       =>  1
        ); 
                   
        $this->db->insert('acc_transaction',$supplier_accledger);
        $this->db->insert('acc_transaction',$cc);
        redirect(base_url('Csupplier/supplier_advancercpt/'.$transaction_id.'/'.$supplier_id));

  }

    public function supplier_advancercpt($receiptid = null,$supplier_id = null) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lsupplier');
        $content = $CI->lsupplier->advance_details_data($receiptid,$supplier_id);
        $this->template->full_admin_html_view($content);
    }

    public function getVendorDatas() {
        $encodedId      = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId      = decodeBase64UrlParameter($encodedId);
        $limit          = $this->input->post('length');
        $start          = $this->input->post('start');
        $search         = $this->input->post('search')['value'];
        $orderField     = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'] =='sl' ? 'supplier_id' : $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
        $orderDirection = $this->input->post('order')[0]['dir'];
        $totalItems     = $this->Suppliers->getSupplierCount($search, $decodedId);
        $items          = $this->Suppliers->getSupplierList($limit, $start, $orderField, $orderDirection, $search, $decodedId);
        $data           = [];
        $sl             = $start + 1;
        $jsaction = "return confirm('Are You Sure ?')";
        foreach ($items as $record) {
            $button = '';
           //if($this->permission1->method('manage_supplier','update')->access()){
                $button .='<a href="'.base_url().'Csupplier/supplier_update_form/'.$record->supplier_id.'?id='.$encodedId.'" class="btnclr btn btn-xs"  data-placement="left" title="'. display('update').'"><i class="fa fa-edit"></i></a> ';
           // }
          // if($this->permission1->method('manage_supplier','delete')->access()){
                 $button .='<a href="#" onclick="deleteSupplier('.$record->supplier_id.')" class="btn btn-danger btn-xs" onclick="'.$jsaction.'" ><i class="fa fa-trash"></i></a>';
          // }
           
            $data[] = array( 
                'sl'               => $sl,
                'supplier_name'    => html_escape($record->supplier_name),
                'address'          => html_escape($record->address),
                'mobile'           => html_escape($record->mobile),
                'businessphone'    => html_escape($record->businessphone),
                'primaryemail'     => html_escape($record->primaryemail),
                'secondaryemail'   => html_escape($record->secondaryemail),
                'city'             => html_escape($record->city),
                'state'            => html_escape($record->state),
                'country'          => html_escape($record->country),
                'credit_limit'     => html_escape($record->credit_limit),
                'previous_balance' => html_escape($record->previous_balance),
                'vendor_type'      => html_escape($record->vendor_type),
                'contactperson'    => html_escape($record->contactperson),
                'fax'              => html_escape($record->fax),
                'taxcollected'     => html_escape($record->taxcollected),
                'zip'              => html_escape($record->zip),
                'details'          => html_escape($record->details),
                'currency_type'    => html_escape($record->currency_type),
                'paymentterms'     => html_escape($record->paymentterms),
                'button'           => $button
            );
                $sl++;
        }
        $response = [
            "draw"            => $this->input->post('draw'),
            "recordsTotal"    => $totalItems,
            "recordsFiltered" => $totalItems,
            "data"            => $data,
        ];
        echo json_encode($response);
    }
    //For Vendor Sales Details Index - From Vendor Create Page
     public function getVendorSalesDeatilsDatas() {
        $encodedId      = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId      = decodeBase64UrlParameter($encodedId);
        $limit          = $this->input->post('length');
        $start          = $this->input->post('start');
        $search         = $this->input->post('search')['value'];
        $orderField     = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'] =='sl' ? 'supplier_id' : $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
        $orderDirection = $this->input->post('order')[0]['dir'];
        $totalItems     = $this->Suppliers->getSupplierSalesCount($search, $decodedId);
        $items          = $this->Suppliers->getSupplierSalesList($limit, $start, $orderField, $orderDirection, $search, $decodedId);
        $data           = [];
        $sl             = $start + 1;
       foreach ($items as $record) {
            $data[] = array( 
                'sl'               => $sl,
                'date'    => html_escape($record->date),
                'address'          => html_escape($record->invoice),
                'mobile'           => html_escape($record->invoice_id),
                'businessphone'    => html_escape($record->product_name),
                'primaryemail'     => html_escape($record->product_model),
                'secondaryemail'   => html_escape($record->supplier_name),
                'city'             => html_escape($record->supplier_rate),
                'state'            => html_escape($record->total)
            );
                $sl++;
        }
        $response = [
            "draw"            => $this->input->post('draw'),
            "recordsTotal"    => $totalItems,
            "recordsFiltered" => $totalItems,
            "data"            => $data,
        ];
        echo json_encode($response);
    }
}
?>