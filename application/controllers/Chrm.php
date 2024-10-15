<?php
error_reporting(0);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Chrm extends CI_Controller {
    public $menu;
    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->library('auth');
        $this->load->library('session');
        $this->load->model('Web_settings');
        $this->load->model('invoice_design');
        $this->load->model('Ppurchases');
        $this->load->model('invoice_content');
        $this->load->model('Hrm_model');
        $this->load->helper('lang_helper');
        $this->auth->check_admin_auth();
    }
// Manage Employee Index  - hr
    public function manage_employee() {
        $encodedId                 = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId                 = decodeBase64UrlParameter($encodedId);
        $setting_detail            = $this->Web_settings->retrieve_setting_editdata($decodedId);
        $data['title']             = display('manage_employee');
        $data['employee_list']     = $this->Hrm_model->employee_list($decodedId);
        $data['id']                = $_GET['id'];
        $data['employee_data_get'] = $this->Hrm_model->employee_data_get($decodedId);
        $data['setting_detail']    = $setting_detail;
        $content                   = $this->parser->parse('hr/employee_list', $data, true);
        $this->template->full_admin_html_view($content);
    }
    // Manage Employee Index  - hr
    public function getEmployeeDatas() {
        $encodedId      = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId      = decodeBase64UrlParameter($encodedId);
        $limit          = $this->input->post('length');
        $start          = $this->input->post('start');
        $search         = $this->input->post('search')['value'];
        $orderField     = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
        $orderDirection = $this->input->post('order')[0]['dir'];
        $totalItems     = $this->Hrm_model->getTotalEmployee($search, $decodedId);
        $items          = $this->Hrm_model->getPaginatedEmployee($limit, $start, $orderField, $orderDirection, $search, $decodedId);
        $data           = [];
        $i              = $start + 1;
        foreach ($items as $item) {
            $profile = '<a href="' . base_url('Chrm/employee_details?id=' . $encodedId . '&employee=' . $item['id']) . '" class="btnclr btn m-b-5 m-r-2"><i class="fa fa-user"></i></a>';
            $empinv  = '<a href="' . base_url('Chrm/timesheed_inserted_data?id=' . $encodedId . '&employee=' . $item['id']) . '" class="btnclr btn m-b-5 m-r-2"><i class="fa fa-download" aria-hidden="true"></i></a>';
            $edit    = '<a href="' . base_url('Chrm/employee_update_form?id=' . $encodedId . '&employee=' . $item['id']) . '" class="btnclr btn m-b-5 m-r-2" data-toggle="tooltip" data-placement="left" title="' . display('update') . '"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            $delete  = '<a href="' . base_url('Chrm/employee_delete?id=' . $encodedId . '&employee=' . $item['id']) . '" class="btnclr btn" style="margin-bottom: 5px;"  onclick="return confirm(\'' . display('are_you_sure') . '\')" data-toggle="tooltip" data-placement="right" title="' . display('delete') . '"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
            $row     = [
                "id"                     => $i,
                "first_name"             => $item['first_name'] . ' ' . $item['middle_name'] . ' ' . $item['last_name'],
                "designation"            => $item['designation'],
                "phone"                  => $item['phone'],
                "email"                  => $item['email'],
                "social_security_number" => $item['social_security_number'],
                "employee_type"          => $item['employee_type'],
                "payroll_type"           => $item['payroll_type'],
                'created_admin'          => $decoded_admin,
                "routing_number"         => $item['routing_number'],
                "account_number"         => $item['account_number'],
                "employee_tax"           => $item['employee_tax'],
                'action'                 => $profile . $empinv . $edit . $delete,
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
    
    // Manage Timesheet Index  - hr
    public function getTimesheetDatas() {
        $encodedId      = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId      = decodeBase64UrlParameter($encodedId);
        $limit          = $this->input->post('length');
        $start          = $this->input->post('start');
        $search         = $this->input->post('search')['value'];
        $orderField     = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
        $orderDirection = $this->input->post('order')[0]['dir'];
        $totalItems     = $this->Hrm_model->getTotalTimesheet($search, $decodedId);
        $items          = $this->Hrm_model->getPaginatedTimesheet($limit, $start, $orderField, $orderDirection, $search, $decodedId);
        $data           = [];
        $i              = $start + 1;
        foreach ($items as $item) {
            $admin        = '<a href="' . base_url('Chrm/employee_payslip_permission?id=' . $encodedId . '&timesheetid=' . trim($item['timesheet_id'])) . '" class="btnclr btn m-b-5 m-r-2"><i class="fas fa-user-tie" aria-hidden="true"></i></a>';
            $timesheetinv = '<a href="' . base_url('Chrm/time_sheet_pdf?id=' . $encodedId . '&timesheetid=' . trim($item['timesheet_id'])) . '" class="btnclr btn m-b-5 m-r-2"><i class="fa fa-download" aria-hidden="true"></i></a>';
            $edit         = '<a href="' . base_url('Chrm/edit_timesheet?id=' . $encodedId . '&timesheetid=' . trim($item['timesheet_id'])) . '" class="btnclr btn m-b-5 m-r-2" data-toggle="tooltip" data-placement="left" title="' . display('update') . '"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            $delete       = '<a href="' . base_url('Chrm/timesheet_delete?id=' . $encodedId . '&timesheetid=' . trim($item['timesheet_id'])) . '"  class="btn btnclr" style="margin-bottom: 5px;"  data-toggle="tooltip"     onclick="return confirm(\'' . display('are_you_sure') . '\')"                data-placement="left" title="' . display('delete') . '"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
            $row          = [
                "id"           => $i,
                "first_name"   => $item['first_name'] . ' ' . $item['middle_name'] . ' ' . $item['last_name'],
                "job_title"    => $item['job_title'],
                "payroll_type" => $item['payroll_type'],
                "month"        => $item['month'],
                "uneditable"   => $item['uneditable'] == 0 ? '<span style="color: red;">Pending</span>' : '<span style="color: green;">Generated</span>',
                'action'       => $admin . $timesheetinv . $edit . $delete,
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
//Emloyee index -hr
    public function employee_details() {
        $employee_id            = isset($_GET['employee']) ? $_GET['employee'] : null;
        $encodedId              = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId              = decodeBase64UrlParameter($encodedId);
        $setting_detail         = $this->Web_settings->retrieve_setting_editdata($decodedId);
        $data['setting_detail'] = $setting_detail;
        $data['title']          = display('employee_update');
        $data['row']            = $this->Hrm_model->employee_detl($employee_id, $decodedId);
        $content                = $this->parser->parse('hr/resumepdf', $data, true);
        $this->template->full_admin_html_view($content);
    }


    public function timesheed_inserted_data() {
        $employee_id = isset($_GET['employee']) ? $_GET['employee'] : null;
        $encodedId   = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId   = decodeBase64UrlParameter($encodedId);
        $this->auth->check_admin_auth();
        $timesheet_data = $this->Hrm_model->timesheet_data($employee_id, $decodedId);
        $setting        = $this->Web_settings->retrieve_setting_editdata($decodedId);
        $dataw          = $this->invoice_design->retrieve_data($decodedId);
        $datacontent    = $this->invoice_content->retrieve_data($decodedId);
        $company_info   = $this->Ppurchases->retrieve_company($decodedId);
        $data           = array(
            'curn_info_default'      => $curn_info_default[0]['currency_name'],
            'currency'               => $currency_details[0]['currency'],
            'header'                 => $dataw[0]['header'],
            'logo'                   => (!empty($setting[0]['invoice_logo']) ? $setting[0]['invoice_logo'] : $company_info[0]['logo']),
            'color'                  => $dataw[0]['color'],
            'template'               => $dataw[0]['template'],
            'first_name'             => $timesheet_data[0]['first_name'],
            'id'                     => $timesheet_data[0]['id'],
            'last_name'              => $timesheet_data[0]['last_name'],
            'designation'            => $timesheet_data[0]['designation'],
            'phone'                  => $timesheet_data[0]['phone'],
            'photo'                  => $timesheet_data[0]['image'],
            'rate_type'              => $timesheet_data[0]['rate_type'],
            'hrate'                  => $timesheet_data[0]['hrate'],
            'email'                  => $timesheet_data[0]['email'],
            'blood_group'            => $timesheet_data[0]['blood_group'],
            'social_security_number' => $timesheet_data[0]['social_security_number'],
            'routing_number'         => $timesheet_data[0]['routing_number'],
            'address_line_1'         => $timesheet_data[0]['address_line_1'],
            'address_line_2'         => $timesheet_data[0]['address_line_2'],
            'country'                => $timesheet_data[0]['country'],
            'city'                   => $timesheet_data[0]['city'],
            'zip'                    => $timesheet_data[0]['zip'],
            'state'                  => $timesheet_data[0]['state'],
            'emergencycontact'       => $timesheet_data[0]['emergencycontact'],
            'emergencycontactnum'    => $timesheet_data[0]['emergencycontactnum'],
            'employee_type'          => $timesheet_data[0]['employee_type'],
            'employee_tax'           => $timesheet_data[0]['employee_tax'],
            'payroll_type'           => $timesheet_data[0]['payroll_type'],
            'state_tax'              => $timesheet_data[0]['state_tx'],
            'living_state_tax'       => $timesheet_data[0]['living_state_tax'],
            'bank_name'              => $timesheet_data[0]['bank_name'],
            'account_number'         => $timesheet_data[0]['account_number'],
            'sc'                     => $timesheet_data[0]['sc'],
            'files'                  => $timesheet_data[0]['files'],
            'invoice_data_info'      => $invoice_data_info,
            'company'                => (!empty($datacontent[0]['company_name']) ? $datacontent[0]['company_name'] : $company_info[0]['company_name']),
            'com_phone'              => (!empty($datacontent[0]['mobile']) ? $datacontent[0]['mobile'] : $company_info[0]['mobile']),
            'com_email'              => (!empty($datacontent[0]['email']) ? $datacontent[0]['email'] : $company_info[0]['email']),
            'website'                => (!empty($datacontent[0]['website']) ? $datacontent[0]['website'] : $company_info[0]['website']),
            'address'                => (!empty($datacontent[0]['address']) ? $datacontent[0]['address'] : $company_info[0]['address']),
        );
        $content = $this->load->view('hr/employe_timesheet_html', $data, true);
        $this->template->full_admin_html_view($content);
    }
//Add Employee form - hr
    public function add_employee() {
        $encodedId                   = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId                   = decodeBase64UrlParameter($encodedId);
        $currency_details            = $this->Web_settings->retrieve_setting_editdata($decodedId);
        $curn_info_default           = $this->Hrm_model->curn_info_default($currency_details[0]['currency'], $decodedId);
        $data['title']               = display('add_employee');
        $data['paytype']             = $this->Hrm_model->paytype_dropdown($decodedId);
        $data['citytx']              = $this->Hrm_model->city_tax_dropdown($decodedId);
        $data['cty_tax']             = $this->Hrm_model->city_tax($decodedId);
        $data['desig']               = $this->Hrm_model->designation_dropdown($decodedId);
        $data['get_info_city_tax']   = $this->Hrm_model->get_info_city_tax($decodedId);
        $data['get_info_county_tax'] = $this->Hrm_model->get_info_county_tax($decodedId);
        $data['state_tx']            = $this->Hrm_model->state_tax($decodedId);
        $data['encodedId']           = $decodedId;
        $data['decodedId']           = $encodedId;
        $data['setting_detail']      = $currency_details;
        $data['curn_info_default']   = $curn_info_default[0]['currency_name'];
        $data['currency']            = $currency_details[0]['currency'];
        $data['payroll_data']        = $this->Hrm_model->get_payroll_data($decodedId);
        $data['bank_data']           = $this->Hrm_model->get_bank_data($decodedId);
        $data['emp_data']            = $this->Hrm_model->get_emp_data($decodedId);
        $content                     = $this->parser->parse('hr/employee_form', $data, true);
        $this->template->full_admin_html_view($content);
    }


    public function UC_2a_form() {
        $data = array(
            'title' => 'uc_2a',
        );
        $content = $this->parser->parse("hr/uc_2aform.php", $data, true);
        $this->template->full_admin_html_view($content);
    }
    //WR30 - HR
    public function wr30_form() {
        $encodedId              = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId              = decodeBase64UrlParameter($encodedId);
        $data['get_cominfo']    = $this->Hrm_model->get_company_info($decodedId);
        $data['info_for_wr']    = $this->Hrm_model->info_for_wrf($decodedId);
        $data['overall_amount'] = $this->Hrm_model->total_amt_wr30($decodedId);
        $content                = $this->parser->parse("hr/wr30_form.php", $data, true);
        $this->template->full_admin_html_view($content);
    }
//employee Index -hr
    public function new_employee() {
        $encodedId       = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId       = decodeBase64UrlParameter($encodedId);
        $company_content = $this->invoice_content->retrieve_info_data();
        $company_info    = $this->Ppurchases->retrieve_company($decodedId);
        $setting         = $this->Web_settings->retrieve_setting_editdata($decodedId);
        $data            = array(
            "company_content" => $company_content,
            "logo"            => !empty($setting[0]["invoice_logo"]) ? $setting[0]["invoice_logo"] : $company_info[0]["logo"],
        );
        $content = $this->parser->parse('hr/new_employee_form', $data, true);
        $this->template->full_admin_html_view($content);
    }
//FNJ927 - hr
    public function formnj927($quarter = null, $decodedId) {
        $data = array(
            'title' => 'NJ927',
        );
        $data['info_for_nj']                       = $this->Hrm_model->info_for_nj($quarter, $decodedId);
        $data['info_info_for_salescommssion_data'] = $this->Hrm_model->info_info_for_salescommssion_data($quarter, $decodedId);
        $data['month']                             = $this->Hrm_model->fetchQuarterlyData($quarter, $decodedId);
        $data['get_cominfo']                       = $this->Hrm_model->get_company_info($decodedId);
        $data['income_tax']                        = $this->Hrm_model->Quarterone($quarter, $decodedId);
        $data['fristmonth']                        = $this->Hrm_model->fristmonth($quarter, $decodedId);
        $data['secondmonth']                       = $this->Hrm_model->secondmonth($quarter, $decodedId);
        $data['thirdmonth']                        = $this->Hrm_model->thirdmonth($quarter, $decodedId);
        $data['fourth']                            = $this->Hrm_model->fourth($quarter, $decodedId);
        $data['fifth']                             = $this->Hrm_model->fifth($quarter, $decodedId);
        $data['sixth']                             = $this->Hrm_model->sixth($quarter, $decodedId);
        $data['seventh']                           = $this->Hrm_model->seventh($quarter, $decodedId);
        $data['eigth']                             = $this->Hrm_model->eigth($quarter, $decodedId);
        $data['ninth']                             = $this->Hrm_model->ninth($quarter, $decodedId);
        $data['tenth']                             = $this->Hrm_model->tenth($quarter, $decodedId);
        $data['eleventh']                          = $this->Hrm_model->eleventh($quarter, $decodedId);
        $data['twelfth']                           = $this->Hrm_model->twelfth($quarter, $decodedId);
        $content                                   = $this->parser->parse("hr/formnj927", $data, true);
        $this->template->full_admin_html_view($content);
    }
// Employee - Hr
    public function employee_delete() {
        $employee_id = isset($_GET['employee']) ? $_GET['employee'] : null;
        $encodedId   = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId   = decodeBase64UrlParameter($encodedId);
        $this->load->model('Hrm_model');
        $this->Hrm_model->delete_employee($employee_id, $decodedId);
        $this->session->set_userdata(array('message' => display('successfully_delete')));
        redirect(base_url('Chrm/manage_employee?id=' . $_GET['id']));
    }
    public function state_summary() {
        $CI = &get_instance();
        $CI->load->model('Web_settings');
        $this->load->model('Hrm_model');
        $setting_detail                 = $CI->Web_settings->retrieve_setting_editdata();
        $data['setting_detail']         = $setting_detail;
        $tax_name                       = urldecode($this->input->post('url'));
        $emp_name                       = $this->input->post('employee_name');
        $taxType                        = $this->input->post('taxType');
        $date                           = $this->input->post('daterangepicker-field');
        $data['state_tax_list']         = $CI->Hrm_model->stateTaxlist();
        $data['state_summary_employee'] = $this->Hrm_model->state_summary_employee();
        $data['state_list']             = $this->db->select('*')->from('state_and_tax')->order_by('state', 'ASC')->where('created_by', $this->session->userdata('user_id'))->where('Status', 2)->where('Type','State')->group_by('id')->get()->result_array();
        $data['state_summary_employer'] = $this->Hrm_model->state_summary_employer();
        $data['emp_name']               = $this->db->select('*')->from('employee_history')->where('create_by', $this->session->userdata('user_id'))->get()->result_array();
        $employee_tax_data              = [];
        foreach ($state_summary_employee as $employee_tax) {
            $employee_tax_data[$employee_tax['time_sheet_id']][$employee_tax['tax_type'] . '_employee'] = $employee_tax['amount'];
        }
        foreach ($state_summary_employer as $employer_tax) {
            $employee_tax_data[$employer_tax['time_sheet_id']][$employer_tax['tax_type'] . '_employer'] = $employer_tax['amount'];
        }
        $data['employee_tax_data'] = $employee_tax_data;
        $content                   = $this->parser->parse('hr/reports/state_summary', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function OverallSummary(){
  $data['setting_detail']         = $this->Web_settings->retrieve_setting_editdata();
 $data['emp_name']=$this->db->select('*')->from('employee_history')->where('create_by', $this->session->userdata('user_id'))->get()->result_array();
  $content                   = $this->parser->parse('hr/reports/overall_state_summary', $data, true);
  $this->template->full_admin_html_view($content);
}
   public function state_tax_search_summary() {
    $CI = get_instance();
    $CI->load->model('Web_settings');
    $this->load->model('Hrm_model');
    $emp_name = $this->input->post('employee_name');
    $tax_choice = $this->input->post('tax_choice');
    $taxType = $this->input->post('taxType');
    $selectState = $this->input->post('selectState');
    $date = $this->input->post('daterangepicker-field');
    $state_summary_employer = $this->Hrm_model->state_summary_employer($emp_name, $tax_choice, $selectState, $date, $taxType);
    $state_summary_employee = $this->Hrm_model->state_summary_employee($emp_name, $tax_choice, $selectState, $date, $taxType);
    // Initialize arrays to store contributions
    $employer_contributions = [
        'state_tax' => [],
        'living_state_tax' => []
    ];
    $employee_contributions = [
        'state_tax' => [],
        'living_state_tax' => []
    ];
    // Organize employer contributions
    foreach ($state_summary_employer as $row) {
        $employee_name = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
        $tax_type = $row['tax_type'];
        $tax = $row['tax'];
        $code = $row['code'];
        $total_amount = $row['total_amount'];
        // Organize by tax type
        $employer_contributions[$tax_type][] = [
            'employee_name' => $employee_name,
            'tax' => $tax,
             'taxType' => $tax_type,
            'code'  => $code,
            'total_amount' => $total_amount
        ];
    }
    // Organize employee contributions
    foreach ($state_summary_employee as $row) {
        $employee_name = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
        $tax_type = $row['tax_type'];
        $tax = $row['tax'];
         $code = $row['code'];
        $total_amount = $row['total_amount'];
        // Organize by tax type
        $employee_contributions[$tax_type][] = [
            'employee_name' => $employee_name,
            'tax' => $tax,
             'code'  => $code,
               'taxType' => $tax_type,
            'total_amount' => $total_amount
        ];
    }
    // Sum similar taxes for each employee
foreach ($employer_contributions as $tax_type => &$contributions) {
    foreach ($contributions as &$contribution) {
        $employee_name = $contribution['employee_name'];
        $tax = $contribution['tax']; // Added tax type condition
        $sum = 0;
        foreach ($state_summary_employer as $row) {
          if ($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'] === $employee_name && $row['tax_type'] === $tax_type && $row['tax'] === $tax) {
                            $final_amount = '';
 
$final_amount = $row['total_amount'];       
            $sum +=   $final_amount;
            }
        }
        $contribution['total_amount'] = $sum;
    }
}
// Sum total amounts for employee contributions
foreach ($employee_contributions as $tax_type => &$contributions) {
    foreach ($contributions as &$contribution) {
        $employee_name = $contribution['employee_name'];
        $tax = $contribution['tax']; // Added tax type condition
        $sum = 0;
        foreach ($state_summary_employee as $row) {
            if ($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'] === $employee_name && $row['tax_type'] === $tax_type && $row['tax'] === $tax) {
                                       $final_amount = '';
 
$final_amount = $row['total_amount'];  
              $sum += $final_amount;
            }
        }
        $contribution['total_amount'] = $sum;
    }
}
    // Construct the response array
    $responseData = [
        'employer_contribution' => $employee_contributions,
        'employee_contribution' =>$employer_contributions 
    ];
    // Encode the response array to JSON
    $jsonData = json_encode($responseData, JSON_PRETTY_PRINT);
    // Output the JSON data
    echo $jsonData;
}
    public function state_tax_search() {
        $CI = &get_instance();
        $CI->load->model('Web_settings');
        $this->load->model('Hrm_model');
        $tax_name               = trim(urldecode($this->input->post('url')));
        $date                   = $this->input->post('daterangepicker-field');
        $employee_name          = $this->input->post('employee_name');
        $employee_contributions = $this->fetch_contributions($employee_name, $tax_name, $date);
        $employer_contributions = $this->fetch_contributions($employee_name, $tax_name, $date);
        $merged_array           = $this->merge_contributions($employee_contributions, $employer_contributions);
        header('Content-Type: application/json');
        echo json_encode($merged_array);
    }
    private function fetch_contributions($employee_name, $tax_name, $date) {
        $state_tax_report = $is_employer ?
        $this->Hrm_model->employer_state_tax_report($employee_name, $tax_name, $date) :
        $this->Hrm_model->state_tax_report($employee_name, $tax_name, $date);
        $living_state_tax_report = $is_employer ?
        $this->Hrm_model->employer_living_state_tax_report($employee_name, $tax_name, $date) :
        $this->Hrm_model->living_state_tax_report($employee_name, $tax_name, $date);
        $merged_array = [];
        foreach ($state_tax_report as $state_tax) {
            $time_sheet_id                               = $state_tax['time_sheet_id'];
            $merged_array[$time_sheet_id]['state_tax'][] = $state_tax;
        }
        foreach ($living_state_tax_report as $living_state_tax) {
            $time_sheet_id                                      = $living_state_tax['time_sheet_id'];
            $merged_array[$time_sheet_id]['living_state_tax'][] = $living_state_tax;
        }
        return $merged_array;
    }
    private function merge_contributions($employee_contributions, $employer_contributions) {
        $merged_array = [];
        foreach ($employee_contributions as $time_sheet_id => $employee_data) {
            $merged_array[$time_sheet_id] = ['employee' => $employee_data];
            if (isset($employer_contributions[$time_sheet_id])) {
                $merged_array[$time_sheet_id]['employer'] = $employer_contributions[$time_sheet_id];
            }
        }
        return $merged_array;
    }


    // Old State Income Tax - Madhu
    public function report($tax_name = '') 
    {
        $CI = & get_instance();
        $CI->load->model('Web_settings');
        $this->load->model('Hrm_model');
        $tax_name = urldecode($tax_name);
        $data['employee_data'] = $this->Hrm_model->employee_data_get();
        $setting_detail = $CI->Web_settings->retrieve_setting_editdata();
        $data['setting_detail'] = $setting_detail;
        $date = $this->input->post('daterangepicker-field');
        $employee_name = $this->input->post('employee_name');
        $data['tax_n'] = $tax_name;

        if (!empty($tax_name)) {
            $data['state_tax_report'] = $this->Hrm_model->statetaxreport($employee_name, $tax_name, $date);
            //print_r($data['state_tax_report']); exit;
            $data['living_state_tax_report'] = $this->Hrm_model->living_state_tax_report($employee_name, $tax_name, $date);
            $merged_array = [];
            foreach ($data['state_tax_report'] as $state_tax) {
                $time_sheet_id = $state_tax['time_sheet_id'];
                $merged_array[$time_sheet_id]['state_tax'][] = $state_tax;
            }
            foreach ($data['living_state_tax_report'] as $living_state_tax) {
                $time_sheet_id = $living_state_tax['time_sheet_id'];
                $merged_array[$time_sheet_id]['living_state_tax'][] = $living_state_tax;
            }
            $data['merged_reports'] = $merged_array;
            $data['employer_state_tax_report'] = $this->Hrm_model->employer_state_tax_report($employee_name, $tax_name, $date);
            $data['employer_living_state_tax_report'] = $this->Hrm_model->employer_living_state_tax_report($employee_name, $tax_name, $date);

            if (empty($data['employer_state_tax_report'])) {
                $data['employer_state_tax_report'] = $data['employer_living_state_tax_report'];
            }

            if (empty($data['employer_living_state_tax_report'])) {
                $data['employer_living_state_tax_report'] = $data['employer_state_tax_report'];
            }


            $merged_array_employer = [];
            foreach ($data['employer_state_tax_report'] as $state_tax) {
                $time_sheet_id = $state_tax['time_sheet_id'];
                $merged_array_employer[$time_sheet_id]['state_tax'][] = $state_tax;
            }
            foreach ($data['employer_living_state_tax_report'] as $living_state_tax) {
                $time_sheet_id = $living_state_tax['time_sheet_id'];
                $merged_array_employer[$time_sheet_id]['living_state_tax'][] = $living_state_tax;
            }

            $data['merged_reports_employer'] = $merged_array_employer;
            $content = $this->parser->parse('hr/reports/state_report', $data, true);
            $this->template->full_admin_html_view($content);
        }
    }


    // Fetch data in State Income Tax Index - Madhu
    public function stateIncomeReportData()
    {   
        $encodedId     = isset($_GET["id"]) ? $_GET["id"] : null;
        $decodedId     = decodeBase64UrlParameter($encodedId);

        $limit          = $this->input->post("length");
        $start          = $this->input->post("start");
        $search         = $this->input->post("search")["value"];
        $orderField     = $this->input->post("columns")[$this->input->post("order")[0]["column"]]["data"];
        $orderDirection = $this->input->post("order")[0]["dir"];
        $date           = $this->input->post("federal_date_search");
        $employee_name  = $this->input->post('employee_name');
        $taxname = $this->input->post('taxname');

        $orderDirection = strtolower($orderDirection);
        if (!in_array($orderDirection, ['asc', 'desc'])) {
            $orderDirection = 'asc';
        }

        $stateTaxReport = $this->Hrm_model->state_tax_report($limit, $start, $orderField, $orderDirection, $search, $taxname, $date, $employee_name,$decodedId);

        $totalItems  = $this->Hrm_model->getTotalIncomeTax($search,$date,$emp_name,$decodedId,$taxname);
        $livingStateTaxReport = $this->Hrm_model->living_state_tax_report($employee_name, $taxname, $date);
        $employerStateTaxReport = $this->Hrm_model->employer_state_tax_report($employee_name, $taxname, $date);
        $employerLivingStateTaxReport = $this->Hrm_model->employer_living_state_tax_report($employee_name,$taxname, $date);

        $mergedArray = [];

        foreach ($stateTaxReport as $stateTax) {
            $timeSheetId = $stateTax['time_sheet_id'];
            if (!isset($mergedArray[$timeSheetId])) {
                $mergedArray[$timeSheetId] = [];
            }
            $mergedArray[$timeSheetId]['state_tax'][] = $stateTax;
        }

        foreach ($livingStateTaxReport as $livingStateTax) {
            $timeSheetId = $livingStateTax['time_sheet_id'];
            if (!isset($mergedArray[$timeSheetId])) {
                $mergedArray[$timeSheetId] = [];
            }
            $mergedArray[$timeSheetId]['living_state_tax'][] = $livingStateTax;
        }

        foreach ($employerStateTaxReport as $stateTax) {
            $timeSheetId = $stateTax['time_sheet_id'];
            if (!isset($mergedArray[$timeSheetId])) {
                $mergedArray[$timeSheetId] = [];
            }
            $mergedArray[$timeSheetId]['employer_state_tax'][] = $stateTax;
        }

        foreach ($employerLivingStateTaxReport as $livingStateTax) {
            $timeSheetId = $livingStateTax['time_sheet_id'];
            if (!isset($mergedArray[$timeSheetId])) {
                $mergedArray[$timeSheetId] = [];
            }
            $mergedArray[$timeSheetId]['employer_living_state_tax'][] = $livingStateTax;
        }

        $data = [];
        $i = $start + 1;
        $final_amount = '';
        foreach ($mergedArray as $timeSheetId => $report) { 
            $stateTax = $report['state_tax'][0] ?? [];
            $livingStateTax = $report['living_state_tax'][0] ?? [];
            // $employerStateTax = $report['employer_state_tax'][0] ?? [];
            // $employerLivingStateTax = $report['employer_living_state_tax'][0] ?? [];

            if ($report['weekly'] > 0) {
                $final_amount = $report['weekly'];
            } elseif ($report['biweekly'] > 0) {
                $final_amount = $report['biweekly'];
            } elseif ($report['monthly'] > 0) {
                $final_amount = $report['monthly'];
            } else {
                $final_amount = $report['amount'];
            }

            $found_employer_state_tax = $report['employer_state_tax'] ?? [];
            $found_employer_living_state_tax = $report['living_state_tax'] ?? [];

            $employer_state_tax_amount = 0;
            $employer_living_state_tax_amount = 0;

            foreach ($found_employer_state_tax as $employer_state_tax) {
                $employer_state_tax_amount += isset($employer_state_tax['amount']) ? $employer_state_tax['amount'] : 0;
            }
          
            foreach ($found_employer_living_state_tax as $employer_living_state_tax) {
                $employer_living_state_tax_amount += isset($employer_living_state_tax['amount']) ? $employer_living_state_tax['amount'] : 0;
            }

            $row = [
                'table_id'      => $i,
                "first_name"    => ($stateTax['first_name'] ?? '') . ' ' . ($stateTax['middle_name'] ?? '') . ' ' . ($stateTax['last_name'] ?? ''),
                "employee_tax"  => $stateTax['employee_tax'] ?? '',
                'state_tx'      => $stateTax['state_tx'] ?? '',
                'living_state_tax' => $stateTax['living_state_tax'] ?? '',
                'time_sheet_id' => $timeSheetId,
                "month"         => $stateTax['month'] ?? '',
                "cheque_date"   => $stateTax['cheque_date'] ?? '',
                "amount"        => $stateTax['amount'] ?? 0,
                "weekly"        => $livingStateTax['amount'] ?? 0,
                "employer_tax"   => number_format($employer_state_tax_amount ?? 0, 3),  
                "employer_weekly" => number_format($employer_state_tax_amount ?? 0, 3),
            ];

            if (trim($row['first_name']) !== '' && trim($row['employee_tax']) !== '') {
                $data[] = $row;
                $i++;
            }
        }

        $response = [
            "draw"            => $this->input->post("draw"),
            "recordsTotal"    => $totalItems,
            "recordsFiltered" => $totalItems,
            "data"            => $data,
        ];

        echo json_encode($response);
    }

    public function report_state_search($tax_name = '') {
        $CI =  & get_instance();
        $CI->load->model('Web_settings');
        $this->load->model('Hrm_model');
        $tax_name               = $_POST['url'];
        $data['employee_data']  = $this->Hrm_model->employee_data_get();
        $setting_detail         = $CI->Web_settings->retrieve_setting_editdata();
        $data['setting_detail'] = $setting_detail;
        $date                   = $_POST['daterangepicker-field'];
        $employee_name          = $_POST['employee_name'];
        $data['tax_n']          = $tax_name;
        if (!empty($tax_name)) {
            $data['state_tax_report']        = $this->Hrm_model->state_tax_report($employee_name, $tax_name, $date);
            $data['living_state_tax_report'] = $this->Hrm_model->living_state_tax_report($employee_name, $tax_name, $date);
            $merged_array                    = [];
            foreach ($data['state_tax_report'] as $state_tax) {
                $time_sheet_id                               = $state_tax['time_sheet_id'];
                $merged_array[$time_sheet_id]['state_tax'][] = $state_tax;
            }
            foreach ($data['living_state_tax_report'] as $living_state_tax) {
                $time_sheet_id                                      = $living_state_tax['time_sheet_id'];
                $merged_array[$time_sheet_id]['living_state_tax'][] = $living_state_tax;
            }
            $data['merged_reports']                   = $merged_array;
            $data['employer_state_tax_report']        = $this->Hrm_model->employer_state_tax_report($employee_name, $tax_name, $date);
            $data['employer_living_state_tax_report'] = $this->Hrm_model->employer_living_state_tax_report($employee_name, $tax_name, $date);
            $merged_array_employer                    = [];
            foreach ($data['employer_state_tax_report'] as $state_tax) {
                $time_sheet_id                                        = $state_tax['time_sheet_id'];
                $merged_array_employer[$time_sheet_id]['state_tax'][] = $state_tax;
            }
            foreach ($data['employer_living_state_tax_report'] as $living_state_tax) {
                $time_sheet_id                                               = $living_state_tax['time_sheet_id'];
                $merged_array_employer[$time_sheet_id]['living_state_tax'][] = $living_state_tax;
            }
            $data['merged_reports_employer'] = $merged_array_employer;
            $content                         = $this->parser->parse('hr/reports/state_report', $data, true);
            $this->template->full_admin_html_view($content);
        }
    }
    public function other_tax() {
        $CI =  & get_instance();
        $CI->load->model('Web_settings');
        $this->load->model('Hrm_model');
        $data['employee_data']  = $this->Hrm_model->employee_data_get();
        $setting_detail         = $CI->Web_settings->retrieve_setting_editdata();
        $data['setting_detail'] = $setting_detail;
        $employee_other_tax     = $this->Hrm_model->other_tax_report();
        $employer_other_tax     = $this->Hrm_model->other_tax_employer_report();
        $merged_array           = [];
        foreach ($employee_other_tax as $employee_tax) {
            $time_sheet_id                                        = $employee_tax['time_sheet_id'];
            $merged_array[$time_sheet_id]['employee_other_tax'][] = $employee_tax;
        }
        foreach ($employer_other_tax as $employer_tax) {
            $time_sheet_id                                        = $employer_tax['time_sheet_id'];
            $merged_array[$time_sheet_id]['employer_other_tax'][] = $employer_tax;
        }
        $data['merged_reports'] = $merged_array;
        $content                = $this->parser->parse('hr/reports/other_tax', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function other_tax_search() {
        $CI =  & get_instance();
        $CI->load->model('Web_settings');
        $this->load->model('Hrm_model');
        $emp_name               = $this->input->post('employee_name');
        $date                   = $this->input->post('daterangepicker-field');
        $data['employee_data']  = $this->Hrm_model->employee_data_get();
        $setting_detail         = $CI->Web_settings->retrieve_setting_editdata();
        $data['setting_detail'] = $setting_detail;
        $employee_other_tax     = $this->Hrm_model->other_tax_report_search($emp_name, $date);
        $employer_other_tax     = $this->Hrm_model->other_tax_employer_report_search($emp_name, $date);
        $merged_array           = [];
        foreach ($employee_other_tax as $employee_tax) {
            $time_sheet_id                                        = $employee_tax['time_sheet_id'];
            $merged_array[$time_sheet_id]['employee_other_tax'][] = $employee_tax;
        }
        foreach ($employer_other_tax as $employer_tax) {
            $time_sheet_id                                        = $employer_tax['time_sheet_id'];
            $merged_array[$time_sheet_id]['employer_other_tax'][] = $employer_tax;
        }
        $data['merged_reports'] = $merged_array;
        echo json_encode($data['merged_reports']);
    }

    // Old Federal Tax - Madhu
    public function federal_tax_report() {
        $CI =  & get_instance();
        $CI->load->model('Web_settings');
        $this->load->model('Hrm_model');
        $setting_detail         = $CI->Web_settings->retrieve_setting_editdata();
        $emp_name               = $this->input->post('employee_name');
        $data['setting_detail'] = $setting_detail;
        $date                   = $this->input->post('daterangepicker-field');
        $split                  = explode(" - ", $date);
        $data['start']          = isset($split[0]) ? $split[0] : null;
        $data['end']            = isset($split[1]) ? $split[1] : null;
        $data['fed_tax']        = $this->Hrm_model->employe($emp_name, $date);
        $data['fed_tax_emplr']  = $this->Hrm_model->employr($emp_name, $date);
        $data['employee_data']  = $this->Hrm_model->employee_data_get();
        $content                = $this->parser->parse('hr/reports/fed_income_tax_report', $data, true);
        $this->template->full_admin_html_view($content);
    }

    // Fetch data in Income Tax Index - Madhu
    public function federaIndexData()
    {   
        $encodedId     = isset($_GET["id"]) ? $_GET["id"] : null;
        $decodedId     = decodeBase64UrlParameter($encodedId);

        $limit          = $this->input->post("length");
        $start          = $this->input->post("start");
        $search         = $this->input->post("search")["value"];
        $orderField     = $this->input->post("columns")[$this->input->post("order")[0]["column"]]["data"];
        $orderDirection = $this->input->post("order")[0]["dir"];
        $date           = $this->input->post("federal_date_search");
        $emp_name       = $this->input->post('employee_name');
        $items          = $this->Hrm_model->getPaginatedfederalincometax($limit,$start,$orderField,$orderDirection,$search,$date,$emp_name, $decodedId);
        $totalItems     = $this->Hrm_model->getTotalfederalincometax($search,$date,$emp_name,$decodedId);
        $fed_tax_emplr  = $this->Hrm_model->employr($emp_name,$date);
        $data           = [];
        $i              = $start + 1;
        $edit           = "";
        $delete         = "";
        foreach ($items as $item) {
            $s_stax_emplr = isset($fed_tax_emplr[$i]['f_ftax']) ? $fed_tax_emplr[$i]['f_ftax'] : 0;
            $row = [
                'table_id'      => $i,
                "first_name"    => $item["first_name"] .' '. $item["middle_name"].' '. $item["last_name"],
                "employee_tax"  => $item["employee_tax"],
                "timesheet_id"  => $item["timesheet_id"],
                "month"         => $item["month"],
                "cheque_date"   => $item["cheque_date"],
                "f_ftax" => !empty($item['f_ftax']) ? number_format($item['f_ftax'], 2) : '0.00',
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

    // Old Social Security - Madhu
    public function social_tax_report() 
    {
        $CI =  & get_instance();
        $CI->load->model('Web_settings');
        $this->load->model('Hrm_model');
        $setting_detail         = $CI->Web_settings->retrieve_setting_editdata();
        $emp_name               = $this->input->post('employee_name');
        $data['setting_detail'] = $setting_detail;
        $date                   = $this->input->post('daterangepicker-field');
        $split                  = explode(" - ", $date);
        $data['start']          = isset($split[0]) ? $split[0] : null;
        $data['end']            = isset($split[1]) ? $split[1] : null;
        $data['fed_tax']        = $this->Hrm_model->employe($emp_name, $date);
        $data['fed_tax_emplr']  = $this->Hrm_model->employr($emp_name, $date);
        $data['employee_data']  = $this->Hrm_model->employee_data_get();
        $content                = $this->parser->parse('hr/reports/social_security_tax', $data, true);
        $this->template->full_admin_html_view($content);
    }


    // Fetch data in Security Income Tax - Madhu
    public function securitytaxIndexData()
    {   
        $encodedId     = isset($_GET["id"]) ? $_GET["id"] : null;
        $decodedId     = decodeBase64UrlParameter($encodedId);

        $limit          = $this->input->post("length");
        $start          = $this->input->post("start");
        $search         = $this->input->post("search")["value"];
        $orderField     = $this->input->post("columns")[$this->input->post("order")[0]["column"]]["data"];
        $orderDirection = $this->input->post("order")[0]["dir"];
        $date           = $this->input->post("federal_date_search");
        $emp_name       = $this->input->post('employee_name');
        $items          = $this->Hrm_model->getPaginatedfederalincometax($limit,$start,$orderField,$orderDirection,$search,$date,$emp_name,$decodedId);
        $totalItems     = $this->Hrm_model->getTotalfederalincometax($search,$date,$emp_name,$decodedId);
        $fed_tax_emplr  = $this->Hrm_model->employr($emp_name,$date);
        $data           = [];
        $i              = $start + 1;
        $edit           = "";
        $delete         = "";
        $merged_results = [];
        $tax_map = [];
        foreach ($fed_tax_emplr as $tax_entry) {
            $tax_map[$tax_entry['timesheet']] = $tax_entry; 
        }

        foreach ($items as $item) {
            $timesheet_id = $item['timesheet'];
            
            if (isset($tax_map[$timesheet_id])) {
                $merged_results[] = array_merge($item, $tax_map[$timesheet_id]);
            } else {
                $merged_results[] = $item; 
            }
        }

        foreach ($merged_results as $key => $item) { 


            $row = [
                'table_id'      => $i,
                "first_name"    => $item["first_name"] .' '. $item["middle_name"].' '. $item["last_name"],
                "employee_tax"  => $item["employee_tax"],
                "timesheet_id"  => $item["timesheet"],
                "month"         => $item["month"],
                "cheque_date"   => $item["cheque_date"],
                "s_stax"        => number_format($item['s_tax'], 2),
                "ts_stax"       => number_format($item['s_stax'], 2),
            ];
            $data[] = $row;
            $i++;
            $index++;
        }

        $response = [
            "draw"            => $this->input->post("draw"),
            "recordsTotal"    => $totalItems,
            "recordsFiltered" => $totalItems,
            "data"            => $data,
        ];
        echo json_encode($response);
    }
    
    // Old Medicare Tax - Madhu
    public function medicare_tax_report() 
    {
        $CI =  & get_instance();
        $CI->load->model('Web_settings');
        $this->load->model('Hrm_model');
        $setting_detail         = $CI->Web_settings->retrieve_setting_editdata();
        $emp_name               = $this->input->post('employee_name');
        $data['setting_detail'] = $setting_detail;
        $date                   = $this->input->post('daterangepicker-field');
        $split                  = explode(" - ", $date);
        $data['start']          = isset($split[0]) ? $split[0] : null;
        $data['end']            = isset($split[1]) ? $split[1] : null;
        $data['fed_tax']        = $this->Hrm_model->employe($emp_name, $date);
        $data['fed_tax_emplr']  = $this->Hrm_model->employr($emp_name, $date);
        $data['employee_data']  = $this->Hrm_model->employee_data_get();
        $content                = $this->parser->parse('hr/reports/medicare_tax', $data, true);
        $this->template->full_admin_html_view($content);
    }

    // Fetch data in Medicare Tax - Madhu
    public function medicaretaxIndexData()
    {   
        $encodedId     = isset($_GET["id"]) ? $_GET["id"] : null;
        $decodedId     = decodeBase64UrlParameter($encodedId);

        $limit          = $this->input->post("length");
        $start          = $this->input->post("start");
        $search         = $this->input->post("search")["value"];
        $orderField     = $this->input->post("columns")[$this->input->post("order")[0]["column"]]["data"];
        $orderDirection = $this->input->post("order")[0]["dir"];
        $date           = $this->input->post("federal_date_search");
        $emp_name       = $this->input->post('employee_name');
        $items          = $this->Hrm_model->getPaginatedfederalincometax($limit,$start,$orderField,$orderDirection,$search,$date,$emp_name,$decodedId);
        $totalItems     = $this->Hrm_model->getTotalfederalincometax($search,$date,$emp_name,$decodedId);
        $fed_tax_emplr  = $this->Hrm_model->employr($emp_name,$date);
        $data           = [];
        $i              = $start + 1;
        $edit           = "";
        $delete         = "";
        $merged_results = [];

        $tax_map = [];
        foreach ($fed_tax_emplr as $tax_entry) {
            $tax_map[$tax_entry['timesheet']] = $tax_entry; 
        }

        foreach ($items as $item) {
            $timesheet_id = $item['timesheet'];
            
            if (isset($tax_map[$timesheet_id])) {
                $merged_results[] = array_merge($item, $tax_map[$timesheet_id]);
            } else {
                $merged_results[] = $item; 
            }
        }

        foreach ($merged_results as $key => $item) { 

            $row = [
                'table_id'      => $i,
                "first_name"    => $item["first_name"] .' '. $item["middle_name"].' '. $item["last_name"],
                "employee_tax"  => $item["employee_tax"],
                "timesheet_id"  => $item["timesheet"],
                "month"         => $item["month"],
                "cheque_date"   => $item["cheque_date"],
                "m_mtax"        => number_format($item['m_tax'], 2),
                "tm_mtax"       => number_format($item['m_mtax'], 2),
            ];
            $data[] = $row;
            $i++;
            $index++;
        }
        $response = [
            "draw"            => $this->input->post("draw"),
            "recordsTotal"    => $totalItems,
            "recordsFiltered" => $totalItems,
            "data"            => $data,
        ];
        echo json_encode($response);
    }

    // Old Unemployment Tax - Madhu
    public function unemployment_tax_report() 
    {
        $CI =  & get_instance();
        $CI->load->model('Web_settings');
        $this->load->model('Hrm_model');
        $setting_detail         = $CI->Web_settings->retrieve_setting_editdata();
        $emp_name               = $this->input->post('employee_name');
        $data['setting_detail'] = $setting_detail;
        $date                   = $this->input->post('daterangepicker-field');
        $split                  = explode(" - ", $date);
        $data['start']          = isset($split[0]) ? $split[0] : null;
        $data['end']            = isset($split[1]) ? $split[1] : null;
        $data['fed_tax']        = $this->Hrm_model->employe($emp_name, $date);
        $data['fed_tax_emplr']  = $this->Hrm_model->employr($emp_name, $date);
        $data['employee_data']  = $this->Hrm_model->employee_data_get();
        $content                = $this->parser->parse('hr/reports/unemployment_tax', $data, true);
        $this->template->full_admin_html_view($content);
    } 

    // Fetch data in Medicare Tax - Madhu
    public function unemploymenttaxIndexData()
    {   
        $encodedId     = isset($_GET["id"]) ? $_GET["id"] : null;
        $decodedId     = decodeBase64UrlParameter($encodedId);

        $limit          = $this->input->post("length");
        $start          = $this->input->post("start");
        $search         = $this->input->post("search")["value"];
        $orderField     = $this->input->post("columns")[$this->input->post("order")[0]["column"]]["data"];
        $orderDirection = $this->input->post("order")[0]["dir"];
        $date           = $this->input->post("federal_date_search");
        $emp_name       = $this->input->post('employee_name');
        $items          = $this->Hrm_model->getPaginatedfederalincometax($limit,$start,$orderField,$orderDirection,$search,$date,$emp_name,$decodedId);
        $totalItems     = $this->Hrm_model->getTotalfederalincometax($search,$date,$emp_name,$decodedId);
        $fed_tax_emplr  = $this->Hrm_model->employr($emp_name,$date);
        $data           = [];
        $i              = $start + 1;
        $edit           = "";
        $delete         = "";
        foreach ($items as $item) {
            $s_stax_emplr = isset($fed_tax_emplr[$i]['u_utax']) ? $fed_tax_emplr[$i]['u_utax'] : 0;
            $row = [
                'table_id'      => $i,
                "first_name"    => $item["first_name"] .' '. $item["middle_name"].' '. $item["last_name"],
                "employee_tax"  => $item["employee_tax"],
                "timesheet_id"  => $item["timesheet_id"],
                "month"         => $item["month"],
                "cheque_date"   => $item["cheque_date"],
                "u_utax"        => number_format($item['u_utax'], 2),
                "tu_utax"        => number_format($s_stax_emplr, 2),
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

    // Old Federal Overall Summary - Madhu
    public function federal_summary() {
        $CI =  & get_instance();
        $CI->load->model('Web_settings');
        $this->load->model('Hrm_model');
        $setting_detail                 = $CI->Web_settings->retrieve_setting_editdata();
        $data['setting_detail']         = $setting_detail;
        $data['fed_tax']                = $this->Hrm_model->social_tax_sumary();
        $data['fed_tax_emplr']          = $this->Hrm_model->social_tax_employer();
        $data['state_tax_list']         = $CI->Hrm_model->stateTaxlist();
        $data['state_summary_employee'] = $this->Hrm_model->state_summary_employee();
        $data['state_list']             = $this->db->select('*')->from('state_and_tax')->order_by('state', 'ASC')->where('created_by', $this->session->userdata('user_id'))->where('Status', 2)->group_by('id')->get()->result_array();
        $mergedArray                    = array();
        foreach ($data['fed_tax'] as $item1) {
            $mergedItem = $item1;
            foreach ($data['fed_tax_emplr'] as $item2) {
                if ($item1['templ_name'] == $item2['employee_id']) {
                    foreach ($item2 as $key => $value) {
                        if (!isset($mergedItem[$key])) {
                            $mergedItem[$key] = $value;
                        }
                    }
                    $mergedArray[] = $mergedItem;
                    break;
                }
            }
        }
        $data['mergedArray']   = $mergedArray;
         // print_r($data['mergedArray']);
        $data['employee_data'] = $this->Hrm_model->employee_data_get();
        $content               = $this->parser->parse('hr/reports/federal_summary', $data, true);
        $this->template->full_admin_html_view($content);
    }

     // New Federal Overall Summary - Madhu
    public function federalsummary() {
        $CI =  & get_instance();
        $CI->load->model('Web_settings');
        $this->load->model('Hrm_model');
        $setting_detail                 = $CI->Web_settings->retrieve_setting_editdata();
        $data['setting_detail']         = $setting_detail;
        $data['fed_tax']                = $this->Hrm_model->social_tax_sumary();
        $data['fed_tax_emplr']          = $this->Hrm_model->social_tax_employer();
        $data['state_tax_list']         = $CI->Hrm_model->stateTaxlist();
        $data['state_summary_employee'] = $this->Hrm_model->state_summary_employee();
        $data['state_list']             = $this->db->select('*')->from('state_and_tax')->order_by('state', 'ASC')->where('created_by', $this->session->userdata('user_id'))->where('Status', 2)->group_by('id')->get()->result_array();
        $mergedArray                    = array();
        foreach ($data['fed_tax'] as $item1) {
            $mergedItem = $item1;
            foreach ($data['fed_tax_emplr'] as $item2) {
                if ($item1['templ_name'] == $item2['employee_id']) {
                    foreach ($item2 as $key => $value) {
                        if (!isset($mergedItem[$key])) {
                            $mergedItem[$key] = $value;
                        }
                    }
                    $mergedArray[] = $mergedItem;
                    break;
                }
            }
        }
        $data['mergedArray']   = $mergedArray;
         // print_r($data['mergedArray']);
        $data['employee_data'] = $this->Hrm_model->employee_data_get();
        $content               = $this->parser->parse('hr/reports/test', $data, true);
        $this->template->full_admin_html_view($content);
    }
    

    // Fetch data in Overall Social Tax - Madhu
    public function overallSocialtaxIndexData()
    {   
        $encodedId     = isset($_GET["id"]) ? $_GET["id"] : null;
        $decodedId     = decodeBase64UrlParameter($encodedId);

        $limit          = $this->input->post("length");
        $start          = $this->input->post("start");
        $search         = $this->input->post("search")["value"];
        $orderField     = $this->input->post("columns")[$this->input->post("order")[0]["column"]]["data"];
        $orderDirection = $this->input->post("order")[0]["dir"];
        $date           = $this->input->post("federal_date_search");
        $emp_name       = $this->input->post('employee_name');
        
        $items          = $this->Hrm_model->getPaginatedSocialTaxSummary($limit, $start, $orderField, $orderDirection, $search, $date, $emp_name,$decodedId);
        $totalItems     = $this->Hrm_model->getSocialOveralltax($search, $date, $emp_name,$decodedId);
        
        $fed_tax        = $this->Hrm_model->social_tax_sumary($date, $emp_name);
        $fed_tax_emplr  = $this->Hrm_model->social_tax_employer($date, $emp_name);

        $mergedArray = [];
        foreach ($fed_tax as $item1) {
            $mergedArray[$item1['employee_id']] = $item1; 
        }

        foreach ($fed_tax_emplr as $item2) {
            if (isset($mergedArray[$item2['employee_id']])) {
                foreach ($item2 as $key => $value) {
                    if (!isset($mergedArray[$item2['employee_id']][$key])) {
                        $mergedArray[$item2['employee_id']][$key] = $value;
                    }
                }
            }
        }

        $data = [];
        $i    = $start + 1;

        foreach ($items as $item) {
            $employeeId = $item["employee_id"];
            $mergedItem = $mergedArray[$employeeId] ?? [];

            $row = [
                'table_id'      => $i,
                "first_name"    => $item["first_name"] .' '. $item["middle_name"].' '. $item["last_name"],
                "employee_tax"  => $item["employee_tax"],
                "cheque_date"   => $item["cheque_date"],

                'f_employee'    => number_format($mergedItem['f_ftax_sum'] ?? 0, 2),
                'f_employer'    => number_format($mergedItem['f_ftax_sum_er'] ?? 0, 2),

                'socialsecurity_employee' => number_format($mergedItem['s_stax_sum'] ?? 0, 2),
                'socialsecurity_employer' => number_format($mergedItem['s_stax_sum_er'] ?? 0, 2),

                'medicare_employee' => number_format($mergedItem['m_mtax_sum'] ?? 0, 2),
                'medicare_employer' => number_format($mergedItem['m_mtax_sum_er'] ?? 0, 2),

                'unemployment_employee' => number_format($mergedItem['u_utax_sum'] ?? 0, 2),
                'unemployment_employer' => number_format($mergedItem['u_utax_sum_er'] ?? 0, 2),
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


    public function federal_tax_report_search() {
        $CI =  & get_instance();
        $CI->load->model('Web_settings');
        $this->load->model('Hrm_model');
        $emp_name    = $this->input->post('employee_name');
        $date        = $this->input->post('daterangepicker-field');
        $status      = $this->input->post('status');
        $data['tax'] = $this->Hrm_model->federal_tax_report($emp_name, $date, $status);
        echo json_encode($data['tax']);
    }
    
    public function social_tax_report_search() {
        $CI =  & get_instance();
        $CI->load->model('Web_settings');
        $this->load->model('Hrm_model');
        $emp_name          = $this->input->post('employee_name');
        $tax_choice        = $this->input->post('tax_choice');
        $selectState       = $this->input->post('selectState');
        $taxType           = $this->input->post('taxType');
        $date              = $this->input->post('daterangepicker-field');
        $data['emplr_tax'] = $this->Hrm_model->social_tax_report($emp_name, $tax_choice, $selectState, $taxType, $date);
        $data['emple_tax'] = $this->Hrm_model->social_tax_employee_report($emp_name, $tax_choice, $selectState, $taxType, $date);
        $mergedArray       = array_merge($data['emplr_tax'], $data['emple_tax']);
        print_r($mergedArray);
        echo json_encode($mergedArray);
    }
  public function social_taxsearch(){
      $CI = & get_instance();
      $CI->load->model('Web_settings');
      $this->load->model('Hrm_model');
      $emp_name = trim($this->input->post('employee_name'));
      $date = $this->input->post('daterangepicker-field');
      $setting_detail = $CI->Web_settings->retrieve_setting_editdata();
      $data['setting_detail']            = $setting_detail;
      $data['employe'] = $this->Hrm_model->so_tax_report_employee($emp_name,$date,$status);
      $data['employer'] = $this->Hrm_model->so_tax_report_employer($emp_name, $date, $status);
      if ($data['employe']) {
        $aggregated = [];
        $aggregated_employe = [];
        foreach ($data['employe'] as $row) {
            $key = $row['first_name'] . '|' . $row['middle_name'] . '|' . $row['last_name'] . '|' . $row['employee_tax'];
            if (!isset($aggregated_employe[$key])) {
                $aggregated_employe[$key] = [
                    'first_name' => $row['first_name'],
                    'middle_name' => $row['middle_name'],
                    'last_name' => $row['last_name'],
                    'employee_tax' => $row['employee_tax'],
                    'fftax' => 0,
                    'mmtax' => 0,
                    'sstax' => 0,
                    'uutax' => 0,
                ];
            }
            $aggregated_employe[$key]['fftax'] += $row['fftax'];
            $aggregated_employe[$key]['mmtax'] += $row['mmtax'];
            $aggregated_employe[$key]['sstax'] += $row['sstax'];
            $aggregated_employe[$key]['uutax'] += $row['uutax'];
        }
        // Convert aggregated data to array format
        $data['aggregated_employe'] = array_values($aggregated_employe);
    } else {
        $data['aggregated_employe'] = [];
    }
      if ($data['employer']) {
          $aggregated = [];
          foreach ($data['employer'] as $row) {
              $key = $row['first_name'] . '|' . $row['middle_name'] . '|' . $row['last_name'] . '|' . $row['employee_tax'];
              if (!isset($aggregated[$key])) {
                  $aggregated[$key] = [
                      'first_name' => $row['first_name'],
                      'middle_name' => $row['middle_name'],
                      'last_name' => $row['last_name'],
                      'employee_tax' => $row['employee_tax'],
                      'fftax' => 0,
                      'mmtax' => 0,
                      'sstax' => 0,
                      'uutax' => 0,
                  ];
              }
              $aggregated[$key]['fftax'] += $row['fftax'];
              $aggregated[$key]['mmtax'] += $row['mmtax'];
              $aggregated[$key]['sstax'] += $row['sstax'];
              $aggregated[$key]['uutax'] += $row['uutax'];
          }
          // Convert aggregated data to array format
          $data['aggregated_employer'] = array_values($aggregated);
      } else {
          $data['aggregated_employer'] = [];
      }//print_r( $data['aggregated_employer']);die();
      $data['employee_data'] =$this->Hrm_model->employee_data_get();
      echo json_encode($data);
   }
    
    public function medicare_tax_report_search() {
        $CI =  & get_instance();
        $CI->load->model('Web_settings');
        $this->load->model('Hrm_model');
        $emp_name    = $this->input->post('employee_name');
        $date        = $this->input->post('daterangepicker-field');
        $status      = $this->input->post('status');
        $data['tax'] = $this->Hrm_model->social_tax_report($emp_name, $date, $status);
        echo json_encode($data['tax']);
    }
    
    public function unemployment_tax_report_search() {
        $CI =  & get_instance();
        $CI->load->model('Web_settings');
        $this->load->model('Hrm_model');
        $emp_name    = $this->input->post('employee_name');
        $date        = $this->input->post('daterangepicker-field');
        $status      = $this->input->post('status');
        $data['tax'] = $this->Hrm_model->social_tax_report($emp_name, $date, $status);
        echo json_encode($data['tax']);
    }
    
    public function federal_summary_search() {
        $CI =  & get_instance();
        $CI->load->model('Web_settings');
        $this->load->model('Hrm_model');
        $emp_name    = $this->input->post('employee_name');
        $date        = $this->input->post('daterangepicker-field');
        $status      = $this->input->post('status');
        $data['tax'] = $this->Hrm_model->social_tax_report($emp_name, $date, $status);
        echo json_encode($data['tax']);
    }
    public function city_tax_report() {
        $CI =  & get_instance();
        $CI->load->model('Web_settings');
        $this->load->model('Hrm_model');
        $setting_detail                   = $CI->Web_settings->retrieve_setting_editdata();
        $data['setting_detail']           = $setting_detail;
        $data['getEmployeeContributions'] = $this->Hrm_model->getEmployeeContributions();
        $data['employee_data']            = $this->Hrm_model->employee_data_get();
        $content                          = $this->parser->parse('hr/reports/city_tax', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function city_tax_search() {
        $CI =  & get_instance();
        $CI->load->model('Web_settings');
        $this->load->model('Hrm_model');
        $setting_detail                   = $CI->Web_settings->retrieve_setting_editdata();
        $date                             = $this->input->post('daterangepicker-field');
        $data['setting_detail']           = $setting_detail;
        $emp_name                         = $this->input->post('employee_name');
        $data['getEmployeeContributions'] = $this->Hrm_model->getEmployeeContributions($emp_name, $date);
        $data['employee_data']            = $this->Hrm_model->employee_data_get();
        echo json_encode($data['getEmployeeContributions']);
    }
    public function city_local_tax() {
        $CI =  & get_instance();
        $CI->load->model('Web_settings');
        $this->load->model('Hrm_model');
        $setting_detail                   = $CI->Web_settings->retrieve_setting_editdata();
        $data['setting_detail']           = $setting_detail;
        $data['getEmployeeContributions'] = $this->Hrm_model->getEmployeeContributions_local();
        $data['employee_data']            = $this->Hrm_model->employee_data_get();
        $content                          = $this->parser->parse('hr/reports/city_local_tax', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function city_local_tax_search() {
        $CI =  & get_instance();
        $CI->load->model('Web_settings');
        $this->load->model('Hrm_model');
        $setting_detail                   = $CI->Web_settings->retrieve_setting_editdata();
        $data['setting_detail']           = $setting_detail;
        $date                             = $this->input->post('daterangepicker-field');
        $emp_name                         = $this->input->post('employee_name');
        $data['getEmployeeContributions'] = $this->Hrm_model->getEmployeeContributions_local($emp_name, $date);
        $data['employee_data']            = $this->Hrm_model->employee_data_get();
        echo json_encode($data['getEmployeeContributions']);
    }
//employee index -hr
    public function hr_tools() {
        $encodedId             = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId             = decodeBase64UrlParameter($encodedId);
        $data['administrator'] = $this->Hrm_model->administrator_data($decodedId);
        $content               = $this->parser->parse('hr/toolkit_index', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function hand_book() {
        $this->load->model('Hrm_model');
        $data['title'] = "HandBook";
        $content       = $this->parser->parse('hr/handbook', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function generateAgentcheck() {
        $CI            =  & get_instance();
        $generateCheck = $CI->Web_settings->retrieve_agentcheck();
        $data          = array(
            'title' => 'Agent Cheque Generation',
            'agent' => $generateCheck,
        );
        $content = $this->parser->parse('hr/generateagentcheck', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function agent_check() {
        $CI         =  & get_instance();
        $agent_list = $CI->Hrm_model->agent_list();
        $data       = array(
            'title'      => 'Agent Cheque Generation',
            'agent_list' => $agent_list,
        );
        $content = $this->parser->parse('hr/agent_list', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function viewAgentcheck($id = null) {
        $CI               =  & get_instance();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $viewCheck        = $CI->Web_settings->retrieve_agentviewcheck($id);
        $data             = array(
            'check'        => $viewCheck,
            'total_amount' => $viewCheck[0]['total_amount'],
            'commission'   => $viewCheck[0]['agent_commission'],
            'date'         => $viewCheck[0]['date'],
            'currency'     => $currency_details[0]['currency'],
        );
        $content = $this->parser->parse('hr/agentviewcheck', $data, true);
        $this->template->full_admin_html_view($content);
    }



    public function second_pay_slip() {
        $id        = $this->input->post('id');
        $decodedId = decodeBase64UrlParameter($id);

        
        $response  = array();
        if (!empty($decodedId)) {
            $company_info = $this->Ppurchases->retrieve_company($decodedId);
            $datacontent  = $this->invoice_content->retrieve_data($decodedId);
            $this->load->model('Hrm_model');
            $data['title']                             = display('pay_slip');
            $data['business_name']                     = (!empty($datacontent[0]['company_name']) ? $datacontent[0]['company_name'] : $company_info[0]['company_name']);
            $data['phone']                             = (!empty($datacontent[0]['mobile']) ? $datacontent[0]['mobile'] : $company_info[0]['mobile']);
            $data['email']                             = (!empty($datacontent[0]['email']) ? $datacontent[0]['email'] : $company_info[0]['email']);
            $data['address']                           = (!empty($datacontent[0]['address']) ? $datacontent[0]['address'] : $company_info[0]['address']);
            $data_timesheet['total_hours']             = $this->input->post('total_net');
            $data_timesheet['templ_name']              = $this->input->post('templ_name');
            $data_timesheet['duration']                = $this->input->post('duration');
            $data_timesheet['job_title']               = $this->input->post('job_title');
            $data_timesheet['payroll_type']            = $this->input->post('payroll_type');
            $data_timesheet['payment_term']            = $this->input->post('payment_term');
            $data_timesheet['extra_hour']              = $this->input->post('extra_hour');
            $data_timesheet['extra_rate']              = $this->input->post('extra_rate');
            $data_timesheet['extra_thisrate']          = $this->input->post('extra_thisrate');
            $data_timesheet['extra_this_hour']         = $this->input->post('extra_this_hour');
            $data_timesheet['extra_ytd']               = $this->input->post('extra_ytd');
            $data_timesheet['above_extra_beforehours'] = $this->input->post('above_extra_beforehours');
            $data_timesheet['above_extra_rate']        = $this->input->post('above_extra_rate');
            $data_timesheet['above_extra_sum']         = $this->input->post('above_extra_sum');
            $data_timesheet['above_this_hours']        = $this->input->post('above_this_hours');
            $data_timesheet['above_extra_ytd']         = $this->input->post('above_extra_ytd');
            $data_timesheet['week_one']                = is_numeric($this->input->post('week_one')) ? (float) $this->input->post('week_one') : 0;
            $data_timesheet['week_two']                = is_numeric($this->input->post('week_two')) ? (float) $this->input->post('week_two') : 0;
            $data_timesheet['week_three']              = is_numeric($this->input->post('week_three')) ? (float) $this->input->post('week_three') : 0;
            $data_timesheet['modified_by']             = $this->session->userdata('user_id');
            $data_timesheet['modified_date']           = date('Y-m-d H:i:s');
            $data_timesheet['month']                   = $this->input->post('date_range');
            $date_split                                = explode(' - ', $this->input->post('date_range'));
            $data_timesheet['start']                   = $date_split[0];
            $data_timesheet['end']                     = $date_split[1];

            if ($this->input->post('payment_method') == 'Cash') {
            $data_timesheet['cheque_date'] =(!empty($this->input->post('cash_date',TRUE))?$this->input->post('cash_date',TRUE):'');
            } 
            else if ($this->input->post('payment_method') == 'Cheque') {
                $data_timesheet['cheque_date'] =(!empty($this->input->post('cheque_date',TRUE))?$this->input->post('cheque_date',TRUE):'');
            }

            $start_date                                = $data_timesheet['start'];
            $month                                     = intval(substr($start_date, 0, 2));
            if ($month >= 1 && $month <= 3) {
                $quarter = 'Q1';
            } elseif ($month >= 4 && $month <= 6) {
                $quarter = 'Q2';
            } elseif ($month >= 7 && $month <= 9) {
                $quarter = 'Q3';
            } elseif ($month >= 10 && $month <= 12) {
                $quarter = 'Q4';
            } else {
                $quarter = 'Unknown';
            }
            $data_timesheet['quarter']        = $quarter;
            $data_timesheet['timesheet_id']   = $this->input->post('tsheet_id');
            $data_timesheet['create_by']      = $this->session->userdata('user_id');
            $data_timesheet['admin_name']     = (!empty($this->input->post('administrator_person', TRUE)) ? $this->input->post('administrator_person', TRUE) : '');
            $data_timesheet['payment_method'] = (!empty($this->input->post('payment_method', TRUE)) ? $this->input->post('payment_method', TRUE) : '');
            $data_timesheet['cheque_no']      = (!empty($this->input->post('cheque_no', TRUE)) ? $this->input->post('cheque_no', TRUE) : '');
           
            $data_timesheet['bank_name']      = (!empty($this->input->post('bank_name', TRUE)) ? $this->input->post('bank_name', TRUE) : '');
            $data_timesheet['payment_ref_no'] = (!empty($this->input->post('payment_refno', TRUE)) ? $this->input->post('payment_refno', TRUE) : '');
            $timesheet_id                     = $this->input->post('tsheet_id');
            $total_hours                      = $this->input->post('total_net', TRUE);
            if (empty($timesheet_id) || $total_hours === FALSE) {
                log_message('error', 'Missing or invalid input for timesheet_id or total_hours.');
                $response = array(
                    'status' => 'failure',
                    'msg'    => 'Error: Missing or invalid input.',
                );
            } else {
                $data2 = array(
                    'timesheet_id' => $timesheet_id,
                    'total_hours'  => $total_hours,
                );
                $this->db->where('timesheet_id', $timesheet_id);
                $this->db->where('create_by', $decodedId);
                $success                  = $this->db->update('info_payslip', $data2);
                $data['employee_data']    = $this->Hrm_model->employee_info($this->input->post('templ_name'), $decodedId);
                $data['timesheet_data']   = $this->Hrm_model->timesheet_info_data($data_timesheet['timesheet_id'], $decodedId);
                $timesheetdata            = $data['timesheet_data'];
                $employeedata             = $data['employee_data'];
                $hrate                    = $data['employee_data'][0]['hrate'];
                $data_timesheet['h_rate'] = $data['employee_data'][0]['hrate'];
                $total_hours              = $data['timesheet_data'][0]['total_hours'];
                $payperiod                = $data['timesheet_data'][0]['month'];
                $get_date                 = explode('-', $payperiod);
                $d1                       = $get_date[1];
                $data['sc']               = $this->Hrm_model->sc_info_count($this->input->post('templ_name'), $payperiod, $decodedId);
                $scValue                  = $data['sc']['sc'][0]['sc'];
                $sc_totalAmount1          = $data['sc']['total_gtotal'];
                $sc_count                 = $data['sc']['count'];
                $scValue                  = $scValue / 100;
                if (isset($data['employee_data']) && !empty($data['employee_data'])) {
                    if (isset($data['employee_data'][0]['choice'])) {
                        if ($data['employee_data'][0]['choice'] == 'No') {
                            $scValueAmount1 = 0;
                        } else {
                            $scValueAmount1 = $scValue * $sc_totalAmount1;
                        }
                    }
                }
                if ($data['timesheet_data'][0]['payroll_type'] == 'Sales Partner') {
                    $data['sc']         = $this->Hrm_model->sc_info_count($this->input->post('templ_name'), $payperiod , $decodedId);
                    $scValue            = $data['sc']['sc'][0]['sc'];
                    $total_gtotal_value = $data['sc']['total_gtotal'];
                    $scValue1           = $scValue / 100;
                    $result             = $scValue1 * $total_gtotal_value;
                    $final              = $result;
                }
                if ($data['timesheet_data'][0]['payroll_type'] !== 'Sales Partner' || $data['employee_data'][0]['choice'] == 'Yes') {
                    if (!empty($this->input->post('administrator_person', TRUE))) {
                        $data_timesheet['uneditable'] = 1;
                    } else {
                        $data_timesheet['uneditable'] = 0;
                    }
                    $u_id                        = $this->input->post('unique_id');
                    $data_timesheet['unique_id'] = $u_id;
                    $employee_detail             = $this->db->where('id', $this->input->post('templ_name'));
                    $q                           = $this->db->get('employee_history');
                    $row                         = $q->row_array();
                    if (!empty($row['id'])) {
                        $data['selected_living_state_tax'] = $row['living_state_tax'];
                        $data['selected_local_tax']        = $row['local_tax'];
                        $data['selected_state_tax']        = $row['state_tx'];
                        $data['templ_name']                = $row['first_name'] . " " . $row['last_name'];
                        $data['job_title']                 = $row['designation'];
                    }
                    $date1          = $this->input->post('date');
                    $day1           = $this->input->post('day');
                    $present1       = $this->input->post('block');
                    $time_start1    = $this->input->post('start');
                    $time_end1      = $this->input->post('end');
                    $hours_per_day1 = $this->input->post('sum');
                    $daily_bk1      = $this->input->post('dailybreak');
                    $purchase_id_1  = $this->db->where('templ_name', $this->input->post('templ_name'))->where('timesheet_id', $data_timesheet['timesheet_id']);
                    $q              = $this->db->get('timesheet_info');
                    $row            = $q->row_array();
                    $old_id         = trim($row['timesheet_id']);
                    if (!empty($old_id)) {
                        $this->session->set_userdata("timesheet_id_old", $row['timesheet_id']);
                        $this->db->where('timesheet_id', $this->session->userdata("timesheet_id_old"));
                        $this->db->delete('timesheet_info');
                        $this->db->where('timesheet_id', $this->session->userdata("timesheet_id_old"));
                        $this->db->delete('timesheet_info_details');
                        $this->db->insert('timesheet_info', $data_timesheet);                      
                    } else {
                        $this->db->insert('timesheet_info', $data_timesheet);
                    }
                    $data['timesheet_data'] = $this->Hrm_model->timesheet_info_data($data_timesheet['timesheet_id'], $decodedId);
                
                 
                    if ($data['timesheet_data'][0]['payroll_type'] == 'Hourly') {
                        if ($total_hours <= 40) {
                            $final = ($hrate * $total_hours) + $scValueAmount1;
                            } else {
                            $final = $data['timesheet_data'][0]['extra_thisrate'] + $data['timesheet_data'][0]['above_extra_sum'];

                        }


                    } else if ($data['timesheet_data'][0]['payroll_type'] == 'Salaried-BiWeekly') {
                        if ($total_hours <= 14) {
                            $final = ($hrate * $total_hours) + $scValueAmount1;
                        } else {
                            $final = $data['timesheet_data'][0]['extra_thisrate'] + $data['timesheet_data'][0]['above_extra_sum'];
                        }
                    } else if ($data['timesheet_data'][0]['payroll_type'] == 'Salaried-weekly') {
                        $final = ($hrate * $total_hours) + $scValueAmount1;
                    } else if ($data['timesheet_data'][0]['payroll_type'] == 'Salaried-Monthly') {
                        if ($total_hours <= 30) {
                            $final = ($hrate * $total_hours) + $scValueAmount1;
                        } else {
                            $final = $data['timesheet_data'][0]['extra_thisrate'] + $data['timesheet_data'][0]['above_extra_sum'];
                        }
                    } else if ($data['timesheet_data'][0]['payroll_type'] == 'Salaried-BiMonthly') {
                        if ($total_hours <= 60) {
                            $final = ($hrate * $total_hours) + $scValueAmount1;
                        } else {
                            $final = $data['timesheet_data'][0]['extra_thisrate'] + $data['timesheet_data'][0]['above_extra_sum'];
                        }
                    } else if ($data['timesheet_data'][0]['payroll_type'] == 'SalesCommission') {
                        $final = ($hrate * $total_hours) + $scValueAmount1;
                    }
                    $purchase_id_2 = $this->db->select('timesheet_id')->from('timesheet_info')->where('templ_name', $this->input->post('templ_name'))->where('month', $this->input->post('date_range'))->get()->row()->timesheet_id;
                    $this->session->set_userdata("timesheet_id_new", $purchase_id_2);
                    if ($date1) {
                        for ($i = 0, $n = count($date1); $i < $n; $i++) {
                            $date          = $date1[$i];
                            $day           = $day1[$i];
                            $present_abs   = $present1[$i];
                            $daily_bk      = $daily_bk1[$i];
                            $time_start    = $time_start1[$i];
                            $time_end      = $time_end1[$i];
                            $hours_per_day = $hours_per_day1[$i];
                            $data1         = array(
                                'timesheet_id'  => $this->session->userdata("timesheet_id_new"),
                                'Date'          => $date,
                                'Day'           => $day,
                                'present'       => $present_abs,
                                'daily_break'   => $daily_bk,
                                'time_start'    => $time_start,
                                'time_end'      => $time_end,
                                'hours_per_day' => $hours_per_day,
                                'created_by'    => $decodedId,
                            );
                            $this->db->insert('timesheet_info_details', $data1);

  
                        }
                    } else {
                        $data1 = array(
                            'timesheet_id' => $this->session->userdata("timesheet_id_new"),
                            'created_by'   => $decodedId,
                        );
                        $this->db->insert('timesheet_info_details', $data1);
 
                    }

                    $s             = '';
                    $u             = '';
                    $m             = '';
                    $f             = '';
                    $federal_tax   = $this->db->select('*')->from('federal_tax')->where('tax', 'Federal Income tax')->where('created_by', $decodedId)   ->get()->result_array();
                
                 
                    $federal_range = '';
                    $f_tax         = '';
                    foreach ($federal_tax as $amt) {
                        $split = explode('-', $amt[$data['employee_data'][0]['employee_tax']]);

                        if ($final >= $split[0] && $final <= $split[1]) {
                            $federal_range = $split[0] . "-" . $split[1];

                         }
                    }

                     $data['federal'] = $this->Hrm_model->federal_tax_info($data['employee_data'][0]['employee_tax'], $final, $federal_range, $decodedId);
                  
 

                      if (!empty($data['federal'])) {
                        $Federal_employee = $data['federal'][0]['employee'];
                        $f                = ($Federal_employee / 100) * $final;
                        $f                = round($f, 3);
                        $Federal_employer = $data['federal'][0]['employer'];
                        $ff               = ($Federal_employer / 100) * $final;
                        $ff               = round($ff, 3);
                        $ar               = $this->db->select('f_tax')->from('tax_history')->where('employee_id', $this->input->post('templ_name'))->get()->row()->f_tax;
                        $f_tax            = $ar + $f;
                    }

                  
 $social_tax   = $this->db->select('*')->from('federal_tax')->where('tax', 'Social Security')->where('created_by', $decodedId) ->get()->result_array();
  $social_range = '';
                    $s_tax        = '';
                    $split        = explode('-', $social_tax[0][$data['employee_data'][0]['employee_tax']]);
                    if ($final >= $split[0] && $final <= $split[1]) {
                        $social_range = $split[0] . "-" . $split[1];
                    }
                    $data['social'] = $this->Hrm_model->social_tax_info($data['employee_data'][0]['employee_tax'], $final, $social_range, $decodedId);
                    if (!empty($data['social'][0]['employee'])) {
                        $social_employee = $data['social'][0]['employee'];
                        $s               = ($social_employee / 100) * $final;
                        $s               = round($s, 3);
                        $social_employer = $data['social'][0]['employer'];
                        $ss              = ($social_employer / 100) * $final;
                        $ss              = round($ss, 3);
                        $ar              = $this->db->select('s_tax')->from('tax_history')->where('employee_id', $this->input->post('templ_name'))->get()->row()->s_tax;
                        $s_tax           = $ar + $s;
                        $Medicare        = $this->db->select('*')->from('federal_tax')->where('tax', 'Medicare')->get()->result_array();
                        $Medicare_range  = '';
                        $m_tax           = '';
                        foreach ($Medicare as $social_amt) {
                            $split = explode('-', $social_amt[$data['employee_data'][0]['employee_tax']]);
                            if ($final >= $split[0] && $final <= $split[1]) {
                                $Medicare_range = $split[0] . "-" . $split[1];
                            }
                        }
                        $data['Medicare'] = $this->Hrm_model->Medicare_tax_info($data['employee_data'][0]['employee_tax'], $final, $Medicare_range, $decodedId);
                     
                    
                     
                        if (!empty($data['Medicare'])) {
                            $Medicare_employee = $data['Medicare'][0]['employee'];
                            $m                 = ($Medicare_employee / 100) * $final;
                            $m                 = round($m, 3);
                            $Medicare_employer = $data['Medicare'][0]['employer'];
                            $mm                = ($Medicare_employer / 100) * $final;
                            $mm                = round($mm, 3);
                            $ar                = $this->db->select('m_tax')->from('tax_history')->where('employee_id', $this->input->post('templ_name'))->get()->row()->m_tax;
                            $m_tax             = $ar + $m;
                        }

                    
                        $unemployment       = $this->db->select('*')->from('federal_tax')->where('tax', 'Federal unemployment')->where('created_by', $decodedId)->get()->result_array();


                        $unemployment_range = '';
                        $u_tax              = '';
                        foreach ($unemployment as $social_amt) {
                            $split = explode('-', $social_amt[$data['employee_data'][0]['employee_tax']]);
                            if ($final >= $split[0] && $final <= $split[1]) {
                                $unemployment_range = $split[0] . "-" . $split[1];
                            }
                        }
                        $data['unemployment'] = $this->Hrm_model->unemployment_tax_info($data['employee_data'][0]['employee_tax'], $final, $unemployment_range, $decodedId);
                        if (!empty($data['unemployment'])) {
                            $unemployment_employee = $data['unemployment'][0]['employee'];
                            $unemployment_employer = $data['unemployment'][0]['employer'];
                            $unemployment_details = $data['unemployment'][0]['details'];
                            $details = preg_replace('/\D/', '', $unemployment_details);
                            $u                     = ($unemployment_employee / 100) * $final;
                            $u                     = round($u, 3);
                           
                            $emp_salary_amt = $this->Hrm_model->get_employee_sal($data['timesheet_data'][0]['templ_name'] , $decodedId);
                            $all_ytd = $emp_salary_amt[0]['totalamout']; 
                            $this->db->select('h_rate, total_hours, extra_thisrate, SUM(extra_thisrate) as totalamout');
                            $this->db->from('timesheet_info');
                            $this->db->where('timesheet_info.month <=', date('Y-m-d'));
                            $this->db->where("STR_TO_DATE(SUBSTRING_INDEX(timesheet_info.month, ' - ', -1), '%m/%d/%Y') < STR_TO_DATE('$d1', '%m/%d/%Y')", NULL, FALSE);
                            $this->db->where('templ_name', $data['timesheet_data'][0]['templ_name']);
                            $this->db->where('create_by', $decodedId);
                            $query = $this->db->get(); 
                            $data['emp_salary_amt'] = $query->result_array(); 
                             if (!empty($data['emp_salary_amt'])) {
                                $total = $data['emp_salary_amt'][0]['extra_thisrate'];
                                $ytd = $data['emp_salary_amt'][0]['totalamout'];
                             }          
                             $total_unemployment = $this->Hrm_model->total_unemployment($data['timesheet_data'][0]['templ_name'] , $decodedId);        
                             if($total_unemployment[0]['unempltotal'] < $details ){
                              if ($all_ytd <= $details) {
                              $uu = ($unemployment_employer / 100) * $final;
                              $uu = round($uu, 3);
                              $tax_amt_final = $final;
                            }  
                            elseif ($all_ytd > $details) {
                                $bal = $details  - $ytd ;
                                $uu = ($unemployment_employer / 100) * $bal;
                                $tax_amt_final = $bal;  
                                $uu = round($uu, 3);
                               }
                              else {
                                $uu = 0.00;
                            }
                          }else{
                            $uu = 0.00;
                    
                          }
                         
                            $ar                    = $this->db->select('u_tax')->from('tax_history')->where('employee_id', $this->input->post('templ_name'))->get()->row()->u_tax;
                            $u_tax                 = $ar + $u;
                        }
                        $state                     = '';
                        $living_state_tax_range    = '';
                        $living_state_tax          = '';
                        $living_state_tax_employer = array();
                        $living_state_tax          = array();

                        if ($data['employee_data'][0]['living_state_tax'] != '' && ($data['employee_data'][0]['living_state_tax'] !== 'Not Applicable')) {
                            $state_tax = $this->db->select('*')->from('state_and_tax')->where('state', $data['employee_data'][0]['living_state_tax'])->where('created_by', $this->session->userdata('user_id'))->get()->result_array();
                            $state     = $this->db->select('*')->from('state_and_tax')->where('state', $state_tax[0]['state']) ->where('created_by', $this->session->userdata('user_id'))->get()->result_array();
                            $tax_split = explode(',', $state[0]['tax']);
                            // Change - 1
                            foreach ($tax_split as $tax) {
                                $tax = 
                                $this->db->select('*')
                                ->from('state_localtax')
                                ->where('tax', $state_tax[0]['state'] . "-" . $tax)
                                ->where('create_by', $this->session->userdata('user_id'))
                                ->get()->result_array();
                            
                                foreach ($tax as $tx) {
                                    $split = explode('-', $tx[$data['employee_data'][0]['employee_tax']]);
                                    if ($split[0] != '' && $split[1] != '') {
                                        if ($final >= $split[0] && $final <= $split[1]) {
                                            $local_tax_range  = $split[0] . "-" . $split[1];
                                            $data['localtax'] = $this->Hrm_model->local_state_tax($data['employee_data'][0]['employee_tax'], $final, $local_tax_range);
                                            if (!empty($data['localtax'])) {
                                                $i = 0;
                                                foreach ($data['localtax'] as $lt) {
                                                    $local_tax_employee = $lt['employee'];
                                                    $local_tax_employer = $lt['employer'];
                                                    $local_tax_ee       = ($local_tax_employee / 100) * $final;
                                                    $local_tax_er       = ($local_tax_employer / 100) * $final;
                                                    $row_employer       = $this->db->select('*')->from('state_localtax')->where('employer', $local_tax_employer)->where('tax', $tx['tax'])->where($data['employee_data'][0]['employee_tax'], $local_tax_range)->where('create_by', $this->session->userdata('user_id'))->count_all_results();
                                                    $data_employer      = "'employer_" . $tx['tax'] . "'";
                                                    if ($row_employer == 1) {
                                                        $t_tx1                                     = $local_tax_er;
                                                        $living_state_tax_employer[$data_employer] = $t_tx1;
                                                    }
                                                    // Change - 3
                                                    $row = $this->db->select('*')->from('state_localtax')->where('employee', $local_tax_employee)->where('tax', $tx['tax'])->where($data['employee_data'][0]['employee_tax'], $local_tax_range)->where('create_by', $this->session->userdata('user_id'))->count_all_results();                                      
                                                    $data_employee = "'employee_" . $tx['tax'] . "'";
                                                    $search_tax    = explode('-', $tx['tax']);
                                                    if ($row == 1) {
                                                        $t_tx                             = $local_tax_ee;
                                                        $living_state_tax[$data_employee] = $t_tx;
                                                    }
                                                    $i++;
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            $test2 = $this->db->select('*')->from('info_payslip')->where('timesheet_id', $timesheetdata[0]['timesheet_id'])
                                ->get()->row();
                            if (!empty($test2->timesheet_id)) {
                                $this->db->where('timesheet_id', $test2->timesheet_id);
                                $this->db->delete('info_payslip');
                            }
                            $test = $this->db->select('time_sheet_id')->from('tax_history')->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                                ->get()->row();
                            if (!empty($test->time_sheet_id)) {
                                $this->db->where('time_sheet_id', $test->time_sheet_id);
                                $this->db->delete('tax_history');
                            }
                            $payperiod  = $data['timesheet_data'][0]['month'];
                            $data['sc'] = $this->Hrm_model->sc_info_count($this->input->post('templ_name'), $payperiod, $decodedId);
                            if (isset($data['sc']['sc'][0]['sc'])) {
                                $scValue = $data['sc']['sc'][0]['sc'];
                            } else {
                                $scValue = 0;
                            }
                            $sc_totalAmount1 = $data['sc']['total_gtotal'];
                            $sc_count        = $data['sc']['count'];
                            if ($sc_totalAmount1 != 0) {
                                $scValuePercentage = ($scValue / $sc_totalAmount1) * 100;
                                $scValueAmount     = ($scValuePercentage / 100) * $sc_totalAmount1;
                            } else {
                                $scValueAmount = 0;
                            }
                            $scValue       = $scValue / 100;
                            $scValueAmount = $scValue * $sc_totalAmount1;
                        }
                        $local_tax_range     = '';
                        $local_tax           = '';
                        $local_tax           = array();
                        $local_tax_employerr = array();

                        if (!empty($data['selected_local_tax']) && ($data['selected_local_tax'] !== 'Not Applicable')) {
                            $state_tax = $this->db->select('*')->from('state_and_tax')->where('state', $data['employee_data'][0]['local_tax'])->where('created_by', $decodedId)->get()->result_array();
                            $state     = $this->db->select('*')->from('state_and_tax')->where('state', $state_tax[0]['state'])->get()->result_array();
                            $tax_split = explode(',', $state[0]['tax']);
                            foreach ($tax_split as $tax) {
                                $tax = $this->db->select('*')->from('state_localtax')->where('tax', $state_tax[0]['state'] . "-" . $tax)->where('create_by', $decodedId)->get()->result_array();
                                foreach ($tax as $tx) {
                                    $split = explode('-', $tx[$data['employee_data'][0]['employee_tax']]);
                                    if ($split[0] != '' && $split[1] != '') {
                                        if ($final >= $split[0] && $final <= $split[1]) {
                                            $local_tax_range  = $split[0] . "-" . $split[1];
                                            $data['localtax'] = $this->Hrm_model->local_state_tax($data['employee_data'][0]['employee_tax'], $final, $local_tax_range);
                                            if (!empty($data['localtax'])) {
                                                $i = 0;
                                                foreach ($data['localtax'] as $lt) {
                                                    $local_tax_employee = $lt['employee'];
                                                    $local_tax_employer = $lt['employer'];
                                                    $local_tax_ee       = ($local_tax_employee / 100) * $final;
                                                    $local_tax_er       = ($local_tax_employer / 100) * $final;
                                                    $row_employer       = $this->db->select('*')->from('state_localtax')->where('employer', $local_tax_employer)->where('tax', $tx['tax'])->where($data['employee_data'][0]['employee_tax'], $local_tax_range)->where('create_by', $this->session->userdata('user_id'))->count_all_results();
                                                    $data_employer      = "'employer_" . $tx['tax'] . "'";
                                                    if ($row_employer == 1) {
                                                        $t_tx1                               = $local_tax_er;
                                                        $local_tax_employerr[$data_employer] = $t_tx1;
                                                    }
                                                    $row           = $this->db->select('*')->from('state_localtax')->where('employee', $local_tax_employee)->where('tax', $tx['tax'])->where($data['employee_data'][0]['employee_tax'], $local_tax_range)->where('create_by', $this->session->userdata('user_id'))->count_all_results();
                                                    $data_employee = "'employee_" . $tx['tax'] . "'";
                                                    $search_tax    = explode('-', $tx['tax']);
                                                    if ($row == 1) {
                                                        $t_tx                      = $local_tax_ee;
                                                        $local_tax[$data_employee] = $t_tx;
                                                    }
                                                    $i++;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $state_tax_range = '';
                        $st_tax          = '';
                        $st_tax          = array();
                        $st_tax_employer = array();
                        if (!empty($data['employee_data'][0]['state_tx']) && ($data['employee_data'][0]['state_tx'] !== 'Not Applicable')) {
                            $state_tax1 = $this->db->select('*')->from('state_and_tax')
                                ->where('state', $data['employee_data'][0]['state_tx'])
                                ->where('created_by', $this->session->userdata('user_id'))->get()->result_array();
                            $state1     = $this->db->select('*')->from('state_and_tax')->where('state', $state_tax1[0]['state'])->where('created_by', $this->session->userdata('user_id'))->get()->result_array();
                            
                            $tax_split1 = explode(',', $state1[0]['tax']);
                            foreach ($tax_split1 as $tax) {
                                $tax = $this->db->select('*')->from('state_localtax')->where('tax', $state_tax1[0]['state'] . "-" . $tax)->where('create_by', $this->session->userdata('user_id'))->get()->result_array();
                              
                                foreach ($tax as $tx) {
                                    $split = explode('-', $tx[$data['employee_data'][0]['employee_tax']]);
                                    if ($split[0] != '' && $split[1] != '') {
                                        if ($final >= $split[0] && $final <= $split[1]) {
                                            $state_tax_range  = $split[0] . "-" . $split[1];
                                            $data['localtax'] = $this->Hrm_model->local_state_tax($data['employee_data'][0]['employee_tax'], $final, $state_tax_range);
                                            if (!empty($data['localtax'])) {
                                                $i = 0;
                                                foreach ($data['localtax'] as $lt) {
                                                    $local_tax_employee = $lt['employee'];
                                                    $local_tax_employer = $lt['employer'];
                                                    if ((strpos($tx['tax'], 'Disability') == true) || (strpos($tx['tax'], 'FLI') == true)) {
                                                        $local_tax_ee = ($local_tax_employee) * $final;
                                                        $local_tax_er = ($local_tax_employer) * $final;
                                                    } else {
                                                        $local_tax_ee = ($local_tax_employee / 100) * $final;
                                                        $local_tax_er = ($local_tax_employer / 100) * $final;
                                                    }
                                                    $row_employer = $this->db->select('*')
                                                        ->from('state_localtax')
                                                        ->where('employer', $local_tax_employer)
                                                        ->where('tax', $tx['tax'])
                                                        ->where($data['employee_data'][0]['employee_tax'], $state_tax_range)
                                                        ->where('create_by', $this->session->userdata('user_id'))
                                                        ->count_all_results();
                                                    $data_employer = "'employer_" . $tx['tax'] . "'";
                                                  
                                                    if ($row_employer == 1) {
                                                        $t_tx1                           = $local_tax_er;
                                                        $st_tax_employer[$data_employer] = $t_tx1;
                                                    }
                                                    $row           = $this->db->select('*')->from('state_localtax')->where('employee', $local_tax_employee)->where('tax', $tx['tax'])->where('create_by', $this->session->userdata('user_id'))->where($data['employee_data'][0]['employee_tax'], $state_tax_range)->count_all_results();
                                                   
                                                    $data_employee = "'employee_" . $tx['tax'] . "'";
                                                    $search_tax    = explode('-', $tx['tax']);
                                                    if ($row == 1) {
                                                        $t_tx                   = $local_tax_ee;
                                                        $st_tax[$data_employee] = $t_tx;
                                                    }
                                                    $i++;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $living_local_tax_range    = '';
                        $living_local_tax          = '';
                        $living_local_tax          = array();
                        $living_local_tax_employer = array();
                        if (!empty($data['employee_data'][0]['living_local_tax']) && ($data['employee_data'][0]['living_local_tax'] !== 'Not Applicable')) {
                            $state_tax1 = $this->db->select('*')->from('state_and_tax')->where('state', $data['employee_data'][0]['living_local_tax'])->where('created_by', $this->session->userdata('user_id'))->get()->result_array();
                            $state1     = $this->db->select('*')->from('state_and_tax')->where('state', $state_tax1[0]['state'])->get()->result_array();
                            $tax_split1 = explode(',', $state1[0]['tax']);
                            foreach ($tax_split1 as $tax) {
                                $tax = $this->db->select('*')->from('state_localtax')->where('tax', $state_tax1[0]['state'] . "-" . $tax)->where('create_by', $this->session->userdata('user_id'))->get()->result_array();
                                foreach ($tax as $tx) {
                                    $split = explode('-', $tx[$data['employee_data'][0]['employee_tax']]);
                                    if ($split[0] != '' && $split[1] != '') {
                                        if ($final >= $split[0] && $final <= $split[1]) {
                                            $state_tax_range  = $split[0] . "-" . $split[1];
                                            $data['localtax'] = $this->Hrm_model->local_state_tax($data['employee_data'][0]['employee_tax'], $final, $state_tax_range);
                                            if (!empty($data['localtax'])) {
                                                $i = 0;
                                                foreach ($data['localtax'] as $lt) {
                                                    $local_tax_employee = $lt['employee'];
                                                    $local_tax_employer = $lt['employer'];
                                                    $local_tax_ee       = ($local_tax_employee / 100) * $final;
                                                    $local_tax_er       = ($local_tax_employer / 100) * $final;
                                                    $row_employer       = $this->db->select('*')->from('state_localtax')->where('employer', $local_tax_employer)->where('tax', $tx['tax'])->where($data['employee_data'][0]['employee_tax'], $state_tax_range)->where('create_by', $this->session->userdata('user_id'))->count_all_results();
                                                    $data_employer      = "'employer_" . $tx['tax'] . "'";
                                                    if ($row_employer == 1) {
                                                        $t_tx1                                     = $local_tax_er;
                                                        $living_local_tax_employer[$data_employer] = $t_tx1;
                                                    }
                                                    $row           = $this->db->select('*')->from('state_localtax')->where('employee', $local_tax_employee)->where('tax', $tx['tax'])->where('create_by', $this->session->userdata('user_id'))->where($data['employee_data'][0]['employee_tax'], $state_tax_range)->count_all_results();
                                                    $data_employee = "'employee_" . $tx['tax'] . "'";
                                                    $search_tax    = explode('-', $tx['tax']);
                                                    if ($row == 1) {
                                                        $t_tx                             = $local_tax_ee;
                                                        $living_local_tax[$data_employee] = $t_tx;
                                                    }
                                                    $i++;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $living_county_tax_range    = '';
                        $living_county_tax          = '';
                        $living_county_tax          = array();
                        $living_county_tax_employer = array();
                        if ((!empty($data['employee_data'][0]['living_county_tax'])) && ($data['employee_data'][0]['living_county_tax'] !== 'Not Applicable')) {
                            $state_tax1 = $this->db->select('*')->from('state_and_tax')->where('state', $data['employee_data'][0]['living_county_tax'])->where('created_by', $this->session->userdata('user_id'))->get()->result_array();
                            $state1     = $this->db->select('*')->from('state_and_tax')->where('state', $state_tax1[0]['state'])->get()->result_array();
                            $tax_split1 = explode(',', $state1[0]['tax']);
                            foreach ($tax_split1 as $tax) {
                                $tax = $this->db->select('*')->from('state_localtax')->where('tax', $state_tax1[0]['state'] . "-" . $tax)->where('create_by', $this->session->userdata('user_id'))->get()->result_array();
                                foreach ($tax as $tx) {
                                    $split = explode('-', $tx[$data['employee_data'][0]['employee_tax']]);
                                    if ($split[0] != '' && $split[1] != '') {
                                        if ($final >= $split[0] && $final <= $split[1]) {
                                            $state_tax_range  = $split[0] . "-" . $split[1];
                                            $data['localtax'] = $this->Hrm_model->local_state_tax($data['employee_data'][0]['employee_tax'], $final, $state_tax_range);
                                            if (!empty($data['localtax'])) {
                                                $i = 0;
                                                foreach ($data['localtax'] as $lt) {
                                                    $local_tax_employee = $lt['employee'];
                                                    $local_tax_employer = $lt['employer'];
                                                    $local_tax_ee       = ($local_tax_employee / 100) * $final;
                                                    $local_tax_er       = ($local_tax_employer / 100) * $final;
                                                    $row_employer       = $this->db->select('*')->from('state_localtax')->where('employer', $local_tax_employer)->where('tax', $tx['tax'])->where($data['employee_data'][0]['employee_tax'], $state_tax_range)->where('create_by', $this->session->userdata('user_id'))->count_all_results();
                                                    $data_employer      = "'employer_" . $tx['tax'] . "'";
                                                    if ($row_employer == 1) {
                                                        $t_tx1                                      = $local_tax_er;
                                                        $living_county_tax_employer[$data_employer] = $t_tx1;
                                                    }
                                                    $row           = $this->db->select('*')->from('state_localtax')->where('employee', $local_tax_employee)->where('tax', $tx['tax'])->where('create_by', $this->session->userdata('user_id'))->where($data['employee_data'][0]['employee_tax'], $state_tax_range)->count_all_results();
                                                    $data_employee = "'employee_" . $tx['tax'] . "'";
                                                    $search_tax    = explode('-', $tx['tax']);
                                                    if ($row == 1) {
                                                        $t_tx                              = $local_tax_ee;
                                                        $living_county_tax[$data_employee] = $t_tx;
                                                    }
                                                    $i++;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $working_county_tax_range    = '';
                        $working_county_tax          = '';
                        $working_county_tax          = array();
                        $working_county_tax_employer = array();
                        if ((!empty($data['employee_data'][0]['cty_tax'])) && ($data['employee_data'][0]['cty_tax'] !== 'Not Applicable')) {
                            $state_tax1 = $this->db->select('*')->from('state_and_tax')->where('state', $data['employee_data'][0]['cty_tax'])->where('created_by', $this->session->userdata('user_id'))->get()->result_array();
                            $state1     = $this->db->select('*')->from('state_and_tax')->where('state', $state_tax1[0]['state'])->get()->result_array();
                            $tax_split1 = explode(',', $state1[0]['tax']);
                            foreach ($tax_split1 as $tax) {
                                $tax = $this->db->select('*')->from('state_localtax')->where('tax', $state_tax1[0]['state'] . "-" . $tax)->where('create_by', $this->session->userdata('user_id'))->get()->result_array();
                                foreach ($tax as $tx) {
                                    $split = explode('-', $tx[$data['employee_data'][0]['employee_tax']]);
                                    if ($split[0] != '' && $split[1] != '') {
                                        if ($final >= $split[0] && $final <= $split[1]) {
                                            $state_tax_range  = $split[0] . "-" . $split[1];
                                            $data['localtax'] = $this->Hrm_model->local_state_tax($data['employee_data'][0]['employee_tax'], $final, $state_tax_range);
                                            if (!empty($data['localtax'])) {
                                                $i = 0;
                                                foreach ($data['localtax'] as $lt) {
                                                    $local_tax_employee = $lt['employee'];
                                                    $local_tax_employer = $lt['employer'];
                                                    $local_tax_ee       = ($local_tax_employee / 100) * $final;
                                                    $local_tax_er       = ($local_tax_employer / 100) * $final;
                                                    $row_employer       = $this->db->select('*')->from('state_localtax')->where('employer', $local_tax_employer)->where('tax', $tx['tax'])->where($data['employee_data'][0]['employee_tax'], $state_tax_range)->where('create_by', $this->session->userdata('user_id'))->count_all_results();
                                                    $data_employer      = "'employer_" . $tx['tax'] . "'";
                                                    if ($row_employer == 1) {
                                                        $t_tx1                                       = $local_tax_er;
                                                        $working_county_tax_employer[$data_employer] = $t_tx1;
                                                    }
                                                    $row           = $this->db->select('*')->from('state_localtax')->where('employee', $local_tax_employee)->where('tax', $tx['tax'])->where('create_by', $this->session->userdata('user_id'))->where($data['employee_data'][0]['employee_tax'], $state_tax_range)->count_all_results();
                                                    $data_employee = "'employee_" . $tx['tax'] . "'";
                                                    $search_tax    = explode('-', $tx['tax']);
                                                    if ($row == 1) {
                                                        $t_tx                               = $local_tax_ee;
                                                        $working_county_tax[$data_employee] = $t_tx;
                                                    }
                                                    $i++;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $other_tax_range    = '';
                        $other_tax          = '';
                        $other_tax          = array();
                        $other_tax_employer = array();
                        if ((!empty($data['employee_data'][0]['state_tax_2'])) && ($data['employee_data'][0]['state_tax_2'] !== 'Not Applicable')) {
                            $state_tax = $this->db->select('*')->from('state_and_tax')->where('state', $data['employee_data'][0]['state_tax_2'])->where('created_by', $this->session->userdata('user_id'))->get()->result_array();
                            $state     = $this->db->select('*')->from('state_and_tax')->where('state', $state_tax[0]['state'])->get()->result_array();
                            $tax_split = explode(',', $state[0]['tax']);
                            foreach ($tax_split as $tax) {
                                $tax = $this->db->select('*')->from('state_localtax')->where('tax', $state_tax[0]['state'] . "-" . $tax)->where('create_by', $this->session->userdata('user_id'))->get()->result_array();
                                foreach ($tax as $tx) {
                                    $split = explode('-', $tx[$data['employee_data'][0]['employee_tax']]);
                                    if ($split[0] != '' && $split[1] != '') {
                                        if ($final >= $split[0] && $final <= $split[1]) {
                                            $local_tax_range  = $split[0] . "-" . $split[1];
                                            $data['localtax'] = $this->Hrm_model->local_state_tax($data['employee_data'][0]['employee_tax'], $final, $local_tax_range);
                                            if (!empty($data['localtax'])) {
                                                $i = 0;
                                                foreach ($data['localtax'] as $lt) {
                                                    $local_tax_employee = $lt['employee'];
                                                    $local_tax_employer = $lt['employer'];
                                                    $local_tax_ee       = ($local_tax_employee / 100) * $final;
                                                    $local_tax_er       = ($local_tax_employer / 100) * $final;
                                                    $row_employer       = $this->db->select('*')->from('state_localtax')->where('employer', $local_tax_employer)->where('tax', $tx['tax'])->where($data['employee_data'][0]['employee_tax'], $local_tax_range)->where('create_by', $this->session->userdata('user_id'))->count_all_results();
                                                    $data_employer      = "'employer_" . $tx['tax'] . "'";
                                                    if ($row_employer == 1) {
                                                        $t_tx1                              = $local_tax_er;
                                                        $other_tax_employer[$data_employer] = $t_tx1;
                                                    }
                                                    $row           = $this->db->select('*')->from('state_localtax')->where('employee', $local_tax_employee)->where('tax', $tx['tax'])->where($data['employee_data'][0]['employee_tax'], $local_tax_range)->where('create_by', $this->session->userdata('user_id'))->count_all_results();
                                                    $data_employee = "'employee_" . $tx['tax'] . "'";
                                                    $search_tax    = explode('-', $tx['tax']);
                                                    if ($row == 1) {
                                                        $t_tx                      = $local_tax_ee;
                                                        $other_tax[$data_employee] = $t_tx;
                                                    }
                                                    $i++;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $other_tax_state_range      = '';
                        $other_working_tax          = '';
                        $other_working_tax          = array();
                        $other_working_tax_employer = array();
                        if ((!empty($data['employee_data'][0]['state_tax_1'])) && ($data['employee_data'][0]['state_tax_1'] !== 'Not Applicable')) {
                            $state_tax = $this->db->select('*')->from('state_and_tax')->where('state', $data['employee_data'][0]['state_tax_1'])->where('created_by', $this->session->userdata('user_id'))->get()->result_array();
                            $state     = $this->db->select('*')->from('state_and_tax')->where('state', $state_tax[0]['state'])->get()->result_array();
                            $tax_split = explode(',', $state[0]['tax']);
                            foreach ($tax_split as $tax) {
                                $tax = $this->db->select('*')->from('state_localtax')->where('tax', $state_tax[0]['state'] . "-" . $tax)->where('create_by', $this->session->userdata('user_id'))->get()->result_array();
                                foreach ($tax as $tx) {
                                    $split = explode('-', $tx[$data['employee_data'][0]['employee_tax']]);
                                    if ($split[0] != '' && $split[1] != '') {
                                        if ($final >= $split[0] && $final <= $split[1]) {
                                            $local_tax_range  = $split[0] . "-" . $split[1];
                                            $data['localtax'] = $this->Hrm_model->local_state_tax($data['employee_data'][0]['employee_tax'], $final, $local_tax_range);
                                            if (!empty($data['localtax'])) {
                                                $i = 0;
                                                foreach ($data['localtax'] as $lt) {
                                                    $local_tax_employee = $lt['employee'];
                                                    $local_tax_employer = $lt['employer'];
                                                    $local_tax_ee       = ($local_tax_employee / 100) * $final;
                                                    $local_tax_er       = ($local_tax_employer / 100) * $final;
                                                    $row_employer       = $this->db->select('*')->from('state_localtax')->where('employer', $local_tax_employer)->where('tax', $tx['tax'])->where($data['employee_data'][0]['employee_tax'], $local_tax_range)->where('create_by', $this->session->userdata('user_id'))->count_all_results();
                                                    $data_employer      = "'employer_" . $tx['tax'] . "'";
                                                    if ($row_employer == 1) {
                                                        $t_tx1                                      = $local_tax_er;
                                                        $other_working_tax_employer[$data_employer] = $t_tx1;
                                                    }
                                                    $row           = $this->db->select('*')->from('state_localtax')->where('employee', $local_tax_employee)->where('tax', $tx['tax'])->where($data['employee_data'][0]['employee_tax'], $local_tax_range)->where('create_by', $this->session->userdata('user_id'))->count_all_results();
                                                    $data_employee = "'employee_" . $tx['tax'] . "'";
                                                    $search_tax    = explode('-', $tx['tax']);
                                                    if ($row == 1) {
                                                        $t_tx                              = $local_tax_ee;
                                                        $other_working_tax[$data_employee] = $t_tx;
                                                    }
                                                    $i++;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $test2 = $this->db->select('*')->from('info_payslip')->where('timesheet_id', $timesheetdata[0]['timesheet_id'])
                            ->get()->row();
                        if (!empty($test2->timesheet_id)) {
                            $this->db->where('timesheet_id', $test2->timesheet_id);
                            $this->db->delete('info_payslip');
                        }
                        $test = $this->db->select('time_sheet_id')->from('tax_history')->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                            ->get()->row();
                        if (!empty($test->time_sheet_id)) {
                            $this->db->where('time_sheet_id', $test->time_sheet_id);
                            $this->db->delete('tax_history');
                        }
                        $payperiod  = $data['timesheet_data'][0]['month'];
                        $data['sc'] = $this->Hrm_model->sc_info_count($this->input->post('templ_name'), $payperiod, $decodedId);
                        if (isset($data['sc']['sc'][0]['sc'])) {
                            $scValue = $data['sc']['sc'][0]['sc'];
                        } else {
                            $scValue = 0;
                        }
                        $sc_totalAmount1 = $data['sc']['total_gtotal'];
                        $sc_count        = $data['sc']['count'];
                        if ($sc_totalAmount1 != 0) {
                            $scValuePercentage = ($scValue / $sc_totalAmount1) * 100;
                            $scValueAmount     = ($scValuePercentage / 100) * $sc_totalAmount1;
                        } else {
                            $scValueAmount = 0;
                        }
                        $scValue       = $scValue / 100;
                        $scValueAmount = $scValue * $sc_totalAmount1;
                        if ($st_tax) {
                            foreach ($st_tax as $k => $v) {
                                $existingRecord = $this->db->select('*')
                                    ->from('tax_history')
                                    ->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                                    ->where('employee_id', $timesheetdata[0]['templ_name'])
                                    ->where('tax', str_replace("'", "", explode('-', $k)[1]))
                                    ->get()->row();
                                $split = explode('-', $k);
                                $tx_n  = str_replace("'", "", $split[1]);
                                $code  = '';
                                if (isset($split[2])) {
                                    $code = $split[2];
                                } else {
                                    $code = '';
                                }
                                $code  = str_replace("'", "", $code);
                                $data1 = array(
                                    's_tax'          => $s,
                                    'm_tax'          => $m,
                                    'u_tax'          => $u,
                                    'f_tax'          => $f,
                                    'code'           => $code,
                                    'tax_type'       => 'state_tax',
                                    'sales_c_amount' => $scValueAmount,
                                    'sc'             => $scValue,
                                    'no_of_inv'      => $sc_count,
                                    'tax'            => $tx_n,
                                    'amount'         => round($v, 3),
                                    'time_sheet_id'  => $timesheetdata[0]['timesheet_id'],
                                    'employee_id'    => $timesheetdata[0]['templ_name'],
                                    'created_by'     => $this->session->userdata('user_id'),
                                );
                                $this->db->insert('tax_history', $data1);
                            }
                            $sql = "DELETE t1
                        FROM tax_history t1
                        INNER JOIN tax_history t2 ON t1.id > t2.id
                        AND t1.tax = t2.tax
                        AND t1.code = t2.code
                        AND t1.amount = t2.amount
                        AND t1.created_by = t2.created_by
                        AND t1.time_sheet_id = t2.time_sheet_id
                        WHERE t1.weekly IS NULL
                        AND t1.monthly IS NULL
                        AND t1.biweekly IS NULL;";
                            $this->db->query($sql);
                        }


                        $state_tx = $data['employee_data'][0]['state_tx']; 
                        if ($data['employee_data'][0]['payroll_type'] == 'Hourly') {
                            $minValue = $final;
                            $maxValue = $final;
                            $emp_tax  = $data['employee_data'][0]['employee_tax'];
                            $user_id  = $this->session->userdata('user_id');
                            $query    = "SELECT `$emp_tax`
                            FROM `state_localtax`
                            WHERE `tax` LIKE '%" . $state_tx . "-Income tax%'
                            AND CAST(SUBSTRING_INDEX(`$emp_tax`, '-', 1) AS UNSIGNED) <= ?
                            AND CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`$emp_tax`, '-', -1), '-', 1) AS UNSIGNED) >= ?
                            AND `create_by` = '" . $user_id . "'";
                            $result =$this->db->query($query, array($maxValue, $minValue));
                             
                           
                             if ($result) {
                                $hourly_tax = $result->result_array();


                                if (!empty($hourly_tax)) {
                                    $hourly_range   = $hourly_tax[0][$emp_tax];
                                    $split_values   = explode('-', $hourly_range);
                                    $firstValue     = $split_values[0];
                                    $secondValue    = $split_values[1];
                                    $getvalue       = $minValue - $firstValue;
                                    $h_tax          = '';
                                    $tax_name       = $data['employee_data'][0]['state_tx'];
                                    $data['hourly'] = $this->Hrm_model->hourly_tax_info($data['employee_data'][0]['employee_tax'], $final, $hourly_range, $tax_name);
                                    $st_name        = $data['employee_data'][0]['state_tx'];
                                    $state_names    = $this->Hrm_model->state_names($st_name);

                                    if (!empty($data['hourly'][0]['employee'])) {
                                        foreach ($state_names as $name) {
                                            if (trim($name['state']) == 'Pennsylvania') {
                                                $hourly_employee_details = $data['hourly'][0]['details'];
                                                $addamt                  = explode('$', $hourly_employee_details);
                                                $houly_employee          = $data['hourly'][0]['employee'];
                                                $holy                    = ($houly_employee / 100) * $final;
                                                $hourly                  = round($holy, 3);
                                            } else if (trim($name['state']) == 'New York') {
                                                $hourly_employee_details = $data['hourly'][0]['details'];
                                                $addamt                  = explode('$', $hourly_employee_details);
                                                $houly_employee          = $data['hourly'][0]['employee'];
                                                $holy                    = ($houly_employee / 100) * $getvalue;
                                                $hourly                  = $hourly_employee_details + $holy;
                                            } else if (trim($name['state']) == 'Delaware') {
                                                $hourly_employee_details = $data['hourly'][0]['details'];
                                                $addamt                  = explode('$', $hourly_employee_details);
                                                $houly_employee          = $data['hourly'][0]['employee'];
                                                $holy                    = ($houly_employee / 100) * $getvalue;
                                                $hourly                  = $hourly_employee_details + $holy;
                                            } else if (trim($name['state']) == 'Maryland') {
                                                $hourly_employee_details = $data['hourly'][0]['details'];
                                                $addamt                  = explode('$', $hourly_employee_details);
                                                $houly_employee          = $data['hourly'][0]['employee'];
                                                $holy                    = ($houly_employee / 100) * $getvalue;
                                                $hourly                  = $hourly_employee_details + $holy;
                                            } else if (trim($name['state']) == 'New Jersey') {
                                                $hourly_employee_details = $data['hourly'][0]['details'];
                                                $addamt                  = explode('$', $hourly_employee_details);
                                                $houly_employee          = $data['hourly'][0]['employee'];
                                                $holy                    = ($houly_employee / 100) * $final;
                                                $hourly                  = round($holy, 3);
                                             } else if (trim($name['state']) == 'Virginia') {
                                                $hourly_employee_details = $data['hourly'][0]['details'];
                                                $addamt                  = explode('$', $hourly_employee_details);
                                                $houly_employee          = $data['hourly'][0]['employee'];
                                                $holy                    = ($houly_employee / 100) * $getvalue;
                                                $hourly                   = $hourly_employee_details + $holy;  
                                            }
                                        }
                                    }
                                    $data1 = array(
                                        's_tax'          => $s,
                                        'm_tax'          => $m,
                                        'u_tax'          => $u,
                                        'f_tax'          => $f,
                                        'code'           => $code,
                                        'tax_type'       => 'state_tax',
                                        'sales_c_amount' => $scValueAmount,
                                        'sc'             => $scValue,
                                        'no_of_inv'      => $sc_count,
                                        'tax'            => $tx_n,
                                        'amount'         => $hourly,
                                        'time_sheet_id'  => $timesheetdata[0]['timesheet_id'],
                                        'employee_id'    => $timesheetdata[0]['templ_name'],
                                        'created_by'     => $this->session->userdata('user_id'),
                                    );
                                    $this->db->insert('tax_history', $data1);

                                    $data2 = array(
                                        'amount' => $hourly,
                                    );
                                    // $this->db->where('time_sheet_id', $timesheetdata[0]['timesheet_id']);
                                    // $this->db->where('hourly IS NULL');
                                    // $query = $this->db->get('tax_history');
                                    // if ($query->num_rows() == 0) {
                                        $this->db->where('time_sheet_id', $timesheetdata[0]['timesheet_id']);
                                        $this->db->order_by('id', 'ASC');
                                        $this->db->limit(1);
                                        $this->db->update('tax_history', $data2);
                                    // }
                                    
                                }
                            }
                        } else if ($data['employee_data'][0]['payroll_type'] == 'Salaried-weekly') {
                            $minValue = $final;
                            $maxValue = $final;
                            $user_id  = $this->session->userdata('user_id');
                            $emp_tax  = $data['employee_data'][0]['employee_tax'];
                            $query    = "SELECT `$emp_tax`
                            FROM `weekly_tax_info`
                            WHERE `tax` LIKE '%Weekly " . $state_tx . "-Income tax%'
                            AND CAST(SUBSTRING_INDEX(`$emp_tax`, '-', 1) AS UNSIGNED) <= ?
                            AND CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`$emp_tax`, '-', -1), '-', 1) AS UNSIGNED) >= ?
                            AND `create_by` = '" . $user_id . "'";
                            $result = $this->db->query($query, array($maxValue, $minValue));             
                           
  
                            if ($result) {
                                $weekly_range = $result->result_array();
                                if (!empty($weekly_range)) {
                                    $weekly_range   = $weekly_range[0][$emp_tax];
                                    $split_values   = explode('-', $weekly_range);
                                    $firstValue     = $split_values[0];
                                    $secondValue    = $split_values[1];
                                    $getvalue       = $minValue - $firstValue;
                                    $w_tax          = '';
                                    $data['weekly'] = $this->Hrm_model->weekly_tax_info($data['employee_data'][0]['employee_tax'], $final, $weekly_range);
                                    // $data['weekly']    = $this->Hrm_model->weekly_tax_info_livingtax($lt_name ,$data['employee_data'][0]['employee_tax'],$final ,  $weekly_range );

                                    $st_name        = $data['employee_data'][0]['state_tx'];
                                    $state_names    = $this->Hrm_model->state_names($st_name);
                                                                  
                                if (!empty($data['weekly'][0]['employee'])) {
                                        foreach ($state_names as $name) {
                                            if (trim($name['state']) == 'Pennsylvania') {
                                                $weekly_employee_details = $data['weekly'][0]['details'];
                                                $addamt                  = explode('$', $weekly_employee_details);
                                                $weekly_employee         = $data['weekly'][0]['employee'];
                                                $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                $wkly                    = round($wkly, 2);
                                                $weekly_tax              = $addamt[1] + $wkly;
                                            } else if (trim($name['state']) == 'New York') {
                                                $weekly_employee_details = $data['weekly'][0]['details'];
                                                $addamt                  = explode('$', $weekly_employee_details);
                                                $weekly_employee         = $data['weekly'][0]['employee'];
                                                $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                $wkly                    = round($wkly, 2);
                                                $weekly_tax              = $addamt[1] + $wkly;
                                            } else if (trim($name['state']) == 'Delaware') {
                                                $weekly_employee_details = $data['weekly'][0]['details'];
                                                $addamt                  = explode('$', $weekly_employee_details);
                                                $weekly_employee         = $data['weekly'][0]['employee'];
                                                $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                $wkly                    = round($wkly, 2);
                                                $weekly_tax              = $addamt[1] + $wkly;
                                            } else if (trim($name['state']) == 'Maryland') {
                                                $weekly_employee_details = $data['weekly'][0]['details'];
                                                $addamt                  = explode('$', $weekly_employee_details);
                                                $weekly_employee         = $data['weekly'][0]['employee'];
                                                $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                $wkly                    = round($wkly, 2);
                                                $weekly_tax              = $addamt[1] + $wkly;
                                            } else if (trim($name['state']) == 'New Jersey') {
                                                $weekly_employee_details = $data['weekly'][0]['details'];
                                                $addamt                  = explode('$', $weekly_employee_details);
                                                $weekly_employee         = $data['weekly'][0]['employee'];
                                                $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                $weekly_tax              = $addamt[1] + $wkly;
                                            } else if (trim($name['state']) == 'Virginia') {
                                                $weekly_employee_details = $data['weekly'][0]['details'];
                                                $addamt                  = explode('$', $weekly_employee_details);
                                                $weekly_employee         = $data['weekly'][0]['employee'];
                                                $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                $wkly                    = round($wkly, 2);
                                                $weekly_tax              = $addamt[1] + $wkly;
                                            }
                                        }
                                    }
                                    $data1 = array(
                                        's_tax'          => $s,
                                        'm_tax'          => $m,
                                        'u_tax'          => $u,
                                        'f_tax'          => $f,
                                        'code'           => $code,
                                        'tax_type'       => 'state_tax',
                                        'sales_c_amount' => $scValueAmount,
                                        'sc'             => $scValue,
                                        'no_of_inv'      => $sc_count,
                                        'tax'            => $tx_n,
                                        'amount'         => round($v, 3),
                                        'time_sheet_id'  => $timesheetdata[0]['timesheet_id'],
                                        'employee_id'    => $timesheetdata[0]['templ_name'],
                                        'created_by'     => $this->session->userdata('user_id'),
                                    );
                                    $this->db->insert('tax_history', $data1);


                                    $data2 = array(
                                        'amount' => $weekly_tax,
                                    );
                                    // $this->db->where('time_sheet_id', $timesheetdata[0]['timesheet_id']);
                                    // $this->db->where('weekly IS NOT NULL');
                                    // $query = $this->db->get('tax_history');
                                    // if ($query->num_rows() == 0) {
                                        $this->db->where('time_sheet_id', $timesheetdata[0]['timesheet_id']);
                                        $this->db->order_by('id', 'ASC');
                                        $this->db->limit(1);
                                        $this->db->update('tax_history', $data2);
                                    // }
                                  
                                    // $this->db->insert('tax_history', $data1);
                                    // $sql = "DELETE t1
                                    // FROM tax_history t1
                                    // INNER JOIN tax_history t2 ON t1.id > t2.id
                                    // AND t1.tax = t2.tax
                                    // AND t1.code = t2.code
                                    // AND t1.amount = t2.amount
                                    // AND t1.created_by = t2.created_by
                                    // AND t1.time_sheet_id = t2.time_sheet_id
                                    // WHERE t1.weekly IS NULL
                                    // AND t1.monthly IS NULL
                                    // AND t1.biweekly IS NULL; ";
                                    //     $this->db->query($sql);
                                    } else {
                                    $minValue = $final;
                                    $maxValue = $final;
                                    $user_id  = $this->session->userdata('user_id');
                                    $emp_tax  = $data['employee_data'][0]['employee_tax'];
                                    $query    = "SELECT `$emp_tax`
                                    FROM `state_localtax`
                                    WHERE `tax` LIKE '%" . $state_tx . "-Income tax%'
                                    AND CAST(SUBSTRING_INDEX(`$emp_tax`, '-', 1) AS UNSIGNED) <= ?
                                    AND CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`$emp_tax`, '-', -1), '-', 1) AS UNSIGNED) >= ?
                                    AND `create_by` = '" . $user_id . "'";
                                    $result = $this->db->query($query, array($maxValue, $minValue));
                                    if ($result) {
                                        $weekly_range = $result->result_array();
                                        if (!empty($weekly_range)) {
                                            $hourly_range   = $weekly_range[0][$emp_tax];
                                            $split_values   = explode('-', $hourly_range);
                                            $firstValue     = $split_values[0];
                                            $secondValue    = $split_values[1];
                                            $getvalue       = $minValue - $firstValue;
                                            $w_tax          = '';
                                            $tax_name       = $data['employee_data'][0]['state_tx'];
                                            $data['weekly'] = $this->Hrm_model->hourly_tax_info($data['employee_data'][0]['employee_tax'], $final, $hourly_range, $tax_name);
                                            $st_name        = $data['employee_data'][0]['state_tx'];
                                            $state_names    = $this->Hrm_model->state_names($st_name);
                                            foreach ($state_names as $name) {
                                                if (trim($name['state']) == 'Pennsylvania') {
                                                    $weekly_employee_details = $data['weekly'][0]['details'];
                                                    $addamt                  = $weekly_employee_details;
                                                    $weekly_employee         = $data['weekly'][0]['employee'];
                                                    $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                    $wkly                    = round($wkly, 2);
                                                    $weekly_tax              = $addamt + $wkly;
                                                } else if (trim($name['state']) == 'New York') {
                                                    $weekly_employee_details = $data['weekly'][0]['details'];
                                                    $addamt                  = $weekly_employee_details;
                                                    $weekly_employee         = $data['weekly'][0]['employee'];
                                                    $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                    $wkly                    = round($wkly, 2);
                                                    $weekly_tax              = $addamt + $wkly;
                                                } else if (trim($name['state']) == 'Delaware') {
                                                    $weekly_employee_details = $data['weekly'][0]['details'];
                                                    $addamt                  = $weekly_employee_details;
                                                    $weekly_employee         = $data['weekly'][0]['employee'];
                                                    $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                    $wkly                    = round($wkly, 2);
                                                    $weekly_tax              = $addamt + $wkly;
                                                } else if (trim($name['state']) == 'Maryland') {
                                                    $weekly_employee_details = $data['weekly'][0]['details'];
                                                    $addamt                  = $weekly_employee_details;
                                                    $weekly_employee         = $data['weekly'][0]['employee'];
                                                    $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                    $wkly                    = round($wkly, 2);
                                                    $weekly_tax              = $addamt + $wkly;
                                                } else if (trim($name['state']) == 'New Jersey') {
                                                    $weekly_employee_details = $data['weekly'][0]['details'];
                                                    $addamt                  = $weekly_employee_details;
                                                    $weekly_employee         = $data['weekly'][0]['employee'];
                                                    $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                    $weekly_tax              = $addamt + $wkly;
                                                }
                                             else if (trim($name['state']) == 'Virginia') {
                                                $weekly_employee_details = $data['weekly'][0]['details'];
                                                $addamt                  = explode('$', $weekly_employee_details);
                                                $weekly_employee         = $data['weekly'][0]['employee'];
                                                $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                $wkly                    = round($wkly, 2);
                                                $weekly_tax              = $addamt[1] + $wkly;
                                            }
 
                                            }
                                            $data1 = array(
                                                's_tax'          => $s,
                                                'm_tax'          => $m,
                                                'u_tax'          => $u,
                                                'f_tax'          => $f,
                                                'code'           => $code,
                                                'tax_type'       => 'state_tax',
                                                'sales_c_amount' => $scValueAmount,
                                                'sc'             => $scValue,
                                                'no_of_inv'      => $sc_count,
                                                'tax'            => $tx_n,
                                                'amount'         => round($v, 3),
                                                'time_sheet_id'  => $timesheetdata[0]['timesheet_id'],
                                                'employee_id'    => $timesheetdata[0]['templ_name'],
                                                'created_by'     => $decodedId,
                                            );
                                            $data2 = array(
                                                'amount' => $weekly_tax,
                                            );
                                            $this->db->where('time_sheet_id', $timesheetdata[0]['timesheet_id']);
                                            $this->db->where('weekly IS NOT NULL');
                                            $query = $this->db->get('tax_history');
                                            if ($query->num_rows() == 0) {
                                                $this->db->where('time_sheet_id', $timesheetdata[0]['timesheet_id']);
                                                $this->db->order_by('id', 'ASC');
                                                $this->db->limit(1);
                                                $this->db->update('tax_history', $data2);
                                            }
                                            $this->db->insert('tax_history', $data1);
                                            $sql = "DELETE t1
                                        FROM tax_history t1
                                        INNER JOIN tax_history t2 ON t1.id > t2.id
                                        AND t1.tax = t2.tax
                                        AND t1.code = t2.code
                                        AND t1.amount = t2.amount
                                        AND t1.created_by = t2.created_by
                                        AND t1.time_sheet_id = t2.time_sheet_id
                                        WHERE t1.weekly IS NULL
                                        AND t1.monthly IS NULL
                                        AND t1.biweekly IS NULL; ";
                                            $this->db->query($sql);
                                        }
                                    }
                                }
                            }
                        } else if ($data['employee_data'][0]['payroll_type'] == 'Salaried-BiWeekly') {
                            $minValue = $final;
                            $maxValue = $final;
                            $user_id  = $decodedId;
                            $emp_tax  = $data['employee_data'][0]['employee_tax'];
                            $query    = "SELECT `$emp_tax`
                        FROM `biweekly_tax_info`
                        WHERE `tax` LIKE '%BIWeekly " . $state_tx . "-Income tax%'
                        AND CAST(SUBSTRING_INDEX(`$emp_tax`, '-', 1) AS UNSIGNED) <= ?
                        AND CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`$emp_tax`, '-', -1), '-', 1) AS UNSIGNED) >= ?
                        AND `create_by` = '" . $user_id . "'";
                            $result = $this->db->query($query, array($maxValue, $minValue));
                            if ($result) {
                                $biweekly_range = $result->result_array();
                                if (!empty($biweekly_range)) {
                                    $biweekly_range   = $biweekly_range[0][$emp_tax];
                                    $split_values     = explode('-', $biweekly_range);
                                    $firstValue       = $split_values[0];
                                    $secondValue      = $split_values[1];
                                    $getvalue         = $minValue - $firstValue;
                                    $bw_tax           = '';
                                    $data['biweekly'] = $this->Hrm_model->biweekly_tax_info($data['employee_data'][0]['employee_tax'], $final, $biweekly_range);
                                    $st_name          = $data['employee_data'][0]['state_tx'];
                                    $state_names      = $this->Hrm_model->state_names($st_name);
                                    if (!empty($data['biweekly'][0]['employee'])) {
                                        foreach ($state_names as $name) {
                                            if (trim($name['state']) == 'Pennsylvania') {
                                                $biweekly_employee_details = $data['biweekly'][0]['details'];
                                                $addamt1                   = explode('$', $biweekly_employee_details);
                                                $biweekly_employee         = $data['biweekly'][0]['employee'];
                                                $biwkly                    = ($biweekly_employee / 100) * $getvalue;
                                                $biwkly                    = round($biwkly, 2);
                                                $biweekly_tax              = $addamt1[1] + $biwkly;
                                            } else if (trim($name['state']) == 'New York') {
                                                $biweekly_employee_details = $data['biweekly'][0]['details'];
                                                $addamt1                   = explode('$', $biweekly_employee_details);
                                                $biweekly_employee         = $data['biweekly'][0]['employee'];
                                                $biwkly                    = ($biweekly_employee / 100) * $getvalue;
                                                $biwkly                    = round($biwkly, 2);
                                                $biweekly_tax              = $addamt1[1] + $biwkly;
                                            } else if (trim($name['state']) == 'Delaware') {
                                                $biweekly_employee_details = $data['biweekly'][0]['details'];
                                                $addamt1                   = explode('$', $biweekly_employee_details);
                                                $biweekly_employee         = $data['biweekly'][0]['employee'];
                                                $biwkly                    = ($biweekly_employee / 100) * $getvalue;
                                                $biwkly                    = round($biwkly, 2);
                                                $biweekly_tax              = $addamt1[1] + $biwkly;
                                            } else if (trim($name['state']) == 'Maryland') {
                                                $biweekly_employee_details = $data['biweekly'][0]['details'];
                                                $addamt1                   = explode('$', $biweekly_employee_details);
                                                $biweekly_employee         = $data['biweekly'][0]['employee'];
                                                $biwkly                    = ($biweekly_employee / 100) * $getvalue;
                                                $biwkly                    = round($biwkly, 2);
                                                $biweekly_tax              = $addamt1[1] + $biwkly;
                                            } else if (trim($name['state']) == 'New Jersey') {
                                                $biweekly_employee_details = $data['biweekly'][0]['details'];
                                                $addamt1                   = explode('$', $biweekly_employee_details);
                                                $biweekly_employee         = $data['biweekly'][0]['employee'];
                                                $biwkly                    = ($biweekly_employee / 100) * $getvalue;
                                                $biwkly                    = round($biwkly, 2);
                                                $biweekly_tax              = $addamt1[1] + $biwkly;
                                            }
                                            else if (trim($name['state']) == 'Virginia') {
                                                $biweekly_employee_details = $data['biweekly'][0]['details'];
                                                $addamt1                   = explode('$', $biweekly_employee_details);
                                                $biweekly_employee         = $data['biweekly'][0]['employee'];
                                                $biwkly                    = ($biweekly_employee / 100) * $getvalue;
                                                $biwkly                    = round($biwkly, 2);
                                                $biweekly_tax             = $addamt1[1] + $biwkly;
                                            }
                                        }
                                    }
                                    $data1 = array(
                                        's_tax'          => $s,
                                        'm_tax'          => $m,
                                        'u_tax'          => $u,
                                        'f_tax'          => $f,
                                        'code'           => $code,
                                        'tax_type'       => 'state_tax',
                                        'sales_c_amount' => $scValueAmount,
                                        'sc'             => $scValue,
                                        'no_of_inv'      => $sc_count,
                                        'tax'            => $tx_n,
                                        'amount'         => round($v, 3),
                                        'time_sheet_id'  => $timesheetdata[0]['timesheet_id'],
                                        'employee_id'    => $timesheetdata[0]['templ_name'],
                                        'created_by'     => $this->session->userdata('user_id'),
                                    );
                                    $this->db->insert('tax_history', $data1);
                                
                                    $data2 = array(
                                        'biweekly' => $biweekly_tax,
                                    );

                                    // $this->db->where('time_sheet_id', $timesheetdata[0]['timesheet_id']);
                                    // $this->db->where('biweekly IS NOT NULL');
                                    // $query = $this->db->get('tax_history');
                                    // if ($query->num_rows() == 0) {
                                        $this->db->where('time_sheet_id', $timesheetdata[0]['timesheet_id']);
                                        $this->db->order_by('id', 'ASC');
                                        $this->db->limit(1);
                                        $this->db->update('tax_history', $data2);
                                //     }
                                //     $sql = "DELETE t1
                                // FROM tax_history t1
                                // INNER JOIN tax_history t2 ON t1.id > t2.id
                                // AND t1.tax = t2.tax
                                // AND t1.code = t2.code
                                // AND t1.amount = t2.amount
                                // AND t1.created_by = t2.created_by
                                // AND t1.time_sheet_id = t2.time_sheet_id
                                // WHERE t1.weekly IS NULL
                                // AND t1.monthly IS NULL
                                // AND t1.biweekly IS NULL;";
                                //     $this->db->query($sql);
                                } else {
                                    $minValue = $final;
                                    $maxValue = $final;
                                    $user_id  = $this->session->userdata('user_id');
                                    $emp_tax  = $data['employee_data'][0]['employee_tax'];
                                    $query    = "SELECT `$emp_tax`
                                FROM `state_localtax`
                                WHERE `tax` LIKE '%" . $state_tx . "-Income tax%'
                                AND CAST(SUBSTRING_INDEX(`$emp_tax`, '-', 1) AS UNSIGNED) <= ?
                                AND CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`$emp_tax`, '-', -1), '-', 1) AS UNSIGNED) >= ?
                                AND `create_by` = '" . $user_id . "'";
                                    $result = $this->db->query($query, array($maxValue, $minValue));
                                    if ($result) {
                                        $weekly_range = $result->result_array();
                                        if (!empty($weekly_range)) {
                                            $hourly_range   = $weekly_range[0][$emp_tax];
                                            $split_values   = explode('-', $hourly_range);
                                            $firstValue     = $split_values[0];
                                            $secondValue    = $split_values[1];
                                            $getvalue       = $minValue - $firstValue;
                                            $w_tax          = '';
                                            $tax_name       = $data['employee_data'][0]['state_tx'];
                                            $data['weekly'] = $this->Hrm_model->hourly_tax_info($data['employee_data'][0]['employee_tax'], $final, $hourly_range, $tax_name);
                                            $st_name        = $data['employee_data'][0]['state_tx'];
                                            $state_names    = $this->Hrm_model->state_names($st_name);
                                            foreach ($state_names as $name) {
                                                if (trim($name['state']) == 'Pennsylvania') {
                                                    $weekly_employee_details = $data['weekly'][0]['details'];
                                                    $addamt                  = $weekly_employee_details;
                                                    $weekly_employee         = $data['weekly'][0]['employee'];
                                                    $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                    $wkly                    = round($wkly, 2);
                                                    $weekly_tax              = $addamt + $wkly;
                                                } else if (trim($name['state']) == 'New York') {
                                                    $weekly_employee_details = $data['weekly'][0]['details'];
                                                    $addamt                  = $weekly_employee_details;
                                                    $weekly_employee         = $data['weekly'][0]['employee'];
                                                    $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                    $wkly                    = round($wkly, 2);
                                                    $weekly_tax              = $addamt + $wkly;
                                                } else if (trim($name['state']) == 'Delaware') {
                                                    $weekly_employee_details = $data['weekly'][0]['details'];
                                                    $addamt                  = $weekly_employee_details;
                                                    $weekly_employee         = $data['weekly'][0]['employee'];
                                                    $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                    $wkly                    = round($wkly, 2);
                                                    $weekly_tax              = $addamt + $wkly;
                                                } else if (trim($name['state']) == 'Maryland') {
                                                    $weekly_employee_details = $data['weekly'][0]['details'];
                                                    $addamt                  = $weekly_employee_details;
                                                    $weekly_employee         = $data['weekly'][0]['employee'];
                                                    $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                    $wkly                    = round($wkly, 2);
                                                    $weekly_tax              = $addamt + $wkly;
                                                } else if (trim($name['state']) == 'New Jersey') {
                                                    $weekly_employee_details = $data['weekly'][0]['details'];
                                                    $addamt                  = $weekly_employee_details;
                                                    $weekly_employee         = $data['weekly'][0]['employee'];
                                                    $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                    $weekly_tax              = $addamt + $wkly;
                                                }
                                                else if (trim($name['state']) == 'Virginia') {
                                                    $weekly_employee_details = $data['weekly'][0]['details'];
                                                    $addamt                  = explode('$', $weekly_employee_details);
                                                    $weekly_employee         = $data['weekly'][0]['employee'];
                                                    $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                    $wkly                    = round($wkly, 2);
                                                    $weekly_tax              = $addamt[1] + $wkly;
                                                }
                                            }
                                            $data1 = array(
                                                's_tax'          => $s,
                                                'm_tax'          => $m,
                                                'u_tax'          => $u,
                                                'f_tax'          => $f,
                                                'code'           => $code,
                                                'tax_type'       => 'state_tax',
                                                'sales_c_amount' => $scValueAmount,
                                                'sc'             => $scValue,
                                                'no_of_inv'      => $sc_count,
                                                'tax'            => $tx_n,
                                                'amount'         => round($v, 3),
                                                'time_sheet_id'  => $timesheetdata[0]['timesheet_id'],
                                                'employee_id'    => $timesheetdata[0]['templ_name'],
                                                'created_by'     => $this->session->userdata('user_id'),
                                            );
                                          
                                            $data2 = array(
                                                'amount' => $weekly_tax,
                                            );
                                            $this->db->where('time_sheet_id', $timesheetdata[0]['timesheet_id']);
                                            $this->db->where('weekly IS NOT NULL');
                                            $query = $this->db->get('tax_history');
                                            if ($query->num_rows() == 0) {
                                                $this->db->where('time_sheet_id', $timesheetdata[0]['timesheet_id']);
                                                $this->db->order_by('id', 'ASC');
                                                $this->db->limit(1);
                                                $this->db->update('tax_history', $data2);
                                            }
                                            $this->db->insert('tax_history', $data1);
                                            $sql = "DELETE t1
                                        FROM tax_history t1
                                        INNER JOIN tax_history t2 ON t1.id > t2.id
                                        AND t1.tax = t2.tax
                                        AND t1.code = t2.code
                                        AND t1.amount = t2.amount
                                        AND t1.created_by = t2.created_by
                                        AND t1.time_sheet_id = t2.time_sheet_id
                                        WHERE t1.weekly IS NULL
                                        AND t1.monthly IS NULL
                                        AND t1.biweekly IS NULL; ";
                                            $this->db->query($sql);
                                        }
                                    }
                                }
                            }
                        } else if ($data['employee_data'][0]['payroll_type'] == 'Salaried-Monthly') {
                            $minValue = $final;
                            $maxValue = $final;
                            $user_id  = $this->session->userdata('user_id');
                            $emp_tax  = $data['employee_data'][0]['employee_tax'];
                            $query    = "SELECT `$emp_tax`
                        FROM `monthly_tax_info`
                        WHERE `tax` LIKE '%Monthly " . $state_tx . "-Income tax%'
                        AND CAST(SUBSTRING_INDEX(`$emp_tax`, '-', 1) AS UNSIGNED) <= ?
                        AND CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`$emp_tax`, '-', -1), '-', 1) AS UNSIGNED) >= ?
                        AND `create_by` = '" . $user_id . "'";
                            $result = $this->db->query($query, array($maxValue, $minValue));
                            if ($result) {
                                $monthly_range = $result->result_array();
                                if (!empty($monthly_range)) {
                                    $monthly_range   = $monthly_range[0][$emp_tax];
                                    $split_values    = explode('-', $monthly_range);
                                    $firstValue      = $split_values[0];
                                    $secondValue     = $split_values[1];
                                    $getvalue        = $minValue - $firstValue;
                                    $m_tax           = '';
                                    $data['monthly'] = $this->Hrm_model->monthly_tax_info($data['employee_data'][0]['employee_tax'], $final, $monthly_range);
                                    $st_name         = $data['employee_data'][0]['state_tx'];
                                    $state_names     = $this->Hrm_model->state_names($st_name);
                                    if (!empty($data['monthly'][0]['employee'])) {
                                        foreach ($state_names as $name) {
                                            if (trim($name['state']) == 'Pennsylvania') {
                                                $monthy_employee_details = $data['monthly'][0]['details'];
                                                $addamt1                 = explode('$', $monthy_employee_details);
                                                $monthly_employee        = $data['monthly'][0]['employee'];
                                                $month                   = ($monthly_employee / 100) * $getvalue;
                                                $month                   = round($month, 2);
                                                $monthly_tax             = $addamt1[1] + $month;
                                            } else if (trim($name['state']) == 'New York') {
                                                $monthy_employee_details = $data['monthly'][0]['details'];
                                                $addamt1                 = explode('$', $monthy_employee_details);
                                                $monthly_employee        = $data['monthly'][0]['employee'];
                                                $month                   = ($monthly_employee / 100) * $getvalue;
                                                $month                   = round($month, 2);
                                                $monthly_tax             = $addamt1[1] + $month;
                                            } else if (trim($name['state']) == 'Delaware') {
                                                $monthy_employee_details = $data['monthly'][0]['details'];
                                                $addamt1                 = explode('$', $monthy_employee_details);
                                                $monthly_employee        = $data['monthly'][0]['employee'];
                                                $month                   = ($monthly_employee / 100) * $getvalue;
                                                $month                   = round($month, 2);
                                                $monthly_tax             = $addamt1[1] + $month;
                                            } else if (trim($name['state']) == 'Maryland') {
                                                $monthy_employee_details = $data['monthly'][0]['details'];
                                                $addamt1                 = explode('$', $monthy_employee_details);
                                                $monthly_employee        = $data['monthly'][0]['employee'];
                                                $month                   = ($monthly_employee / 100) * $getvalue;
                                                $month                   = round($month, 2);
                                                $monthly_tax             = $addamt1[1] + $month;
                                            } else if (trim($name['state']) == 'New Jersey') {
                                                $monthy_employee_details = $data['monthly'][0]['details'];
                                                $addamt1                 = explode('$', $monthy_employee_details);
                                                $monthly_employee        = $data['monthly'][0]['employee'];
                                                $month                   = ($monthly_employee / 100) * $getvalue;
                                                $month                   = round($month, 2);
                                                $monthly_tax             = $addamt1[1] + $month;
                                                } else if (trim($name['state']) == 'Virginia') {
                                                    $monthy_employee_details = $data['monthly'][0]['details'];
                                                    $addamt1                 = explode('$', $monthy_employee_details);
                                                    $monthly_employee        = $data['monthly'][0]['employee'];
                                                    $month                   = ($monthly_employee / 100) * $getvalue;
                                                    $month                   = round($month, 2);
                                                    $monthly_tax       = $addamt1[1] + $month;
                                                }
                                        }
                                    }
                                    $data1 = array(
                                        's_tax'          => $s,
                                        'm_tax'          => $m,
                                        'u_tax'          => $u,
                                        'f_tax'          => $f,
                                        'code'           => $code,
                                        'tax_type'       => 'state_tax',
                                        'sales_c_amount' => $scValueAmount,
                                        'sc'             => $scValue,
                                        'no_of_inv'      => $sc_count,
                                        'tax'            => $tx_n,
                                        'amount'         => round($v, 3),
                                        'time_sheet_id'  => $timesheetdata[0]['timesheet_id'],
                                        'employee_id'    => $timesheetdata[0]['templ_name'],
                                        'created_by'     => $this->session->userdata('user_id'),
                                    );
                                    $this->db->insert('tax_history', $data1);
                                    $data2 = array(
                                        'monthly' => $monthly_tax,
                                    );
                                    // $this->db->where('time_sheet_id', $timesheetdata[0]['timesheet_id']);
                                    // $this->db->where('monthly IS NOT NULL');
                                    // $query = $this->db->get('tax_history');
                                    // if ($query->num_rows() == 0) {
                                        $this->db->where('time_sheet_id', $timesheetdata[0]['timesheet_id']);
                                        $this->db->order_by('id', 'ASC');
                                        $this->db->limit(1);
                                        $this->db->update('tax_history', $data2);
                                //     }
                                //     $sql = "DELETE t1
                                // FROM tax_history t1
                                // INNER JOIN tax_history t2 ON t1.id > t2.id
                                // AND t1.tax = t2.tax
                                // AND t1.code = t2.code
                                // AND t1.amount = t2.amount
                                // AND t1.created_by = t2.created_by
                                // AND t1.time_sheet_id = t2.time_sheet_id
                                // WHERE t1.weekly IS NULL
                                // AND t1.monthly IS NULL
                                // AND t1.biweekly IS NULL;";
                                //     $this->db->query($sql);
                                }
                            }
                        } else {
                            $data1 = array(
                                's_tax'          => $s,
                                'm_tax'          => $m,
                                'u_tax'          => $u,
                                'f_tax'          => $f,
                                'code'           => $code,
                                'tax_type'       => 'state_tax',
                                'sales_c_amount' => $scValueAmount,
                                'sc'             => $scValue,
                                'no_of_inv'      => $sc_count,
                                'tax'            => $tx_n,
                                'amount'         => round($v, 3),
                                'time_sheet_id'  => $timesheetdata[0]['timesheet_id'],
                                'employee_id'    => $timesheetdata[0]['templ_name'],
                                'created_by'     => $this->session->userdata('user_id'),
                            );
                            $this->db->insert('tax_history', $data1);
                            $sql = "DELETE t1
                        FROM tax_history t1
                        INNER JOIN tax_history t2 ON t1.id > t2.id
                        AND t1.tax = t2.tax
                        AND t1.code = t2.code
                        AND t1.amount = t2.amount
                        AND t1.created_by = t2.created_by
                        AND t1.time_sheet_id = t2.time_sheet_id
                        WHERE t1.weekly IS NULL
                        AND t1.monthly IS NULL
                        AND t1.biweekly IS NULL;
                        ";
                            $this->db->query($sql);
                        }





                        if ($st_tax_employer) {
                            foreach ($st_tax_employer as $k => $v) {
                                if (trim(round($v, 3)) > 0) {
                                    $existingRecord = $this->db->select('*')
                                        ->from('tax_history_employer')
                                        ->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                                        ->where('employee_id', $timesheetdata[0]['templ_name'])
                                        ->where('tax', str_replace("'", "", explode('-', $k)[1]))
                                        ->get()->row();
                                    $split = explode('-', $k);
                                    $tx_n  = str_replace("'", "", $split[1]);
                                    $code  = '';
                                    if (isset($split[2])) {
                                        $code = $split[2];
                                    } else {
                                        $code = '';
                                    }
                                    $code  = str_replace("'", "", $code);
                                    $data1 = array(
                                        's_tax'         => $ss,
                                        'm_tax'         => $mm,
                                        'u_tax'         => $uu,
                                        'f_tax'         => $ff,
                                        'code'          => $code,
                                        'tax_type'      => 'state_tax',
                                        'tax'           => $tx_n,
                                        'amount'        => round($v, 3),
                                        'time_sheet_id' => $timesheetdata[0]['timesheet_id'],
                                        'employee_id'   => $timesheetdata[0]['templ_name'],
                                        'weekly'        => $weekly_tax,
                                        'biweekly'      => $biweekly_tax,
                                        'created_by'    => $this->session->userdata('user_id'),
                                        'unemployement_total'  => $tax_amt_final,
                                    );
                                    $this->db->insert('tax_history_employer', $data1);
                                }
                            }
                            $sql = "DELETE t1
                        FROM tax_history t1
                        INNER JOIN tax_history t2 ON t1.id > t2.id
                        AND t1.tax = t2.tax
                        AND t1.code = t2.code
                        AND t1.amount = t2.amount
                        AND t1.created_by = t2.created_by
                        AND t1.time_sheet_id = t2.time_sheet_id
                        WHERE t1.weekly IS NULL
                        AND t1.monthly IS NULL
                        AND t1.biweekly IS NULL;";
                            $this->db->query($sql);
                        }
 

                        if ($living_state_tax) {
                            $payperiod  = $data['timesheet_data'][0]['month'];
                            $data['sc'] = $this->Hrm_model->sc_info_count($this->input->post('templ_name'), $payperiod , $decodedId);
                            if (isset($data['sc']['sc'][0]['sc'])) {
                                $scValue = $data['sc']['sc'][0]['sc'];
                            } else {
                                $scValue = 0;
                            }
                            $sc_totalAmount1 = $data['sc']['total_gtotal'];
                            $sc_count        = $data['sc']['count'];
                            if ($sc_totalAmount1 != 0) {
                                $scValuePercentage = ($scValue / $sc_totalAmount1) * 100;
                                $scValueAmount     = ($scValuePercentage / 100) * $sc_totalAmount1;
                            } else {
                                $scValueAmount = 0;
                            }
                            $scValue       = $scValue / 100;
                            $scValueAmount = $scValue * $sc_totalAmount1;
                            foreach ($living_state_tax as $k => $v) {
                                $split = explode('-', $k);
                                $tx_n  = str_replace("'", "", $split[1]);
                                $code  = '';
                                if (isset($split[2])) {
                                    $code = $split[2];
                                } else {
                                    $code = '';
                                }
                                $code       = str_replace("'", "", $code);

                                $living_tax = $data['employee_data'][0]['living_state_tax'];
         
 
                                if ($data['employee_data'][0]['payroll_type'] == 'Hourly') {
                                    $minValue = $final;
                                    $maxValue = $final;
                                    $user_id  = $this->session->userdata('user_id');
                                    $emp_tax  = $data['employee_data'][0]['employee_tax'];
                                    $query    = "SELECT `$emp_tax`
                                FROM `state_localtax`
                                WHERE `tax` LIKE '%" . $living_tax . "-Income tax%'
                                AND CAST(SUBSTRING_INDEX(`$emp_tax`, '-', 1) AS UNSIGNED) <= ?
                                AND CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`$emp_tax`, '-', -1), '-', 1) AS UNSIGNED) >= ?
                                AND `create_by` = '" . $user_id . "'";
                                    $result = $this->db->query($query, array($maxValue, $minValue));
                                    if ($result) {
                                        $hourly_tax = $result->result_array();
                                        if (!empty($hourly_tax)) {
                                            $hourly_range      = $hourly_tax[0][$emp_tax];
                                            $split_values      = explode('-', $hourly_range);
                                            $firstValue        = $split_values[0];
                                            $secondValue       = $split_values[1];
                                            $getvalue          = $minValue - $firstValue;
                                            $h_tax             = '';
                                            $st_name           = $data['employee_data'][0]['living_state_tax'];
                                            $data['hourly']    = $this->Hrm_model->living_hourly_tax_info($data['employee_data'][0]['employee_tax'], $final, $hourly_range, $st_name);
                                            $livingstate_names = $this->Hrm_model->state_names($st_name);
                                            if (!empty($data['hourly'][0]['employee'])) {
                                                foreach ($livingstate_names as $name) {
                                                    if (trim($name['state']) == 'Pennsylvania') {
                                                        $hourly_employee_details = $data['hourly'][0]['details'];
                                                        $addamt                  = explode('$', $hourly_employee_details);
                                                        $houly_employee          = $data['hourly'][0]['employee'];
                                                        $holy                    = ($houly_employee / 100) * $final;
                                                        $hourlyliving            = round($holy, 3);
                                                    } else if (trim($name['state']) == 'New York') {
                                                        $hourly_employee_details = $data['hourly'][0]['details'];
                                                        $addamt                  = explode('$', $hourly_employee_details);
                                                        $houly_employee          = $data['hourly'][0]['employee'];
                                                        $holy                    = ($houly_employee / 100) * $getvalue;
                                                        $hourlyliving            = $hourly_employee_details + $holy;
                                                    } else if (trim($name['state']) == 'Delaware') {
                                                        $hourly_employee_details = $data['hourly'][0]['details'];
                                                        $addamt                  = explode('$', $hourly_employee_details);
                                                        $houly_employee          = $data['hourly'][0]['employee'];
                                                        $holy                    = ($houly_employee / 100) * $getvalue;
                                                        $hourlyliving            = $hourly_employee_details + $holy;
                                                    } else if (trim($name['state']) == 'Maryland') {
                                                        $hourly_employee_details = $data['hourly'][0]['details'];
                                                        $addamt                  = explode('$', $hourly_employee_details);
                                                        $houly_employee          = $data['hourly'][0]['employee'];
                                                        $holy                    = ($houly_employee / 100) * $getvalue;
                                                        $hourlyliving            = $hourly_employee_details + $holy;
                                                    } else if (trim($name['state']) == 'New Jersey') {
                                                        $hourly_employee_details = $data['hourly'][0]['details'];
                                                        $addamt                  = explode('$', $hourly_employee_details);
                                                        $houly_employee          = $data['hourly'][0]['employee'];
                                                        $holy                    = ($houly_employee / 100) * $final;
                                                        $hourlyliving            = round($holy, 3);
                                                    }

                                                    else if (trim($name['state']) == 'Virginia') {
                                                        $hourly_employee_details = $data['hourly'][0]['details'];
                                                        $addamt                  = explode('$', $hourly_employee_details);
                                                        $houly_employee          = $data['hourly'][0]['employee'];
                                                        $holy                    = ($houly_employee / 100) * $getvalue;
                                                        $hourlyliving            = $hourly_employee_details + $holy;                                                                                               
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else if ($data['employee_data'][0]['payroll_type'] == 'Salaried-weekly') {
                                    $minValue = $final;
                                    $maxValue = $final;
                                    $user_id  = $this->session->userdata('user_id');
                                    $emp_tax  = $data['employee_data'][0]['employee_tax'];
                                    $query    = "SELECT `$emp_tax`
                                FROM `weekly_tax_info`
                                WHERE `tax` LIKE '%Weekly " . $living_tax . "-Income tax%'
                                AND CAST(SUBSTRING_INDEX(`$emp_tax`, '-', 1) AS UNSIGNED) <= ?
                                AND CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`$emp_tax`, '-', -1), '-', 1) AS UNSIGNED) >= ?
                                AND `create_by` = '" . $user_id . "'";
                                    $result = $this->db->query($query, array($maxValue, $minValue));
                                    if ($result) {
                                        $weekly_range = $result->result_array();
                                        if (!empty($weekly_range)) {
                                            $weekly_range      = $weekly_range[0][$emp_tax];
                                            $split_values      = explode('-', $weekly_range);
                                            $firstValue        = $split_values[0];
                                            $secondValue       = $split_values[1];
                                            $getvalue          = $minValue - $firstValue;
                                            $w_tax             = '';
                                            $data['weekly']    = $this->Hrm_model->weekly_tax_info($data['employee_data'][0]['employee_tax'], $final, $weekly_range);
                                            $st_name           = $data['employee_data'][0]['living_state_tax'];
                                            $livingstate_names = $this->Hrm_model->state_names($st_name);
                                            if (!empty($data['weekly'][0]['employee'])) {
                                                foreach ($livingstate_names as $name) {
                                                    if (trim($name['state']) == 'Pennsylvania') {
                                                        $weekly_employee_details = $data['weekly'][0]['details'];
                                                        $addamt                  = explode('$', $weekly_employee_details);
                                                        $weekly_employee         = $data['weekly'][0]['employee'];
                                                        $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                        $wkly                    = round($wkly, 2);
                                                        $weekly_taxliving        = $addamt[1] + $wkly;
                                                    } else if (trim($name['state']) == 'New York') {
                                                        $weekly_employee_details = $data['weekly'][0]['details'];
                                                        $addamt                  = explode('$', $weekly_employee_details);
                                                        $weekly_employee         = $data['weekly'][0]['employee'];
                                                        $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                        $wkly                    = round($wkly, 2);
                                                        $weekly_taxliving        = $addamt[1] + $wkly;
                                                    } else if (trim($name['state']) == 'Delaware') {
                                                        $weekly_employee_details = $data['weekly'][0]['details'];
                                                        $addamt                  = explode('$', $weekly_employee_details);
                                                        $weekly_employee         = $data['weekly'][0]['employee'];
                                                        $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                        $wkly                    = round($wkly, 2);
                                                        $weekly_taxliving        = $addamt[1] + $wkly;
                                                    } else if (trim($name['state']) == 'Maryland') {
                                                        $weekly_employee_details = $data['weekly'][0]['details'];
                                                        $addamt                  = explode('$', $weekly_employee_details);
                                                        $weekly_employee         = $data['weekly'][0]['employee'];
                                                        $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                        $wkly                    = round($wkly, 2);
                                                        $weekly_taxliving        = $addamt[0] + $wkly;
                                                    } else if (trim($name['state']) == 'New Jersey') {
                                                        $weekly_employee_details = $data['weekly'][0]['details'];
                                                        $addamt                  = explode('$', $weekly_employee_details);
                                                        $weekly_employee         = $data['weekly'][0]['employee'];
                                                        $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                        $wkly                    = round($wkly, 2);
                                                        $weekly_taxliving        = $addamt[1] + $wkly;                                           
                                                    } else if (trim($name['state']) == 'Virginia') {
                                                        $weekly_employee_details = $data['weekly'][0]['details'];
                                                        $addamt                  = explode('$', $weekly_employee_details);
                                                        $weekly_employee         = $data['weekly'][0]['employee'];
                                                        $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                        $wkly                    = round($wkly, 2);
                                                        $weekly_taxliving        = $addamt[1] + $wkly;
                                                    }


                                                }
                                            }
                                        } else {
                                            $minValue = $final;
                                            $maxValue = $final;
                                            $user_id  = $this->session->userdata('user_id');
                                            $emp_tax  = $data['employee_data'][0]['employee_tax'];
                                            $query    = "SELECT `$emp_tax`
                                        FROM `state_localtax`
                                        WHERE `tax` LIKE '%" . $living_tax . "-Income tax%'
                                        AND CAST(SUBSTRING_INDEX(`$emp_tax`, '-', 1) AS UNSIGNED) <= ?
                                        AND CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`$emp_tax`, '-', -1), '-', 1) AS UNSIGNED) >= ?
                                        AND `create_by` = '" . $user_id . "'";
                                            $result = $this->db->query($query, array($maxValue, $minValue));
                                            if ($result) {
                                                $weekly_range = $result->result_array();
                                                if (!empty($weekly_range)) {
                                                    $hourly_range   = $weekly_range[0][$emp_tax];
                                                    $split_values   = explode('-', $hourly_range);
                                                    $firstValue     = $split_values[0];
                                                    $secondValue    = $split_values[1];
                                                    $getvalue       = $minValue - $firstValue;
                                                    $w_tax          = '';
                                                    $st_name        = $data['employee_data'][0]['living_state_tax'];
                                                    $data['weekly'] = $this->Hrm_model->living_hourly_tax_info($data['employee_data'][0]['employee_tax'], $final, $hourly_range, $st_name);
                                                    $st_name        = $data['employee_data'][0]['living_state_tax'];
                                                    $state_names    = $this->Hrm_model->state_names($st_name);
                                                    foreach ($state_names as $name) {
                                                        if (trim($name['state']) == 'Pennsylvania') {
                                                            $weekly_employee_details = $data['weekly'][0]['details'];
                                                            $addamt                  = $weekly_employee_details;
                                                            $weekly_employee         = $data['weekly'][0]['employee'];
                                                            $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                            $wkly                    = round($wkly, 2);
                                                            $weekly_taxliving        = $addamt + $wkly;
                                                        } else if (trim($name['state']) == 'New York') {
                                                            $weekly_employee_details = $data['weekly'][0]['details'];
                                                            $addamt                  = $weekly_employee_details;
                                                            $weekly_employee         = $data['weekly'][0]['employee'];
                                                            $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                            $wkly                    = round($wkly, 2);
                                                            $weekly_taxliving        = $addamt + $wkly;
                                                        } else if (trim($name['state']) == 'Delaware') {
                                                            $weekly_employee_details = $data['weekly'][0]['details'];
                                                            $addamt                  = $weekly_employee_details;
                                                            $weekly_employee         = $data['weekly'][0]['employee'];
                                                            $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                            $wkly                    = round($wkly, 2);
                                                            $weekly_taxliving        = $addamt + $wkly;
                                                        } else if (trim($name['state']) == 'Maryland') {
                                                            $weekly_employee_details = $data['weekly'][0]['details'];
                                                            $addamt                  = $weekly_employee_details;
                                                            $weekly_employee         = $data['weekly'][0]['employee'];
                                                            $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                            $wkly                    = round($wkly, 2);
                                                            $weekly_taxliving        = $addamt + $wkly;
                                                        } else if (trim($name['state']) == 'New Jersey') {
                                                            $weekly_employee_details = $data['weekly'][0]['details'];
                                                            $addamt                  = $weekly_employee_details;
                                                            $weekly_employee         = $data['weekly'][0]['employee'];
                                                            $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                            $weekly_taxliving        = $addamt + $wkly;
                                                        } else if (trim($name['state']) == 'Virginia') {
                                                            $weekly_employee_details = $data['weekly'][0]['details'];
                                                            $addamt                  = explode('$', $weekly_employee_details);
                                                            $weekly_employee         = $data['weekly'][0]['employee'];
                                                            $wkly                    = ($weekly_employee / 100) * $getvalue;
                                                            $wkly                    = round($wkly, 2);
                                                            $weekly_taxliving        = $addamt[1] + $wkly;
                                                        }
 
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else if ($data['employee_data'][0]['payroll_type'] == 'Salaried-BiWeekly') {
                                    $minValue = $final;
                                    $maxValue = $final;
                                    $user_id  = $this->session->userdata('user_id');
                                    $emp_tax  = $data['employee_data'][0]['employee_tax'];
                                    $query    = "SELECT `$emp_tax`
                                FROM `biweekly_tax_info`
                                WHERE `tax` LIKE '%BIWeekly " . $living_tax . "-Income tax%'
                                AND CAST(SUBSTRING_INDEX(`$emp_tax`, '-', 1) AS UNSIGNED) <= ?
                                AND CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`$emp_tax`, '-', -1), '-', 1) AS UNSIGNED) >= ?
                                AND `create_by` = '" . $user_id . "'";
                                    $result = $this->db->query($query, array($maxValue, $minValue));
                                    if ($result) {
                                        $biweekly_range = $result->result_array();
                                        if (!empty($biweekly_range)) {
                                            $biweekly_range    = $biweekly_range[0][$emp_tax];
                                            $split_values      = explode('-', $biweekly_range);
                                            $firstValue        = $split_values[0];
                                            $secondValue       = $split_values[1];
                                            $getvalue          = $minValue - $firstValue;
                                            $bw_tax            = '';
                                            $data['biweekly']  = $this->Hrm_model->biweekly_tax_info($data['employee_data'][0]['employee_tax'], $final, $biweekly_range);
                                            $st_name           = $data['employee_data'][0]['living_state_tax'];
                                            $livingstate_names = $this->Hrm_model->state_names($st_name);
                                            if (!empty($data['biweekly'][0]['employee'])) {
                                                foreach ($livingstate_names as $name) {
                                                    if (trim($name['state']) == 'Pennsylvania') {
                                                        $biweekly_employee_details = $data['biweekly'][0]['details'];
                                                        $addamt1                   = explode('$', $biweekly_employee_details);
                                                        $biweekly_employee         = $data['biweekly'][0]['employee'];
                                                        $biwkly                    = ($biweekly_employee / 100) * $getvalue;
                                                        $biwkly                    = round($biwkly, 2);
                                                        $biweekly_taxliving        = $addamt1[1] + $biwkly;
                                                    } else if (trim($name['state']) == 'New York') {
                                                        $biweekly_employee_details = $data['biweekly'][0]['details'];
                                                        $addamt1                   = explode('$', $biweekly_employee_details);
                                                        $biweekly_employee         = $data['biweekly'][0]['employee'];
                                                        $biwkly                    = ($biweekly_employee / 100) * $getvalue;
                                                        $biwkly                    = round($biwkly, 2);
                                                        $biweekly_taxliving        = $addamt1[1] + $biwkly;
                                                    } else if (trim($name['state']) == 'Delaware') {
                                                        $biweekly_employee_details = $data['biweekly'][0]['details'];
                                                        $addamt1                   = explode('$', $biweekly_employee_details);
                                                        $biweekly_employee         = $data['biweekly'][0]['employee'];
                                                        $biwkly                    = ($biweekly_employee / 100) * $getvalue;
                                                        $biwkly                    = round($biwkly, 2);
                                                        $biweekly_taxliving        = $addamt1[1] + $biwkly;
                                                    } else if (trim($name['state']) == 'Maryland') {
                                                        $biweekly_employee_details = $data['biweekly'][0]['details'];
                                                        $addamt1                   = explode('$', $biweekly_employee_details);
                                                        $biweekly_employee         = $data['biweekly'][0]['employee'];
                                                        $biwkly                    = ($biweekly_employee / 100) * $getvalue;
                                                        $biwkly                    = round($biwkly, 2);
                                                        $biweekly_taxliving        = $addamt1[1] + $biwkly;
                                                    } else if (trim($name['state']) == 'New Jersey') {
                                                        $biweekly_employee_details = $data['biweekly'][0]['details'];
                                                        $addamt1                   = explode('$', $biweekly_employee_details);
                                                        $biweekly_employee         = $data['biweekly'][0]['employee'];
                                                        $biwkly                    = ($biweekly_employee / 100) * $getvalue;
                                                        $biwkly                    = round($biwkly, 2);
                                                        $biweekly_taxliving        = $addamt1[1] + $biwkly;
                                                    } else if (trim($name['state']) == 'Virginia') {
                                                        $biweekly_employee_details = $data['biweekly'][0]['details'];
                                                        $addamt1                   = explode('$', $biweekly_employee_details);
                                                        $biweekly_employee         = $data['biweekly'][0]['employee'];
                                                        $biwkly                    = ($biweekly_employee / 100) * $getvalue;
                                                        $biwkly                    = round($biwkly, 2);
                                                        $biweekly_taxliving        = $addamt1[1] + $biwkly;
                                                    }
                                                }
                                            }
                                        } else {
                                            $minValue = $final;
                                            $maxValue = $final;
                                            $user_id  = $this->session->userdata('user_id');
                                            $emp_tax  = $data['employee_data'][0]['employee_tax'];
                                            $query    = "SELECT `$emp_tax`
                                        FROM `state_localtax`
                                        WHERE `tax` LIKE '%" . $living_tax . "-Income tax%'
                                        AND CAST(SUBSTRING_INDEX(`$emp_tax`, '-', 1) AS UNSIGNED) <= ?
                                        AND CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`$emp_tax`, '-', -1), '-', 1) AS UNSIGNED) >= ?
                                        AND `create_by` = '" . $user_id . "'";
                                            $result = $this->db->query($query, array($maxValue, $minValue));
                                            if ($result) {
                                                $biweekly_range = $result->result_array();
                                                if (!empty($biweekly_range)) {
                                                    $biweekly_range    = $biweekly_range[0][$emp_tax];
                                                    $split_values      = explode('-', $biweekly_range);
                                                    $firstValue        = $split_values[0];
                                                    $secondValue       = $split_values[1];
                                                    $getvalue          = $minValue - $firstValue;
                                                    $w_tax             = '';
                                                    $st_name           = $data['employee_data'][0]['living_state_tax'];
                                                    $data['biweekly']  = $this->Hrm_model->living_hourly_tax_info($data['employee_data'][0]['employee_tax'], $final, $biweekly_range, $st_name);
                                                    $st_name           = $data['employee_data'][0]['living_state_tax'];
                                                    $livingstate_names = $this->Hrm_model->state_names($st_name);
                                                    foreach ($livingstate_names as $name) {
                                                        if (trim($name['state']) == 'Pennsylvania') {
                                                            $biweekly_employee_details = $data['biweekly'][0]['details'];
                                                            $addamt1                   = explode('$', $biweekly_employee_details);
                                                            $biweekly_employee         = $data['biweekly'][0]['employee'];
                                                            $biwkly                    = ($biweekly_employee / 100) * $getvalue;
                                                            $biwkly                    = round($biwkly, 2);
                                                            $biweekly_taxliving        = $addamt1[1] + $biwkly;
                                                        } else if (trim($name['state']) == 'New York') {
                                                            $biweekly_employee_details = $data['biweekly'][0]['details'];
                                                            $addamt1                   = explode('$', $biweekly_employee_details);
                                                            $biweekly_employee         = $data['biweekly'][0]['employee'];
                                                            $biwkly                    = ($biweekly_employee / 100) * $getvalue;
                                                            $biwkly                    = round($biwkly, 2);
                                                            $biweekly_taxliving        = $addamt1[1] + $biwkly;
                                                        } else if (trim($name['state']) == 'Delaware') {
                                                            $biweekly_employee_details = $data['biweekly'][0]['details'];
                                                            $addamt1                   = explode('$', $biweekly_employee_details);
                                                            $biweekly_employee         = $data['biweekly'][0]['employee'];
                                                            $biwkly                    = ($biweekly_employee / 100) * $getvalue;
                                                            $biwkly                    = round($biwkly, 2);
                                                            $biweekly_taxliving        = $addamt1[1] + $biwkly;
                                                        } else if (trim($name['state']) == 'Maryland') {
                                                            $biweekly_employee_details = $data['biweekly'][0]['details'];
                                                            $addamt1                   = $biweekly_employee_details;
                                                            $biweekly_employee         = $data['biweekly'][0]['employee'];
                                                            $biwkly                    = ($biweekly_employee / 100) * $getvalue;
                                                            $biwkly                    = round($biwkly, 2);
                                                            $biweekly_taxliving        = $addamt1 + $biwkly;
                                                        } else if (trim($name['state']) == 'New Jersey') {
                                                            $biweekly_employee_details = $data['biweekly'][0]['details'];
                                                            $addamt1                   = explode('$', $biweekly_employee_details);
                                                            $biweekly_employee         = $data['biweekly'][0]['employee'];
                                                            $biwkly                    = ($biweekly_employee / 100) * $getvalue;
                                                            $biwkly                    = round($biwkly, 2);
                                                            $biweekly_taxliving        = $addamt1[1] + $biwkly;
                                                        } else if (trim($name['state']) == 'Virginia') {
                                                            $biweekly_employee_details = $data['biweekly'][0]['details'];
                                                            $addamt1                   = explode('$', $biweekly_employee_details);
                                                            $biweekly_employee         = $data['biweekly'][0]['employee'];
                                                            $biwkly                    = ($biweekly_employee / 100) * $getvalue;
                                                            $biwkly                    = round($biwkly, 2);
                                                            $biweekly_taxliving        = $addamt1[1] + $biwkly;
                                                        }


                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else if ($data['employee_data'][0]['payroll_type'] == 'Salaried-Monthly') {
                                    $minValue = $final;
                                    $maxValue = $final;
                                    $user_id  = $this->session->userdata('user_id');
                                    $emp_tax  = $data['employee_data'][0]['employee_tax'];
                                    $query    = "SELECT `$emp_tax`
                                FROM `monthly_tax_info`
                                WHERE `tax` LIKE '%Monthly " . $living_tax . "-Income tax%'
                                AND CAST(SUBSTRING_INDEX(`$emp_tax`, '-', 1) AS UNSIGNED) <= ?
                                AND CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`$emp_tax`, '-', -1), '-', 1) AS UNSIGNED) >= ?
                                AND `create_by` = '" . $user_id . "'";
                                    $result = $this->db->query($query, array($maxValue, $minValue));
                                    if ($result) {
                                        $monthly_range = $result->result_array();
                                        if (!empty($monthly_range)) {
                                            $monthly_range     = $monthly_range[0][$emp_tax];
                                            $split_values      = explode('-', $monthly_range);
                                            $firstValue        = $split_values[0];
                                            $secondValue       = $split_values[1];
                                            $getvalue          = $minValue - $firstValue;
                                            $m_tax             = '';
                                            $data['monthly']   = $this->Hrm_model->monthly_tax_info($data['employee_data'][0]['employee_tax'], $final, $monthly_range);
                                            $st_name           = $data['employee_data'][0]['living_state_tax'];
                                            $livingstate_names = $this->Hrm_model->state_names($st_name);
                                            if (!empty($data['monthly'][0]['employee'])) {
                                                foreach ($livingstate_names as $name) {
                                                    if (trim($name['state']) == 'Pennsylvania') {
                                                        $monthy_employee_details = $data['monthly'][0]['details'];
                                                        $addamt1                 = explode('$', $monthy_employee_details);
                                                        $monthly_employee        = $data['monthly'][0]['employee'];
                                                        $month                   = ($monthly_employee / 100) * $getvalue;
                                                        $month                   = round($month, 2);
                                                        $monthly_taxliving       = $addamt1[1] + $month;
                                                    } else if (trim($name['state']) == 'New York') {
                                                        $monthy_employee_details = $data['monthly'][0]['details'];
                                                        $addamt1                 = explode('$', $monthy_employee_details);
                                                        $monthly_employee        = $data['monthly'][0]['employee'];
                                                        $month                   = ($monthly_employee / 100) * $getvalue;
                                                        $month                   = round($month, 2);
                                                        $monthly_taxliving       = $addamt1[1] + $month;
                                                    } else if (trim($name['state']) == 'Delaware') {
                                                        $monthy_employee_details = $data['monthly'][0]['details'];
                                                        $addamt1                 = explode('$', $monthy_employee_details);
                                                        $monthly_employee        = $data['monthly'][0]['employee'];
                                                        $month                   = ($monthly_employee / 100) * $getvalue;
                                                        $month                   = round($month, 2);
                                                        $monthly_taxliving       = $addamt1[1] + $month;
                                                    } else if (trim($name['state']) == 'Maryland') {
                                                        $monthy_employee_details = $data['monthly'][0]['details'];
                                                        $addamt1                 = explode('$', $monthy_employee_details);
                                                        $monthly_employee        = $data['monthly'][0]['employee'];
                                                        $month                   = ($monthly_employee / 100) * $getvalue;
                                                        $month                   = round($month, 2);
                                                        $monthly_taxliving       = $addamt1[1] + $month;
                                                    } else if (trim($name['state']) == 'New Jersey') {
                                                        $monthy_employee_details = $data['monthly'][0]['details'];
                                                        $addamt1                 = explode('$', $monthy_employee_details);
                                                        $monthly_employee        = $data['monthly'][0]['employee'];
                                                        $month                   = ($monthly_employee / 100) * $getvalue;
                                                        $month                   = round($month, 2);
                                                        $monthly_taxliving       = $addamt1[1] + $month;
                                                    } else if (trim($name['state']) == 'Virginia') {
                                                        $monthy_employee_details = $data['monthly'][0]['details'];
                                                        $addamt1                 = explode('$', $monthy_employee_details);
                                                        $monthly_employee        = $data['monthly'][0]['employee'];
                                                        $month                   = ($monthly_employee / 100) * $getvalue;
                                                        $month                   = round($month, 2);
                                                        $monthly_taxliving       = $addamt1[1] + $month;
                                                    }
                                                }
                                            }
                                        } else {
                                            $minValue = $final;
                                            $maxValue = $final;
                                            $user_id  = $this->session->userdata('user_id');
                                            $emp_tax  = $data['employee_data'][0]['employee_tax'];
                                            $query    = "SELECT `$emp_tax`
                                        FROM `state_localtax`
                                        WHERE `tax` LIKE '%" . $living_tax . "-Income tax%'
                                        AND CAST(SUBSTRING_INDEX(`$emp_tax`, '-', 1) AS UNSIGNED) <= ?
                                        AND CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`$emp_tax`, '-', -1), '-', 1) AS UNSIGNED) >= ?
                                        AND `create_by` = '" . $user_id . "'";
                                            $result        = $this->db->query($query, array($maxValue, $minValue));
                                            $monthly_range = $result->result_array();
                                            if (!empty($monthly_range)) {
                                                $monthly_range     = $monthly_range[0][$emp_tax];
                                                $split_values      = explode('-', $monthly_range);
                                                $firstValue        = $split_values[0];
                                                $secondValue       = $split_values[1];
                                                $getvalue          = $minValue - $firstValue;
                                                $m_tax             = '';
                                                $data['monthly']   = $this->Hrm_model->monthly_tax_info($data['employee_data'][0]['employee_tax'], $final, $monthly_range);
                                                $st_name           = $data['employee_data'][0]['living_state_tax'];
                                                $data['monthly']   = $this->Hrm_model->living_hourly_tax_info($data['employee_data'][0]['employee_tax'], $final, $monthly_range, $st_name);
                                                $livingstate_names = $this->Hrm_model->state_names($st_name);
                                                if (!empty($data['monthly'][0]['employee'])) {
                                                    foreach ($livingstate_names as $name) {
                                                        if (trim($name['state']) == 'Pennsylvania') {
                                                            $monthy_employee_details = $data['monthly'][0]['details'];
                                                            $addamt1                 = explode('$', $monthy_employee_details);
                                                            $monthly_employee        = $data['monthly'][0]['employee'];
                                                            $month                   = ($monthly_employee / 100) * $getvalue;
                                                            $month                   = round($month, 2);
                                                            $monthly_taxliving       = $addamt1[1] + $month;
                                                        } else if (trim($name['state']) == 'New York') {
                                                            $monthy_employee_details = $data['monthly'][0]['details'];
                                                            $addamt1                 = $monthy_employee_details;
                                                            $monthly_employee        = $data['monthly'][0]['employee'];
                                                            $month                   = ($monthly_employee / 100) * $getvalue;
                                                            $month                   = round($month, 2);
                                                            $monthly_taxliving       = $addamt1 + $month;
                                                        } else if (trim($name['state']) == 'Delaware') {
                                                            $monthy_employee_details = $data['monthly'][0]['details'];
                                                            $addamt1                 = explode('$', $monthy_employee_details);
                                                            $monthly_employee        = $data['monthly'][0]['employee'];
                                                            $month                   = ($monthly_employee / 100) * $getvalue;
                                                            $month                   = round($month, 2);
                                                            $monthly_taxliving       = $addamt1[1] + $month;
                                                        } else if (trim($name['state']) == 'Maryland') {
                                                            $monthy_employee_details = $data['monthly'][0]['details'];
                                                            $addamt1                 = explode('$', $monthy_employee_details);
                                                            $monthly_employee        = $data['monthly'][0]['employee'];
                                                            $month                   = ($monthly_employee / 100) * $getvalue;
                                                            $month                   = round($month, 2);
                                                            $monthly_taxliving       = $addamt1[1] + $month;
                                                        } else if (trim($name['state']) == 'New Jersey') {
                                                            $monthy_employee_details = $data['monthly'][0]['details'];
                                                            $addamt1                 = explode('$', $monthy_employee_details);
                                                            $monthly_employee        = $data['monthly'][0]['employee'];
                                                            $month                   = ($monthly_employee / 100) * $getvalue;
                                                            $month                   = round($month, 2);
                                                            $monthly_taxliving       = $addamt1[1] + $month;
                                                        } else if (trim($name['state']) == 'Virginia') {
                                                            $monthy_employee_details = $data['monthly'][0]['details'];
                                                            $addamt1                 = explode('$', $monthy_employee_details);
                                                            $monthly_employee        = $data['monthly'][0]['employee'];
                                                            $month                   = ($monthly_employee / 100) * $getvalue;
                                                            $month                   = round($month, 2);
                                                            $monthly_taxliving       = $addamt1[1] + $month;
                                                        }
                                                        }
                                                }
                                            }
                                        }
                                    }
                                }
                                $data8 = array(
                                    's_tax'          => $s,
                                    'm_tax'          => $m,
                                    'u_tax'          => $u,
                                    'f_tax'          => $f,
                                    'code'           => $code,
                                    'sales_c_amount' => $scValueAmount,
                                    'sc'             => $scValue,
                                    'tax_type'       => 'living_state_tax',
                                    'no_of_inv'      => $sc_count,
                                    'tax'            => $tx_n,
                                    'amount'         => $v,
                                    'time_sheet_id'  => $timesheetdata[0]['timesheet_id'],
                                    'employee_id'    => $timesheetdata[0]['templ_name'],
                                    'created_by'     => $this->session->userdata('user_id'),
                                );
                                $this->db->insert('tax_history', $data8);
                                error_log("data in model AFTER INSERT: ");
                                if ($data['employee_data'][0]['payroll_type'] == 'Hourly') {
                                    $amt = $hourlyliving;
                                } else if ($data['employee_data'][0]['payroll_type'] == 'Salaried-weekly') {
                                    $amt = $weekly_taxliving;
                                } else if ($data['employee_data'][0]['payroll_type'] == 'Salaried-BiWeekly') {
                                    $amt = $biweekly_taxliving;
                                } else if ($data['employee_data'][0]['payroll_type'] == 'Salaried-Monthly') {
                                    $amt = $monthly_taxliving;
                                }
                                $data2 = array(
                                    'amount' => $amt,
                                );
                                $this->db->where('time_sheet_id', $timesheetdata[0]['timesheet_id']);
                                $this->db->where('hourly IS NOT NULL');
                                $query = $this->db->get('tax_history');
                                if ($query->num_rows() == 0) {
                                    $this->db->where('time_sheet_id', $timesheetdata[0]['timesheet_id']);
                                    $this->db->order_by('id', 'ASC');
                                    $this->db->limit(1);
                                    $this->db->where('tax_type', 'living_state_tax');
                                    $this->db->update('tax_history', $data2);
                                }
                            } //foreach $living_state_tax end
                            $sql = "DELETE t1
                        FROM tax_history t1
                        INNER JOIN tax_history t2 ON t1.id > t2.id
                        AND t1.tax = t2.tax
                        AND t1.code = t2.code
                        AND t1.amount = t2.amount
                        AND t1.created_by = t2.created_by
                        AND t1.time_sheet_id = t2.time_sheet_id
                        WHERE t1.weekly IS NULL
                        AND t1.monthly IS NULL
                        AND t1.biweekly IS NULL; ";
                            $this->db->query($sql);
                        }
                        if ($living_state_tax_employer) {
                            $payperiod  = $data['timesheet_data'][0]['month'];
                            $data['sc'] = $this->Hrm_model->sc_info_count($this->input->post('templ_name'), $payperiod , $decodedId);
                            if (isset($data['sc']['sc'][0]['sc'])) {
                                $scValue = $data['sc']['sc'][0]['sc'];
                            } else {
                                $scValue = 0;
                            }
                            $sc_totalAmount1 = $data['sc']['total_gtotal'];
                            $sc_count        = $data['sc']['count'];
                            if ($sc_totalAmount1 != 0) {
                                $scValuePercentage = ($scValue / $sc_totalAmount1) * 100;
                                $scValueAmount     = ($scValuePercentage / 100) * $sc_totalAmount1;
                            } else {
                                $scValueAmount = 0;
                            }
                            $scValue       = $scValue / 100;
                            $scValueAmount = $scValue * $sc_totalAmount1;
                            foreach ($living_state_tax_employer as $k => $v) {
                                if (trim(round($v, 3)) > 0) {
                                    $split = explode('-', $k);
                                    $tx_n  = str_replace("'", "", $split[1]);
                                    $code  = '';
                                    if (isset($split[2])) {
                                        $code = $split[2];
                                    } else {
                                        $code = '';
                                    }
                                    $code  = str_replace("'", "", $code);
                                    $data8 = array(
                                        's_tax'         => $ss,
                                        'm_tax'         => $mm,
                                        'u_tax'         => $uu,
                                        'f_tax'         => $ff,
                                        'code'          => $code,
                                        'tax_type'      => 'living_state_tax',
                                        'tax'           => $tx_n,
                                        'amount'        => round($v, 3),
                                        'time_sheet_id' => $timesheetdata[0]['timesheet_id'],
                                        'employee_id'   => $timesheetdata[0]['templ_name'],
                                        'created_by'    => $this->session->userdata('user_id'),
                                        'weekly'        => $weekly_tax,
                                        'biweekly'      => $biweekly_tax,
                                    );
                                    $this->db->insert('tax_history_employer', $data8);
                                    error_log("data in model AFTER INSERT: ");
                                }
                            }
                        }
                        if ($local_tax) {
                            $payperiod  = $data['timesheet_data'][0]['month'];
                            $data['sc'] = $this->Hrm_model->sc_info_count($this->input->post('templ_name'), $payperiod , $decodedId);
                            if (isset($data['sc']['sc'][0]['sc'])) {
                                $scValue = $data['sc']['sc'][0]['sc'];
                            } else {
                                $scValue = 0;
                            }
                            $sc_totalAmount1 = $data['sc']['total_gtotal'];
                            $sc_count        = $data['sc']['count'];
                            if ($sc_totalAmount1 != 0) {
                                $scValuePercentage = ($scValue / $sc_totalAmount1) * 100;
                                $scValueAmount     = ($scValuePercentage / 100) * $sc_totalAmount1;
                            } else {
                                $scValueAmount = 0;
                            }
                            $scValue       = $scValue / 100;
                            $scValueAmount = $scValue * $sc_totalAmount1;
                            foreach ($local_tax as $k => $v) {
                                if (trim(round($v, 3)) > 0) {
                                    $existingRecord = $this->db->select('*')
                                        ->from('tax_history')
                                        ->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                                        ->where('employee_id', $timesheetdata[0]['templ_name'])
                                        ->where('tax', str_replace("'", "", explode('-', $k)[1]))
                                        ->where('tax_type', 'local_tax')
                                        ->get()->row();
                                    $split = explode('-', $k);
                                    
                                    $tx_n = str_replace("'", "", $split[1]);
                                    $code = '';
                                    if (isset($split[2])) {
                                        $code = $split[2];
                                    } else {
                                        $code = '';
                                    }
                                    $code = str_replace("'", "", $code);
                                    if (!$existingRecord) {
                                        $data1 = array(
                                            's_tax'          => $s,
                                            'm_tax'          => $m,
                                            'u_tax'          => $u,
                                            'f_tax'          => $f,
                                            'code'           => $code,
                                            'tax_type'       => 'local_tax',
                                            'sales_c_amount' => $scValueAmount,
                                            'sc'             => $scValue,
                                            'no_of_inv'      => $sc_count,
                                            'tax'            => $tx_n,
                                            'amount'         => round($v, 3),
                                            'time_sheet_id'  => $timesheetdata[0]['timesheet_id'],
                                            'employee_id'    => $timesheetdata[0]['templ_name'],
                                            'created_by'     => $this->session->userdata('user_id'),
                                        );
                                        $this->db->insert('tax_history', $data1);
                                    }
                                }
                            }
                        }
                        if ($local_tax_employerr) {
                            $payperiod  = $data['timesheet_data'][0]['month'];
                            $data['sc'] = $this->Hrm_model->sc_info_count($this->input->post('templ_name'), $payperiod , $decodedId);
                            if (isset($data['sc']['sc'][0]['sc'])) {
                                $scValue = $data['sc']['sc'][0]['sc'];
                            } else {
                                $scValue = 0;
                            }
                            $sc_totalAmount1 = $data['sc']['total_gtotal'];
                            $sc_count        = $data['sc']['count'];
                            if ($sc_totalAmount1 != 0) {
                                $scValuePercentage = ($scValue / $sc_totalAmount1) * 100;
                                $scValueAmount     = ($scValuePercentage / 100) * $sc_totalAmount1;
                            } else {
                                $scValueAmount = 0;
                            }
                            $scValue       = $scValue / 100;
                            $scValueAmount = $scValue * $sc_totalAmount1;
                            foreach ($local_tax_employerr as $k => $v) {
                                if (trim(round($v, 6)) > 0) {
                                    $existingRecord = $this->db->select('*')
                                        ->from('tax_history_employer')
                                        ->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                                        ->where('employee_id', $timesheetdata[0]['templ_name'])
                                        ->where('tax', str_replace("'", "", explode('-', $k)[1]))
                                        ->where('tax_type', 'local_tax')
                                        ->get()->row();
                                    $split = explode('-', $k);
                                  
                                    $tx_n = str_replace("'", "", $split[1]);
                                    $code = '';
                                    if (isset($split[2])) {
                                        $code = $split[2];
                                    } else {
                                        $code = '';
                                    }
                                    $code = str_replace("'", "", $code);
                                    if (!$existingRecord) {
                                        $data1 = array(
                                            's_tax'         => $ss,
                                            'm_tax'         => $mm,
                                            'u_tax'         => $uu,
                                            'f_tax'         => $ff,
                                            'code'          => $code,
                                            'tax_type'      => 'local_tax',
                                            'tax'           => $tx_n,
                                            'amount'        => round($v, 3),
                                            'time_sheet_id' => $timesheetdata[0]['timesheet_id'],
                                            'employee_id'   => $timesheetdata[0]['templ_name'],
                                            'created_by'    => $this->session->userdata('user_id'),
                                            'weekly'        => $weekly_tax,
                                            'biweekly'      => $biweekly_tax,
                                        );
                                        $this->db->insert('tax_history_employer', $data1);
                                    }
                                }
                            }
                        }
                        if ($living_local_tax) {
                            foreach ($living_local_tax as $k => $v) {
                                if (trim(round($v, 3)) > 0) {
                                    $existingRecord = $this->db->select('*')
                                        ->from('tax_history')
                                        ->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                                        ->where('employee_id', $timesheetdata[0]['templ_name'])
                                        ->where('tax', str_replace("'", "", explode('-', $k)[1]))
                                        ->get()->row();
                                    $split = explode('-', $k);
                                    $tx_n  = str_replace("'", "", $split[1]);
                                    $code  = '';
                                    if (isset($split[2])) {
                                        $code = $split[2];
                                    } else {
                                        $code = '';
                                    }
                                    $code  = str_replace("'", "", $code);
                                    $data1 = array(
                                        's_tax'          => $s,
                                        'm_tax'          => $m,
                                        'u_tax'          => $u,
                                        'f_tax'          => $f,
                                        'code'           => $code,
                                        'tax_type'       => 'living_local_tax',
                                        'sales_c_amount' => $scValueAmount,
                                        'sc'             => $scValue,
                                        'no_of_inv'      => $sc_count,
                                        'tax'            => $tx_n,
                                        'amount'         => round($v, 3),
                                        'time_sheet_id'  => $timesheetdata[0]['timesheet_id'],
                                        'employee_id'    => $timesheetdata[0]['templ_name'],
                                        'created_by'     => $this->session->userdata('user_id'),
                                    );
                                    $this->db->insert('tax_history', $data1);
                                }
                            }
                        }
                        if ($living_local_tax_employer) {
                            foreach ($living_local_tax_employer as $k => $v) {
                                if (trim(round($v, 3)) > 0) {
                                    $existingRecord = $this->db->select('*')
                                        ->from('tax_history_employer')
                                        ->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                                        ->where('employee_id', $timesheetdata[0]['templ_name'])
                                        ->where('tax', str_replace("'", "", explode('-', $k)[1]))
                                        ->get()->row();
                                    $split = explode('-', $k);
                                    $tx_n  = str_replace("'", "", $split[1]);
                                    $code  = '';
                                    if (isset($split[2])) {
                                        $code = $split[2];
                                    } else {
                                        $code = '';
                                    }
                                    $code  = str_replace("'", "", $code);
                                    $data1 = array(
                                        's_tax'         => $ss,
                                        'm_tax'         => $mm,
                                        'u_tax'         => $uu,
                                        'f_tax'         => $ff,
                                        'code'          => $code,
                                        'tax_type'      => 'living_local_tax',
                                        'tax'           => $tx_n,
                                        'amount'        => $v,
                                        'time_sheet_id' => $timesheetdata[0]['timesheet_id'],
                                        'employee_id'   => $timesheetdata[0]['templ_name'],
                                        'created_by'    => $this->session->userdata('user_id'),
                                        'weekly'        => $weekly_tax,
                                        'biweekly'      => $biweekly_tax,
                                    );
                                    $this->db->insert('tax_history_employer', $data1);
                                }
                            }
                        }
                        if ($working_county_tax) {
                            foreach ($working_county_tax as $k => $v) {
                                if (trim(round($v, 3)) > 0) {
                                    $existingRecord = $this->db->select('*')
                                        ->from('tax_history')
                                        ->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                                        ->where('employee_id', $timesheetdata[0]['templ_name'])
                                        ->where('tax', str_replace("'", "", explode('-', $k)[1]))
                                        ->get()->row();
                                    $split = explode('-', $k);
                                    $tx_n  = str_replace("'", "", $split[1]);
                                    $code  = '';
                                    if (isset($split[2])) {
                                        $code = $split[2];
                                    } else {
                                        $code = '';
                                    }
                                    $code  = str_replace("'", "", $code);
                                    $data1 = array(
                                        's_tax'          => $s,
                                        'm_tax'          => $m,
                                        'u_tax'          => $u,
                                        'f_tax'          => $f,
                                        'code'           => $code,
                                        'tax_type'       => 'working_county_tax',
                                        'sales_c_amount' => $scValueAmount,
                                        'sc'             => $scValue,
                                        'no_of_inv'      => $sc_count,
                                        'tax'            => $tx_n,
                                        'amount'         => round($v, 3),
                                        'time_sheet_id'  => $timesheetdata[0]['timesheet_id'],
                                        'employee_id'    => $timesheetdata[0]['templ_name'],
                                        'created_by'     => $this->session->userdata('user_id'),
                                    );
                                    $this->db->insert('tax_history', $data1);
                                }
                            }
                        }
                        if ($working_county_tax_employer) {
                            foreach ($working_county_tax_employer as $k => $v) {
                                if (trim(round($v, 3)) > 0) {
                                    $existingRecord = $this->db->select('*')
                                        ->from('tax_history_employer')
                                        ->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                                        ->where('employee_id', $timesheetdata[0]['templ_name'])
                                        ->where('tax', str_replace("'", "", explode('-', $k)[1]))
                                        ->get()->row();
                                    $split = explode('-', $k);
                                    $tx_n  = str_replace("'", "", $split[1]);
                                    $code  = '';
                                    if (isset($split[2])) {
                                        $code = $split[2];
                                    } else {
                                        $code = '';
                                    }
                                    $code  = str_replace("'", "", $code);
                                    $data1 = array(
                                        's_tax'         => $ss,
                                        'm_tax'         => $mm,
                                        'u_tax'         => $uu,
                                        'f_tax'         => $ff,
                                        'code'          => $code,
                                        'tax_type'      => 'working_county_tax',
                                        'tax'           => $tx_n,
                                        'amount'        => round($v, 3),
                                        'time_sheet_id' => $timesheetdata[0]['timesheet_id'],
                                        'employee_id'   => $timesheetdata[0]['templ_name'],
                                        'created_by'    => $this->session->userdata('user_id'),
                                        'weekly'        => $weekly_tax,
                                        'biweekly'      => $biweekly_tax,
                                    );
                                    $this->db->insert('tax_history_employer', $data1);
                                }
                            }
                        }
                        if ($living_county_tax) {
                            foreach ($living_county_tax as $k => $v) {
                                if (trim(round($v, 3)) > 0) {
                                    $existingRecord = $this->db->select('*')
                                        ->from('tax_history')
                                        ->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                                        ->where('employee_id', $timesheetdata[0]['templ_name'])
                                        ->where('tax', str_replace("'", "", explode('-', $k)[1]))
                                        ->get()->row();
                                    $split = explode('-', $k);
                                    $tx_n  = str_replace("'", "", $split[1]);
                                    $code  = '';
                                    if (isset($split[2])) {
                                        $code = $split[2];
                                    } else {
                                        $code = '';
                                    }
                                    $code  = str_replace("'", "", $code);
                                    $data1 = array(
                                        's_tax'          => $s,
                                        'm_tax'          => $m,
                                        'u_tax'          => $u,
                                        'f_tax'          => $f,
                                        'code'           => $code,
                                        'tax_type'       => 'living_county_tax',
                                        'sales_c_amount' => $scValueAmount,
                                        'sc'             => $scValue,
                                        'no_of_inv'      => $sc_count,
                                        'tax'            => $tx_n,
                                        'amount'         => round($v, 3),
                                        'time_sheet_id'  => $timesheetdata[0]['timesheet_id'],
                                        'employee_id'    => $timesheetdata[0]['templ_name'],
                                        'created_by'     => $this->session->userdata('user_id'),
                                    );
                                    $this->db->insert('tax_history', $data1);
                                }
                            }
                        }
                        if ($living_county_tax_employer) {
                            foreach ($living_county_tax_employer as $k => $v) {
                                if (trim(round($v, 3)) > 0) {
                                    $existingRecord = $this->db->select('*')
                                        ->from('tax_history_employer')
                                        ->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                                        ->where('employee_id', $timesheetdata[0]['templ_name'])
                                        ->where('tax', str_replace("'", "", explode('-', $k)[1]))
                                        ->get()->row();
                                    $split = explode('-', $k);
                                    $tx_n  = str_replace("'", "", $split[1]);
                                    $code  = '';
                                    if (isset($split[2])) {
                                        $code = $split[2];
                                    } else {
                                        $code = '';
                                    }
                                    $code  = str_replace("'", "", $code);
                                    $data1 = array(
                                        's_tax'         => $ss,
                                        'm_tax'         => $mm,
                                        'u_tax'         => $uu,
                                        'f_tax'         => $ff,
                                        'code'          => $code,
                                        'tax_type'      => 'living_county_tax',
                                        'tax'           => $tx_n,
                                        'amount'        => round($v, 3),
                                        'time_sheet_id' => $timesheetdata[0]['timesheet_id'],
                                        'employee_id'   => $timesheetdata[0]['templ_name'],
                                        'created_by'    => $this->session->userdata('user_id'),
                                        'weekly'        => $weekly_tax,
                                        'biweekly'      => $biweekly_tax,
                                    );
                                    $this->db->insert('tax_history_employer', $data1);
                                }
                            }
                        }
                        if ($other_tax) {
                            foreach ($other_tax as $k => $v) {
                                if (trim(round($v, 3)) > 0) {
                                    $existingRecord = $this->db->select('*')
                                        ->from('tax_history')
                                        ->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                                        ->where('employee_id', $timesheetdata[0]['templ_name'])
                                        ->where('tax', str_replace("'", "", explode('-', $k)[1]))
                                        ->get()->row();
                                    $split = explode('-', $k);
                                    $tx_n  = str_replace("'", "", $split[1]);
                                    $code  = '';
                                    if (isset($split[2])) {
                                        $code = $split[2];
                                    } else {
                                        $code = '';
                                    }
                                    $code  = str_replace("'", "", $code);
                                    $data1 = array(
                                        's_tax'          => $s,
                                        'm_tax'          => $m,
                                        'u_tax'          => $u,
                                        'f_tax'          => $f,
                                        'code'           => $code,
                                        'tax_type'       => 'other_tax',
                                        'sales_c_amount' => $scValueAmount,
                                        'sc'             => $scValue,
                                        'no_of_inv'      => $sc_count,
                                        'tax'            => $tx_n,
                                        'amount'         => round($v, 3),
                                        'time_sheet_id'  => $timesheetdata[0]['timesheet_id'],
                                        'employee_id'    => $timesheetdata[0]['templ_name'],
                                        'created_by'     => $this->session->userdata('user_id'),
                                    );
                                    $this->db->insert('tax_history', $data1);
                                }
                            }
                        }
                        if ($other_tax_employer) {
                            foreach ($other_tax_employer as $k => $v) {
                                if (trim(round($v, 3)) > 0) {
                                    $existingRecord = $this->db->select('*')
                                        ->from('tax_history_employer')
                                        ->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                                        ->where('employee_id', $timesheetdata[0]['templ_name'])
                                        ->where('tax', str_replace("'", "", explode('-', $k)[1]))
                                        ->get()->row();
                                    $split = explode('-', $k);
                                    $tx_n  = str_replace("'", "", $split[1]);
                                    $code  = '';
                                    if (isset($split[2])) {
                                        $code = $split[2];
                                    } else {
                                        $code = '';
                                    }
                                    $code  = str_replace("'", "", $code);
                                    $data1 = array(
                                        's_tax'         => $ss,
                                        'm_tax'         => $mm,
                                        'u_tax'         => $uu,
                                        'f_tax'         => $ff,
                                        'code'          => $code,
                                        'tax_type'      => 'other_tax',
                                        'tax'           => $tx_n,
                                        'amount'        => round($v, 3),
                                        'time_sheet_id' => $timesheetdata[0]['timesheet_id'],
                                        'employee_id'   => $timesheetdata[0]['templ_name'],
                                        'created_by'    => $this->session->userdata('user_id'),
                                        'weekly'        => $weekly_tax,
                                        'biweekly'      => $biweekly_tax,
                                    );
                                    $this->db->insert('tax_history_employer', $data1);
                                }
                            }
                        }
                        if ($other_working_tax) {
                            foreach ($other_working_tax as $k => $v) {
                                if (trim(round($v, 3)) > 0) {
                                    $existingRecord = $this->db->select('*')
                                        ->from('tax_history')
                                        ->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                                        ->where('employee_id', $timesheetdata[0]['templ_name'])
                                        ->where('tax', str_replace("'", "", explode('-', $k)[1]))
                                        ->get()->row();
                                    $split = explode('-', $k);
                                    $tx_n  = str_replace("'", "", $split[1]);
                                    $code  = '';
                                    if (isset($split[2])) {
                                        $code = $split[2];
                                    } else {
                                        $code = '';
                                    }
                                    $code  = str_replace("'", "", $code);
                                    $data1 = array(
                                        's_tax'          => $s,
                                        'm_tax'          => $m,
                                        'u_tax'          => $u,
                                        'f_tax'          => $f,
                                        'code'           => $code,
                                        'tax_type'       => 'other_working_tax',
                                        'sales_c_amount' => $scValueAmount,
                                        'sc'             => $scValue,
                                        'no_of_inv'      => $sc_count,
                                        'tax'            => $tx_n,
                                        'amount'         => round($v, 3),
                                        'time_sheet_id'  => $timesheetdata[0]['timesheet_id'],
                                        'employee_id'    => $timesheetdata[0]['templ_name'],
                                        'created_by'     => $this->session->userdata('user_id'),
                                    );
                                    $this->db->insert('tax_history', $data1);
                                }
                            }
                        }
                        if ($other_working_tax_employer) {
                            foreach ($other_working_tax_employer as $k => $v) {
                                if (trim(round($v, 3)) > 0) {
                                    $existingRecord = $this->db->select('*')
                                        ->from('tax_history_employer')
                                        ->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                                        ->where('employee_id', $timesheetdata[0]['templ_name'])
                                        ->where('tax', str_replace("'", "", explode('-', $k)[1]))
                                        ->get()->row();
                                    $split = explode('-', $k);
                                    $tx_n  = str_replace("'", "", $split[1]);
                                    $code  = '';
                                    if (isset($split[2])) {
                                        $code = $split[2];
                                    } else {
                                        $code = '';
                                    }
                                    $code  = str_replace("'", "", $code);
                                    $data1 = array(
                                        's_tax'         => $ss,
                                        'm_tax'         => $mm,
                                        'u_tax'         => $uu,
                                        'f_tax'         => $ff,
                                        'code'          => $code,
                                        'tax_type'      => 'other_working_tax',
                                        'tax'           => $tx_n,
                                        'amount'        => round($v, 3),
                                        'time_sheet_id' => $timesheetdata[0]['timesheet_id'],
                                        'employee_id'   => $timesheetdata[0]['templ_name'],
                                        'created_by'    => $this->session->userdata('user_id'),
                                        'weekly'        => $weekly_tax,
                                        'biweekly'      => $biweekly_tax,
                                    );
                                    $this->db->insert('tax_history_employer', $data1);
                                }
                            }
                        }
                        $payperiod         = $data['timesheet_data'][0]['month'];
                        $data['sc']        = $this->Hrm_model->sc_info_count($this->input->post('templ_name'), $payperiod, $decodedId);
                        $scValue           = $data['sc']['sc'][0]['sc'];
                        $sc_totalAmount1   = $data['sc']['total_gtotal'];
                        $sc_count          = $data['sc']['count'];
                        $scValuePercentage = ($scValue / $sc_totalAmount1) * 100;
                        $sc_totalAmount    = ($scValuePercentage / 100) * $sc_totalAmount1;
                        if (is_nan($scValuePercentage)) {
                            $scValuePercentage = 0;
                        }
                        $scValue       = $scValue / 100;
                        $scValueAmount = $scValue * $sc_totalAmount1;
                        $data2         = array(
                            's_tax'          => $s,
                            'm_tax'          => $m,
                            'u_tax'          => $u,
                            'f_tax'          => $f,
                            'sc'             => $scValueAmount,
                            'no_of_inv'      => $countValue,
                            'tax'            => $tx_n,
                            'sales_c_amount' => $scValueAmount,
                            'total_amount'   => $final,
                            'timesheet_id'   => $timesheetdata[0]['timesheet_id'],
                            'total_hours'    => $timesheetdata[0]['total_hours'],
                            'templ_name'     => $timesheetdata[0]['templ_name'],
                            'employee_tax'   => $employeedata[0]['employee_tax'],
                            'hrate'          => $employeedata[0]['hrate'],
                            'id'             => $employeedata[0]['id'],
                            'create_by'      => $this->session->userdata('user_id'),
                        );
                        $result5 = $this->db->insert('info_payslip', $data2);
                        // echo $this->db->last_query(); die();
                    }
                } else {
                    $payperiod                        = $data['timesheet_data'][0]['month'];
                    $get_date                         = explode('-', $payperiod);
                    $d1                               = $get_date[1];
                    $data['sc']                       = $this->Hrm_model->sc_info_count($this->input->post('templ_name'), $payperiod , $decodedId);
                    $scValue                          = $data['sc']['sc'][0]['sc'];
                    $sc_totalAmount1                  = $data['sc']['total_gtotal'];
                    $sc_count                         = $data['sc']['count'];
                    $scValue                          = $scValue / 100;
                    $scValueAmount1                   = $scValue * $sc_totalAmount1;
                    $u_id                             = $this->input->post('unique_id');
                    $data_timesheet['unique_id']      = $u_id;
                    $data_timesheet['payroll_type']   = "Sales Partner";
                    $data_timesheet['uneditable']     = 1;
                    $data_timesheet['extra_thisrate'] = $scValueAmount1;
                    $employee_detail                  = $this->db->where('id', $this->input->post('templ_name'));
                    $q                                = $this->db->get('employee_history');
                    $row                              = $q->row_array();
                    if (!empty($row['id'])) {
                        $data['selected_living_state_tax'] = $row['living_state_tax'];
                        $data['selected_local_tax']        = $row['local_tax'];
                        $data['selected_state_tax']        = $row['state_tx'];
                        $data_timesheet['templ_name']      = $row['id'];
                        $data['templ_name']                = $row['first_name'] . " " . $row['last_name'];
                        $data['job_title']                 = 'Sales Partner';
                    }
                    $purchase_id_1 = $this->db->where('templ_name', $this->input->post('templ_name'))->where('timesheet_id', $data_timesheet['timesheet_id']);
                    $q             = $this->db->get('timesheet_info');
                    $row           = $q->row_array();
                    $old_id        = trim($row['timesheet_id']);
                    if (!empty($old_id)) {
                        $this->session->set_userdata("timesheet_id_old", $row['timesheet_id']);
                        $this->db->where('timesheet_id', $this->session->userdata("timesheet_id_old"));
                        $this->db->delete('timesheet_info');
                        $this->db->where('timesheet_id', $this->session->userdata("timesheet_id_old"));
                        $this->db->delete('timesheet_info_details');
                        //11111
                        $result1 = $this->db->insert('timesheet_info', $data_timesheet);
                    } else {
                        $result2 = $this->db->insert('timesheet_info', $data_timesheet);
                    }
                    $purchase_id_2 = $this->db->select('timesheet_id')->from('timesheet_info')->where('templ_name', $this->input->post('templ_name'))->where('month', $this->input->post('date_range'))->get()->row()->timesheet_id;
                    $this->session->set_userdata("timesheet_id_new", $purchase_id_2);
                    if ($date1) {
                        for ($i = 0, $n = count($date1); $i < $n; $i++) {
                            $date          = $date1[$i];
                            $day           = $day1[$i];
                            $daily_bk      = $daily_bk1[$i];
                            $time_start    = $time_start1[$i];
                            $time_end      = $time_end1[$i];
                            $hours_per_day = $hours_per_day1[$i];
                            $data1         = array(
                                'timesheet_id'  => $this->session->userdata("timesheet_id_new"),
                                'Date'          => $date,
                                'Day'           => $day,
                                'daily_break'   => $daily_bk,
                                'time_start'    => $time_start,
                                'time_end'      => $time_end,
                                'hours_per_day' => $hours_per_day,
                                'created_by'    => $this->session->userdata('user_id'),
                            );
                            $result3 = $this->db->insert('timesheet_info_details', $data1);
                        }
                    } else {
                        $data1 = array(
                            'timesheet_id' => $this->session->userdata("timesheet_id_new"),
                            'created_by'   => $this->session->userdata('user_id'),
                        );
                        $result4 = $this->db->insert('timesheet_info_details', $data1);
                    }
                }
                $response = array('status' => 'success', 'msg' => 'Payslip has been approved successfully');
            }
            $response = array('status' => 'success', 'msg' => 'Payslip has been approved successfully');
        } else {
            $response = array('status' => 'failure', 'msg' => 'Invalid details');
        }
        echo json_encode($response);
    }
 
//last



    public function checkTimesheet() {
        $selectedDate = $this->input->post('selectedDate');
        $employeeId   = $this->input->post('employeeId');
        $this->load->model('Hrm_model');
        $timesheetExists = $this->Hrm_model->checkTimesheetInfo($employeeId, $selectedDate);
        if ($timesheetExists) {
            echo 'Timesheet exists for this date and employee';
        } else {
            echo 'No timesheet found for this date and employee';
        }
    }
//timesheet index -hr
    public function edit_timesheet() {
        $encodedId               = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId               = decodeBase64UrlParameter($encodedId);
        $timesheet_id            = isset($_GET['timesheetid']) ? $_GET['timesheetid'] : null;
        $setting_detail          = $this->Web_settings->retrieve_setting_editdata($decodedId);
        $data['title']           = display('Payment_Administration');
        $data['time_sheet_data'] = $this->Hrm_model->time_sheet_data($timesheet_id, $decodedId);
        $data['setting_detail']  = $setting_detail;
        $data['encodedId']       = $encodedId;
        $data['employee_name']   = $this->Hrm_model->employee_name($data['time_sheet_data'][0]['templ_name'], $decodedId);
        $data['payment_terms']   = $this->Hrm_model->get_payment_terms($decodedId);
        $data['dailybreak']      = $this->Hrm_model->get_dailybreak($decodedId);
        $data['duration']        = $this->Hrm_model->get_duration_data($decodedId);
        $data['administrator']   = $this->Hrm_model->administrator_data($decodedId);
        $content                 = $this->parser->parse('hr/edit_timesheet', $data, true);
        $this->template->full_admin_html_view($content);
    }
//Payslip Datas
    public function time_list() {
        $encodedId                         = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId                         = decodeBase64UrlParameter($encodedId);
  
 
        $timesheet_id                      = isset($_GET['timesheetid']) ? $_GET['timesheetid'] : null;
        $templ_name                        = isset($_GET['name']) ? $_GET['name'] : null;
        $setting_detail                    = $this->Web_settings->retrieve_setting_editdata();
        $company_info                      = $this->Ppurchases->retrieve_company($decodedId);
        $datacontent                       = $this->invoice_content->retrieve_data($decodedId);
        $data['employee_data']             = $this->Hrm_model->employee_info($templ_name, $decodedId);
        $data['timesheet_data']            = $this->Hrm_model->timesheet_info_data($timesheet_id, $decodedId);
        $dataw                             = $this->invoice_design->retrieve_data($decodedId);
        $data['setting_detail']            = $setting_detail;
        $timesheetdata                     = $data['timesheet_data'];
        $employeedata                      = $data['employee_data'];
        $data['selected_living_state_tax'] = $data['employee_data'][0]['living_state_tax'];
        $data['selected_local_tax']        = $data['employee_data'][0]['local_tax'];
        $data['selected_state_tax']        = $data['employee_data'][0]['state_tx'];
        $data['other_tax']                 = $data['employee_data'][0]['state_tax_2'];
        $hrate                             = $data['timesheet_data'][0]['h_rate'];
        $total_hours                       = $data['timesheet_data'][0]['total_hours'];
        $payperiod                         = $data['timesheet_data'][0]['month'];
        $get_date                          = explode('-', $payperiod);
        $d1                                = $get_date[1];
        $data['sc']                        = $this->Hrm_model->sc_info_count($templ_name, $payperiod, $decodedId , $decodedId);
        $scValue                           = $data['sc']['sc'][0]['sc'];
        $sc_totalAmount1                   = $data['sc']['total_gtotal'];
        $sc_count                          = $data['sc']['count'];
        $scValue                           = $scValue / 100;
        if (isset($data['employee_data']) && !empty($data['employee_data'])) {
            if (isset($data['employee_data'][0]['choice'])) {
                if ($data['employee_data'][0]['choice'] == 'No') {
                    $scValueAmount1 = 0;
                } else {
                    $scValueAmount1 = $scValue * $sc_totalAmount1;
                }
            }
        }
        if ($data['timesheet_data'][0]['payroll_type'] == 'Hourly') {
            if ($data['employee_data'][0]['choice'] == 'Yes') {
                $templ_name = $data['employee_data'][0]['id'];
                $payperiod  = $data['timesheet_data'][0]['month'];
                $data['sc'] = $this->Hrm_model->sc_info_count($templ_name, $payperiod, $decodedId);
                if (isset($data['sc']['sc'][0]['sc'])) {
                    $scValue = $data['sc']['sc'][0]['sc'];
                } else {
                    $scValue = 0;
                }
                $sc_totalAmount1 = $data['sc']['total_gtotal'];
                $sc_count        = $data['sc']['count'];
                if ($sc_totalAmount1 != 0) {
                    $scValuePercentage = ($scValue / $sc_totalAmount1) * 100;
                    $scValueAmount     = ($scValuePercentage / 100) * $sc_totalAmount1;
                    $value_sc          = $sc_totalAmount1 * $scValueAmount / 100;
                } else {
                    $scValueAmount = 0;
                }
            }
            if ($total_hours <= 40) {
                $final = ($hrate * $total_hours) + $scValueAmount1;
            } else {
                $final = $data['timesheet_data'][0]['extra_thisrate'] + $data['timesheet_data'][0]['above_extra_sum'] + $value_sc;
            }
        } else if ($data['timesheet_data'][0]['payroll_type'] == 'Salaried-BiWeekly') {
            if ($total_hours <= 14) {
                $final = ($hrate * $total_hours) + $scValueAmount1;
            } else {
                $final = $data['timesheet_data'][0]['extra_thisrate'] + $data['timesheet_data'][0]['above_extra_sum'];
            }
        } else if ($data['timesheet_data'][0]['payroll_type'] == 'Salaried-weekly') {
            if ($total_hours <= 7) {
                $final = ($hrate * $total_hours) + $scValueAmount1;
            } else {
                $final = $data['timesheet_data'][0]['extra_thisrate'] + $data['timesheet_data'][0]['above_extra_sum'];
            }
        } else if ($data['timesheet_data'][0]['payroll_type'] == 'Salaried-Monthly') {
            if ($total_hours <= 30) {
                $final = ($hrate * $total_hours) + $scValueAmount1;
            } else {
                $final = $data['timesheet_data'][0]['extra_thisrate'] + $data['timesheet_data'][0]['above_extra_sum'];
            }
        } else if ($data['timesheet_data'][0]['payroll_type'] == 'Salaried-BiMonthly') {
            if ($total_hours <= 60) {
                $final = ($hrate * $total_hours) + $scValueAmount1;
            } else {
                $final = $data['timesheet_data'][0]['extra_thisrate'] + $data['timesheet_data'][0]['above_extra_sum'];
            }
        } else if ($data['timesheet_data'][0]['payroll_type'] == 'SalesCommission') {
            $final = ($hrate * $total_hours) + $scValueAmount1;
        } else if ($data['timesheet_data'][0]['payroll_type'] == 'Sales Partner') {
            $final = $scValueAmount1;
        }
        $fin         = $final;
        $s           = '';
        $u           = '';
        $m           = '';
        $f           = '';
        $federal_tax = $this->db->select('*')
            ->from('federal_tax')
            ->where('tax', 'Federal Income tax')
            ->where('created_by', $decodedId)
            ->get()->result_array();
        $federal_range = '';
        $f_tax         = '';
        foreach ($federal_tax as $amt) {
            $split = explode('-', $amt[$data['employee_data'][0]['employee_tax']]);
            if ($final >= $split[0] && $final <= $split[1]) {
                $federal_range = $split[0] . "-" . $split[1];
            }
        }
        $query_row_count = $this->db->select('timesheet_info.*, info_payslip.*, SUM(info_payslip.s_tax) as t_s_tax, SUM(info_payslip.m_tax) as t_m_tax, SUM(info_payslip.f_tax) as t_f_tax, SUM(info_payslip.u_tax) as t_u_tax, SUM(info_payslip.total_amount) as t_amount, SUM(timesheet_info.total_hours) as t_hours');
        $this->db->from('timesheet_info');
        $this->db->join('info_payslip', 'timesheet_info.timesheet_id = info_payslip.timesheet_id');
        $this->db->where('info_payslip.templ_name', $data['employee_data'][0]['id']);
        $this->db->where('info_payslip.create_by', $decodedId);
        $this->db->where("STR_TO_DATE(SUBSTRING_INDEX(timesheet_info.month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE(' $d1', '%m/%d/%Y')", NULL, FALSE);
        $query_row_count = $this->db->get();
        $data['federal'] = $this->Hrm_model->federal_tax_info($data['employee_data'][0]['employee_tax'], $final, $federal_range, $decodedId);
        if (!empty($data['federal'])) {
            $Federal_employee = $data['federal'][0]['employee'];
            $f                = ($Federal_employee / 100) * $final;
            $f                = round($f, 3);
            if ($query_row_count->num_rows() > 1) {
                $ar = $this->db->select('f_tax')
                    ->from('info_payslip')
                    ->where("templ_name", $data['employee_data'][0]['id'])
                    ->where('create_by', $decodedId)
                    ->get()->row()->f_tax;
                $f_tax = round(($ar + $f), 3);
            } else {
                $f_tax = round($f, 3);
            }
        }
        $social_tax = $this->db->select('*')->from('federal_tax')
            ->where('tax', 'Social Security')
            ->where('created_by', $decodedId)
            ->get()->result_array();
        $social_range = '';
        $s_tax        = '';
        $split        = explode('-', $social_tax[0][$data['employee_data'][0]['employee_tax']]);
        if ($final >= $split[0] && $final <= $split[1]) {
            $social_range = $split[0] . "-" . $split[1];
        }
        $data['social'] = $this->Hrm_model->social_tax_info($data['employee_data'][0]['employee_tax'], $final, $social_range, $decodedId);
        if (!empty($data['social'][0]['employee'])) {
            $social_employee = $data['social'][0]['employee'];
            $s               = ($social_employee / 100) * $final;
            $s               = round($s, 3);
            if ($query_row_count->num_rows() > 1) {
                $ar = $this->db->select('s_tax')
                    ->from('info_payslip')
                    ->where("templ_name", $data['employee_data'][0]['id'])
                    ->where('create_by', $decodedId)
                    ->get()->row()->s_tax;
                $s_tax = round(($ar + $s), 3);
            } else {
                $s_tax = round($s, 3);
            }
        }
        $Medicare = $this->db->select('*')->from('federal_tax')
            ->where('tax', 'Medicare')
            ->where('created_by', $decodedId)
            ->get()->result_array();
        $Medicare_range = '';
        $m_tax          = '';
        foreach ($Medicare as $social_amt) {
            $split = explode('-', $social_amt[$data['employee_data'][0]['employee_tax']]);
            if ($final >= $split[0] && $final <= $split[1]) {
                $Medicare_range = $split[0] . "-" . $split[1];
            }
        }
        $data['Medicare'] = $this->Hrm_model->Medicare_tax_info($data['employee_data'][0]['employee_tax'], $final, $Medicare_range, $decodedId);
        if (!empty($data['Medicare'])) {
            $Medicare_employee = $data['Medicare'][0]['employee'];
            $m                 = ($Medicare_employee / 100) * $final;
            $m                 = round($m, 3);
            if ($query_row_count->num_rows() > 1) {
                $ar = $this->db->select('m_tax')
                    ->from('info_payslip')
                    ->where("templ_name", $data['employee_data'][0]['id'])
                    ->where('create_by', $decodedId)
                    ->get()->row()->m_tax;
                $m_tax = round(($ar + $m), 3);
            } else {
                $m_tax = round($m, 3);
            }
        }
        $unemployment = $this->db->select('*')->from('federal_tax')
            ->where('tax', 'Federal unemployment')
            ->where('created_by', $decodedId)
            ->get()->result_array();
        $unemployment_range = '';
        $u_tax              = '';
        foreach ($unemployment as $social_amt) {
            $split = explode('-', $social_amt[$data['employee_data'][0]['employee_tax']]);
            if ($final >= $split[0] && $final <= $split[1]) {
                $unemployment_range = $split[0] . "-" . $split[1];
            }
        }
        $data['unemployment'] = $this->Hrm_model->unemployment_tax_info($data['employee_data'][0]['employee_tax'], $final, $unemployment_range, $decodedId);
        if (!empty($data['unemployment'])) {
            $unemployment_employee = $data['unemployment'][0]['employee'];
            $u                     = ($unemployment_employee / 100) * $final;
            $u                     = round($u, 3);
            if ($query_row_count->num_rows() > 1) {
                $ar = $this->db->select('u_tax')->from('info_payslip')
                    ->where("templ_name", $data['employee_data'][0]['id'])
                    ->where('create_by', $decodedId)
                    ->get()->row()->u_tax;
                $u_tax = round(($ar + $u), 3);
            } else {
                $u_tax = round($u, 3);
            }
        }
        $state              = '';
        $local_sum          = array();
        $local_tax          = '';
        $local_tax          = array();
        $selected_local_sum = array();
        $selected_local_tax = '';
        $selected_local_tax = array();
        $selected_state_sum = array();
        $selected_state_tax = '';
        $selected_state_tax = array();
        $other_tax          = '';
        $other_tax          = array();
        $other_tax_sum      = array();
        $get_date           = explode('-', $payperiod);
        $d1                 = $get_date[1];
        if (($data['selected_living_state_tax'] != '') && ($data['selected_living_state_tax'] !== 'Not Applicable')) {
            $state_tax = $this->db->select('*')
                ->from('state_and_tax')
                ->where('state', $data['selected_living_state_tax'])
                ->where('created_by', $decodedId)
                ->get()->result_array();
            $state = $this->db->select('*')->from('state_and_tax')
                ->where('state', $state_tax[0]['state'])
                ->where('created_by', $decodedId)
                ->get()->result_array();
            $tax_split       = explode(',', $state[0]['tax']);
            $local_tax_range = '';
            foreach ($tax_split as $tax) {
                $tax = $this->db->select('*')
                    ->from('state_localtax')
                    ->where('tax', $state_tax[0]['state'] . "-" . $tax)
                    ->where('create_by', $decodedId)
                    ->get()->result_array();
                foreach ($tax as $tx) {
                    $split = explode('-', $tx[$data['employee_data'][0]['employee_tax']]);
                    if ($split[0] != '' && $split[1] != '') {
                        if ($final >= $split[0] && $final <= $split[1]) {
                            $local_tax_range  = $split[0] . "-" . $split[1];
                            $data['localtax'] = $this->Hrm_model->local_state_tax($data['employee_data'][0]['employee_tax'], $final, $local_tax_range);
                            if (!empty($data['localtax'])) {
                                $i = 0;
                                foreach ($data['localtax'] as $lt) {
                                    $local_tax_employee = $lt['employee'];
                                    $local_tax_employer = $lt['employer'];
                                    $local_tax_ee       = ($local_tax_employee / 100) * $final;
                                    $local_tax_er       = ($local_tax_employer / 100) * $final;
                                    $row                = $this->db->select('*')->from('state_localtax')
                                        ->where('employee', $local_tax_employee)
                                        ->where('tax', $tx['tax'])
                                        ->where($data['employee_data'][0]['employee_tax'], $local_tax_range)
                                        ->where('create_by', $decodedId)->count_all_results();
                                    $data_employee = "'employee_" . $tx['tax'] . "'";
                                    $search_tax    = explode('-', $tx['tax']);
                                    if ($row == 1) {
                                        $ar = $this->db->select('amount')
                                            ->from('tax_history')
                                            ->where('tax_type', 'living_state_tax')
                                            ->where('tax', $search_tax[1])
                                            ->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                                            ->where('created_by', $decodedId)
                                            ->get()->row()->amount;
                                        if ($ar) {
                                            $t_tx = $ar;
                                        } else {
                                            $t_tx = 0;
                                        }
                                        $query = $this->db->select("*")
                                            ->from("tax_history")
                                            ->where("employee_id", $data['employee_data'][0]['id'])
                                            ->where("tax", $search_tax[1])
                                            ->join('timesheet_info', 'tax_history.time_sheet_id = timesheet_info.timesheet_id')
                                            ->where("STR_TO_DATE(SUBSTRING_INDEX(timesheet_info.month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE('$d1', '%m/%d/%Y')", NULL, FALSE)
                                            ->where('created_by', $decodedId)
                                            ->get();
                                        if ($query->num_rows() >= 1) {
                                            $query = $this->db->select_sum("amount")
                                                ->from("tax_history")
                                                ->where("tax_type", "living_state_tax")
                                                ->where("employee_id", $data['employee_data'][0]['id'])
                                                ->where("tax", $search_tax[1])
                                                ->join('timesheet_info', 'tax_history.time_sheet_id = timesheet_info.timesheet_id')
                                                ->where("STR_TO_DATE(SUBSTRING_INDEX(timesheet_info.month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE('$d1', '%m/%d/%Y')", NULL, FALSE)
                                                ->where('created_by', $decodedId)
                                                ->get()->row()->amount;
                                            $amt                       = $query;
                                            $local_sum[$search_tax[1]] = $amt;
                                        } else {
                                            $local_sum[$search_tax[1]] = $local_tax_ee;
                                        }
                                        $local_tax[$data_employee] = $t_tx;
                                    }
                                    $i++;
                                }
                            }
                        }
                    }
                }
            }
        }
        if (!empty($data['selected_local_tax']) && ($data['selected_local_tax'] !== 'Not Applicable')) {
            $state_tax = $this->db->select('*')
                ->from('state_and_tax')
                ->where('state', $data['selected_local_tax'])
                ->where('created_by', $decodedId)
                ->get()->result_array();
            $state = $this->db->select('*')
                ->from('state_and_tax')
                ->where('state', $state_tax[0]['state'])
                ->where('created_by', $decodedId)
                ->get()->result_array();
            $tax_split       = explode(',', $state[0]['tax']);
            $local_tax_range = '';
            foreach ($tax_split as $tax) {
                $tax = $this->db->select('*')
                    ->from('state_localtax')
                    ->where('tax', $state_tax[0]['state'] . "-" . $tax)
                    ->where('create_by', $decodedId)
                    ->get()->result_array();
                foreach ($tax as $tx) {
                    $split = explode('-', $tx[$data['employee_data'][0]['employee_tax']]);
                    if ($split[0] != '' && $split[1] != '') {
                        if ($final >= $split[0] && $final <= $split[1]) {
                            $local_tax_range  = $split[0] . "-" . $split[1];
                            $data['localtax'] = $this->Hrm_model->local_state_tax($data['employee_data'][0]['employee_tax'], $final, $local_tax_range);
                            if (!empty($data['localtax'])) {
                                $i = 0;
                                foreach ($data['localtax'] as $lt) {
                                    $local_tax_employee = $lt['employee'];
                                    $local_tax_employer = $lt['employer'];
                                    $local_tax_ee       = ($local_tax_employee / 100) * $final;
                                    $local_tax_er       = ($local_tax_employer / 100) * $final;
                                    $row                = $this->db
                                        ->select('*')
                                        ->from('state_localtax')
                                        ->where('employee', $local_tax_employee)->where('tax', $tx['tax'])
                                        ->where($data['employee_data'][0]['employee_tax'], $local_tax_range)
                                        ->where('create_by', $decodedId)
                                        ->count_all_results();
                                    $data_employee = "'employee_" . $tx['tax'] . "'";
                                    $search_tax    = explode('-', $tx['tax']);
                                    if ($row == 1) {
                                        $ar = $this->db->select('amount')
                                            ->from('tax_history')
                                            ->where('tax_type', 'local_tax')
                                            ->where('tax', $search_tax[1])
                                            ->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                                            ->where('created_by', $decodedId)
                                            ->get()->row()->amount;
                                        $t_tx = '';
                                        if ($ar) {
                                            $t_tx = $ar;
                                        } else {
                                            $t_tx = 0;
                                        }
                                    }
                                    $query = $this->db->select("*")
                                        ->from("tax_history")
                                        ->where("employee_id", $data['employee_data'][0]['id'])
                                        ->where("tax", $search_tax[1])
                                        ->join('timesheet_info', 'tax_history.time_sheet_id = timesheet_info.timesheet_id')
                                        ->where("STR_TO_DATE(SUBSTRING_INDEX(timesheet_info.month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE('$d1', '%m/%d/%Y')", NULL, FALSE)
                                        ->where('created_by', $decodedId)
                                        ->get();
                                    if ($query->num_rows() >= 1) {
                                        $query = $this->db->select_sum("amount")
                                            ->from("tax_history")
                                            ->where("employee_id", $data['employee_data'][0]['id'])
                                            ->where("tax", $search_tax[1])
                                            ->where("tax_type", "local_tax")
                                            ->join('timesheet_info', 'tax_history.time_sheet_id = timesheet_info.timesheet_id')
                                            ->where("STR_TO_DATE(SUBSTRING_INDEX(timesheet_info.month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE('$d1', '%m/%d/%Y')", NULL, FALSE)
                                            ->where('created_by', $decodedId)
                                            ->get()->row()->amount;
                                        $amt                                = $query;
                                        $selected_local_sum[$search_tax[1]] = $amt;
                                    } else {
                                        $selected_local_sum[$search_tax[1]] = $local_tax_ee;
                                    }
                                    $selected_local_tax[$data_employee] = $t_tx;
                                    $i++;
                                }
                            }
                        }
                    }
                }
            }
        }
        if (!empty($data['selected_state_tax']) && ($data['selected_state_tax'] !== 'Not Applicable')) {
            $state_tax = $this->db->select('*')
                ->from('state_and_tax')
                ->where('state', $data['selected_state_tax'])
                ->where('created_by', $decodedId)
                ->get()->result_array();
            $state = $this->db->select('*')
                ->from('state_and_tax')
                ->where('state', $state_tax[0]['state'])
                ->where('created_by', $decodedId)
                ->get()->result_array();
            $tax_split          = explode(',', $state[0]['tax']);
            $filtered_tax_split = array_filter($tax_split, function ($tax) {
                return trim($tax) !== 'Income tax - 0J';
            });
            $local_tax_range = '';
            foreach ($filtered_tax_split as $tax) {
                $tax = $this->db->select('*')
                    ->from('state_localtax')
                    ->where('tax', $state_tax[0]['state'] . "-" . $tax)
                    ->where('create_by', $decodedId)
                    ->get()->result_array();
                foreach ($tax as $tx) {
                    $split = explode('-', $tx[$data['employee_data'][0]['employee_tax']]);
                    if ($split[0] != '' && $split[1] != '') {
                        if ($final >= $split[0] && $final <= $split[1]) {
                            $local_tax_range  = $split[0] . "-" . $split[1];
                            $data['localtax'] = $this->Hrm_model->local_state_tax($data['employee_data'][0]['employee_tax'], $final, $local_tax_range);
                            if (!empty($data['localtax'])) {
                                $i = 0;
                                foreach ($data['localtax'] as $lt) {
                                    $local_tax_employee = $lt['employee'];
                                    $local_tax_employer = $lt['employer'];
                                    $local_tax_ee       = ($local_tax_employee / 100) * $final;
                                    $local_tax_er       = ($local_tax_employer / 100) * $final;
                                    $row                = $this->db->select('*')
                                        ->from('state_localtax')
                                        ->where('employee', $local_tax_employee)
                                        ->where('tax', $tx['tax'])
                                        ->where($data['employee_data'][0]['employee_tax'], $local_tax_range)
                                        ->where('create_by', $decodedId)
                                        ->count_all_results();
                                    $data_employee = "'employee_" . $tx['tax'] . "'";
                                    $search_tax    = explode('-', $tx['tax']);
                                    if ($row == 1) {
                                        $ar = $this->db->select('amount')
                                            ->from('tax_history')
                                            ->where('tax_type', 'state_tax')
                                            ->where('tax', $search_tax[1])
                                            ->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                                            ->where('created_by', $decodedId)
                                            ->get()->row()->amount;
                                        if ($ar) {
                                            $t_tx = $ar;
                                        } else {
                                            $t_tx = 0;
                                        }
                                        $query = $this->db->select("*")
                                            ->from("tax_history")
                                            ->where("employee_id", $data['employee_data'][0]['id'])
                                            ->where("tax", $search_tax[1])
                                            ->join('timesheet_info', 'tax_history.time_sheet_id = timesheet_info.timesheet_id')
                                            ->where("STR_TO_DATE(SUBSTRING_INDEX(timesheet_info.month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE('$d1', '%m/%d/%Y')", NULL, FALSE)
                                            ->where('created_by', $decodedId)
                                            ->get();
                                        if ($query->num_rows() >= 1) {
                                            $query = $this->db->select_sum("amount")
                                                ->from("tax_history")
                                                ->where("employee_id", $data['employee_data'][0]['id'])
                                                ->where("tax", $search_tax[1])
                                                ->where("tax_type", "state_tax")
                                                ->join('timesheet_info', 'tax_history.time_sheet_id = timesheet_info.timesheet_id')
                                                ->where("STR_TO_DATE(SUBSTRING_INDEX(timesheet_info.month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE('$d1', '%m/%d/%Y')", NULL, FALSE)
                                                ->where('created_by', $decodedId)
                                                ->get()->row()->amount;
                                            $amt                                = $query;
                                            $selected_state_sum[$search_tax[1]] = $amt;
                                        } else {
                                            $selected_state_sum[$search_tax[1]] = $local_tax_ee;
                                        }
                                        $selected_state_tax[$data_employee] = $t_tx;
                                    }
                                    $i++;
                                }
                            }
                        }
                    }
                }
            }
        }
        if (!empty($data['other_tax']) && ($data['other_tax'] !== 'Not Applicable')) {
            $state_tax = $this->db->select('*')->from('state_and_tax')->where('state', $data['other_tax'])->where('created_by', $this->session->userdata('user_id'))->get()->result_array();
            $state     = $this->db->select('*')
                ->from('state_and_tax')
                ->where('state', $state_tax[0]['state'])
                ->where('created_by', $decodedId)
                ->get()->result_array();
            $tax_split       = explode(',', $state[0]['tax']);
            $local_tax_range = '';
            foreach ($tax_split as $tax) {
                $tax = $this->db->select('*')
                    ->from('state_localtax')
                    ->where('tax', $state_tax[0]['state'] . "-" . $tax)
                    ->where('create_by', $decodedId)
                    ->get()->result_array();
                foreach ($tax as $tx) {
                    $split = explode('-', $tx[$data['employee_data'][0]['employee_tax']]);
                    if ($split[0] != '' && $split[1] != '') {
                        if ($final >= $split[0] && $final <= $split[1]) {
                            $local_tax_range  = $split[0] . "-" . $split[1];
                            $data['localtax'] = $this->Hrm_model->local_state_tax($data['employee_data'][0]['employee_tax'], $final, $local_tax_range);
                            if (!empty($data['localtax'])) {
                                $i = 0;
                                foreach ($data['localtax'] as $lt) {
                                    $local_tax_employee = $lt['employee'];
                                    $local_tax_employer = $lt['employer'];
                                    $local_tax_ee       = ($local_tax_employee / 100) * $final;
                                    $local_tax_er       = ($local_tax_employer / 100) * $final;
                                    $row                = $this->db->select('*')
                                        ->from('state_localtax')
                                        ->where('employee', $local_tax_employee)
                                        ->where('tax', $tx['tax'])
                                        ->where($data['employee_data'][0]['employee_tax'], $local_tax_range)
                                        ->where('create_by', $decodedId)
                                        ->count_all_results();
                                    $data_employee = "'employee_" . $tx['tax'] . "'";
                                    $search_tax    = explode('-', $tx['tax']);
                                    $t_tx          = '';
                                    if ($row == 1) {
                                        $ar = $this->db->select('amount')
                                            ->from('tax_history')
                                            ->where('tax_type', 'other_tax')
                                            ->where('tax', $search_tax[1])
                                            ->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                                            ->where('created_by', $decodedId)
                                            ->get()->row()->amount;
                                        if ($ar) {
                                            $t_tx = $ar;
                                        } else {
                                            $t_tx = 0;
                                        }
                                        $query = $this->db->select("*")
                                            ->from("tax_history")
                                            ->where("employee_id", $data['employee_data'][0]['id'])
                                            ->where("tax", $search_tax[1])
                                            ->join('timesheet_info', 'tax_history.time_sheet_id = timesheet_info.timesheet_id')
                                            ->where("STR_TO_DATE(SUBSTRING_INDEX(timesheet_info.month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE('$d1', '%m/%d/%Y')", NULL, FALSE)
                                            ->where('created_by', $decodedId)
                                            ->get();
                                        if ($query->num_rows() >= 1) {
                                            $query = $this->db->select_sum("amount")
                                                ->from("tax_history")
                                                ->where("employee_id", $data['employee_data'][0]['id'])
                                                ->where("tax", $search_tax[1])
                                                ->where("tax_type", "other_tax")
                                                ->join('timesheet_info', 'tax_history.time_sheet_id = timesheet_info.timesheet_id')
                                                ->where("STR_TO_DATE(SUBSTRING_INDEX(timesheet_info.month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE('$d1', '%m/%d/%Y')", NULL, FALSE)
                                                ->where('created_by', $decodedId)
                                                ->get()->row()->amount;
                                            $amt                           = $query;
                                            $other_tax_sum[$search_tax[1]] = $amt;
                                        } else {
                                            $other_tax_sum[$search_tax[1]] = $local_tax_ee;
                                        }
                                        $other_tax[$data_employee] = $t_tx;
                                    }
                                    $i++;
                                }
                            }
                        }
                    }
                }
            }
        }
        $other_working_tax = array();
        $other_working_sum = array();
        if (!empty($data['employee_data'][0]['state_tax_1']) && ($data['employee_data'][0]['state_tax_1'] !== 'Not Applicable')) {
            $state_tax = $this->db->select('*')
                ->from('state_and_tax')
                ->where('state', $data['employee_data'][0]['state_tax_1'])
                ->where('created_by', $decodedId)
                ->get()->result_array();
            $state = $this->db->select('*')
                ->from('state_and_tax')
                ->where('state', $state_tax[0]['state'])
                ->where('created_by', $decodedId)
                ->get()->result_array();
            $tax_split       = explode(',', $state[0]['tax']);
            $local_tax_range = '';
            foreach ($tax_split as $tax) {
                $tax = $this->db->select('*')
                    ->from('state_localtax')
                    ->where('tax', $state_tax[0]['state'] . "-" . $tax)
                    ->where('create_by', $decodedId)
                    ->get()->result_array();
                foreach ($tax as $tx) {
                    $split = explode('-', $tx[$data['employee_data'][0]['employee_tax']]);
                    if ($split[0] != '' && $split[1] != '') {
                        if ($final >= $split[0] && $final <= $split[1]) {
                            $local_tax_range  = $split[0] . "-" . $split[1];
                            $data['localtax'] = $this->Hrm_model->local_state_tax($data['employee_data'][0]['employee_tax'], $final, $local_tax_range);
                            if (!empty($data['localtax'])) {
                                $i = 0;
                                foreach ($data['localtax'] as $lt) {
                                    $local_tax_employee = $lt['employee'];
                                    $local_tax_employer = $lt['employer'];
                                    $local_tax_ee       = ($local_tax_employee / 100) * $final;
                                    $local_tax_er       = ($local_tax_employer / 100) * $final;
                                    $row                = $this->db->select('*')
                                        ->from('state_localtax')
                                        ->where('employee', $local_tax_employee)
                                        ->where('tax', $tx['tax'])->where($data['employee_data'][0]['employee_tax'], $local_tax_range)
                                        ->where('create_by', $decodedId)
                                        ->count_all_results();
                                    $data_employee = "'employee_" . $tx['tax'] . "'";
                                    $search_tax    = explode('-', $tx['tax']);
                                    $t_tx          = '';
                                    if ($row == 1) {
                                        $ar = $this->db->select('amount')
                                            ->from('tax_history')
                                            ->where('tax_type', 'other_working_tax')
                                            ->where('tax', $search_tax[1])
                                            ->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                                            ->where('created_by', $decodedId)
                                            ->get()->row()->amount;
                                        if ($ar) {
                                            $t_tx = $ar;
                                        } else {
                                            $t_tx = 0;
                                        }
                                        $query = $this->db->select("*")
                                            ->from("tax_history")
                                            ->where("employee_id", $data['employee_data'][0]['id'])
                                            ->where("tax", $search_tax[1])
                                            ->join('timesheet_info', 'tax_history.time_sheet_id = timesheet_info.timesheet_id')
                                            ->where("STR_TO_DATE(SUBSTRING_INDEX(timesheet_info.month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE('$d1', '%m/%d/%Y')", NULL, FALSE)
                                            ->where('created_by', $decodedId)
                                            ->get();
                                        if ($query->num_rows() >= 1) {
                                            $query = $this->db->select_sum("amount")
                                                ->from("tax_history")
                                                ->where("employee_id", $data['employee_data'][0]['id'])
                                                ->where("tax", $search_tax[1])
                                                ->where("tax_type", "other_working_tax")
                                                ->join('timesheet_info', 'tax_history.time_sheet_id = timesheet_info.timesheet_id')
                                                ->where("STR_TO_DATE(SUBSTRING_INDEX(timesheet_info.month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE('$d1', '%m/%d/%Y')", NULL, FALSE)
                                                ->where('created_by', $decodedId)
                                                ->get()->row()->amount;
                                            $amt                               = $query;
                                            $other_working_sum[$search_tax[1]] = $amt;
                                        } else {
                                            $other_working_sum[$search_tax[1]] = $local_tax_ee;
                                        }
                                        $other_working_tax[$data_employee] = $t_tx;
                                    }
                                    $i++;
                                }
                            }
                        }
                    }
                }
            }
        }
        $living_county_tax_range = '';
        $living_county_tax       = '';
        $living_county_tax       = array();
        $living_county_sum       = array();
        if (!empty($data['employee_data'][0]['living_county_tax']) && ($data['employee_data'][0]['living_county_tax'] !== 'Not Applicable')) {
            $state_tax = $this->db->select('*')
                ->from('state_and_tax')
                ->where('state', $data['employee_data'][0]['living_county_tax'])
                ->where('created_by', $decodedId)
                ->get()->result_array();
            $state = $this->db->select('*')
                ->from('state_and_tax')
                ->where('state', $state_tax[0]['state'])
                ->where('created_by', $decodedId)
                ->get()->result_array();
            $tax_split       = explode(',', $state[0]['tax']);
            $local_tax_range = '';
            foreach ($tax_split as $tax) {
                $tax = $this->db->select('*')
                    ->from('state_localtax')
                    ->where('tax', $state_tax[0]['state'] . "-" . $tax)
                    ->where('create_by', $decodedId)
                    ->get()->result_array();
                foreach ($tax as $tx) {
                    $split = explode('-', $tx[$data['employee_data'][0]['employee_tax']]);
                    if ($split[0] != '' && $split[1] != '') {
                        if ($final >= $split[0] && $final <= $split[1]) {
                            $local_tax_range  = $split[0] . "-" . $split[1];
                            $data['localtax'] = $this->Hrm_model->local_state_tax($data['employee_data'][0]['employee_tax'], $final, $local_tax_range);
                            if (!empty($data['localtax'])) {
                                $i = 0;
                                foreach ($data['localtax'] as $lt) {
                                    $local_tax_employee = $lt['employee'];
                                    $local_tax_employer = $lt['employer'];
                                    $local_tax_ee       = ($local_tax_employee / 100) * $final;
                                    $local_tax_er       = ($local_tax_employer / 100) * $final;
                                    $row                = $this->db->select('*')
                                        ->from('state_localtax')
                                        ->where('employee', $local_tax_employee)
                                        ->where('tax', $tx['tax'])
                                        ->where($data['employee_data'][0]['employee_tax'], $local_tax_range)
                                        ->where('create_by', $decodedId)
                                        ->count_all_results();
                                    $data_employee = "'employee_" . $tx['tax'] . "'";
                                    $search_tax    = explode('-', $tx['tax']);
                                    $t_tx          = '';
                                    if ($row == 1) {
                                        $ar = $this->db->select('amount')
                                            ->from('tax_history')
                                            ->where('tax_type', 'living_county_tax')
                                            ->where('tax', $search_tax[1])
                                            ->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                                            ->where('created_by', $decodedId)
                                            ->get()->row()->amount;
                                        if ($ar) {
                                            $t_tx = $ar;
                                        } else {
                                            $t_tx = 0;
                                        }
                                        $query = $this->db->select("*")
                                            ->from("tax_history")
                                            ->where("employee_id", $data['employee_data'][0]['id'])
                                            ->where("tax", $search_tax[1])
                                            ->join('timesheet_info', 'tax_history.time_sheet_id = timesheet_info.timesheet_id')
                                            ->where("STR_TO_DATE(SUBSTRING_INDEX(timesheet_info.month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE('$d1', '%m/%d/%Y')", NULL, FALSE)
                                            ->where('created_by', $decodedId)
                                            ->get();
                                        if ($query->num_rows() >= 1) {
                                            $query = $this->db->select_sum("amount")
                                                ->from("tax_history")
                                                ->where("employee_id", $data['employee_data'][0]['id'])
                                                ->where("tax", $search_tax[1])
                                                ->where("tax_type", "living_county_tax")
                                                ->join('timesheet_info', 'tax_history.time_sheet_id = timesheet_info.timesheet_id')
                                                ->where("STR_TO_DATE(SUBSTRING_INDEX(timesheet_info.month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE('$d1', '%m/%d/%Y')", NULL, FALSE)
                                                ->where('created_by', $decodedId)
                                                ->get()->row()->amount;
                                            $amt                               = $query;
                                            $living_county_sum[$search_tax[1]] = $amt;
                                        } else {
                                            $living_county_sum[$search_tax[1]] = $local_tax_ee;
                                        }
                                        $living_county_tax[$data_employee] = $t_tx;
                                    }
                                    $i++;
                                }
                            }
                        }
                    }
                }
            }
        }
        $working_county_tax_range = '';
        $working_county_tax       = '';
        $working_county_tax       = array();
        $working_county_sum       = array();
        if (!empty($data['employee_data'][0]['cty_tax']) && ($data['employee_data'][0]['cty_tax'] !== 'Not Applicable')) {
            $state_tax = $this->db->select('*')
                ->from('state_and_tax')
                ->where('state', $data['employee_data'][0]['cty_tax'])
                ->where('created_by', $decodedId)
                ->get()->result_array();
            $state = $this->db->select('*')
                ->from('state_and_tax')
                ->where('state', $state_tax[0]['state'])
                ->where('created_by', $decodedId)
                ->get()->result_array();
            $tax_split       = explode(',', $state[0]['tax']);
            $local_tax_range = '';
            foreach ($tax_split as $tax) {
                $tax = $this->db->select('*')
                    ->from('state_localtax')
                    ->where('tax', $state_tax[0]['state'] . "-" . $tax)
                    ->where('create_by', $decodedId)
                    ->get()->result_array();
                foreach ($tax as $tx) {
                    $split = explode('-', $tx[$data['employee_data'][0]['employee_tax']]);
                    if ($split[0] != '' && $split[1] != '') {
                        if ($final >= $split[0] && $final <= $split[1]) {
                            $local_tax_range  = $split[0] . "-" . $split[1];
                            $data['localtax'] = $this->Hrm_model->local_state_tax($data['employee_data'][0]['employee_tax'], $final, $local_tax_range);
                            if (!empty($data['localtax'])) {
                                $i = 0;
                                foreach ($data['localtax'] as $lt) {
                                    $local_tax_employee = $lt['employee'];
                                    $local_tax_employer = $lt['employer'];
                                    $local_tax_ee       = ($local_tax_employee / 100) * $final;
                                    $local_tax_er       = ($local_tax_employer / 100) * $final;
                                    $row                = $this->db->select('*')
                                        ->from('state_localtax')
                                        ->where('employee', $local_tax_employee)
                                        ->where('tax', $tx['tax'])
                                        ->where($data['employee_data'][0]['employee_tax'], $local_tax_range)
                                        ->where('create_by', $decodedId)
                                        ->count_all_results();
                                    $data_employee = "'employee_" . $tx['tax'] . "'";
                                    $search_tax    = explode('-', $tx['tax']);
                                    $t_tx          = '';
                                    if ($row == 1) {
                                        $ar = $this->db->select('amount')
                                            ->from('tax_history')
                                            ->where('tax_type', 'working_county_tax')
                                            ->where('tax', $search_tax[1])->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                                            ->where('created_by', $decodedId)
                                            ->get()->row()->amount;
                                        if ($ar) {
                                            $t_tx = $ar;
                                        } else {
                                            $t_tx = 0;
                                        }
                                        $query = $this->db->select("*")
                                            ->from("tax_history")
                                            ->where("employee_id", $data['employee_data'][0]['id'])
                                            ->where("tax", $search_tax[1])
                                            ->join('timesheet_info', 'tax_history.time_sheet_id = timesheet_info.timesheet_id')
                                            ->where("STR_TO_DATE(SUBSTRING_INDEX(timesheet_info.month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE('$d1', '%m/%d/%Y')", NULL, FALSE)
                                            ->where('created_by', $decodedId)
                                            ->get();
                                        if ($query->num_rows() >= 1) {
                                            $query = $this->db->select_sum("amount")
                                                ->from("tax_history")
                                                ->where("employee_id", $data['employee_data'][0]['id'])
                                                ->where("tax", $search_tax[1])
                                                ->where("tax_type", "working_county_tax")
                                                ->join('timesheet_info', 'tax_history.time_sheet_id = timesheet_info.timesheet_id')
                                                ->where("STR_TO_DATE(SUBSTRING_INDEX(timesheet_info.month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE('$d1', '%m/%d/%Y')", NULL, FALSE)
                                                ->where('created_by', $decodedId)
                                                ->get()->row()->amount;
                                            $amt                                = $query;
                                            $working_county_sum[$search_tax[1]] = $amt;
                                        } else {
                                            $working_county_sum[$search_tax[1]] = $local_tax_ee;
                                        }
                                        $working_county_tax[$data_employee] = $t_tx;
                                    }
                                    $i++;
                                }
                            }
                        }
                    }
                }
            }
        }
        $living_local_tax_range = '';
        $living_local_tax       = '';
        $living_local_tax       = array();
        $living_local_sum       = array();
        if (!empty($data['employee_data'][0]['living_local_tax']) && ($data['employee_data'][0]['living_local_tax'] !== 'Not Applicable')) {
            $state_tax = $this->db->select('*')
                ->from('state_and_tax')
                ->where('state', $data['employee_data'][0]['living_local_tax'])
                ->where('created_by', $decodedId)
                ->get()->result_array();
            $state = $this->db->select('*')
                ->from('state_and_tax')
                ->where('state', $state_tax[0]['state'])
                ->where('created_by', $decodedId)
                ->get()->result_array();
            $tax_split       = explode(',', $state[0]['tax']);
            $local_tax_range = '';
            foreach ($tax_split as $tax) {
                $tax = $this->db->select('*')
                    ->from('state_localtax')
                    ->where('tax', $state_tax[0]['state'] . "-" . $tax)
                    ->where('create_by', $decodedId)
                    ->get()->result_array();
                foreach ($tax as $tx) {
                    $split = explode('-', $tx[$data['employee_data'][0]['employee_tax']]);
                    if ($split[0] != '' && $split[1] != '') {
                        if ($final >= $split[0] && $final <= $split[1]) {
                            $local_tax_range  = $split[0] . "-" . $split[1];
                            $data['localtax'] = $this->Hrm_model->local_state_tax($data['employee_data'][0]['employee_tax'], $final, $local_tax_range);
                            if (!empty($data['localtax'])) {
                                $i = 0;
                                foreach ($data['localtax'] as $lt) {
                                    $local_tax_employee = $lt['employee'];
                                    $local_tax_employer = $lt['employer'];
                                    $local_tax_ee       = ($local_tax_employee / 100) * $final;
                                    $local_tax_er       = ($local_tax_employer / 100) * $final;
                                    $row                = $this->db->select('*')
                                        ->from('state_localtax')
                                        ->where('employee', $local_tax_employee)
                                        ->where('tax', $tx['tax'])
                                        ->where($data['employee_data'][0]['employee_tax'], $local_tax_range)
                                        ->where('create_by', $decodedId)
                                        ->count_all_results();
                                    $data_employee = "'employee_" . $tx['tax'] . "'";
                                    $search_tax    = explode('-', $tx['tax']);
                                    $t_tx          = '';
                                    if ($row == 1) {
                                        $ar = $this->db->select('amount')
                                            ->from('tax_history')
                                            ->where('tax_type', 'living_local_tax')
                                            ->where('tax', $search_tax[1])
                                            ->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                                            ->where('created_by', $decodedId)
                                            ->get()->row()->amount;
                                        if ($ar) {
                                            $t_tx = $ar;
                                        } else {
                                            $t_tx = 0;
                                        }
                                        $query = $this->db->select("*")
                                            ->from("tax_history")
                                            ->where("employee_id", $data['employee_data'][0]['id'])
                                            ->where("tax", $search_tax[1])
                                            ->join('timesheet_info', 'tax_history.time_sheet_id = timesheet_info.timesheet_id')
                                            ->where("STR_TO_DATE(SUBSTRING_INDEX(timesheet_info.month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE('$d1', '%m/%d/%Y')", NULL, FALSE)
                                            ->where('created_by', $decodedId)
                                            ->get();
                                        if ($query->num_rows() >= 1) {
                                            $query = $this->db->select_sum("amount")
                                                ->from("tax_history")
                                                ->where("employee_id", $data['employee_data'][0]['id'])
                                                ->where("tax", $search_tax[1])
                                                ->where("tax_type", "living_local_tax")
                                                ->join('timesheet_info', 'tax_history.time_sheet_id = timesheet_info.timesheet_id')
                                                ->where("STR_TO_DATE(SUBSTRING_INDEX(timesheet_info.month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE('$d1', '%m/%d/%Y')", NULL, FALSE)
                                                ->where('created_by', $decodedId)
                                                ->get()->row()->amount;
                                            $amt                              = $query;
                                            $living_local_sum[$search_tax[1]] = $amt;
                                        } else {
                                            $living_local_sum[$search_tax[1]] = $local_tax_ee;
                                        }
                                        $living_local_tax[$data_employee] = $t_tx;
                                    }
                                    $i++;
                                }
                            }
                        }
                    }
                }
            }
        }
        $ads_id         = $data['timesheet_data'][0]['admin_name'];
        $adminis_data   = $this->Hrm_model->administrator_info($ads_id, $decodedId);
        $payslip_design = $this->db->select('*')
            ->from('payslip_invoice_design')
            ->where('user_id', $decodedId)
            ->get()->result_array();
        $currency_details    = $this->Web_settings->retrieve_setting_editdata();
        $name                = $data['employee_data'][0]['first_name'] . ' ' . $data['employee_data'][0]['last_name'];
        $get_officeloan_data = $this->db->select('*')
            ->from('person_ledger')
            ->where('create_by', $decodedId)
            ->where('person_id', $name)
            ->where('status', 0)
            ->get()->result_array();
        $payrolltaxinfo = $this->db->select('weekly')
            ->from('tax_history')
            ->where('created_by', $decodedId)
            ->where('time_sheet_id', $data['timesheet_data'][0]['timesheet_id'])
            ->where('weekly IS NOT NULL')
            ->get()
            ->result_array();
        $payrolltaxinfo1 = $this->db->select('biweekly')
            ->from('tax_history')
            ->where('created_by', $decodedId)
            ->where('time_sheet_id', $data['timesheet_data'][0]['timesheet_id'])
            ->where('biweekly IS NOT NULL')
            ->get()
            ->result_array();
        $payrolltaxinfo2 = $this->db->select('monthly')
            ->from('tax_history')
            ->where('created_by', $decodedId)
            ->where('time_sheet_id', $data['timesheet_data'][0]['timesheet_id'])
            ->where('monthly IS NOT NULL')
            ->get()
            ->result_array();
        $ytdtotals = $this->db->select(['SUM(biweekly) AS OVbiweekly', 'SUM(weekly) AS OVweekly', 'SUM(monthly) AS OVmonthly', 'SUM(amount) AS OVhourly'])
            ->from('tax_history')
            ->where('created_by', $this->session->userdata('user_id'))
            ->where("employee_id", $data['employee_data'][0]['id'])
            ->where('tax_type', 'state_tax')
            ->where('tax', 'Income tax')
            ->join('timesheet_info', 'tax_history.time_sheet_id = timesheet_info.timesheet_id')
            ->where("STR_TO_DATE(SUBSTRING_INDEX(timesheet_info.month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE('$d1', '%m/%d/%Y')", NULL, FALSE)
            ->where('created_by', $decodedId)
            ->get()
            ->result_array();
        $extrahours = $this->db->select('*')
            ->from('working_time')
            ->where('created_by', $decodedId)
            ->get()
            ->result_array();
        $incometax = $this->db->select('amount')
            ->from('tax_history')
            ->where('created_by', $decodedId)
            ->where('time_sheet_id', $data['timesheet_data'][0]['timesheet_id'])
            ->where('tax_type', 'state_tax')
            ->where('tax', 'Income tax')
            ->get()
            ->result_array();
        $overtime_info = $this->db->select('*')
            ->from('timesheet_info')
            ->where('create_by', $decodedId)
            ->where('timesheet_id', $data['timesheet_data'][0]['timesheet_id'])
            ->get()
            ->result_array();
        $timesheet_id    = $data['timesheet_data'][0]['timesheet_id'];
        $payperiod       = $data['timesheet_data'][0]['month'];
        $data['sc']      = $this->Hrm_model->sc_info_count($templ_name, $payperiod, $decodedId);
        $scValue         = $data['sc']['sc'][0]['sc'];
        $sc_totalAmount1 = $data['sc']['total_gtotal'];
        $sc_count        = $data['sc']['count'];
        $scValue         = $scValue / 100;
        $scValueAmount1  = $scValue * $sc_totalAmount1;
        $merged_tax      = array_merge($local_tax, $selected_local_tax, $selected_state_tax, $other_tax);
        $merged_sum      = array_merge($local_sum, $selected_local_sum, $selected_state_sum, $other_tax_sum);
        $data            = array(
            'sc'                        => $scValueAmount1,
            'no_of_inv'                 => $sc[0]['no_of_inv'],
            'sales_c_amount'            => $sc[0]['sales_c_amount'],
            'currency'                  => $currency_details[0]['currency'],
            'color'                     => $dataw[0]['color'],
            'selected_local_tax'        => $selected_local_tax,
            'selected_state_tax'        => $selected_state_tax,
            'working_county_tax'        => $working_county_tax,
            'other_working_tax'         => $other_working_tax,
            'living_local_tax'          => $living_local_tax,
            'living_county_tax'         => $living_county_tax,
            'selected_living_state_tax' => $local_tax,
            'other_tax'                 => $other_tax,
            'selected_living_state_sum' => $local_sum,
            'other_working_sum'         => $other_working_sum,
            'selected_local_sum'        => $selected_local_sum,
            'selected_state_sum'        => $selected_state_sum,
            'working_county_sum'        => $working_county_sum,
            'living_local_sum'          => $living_local_sum,
            'living_county_sum'         => $living_county_sum,
            'other_tax_sum'             => $other_tax_sum,
            's_tax'                     => $s_tax,
            'm_tax'                     => $m_tax,
            'u_tax'                     => $u_tax,
            'f_tax'                     => $f_tax,
            's'                         => $s,
            'f'                         => $f,
            'u'                         => $u,
            'm'                         => $m,
            'sum'                       => $merged_sum,
            'designation'               => $timesheetdata[0]['job_title'],
            'company'                   => $datacontent,
            'template'                  => $payslip_design[0]['template'],
            'business_name'             => (!empty($datacontent[0]['company_name']) ? $datacontent[0]['company_name'] : $company_info[0]['company_name']),
            'phone'                     => (!empty($datacontent[0]['mobile']) ? $datacontent[0]['mobile'] : $company_info[0]['mobile']),
            'email'                     => (!empty($datacontent[0]['email']) ? $datacontent[0]['email'] : $company_info[0]['email']),
            'address'                   => (!empty($datacontent[0]['address']) ? $datacontent[0]['address'] : $company_info[0]['address']),
            'logo'                      => base_url() . $company_info[0]['logo'],
            'infotime'                  => $timesheetdata,
            'infoemployee'              => $employeedata,
            'total'                     => $final,
            'adm_name'                  => $adminis_data,
            'adminis_data'              => $adminis_data,
            'totalpayments'             => $get_officeloan_data[0]['noofpayterms'],
            'count_paid'                => $get_officeloan_data[0]['payterms'],
            't_amount'                  => $get_officeloan_data[0]['debit'],
            'o_s_a'                     => $get_officeloan_data[0]['out_standing'],
            'o_s_l'                     => $get_officeloan_data[0]['o_s_l'],
            'hourly'                    => $incometax[0]['amount'],
            'weekly'                    => $payrolltaxinfo[0]['weekly'],
            'biweekly'                  => $payrolltaxinfo1[0]['biweekly'],
            'monthly'                   => $payrolltaxinfo2[0]['monthly'],
            'OVhourly'                  => $ytdtotals[0]['OVhourly'],
            'OVweekly'                  => $ytdtotals[0]['OVweekly'],
            'OVbiweekly'                => $ytdtotals[0]['OVbiweekly'],
            'OVmonthly'                 => $ytdtotals[0]['OVmonthly'],
            'data_work_hour'            => $extrahours[0]['work_hour'],
            'extra_workamount'          => $extrahours[0]['extra_workamount'],
            'hrate'                     => $hrate,
            'extra_hour'                => $overtime_info[0]['extra_hour'],
            'extra_rate'                => $overtime_info[0]['extra_rate'],
            'extra_thisrate'            => $overtime_info[0]['extra_thisrate'],
            'extra_this_hour'           => $overtime_info[0]['extra_this_hour'],
            'extra_ytd'                 => $overtime_info[0]['extra_ytd'],
            'above_extra_beforehours'   => $overtime_info[0]['above_extra_beforehours'],
            'above_extra_rate'          => $overtime_info[0]['above_extra_rate'],
            'above_extra_sum'           => $overtime_info[0]['above_extra_sum'],
            'above_this_hours'          => $overtime_info[0]['above_this_hours'],
            'above_extra_ytd'           => $overtime_info[0]['above_extra_ytd'],
        );
        $empid   = $employeedata[0]['id'];
        $user_id = $this->session->userdata('user_id');
        $this->db->select('*');
        $this->db->from('timesheet_info');
        $this->db->join('info_payslip', 'timesheet_info.timesheet_id = info_payslip.timesheet_id');
        $this->db->where('info_payslip.templ_name', $empid);
        $this->db->where('info_payslip.create_by', $decodedId);
        $this->db->where('timesheet_info.month <=', date('Y-m-d'));
        $this->db->where("STR_TO_DATE(SUBSTRING_INDEX(timesheet_info.month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE('$d1', '%m/%d/%Y')", NULL, FALSE);
        $query           = $this->db->get();
        $info_datapay    = $this->Hrm_model->get_data_pay($d1, $empid, $timesheetdata[0]['timesheet_id'], $decodedId);
        $sc_info_datapay = $this->Hrm_model->sc_get_data_pay($d1, $empid, $timesheetdata[0]['timesheet_id'], $decodedId);
        if ($query->num_rows() >= 1) {
            $info_datapay               = $this->Hrm_model->get_data_pay($d1, $empid, $timesheetdata[0]['timesheet_id'], $decodedId);
            $data['overalltotalhours']  = $info_datapay[0]['t_hours'];
            $data['extra_eth']          = $info_datapay[0]['eth'];
            $data['extra_ytdeth']       = $info_datapay[0]['ytdeth'];
            $data['above_eth']          = $info_datapay[0]['above_eth'];
            $data['ytdeth']             = $info_datapay[0]['ytdeth'];
            $data['above_ytdeth']       = $info_datapay[0]['above_ytdeth'] + $info_datapay[0]['sc'];
            $data['sum_above']          = $info_datapay[0]['ytdeth'] + $info_datapay[0]['above_ytdeth'];
            $data['aboveytd']           = $info_datapay[0]['extra_thisrate'] + $info_datapay[0]['above_extra_sum'];
            $data['overalltotalamount'] = $info_datapay[0]['t_amount'] + $info_datapay[0]['sc'];
            $data['t_s_tax']            = $info_datapay[0]['t_s_tax'];
            $data['t_m_tax']            = $info_datapay[0]['t_m_tax'];
            $data['t_f_tax']            = $info_datapay[0]['t_f_tax'];
            $data['t_u_tax']            = $info_datapay[0]['t_u_tax'];
        } else {
            $data['overalltotalhours']  = $timesheetdata[0]['total_hours'];
            $data['extra_eth']          = $info_datapay[0]['eth'];
            $data['extra_ytdeth']       = $info_datapay[0]['ytdeth'];
            $data['above_eth']          = $info_datapay[0]['above_eth'];
            $data['above_ytdeth']       = $info_datapay[0]['above_ytdeth'] + $info_datapay[0]['sc'];
            $data['aboveytd']           = $info_datapay[0]['extra_thisrate'];
            $data['overalltotalamount'] = $sc_info_datapay[0]['S_sales_c_amount'];
            $data['t_s_tax']            = $sc_info_datapay[0]['s_s_tax'];
            $data['t_m_tax']            = $sc_info_datapay[0]['s_m_tax'];
            $data['t_f_tax']            = $sc_info_datapay[0]['s_f_tax'];
            $data['t_u_tax']            = $sc_info_datapay[0]['s_u_tax'];
        }
        $t_data = $this->Hrm_model->timesheet_info_data($timesheet_id, $decodedId);
        if ($t_data[0]['payroll_type'] == 'Sales Partner') {
            $data['partner_total'] = $t_data[0]['extra_thisrate'];
            $this->db->select('*');
            $this->db->from('timesheet_info');
            $this->db->where('timesheet_info.month <=', date('Y-m-d'));
            $this->db->where("STR_TO_DATE(SUBSTRING_INDEX(timesheet_info.month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE('$d1', '%m/%d/%Y')", NULL, FALSE);
            $this->db->where('payroll_type', 'Sales Partner');
            $this->db->where('templ_name', $templ_name);
            $this->db->where('create_by', $decodedId);
            $query = $this->db->get();
            if ($query->num_rows() >= 1) {
                $partner         = $this->Hrm_model->get_data_pay_partner($d1, $empid, $timesheetdata[0]['timesheet_id'], $decodedId);
                $data['partner'] = $partner[0]['amount'];
                $data['jt']      = $partner[0]['job_title'];
            }
        }
        if ($t_data[0]['payroll_type'] == 'SalesCommission') {
            $data['partner_total'] = $t_data[0]['extra_thisrate'];
            $this->db->select('*');
            $this->db->from('timesheet_info');
            $this->db->where('timesheet_info.month <=', date('Y-m-d'));
            $this->db->where("STR_TO_DATE(SUBSTRING_INDEX(timesheet_info.month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE('$d1', '%m/%d/%Y')", NULL, FALSE);
            $this->db->where('payroll_type', 'SalesCommission');
            $this->db->where('templ_name', $templ_name);
            $this->db->where('create_by', $decodedId);
            $query = $this->db->get();
            if ($query->num_rows() >= 1) {
                $payperiod       = $data['timesheet_data'][0]['month'];
                $get_date        = explode('-', $payperiod);
                $d1              = $get_date[1];
                $partner         = $this->Hrm_model->get_data_pay_SalesCommission($d1, $empid, $timesheetdata[0]['timesheet_id'], $decodedId);
                $data['comm']    = $partner[0]['amount'];
                $data['jt_comm'] = $partner[0]['job_title'];
            }
        }
        if ($payslip_design[0]['template'] == 3) {
            $content = $this->parser->parse('hr/pay_slip2', $data, true);
            $this->template->full_admin_html_view($content);
        } else {
            $content = $this->parser->parse('hr/pay_slip', $data, true);
            $this->template->full_admin_html_view($content);
        }
    }







    public function check_employee_pay_type() {
        $CI = &get_instance();
        $CI->load->model('Hrm_model');
        $employeeId = $this->input->post('employeeId');
        $pay_type   = $CI->db->select('payroll_type')->from('employee_history')->where('id', $employeeId)->get()->row()->payroll_type;
        if (empty($pay_type)) {
            $pay_type = 'Sales Partner';
        } else {
            echo $pay_type;
        }
    }
    public function updatepayslipinvoicedesign($id) {
        $query = 'update payslip_invoice_design set template=' . $id;
        $this->db->query($query);
        redirect('Chrm/payslip_setting');
    }
    public function add_taxname_data() {
        $this->load->model('Hrm_model');
        $postData = $this->input->post('value');
        $data     = $this->Hrm_model->insert_taxesname($postData);
    }
    public function payslip_setting() {
        $data['title'] = display('payslip');
        $CI            =  & get_instance();
        $CD            =  & get_instance();
        $CI->load->model('invoice_design');
        $CD->load->model('Companies');
        $CI->load->model('Web_settings');
        $CI->load->model('invoice_content');
        $setting_detail = $CI->Web_settings->retrieve_setting_editdata();
        $dataw          = $CI->invoice_design->get_data_payslip();
        $datac          = $CD->Companies->company_details();
        $datacontent    = $CI->invoice_content->retrieve_data();
        $data           = array(
            'header'       => (!empty($dataw[0]['header']) ? $dataw[0]['header'] : ''),
            'logo'         => (!empty($dataw[0]['logo']) ? $dataw[0]['logo'] : ''),
            'color'        => (!empty($dataw[0]['color']) ? $dataw[0]['color'] : ''),
            'invoice_logo' => (!empty($setting_detail[0]['invoice_logo']) ? $setting_detail[0]['invoice_logo'] : ''),
            'address'      => (!empty($datacontent[0]['address']) ? $datacontent[0]['address'] : ''),
            'cname'        => (!empty($datacontent[0]['business_name']) ? $datacontent[0]['business_name'] : ''),
            'mobile'       => (!empty($datacontent[0]['phone']) ? $datacontent[0]['phone'] : ''),
            'email'        => (!empty($datacontent[0]['email']) ? $datacontent[0]['email'] : ''),
            'template'     => (!empty($dataw[0]['template']) ? $dataw[0]['template'] : ''),
        );
        $content = $this->parser->parse('hr/payslip_view', $data, true);
        $this->template->full_admin_html_view($content);
    }
//timesheet emp details - hr
    public function employee_payslip_permission() {
        $timesheet_id            = isset($_GET['timesheetid']) ? $_GET['timesheetid'] : null;
        $encodedId               = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId               = decodeBase64UrlParameter($encodedId);
        $data['title']           = display('Payment_Administration');
        $data['time_sheet_data'] = $this->Hrm_model->time_sheet_data($timesheet_id, $decodedId);
        $data['employee_name']   = $this->Hrm_model->employee_name($data['time_sheet_data'][0]['templ_name'], $decodedId);
        $data['employee']        = $this->Hrm_model->employee_partner($timesheet_id, $decodedId);
        $data['dailybreak']      = $this->Hrm_model->get_dailybreak($decodedId);
        $data['duration']        = $this->Hrm_model->get_duration_data($decodedId);
        $data['payment_terms']   = $this->Hrm_model->get_payment_terms($decodedId);
        $data['administrator']   = $this->Hrm_model->administrator_data($decodedId);
        $data['extratime_info']  = $this->Hrm_model->get_overtime_data($decodedId);
        $data['encodedId']       = $encodedId;
        $data['designation']     = $this->Hrm_model->info_data_getdesignation($data['employee_name'][0]['id'], $decodedId);
        $setting_detail          = $this->Web_settings->retrieve_setting_editdata($decodedId);
        $data['setting_detail']  = $setting_detail;
        $content                 = $this->parser->parse('hr/emp_payslip_permission', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function officeloan_edit($transaction_id) {
        $this->load->model('Hrm_model');
        $CI =  & get_instance();
        $CI->load->model('Web_settings');
        $CI->load->model('Invoices');
        $CI->load->model('Settings');
        $office_loan_datas = $this->Hrm_model->office_loan_datas($transaction_id);
        $setting_detail    = $CI->Web_settings->retrieve_setting_editdata();
        $bank_name         = $CI->db->select('bank_id,bank_name')
            ->from('bank_add')
            ->get()
            ->result_array();
        $data['bank_list'] = $CI->Web_settings->bank_list();
        $paytype           = $CI->Invoices->payment_type();
        $CI                =  & get_instance();
        $CI->load->model('Web_settings');
        $selected_bank_name  = $this->db->select('bank_name')->from('bank_add')->where('bank_id', $office_loan_datas[0]['bank_name'])->get()->row()->bank_name;
        $data['payment_typ'] = $paytype;
        $data['bank_name']   = $bank_name;
        $person_listdaa      = $CI->Settings->office_loan_person();
        $data                = array(
            'id'                 => $office_loan_datas[0]['id'],
            'person_id'          => $office_loan_datas[0]['person_id'],
            'date'               => $office_loan_datas[0]['date'],
            'debit'              => $office_loan_datas[0]['debit'],
            'details'            => $office_loan_datas[0]['details'],
            'phone'              => $office_loan_datas[0]['phone'],
            'paytype'            => $office_loan_datas[0]['paytype'],
            'bank_name1'         => $office_loan_datas[0]['bank_name'],
            'selected_bank_name' => $selected_bank_name,
            'transaction_id'     => $office_loan_datas[0]['transaction_id'],
            'person_list'        => $person_listdaa,
            'status'             => $office_loan_datas[0]['status'],
            'description'        => $office_loan_datas[0]['description'],
            'bank_name'          => $bank_name,
            'payment_typ'        => $paytype,
            'tran_id'            => $transaction_id,
            'setting_detail'     => $setting_detail,
        );
        $content = $this->parser->parse('hr/edit_officeloan', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function delete_expense($id = null) {
        $this->db->where('id', $id);
        $this->db->delete('expense');
        redirect('Chrm/expense_list');
        $this->template->full_admin_html_view($content);
    }
    public function edit_expense($id) {
        $this->load->library('lsettings');
        $content = $this->lsettings->expense_show_by_id($id);
        $this->template->full_admin_html_view($content);
    }
    public function expense_download($id) {
        $CI =  & get_instance();
        $CC =  & get_instance();
        $CA =  & get_instance();
        $CI->load->model('Web_settings');
        $CI->load->model('Hrm_model');
        $CA->load->model('invoice_design');
        $CC->load->model('invoice_content');
        $CI->load->model('invoice_content');
        $w =  & get_instance();
        $w->load->model('Ppurchases');
        $company_info      = $w->Ppurchases->retrieve_company();
        $expense_pdf       = $CI->Hrm_model->pdf_expense($id);
        $setting           = $CI->Web_settings->retrieve_setting_editdata();
        $dataw             = $CA->invoice_design->retrieve_data();
        $datacontent       = $CI->invoice_content->retrieve_info_data();
        $currency_details  = $CI->Web_settings->retrieve_setting_editdata();
        $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon', $currency_details[0]['currency'])->get()->result_array();
        $data              = array(
            'curn_info_default' => $curn_info_default[0]['currency_name'],
            'currency'          => $currency_details[0]['currency'],
            'header'            => $dataw[0]['header'],
            'logo'              => (!empty($setting[0]['invoice_logo']) ? $setting[0]['invoice_logo'] : $company_info[0]['logo']),
            'color'             => $dataw[0]['color'],
            'template'          => $dataw[0]['template'],
            'company'           => $datacontent,
            'expense_pdf'       => $expense_pdf,
            'company'           => (!empty($datacontent[0]['company_name']) ? $datacontent[0]['company_name'] : $company_info[0]['company_name']),
            'phone'             => (!empty($datacontent[0]['mobile']) ? $datacontent[0]['mobile'] : $company_info[0]['mobile']),
            'email'             => (!empty($datacontent[0]['email']) ? $datacontent[0]['email'] : $company_info[0]['email']),
            'website'           => (!empty($datacontent[0]['website']) ? $datacontent[0]['website'] : $company_info[0]['website']),
            'address'           => (!empty($datacontent[0]['address']) ? $datacontent[0]['address'] : $company_info[0]['address']),
        );
        $content = $this->load->view('hr/expense_html_pdf', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function update_expense($id) {
        $this->load->library('lsettings');
        $content = $this->lsettings->update_expense_id($id);
        $this->template->full_admin_html_view($content);
        redirect('Chrm/expense_list');
    }
    public function create_expense() {
        $this->form_validation->set_rules('expense_name', display('expense_name'), 'required|max_length[100]');
        $this->form_validation->set_rules('expense_date', display('expense_date'), 'required|max_length[100]');
        $this->form_validation->set_rules('expense_payment_date', display('expense_payment_date'), 'required|max_length[100]');
        $postData = [
            'emp_name'             => $this->input->post('person_id', true),
            'expense_name'         => $this->input->post('expense_name', true),
            'expense_date'         => $this->input->post('expense_date', true),
            'expense_amount'       => $this->input->post('expense_amount', true),
            'total_amount'         => $this->input->post('total_amount', true),
            'expense_payment_date' => $this->input->post('expense_payment_date', true),
            'description'          => $this->input->post('description', true),
            'unique_id'            => $this->session->userdata('unique_id'),
            'create_by'            => $this->session->userdata('user_id'),
        ];
        $this->db->insert('expense', $postData);
        redirect(base_url('Chrm/expense_list'));
    }
    public function office_loan_inserthtml($transaction_id) {
        $CC =  & get_instance();
        $CA =  & get_instance();
        $CI =  & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('invoice_content');
        $w =  & get_instance();
        $w->load->model('Ppurchases');
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $CA->load->model('invoice_design');
        $CC->load->model('invoice_content');
        $this->load->model('Hrm_model');
        $company_info      = $w->Ppurchases->retrieve_company();
        $office_loan_datas = $this->Hrm_model->office_loan_datas($transaction_id);
        $datacontent       = $CC->invoice_content->retrieve_data();
        $dataw             = $CA->invoice_design->retrieve_data();
        $setting           = $CI->Web_settings->retrieve_setting_editdata();
        $data              = array(
            'header'            => $dataw[0]['header'],
            'logo'              => (!empty($setting[0]['invoice_logo']) ? $setting[0]['invoice_logo'] : $company_info[0]['logo']),
            'color'             => $dataw[0]['color'],
            'template'          => $dataw[0]['template'],
            'person_id'         => $office_loan_datas[0]['person_id'],
            'date'              => $office_loan_datas[0]['date'],
            'debit'             => $office_loan_datas[0]['debit'],
            'details'           => $office_loan_datas[0]['details'],
            'phone'             => $office_loan_datas[0]['phone'],
            'paytype'           => $office_loan_datas[0]['paytype'],
            'paytype'           => $office_loan_datas[0]['paytype'],
            'paytype'           => $office_loan_datas[0]['paytype'],
            'company'           => $datacontent,
            'company'           => (!empty($datacontent[0]['company_name']) ? $datacontent[0]['company_name'] : $company_info[0]['company_name']),
            'phone'             => (!empty($datacontent[0]['mobile']) ? $datacontent[0]['mobile'] : $company_info[0]['mobile']),
            'email'             => (!empty($datacontent[0]['email']) ? $datacontent[0]['email'] : $company_info[0]['email']),
            'website'           => (!empty($datacontent[0]['website']) ? $datacontent[0]['website'] : $company_info[0]['website']),
            'address'           => (!empty($datacontent[0]['address']) ? $datacontent[0]['address'] : $company_info[0]['address']),
            'office_loan_datas' => $office_loan_datas,
        );
        $content = $this->load->view('hr/office_loan_html', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function time_sheet_pdf() {
        $timesheet_id  = isset($_GET['timesheetid']) ? $_GET['timesheetid'] : null;
        $encodedId     = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId     = decodeBase64UrlParameter($encodedId);
        $pdf           = $this->Hrm_model->time_sheet_data($timesheet_id, $decodedId);
        $company_info  = $this->Ppurchases->retrieve_company($decodedId);
        $employee_data = $this->Hrm_model->get_employeedata_pdf($pdf[0]['templ_name'], $decodedId);
        $setting       = $this->Web_settings->retrieve_setting_editdata($decodedId);
        $dataw         = $this->invoice_design->retrieve_data($decodedId);
        $datacontent   = $this->invoice_content->retrieve_data($decodedId);
        $data          = array(
            'header'        => $dataw[0]['header'],
            'logo'          => (!empty($setting[0]['invoice_logo']) ? $setting[0]['invoice_logo'] : $company_info[0]['logo']),
            'color'         => $dataw[0]['color'],
            'template'      => $dataw[0]['template'],
            'company'       => $datacontent,
            'employee_name' => $employee_data->first_name . " " . $employee_data->last_name,
            'destination'   => $employee_data->designation,
            'id'            => $employee_data->id,
            'company'       => (!empty($datacontent[0]['company_name']) ? $datacontent[0]['company_name'] : $company_info[0]['company_name']),
            'phone'         => (!empty($datacontent[0]['mobile']) ? $datacontent[0]['mobile'] : $company_info[0]['mobile']),
            'email'         => (!empty($datacontent[0]['email']) ? $datacontent[0]['email'] : $company_info[0]['email']),
            'website'       => (!empty($datacontent[0]['website']) ? $datacontent[0]['website'] : $company_info[0]['website']),
            'address'       => (!empty($datacontent[0]['address']) ? $datacontent[0]['address'] : $company_info[0]['address']),
            'time_sheet'    => $pdf,
        );
        $content = $this->load->view('hr/timesheet_pdf', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function office_loan_delete($transaction_id) {
        $this->load->model('Hrm_model');
        $this->Hrm_model->delete_off_loan($transaction_id);
        $this->session->set_userdata(array('message' => display('successfully_delete')));
        redirect("Chrm/manage_officeloan");
    }
// timesheet index - hr
    public function manage_timesheet() {
        $id        =  $_GET['id'];
        $decodedId = decodeBase64UrlParameter($id);
 
        $response  = array();
        if ($id != "") {
            $setting_detail             = $this->Web_settings->retrieve_setting_editdata($decodedId);
            $data['setting_detail']     = $setting_detail;
            $data['title']              = display('manage_employee');
            $data['timesheet_list']     = $this->Hrm_model->timesheet_list($decodedId);
            $data['timesheet_data_get'] = $this->Hrm_model->timesheet_data_get($decodedId);
            $data['id']                 = $_GET['id'];
            $content                    = $this->parser->parse('hr/timesheet_list', $data, true);
            $this->template->full_admin_html_view($content);
        }  

    }


    public function manage_officeloan() {
        $this->load->model('Hrm_model');
        $CI =  & get_instance();
        $CI->load->model('Web_settings');
        $setting_detail              = $CI->Web_settings->retrieve_setting_editdata();
        $data['title']               = display('manage_employee');
        $data['office_loan_list']    = $this->Hrm_model->office_loan_list();
        $data['officeloan_data_get'] = $this->Hrm_model->officeloan_data_get();
        $data['setting_detail']      = $setting_detail;
        $content                     = $this->parser->parse('hr/officeloan_list', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function add_dailybreak_info() {
        $CI =  & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Hrm_model');
        $postData = $this->input->post('dailybreak_name');
        $data     = $this->Hrm_model->insert_dailybreak_data($postData);
        echo json_encode($data);
    }
    public function timesheet_delete() {
        $encodedId    = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId    = decodeBase64UrlParameter($encodedId);
        $timesheet_id = isset($_GET['timesheetid']) ? $_GET['timesheetid'] : null;
        $this->db->where('timesheet_id', $timesheet_id);
        $this->db->where('create_by', $decodedId);
        $this->db->delete('timesheet_info');
        $this->db->where('timesheet_id', $timesheet_id);
        $this->db->where('created_by', $decodedId);
        $this->db->delete('timesheet_info_details');
        $this->db->where('time_sheet_id', $timesheet_id);
        $this->db->where('created_by', $decodedId);
        $this->db->delete('tax_history');
        $this->db->where('timesheet_id', $timesheet_id);
        $this->db->where('create_by', $decodedId);
        $this->db->delete('info_payslip');
        $this->db->where('time_sheet_id', $timesheet_id);
        $this->db->where('created_by', $decodedId);
        $this->db->delete('tax_history_employer');
        $this->session->set_flashdata('message', "Deleted Successfully");
        redirect(base_url('Chrm/manage_timesheet?id=' . $_GET['id']));
    }
    public function pay_slip() {
        $id        = $this->input->post('id');
        $decodedId = decodeBase64UrlParameter($id);
        if (empty($id)) {
            redirect(base_url());
        }
        $company_info = $this->Ppurchases->retrieve_company($decodedId);
        $datacontent  = $this->invoice_content->retrieve_data($decodedId);
        $this->load->model('Hrm_model');
        $data['title']                  = display('pay_slip');
        $data['business_name']          = (!empty($datacontent[0]['company_name']) ? $datacontent[0]['company_name'] : $company_info[0]['company_name']);
        $data['phone']                  = (!empty($datacontent[0]['mobile']) ? $datacontent[0]['mobile'] : $company_info[0]['mobile']);
        $data['email']                  = (!empty($datacontent[0]['email']) ? $datacontent[0]['email'] : $company_info[0]['email']);
        $data['address']                = (!empty($datacontent[0]['address']) ? $datacontent[0]['address'] : $company_info[0]['address']);
        $data_timesheet['total_hours']  = $this->input->post('total_net');
        $data_timesheet['templ_name']   = $this->input->post('templ_name');
        $data_timesheet['payroll_type'] = $this->input->post('payroll_type');
        $data_timesheet['duration']     = $this->input->post('duration');
        $data_timesheet['job_title']    = $this->input->post('job_title');
        $data_timesheet['payment_term'] = $this->input->post('payment_term');
        $data_timesheet['month']        = $this->input->post('date_range');
        $week_total_net                 = $this->input->post('week_total_net');
        $data_timesheet['week_one']     = isset($week_total_net[0]) ? $week_total_net[0] : null;
        $data_timesheet['week_two']     = isset($week_total_net[1]) ? $week_total_net[1] : null;
        $data_timesheet['week_three']   = isset($week_total_net[2]) ? $week_total_net[2] : null;
        $date_split                     = explode(' - ', $this->input->post('date_range'));
        $data_timesheet['start']        = $date_split[0];
        $data_timesheet['end']          = $date_split[1];
        $start_date                     = $data_timesheet['start'];
        $month                          = date('m', strtotime(str_replace('/', '-', $start_date)));
        if ($month >= 1 && $month <= 3) {
            $quarter = 'Q1';
        } elseif ($month >= 4 && $month <= 6) {
            $quarter = 'Q2';
        } elseif ($month >= 7 && $month <= 9) {
            $quarter = 'Q3';
        } elseif ($month >= 10 && $month <= 12) {
            $quarter = 'Q4';
        } else {
            $quarter = 'Unknown';
        }
        $data_timesheet['quarter']        = $quarter;
        $data_timesheet['timesheet_id']   = $this->input->post('tsheet_id');
        $data_timesheet['create_by']      = $this->session->userdata('user_id');
        $data_timesheet['admin_name']     = (!empty($this->input->post('administrator_person', TRUE)) ? $this->input->post('administrator_person', TRUE) : '');
        $data_timesheet['payment_method'] = (!empty($this->input->post('payment_method', TRUE)) ? $this->input->post('payment_method', TRUE) : '');
        $data_timesheet['cheque_no']      = (!empty($this->input->post('cheque_no', TRUE)) ? $this->input->post('cheque_no', TRUE) : '');
        $data_timesheet['cheque_date']    = (!empty($this->input->post('cheque_date', TRUE)) ? $this->input->post('cheque_date', TRUE) : '');
        $data_timesheet['bank_name']      = (!empty($this->input->post('bank_name', TRUE)) ? $this->input->post('bank_name', TRUE) : '');
        $data_timesheet['payment_ref_no'] = (!empty($this->input->post('payment_refno', TRUE)) ? $this->input->post('payment_refno', TRUE) : '');
        if (!empty($this->input->post('administrator_person', TRUE))) {
            $data_timesheet['uneditable'] = 1;
        } else {
            $data_timesheet['uneditable'] = 0;
        }
        $u_id                        = $this->input->post('unique_id');
        $data_timesheet['unique_id'] = $u_id;
        $employee_detail             = $this->db->where('id', $this->input->post('templ_name'));
        $q                           = $this->db->get('employee_history');
        $row                         = $q->row_array();
        if (!empty($row['id'])) {
            $data['selected_state_local_tax'] = $row['state_local_tax'];
            $data['selected_local_tax']       = $row['local_tax'];
            $data['selected_state_tax']       = $row['state_tx'];
            $data['templ_name']               = $row['first_name'] . " " . $row['last_name'];
            $data['job_title']                = $row['designation'];
        }
        $present1       = $this->input->post('block');
        $date1          = $this->input->post('date');
        $day1           = $this->input->post('day');
        $time_start1    = $this->input->post('start');
        $time_end1      = $this->input->post('end');
        $hours_per_day1 = $this->input->post('sum');
        $daily_bk1      = $this->input->post('dailybreak');
        $purchase_id_1  = $this->db->where('templ_name', $this->input->post('templ_name'))->where('timesheet_id', $data_timesheet['timesheet_id']);
        $q              = $this->db->get('timesheet_info');
        $row            = $q->row_array();
        $old_id         = trim($row['timesheet_id']);
        if (!empty($old_id)) {
            $this->session->set_userdata("timesheet_id_old", $row['timesheet_id']);
            $this->db->where('timesheet_id', $this->session->userdata("timesheet_id_old"));
            $this->db->delete('timesheet_info');
            $this->db->where('timesheet_id', $this->session->userdata("timesheet_id_old"));
            $this->db->delete('timesheet_info_details');
            $this->db->insert('timesheet_info', $data_timesheet);
        } else {
            $this->db->insert('timesheet_info', $data_timesheet);
        }
        $purchase_id_2 = $this->db->select('timesheet_id')->from('timesheet_info')->where('templ_name', $this->input->post('templ_name'))->where('month', $this->input->post('date_range'))->get()->row()->timesheet_id;
        $this->session->set_userdata("timesheet_id_new", $purchase_id_2);
        if (empty($date1)) {
            $data1 = array(
                'timesheet_id' => $this->session->userdata("timesheet_id_new"),
            );
            $this->db->insert('timesheet_info_details', $data1);
        } else {
            for ($i = 0, $n = count($date1); $i < $n; $i++) {
                $present       = $present1[$i];
                $date          = $date1[$i];
                $day           = $day1[$i];
                $time_start    = $time_start1[$i];
                $daily_bk      = $daily_bk1[$i];
                $time_end      = $time_end1[$i];
                $hours_per_day = $hours_per_day1[$i];
                $data1         = array(
                    'timesheet_id'  => $this->session->userdata("timesheet_id_new"),
                    'present'       => $present,
                    'Date'          => $date,
                    'Day'           => $day,
                    'time_start'    => $time_start,
                    'daily_break'   => $daily_bk,
                    'time_end'      => $time_end,
                    'hours_per_day' => $hours_per_day,
                    'created_by'    => $this->session->userdata('user_id'),
                );
                $this->db->insert('timesheet_info_details', $data1);
            }
        }
        $data['employee_data']  = $this->Hrm_model->employee_info($this->input->post('templ_name'), $decodedId);
        $data['timesheet_data'] = $this->Hrm_model->timesheet_info_data($this->session->userdata("timesheet_id_new"), $decodedId);
        $timesheetdata          = $data['timesheet_data'];
        $employeedata           = $data['employee_data'];
        $hrate                  = $data['employee_data'][0]['hrate'];
        $total_hours            = $data['timesheet_data'][0]['total_hours'];
        $payperiod              = $data['timesheet_data'][0]['month'];
        $get_date               = explode('-', $payperiod);
        $d1                     = $get_date[1];
        $data['sc']             = $this->Hrm_model->sc_info_count($data['employee_data'][0]['id'], $payperiod, $decodedId);
        $scValue                = $data['sc']['sc'][0]['sc'];
        $sc_totalAmount1        = $data['sc']['total_gtotal'];
        $sc_count               = $data['sc']['count'];
        $scValue                = $scValue / 100;
        $scValueAmount1         = $scValue * $sc_totalAmount1;
        if ($data['timesheet_data'][0]['payroll_type'] == 'Hourly') {
            if ($total_hours <= 40) {
                $final = ($hrate * $total_hours) + $scValueAmount1;
            } else {
                $final = $data['timesheet_data'][0]['extra_thisrate'] + $data['timesheet_data'][0]['above_extra_sum'];
            }
        } else if ($data['timesheet_data'][0]['payroll_type'] == 'Salaried-BiWeekly') {
            if ($total_hours <= 14) {
                $final = ($hrate * $total_hours) + $scValueAmount1;
            } else {
                $final = $data['timesheet_data'][0]['extra_thisrate'] + $data['timesheet_data'][0]['above_extra_sum'];
            }
        } else if ($data['timesheet_data'][0]['payroll_type'] == 'Salaried-weekly') {
            if ($total_hours <= 7) {
                $final = ($hrate * $total_hours) + $scValueAmount1;
            } else {
                $final = $data['timesheet_data'][0]['extra_thisrate'] + $data['timesheet_data'][0]['above_extra_sum'];
            }
        } else if ($data['timesheet_data'][0]['payroll_type'] == 'Salaried-Monthly') {
            if ($total_hours <= 30) {
                $final = ($hrate * $total_hours) + $scValueAmount1;
            } else {
                $final = $data['timesheet_data'][0]['extra_thisrate'] + $data['timesheet_data'][0]['above_extra_sum'];
            }
        } else if ($data['timesheet_data'][0]['payroll_type'] == 'Salaried-BiMonthly') {
            if ($total_hours <= 60) {
                $final = ($hrate * $total_hours) + $scValueAmount1;
            } else {
                $final = $data['timesheet_data'][0]['extra_thisrate'] + $data['timesheet_data'][0]['above_extra_sum'];
            }
        }
        $s             = '';
        $u             = '';
        $m             = '';
        $f             = '';
        $federal_tax   = $this->db->select('*')->from('federal_tax')->where('tax', 'Federal Income tax')->get()->result_array();
        $federal_range = '';
        $f_tax         = '';
        foreach ($federal_tax as $amt) {
            $split = explode('-', $amt[$data['employee_data'][0]['employee_tax']]);
            if ($final >= $split[0] && $final <= $split[1]) {
                $federal_range = $split[0] . "-" . $split[1];
            }
        }
        $data['federal'] = $this->Hrm_model->federal_tax_info($data['employee_data'][0]['employee_tax'], $final, $federal_range, $decodedId);
        if (!empty($data['federal'])) {
            $Federal_employee = $data['federal'][0]['employee'];
            $f                = ($Federal_employee / 100) * $final;
            $f                = round($f, 2);
            $ar               = $this->db->select('f_tax')->from('tax_history')->where('employee_id', $this->input->post('templ_name'))->get()->row()->f_tax;
            $f_tax            = $ar + $f;
        }
        $social_tax   = $this->db->select('*')->from('federal_tax')->where('tax', 'Social Security')->get()->result_array();
        $social_range = '';
        $s_tax        = '';
        $split        = explode('-', $social_tax[0][$data['employee_data'][0]['employee_tax']]);
        if ($final >= $split[0] && $final <= $split[1]) {
            $social_range = $split[0] . "-" . $split[1];
        }
        $data['social'] = $this->Hrm_model->social_tax_info($data['employee_data'][0]['employee_tax'], $final, $social_range, $decodedId);
        if (!empty($data['social'][0]['employee'])) {
            $social_employee = $data['social'][0]['employee'];
            $s               = ($social_employee / 100) * $final;
            $s               = round($s, 2);
            $ar              = $this->db->select('s_tax')->from('tax_history')->where('employee_id', $this->input->post('templ_name'))->get()->row()->s_tax;
            $s_tax           = $ar + $s;
        }
        $Medicare       = $this->db->select('*')->from('federal_tax')->where('tax', 'Medicare')->get()->result_array();
        $Medicare_range = '';
        $m_tax          = '';
        foreach ($Medicare as $social_amt) {
            $split = explode('-', $social_amt[$data['employee_data'][0]['employee_tax']]);
            if ($final >= $split[0] && $final <= $split[1]) {
                $Medicare_range = $split[0] . "-" . $split[1];
            }
        }
        $data['Medicare'] = $this->Hrm_model->Medicare_tax_info($data['employee_data'][0]['employee_tax'], $final, $Medicare_range, $decodedId);
        if (!empty($data['Medicare'])) {
            $Medicare_employee = $data['Medicare'][0]['employee'];
            $m                 = ($Medicare_employee / 100) * $final;
            $m                 = round($m, 2);
            $ar                = $this->db->select('m_tax')->from('tax_history')->where('employee_id', $this->input->post('templ_name'))->get()->row()->m_tax;
            $m_tax             = $ar + $m;
        }
        $minValue = $final;
        $maxValue = $final;
        $query    = "SELECT `single`
FROM `weekly_tax_info`
WHERE `tax` = 'Weekly New Jersey-Income tax - NJ'
AND CAST(SUBSTRING_INDEX(`single`, '-', 1) AS UNSIGNED) <= $maxValue
AND CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`single`, '-', -1), '-', 1) AS UNSIGNED) >= $minValue";
        $result = $this->db->query($query);
        if (!$result) {
            $error = $this->db->error();
            echo "Query execution error: " . $error['message'];
        } else {
            $weekly_tax = $result->result_array();
        }
        $weekly_range   = $weekly_tax[0]['single'];
        $split_values   = explode('-', $weekly_range);
        $firstValue     = $split_values[0];
        $secondValue    = $split_values[1];
        $getvalue       = $minValue - $firstValue;
        $w_tax          = '';
        $data['weekly'] = $this->Hrm_model->weekly_tax_info($data['employee_data'][0]['employee_tax'], $final, $weekly_range);
        if (!empty($data['weekly'][0]['employee'])) {
            $weekly_employee_details = $data['weekly'][0]['details'];
            $addamt                  = explode('$', $weekly_employee_details);
            $weekly_employee         = $data['weekly'][0]['employee'];
            $wkly                    = ($weekly_employee / 100) * $getvalue;
            $wkly                    = round($wkly, 2);
            $weekly_tax              = $addamt[1] + $wkly;
        }
        $unemployment       = $this->db->select('*')->from('federal_tax')->where('tax', 'Federal unemployment')->get()->result_array();
        $unemployment_range = '';
        $u_tax              = '';
        foreach ($unemployment as $social_amt) {
            $split = explode('-', $social_amt[$data['employee_data'][0]['employee_tax']]);
            if ($final >= $split[0] && $final <= $split[1]) {
                $unemployment_range = $split[0] . "-" . $split[1];
            }
        }
        $data['unemployment'] = $this->Hrm_model->unemployment_tax_info($data['employee_data'][0]['employee_tax'], $final, $unemployment_range, $decodedId);
        if (!empty($data['unemployment'])) {
            $unemployment_employee = $data['Medicare'][0]['employee'];
            $u                     = ($unemployment_employee / 100) * $final;
            $u                     = round($u, 2);
            $ar                    = $this->db->select('u_tax')->from('tax_history')->where('employee_id', $this->input->post('templ_name'))->get()->row()->u_tax;
            $u_tax                 = $ar + $u;
        }
        $state = '';
        if ($data['selected_state_local_tax'] != '') {
            $state_tax       = $this->db->select('*')->from('state_and_tax')->where('state', $data['selected_state_local_tax'])->where('created_by', $this->session->userdata('user_id'))->get()->result_array();
            $state           = $this->db->select('*')->from('state_and_tax')->where('state', $state_tax[0]['state'])->get()->result_array();
            $tax_split       = explode(',', $state[0]['tax']);
            $local_tax_range = '';
            $local_tax       = '';
            $local_tax       = array();
            foreach ($tax_split as $tax) {
                $tax = $this->db->select('*')->from('state_localtax')->where('tax', $state_tax[0]['state'] . "-" . $tax)->where('create_by', $this->session->userdata('user_id'))->get()->result_array();
                foreach ($tax as $tx) {
                    $split = explode('-', $tx[$data['employee_data'][0]['employee_tax']]);
                    if ($split[0] != '' && $split[1] != '') {
                        if ($final >= $split[0] && $final <= $split[1]) {
                            $local_tax_range  = $split[0] . "-" . $split[1];
                            $data['localtax'] = $this->Hrm_model->local_state_tax($data['employee_data'][0]['employee_tax'], $final, $local_tax_range);
                            if (!empty($data['localtax'])) {
                                $i = 0;
                                foreach ($data['localtax'] as $lt) {
                                    $local_tax_employee = $lt['employee'];
                                    $local_tax_employer = $lt['employer'];
                                    $local_tax_ee       = ($local_tax_employee / 100) * $final;
                                    $local_tax_er       = ($local_tax_employer / 100) * $final;
                                    $row                = $this->db->select('*')->from('state_localtax')->where('employee', $local_tax_employee)->where('tax', $tx['tax'])->where($data['employee_data'][0]['employee_tax'], $local_tax_range)->where('create_by', $this->session->userdata('user_id'))->count_all_results();
                                    $data_employee      = "'employee_" . $tx['tax'] . "'";
                                    $search_tax         = explode('-', $tx['tax']);
                                    if ($row == 1) {
                                        $ar                        = $this->db->select('amount')->from('tax_history')->where('tax', $search_tax[1])->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])->get()->row()->amount;
                                        $t_tx                      = $local_tax_ee;
                                        $local_tax[$data_employee] = $t_tx;
                                    }
                                    $i++;
                                }
                            }
                        }
                    }
                }
            }
            $test2 = $this->db->select('*')->from('info_payslip')->where('timesheet_id', $timesheetdata[0]['timesheet_id'])
                ->get()->row();
            if (!empty($test2->timesheet_id)) {
                $this->db->where('timesheet_id', $test2->timesheet_id);
                $this->db->delete('info_payslip');
            }
            $test = $this->db->select('time_sheet_id')->from('tax_history')->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                ->get()->row();
            if (!empty($test->time_sheet_id)) {
                $this->db->where('time_sheet_id', $test->time_sheet_id);
                $this->db->delete('tax_history');
            }
            $payperiod       = $data['timesheet_data'][0]['month'];
            $data['sc']      = $this->Hrm_model->sc_info_count($this->input->post('templ_name'), $payperiod, $decodedId);
            $scValue         = $data['sc']['sc'][0]['sc'];
            $sc_totalAmount1 = $data['sc']['total_gtotal'];
            $sc_count        = $data['sc']['count'];
            if ($sc_totalAmount1 != 0) {
                $scValuePercentage = ($scValue / $sc_totalAmount1) * 100;
                $scValueAmount     = ($scValuePercentage / 100) * $sc_totalAmount1;
            } else {
                $scValueAmount = 0;
            }
            $scValue       = $scValue / 100;
            $scValueAmount = $scValue * $sc_totalAmount;
            if ($local_tax) {
                foreach ($local_tax as $k => $v) {
                    $split = explode('-', $k);
                    $tx_n  = str_replace("'", "", $split[1]);
                    $data1 = array(
                        's_tax'          => $s,
                        'm_tax'          => $m,
                        'u_tax'          => $u,
                        'f_tax'          => $f,
                        'sales_c_amount' => $scValueAmount,
                        'sc'             => $scValue,
                        'tax_type'       => 'state_local_tax',
                        'no_of_inv'      => $sc_count,
                        'tax'            => $tx_n,
                        'amount'         => $v,
                        'time_sheet_id'  => $timesheetdata[0]['timesheet_id'],
                        'employee_id'    => $timesheetdata[0]['templ_name'],
                        'weekly'         => $weekly_tax,
                        'created_by'     => $this->session->userdata('user_id'),
                    );
                    $this->db->insert('tax_history', $data1);
                }
            } else {
                $data1 = array(
                    's_tax'          => $s,
                    'm_tax'          => $m,
                    'u_tax'          => (!empty($data['unemployment']) ? $u : 0),
                    'f_tax'          => $f,
                    'tax_type'       => 'state_local_tax',
                    'sales_c_amount' => $sc_totalAmount,
                    'sc'             => $scValue,
                    'no_of_inv'      => $sc_count,
                    'tax'            => '',
                    'amount'         => '',
                    'time_sheet_id'  => $timesheetdata[0]['timesheet_id'],
                    'employee_id'    => $timesheetdata[0]['templ_name'],
                    'weekly'         => $weekly_tax,
                    'created_by'     => $this->session->userdata('user_id'),
                );
                $this->db->insert('tax_history', $data1);
            }
        }
        if ($data['selected_state_local_tax'] == '') {
            if (!empty($data['selected_local_tax'])) {
                $state_tax       = $this->db->select('*')->from('state_and_tax')->where('state', $data['selected_local_tax'])->where('created_by', $this->session->userdata('user_id'))->get()->result_array();
                $state           = $this->db->select('*')->from('state_and_tax')->where('state', $state_tax[0]['state'])->get()->result_array();
                $tax_split       = explode(',', $state[0]['tax']);
                $local_tax_range = '';
                $local_tax       = '';
                $local_tax       = array();
                foreach ($tax_split as $tax) {
                    $tax = $this->db->select('*')->from('state_localtax')->where('tax', $state_tax[0]['state'] . "-" . $tax)->where('create_by', $this->session->userdata('user_id'))->get()->result_array();
                    foreach ($tax as $tx) {
                        $split = explode('-', $tx[$data['employee_data'][0]['employee_tax']]);
                        if ($split[0] != '' && $split[1] != '') {
                            if ($final >= $split[0] && $final <= $split[1]) {
                                $local_tax_range  = $split[0] . "-" . $split[1];
                                $data['localtax'] = $this->Hrm_model->local_state_tax($data['employee_data'][0]['employee_tax'], $final, $local_tax_range);
                                if (!empty($data['localtax'])) {
                                    $i = 0;
                                    foreach ($data['localtax'] as $lt) {
                                        $local_tax_employee = $lt['employee'];
                                        $local_tax_employer = $lt['employer'];
                                        $local_tax_ee       = ($local_tax_employee / 100) * $final;
                                        $local_tax_er       = ($local_tax_employer / 100) * $final;
                                        $row                = $this->db->select('*')->from('state_localtax')->where('employee', $local_tax_employee)->where('tax', $tx['tax'])->where('create_by', $this->session->userdata('user_id'))->where($data['employee_data'][0]['employee_tax'], $local_tax_range)->count_all_results();
                                        $data_employee      = "'employee_" . $tx['tax'] . "'";
                                        $search_tax         = explode('-', $tx['tax']);
                                        if ($row == 1) {
                                            $ar                        = $this->db->select('amount')->from('tax_history')->where('tax', $search_tax[1])->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])->get()->row()->amount;
                                            $t_tx                      = $local_tax_ee;
                                            $local_tax[$data_employee] = $t_tx;
                                        }
                                        $i++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if (!empty($data['selected_state_tax'])) {
                $state_tax1      = $this->db->select('*')->from('state_and_tax')->where('state', $data['selected_state_tax'])->where('created_by', $this->session->userdata('user_id'))->get()->result_array();
                $state1          = $this->db->select('*')->from('state_and_tax')->where('state', $state_tax1[0]['state'])->get()->result_array();
                $tax_split1      = explode(',', $state1[0]['tax']);
                $state_tax_range = '';
                $st_tax          = '';
                $st_tax          = array();
                foreach ($tax_split1 as $tax) {
                    $tax = $this->db->select('*')->from('state_localtax')->where('tax', $state_tax1[0]['state'] . "-" . $tax)->where('create_by', $this->session->userdata('user_id'))->get()->result_array();
                    foreach ($tax as $tx) {
                        $split = explode('-', $tx[$data['employee_data'][0]['employee_tax']]);
                        if ($split[0] != '' && $split[1] != '') {
                            if ($final >= $split[0] && $final <= $split[1]) {
                                $state_tax_range  = $split[0] . "-" . $split[1];
                                $data['localtax'] = $this->Hrm_model->local_state_tax($data['employee_data'][0]['employee_tax'], $final, $state_tax_range);
                                if (!empty($data['localtax'])) {
                                    $i = 0;
                                    foreach ($data['localtax'] as $lt) {
                                        $local_tax_employee = $lt['employee'];
                                        $local_tax_employer = $lt['employer'];
                                        $local_tax_ee       = ($local_tax_employee / 100) * $final;
                                        $local_tax_er       = ($local_tax_employer / 100) * $final;
                                        $row                = $this->db->select('*')->from('state_localtax')->where('employee', $local_tax_employee)->where('tax', $tx['tax'])->where($data['employee_data'][0]['employee_tax'], $local_tax_range)->where('create_by', $this->session->userdata('user_id'))->count_all_results();
                                        $data_employee      = "'employee_" . $tx['tax'] . "'";
                                        $search_tax         = explode('-', $tx['tax']);
                                        if ($row == 1) {
                                            $ar                     = $this->db->select('amount')->from('tax_history')->where('tax', $search_tax[1])->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])->get()->row()->amount;
                                            $t_tx                   = $local_tax_ee;
                                            $st_tax[$data_employee] = $t_tx;
                                        }
                                        $i++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $test2 = $this->db->select('*')->from('info_payslip')->where('timesheet_id', $timesheetdata[0]['timesheet_id'])
                ->get()->row();
            if (!empty($test2->timesheet_id)) {
                $this->db->where('timesheet_id', $test2->timesheet_id);
                $this->db->delete('info_payslip');
            }
            $test = $this->db->select('time_sheet_id')->from('tax_history')->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                ->get()->row();
            if (!empty($test->time_sheet_id)) {
                $this->db->where('time_sheet_id', $test->time_sheet_id);
                $this->db->delete('tax_history');
            }
            $payperiod       = $data['timesheet_data'][0]['month'];
            $data['sc']      = $this->Hrm_model->sc_info_count($this->input->post('templ_name'), $payperiod, $decodedId);
            $scValue         = $data['sc']['sc'][0]['sc'];
            $sc_totalAmount1 = $data['sc']['total_gtotal'];
            $sc_count        = $data['sc']['count'];
            if ($sc_totalAmount1 != 0) {
                $scValuePercentage = ($scValue / $sc_totalAmount1) * 100;
                $scValueAmount     = ($scValuePercentage / 100) * $sc_totalAmount1;
            } else {
                $scValueAmount = 0;
            }
            $scValue       = $scValue / 100;
            $scValueAmount = $scValue * $sc_totalAmount;
        }
        if ($st_tax) {
            foreach ($st_tax as $k => $v) {
                $existingRecord = $this->db->select('*')
                    ->from('tax_history')
                    ->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                    ->where('employee_id', $timesheetdata[0]['templ_name'])
                    ->where('tax', str_replace("'", "", explode('-', $k)[1]))
                    ->get()->row();
                $split = explode('-', $k);
                $tx_n  = str_replace("'", "", $split[1]);
                if (!$existingRecord) {
                    $data1 = array(
                        's_tax'          => $s,
                        'm_tax'          => $m,
                        'u_tax'          => $u,
                        'f_tax'          => $f,
                        'tax_type'       => 'state_tax',
                        'sales_c_amount' => $scValueAmount,
                        'sc'             => $scValue,
                        'no_of_inv'      => $sc_count,
                        'tax'            => $tx_n,
                        'amount'         => $v,
                        'time_sheet_id'  => $timesheetdata[0]['timesheet_id'],
                        'employee_id'    => $timesheetdata[0]['templ_name'],
                        'created_by'     => $this->session->userdata('user_id'),
                    );
                    $this->db->insert('tax_history', $data1);
                }
            }
            $sql = "DELETE t1
FROM tax_history t1
INNER JOIN tax_history t2 ON t1.id > t2.id
AND t1.tax = t2.tax
AND t1.code = t2.code
AND t1.amount = t2.amount
AND t1.created_by = t2.created_by
AND t1.time_sheet_id = t2.time_sheet_id
WHERE t1.weekly IS NULL
AND t1.monthly IS NULL
AND t1.biweekly IS NULL;
";
            $this->db->query($sql);
        }
        if ($local_tax) {
            foreach ($local_tax as $k => $v) {
                $existingRecord = $this->db->select('*')
                    ->from('tax_history')
                    ->where('time_sheet_id', $timesheetdata[0]['timesheet_id'])
                    ->where('employee_id', $timesheetdata[0]['templ_name'])
                    ->where('tax', str_replace("'", "", explode('-', $k)[1]))
                    ->get()->row();
                $split = explode('-', $k);
                $tx_n  = str_replace("'", "", $split[1]);
                if (!$existingRecord) {
                    $data1 = array(
                        's_tax'          => $s,
                        'm_tax'          => $m,
                        'u_tax'          => $u,
                        'f_tax'          => $f,
                        'tax_type'       => 'local_tax',
                        'sales_c_amount' => $sc_totalAmount,
                        'sc'             => $scValue,
                        'no_of_inv'      => $sc_count,
                        'tax'            => $tx_n,
                        'amount'         => $v,
                        'time_sheet_id'  => $timesheetdata[0]['timesheet_id'],
                        'employee_id'    => $timesheetdata[0]['templ_name'],
                        'created_by'     => $this->session->userdata('user_id'),
                    );
                    $this->db->insert('tax_history', $data1);
                }
            }
        }
        $payperiod         = $data['timesheet_data'][0]['month'];
        $data['sc']        = $this->Hrm_model->sc_info_count($this->input->post('templ_name'), $payperiod, $decodedId);
        $scValue           = $data['sc']['sc'][0]['sc'];
        $sc_totalAmount1   = $data['sc']['total_gtotal'];
        $sc_count          = $data['sc']['count'];
        $scValuePercentage = ($scValue / $sc_totalAmount1) * 100;
        $sc_totalAmount    = ($scValuePercentage / 100) * $sc_totalAmount1;
        if (is_nan($scValuePercentage)) {
            $scValuePercentage = 0;
            $data2             = array(
                's_tax'          => $s,
                'm_tax'          => $m,
                'u_tax'          => $u,
                'f_tax'          => $f,
                'sc'             => $scValue,
                'no_of_inv'      => $countValue,
                'tax'            => $tx_n,
                'sales_c_amount' => $sales_amount,
                'total_amount'   => $final,
                'timesheet_id'   => $timesheetdata[0]['timesheet_id'],
                'total_hours'    => $timesheetdata[0]['total_hours'],
                'templ_name'     => $timesheetdata[0]['templ_name'],
                'employee_tax'   => $employeedata[0]['employee_tax'],
                'hrate'          => $employeedata[0]['hrate'],
                'id'             => $employeedata[0]['id'],
                'create_by'      => $this->session->userdata('user_id'),
            );
            $result = $this->db->insert('info_payslip', $data2);
            if ($result) {
                $response['status'] = 'success';
                $response['msg']    = 'Timesheet  has been added successfully';
            }
        }
        echo json_encode($response);
    }
    public function expense_list() {
        $this->load->model('Hrm_model');
        $CI =  & get_instance();
        $CI->load->model('Web_settings');
        $setting_detail            = $CI->Web_settings->retrieve_setting_editdata();
        $data['expen_list']        = $this->Hrm_model->expense_list();
        $data['expenses_data_get'] = $this->Hrm_model->expenses_data_get();
        $data['setting_detail']    = $setting_detail;
        $content                   = $this->parser->parse('hr/expense_list', $data, true);
        $this->template->full_admin_html_view($content);
    }
//Generated Pay Slips List - Index page
    public function pay_slip_list() {
        $encodedId          = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId          = decodeBase64UrlParameter($encodedId);
        $data['title']      = display('pay_slip_list');
        // $datainfo           = $this->Hrm_model->get_data_payslip($decodedId);
        $infodatainfo       = $this->Hrm_model->get_data_payslip($decodedId);
        $sc_no_datainfo     = $this->Hrm_model->sc_no_get_data_payslip($decodedId);
        $sc_info_choice_yes = $this->Hrm_model->sc_info_choice_yes($decodedId);
        $datainfo           = array_merge($infodatainfo, $sc_no_datainfo, $sc_info_choice_yes);
        $data               = array(
            'dataforpayslip' => $datainfo,
        );
        $content = $this->parser->parse('hr/pay_slip_list', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function payroll_reports() {
        $this->load->model('Hrm_model');
        $CI =  & get_instance();
        $CI->load->model('Web_settings');
        $setting_detail = $CI->Web_settings->retrieve_setting_editdata();
        $data['title']  = display('payroll_manage');
        $datainfo       = $this->Hrm_model->get_data_payslip();
        $emplinfo       = $this->Hrm_model->empl_data_info();
        $data           = array(
            'dataforpayslip' => $datainfo,
            'employee_info'  => $emplinfo,
            'setting_detail' => $setting_detail,
        );
        $content = $this->parser->parse('hr/payroll_manage_list', $data, true);
        $this->template->full_admin_html_view($content);
    }
//Payroll setting - Hr
    public function add_state() {
        $encodedId = $this->input->post('encodedId');
        $decodedId = decodeBase64UrlParameter($encodedId);
        $this->form_validation->set_rules('state_name', 'State Name', 'required');
        $response = array();
        if ($this->form_validation->run() == FALSE) {
            $response['status'] = 'failure';
            $response['msg']    = validation_errors();
        } else {
            $state_name = $this->input->post('state_name');
            $data       = array(
                'state'      => $state_name,
                'Type'       => 'State',
                'created_by' => $decodedId,
            );
            $result = $this->db->insert('state_and_tax', $data);
            if ($result) {
                $response['status'] = 'success';
                $response['msg']    = 'State Name has been added successfully';
            } else {
                $response['status'] = 'failure';
                $response['msg']    = 'Failed to add State Name. Please try again.';
            }
        }
        echo json_encode($response);
    }
//Payroll setting - Hr
    public function add_state_tax() {
        $encodedId = $this->input->post('encodedId');
        $decodedId = decodeBase64UrlParameter($encodedId);
        $this->form_validation->set_rules('selected_state', 'State Name', 'required');
        $this->form_validation->set_rules('state_tax_name', 'Tax Name', 'required');
        $response = array();
        if ($this->form_validation->run() == FALSE) {
            $response['status'] = 'failure';
            $response['msg']    = validation_errors();
        } else {
            $tx                 = $this->input->post('state_tax_name');
            $st_code            = explode("-", $tx);
            $state_code         = trim($st_code[1]);
            $selected_state     = $this->input->post('selected_state');
            $addstatetax_update = $this->Hrm_model->addstatetax_update($selected_state, $tx, $decodedId);
            $statetax_updated   = $this->Hrm_model->update_statetax($state_code, $selected_state, $decodedId);
            if ($addstatetax_update & $statetax_updated) {
                $response['status'] = 'success';
                $response['msg']    = 'State Name Assigned  successfully';
            } else {
                $response['status'] = 'failure';
                $response['msg']    = 'Failed to add State Name Assigned. Please try again.';
            }
        }
        echo json_encode($response);
    }
//Payroll setting - Hr
    public function add_city() {
        $encodedId = $this->input->post('encodedId');
        $decodedId = decodeBase64UrlParameter($encodedId);
        $this->form_validation->set_rules('city_name', 'City Name', 'required');
        $response = array();
        if ($this->form_validation->run() == FALSE) {
            $response['status'] = 'failure';
            $response['msg']    = validation_errors();
        } else {
            $city_name = $this->input->post('city_name');
            $data      = array(
                'state'      => $city_name,
                'Type'       => 'City',
                'created_by' => $decodedId,
            );
            $result = $this->db->insert('state_and_tax', $data);
            if ($result) {
                $response['status'] = 'success';
                $response['msg']    = 'City Name has been added successfully';
            } else {
                $response['status'] = 'failure';
                $response['msg']    = 'Failed to add City Name has been added. Please try again.';
            }
        }
        echo json_encode($response);
    }
    //Payroll setting - Hr
    public function add_city_state_tax() {
        $encodedId = $this->input->post('encodedId');
        $decodedId = decodeBase64UrlParameter($encodedId);
        $this->form_validation->set_rules('selected_city', 'City Name', 'required');
        $this->form_validation->set_rules('city_tax_name', 'City Tax Name', 'required');
        $response = array();
        if ($this->form_validation->run() == FALSE) {
            $response['status'] = 'failure';
            $response['msg']    = validation_errors();
        } else {
            $selected_state    = $this->input->post('selected_city');
            $tx                = $this->input->post('city_tax_name');
            $city_update       = $this->Hrm_model->city_update($selected_state, $tx, $decodedId);
            $cityassign_update = $this->Hrm_model->cityassign_update();
            if ($city_update) {
                $response['status'] = 'success';
                $response['msg']    = 'City Name Assigned  successfully';
            } else {
                $response['status'] = 'failure';
                $response['msg']    = 'Failed to add City Name Assigned. Please try again.';
            }
        }
        echo json_encode($response);
    }
    public function add_county() {
        $encodedId = $this->input->post('encodedId');
        $decodedId = decodeBase64UrlParameter($encodedId);
        $this->form_validation->set_rules('county', 'County ', 'required');
        $response = array();
        if ($this->form_validation->run() == FALSE) {
            $response['status'] = 'failure';
            $response['msg']    = validation_errors();
        } else {
            $county = $this->input->post('county');
            $data   = array(
                'state'      => $county,
                'created_by' => $decodedId,
                'Type'       => 'County',
            );
            $result = $this->db->insert('state_and_tax', $data);
            if ($result) {
                $response['status'] = 'success';
                $response['msg']    = 'County Name has been added successfully';
            } else {
                $response['status'] = 'failure';
                $response['msg']    = 'Failed to add County Name has been added. Please try again.';
            }
        }
        echo json_encode($response);
    }
//Payroll setting - Hr
    public function add_county_tax() {
        $encodedId = $this->input->post('encodedId');
        $decodedId = decodeBase64UrlParameter($encodedId);
        $this->form_validation->set_rules('selected_county', 'County Name', 'required');
        $this->form_validation->set_rules('county_tax_name', 'County Tax Name', 'required');
        $response = array();
        if ($this->form_validation->run() == FALSE) {
            $response['status'] = 'failure';
            $response['msg']    = validation_errors();
        } else {
            $selected_state      = $this->input->post('selected_county');
            $tx                  = $this->input->post('county_tax_name');
            $county_update       = $this->Hrm_model->county_update($selected_state, $tx, $decodedId);
            $countyassign_update = $this->Hrm_model->countyassign_update();
            if ($county_update) {
                $response['status'] = 'success';
                $response['msg']    = 'County Name Assigned  successfully';
            } else {
                $response['status'] = 'failure';
                $response['msg']    = 'Failed to add County Name Assigned. Please try again.';
            }
        }
        echo json_encode($response);
    }
    //Employee add designation -hr
    public function add_designation_data() {
        $this->form_validation->set_rules('designation', 'Designation', 'required');
        $response = array();
        if ($this->form_validation->run() == FALSE) {
            $response['status'] = 'failure';
            $response['msg']    = validation_errors();
        } else {
            $postData  = $this->input->post('designation');
            $decodedId = $this->input->post('encodedId');
            $data      = $this->Hrm_model->designation_info($postData, $decodedId);
            if ($data) {
                $response['status']          = 'success';
                $response['msg']             = 'Designation has been added successfully';
                $response['get_designation'] = $data;
            } else {
                $response['status'] = 'failure';
                $response['msg']    = 'Failed to add Designation. Please try again.';
            }
        }
        echo json_encode($response);
    }



    
    public function add_office_loan() {
        $CI =  & get_instance();
        $CI->load->model('Web_settings');
        $CI->load->model('Invoices');
        $CI->load->model('Settings');
        $data['person_list'] = $CI->Settings->office_loan_person();
        $setting_detail      = $CI->Web_settings->retrieve_setting_editdata();
        $bank_name           = $CI->db->select('bank_id,bank_name')
            ->from('bank_add')
            ->get()
            ->result_array();
        $data['bank_list'] = $CI->Web_settings->bank_list();
        $CI                =  & get_instance();
        $paytype           = $CI->Invoices->payment_type();
        $noofpayment_type  = $CI->Invoices->noofpayment_type();
        $CI->load->model('Web_settings');
        $data['payment_typ']      = $paytype;
        $data['bank_name']        = $bank_name;
        $data['noofpayment_type'] = $noofpayment_type;
        $data['setting_detail']   = $setting_detail;
        $currency_details         = $CI->Web_settings->retrieve_setting_editdata();
        $data['title']            = display('add_office_loan');
        $data['currency']         = $currency_details[0]['currency'];
        $content                  = $this->parser->parse('hr/add_office_loan', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function add_expense_item() {
        $CI =  & get_instance();
        $CI->load->model('Web_settings');
        $CI->load->model('Hrm_model');
        $currency_details       = $CI->Web_settings->retrieve_setting_editdata();
        $setting_detail         = $CI->Web_settings->retrieve_setting_editdata();
        $data['setting_detail'] = $setting_detail;
        $data['person_list']    = $CI->Hrm_model->employee_list();
        $data['title']          = display('expense_item_form');
        $data['currency']       = $currency_details[0]['currency'];
        $content                = $this->parser->parse('hr/expense_item_form', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function tax_list() {
        $data['title'] = display('tax_list');
        $content       = $this->parser->parse('hr/payroll_setting', $data, true);
        $this->template->full_admin_html_view($content);
    }
//Payroll Settings - Hrm
    public function payroll_setting() {
        $encodedId                             = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId                             = decodeBase64UrlParameter($encodedId);
        $data['title']                         = display('federal_taxes');
        $setting_detail                        = $this->Web_settings->retrieve_setting_editdata($decodedId);
        $data['timesheet_data_emp']            = $this->Hrm_model->timesheet_data_emp($decodedId);
        $data['setting_detail']                = $setting_detail;
        $data['encodedId']                     = $encodedId;
        $data['decodedId']                     = $decodedId;
        $data['states_list']                   = $this->Hrm_model->get_state_taxdata($decodedId);
        $data['city_list']                     = $this->Hrm_model->get_city_taxdata($decodedId);
        $data['county_list']                   = $this->Hrm_model->get_county_taxdata($decodedId);
        $data['get_data_salespartner']         = $this->Hrm_model->get_data_salespartner($decodedId);
        $data['get_data_salespartner_another'] = $this->Hrm_model->get_data_salespartner_another($decodedId);
        $data['merged_data_salespartner']      = array_merge($data['get_data_salespartner'], $data['get_data_salespartner_another']);
        $data['state_selected']                = $this->Hrm_model->get_state_selected($decodedId);
        $content                               = $this->parser->parse('hr/federal_taxes', $data, true);
        $this->template->full_admin_html_view($content);
    }  
//F1099NEC -HR
    public function formfl099nec($selectedValue = null, $decodedId) {
        $data['get_cominfo']            = $this->Hrm_model->get_company_info($decodedId);
        $data['get_f1099nec_info']      = $this->Hrm_model->get_f1099nec_info($selectedValue, $decodedId);
        $data['choice']                 = $data['get_f1099nec_info'][0]['choice'];
        $data['no_salecommission']      = $this->Hrm_model->no_salecommission($selectedValue, $decodedId);
        $data['emp_yes_salecommission'] = $this->Hrm_model->emp_yes_salecommission($selectedValue);
        $data['sss']                    = $data['emp_yes_salecommission'][0]['emp_sc_amount'];
        $currency_details               = $this->Web_settings->retrieve_setting_editdata($decodedId);
        $data['currency']               = $currency_details[0]['currency'];
        $content                        = $this->parser->parse('hr/fl099nec', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function delete_tax() {
        $tax   = $this->input->post('tax');
        $state = $this->input->post('state');
        $this->load->model('Hrm_model');
        $this->Hrm_model->delete_tax($tax, $state);
        $this->session->set_flashdata('show', display('successfully_delete'));
        redirect("Chrm/payroll_setting");
    }
    public function citydelete_tax() {
        $citytax = $this->input->post('citytax');
        $city    = $this->input->post('city');
        $this->load->model('Hrm_model');
        $this->Hrm_model->citydelete_tax($citytax, $city);
        $this->session->set_flashdata('show', display('successfully_delete'));
    }
    public function countydelete_tax() {
        $countytax = $this->input->post('countytax');
        $county    = $this->input->post('county');
        $this->load->model('Hrm_model');
        $this->Hrm_model->countydelete_tax($countytax, $county);
        $this->session->set_flashdata('show', display('successfully_delete'));
        redirect("Chrm/payroll_setting");
    }
    public function getemployee_data() {
        $CI =  & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Hrm_model');
        $value         = $this->input->post('value', TRUE);
        $customer_info = $CI->Hrm_model->getemp_data($value);
        echo json_encode($customer_info);
    }
    public function add_state_taxes_detail($tax = null) {
        $encodedId              = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId              = decodeBase64UrlParameter($encodedId);
        $setting_detail         = $this->Web_settings->retrieve_setting_editdata();
        $data['setting_detail'] = $setting_detail;
        $url                    = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $parts                  = parse_url($url);
        parse_str($parts['query'], $query);
        $data['taxinfo']           = $this->Hrm_model->retrieve_state_localtax($decodedId, $query['tax']);
        $get_tax_name              = $this->Hrm_model->get_weeklytaxinfo($decodedId);
        $weekly_tax                = 'Weekly';
        $data['trimmed_tax']       = str_replace($weekly_tax, '', $get_tax_name[0]['tax']);
        $data['weekly_taxinfo']    = $this->Hrm_model->retrieveget_weeklytaxinfo($decodedId, $get_tax_name[0]['tax']);
        $get_tax_name_biweekly     = $this->Hrm_model->get_biweeklytaxinfo($decodedId);
        $biweekly_tax              = 'BIWeekly';
        $data['trimmed_tax_bi']    = str_replace($biweekly_tax, '', $get_tax_name_biweekly[0]['tax']);
        $data['biweekly_taxinfo']  = $this->Hrm_model->retrieveget_biweeklytaxinfo($decodedId, $get_tax_name_biweekly[0]['tax']);
        $get_tax_name_monthly      = $this->Hrm_model->get_tax_name_monthly($decodedId);
        $monthly_tax               = 'Monthly';
        $data['trimmed_tax_monly'] = str_replace($monthly_tax, '', $get_tax_name_monthly[0]['tax']);
        $data['monthly_taxinfo']   = $this->Hrm_model->retrieveget_monthlytaxinfo($decodedId, $get_tax_name_monthly[0]['tax']);
        $data['title']             = display('add_taxes_detail');
        $content                   = $this->parser->parse('hr/add_state_tax_detail', $data, true);
        $this->template->full_admin_html_view($content);
    }
// Payroll Setting - Hr
    public function add_taxes_detail() {
        $encodedId              = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId              = decodeBase64UrlParameter($encodedId);
        $setting_detail         = $this->Web_settings->retrieve_setting_editdata();
        $data['setting_detail'] = $setting_detail;
        $tax                    = $this->input->post('tax');
        $data['taxinfo']        = $this->Hrm_model->retrieve_federal_tax($decodedId);
        $data['title']          = display('add_taxes_detail');
        $content                = $this->parser->parse('hr/add_taxes_detail', $data, true);
        $this->template->full_admin_html_view($content);
    }
// Payroll Setting - Hr
    public function socialsecurity_detail() {
        $encodedId              = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId              = decodeBase64UrlParameter($encodedId);
        $setting_detail         = $this->Web_settings->retrieve_setting_editdata();
        $data['setting_detail'] = $setting_detail;
        $data['taxinfo']        = $this->Hrm_model->retrieve_socialsecurity_tax($decodedId);
        $data['title']          = display('add_taxes_detail');
        $content                = $this->parser->parse('hr/social_security_list', $data, true);
        $this->template->full_admin_html_view($content);
    }
// Payroll Setting - Hr
    public function medicare_detail() {
        $encodedId              = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId              = decodeBase64UrlParameter($encodedId);
        $setting_detail         = $this->Web_settings->retrieve_setting_editdata();
        $data['setting_detail'] = $setting_detail;
        $data['taxinfo']        = $this->Hrm_model->retrieve_medicare_tax($decodedId);
        $data['title']          = display('add_taxes_detail');
        $content                = $this->parser->parse('hr/medicare_list', $data, true);
        $this->template->full_admin_html_view($content);
    }
// Payroll Setting - Hr
    public function federalunemployment_detail() {
        $encodedId              = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId              = decodeBase64UrlParameter($encodedId);
        $setting_detail         = $this->Web_settings->retrieve_setting_editdata();
        $data['taxinfo']        = $this->Hrm_model->retrieve_federal_unemployment($decodedId);
        $data['title']          = display('add_taxes_detail');
        $data['setting_detail'] = $setting_detail;
        $content                = $this->parser->parse('hr/federalunemployment_list', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function add_timesheet() {
        $encodedId              = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId              = decodeBase64UrlParameter($encodedId);
        $data['title']          = display('add_timesheet');
        $setting_detail         = $this->Web_settings->retrieve_setting_editdata($decodedId);
        $data['employee_name']  = $this->Hrm_model->employee_name1($decodedId);
        $data['payment_terms']  = $this->Hrm_model->get_payment_terms($decodedId);
        $data['setting_detail'] = $setting_detail;
        $data['encodedId']      = $encodedId;
        $data['dailybreak']     = $this->Hrm_model->get_dailybreak($decodedId);
        $data['duration']       = $this->Hrm_model->get_duration_data($decodedId);
        $content                = $this->parser->parse('hr/add_timesheet', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function add_durat_info() {
        $CI =  & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Hrm_model');
        $postData = $this->input->post('duration_name');
        $data     = $this->Hrm_model->insert_duration_data($postData);
        echo json_encode($data);
    }
    public function add_adm_data() {
        $CI =  & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Hrm_model');
        $postData = $this->input->post('data_name');
        $postData = $this->input->post('data_adres');
        $data     = $this->Hrm_model->insert_adsrs_data($postData);
        echo json_encode($data);
    }
//Administrator name -Add
    public function insert_data_adsr() {
        $this->form_validation->set_rules('adms_name', 'Designation', 'required');
        $response = array();
        if ($this->form_validation->run() == FALSE) {
            $response['status'] = 'failure';
            $response['msg']    = validation_errors();
        } else {
            $encodedId = $this->input->post('id');
            $decodedId = decodeBase64UrlParameter($encodedId);
            $postData  = array(
                'adm_name'    => $this->input->post('adms_name', TRUE),
                'adm_address' => $this->input->post('address', TRUE),
                'create_by'   => $decodedId,
            );
            $result = $this->Hrm_model->insert_adsrs_data($postData ,$decodedId );
            if ($result) {
                $response['status']            = 'success';
                $response['msg']               = 'Administrator has been added successfully';
                $response['get_administrator'] = $result;
            } else {
                $response['status'] = 'failure';
                $response['msg']    = 'Failed to add Administrator. Please try again.';
            }
        }
        echo json_encode($response);
    }
    public function add_designation() {
        $data['title'] = display('add_designation');
        $content       = $this->parser->parse('hr/employee_type', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function create_designation() {
        $this->form_validation->set_rules('designation', display('designation'), 'required|max_length[100]');
        $this->form_validation->set_rules('details', display('details'), 'max_length[250]');
        if ($this->form_validation->run()) {
            $postData = [
                'id'          => $this->input->post('id', true),
                'designation' => $this->input->post('designation', true),
                'details'     => $this->input->post('details', true),
            ];
            if (empty($this->input->post('id', true))) {
                if ($this->Hrm_model->create_designation($postData)) {
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    $this->session->set_flashdata('error_message', display('please_try_again'));
                }
            } else {
                if ($this->Hrm_model->update_designation($postData)) {
                    $this->session->set_flashdata('message', display('successfully_updated'));
                } else {
                    $this->session->set_flashdata('error_message', display('please_try_again'));
                }
            }
            redirect("Chrm/manage_designation");
        }
        redirect("Chrm/add_designation");
    }
    public function manage_designation() {
        $this->load->model('Hrm_model');
        $data['title']            = display('manage_designation');
        $data['designation_list'] = $this->Hrm_model->designation_list();
        $content                  = $this->parser->parse('hr/designation_list', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function designation_update_form($id) {
        $this->load->model('Hrm_model');
        $data['title']            = display('designation_update_form');
        $data['designation_data'] = $this->Hrm_model->designation_editdata($id);
        $content                  = $this->parser->parse('hr/employee_type', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function designation_delete($id) {
        $this->load->model('Hrm_model');
        $this->Hrm_model->delete_designation($id);
        $this->session->set_userdata(array('message' => display('successfully_delete')));
        redirect("Chrm/manage_designation");
    }
// For Create Sale - Sales Partner
    public function getAllSalesPartner() {
        $data = $this->Hrm_model->getAllSalesPartner();
        echo json_encode($response);
    }



// For Create Sale - Sales Partner
public function salespartner_create() {
        $this->form_validation->set_rules('sfirst_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        if (($ssn === true || $federalidentificationnumber === false) && ($ssn === false || $federalidentificationnumber === true)) {
            $this->form_validation->set_rules('ssn', 'Social Security Number', 'required');
            $this->form_validation->set_rules('federalidentificationnumber', 'Federal Identification Number', 'required');
        }
        $this->form_validation->set_rules('federaltaxclassification', 'Federal Tax Classification', 'required');
        $this->form_validation->set_rules('emp_tax_detail', 'Employee Tax', 'required');
        $this->form_validation->set_rules('state_tax', 'Withholding Tax - State Tax', 'required');
        $this->form_validation->set_rules('city_tax', 'Withholding Tax - City Tax', 'required');
        $this->form_validation->set_rules('county_tax', 'Withholding Tax - County Tax', 'required');
        $this->form_validation->set_rules('other_working_tax', 'Withholding Tax - Other Working Tax', 'required');
        $this->form_validation->set_rules('living_state_tax', 'Withholding Tax - Living State Tax', 'required');
        $this->form_validation->set_rules('living_city_tax', 'Withholding Tax - Living City Tax', 'required');
        $this->form_validation->set_rules('living_county_tax', 'Withholding Tax - Living County Tax', 'required');
        $this->form_validation->set_rules('other_living_tax', 'Withholding Tax - Other Living Tax', 'required');
        $response = array();
        if ($this->form_validation->run() == FALSE) {
            $response['status'] = 'failure';
            $response['msg']    = validation_errors();
        } else {
                $id =  $this->input->post('id');
                if ($_FILES['profile_image']['name']) {
                    $config['upload_path']   = 'uploads/profile/salespartner/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
                    $config['encrypt_name']  = TRUE;
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('profile_image')) {
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                        redirect(base_url('Cweb_setting'));
                    } else {
                        $data                     = $this->upload->data();
                        $profile_image            = $data['file_name'];
                        $config['image_library']  = 'gd2';
                        $config['source_image']   = $profile_image;
                        $config['create_thumb']   = false;
                        $config['maintain_ratio'] = TRUE;
                        $config['width']          = 200;
                        $config['height']         = 200;
                        $this->load->library('image_lib', $config);
                        $this->image_lib->resize();
                        $profile_image = $profile_image;
                    }
                }
                $data_empolyee['last_name']                   = $this->input->post('last_name');
                $data_empolyee['designation']                 = $this->input->post('designation');
                $data_empolyee['first_name']                  = $this->input->post('sfirst_name');
                $data_empolyee["middle_name"]                 = $this->input->post("smiddle_name");
                $data_empolyee['phone']                       = $this->input->post('phone');
                $data_empolyee['files']                       = $insertImages;
                $data_empolyee['employee_tax']                = $this->input->post('emp_tax_detail');
                $data_empolyee['employee_type']               = $this->input->post('employee_type');
                $data_empolyee['salesbusiness_name']          = $this->input->post('salesbusiness_name');
                $data_empolyee['federalidentificationnumber'] = $this->input->post('federalidentificationnumber');
                $data_empolyee['federaltaxclassification']    = $this->input->post('federaltaxclassification');
                $data_empolyee['cty_tax']                     = $this->input->post('citytx');
                $data_empolyee['email']                       = $this->input->post('email');
                $data_empolyee['sc']                          = $this->input->post('sc');
                $data_empolyee['address_line_1']              = $this->input->post('address_line_1');
                $data_empolyee['address_line_2']              = $this->input->post('address_line_2');
                $data_empolyee['social_security_number']      = $this->input->post('ssnInput');
                $data_empolyee['routing_number']              = $this->input->post('routing_number');
                $data_empolyee['sales_partner']               = 'Sales_Partner';
                $data_empolyee['choice']                      = $this->input->post('choice');
                $data_empolyee['account_number']              = $this->input->post('account_number');
                $data_empolyee['rate_type']                   = $this->input->post('paytype');
                $data_empolyee['bank_name']                   = $this->input->post('bank_name');
                $data_empolyee['country']                     = $this->input->post('country');
                $data_empolyee['city']                        = $this->input->post('city');
                $data_empolyee['zip']                         = $this->input->post('zip');
                $data_empolyee['state']                       = $this->input->post('state');
                $data_empolyee['emergencycontact']            = $this->input->post('emergencycontact');
                $data_empolyee['emergencycontactnum']         = $this->input->post('emergencycontactnum');
                $data_empolyee['withholding_tax']             = $this->input->post('withholding_tax');
                $data_empolyee['last_name']                   = $this->input->post('last_name');
                $data_empolyee['profile_image']               = $profile_image;
                $data_empolyee['create_by']                   = decodeBase64UrlParameter($id);
                $data_empolyee['e_type']                      = 2;
                $data_empolyee['sp_withholding']              = $this->input->post('choice');
                $state_tax                                    = $this->input->post('state_tax');
                $living_state_tax                             = $this->input->post('living_state_tax');
                if ($state_tax == $living_state_tax) {
                    $data_empolyee['state_tx'] = $state_tax;
                } else {

if ($_FILES['profile_image']['name']) {
                    $config['upload_path']   = 'uploads/profile';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
                    $config['encrypt_name']  = TRUE;
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('profile_image')) {
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                        redirect(base_url('Cweb_setting'));
                    } else {
                        $data                     = $this->upload->data();
                        $profile_image            = $data['file_name'];
                        $config['image_library']  = 'gd2';
                        $config['source_image']   = $profile_image;
                        $config['create_thumb']   = false;
                        $config['maintain_ratio'] = TRUE;
                        $config['width']          = 200;
                        $config['height']         = 200;
                        $this->load->library('image_lib', $config);
                        $this->image_lib->resize();
                        $profile_image = $profile_image;
                    }
                }
                $data_empolyee['last_name']                   = $this->input->post('last_name');
                $data_empolyee['designation']                 = $this->input->post('designation');
                $data_empolyee['first_name']                  = $this->input->post('sfirst_name');
                $data_empolyee["middle_name"]                 = $this->input->post("smiddle_name");
                $data_empolyee['phone']                       = $this->input->post('phone');
                $data_empolyee['files']                  = $insertImages;
                $data_empolyee['employee_tax']                = $this->input->post('emp_tax_detail');
                $data_empolyee['employee_type']               = $this->input->post('employee_type');
                $data_empolyee['salesbusiness_name']          = $this->input->post('salesbusiness_name');
                $data_empolyee['federalidentificationnumber'] = $this->input->post('federalidentificationnumber');
                $data_empolyee['federaltaxclassification']    = $this->input->post('federaltaxclassification');
                $data_empolyee['cty_tax']                     = $this->input->post('citytx');
                $data_empolyee['email']                       = $this->input->post('email');
                $data_empolyee['sc']                          = $this->input->post('sc');
                $data_empolyee['address_line_1']              = $this->input->post('address_line_1');
                $data_empolyee['address_line_2']              = $this->input->post('address_line_2');
                $data_empolyee['social_security_number']      = $this->input->post('ssnInput');
                $data_empolyee['routing_number']              = $this->input->post('routing_number');
                $data_empolyee['sales_partner']               = 'Sales_Partner';
                $data_empolyee['choice']                      = $this->input->post('choice');
                $data_empolyee['account_number']              = $this->input->post('account_number');
                $data_empolyee['rate_type']                   = $this->input->post('paytype');
                $data_empolyee['bank_name']                   = $this->input->post('bank_name');
                $data_empolyee['country']                     = $this->input->post('country');
                $data_empolyee['city']                        = $this->input->post('city');
                $data_empolyee['zip']                         = $this->input->post('zip');
                $data_empolyee['state']                        = $this->input->post('state');
                $data_empolyee['emergencycontact']            = $this->input->post('emergencycontact');
                $data_empolyee['emergencycontactnum']         = $this->input->post('emergencycontactnum');
                $data_empolyee['withholding_tax']             = $this->input->post('withholding_tax');
                $data_empolyee['last_name']                   = $this->input->post('last_name');
                $data_empolyee['profile_image']               = $profile_image;
                $data_empolyee['create_by']                   = decodeBase64UrlParameter($id);
                $data_empolyee['e_type']                      = 2;
                $data_empolyee['sp_withholding']              = $this->input->post('choice');
                $state_tax                                    = $this->input->post('state_tax');
                $living_state_tax                             = $this->input->post('living_state_tax');
                if ($state_tax == $living_state_tax) {
                    $data_empolyee['state_tx'] = $state_tax;
                } else {
                    $data_empolyee['state_tx']         = $state_tax;
                    $data_empolyee['living_state_tax'] = $living_state_tax;
                }
                $city_tax        = $this->input->post('city_tax');
                $living_city_tax = $this->input->post('living_city_tax');
                if ($city_tax == $living_city_tax) {
                    $data_empolyee['local_tax'] = $city_tax;
                } else {
                    $data_empolyee['local_tax']        = $city_tax;
                    $data_empolyee['living_local_tax'] = $living_city_tax;
                }
                $county_tax        = $this->input->post('county_tax');
                $living_county_tax = $this->input->post('living_county_tax');
                if ($county_tax == $living_county_tax) {
                    $data_empolyee['cty_tax'] = $county_tax;
                } else {
                    $data_empolyee['cty_tax']           = $county_tax;
                    $data_empolyee['living_county_tax'] = $living_county_tax;
                }
                $other_working_tax = $this->input->post('other_working_tax');
                $other_living_tax  = $this->input->post('other_living_tax');
                if ($county_tax == $county_tax) {
                    $data_empolyee['state_tax_1'] = $other_working_tax;
                } else {
                    $data_empolyee['state_tax_1'] = $other_working_tax;
                    $data_empolyee['state_tax_2'] = $other_living_tax;
                }
                $living_state_tax                     = $this->input->post('living_state_tax');
                $data_empolyee['edit_working_state']  = $state_tax;
                $data_empolyee['edit_living_state']   = $living_state_tax;
                $city_tax                             = $this->input->post('city_tax');
                $living_city_tax                      = $this->input->post('living_city_tax');
                $data_empolyee['edit_working_city']   = $city_tax;
                $data_empolyee['edit_living_city']    = $living_city_tax;
                $county_tax                           = $this->input->post('county_tax');
                $living_county_tax                    = $this->input->post('living_county_tax');
                $data_empolyee['edit_working_county'] = $county_tax;
                $data_empolyee['edit_living_county']  = $living_county_tax;
                $other_working_tax                    = $this->input->post('other_working_tax');
                $other_living_tax                     = $this->input->post('other_living_tax');
                $data_empolyee['edit_working_other']  = $other_working_tax;
                $data_empolyee['edit_living_other']   = $other_living_tax;
                }
                $result  = $this->db->insert('employee_history', $data_empolyee);
                $all_sales_partner = $this->Hrm_model->getAllSalesPartner(decodeBase64UrlParameter($id));
                $employeeId        = $this->db->insert_id();
                $lastempid = $this->Hrm_model->getlastid(decodeBase64UrlParameter($id));
                $lastId = $lastempid[0]['id'];
            // Insert Attchment
                if(!empty($_FILES['salefiles'])){
                    $fileCount = count($_FILES['salefiles']['name']);
                    for ($i = 0; $i <= $fileCount; $i++) {
                        if ($_FILES['salefiles']['error'][$i] == UPLOAD_ERR_OK) {
                        $upload_data = multiple_file_upload('salefiles',$i,'salespartner',SALESPARTNER_IMG_PATH);
                        if($upload_data['upload_data']['file_name'] !=""){
                            $res = insertAttachments($lastId, $upload_data['upload_data']['file_name'],SALESPARTNER_IMG_PATH,'salespartner',$this->session->userdata('unique_id'),decodeBase64UrlParameter($id));
                        }
                        }
                    }
                }
                if ($result && $all_sales_partner) {$response['data'] = $all_sales_partner;
                    $response['status']                          = 'success';
                    $response['msg']                             = 'Employee has been added successfully';
                    $response['msg']                             = 'Sales Partner has been added successfully';} else {
                    $response['status'] = 'failure';
                    $response['msg']    = 'Failed to add Employee. Please try again.';
                    $response['msg']    = 'Failed to add Sales Partner. Please try again.';
                 }
              }
            echo json_encode($response);
        }
 
public function salespartner_update() {
    $this->form_validation->set_rules('sfirst_name', 'First Name', 'required');
    $this->form_validation->set_rules('last_name', 'Last Name', 'required');
    $this->form_validation->set_rules('phone', 'Phone', 'required');
    $ssn = $this->input->post('ssn');
    $federalidentificationnumber = $this->input->post('federalidentificationnumber');
    if (($ssn && !$federalidentificationnumber) || (!$ssn && $federalidentificationnumber)) {
        $this->form_validation->set_rules('ssn', 'Social Security Number', 'required');
        $this->form_validation->set_rules('federalidentificationnumber', 'Federal Identification Number', 'required');
    }
    $this->form_validation->set_rules('federaltaxclassification', 'Federal Tax Classification', 'required');
    $this->form_validation->set_rules('emp_tax_detail', 'Employee Tax', 'required');
    $this->form_validation->set_rules('state_tax', 'Withholding Tax - State Tax', 'required');
    $this->form_validation->set_rules('city_tax', 'Withholding Tax - City Tax', 'required');
    $this->form_validation->set_rules('county_tax', 'Withholding Tax - County Tax', 'required');
    $this->form_validation->set_rules('other_working_tax', 'Withholding Tax - Other Working Tax', 'required');
    $this->form_validation->set_rules('living_state_tax', 'Withholding Tax - Living State Tax', 'required');
    $this->form_validation->set_rules('living_city_tax', 'Withholding Tax - Living City Tax', 'required');
    $this->form_validation->set_rules('living_county_tax', 'Withholding Tax - Living County Tax', 'required');
    $this->form_validation->set_rules('other_living_tax', 'Withholding Tax - Other Living Tax', 'required');
    $response = array();
    $id = $this->input->post('id');
    $updatedid = $this->input->post('updatedid');
 
    if ($this->form_validation->run() == FALSE) {
        $response['status'] = 'failure';
        $response['msg'] = validation_errors();
    } else {
        $profile_image = '';
        if (!empty($_FILES['profile_image']['name'])) {
            $config['upload_path'] = 'uploads/profile/salespartner/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            
            if (!$this->upload->do_upload('profile_image')) {
                $response['status'] = 'failure';
                $response['msg'] = $this->upload->display_errors();
                echo json_encode($response);
                return;
            } else {
                $data = $this->upload->data();
                $profile_image = $data['file_name'];
                
                // Resize image
                $config['image_library'] = 'gd2';
                $config['source_image'] = $config['upload_path'] . $profile_image;
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 200;
                $config['height'] = 200;
                $this->load->library('image_lib', $config);
                
                if (!$this->image_lib->resize()) {
                    $response['status'] = 'failure';
                    $response['msg'] = $this->image_lib->display_errors();
                    echo json_encode($response);
                    return;
                }
            }
        }
        $data_employee = array(
            'last_name' => $this->input->post('last_name'),
            'designation' => $this->input->post('designation'),
            'first_name' => $this->input->post('sfirst_name'),
            'middle_name' => $this->input->post('smiddle_name'),
            'phone' => $this->input->post('phone'),
            'files' => $insertImages,
            'employee_tax' => $this->input->post('emp_tax_detail'),
            'employee_type' => $this->input->post('employee_type'),
            'salesbusiness_name' => $this->input->post('salesbusiness_name'),
            'federalidentificationnumber' => $this->input->post('federalidentificationnumber'),
            'federaltaxclassification' => $this->input->post('federaltaxclassification'),
            'cty_tax' => $this->input->post('citytx'),
            'email' => $this->input->post('email'),
            'sc' => $this->input->post('sc'),
            'address_line_1' => $this->input->post('address_line_1'),
            'address_line_2' => $this->input->post('address_line_2'),
            'social_security_number' => $this->input->post('ssnInput'),
            'routing_number' => $this->input->post('routing_number'),
            'sales_partner' => 'Sales_Partner',
            'choice' => $this->input->post('choice'),
            'account_number' => $this->input->post('account_number'),
             'rate_type' => $this->input->post('paytype'),
            'bank_name' => $this->input->post('bank_name'),
            'country' => $this->input->post('country'),
            'city' => $this->input->post('city'),
            'zip' => $this->input->post('zip'),
            'state' => $this->input->post('state'),
            'emergencycontact' => $this->input->post('emergencycontact'),
            'emergencycontactnum' => $this->input->post('emergencycontactnum'),
            'withholding_tax' => $this->input->post('withholding_tax'),
            'profile_image' => $profile_image,
            'create_by' => $id,
            'e_type' => 2,
            'sp_withholding' => $this->input->post('choice'),
            'state_tx' => $this->input->post('state_tax'),
            'living_state_tax' => $this->input->post('living_state_tax'),
            'local_tax' => $this->input->post('city_tax'),
            'living_local_tax' => $this->input->post('living_city_tax'),
            'cty_tax' => $this->input->post('county_tax'),
            'living_county_tax' => $this->input->post('living_county_tax'),
            'state_tax_1' => $this->input->post('other_working_tax'),
            'state_tax_2' => $this->input->post('other_living_tax'),
            'edit_working_state' => $this->input->post('state_tax'),
            'edit_living_state' => $this->input->post('living_state_tax'),
            'edit_working_city' => $this->input->post('city_tax'),
            'edit_living_city' => $this->input->post('living_city_tax'),
            'edit_working_county' => $this->input->post('county_tax'),
            'edit_living_county' => $this->input->post('living_county_tax'),
            'edit_working_other' => $this->input->post('other_working_tax'),
            'edit_living_other' => $this->input->post('other_living_tax')
        );
        $this->db->where('id', $updatedid);
        $result = $this->db->update('employee_history', $data_employee);
    
    // Insert Attchment
    if(!empty($_FILES['files'])){
        $fileCount = count($_FILES['files']['name']);
        for ($i = 0; $i <= $fileCount; $i++) {
            if ($_FILES['files']['error'][$i] == UPLOAD_ERR_OK) {
            $upload_data = multiple_file_upload('files',$i,'salespartner',SALESPARTNER_IMG_PATH);             
            if($upload_data['upload_data']['file_name'] !=""){
                $res = insertAttachments($updatedid, $upload_data['upload_data']['file_name'],SALESPARTNER_IMG_PATH,'salespartner',$this->session->userdata('unique_id'),$id);
            }
            } 
    }
    }
 
        if ($result) {
            $response['status'] = 'success';
            $response['msg'] = 'Sales Partner has been updated successfully';
        } else {
            $response['status'] = 'failure';
            $response['msg'] = 'Failed to update Sales Partner. Please try again.';
        }
    }
    echo json_encode($response);
}


















    //employee - hr
    public function employee_create() {
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('designation', 'Designation', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_rules('employee_type', 'Employee Type', 'required');
        $this->form_validation->set_rules('payroll_type', 'Payroll Type', 'required');
        $this->form_validation->set_rules('hrate', 'Pay Rate', 'required');
        $this->form_validation->set_rules('ssn', 'Social Security Number', 'required');
        $this->form_validation->set_rules('emp_tax_detail', 'Employee Tax', 'required');
        $this->form_validation->set_rules('state_tax', 'Withholding Tax - State Tax', 'required');
        $this->form_validation->set_rules('city_tax', 'Withholding Tax - City Tax', 'required');
        $this->form_validation->set_rules('county_tax', 'Withholding Tax - County Tax', 'required');
        $this->form_validation->set_rules('other_working_tax', 'Withholding Tax - Other Working Tax', 'required');
        $this->form_validation->set_rules('living_state_tax', 'Withholding Tax - Living State Tax', 'required');
        $this->form_validation->set_rules('living_city_tax', 'Withholding Tax - Living City Tax', 'required');
        $this->form_validation->set_rules('living_county_tax', 'Withholding Tax - Living County Tax', 'required');
        $this->form_validation->set_rules('other_living_tax', 'Withholding Tax - Other Living Tax', 'required');
        $this->form_validation->set_message('alpha_space', 'The {field} field should only contain alphabets and spaces.');
        $response = array();
         if ($this->form_validation->run() == FALSE) {
            $response['status'] = 'failure';
            $response['msg']    = validation_errors();
        } else {
            $decodedId ='';
            if($this->input->post('encodedId')){
            $decodedId= $this->input->post('encodedId');
            }else{
              $decodedId=decodeBase64UrlParameter($this->input->post('admin_company_id'));
            }
 
            if (isset($_FILES['files']) && !empty($_FILES['files']['name'][0])) {
                $no_files = count($_FILES["files"]['name']);
                for ($i = 0; $i <= $no_files; $i++) {
                    if ($_FILES["files"]["error"][$i] > 0) {
                      //  echo "Error: " . $_FILES["files"]["error"][$i] . "<br>";
                    } else {
                        move_uploaded_file(
                            $_FILES["files"]["tmp_name"][$i],
                            "uploads/employeedetails/" . $_FILES["files"]["name"][$i]
                        );
                        $images[]     = $_FILES["files"]["name"][$i];
                        $insertImages = implode(', ', $images);
                    }
                }
                if ($_FILES['profile_image']['name']) {
                    $config['upload_path']   = 'uploads/profile';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
                    $config['encrypt_name']  = TRUE;
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('profile_image')) {
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                        redirect(base_url('Cweb_setting'));
                    } else {
                        $data                     = $this->upload->data();
                        $profile_image            = $data['file_name'];
                        $config['image_library']  = 'gd2';
                        $config['source_image']   = $profile_image;
                        $config['create_thumb']   = false;
                        $config['maintain_ratio'] = TRUE;
                        $config['width']          = 200;
                        $config['height']         = 200;
                        $this->load->library('image_lib', $config);
                        $this->image_lib->resize();
                        $profile_image = $profile_image;
                    }
                }
                $data_empolyee['last_name']              = $this->input->post('last_name');
                $data_empolyee['designation']            = $this->input->post('designation');
                $data_empolyee['first_name']             = $this->input->post('first_name');
                $data_empolyee["middle_name"]            = $this->input->post("middle_name");
                $data_empolyee['phone']                  = $this->input->post('phone');
                $data_empolyee['files']                  = $insertImages;
                $data_empolyee['employee_tax']           = $this->input->post('emp_tax_detail');
                $data_empolyee['employee_type']          = $this->input->post('employee_type');
                $data_empolyee['rate_type']              = $this->input->post('paytype');
                $data_empolyee['payroll_type']           = $this->input->post('payroll_type');
                $data_empolyee['choice']                 = $this->input->post('choice');
                $data_empolyee['cty_tax']                = $this->input->post('citytx');
                $data_empolyee['email']                  = $this->input->post('email');
                $data_empolyee['hrate']                  = $this->input->post('hrate');
                $data_empolyee['sc']                     = $this->input->post('sc');
                $data_empolyee['address_line_1']         = $this->input->post('address_line_1');
                $data_empolyee['address_line_2']         = $this->input->post('address_line_2');
                $data_empolyee['social_security_number'] = $this->input->post('ssn');
                $data_empolyee['routing_number']         = $this->input->post('routing_number');
                $data_empolyee['account_number']         = $this->input->post('account_number');
                $data_empolyee['bank_name']              = $this->input->post('bank_name');
                $data_empolyee['country']                = $this->input->post('country');
                $data_empolyee['city']                   = $this->input->post('city');
                $data_empolyee['zip']                    = $this->input->post('zip');
                $data_empolyee['state']                  = $this->input->post('state');
                $data_empolyee['emergencycontact']       = $this->input->post('emergencycontact');
                $data_empolyee['emergencycontactnum']    = $this->input->post('emergencycontactnum');
                $data_empolyee['withholding_tax']        = $this->input->post('withholding_tax');
                $data_empolyee['last_name']              = $this->input->post('last_name');
                $data_empolyee['profile_image']          = $profile_image;
                $data_empolyee['create_by']              = $decodedId;
                $data_empolyee['e_type']                 = 1;
                $state_tax                               = $this->input->post('state_tax');
                $living_state_tax                        = $this->input->post('living_state_tax');
                if ($state_tax == $living_state_tax) {
                    $data_empolyee['state_tx'] = $state_tax;
                } else {
                    $data_empolyee['state_tx']         = $state_tax;
                    $data_empolyee['living_state_tax'] = $living_state_tax;
                }
                $city_tax        = $this->input->post('city_tax');
                $living_city_tax = $this->input->post('living_city_tax');
                if ($city_tax == $living_city_tax) {
                    $data_empolyee['local_tax'] = $city_tax;
                } else {
                    $data_empolyee['local_tax']        = $city_tax;
                    $data_empolyee['living_local_tax'] = $living_city_tax;
                }
                $county_tax        = $this->input->post('county_tax');
                $living_county_tax = $this->input->post('living_county_tax');
                if ($county_tax == $living_county_tax) {
                    $data_empolyee['cty_tax'] = $county_tax;
                } else {
                    $data_empolyee['cty_tax']           = $county_tax;
                    $data_empolyee['living_county_tax'] = $living_county_tax;
                }
                $other_working_tax = $this->input->post('other_working_tax');
                $other_living_tax  = $this->input->post('other_living_tax');
                if ($county_tax == $county_tax) {
                    $data_empolyee['state_tax_1'] = $other_working_tax;
                } else {
                    $data_empolyee['state_tax_1'] = $other_working_tax;
                    $data_empolyee['state_tax_2'] = $other_living_tax;
                }
                $living_state_tax                     = $this->input->post('living_state_tax');
                $data_empolyee['edit_working_state']  = $state_tax;
                $data_empolyee['edit_living_state']   = $living_state_tax;
                $city_tax                             = $this->input->post('city_tax');
                $living_city_tax                      = $this->input->post('living_city_tax');
                $data_empolyee['edit_working_city']   = $city_tax;
                $data_empolyee['edit_living_city']    = $living_city_tax;
                $county_tax                           = $this->input->post('county_tax');
                $living_county_tax                    = $this->input->post('living_county_tax');
                $data_empolyee['edit_working_county'] = $county_tax;
                $data_empolyee['edit_living_county']  = $living_county_tax;
                $other_working_tax                    = $this->input->post('other_working_tax');
                $other_living_tax                     = $this->input->post('other_living_tax');
                $data_empolyee['edit_working_other']  = $other_working_tax;
                $data_empolyee['edit_living_other']   = $other_living_tax;
            } else {
                if ($_FILES['profile_image']['name']) {
                    $config['upload_path']   = 'uploads/profile';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
                    $config['encrypt_name']  = TRUE;
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('profile_image')) {
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                        redirect(base_url('Cweb_setting'));
                    } else {
                        $data                     = $this->upload->data();
                        $profile_image            = $data['file_name'];
                        $config['image_library']  = 'gd2';
                        $config['source_image']   = $profile_image;
                        $config['create_thumb']   = false;
                        $config['maintain_ratio'] = TRUE;
                        $config['width']          = 200;
                        $config['height']         = 200;
                        $this->load->library('image_lib', $config);
                        $this->image_lib->resize();
                        $profile_image = $profile_image;
                    }
                }
                $data_empolyee['last_name']              = $this->input->post('last_name');
                $data_empolyee['designation']            = $this->input->post('designation');
                $data_empolyee['first_name']             = $this->input->post('first_name');
                $data_empolyee["middle_name"]            = $this->input->post("middle_name");
                $data_empolyee['phone']                  = $this->input->post('phone');
                $data_empolyee['employee_tax']           = $this->input->post('emp_tax_detail');
                $data_empolyee['employee_type']          = $this->input->post('employee_type');
                $data_empolyee['payroll_type']           = $this->input->post('payroll_type');
                $data_empolyee['choice']                 = $this->input->post('choice');
                $data_empolyee['rate_type']              = $this->input->post('paytype');
                $data_empolyee['cty_tax']                = $this->input->post('citytx');
                $data_empolyee['email']                  = $this->input->post('email');
                $data_empolyee['sc']                     = $this->input->post('sc');
                $data_empolyee['hrate']                  = $this->input->post('hrate');
                $data_empolyee['address_line_1']         = $this->input->post('address_line_1');
                $data_empolyee['address_line_2']         = $this->input->post('address_line_2');
                $data_empolyee['social_security_number'] = $this->input->post('ssn');
                $data_empolyee['routing_number']         = $this->input->post('routing_number');
                $data_empolyee['account_number']         = $this->input->post('account_number');
                $data_empolyee['bank_name']              = $this->input->post('bank_name');
                $data_empolyee['country']                = $this->input->post('country');
                $data_empolyee['city']                   = $this->input->post('city');
                $data_empolyee['zip']                    = $this->input->post('zip');
                $data_empolyee['state']                  = $this->input->post('state');
                $data_empolyee['emergencycontact']       = $this->input->post('emergencycontact');
                $data_empolyee['emergencycontactnum']    = $this->input->post('emergencycontactnum');
                $data_empolyee['withholding_tax']        = $this->input->post('withholding_tax');
                $data_empolyee['last_name']              = $this->input->post('last_name');
                $data_empolyee['profile_image']          = $profile_image;
                $data_empolyee['create_by']              = $decodedId;
                $data_empolyee['e_type']                 = 1;
                $state_tax                               = $this->input->post('state_tax');
                $living_state_tax                        = $this->input->post('living_state_tax');
                if ($state_tax == $living_state_tax) {
                    $data_empolyee['state_tx'] = $state_tax;
                } else {
                    $data_empolyee['state_tx']         = $state_tax;
                    $data_empolyee['living_state_tax'] = $living_state_tax;
                }
                $city_tax        = $this->input->post('city_tax');
                $living_city_tax = $this->input->post('living_city_tax');
                if ($city_tax == $living_city_tax) {
                    $data_empolyee['local_tax'] = $city_tax;
                } else {
                    $data_empolyee['local_tax']        = $city_tax;
                    $data_empolyee['living_local_tax'] = $living_city_tax;
                }
                $county_tax        = $this->input->post('county_tax');
                $living_county_tax = $this->input->post('living_county_tax');
                if ($county_tax == $living_county_tax) {
                    $data_empolyee['cty_tax'] = $county_tax;
                } else {
                    $data_empolyee['cty_tax']           = $county_tax;
                    $data_empolyee['living_county_tax'] = $living_county_tax;
                }
                $other_working_tax = $this->input->post('other_working_tax');
                $other_living_tax  = $this->input->post('other_living_tax');
                if ($county_tax == $county_tax) {
                    $data_empolyee['state_tax_1'] = $other_working_tax;
                } else {
                    $data_empolyee['state_tax_1'] = $other_working_tax;
                    $data_empolyee['state_tax_2'] = $other_living_tax;
                }
                $living_state_tax                     = $this->input->post('living_state_tax');
                $data_empolyee['edit_working_state']  = $state_tax;
                $data_empolyee['edit_living_state']   = $living_state_tax;
                $city_tax                             = $this->input->post('city_tax');
                $living_city_tax                      = $this->input->post('living_city_tax');
                $data_empolyee['edit_working_city']   = $city_tax;
                $data_empolyee['edit_living_city']    = $living_city_tax;
                $county_tax                           = $this->input->post('county_tax');
                $living_county_tax                    = $this->input->post('living_county_tax');
                $data_empolyee['edit_working_county'] = $county_tax;
                $data_empolyee['edit_living_county']  = $living_county_tax;
                $other_working_tax                    = $this->input->post('other_working_tax');
                $other_living_tax                     = $this->input->post('other_living_tax');
                $data_empolyee['edit_working_other']  = $other_working_tax;
                $data_empolyee['edit_living_other']   = $other_living_tax;
            }
            $result     = $this->db->insert('employee_history', $data_empolyee);
       
            $getEmployee_List = $this->Hrm_model->getAllEmployee($decodedId);
          
            $employeeId       = $this->db->insert_id();
            if ($result) {$response['employee_list'] = $getEmployee_List;
                $response['status']                                   = 'success';
                $response['msg']                                      = 'Employee has been added successfully';} else {
                $response['status'] = 'failure';
                $response['msg']    = 'Failed to add Employee. Please try again.';
            }
        }
        echo json_encode($response);
    }


    public function employee_update_form() {
        $employee_id                 = isset($_GET['employee']) ? $_GET['employee'] : null;
        $encodedId                   = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId                   = decodeBase64UrlParameter($encodedId);
        $setting_detail              = $this->Web_settings->retrieve_setting_editdata($decodedId);
        $currency_details            = $this->Web_settings->retrieve_setting_editdata($decodedId);
        $curn_info_default           = $this->Hrm_model->curn_info_default($currency_details[0]["currency"], $decodedId);
        $data["setting_detail"]      = $setting_detail;
        $data["curn_info_default"]   = $curn_info_default[0]["currency_name"];
        $data["currency"]            = $currency_details[0]["currency"];
        $data["get_info_city_tax"]   = $this->Hrm_model->get_info_city_tax($decodedId);
        $data["get_info_county_tax"] = $this->Hrm_model->get_info_county_tax($decodedId);
        $data["encodedId"] =   $decodedId ;
        $data["title"]               = display("employee_update");
        $data["employee_data"]       = $this->Hrm_model->employee_editdata($employee_id, $decodedId);
        $emp_id   =       $data["employee_data"][0]['id'];
        $data["attachmentData"]      = $this->Hrm_model->editAttachment($emp_id, $decodedId);
        $data["state_tx"]            = $this->Hrm_model->state_tax($decodedId);
        $data["cty_tax"]             = $this->Hrm_model->state_tax($decodedId);
        $data["designation"]         = $this->Hrm_model->getdesignation($data["employee_data"][0]["designation"], $decodedId);
        $data["payroll_data"]        = $this->Hrm_model->payroll_editdata($id, $decodedId);
        $data["employeetype_data"]   = $this->Hrm_model->employeestype_editdata($id, $decodedId);
        $data["bank_data"]           = $this->Hrm_model->getbankinfo($decodedId);
        $data["desig"]               = $this->Hrm_model->designation_dropdown($decodedId);
        $content                     = $this->parser->parse("hr/employee_updateform", $data, true);
        $this->template->full_admin_html_view($content);
    }



 
    public function update_employee() {
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('designation', 'Designation', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_rules('employee_type', 'Employee Type', 'required');
        $this->form_validation->set_rules('payroll_type', 'Payroll Type', 'required');
        $this->form_validation->set_rules('hrate', 'Pay Rate', 'required');
        $this->form_validation->set_rules('ssn', 'Social Security Number', 'required');
        $this->form_validation->set_rules('emp_tax_detail', 'Employee Tax', 'required');
        $this->form_validation->set_rules('state_tax', 'State Tax', 'required');
        $this->form_validation->set_rules('city_tax', 'City Tax', 'required');
        $this->form_validation->set_rules('county_tax', 'County Tax', 'required');
        $this->form_validation->set_rules('other_working_tax', 'Other Working Tax', 'required');
        $this->form_validation->set_rules('living_state_tax', 'Living State Tax', 'required');
        $this->form_validation->set_rules('living_city_tax', 'Living City Tax', 'required');
        $this->form_validation->set_rules('living_county_tax', 'Living County Tax', 'required');
        $this->form_validation->set_rules('other_living_tax', 'Other Living Tax', 'required');
        $this->form_validation->set_message('alpha_space', 'The {field} field should only contain alphabets and spaces.');
        $response = array();
        if ($this->form_validation->run() == FALSE) {
            $response['status'] = 'failure';
            $response['msg']    = validation_errors();
        } else {

  
            $this->load->model("Hrm_model");
            if (isset($_FILES["files"]) && is_array($_FILES["files"]["name"])) {
                $no_files = count($_FILES["files"]["name"]);
                $images = [];
                for ($i = 0; $i < $no_files; $i++) {
                    if ($_FILES["files"]["error"][$i] > 0) {
                    } else {
                        move_uploaded_file(
                            $_FILES["files"]["tmp_name"][$i],
                            "uploads/employeedetails/" . $_FILES["files"]["name"][$i]
                        );
                        $images[] = $_FILES["files"]["name"][$i];
                    }
                }
                $old_images = isset($_POST['old_image']) ? $_POST['old_image'] : [];
                $all_images = array_merge($old_images, $images);
                $insertImages = implode(", ", $all_images);
            } else {
                echo "No files uploaded or invalid file structure.";
            }






            if ($_FILES["profile_image"]["name"]) {
                $config["upload_path"]   = "uploads/profile";
                $config["allowed_types"] = "gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG";
                $config["encrypt_name"]  = true;
                $config["max_size"]      = 2048;
                $this->load->library("upload", $config);
                if (!$this->upload->do_upload("profile_image")) {
                    $error = ["error" => $this->upload->display_errors()];
                    redirect(base_url("Chrm"));
                } else {
                    $data                     = $this->upload->data();
                    $profile_image            = $data["file_name"];
                    $config["image_library"]  = "gd2";
                    $config["source_image"]   = $profile_image;
                    $config["create_thumb"]   = false;
                    $config["maintain_ratio"] = true;
                    $config["width"]          = 200;
                    $config["height"]         = 200;
                    $this->load->library("image_lib", $config);
                    $this->image_lib->resize();
                    $profile_image = $profile_image;
                }
            }
            $headname =
            $this->input->post("employee_id", true) .
            "-" .
            $this->input->post("old_first_name", true) .
            "" .
            $this->input->post("old_middle_name", true) .
            "" .
            $this->input->post("old_last_name", true);
            $emp_data = [
                "id"            => $this->input->post("employee_id", true),
                "employee_type" => $this->input->post("employee_type", true),
            ];
            $pay_data = [
                "id"           => $this->input->post("employee_id", true),
                "payroll_type" => $this->input->post("payroll_type", true),
            ];
            $state_tax                 = $this->input->post("state_tax");
            $living_state_tax          = $this->input->post("living_state_tax");
            $data_employee["state_tx"] = $state_tax;
            if ($state_tax != $living_state_tax) {
                $data_employee["living_state_tax"] = $living_state_tax;
            }
            $city_tax                   = $this->input->post("city_tax");
            $living_city_tax            = $this->input->post("living_city_tax");
            $data_employee["local_tax"] = $city_tax;
            if ($city_tax != $living_city_tax) {
                $data_employee["living_local_tax"] = $living_city_tax;
            }
            $county_tax               = $this->input->post("county_tax");
            $living_county_tax        = $this->input->post("living_county_tax");
            $data_employee["cty_tax"] = $county_tax;
            if ($county_tax != $living_county_tax) {
                $data_employee["living_county_tax"] = $living_county_tax;
            }
            $other_working_tax            = $this->input->post("other_working_tax");
            $other_living_tax             = $this->input->post("other_living_tax");
            $data_employee["state_tax_1"] = $other_working_tax;
            if ($other_working_tax != $other_living_tax) {
                $data_employee["state_tax_2"] = $other_living_tax;
            }
            $data_employee["edit_working_state"]  = $state_tax;
            $data_employee["edit_living_state"]   = $living_state_tax;
            $city_tax                             = $this->input->post("city_tax");
            $living_city_tax                      = $this->input->post("living_city_tax");
            $data_employee["edit_working_city"]   = $city_tax;
            $data_employee["edit_living_city"]    = $living_city_tax;
            $county_tax                           = $this->input->post("county_tax");
            $living_county_tax                    = $this->input->post("living_county_tax");
            $data_employee["edit_working_county"] = $county_tax;
            $data_employee["edit_living_county"]  = $living_county_tax;
            $other_working_tax                    = $this->input->post("other_working_tax");
            $other_living_tax                     = $this->input->post("other_living_tax");
            $data_employee["edit_working_other"]  = $other_working_tax;
            $data_employee["edit_living_other"]   = $other_living_tax;
            $postData                             = [
                "id"                     => $this->input->post("employee_id", true),
                "first_name"             => $this->input->post("first_name", true),
                "middle_name"            => $this->input->post("middle_name", true),
                "last_name"              => $this->input->post("last_name", true),
                "designation"            => $this->input->post("designation", true),
                "phone"                  => $this->input->post("phone", true),
                "files" => !empty($insertImages) ? $insertImages: $this->input->post("old_image", true),
                "rate_type"              => $this->input->post("paytype", true),
                "sc"                     => $this->input->post("sc", true),
                "email"                  => $this->input->post("email", true),
                "employee_tax"           => $this->input->post("emp_tax_detail", true),
                "social_security_number" => $this->input->post("ssn", true),
                "routing_number"         => $this->input->post("routing_number", true),
                "hrate"                  => $this->input->post("hrate", true),
                "address_line_1"         => $this->input->post("address_line_1", true),
                "address_line_2"         => $this->input->post("address_line_2", true),
                "country"                => $this->input->post("country", true),
                "city"                   => $this->input->post("city", true),
                "zip"                    => $this->input->post("zip", true),
                "state"                  => $this->input->post("state", true),
                "emergencycontact"       => $this->input->post("emergencycontact", true),
                "emergencycontactnum"    => $this->input->post(
                    "emergencycontactnum",
                    true
                ),
                "profile_image"          => !empty($profile_image) ? $profile_image : $this->input->post("old_profileimage", true),
                "payroll_type"           => $this->input->post("payroll_type"),
            ];


            $result = $this->Hrm_model->update_employee($postData, $headname, $emp_data, $pay_data);
            if ($result) {
                $response['status'] = 'success';
                $response['msg']    = 'Employee has been updated successfully';
            } else {
                $response['status'] = 'failure';
                $response['msg']    = 'Failed to update Employee. Please try again.';
            }
        }
        echo json_encode($response);
    }




    public function form1099nec() {
        $CI = &get_instance();
        $this->load->model("Hrm_model");
        $data = array(
            'title' => '1099 NECForm',
        );
        $content = $CI->parser->parse("hr/1099necform", $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function w4form() {
        $employee_id = isset($_GET['employee']) ? $_GET['employee'] : null;
        $encodedId   = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId   = decodeBase64UrlParameter($encodedId);
        $CI          = &get_instance();
        $this->load->model("Hrm_model");
        $company_name = $this->Hrm_model->getcompany_datainfo($decodedId);
        $data         = array(
            'title'  => 'w4form',
            'c_name' => $company_name,
        );
        $content = $CI->parser->parse("hr/w4_form", $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function w9form() {
        $CI = &get_instance();
        $this->load->model("Hrm_model");
        $data = array(
            'title' => 'w9form',
        );
        $content = $CI->parser->parse("hr/w9_form", $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function create_employee() {
        $this->load->model('Hrm_model');
        $this->form_validation->set_rules('first_name', display('first_name'), 'required|max_length[100]');
        $this->form_validation->set_rules('last_name', display('last_name'), 'required|max_length[100]');
        $this->form_validation->set_rules('designation', display('designation'), 'required|max_length[100]');
        $this->form_validation->set_rules('phone', display('phone'), 'max_length[20]');
        $this->form_validation->set_rules('employee_type', 'Employee Type', 'required');
        $this->form_validation->set_rules('emp_tax_detail', 'Employee Tax Detail', 'required');
        $this->form_validation->set_rules('in_department', 'In Department', 'required');
        if ($this->form_validation->run()) {
            if ($_FILES['image']['name']) {
                $config['upload_path']   = 'assets/images/employee/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']      = "*";
                $config['max_width']     = "*";
                $config['max_height']    = "*";
                $config['encrypt_name']  = TRUE;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('image')) {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                } else {
                    $image     = $this->upload->data();
                    $image_url = base_url() . "assets/images/employee/" . $image['file_name'];
                }
            }
            $postData = [
                'first_name'             => $this->input->post('first_name', true),
                'last_name'              => $this->input->post('last_name', true),
                'designation'            => $this->input->post('designation', true),
                'phone'                  => $this->input->post('phone', true),
                'files'                  => $image_url,
                'rate_type'              => $this->input->post('rate_type', true),
                'payroll_type'           => $this->input->post('payroll_type', true),
                'cty_tax'                => $this->input->post('citytx', true),
                'email'                  => $this->input->post('email', true),
                'hrate'                  => $this->input->post('hrate', true),
                'address_line_1'         => $this->input->post('address_line_1', true),
                'address_line_2'         => $this->input->post('address_line_2', true),
                'state_local_tax'        => $this->input->post('state_local_tax', true),
                'local_tax'              => $this->input->post('local_tax', true),
                'state_tx'               => $this->input->post('state_tx', true),
                'social_security_number' => $this->input->post('social_security_number', true),
                'routing_number'         => $this->input->post('routing_number', true),
                'country'                => $this->input->post('country', true),
                'city'                   => $this->input->post('city', true),
                'zip'                    => $this->input->post('zip', true),
            ];
            if ($this->Hrm_model->create_employee($postData)) {
                $this->session->set_flashdata('message', display('save_successfully'));
                redirect("Chrm/manage_employee");
            } else {
                $this->session->set_flashdata('error_message', display('please_try_again'));
                redirect("Chrm/manage_employee");
            }
        } else {
            echo validation_errors();
        }
    }
    //W2FORM  - hr
    public function w2Form($id = null, $decodedId) {
        if ($id) {
        }
        $employee_ids       = $this->input->post('employee_ids');
        $currency_details   = $this->Web_settings->retrieve_setting_editdata($decodedId);
        $curn_info_default  = $this->Hrm_model->curn_info_default($currency_details[0]['currency'], $decodedId);
        $employee_details   = $this->Hrm_model->employeeDetailsdata($id, $decodedId);
        $data['get_cdata']  = $this->Hrm_model->get_employer_federaltax($decodedId);
        $get_cominfo        = $this->Hrm_model->get_company_info($decodedId);
        $fed_tax            = $this->Hrm_model->getoveralltaxdata($id, $decodedId);
        $get_payslip_info   = $this->Hrm_model->w2get_payslip_info($id, $decodedId);
        $state_taxtype      = $this->Hrm_model->tax_statecode_info($id, $decodedId);
        $other_tx1          = $this->Hrm_model->getother_tax($id, $decodedId);
        $get_payslipalldata = $this->Hrm_model->w2get_payslip_alldata($id, $decodedId);
        $state_tax          = $this->Hrm_model->w2total_state_tax($id, $decodedId);
        $state_taxworking   = $this->Hrm_model->w2totalstatetaxworking($id, $decodedId);
        $county_tax         = $this->Hrm_model->getcounty_tax($id, $decodedId);
        $local_tax          = $this->Hrm_model->w2total_local_tax($id, $decodedId);
        $livinglocaldata    = $this->Hrm_model->w2total_livinglocaldata($id, $decodedId);
        $gettaxother_info   = $this->Hrm_model->gettaxother_info($id, $decodedId);
        $company_details    = $this->Hrm_model->company_details($id, $decodedId);
        $data               = array(
            'title'             => 'W2 Form',
            'getlocation'       => $get_cominfo,
            'gettaxdata'        => $fed_tax,
            'curn_info_default' => $curn_info_default[0]['currency_name'],
            'currency'          => $currency_details[0]['currency'],
            'other_tx'          => $other_tx1,
            'countyTax'         => $county_tax,
            'stateTax'          => $state_tax,
            'e_details'         => $employee_details,
            'stateworkingtax'   => $state_taxworking,
            'localTax'          => $local_tax,
            'StatetaxType'      => $state_taxtype,
            'c_details'         => $company_details,
            'get_payslip_info'  => $get_payslip_info,
            'livinglocaldata'   => $livinglocaldata,
            'gettaxother_info'  => $gettaxother_info,
        );
        $content = $this->parser->parse('hr/w2_taxform', $data, true);
        $this->template->full_admin_html_view($content);
    }
    //w3form -hr
    public function formw3Form() {
        $encodedId               = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId               = decodeBase64UrlParameter($encodedId);
        $get_cominfo             = $this->Hrm_model->get_company_info($decodedId);
        $get_payslip_info        = $this->Hrm_model->get_payslip_info($decodedId);
        $total_state_tax         = $this->Hrm_model->total_state_tax($decodedId);
        $get_sc_info             = $this->Hrm_model->get_sc_info($decodedId);
        $sum_of_weekly_array     = $this->Hrm_model->sum_of_weekly($decodedId);
        $sum_of_hourly_array     = $this->Hrm_model->sum_of_hourly($decodedId);
        $sum_of_biweekly_array   = $this->Hrm_model->sum_of_biweekly($decodedId);
        $sum_of_monthly_array    = $this->Hrm_model->sum_of_monthly($decodedId);
        $sum_of_weekly           = !empty($sum_of_weekly_array) ? $sum_of_weekly_array[0]['weekly'] : 0;
        $sum_of_hourly           = !empty($sum_of_hourly_array) ? $sum_of_hourly_array[0]['amount'] : 0;
        $sum_of_biweekly         = !empty($sum_of_biweekly_array) ? $sum_of_biweekly_array[0]['biweekly'] : 0;
        $sum_of_monthly          = !empty($sum_of_monthly_array) ? $sum_of_monthly_array[0]['monthly'] : 0;
        $total_sum               = $sum_of_weekly + $sum_of_hourly + $sum_of_biweekly + $sum_of_monthly;
        $total_local_tax         = $this->Hrm_model->total_local_tax($decodedId);
        $employeer_details       = $this->Hrm_model->employeerDetailsdata($decodedId);
        $get_employer_federaltax = $this->Hrm_model->get_employer_federaltax($decodedId);
        $get_total_customersData = $this->Hrm_model->get_total_customersData($decodedId);
        $data                    = array(
            'title'                   => 'W3 Form',
            'get_cominfo'             => $get_cominfo,
            'get_payslip_info'        => $get_payslip_info,
            'employeer'               => $employeer_details,
            'total_state_tax'         => $total_sum,
            'total_local_tax'         => $total_local_tax,
            'get_employer_federaltax' => $get_employer_federaltax,
            'get_total_customersData' => $get_total_customersData,
            'get_sc_info'             => $get_sc_info,
        );
        $content = $this->parser->parse('hr/w3_taxform', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function sc_cnt() {
        $CI =  & get_instance();
        $this->load->model('Hrm_model');
        $employeeId  = $this->input->post('employeeId', TRUE);
        $reportrange = $this->input->post('reportrange', TRUE);
        $data['sc']  = $this->Hrm_model->sc_info_count($employeeId, $reportrange , $decodedId);
        echo json_encode($data['sc']);
    }
    //F940 -hr
    public function form940Form() {
        $encodedId                 = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId                 = decodeBase64UrlParameter($encodedId);
        $data['get_cominfo']       = $this->Hrm_model->get_company_info($decodedId);
        $data['get_cdata']         = $this->Hrm_model->get_employer_federaltax($decodedId);
        $data['get_sc_info']       = $this->Hrm_model->get_sc_info($decodedId);
        $data['get_paytotal']      = $this->Hrm_model->get_paytotal($decodedId);
        $data['get_userlist']      = $this->Hrm_model->get_userlist($decodedId);
        $data['amountGreaterThan'] = $this->Hrm_model->f940_excess_emp($decodedId);
        $totalAmount               = 0;
        if ($data['amountGreaterThan']) {
            foreach ($data['amountGreaterThan'] as $row) {
                $totalAmount += $row['totalAmount'];
            }
            $value = $totalAmount / 2;
            if (!empty($value)) {
                $final_amount = $value - 7000;
            } else {
                $final_amount = 0;
            }
            if (!empty($final_amount)) {
                $totalAmount = $final_amount;
            }
        }
        $data = array(
            'title'             => '940 Form',
            'get_cominfo'       => $data['get_cominfo'],
            'get_cdata'         => $data['get_cdata'],
            'get_paytotal'      => $data['get_paytotal'],
            'get_userlist'      => $data['get_userlist'],
            'amountGreaterThan' => $data['amountGreaterThan'],
            'get_sc_info'       => $data['get_sc_info'],
            'amt'               => $totalAmount,
        );
        $content = $this->parser->parse('hr/f940', $data, true);
        $this->template->full_admin_html_view($content);
    }
    //F941 - hr
    public function form941Form($selectedValue = null, $decodedId) {
        $data['get_cdata']   = $this->Hrm_model->get_employer_federaltax($decodedId);
        $data['get_cominfo'] = $this->Hrm_model->get_company_info($decodedId);
        $data['fed_tax']     = $this->Hrm_model->social_tax($decodedId);
        $data['tat']         = $this->Hrm_model->so_total_amount($selectedValue, $decodedId);
        $total               = 0;
        foreach ($data['tat'] as $item) {
            $total += $item['tamount'];
        }
        $data['tamount']         = $total;
        $data['get_userlist']    = $this->Hrm_model->get_userlist($decodedId);
        $data['tif']             = $this->Hrm_model->get_taxinfomation($selectedValue, $decodedId);
        $data['get_941_sc_info'] = $this->Hrm_model->get_941_sc_info($selectedValue, $decodedId);
        $data['gt']              = $this->Hrm_model->get_gtinfo($selectedValue, $decodedId);
        $view_data               = array(
            'title'           => '941 Form',
            'tamount'         => $data['tamount'],
            'get_cdata'       => $data['get_cdata'],
            'get_cominfo'     => $data['get_cominfo'],
            'tif'             => $data['tif'],
            'get_userlist'    => $data['get_userlist'],
            'gt'              => $data['gt'],
            'get_941_sc_info' => $data['get_941_sc_info'],
            'selectedValue'   => $selectedValue,
        );
        $content = $this->parser->parse('hr/f941', $view_data, true);
        $this->template->full_admin_html_view($content);
    }
    //F944 - hr
    public function form942Form() {
        $encodedId                = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId                = decodeBase64UrlParameter($encodedId);
        $data['get_cdata']        = $this->Hrm_model->get_employer_federaltax($decodedId);
        $data['get_cominfo']      = $this->Hrm_model->get_company_info($decodedId);
        $data['tif']              = $this->Hrm_model->get_taxinfomation_old($decodedId);
        $data['get_userlist']     = $this->Hrm_model->get_userlist($decodedId);
        $data['fed_tax']          = $this->Hrm_model->social_tax($decodedId);
        $data['get_payslip_info'] = $this->Hrm_model->get_payslip_info($decodedId);
        $currency_details         = $this->Web_settings->retrieve_setting_editdata($decodedId);
        $curn_info_default        = $this->Hrm_model->curn_info_default($currency_details[0]['currency'], $decodedId);
        $data['currency']         = $currency_details[0]['currency'];
        $content                  = $this->parser->parse('hr/f942', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function manage_workinghours() {
        $CI = &get_instance();
        $CI->load->model("Web_settings");
        $this->load->model("Hrm_model");
        $w_hourdata = $this->db->select('*')->from('working_time')->where('created_by', $this->session->userdata('user_id'))->get()->result_array();
        $data       = array(
            'title'  => 'Manage Working Hours',
            'w_data' => $w_hourdata,
        );
        $content = $this->parser->parse("hr/workinghour_list", $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function working_hours() {
        $CI = &get_instance();
        $this->load->model("Hrm_model");
        $data = array(
            'title' => 'Working Hours',
        );
        $content = $CI->parser->parse("hr/setworking_hours", $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function insertworking_hours() {
        $hour_rate   = $this->input->post('work_hour');
        $exhour_rate = $this->input->post('extra_workamount');
        $data        = array(
            'work_hour'        => $hour_rate,
            'extra_workamount' => $exhour_rate,
            'created_by'       => $this->session->userdata('user_id'),
        );
        $this->db->insert("working_time", $data);
        $this->session->set_flashdata("message", display("save_successfully"));
        redirect(base_url("Chrm/working_hours"));
    }

    
    public function getPayslipDatas() {
        $encodedId      = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId      = decodeBase64UrlParameter($encodedId);
        $limit          = $this->input->post('length');
        $start          = $this->input->post('start');
        $search         = $this->input->post('search')['value'];
        $orderField     = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
        $orderDirection = $this->input->post('order')[0]['dir'];
        $totalItems     = $this->Hrm_model->getTotalPayslip($search, $decodedId);
        $items          = $this->Hrm_model->getPaginatedPayslip($limit, $start, $orderField, $orderDirection, $search, $decodedId);
        $data           = [];
        $i              = $start + 1;
        foreach ($items as $item) {
            $payslip = '<a href="' . base_url('Chrm/time_list?id=' . $encodedId . '&timesheetid=' . trim($item['timesheet_id'])) . '&name=' . trim($item['templ_name']) . '" class="btnclr btn m-b-5 m-r-2"     ><i class="fa fa-window-restore"  aria-hidden="true"></i></a>';
            $row     = [
                "id"              => $i,
                "first_name"      => $item['first_name'] . ' ' . $item['middle_name'] . ' ' . $item['last_name'],
                "job_title"       => $item['job_title'],
                "month"           => $item['month'],
                "total_hours"     => $item['total_hours'],
                "total"           => (!empty($item['extra_this_hour']))
                ? $item['above_extra_sum'] + $item['extra_thisrate']
                : $item['above_extra_sum'] + 0,
                "extra_this_hour" => $item['extra_this_hour'] + 0,
                "sales_c_amount"  => $item['sales_c_amount'] + 0,
                'action'          => $payslip,
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
}
