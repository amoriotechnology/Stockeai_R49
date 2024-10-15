<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Permission_model extends CI_Model {
	public function __construct(){
		parent::__construct();
	}



    
  
    public function editadmin_role_update($unique_id, $user_type) {
        try {
            $this->db->where('admin_comp', $unique_id);
            $this->db->update('company_assignrole', array('roleid' => $user_type)); // Assuming 'roleid' is the field to update
            // echo $this->db->last_query(); 
            // die();
             if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                throw new Exception("No rows affected.");
            }
        } catch (Exception $e) {
             error_log("Error in editadmin_role_update: " . $e->getMessage());
            return false;
        }
    }
    
    

    
    public function user_role_name($unique_id) {
        $this->db->select('a.*, b.*'); // Select all columns from tables a and b
        $this->db->from('company_assignrole a'); // Correct table alias syntax
        $this->db->join('super_role b', 'b.id = a.roleid'); // Correct join condition assuming role_id exists in company_assignrole
        $this->db->where('a.admin_comp', $unique_id); // Correct column name in where clause
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        if (!$query) {
            return false;
        }
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    





    public function admin_roleedit($unique_id) {
        $this->db->select("a.*, b.company_name ,b.company_id ");
        $this->db->from('user_login a');
        $this->db->join('company_information b', 'b.company_id = a.cid');
        $this->db->where('a.unique_id', $unique_id);
        $query = $this->db->get();
        //  echo $this->db->last_query(); die();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    




    public function get_data_company() {
        $this->db->select("a.*, b.company_name ,b.company_id ");
        $this->db->from('user_login a');
        $this->db->join('company_information b', 'b.company_id = a.cid');
         $query = $this->db->get();
        //  echo $this->db->last_query(); die();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    







	public function adminassignrole_list() {
      
        $this->db->select('comp.company_name, userlog.username,  comassg.*');
        $this->db->from('company_information comp');
        $this->db->join('user_login userlog', 'userlog.user_id = comp.company_id', 'left');
        $this->db->join('company_assignrole comassg', 'comassg.user_id = comp.company_id', 'left');
         
        $query = $this->db->get();

    //    echo $this->db->last_query(); die();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    

 

	//customer List
	public function permission_list(){
		$this->db->select('*');
		$this->db->from('module');
		$this->db->where('status',1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
		return false;
	}


 public function super_rolepermission_list(){
        $this->db->select('*');
        $this->db->from('super_module');
        $this->db->where('status',1);
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function super_count(){
        $query = $this->db->query('select * from super_role');
        return $query->num_rows();
    }



    public function super_user_list(){
        $this->db->select('*');
        $this->db->from('super_role');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //customer List
    public function  superpermission_list(){
        $this->db->select('*');
        $this->db->from('super_module');
        $this->db->where('status',1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function super_role_list(){
        $this->db->select('*');
        $this->db->from('super_role');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function details_permission_list(){
    $this->db->select('*');
    $this->db->from('super_module');
    $this->db->where('status',1);
        //  $this->db->where('id' , $id);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
        return $query->result_array();
    }
    return false;
}
public function role_edit_super($id = null){
    $this->db->select('super_permission.*,super_module.name');
         $this->db->from('super_permission');
         $this->db->join('super_module','super_module.id=super_permission.fk_module_id');
         $this->db->where('super_permission.role_id',$id);
        $sql='SELECT GROUP_CONCAT(CONCAT(`menu`, " - ", `create`) SEPARATOR ", ") AS items FROM super_permission';
         $query = $this->db->get();
        //  echo $this->db->last_query();
     if ($query->num_rows() > 0) {
         return $query->result_array();
     }
 }
public function details_list_info($id){
    $this->db->select('*');
    $this->db->from('super_role');
     $this->db->where('id' , $id);
    $query = $this->db->get();
    // echo $this->db->last_query(); die();
    if ($query->num_rows() > 0) {
        return $query->result_array();
    }
    return false;
}
public function delete_role_super($id){
    $this->db->set('is_deleted',1);
    $this->db->where('id',$id);
    $this->db->update('super_role');
    return true;
}
public function delete_role_permission_super($id){
      $this->db->set('is_deleted',1);
    $this->db->where('role_id',$id);
    $this->db->update('super_permission');
    return true;
}
    public function company_role_create($postData = array()){
        $this->db->insert('company_assignrole',$postData);
    }
    public function company_admin_data($admin_id){
        $this->db->select('*');
        $this->db->from('user_login');
        $this->db->where('cid',$admin_id);
        $this->db->where('u_type',2);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    public function module_list2(){
        $this->db->select('*');
        $this->db->from('module');
        $this->db->where('status',1);
      return  $query = $this->db->get()->result();
    }
    public function user_count(){
        $query = $this->db->query('select * from sec_role');  
        return $query->num_rows();
    }
// ****************



    public function  role_edit2($id){
      $sql='SELECT GROUP_CONCAT(CONCAT(`menu`, " - ", `create`,`price`,`update`,`delete`) SEPARATOR ", ") AS items FROM role_permission where role_id='.$id;


$query=$this->db->query($sql);

        return $query->result_array();
    }
    public function  role_name($uid){
        $query = $this->db->query('select * from sec_role where id="'.$uid.'"');
        return $query->result_array();
    }
    

// ****************




	public function user_list(){
		$this->db->select('*');
		$this->db->from('sec_role');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
    public function user(){
         $this->db->select('*');
        $this->db->from('users');
      //  $this->db->where('create_by',$this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function create($data = array()){
	
		$this->db->where('role_id', $data[0]['role_id'])->delete('role_permission');
		return $this->db->insert_batch('role_permission', $data);
	}
    public function role_create($postData = array()){
        $this->db->insert('sec_userrole',$postData);
    }
    public function insert_user_entry($data = array()){
        $this->db->insert('sec_role',$data);
        return $insert_id = $this->db->insert_id();
    }
    public function userdata_editdata($id){
        $this->db->select('*');
        $this->db->from('sec_role');
        $this->db->where('id',$id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function update_role($data,$id){
        $this->db->where('id',$id);
        $this->db->update('sec_role',$data);
        return true;
    }
    public function delete_role($id){
        $this->db->where('id',$id);
        $this->db->delete('sec_role');
        return true;
    }
    public function delete_role_permission($id){
        $this->db->where('role_id',$id);
        $this->db->delete('role_permission');
        return true;
    }
    public function module(){
        return $modules = $this->db->select('*')->from('module')->get()->result();

    }





    public function role($id = null){
      return  $data = $this->db->select('*')
             ->from('sec_role')
             ->where('id',$id)
             ->get()
             ->result();
    }




    public function role_edit($id = null){
       $this->db->select('role_permission.*,sub_module.name');
            $this->db->from('role_permission');
            $this->db->join('sub_module','sub_module.id=role_permission.fk_module_id');
            $this->db->where('role_permission.role_id',$id);
           $sql='SELECT GROUP_CONCAT(CONCAT(`menu`, " - ", `create`,`read`,`update`,`delete`) SEPARATOR ", ") AS items FROM role_permission';
 
        //     $sql='SELECT role_permission.*,sub_module.name from role_permission as a join sub_module b on b.id=a.fk_module_id where a.role_id='.$id;
        //   echo $sql;die();
            $query = $this->db->get();
       //     echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
        public function assign_role()
    {

        $uid=$_SESSION['user_id'];
         $sql='SELECT b.* from sec_userrole as a join role_permission b on b.role_id=a.roleid where a.user_id='.$uid;
        $query = $this->db->query($sql);  

        return $query->result();

    }
    public function role_update($data,$id){
         
        $this->db->where('id',$id);
        $this->db->update('sec_role',$data);
        return true;
    }
    public function moduleinfo($id){
     return $info = $this->db->select('*')->from('module')->where('id',$id)->where('status',1)->get()->row();
    }
    //module list
    public function module_list(){
       return $module = $this->db->select('*')
            ->from('module')
            ->get()
            ->result();  
    }
    // menu info id wise
    public function menuinfo($id){
         return $info = $this->db->select('*')->from('sub_module')->where('id',$id)->where('status',1)->get()->row();
    }


















     

  
    public function getTotalRolelist($search){
         $this->db->select("COUNT(*) as count");
        $this->db->from('super_role');

        if (!empty($search)) {
            $this->db->group_start(); // Start a group for OR conditions
            $this->db->like('type', $search);
            $this->db->group_end(); // End the group
        }
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();

        //echo $this->db->last_query(); exit;
       $result = $query->row_array();
        
        return $result;
        }



public function getPaginatedRole($limit, $offset, $orderField, $orderDirection, $search) {
    $this->db->select("type, id");
    $this->db->from('super_role');
    
    if (!empty($search)) {
        $this->db->group_start(); // Start a group for OR conditions
        $this->db->like('type', $search);
        $this->db->group_end(); // End the group
    }
    
    $this->db->limit($limit, $offset);
    $this->db->order_by($orderField, $orderDirection);
         $this->db->where('is_deleted', 0);
    $query = $this->db->get();
  
    if (!$query) {
        $error = $this->db->error();
        log_message('error', 'Database Error: ' . $error['message']);
        return []; // Return empty array or handle as needed
    }
    
    $result = $query->result_array();
    return $result;
}

  public function getAdminAssignRole($search)
  { 
  $this->db->select("a.username ,a.email_id , b.company_name, b.company_id");
  $this->db->from('user_login a');
  $this->db->join('company_information b', 'b.company_id = a.cid');
  if (!empty($search)) {
      $this->db->group_start(); // Start a group for OR conditions
      $this->db->like('b.company_name', $search);
      $this->db->or_like('a.username', $search);
      $this->db->or_like('a.email_id', $search);
      $this->db->group_end(); // End the group
  }
  $query = $this->db->get();
  return $query->num_rows();
}
 public function getAssignedRole($search)
  { 
  $this->db->select("a.username , b.company_name, d.type,a.unique_id");
  $this->db->from('user_login a');
  $this->db->join('company_information b', 'b.company_id = a.cid');
   $this->db->join('company_assignrole c', 'b.company_id = c.user_id');
    $this->db->join('super_role d', 'c.roleid = d.id');
  
  if (!empty($search)) {
      $this->db->group_start(); // Start a group for OR conditions
      $this->db->like('b.company_name', $search);
      $this->db->or_like('a.username', $search);
      $this->db->or_like('d.type', $search);
      $this->db->group_end(); // End the group
  }
  $query = $this->db->get();
  return $query->num_rows();
}
 public function getPaginatedAssignedRole($limit, $offset, $orderField, $orderDirection, $search)
{
    $this->db->select('b.company_name, a.username,d.type,a.unique_id');
   $this->db->from('user_login a');
  $this->db->join('company_information b', 'b.company_id = a.cid');
   $this->db->join('company_assignrole c', 'b.company_id = c.user_id');
    $this->db->join('super_role d', 'c.roleid = d.id');
    if (!empty($search)) {
        $this->db->group_start(); // Start a group for OR conditions
      $this->db->like('b.company_name', $search);
      $this->db->or_like('a.username', $search);
      $this->db->or_like('d.type', $search);
        $this->db->group_end(); // End the group
    }
    $this->db->limit($limit, $offset);
    $this->db->order_by($orderField, $orderDirection);
    $query = $this->db->get();
    //  echo $this->db->last_query(); die();
    if (!$query) {
        $error = $this->db->error();
        log_message('error', 'Database Error: ' . $error['message']);
        return []; // Return empty array or handle as needed
    }
    $result = $query->result_array();
    return $result;
}
public function getPaginatedAssignRole($limit, $offset, $orderField, $orderDirection, $search)
{
    $this->db->select('b.company_name, a.username, a.email_id ,a.unique_id');
    $this->db->from('user_login a');
    $this->db->join('company_information b', 'b.company_id = a.cid');
    if (!empty($search)) {
        $this->db->group_start(); // Start a group for OR conditions
        $this->db->like('b.company_name', $search);
        $this->db->or_like('a.username', $search);
        $this->db->or_like('a.email_id', $search);
        $this->db->group_end(); // End the group
    }
    $this->db->limit($limit, $offset);
    $this->db->order_by($orderField, $orderDirection);
    $query = $this->db->get();
    //  echo $this->db->last_query(); die();
    if (!$query) {
        $error = $this->db->error();
        log_message('error', 'Database Error: ' . $error['message']);
        return []; // Return empty array or handle as needed
    }
    $result = $query->result_array();
    return $result;
}


   public function get_modules() {
        return $this->db->get('super_module')->result_array();
    }

    public function update_roles($rolename, $rid, $permissions) {
      $date = date('Y-m-d H:i:s');
          $this->db->set('type', $rolename);
          $this->db->set('modified_date', $date);
          
        $this->db->where('id', $rid);
        $this->db->update('super_role');

        // Delete existing permissions
        $this->db->where('role_id', $rid);
        $this->db->delete('super_permission');

        // Insert new permissions
        foreach ($permissions as $permission) {
            $this->db->insert('super_permission', $permission);
        }
    }





}