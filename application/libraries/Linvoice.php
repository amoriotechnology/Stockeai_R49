<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Linvoice {

public function dataCart()
     {
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $customer_details = $CI->Invoices->pos_customer_setup();
        $dataFetch = $CI->Invoices->cart_items();
        $paytype=$CI->Invoices->payment_type();
        $prodt = $CI->db->select('product_name,product_model,p_quantity')->from('product_information')->get()->result_array();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
        $taxfield1 = $CI->db->select('tax_id,tax')->from('tax_information')->get()->result_array();
        $taxfield = $CI->db->select('tax_name,default_value')->from('tax_settings')->get()->result_array();
        $product_name= $CI->db->select('product_name,product_model')->from('product_information')->where('product_id',
        $dataFetch[0]['product_id'])->get()->result_array();
        $data = array(
           'title' => display('Cart'),
           'addcart_details' => $dataFetch,
           'product' =>$prodt,
           'product_name' =>$product_name[0]['product_name'].'-'.$product_name[0]['product_model'],
           'taxes' => $taxfield,
           'tax'   => $taxfield1,
           'curn_info_default' =>$curn_info_default[0]['currency_name'],
           'currency'  =>$currency_details[0]['currency'],
           'customer_details'   => $customer_details,
           'payment_typ'  =>$paytype,
           'customer' => $CI->Invoices->profarma_invoice_customer(),
        );
        if($dataFetch[0]['radio_action']=='invoice'){
        $cartdataList = $CI->parser->parse('invoice/cart_invoice_form', $data, true);
        return $cartdataList;
        }else{
        $cartdataList = $CI->parser->parse('invoice/cart_quotation_form', $data, true);
        return $cartdataList;
        }
     }
    // add cart items
    public function add_cartitems()
    {
        $CI = & get_instance();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
       
        $data = array(
            'title' => display('View cart'),
            'currency' =>   $currency_details
        );
        $cartList = $CI->parser->parse('invoice/addcart_details', $data, true);
        return $cartList;
    }


 


     public function ocean_export_tracking_invoice_list() {
     

        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $company_info = $CI->Invoices->retrieve_company();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $ocean_exports = $CI->Invoices->getOceanExportsdata();
        $data = array(
            'title'         => 'Manage Ocean Export Invoices',
            'total_invoice' => $CI->Invoices->count_invoice(),
            'currency'      => $currency_details[0]['currency'],
            'company_info'  => $company_info,
            'ocean_exports' => $ocean_exports
        );
        $invoiceList = $CI->parser->parse('invoice/ocean_export_tracking_invoice_list', $data, true);
        return $invoiceList;
    }


         //ocean import tracking Edit Data

         public function ocean_export_tracking_edit_data($purchase_id) {

            $CI = & get_instance();
    
           $CI->load->model('Invoices');
    
            $CI->load->model('Suppliers');
    
            $CI->load->model('Web_settings');
    
            $bank_list       = $CI->Web_settings->bank_list();
    
            $purchase_detail = $CI->Invoices->retrieve_ocean_export_tracking_editdata($purchase_id);
            
            $view_attachments = $CI->Invoices->editMultiplefiles($purchase_detail[0]['booking_no']);
    
            $customer_name = $CI->db->select('*')->from('customer_information')->where('customer_id', $purchase_detail[0]['consignee'])->get()->result_array();
    
    
            $supplier_id = $purchase_detail[0]['supplier_id'];
    
            $supplier_name = $purchase_detail[0]['supplier_name'];
    
            $supplier_list = $CI->Suppliers->supplier_list("110", "0");

            $supplier_selected = $CI->Suppliers->supplier_search_item($supplier_id);
    
    
    
            if (!empty($purchase_detail)) {
    
                $i = 0;
    
                foreach ($purchase_detail as $k => $v) {
    
                    $i++;
    
                    $purchase_detail[$k]['sl'] = $i;
    
                }
    
            }
    
        $setting_detail = $CI->Web_settings->retrieve_setting_editdata();

    
            $currency_details = $CI->Web_settings->retrieve_setting_editdata();
            $customer=  $CI->Invoices->profarma_invoice_customer();
            $data = array(
    
                'title'         => 'Edit Ocean Import Tracking Invoice',
           'customs_broker_name' => $purchase_detail[0]['customs_broker_name'],
                'mbl_no' => $purchase_detail[0]['mbl_no'],
                'hbl_no'  => $purchase_detail[0]['hbl_no'],
                'obl_no' => $purchase_detail[0]['obl_no'],
                'ams_no' => $purchase_detail[0]['ams_no'],
                'isf_no'  => $purchase_detail[0]['isf_no'],
                'ocean_export_tracking_id'   => $purchase_detail[0]['ocean_export_tracking_id'],
    
                'booking_no'     => $purchase_detail[0]['booking_no'],
                'customer_name'  => $customer_name[0]['customer_name'],
                'customer_id'  => $customer_name[0]['customer_id'],
                'supplier_name' => $supplier_name,
                'supplier_list' =>$supplier_list,
    
                'supplier_id'   => $supplier_id,
    
                'container_no' => $purchase_detail[0]['container_no'],
    
                'seal_no'   => $purchase_detail[0]['seal_no'],
    
                'shipper' => $purchase_detail[0]['shipper'],
    
                'invoice_date' => $purchase_detail[0]['invoice_date'],
    
                'consignee' => $purchase_detail[0]['consignee'],
    
                'notify_party' => $purchase_detail[0]['notify_party'],
    
                'vessel' =>  $purchase_detail[0]['vessel'],
    
                'voyage_no' =>  $purchase_detail[0]['voyage_no'],
    
                'port_of_loading' =>  $purchase_detail[0]['port_of_loading'],
    
                'port_of_discharge' => $purchase_detail[0]['port_of_discharge'],
    
                'place_of_delivery' => $purchase_detail[0]['place_of_delivery'],
    
                'freight_forwarder'  => $purchase_detail[0]['freight_forwarder'],
    
                'particular' => $purchase_detail[0]['particular'],
    
                'attachment' => $purchase_detail[0]['attachment'],
    
                'status'  => $purchase_detail[0]['status'],
                'customer' =>$customer,
                'view_attachments' => $view_attachments,
                           'setting_detail' => $setting_detail

    
            );
    
    
    
            $chapterList = $CI->parser->parse('invoice/edit_ocean_export_tracking_form', $data, true);
    
            return $chapterList;
    
        }

    
public function ocean_export_tracking_details_data_print($purchase_id) {
            $CI = & get_instance();
            $CI->load->model('Invoices');
            $CI->load->model('Web_settings');
               $CI->load->model('invoice_content');
            $CI->load->library('occational');
             $w = & get_instance();



        $w->load->model('Ppurchases');
        $company_info = $w->Ppurchases->retrieve_company();
            $purchase_detail = $CI->Invoices->ocean_export_tracking_details_data($purchase_id);
            if (!empty($purchase_detail)) {
                $i = 0;
                foreach ($purchase_detail as $k => $v) {
                    $i++;
                    $purchase_detail[$k]['sl'] = $i;
                }
                foreach ($purchase_detail as $k => $v) {
                    $purchase_detail[$k]['convert_date'] = $CI->occational->dateConvert($purchase_detail[$k]['invoice_date']);
                }
            }
            $CII = & get_instance();
            $CII->load->model('invoice_design');
              $datacontent = $CI->invoice_content->retrieve_info_data();
            $currency_details = $CI->Web_settings->retrieve_setting_editdata();

            $dataw = $CII->invoice_design->retrieve_data();

            $setting=  $CI->Web_settings->retrieve_setting_editdata();

          
            $customer_name = $CI->db->select('*')->from('customer_information')->where('customer_id', $purchase_detail[0]['consignee'])->get()->result_array();
                     $setting=  $CI->Web_settings->retrieve_setting_editdata();

         
            $data = array(
                'header'=> $dataw[0]['header'],
              'logo'=>(!empty($setting[0]['invoice_logo'])?$setting[0]['invoice_logo']:$company_info[0]['logo']),  
                'color'=> $dataw[0]['color'],
                'template'=> $dataw[0]['template'],
            'title'            => 'Ocean Export Tracking Invoice Detail',
            'ocean_import_tracking_id'      => $purchase_detail[0]['ocean_export_tracking_id'],
                'booking_no' => $purchase_detail[0]['booking_no'],
              'customer_name'  => $customer_name[0]['customer_name'],
                'supplier'    => $purchase_detail[0]['supplier_name'],
                'container_no'    => $purchase_detail[0]['container_no'],
                    

          'company'=>(!empty($datacontent[0]['company_name'])?$datacontent[0]['company_name']:$company_info[0]['company_name']),   
            'phone'=>(!empty($datacontent[0]['mobile'])?$datacontent[0]['mobile']:$company_info[0]['mobile']),   
            'email'=>(!empty($datacontent[0]['email'])?$datacontent[0]['email']:$company_info[0]['email']),   
            'reg_number'=>(!empty($datacontent[0]['reg_number'])?$datacontent[0]['reg_number']:$company_info[0]['reg_number']),  
            'website'=>(!empty($datacontent[0]['website'])?$datacontent[0]['website']:$company_info[0]['website']),   
            'address'=>(!empty($datacontent[0]['address'])?$datacontent[0]['address']:$company_info[0]['address']),  
                'seal_no'       => $purchase_detail[0]['seal_no'],
                'etd' => $purchase_detail[0]['etd'],
                'eta' => $purchase_detail[0]['eta'],
                'supplier_id' => $purchase_detail[0]['supplier_id'],
                'supplier_name' => $purchase_detail[0]['supplier_name'],
                'shipper' => $purchase_detail[0]['shipper'],
                'invoice_date' => $purchase_detail[0]['invoice_date'],
                'consignee' => $purchase_detail[0]['consignee'],
                'notify_party' => $purchase_detail[0]['notify_party'],
                'vessel' => $purchase_detail[0]['vessel'],
                'voyage_no' => $purchase_detail[0]['voyage_no'],
                'port_of_loading' => $purchase_detail[0]['port_of_loading'],
                'port_of_discharge' => $purchase_detail[0]['port_of_discharge'],
                'place_of_delivery' => $purchase_detail[0]['place_of_delivery'],
                'freight_forwarder' => $purchase_detail[0]['freight_forwarder'],
                'particular' => $purchase_detail[0]['particular'],
                'attachment' => $purchase_detail[0]['attachment'],
                'customs_broker_name' => $purchase_detail[0]['customs_broker_name'],
                'mbl_no' => $purchase_detail[0]['mbl_no'],
                'hbl_no'  => $purchase_detail[0]['hbl_no'],
                'obl_no' => $purchase_detail[0]['obl_no'],
                'ams_no' => $purchase_detail[0]['ams_no'],
                'isf_no'  => $purchase_detail[0]['isf_no'],
                'status' => $purchase_detail[0]['status'],
                'create_by' => $purchase_detail[0]['create_by'],
                // 'sub_total_amount' => number_format($purchase_detail[0]['grand_total_amount'], 2, '.', ','),
            );
            $chapterList = $CI->parser->parse('invoice/ocean_export_invoice_print', $data, true);
            return $chapterList;
        }

    


   public function ocean_export_tracking_details_data($purchase_id) {
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $CI->load->model('invoice_content');
 $w = & get_instance();

        $w->load->model('Ppurchases');
        $company_info = $w->Ppurchases->retrieve_company();
        $purchase_detail = $CI->Invoices->ocean_export_tracking_details_data($purchase_id);
        if (!empty($purchase_detail)) {
            $i = 0;
            foreach ($purchase_detail as $k => $v) {
                $i++;
                $purchase_detail[$k]['sl'] = $i;
            }
            foreach ($purchase_detail as $k => $v) {
                $purchase_detail[$k]['convert_date'] = $CI->occational->dateConvert($purchase_detail[$k]['invoice_date']);
            }
        }
        $CII = & get_instance();
        $CII->load->model('invoice_design');
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $dataw = $CII->invoice_design->retrieve_data();

        $datacontent = $CI->invoice_content->retrieve_info_data();
        //  print_r($datacontent); die();
        $setting=  $CI->Web_settings->retrieve_setting_editdata();


    
        $customer_name = $CI->db->select('*')->from('customer_information')->where('customer_id', $purchase_detail[0]['consignee'])->get()->result_array();
        $data = array(
            'header'=> $dataw[0]['header'],
            'logo'=>(!empty($setting[0]['invoice_logo'])?$setting[0]['invoice_logo']:$company_info[0]['logo']),  
            'color'=> $dataw[0]['color'],
            'template'=> $dataw[0]['template'],
        'title'            => 'Ocean Export Tracking Invoice Detail',
        'ocean_import_tracking_id'      => $purchase_detail[0]['ocean_export_tracking_id'],
            'booking_no' => $purchase_detail[0]['booking_no'],
          'customer_name'  => $customer_name[0]['customer_name'],
            'supplier'    => $purchase_detail[0]['supplier_name'],
            'container_no'    => $purchase_detail[0]['container_no'],


         

 'business_name'=>(!empty($datacontent[0]['company_name'])?$datacontent[0]['company_name']:$company_info[0]['company_name']),   
            'phone'=>(!empty($datacontent[0]['mobile'])?$datacontent[0]['mobile']:$company_info[0]['mobile']),   
            'email'=>(!empty($datacontent[0]['email'])?$datacontent[0]['email']:$company_info[0]['email']),   
            'reg_number'=>(!empty($datacontent[0]['reg_number'])?$datacontent[0]['reg_number']:$company_info[0]['reg_number']),  
            'website'=>(!empty($datacontent[0]['website'])?$datacontent[0]['website']:$company_info[0]['website']),   
            'address'=>(!empty($datacontent[0]['address'])?$datacontent[0]['address']:$company_info[0]['address']),  




            'seal_no'       => $purchase_detail[0]['seal_no'],
            'etd' => $purchase_detail[0]['etd'],
            'eta' => $purchase_detail[0]['eta'],
            'supplier_id' => $purchase_detail[0]['supplier_id'],
            'supplier_name' => $purchase_detail[0]['supplier_name'],
            'shipper' => $purchase_detail[0]['shipper'],
            'invoice_date' => $purchase_detail[0]['invoice_date'],
            'consignee' => $purchase_detail[0]['consignee'],
            'notify_party' => $purchase_detail[0]['notify_party'],
            'vessel' => $purchase_detail[0]['vessel'],
            'voyage_no' => $purchase_detail[0]['voyage_no'],
            'port_of_loading' => $purchase_detail[0]['port_of_loading'],
            'port_of_discharge' => $purchase_detail[0]['port_of_discharge'],
            'place_of_delivery' => $purchase_detail[0]['place_of_delivery'],
            'freight_forwarder' => $purchase_detail[0]['freight_forwarder'],
            'particular' => $purchase_detail[0]['particular'],
            'attachment' => $purchase_detail[0]['attachment'],
            'customs_broker_name' => $purchase_detail[0]['customs_broker_name'],
            'mbl_no' => $purchase_detail[0]['mbl_no'],
            'hbl_no'  => $purchase_detail[0]['hbl_no'],
            'obl_no' => $purchase_detail[0]['obl_no'],
            'ams_no' => $purchase_detail[0]['ams_no'],
            'isf_no'  => $purchase_detail[0]['isf_no'],
            'status' => $purchase_detail[0]['status'],
            'create_by' => $purchase_detail[0]['create_by'],
            // 'sub_total_amount' => number_format($purchase_detail[0]['grand_total_amount'], 2, '.', ','),
        );

 
        $chapterList = $CI->parser->parse('invoice/ocean_export_invoice_html', $data, true);
        return $chapterList;
    }

    public function trucking_edit_data($purchase_id,$admin_id) {

        
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Suppliers');
        $CI->load->model('Ppurchases');
        $CI->load->model('Web_settings');
        $CI->load->model('Accounts_model');

        $purchase_detail = $CI->Invoices->retrieve_trucking_editdata($purchase_id,$admin_id);
        
        $trucking_data = $CI->Invoices->getTruckingeditdata($purchase_detail[0]['invoice_no'],$admin_id,'sales_tracking');
        //print_r($trucking_data); exit;
        $setting_detail = $CI->Web_settings->retrieve_setting_editdata($admin_id);

     
        $customer_id = $purchase_detail[0]['customer_id'];

        // $supplier_list = $CI->Suppliers->supplier_list("110", "0");

        // $supplier_selected = $CI->Suppliers->supplier_search_item($supplier_id);



        if (!empty($purchase_detail)) {

            $i = 0;

            foreach ($purchase_detail as $k => $v) {

                $i++;

                $purchase_detail[$k]['sl'] = $i;

            }

        }

        $currency_details = $CI->Web_settings->retrieve_setting_editdata($admin_id);
        $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
       $customer_name = $CI->db->select('*')->from('customer_information')->where('customer_id', $purchase_detail[0]['delivery_to'])->get()->result_array();
    
        $taxfield = $CI->db->select('tax_name,default_value')->from('tax_settings')->get()->result_array();
        $taxfield1 = $CI->db->select('tax_id,tax')
        ->from('tax_information')
        ->get()
        ->result_array();
        $get_customer  = $CI->Accounts_model->get_customer($admin_id);
        $all_supplier  = $CI->Ppurchases->select_all_supplier_trucker($admin_id);
        $pro_number    = $CI->Invoices->pro_number($admin_id);
        $company_info  = $CI->Ppurchases->retrieve_company($admin_id);
        $edit_tax      = $CI->Invoices->edit_Trucking_taxdata($admin_id);
        $supplier_data = $CI->Invoices->supplier_list($admin_id);
        $bank_list      = $CI->Web_settings->bank_list($admin_id);
        $data = array(
            'all_supplier'  => $all_supplier,
            'curn_info_default' =>$curn_info_default[0]['currency_name'],
            'currency'  =>$currency_details[0]['currency'],
            'delivery_to'   => $purchase_detail[0]['delivery_to'],
            'truck_no'   => $purchase_detail[0]['truck_no'],
            'delivery_time_from' =>$purchase_detail[0]['delivery_time_from'],
                'delivery_time_to' =>$purchase_detail[0]['delivery_time_to'],
            'title'         => 'Edit Trucking Invoice',
            'taxes'         => $taxfield,
            'tax'         => $taxfield1,
            'payment_id' =>  $purchase_detail[0]['payment_id'],
            'trucking_id'   => $purchase_detail[0]['trucking_id'],

            'invoice_no'     => $purchase_detail[0]['invoice_no'],
          
            'customer_name' => $purchase_detail[0]['customer_name'],
             
            'customer_id'   => $purchase_detail[0]['customer_id'],
            'bank_list'       => $bank_list,
            'bill_to'   => $purchase_detail[0]['bill_to'],

            'purchase_info' => $purchase_detail,

            'shipment_company'   => $purchase_detail[0]['shipment_company'],

            'container_pickup_date'   => $purchase_detail[0]['container_pickup_date'],

            'delivery_date'   => $purchase_detail[0]['delivery_date'],

            'total'         => number_format($purchase_detail[0]['grand_total_amount'] + (!empty($purchase_detail[0]['total_discount'])?$purchase_detail[0]['total_discount']:0),2),

            'customer_list' => $get_customer,
            'company_info' => $company_info,
            'invoice'  => $pro_number,
            'trucking_data' => $trucking_data,
            'edit_tax' => $edit_tax,
            'get_supplier' => $supplier_data,
           'setting_detail' => $setting_detail

        );
        $chapterList = $CI->parser->parse('sales/road_trans_edit', $data, true);

        return $chapterList;

    }
   
    
   
    public function trucking_details_data($purchase_id,$admin_id) {
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $purchase_detail = $CI->Invoices->trucking_details_data($purchase_id);
        if (!empty($purchase_detail)) {
            $i = 0;
            foreach ($purchase_detail as $k => $v) {
                $i++;
                $purchase_detail[$k]['sl'] = $i;
            }
            foreach ($purchase_detail as $k => $v) {
                $purchase_detail[$k]['convert_date'] = $CI->occational->dateConvert($purchase_detail[$k]['invoice_date']);
            }
        }

        $setting=  $CI->Web_settings->retrieve_setting_editdata();

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
              $customer_name = $CI->db->select('*')->from('customer_information')->where('customer_id', $purchase_detail[0]['delivery_to'])->get()->result_array();
        $CII = & get_instance();
        $CC = & get_instance();
        $w = & get_instance();
        $w->load->model('Ppurchases');
       $company_info = $w->Ppurchases->retrieve_company($admin_id);
       // print_r($company_info); die();
        $CII->load->model('invoice_design');
        $CC->load->model('invoice_content');
        $CI1 = & get_instance();
        $CI1->load->model('Purchases');
        $all_supplier = $CI1->Purchases->select_all_supplier($admin_id);
       $dataw = $CII->invoice_design->retrieve_data($admin_id);
        $setting_detail = $CI->Web_settings->retrieve_setting_editdata($admin_id);

       $datacontent = $CI->invoice_content->retrieve_data($admin_id);
        //   print_r($datacontent); die();


     $data = array(
            'curn_info_default'     => $curn_info_default[0]['currency_name'],
            'currency'              => $currency_details[0]['currency'],
            'header'                => $dataw[0]['header'],
            'logo'                  => (!empty($setting[0]['invoice_logo'])?$setting[0]['invoice_logo']:$company_info[0]['logo']),  
            'color'                 => $dataw[0]['color'],
            'template'              => $dataw[0]['template'],
            'all_supplier'          => $all_supplier,
            'add'                   => $company_info[0]['address'],
            'company'               => $company_info[0]['company_name'],
             'cname'                => (!empty($datacontent[0]['company_name'])?$datacontent[0]['company_name']:$company_info[0]['company_name']),   
            'phone'                 => (!empty($datacontent[0]['mobile'])?$datacontent[0]['mobile']:$company_info[0]['mobile']),   
            'email'                 => (!empty($datacontent[0]['email'])?$datacontent[0]['email']:$company_info[0]['email']),   
            'reg_number'            => (!empty($datacontent[0]['reg_number'])?$datacontent[0]['reg_number']:$company_info[0]['reg_number']),  
            'website'               =>  (!empty($datacontent[0]['website'])?$datacontent[0]['website']:$company_info[0]['website']),   
            'address'               => (!empty($datacontent[0]['address'])?$datacontent[0]['address']:$company_info[0]['address']),  
            'title'                 => display('purchase_details'),
            'trucking_id'           => $purchase_detail[0]['trucking_id'],
            'invoice_no'    =>  $purchase_detail[0]['invoice_no'],
            'invoice_date'  => $purchase_detail[0]['invoice_date'],
            'bill_to'       => $purchase_detail[0]['bill_to'],
            'shipment_company' => $purchase_detail[0]['shipment_company'],
            'container_pickup_date' => $purchase_detail[0]['container_pickup_date'],
            'delivery_date'     => $purchase_detail[0]['delivery_date'],
            'truckingdate'      => $purchase_detail[0]['trucking_date'],
            'delivery_to'       => $purchase_detail[0]['delivery_to'],
            'truck_no'          => $purchase_detail[0]['truck_no'],
            'delivery_time_from' =>$purchase_detail[0]['delivery_time_from'],
            'delivery_time_to'  =>$purchase_detail[0]['delivery_time_to'],
            'customer_name'     => $purchase_detail[0]['customer_name'],
            'customer_currency' => $purchase_detail[0]['currency_type'],
            'qty'               => $purchase_detail[0]['qty'],
            'description'       => $purchase_detail[0]['description'],
            'rate'              => $purchase_detail[0]['rate'],
           // 'pro_no_reference' => $purchase_detail[0]['pro_no_reference'],
            'total_amt'         =>  $purchase_detail[0]['total_amt'],
            'tax'               =>  $purchase_detail[0]['tax'],
            'grandtotal'        =>  $purchase_detail[0]['grand_total_amount'],
            'remarks'           =>  $purchase_detail[0]['remarks'],
            'purchase_all_data'=> $purchase_detail,
           // 'company_info'     => $company_info,
            'Web_settings'     => $currency_details,
            'setting_detail' => $setting_detail,
            'admin_id'       => $admin_id

        );

     /// print_r($dataw[0]['color']);

        // echo "<pre>";
        $chapterList = $CI->parser->parse('invoice/trucking_invoice_html', $data, true);
        return $chapterList;
    }

   public function trucking_details_data_print($purchase_id) {
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $purchase_detail = $CI->Invoices->trucking_details_data($purchase_id);
        if (!empty($purchase_detail)) {
            $i = 0;
            foreach ($purchase_detail as $k => $v) {
                $i++;
                $purchase_detail[$k]['sl'] = $i;
            }
            foreach ($purchase_detail as $k => $v) {
                $purchase_detail[$k]['convert_date'] = $CI->occational->dateConvert($purchase_detail[$k]['invoice_date']);
            }
        }
  $customer_name = $CI->db->select('*')->from('customer_information')->where('customer_id', $purchase_detail[0]['delivery_to'])->get()->result_array();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
        $CII = & get_instance();
        $CC = & get_instance();
        $w = & get_instance();
        $w->load->model('Ppurchases');
       $company_info = $w->Ppurchases->retrieve_company();
       // print_r($company_info); die();
        $CII->load->model('invoice_design');
        $CC->load->model('invoice_content');
        $CI1 = & get_instance();
        $CI1->load->model('Purchases');

        $setting=  $CI->Web_settings->retrieve_setting_editdata();
        $all_supplier = $CI1->Purchases->select_all_supplier();
       $dataw = $CII->invoice_design->retrieve_data();
       $datacontent = $CI->invoice_content->retrieve_data();
     $data = array(
        'curn_info_default' =>$curn_info_default[0]['currency_name'],
        'currency'  =>$currency_details[0]['currency'],
            'header'=> $dataw[0]['header'],
           'logo'=>(!empty($setting[0]['invoice_logo'])?$setting[0]['invoice_logo']:$company_info[0]['logo']),  
            'color'=> $dataw[0]['color'],
            'template'=> $dataw[0]['template'],
            'all_supplier' => $all_supplier,
            'add'=>$company_info[0]['address'],
            'company'=>$company_info[0]['company_name'],
            'cname'=>(!empty($datacontent[0]['company_name'])?$datacontent[0]['company_name']:$company_info[0]['company_name']),   
            'phone'=>(!empty($datacontent[0]['mobile'])?$datacontent[0]['mobile']:$company_info[0]['mobile']),   
            'email'=>(!empty($datacontent[0]['email'])?$datacontent[0]['email']:$company_info[0]['email']),   
            'reg_number'=>(!empty($datacontent[0]['reg_number'])?$datacontent[0]['reg_number']:$company_info[0]['reg_number']),  
            'website'=>(!empty($datacontent[0]['website'])?$datacontent[0]['website']:$company_info[0]['website']),   
            'address'=>(!empty($datacontent[0]['address'])?$datacontent[0]['address']:$company_info[0]['address']),  
            'title'            => display('purchase_details'),
            'trucking_id'      => $purchase_detail[0]['trucking_id'],
            'invoice_no' =>  $purchase_detail[0]['invoice_no'],
            'invoice_date' => $purchase_detail[0]['invoice_date'],
            'bill_to' => $purchase_detail[0]['bill_to'],
            'shipment_company' => $purchase_detail[0]['shipment_company'],
            'container_pickup_date' => $purchase_detail[0]['container_pickup_date'],
            'delivery_date' => $purchase_detail[0]['delivery_date'],
            'truckingdate' => $purchase_detail[0]['trucking_date'],
            'delivery_to'   => $purchase_detail[0]['delivery_to'],
            'truck_no'   => $purchase_detail[0]['truck_no'],
           'delivery_time_from' =>$purchase_detail[0]['delivery_time_from'],
       'delivery_time_to' =>$purchase_detail[0]['delivery_time_to'],
            'customer_name' => $purchase_detail[0]['customer_name'],
            'customer_currency' => $purchase_detail[0]['currency_type'],
            'qty' => $purchase_detail[0]['qty'],
            'description' => $purchase_detail[0]['description'],
            'rate' => $purchase_detail[0]['rate'],
           // 'pro_no_reference' => $purchase_detail[0]['pro_no_reference'],
            'total_amt' =>  $purchase_detail[0]['total_amt'],
            'tax' =>  $purchase_detail[0]['tax'],
            'grandtotal' =>  $purchase_detail[0]['grand_total_amount'],
            'remarks' =>  $purchase_detail[0]['remarks'],
            'purchase_all_data'=> $purchase_detail,
           // 'company_info'     => $company_info,
            'Web_settings'     => $currency_details,
        );
        // echo "<pre>";
        $chapterList = $CI->parser->parse('invoice/trucking_invoice_print', $data, true);
        return $chapterList;
    }

    public function trucking_invoice_list() {
     

        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $company_info = $CI->Invoices->retrieve_company();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $transports = $CI->Invoices->getRoadTransportData();
        // print_r($transports);
        $data = array(
            'title'         => display('manage_invoice'),
            'total_invoice' => $CI->Invoices->count_invoice(),
            'currency'      => $currency_details[0]['currency'],
            'company_info'  => $company_info,
            'transports' => $transports,
        );
        $invoiceList = $CI->parser->parse('invoice/trucking_invoice_list', $data, true);
        return $invoiceList;
    }







   

public function tax_data() {
        $this->db->select('tax_id,tax');
        $this->db->from('tax_information');
        $this->db->where('created_by' ,$this->session->userdata('user_id'));
        $query = $this->db->get();
    //    echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }


      //ocean_export_tracking_add_form -vijila - 30-07-2024
      public function ocean_export_tracking_add_form($cdata) {
        $company_id = $cdata['company_id'];
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Ppurchases');
        $CI->load->model('Web_settings');
        $all_supplier       = $CI->Ppurchases->select_all_supplier($company_id);
        $customer_details   = $CI->Invoices->pos_customer_setup($company_id);
        $ocean_remarks      = $CI->Web_settings->ocean_remarks($company_id);

        $setting_detail     = $CI->Web_settings->retrieve_setting_editdata($company_id);
        $bank_list          = $CI->Web_settings->bank_list($company_id);
        $data = array(
            'title'         => 'Add New Export Invoice',
            'discount_type' => $setting_detail[0]['discount_type'],
            'customer_name' => $customer_details,
            'customer_id'   => isset($customer_details[0]['customer_id']) ? $customer_details[0]['customer_id']:'',
            'bank_list'     => $bank_list,
            'all_supplier'  => $all_supplier,
            'ocean_remarks' => $ocean_remarks,   
            'setting_detail' => $setting_detail,
            'company_id'     => $company_id
        );
        $invoiceForm = $CI->parser->parse('sales/ocean_export_track_add', $data, true);
        return $invoiceForm;
    }
     
      //Invoice add form ->vijila
    public function trucking_add_form($data) {
        $company_id = $data['company_id'];
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Accounts_model');
        $CI->load->model('Web_settings');
        $CI->load->model('Ppurchases');
        $all_supplier = $CI->Ppurchases->select_all_supplier_trucker($company_id);
        $customer_details = $CI->Invoices->pos_customer_setup($company_id);
        $get_customer= $CI->Accounts_model->get_customer($company_id);
        $pro_number = $CI->Invoices->pro_number($company_id);
        $voucher = $CI->Invoices->sale_trucking_voucher($company_id);
        $currency_details = $CI->Web_settings->retrieve_setting_editdata($company_id);
        $curn_info_default = $CI->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
        $taxfield = $CI->db->select('tax_name,default_value')->from('tax_settings')->get()->result_array();      
        $company_info = $CI->Invoices->company_information($company_id);
        $trucking_data = $CI->Invoices->getAllTruckingdata($company_id);
        $setting_detail = $CI->Web_settings->retrieve_setting_editdata($company_id);
        $roadtransport_remarks = $CI->Web_settings->roadtransport_remarks($company_id);       
        $taxfield1 =  $CI->Invoices->fetchTaxdata($company_id);
        $bank_list = $CI->Web_settings->bank_list($company_id);
        $data = array(
            'curn_info_default' =>$curn_info_default[0]['currency_name'],
            'currency'  =>$currency_details[0]['currency'],
            'title'         => 'Add New Trucking Invoice',
            'discount_type' => $currency_details[0]['discount_type'],
            'all_supplier'  => $all_supplier,
            'taxes'         => $taxfield,
            'tax'         => $taxfield1,
            'company_name' =>$company_info,
            'customer_name' => isset($customer_details[0]['customer_name'])?$customer_details[0]['customer_name']:'',
            'customer_id'   => isset($customer_details[0]['customer_id'])?$customer_details[0]['customer_id']:'',
            'bank_list'     => $bank_list,
            'customer_list' => $get_customer,
            'setting_detail' => $setting_detail,
            'invoice'  => $pro_number,
            'voucher_no' => $voucher,
            'trucking_data' => $trucking_data,
            'roadtransport_remarks' =>$roadtransport_remarks,   
            'remarks' =>  $roadtransport_remarks 
        );
        $invoiceForm = $CI->parser->parse('invoice/trucking', $data, true);
        return $invoiceForm;
    }
    public function trucking_add_form1() {
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Accounts_model');
        $CI->load->model('Web_settings');
        $CI->load->model('Ppurchases');
        $all_supplier = $CI->Ppurchases->select_all_supplier_trucker();
        $customer_details = $CI->Invoices->pos_customer_setup();
        $get_customer= $CI->Accounts_model->get_customer();     
        $taxfield = $CI->db->select('tax_name,default_value')
                ->from('tax_settings')
                ->get()
                ->result_array();
            $bank_list          = $CI->Web_settings->bank_list();
            $data = array(
            'title'         => 'Add New Trucking Invoice',
            'discount_type' => $currency_details[0]['discount_type'],
            'all_supplier'  => $all_supplier,
            'taxes'         => $taxfield,
            'customer_name' => isset($customer_details[0]['customer_name'])?$customer_details[0]['customer_name']:'',
            'customer_id'   => isset($customer_details[0]['customer_id'])?$customer_details[0]['customer_id']:'',
            'bank_list'     => $bank_list,
            'customer_list' => $get_customer
        );

        $invoiceForm = $CI->parser->parse('purchase/trucking', $data, true);
      
        return $invoiceForm;
    }

    public function profarma_invoice_add() {
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $data = $CI->Invoices->profarma_invoice_customer();
       
        $profarma_customer = $CI->parser->parse('invoice/profarma_invoice', $data, true);

       // print_r($data); die;
        return $profarma_customer;
    }
   


  
   

}

?>