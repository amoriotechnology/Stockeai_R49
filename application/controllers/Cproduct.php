<?php
if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}
class Cproduct extends CI_Controller {
    public $product_id;
    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model("Suppliers");
        $this->load->helper("lang_helper");
         $this->load->model("Products");
        $this->load->model("Categories");
        $this->load->model("Units");
        $this->load->library("auth");
        $this->load->library("lproduct");
        $encodedId = isset($_GET['id'])? $_GET["id"] : null;
        $this->admin_id   = decodeBase64UrlParameter($encodedId);
    }
    //Index page load
    public function index() {
      $CI = &get_instance();
        $CI->load->model("Products");
        $CI->load->model("Suppliers");
        $CI->load->model("Categories");
        $CI->load->model("Units");
        $CI->load->model("Web_settings");
       $encodedId     = isset($_GET["id"]) ? $_GET["id"] : null;
       $decodedId     = decodeBase64UrlParameter($encodedId);

        $currency_details = $CI->Web_settings->retrieve_setting_editdata($decodedId);
        $supplier = $CI->Suppliers->supplier_list($decodedId);
        $category_list = $CI->Categories->category_list_product($decodedId);
        $unit_list = $CI->Units->unit_list();
        $setting_detail = $CI->Web_settings->retrieve_setting_editdata($decodedId);
        $country_list = $CI->Web_settings->getCountryDetails();
        $data = [
            "currency" => $currency_details[0]["currency"],
            "title" => display("add_product"),
            "supplier" => $supplier,
            "category_list" => $category_list,
            "unit_list" => $unit_list,
            "country_list" => $country_list,
            "setting_detail" => $setting_detail,
        ];
        $productForm = $CI->parser->parse("product/add_product_form",$data,true);
      
        $this->template->full_admin_html_view($productForm);
    }
    public function getProductDatas() {
        $encodedId     = isset($_GET["id"]) ? $_GET["id"] : null;
       $decodedId     = decodeBase64UrlParameter($encodedId);
        $limit         = $this->input->post("length");
        $start         = $this->input->post("start");
        $search        = $this->input->post("search")["value"];
       $orderField     = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'] =='sl' ? 'product_name' : $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
        $orderDirection = $this->input->post("order")[0]["dir"];
        $totalItems     = $this->Products->getTotalProducts($search, $decodedId);
        $items          = $this->Products->getPaginatedProducts(
            $limit,
            $start,
            $orderField,
            $orderDirection,
            $search,
            $decodedId
        );
        $sales_count   = $this->Products->sales_product_all($decodedId);
        $expense_count = $this->Products->expense_product_all($decodedId);
        $data          = [];
        $i             = $start + 1;
        $edit          = "";
        $delete        = "";
        foreach ($items as $item) {
            $total    = $item["p_quantity"];
            $sale_sum = false;
            $ex_sum   = false;
            if ($sales_count) {
                foreach ($sales_count as $sale) {
                    if ($item["product_id"] == $sale["product_id"]) {
                        $total -= $sale["available"];
                        $sale_sum = true;
                    }
                }
            }
            if ($expense_count) {
                foreach ($expense_count as $expense) {
                    if ($item["product_id"] == $expense["product_id"]) {
                        $total += $expense["available"];
                        $ex_sum = true;
                    }
                }
            }
            if ($ex_sum && $sale_sum) {
                $total =
                    $item["p_quantity"] -
                    $sale["available"] +
                    $expense["available"];
            }
            $edit =
            '<a href="' . base_url("Cproduct/product_update_form?id=" . $encodedId . "&product_id=" . $item["product_id"]) .
                '" class="btnclr btn btn-sm" style="background-color:#424f5c; margin-right: 5px;"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            $delete =
            '<a onclick="return confirm(' . display("are_you_sure") . ')" href="' . base_url("Cproduct/product_delete_form?id=" .
                $encodedId . "&product_id=" . $item["product_id"]) .
                '" class="btnclr btn btn-sm" style="background-color:#424f5c; margin-right: 5px;"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            $product_name =
            '<a href="' . base_url("Cproduct/product_view?id=" . $encodedId . "&product_id=" . $item["product_id"]) . '">' .
                $item["product_name"] .
                "</a>";
            $row = [
                 'sl'               => $i,
                "product_name"  => $product_name,
                "product_model" => $item["product_model"],
                "product_id"    => $item["product_id"],
                "inventry"      => $total,
                "category_name" => $item["category_name"],
                "unit"          => $item["unit"],
                "price"         => $item["price"],
                "supplier_name" => $item["supplier_name"],
                "country"       => $item["country"],
                "p_quantity"    => $item["p_quantity"],
                "action"        => $edit . $delete,
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
    public function product_info() {
        $CI = &get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library("lproduct");
        $CI->load->model("Products");
        $CI->load->model("Web_settings");
        $data[
            "setting_detail"
        ]                      = $CI->Web_settings->retrieve_setting_editdata();
        $data["list"]          = $this->lproduct->product_list();
        $company_info          = $CI->Products->retrieve_company();
        $data["getsupplier"]   = $CI->Suppliers->get_all_supplier();
        $data["total_product"] = $CI->Products->count_product();
        $data["products"]      = $CI->Products->product_info_report();
        $data["company_info"]  = $company_info;
        $data["sale_count"]    = $CI->Products->sales_product_all();
        $data["expense_count"] = $CI->Products->expense_product_all();
        $data["category"]      = $CI->Products->get_products();
        $content               = $CI->parser->parse("report/product_report", $data, true);
        $this->template->full_admin_html_view($content);
    }
    //For Report - Product Stock
    public function product_info_stock() {
        $CI = &get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library("lproduct");
        $CI->load->model("Products");
        $CI->load->model("Web_settings");
        $setting_detail         = $CI->Web_settings->retrieve_setting_editdata();
        $data["list"]           = $this->lproduct->product_list();
        $company_info           = $CI->Products->retrieve_company();
        $data["getsupplier"]    = $CI->Suppliers->get_all_supplier();
        $data["total_product"]  = $CI->Products->count_product();
        $data["products"]       = $CI->Products->product_info_report();
        $data["company_info"]   = $company_info;
        $data["setting_detail"] = $setting_detail;
        $data["sale_count"]     = $CI->Products->sales_product_all();
        $data["expense_count"]  = $CI->Products->expense_product_all();
        $data["category"]       = $CI->Products->get_products();
        $content                = $CI->parser->parse("report/product_stock", $data, true);
        $this->template->full_admin_html_view($content);
    }
    // Search Product
    public function searchproduct() {
        $CI = &get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model("Products");
        $search_items = $this->input->post("searchField");
        $result       = $CI->Products->searchproduct_entry($search_items);
        echo json_encode($result);
    }
    // unique product name - add_product_form
    public function uniqueproductname() {
        $CI = &get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model("Products");
        $uniqueproduct_name  = $this->input->post("unique_pname");
        $uniqueproduct_model = $this->input->post("product_model");
        $uniquecategory_name = $this->input->post("category_name");
        $uniqueproduct_id = $this->input->post("product_id");
        $exists              = $CI->Products->uniqueProductname(
            $uniqueproduct_name,
            $uniqueproduct_model,
            $uniqueproduct_id,
            $uniquecategory_name
        );
    }
    // For Product Details Page - from Product Index
    public function product_view() {
        $CI = &get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library("lproduct");
        $content = $this->lproduct->product_view(
            $_GET["product_id"],
            decodeBase64UrlParameter($_GET["id"])
        );
        $this->template->full_admin_html_view($content);
    }
public function product_delete_form() {
    $product_id = $_GET['product_id'];
    $created_by = decodeBase64UrlParameter($_GET['id']);
    $data = array(
        'modified_date' => date('Y-m-d H:i:s'),
        'modified_by'   => $this->session->userdata('unique_id'),
        'is_deleted'    => 1,
    );
    $this->db->where('product_id', $product_id);
    $this->db->where('created_by', $created_by);
    $result = $this->db->update('product_information', $data);
    $this->db->where('product_id', $product_id);
    $this->db->where('create_by', $created_by);
    $supplier_data = array('is_deleted' => 1);
    $result2 = $this->db->update('product_details', $supplier_data); 
    $this->db->where('product_id', $product_id);
    $this->db->where('created_by', $created_by);
    $result3 = $this->db->update('supplier_product', $supplier_data); 
    if ($result !== false && $result2 !== false && $result3 !== false) {
        $this->session->set_userdata([
            'message' => 'Product successfully deleted.',
        ]);
          redirect(base_url('Cproduct/manage_product?id=' . $_GET['id']));
    } else {
        $this->session->set_userdata([
            'message' => 'Failed to delete product. Please try again.',
        ]);
          redirect(base_url('Cproduct/manage_product?id=' . $_GET['id']));
    }
}
    public function insert_product_form() {
        $this->form_validation->set_rules(
            "product_name",
            "Product Name",
            "required"
        );
        $this->form_validation->set_rules("model", "Product Model", "required");
        $this->form_validation->set_rules("price", "Price", "required|numeric");
        $this->form_validation->set_rules("quantity", "Quantity", "required|numeric");
        $this->form_validation->set_rules(
            "supplier_id",
            "Vendor Name",
            "required"
        );
        $this->form_validation->set_rules(
            "category_id",
            "Category",
            "required"
        );
        $this->form_validation->set_rules("thickness[]", "Thickness", "required|regex_match[/^\s*\d+(\.\d+)?\s*$/]");

        $this->form_validation->set_rules(
            "supplier_block_no[]",
            "Supplier Block Number",
            "required|regex_match[/^\d+(\.\d+)?$/]"
        );
        $this->form_validation->set_rules(
            "supplier_slab_no[]",
            "Supplier Slab No",
            "required|regex_match[/^\d+(\.\d+)?$/]"
        );
        $this->form_validation->set_rules(
            "gross_width[]",
            "Gross Width",
            "required|regex_match[/^\d+(\.\d+)?$/]"
        );
        $this->form_validation->set_rules(
            "gross_height[]",
            "Gross Height",
            "required|regex_match[/^\d+(\.\d+)?$/]"
        );
        $this->form_validation->set_rules(
            "bundle_no[]",
            "Bundle Number",
            "required|regex_match[/^\d+(\.\d+)?$/]"
        );
        $this->form_validation->set_rules(
            "net_width[]",
            "Net Width",
            "required|regex_match[/^\d+(\.\d+)?$/]"
        );
        $this->form_validation->set_rules(
            "net_height[]",
            "Net Height",
            "required|regex_match[/^\d+(\.\d+)?$/]"
        );
        $response = [];
     
        if ($this->form_validation->run() == false) {
            $response["status"] = "failure";
            $response["msg"]    = validation_errors();
        } else {
            $CI = &get_instance();
            $CI->auth->check_admin_auth();
            $CI->load->model("Products");
            $insertImages = "";
          
            $quantity     = !empty($this->input->post("quantity", true))
            ? $this->input->post("quantity", true)
            : 1;
            if ($quantity < 1) {
                $quantity = 1;
            }
             $product_id = $this->input->post("product_id", true);
            $check_product = $this->db
                ->select("*")
                ->from("product_information")
                ->where("product_id", $product_id)
                ->get()
                ->num_rows();
            $sup_price      = $this->input->post("supplier_price", true);
            $s_id           = $product_id;
            $product_model  = $this->input->post("model", true);
            $supplier_id    = $this->input->post("supplier_id", true);
            $supplier_price = $this->input->post("price", true);
            $products_model = $this->input->post("model", true);
            $supp_prd       = [
                "created_by"     => decodeBase64UrlParameter(
                    $this->input->post("id", true)
                ),
                "created_admin"  => $this->session->userdata("unique_id"),
                "product_id"     => $product_id,
                "supplier_id"    => $supplier_id,
                "supplier_price" => $supplier_price,
                "products_model" => $product_model,
            ];
            $purchase_id_1 = $this->db->where("product_id", $product_id);
            $q             = $this->db->get("supplier_product");
            $row           = $q->row_array();
            if (!empty($row["product_id"])) {
                $this->db->where("product_id", $product_id);
                $this->db->update("supplier_product", $supp_prd);
            } else {
                $this->db->insert("supplier_product", $supp_prd);
            }
            $thickness        = $this->input->post("thickness", true);
            $desc             = $this->input->post("description_table", true);
            $supplier_b_no    = $this->input->post("supplier_block_no", true);
            $supplier_slab_no = $this->input->post("supplier_slab_no", true);
            $gross_width      = $this->input->post("gross_width", true);
            $gross_height     = $this->input->post("gross_height", true);
            $gross_sq_ft      = $this->input->post("gross_sq_ft", true);
            $bundle_no        = $this->input->post("bundle_no", true);
            $net_width        = $this->input->post("net_width", true);
            $net_height       = $this->input->post("net_height", true);
            $net_sq_ft        = $this->input->post("net_sq_ft", true);
            $cost_sq_ft       = $this->input->post("cost_sq_ft", true);
            $cost_sq_slab     = $this->input->post("cost_sq_slab", true);
            $sales_amt_sq_ft  = $this->input->post("sales_amt_sq_ft", true);
            $sales_slab_amt   = $this->input->post("sales_slab_amt", true);
            $weight           = $this->input->post("weight", true);
            $origin           = $this->input->post("origin", true);
            $total_amt        = $this->input->post("total_amt", true);
            $slab_no          = $this->input->post("slab_no", true);
            $product_id       = $product_id;
            $purchase_id_2    = $this->db->where("product_id", $product_id);
            $q2               = $this->db->get("product_details");
            $row2             = $q2->row_array();
             if (!empty($row2["product_id"])) {
                    $this->db->where("product_id", $product_id);
                    $this->db->delete("product_details");
             }
            for ($i = 0, $n = count($thickness); $i < $n; $i++) {
                $prodt_name = $thickness[$i];
                $data1      = [
                    "product_id"        => $product_id,
                    "create_by"         => decodeBase64UrlParameter(
                        $this->input->post("id", true)
                    ),
                    "thickness"         => trim($thickness[$i]),
                    "description_table" => trim($desc[$i]),
                    "supplier_block_no" => trim($supplier_b_no[$i]),
                    "supplier_slab_no"  => trim($supplier_slab_no[$i]),
                    "total_amt"         => trim($total_amt[$i]),
                    "g_width"           => trim($gross_width[$i]),
                    "slab_no"           => trim($slab_no[$i]),
                    "g_height"          => trim($gross_height[$i]),
                    "gross_sqft"        => trim($gross_sq_ft[$i]),
                    "bundle_no"         => trim($bundle_no[$i]),
                    "n_width"           => trim($net_width[$i]),
                    "n_height"          => trim($net_height[$i]),
                    "net_sqft"          => trim($net_sq_ft[$i]),
                    "cost_sqft"         => trim($cost_sq_ft[$i]),
                    "cost_slab"         => trim($cost_sq_slab[$i]),
                    "sales_price_sqft"  => trim($sales_amt_sq_ft[$i]),
                    "sales_slab_price"  => trim($sales_slab_amt[$i]),
                    "weight"            => trim($weight[$i]),
                    "origin"            => trim($origin[$i]),
                    "status"            => 1,
                ];
                $this->db->insert("product_details", $data1);
          }
            $price          = $this->input->post("price", true);
            $tax_percentage = $this->input->post("tax", true);
            $serial_no      = substr(time(), -7, -1);
            if ($this->input->post("serial_no", true)) {
                $serial_no = $this->input->post("serial_no", true);
            }
            $data["barcode"]          = $this->input->post("barcode", true);
            $data["product_id"]       = $product_id;
            $data["product_name"]     = $this->input->post("product_name", true);
            $data["category_name"]    = $this->input->post("category_id", true);
            $data["unit"]             = $this->input->post("unit", true);
            $data["country"]          = $this->input->post("country", true);
            $data["oa_total"]         = $this->input->post("oa_total", true);
            $data["supplier_id"]      = $this->input->post("supplier_id", true);
            $data["tax"]              = $this->input->post("tax", true);
            $data["account_category"] = $this->input->post(
                "account_category",
                true
            );
            $data["account_sub_category"] = $this->input->post(
                "account_sub_category",
                true
            );
            $data["account_subcat"] = $this->input->post(
                "account_subcat",
                true
            );
            $data["p_quantity"]      = $quantity;
            $data["serial_no"]       = $serial_no;
            $data["price"]           = $price;
            $data["product_model"]   = $this->input->post("model", true);
            $data["product_details"] = $this->input->post("description", true);
            $data["is_deleted"]      = 0;
            $purchase_id_3           = $this->db->where("product_id", $product_id);
            $q3                      = $this->db->get("product_information");
            $row3                    = $q3->row_array();
            $insert                  = "";
            if (!empty($row3["product_id"])) {
                $data["modified_date"] = date("Y-m-d H:i:s");
                $data["created_by"]    = decodeBase64UrlParameter(
                    $this->input->post("id", true)
                );
                $insert = $this->db
                    ->where("product_id", $product_id)
                    ->update("product_information", $data);
            } else {
                $data["created_admin"] = $this->session->userdata("unique_id");
                $data["created_by"]    = decodeBase64UrlParameter(
                    $this->input->post("id", true)
                );
                $insert = $this->db->insert("product_information", $data);
            }
            if ($product_id && $_FILES['attachments']['name'] != "") {
    $upload_data = file_upload('attachments', 'product', './uploads/product/');
    if ($upload_data['upload_data']['file_name'] != "") {
        $update_data = array('attachments' => $upload_data['upload_data']['file_name']);
        $res         = $this->Products->update_product($update_data, $product_id);
        $response    = array(
            'status' => 'success',
            'msg'    => 'Supplier has been added successfully.',
        );
    }
} else {
    $response = array(
        'status' => 'failure',
        'msg'    => 'Failed to update supplier.Try again...',
    );
}

            if ($insert) {
                $response["status"] = "success";
                $response["msg"]    = "Product has been saved successfully";
            } else {
                $response["status"] = "failure";
                $response["msg"]    = "Failed to add product. Please try again.";
            }
        }
        echo json_encode($response);
    }
    //For Inserting Product category
    public function insert_instant_cat() {
        $this->form_validation->set_rules(
            "category_name",
            "Category Name",
            "required"
        );
        $response = [];
        if ($this->form_validation->run() == false) {
            $response["status"] = "failure";
            $response["msg"]    = validation_errors();
        } else {
            $category_id = $this->auth->generator(15);
            $data        = [
                "created_by"    => decodeBase64UrlParameter($_GET["id"]),
                "created_admin" => $this->session->userdata("unique_id"),
                "category_id"   => $category_id,
                "category_name" => $this->input->post("category_name", true),
            ];
            $result = $this->Categories->category_entry($data);
            if ($result) {
                $response["status"] = "success";
                $response["msg"]    = "Category has been added successfully";
                $response["data"]   = $result;
            } else {
                $response["status"] = "failure";
                $response["msg"]    = "Failed to add category. Please try again.";
            }
        }
        echo json_encode($response);
    }
    //For Inserting Product Unit
    public function insert_instant_unit() {
        $this->form_validation->set_rules("unit_name", "Unit Name", "required");
        $response = [];
        if ($this->form_validation->run() == false) {
            $response["status"] = "failure";
            $response["msg"]    = validation_errors();
        } else {
            $unit_id = $this->auth->generator(15);
            $data    = [
                "created_by"    => decodeBase64UrlParameter($_GET["id"]),
                "created_admin" => $this->session->userdata("unique_id"),
                "unit_id"       => $unit_id,
                "unit_name"     => $this->input->post("unit_name", true),
                "status"        => 1,
            ];
            $result = $this->Units->insert_unit($data);
            if ($result) {
                $response["status"] = "success";
                $response["msg"]    = "Unit has been added successfully";
                $response["data"]   = $result;
            } else {
                $response["status"] = "failure";
                $response["msg"]    = "Failed to add unit. Please try again.";
            }
        }
        echo json_encode($response);
    }
    //For Product Update - from Index page
    public function product_update_form() {
        $product_id = isset($_GET["product_id"]) ? $_GET["product_id"] : null;
        $created_by = isset($_GET["id"]) ? $_GET["id"] : null;
        $CI         = &get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library("lproduct");
        $content = $CI->lproduct->product_edit_data( $product_id,$this->admin_id);
        $this->template->full_admin_html_view($content);
    }
    //Manage Product
    public function manage_product() {
        $this->auth->check_admin_auth();
        $this->load->library("lproduct");
        $this->load->model("Products");
        $content = $this->lproduct->product_list($this->admin_id);
        $this->template->full_admin_html_view($content);
    }
    public function get_all_tax() {
        $CI       = &get_instance();
        $taxfield = $CI->db
            ->select("tax_id,tax")
            ->from("tax_information")
            ->get()
            ->result_array();
        echo json_encode($taxfield);
    }
    public function product_details_edit() {
        $id         = $this->input->post("id", true);
        $desc       = $this->input->post("description", true);
        $notes      = $this->input->post("notes", true);
        $block      = $this->input->post("block", true);
        $product_id = $this->input->post("product_id", true);
        for ($i = 1, $n = count($desc); $i < $n; $i++) {
        }
        for ($i = 0, $n = count($desc); $i < $n; $i++) {
            $target_path = "uploads/product/";
            $file        = "";
            if (
                file_exists($_FILES["image"]["tmp_name"][$i]) ||
                is_uploaded_file($_FILES["image"]["tmp_name"][$i])
            ) {
                $target = "uploads/product/";
                move_uploaded_file(
                    $_FILES["image"]["tmp_name"][$i],
                    $target . $_FILES["image"]["name"][$i]
                );
                $file  = $target . $_FILES["image"]["name"][$i];
                $data1 = [
                    "block" => $block[$i],
                    "img"   => "uploads/product/" . $_FILES["image"]["name"][$i],
                    "notes" => $notes[$i],
                ];
                $this->db->where("description_table", $desc[$i]);
                $this->db->where("id", $id[$i]);
                $this->db->where("product_id", $product_id[$i]);
                $this->db->update("product_details", $data1);
            } else {
                $data1 = [
                    "block" => $block[$i],
                    "notes" => $notes[$i],
                ];
                $this->db->where("description_table", $desc[$i]);
                $this->db->where("id", $id[$i]);
                $this->db->where("product_id", $product_id[$i]);
                $this->db->update("product_details", $data1);
            }
        }
        echo json_encode($data1);
    }
    //For Product Cart - Quotation
    public function get_all_product1() {
        $CI    = &get_instance();
        $prodt = $CI->db
            ->select("product_name,product_model,p_quantity")
            ->from("product_information")
            ->get()
            ->result_array();
        echo json_encode($prodt);
    }
    public function get_all_product() {
        $CI    = &get_instance();
        $prodt = $CI->db
            ->select("product_name,product_model,p_quantity")
            ->from("product_information")
            ->get()
            ->result_array();
        $data2 = [
            "product" => $prodt,
        ];
        $invoiceForm1 = $CI->parser->parse(
            "invoice/add_invoice_form",
            $data2,
            true
        );
        return $invoiceForm1;
    }
    public function CheckProductList() {
        $this->load->model("Products");
        $postData = $this->input->post();
        $data     = $this->Products->getProductList($postData);
        $content  = $CI->parser->parse("invoice/add_invoice_form", $data, true);
        $content  = $CI->parser->parse("invoice/profarma_invoice", $data, true);
        return $content;
    }
    //Add Product CSV
    public function add_product_csv() {
        $CI   = &get_instance();
        $data = [
            "title" => display("add_product_csv"),
        ];
        $content = $CI->parser->parse("product/add_product_csv", $data, true);
        $this->template->full_admin_html_view($content);
    }
    //CSV Upload File
    function uploadCsv() {
        $this->load->model("suppliers");
        $CI = &get_instance();
        $CI->load->model("Products");
        $filename = $_FILES["upload_csv_file"]["name"];
        $ext      = substr(strrchr($filename, "."), 1);
        if ($ext == "csv") {
            $count = 0;
            ($fp = fopen($_FILES["upload_csv_file"]["tmp_name"], "r")) or
            die("can't open file");
            if (
                ($handle = fopen(
                    $_FILES["upload_csv_file"]["tmp_name"],
                    "r"
                )) !== false
            ) {
                while ($csv_line = fgetcsv($fp, 1024)) {
                    for ($i = 0, $j = count($csv_line); $i < $j; $i++) {
                        $product_id   = $this->generator(10);
                        $insert_csv   = [];
                        $product_name = !empty($csv_line[2])
                        ? $csv_line[2]
                        : null;
                        $title = explode("-", $product_name);
                        $name  = trim($title[0]);
                        if (empty($title[1])) {
                            $model = "";
                        } else {
                            $model = trim($title[1]);
                        }
                        $insert_csv["supplier_id"] = !empty($csv_line[1])
                        ? $csv_line[1]
                        : null;
                        $insert_csv["product_name"]  = $name;
                        $insert_csv["product_model"] = $model;
                        $insert_csv["category_id"]   = !empty($csv_line[3])
                        ? $csv_line[3]
                        : null;
                        $insert_csv["price"] = !empty($csv_line[4])
                        ? $csv_line[4]
                        : null;
                        $insert_csv["supplier_price"] = !empty($csv_line[5])
                        ? $csv_line[5]
                        : null;
                        $insert_csv["Barcode"] = !empty($csv_line[6])
                        ? $csv_line[6]
                        : null;
                        $insert_csv["quantity"] = !empty($csv_line[7])
                        ? $csv_line[7]
                        : null;
                        $insert_csv["unit"] = !empty($csv_line[8])
                        ? $csv_line[8]
                        : null;
                        $insert_csv["Productsubcategory"] = !empty($csv_line[9])
                        ? $csv_line[9]
                        : null;
                        $insert_csv["Accountcategoryname"] = !empty(
                            $csv_line[10]
                        )
                        ? $csv_line[10]
                        : null;
                        $insert_csv["accountsubcategory"] = !empty(
                            $csv_line[11]
                        )
                        ? $csv_line[11]
                        : null;
                        $insert_csv["Sales_des"] = !empty($csv_line[12])
                        ? $csv_line[12]
                        : null;
                        $insert_csv["SKU"] = !empty($csv_line[13])
                        ? $csv_line[13]
                        : null;
                        $insert_csv["Type"] = !empty($csv_line[14])
                        ? $csv_line[14]
                        : null;
                        $insert_csv["Taxable"] = !empty($csv_line[15])
                        ? $csv_line[15]
                        : null;
                        $insert_csv["Income_Account"] = !empty($csv_line[16])
                        ? $csv_line[16]
                        : null;
                        $insert_csv["Purchase_Description"] = !empty(
                            $csv_line[17]
                        )
                        ? $csv_line[17]
                        : null;
                        $insert_csv["Expense_Account"] = !empty($csv_line[18])
                        ? $csv_line[18]
                        : null;
                        $insert_csv["Reorder_Point"] = !empty($csv_line[19])
                        ? $csv_line[19]
                        : null;
                        $insert_csv["Inventory_Asset_Account"] = !empty(
                            $csv_line[20]
                        )
                        ? $csv_line[20]
                        : null;
                        $insert_csv["Quantity_as_of_Date"] = !empty(
                            $csv_line[21]
                        )
                        ? $csv_line[21]
                        : null;
                    }
                    $check_supplier = $this->db
                        ->select("*")
                        ->from("supplier_information")
                        ->where("supplier_name", $insert_csv["supplier_id"])
                        ->get()
                        ->row();
                    if (!empty($check_supplier)) {
                        $supplier_id = $check_supplier->supplier_id;
                    } else {
                        $supplierinfo = [
                            "created_by"    => $this->session->userdata("user_id"),
                            "supplier_name" => $insert_csv["supplier_id"],
                            "address"       => "",
                            "mobile"        => "",
                            "details"       => "",
                            "status"        => 1,
                        ];
                        if ($count > 0) {
                            $this->db->insert(
                                "supplier_information",
                                $supplierinfo
                            );
                            echo $this->db->last_query();
                        }
                        $supplier_id = $this->db->insert_id();
                        $coa         = $this->suppliers->headcode();
                        if ($coa->HeadCode != null) {
                            $headcode = $coa->HeadCode + 1;
                        } else {
                            $headcode = "50205000001";
                        }
                        $c_acc =
                            $supplier_id . "-" . $insert_csv["supplier_id"];
                        $createby     = $this->session->userdata("user_id");
                        $createdate   = date("Y-m-d H:i:s");
                        $supplier_coa = [
                            "HeadCode"         => $headcode,
                            "HeadName"         => $c_acc,
                            "PHeadName"        => "Account Payable",
                            "HeadLevel"        => "3",
                            "IsActive"         => "1",
                            "IsTransaction"    => "1",
                            "IsGL"             => "0",
                            "HeadType"         => "L",
                            "IsBudget"         => "0",
                            "IsDepreciation"   => "0",
                            "supplier_id"      => $supplier_id,
                            "DepreciationRate" => "0",
                            "CreateBy"         => $createby,
                            "CreateDate"       => $createdate,
                        ];
                        if ($count > 0) {
                            $this->db->insert("acc_coa", $supplier_coa);
                        }
                    }
                    if (
                        !empty($insert_csv["category_id"]) &&
                        $insert_csv["category_id"] != "Category Name"
                    ) {
                        $check_category = $this->db
                            ->select("*")
                            ->from("product_category")
                            ->where("category_name", $insert_csv["category_id"])
                            ->get()
                            ->row();
                        if (!empty($check_category)) {
                            $category_id = $check_category->category_id;
                        } else {
                            $category_id  = $this->auth->generator(15);
                            $categorydata = [
                                "created_by"    => $this->session->userdata(
                                    "user_id"
                                ),
                                "category_id"   => $category_id,
                                "category_name" => $insert_csv["category_id"],
                                "status"        => 1,
                            ];
                            if ($count > 0) {
                                $this->db->insert(
                                    "product_category",
                                    $categorydata
                                );
                            }
                        }
                    }
                    if (
                        !empty($insert_csv["unit"]) &&
                        $insert_csv["unit"] != "Unit"
                    ) {
                        $check_unit = $this->db
                            ->select("*")
                            ->from("units")
                            ->where("unit_name", $insert_csv["unit"])
                            ->get()
                            ->row();
                        if (!empty($check_unit)) {
                            $unit_id = $check_unit->unit_id;
                        } else {
                            $unit_id  = $this->auth->generator(15);
                            $unitdata = [
                                "created_by" => $this->session->userdata(
                                    "user_id"
                                ),
                                "unit_id"    => $unit_id,
                                "unit_name"  => $insert_csv["unit"],
                                "status"     => 1,
                            ];
                            if ($count > 0) {
                                $this->db->insert("units", $unitdata);
                            }
                        }
                    }
                    $data = [
                        "product_id"      => $product_id,
                        "created_by"      => $this->session->userdata("user_id"),
                        "p_quantity"      => $insert_csv["quantity"],
                        "category_id"     => $insert_csv["category_id"],
                        "product_name"    => $insert_csv["product_name"],
                        "product_model"   => $insert_csv["product_model"],
                        "price"           => $insert_csv["price"],
                        "unit"            => $insert_csv["unit"],
                        "tax"             => "",
                        "image"           => base_url("my-assets/image/product.png"),
                        "status"          => 1,
                        "product_details" =>
                        "Sales Description :" .
                        $insert_csv["Sales_des"] .
                        " ;" .
                        "SKU :" .
                        $insert_csv["SKU"] .
                        " ;" .
                        "Type :" .
                        $insert_csv["Type"] .
                        " ;" .
                        "Taxable :" .
                        $insert_csv["Taxable"] .
                        " ;" .
                        "Income Account :" .
                        $insert_csv["Income_Account"] .
                        " ;" .
                        "Purchase_Description :" .
                        $insert_csv["Purchase_Description"] .
                        " ;" .
                        "Expense_Account :" .
                        $insert_csv["Expense_Account"] .
                        " ;" .
                        "Reorder_Point :" .
                        $insert_csv["Reorder_Point"] .
                        " ;" .
                        "Inventory Asset Account :" .
                        $insert_csv["Inventory_Asset_Account"] .
                        " ;" .
                        "Quantity as of Date :" .
                        $insert_csv["Quantity_as_of_Date"] .
                        " ;",
                    ];
                    if ($count > 0) {
                        $result = $this->db
                            ->select("*")
                            ->from("product_information")
                            ->where("product_name", $data["product_name"])
                            ->where("product_model", $data["product_model"])
                            ->where("category_id", $category_id)
                            ->get()
                            ->row();
                        if (empty($result)) {
                            $this->db->insert("product_information", $data);
                            $product_id = $product_id;
                        } else {
                            $product_id = $result->product_id;
                            $udata      = [
                                "created_by"      => $this->session->userdata(
                                    "user_id"
                                ),
                                "product_id"      => $result->product_id,
                                "category_id"     => $category_id,
                                "product_name"    => $result->product_name,
                                "product_model"   => $insert_csv["product_model"],
                                "price"           => $insert_csv["price"],
                                "unit"            => "",
                                "tax"             => "",
                                "product_details" => "Csv Uploaded Product",
                                "image"           => base_url(
                                    "my-assets/image/product.png"
                                ),
                                "status"          => 1,
                            ];
                            $this->db->where("product_id", $result->product_id);
                            $this->db->update("product_information", $udata);
                        }
                        $supp_prd = [
                            "created_by"     => $this->session->userdata("user_id"),
                            "product_id"     => $product_id,
                            "supplier_id"    => $supplier_id,
                            "supplier_price" => $insert_csv["supplier_price"],
                            "products_model" => $insert_csv["product_model"],
                        ];
                        $splprd = $this->db
                            ->select("*")
                            ->from("supplier_product")
                            ->where("supplier_id", $supplier_id)
                            ->where("product_id", $product_id)
                            ->get()
                            ->num_rows();
                        if ($splprd == 0) {
                            $this->db->insert("supplier_product", $supp_prd);
                            echo $this->db->last_query();
                        } else {
                            $supp_prd = [
                                "supplier_id"    => $supplier_id,
                                "supplier_price" =>
                                $insert_csv["supplier_price"],
                                "products_model" =>
                                $insert_csv["product_model"],
                            ];
                            $this->db->where("product_id", $product_id);
                            $this->db->where("supplier_id", $supplier_id);
                            $this->db->update("supplier_product", $supp_prd);
                        }
                    }
                    $count++;
                }
                $this->db->select("*");
                $this->db->from("product_information");
                $this->db->where("status", 1);
                $query = $this->db->get();
                foreach ($query->result() as $row) {
                    $json_product[] = [
                        "label" =>
                        $row->product_name .
                        "-(" .
                        $row->product_model .
                        ")",
                        "value" => $row->product_id,
                    ];
                }
                $cache_file  = "./my-assets/js/admin_js/json/product.json";
                $productList = json_encode($json_product);
                file_put_contents($cache_file, $productList);
                fclose($fp) or die("can't close file");
                $this->session->set_userdata([
                    "message" => display("successfully_added"),
                ]);
            } else {
                $this->session->set_userdata([
                    "error_message" => "Please Import Only Csv File",
                ]);
            }
        }
    }
    public function add_supplier() {
        $this->load->model("Suppliers");
        $data = [
            "supplier_id"   => $this->auth->generator(20),
            "supplier_name" => $this->input->post("supplier_name", true),
            "address"       => $this->input->post("address", true),
            "mobile"        => $this->input->post("mobile", true),
            "details"       => $this->input->post("details", true),
            "status"        => 1,
        ];
     //   $supplier = $this->Suppliers->supplier_entry($data);
        if ($supplier == true) {
            $this->session->set_userdata([
                "message" => display("successfully_added"),
            ]);
            echo true;
        } else {
            $this->session->set_userdata([
                "error_message" => display("already_exists"),
            ]);
            echo false;
        }
    }
    public function insert_category() {
        $this->load->model("Categories");
        $category_id = $this->auth->generator(15);
        $data        = [
            "created_by"    => $this->session->userdata("user_id"),
            "category_id"   => $category_id,
            "category_name" => $this->input->post("category_name", true),
            "status"        => 1,
        ];
        $result = $this->Categories->category_entry($data);
        if ($result == true) {
            $this->session->set_userdata([
                "message" => display("successfully_added"),
            ]);
            echo true;
        } else {
            $this->session->set_userdata([
                "error_message" => display("already_exists"),
            ]);
            echo false;
        }
    }
    //Retrieve Single Item  By Search
    public function product_by_search() {
        $CI = &get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library("lproduct");
        $product_id = $this->input->post("product_id", true);
        $content    = $CI->lproduct->product_search_list($product_id);
        $this->template->full_admin_html_view($content);
    }
    //Retrieve Single Item  By Search
    public function product_details($product_id) {
        $this->product_id = $product_id;
        $CI               = &get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library("lproduct");
        $content = $CI->lproduct->product_details($product_id);
        $this->template->full_admin_html_view($content);
    }
    //Retrieve Single Item  By Search
    public function product_sales_supplier_rate(
        $product_id = null,
        $startdate = null,
        $enddate = null
    ) {
        if ($startdate == null) {
            $startdate = date("Y-m-d", strtotime("-30 days"));
        }
        if ($enddate == null) {
            $enddate = date("Y-m-d");
        }
        $product_id_input = $this->input->post("product_id", true);
        if (!empty($product_id_input)) {
            $product_id = $this->input->post("product_id", true);
            $startdate  = $this->input->post("from_date", true);
            $enddate    = $this->input->post("to_date", true);
        }
        $this->product_id = $product_id;
        $CI               = &get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library("lproduct");
        $content = $CI->lproduct->product_sales_supplier_rate(
            $product_id,
            $startdate,
            $enddate
        );
        $this->template->full_admin_html_view($content);
    }
    //This function is used to Generate Key
    public function generator($lenth) {
        $CI = &get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model("Products");
        $number = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0"];
        for ($i = 0; $i < $lenth; $i++) {
            $rand_value  = rand(0, 8);
            $rand_number = $number["$rand_value"];
            if (empty($con)) {
                $con = $rand_number;
            } else {
                $con = "$con" . "$rand_number";
            }
        }
        $result = $this->Products->product_id_check($con);
        if ($result === true) {
            $this->generator(8);
        } else {
            return $con;
        }
    }
    //Export CSV
    public function exportCSV() {
        $this->load->model("Products");
        $filename = "product_" . date("Ymd") . ".csv";
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");
        $usersData = $this->Products->product_csv_file();
        $file      = fopen("php://output", "w");
        $header    = [
            "product_id",
            "supplier_id",
            "category_id",
            "product_name",
            "price",
            "supplier_price",
            "unit",
            "tax",
            "product_model",
            "product_details",
            "image",
            "status",
        ];
        fputcsv($file, $header);
        foreach ($usersData as $line) {
            fputcsv($file, $line);
        }
        fclose($file);
        exit();
    }
  
}
