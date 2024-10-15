<?php
if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class Products extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function product_info_report($admin_id)
    {
        $this->db->select("a.*, b.*, COUNT(c.product_id) AS product_quantity");
        $this->db->from("product_information a");
        $this->db->join(
            "supplier_information b",
            "b.supplier_id = a.supplier_id",
            "left"
        );
        $this->db->join(
            "purchase_order_details c",
            "c.product_id = a.product_id",
            "left"
        );
        $this->db->where("a.created_by", $admin_id);
        $this->db->group_by("a.product_id, a.supplier_id");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    // public function get_products()
    // {
    //     $sql =
    //         "select a.*,b.category_name  from product_information a join product_category b on b.category_id=a.category_id limit 10";
    //     $query = $this->db->query($sql);
    //     if ($query->num_rows() > 0) {
    //         return $query->result_array();
    //     }
    // }

    //For Listing Products in 
    public function get_all_products_with_supplier()
    {
        $this->db->select("*");
        $this->db->from("product_information");
        $this->db->where("created_by", $this->session->userdata("user_id"));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    // For Product Datatable
    public function getPaginatedProducts(
        $limit,
        $offset,
        $orderField,
        $orderDirection,
        $search,
        $Id
    ) {
        $this->db->select(
            "a.product_id, a.product_name, a.category_name, a.unit, a.price, a.product_model, b.supplier_name, a.p_quantity, a.account_category, a.country, a.account_sub_category, a.account_subcat"
        );
        $this->db->from("product_information a");
        $this->db->join(
            "supplier_information b",
            "b.supplier_id = a.supplier_id",
            "left"
        );
        if ($search != "") {
            $this->db->group_start();
            $this->db->like("a.product_id", $search);
            $this->db->or_like("a.product_name", $search);
            $this->db->or_like("a.category_name", $search);
            $this->db->or_like("a.unit", $search);
            $this->db->or_like("a.price", $search);
            $this->db->or_like("a.product_model", $search);
            $this->db->or_like("b.supplier_name", $search);
            $this->db->or_like("a.p_quantity", $search);
            $this->db->or_like("a.account_category", $search);
            $this->db->or_like("a.account_sub_category", $search);
            $this->db->or_like("a.account_subcat", $search);
            $this->db->or_like("a.country", $search);
            $this->db->group_end();
        }
        $this->db->where("a.is_deleted", 0);
        $this->db->where("a.created_by", $Id);
        $this->db->limit($limit, $offset);
        $this->db->order_by($orderField, $orderDirection);
        $query = $this->db->get();
        
        $result = $query->result_array();
        return $result;
    }
    // For Product Datatable
    public function getTotalProducts($search, $Id)
    {
        $this->db->select("product_name,product_model");
        $this->db->from("product_information");
        if ($search != "") {
            $this->db->or_like([
                "product_name" => $search,
                "product_model" => $search,
                "product_id" => $search,
                "supplier_id" => $search,
                "category_name" => $search,
                "unit" => $search,
                "account_category" => $search,
                "account_sub_category" => $search,
                "account_subcat" => $search,
                "country" => $search,
            ]);
        }
        $this->db->where("is_deleted", 0);
        $this->db->where("created_by", $Id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    //Count Product
    public function count_product($admin_id)
    {
        $query = $this->db->select("*")->from("product_information")->where("created_by", $admin_id)->where("is_deleted", 0)->get();

        if ($query === false) {
            return 0;
        }
        return $query->num_rows();
    }

    public function get_profarma_product()
    {
        $this->db->select("a.*,b.*");
        $this->db->from("profarma_invoice a");
        $this->db->join(
            "profarma_invoice_details b",
            "b.purchase_id = a.purchase_id"
        );
        $this->db->where("a.sales_by", $this->session->userdata("user_id"));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    //For Listing the Products in Expense Create/Edit 
    public function get_all_products($company_id)
    {
        $this->db->select("*");
        $this->db->from("product_information");
        $this->db->where("created_by", $company_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    public function get_all_products_with_supplier_details()
    {
        $this->db->select("a.*,b.supplier_price,c.supplier_name");
        $this->db->from("product_information a");
        $this->db->join("supplier_product b", "b.product_id = a.product_id");
        $this->db->join(
            "supplier_information c",
            "b.supplier_id =c.supplier_id"
        );
        $this->db->where("a.created_by", $this->session->userdata("user_id"));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    // To calculate the Product Availablity for Product Index Page
    public function expense_product_all($admin_id)
    {
        $this->db->select(
            "a.product_id,b.product_name,COUNT(*) as available,b.p_quantity"
        );
        $this->db->from("product_purchase_details a");
        $this->db->join("product_information b", "b.product_id = a.product_id");
        $this->db->where("a.create_by", $admin_id);
        $this->db->group_by("a.product_id");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }else{
            return array();
        }
    }



    // To calculate the Product Availablity for Product Index Page
    public function sales_product_all($admin_id)
    {
        $this->db->select(
            "a.product_id,a.product_name,COUNT(*) as available ,b.p_quantity"
        );
        $this->db->from("invoice_details a");
        $this->db->join("product_information b", "b.product_id = a.product_id");
        $this->db->group_by("a.product_id");
        $this->db->where("a.created_by", $admin_id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }








    public function uniqueProductname(
        $uniqueproduct_name,
        $uniqueproduct_model,$uniqueproduct_id,
        $uniquecategory_name
    ) {
        $this->db->select(
            "p.product_name, p.product_model, p.category_name,p.product_id, c.category_name"
        );
        $this->db->from("product_information p");
        $this->db->join(
            "product_category c",
            "c.category_name = p.category_name"
        );
        $this->db->where("product_name", $uniqueproduct_name);
        $this->db->where("p.product_model", $uniqueproduct_model);
        $this->db->where("c.category_name", $uniquecategory_name);
        $this->db->where("p.product_id !=", $uniqueproduct_id);
        $this->db->where("p.created_by", $this->session->userdata("user_id"));
        $query = $this->db->get();
       if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            echo "not available";
        }
    }
    public function get_sales_product_history($pid, $company_id)
    {
        $this->db->select(
            "b.product_id,a.invoice_id as inv,a.commercial_invoice_number,b.*"
        );
        $this->db->from("invoice a");
        $this->db->join(
            "product_details_history b",
            "b.invoice_id = a.invoice_id"
        );
        $this->db->where("a.sales_by", $company_id);
        $this->db->where("b.product_id", $pid);
        $this->db->where("b.sales", "sales");
        $this->db->order_by("a.commercial_invoice_number", "asc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    public function get_expense_product_history($pid, $company_id)
    {
        $this->db->select(
            "a.product_id,a.product_name,a.bundle_no,b.chalan_no,a.purchase_id,c.*"
        );
        $this->db->from("product_purchase_details a");
        $this->db->join("product_purchase b", "b.purchase_id = a.purchase_id");
        $this->db->join(
            "product_details_history c",
            "a.product_id = c.product_id"
        );
        $this->db->where("a.create_by", $company_id);
        $this->db->where("a.product_id", $pid);
        $this->db->where("c.expenses", "expenses");
        $this->db->group_by("a.bundle_no");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    public function sales_products($id)
    {
        $sql = "SELECT * FROM `invoice_details` where product_id=" . $id;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
        return false;
    }
    public function expense_products($id)
    {
        $sql =
            "SELECT * FROM `product_purchase_details` where product_id=" . $id;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
        return false;
    }
    //Product List
    public function product_list_count()
    {
        $query = $this->db
            ->select(
                "supplier_information.*,product_information.*,supplier_product.*"
            )
            ->from("product_information")
            ->join(
                "supplier_product",
                "product_information.product_id = supplier_product.product_id",
                "left"
            )
            ->join(
                "supplier_information",
                "supplier_information.supplier_id = supplier_product.supplier_id",
                "left"
            )
            ->where(
                "product_information.created_by",
                $this->session->userdata("user_id")
            )
            ->order_by("product_information.product_name", "asc")
            ->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }
    //Product tax list
    public function retrieve_product_tax()
    {
        $result = $this->db
            ->select("*")
            ->from("tax_information")
            ->where("create_by", $this->session->userdata("user_id"))
            ->get()
            ->result();
        return $result;
    }
    //Tax selected item
    public function tax_selected_item($tax_id)
    {
        $result = $this->db
            ->select("*")
            ->from("tax_information")
            ->where("tax_id", $tax_id)
            ->where("create_by", $this->session->userdata("user_id"))
            ->get()
            ->result();
        return $result;
    }
    //Product generator id check
    public function product_id_check($product_id)
    {
        $query = $this->db
            ->select("*")
            ->from("product_information")
            ->where("product_id", $product_id)
            ->where("created_by", $this->session->userdata("user_id"))
            ->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    //For Product Update
    public function product_table($product_id)
    {
        $this->db->select("*");
        $this->db->from("product_details");
        $this->db->where("product_id", $product_id);
        $this->db->where("create_by", $this->session->userdata("user_id"));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //For Product Edit Data
    public function retrieve_product_editdata($product_id)
    { 
        $this->db->select(
            "product_information.*,supplier_information.supplier_name"
        );
        $this->db->from("product_information");
        $this->db->join(
            "supplier_information",
            "product_information.supplier_id = supplier_information.supplier_id",
            "left"
        );
        $this->db->where("product_information.product_id", $product_id);
        $this->db->where(
            "product_information.created_by",
            $this->session->userdata("user_id")
        );
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //Retrieve company Edit Data
    public function retrieve_company()
    {
        $this->db->select("*");
        $this->db->from("company_information");
        $this->db->limit("1");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //Update Categories

   


    public function update_product($data, $product_id)
    {
        $this->db->where("product_id", $product_id);
        $this->db->update("product_information", $data);
       
        $this->db->select("*");
        $this->db->from("product_information");
        $this->db->where("created_by", $this->session->userdata("user_id"));
        $this->db->where("is_deleted", 0);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $json_product[] = [
                "label" =>
                    $row->product_name . "-(" . $row->product_model . ")",
                "value" => $row->product_id,
            ];
        }
        $cache_file = "./my-assets/js/admin_js/json/product.json";
        $productList = json_encode($json_product);
        file_put_contents($cache_file, $productList);
        return true;
    }
    public function check_calculaton($product_id)
    {
        $this->db->select("*");
        $this->db->from("product_purchase_details");
        $this->db->where("product_id", $product_id);
        $this->db->where("create_by", $this->session->userdata("user_id"));
        $query = $this->db->get();
        return $query->num_rows();
    }
    // Delete Product Item
    public function delete_product($product_id)
    {
        $this->db->where("product_id", $product_id);
        $this->db->delete("product_information");
        $this->db->where("product_id", $product_id);
        $this->db->delete("supplier_product");
        return true;
    }
    //Product By Search
    public function product_search_item($product_id)
    {
        $query = $this->db
            ->select(
                "supplier_information.*,product_information.*,supplier_product.*"
            )
            ->from("product_information")
            ->join(
                "supplier_product",
                "product_information.product_id = supplier_product.product_id",
                "left"
            )
            ->join(
                "supplier_information",
                "supplier_product.supplier_id = supplier_information.supplier_id",
                "left"
            )
            ->order_by("product_information.product_id", "desc")
            ->where(
                "product_information.created_by",
                $this->session->userdata("user_id")
            )
            ->where("product_information.product_id", $product_id)
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //Duplicate Entry Checking
    public function product_model_search($product_model)
    {
        $this->db->select("*");
        $this->db->from("product_information");
        $this->db->where("product_model", $product_model);
        $this->db->where("created_by", $this->session->userdata("user_id"));
        $query = $this->db->get();
        return $this->db->affected_rows();
    }
    public function product_details($id)
    {
        $sql =
            'SELECT b.*,a.products_model,d.iso3,a.supplier_price,c.supplier_name,c.country,c.address,c.email_address FROM `supplier_product` a join product_information b on a.product_id=b.product_id JOIN supplier_information c on c.supplier_id=a.product_id
            join country d
            on d.name=c.country
        where b.id=' . $id;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    public function retrieve_product_details($id)
    {
        $this->db->select("*");
        $this->db->from("product_information");
        $this->db->where("product_id", $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function product_details_pdv($product_id)
    {
        $this->db->select("a.*,b.*,c.supplier_name");
        $this->db->from("product_information a");
        $this->db->join("product_details b", "b.product_id = a.product_id");
        $this->db->join(
            "supplier_information c",
            "c.supplier_id = a.supplier_id"
        );
        $this->db->where("a.product_id", $product_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            $this->db->select("a.*");
            $this->db->from("product_information a");
            $this->db->where("a.product_id", $product_id);
            $query = $this->db->get();
            return $query->result_array();
        }
        return false;
    }
    public function product_details_info($product_id)
    {
        $this->db->select("*");
        $this->db->from("product_information");
        $this->db->where("product_id", $product_id);
        $this->db->where("created_by", $this->session->userdata("user_id"));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    // Product Purchase Report
    public function product_purchase_info($product_id)
    {
        $this->db->select(
            "a.*,b.*,sum(b.quantity) as quantity,sum(b.total_amount) as total_amount,c.supplier_name"
        );
        $this->db->from("product_purchase a");
        $this->db->join(
            "product_purchase_details b",
            "b.purchase_id = a.purchase_id"
        );
        $this->db->join(
            "supplier_information c",
            "c.supplier_id = a.supplier_id"
        );
        $this->db->where("b.product_id", $product_id);
        $this->db->where("a.create_by", $this->session->userdata("user_id"));
        $this->db->order_by("a.purchase_id", "asc");
        $this->db->group_by("a.purchase_id");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }



  





}