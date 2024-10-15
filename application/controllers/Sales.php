<?php
/*created by - Vijila
created date - 26-07-2024
sales - ocean Export tracking
sales - road transport 
Modified Date - 26-07-2024
Modified By - Vijila */

defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Controller {
    public function __construct()
 	{
 		parent::__construct();
 		$this->load->model(array(
 			'sales_model','Invoices','Suppliers','Web_settings'
 		));
 		$this->load->library(array('linvoice'));
		 $this->auth->check_admin_auth();
 	}
	/*index page for ocean export tracking */
	public function oceanExportTracking(){
		$data =array();
		$content = $this->load->view('sales/ocean_export_tracking_view', $data, true);
        $this->template->full_admin_html_view($content);
	}
	/*data table display */   
	public function getOceanExportInvoice(){
		$encodedId      = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId      = decodeBase64UrlParameter($encodedId);
        $limit          = $this->input->post('length');
        $start          = $this->input->post('start');
        $search         = $this->input->post('search')['value'];
        $orderField     = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'] =='sl' ? 'id' : $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
        $orderDirection = $this->input->post('order')[0]['dir'];
        $totalItems     = $this->sales_model->getOceanExportCount($search, $decodedId);
        $items          = $this->sales_model->getOceanExportsdata($limit, $start, $orderField, $orderDirection, $search, $decodedId);
        $data           = [];
        $sl             = $start + 1;
        $jsaction = "return confirm('Are You Sure ?')";
        foreach ($items as $record) {
            $button = '';
           //if($this->permission1->method('manage_supplier','update')->access()){
                $button .='<a href="'.base_url().'sales/oceanExportTrackingEdit/'.$record->id.'?id='.$encodedId.'" class="btnclr btn btn-xs"  data-placement="left" title="'. display('update').'"><i class="fa fa-edit"></i></a> ';
           // }
          // if($this->permission1->method('manage_supplier','delete')->access()){
                 $button .='<a href="#" onclick="deleteOceanExpTrac('.$record->id.','.$decodedId.')" class="btn btnclr btn-xs" onclick="'.$jsaction.'" ><i class="fa fa-trash"></i></a>';
          // }
            $data[] = array( 
                'sl'               	=> $sl,
                'booking_no'    	=> html_escape($record->booking_no),
                'container_no'      => html_escape($record->container_no),
                'seal_no'           => html_escape($record->seal_no),
                'ocean_export_tracking_id'    => html_escape($record->ocean_export_tracking_id),
                'supplier_name'     => html_escape($record->supplier_name),
                'invoice_date'   	=> html_escape($record->invoice_date),
                'place_of_delivery' => html_escape($record->place_of_delivery),
                'notify_party'      => html_escape($record->notify_party),
                'vessel'          	=> html_escape($record->vessel),
                'voyage_no'     	=> html_escape($record->voyage_no),
                'freight_forwarder' => html_escape($record->freight_forwarder),
                'hbl_no'      		=> html_escape($record->hbl_no),
                'obl_no'    		=> html_escape($record->obl_no),
                'ams_no'            => html_escape($record->ams_no),
                'isf_no'     		=> html_escape($record->isf_no),
                'mbl_no'            => html_escape($record->mbl_no),
                'port_of_discharge' => html_escape($record->port_of_discharge),
                'customs_broker_name' => html_escape($record->customs_broker_name),
                'etd'     			=> html_escape($record->etd),
                'consignee'     	=> html_escape($record->consignee),
                'port_of_loading'   => html_escape($record->port_of_loading),
                'eta'     			=> html_escape($record->eta),
                'particular'     	=> html_escape($record->particular),
                'etd'     			=> html_escape($record->etd),
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




	// create form
	public function createOceExpTracking(){
        $encodedId      = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId      = decodeBase64UrlParameter($encodedId);
        if($decodedId ==""){
            redirect(base_url());
        }
        $this->load->library('linvoice');
        $data = array('company_id'=>$decodedId);
        $content = $this->linvoice->ocean_export_tracking_add_form($data);

        $this->template->full_admin_html_view($content);
	}



    public function insert_ocean_export(){
        $admin_comp_id = decodeBase64UrlParameter($this->input->post('admin_company_id'));
        $purchase_id = date('YmdHis');
        $data = array(
            'customs_broker_name' => $this->input->post('customs_broker_name',TRUE),
            'mbl_no' => $this->input->post('mbl_no',TRUE),
            'hbl_no' => $this->input->post('hbl_no',TRUE),
            'obl_no' => $this->input->post('obl_no',TRUE),
            'ams_no' => $this->input->post('ams_no',TRUE),
            'isf_no' => $this->input->post('isf_no',TRUE),
            'ocean_export_tracking_id'        => $purchase_id,
            'booking_no'                        => $this->input->post('booking_no',TRUE),
            'container_no'                      => $this->input->post('container_no',TRUE),
            'seal_no'                           => $this->input->post('seal_no',TRUE),
            'etd'                               => $this->input->post('esti_depart',TRUE),
            'eta'                               => $this->input->post('est_time_arrival',TRUE),
            'supplier_id'                       => $this->input->post('supplier_id',TRUE),
            'shipper'                           => $this->input->post('supplier_id',TRUE),
            'invoice_date'                      => $this->input->post('invoice_date',TRUE),
            'consignee'                         => $this->input->post('consignee',TRUE),
            'notify_party'                      => $this->input->post('notify_party',TRUE),
            'vessel'                            => $this->input->post('vessel',TRUE),
            'voyage_no'                         => $this->input->post('voyage_no',TRUE),
            'port_of_loading'                   => $this->input->post('port_of_loading',TRUE),
            'port_of_discharge'                 => $this->input->post('port_of_discharge',TRUE),
            'place_of_delivery'                 => $this->input->post('place_of_delivery',TRUE),
            'freight_forwarder'                 => $this->input->post('freight_forwarder',TRUE),
            'particular'                        => $this->input->post('particulars',TRUE),
            'status'                            => 1,
            'created_by'                        =>  $admin_comp_id,
            'created_date'                      => date('Y-m-d H:i:s'),
            );
            $purchase_id_1 = $this->db->where('booking_no',$this->input->post('booking_no',TRUE));
            $q=$this->db->get('ocean_export_tracking');
            $row = $q->row_array();
            $resmess = 'inserted';
            if($this->input->post('ocean_export_tracking_id') && $this->input->post('ocean_export_tracking_id') !=""){
                $data['modified_by'] = $admin_comp_id;
                $this->sales_model->updateOceanExport($data,$this->input->post('ocean_export_tracking_id'));
                $ocean_insert_id = $this->input->post('ocean_export_tracking_id');
                $resmess = 'updated';
            }
            else if(!empty($row['booking_no'])){
                $this->session->set_userdata("ocean_export_1",$row['booking_no']);
                //delete when same booking no is already present
                $del_data = array('is_deleted' =>1);
                $this->sales_model->updateOceanExport($del_data, $row['id']);
                $ocean_insert_id = $this->sales_model->insertOceanExport($data);
            } 
            else{
                $ocean_insert_id = $this->sales_model->insertOceanExport($data);
            }
            $eta =  date('Y-m-d', strtotime($this->input->post('est_time_arrival', TRUE))); 
            $etd = date('Y-m-d', strtotime($this->input->post('esti_depart', TRUE))); 
            $adjusted_date = $this->Invoices->adjustDatesBasedOnNotifications_ocean($eta, $etd, $this->session->userdata('unique_id'));
            $company_email_id = $this->db->select('email')->from('company_information')->where('create_by',$admin_comp_id)->get()->row()->email;
            if($adjusted_date['adjusted_eta'] && $adjusted_date['adjusted_eta_notification_source']){
                $data_eta=array(
                    'unique_id'  =>$this->session->userdata('unique_id'),
                    'invoice_no'       =>$this->input->post('booking_no',TRUE),
                    'title'     => 'SALE - OCEAN EXPORT TRACKING - ETA',
                    'description'   => 'Scheduled ETA for Invoice ' .$this->input->post('booking_no',TRUE).' OCEAN EXPORT TRACKING',
                    'created_by' => $admin_comp_id,
                    'start'    =>$adjusted_date['adjusted_eta'],
                    'invoice_id' => $purchase_id,
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
                'invoice_no'       =>$this->input->post('booking_no',TRUE),
                'title'     => 'SALE - OCEAN EXPORT TRACKING - ETD',
                'invoice_id' => $purchase_id,
                'description'   => 'Scheduled ETD for Invoice ' .$this->input->post('booking_no',TRUE).' OCEAN EXPORT TRACKING',
                'created_by' => $admin_comp_id,
                'bell_notification' => ($adjusted_date['adjusted_etd_notification_source'] === 'STOCKEAI') ? 1 : '',
                'source'  => $adjusted_date['adjusted_etd_notification_source'],
                'email_id'  => ($adjusted_date['adjusted_eta_notification_source'] === 'EMAIL') ? $company_email_id : '',
                'start'    =>$adjusted_date['adjusted_etd'],
                'schedule_status' =>1,
                'create_date'   => date("Y-m-d")
            );
        }
      
        if($adjusted_date['adjusted_eta']){
         $this->db->where('invoice_no',$this->input->post('booking_no',TRUE));
         $this->db->where('title','SALE - OCEAN EXPORT TRACKING - ETA');$this->db->delete('schedule_list');
         $this->db->insert('schedule_list', $data_eta);
    
       }
        if($adjusted_date['adjusted_etd']){
         $this->db->where('invoice_no',$this->input->post('booking_no',TRUE));
         $this->db->where('title','SALE - OCEAN EXPORT TRACKING - ETD');$this->db->delete('schedule_list');
         $this->db->insert('schedule_list', $data_etd);
         
       }
       //file upload
       if($ocean_insert_id!=""){
            if(!empty($_FILES['files'])){
                    $fileCount = count($_FILES['files']['name']);
                    for ($i = 0; $i < $fileCount; $i++) {
                        $upload_data = multiple_file_upload('files',$i,'ocean_export',OCEAN_EXPORT_IMG_PATH);
                        if($upload_data['upload_data']['file_name'] !=""){
                            $res = insertAttachments($ocean_insert_id, $upload_data['upload_data']['file_name'],OCEAN_EXPORT_IMG_PATH,'ocean_export_tracking',$this->session->userdata('unique_id'),$admin_comp_id);
                            
                        }
                    }
            }
        }
       $response = array(
        'status' =>'success',
        'msg'    => 'Ocean export tracking has been '.$resmess.' successfully'
        );
     //return $purchase_id."/".$this->input->post('booking_no',TRUE);
        echo json_encode($response);
    }


public function oceanExportTrackingEdit(){
    $CI = & get_instance();
    $encodedId      = isset($_GET['id']) ? $_GET['id'] : null;
    $decodedId      = decodeBase64UrlParameter($encodedId);
    $purchase_id    = $this->uri->segment(3);
    if($decodedId ==""){
        redirect(base_url());
    }
    $this->load->library('linvoice');
    $data = array('company_id'=>$decodedId);

     $bank_list       = $this->Web_settings->bank_list();

     $ocean_exp_detls = $this->Invoices->retrieve_ocean_export_tracking_editdata($purchase_id,$decodedId);
     $purchase_detail = $ocean_exp_detls;
     $view_attachments = $this->Invoices->editMultiplefiles($purchase_id,'ocean_export_tracking',$decodedId);
     //echo $this->db->last_query();
     //print_r($view_attachments); exit;
     $customer_name = $this->Invoices->getcustomer_data($purchase_detail[0]['consignee']);


     $supplier_id = $purchase_detail[0]['supplier_id'];

     $supplier_name = $purchase_detail[0]['supplier_name'];

     $supplier_list = $this->Suppliers->supplier_list($decodedId);

     if (!empty($purchase_detail)) {

         $i = 0;

         foreach ($purchase_detail as $k => $v) {

             $i++;

             $purchase_detail[$k]['sl'] = $i;

         }

     }

    $setting_detail = $this->Web_settings->retrieve_setting_editdata();


     $currency_details = $this->Web_settings->retrieve_setting_editdata();
     //$customer=  $this->Invoices->profarma_invoice_customer();
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
         'customer_name'  => $customer_name[0]->customer_name,
         'customer_id'  => $customer_name[0]->customer_id,
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
         //'customer' =>$customer,
         'view_attachments' => $view_attachments,
        'setting_detail' => $setting_detail,
        'ocean_edit_details' => $ocean_exp_detls[0]


     );
//print_r($data); exit;
     $chapterList = $CI->parser->parse('sales/ocean_export_track_edit', $data, true);
     $this->template->full_admin_html_view($chapterList);
    //return $chapterList;
}



/*index page for ocean export tracking */
public function roadTransport(){
    $data =array();
    $content = $this->load->view('sales/road_transport_view', $data, true);
    $this->template->full_admin_html_view($content);
}

public function getTruckingInvoice(){
    $encodedId      = isset($_GET['id']) ? $_GET['id'] : null;
    $decodedId      = decodeBase64UrlParameter($encodedId);
    $limit          = $this->input->post('length');
    $start          = $this->input->post('start');
    $search         = $this->input->post('search')['value'];
    $orderField     = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'] =='sl' ? 'id' : $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
    $orderDirection = $this->input->post('order')[0]['dir'];
    $totalItems     = $this->sales_model->getRoadtransportCount($search, $decodedId);
    $items          = $this->sales_model->getRoadtransportsdata($limit, $start, $orderField, $orderDirection, $search, $decodedId);
    $data           = [];
    $sl             = $start + 1;
    $jsaction = "return confirm('Are You Sure ?')";
   
   
    foreach ($items as $record) {
        $button = '';

        $button .= '<a class="btnclr btn btn-sm" href="' . base_url() . 'sales/trucking_details_data/' . $record->trucking_id. '?id='.$_GET['id'].'"><i class="fa fa-download" aria-hidden="true"></i></a>';
        //$button .= ' <a class="btnclr btn btn-sm get_truckingid" data-toggle="modal" data-target="#emailmodal" onclick="truckingmail(' . $record->trucking_id. ', \'sale_trucking\', \'trucking_id\')"><i class="fa fa-envelope" aria-hidden="true"></i></a>';
        $button .= ' <a class="btnclr btn btn-sm trucking-edit" href="' . base_url() . 'sales/UpdateRoadTransport/' . $record->trucking_id . '?id='.$_GET['id'].'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
        $button .= ' <a class="btn btn-sm btnclr" onclick="deleteRoadTrans('. $record->id.','.$decodedId.')" href="#"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
    

        $data[] = array( 
            'sl'               	=> $sl,
            'invoice_no'    	=> html_escape($record->invoice_no),
            'invoice_date'      => html_escape($record->invoice_date),
            'customer_name'     => html_escape($record->customer_name),
             'trucking_id'      => html_escape($record->trucking_id),
            'container_pickup_date'   	=> html_escape($record->container_pickup_date),
            'delivery_date'         => html_escape($record->delivery_date),
            'shipment_company'      => html_escape($record->supplier_name),
            'delivery_time_from'    => html_escape($record->delivery_time_from),
            'delivery_time_to'     	=> html_escape($record->delivery_time_to),
            'truck_no'              => html_escape($record->truck_no),
            'delivery_to'      		=> html_escape($record->delivery_to),
            'tax'    		        => html_escape($record->tax),
            'grand_total_amount'    => html_escape($record->grand_total_amount),
            'customer_gtotal'       => html_escape($record->customer_gtotal),
            'amt_paid'            => html_escape($record->amt_paid),
            'balance'               => html_escape($record->balance),
            'remarks'               => html_escape($record->remarks),
            'button'                => $button
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
public function trucking_details_data($purchase_id) {
    $admin_id = $_GET['id'];
    $CI = & get_instance();
    $CI->auth->check_admin_auth();
    $content = $this->linvoice->trucking_details_data($purchase_id,$admin_id);
    $this->template->full_admin_html_view($content);
}

public function deleteOceanExportTrack(){
    $id             = $this->input->post('id');
    $modified_by    = $this->input->post('moid');
    $exp_data = $this->sales_model->getOceanExportData($id);
    if($exp_data['booking_no']){
       
        $this->db->where('invoice_no',$exp_data['booking_no']);
        $this->db->delete('schedule_list');
    }
    $up_data = array('is_deleted'=>1,'modified_by'=>$modified_by);
    $this->sales_model->updateOceanExport($up_data, $id);
    $response = array(
        'status'=>'success',
        'msg'   => 'Ocean export has been deleted successfully!'
    );
    echo json_encode($response);
}

public function createRoadTrans(){
        $encodedId      = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId      = decodeBase64UrlParameter($encodedId);
        if($decodedId ==""){
            redirect(base_url());
        }
        $data = array('company_id'=>$decodedId);
        $content = $this->trucking_add_form($data);
        $this->template->full_admin_html_view($content);
    }


    public function trucking_add_form($data) {
        $company_id = $data['company_id'];
        $this->load->model('Invoices');
        $this->load->model('Accounts_model');
        $this->load->model('Web_settings');
        $this->load->model('Ppurchases');
        $all_supplier = $this->Ppurchases->select_all_supplier_trucker($company_id);
        $customer_details = $this->Invoices->pos_customer_setup($company_id);
        $get_customer= $this->Accounts_model->get_customer($company_id);


        $pro_number = $this->Invoices->pro_number($company_id);
        $voucher = $this->Invoices->sale_trucking_voucher($company_id);
        $currency_details = $this->Web_settings->retrieve_setting_editdata($company_id);
        $curn_info_default = $this->db->select('*')->from('currency_tbl')->where('icon',$currency_details[0]['currency'])->get()->result_array();
        $taxfield = $this->db->select('tax_name,default_value')->from('tax_settings')->get()->result_array();
       
        $company_info = $this->Invoices->company_information($company_id);
        
        $trucking_data = $this->Invoices->edit_Trucking_taxdata($company_id);
       
        $setting_detail = $this->Web_settings->retrieve_setting_editdata($company_id);

        $roadtransport_remarks = $this->Web_settings->roadtransport_remarks($company_id);
       
       $taxfield1 =  $this->Invoices->fetchTaxdata($company_id);
        $bank_list = $this->Web_settings->bank_list($company_id);
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
        $invoiceForm = $this->parser->parse('sales/road_trans_add', $data, true);
        return $invoiceForm;
    } 

    // Insert Road Transport
    public function insertTrucking()
    {
        $encodedId          = $this->input->post('admin_company_id');
        $admin_id           = decodeBase64UrlParameter($encodedId);
        $trucking_date      = $this->input->post('trucking_date',TRUE);
        $invoice_no         = $this->input->post('invoice_no',TRUE);
  
        $payment_id         = $this->input->post('makepaymentId');
        $p_id               = $this->input->post('product_id',TRUE);
        $receive_by         = $admin_id;
        $receive_date       = date('Y-m-d');
        $createdate         = date('Y-m-d H:i:s');
        $paid_amount        = $this->input->post('amount_paid',TRUE);
        $due_amount         = $this->input->post('due_amount',TRUE);
        $discount           = $this->input->post('discount',TRUE);
        $bank_id            = $this->input->post('bank_id',TRUE);
        if(!empty($bank_id)){
           $bankname = $this->db->select('bank_name')->from('bank_add')->where('bank_id',$bank_id)->get()->row()->bank_name;
        
           $bankcoaid = $this->db->select('HeadCode')->from('acc_coa')->where('HeadName',$bankname)->get()->row()->HeadCode;
         }else{
             $bankcoaid = '';
         }
  
          $purchase_id = date('YmdHis');
  
          $data = array(
            'payment_id'            => $payment_id,
            'delivery_time_from'    => $this->input->post('delivery_time_from',TRUE),
            'delivery_time_to'      => $this->input->post('delivery_time_to',TRUE),
            'truck_no'              => $this->input->post('truck_no',TRUE),
            'trucking_id'           => $purchase_id,
            'create_by'             => $admin_id,
            'invoice_no'            => $this->input->post('invoice_no',TRUE),
            'invoice_date'          => $this->input->post('invoice_date',TRUE),
            'bill_to'               => $this->input->post('bill_to',TRUE),
            'shipment_company'      => $this->input->post('supplier_id',TRUE),
            'container_pickup_date' => $this->input->post('container_pick_up_date',TRUE),
            'delivery_date'         => $this->input->post('delivery_date',TRUE),
            'total_amt'             => $this->input->post('total',TRUE),
            'tax'                   => $this->input->post('tax_details',TRUE),
            'grand_total_amount'    => $this->input->post('gtotal',TRUE),
            'customer_gtotal'       => $this->input->post('customer_gtotal',TRUE),
            'delivery_to'           => $this->input->post('delivery_to',TRUE),
            'amt_paid'              => $this->input->post('amount_paid',TRUE),
            'balance'               => $this->input->post('balance',TRUE),
            'remarks'               => $this->input->post('remarks',TRUE),
            'status'                => 1,
           
          );
  
            $purchase_id_1 = $this->db->where('invoice_no',$this->input->post('invoice_no',TRUE));
            $q=$this->db->get('sale_trucking');
            $row = $q->row_array();
            if(!empty($row['trucking_id'])){
                $this->session->set_userdata("sale_trucking_1",$row['trucking_id']);
                $data['modified_by'] = $admin_id;
                $this->db->where('invoice_no',$this->input->post('invoice_no',TRUE));
                $this->db->update('sale_trucking',$data);
            }   
            else{
                $this->db->insert('sale_trucking', $data);
            }
           // echo $this->db->last_query(); exit;
         $purchase_id = $this->db->select('trucking_id')->from('sale_trucking')->where('invoice_no',$this->input->post('invoice_no',TRUE))->get()->row()->trucking_id;
         $this->session->set_userdata("sale_trucking_2",$purchase_id);

        $rowCount = count($this->input->post('trucking_date',TRUE));
        $this->db->where('sale_trucking_id', $this->session->userdata("sale_trucking_1"));
        $this->db->delete('sale_trucking_details');
            for ($i = 0; $i < $rowCount; $i++) {
                $t_date             = $this->input->post('trucking_date',TRUE);
                $trucking_rate      = $this->input->post('product_rate',TRUE);
                $quantity           = $this->input->post('product_quantity',TRUE);
                $trucking_description = $this->input->post('description',TRUE);
                $trucking_pro_no    =  $this->input->post('pro_no',TRUE);
                $t_price            = $this->input->post('total_price',TRUE);
                $trucking_date      = $t_date[$i];
                $product_quantity   = $quantity[$i];
                $description        = $trucking_description[$i];
                $product_rate       =  $trucking_rate[$i];
                $pro_no             = $trucking_pro_no[$i];
                $total              =  $t_price[$i];
                $data1 = array(
                    'sale_trucking_detail_id' => $this->generator(15),
                    'sale_trucking_id'        => $this->session->userdata("sale_trucking_2"),
                    'trucking_date'           => $trucking_date,
                    'qty'                     => $product_quantity,
                    'description'             => $description,
                    'rate'                    => $product_rate ,
                    'pro_no_reference'        => $pro_no,
                    'total'                   => $total,
                    'create_by'               =>  $admin_id,
                    'status'                  => 1
                );

            $this->db->insert('sale_trucking_details', $data1);
     
        }
    
        $response = array(
            'status' => 'success',
            'msg' => 'Road Transport has been created successfully'
        );
       
        $container_pickup_date =  date('Y-m-d', strtotime($this->input->post('container_pick_up_date',TRUE))); 

        $delivery_date = date('Y-m-d', strtotime($this->input->post('delivery_date',TRUE))); 
        $adjusted_date = $this->Invoices->adjustDatesBasedOnNotifications_truck($delivery_date,$container_pickup_date, $this->session->userdata('unique_id'));
        $company_email = $this->Invoices->company_information($admin_id); 
        //echo $this->db->last_query(); exit;
        $company_email_id = $company_email[0]['email'];
        if($adjusted_date['container_pickupdate'] && $adjusted_date['adjusted_container_pickupdate_source']){
            $data_etd=array(
                'unique_id'     => $this->session->userdata('unique_id'),
                'invoice_no'    => $this->input->post('truck_no',TRUE),
                'title'         => 'SALE - TRUCKING - CONTAINER PICKUP DATE',
                'description'   => 'Scheduled CONTAINER PICKUP DATE for Invoice ' .$this->input->post('truck_no',TRUE).' TRUCKING',
                'created_by'    => $admin_id,
                'start'         => $adjusted_date['container_pickupdate'],
                'invoice_id'    => $purchase_id,
                'bell_notification' => ($adjusted_date['adjusted_container_pickupdate_source'] === 'STOCKEAI') ? 1 : '',
                'source'        => $adjusted_date['adjusted_container_pickupdate_source'],
                'email_id'      => ($adjusted_date['adjusted_eta_notification_source'] === 'EMAIL') ? $company_email_id : '',
                'schedule_status' =>1,
                'create_date'   => date("Y-m-d")

            );
        }
        if($adjusted_date['delivery_date'] && $adjusted_date['adjusted_delivery_source']){
        $data_eta=array(
             'unique_id'        =>$this->session->userdata('unique_id'),
             'invoice_no'       =>$this->input->post('truck_no',TRUE),
              'title'           => 'SALE - TRUCKING - DELIVERY DATE',
              'invoice_id'      => $purchase_id,
              'description'     => 'Scheduled DELIVERY DATE for Invoice ' .$this->input->post('truck_no',TRUE).' TRUCKING',
              'created_by'      => $admin_id,
               'bell_notification' => ($adjusted_date['adjusted_delivery_source'] === 'STOCKEAI') ? 1 : '',
              'source'          => $adjusted_date['adjusted_delivery_source'],
               'email_id'       => ($adjusted_date['adjusted_eta_notification_source'] === 'EMAIL') ? $company_email_id : '',
             'start'            =>$adjusted_date['delivery_date'],
             'schedule_status'  =>1,
             'create_date'      => date("Y-m-d")

        );
    }
      
     if($adjusted_date['delivery_date']){
         $this->db->where('invoice_no',$this->input->post('truck_no',TRUE));
         $this->db->where('title','SALE - TRUCKING - DELIVERY DATE');$this->db->delete('schedule_list');
         $this->db->insert('schedule_list', $data_eta);
    
       }
        if($adjusted_date['container_pickupdate']){
         $this->db->where('invoice_no',$this->input->post('truck_no',TRUE));
         $this->db->where('title','SALE - TRUCKING - CONTAINER PICKUP DATE');$this->db->delete('schedule_list');
         $this->db->insert('schedule_list', $data_etd);
         
       }
    //file upload
    $trucking_id = $this->input->post('attachment_id',TRUE);
        //print_r($_FILES); die();
        if (isset($_FILES['files']) && !empty($_FILES['files'])) {
            if(!empty($_FILES['files'])){
                $fileCount = count($_FILES['files']['name']);
                for ($i = 0; $i < $fileCount; $i++) {
                    $upload_data = multiple_file_upload('files',$i,'truck',TRUCK_IMG_PATH);
                    //print_r($upload_data); exit;
                    if($upload_data['upload_data']['file_name'] !=""){
                        $res = insertAttachments($trucking_id, $upload_data['upload_data']['file_name'],TRUCK_IMG_PATH,'sales_tracking',$this->session->userdata('unique_id'),$admin_id);
                        
                    }
                }
        }
        $response = array('status'=>'success', 'msg'=>'Road trasport has been added successfully');
        echo json_encode($response);
    
        }
    }
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
    public function UpdateRoadTransport($purchase_id){
        $encodedId      = isset($_GET['id']) ? $_GET['id'] : null;
        $decodedId      = decodeBase64UrlParameter($encodedId);
        if($decodedId ==""){
            redirect(base_url());
        }
        $this->auth->check_admin_auth();
        $content = $this->linvoice->trucking_edit_data($purchase_id,$decodedId);
        $this->template->full_admin_html_view($content);
    }
    public function deleteAttachment(){
        $id= $this->input->post('id');
        if($id !=""){
            $this->sales_model->deleteAttachment($id);
            echo 'success';
        }else{
            echo 'failure';
        }
    }
    public function deleteRoadTrack(){
        $id             = $this->input->post('id');
        $modified_by    = $this->input->post('moid');
       
        $up_data = array('is_deleted'=>1,'modified_by'=>$modified_by);
        $this->sales_model->updateRoadTruck($up_data, $id);
       // echo $this->db->last_query();
        //exit;
        $response = array(
            'status'=>'success',
            'msg'   => 'Road transport has been deleted successfully!'
        );
        echo json_encode($response);
    }
}