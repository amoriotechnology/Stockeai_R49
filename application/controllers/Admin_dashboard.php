<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Admin_dashboard extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->template->current_menu = 'home';
        $this->load->model('Web_settings');
        $this->load->model('Reports');
        $this->load->database();
        $encodedId = isset($_GET['id']) ? $_GET['id'] : '';
        $this->admin_id   = decodeBase64UrlParameter($encodedId);
    }
public function dashboardsetting()
    {
        $CI = & get_instance();
        $CI->load->library('lreport');
        $CI->load->library('occational');
         $CI->load->model('Web_settings');
         $CI->load->model('Customers');
        if (!$this->auth->is_logged()) {
            $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
        }
        $pageen=array();
        $data['page_setting']=$page_setting=array(array("slug"=>"TotalSale","status"=>"enable"),array("slug"=>"TotalExpense","status"=>"enable"),array("slug"=>"Profit","status"=>"enable"),array("slug"=>"NoofProduct","status"=>"enable"),array("slug"=>"Sale_Expense_Overview","status"=>"enable"),array("slug"=>"Pie_Chart","status"=>"enable"),array("slug"=>"No_of_Vendor","status"=>"enable"),array("slug"=>"No_of_Customer","status"=>"enable"),array("slug"=>"No_of_Employee","status"=>"enable"),array("slug"=>"Best_10_Sales_Product","status"=>"enable"));
        if($this->input->post('page_status')){
        $pagedata=$this->input->post('page_status');
        foreach ($page_setting as  $single) {
            if(isset($pagedata[$single['slug']])){
                $pageen[]=array("slug"=>$single['slug'],"status"=>"enable");
            }else{
               $pageen[]=array("slug"=>$single['slug'],"status"=>"disable");
            }
        }
        $arr['section_setting']=json_encode($pageen);
              $CI->Web_settings->update_user_setting($this->session->userdata('user_id'),$arr);
              $this->session->set_userdata(array('message'=>'Settings successfully updated'));
        }
        $page_details    = $CI->Web_settings->get_user_setting($this->session->userdata('user_id'));
         if(isset($page_details['section_setting']) && $page_details['section_setting']!='')
         {
            $pagen=array();
            $da=json_decode($page_details['section_setting']);
            foreach ($da as $single) {
                $pagen[]=array("slug"=>$single->slug,"status"=>$single->status);
        }
            $data['page_setting']=$pagen;
         }
        $content = $CI->parser->parse('include/dashboard_setting', $data, true);
       $this->template->full_admin_html_view($content);
    }
    public function dashboardsettingUser()
    {
       $CI = & get_instance();
       if (!$this->auth->is_logged()) {
            $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
        }
        $data['user_setting']=$user_setting=array(array("slug"=>"No_of_Invoices","status"=>"enable"),array("slug"=>"No_of_Expenses","status"=>"enable"),array("slug"=>"No_of_Timesheet","status"=>"enable"),array("slug"=>"No_of_Workinghours","status"=>"enable"));
        if($this->input->post('userpage_status')){
        $pagedata=$this->input->post('userpage_status');
        foreach ($user_setting as  $single) {
            if(isset($pagedata[$single['slug']])){
                $pageen[]=array("slug"=>$single['slug'],"status"=>"enable");
            }else{
               $pageen[]=array("slug"=>$single['slug'],"status"=>"disable");
            }
        }
        $arr['user_section_setting']=json_encode($pageen);
              $CI->Web_settings->update_userlogin_setting($this->session->userdata('user_id'),$arr);
              $this->session->set_userdata(array('message'=>'Settings successfully updated'));
        }
        $page_details    = $CI->Web_settings->get_userlogin_setting($this->session->userdata('user_id'));
         if(isset($page_details['user_section_setting']) && $page_details['user_section_setting']!='')
         {
            $pagen=array();
            $da=json_decode($page_details['user_section_setting']);
            foreach ($da as $single) {
                $pagen[]=array("slug"=>$single->slug,"status"=>$single->status);
        }
            $data['user_setting']=$pagen;
         }
       $content = $CI->parser->parse('include/dashboard_setting_user', $data, true);
       $this->template->full_admin_html_view($content);
    }
    public function index() {
        $date = $this->input->post('daterangepicker-field',TRUE);
        if($date==''){
            $prev_month = date('Y-m-d', strtotime("-1 months", strtotime("NOW"))); 
            $current=date('Y-m-d');
            $date= $prev_month."to". $current;
        }
        $date = str_replace(' ', '', $date);
        $split=explode("to",$date);
        $CI = & get_instance();
        $CI->load->library('lreport');
        $CI->load->library('occational');
        if (!$this->auth->is_logged()) {
            $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
        }
        $this->auth->check_admin_auth();
        $CI->load->model('Customers');
        $CI->load->model('Products');
        $CI->load->model('Suppliers');
        $CI->load->model('Invoices');
        $CI->load->model('Purchases');
        $CI->load->model('Reports');
        $CI->load->model('Web_settings');
        $total_customer      = $CI->Customers->count_customer();
        $total_product       = $CI->Products->count_product($this->admin_id);
        $total_suppliers     = $CI->Suppliers->count_supplier();
         $todays_sales_report_detail = '';

         $monthly_sales_report= $CI->Reports->monthly_sales_report();
         $overall_sales= $CI->Reports->overall_sales();
         $overall_sale_no        = $CI->Reports->overall_sale_no();
         $no_of_sale     = $CI->Reports->total_sales_report($split[0],$split[1]);
         $sales_paid     = $CI->Reports->sales_paid();
         $sales_due   = $CI->Reports->sales_due();
         $exp_paid     = $CI->Reports->exp_paid();
         $exp_due   = $CI->Reports->exp_due();
         $overall_exp_no        = $CI->Reports->overall_exp_no();
         $getrowcount_invoices = $CI->Invoices->getRowCountInvoices();
         $getrowcount_expenses = $CI->Invoices->getRowCountExpenses();
         $getrowcount_timesheet = $CI->Invoices->getRowCountTimesheet();
         $getTodayWorkingHours = $CI->Invoices->getCountTodayWorkingHour();
         $gettotal_Workinghours = $CI->Invoices->getnumberofWorkinghours();
         $getPiechart = $CI->Invoices->getPiechartsalesData();
         $getoverallExpensesamt = $CI->Invoices->getoverallExpensesAmount();
         $getoverallExpensesamtArray = $CI->Invoices->getoverallExpensesAmountarray();
         $getTotalOutstand = $CI->Invoices->getTotalOutstandingamt();
        $no_of_expense     = $CI->Reports->total_purchase_report($split[0],$split[1]);
        $total_sales_invoice         = '';
        //$CI->Reports->total_sale_invoice();
        $service_provider_list = $CI->Invoices->servic_provider();
        $total_sales         = $CI->Reports->total_sales_amount($split[0],$split[1]);
        $total_purchase      = $CI->Reports->total_purchase_amount($split[0],$split[1]);
       $total_expenses      =$CI->Reports->total_expense_amount($split[0],$split[1]);
        $salesamount         = $CI->Reports->todays_total_sales_amount($split[0],$split[1]);
        $total_employee_salary       = $CI->Reports->total_employee_salary($split[0],$split[1]);
        $total_service     = $CI->Reports->total_service_amount($split[0],$split[1]);
        $purchase_report     = $CI->Reports->todays_total_purchase_report();
        $todaysale=$CI->Reports->todays_total_sales_amount();
        $today_n_sale=$CI->Reports->today_no_of_sale();
        $today_sale_due=$CI->Reports->today_sale_due();
        $today_sale_paid=$CI->Reports->today_sale_paid();
          $todayex=$CI->Reports->todays_total_purchase_report();
        $today_n_ex=$CI->Reports->today_no_of_ex();
        $today_ex_due=$CI->Reports->today_ex_due();
        $today_ex_paid=$CI->Reports->today_ex_paid();
     $overall_purchase_amt= $CI->Reports->overall_purchase_amt();
        $todays_sale_product = $CI->Reports->todays_sale_product();
        $total_profit        = ($sales_report[0]['total_sale'] - $sales_report[0]['total_supplier_rate']);
        $currency_details    = $CI->Web_settings->retrieve_setting_editdata();
        // $Best_10_Sales_Product  = $CI->Invoices->best_sales_products();
    // $total_sales_product =$CI->Reports->total_sales_product();
    $total_expense_product =$CI->Reports->total_expense_product();
         $tlvmonth = '';
                    $month = ["January","February","March","April","May","June","July","August","September","October","November","December"];
                    for ($i=0; $i <= 11; $i++) {
                        $tlvmonth.=  $month[$i].',';
                            }
       $currentyearsale='';
                      for ($i=1; $i <= 12; $i++) {
                               $sold = $CI->Reports->yearly_invoice_report($i);
                               if (!empty($sold)) {
                                    $currentyearsale.=$sold->total_sale.",";
                                     }else{
                                $currentyearsale.=",";
                               }
                            } 
        $currentyearpurchase='';
                      for ($i=1; $i <= 12; $i++) {
                               $purchase = $CI->Reports->yearly_purchase_report($i);
                               if (!empty($purchase)) {
                                    $currentyearpurchase.=$purchase->total_purchase.",";
                                     }else{
                                $currentyearpurchase.=",";
                               }
                            }                     
$chart_label = $chart_data = '';
    for ($i = 0; $i < 12; $i++) {
        $chart_label .= (!empty($Best_10_Sales_Product[$i]) ?  $Best_10_Sales_Product[$i]->product_name . ', ' : null);
        $chart_data .= (!empty($Best_10_Sales_Product[$i]) ? $Best_10_Sales_Product[$i]->quantity . ', ' : null);
    }
    $page_details    = $CI->Web_settings->get_user_setting($this->session->userdata('user_id'));
    $Sale=$Expense=$Sale_invoice=$Expense_invoice=$Product_sold=$Product_purchased=$Best_10_Sales_Product=$todays_overview=$yearly_report=$todays_sales_report='enable';
    if(isset($page_details['section_setting']) && $page_details['section_setting']!='')
         {
             $data['page_setting']=$p=json_decode($page_details['section_setting']);
             $Sale=isset($p[0]->slug)?$p[0]->status:'enable';
             $Expense=isset($p[1]->slug)?$p[1]->status:'enable';
             $Sale_invoice=isset($p[2]->slug)?$p[2]->status:'enable';
             $Expense_invoice=isset($p[3]->slug)?$p[3]->status:'enable';
             $Product_sold=isset($p[4]->slug)?$p[4]->status:'enable';
             $Product_purchased=isset($p[5]->slug)?$p[5]->status:'enable';
             $no_of_vendor=isset($p[6]->slug)?$p[6]->status:'enable';
             $todays_overview=isset($p[7]->slug)?$p[7]->status:'enable';
             $yearly_report=isset($p[8]->slug)?$p[8]->status:'enable';
             $bestofProduct=isset($p[9]->slug)?$p[9]->status:'enable';
         }
         $pageuser_details = $CI->Web_settings->get_userlogin_setting($this->session->userdata('user_id'));
    $No_of_Invoices = $No_of_Expenses = $No_of_Timesheet = $No_of_Workinghours='enable';
    if(isset($pageuser_details['user_section_setting']) && $pageuser_details['user_section_setting']!=''){
        $data['user_setting']=$u=json_decode($pageuser_details['user_section_setting']);
        $No_of_Invoices=isset($u[0]->slug)?$u[0]->status:'enable';
        $No_of_Expenses=isset($u[1]->slug)?$u[1]->status:'enable';
        $No_of_Timesheet=isset($u[2]->slug)?$u[2]->status:'enable';
        $No_of_Workinghours=isset($u[3]->slug)?$u[3]->status:'enable';
    }
      $data1 = array(
        'total_sales'         => $total_sales,
        'total_purchase'     => $total_purchase,
        'total_expenses'      =>$total_expenses,
        'salesamount'         => $salesamount,
        'total_employee_salary'       => $total_employee_salary,
       'total_service'  =>$total_service
     );
   $data = array(
            'total_sales_product'  =>$total_sales_product,
            'total_expense_product' => $total_expense_product,
            'no_of_expense' => $no_of_expense,
            'overall_purchase_amt'  => $overall_purchase_amt,
            'total_expenses'      =>$total_expenses,
            'salesamount'         => $salesamount,
            'total_employee_salary'       => $total_employee_salary,
           'total_service'  =>$total_service,
           'no_of_sale' =>$no_of_sale,
           'total_sales_invoice'=>$total_sales_invoice,
    'title'               => display('dashboard'),
    'total_customer'      => $total_customer,
    'no_of_vendor' => $no_of_vendor,
    'total_product'       => $total_product,
   'bestofProduct'=> $bestofProduct,
    'total_suppliers'     => $total_suppliers,
   'tlvmonthsale'        => $currentyearsale,
    'tlvmonthpurchase'    => $currentyearpurchase,
    'month'               => $tlvmonth,
    'total_sales'         => $total_sales,
    'todays_sales_report_detail' =>$todays_sales_report_detail,
    'service_provider_list'  => $service_provider_list,
    'sale_setting'  => $Sale,
    'expense_setting'  => $Expense,
    'sale_invoice_setting'  => $Sale_invoice,
    'expense_invoice_setting'  => $Expense_invoice,
    'product_sold'  => $Product_sold,
    'product_purchased'  => $Product_purchased,
    'Best_10_Sales_Product'  => $Best_10_Sales_Product,
    'todays_overviewsetting'  => $todays_overview,
    'yearly_reportsetting'  => $yearly_report,
    'todays_sales_reportsetting'=> $todays_sales_report_set,
    'total_purchase'      => $total_purchase,
    'todays_total_sales_report' => $todays_total_sales_amount,
    'chart_data'          => $chart_data,
    'purchase_amount'     => number_format($sales_report[0]['total_supplier_rate'], 2, '.', ','),
    'sales_amount'        => '',
    'todays_sale_product' => $todays_sale_product,
    'todays_total_purchase'=> '',
    'total_profit'        => number_format($total_profit, 2, '.', ','),
    'monthly_sales_report'=> $monthly_sales_report,
    'count_invoices' => $getrowcount_invoices,
    'count_expenses' => $getrowcount_expenses,
    'count_timesheets' => $getrowcount_timesheet,
    'total_workinghours' => $gettotal_Workinghours,
    'getHours' => $getTodayWorkingHours,
    'getPiechart' => $getPiechart,
    'invoice_setting' => $No_of_Invoices,
    'expense_settings' => $No_of_Expenses,
    'timesheet_setting' => $No_of_Timesheet,
    'workinghours_setting' => $No_of_Workinghours,
    'expenseamt' => $getoverallExpensesamt,
    'arrayexpenseamt' => $getoverallExpensesamtArray,
    'outstanding_loan' => $getTotalOutstand,
    'currency'            => $currency_details[0]['currency'],
    'position'            => $currency_details[0]['currency_position'],
        );
        $content = $CI->parser->parse('include/admin_home', $data, true);
       $this->template->full_admin_html_view($content);
    }
    public function chart() {
        $start=$_GET['start'];
        $end=$_GET['end'];
        $CI = & get_instance();
        $CI->load->model('Reports');
        $info = $CI->Reports->chart_exp($start,$end);
  }
    public function see_all_best_sales() {
        $CI = & get_instance();
        $CI->load->library('lreport');
        $CI->load->library('occational');
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $CI->load->model('Customers');
        if (!$this->auth->is_logged()) {
            $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
        }
        $company_info = $CI->Customers->retrieve_company();
        $best_saler_product_list = $CI->Invoices->best_saler_product_list();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title'                   => display('dashboard'),
            'best_saler_product_list' => $best_saler_product_list,
            'company_info'            => $company_info,
            'currency'                => $currency_details[0]['currency'],
            'position'                => $currency_details[0]['currency_position'],
        );
        $content = $CI->parser->parse('report/best_saler_product_list', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function todays_customer_receipt() {
        $CI = & get_instance();
        $CI->load->library('occational');
        if (!$this->auth->is_logged()) {
            $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
        }
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $today = date('Y-m-d');
        $company_info = $CI->Customers->retrieve_company();
         $created_by   = $this->session->userdata('user_id');
        $all_customer = $this->db->select('*')
        ->from('customer_information')
        ->where('create_by',$created_by)
        ->get()
        ->result();
        $todays_customer_receipt = $CI->Invoices->todays_customer_receipt($today);
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title'                   => "Received From Customer",
            'all_customer'            => $all_customer,
            'todays_customer_receipt' => $todays_customer_receipt,
            'today'                   => $today,
            'company_info'            => $company_info,
            'currency'                => $currency_details[0]['currency'],
            'position'                => $currency_details[0]['currency_position'],
            'software_info'           => $currency_details,
            'customer_info'           => '',
            'company'                 => $company_info,
        );
        $content = $CI->parser->parse('report/todays_customer_receipt', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function filter_customer_wise_receipt() {
        $CI = & get_instance();
        $CI->load->library('lreport');
        $CI->load->library('occational');
        $w = & get_instance();
        $w->load->model('Ppurchases');
        $CI->load->model('Web_settings');
        $company_info = $w->Ppurchases->retrieve_company();
        $setting=  $CI->Web_settings->retrieve_setting_editdata();
        if (!$this->auth->is_logged()) {
            $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
        }
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $customer_id = $this->input->post('customer_id',TRUE);
        $from_date   = $this->input->post('from_date',TRUE);
        $today       = date('Y-m-d');
        $created_by   = $this->session->userdata('user_id');
        $all_customer = $this->db->select('*')
        ->from('customer_information')
        ->where('create_by',$created_by)
        ->get()
        ->result();
        $filter_customer_wise_receipt = $CI->Invoices->filter_customer_wise_receipt($customer_id, $from_date);
        $todays_customer_receipt = $CI->Invoices->todays_customer_receipt($today);
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title'                   => "Received From Customer",
            'all_customer'            => $all_customer,
            'todays_customer_receipt' => $filter_customer_wise_receipt,
            'today'                   => $today,
            'customer_info'           =>  $CI->Invoices->customerinfo_rpt($customer_id),
            'currency'                => $currency_details[0]['currency'],
            'position'                => $currency_details[0]['currency_position'],
            'logo'  =>(!empty($setting[0]['invoice_logo'])?$setting[0]['invoice_logo']:$company_info[0]['logo']),  
            'company'=>(!empty($datacontent[0]['company_name'])?$datacontent[0]['company_name']:$company_info[0]['company_name']),   
            'phone'=>(!empty($datacontent[0]['mobile'])?$datacontent[0]['mobile']:$company_info[0]['mobile']),   
            'email'=>(!empty($datacontent[0]['email'])?$datacontent[0]['email']:$company_info[0]['email']),   
            'address'=>(!empty($datacontent[0]['address'])?$datacontent[0]['address']:$company_info[0]['address']), 
        );
        $content = $CI->parser->parse('report/todays_customer_receipt', $data,true);
        $this->template->full_admin_html_view($content);
    }
    public function all_report() {
        $CI = & get_instance();
        $CI->load->library('lreport');
        if (!$this->auth->is_logged()) {
            $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
        }
          $user_type = $this->session->userdata('user_type');
            $content = $CI->lreport->retrieve_all_reports();
            $this->template->full_admin_html_view($content);
    }
       public function forgot()
        {
                 $CI = & get_instance();
        $this->load->model('Users');
                     $this->form_validation->set_rules('email', 'Email', 'required|valid_email'); 
                $email = $this->input->post('email');  
                 $clean = $this->security->xss_clean($email);
            $userInfo = $CI->Users->getUserInfoByEmail($clean);
                $email = $this->input->post('email');  
                 $clean = $this->security->xss_clean($email);
   $to = $email;
                if(empty($userInfo)){
                    $this->session->set_flashdata('flash_message', 'We cant find your email address');
                }   
  $token = $CI->Users->insertToken($userInfo[0]['unique_id']);        
                $qstring = $this->base64url_encode($token);                  
                $url = site_url() . 'Admin_dashboard/reset_password/token/' . $qstring;
                $link = '<a href="' . $url . '">' . $url . '</a>'; 
                $subject="Stockeai - Reset Password";
                $message = '';                     
                $message .= '<strong>Greeting from Stockeai</strong><br>
There was a request to change your password!
If you did not make this request then please ignore this email.
Otherwise, please click this link to change your password:</strong><br>';
                $message .= '<strong>' . $link.'</strong> ';             
        try {
          $setting_detail = $this->db->select('*')->from('email_config')->get()->row();
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
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        $check_email = $this->test_input($email);
        $this->email->send();
            echo "<script>alert('Email Send Successfully')</script>";
         sleep(2);
redirect(base_url()."Admin_dashboard/login");
  $this->session->set_flashdata('flash_message', 'Your password has been updated. You may now login');
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
      public function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
           public function reset_password()
        {
                $CI = & get_instance();
        $this->load->model('Users');
            $token = $this->base64url_decode($this->uri->segment(4));                  
            $cleanToken = $this->security->xss_clean($token);
            $user_info = $CI->Users->isTokenValid($cleanToken); //either false or array();               
            if(!$user_info){
                $this->session->set_flashdata('flash_message', 'Token is invalid or expired');
                redirect(site_url().'Admin_dashboard/login');
            }            
            $data = array(
                'firstName'=> $user_info->username, 
                'email'=>$user_info->email_id, 
                'token'=>$this->base64url_encode($token)
            );
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
            $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');              
            if ($this->form_validation->run() == FALSE) {   
                $this->load->view('reset_password', $data);
            }else{
                $this->load->library('password');                 
                $post = $this->input->post(NULL, TRUE);                
                $cleanPost = $this->security->xss_clean($post);                
                  $hashed=md5('gef'.$cleanPost['password']);     
                $cleanPost['password'] = $hashed;
                $cleanPost['unique_id'] = $user_info->unique_id;
                unset($cleanPost['passconf']);                
                if(!$CI->Users->updatePassword($cleanPost)){
                    $this->session->set_flashdata('flash_message', 'There was a problem updating your password');
                }else{
                    ?>
<script type="text/javascript">
window.history.go(-2);
</script>
<?php
                    sleep(5);
                   $this->session->set_flashdata('flash_message', 'Your password has been updated. You may now login');
                      header("Location:".base_url()."/Admin_dashboard/login/");
                }
            }
        }
            public function base64url_encode($data) { 
      return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
    } 
    public function base64url_decode($data) { 
      return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
    } 
    public function filter_purchase_report_category_wise() {
        $CI = & get_instance();
        $CI->load->library('lreport');
        $category  = $this->input->post('category',TRUE);
        $from_date = $this->input->post('from_date',TRUE);
        $to_date   = $this->input->post('to_date',TRUE);
        $content   = $this->lreport->filter_purchase_report_category_wise($category, $from_date, $to_date);
        $this->template->full_admin_html_view($content);
    }
    public function filter_sales_report_category_wise() {
        $CI = & get_instance();
        $CI->load->library('lreport');
        $category  = $this->input->post('category',TRUE);
        $from_date = $this->input->post('from_date',TRUE);
        $to_date   = $this->input->post('to_date',TRUE);
        $content   = $this->lreport->filter_sales_report_category_wise($category, $from_date, $to_date);
        $this->template->full_admin_html_view($content);
    }
    public function login() {
        if ($this->auth->is_logged()) {
            $this->output->set_header("Location: " . base_url() . 'Admin_dashboard', TRUE, 302);
        }
        $data['title'] = display('admin_login_area');
        $content = $this->parser->parse('user/admin_login_form', $data, true);
        $this->template->full_admin_html_view($content);
    }
  public function userauth() {
    $this->load->library('session');
    $this->session;
    $query='select * from user_login where username="'.$_REQUEST['username'].'"';
    $query=$this->db->query($query);
    $row=$query->result_array();
    $u_type=$row[0]['u_type'];
    $this->session->set_userdata('u_type',$u_type); 
    $this->session->set_userdata('u_name',$row[0]['username']);
    $this->session->set_userdata('unique_id',$row[0]['unique_id']); 
    $sql='select * from user_login where username="'.$_POST['username'].'"';
    $query=$this->db->query($sql);
    $row=$query->result_array();
    $user_id=$row[0]['user_id']; 
    $unique_id=$row[0]['unique_id']; 
    $this->session->set_userdata('unique_id',$unique_id); 
    $query1='select * from company_information where company_id="'.$row[0]['cid'].'"';
    $query1=$this->db->query($query1);
    $row1=$query1->result_array();
    $logo=$row1[0]['logo']; 
    $this->session->set_userdata('logo',$row1[0]['logo']); 
    $this->session->set_userdata('company_name',$row1[0]['company_name']);
    $this->session->set_userdata('tax_consultant',$row1[0]['tax_consultant']);
    $sql='select * from sec_userrole  where user_id="'.$user_id.'"';
    $query=$this->db->query($sql);
    $row=$query->result_array();
    $num=$query->num_rows();
    if($num>0)
    {
        $roleid=$row[0]['roleid'];
        $sql='SELECT GROUP_CONCAT(CONCAT(`menu`, " - ", `create`,`price`,`update`,`delete`) SEPARATOR ", ") AS items FROM role_permission where role_id="'.$roleid.'"';
        $query=$this->db->query($sql);
        $row=$query->result_array();
        $sale=array();$product=array();
        foreach($row as $val){
            foreach($val as $perm_data){
                $perm_data=explode(',',$perm_data);
                $this->session->set_userdata('perm_data',$perm_data); 
            }
        }
    }
    $sql2='select * from company_assignrole  where user_id="'.$user_id.'"';
    $query=$this->db->query($sql2);
    $row=$query->result_array();
    $nums=$query->num_rows();
    if($nums>0)
    {
        $roleid=$row[0]['roleid'];
        $sql2='SELECT GROUP_CONCAT(CONCAT(`menu`, " - ", `create`) SEPARATOR ", ") AS items FROM super_permission where role_id="'.$roleid.'"';
        $query=$this->db->query($sql2);
        $row2=$query->result_array();
        $sale=array();$product=array();
        foreach($row2 as $val1){
            foreach($val1 as $admin_data){
                $admin_data=explode(',',$admin_data);
                $this->session->set_userdata('admin_data',$admin_data);
            }
        }
    }
    if (!$this->input->post('username',TRUE)) {
        $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    if ($this->auth->is_logged()) {
        $this->output->set_header("Location: " . base_url() . 'Admin_dashboard', TRUE, 302);
    }
    $dat['username'] = $this->input->post('username',TRUE);
    $dat['password']= $this->input->post('password',TRUE);
    $dat['otp']=$otp=rand(1000,9999);
    $this->session->set_userdata($dat);
    $data['title'] = display('admin_login_area');
    $from_email = "info@gmail.com";
    $to_email = $this->input->post('username');
    $this->load->library('email');
    $this->email->from($from_email, 'kptest');
    $this->email->to($to_email);
    $this->email->subject('Email Test');
    $this->email->message('One time OTP Passkey .'.$otp);
    if($this->email->send())
        $this->session->set_flashdata("email_sent","Email sent successfully.");
    else
        $this->session->set_flashdata("email_sent","Error in sending Email.");
    redirect(base_url() . 'Admin_dashboard/do_login');
    echo $content = $this->parser->parse('user/admin_auth_form', $data, true);
}
    #==============Valid user check=======#
     public function do_login() {
        $error = '';
        $setting_detail = $this->Web_settings->retrieve_setting_editdata();
        if ($setting_detail[0]['captcha'] == 0 && $setting_detail[0]['secret_key'] != null && $setting_detail[0]['site_key'] != null) {
            $this->form_validation->set_rules('g-recaptcha-response', 'recaptcha validation', 'required|callback_validate_captcha');
            $this->form_validation->set_message('validate_captcha', 'Please check the the captcha form');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_userdata(array('error_message' => display('please_enter_valid_captcha')));
                $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
            } else {
                $username = $this->input->post('username',TRUE);
                $password = $this->input->post('password',TRUE);
                if ($username == '' || $password == '' || $this->auth->login($username, $password) === FALSE) {
                    $error = display('wrong_username_or_password');
                }
                if ($error != '') {
                    $this->session->set_userdata(array('error_message' => $error));
                    $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
                } else {
                    $this->output->set_header("Location: " . base_url(), TRUE, 302);
                }
            }
        } else {
           if ($this->session->userdata('otp')) {
            $username =  $this->session->userdata('username');
            $password = $this->session->userdata('password');
            if ($username == '' || $password == '' || $this->auth->login($username, $password) === FALSE) {
                $error = display('wrong_username_or_password');
            }
            }else{
            $error = 'invalid otp';
        }
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('password');
            if ($error != '') {
                $this->session->set_userdata(array('error_message' => $error));
                $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
            } else {
                $sqlmode= $this->db->query('select @@sql_mode')->row_array();
                if(stristr(@$sqlmode['@@sql_mode'], 'ONLY_FULL_GROUP_BY')){
                     $this->db->query("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
                     redirect(base_url());
                }
                $this->output->set_header("Location: " . base_url(), TRUE, 302);
            }
        }
    }
    function validate_captcha() {
        $setting_detail = $this->Web_settings->retrieve_setting_editdata();
        $captcha = $this->input->post('g-recaptcha-response',TRUE);
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $setting_detail[0]['secret_key'] . ".&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
        if ($response . 'success' == false) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    #===============Logout=======#
    public function logout() {
        if ($this->auth->logout())
            $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    #=============Edit Profile======#
    public function edit_profile() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('luser');
        $content = $CI->luser->edit_profile_form();
        $this->template->full_admin_html_view($content);
    }
    #=============Update Profile========#
    public function update_profile() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Users');
        $this->Users->profile_update();
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('Admin_dashboard/edit_profile'));
    }
    #=============Change Password=========# 
    public function change_password_form() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $content = $CI->parser->parse('user/change_password', array('title' => display('change_password')), true);
        $this->template->full_admin_html_view($content);
    }
    #============Change Password===========#
   public function change_password() {
    $this->load->library('form_validation');
    $this->load->model('Users');
    $this->form_validation->set_rules('email', 'User Name', 'trim|required');
    $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
    $this->form_validation->set_rules('repassword', 'Re-Enter Password', 'trim|required|matches[password]');
    $this->form_validation->set_message('required', '{field} is required.');
    $this->form_validation->set_message('min_length', '{field} must be at least {param} characters long.');
    $this->form_validation->set_message('matches', 'The {field} does not match with Password.');
    if ($this->form_validation->run() == FALSE) {
        $this->session->set_userdata('error_message', validation_errors());
        redirect('Admin_dashboard/change_password_form'); 
    } else {
        $email = $this->input->post('email', TRUE);
        $old_password = $this->input->post('old_password', TRUE);
        $new_password = $this->input->post('password', TRUE);
        if (!$this->Users->verify_password($email, $old_password)) {
            $this->session->set_userdata('error_message', 'Incorrect old password.');
            redirect('Admin_dashboard/change_password_form'); 
        }
        $result = $this->Users->change_password($email, $old_password, $new_password);
        if ($result) {
            $this->session->set_userdata('message', 'Password changed successfully.');
            redirect('Admin_dashboard/change_password_form');
        } else {
            $this->session->set_userdata('error_message', 'Failed to change password. Please try again.');
            redirect('Admin_dashboard/change_password_form'); 
        }
    }
}
    public function closing() {
        $CI = & get_instance();
        $CI->load->model('Reports');
        $data = array('title' => "Reports | Daily Closing");
        $data = $this->Reports->accounts_closing_data();
        $content = $this->parser->parse('accounts/closing_form', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function closing_report()
    {
        $CI = & get_instance();
        $CI->load->library('laccounts');
        $content =$this->laccounts->daily_closing_list();
        $this->template->full_admin_html_view($content);
    }
    public function password_recovery(){
         $CI = & get_instance();
         $CI->load->model('Settings');
    $this->form_validation->set_rules('rec_email', display('email'), 'required|valid_email|max_length[100]|trim');  
    $userData = array(
            'email' => $this->input->post('rec_email',TRUE)
        );
    if ($this->form_validation->run())
        {
    $user = $this->Settings->password_recovery($userData);
     $ptoken = date('ymdhis');
        if($user->num_rows() > 0) {
            $email =$user->row()->username;
            $precdat = array(
            'username'      => $email,
            'security_code' => $ptoken,
        );
        $this->db->where('username',$email)
            ->update('user_login',$precdat);
             $send_email = '';
             if (!empty($email)) {
                $send_email = $this->setmail($email,$ptoken);
             }
           if($send_email){
             $this->session->set_userdata(array('message' => 'Forget link sent to your email. Please Check your email'));
           }else{
              $this->session->set_userdata(array('message' => 'Sorry Email Not Send'));
           }
        }else{
             $this->session->set_userdata(array('message' => 'Email Not found'));
        }
    }else{
         $this->session->set_userdata(array('message' => 'Please try again'));
        }
         echo json_encode($user_data);
    }
     public function setmail($email,$ptoken)
    {
$msg = "Hi,
There was a request to change your password!
If you did not make this request then please ignore this email.
Otherwise, please click this link to change your password: ".base_url().'Admin_dashboard/recovery_form/'.$ptoken;
mail($email,"passwordrecovery",$msg);
return true;
}
public function recovery_form($token_id = null){
        $CI = & get_instance();
        $CI->load->model('Settings');
        $tokeninfo = $this->Settings->token_matching($token_id);
      if($tokeninfo->num_rows() > 0) {
        $data['token'] = $token_id;
        $data['title'] = display('recovery_form');
        $this->load->view('user/user_recovery_form', $data);
      }else{
        redirect(base_url('Admin_dashboard/login'));  
      }
}
public function recovery_update(){
    $token = $this->input->post('token',TRUE);
    $newpassword = $this->input->post('newpassword',TRUE);
    $userdata = array(
        'password'      =>  md5("gef" . $newpassword),
        'security_code' => '001'
        );
        $this->db->where('security_code',$token)
            ->update('user_login',$userdata);
            redirect(base_url('Admin_dashboard/login')); 
}
}