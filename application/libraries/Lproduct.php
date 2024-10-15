<?php
if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class Lproduct 
{
  
  
    public function product_list($admin_id)
    {
        $CI = &get_instance();
        $CI->load->model("Products");
        $CI->load->model("Web_settings");
        $setting_detail = $CI->Web_settings->retrieve_setting_editdata($admin_id);
        $data["sale_count"] = $CI->Products->sales_product_all($admin_id);
        $data["expense_count"] = $CI->Products->expense_product_all($admin_id);
        $productList = $CI->parser->parse("product/product", $data, true);
        return $productList;
    }



    public function product_view($id, $company_id)
    {
        $CI = &get_instance();
        $CI->load->model("Products");
        $CI->load->model("Web_settings");
        $products = $CI->Products->retrieve_product_details($id);
        $product_details_pdv = $CI->Products->product_details_pdv($id);
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        if ($products[0]["supplier_id"]) {
            $supplier_name = $CI->db
                ->select("supplier_name")
                ->from("supplier_information")
                ->where("supplier_id", $products[0]["supplier_id"])
                ->get()
                ->row()->supplier_name;
            $supplier_price = $CI->db
                ->select("supplier_price")
                ->from("supplier_product")
                ->where("supplier_id", $products[0]["supplier_id"])
                ->get()
                ->row()->supplier_price;
        }
        $data["currency"] = $currency_details[0]["currency"];
        $data["description_table"] = isset(
            $product_details_pdv[0]["description_table"]
        )
            ? isset($product_details_pdv[0]["description_table"])
            : null;
        $data["thickness"] = isset($product_details_pdv[0]["thickness"])
            ? isset($product_details_pdv[0]["thickness"])
            : null;
        $data["supplier_block_no"] = isset(
            $product_details_pdv[0]["supplier_block_no"]
        )
            ? isset($product_details_pdv[0]["supplier_block_no"])
            : null;
        $data["supplier_slab_no"] = isset(
            $product_details_pdv[0]["supplier_slab_no"]
        )
            ? isset($product_details_pdv[0]["supplier_slab_no"])
            : null;
        $data["g_width"] = isset($product_details_pdv[0]["g_width"])
            ? isset($product_details_pdv[0]["g_width"])
            : null;
        $data["g_height"] = isset($product_details_pdv[0]["g_height"])
            ? isset($product_details_pdv[0]["g_height"])
            : null;
        $data["gross_sqft"] = isset($product_details_pdv[0]["gross_sqft"])
            ? isset($product_details_pdv[0]["gross_sqft"])
            : null;
        $data["bundle_no"] = isset($product_details_pdv[0]["bundle_no"])
            ? isset($product_details_pdv[0]["bundle_no"])
            : null;
        $data["n_width"] = isset($product_details_pdv[0]["n_width"])
            ? isset($product_details_pdv[0]["n_width"])
            : null;
        $data["n_height"] = isset($product_details_pdv[0]["n_height"])
            ? isset($product_details_pdv[0]["n_height"])
            : null;
        $data["net_sqft"] = isset($product_details_pdv[0]["net_sqft"])
            ? isset($product_details_pdv[0]["net_sqft"])
            : null;
        $data["cost_sqft"] = isset($product_details_pdv[0]["cost_sqft"])
            ? isset($product_details_pdv[0]["cost_sqft"])
            : null;
        $data["cost_slab"] = isset($product_details_pdv[0]["cost_perslab"])
            ? isset($product_details_pdv[0]["cost_perslab"])
            : null;
        $data["sales_price_sqft"] = isset(
            $product_details_pdv[0]["sales_price_sqft"]
        )
            ? isset($product_details_pdv[0]["sales_price_sqft"])
            : null;
        $data["sales_slab_price"] = isset(
            $product_details_pdv[0]["sales_slab_price"]
        )
            ? isset($product_details_pdv[0]["sales_slab_price"])
            : null;
        $data["weight"] = isset($product_details_pdv[0]["weight"])
            ? isset($product_details_pdv[0]["weight"])
            : null;
        $data["origin"] = isset($product_details_pdv[0]["origin"])
            ? isset($product_details_pdv[0]["origin"])
            : null;
        $data["total_amt"] = isset($product_details_pdv[0]["total_amt"])
            ? isset($product_details_pdv[0]["total_amt"])
            : null;
        $data["notes"] = isset($product_details_pdv[0]["notes"])
            ? isset($product_details_pdv[0]["notes"])
            : null;
        $data["block"] = isset($product_details_pdv[0]["block"])
            ? isset($product_details_pdv[0]["block"])
            : null;
        $data["category_name"] = isset($product_details_pdv[0]["category_id"])
            ? isset($product_details_pdv[0]["category_id"])
            : null;
        $data["all_product_detail"] = $product_details_pdv;
        $data["product_info"] = $products;
        $data["supplier_namee"] = isset($supplier_name)
            ? isset($supplier_name)
            : null;
        $data["supplier_price"] = isset($supplier_price)
            ? isset($supplier_price)
            : null;
        $data["sale_history"] = $CI->Products->get_sales_product_history(
            $product_details_pdv[0]["product_id"],
            $company_id
        );
        $data["expense_history"] = $CI->Products->get_expense_product_history(
            $product_details_pdv[0]["product_id"],
            $company_id
        );
        $data["sale_count"] = $CI->Products->sales_product_all($admin_id);
        $data["expense_count"] = $CI->Products->expense_product_all();
        $data[
            "setting_detail"
        ] = $CI->Web_settings->retrieve_setting_editdata();
        $productList = $CI->parser->parse(
            "product/product-details",
            $data,
            true
        );
        return $productList;
    }
  
    public function insert_product($data)
    {
        $CI = &get_instance();
        $CI->load->model("Products");
        $result = $CI->Products->product_entry($data);
        if ($result == 1) {
            return true;
        } else {
            return false;
        }
    }
    //For Product Update
    public function product_edit_data($product_id, $created_by)
    {
        $CI = &get_instance();
        $CI->load->model("Products");
        $CI->load->model("Suppliers");
        $CI->load->model("Invoices");
        $CI->load->model("Categories");
        $CI->load->model("Units");
        $CI->load->model("Web_settings");
        $product_detail = $CI->Products->retrieve_product_editdata($product_id);
        $country_list = $CI->Web_settings->getCountryDetails();
        $product_table = $CI->Products->product_table($product_id);
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $supplier_list = $CI->Suppliers->supplier_list($created_by);
        $view_attachments = $CI->Invoices->editMultiplefiles(
            $product_id,
            "product",
            $created_by
        );
        $category_list = $CI->Categories->category_list_product($created_by);
        $unit_list = $CI->Units->unit_list();
        $setting_detail = $CI->Web_settings->retrieve_setting_editdata($created_by);
        $data["supplier_list"] = $supplier_list;
        $data["country_list"] = $country_list;
        $data["unit_list"] = $unit_list;
        $data["category_list"] = $category_list;
        $data["view_attachments"] = $view_attachments;
        $data["currency"] = $currency_details[0]["currency"];
        $data["product_detail"] = $product_detail;
        $data["category_name"] = $product_detail[0]["category_name"];
        $data["unit"] = $product_detail[0]["unit"];
        $data["price"] = $product_detail[0]["price"];
        $data["product_model"] = $product_detail[0]["product_model"];
        $data["product_name"] = $product_detail[0]["product_name"];
        $data["serial_no"] = $product_detail[0]["serial_no"];
        $data["p_quantity"] = $product_detail[0]["p_quantity"];
        $data["account_subcat"] = $product_detail[0]["account_subcat"];
        $data["account_sub_category"] =
            $product_detail[0]["account_sub_category"];
        $data["account_category"] = $product_detail[0]["account_category"];
        $data["oa_total"] = $product_detail[0]["oa_total"];
        $data["tax"] = $product_detail[0]["tax"];
        $data["product_details"] = $product_detail[0]["product_details"];
        $data["supplier_id"] = $product_detail[0]["supplier_id"];
        $data["description_table"] = !empty(
            $product_table[0]["description_table"]
        )
            ? $product_table[0]["description_table"]
            : "";
        $data["thickness"] = !empty($product_table[0]["thickness"])
            ? $product_table[0]["thickness"]
            : "";
        $data["supplier_block_no"] = !empty(
            $product_table[0]["supplier_block_no"]
        )
            ? $product_table[0]["supplier_block_no"]
            : "";
        $data["supplier_slab_no"] = !empty(
            $product_table[0]["supplier_slab_no"]
        )
            ? $product_table[0]["supplier_slab_no"]
            : "";
        $data["gross_width"] = !empty($product_table[0]["g_width"])
            ? $product_table[0]["g_width"]
            : "";
        $data["gross_height"] = !empty($product_table[0]["g_height"])
            ? $product_table[0]["g_height"]
            : "";
        $data["gross_sq_ft"] = !empty($product_table[0]["gross_sqft"])
            ? $product_table[0]["gross_sqft"]
            : "";
        $data["bundle_no"] = !empty($product_table[0]["bundle_no"])
            ? $product_table[0]["bundle_no"]
            : "";
        $data["net_width"] = !empty($product_table[0]["n_width"])
            ? $product_table[0]["n_width"]
            : "";
        $data["net_height"] = !empty($product_table[0]["n_height"])
            ? $product_table[0]["n_height"]
            : "";
        $data["net_sq_ft"] = !empty($product_table[0]["net_sqft"])
            ? $product_table[0]["net_sqft"]
            : "";
        $data["weight"] = !empty($product_table[0]["weight"])
            ? $product_table[0]["weight"]
            : "";
        $data["origin"] = !empty($product_table[0]["origin"])
            ? $product_table[0]["origin"]
            : "";
        $data["total_amt"] = !empty($product_table[0]["total_amt"])
            ? $product_table[0]["total_amt"]
            : "";
        $data["product_id"] = !empty($product_table[0]["product_id"])
            ? $product_table[0]["product_id"]
            : "";
        $data["cost_slab"] = !empty($product_table[0]["cost_slab"])
            ? $product_table[0]["cost_slab"]
            : "";
        $data["cost_sqft"] = !empty($product_table[0]["cost_sqft"])
            ? $product_table[0]["cost_sqft"]
            : "";
        $data["oa_total"] = !empty($product_table[0]["oa_total"])
            ? $product_table[0]["oa_total"]
            : "";
        $data["sales_price_sqft"] = !empty(
            $product_table[0]["sales_price_sqft"]
        )
            ? $product_table[0]["sales_price_sqft"]
            : "";
        $data["sales_slab_price"] = !empty(
            $product_table[0]["sales_slab_price"]
        )
            ? $product_table[0]["sales_slab_price"]
            : "";
        $data["setting_detail"] = $setting_detail;
        $data["data_products"] = $product_table;
        $chapterList = $CI->parser->parse(
            "product/edit_product_form",
            $data,
            true
        );
        return $chapterList;
    }
    //Search Product
    public function product_search_list($product_id)
    {
        $CI = &get_instance();
        $CI->load->model("Web_settings");
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = [
            "title" => display("manage_product"),
            "links" => "",
            "currency" => $currency_details[0]["currency"],
            "position" => $currency_details[0]["currency_position"],
        ];
        $productList = $CI->parser->parse("product/product", $data, true);
        return $productList;
    }
}
?>
