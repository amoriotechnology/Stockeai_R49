<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Creport extends CI_Controller {

    function __construct() {
        parent::__construct(); 
        $this->db->query('SET SESSION sql_mode = ""');
        $CI = & get_instance();
        $CI->load->model('Web_settings');

        $this->load->model('Invoices');
        $this->load->model('Suppliers');

        $this->auth->check_admin_auth();
        $encodedId = $_GET['id'];
        $this->admin_id   = decodeBase64UrlParameter($encodedId);
    }

  public function index()
    {
       $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lreport');
       
        $content = $CI->lreport->stock_report_single_item();

        $this->template->full_admin_html_view($content); 
    }
    public function Users($id)
    {
        $this->load->model('User_mdel');
        echo json_encode($this->User_mdel->list());
    }
      public function supplier_wise_stock()
    {
       $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lreport');
       
        $content = $CI->lreport->stock_supplierwise();
        
        $this->template->full_admin_html_view($content); 
    }


    public function CheckList(){
        // GET data
        $this->load->model('Reports');
        $postData = $this->input->post();
        $data = $this->Reports->getCheckList($postData);
        echo json_encode($data);
    } 

    public function suppliestock(){
        $this->load->model('Reports');
        $postData = $this->input->post();
        $data = $this->Reports->getSupplierStockList($postData);
        echo json_encode($data);
    }

    public function out_of_stock() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lreport');

        $content = $CI->lreport->out_of_stock();

        $this->template->full_admin_html_view($content);
    }

    //Stock report supplir report
    public function product_stock(){
         $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lreport');
        $CI->load->model('Products');
        $content =$this->lreport->product_list();
        $this->template->full_admin_html_view($content);
    }
    public function stock_report_product_wise() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lreport');
        $CI->load->model('Reports');
        $today = date('Y-m-d');

        $product_id = $this->input->post('product_id',TRUE) ? $this->input->post('product_id',TRUE) : "";
        $supplier_id = $this->input->post('supplier_id',TRUE) ? $this->input->post('supplier_id',TRUE) : "";

        $date = $this->input->post('stock_date',TRUE) ? $this->input->post('stock_date',TRUE) : $today;
        $alldata = $this->input->post('all',TRUE);
        if(!empty($alldata)){
            $perpagdata = $this->Reports->product_counter_by_supplier($supplier_id);
        }else{
          $perpagdata = 50;  
        }
        #
        #pagination starts
        #
        $config["base_url"] = base_url('Creport/stock_report_product_wise/');
        $config["total_rows"] = $this->Reports->product_counter_by_supplier($supplier_id);
        $config["per_page"] = $perpagdata;
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
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  
        $content = $this->lreport->stock_report_supplier_wise($product_id, $supplier_id, $date, $links, $config["per_page"], $page);


        $this->template->full_admin_html_view($content);
    }

// date wise product report
    public function stock_date_to_date_product_wise() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lreport');
        $CI->load->model('Reports');
        $today = date('Y-m-d');
        $from_date = $this->input->get('from_date');
        $to_date = $this->input->get('to_date');
          $alldata = $this->input->get('all');
        if(!empty($alldata)){
            $perpagdata = $this->Reports->product_counter_by_productdatetodate($from_date, $to_date);
        }else{
          $perpagdata = 50;  
        }
        
        #exit;
        #pagination starts
        #
        $config["base_url"] = base_url('Creport/stock_date_to_date_product_wise/');
        $config["total_rows"] = $this->Reports->product_counter_by_productdatetodate($from_date, $to_date);
        $config["per_page"] = $perpagdata;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        $config['suffix'] = '?' . http_build_query($_GET, '', '&');
        $config['first_url'] = $config["base_url"] . $config['suffix'];
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
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  
        $content = $this->lreport->stock_report_product_date_date_wise($from_date, $to_date, $links, $config["per_page"], $page);


        $this->template->full_admin_html_view($content);
    }

    //Stock report supplir report
    public function stock_report_supplier_wise() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lreport');
        $CI->load->model('Reports');
        $today = date('Y-m-d');

        $product_id = $this->input->post('product_id',TRUE) ? $this->input->post('product_id',TRUE) : "";
        $supplier_id = $this->input->post('supplier_id',TRUE) ? $this->input->post('supplier_id',TRUE) : "";
        $from_date = $this->input->post('from_date',TRUE);
        $to_date = $this->input->post('to_date',TRUE);
         $alldata = $this->input->post('all',TRUE);
        if(!empty($alldata)){
            $perpagdata = $this->Reports->stock_report_product_bydate_count($supplier_id, $from_date, $to_date);
        }else{
          $perpagdata = 50;  
        }
        #
        #pagination starts
        #
        $config["base_url"] = base_url('Creport/stock_report_supplier_wise');
        $config["total_rows"] = $this->Reports->stock_report_product_bydate_count($supplier_id, $from_date, $to_date);

        $config["per_page"] = $perpagdata;
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
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  
        $content = $this->lreport->stock_report_product_wise($supplier_id, $from_date, $to_date, $links, $config["per_page"], $page);

        $this->template->full_admin_html_view($content);
    }

    //Get product by supplier
    public function get_product_by_supplier() {
        $supplier_id = $this->input->post('supplier_id',TRUE);

        $product_info_by_supplier = $this->db->select('a.*,b.*')
                ->from('product_information a')
                ->join('supplier_product b', 'a.product_id=b.product_id')
                ->where('b.supplier_id', $supplier_id)
                ->get()
                ->result();

        if ($product_info_by_supplier) {
            echo "<select class=\"form-control\" id=\"supplier_id\" name=\"supplier_id\">
	                <option value=\"\">" . display('select_one') . "</option>";
            foreach ($product_info_by_supplier as $product) {
                echo "<option value='" . $product->product_id . "'>" . $product->product_name . '-(' . $product->product_model . ')' . " </option>";
            }
            echo " </select>";
        }
    }

    #===============Report paggination=============#

    public function pagination($per_page, $page) {
        $CI = & get_instance();
        $CI->load->model('Reports');
        $product_id = $this->input->post('product_id',TRUE);

        $config = array();
        $config["base_url"] = base_url() . $page;
        $config["total_rows"] = $this->Reports->product_counter($product_id);
        $config["per_page"] = $per_page;
        $config["uri_segment"] = 4;
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



        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $limit = $config["per_page"];
        return $links = $this->pagination->create_links();
    }
    
     //pdf stock report
          public function stock_report_downloadpdf(){
        $CI = & get_instance();
        $CI->load->model('Reports');
        $CI->load->model('Web_settings');
        $CI->load->model('Invoices');
        $CI->load->library('pdfgenerator'); 
        $stok_report = $CI->Reports->stock_report_pdf();
          $sub_total_in = 0;
        $sub_total_out = 0;
        $sub_total_stock = 0;
        $sub_total_stokpurchase = 0;
        $sub_total_stoksale = 0;
        if (!empty($stok_report)) {
            $i = $page;
            foreach ($stok_report as $k => $v) {
                $i++;
                $stok_report[$k]['sl'] = $i;
            }

            foreach ($stok_report as $k => $v) {
                $i++;
                $stok_report[$k]['stok_quantity_cartoon'] = ($stok_report[$k]['totalPurchaseQnty'] - $stok_report[$k]['totalSalesQnty']);
                $stok_report[$k]['SubTotalOut'] = ($sub_total_out + $stok_report[$k]['totalSalesQnty']);
                $sub_total_out = $stok_report[$k]['SubTotalOut'];
                $stok_report[$k]['SubTotalIn'] = ($sub_total_in + $stok_report[$k]['totalPurchaseQnty']);
                $sub_total_in = $stok_report[$k]['SubTotalIn'];
                $stok_report[$k]['SubTotalStock'] = ($sub_total_stock + $stok_report[$k]['stok_quantity_cartoon']);
                $sub_total_stock = $stok_report[$k]['SubTotalStock'];

                $stok_report[$k]['total_sale_price'] = $stok_report[$k]['stok_quantity_cartoon'] * $stok_report[$k]['price'];

                $stok_report[$k]['sales_price'] = $stok_report[$k]['price'];

                $sub_total_stoksale += $stok_report[$k]['total_sale_price'];
            }
        }
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $company_info = $CI->Reports->retrieve_company();
        $data = array(
            'title'            => display('stock_report'),
            'stok_report'      => $stok_report,
            'product_model'    => $stok_report[0]['product_model'],
            'date'             => $date,
            'sub_total_in'     => number_format($sub_total_in, 2, '.', ','),
            'sub_total_out'    => number_format($sub_total_out, 2, '.', ','),
            'sub_total_stock'  => number_format($sub_total_stock, 2, '.', ','),
            'company_info'     => $company_info,
            'stock_purchase'   => number_format($sub_total_stokpurchase, 2, '.', ','),
            'stock_sale'       => number_format($sub_total_stoksale, 2, '.', ','),
            'currency'         => $currency_details[0]['currency'],
            'position'         => $currency_details[0]['currency_position'],
            'software_info'    => $currency_details,
            'company'          => $company_info,
        );
            $this->load->helper('download');
            $content = $this->parser->parse('report/stock_report_pdf', $data, true);
            $time = date('Ymdhi');
            $dompdf = new DOMPDF();
            $dompdf->load_html($content);
            $dompdf->render();
            $output = $dompdf->output();
            file_put_contents('assets/data/pdf/'.'stock_report'.$time.'.pdf', $output);
            $file_path = 'assets/data/pdf/'.'stock_report'.$time.'.pdf';
           $file_name = 'stock_report'.$time.'.pdf';
            force_download(FCPATH.'assets/data/pdf/'.$file_name, null);
    }
    public function customerReport(){ //for report - vijila - 28-08-2024

        $data['setting_detail'] = $this->Web_settings->retrieve_setting_editdata($this->admin_id);
        $content = $this->parser->parse('report/customer_info_report', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function getCustomerDatas() { //for report - vijila - 28-08-2024
        $encodedId      = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId      = decodeBase64UrlParameter($encodedId);
        $this->load->model('Customers');
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
    public function customerSalesReport(){
        $data['setting_detail'] = $this->Web_settings->retrieve_setting_editdata($this->admin_id);
        $content = $this->parser->parse('report/customer_report', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function getCustomerSalesDatas() { //for customer sale report - vijila - 28-08-2024
       
        $this->load->model('Reports');
        $setting_detail = $this->Web_settings->retrieve_setting_editdata($this->admin_id);
        $currency       = $setting_detail[0]['currency'];
        $limit          = $this->input->post('length');
        $start          = $this->input->post('start');
        $search         = $this->input->post('search')['value'];
        $orderField     = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
        $orderDirection = $this->input->post('order')[0]['dir'];
        $totalItems     = $this->Reports->getAllCustSale($search, $this->admin_id);
        //echo $this->db->last_query(); exit;
        $items          = $this->Reports->getAllCustSaleData($limit, $start, $orderField, $orderDirection, $search, $this->admin_id);
        $data           = [];
        $i              = $start + 1;
        foreach ($items as $item) {
            $numberOfDays='';
            $date_now = date("Y-m-d");
            if($item['payment_due_date'] !=='' && ($item['payment_due_date'] < $date_now)){
                
                $dateStr1=$item['payment_due_date'];
                $dateStr2=date('Y-m-d');
                $date1 = new DateTime($dateStr1);
                $date2 = new DateTime($dateStr2);
                $interval = $date1->diff($date2);
                $numberOfDays = $interval->days;
            }
            $status='';
            if($item['gtotal']==$item['paid_amount'] && ($item['due_amount']=='0' || $item['due_amount']=='0.00' )){
                $status='Paid';
                $status_disp='<span style="color: green; font-weight: bold;">Paid</span>';
            }else if($item['gtotal'] != $item['paid_amount'] && ($item['paid_amount'] =='0.00' || $item['paid_amount'] =='' || $item['paid_amount'] =='0')){
                $status='Not Paid';
                $status_disp='<span style="color: red; font-weight: bold;">Not Paid</span>';
            }else if($item['gtotal'] != $item['paid_amount'] && $item['paid_amount'] !='0.00'  && $item['paid_amount'] !='0' && substr($item['due_amount'], 0, 1) != '-'){
                $status='Partially Paid';
                $status_disp='<span style="color: #4E11A8; font-weight: bold;">Partially Paid</span>';
            }else if( substr($item['due_amount'], 0, 1) == '-'){
                $status='Paid';
                $status_disp='<span style="color: green; font-weight: bold;">Paid</span>';
            }
                $row = [
                    "id"     => $i,
                    "commercial_invoice_number"     => $item['commercial_invoice_number'],
                    "date"                          => $item['date'],
                    "gtotal"                        => $item['gtotal'],
                    "customer_name"                 => $item['customer_name'],
                    "payment_due_date"              => $item['payment_due_date'],
                    "no_of_days"                    => ($status != 'Paid') ? $numberOfDays : '0',
                    "paid_amount"                   => $currency.($item['paid_amount'] =='' ? '0.00' : $item['paid_amount']),
                    "due_amount"                    => $currency.($item['due_amount'] =='' ? '0.00' : $item['due_amount']),
                    "status"                        => $status_disp
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
    public function customerTransaction(){ //for customer transaction report - vijila - 29-08-2024
       
        $data['setting_detail']  = $this->Web_settings->retrieve_setting_editdata($this->admin_id);
        $content = $this->parser->parse('report/transaction_list_customer', $data, true);
        $this->template->full_admin_html_view($content);
      
      
    }
    public function getCustomerTransactionDatas() { //for customer transaction report - vijila - 29-08-2024
       
        $this->load->model('Reports');
        $setting_detail = $this->Web_settings->retrieve_setting_editdata($this->admin_id);
        $currency       = $setting_detail[0]['currency'];
        $limit          = $this->input->post('length');
        $start          = $this->input->post('start');
        $search         = $this->input->post('search')['value'];
        $paydate        = $this->input->post('payment_date_search');
        $orderField     = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
        $orderDirection = $this->input->post('order')[0]['dir'];
        $totalItems     = $this->Reports->getAllCustomerTransaction($search, $this->admin_id,$paydate);
        $items          = $this->Reports->getAllCustomerTransactionData($limit, $start, $orderField, $orderDirection, $search, $this->admin_id,$paydate);
        $data           = [];
        $i              = $start + 1;
        if (!empty($items)) {
            $previousSupplierName = null;
            $previousInvoiceNumber = null;
            $previousPaymentID = null;
        
            foreach ($items as $arr) {
                $status = '';
        
                if ($arr['total_amt'] == $arr['amt_paid']) {
                    $status = '<span class="badge bg-success">Paid</span>';
                } else if ($arr['total_amt'] != $arr['amt_paid'] && $arr['amt_paid'] != '0.00' && $arr['amt_paid'] != '0' && substr($arr['due_amount'], 0, 1) != '-') {
                    $status = '<span class="badge bg-warning">Partially Paid</span>';
                } else if ($arr['total_amt'] != $arr['amt_paid'] && $arr['amt_paid'] == '0.00') {
                    $status = '<span class="badge bg-danger">Not Paid</span>';
                } else if (substr($arr['balance'], 0, 1) == '-') {
                    $status = '<span class="badge bg-success">Paid</span>';
                }
                $row = [
                    "customer_id"     => $i,
                    "customer_name"     => $arr['customer_name'],
                    "commercial_invoice_number"   => $arr['commercial_invoice_number'],
                    "payment_id"                  => $arr['payment_id'],
                    "payment_date"                => $arr['payment_date'] !="" ? date('m-d-Y',strtotime($arr['payment_date'])) : '',
                    "total_amt"                   => $currency.($arr['total_amt'] =='' ? '0.00' : $arr['total_amt']),
                    "amt_paid"                    => $currency.($arr['amt_paid'] =='' ? '0.00' : $arr['amt_paid']),
                    "balance"                     => $currency.($arr['balance'] =='' ? '0.00' : $arr['balance']),
                    "details"                     => $arr['details'],
                    "status"                      => $status
                ];
                $data[] = $row;
                $i++;
            }
        }
       
        $response = [
            "draw"            => $this->input->post('draw'),
            "recordsTotal"    => $totalItems,
            "recordsFiltered" => $totalItems,
            "data"            => $data,
        ];
        echo json_encode($response);
    }
    public function vendorList() {
        $this->load->model('Web_settings');
       
        $data['setting_detail'] = $this->Web_settings->retrieve_setting_editdata($this->admin_id);
        $content = $this->parser->parse('report/vendor_info_report', $data, true);
        $this->template->full_admin_html_view($content);

    }




    public function vendorListData() {
        $this->load->model('Web_settings');
        $this->load->model('Reports');
        $setting_detail = $this->Web_settings->retrieve_setting_editdata($this->admin_id);
        $currency       = $setting_detail[0]['currency'];
        $limit          = $this->input->post('length');
        $start          = $this->input->post('start');
        $search         = $this->input->post('search')['value'];
        $orderField     = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
        $orderDirection = $this->input->post('order')[0]['dir'];
        $totalItems     = $this->Reports->getAllSupplier($search, $this->admin_id);
        $items          = $this->Reports->getAllSupplierData($limit, $start, $orderField, $orderDirection, $search, $this->admin_id);
       // print_r($items); exit;
        $data           = [];
        $i              = $start + 1;
       
        if (!empty($items)) {
            $previousSupplierName = null;
            $previousInvoiceNumber = null;
            $previousPaymentID = null;
        
            foreach ($items as $arr) {
                $supplier_name = $arr['vendor_type']=='Product Supplier' ? '<a href="'.base_url().'/Csupplier/supplier_ledger_report/'.$arr['vendor_type'].'/'.$arr['supplier_id'].'">'.$arr['supplier_name'] : '<a href="'.base_url().'/Csupplier/supplier_ledger_report/'.$arr['vendor_type'].'/'.$arr['supplier_id'].' class="ads">'.$arr['supplier_name'].'</a>';
                if($arr['vendor_type'] == 'Product Supplier' ){
         
                    if(!empty($arr['inv_due_amount_usd'])) { $inv_due_amt = $currency." ".$arr['inv_due_amount_usd'];} 
                    elseif (!empty($arr['due_amount_usd']) ) { $inv_due_amt = $currency." ".$arr['due_amount_usd'];}
                    else{ $inv_due_amt= $currency." 0.00";}     
                    
                }
                else{
                  if(!empty($arr['service_balance'])){
                    $inv_due_amt = $currency." ".$arr['service_balance']; }
                  else{ $inv_due_amt = $currency." 0.00"; }     
                
                }
                $row = [
                    "created_by"     => $i,
                    "supplier_id"     => $arr['supplier_id'],
                    "supplier_name"   => $supplier_name,
                    "address"         => $arr['address'],
                    "mobile"          => $arr['mobile'],
                    "businessphone"   => $arr['businessphone'],
                    "primaryemail"    => $arr['primaryemail'],
                    "city"            => $arr['city'],
                    "country"         => $arr['country'],
                    "credit_limit"    => $arr['credit_limit'] =="" ? $currency.'0.00' : $arr['credit_limit'],
                    "inv_due_amount_usd"    => $inv_due_amt,
                    "vendor_type"    => $arr['vendor_type'],
                    "state"          => $arr['state'],
                    "zip"               => $arr['zip'],
                    "details"       => $arr['details'],
                ];
                $data[] = $row;
                $i++;
            }
        }
       
        $response = [
            "draw"            => $this->input->post('draw'),
            "recordsTotal"    => $totalItems,
            "recordsFiltered" => $totalItems,
            "data"            => $data,
        ];
        echo json_encode($response);
    }

    public function purchaseByvendorList() {
        $this->load->model('Web_settings');
       
        $data['setting_detail'] = $this->Web_settings->retrieve_setting_editdata($this->admin_id);
        $content = $this->parser->parse('report/vendor_report', $data, true);
        $this->template->full_admin_html_view($content);
    }

    public function purchaseByvendorListgetData() {
        $this->load->model('Web_settings');
        $this->load->model('Reports');
        $setting_detail = $this->Web_settings->retrieve_setting_editdata($this->admin_id);
        $currency       = $setting_detail[0]['currency'];
        $limit          = $this->input->post('length');
        $start          = $this->input->post('start');
        $search         = $this->input->post('search')['value'];
        $orderField     = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
        $orderDirection = $this->input->post('order')[0]['dir'];
        $totalItems     = $this->Reports->getAllpurchasebyVendor($search, $this->admin_id);
        $items          = $this->Reports->getAllpurchasebyVendorData($limit, $start, $orderField, $orderDirection, $search, $this->admin_id);
        $data           = [];
        $i              = $start + 1;
       
        if (!empty($items)) {
            foreach ($items as $arr) {
               
                $status='';
                if($arr['grand_total_amount']==$arr['paid_amount'] && ($arr['balance']=='0' || $arr['balance']=='0.00')){
                    $status='Paid';
                }else if($arr['grand_total_amount'] != $arr['paid_amount'] && ($arr['paid_amount'] =='0.00' || $arr['paid_amount']=='')){
                    $status='Not Paid';
                }else if($arr['grand_total_amount'] != $arr['paid_amount'] && $arr['paid_amount'] !=='0.00'  && $arr['paid_amount'] !=='0' && substr($arr['due_amount'], 0, 1) !== '-'){
                    $status='Partially Paid';
                }else if( substr($arr['balance'], 0, 1) == '-'){
                    $status='Paid';
                }
                    
                $numberOfDays='';
                $date_now = date("Y-m-d");
                if($arr['payment_due_date'] !=='' && $invdatcus['payment_due_date'] < $date_now){
                    $dateStr1=$arr['payment_due_date'];
                    $dateStr2=date('Y-m-d');
                    $date1 = new DateTime($dateStr1);
                    $date2 = new DateTime($dateStr2);
                    $interval = $date1->diff($date2);
                    $numberOfDays = $interval->days;
                }
                if ($status != 'Paid') {
                    $numberOfDaysc = $numberOfDays;
                }else{
                    $numberOfDaysc = 0;
                }
                if ($status == 'Paid') {
                    $statusdisp = '<span style="color: green; font-weight: bold;">' . $status . '</span>';
                } else if ($status == 'Partially Paid') {
                    $statusdisp = '<span style="color: #4E11A8; font-weight: bold;">' . $status . '</span>';
                } else if ($status == 'Not Paid') {
                    $statusdisp = '<span style="color: red; font-weight: bold;">' . $status . '</span>';
                }
             
                $row = [
                    "supplier_id"            => $i,
                    "chalan_no"             => $arr['chalan_no'],
                    "purchase_date"         =>  date('m-d-Y',strtotime($arr['purchase_date'])),
                    "grand_total_amount"    => $currency. $arr['grand_total_amount'],
                    "supplier_name"         => $arr['supplier_name'],
                    "payment_due_date"      => date('m-d-Y',strtotime($arr['payment_due_date'])),
                    "no_of_days"            => $numberOfDaysc,
                    "paid_amount"           => $currency. ($arr['paid_amount'] =='' ? '0' : $arr['paid_amount']),
                    "balance"               => $currency. ($arr['balance'] =='' ? 0 : $arr['balance']),
                    "due_amount"            => $statusdisp
                ];
                $data[] = $row;
                $i++;
            }
        }
       
        $response = [
            "draw"            => $this->input->post('draw'),
            "recordsTotal"    => $totalItems,
            "recordsFiltered" => $totalItems,
            "data"            => $data,
        ];
        echo json_encode($response);
    }

    public function supplierTransactionList(){
        $this->load->model('Web_settings');

        $data['setting_detail'] = $this->Web_settings->retrieve_setting_editdata($this->admin_id);
        $data['supplier_info']  = $this->Suppliers->transaction_supplier($this->admin_id);
        
        $content = $this->parser->parse('report/transaction_list_vendor', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function supplierTransactionData() {
        $this->load->model('Web_settings');
        $this->load->model('Reports');
        $setting_detail = $this->Web_settings->retrieve_setting_editdata($this->admin_id);
        $currency       = $setting_detail[0]['currency'];
        $limit          = $this->input->post('length');
        $start          = $this->input->post('start');
        $search         = $this->input->post('search')['value'];
        $paydate        = $this->input->post('payment_date_search');
        $supplierId     = $this->input->post('supplier_id');
        $msearch['paydate'] = $paydate;
        $msearch['supplier_id'] = $supplierId;
        $orderField     = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
        $orderDirection = $this->input->post('order')[0]['dir'];
        $totalItems     = $this->Reports->getSupplierTransactCount($search, $this->admin_id,$msearch);
        $items          = $this->Reports->getSupplierTransactData($limit, $start, $orderField, $orderDirection, $search, $this->admin_id,$msearch);
        $data           = [];
        $i              = $start + 1;
       
        if (!empty($items)) {
            $previousSupplierName = null;
            $previousInvoiceNumber = null;
            $previousPaymentID = null;
            
            foreach ($items as $arr) {
                $status = '';
        
                if ($arr['total_amt'] == $arr['amt_paid']) {
                    $status = '<span style="color: green; font-weight: bold;">Paid</span>';
                } else if ($arr['total_amt'] != $arr['amt_paid'] && ($arr['amt_paid'] == '0.00' || $arr['amt_paid'] == '')) {
                    $status = '<span style="color: red; font-weight: bold;">Not Paid</span>';
                }else if ($arr['total_amt'] != $arr['amt_paid'] && $arr['amt_paid'] !== '0.00' && $arr['amt_paid'] !== '0' && substr($arr['due_amount'], 0, 1) !== '-') {
                    $status = '<span style="color: #4E11A8; font-weight: bold;">Partially Paid</span>';
                } else if (substr($arr['balance'], 0, 1) == '-') {
                    $status = '<span style="color: green; font-weight: bold;">Paid</span>';
                }
            
                $row = [
                    "supplier_id"           => $i,
                    "supplier_name"         => $arr['supplier_name'],
                    "chalan_no"             =>  $arr['chalan_no'],
                    "payment_id"            => $arr['payment_id'],
                    "payment_date"          => $arr['payment_date'] !="" ? date('m-d-Y',strtotime($arr['payment_date'])) : '',
                    "total_amt"             => $currency . number_format($arr['total_amt'] , 2),
                    "amt_paid"              => $currency.number_format($arr['amt_paid'] , 2),
                    "balance"               => $currency.number_format($arr['balance'] , 2),
                    "details"               => $arr['details'],
                    "status"                => $status
                ];
                $data[] = $row;
                $i++;
            }
        }
       
        $response = [
            "draw"            => $this->input->post('draw'),
            "recordsTotal"    => $totalItems,
            "recordsFiltered" => $totalItems,
            "data"            => $data,
        ];
        echo json_encode($response);
    }
    public function productReport() {
        $this->load->model("Products");
        $data["setting_detail"] = $this->Web_settings->retrieve_setting_editdata($this->admin_id);
        $data["products"]      = $this->Products->product_info_report($this->admin_id);
        $data["getsupplier"]   = $this->Suppliers->get_all_supplier($this->admin_id);
        $content               = $this->parser->parse("report/product_report", $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function productReportData() {

        $this->load->model("Products");
        $this->load->library("lproduct");
        $this->load->model('Reports');
        $data["setting_detail"] = $this->Web_settings->retrieve_setting_editdata($this->admin_id);
        $currency       = $setting_detail[0]['currency'];
        $limit          = $this->input->post('length');
        $start          = $this->input->post('start');
        $search         = $this->input->post('search')['value'];
        $supplierId     = $this->input->post('supplier_id');
        $msearch['supplier_id'] = $supplierId;
        $orderField     = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
        $orderDirection = $this->input->post('order')[0]['dir'];
        $totalItems     = $this->Reports->getProductReportCount($search, $this->admin_id,$msearch);
        $items          = $this->Reports->getProductReportData($limit, $start, $orderField, $orderDirection, $search, $this->admin_id,$msearch);
        $data           = [];
        $i              = $start + 1;
       
        if (!empty($items)) {
            $previousSupplierName = null;
            $previousInvoiceNumber = null;
            $previousPaymentID = null;
            foreach ($items as $product) {
                $row = [
                    "supplier_id"         => $i,
                    "product_id"          => $product['product_id'],
                    "product_name"        => '<a href="'.base_url(). 'Cproduct/product_view/'.$product['product_id'].'">'.$product['product_name'].'</a>',
                    "product_model"       => $product['product_model'],
                    "category_name"         => $product['category_name'],
                    "supplier_name"       => $product['supplier_name'],
                    "unit"                => $product['unit']
                ];
                $data[] = $row;
                $i++;
            }
        }
       
        $response = [
            "draw"            => $this->input->post('draw'),
            "recordsTotal"    => $totalItems,
            "recordsFiltered" => $totalItems,
            "data"            => $data,
        ];
        echo json_encode($response);
    }


     
    public function productReportStock() {
         
        $this->load->library("lproduct");
        $this->load->model("Products");
        $this->load->model("Web_settings");
        $setting_detail         = $this->Web_settings->retrieve_setting_editdata($this->admin_id);
        $data["list"]           = $this->lproduct->product_list($this->admin_id);
        $company_info           = $this->Products->retrieve_company($this->admin_id);
        $data["getsupplier"]    = $this->Suppliers->get_all_supplier($this->admin_id);
        $data["total_product"]  = $this->Products->count_product($this->admin_id);
        $data["products"]       = $this->Products->product_info_report($this->admin_id);
        $data["company_info"]   = $company_info;
        $data["setting_detail"] = $setting_detail;
        $data["sale_count"]     = $this->Products->sales_product_all($this->admin_id);
        $data["expense_count"]  = $this->Products->expense_product_all($this->admin_id);
        // $data["category"]       = $this->Products->get_products($this->admin_id);
        $content                = $this->parser->parse("report/product_stock", $data, true);
        $this->template->full_admin_html_view($content);
    }


    public function productReportStockData() {
        $this->load->library("lproduct");
        $this->load->model("Products");
        $this->load->model("Web_settings");
        $this->load->model("Suppliers");
        $this->load->model('Reports');
    
        $setting_detail = $this->Web_settings->retrieve_setting_editdata($this->admin_id);
        
    
        // Fetch sales and expense data for all products
        $sale_count = $this->Products->sales_product_all($this->admin_id);
        $expense_count = $this->Products->expense_product_all($this->admin_id);
    
        $currency = $setting_detail[0]['currency'];
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $search = $this->input->post('search')['value'];
        $supplierId = $this->input->post('supplier_id');
        $msearch['supplier_id'] = $supplierId;
        $orderField = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
        $orderDirection = $this->input->post('order')[0]['dir'];
        $totalItems = $this->Reports->getProductReportCount($search, $this->admin_id, $msearch);
        $items = $this->Reports->getProductReportData($limit, $start, $orderField, $orderDirection, $search, $this->admin_id, $msearch);
    
        $data = [];
        $i = $start + 1;
    
        if (!empty($items)) {
            foreach ($items as $product) {
                $sales_total = 0;
                $expenses_total = 0;
    
                // Calculate the total sales for this product
                if (!empty($sale_count)) {
                    foreach ($sale_count as $sale) {
                        if ($product['product_id'] == $sale['product_id']) {
                            $sales_total += $sale['available'];
                        }
                    }
                }
    
                // Calculate the total expenses for this product
                if (!empty($expense_count)) {
                    foreach ($expense_count as $expense) {
                        if ($product['product_id'] == $expense['product_id']) {
                            $expenses_total += $expense['available'];
                        }
                    }
                }
    
                // Calculate the total availability
                $total = $product['p_quantity'] - $sales_total + $expenses_total;
    
                // Generate the table row with data
                $row = [
                    "supplier_id"   => $i,
                    "product_id"    => $product['product_id'],
                    "product_name"  => $product['product_name'],   
                    "product_model" => $product['product_model'],
                    "p_quantity"    => '
                        <td data-col="4" class="4" style="text-align: center;">
                            <div class="row" style="text-align:center; padding:5px; width:200px; border: 1px solid #d3d3d366; margin: -1px;">
                                <div class="col-sm-6" style="font-weight:bold;">'.display('In Stock').'</div>
                                <div class="col-sm-6" id="stock">'.$product['p_quantity'].'</div>
                            </div>
                            <div class="row" style="text-align:center; padding:5px; width:200px; border: 1px solid #d3d3d366; margin: -1px;">
                                <div class="col-sm-6" style="font-weight:bold;">'. ('Availability').'</div>
                                <div id="avail" class="col-sm-6">
                                    '.($total).'
                                </div>
                            </div>
                        </td>',
                    "unit"          => $product['product_quantity']
                ];
    
                // Add the generated row to the data array
                $data[] = $row;
                $i++;
            }
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
