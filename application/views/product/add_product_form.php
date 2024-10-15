<?php
$modaldata['bootstrap_model'] = array('vendor','tax_info','payment_model','bank_info');

$this->load->view('include/bootstrap_model', $modaldata);
?>
<div class="content-wrapper">
  <section class="content-header" style='height:60px;'>
    <div class="header-icon"> <img src="<?php echo base_url()  ?>asset/images/product.png" class="headshotphoto" style="height:50px;" /> </div>
    <div class="header-title">
      <div class="logo-holder logo-9">
        <h1><?php echo display('new_product') ?></h1>
      </div>
      <ol class="breadcrumb" style=" border: 3px solid #d7d4d6;">
        <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
        <li><a href="#"><?php echo display('product') ?></a></li>
        <li class="active" style="color:orange"><?php echo display('new_product') ?></li>
      </ol>
    </div>
  </section>
  <style>
    .select2-container .select2-selection--single .select2-selection__rendered {
     padding-right:0px !important;
    }
    </style>
  <section class="content" style='margin-top:-30px;'>
  <?php
         $message = $this->session->userdata('message');
         if (isset($message)) {
             ?> <div class="alert alert-info alert-dismissable"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <?php echo $message ?> </div> <?php
         $this->session->unset_userdata('message');
         }
         $error_message = $this->session->userdata('error_message');
         if (isset($error_message)) {
         ?> <div class="alert alert-danger alert-dismissable"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <?php echo $error_message ?> </div> <?php
         $this->session->unset_userdata('error_message');
         }
         ?>
           <div id="errormessage_product" class="alert"></div>
         <div class="row">
      <div class="col-sm-12">
        <form id="insert_product_form" enctype="multipart/form-data" method="post"> <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>"> <?php  $product_id = rand();  ?> <input type="hidden" name="product_id" class="form-control" id="product_id" value="<?php echo  $product_id; ?>" tabindex="4" placeholder=" product_id" />
          <div class="col-sm-12">
            <div class="panel panel-bd lobidrag" style=" border: 3px solid #d7d4d6;">
              <div class="panel-heading" style="height: 55px;">
                <div class="panel-title">
                  <div id="bloc2" style="float:right;"> <a href="<?php echo base_url('Cproduct/manage_product'.'?id='.urlencode($_GET['id']))?>" class="btnclr btn  m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo ('Manage Product') ?> </a> </div>
                </div>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group row"> <label for="barcode_or_qrcode" class="col-sm-4 col-form-label"><?php echo display('barcode_or_qrcode') ?> <i class="text-danger"></i></label>
                      <div class="col-sm-8"> <input type="text" tabindex="3" class="form-control" name="barcode" placeholder="Barcode/QR-code" id="barcode" /> </div>
                    </div> <!-- Product Name -->
                    <div class="form-group row"> <label for="product_name" class="col-sm-4 col-form-label"><?php echo display('product_name') ?> <i class="text-danger">*</i></label>
                      <div class="col-sm-8"> <input class="form-control validate_productname" name="product_name" type="text" required placeholder="<?php echo display('product_name') ?>" tabindex="1"> </div>
                    </div> <!-- Model -->
                    <div class="form-group row"> <label for="product_model" class="col-sm-4 col-form-label"><?php echo display('model') ?> <i class="text-danger">*</i></label>
                      <div class="col-sm-8"> <input type="text" class="form-control p_model" id="product_model" name="model" required placeholder="<?php echo display('model') ?>"> </div>
                    </div> <!-- Price -->
                    <div class="form-group row"> <label for="sell_price" class="col-sm-4 col-form-label"><?php echo display('sell_price') ?> <i class="text-danger">*</i></label>
                      <div class="col-sm-8"> <input class="form-control" id="sell_price" name="price" type="text" required placeholder="0.00" tabindex="3"> </div>
                    </div> <!-- Quantity -->
                    <div class="form-group row"> <label for="quantity" class="col-sm-4 col-form-label"><?php echo ('Quantity') ?> <i class="text-danger">*</i></label>
                      <div class="col-sm-8"> <input class="form-control" name="quantity" type="number" id="quantity" required placeholder="Enter Product Quantity only" tabindex="5"> </div>
                    </div> <!-- Supplier -->
                    <div class="form-group row"> <label for="supplier_id" class="col-sm-4 col-form-label"><?php echo display('Vendor') ?> <i class="text-danger">*</i></label>
                      <div class="col-sm-7"> <select name="supplier_id" id="supplier_id" required class="form-control">
                          <option value=""><?php echo display('Select Vendor')?></option> <?php if ($supplier) { ?> {supplier} <option value="{supplier_id}">{supplier_name}</option> {/supplier} <?php } ?>
                        </select> </div>
                      <div class="col-sm-1"> <?php //if($this->permission1->method('add_supplier','create')->access()){ ?> <a href="#" class="btnclr client-add-btn btn" aria-hidden="true" data-toggle="modal" data-target="#add_vendor"><i class="fa fa-user"></i></a> <?php //}?> </div>
                    </div> <!-- Serial Number -->
                    <div class="form-group row"> <label for="serial_no" class="col-sm-4 col-form-label"><?php echo display('Serial No') ?></label>
                      <div class="col-sm-8"> <input type="text" class="form-control" id="serial_no" name="serial_no" placeholder="111,abc,XYz"> </div>
                    </div>
                  </div> <!-- Right Column -->
                  <div class="col-sm-6">
                    <!-- Country -->
                    <div class="form-group row"> <label for="country" class="col-sm-4 col-form-label"><?php echo display('country') ?></label>
                      <div class="col-sm-8"> <select class="form-control" name="country" id="country"> <?php $default_country = 'USA - United States';?> <?php if (!empty($country_list)): ?> <?php foreach ($country_list as $country): ?> <option value="<?php echo $country['id']; ?>" <?php echo ($country['iso3'] . ' - ' . $country['nickname'] == $default_country) ? 'selected' : ''; ?>> <?php echo $country['iso3'] . ' - ' . $country['nickname'] ; ?> </option> <?php endforeach;?> <?php else: ?> <option value="">No Countries found</option> <?php endif;?> </select> </div>
                    </div> <!-- Category -->
                    <div class="form-group row"> <label for="category_id" class="col-sm-4 col-form-label"><?php echo display('category') ?>&nbsp;<i class="text-danger">*</i></label>
                      <div class="col-sm-7"> <select class="form-control cat_name" required id="category_id" name="category_id" tabindex="2">
                          <option value=""><?php echo display('Select the Category') ?> </option> <?php if ($category_list) { 
                            foreach($category_list as $cl){ ?> <option value="<?php echo $cl['category_name']; ?>"> <?php echo $cl['category_name']; ?></option> <?php }} ?>
                        </select> </div>
                      <div class=" col-sm-1"> <?php //if($this->permission1->method('manage_category','create')->access() || $this->permission1->method('manage_category','read')->access()|| $this->permission1->method('manage_category','update')->access()|| $this->permission1->method('manage_category','delete')->access()){ ?> <a href="#" class="client-add-btn btn  btnclr" aria-hidden="true" data-toggle="modal" data-target="#add_cat"> <i class='fa fa-plus'></i></a> <?php //} ?> </div>
                    </div> <!-- Unit -->
                    <div class="form-group row"> <label for="unit" class="col-sm-4 col-form-label"><?php echo display('unit') ?></label>
                      <div class="col-sm-7"> <select class="form-control" id="unit" name="unit" tabindex="4">
                          <option value=""><?php echo display('Select the Unit')?></option> <?php if ($unit_list) { ?> {unit_list} <option value="{unit_name}">{unit_name}</option> {/unit_list} <?php } ?>
                        </select> </div>
                      <div class=" col-sm-1">
                        <!--   <?php //if($this->permission1->method('manage_unit','create')->access() || $this->permission1->method('manage_unit','read')->access() || $this->permission1->method('manage_unit','delete')->access() || $this->permission1->method('manage_unit','update')->access()){ ?>--> <a href="#" class="client-add-btn btn  btnclr" aria-hidden="true" data-toggle="modal" data-target="#add_unit"> <i class='fa fa-plus'></i></a> <!--                                <?php// } ?>-->
                      </div>
                    </div> <!-- Account Category -->
                    <div class="form-group row"> <label for="account_category" class="col-sm-4 col-form-label"><?php echo display('Account Category');?></label>
                      <div class="col-sm-8"> <select id="ddl" name="account_category" class="form-control" onchange="configureDropDownLists(this, document.getElementById('ddl2'))">
                          <option value=""> <?php echo display('Select the Account Category');?></option>
                          <option value="1000 ASSETS">1000 <?php echo  display('ASSETS');?> </option>
                          <option value="1200 RECEIVABLES">1200 <?php echo  display('RECEIVABLES');?> </option>
                          <option value="1300 INVENTORIES">1300 <?php echo  display('INVENTORIES');?> </option>
                          <option value="1400 PREPAID EXPENSES & OTHER CURRENT ASSETS">1400 <?php echo  display('PREPAID EXPENSES & OTHER CURRENT ASSETS');?> </option>
                          <option value="1500 PROPERTY PLANT & EQUIPMENT">1500 <?php echo  display('PROPERTY PLANT & EQUIPMENT');?></option>
                          <option value="1600 ACCUMULATED DEPRECIATION & AMORTIZATION">1600 <?php echo  display('ACCUMULATED DEPRECIATION & AMORTIZATION');?> </option>
                          <option value="1700 NON – CURRENT RECEIVABLES">1700 <?php echo  display('NON – CURRENT RECEIVABLES');?></option>
                          <option value="1800 INTERCOMPANY RECEIVABLES & OTHER NON-CURRENT ASSETS"> 1800 <?php echo  display('INTERCOMPANY RECEIVABLES & OTHER NON-CURRENT ASSETS');?> </option>
                          <option value="2000 LIABILITIES & 2100 PAYABLES">2000 <?php echo  display('LIABILITIES & PAYABLES');?></option>
                          <option value="2200 ACCRUED COMPENSATION & RELATED ITEMS">2200 <?php echo  display('ACCRUED COMPENSATION & RELATED ITEMS');?> </option>
                          <option value="2300 OTHER ACCRUED EXPENSES">2300 <?php echo  display('OTHER ACCRUED EXPENSES');?></option>
                          <option value="2500 ACCRUED TAXES">2500 <?php echo  display('ACCRUED TAXES');?></option>
                          <option value="2600 DEFERRED TAXES">2600 <?php echo  display('DEFERRED TAXES');?></option>
                          <option value="2700 LONG-TERM DEBT">2700 <?php echo  display('LONG-TERM DEBT');?></option>
                          <option value="2800 INTERCOMPANY PAYABLES & OTHER NON CURRENT LIABILITIES & OWNERS EQUITIES"> 2800 <?php echo  display('INTERCOMPANY PAYABLES & OTHER NON CURRENT LIABILITIES & OWNERS EQUITIES');?> </option>
                          <option value="4000 REVENUE">4000 <?php echo  display('REVENUE');?> </option>
                          <option value="5000 COST OF GOODS SOLD">5000 <?php echo  display('COST OF GOODS SOLD');?></option>
                          <option value="6000 – 7000 OPERATING EXPENSES">6000 – 7000 <?php echo  display('OPERATING EXPENSES');?></option>
                        </select> </div>
                    </div> <!-- Account Subcategory -->
                    <div class="form-group row"> <label for="account_sub_category" class="col-sm-4 col-form-label">Account Subcategory</label>
                      <div class="col-sm-8"> <select class="form-control" name="account_sub_category" id="ddl2">
                          <option value="Select Sub Category">Select Sub Category</option>
                        </select> </div>
                    </div>
                    <div class="form-group row"> <label for="port_of_discharge" class="col-sm-4 col-form-label">Account Subcategory</label>
                      <div class="col-sm-8"> <input class="form-control" name="account_subcat" id="account_subcat" type="text" style="border: 2px solid #d7d4d6;" placeholder=" Account Sub Category" tabindex="1"> </div>
                    </div> <!-- Taxes -->
                    <div class="form-group row"> <label for="tax_id" class="col-sm-4 col-form-label"><?php echo display('Taxes');?></label>
                      <div class="col-sm-8"> <input type="text" name="tax" class="form-control" id="tax_id" placeholder="Tax"> </div>
                    </div> <!-- Product Image -->
                     <div class="form-group row">
                                <label for="adress" class="col-sm-4 col-form-label"><?php echo display('Attachments') ?>
                                </label>
                                <div class="col-sm-8">
                                    <input type="file" name="attachments" class="form-control">
                                </div>
                            </div>
                  </div>
                </div> <input type="hidden" name="id" id="id" value="<?php echo $this->input->get('id'); ?>"> <br />
                <div class="table-responsive product-supplier">
                  <table class="table table-bordered table-hover normalinvoice" id="producttable_1" style="border: 2px solid #d7d4d6;">
                    <thead>
                      <tr class="btnclr">
                        <th rowspan="2" style="width: max-content;" class="text-center"> <?php echo  display('description'); ?></th>
                        <th rowspan="2" class="text-center"> <?php echo display('Thick ness');?><i class="text-danger">*</i></th>
                        <th rowspan="2" class="text-center"> <?php echo display('Supplier Block No');?><i class="text-danger">*</i></th>
                        <th rowspan="2" class="text-center"> <?php echo display('Supplier Slab No');?><i class="text-danger">*</i> </th>
                        <th colspan="2" class="text-center"> <?php echo display('Gross Measurement');?><i class="text-danger">*</i> </th>
                        <th rowspan="2" class="text-center"><?php echo display('Gross Sq.Ft');?> </th>
                        <th rowspan="2" class="text-center"><?php echo display('Bundle No');?><i class="text-danger">*</i></th>
                        <th rowspan="2" class="text-center"><?php echo display('Slab No');?><i class="text-danger">*</i></th>
                        <th colspan="2" class="text-center"> <?php echo display('Net Measure');?><i class="text-danger">*</i> </th>
                        <th rowspan="2" class="text-center"><?php echo display('Net Sq.Ft');?> </th>
                        <th rowspan="2" class="text-center"> <?php echo display('Cost per Sq.Ft').' ( '.$currency.' )';?></th>
                        <th rowspan="2" class="text-center"> <?php echo display('Cost per Slab').' ( '.$currency.' )';?></th>
                        <th rowspan="2" class="text-center"> <?php echo display('sales'); ?><br /><?php echo display('Price per Sq.Ft').' ( '.$currency.' )';?> </th>
                        <th rowspan="2" class="text-center"> <?php echo display('Sales Slab Price').' ( '.$currency.' )';?></th>
                        <th rowspan="2" class="text-center"><?php echo display('Weight');?></th>
                        <th rowspan="2" class="text-center"><?php echo display('Origin');?></th>
                        <th rowspan="2" class="text-center"> <?php  echo  display('total').' ( '.$currency.' )'; ?></th>
                        <th rowspan="2" class="text-center"><?php  echo  display('action'); ?> </th>
                      </tr>
                      <tr>
                        <th class="text-center btnclr"><?php echo display('Width');?></th>
                        <th class="text-center btnclr"><?php echo display('Height');?></th>
                        <th class="text-center btnclr"><?php echo display('Width');?></th>
                        <th class="text-center btnclr"><?php echo display('Height');?></th>
                      </tr>
                    </thead>
                    <tbody id="addPurchaseItem_1">
                      <tr>
                        <td> <input type="text" id="description_table_1" name="description_table[]" class="form-control" /> </td>
                        <td> <input type="text" name="thickness[]" id="thickness_1" class="form-control" /> </td>
                        <td> <input type="text" id="supplier_b_no_1" name="supplier_block_no[]" class="form-control" /> </td>
                        <td> <input type="text" id="supplier_s_no_1" name="supplier_slab_no[]" class="form-control" /> </td>
                        <td> <input type="text" id="gross_width_1" name="gross_width[]" class="gross_width  form-control" /> </td>
                        <td> <input type="text" id="gross_height_1" name="gross_height[]" class="gross_height form-control" /> </td>
                        <td> <input type="text" style="width:60px;" id="gross_sq_ft_1" readonly name="gross_sq_ft[]" class="gross_sq_ft form-control" /> </td>
                        <td> <input type="text" id="bundle_no_1" name="bundle_no[]" class="bundle_no form-control" /> </td>
                        <td style="text-align:center;"> <input type="text" id="slab_no_1" name="slab_no[]" class="slab_no form-control" value="1" readonly /> </td>
                        <td> <input type="text" id="net_width_1" name="net_width[]" class="net_width form-control" /> </td>
                        <td> <input type="text" id="net_height_1" name="net_height[]" class="net_height form-control" /> </td>
                        <td> <input type="text" style="width:60px;" id="net_sq_ft_1" readonly name="net_sq_ft[]" class="net_sq_ft form-control" /> </td>
                        <td> <span class="input-symbol-euro"> <input type="text" id="cost_sq_ft_1" name="cost_sq_ft[]" placeholder="0.00" class="cost_sq_ft form-control"> </span>
                        <td> <span class="input-symbol-euro"> <input type="text" id="cost_sq_slab_1" name="cost_sq_slab[]" placeholder="0.00" class="cost_sq_slab form-control" /> </span> </td>
                        <td> <span class="input-symbol-euro"> <input type="text" id="sales_amt_sq_ft_1" name="sales_amt_sq_ft[]" placeholder="0.00" class="sales_amt_sq_ft form-control" /> </span> </td>
                        <td> <span class="input-symbol-euro"> <input type="text" id="sales_slab_amt_1" name="sales_slab_amt[]" placeholder="0.00" class="sales_slab_amt form-control" /></span> </td>
                        </td>
                        <td> <input type="text" id="weight_1" name="weight[]" class="weight form-control" /> </td>
                        <td style='width:90px;'> <select id="origin_1" name="origin[]"  class="form-control"> <?php foreach ($country_list as $key => $code) { ?> <option value="<?php echo $code['iso']; ?>"> <?php echo $code['iso']; ?></option> <?php } ?> </select> </td>
                        <td> <span class="input-symbol-euro"><input type="text" class="total_price form-control" style="width:80px;" readonly id="total_1" value="0.00" name="total_amt[]" /></span> </td>
                        <td style="text-align:center;"> <button class='delete btn btn-danger' id="delete_1" type='button' value='Delete'><i class="fa fa-trash"></i></button> </td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td style="text-align:right;" colspan="6"> <b><?php  echo display('Gross Sq.Ft');?> :</b> </td>
                        <td> <input type="text" id="overall_gross_1" name="overall_gross[]" class="overall_gross form-control" style="width: 60px" readonly="readonly" /> </td>
                        <td style="text-align:right;" colspan="4"> <b><?php  echo display('Net Sq.Ft');?> :</b> </td>
                        <td> <input type="text" id="overall_net_1" name="overall_net[]" class="overall_net form-control" style="width: 60px" readonly="readonly" /> </td>
                        <td style="text-align:right;" colspan="4"> <b><?php  echo display('Weight');?> :</b> </td>
                        <td> <input type="text" id="overall_weight_1" name="overall_weight[]" class="overall_weight form-control" readonly="readonly" /> </td>
                        <td style="text-align:right;height:50px;" colspan="1"> <b><?php  echo display('total'); ?> :</b> </td>
                        <td> <span class="input-symbol-euro"> <input type="text" id="Total" name="oa_total" readonly class="b_total form-control" style="width: 80px" value="0.00" /> </span> </td>
                      </tr>
                    </tfoot>
                    <tfoot>
                      <tr> </tr>
                    </tfoot>
                  </table>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <center><label for="description" class="col-form-label"><?php echo display('product_details') ?></label> </center> <textarea class="form-control" name="description" id="description" rows="2" placeholder="<?php echo display('product_details') ?>" style="border: 2px solid #d7d4d6;" tabindex="2"></textarea>
                  </div>
                </div> <br>
             <div class="col-sm-12 text-center">
                          <input type="submit" id="add-product" class="btn  btnclr btn-large" name="add-product" value="<?php echo display('save') ?>" tabindex="10" /> 
                            <a href="<?php echo base_url('Cproduct/manage_product?id='.$_GET['id']); ?>" class="btn btn-info">Cancel</a>
                        </div>
              </div>
            </div>
        </form>
      </div>
    </div>
</div>
</div>
</section>
</div>
<form id="insert_category" method="post">
  <div class="modal fade modal-success" id="add_cat" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="text-align:center;width: 600px;margin-left: 440px;">
        <div class="modal-header btnclr"> <a href="#" class="close" data-dismiss="modal">&times;</a>
          <h3 class="modal-title"><?php echo "CATEGORY"?></h3>
        </div>
        <div class="modal-body" style='margin-top: -30px;'>
          <div id="errormessage_category" class="alert"></div>
          <div class="panel-body"> <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
            <div class="form-group row"> <label for="category_name" class="col-sm-4 col-form-label"><?php echo display('category') ?> <i class="text-danger">*</i></label>
              <div class="col-sm-6"> <input class="form-control" name="category_name" id="category_name" type="text" placeholder="<?php echo ('Add New Category Name') ?>"> </div>
            </div>
          </div>
        </div>
        <div class="modal-footer"> <input type="submit" class="btn btnclr" value="<?php echo display('submit')?>"> <a href="#" class="btn btnclr" data-dismiss="modal"><?php echo display('Close')?></a> </div>
      </div>
    </div>
  </div>
</form>
<form id="insert_unit">
  <div class="modal fade modal-success" id="add_unit" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="text-align:center;width: 600px;margin-left: 440px;">
        <div class="modal-header btnclr"> <a href="#" class="close" data-dismiss="modal">&times;</a>
          <h3 class="modal-title"><?php echo ('UNIT')?></h3>
        </div>
        <div class="modal-body" style='margin-top: -30px;'>
          <div class="panel-body">
            <div id="errormessage_unit" class="alert"></div>
            <div class="form-group row"> <label for="unit_name" class="col-sm-3 col-form-label"><?php echo display('unit_name') ?> <i class="text-danger">*</i></label>
              <div class="col-sm-6"> <input class="form-control" name="unit_name" id="unit_name" type="text" placeholder="<?php echo display('unit_name') ?>"> </div>
            </div>
          </div>
        </div> <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
        <div class="modal-footer"> <input type="submit" class="btn btnclr" value="<?php echo display('submit')?>"> <a href="#" class="btn btnclr" data-dismiss="modal"><?php echo display('Close')?></a> </div>
      </div>
    </div>
  </div>
</form>
<script type="text/javascript">
  var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
  var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
  var succalert = '<div class="alert alert-success alert-dismissible" role="alert">';
  var failalert = '<div class="alert alert-danger alert-dismissible" role="alert">';
  var alert2 =
      '<button type="button" style="margin-top: -20px;" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
  $(document).on('keyup', '.net_height,.net_width', function() {
      var netheight = $(this).attr('id');
      const indexLastDot = netheight.lastIndexOf('_');
      var id = netheight.slice(indexLastDot + 1);
      var net_width = 'net_width_' + id;
      var net_height = 'net_height_' + id;
      var netwidth = $('#' + net_width).val();
      var netheight = $('#' + net_height).val();
      var netresult = parseInt(netwidth) * parseInt(netheight);
      netresult = netresult / 144;
      netresult = isNaN(netresult) ? 0 : netresult;
      $('#' + 'net_sq_ft_' + id).val(netresult.toFixed(3));
      var net = 'net_sq_ft_' + id;
      var cost = 'sales_amt_sq_ft_' + id;
      var net_val = $('#' + net).val();
      var cost_val = $('#' + cost).val();
      var final = net_val * cost_val;
      final = isNaN(final) ? 0 : final;
      $('#' + 'sales_slab_amt_' + id).val(final.toFixed(3));
      $('#' + 'total_' + id).val(final.toFixed(3));
      var net = 'net_sq_ft_' + id;
      var cost = 'cost_sq_ft_' + id;
      var net_val = $('#' + net).val();
      var cost_val = $('#' + cost).val();
      var final = net_val * cost_val;
      final = isNaN(final) ? 0 : final;
      $('#' + 'cost_sq_slab_' + id).val(final.toFixed(3));
      var total_net = 0;
      $('.table').each(function() {
          $(this).find('.net_sq_ft').each(function() {
              var precio = $(this).val();
              if (!isNaN(precio) && precio.length !== 0) {
                  total_net += parseFloat(precio);
              }
          });
      });
      $('#overall_net_1').val(total_net.toFixed(3)).trigger('change');
      var overall_sum = 0;
      $('.table').find('.total_price').each(function() {
          var v = $(this).val();
          overall_sum += parseFloat(v);
      });
      $('#Total').val(overall_sum).trigger('change');
  });
  $(document).on('keyup', '.cost_sq_ft', function() {
      var netheight = $(this).attr('id');
      const indexLastDot = netheight.lastIndexOf('_');
      var id = netheight.slice(indexLastDot + 1);
      var net = 'net_sq_ft_' + id;
      var cost = 'cost_sq_ft_' + id;
      var net_val = $('#' + net).val();
      var cost_val = $('#' + cost).val();
      var final = net_val * cost_val;
      final = isNaN(final) ? 0 : final;
      $('#' + 'cost_sq_slab_' + id).val(final.toFixed(3));
  });
  $(document).on('keyup', '.cost_sq_slab', function() {
      var netheight = $(this).attr('id');
      const indexLastDot = netheight.lastIndexOf('_');
      var id = netheight.slice(indexLastDot + 1);
      var net = 'net_sq_ft_' + id;
      var cost = 'cost_sq_slab_' + id;
      var net_val = $('#' + net).val();
      var cost_val = $('#' + cost).val();
      var final = cost_val / net_val;
      final = isNaN(final) ? 0 : final;
      $('#' + 'cost_sq_ft_' + id).val(final.toFixed(3));
  });
  $(document).on('keyup', '.sales_amt_sq_ft', function() {
      var netheight = $(this).attr('id');
      const indexLastDot = netheight.lastIndexOf('_');
      var id = netheight.slice(indexLastDot + 1);
      var net = 'net_sq_ft_' + id;
      var cost = 'sales_amt_sq_ft_' + id;
      var net_val = $('#' + net).val();
      var cost_val = $('#' + cost).val();
      var final = net_val * cost_val;
      final = isNaN(final) ? 0 : final;
      $('#' + 'sales_slab_amt_' + id).val(final.toFixed(3));
      $('#' + 'total_' + id).val(final.toFixed(3));
      var overall_sum = 0;
      $('.table').find('.total_price').each(function() {
          var v = $(this).val();
          overall_sum += parseFloat(v);
      });
      $('#Total').val(overall_sum).trigger('change');
  });
  $(document).on('keyup', '.sales_slab_amt', function() {
      var netheight = $(this).attr('id');
      const indexLastDot = netheight.lastIndexOf('_');
      var id = netheight.slice(indexLastDot + 1);
      var net = 'net_sq_ft_' + id;
      var cost = 'sales_slab_amt_' + id;
      var net_val = $('#' + net).val();
      var cost_val = $('#' + cost).val();
      var final = cost_val / net_val;
      final = isNaN(final) ? 0 : final;
      $('#' + 'sales_amt_sq_ft_' + id).val(final.toFixed(3));
      $('#' + 'total_' + id).val($(this).val());
      var overall_sum = 0;
      $('.table').find('.total_price').each(function() {
          var v = $(this).val();
          overall_sum += parseFloat(v);
      });
      $('#Total').val(overall_sum).trigger('change');
  });
  $(document).on('keyup', '.gross_height,.gross_width', function() {
      var netheight = $(this).attr('id');
      const indexLastDot = netheight.lastIndexOf('_');
      var id = netheight.slice(indexLastDot + 1);
      var net_width = 'gross_width_' + id;
      var net_height = 'gross_height_' + id;
      var netwidth = $('#' + net_width).val();
      var netheight = $('#' + net_height).val();
      var netresult = parseInt(netwidth) * parseInt(netheight);
      netresult = netresult / 144;
      netresult = isNaN(netresult) ? 0 : netresult;
      var nresult = netresult.toFixed(3);
      $('#' + 'gross_sq_ft_' + id).val(netresult.toFixed(3));
      var total_net = 0;
      $('.table').each(function() {
          $(this).find('.gross_sq_ft').each(function() {
              var precio = $(this).val();
              if (!isNaN(precio) && precio.length !== 0) {
                  total_net += parseFloat(precio);
              }
          });
      });
      $('#overall_gross_1').val(total_net.toFixed(3)).trigger('change');
  });
  
//   $(document).ready(function() {
//       $('#insert_supplier').submit(function(event) {
//           var empty = $(this).find('input[required]').filter(function() {
//               return this.value == '';
//           });
//           if (empty.length) {
//               e.preventDefault();
//           }
//           var dataString = {
//               dataString: $("#insert_supplier").serialize()
//           };
//           dataString[csrfName] = csrfHash;
//           $.ajax({
//               type: "POST",
//               dataType: "json",
//               url: "<?php echo base_url(); ?>Csupplier/insert_supplier",
//               data: $("#insert_supplier").serialize(),
//               success: function(states) {
//                   $("#supplier_id").html("");
//                   if (Object.keys(states).length > 0) {
//                       $("#supplier_id").append($('<option></option>').val(0).html(
//                           'Select a Vendor'));
//                   } else {
//                       $("#supplier_id").append($('<option></option>').val(0).html(''));
//                   }
//                   $.each(states, function(i, state) {
//                       $("#supplier_id").append($('<option></option>').val(state
//                           .supplier_id).html(state.supplier_name));
//                   });
//                   $('#add_vendor').modal('hide');
//                   $("#bodyModal1").html(
//                       "<?php  echo  display('New Vendor Added Successfully')?>");
//                   $('#myModal1').modal('show');
//                   $('#insert_supplier')[0].reset();
//                   window.setTimeout(function() {
//                       $('#myModal1').modal('hide');
//                       $('.modal-backdrop').remove();
//                   }, 2500);
//               }
//           });
//           event.preventDefault();
//       });
//       var netheight = $(this).attr('id');
//       const indexLastDot = netheight.lastIndexOf('_');
//       var id = netheight.slice(indexLastDot + 1);
//       var net_width = 'gross_width_' + id;
//       var net_height = 'gross_height_' + id;
//       var netwidth = $('#' + net_width).val();
//       var netheight = $('#' + net_height).val();
//       var netresult = parseInt(netwidth) * parseInt(netheight);
//       netresult = netresult / 144;
//       netresult = isNaN(netresult) ? 0 : netresult;
//       var nresult = netresult.toFixed(3);
//       $('#' + 'gross_sq_ft_' + id).val(netresult.toFixed(3));
//       var cost_sqft = $('#cost_sq_ft_' + id).val();
//       var sales_sqft = cost_sqft * nresult;
//       var sales_slab_price = cost_sqft * nresult * id;
//       console.log(parseInt(cost_sqft) + "*" + parseInt(nresult) + "*" + id);
//       $('#' + 'sales_slab_amt_' + id).val(sales_slab_price.toFixed(3));
//       sales_sqft = isNaN(sales_sqft) ? 0 : sales_sqft;
//       $('#' + 'sales_amt_sq_ft_' + id).val(sales_sqft.toFixed(3));
//       $('#title').hide();
//       $('#account_category').bind('change', function() {
//           var elements = $('div.container').children().hide();
//           var value = $(this).val();
//           if (value.length) {
//               $('#title').show();
//               elements.filter('.' + value).show();
//           }
//       }).trigger('change');
//   });
  
  function configureDropDownLists(ddl1, ddl2) {
     var assets = ['1010 CASH Operating Account', '1020 CASH Debitors', '1030 CASH Petty Cash'];
var receivables = ['1210 A/REC Trade', '1220 A/REC Trade Notes Receivable', '1230 A/REC Installment Receivables','1240 A/REC Retainage Withheld','1290 A/REC Allowance for Uncollectible Accounts'];
var inventories = ['1310 INV – Reserved', '1320 INV – Work-in-Progress', '1330 INV – Finished Goods','1340 INV – Reserved','1350 INV – Unbilled Cost & Fees','1390 INV – Reserve for Obsolescence'];
var prepaid_expense = ['1410 PREPAID – Insurance', '1420 PREPAID – Real Estate Taxes', '1430 PREPAID – Repairs & Maintenance','1440 PREPAID – Rent','1450 PREPAID – Deposits'];
var property_plant = ['1510 PPE – Buildings', '1520 PPE – Machinery & Equipment', '1530 PPE – Vehicles','1540 PPE – Computer Equipment','1550 PPE – Furniture & Fixtures','1560 PPE – Leasehold Improvements'];
var acc_dep = ['1610 ACCUM DEPR Buildings', '1620 ACCUM DEPR Machinery & Equipment', '1630 ACCUM DEPR Vehicles','1640 ACCUM DEPR Computer Equipment','1650 ACCUM DEPR Furniture & Fixtures','1660 ACCUM DEPR Leasehold Improvements'];
var noncurrenctreceivables = ['1710 NCA – Notes Receivable', '1720 NCA – Installment Receivables', '1730 NCA – Retainage Withheld'];
var intercompany_receivables = ['1910 Organization Costs', '1920 Patents & Licenses', '1930 Intangible Assets – Capitalized Software Costs'];
var liabilities = ['2110 A/P Trade', '2120 A/P Accrued Accounts Payable', '2130 A/P Retainage Withheld','2150 Current Maturities of Long-Term Debt','2160 Bank Notes Payable','2170 Construction Loans Payable'];
var accrued_compensation = ['2210 Accrued – Payroll', '2220 Accrued – Commissions', '2230 Accrued – FICA','2240 Accrued – Unemployment Taxes','2250 Accrued – Workmen’s Comp'];
var other_accrued_expenses = ['2310 Accrued – Rent', '2320 Accrued – Interest', '2330 Accrued – Property Taxes', '2340 Accrued – Warranty Expense'];
var accrued_taxes= ['2510 Accrued – Federal Income Taxes', '2520 Accrued – State Income Taxes', '2530 Accrued – Franchise Taxes','2540 Deferred – FIT Current','2550 Deferred – State Income Taxes'];
var deferred_taxes= ['2610 D/T – FIT – NON CURRENT', '2620 D/T – SIT – NON CURRENT'];
var long_term_debt=['2710 LTD – Notes Payable','2720 LTD – Mortgages Payable','2730 LTD – Installment Notes Payable'];
var intercompany_payables=['3100 Common Stock','3200 Preferred Stock','3300 Paid in Capital','3400 Partners Capital','3500 Member Contributions','3900 Retained Earnings'];
var revenue=['4010 REVENUE – PRODUCT 1','4020 REVENUE – PRODUCT 2','4030 REVENUE – PRODUCT 3','4040 REVENUE – PRODUCT 4','4600 Interest Income','4700 Other Income','4800 Finance Charge Income','4900 Sales Returns and Allowances','4950 Sales Discounts'];
var cost_goods= ['5010 COGS – PRODUCT 1', '5020 COGS – PRODUCT 2','5030 COGS – PRODUCT 3','5040 COGS – PRODUCT 4','5700 Freight','5800 Inventory Adjustments','5900 Purchase Returns and Allowances','5950 Reserved'];
var operating_expenses=['6010 Advertising Expense','6050 Amortization Expense','6100 Auto Expense','6150 Bad Debt Expense','6150 Bad Debt Expense','6200 Bank Charges','6250 Cash Over and Short','6300 Commission Expense','6350 Depreciation Expense','6400 Employee Benefit Program','6550 Freight Expense','6600 Gifts Expense','6650 Insurance – General','6700 Interest Expense','6750 Professional Fees','6800 License Expense','6850 Maintenance Expense','6900 Meals and Entertainment','6950 Office Expense','7000 Payroll Taxes','7050 Printing','7150 Postage','7200 Rent','7250 Repairs Expense','7300 Salaries Expense','7350 Supplies Expense','7400 Taxes – FIT Expense','7500 Utilities Expense','7900 Gain/Loss on Sale of Assets'];

      switch (ddl1.value) {
          case '1000 ASSETS':
              ddl2.options.length = 0;
              for (i = 0; i < assets.length; i++) {
                  createOption(ddl2, assets[i], assets[i]);
              }
              break;
          case '1200 RECEIVABLES':
              ddl2.options.length = 0;
              for (i = 0; i < receivables.length; i++) {
                  createOption(ddl2, receivables[i], receivables[i]);
              }
              break;
          case '1300 INVENTORIES':
              ddl2.options.length = 0;
              for (i = 0; i < inventories.length; i++) {
                  createOption(ddl2, inventories[i], inventories[i]);
              }
              break;
          case '1400 PREPAID EXPENSES & OTHER CURRENT ASSETS':
              ddl2.options.length = 0;
              for (i = 0; i < prepaid_expense.length; i++) {
                  createOption(ddl2, prepaid_expense[i], prepaid_expense[i]);
              }
              break;
          case '1500 PROPERTY PLANT & EQUIPMENT':
              ddl2.options.length = 0;
              for (i = 0; i < property_plant.length; i++) {
                  createOption(ddl2, property_plant[i], property_plant[i]);
              }
              break;
          case '1600 ACCUMULATED DEPRECIATION & AMORTIZATION':
              ddl2.options.length = 0;
              for (i = 0; i < acc_dep.length; i++) {
                  createOption(ddl2, acc_dep[i], acc_dep[i]);
              }
              break;
          case '1700 NON – CURRENT RECEIVABLES':
              ddl2.options.length = 0;
              for (i = 0; i < noncurrenctreceivables.length; i++) {
                  createOption(ddl2, noncurrenctreceivables[i], noncurrenctreceivables[i]);
              }
              break;
          case '1800 INTERCOMPANY RECEIVABLES & OTHER NON-CURRENT ASSETS':
              ddl2.options.length = 0;
              for (i = 0; i < intercompany_receivables.length; i++) {
                  createOption(ddl2, intercompany_receivables[i], intercompany_receivables[i]);
              }
              break;
          case '2000 LIABILITIES & PAYABLES':
              ddl2.options.length = 0;
              for (i = 0; i < liabilities.length; i++) {
                  createOption(ddl2, liabilities[i], liabilities[i]);
              }
              break;
          case '2200 ACCRUED COMPENSATION & RELATED ITEMS':
              ddl2.options.length = 0;
              for (i = 0; i < accrued_compensation.length; i++) {
                  createOption(ddl2, accrued_compensation[i], accrued_compensation[i]);
              }
              break;
          case '2300 OTHER ACCRUED EXPENSES':
              ddl2.options.length = 0;
              for (i = 0; i < other_accrued_expenses.length; i++) {
                  createOption(ddl2, other_accrued_expenses[i], other_accrued_expenses[i]);
              }
              break;
          case '2500 ACCRUED TAXES':
              ddl2.options.length = 0;
              for (i = 0; i < accrued_taxes.length; i++) {
                  createOption(ddl2, accrued_taxes[i], accrued_taxes[i]);
              }
              break;
          case '2600 DEFERRED TAXES':
              ddl2.options.length = 0;
              for (i = 0; i < deferred_taxes.length; i++) {
                  createOption(ddl2, deferred_taxes[i], deferred_taxes[i]);
              }
              break;
          case '2700 LONG-TERM DEBT':
              ddl2.options.length = 0;
              for (i = 0; i < long_term_debt.length; i++) {
                  createOption(ddl2, long_term_debt[i], long_term_debt[i]);
              }
              break;
          case '2800 INTERCOMPANY PAYABLES & OTHER NON CURRENT LIABILITIES & OWNERS EQUITIES':
              ddl2.options.length = 0;
              for (i = 0; i < intercompany_payables.length; i++) {
                  createOption(ddl2, intercompany_payables[i], intercompany_payables[i]);
              }
              break;
          case '4000 REVENUE':
              ddl2.options.length = 0;
              for (i = 0; i < revenue.length; i++) {
                  createOption(ddl2, revenue[i], revenue[i]);
              }
              break;
          case '5000 COST OF GOODS SOLD':
              ddl2.options.length = 0;
              for (i = 0; i < cost_goods.length; i++) {
                  createOption(ddl2, cost_goods[i], cost_goods[i]);
              }
              break;
          case '6000 - 7000 OPERATING EXPENSES':
              ddl2.options.length = 0;
              for (i = 0; i < operating_expenses.length; i++) {
                  createOption(ddl2, operating_expenses[i], operating_expenses[i]);
              }
              break;
          default:
              ddl2.options.length = 0;
              break;
      }
  }
  
  function createOption(ddl, text, value) {
      var opt = document.createElement('option');
      opt.value = value;
      opt.text = text;
      ddl.options.add(opt);
  }
</script>
</div>
</div>
</section>
</div>

<script type="text/javascript">
  var customerId = '<?php echo $this->input->get('id'); ?>';
  $("#tax_id").on("input", function() {
      var intValue = parseInt($(this).val().replace(/%/g, '')) || 0;
      $(this).val(intValue + '%');
  });
  $('#insert_unit').submit(function(event) {
      var dataString = {
          dataString: $("#insert_unit").serialize()
      };
      dataString[csrfName] = csrfHash;
      $.ajax({
          type: "POST",
          dataType: "json",
          url: '<?php echo base_url(); ?>Cproduct/insert_instant_unit?id=' + customerId,
          data: $("#insert_unit").serialize(),
          success: function(response) {
              $('#errormessage_unit').html("");
              if (response.status == 'success') {
                  $('#unit_name').empty();
                  $.each(response.data, function(index, item) {
                      var option = '<option value="' + item.unit_name + '">' + item
                          .unit_name + '</option>';
                      $('#unit').append(option);
                  });
                  $('#unit_name').val("");
                  $('#errormessage_unit').html(succalert + response.msg + alert2);
                  $('#unit').show();
                  window.setTimeout(function() {
                      $('#add_unit').modal('hide');
                  }, 2500);
                  $('#unit').selectmenu('refresh', true);
              } else {
                  $('#errormessage_unit').html(failalert + response.msg + alert2);
              }
          }
      });
      event.preventDefault();
  });
  //Add Category
  $('#insert_category').submit(function(e) {
      e.preventDefault();
      var data = {
          category_name: $('#category_name').val()
      };
      data[csrfName] = csrfHash;
      $.ajax({
          type: 'POST',
          data: data,
          dataType: "json",
          url: '<?php echo base_url(); ?>Cproduct/insert_instant_cat?id=' + customerId,
          success: function(response, status) {
              console.log(response);
              $('#errormessage_category').html("");
              if (response.status == 'success') {
                  $('#category_name').empty();
                  $.each(response.data, function(index, item) {
                      var option = '<option value="' + item.category_name + '">' + item
                          .category_name + '</option>';
                      $('#category_id').append(option);
                  });
                  $('#category_name').val("");
                  $('#errormessage_category').html(succalert + response.msg + alert2);
                  $('#category_id').show();
                  window.setTimeout(function() {
                      $('#add_cat').modal('hide');
                  }, 2500);
                  $('#category_id').selectmenu('refresh', true);
              } else {
                  $('#errormessage_category').html(failalert + response.msg + alert2);
              }
          }
      });
  });
  $(document).on('keyup', '.weight', function() {
      var weight = 0;
      $(this).closest('table').find('.weight').each(function() {
          var v = $(this).val();
          if (!isNaN(v) && v.length !== 0) {
              weight += parseFloat(v);
          }
      });
      $(this).closest('table').find('.overall_weight').val(weight.toFixed(3));
  });
  $(document).on('keyup', '.normalinvoice tbody tr:last', function(e) {
      var netheight = $('.normalinvoice').attr('id');
      const indexLastDot = netheight.lastIndexOf('_');
      var id = netheight.slice(indexLastDot + 1);
      var $last = $('#addPurchaseItem_1 tr:last');
      var num = id + ($last.index() + 1);
      $('#addPurchaseItem_1 tr:last').clone().find('input,select').attr('id', function(i, current) {
          return current.replace(/\d+$/, num);
      }).end().appendTo('#addPurchaseItem_1');
      $.each($('#producttable_1 > tbody > tr'), function(index, el) {
          $(this).find(".slab_no").val(index +
              1);
      })
  });
  $(document).ready(function() {
      var netheight = $(this).attr('id');
      const indexLastDot = netheight.lastIndexOf('_');
      var id = netheight.slice(indexLastDot + 1);
      var net_width = 'gross_width_' + id;
      var net_height = 'gross_height_' + id;
      var netwidth = $('#' + net_width).val();
      var netheight = $('#' + net_height).val();
      var netresult = parseInt(netwidth) * parseInt(netheight);
      netresult = netresult / 144;
      netresult = isNaN(netresult) ? 0 : netresult;
      var nresult = netresult.toFixed(3);
      $('#' + 'gross_sq_ft_' + id).val(netresult.toFixed(3));
      var cost_sqft = $('#cost_sq_ft_' + id).val();
      var sales_sqft = cost_sqft * nresult;
      var sales_slab_price = cost_sqft * nresult * id;
      console.log(parseInt(cost_sqft) + "*" + parseInt(nresult) + "*" + id);
      $('#' + 'sales_slab_amt_' + id).val(sales_slab_price.toFixed(3));
      sales_sqft = isNaN(sales_sqft) ? 0 : sales_sqft;
      $('#' + 'sales_amt_sq_ft_' + id).val(sales_sqft.toFixed(3));
      $('#title').hide();
      $('#account_category').bind('change', function() {
          var elements = $('div.container').children().hide();
          var value = $(this).val();
          if (value.length) {
              $('#title').show();
              elements.filter('.' + value).show();
          }
      }).trigger('change');
  });
  
  function createOption(ddl, text, value) {
      var opt = document.createElement('option');
      opt.value = value;
      opt.text = text;
      ddl.options.add(opt);
  }
  $(document).on('click', '.delete', function() {
      var tid = $(this).closest('table').attr('id');
     var rowCount = $(this).closest('tbody').find('tr').length;
   if(rowCount>1){
   $(this).closest('tr').remove();
   }else if(rowCount==1){
      $('#errormessage_product').html(failalert + 'Deletion not allowed. Table must contain at least one row' + alert2);
      return false;
   }
      localStorage.setItem("delete_table", tid);
 
      console.log(localStorage.getItem("delete_table"));
      $(this).closest('tr').remove();
      var sum = 0;
      $('#' + localStorage.getItem("delete_table")).find('.total_price').each(function() {
          var v = $(this).val();
          sum += parseFloat(v);
      });
      $('#' + localStorage.getItem("delete_table")).find('.b_total').val(sum).trigger('change');
      var sumnet = 0;
      $('#' + localStorage.getItem("delete_table")).find('.net_sq_ft').each(function() {
          var v = $(this).val();
          if (!isNaN(v) && v.length !== 0) {
              sumnet += parseFloat(v);
          }
      });
      $('#' + localStorage.getItem("delete_table")).find('.overall_net').val(sumnet.toFixed(3));
      var sumgross = 0;
      $('#' + localStorage.getItem("delete_table")).find('.gross_sq_ft').each(function() {
          var v = $(this).val();
          if (!isNaN(v) && v.length !== 0) {
              sumgross += parseFloat(v);
          }
      });
      $('#' + localStorage.getItem("delete_table")).find('.overall_gross').val(sumgross.toFixed(3));
      var sum_w = 0;
      $('#' + localStorage.getItem("delete_table")).find('.weight').each(function() {
          var precio = $(this).val();
          if (!isNaN(precio) && precio.length !== 0) {
              sum_w += parseFloat(precio);
          }
      });
      $('#overall_weight_1').val(sum_w).trigger('change');
  });
  $(document).ready(function() {
      var csrfName = $('.txt_csrfname').attr('name');
      var csrfHash = $('.txt_csrfname').val();
      $.ajaxSetup({
          cache: false
      });
      $('#product_name').keyup(function() {
          if (document.getElementById('product_name').value === "") {
              $("#result").hide();
          } else {
              $("#result").show();
          }
          $('#result').html('');
          $('#state').val('');
          var searchField = $('#product_name').val();
          var expression = new RegExp(searchField, "i");
          $.ajax({
              type: "POST",
              url: '<?php echo base_url(); ?>Cproduct/searchproduct',
              dataType: "json",
              data: {
                  [csrfName]: csrfHash,
                  searchField: searchField
              },
              success: function(data) {
                  $('#result').html('');
                  var productsFound = false;
                  $.each(data, function(key, value) {
                      if (value.product_name != '') {
                          $('#result').append(
                              '<li class="list-group-item link-class get_result">' +
                              value.product_name + ' - ' + value.product_model +
                              ' - ' + value.category_name + '</li>');
                          productsFound = true;
                      }
                  });
                  if (!productsFound) {
                      $("#result").hide();
                  } else {
                      $("#result").show();
                      $("#result").css({
                          "height": "200px",
                          "overflow": "scroll",
                          "width": "493px",
                          "position": "relative",
                          "left": "277px",
                          "top": "3px",
                      });
                  }
              }
          });
      });
  });
  $(document).ready(function() {
      $("#result").hide();
      $("#product_name").on("blur", function() {
          $("#result").hide();
      });
      $("#product_name").on("focus", function() {
          $("#result").show();
      });
  });
 
 var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
   $(document).ready(function() {
 $('#insert_supplier').submit(function (event) {
      var empty = $(this).find('input[required]').filter(function() {
       return this.value == '';
     });
     event.preventDefault();
      var formData = new FormData(this);

      formData.append(csrfName, csrfHash);
       $.ajax({
           type:"POST",
           dataType:"json",
           url:"<?php echo base_url(); ?>Csupplier/insert_supplier",
           data:formData,
           contentType: false, 
           processData: false,
           success:function (response) {
            if(response.status =="success"){
              window.location.href ="<?php echo base_url('Cproduct/') ?>?id=" +customerId;
            }else{
              $('.error_supplier').html(response.msg);
            }
           },
              error: function(xhr, status, error) {
                  console.error(xhr.responseText);
                  $('#errormessage_vendor').html(failalert +
                      "An error occurred. Please try again.");
              }
       });
       event.preventDefault();
   });
   var netheight = $(this).attr('id');
   const indexLastDot = netheight.lastIndexOf('_');
   var id = netheight.slice(indexLastDot + 1);
   var net_width='gross_width_'+id;
   var net_height = 'gross_height_'+ id;
   var netwidth=$('#'+net_width).val();
   var netheight=$('#'+net_height).val();
   var netresult=parseInt(netwidth) * parseInt(netheight);
   netresult=netresult/144;
   netresult = isNaN(netresult) ? 0 : netresult;
   var nresult=netresult.toFixed(3);
   
   $('#'+'gross_sq_ft_'+id).val(netresult.toFixed(3));
   var cost_sqft=$('#cost_sq_ft_'+id).val();
   
   var sales_sqft=cost_sqft *nresult;
   var sales_slab_price=cost_sqft *nresult*id;
   console.log(parseInt(cost_sqft) +"*"+parseInt(nresult)+"*"+id);
   $('#'+'sales_slab_amt_'+id).val("<?php //echo $currency." ";  ?>"+sales_slab_price.toFixed(3));
   sales_sqft = isNaN(sales_sqft) ? 0 : sales_sqft;
   $('#'+'sales_amt_sq_ft_'+id).val("<?php //echo $currency." ";  ?>"+sales_sqft.toFixed(3));
   $('#title').hide();
   $('#account_category').bind('change', function() {
   var elements = $('div.container').children().hide(); // hide all the elements
   var value = $(this).val();
   
   if (value.length) { // if somethings' selected
   $('#title').show();
   elements.filter('.' + value).show(); // show the ones we want
   }
   }).trigger('change');
   });
   
   
     $(document).ready(function() {
      var csrfName = $('.txt_csrfname').attr('name');
      var csrfHash = $('.txt_csrfname').val();
	      $.validator.addMethod("trimRequired", function(value, element) {
        return $.trim(value) !== "";
    }, "This field is required.");
	 $("#insert_product_form").validate({
	 rules: {
            product_name: "trimRequired",
            model: "required",
            email: "required",
            price: "required",
            quantity: "required",
            supplier_id: "required",
            category_id: "required"
           
        },
        messages: {
            product_name: "Product Name is required",
            model: "Product Model is required",
            email: "Email is required",
            price: "Price is required",
            quantity: "Quantity is required",
            supplier_id: "Supplier is required",
            category_id: "Category is required"
        },
        errorPlacement: function(error, element) {
            if (element.hasClass("select2-hidden-accessible")) {
                error.insertAfter(element.next('span.select2'));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
          event.preventDefault();
          var unique_pname = $('.validate_productname').val();
          var product_model = $('.p_model').val();
          var category_name = $('.cat_name').val();
            var product_id = $('#product_id').val();
           $.ajax({
              type: 'POST',
              url: '<?php echo base_url(); ?>Cproduct/uniqueproductname',
              data: {
                  [csrfName]: csrfHash,
                  unique_pname: unique_pname,
                  product_model: product_model,
                   product_id: product_id,
                  category_name: category_name
              },
              success: function(data) {
                  debugger;
                  var d = data.replace(/^\s+|\s+$/gm, '');
                  console.log(d);
                  if (d != "not available") {
                      $('#errormessage_product').html(failalert +
                          "Product with same Name , Model and Category Already Exists" +
                          alert2);
                  } else {
                      var form_data = new FormData($('#insert_product_form')[0]);
                      form_data.append(
                          '<?php echo $this->security->get_csrf_token_name(); ?>',
                          '<?php echo $this->security->get_csrf_hash(); ?>');
                      // var ins = document.getElementById('attachment').files.length;
                      // for (var x = 0; x < ins; x++) {
                      //     form_data.append("files[]", document.getElementById('attachment')
                      //         .files[x]);
                      // }
                      $.ajax({
                          url: '<?php echo base_url(); ?>Cproduct/insert_product_form',
                          type: 'POST',
                          data: form_data,
                          contentType: false,
                          processData: false,
                          success: function(response) {
                              var res = JSON.parse(response);
                              console.log(res);
                              if (res.status === 'success') {
                                  $('#errormessage_product').html(succalert + res
                                      .msg + alert2);
                                  setTimeout(function() {
                                      window.location.href =
                                          "<?php echo base_url('Cproduct/manage_product') ?>?id=" +
                                          (customerId);
                                  }, 3000);
                              } else if (res.status === 'failure') {
                                  $('#errormessage_product').html(failalert + res
                                      .msg + alert2);
                              }
                          },
                          error: function(xhr, status, error) {
                              console.error(xhr.responseText);
                              $('#errormessage_product').html(failalert +
                                  "An error occurred. Please try again.");
                          }
                      });
                  }
              },
              error: function(xhr, status, error) {
                  console.error(xhr.responseText);
                  $('#errormessage_product').html(failalert +
                      "An error occurred while checking product name. Please try again.");
              }
          });
      }
  });  });
   
</script>
