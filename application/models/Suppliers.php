<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Suppliers extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
   
    public function add_payment_terms($postData){
        $data=array(
            'paymentterms_add' => $postData,
            'create_by' => $this->session->userdata('user_id')
        );
        $this->db->insert('paymentterms_add', $data);
        $this->db->select('*');
        $this->db->from('paymentterms_add');
        $this->db->where('create_by' ,$this->session->userdata('user_id'));
        $query = $this->db->get();
        return $query->result_array();
    }
    public function vendor_overall_amt_bal($sup_id) {
        $this->db->select('SUM(a.paid_amount) as vtotal_paid_amount, SUM(a.balance) as vtotal_due_amount,SUM(a.amount_pay_usd) as vtotal_amount_pay_usd, SUM(a.due_amount_usd) as vtotal_due_amount_usd');
        $this->db->from('product_purchase a');
        $this->db->where('a.create_by', $this->session->userdata('user_id'));
        $this->db->where('a.supplier_id', $sup_id);
        $query = $this->db->get();
        return $query->row_array(); 
    }
    public function service_overall_amt_bal($sup_id) {
        $this->db->select('SUM(a.amount_paids) as service_total_paid_amount,SUM(a.balances) as service_total_due_amount');
        $this->db->from('service a');
        $this->db->join('supplier_information b', 'a.service_provider_name = b.supplier_name'); 
        $this->db->where('b.created_by', $this->session->userdata('user_id'));
        $this->db->where('b.supplier_id', $sup_id); 
        $query = $this->db->get();
        return $query->row_array(); 
    }
    public function get_all_supplier($admin_id) {
        $this->db->select('*');
        $this->db->from('supplier_information');
        $this->db->where('created_by' ,$admin_id);
        $query = $this->db->get();  
            return $query->result_array();
    }
    public function payment_terms_dropdown() {
        $this->db->select('*');
        $this->db->from('payment_terms');
        $this->db->where('create_by',$this->session->userdata('user_id'));
         $this->db->order_by('payment_terms', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    //Count supplier
    public function count_supplier() {
        $this->db->select('*');
        $this->db->from('supplier_information');
        $this->db->where('created_by',$this->session->userdata('user_id'));
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function company_dropdown() {
        $this->db->select('*');
        $this->db->from('company_information');
        $this->db->where('create_by',$this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    //supplier List
    public function supplier_list_pag($per_page, $page) {
        $this->db->select('*');
        $this->db->from('supplier_information');
        $this->db->where('created_by',$this->session->userdata('user_id'));
        $this->db->limit($per_page, $page);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
     public function transaction_supplier($admin_id, $supplier=null,$date=null){
        if($date) {
            $split=explode(' to ',$date);
            $start =  $split[0];
            $end = $split[1];
        }
        $this->db->select('s.*,p.*,py.*');
        $this->db->from('supplier_information s');
        $this->db->join('product_purchase p','s.supplier_id=p.supplier_id');
        if($supplier){
            $this->db->where('s.supplier_id', $supplier_id);
        }
        if($date) {
            $this->db->where('py.payment_date >=',$start);
            $this->db->where('py.payment_date <=',$end);
        }
        $this->db->join('payment py','p.payment_id=py.payment_id');
        $this->db->where('s.created_by',$admin_id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
  public function amountGetPurchase($supplier_id=null)
    {
        $this->db->select('s.*,p.*');
        $this->db->from('supplier_information s');
        $this->db->join('product_purchase p','s.supplier_id=p.supplier_id');
        if($supplier_id){
        $this->db->where('s.supplier_id', $supplier_id);
        }
        $this->db->where('s.created_by',$this->session->userdata('user_id'));
        $query = $this->db->get();
      if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function getAllDatas()
    {
        $this->db->select('*');
        $this->db->from('supplier_information s');
        $this->db->join('product_purchase p','s.supplier_id=p.supplier_id');
       $this->db->where('s.created_by',$this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
       public function headcode(){
        $query=$this->db->query("SELECT MAX(HeadCode) as HeadCode FROM acc_coa WHERE HeadLevel='3' And HeadCode LIKE '50200%'");
        return $query->row();
        }
  public function insert_supplier($data){
        $this->db->insert('supplier_information',$data);
        $supplier_id = $this->db->insert_id();
        $coa = $this->Suppliers->headcode();
        if($coa->HeadCode!=NULL){
            $headcode=$coa->HeadCode+1;
        }
        else{
            $headcode="502000001";
        }
        $c_acc=$supplier_id.'-'.$this->input->post('supplier_name',TRUE);
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
            'supplier_id'      => $supplier_id,
            'IsDepreciation'   => '0',
            'DepreciationRate' => '0',
            'CreateBy'         => $createby,
            'CreateDate'       => $createdate,
        ];
        $this->db->insert('acc_coa',$supplier_coa);
        $this->Suppliers->previous_balance_add($this->input->post('previous_balance',TRUE), $supplier_id,$c_acc,$this->input->post('supplier_name',TRUE));

        return  $supplier_id;

    }

     
    public function supplier_list($admin_company_id) {
        $this->db->select('supplier_name,supplier_id,created_by');
        $this->db->from('supplier_information');
        $this->db->where('created_by',$admin_company_id);
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }




    public function getSupplierCount($searchValue,$companyId){
        $searchQuery = "";
        if($searchValue != ''){
           $searchQuery = " (a.supplier_name like '%".$searchValue."%' or a.mobile like '%".$searchValue."%' or a.country like '%".$searchValue."%' or a.state like '%".$searchValue."%' or a.zip like '%".$searchValue."%' or a.city like '%".$searchValue."%') ";
        }
        $this->db->select('count(*) as allcount');
        $this->db->from('supplier_information a');
        $this->db->group_by('a.supplier_id');
        $this->db->where('a.created_by',$companyId);
        $this->db->where('a.is_deleted',0);
         if($searchValue != '')
        $this->db->where($searchQuery);
        $records = $this->db->get()->num_rows();
        return $records; 
   }
public function getSupplierList($limit, $start, $orderField, $orderDirection, $searchValue, $decodedId){
         $searchQuery = "";
         if($searchValue != ''){
            $searchQuery = " (a.supplier_name like '%".$searchValue."%' or a.address like '%".$searchValue."%' or a.mobile like '%".$searchValue."%' or a.businessphone like '%".$searchValue."%' or a.primaryemail like '%".$searchValue."%' or a.secondaryemail like '%".$searchValue."%' or a.city like '%".$searchValue."%' or a.state like '%".$searchValue."%' or a.country like '%".$searchValue."%' or a.credit_limit like '%".$searchValue."%' or a.previous_balance like '%".$searchValue."%' or a.vendor_type like '%".$searchValue."%' or a.fax like '%".$searchValue."%' or a.taxcollected like '%".$searchValue."%' or a.zip like '%".$searchValue."%' or a.details like '%".$searchValue."%' or a.currency_type like '%".$searchValue."%' or a.paymentterms like '%".$searchValue."%' or a.paymentterms like '%".$searchValue."%') ";
         }
         $this->db->select("a.*");
         $this->db->from('supplier_information a');
         $this->db->where('a.created_by',$decodedId);
         $this->db->where('a.is_deleted',0);
         if($searchValue != '')
         $this->db->where($searchQuery);
         $this->db->order_by($orderField, $orderDirection);
         $this->db->limit($limit, $start);
          $records = $this->db->get()->result();
         return $records; 
    }
    //Vendor Sales Details 
       public function getSupplierSalesCount($searchValue,$companyId){
       $searchQuery = "";
       if($searchValue != ''){
           $searchQuery = " (b.invoice_id like '%".$searchValue."%' or e.product_name like '%".$searchValue."%' or d.supplier_name like '%".$searchValue."%' or e.product_model like '%".$searchValue."%' or b.invoice like '%".$searchValue."%') ";
       }
       $this->db->select('b.date,b.invoice,b.invoice_id,e.product_name,e.product_model,e.product_id,d.supplier_name,
		a.quantity,c.supplier_price as supplier_rate,CAST(a.quantity*c.supplier_price AS DECIMAL(16,2) ) as total');
        $this->db->select('count(*) as allcount');
        $this->db->from('invoice_details a');
        $this->db->join('product_information e','e.product_id = a.product_id','left');
        $this->db->join('invoice b','b.invoice_id = a.invoice_id','left');
        $this->db->join('supplier_product c','c.product_id = a.product_id','left');
        $this->db->join('supplier_information d','d.supplier_id = c.supplier_id','left');
        $this->db->where('a.create_by',$companyId);
         if($searchValue != '')
        $this->db->where($searchQuery);
        $records = $this->db->get()->num_rows();
        echo $this->db->last_query();die();
        return $records; 
       }
    //Vendor Sales Details 
        public function getSupplierSalesList($limit, $start, $orderField, $orderDirection, $searchValue, $decodedId){
         $searchQuery = "";
        if($searchValue != ''){
        $searchQuery = " (b.invoice like '%".$searchValue."%' or e.product_name like '%".$searchValue."%' or e.product_model like '%".$searchValue."%' or d.supplier_name like '%".$searchValue."%' or b.invoice_id like '%".$searchValue."%') ";
        }
        $this->db->select('b.date,b.invoice,b.invoice_id,e.product_name,e.product_model,e.product_id,d.supplier_name,a.quantity,
        c.supplier_price as supplier_rate,CAST(a.quantity*c.supplier_price AS DECIMAL(16,2) ) as total');
        $this->db->from('invoice_details a');
        $this->db->join('product_information e','e.product_id = a.product_id','left');
        $this->db->join('invoice b','b.invoice_id = a.invoice_id','left');
        $this->db->join('supplier_product c','c.product_id = a.product_id','left');
        $this->db->join('supplier_information d','d.supplier_id = c.supplier_id','left');
        $this->db->where('a.create_by',$companyId);
        $this->db->limit($per_page, $page);
         if($searchValue != '')
         $this->db->where($searchQuery);
         $this->db->order_by($orderField, $orderDirection);
         $this->db->limit($limit, $start);
          $records = $this->db->get()->result();
         return $records; 
    }
    // supplier search
    public function supplier_search($supplier_id) {
        $this->db->select('*');
        $this->db->from('supplier_information');
        $this->db->where('supplier_id', $supplier_id);
        $this->db->where('created_by',$this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //supplier List For Report
    public function supplier_list_report() {
        $this->db->select('*');
        $this->db->from('supplier_information');
        $this->db->where('created_by',$this->session->userdata('user_id'));
        $this->db->order_by('supplier_id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //supplier List
    public function supplier_list_count() {
        $this->db->select('*');
        $this->db->from('supplier_information');
        $this->db->where('created_by',$this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }
    //Retrieve company Edit Data
    public function retrieve_company() {
        $this->db->select('*');
        $this->db->from('company_information');
        $this->db->limit('1');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //supplier Search List
    public function supplier_search_item($supplier_id,$admin_id) {
        $this->db->select('*');
        $this->db->from('supplier_information');
        if($admin_id ==""){
            $this->db->where('created_by',$this->session->userdata('user_id'));
        }else{
            $this->db->where('created_by',$admin_id);
        }
        $this->db->where('supplier_id', $supplier_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //Selected Supplier List
    public function selected_product($product_id) {
        $this->db->select('*');
        $this->db->from('product_information');
        $this->db->where('created_by',$this->session->userdata('user_id'));
        $this->db->where('product_id', $product_id);
        return $query = $this->db->get()->row();
    }
    //Product search by name
    public function product_search_by_name($product_name){
      $query=$this->db->select('*')
                ->from('product_information b')
                ->like('b.product_name', $product_name, 'both')
                ->order_by('b.product_name','asc')
                ->limit(15)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();  
        }
        return false;
    }
    //Product search item
    public function product_search_item($supplier_id, $product_name) {
        $query=$this->db->select('*')
                  ->from('supplier_product a')
                  ->join('product_information b','a.product_id = b.product_id')
                  ->where('a.supplier_id',$supplier_id)
                  ->where('a.created_by',$this->session->userdata('user_id'))
                  ->like('b.product_model', $product_name, 'both')
                  ->or_where('a.supplier_id',$supplier_id)
                  ->like('b.product_name', $product_name, 'both')
                  ->group_by('a.product_id')
                  ->order_by('b.product_name','asc')
                  ->limit(15)
                  ->get();
          if ($query->num_rows() > 0) {
              return $query->result_array();
          }
      }
    //supplier product
    public function supplier_product($supplier_id) {
        $this->db->select('*');
        $this->db->from('product_information');
        $this->db->where('created_by',$this->session->userdata('user_id'));
        $this->db->where('supplier_id', $supplier_id);
        return $query = $this->db->get()->result();
    }
    //Count supplier
    public function supplier_entry($data) {
        $this->db->select('*');
        $this->db->from('supplier_information');
        $this->db->where('created_by',$this->session->userdata('user_id'));
        $this->db->where('supplier_name', $data['supplier_name']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            $this->db->insert('supplier_information', $data);
            $this->db->select('*');
            $this->db->from('supplier_information');
            $this->db->where('created_by',$this->session->userdata('user_id'));
            $this->db->where('status', 1);
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $json_product[] = array('label' => $row->supplier_name, 'value' => $row->supplier_id);
            }
            $cache_file = './my-assets/js/admin_js/json/supplier.json';
            $productList = json_encode($json_product);
            file_put_contents($cache_file, $productList);
            return TRUE;
        }
    }
    //Supplier Previous balance adjustment
   public function previous_balance_add($balance, $supplier_id,$c_acc,$supplier_name) {
        $this->load->library('auth');
        $transaction_id = $this->auth->generator(10);
    $coainfo = $this->db->select('*')->from('acc_coa')->where('HeadName',$c_acc)->get()->row();
    $supplier_headcode = $coainfo->HeadCode;
             $cosdr = array(
      'VNo'            =>  $transaction_id,
      'Vtype'          =>  'PR Balance',
      'VDate'          =>  date("Y-m-d"),
      'COAID'          =>  $supplier_headcode,
      'Narration'      =>  'supplier debit For '.$supplier_name,
      'Debit'          =>  0,
      'Credit'         =>  $balance,
      'IsPosted'       => 1,
      'CreateBy'       => $this->session->userdata('user_id'),
      'CreateDate'     => date('Y-m-d H:i:s'),
      'IsAppove'       => 1
    );
       $inventory = array(
      'VNo'            =>  $transaction_id,
      'Vtype'          =>  'PR Balance',
      'VDate'          =>  date("Y-m-d"),
      'COAID'          =>  10107,
      'Narration'      =>  'Inventory credit For  '.$supplier_name,
      'Debit'          =>  $balance,
      'Credit'         =>  0,
      'IsPosted'       => 1,
      'CreateBy'       => $this->session->userdata('user_id'),
      'CreateDate'     => date('Y-m-d H:i:s'),
      'IsAppove'       => 1
    ); 
        if(!empty($balance)){
           $this->db->insert('acc_transaction', $cosdr); 
           $this->db->insert('acc_transaction', $inventory); 
        }
    }
    //Retrieve supplier Edit Data
public function retrieve_supplier_editdata($supplier_id) {
        $this->db->select('*');
        $this->db->from('supplier_information');
        $this->db->where('created_by',$this->session->userdata('user_id'));
        $this->db->where('supplier_id', $supplier_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //Update Categories
    public function update_supplier($data, $supplier_id) {
        $this->db->where('supplier_id', $supplier_id);
        $this->db->update('supplier_information', $data);
        return true;
    }
    //Retrieve Supplier Purchase Data 
    public function supplier_purchase_data($supplier_id) {
        $this->db->select('*');
        $this->db->from('product_purchase');
        $this->db->where('create_by',$this->session->userdata('user_id'));
        $this->db->where(array('supplier_id' => $supplier_id, 'status' => 1));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //Supplier Search Data
    public function supplier_search_list($cat_id, $company_id) {
        $this->db->select('a.*,b.sub_category_name,c.category_name');
        $this->db->from('suppliers a');
        $this->db->join('supplier_sub_category b', 'b.sub_category_id = a.sub_category_id');
        $this->db->join('supplier_category c', 'c.category_id = b.category_id');
        $this->db->where('a.sister_company_id', $company_id);
        $this->db->where('c.category_id', $cat_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //Supplioer product information
    public function supplier_product_sale($supplier_id) {
        $query = $this->db->select('
								a.product_name,
								a.supplier_price,
								b.quantity,
								CAST(sum(b.quantity * b.supplier_rate) AS DECIMAL(16,2)) as total_taka,
								c.date
								')
                ->from('product_information a')
                ->join('invoice_details b', 'a.product_id = b.product_id', 'left')
                ->join('invoice c', 'c.invoice_id = b.invoice_id', 'left')
                ->where('a.created_by',$this->session->userdata('user_id'))
                ->where('a.supplier_id', $supplier_id)
                ->group_by('c.date')
                ->order_by('c.date')
                ->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
 public function supplier_product_sale1($per_page, $page,$sup_id) {
        if($page=='Product Supplier'){
  $this->db->select('s.*,p.*');
        $this->db->from('supplier_information s');
        $this->db->join('product_purchase p','s.supplier_id=p.supplier_id');
        $this->db->where('s.supplier_id', $sup_id);
        $this->db->where('s.created_by',$this->session->userdata('user_id'));
        $this->db->order_by('payment_due_date', 'desc');
        $query = $this->db->get();
     if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        }else{
             $sup_id1 = $this->db->select('supplier_name')->from('supplier_information')->where('supplier_id',$sup_id)->get()->row()->supplier_name;
  $this->db->select('s.*,p.*');
        $this->db->from('supplier_information s');
        $this->db->join('service p','s.supplier_name=p.service_provider_name');
        $this->db->where('s.supplier_name', $sup_id1);
        $this->db->where('s.created_by',$this->session->userdata('user_id'));
        $this->db->order_by('bill_date', 'desc');
        $query = $this->db->get();
      if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        }
       return false;
    }
    //To get certain supplier's chalan info by which this company got products day by day
 public function suppliers_ledger($supplier_id, $start,$end,$page) {
        $eplode=explode("-",$start);
               $eplode1=explode("-",$end);
               if($page=='Product Supplier'){
                $s=$eplode[0]."-".$eplode[1]."-".$eplode[2];
                  $e=$eplode1[0]."-".$eplode1[1]."-".$eplode1[2];
  $this->db->select('s.*,p.*');
        $this->db->from('supplier_information s');
        $this->db->join('product_purchase p','s.supplier_id=p.supplier_id');
        $this->db->where('s.supplier_id', $supplier_id);
         $this->db->where('p.purchase_date >=', $s);
          $this->db->where('p.purchase_date <=', $e);
        $this->db->where('s.created_by',$this->session->userdata('user_id'));
        $query = $this->db->get();
        echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        }else{
 $sup_id1 = $this->db->select('supplier_name')->from('supplier_information')->where('supplier_id',$supplier_id)->get()->row()->supplier_name;
            $eplode=explode("-",$start);
             $s=$eplode[0]."-".$eplode[1]."-".$eplode[2];
             $e=$eplode1[0]."-".$eplode1[1]."-".$eplode1[2];
  $this->db->select('*');
        $this->db->from('service');
      $this->db->where('service_provider_name', $sup_id1);
          $this->db->where("bill_date >= " , $s);
          $this->db->where("bill_date <= ", $e);
        $this->db->where('create_by',$this->session->userdata('user_id'));
        $query = $this->db->get();
     return $query->result();
        }
    }
    //Findings a certain supplier products sales information
    public function supplier_sales_details() {
        $supplier_id = $this->uri->segment(3);
        $start = $this->uri->segment(4);
        $end = $this->uri->segment(5);
        $this->db->select('
					date,
					product_name,
					product_model,
					product_id,
					quantity,
					supplier_rate,
					CAST(quantity*supplier_rate AS DECIMAL(16,2) ) as total
				');
        $this->db->from('sales_report');
        $this->db->where('supplier_id', $supplier_id);
        $this->db->where(array('date >=' => $start, 'date <=' => $end));
        $this->db->order_by('date', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
  public function supplier_sales_details_all($per_page, $page) {
        $this->db->select('
						b.date,
            b.invoice,
            b.invoice_id,
						e.product_name,
						e.product_model,
						e.product_id,
            d.supplier_name,
						a.quantity,
						c.supplier_price as supplier_rate,
            CAST(a.quantity*c.supplier_price AS DECIMAL(16,2) ) as total
					');
        $this->db->from('invoice_details a');
        $this->db->join('product_information e','e.product_id = a.product_id','left');
        $this->db->join('invoice b','b.invoice_id = a.invoice_id','left');
        $this->db->join('supplier_product c','c.product_id = a.product_id','left');
        $this->db->join('supplier_information d','d.supplier_id = c.supplier_id','left');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
        $this->db->order_by('b.date', 'desc');
        $this->db->limit($per_page, $page);
        $query = $this->db->get();
       if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function supplier_sales_details_datewise($per_page, $page,$fromdate,$todate) {
        $this->db->select('
            b.date,
            b.invoice,
            b.invoice_id,
            e.product_name,
            e.product_model,
            e.product_id,
            d.supplier_name,
            a.quantity,
            c.supplier_price as supplier_rate,
            CAST(a.quantity*c.supplier_price AS DECIMAL(16,2) ) as total
          ');
        $this->db->from('invoice_details a');
        $this->db->join('product_information e','e.product_id = a.product_id','left');
        $this->db->join('invoice b','b.invoice_id = a.invoice_id','left');
        $this->db->join('supplier_product c','c.product_id = a.product_id','left');
        $this->db->join('supplier_information d','d.supplier_id = c.supplier_id','left');
        $this->db->where(array('b.date >=' => $fromdate, 'b.date <=' => $todate));
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
        $this->db->order_by('b.date', 'desc');
        $this->db->limit($per_page, $page);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //Findings a certain supplier products sales information
    public function supplier_sales_details_count($supplier_id) {
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $this->db->select('date,product_name,product_model,product_id,quantity,supplier_rate,(quantity*supplier_rate) as total');
        $this->db->from('sales_report');
        $this->db->where('supplier_id', $supplier_id);
        if ($from_date != null AND $to_date != null) {
            $this->db->where('date >', $from_date);
            $this->db->where('date <', $to_date);
        }
        $this->db->order_by('date', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }
    // supplier sales details count menu all
    public function supplier_sales_details_count_all() {
        $this->db->select('
            b.date,
            e.product_name,
            e.product_model,
            e.product_id,
            a.quantity,
            c.supplier_price as supplier_rate,
            CAST(a.quantity*c.supplier_price AS DECIMAL(16,2) ) as total
          ');
        $this->db->from('invoice_details a');
        $this->db->join('product_information e','e.product_id = a.product_id','left');
        $this->db->join('invoice b','b.invoice_id = a.invoice_id','left');
        $this->db->join('supplier_product c','c.product_id = a.product_id','left');
        $this->db->join('supplier_information d','d.supplier_id = c.supplier_id','left');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
        $this->db->order_by('b.date', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }
    public function supplier_sales_summary($per_page, $page) {
        $date = $this->input->post('date');
        $supplier_id = $this->uri->segment(3);
        $start = $this->uri->segment(4);
        $end = $this->uri->segment(5);
        $this->db->select('
						date,
						quantity,
						product_name,product_model,
						product_id, 
						sum(quantity) as quantity ,
						supplier_rate,
						CAST(sum(quantity*supplier_rate) AS DECIMAL(16,2)) as total,
					');
        $this->db->from('sales_report');
        $this->db->where('supplier_id', $supplier_id);
        $this->db->where(array('date >=' => $start, 'date <=' => $end));
        $this->db->group_by('invoice_id');
        $this->db->limit($per_page, $page);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function supplier_sales_summary_count($supplier_id) {
        $date = $this->input->post('date');
        $this->db->select('
						date,
						quantity,
						product_name,product_model,
						product_id,
						sum(quantity) as quantity ,
						supplier_rate,
						sum(quantity*supplier_rate) as total,
					');
        $this->db->from('sales_report');
        $this->db->where('supplier_id', $supplier_id);
        if ($date != null) {
            $this->db->where('date =', $date);
        }
        $this->db->group_by('product_id,date,supplier_rate');
        $this->db->order_by('date', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }








    public function suppliers_list($date=null ) {
                    if($date) {
            $split = array_map(
            function($value) {
                return implode(' ', $value);
            },
            array_chunk(explode('-', $date), 3)
            );
                $start = str_replace(' ', '-', $split[0]);
                $end = str_replace(' ', '-', $split[1]);
                $start = rtrim($start, "-");
                $end= preg_replace('/' . '-' . '/', '', $end, 1);
            }
            $query = '';
                $data = array();
                $records_per_page = 10;
                $start_from = 0;
                $current_page_number = 0;
                if(isset($_POST["rowCount"]))
                {
                $records_per_page = $_POST["rowCount"];
                }
                else
                {
                $records_per_page = 10;
                }
                if(isset($_POST["current"]))
                {
                $current_page_number = $_POST["current"];
                }
                else
                {
                $current_page_number = 1;
                }
                $start_from = ($current_page_number - 1) * $records_per_page;
                $usertype = $this->session->userdata('user_type');
                    $this->db->select("(select (sum(due_amount_usd)) from product_purchase where supplier_id= `b`.`supplier_id`) as due_amount_usd,(select (sum(balance)) from product_purchase where supplier_id= `b`.`supplier_id`) as inv_due_amount_usd,(select (sum(balances)) from service where service_provider_name= `a`.`supplier_name`) as service_balance, a.*,b.HeadCode,((select ifnull(sum(Debit),0) from acc_transaction where COAID= `b`.`HeadCode` AND IsAppove = 1)-(select ifnull(sum(Credit),0) from acc_transaction where COAID= `b`.`HeadCode` AND IsAppove = 1)) as balance");
                    $this->db->from('supplier_information a');
                    $this->db->join('acc_coa b','a.supplier_id = b.supplier_id','left');
                    $this->db->group_by('a.supplier_id');
                    $this->db->where('a.created_by',$this->session->userdata('user_id'));
                if($date) {
                if(!empty($start) && !empty($end)){
                    $this->db->where('a.date >=',$start);
                $this->db->where('a.date <=',$end);
                }
                }
                if(!empty($_POST["searchPhrase"]))
                {
                $query .= 'WHERE (a.supplier_name LIKE "%'.$_POST["searchPhrase"].'%" ';
                $query .= 'OR a.address LIKE "%'.$_POST["searchPhrase"].'%" ';
                $query .= 'OR a.mobile LIKE "%'.$_POST["searchPhrase"].'%" ';
                $query .= 'OR a.businessphone LIKE "%'.$_POST["searchPhrase"].'%" ) ';
                $query .= 'OR a.primaryemail LIKE "%'.$_POST["searchPhrase"].'%" ) ';
                $query .= 'OR a.city LIKE "%'.$_POST["searchPhrase"].'%" ) ';
                $query .= 'OR a.country LIKE "%'.$_POST["searchPhrase"].'%" ) ';
                }
                $order_by = '';
                if(isset($_POST["sort"]) && is_array($_POST["sort"]))
                {
                foreach($_POST["sort"] as $key => $value)
                {
                $order_by .= " $key $value, ";
                }
                }
                else
                {
                $query .= 'ORDER BY a.id DESC ';
                }
                
                if($records_per_page != -1)
                {
                $query .= " LIMIT " . $start_from . ", " . $records_per_page;
                }
                    $query = $this->db->get();
                $result = $query->result_array();
                foreach($result as $row)
            {
                $data[] = $row;
            }
                $this->db->select("a.*,b.HeadCode,((select ifnull(sum(Debit),0) from acc_transaction where COAID= `b`.`HeadCode` AND IsAppove = 1)-(select ifnull(sum(Credit),0) from acc_transaction where COAID= `b`.`HeadCode` AND IsAppove = 1)) as balance");
                    $this->db->from('supplier_information a');
                    $this->db->join('acc_coa b','a.supplier_id = b.supplier_id','left');
                    $this->db->group_by('a.supplier_id');
                    $this->db->where('a.created_by',$this->session->userdata('user_id'));
                $this->db->get();
                $result1 = $query->result_array();
                $total_records = $query->num_rows();
                    $output = array(
                'rows'   => $data
                );
            return $output;
            }




}
