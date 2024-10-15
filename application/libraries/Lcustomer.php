<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Lcustomer {
    public function customer_search_item($customer_id) {
        $CI = &get_instance();
        $CI->load->model('Customers');
        $CI->load->model('Web_settings');
        $customers_list    = $CI->Customers->customer_search_item($customer_id);
        $all_customer_list = $CI->Customers->all_customer_list();
        $i                 = 0;
        $total             = 0;
        if ($customers_list) {
            foreach ($customers_list as $k => $v) {
                $i++;
                $customers_list[$k]['sl'] = $i;
                $total += $customers_list[$k]['customer_balance'];
            }
            $currency_details = $CI->Web_settings->retrieve_setting_editdata();
            $data             = array(
                'title'             => display('manage_customer'),
                'subtotal'          => number_format($total, 2, '.', ','),
                'all_customer_list' => $all_customer_list,
                'links'             => "",
                'pagenum'           => "",
                'customers_list'    => $customers_list,
                'currency'          => $currency_details[0]['currency'],
                'position'          => $currency_details[0]['currency_position'],
            );
            $customerList = $CI->parser->parse('customer/customer', $data, true);
            return $customerList;
        } else {
            redirect('Ccustomer/manage_customer');
        }
    }



    
    public function customer_add_form($encoded_adminId) {
        $CI = &get_instance();
        $CI->load->model('Customers');
        $CI->load->model('Web_settings');
        $setting_detail      = $CI->Web_settings->retrieve_setting_editdata();
        $currency_table      = $CI->Web_settings->getCurrencyDetails();
        $paymentterms_detail = $CI->Customers->get_payment_terms();
        $customertype_detail = $CI->Customers->get_customer_type();
        $state_detail        = $CI->Web_settings->getStateDetails();
        $data                = array(
            'title'               => display('add_customer'),
            'payment_terms'       => $paymentterms_detail,
            'customertype_detail' => $customertype_detail,
            'setting_detail'      => $setting_detail,
            'admin_id'            => $encoded_adminId,
            'currency_table'      => $currency_table,
            'states'              => $state_detail,
        );
        $customerForm = $CI->parser->parse('customer/add_customer_form', $data, true);
        return $customerForm;
    }


    public function insert_customer($data) {
        $CI = &get_instance();
        $CI->load->model('Customers');
        $CI->Customers->customer_entry($data);
        return true;
    }
    public function customer_edit_data() {
  
        $customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : null;
   
   
    $CI = &get_instance();
        $CI->load->model('Customers');
        $CI->load->model('Web_settings');
        $currency_table      = $CI->Web_settings->getCurrencyDetails();
        $state_detail        = $CI->Web_settings->getStateDetails();
        $customer_detail = $CI->Customers->retrieve_customer_editdata($customer_id);
        $setting_detail  = $CI->Web_settings->retrieve_setting_editdata();
        $data            = array(
            'title'            => display('customer_edit'),
            'customer_id'      => $customer_detail[0]['customer_id'],
            'company_name'     => $customer_detail[0]['customer_name'],
            'customer_type'    => $customer_detail[0]['customer_type'],
            'billing_address' => $customer_detail[0]['billing_address'],
            'shipping_address'         => $customer_detail[0]['shipping_address'],
            'customer_mobile'  => $customer_detail[0]['customer_mobile'],
            'bussiness_phone'            => $customer_detail[0]['bussiness_phone'],
            'fax'              => $customer_detail[0]['fax'],
            'contact_person'          => $customer_detail[0]['contact_person'],
            'city'             => $customer_detail[0]['city'],
            'tax_status'       => $customer_detail[0]['tax_status'],
            'credit_limit'     => $customer_detail[0]['credit_limit'],
            'state'            => $customer_detail[0]['state'],
            'zip'              => $customer_detail[0]['zip'],
            'country'          => $customer_detail[0]['country'],
            'primary_email'   => $customer_detail[0]['primary_email'],
            'secondary_email'    => $customer_detail[0]['secondary_email'],
            'status'           => $customer_detail[0]['status'],
            'payment'          => $customer_detail[0]['payment_terms'],
            'sales_tax'        => $customer_detail[0]['sales_tax'],
            'tax_percent'      => $customer_detail[0]['tax_percent'],
            'currency_type'    => $customer_detail[0]['currency_type'],
            'previous_balance' => $customer_detail[0]['credit_limit'],
            'open_balance'     => $customer_detail[0]['open_balance'],
            'setting_detail'   => $setting_detail,
            'admin_id'         => isset($_GET['admin']) ? $_GET['admin'] : null,
            'currency_table'      => $currency_table,
            'states'              => $state_detail,
            'company_id'         => isset($_GET['id']) ? $_GET['id'] : null,
        );
        $chapterList = $CI->parser->parse('customer/edit_customer_form', $data, true);
        return $chapterList;
    }
}