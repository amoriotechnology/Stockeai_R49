<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Companies extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function companyList($id = null)
	{
		$this->db->select('*');
		$this->db->from('company_information');
		$this->db->where('company_id', $id);
		$query = $this->db->get();   
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	public function editurlstdata($company_id)
    {
        $this->db->select('*');
        $this->db->from('url_st');
		$this->db->where('company_id', $company_id);
        $this->db->where('create_by', $this->session->userdata('user_id'));
        $query = $this->db->get();
		if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
	public function editurllctxdata($company_id)
    {
        $this->db->select('*');
        $this->db->from('url_lctx');
		$this->db->where('company_id', $company_id);
        $this->db->where('create_by', $this->session->userdata('user_id'));
        $query = $this->db->get();
		if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
	public function editurlsstxdata($company_id)
    {
        $this->db->select('*');
        $this->db->from('url_sstx');
		$this->db->where('company_id', $company_id);
        $this->db->where('create_by', $this->session->userdata('user_id'));
        $query = $this->db->get();
		if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
public function editurldata($company_id)
    {
        $this->db->select('*');
        $this->db->from('url');
		$this->db->where('company_id', $company_id);
        $this->db->where('create_by', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
	#============Count Company=============#
	public function count_company()
	{
		return $this->db->count_all("company_information");
	}
	#=============Company List=============#
	public function company_list()
	{
		$this->db->select('*');
		$this->db->from('company_information');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	public function getemailConfig()
    {
        $this->db->select('*');
        $this->db->from('email_config');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    public function editstatedata()
    {
        $this->db->select('*');
        $this->db->from('state_tax_id');
        $this->db->where('create_by', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
	public function editlocaldata()
    {
        $this->db->select('*');
        $this->db->from('local_tax_id');
        $this->db->where('create_by', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    // Changed by Ajith on 27-08-2024
	public function retrieve_localtax($decodedId)
    {
        $this->db->select('*');
        $this->db->from('local_tax_id');
        $this->db->where('create_by',$decodedId);
        $query = $this->db->get();
		// echo $this->db->last_query(); die();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    // Changed by Ajith on 27-08-2024
	public function retrieve_statetax($decodedId)
    {
        $this->db->select('*');
        $this->db->from('state_tax_id');
        $this->db->where('create_by', $decodedId);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

public function company_info()
	{
		$this->db->select('*');
		$this->db->from('company_information');
		$this->db->where('company_id', $this->session->userdata('user_id'));
		$query = $this->db->get();
 		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}


	public function company_admin_info()
	{
		$this->db->select('*');
		$this->db->from('company_information');
		$this->db->where('create_by', $this->session->userdata('user_id'));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Changed by Aith on 27/08/2024
	public function company_details($decodedId){
		$this->db->select('*');
		$this->db->from('company_information');
		$this->db->where('create_by',$decodedId);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	#==============Company search list==============#
	public function company_search_item($company_id)
	{
		$this->db->select('*');
		$this->db->from('company_information');
		$this->db->where('company_id',$company_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	#============Insert company to database========#
	public function company_entry($data)
	{
		$this->db->insert('company_information',$data);
		$this->db->select('*');
		$this->db->from('company_information');
		$this->db->where('status',1);
		$query = $this->db->get();
		foreach ($query->result() as $row) {
			$json_product[] = array('label'=>$row->company_name,'value'=>$row->company_id);
		}
		$cache_file = './my-assets/js/admin_js/json/company.json';
		$productList = json_encode($json_product);
		file_put_contents($cache_file,$productList);
	}
	#==============Company edit data===============#
	public function retrieve_company_editdata($company_id)
	{
		$this->db->select('*');
		$this->db->from('company_information');
		$this->db->where('company_id',$company_id);
		$query = $this->db->get();
 		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	#==============Update company==================#
	public function update_company($data,$company_id)
	{
		$this->db->where('company_id',$company_id);
		$this->db->update('company_information',$data); 
        $this->db->select('*');
		$this->db->from('company_information');
		$this->db->where('status',1);
		$query = $this->db->get();
		foreach ($query->result() as $row) {
			$json_product[] = array('label'=>$row->company_name,'value'=>$row->company_id);
		}
		$cache_file = './my-assets/js/admin_js/json/company.json';
		$productList = json_encode($json_product);
		file_put_contents($cache_file,$productList);
		return true;
	}
	public function supplier_personal_data($supplier_id)
	{
		$this->db->select('*');
		$this->db->from('supplier_information');
		$this->db->where('supplier_id',$supplier_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	public function supplier_purchase_data($supplier_id)
	{
		$this->db->select('*');
		$this->db->from('product_purchase');
		$this->db->where(array('supplier_id'=>$supplier_id,'status'=>1));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	public function supplier_search_list($cat_id,$company_id)
	{
		$this->db->select('a.*,b.sub_category_name,c.category_name');
		$this->db->from('suppliers a');
		$this->db->join('supplier_sub_category b','b.sub_category_id = a.sub_category_id');
		$this->db->join('supplier_category c','c.category_id = b.category_id');
		$this->db->where('a.sister_company_id',$company_id);
		$this->db->where('c.category_id',$cat_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	public function suppliers_ledger($supplier_id)
	{ 
		$this->db->select('*');
		$this->db->from('supplier_ledger');
		$this->db->where('supplier_id',$supplier_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	public function suppliers_transection_summary($supplier_id)
	{
	 $result=array();
		$this->db->select_sum('amount','total_credit');
		$this->db->from('supplier_ledger');
		$this->db->where(array('supplier_id'=>$supplier_id,'deposit_no'=>NULL,'status'=>1));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result[]=$query->result_array();	
		}
		$this->db->select_sum('amount','total_debit');
		$this->db->from('supplier_ledger');
		$this->db->where(array('supplier_id'=>$supplier_id,'chalan_no'=>NULL,'status'=>1));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result[]=$query->result_array();	
		}
		return $result;
	}
	public function supplier_sales_details($supplier_id)
	{
		$from_date = $this->input->post('from_date');		
		$to_date = $this->input->post('to_date');
		$this->db->select('date,product_name,product_model,product_id,cartoon,quantity,supplier_rate,(quantity*supplier_rate) as total');
		$this->db->from('sales_report');
		$this->db->where('supplier_id',$supplier_id);
		if($from_date!=null AND $to_date!=null)
		{
			$this->db->where('date >',$from_date.' 00:00:00');
			$this->db->where('date <',$to_date.' 00:00:00');
		}
		$this->db->order_by('date','desc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	public function supplier_sales_summary($supplier_id)
	{
		$from_date = $this->input->post('from_date');		
		$to_date = $this->input->post('to_date');
		$this->db->select('date,product_name,product_model,product_id,sum(cartoon) as cartoon, sum(quantity) as quantity ,supplier_rate,sum(quantity*supplier_rate) as total');
		$this->db->from('sales_report');
		$this->db->where('supplier_id',$supplier_id);
		if($from_date!=null AND $to_date!=null)
		{
			$this->db->where('date >=',$from_date.' 00:00:00');
			$this->db->where('date <=',$to_date.' 00:00:00');
		}
		$this->db->group_by('product_id,date,supplier_rate');
		$this->db->order_by('date','desc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	public function sales_payment_actual($supplier_id,$limit,$start_record,$from_date=null,$to_date=null)
	{
		$this->db->select('*');
		$this->db->from('sales_actual');
		$this->db->where('supplier_id',$supplier_id);
		if($from_date!=null AND $to_date!=null)
		{
			$this->db->where('date >',$from_date.' 00:00:00');
			$this->db->where('date <',$to_date.' 00:00:00');
		}
		$this->db->limit($limit, $start_record);
		$this->db->order_by('date');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	public function sales_payment_actual_total($supplier_id)
	{
		$this->db->select_sum('sub_total');
		$this->db->from('sales_actual');
		$this->db->where('supplier_id',$supplier_id);
		$this->db->where('sub_total >',0);
		$query = $this->db->get();
		$result=$query->result_array();
		$data[0]["debit"]=$result[0]["sub_total"];
		$this->db->select_sum('sub_total');
		$this->db->from('sales_actual');
		$this->db->where('supplier_id',$supplier_id);
		$this->db->where('sub_total <',0);
		$query = $this->db->get();
		$result=$query->result_array();
		$data[0]["credit"]=$result[0]["sub_total"];
		$data[0]["balance"]=$data[0]["debit"]+$data[0]["credit"];
		return $data;
	}
	public function supplier_paid_details($supplier_id)
	{
		$this->db->select('*');
		$this->db->from('supplier_ledger');
		$this->db->where('supplier_id',$supplier_id);
		$this->db->where('chalan_no',NULL);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	public function supplier_chalan_details($supplier_id)
	{ 
		$this->db->select('*');
		$this->db->from('supplier_ledger');
		$this->db->where('supplier_id',$supplier_id);
		$this->db->where('deposit_no',NULL);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	public function superadmin_companyedit_data($cid)
	{
		$this->db->select('*');
		$this->db->from('company_information');
		$this->db->where('company_id',$cid );
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	public function superadmin_companydelete_data($cid)
{
	 $date = date('Y-m-d H:i:s');
    if (!is_numeric($cid) || $cid <= 0) {
        return false;
    }
    if (!isset($this->db)) {
        $this->load->database();
    }
    $this->db->select('*');
    $this->db->from('company_information');
    $this->db->where('company_id', $cid);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
       $this->db->where('company_id', $cid);
$update_data = array(
    'is_deleted' => 1,
	'modified_date' => $date,
	'modified_by'  =>$this->session->userdata('user_id')
);
$delete = $this->db->update('company_information', $update_data);
        if ($delete) {
            return true;
        } else {
            return false;
        }
    }
    return false;
}
	public function getPaginatedCompanies($limit, $offset, $orderField, $orderDirection,$search)
	{
		$this->db->select('company_id,company_name,email,address,mobile,website,logo,payment_reminder_date,due_date,subscription_fees, follow_up_mail,currency,mail,user_name,password,c_city,c_state,status');
		$this->db->from('company_information');
		if($search !=""){
			$this->db->or_like(array('company_name' => $search, 'email' => $search,'address'=>$search,'mobile'=>$search,'website'=>$search));
		}
		$this->db->limit($limit, $offset);
		$this->db->order_by($orderField, $orderDirection);
		  $this->db->where('is_deleted', 0);
		$query = $this->db->get(); 
		$result =	$query->result_array();
		return $result;
	}
	public function getTotalCompanies($search)
    {
        $this->db->select('company_name');
		$this->db->from('company_information');
		if($search !=""){
			$this->db->or_like(array('company_name' => $search, 'email' => $search,'address'=>$search,'mobile'=>$search,'website'=>$search));
		}
		 $this->db->where('is_deleted', 0);
		$query = $this->db->get();
		return $query->num_rows();
    }
	public function getTotalAdmin($search)
	{
		$this->db->select("a.username ,a.email_id , b.company_name, b.company_id");
		$this->db->from('user_login a');
		$this->db->join('company_information b', 'b.company_id = a.cid');
		if (!empty($search)) {
			$this->db->group_start(); 
			$this->db->like('b.company_name', $search);
			$this->db->or_like('a.username', $search);
			$this->db->or_like('a.email_id', $search);
			$this->db->group_end(); 
		}
		 $this->db->where('a.is_deleted', 0);
		$query = $this->db->get();
		return $query->num_rows();
	}
	public function getPaginatedAdmin($limit, $offset, $orderField, $orderDirection, $search)
	{
		$this->db->select('b.company_name, a.username, a.email_id ,a.unique_id');
		$this->db->from('user_login a');
		$this->db->join('company_information b', 'b.company_id = a.cid');
		if (!empty($search)) {
			$this->db->group_start(); 
			$this->db->like('b.company_name', $search);
			$this->db->or_like('a.username', $search);
			$this->db->or_like('a.email_id', $search);
			$this->db->group_end(); 
		}
		$this->db->limit($limit, $offset);
		$this->db->order_by($orderField, $orderDirection);
		 $this->db->where('a.is_deleted', 0);
		$query = $this->db->get();
		if (!$query) {
			$error = $this->db->error();
			log_message('error', 'Database Error: ' . $error['message']);
			return []; 
		}
		$result = $query->result_array();
		return $result;
	}

 

	public function getTotalCompany($search, $Id) {
        $this->db->select('company_name,email,address,mobile,website,c_city,c_state,company_id');
        $this->db->from('company_information');
        if ($search != "") {
            $this->db->or_like(array('company_name' => $search, 'address' => $search, 'mobile' => $search, 'c_city' => $search,
                'c_state'=> $search, 'website'       => $search ,'company_id'       => $search));
        }
        $this->db->where('is_deleted', 0);
        $this->db->where('create_by', $Id);
        $query = $this->db->get();
        return $query->num_rows();
    }

 
	public function getPaginatedCompany($limit, $offset, $orderField, $orderDirection, $search, $Id) {
		$this->db->select('company_name,email,address,mobile,website,c_city,c_state,company_id');
        $this->db->from('company_information');
         if ($search != "") {
            $this->db->group_start();
            $this->db->like('company_name', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('address', $search);
            $this->db->or_like('mobile', $search);
            $this->db->or_like('website', $search);
            $this->db->or_like('c_city', $search);
			$this->db->or_like('c_state', $search);
			$this->db->or_like('company_id', $search);
            $this->db->group_end();
        }
        $this->db->where('is_deleted', 0);
        $this->db->where('create_by', $Id);
        $this->db->limit($limit, $offset);
        // $this->db->order_by($orderField, $orderDirection);
        $query  = $this->db->get();
        $result = $query->result_array();
        return $result;
    }




}