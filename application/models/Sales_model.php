<?php 
/*created by - Vijila
created date - 26-07-2024
sales - ocean Export tracking
sales - road transport 
Modified Date - 26-07-2024
Modified By - Vijila */

defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_model extends CI_Model {

    public function getOceanExportsdata($limit, $start, $orderField, $orderDirection, $searchValue, $decodedId) {

        $searchQuery = "";
         if($searchValue != ''){
            $searchQuery = " (a.booking_no like '%".$searchValue."%' or a.container_no like '%".$searchValue."%' or a.seal_no like '%".$searchValue."%' or a.etd like '%".$searchValue."%' or a.eta like '%".$searchValue."%' or a.supplier_id like '%".$searchValue."%' or a.shipper like '%".$searchValue."%' or a.invoice_date like '%".$searchValue."%' or a.consignee like '%".$searchValue."%' or a.notify_party like '%".$searchValue."%' or a.vessel like '%".$searchValue."%' or a.voyage_no like '%".$searchValue."%' or a.port_of_loading like '%".$searchValue."%' or a.port_of_discharge like '%".$searchValue."%' or a.place_of_delivery like '%".$searchValue."%' or a.freight_forwarder like '%".$searchValue."%' or a.particular like '%".$searchValue."%' or a.customs_broker_name like '%".$searchValue."%' or a.hbl_no like '%".$searchValue."%' or a.obl_no like '%".$searchValue."%' or a.ams_no like '%".$searchValue."%' or a.isf_no like '%".$searchValue."%' or a.mbl_no like '%".$searchValue."%') ";
         }
         $this->db->select("a.*,s.supplier_name");
         $this->db->from('ocean_export_tracking a');
         $this->db->join('supplier_information s','s.supplier_id = a.supplier_id','left');
         $this->db->where('a.created_by',$decodedId);
         $this->db->where('a.is_deleted',0);
         if($searchValue != '')
         $this->db->where($searchQuery);
         $this->db->order_by($orderField, $orderDirection);
         $this->db->limit($limit, $start);
         $records = $this->db->get()->result();
         return $records;
    }


    public function getOceanExportCount($searchValue,$companyId){
        $searchQuery = "";
        if($searchValue != ''){
            $searchQuery = " (a.booking_no like '%".$searchValue."%' or a.container_no like '%".$searchValue."%' or a.seal_no like '%".$searchValue."%' or a.etd like '%".$searchValue."%' or a.eta like '%".$searchValue."%' or a.supplier_id like '%".$searchValue."%' or a.shipper like '%".$searchValue."%' or a.invoice_date like '%".$searchValue."%' or a.consignee like '%".$searchValue."%' or a.notify_party like '%".$searchValue."%' or a.vessel like '%".$searchValue."%' or a.voyage_no like '%".$searchValue."%' or a.port_of_loading like '%".$searchValue."%' or a.port_of_discharge like '%".$searchValue."%' or a.place_of_delivery like '%".$searchValue."%' or a.freight_forwarder like '%".$searchValue."%' or a.particular like '%".$searchValue."%' or a.customs_broker_name like '%".$searchValue."%' or a.hbl_no like '%".$searchValue."%' or a.obl_no like '%".$searchValue."%' or a.ams_no like '%".$searchValue."%' or a.isf_no like '%".$searchValue."%' or a.mbl_no like '%".$searchValue."%') ";
        }
        $this->db->select('a.id');
         $this->db->from('ocean_export_tracking a');
         $this->db->where('a.created_by',$companyId);
         $this->db->where('a.is_deleted',0);
          if($searchValue != '')
         $this->db->where($searchQuery);
         $records = $this->db->get()->num_rows();
         return $records; 
    }

    public function insertOceanExport($data){
        if(!empty($data)){
            $this->db->insert('ocean_export_tracking',$data);
            return $this->db->insert_id();
        }else{
            return false;
        }
        
    }
    public function updateOceanExport($data,$bookingid){
        if(!empty($data)){
            $this->db->where('id',$bookingid);
            $this->db->update('ocean_export_tracking',$data);
            return $bookingid;
        }else{
            return false;
        }
        
    }

    

    public function getRoadtransportCount($searchValue, $companyId) {
        $searchQuery = "";
    
        if ($searchValue != '') {
            $searchQuery = "(
                a.invoice_no LIKE '%" . $searchValue . "%' OR
                a.invoice_date LIKE '%" . $searchValue . "%' OR
                b.customer_name LIKE '%" . $searchValue . "%' OR
                a.trucking_id LIKE '%" . $searchValue . "%' OR
                a.container_pickup_date LIKE '%" . $searchValue . "%' OR
                a.delivery_date LIKE '%" . $searchValue . "%' OR
                a.shipment_company LIKE '%" . $searchValue . "%' OR
                a.delivery_time_from LIKE '%" . $searchValue . "%' OR
                a.delivery_time_to LIKE '%" . $searchValue . "%' OR
                a.truck_no LIKE '%" . $searchValue . "%' OR
                a.delivery_to LIKE '%" . $searchValue . "%' OR
                a.tax LIKE '%" . $searchValue . "%' OR
                a.grand_total_amount LIKE '%" . $searchValue . "%' OR
                a.customer_gtotal LIKE '%" . $searchValue . "%' OR
                a.amt_paid LIKE '%" . $searchValue . "%' OR
                a.balance LIKE '%" . $searchValue . "%'
            )";
        }
    
        $this->db->select('count(*) as total_count');
        $this->db->from('sale_trucking a');
        $this->db->join('customer_information b', 'b.customer_id = a.bill_to', 'left');
        $this->db->where('a.create_by', $companyId);
        $this->db->where('a.is_deleted', 0);
        if ($searchValue != '') {
            $this->db->where($searchQuery);
        }
        $records = $this->db->get()->result_array();
        //echo $this->db->last_query(); exit;
        return $records[0]['total_count'];
    }
    

    


    public function getRoadtransportsdata($limit, $start, $orderField, $orderDirection, $searchValue, $decodedId) {

        $searchQuery = "";
         if($searchValue != ''){
            $searchQuery = "(
                a.invoice_no LIKE '%" . $searchValue . "%' OR
                a.invoice_date LIKE '%" . $searchValue . "%' OR
                b.customer_name LIKE '%" . $searchValue . "%' OR
                a.trucking_id LIKE '%" . $searchValue . "%' OR
                a.container_pickup_date LIKE '%" . $searchValue . "%' OR
                a.delivery_date LIKE '%" . $searchValue . "%' OR
                a.shipment_company LIKE '%" . $searchValue . "%' OR
                a.delivery_time_from LIKE '%" . $searchValue . "%' OR
                a.delivery_time_to LIKE '%" . $searchValue . "%' OR
                a.truck_no LIKE '%" . $searchValue . "%' OR
                a.delivery_to LIKE '%" . $searchValue . "%' OR
                a.tax LIKE '%" . $searchValue . "%' OR
                a.grand_total_amount LIKE '%" . $searchValue . "%' OR
                a.customer_gtotal LIKE '%" . $searchValue . "%' OR
                a.amt_paid LIKE '%" . $searchValue . "%' OR
                a.balance LIKE '%" . $searchValue . "%'
            )";         }
            $this->db->select('a.*, b.customer_name,c.supplier_name');
            $this->db->from('sale_trucking a');
            $this->db->join('customer_information b', 'b.customer_id = a.bill_to', 'left');
            $this->db->join('supplier_information c', 'c.supplier_id = a.shipment_company', 'left');
            $this->db->where('a.create_by',$decodedId);
            $this->db->where('a.is_deleted',0);
  
    if($searchValue != ''){
        $this->db->where($searchQuery);
    }
    $this->db->order_by($orderField, $orderDirection);
    $this->db->limit($limit, $start);
    $records = $this->db->get()->result();
    return $records;
}

public function getOceanExportData($id){
    $this->db->select("booking_no");
    $this->db->from('ocean_export_tracking');
    $this->db->where('id',$id);
    $records = $this->db->get()->result_array();
    return $records[0];
}
public function deleteAttachment($id){
    $this->db->where('id',$id);
    $this->db->delete('attachments');
    return true;
}
public function updateRoadTruck($data,$id){
    if(!empty($data)){
        $this->db->where('id',$id);
        $this->db->update('sale_trucking',$data);
        return $id;
    }else{
        return false;
    }
    
}
}