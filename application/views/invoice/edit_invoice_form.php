             <?php
$modaldata['bootstrap_model'] = array('payment_model', 'bank_info');
$modaldata['old_payment_id'] = $all_invoice[0]['payment_id'];
$this->load->view('include/bootstrap_model', $modaldata);
?>
<div class="content-wrapper">
   <section class="content-header">
      <div class="header-icon">
               <img src="<?php echo base_url()  ?>asset/images/sales.png"  class="headshotphoto" style="height:50px;" />
               </div>
      <div class="header-title">
          <div class="logo-holder logo-9">
           <h1><?php echo display('Edit Sale') ?></h1>
       </div>
         <small></small>
         <ol class="breadcrumb" style="border: 3px solid #d7d4d6;">
            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
            <li><a href="#"><?php echo display('invoice') ?></a></li>
            <li class="active" style="color:orange;"><?php echo display('Edit Sale') ?></li>
         </ol>
      </div>
   </section>
   <section class="content">
    <style>
           #bulk_payment_form input[type="text"]  { border: none; 
    background: inherit;
    padding: 0; 
    margin: 0; 
    box-shadow: none; 
    outline: none; 
}
            </style>
      <?php  $payment_id_new=rand(); ?>
      <!--Add Invoice -->
      <div class="row">
         <div class="col-sm-12">
            <div class="panel panel-bd lobidrag"   style="border: 3px solid #d7d4d6;" >
               <div class="panel-heading" style="height: 60px;">
                  <div class="panel-title">
                      <div class="error_display alert" style='margin-top:-20px;'></div>
                     <div class="Row">
                        <div class="Column" style="float: left;">
                            
                        </div>
                        <div class="Column" style="float: right;">
                           <form id="histroy" method="post" >
                              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                              <input type="hidden"  value="<?php if($all_invoice[0]['payment_id']){ echo $all_invoice[0]['payment_id']; }else{ echo $payment_id_new;}?>" name="makepaymentId" class="makepaymentId" id="makepaymentId"/>
                              <input type="hidden" value="<?php  echo $invoice_detail[0]['customer_id']; ?>" name="customer_id"/>
                              <input type="hidden" id='current_in_id' name="current_in_id"/>
                              <input type="submit" id="payment_history" name="payment_history" class="btnclr btn" style="float:right;  float:right;margin-bottom:30px;"   value="<?php echo display('Payment History') ?>"/>
                           </form>
                        </div>
                        <div class="Column" style="float: right;">
                           <a  href="<?php  echo base_url(); ?>Cinvoice/manage_invoice?id=<?php echo $_GET['id']; ?>"; class="btnclr btn  m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_invoice') ?> </a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="panel-body">
                  <?php //echo form_open_multipart('Cinvoice/manual_sales_insert',array('class' => 'form-vertical', 'id' => 'insert_sale','name' => 'insert_sale'))?>
                  <form id="insert_invoice"  method="post">
                     <div class="row">
                          <input type ="hidden"  id="admin_company_id" value="<?php echo $_GET['id'];  ?>" name="admin_company_id" />
                        <div class="col-sm-6" id="payment_from_1">
                           <div class="form-group row">
                              <label for="customer_name" class="col-sm-4 col-form-label"><?php
                                 echo display('customer_name');
                                 ?><i class="text-danger">*</i> </label>
                              <div class="col-sm-8">
                                 <select name="customer_name" class="form-control customer_name"  id="customer_name">
                                    <option value="<?php echo $invoice_detail[0]['customer_id']; ?>"><?php echo $invoice_detail[0]['customer_name']; ?></option>
                                    <?php foreach($customer as $customer){?>
                                    <option value="<?php echo html_escape($customer['customer_id'])?>"><?php echo html_escape($customer['customer_name']);?></option>
                                    <?php }?>
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                    <input id="autocomplete_customer_id" class="customer_hidden_value abc" type="hidden" style="border: 2px solid #d7d4d6;"  name="customer_id" value="{customer_name}" >
                              </div>
                              <?php if($this->permission1->method('add_customer','create')->access()){ ?>
                              <?php } ?>
                           </div>
                        </div>
                        <div class="col-sm-6" id="payment_from">
                      <div class="form-group row">
                              <label for="date" class="col-sm-4 col-form-label"><?php echo display('Invoice Number') ?><i class="text-danger">*</i></label>
                              <div class="col-sm-8">
                                 <input class="form-control" placeholder="Commercial Invoice Number" id="invoice"  type="text" name="commercial_invoice_number"  style="border: 2px solid #d7d4d6;"  value= "<?php  echo $invoice_detail[0]['commercial_invoice_number'] ; ?>"  />
                              </div>
                           </div>
                        </div>
                     </div>
                         <input type="hidden" id="inv_id"/>
                           <input type="hidden" id="inv_no"/>
                      <input type="hidden" id="makepaymentId" name="makepaymentId" value="<?php echo $all_invoice[0]['payment_id']; ?>">
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group row">
                              <label for="date" class="col-sm-4 col-form-label"><?php echo display('Sales Invoice date') ?> <i class="text-danger">*</i></label>
                              <div class="col-sm-8">
                                 <?php
                                    $date = date('Y-m-d');
                                                                       ?>
                                 <input class=" form-control" type="date" size="50" name="invoice_date" id="date"   style="border: 2px solid #d7d4d6;"  value="<?php  echo $invoice_detail[0]['date'] ; ?>" tabindex="4" />
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="billing_address" class="col-sm-4 col-form-label"><?php echo display('Billing Address') ?><i class="text-danger">*</i></label>
                              <div class="col-sm-8">
                                 <textarea rows="5" cols="50" name="billing_address" class=" form-control"  placeholder='Billing Address' style="border: 2px solid #d7d4d6;"  id="billing_address"> <?php  echo $invoice_detail[0]['billing_address'] ; ?></textarea>
                              </div>
                           </div>
                           <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                           <input type="hidden"  value="<?php if($invoice_detail[0]['payment_id']){ echo $invoice_detail[0]['payment_id']; }else{ echo $payment_id_new;}?>"  name="payment_id"/>
                           <div class="form-group row">
                              <label for="shipping_address" class="col-sm-4 col-form-label"><?php echo display('Shipping Address') ?></label>
                              <div class="col-sm-8">
                                 <textarea rows="5" cols="50" name="shipping_address" class=" form-control" placeholder='Shipping Address'  style="border: 2px solid #d7d4d6;"  id="shipping_address"><?php  echo $invoice_detail[0]['shipping_address'] ; ?> </textarea>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="payment_terms" class="col-sm-4 col-form-label"><?php echo display('Payment Terms') ?><i class="text-danger">*</i></label>
                              <div class="col-sm-8">
                                 <select   name="terms" id="payment_terms" class=" form-control" placeholder='Payment Terms'  style="border: 2px solid #d7d4d6;"  id="payment_terms">
                                   <option selected value="<?php echo $invoice_detail[0]['payment_terms']; ?>"><?php echo $invoice_detail[0]['payment_terms']; ?></option>  
                                     <?php foreach (PAYMENT_TYPE as $payment_typ) {?>
                            <option value="<?php echo $payment_typ; ?>"><?php echo $payment_typ; ?></option>
                        <?php }?>
                                 </select>
                              </div>
                              <!-- <a href="#" class="client-add-btn btn " style="color:white;background-color:#38469f;" aria-hidden="true" data-toggle="modal" data-target="#payment_terms"><i class="ti-plus m-r-2"></i></a> -->
                           </div>
                              <div class="form-group row">
                              <label for="port_of_discharge" class="col-sm-4 col-form-label"><?php echo display('Payment Due date') ?><i class="text-danger">*</i></label>
                              <div class="col-sm-8">
                                 <input class="form-control" type="date" size="50" value= "<?php  echo $invoice_detail[0]['payment_due_date'] ; ?>" name="payment_due_date" id="date1"  style="border: 2px solid #d7d4d6;"   tabindex="4" />
                              </div>
                           </div>
                                <div class="form-group row">
                        <label for="payment_type" class="col-sm-4 col-form-label"><?php
                           echo display('payment_type');
                           ?> </label>
                        <div class="col-sm-8">
                        <select name="paytype" id="paytype" class="form-control"  style="border: 2px solid #d7d4d6;"  tabindex="3" >
                        <option value="<?php echo $invoice_detail[0]['customer_id']; ?>"><?php echo $invoice_detail[0]['customer_id']; ?></option>
                        <?php  foreach($payment_type as $pt){ ?>
                        <option value="<?php  echo $pt['payment_type'] ;?>"><?php  echo $pt['payment_type'] ;?></option>
                        <?php  } ?>
                        </select>
                        </div>
                        </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group row">
                              <label for="container_number" class="col-sm-4 col-form-label"><?php echo display('Container Number') ?> </label>
                              <div class="col-sm-8">
                                 <input class="form-control" placeholder="Container Number" type="text" size="50" name="container_no" id="date"  style="border: 2px solid #d7d4d6;"   value= "<?php  echo  $invoice_detail[0]['container_no'] ; ?>" tabindex="4" />
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group row">
                              <label for="date" class="col-sm-4 col-form-label"><?php echo display('B/L No') ?><i class="text-danger"></i></label>
                              <div class="col-sm-8">
                                 <input class="form-control" placeholder="BL Number" type="text" size="50" name="bl_no"  style="border: 2px solid #d7d4d6;"  value= "<?php  echo $invoice_detail[0]['bl_no'] ; ?>"/>
                              </div>
                              <input type="hidden" id="invoice_hdn"/> <input type="hidden" id="invoice_hdn1"/>
                           </div>
                           <div class="form-group row">
                              <label for="ETA" class="col-sm-4 col-form-label"><?php echo display('Estimated Time of Arrival') ?></label>
                              <div class="col-sm-8">
                                 <input class="form-control" type="date" size="50" value="<?php echo $invoice_detail[0]['eta'] ; ?>"  name="eta" id="date1"  style="border: 2px solid #d7d4d6;"   tabindex="4" />
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="ETA" class="col-sm-4 col-form-label"><?php echo display('Estimated Time of Departure') ?></label>
                              <div class="col-sm-8">
                                 <input type="date" name="etd"  value= "<?php  echo $invoice_detail[0]['etd'] ; ?>" class="form-control">
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="port_of_discharge" class="col-sm-4 col-form-label"><?php echo display('Port Of Discharge') ?></label>
                              <div class="col-sm-8">
                                 <input class="form-control" type="" size="50" name="Port_of_discharge" id="date1"   value= "<?php  echo $invoice_detail[0]['Port_of_discharge']; ?>"  tabindex="4" />
                              </div>
                           </div>
                             <div class="form-group row">
                              <label for="account_category" class="col-sm-4 col-form-label">Account Category</label>
                               <div class="col-sm-8">
                                    <select id="ddl"  name="account_category" class="form-control"  style="border: 2px solid #d7d4d6;"  onchange="configureDropDownLists(this,document.getElementById('ddl2'))">
                                       <option value="<?php echo $invoice_detail[0]['account_category']; ?>" <?php if($invoice_detail[0]['account_category']) { echo 'selected'; } ?>>
                                       <?php echo $invoice_detail[0]['account_category']; ?>
                                    </option>
                                        <option value="ASSETS"><?php echo  display('ASSETS');?></option>
                                        <option value="RECEIVABLES"><?php echo  display('RECEIVABLES');?></option>
                                        <option value="INVENTORIES"><?php echo  display('INVENTORIES');?></option>
                                        <option value="PREPAID EXPENSES & OTHER CURRENT ASSETS"><?php echo  display('PREPAID EXPENSES & OTHER CURRENT ASSETS');?></option>
                                        <option value="PROPERTY PLANT & EQUIPMENT"><?php echo  display('PROPERTY PLANT & EQUIPMENT');?></option>
                                        <option value="ACCUMULATED DEPRECIATION & AMORTIZATION"><?php echo  display('ACCUMULATED DEPRECIATION & AMORTIZATION');?></option>
                                        <option value="NON – CURRENT RECEIVABLES"><?php echo  display('NON – CURRENT RECEIVABLES');?></option>
                                        <option value="INTERCOMPANY RECEIVABLES & OTHER NON-CURRENT ASSETS"><?php echo  display('INTERCOMPANY RECEIVABLES & OTHER NON-CURRENT ASSETS');?></option>
                                        <option value="LIABILITIES & PAYABLES"><?php echo  display('LIABILITIES & PAYABLES');?></option>
                                        <option value="ACCRUED COMPENSATION & RELATED ITEMS"><?php echo  display('ACCRUED COMPENSATION & RELATED ITEMS');?></option>
                                        <option value="OTHER ACCRUED EXPENSES"><?php echo  display('OTHER ACCRUED EXPENSES');?></option>
                                        <option value="ACCRUED TAXES"><?php echo  display('ACCRUED TAXES');?></option>
                                        <option value="DEFERRED TAXES"><?php echo  display('DEFERRED TAXES');?></option>
                                        <option value="LONG-TERM DEBT"><?php echo  display('LONG-TERM DEBT');?></option>
                                        <option value="INTERCOMPANY PAYABLES & OTHER NON CURRENT LIABILITIES & OWNERS EQUITIES"><?php echo  display('INTERCOMPANY PAYABLES & OTHER NON CURRENT LIABILITIES & OWNERS EQUITIES');?></option>
                                        <option value="REVENUE"><?php echo  display('REVENUE');?></option>
                                        <option value="COST OF GOODS SOLD"><?php echo  display('COST OF GOODS SOLD');?></option>
                                        <option value="OPERATING EXPENSES"><?php echo  display('OPERATING EXPENSES');?></option>
                                    </select>
                                </div>
                           </div>
                             <div class="form-group row">
                              <label  class="col-sm-4 col-form-label">Account Subcategory</label>
                              <div class="col-sm-8">
                                <input class="form-control" name ="account_subcat" id="account_subcat" type="text" placeholder=" Account Sub Category"  style="border: 2px solid #d7d4d6;"  value="<?php echo $invoice_detail[0]['account_subcat']; ?>" tabindex="1" >
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="port_of_discharge" class="col-sm-4 col-form-label">Account Subcategory</label>
                              <div class="col-sm-8">
                                <select class="form-control" style="border: 2px solid #d7d4d6;"  name="sub_category" id="ddl2">
                                    <option value="<?php echo $invoice_detail[0]['sub_category']; ?>" <?php if($invoice_detail[0]['sub_category']) { echo 'selected'; } ?>>
                                       <?php echo $invoice_detail[0]['sub_category']; ?>
                                    </option>
                                </select>
                              </div>
                           </div>
                                  <?php
if ($_SESSION['u_type'] == 2) {?>
                        <div class="form-group row">
                           <label for="sold_by" class="col-sm-4 col-form-label">Sold By</label>
                           <div class="col-sm-8">
                              <select name="emp_id" id="emp_id" class="form-control" style="border: 2px solid #D7D4D6;" tabindex="3">
                               <option value="<?php echo $invoice_detail[0]['user_emp_id']; ?>"><?php echo $invoice_detail[0]['sc_emp_name']; ?></option>
                               <?php foreach ($employee_info as $pt) {?>
                               <option value="<?php echo $pt['id']; ?>"><?php echo $pt['first_name'] . ' ' . $pt['last_name']; ?></option>
                               <?php }?>
                               </select>
                         <input type="hidden" name="selected_text" id="selected_text" <?php if ($invoice_detail[0]['sc_emp_name'] !== '') {
    echo 'value="' . $invoice_detail[0]['sc_emp_name'] . '"';
}
    ?>>
                           </div>
                        </div>
                        <?php }?>
                           <div class="form-group row">
                              <label for="ETA" class="col-sm-4 col-form-label"><?php echo display('Attachments') ?></label>
                              <div class="col-sm-6">
                                 <p>
                                    <label for="attachment">
                                    <a class="btnclr btn   text-light" role="button" aria-disabled="false"><i class="fa fa-upload"></i>&nbsp; Choose Files</a>
                                    </label>
                                    <input type="file" name="invoicefiles[]" class="upload" id="attachment" style="visibility: hidden; position: absolute;" multiple/>
                                    <br>
                                    <?php if (!empty($edit_files)) { ?>
                                        <?php foreach ($edit_files as $key => $attachment) { ?> 
                                      <a href="<?php  echo base_url(); ?>uploads/invoice/<?php echo $attachment['files']; ?>" class="file-block" target=_blank><span class="file-delete"><span><i class="fa fa-trash-o"></i></span></span><?php echo $attachment['files']; ?></a>
                                       <?php } ?>
                                    <?php } ?>
                                 </p>
                                 <p id="files-area">
                                    <span id="filesList">
                                    <span id="files-names"></span>
                                    </span>
                                 </p>
                              </div>
                           </div>
                        </div>
                     </div>
                     <?php  $d= $tax_details; 
                        $t='';
                        if($d !=='' && !empty($d)){
                           preg_match('#\((.*?)\)#', $d, $match);
                           $t=$match[1];$t=trim($t);
                         }else{
                           $t=$t=trim($t);
                         }
                        ?> 
                     <br>
                     <div class="table-responsive">
                        <div id="content" style="overflow-x: auto;">
                           <?php 
                              for($m=0;$m<=count($all_invoice);$m++){ 
                                  ?>
                           <table class="table table-bordered normalinvoice table-hover" id="normalinvoice_<?php  echo $m; ?>" style="border: 2px solid #d7d4d6;" >
                              <thead>
                                 <tr>
                                    <th rowspan="2" class="text-center" style="width:170px;" ><?php echo display('product_name') ?><i class="text-danger">*</i>  </th>
                                    <th rowspan="2" class="text-center" style="width:80px;"><?php echo display('Bundle No') ?><i class="text-danger">*</i></th>
                                    <th rowspan="2"  class="text-center"><?php echo display('Description') ?></th>
                                    <th rowspan="2" class="text-center" style="width:60px;"><?php echo display('Thick ness') ?><i class="text-danger">*</i></th>
                                    <th rowspan="2" class="text-center"><?php echo display('Supplier Block No') ?><i class="text-danger">*</i></th>
                                    <th rowspan="2" class="text-center" ><?php echo display('Supplier Slab No') ?><i class="text-danger">*</i> </th>
                                    <th colspan="2"   style="width:150px;" class="text-center"><?php echo display('Gross Measurement') ?><i class="text-danger">*</i> </th>
                                    <th rowspan="2" class="text-center"><?php echo display('Gross Sq.Ft') ?></th>
                                  
                                    <th colspan="2"  style="width:150px;" class="text-center"><?php echo display('Net Measure') ?><i class="text-danger">*</i></th>
                                    <th rowspan="2" class="text-center"><?php echo display('Net Sq.Ft') ?></th>
                                    <th rowspan="2"  class="text-center"><?php echo display('Cost per Sq.Ft') ?></th>
                                    <th rowspan="2"  class="text-center"><?php echo display('Cost per Slab') ?></th>
                                    <?php  if($all_invoice[0]['landing_cost']){ ?>
                                    <th rowspan="2" class="land_th" style="width: 100px" class="text-center"><?php echo "Landing Cost per Sq.Ft" ?></th>
                                    <th rowspan="2" class="land_th" style="width: 100px" class="text-center"><?php echo "Landing Cost per Slab" ?></th>
                                    <?php  } ?>
                                    <th rowspan="2"  class="text-center"><?php echo display('Sales') ?><br/><?php echo display('Price per Sq.Ft') ?></th>
                                    <th rowspan="2"  class="text-center"><?php echo display('Sales Slab Price') ?></th>
                                    <th rowspan="2" class="text-center"><?php echo display('Weight') ?></th>
                                   
                                    <th rowspan="2" style="width: 100px" class="text-center"><?php echo display('Total') ?></th>
                                    <th rowspan="2" class="text-center"><?php echo display('Action') ?></th>
                                 </tr>
                                 <tr>
                                    <th class="text-center"><?php echo display('Width') ?></th>
                                    <th class="text-center"><?php echo display('Height') ?></th>
                                    <th class="text-center"  ><?php echo display('Width') ?></th>
                                    <th class="text-center" ><?php echo display('Height') ?></th>
                                 </tr>
                              </thead>
                              <tbody class="tbody" id="addPurchaseItem_<?php echo $m;  ?>">
                                 <?php  $n=0; ?>
                                 <?php foreach($invoice_detail as $inv){
                                    $a = substr($inv['tableid'], 0, 1);
                                    if($a==$m){
                                    ?>
                                 <tr>
                                    <td>
                                       <input type="hidden" name="tableid[]" id="tableid_1" value="<?php  echo $inv['tableid'];   ?>"/>
                                       <input list="magicHouses" name="prodt[]" id="prodt_<?php  echo $m.$n; ?>" class="form-control product_name" value="<?php  echo $inv['product_name'];  ?>" onfocus="this.value=''" style="width:160px;" />
                                       <datalist id="magicHouses">
                                          <?php                                
                                             foreach($product as $tx){?>
                                          <option value="<?php echo $tx['product_name'].'-'.$tx['product_model'];?>">  <?php echo $tx['product_name'].'-'.$tx['product_model'];  ?></option>
                                          <?php } ?>
                                       </datalist>
                                       <input type='hidden' class='common_product autocomplete_hidden_value  product_id_1' value="<?php  echo $inv['product_id'];  ?>" name='product_id[]' id='selected_product_id_<?php  echo $m.$n; ?>' />
                                    </td>
                                    <td>
                                       <input list="magic_bundle" name="bundle_no[]" id="bundle_no_<?php  echo $m.$n; ?>"  value="<?php  echo $inv['bundle_no'];  ?>"  class="form-control bundle_no"   onfocus="this.value=''" onchange="this.blur();" />
                                       <datalist id="magic_bundle">
                                          <?php                                
                                             foreach($bundle as $tx){?>
                                          <option value="<?php echo $tx['bundle_no'];?>">  <?php echo $tx['bundle_no'];  ?></option>
                                          <?php } ?>
                                       </datalist>
                                     
                                    </td>
                                 
                                    <td>
                                       <input type="text" id="description_<?php  echo $m.$n; ?>" name="description[]" value="<?php  echo $inv['description'];  ?>" class="form-control" />
                                    </td>
                                    <td >
                                       <input type="text" name="thickness[]" id="thickness_<?php  echo $m.$n; ?>" required="" value="<?php  echo $inv['thickness'];  ?>" class="form-control"/>
                                    </td>
                                    <td>
                                       <input list="magic_supplier_block" name="supplier_block_no[]"  id="supplier_b_no_<?php  echo $m.$n; ?>"  value="<?php  echo $inv['supplier_block_no'];  ?>"  class="form-control supplier_block_no"  placeholder="Search Product" onfocus="this.value=''" onchange="this.blur();" />
                                       <datalist id="magic_supplier_block">
                                          <?php                                
                                             foreach($supplier_block_no as $tx){?>
                                          <option value="<?php echo $tx['supplier_block_no'];?>">  <?php echo $tx['supplier_block_no'];  ?></option>
                                          <?php } ?>
                                       </datalist>
                                    </td>
                                   
                                    <td >
                                       <input type="text"  id="supplier_s_no_<?php  echo $m.$n; ?>" name="supplier_slab_no[]" required="" value="<?php  echo $inv['supplier_slab_no'];  ?>" class="form-control"/>
                                    </td>
                                    <td>
                                       <input type="text" id="gross_width_<?php  echo $m.$n; ?>" name="gross_width[]" required="" value="<?php  echo $inv['g_width'];  ?>" class="gross_width  form-control" />
                                    </td>
                                    <td>
                                       <input type="text" id="gross_height_<?php  echo $m.$n; ?>" name="gross_height[]"  required=""  value="<?php  echo $inv['g_height'];  ?>" class="gross_height form-control" />
                                    </td>
                                    <td >
                                       <input type="text"   style="width:60px;" readonly id="gross_sq_ft_<?php  echo $m.$n; ?>" name="gross_sq_ft[]" value="<?php  echo $inv['gross_sqft'];  ?>" class="gross_sq_ft form-control"/>
                                    </td>
                                   
                                    <td>
                                       <input type="text" id="net_width_<?php  echo $m.$n; ?>" name="net_width[]" required="" value="<?php  echo $inv['n_width'];  ?>" class="net_width form-control" />
                                    </td>
                                    <td>
                                       <input type="text" id="net_height_<?php  echo $m.$n; ?>" name="net_height[]"    required="" value="<?php  echo $inv['n_height'];  ?>" class="net_height form-control" />
                                    </td>
                                    <td >
                                       <input type="text"   style="width:60px;" readonly id="net_sq_ft_<?php  echo $m.$n; ?>" name="net_sq_ft[]" value="<?php  echo $inv['net_sqft'];  ?>" class="net_sq_ft form-control"/>
                                    </td>
                                    <td>
                                       <span class="input-symbol-euro"><input type="text" id="cost_sq_ft_<?php  echo $m.$n; ?>"  name="cost_sq_ft[]"   style="width:60px;" value="<?php  echo $inv['cost_sqft'];  ?>" readonly  class="cost_sq_ft form-control" ></span>
                                    <td >
                                       <span class="input-symbol-euro"> <input type="text"  id="cost_sq_slab_<?php  echo $m.$n; ?>" name="cost_sq_slab[]"  readonly  style="width:60px;" value="<?php  echo $inv['cost_slab'];  ?>"  class="cost_sq_slab form-control"/></span>
                                    </td>
                                    <?php   if($inv['landing_cost']){ ?>
                                    <td class="landing_field"><span class="input-symbol-euro"><input type="text" readonly style="width:80px;" name="l_cost[]"  value="<?php  echo $inv['landing_cost'];  ?>"  class="form-control l_cost"></span></td>
                                    <td class="landing_field"><span class="input-symbol-euro"><input type="text" style="width:80px;" readonly name="l_cost_slab[]" value="<?php  echo $inv['landing_cost_slab'];  ?>"  class="form-control l_cost_slab"></span></td>
                                    <?php  } ?>
                                    <td>
                                       <span class="input-symbol-euro">  <input type="text" id="sales_amt_sq_ft_<?php  echo $m.$n; ?>"  name="sales_amt_sq_ft[]"  style="width:60px;"  value="<?php  echo $inv['sales_price_sqft'];  ?>" class="sales_amt_sq_ft form-control" /></span>
                                    </td>
                                    <td >
                                       <span class="input-symbol-euro">   <input type="text"  id="sales_slab_amt_<?php  echo $m.$n; ?>" name="sales_slab_amt[]"  style="width:60px;" value="<?php  echo $inv['sales_slab_price'];  ?>"  class="sales_slab_amt form-control"/>
                                    </td>
                                    </span>
                                    </td>
                                    <td>
                                       <input type="text" id="weight_<?php  echo $m.$n; ?>" name="weight[]"  value="<?php  echo $inv['weight'];  ?>" class="weight form-control" />
                                    </td>
                                   
                                    <td >
                                       <span class="input-symbol-euro"><input  type="text" class="total_price form-control" style="width:70px;"   value="<?php  echo $inv['total_price'];  ?>"  id="total_<?php  echo $m.$n; ?>"     name="total_amt[]"/></span>
                                    </td>
                                    <td style="text-align:center;">
                                       <button  class='delete btn btn-danger' type='button' value='Delete' ><i class='fa fa-trash'></i></button>
                                    </td>
                                 </tr>
                                 <?php $n++;   } }  ?>
                              </tbody>
                              <tfoot>
                                 <tr>
                                    <td style="text-align:right;" colspan="8"><b><?php echo display('Gross Sq.Ft') ?> :</b></td>
                                    <td >
                                       <input type="text" id="overall_gross_<?php echo $m; ?>" name="overall_gross[]"    class="overall_gross form-control" style="width: 60px"   readonly="readonly"  /> 
                                    </td>
                                    <td style="text-align:right;" colspan="2"><b><?php echo display('Net Sq.Ft') ?> :</b></td>
                                    <td >
                                       <input type="text" id="overall_net_<?php echo $m; ?>" name="overall_net[]"  class="overall_net form-control"  style="width: 60px"   readonly="readonly"  /> 
                                    </td>
                                    <td >
                                       <input type="text" id="costpersqft_<?php echo $m; ?>" name="costpersqft[]"  class="costpersqft form-control"  style="width: 60px"  readonly="readonly"  /> 
                                    </td>
                                    <td >
                                       <input type="text" id="costperslab_<?php echo $m; ?>" name="costperslab[]"  class="costperslab form-control"  style="width: 60px"  readonly="readonly"  /> 
                                    </td>
                                    <?php  if($invoice_detail[0]['landing_cost']){ ?>
                                    <td class="lc_tdfields">
                                       <input type="text" id="landingpersqft_<?php echo $m; ?>" name="landingpersqft[]"  class="landingpersqft form-control"  style="width: 60px"  readonly="readonly"  /> 
                                    </td>
                                    <td class="lc_tdfields">
                                       <input type="text" id="landingperslab_<?php echo $m; ?>" name="landingperslab[]"  class="landingperslab form-control"  style="width: 60px"  readonly="readonly"  /> 
                                    </td>
                                    <?php  }  ?>
                                    <td >
                                       <input type="text" id="salespricepersqft_<?php echo $m; ?>" name="salespricepersqft[]"  class="salespricepersqft form-control"  style="width: 60px"  readonly="readonly"  /> 
                                    </td>
                                    <td >
                                       <input type="text" id="salesslabprice_<?php echo $m; ?>" name="salesslabprice[]"  class="salesslabprice form-control"  style="width: 60px"  readonly="readonly"  /> 
                                    </td>
                                    <td >
                                       <input type="text" id="overall_weight_<?php echo $m; ?>" name="overall_weight[]"  class="overall_weight form-control"  style="width: 70px"  readonly="readonly"  /> 
                                    </td>
                                    <td >
                                       <span class="input-symbol-euro">     <input type="text" id="Total_<?php echo $m; ?>" name="total[]"   class="b_total form-control"   style="padding-top: 6px;width: 70px"    readonly="readonly"  />
                                    </td>
                                    <td colspan="21" style="text-align: center;">
                                       <i id="buddle_<?php echo $m; ?>" class="btn-danger removebundle fa fa-minus"  aria-hidden="true"></i>    
                                    </td>
                                 </tr>
                              </tfoot>
                           </table>
                           <?php   } ?>
                           <i id="buddle_1" class="btnclr addbundle fa fa-plus" style=" padding: 10px 12px 10px 12px;margin-right: 18px;float:right; "   onclick="addbundle(); "aria-hidden="true"></i>
                        </div>
                     </div>
                     <table class="taxtab table table-bordered table-hover" style="border: 2px solid #d7d4d6;" >
                        <tr>
                           <td class="hiden" style="width:20%;border:none;text-align:end;font-weight:bold;">
                              <?php echo display('Live Rate') ?> : 
                           </td>
                           <td class="btnclr hiden" style="width:12%;text-align-last: center;padding:5px; border:none;font-weight:bold;color:white;">1 <?php  echo $curn_info_default;  ?>
                              = <input style="width: 80px;text-align:center;color:black;padding:5px; " type="text" class="custocurrency_rate"/>&nbsp;<label for="custocurrency"></label>
                           </td>
                           <td style="border:none;text-align:right;font-weight:bold;">  <?php echo display('Tax') ?> : 
                           </td>
                           <td style="width:12%">
                              <?php   
                              $get_tax_percent= getDataInsideBrackets($invoice_detail[0]['total_tax']);  
                              ?>
                              <input list="magic_tax" name="tx"  id="product_tax" value="<?php  echo $get_tax_percent; ?>" class="form-control"   onchange="this.blur();" />
                              <datalist id="magic_tax">
                                 <?php                                
                                    foreach($tax_data as $tx){?>
                                 <option value="<?php echo $tx['tax'].'%';?>">  <?php echo $tx['tax'].'%';  ?></option>
                                 <?php } ?>
                              </datalist>
                           </td>
                           <td  style="width:20%;"></td>
                        </tr>
                     </table>
                    <table border="0" style="width: 100%; border-collapse: collapse; text-align: left;" class="overall table table-bordered table-hover" style="border:2px solid #d7d4d6;">
    <tbody>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="Over_all_Total"><b><?php echo display('Overall TOTAL') ?> :</b></label>
                <input type="text" id="Over_all_Total" name="Over_all_Total" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" value="<?php echo $invoice_detail[0]['total_amount'];  ?>" readonly="readonly" />
            </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="additional_cost"><b><?php echo ('Additional Cost') ?> :</b></label>
                <input type="text" id="additional_cost" name="additional_cost" value="<?php  echo $invoice_detail[0]['lc_cost_total'] ;   ?>" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" readonly="readonly" />
            </td>
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="total_gross"><b><?php echo display('Overall Gross Sq.Ft') ?> :</b></label>
                <input type="text" id="total_gross" value="<?php echo  $invoice_detail[0]['total_gross'];  ?>" name="total_gross" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" readonly="readonly" />
            </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="tax_details"><b><?php echo display('TAX DETAILS') ?> :</b></label>
                <input type="text" id="tax_details" name="tax_details" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" value="0.00" readonly="readonly" />
            </td>
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="total_net"><b><?php echo display('Overall Net Sq.Ft') ?> :</b></label>
                <input type="text" id="total_net" name="total_net" value="<?php echo  $invoice_detail[0]['total_net'];  ?>" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" readonly="readonly" />
            </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="gtotal"><b><?php echo display('GRAND TOTAL') ?> :</b></label>
                <input type="text" id="gtotal" name="gtotal" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" value="<?php echo $all_invoice[0]['gtotal'];  ?>" readonly="readonly" />
            </td>
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="total_weight"><b><?php echo display('Overall Weight') ?> :</b></label>
                <input type="text" id="total_weight" name="total_weight" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" readonly="readonly" />
            </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="customer_gtotal"><b><?php echo display('Preferred Currency') ?> :</b></label>
                <input type="text" id="customer_gtotal" name="customer_gtotal" value="<?php echo $invoice_detail[0]['gtotal_preferred_currency'];  ?>" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" readonly />
            </td>
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="amount_paid"><b><?php echo display('Amount Paid') ?> :</b></label>
                <input type="text" id="amount_paid" name="amount_paid" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" readonly />
            </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="balance"><b><?php echo display('Balance Amount') ?> :</b></label>
                <input type="text" id="balance" name="balance" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" readonly />
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr style="border-right:none; border-left:none; border-bottom:none; border-top:none;">
            <td colspan="2" style="text-align: right; padding: 20px;">
                <input type="submit" value="<?php echo "Additional Cost"; ?>" class="btnclr btn btn-large" id="landing_cost" style="color:white; margin-right: 10px;" />
               <a class="client-add-btn btn btnclr" aria-hidden="true" id="paypls" data-toggle="modal" data-target="#payment_modal">
                      Make Payment
             </a>
            </td>
        </tr>
    </tfoot>
</table>
                        <input type="hidden" id="final_gtotal"  name="final_gtotal" />
                        <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/>
                     <div class="form-group row">
                     <div class="col-sm-6 ">
                     <table style="height:100px;">
                     <tr>
                     <td>
                     <input type="submit" id="add_purchase"   class="btnclr btn btn-large" name="add-packing-list" value= <?php echo display('Save') ?> />
                     </td>
                     <td class="hidden_button"> 
                     <a    id="final_submit"   class='btnclr final_submit btn'> <?php echo display('submit') ?></a>
                     </td>
                     <td class="hidden_button">         
                     <select name="download_select" id="download_select" class="form-control"   style="background-color:<?php echo $setting_detail[0]['button_color']; ?>; color:white;width:auto;"  >
                     <option value="Download"  class="btnclr"   selected><?php echo display('Download') ?></option>
                     <option value="Invoice" ><?php echo display('New Invoice') ?></option>
                     <option value="Packing" ><?php echo display('Packing List') ?></option>
                     </select>
                     </td>       
                     <td style="width:20px;" class="hidden_button"></td>
                     <td class="hidden_button">
                     <select name="print_select" id="print_select" class="form-control"  style="background-color:<?php echo $setting_detail[0]['button_color']; ?>; color:white;width:auto;"  >
                     <option class="btnclr"  value="Print" selected><?php echo display('Print') ?></option>
                     <option value="Invoice" ><?php echo display('New Invoice') ?></option>
                     <option value="Packing" ><?php echo display('Packing List') ?></option>
                     </select>
                     </td>                   
                     </tr>
                     </div>
                     </div>
                     </div>
               </div>
               <div class="form-group row">
               </div>
               <div class="form-group row">
               <label for="billing_address" class="col-sm-4 col-form-label"><?php echo display('Account Details/Additional Information') ?></label>
               <div class="col-sm-8">
               <textarea rows="4" cols="50" id="details" name="ac_details"     style="border: 2px solid #d7d4d6;"   class=" form-control"  ><?php  if(!empty($invoice_detail[0]['ac_details'])){echo trim($invoice_detail[0]['ac_details']);} ?></textarea>
               </div>
               </div> 
               <div class="form-group row">
               <label for="remark" class="col-sm-4 col-form-label"><?php echo display('Remarks/Conditions') ?></label>
               <div class="col-sm-8">
               <textarea rows="4" cols="50" id="remarks" name="remark" style="border: 2px solid #d7d4d6;"  class=" form-control"    ><?php   if(!empty($invoice_detail[0]['remark'])){echo trim($invoice_detail[0]['remark']);} ?></textarea>                                      
               </div>
               </div>
               <div class="table-responsive">
               <table class='table' style="display:none;">
               <tr>
               <th colspan='7'>
               </th>
               </tr>    
               </table>
               </div>
               <div id='customer-data' style='color:red;'></div>
               </form>
            </div>
            <input type="hidden" id="hdn"/>
            <input type="hidden" id="gtotal_dup"/>
            <div class="modal fade in" id="landing_modal" role="dialog">
               <div class="modal-dialog" style="padding-right: 1200px;">
                  <!-- Modal content-->
                  <div class="modal-content" style="width: 1500px;margin-top: 190px;text-align:center;">
                     <div class="btnclr modal-header" style="color:white;font-weight:bold;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" style="font-weight:bold;font-size:18px;"><?php echo "Additional Cost"; ?></h4>
                     </div>
                     <div class="modal-body">
                      <form id="land_form" method="post">
                         <input type="hidden" id="service_invoice" value="<?php echo !empty($invoice_details) ? $invoice_details[0]['commercial_invoice_number'] : ''; ?>" name="service_invoice"/>
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
   <input type ="hidden"  id="admin_company_id" value="<?php echo $_GET['id'];  ?>" name="admin_company_id" />
    <table class="serviceprovider table table-bordered" id="service_1">
        <thead>
            <tr style="text-align:center;">
                <th>Service Provider</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Rate</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="service_pro">
            <?php 
            $j = 0;
            // Determine whether we have additional costs or not
            $costs = !empty($additional_cost) ? $additional_cost : [
                ['service_provider' => '', 'Description' => '', 'Quantity' => '', 'Rate' => '', 'Total' => '']
            ];
            foreach ($costs as $ac_cost): ?>
                <tr>
                    <td>
                        <input list="magic_pro" id="service_provider_<?php echo $j; ?>" class="form-control sp" name="s_p[]" value="<?php echo $ac_cost['service_provider']; ?>" onchange="this.blur();"/>
                        <datalist id="magic_pro">
                            <option value="<?php echo $ac_cost['service_provider']; ?>"><?php echo $ac_cost['service_provider']; ?></option>
                            <?php foreach ($servic_provider as $tx): ?>
                                <option value="<?php echo $tx['service_provider_name']; ?>"><?php echo $tx['service_provider_name']; ?></option>
                            <?php endforeach; ?>
                        </datalist>
                    </td>
                    <td><input type="text" id="sp_description_<?php echo $j; ?>" value="<?php echo $ac_cost['Description']; ?>" class="sp_description form-control" name="sp_description[]"/></td>
                    <td><input type="text" id="sp_qty_<?php echo $j; ?>" value="<?php echo $ac_cost['Quantity']; ?>" class="sp_qty form-control" name="sp_qty[]"/></td>
                    <td><input type="text" id="sp_rate_<?php echo $j; ?>" value="<?php echo $ac_cost['Rate']; ?>" class="sp_rate form-control" name="sp_rate[]"/></td>
                    <td><input readonly type="text" id="sp_total_<?php echo $j; ?>" value="<?php echo $ac_cost['Total']; ?>" readonly class="form-control sp_total" name="sp_total[]"/></td>
                    <td>
                        <button class='delete_provider btn btn-danger' type='button'><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            <?php 
                $j++;
            endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align:right;">Total:</td>
                <td colspan="2"><input readonly type="text" class="form-control" value="<?php echo $invoice_detail[0]['lc_cost_total']; ?>" id="landing_amount"/></td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td colspan="2" style='text-align:right;'><input type="submit" id="land_amt" class="btn btn-primary" value="Apply to the Invoice"/></td>
                   <td colspan="2">  <button type="button" class="btn btnclr" data-dismiss="modal"><?php echo display('Close'); ?></button></td>
            </tr>
        </tfoot>
    </table>
</form>
                     </div>
                     <div class="modal-footer">
                     </div>
                  </div>
               </div>
            </div>
            <script>
   // Function for Calculation for Sale
function calculateSum(context, selector) {
    var sum = 0;
    $(context).find(selector).each(function() {
        sum += parseFloat($(this).val()) || 0;
    });
    return sum;
}
// To calculate the values for the fields in Table footer
function updateTableTotals(tableId) {
 var tableIdentifier = tableId.split('_').pop();
    var sumNet = calculateSum('#' + tableId, '.net_sq_ft');
    $('#overall_net_' + tableIdentifier).val(sumNet.toFixed(2));
 var sumTotalPrice = calculateSum('#' + tableId, '.total_price');
    $('#Total_' + tableIdentifier).val(sumTotalPrice.toFixed(2));
 var sumGross = calculateSum('#' + tableId, '.gross_sq_ft');
    $('#overall_gross_' + tableIdentifier).val(sumGross.toFixed(2));
 var totalNetSalesPrice = calculateSum('#' + tableId, '.sales_amt_sq_ft');
    $('#salespricepersqft_' + tableIdentifier).val(totalNetSalesPrice.toFixed(2));
    var totalNetSalesSlabPrice = calculateSum('#' + tableId, '.sales_slab_amt');
    $('#salesslabprice_' + tableIdentifier).val(totalNetSalesSlabPrice.toFixed(2));
        var totalNetCost = calculateSum('#' + tableId, '.cost_sq_ft');
    $('#costpersqft_' + tableIdentifier).val(totalNetCost.toFixed(2));
        var totalNetCostSlabPrice = calculateSum('#' + tableId, '.cost_sq_slab');
    $('#costperslab_' + tableIdentifier).val(totalNetCostSlabPrice.toFixed(2));
   var totalWeightvalue = calculateSum('#' + tableId, '.weight');
    $('#overall_weight_' + tableIdentifier).val(totalWeightvalue.toFixed(2));
}
// To calculate the overall total
function updateOverallTotals(includeGross = false) {
    var totalNet = calculateSum('.table', '.net_sq_ft');
    $('#total_net').val(totalNet.toFixed(2)).trigger('change');
    var overallSum = calculateSum('.table', '.total_price');
    $('#Over_all_Total').val(overallSum.toFixed(2)).trigger('change');
 var totalWeight = calculateSum('.table', '.weight');
    $('#total_weight').val(totalWeight.toFixed(2)).trigger('change');
    if (includeGross) {
        var totalGross = calculateSum('.table', '.gross_sq_ft');
        $('#total_gross').val(totalGross.toFixed(2)).trigger('change');
    }
        if($('#landing_amount').val()){
      $('#additional_cost').val(parseFloat($('#landing_amount').val()));
   var gtotal = parseFloat($('#gtotal').val()) || 0; 
var additional_cost = parseFloat($('#additional_cost').val()) || 0; 
var total_incl_additionalcost = gtotal + additional_cost;
$('#gtotal').val(total_incl_additionalcost.toFixed(2));
 var amt_paid=parseFloat($('#amount_paid').val()) || 0; 
        $('#balance').val(total_incl_additionalcost-amt_paid.toFixed(2));
      }
   if($('#product_tax').val()) {
 var overall_total = parseFloat($('#Over_all_Total').val()) || 0;
        var tax = parseFloat($('#product_tax').val()) || 0;
var additional_cost = parseFloat($('#additional_cost').val()) || 0; 
        var tax_amount = (overall_total * tax) / 100;
        $('#tax_details').val(tax_amount.toFixed(2) + '(' + tax.toFixed(2) + '%)');
 var gtotal = overall_total + tax_amount;
gtotal = gtotal + additional_cost;
        $('#gtotal').val(gtotal.toFixed(2));
         var amt_paid=parseFloat($('#amount_paid').val()) || 0; 
        $('#balance').val(gtotal-amt_paid.toFixed(2));
 var custo_amt = parseFloat($('.custocurrency_rate').val()) || 1;
        var customer_prefered_currency = gtotal * custo_amt;
        $('#customer_gtotal').val(customer_prefered_currency.toFixed(2));
    }
     var lc_cost=0;
               $('.table').each(function() {
   $(this).find('.l_cost').each(function() {
       var precio = $(this).val();
       if (!isNaN(precio) && precio.length !== 0) {
         lc_cost += parseFloat(precio);
       }
     });
   $(this).closest('table').find('.landingpersqft').val(lc_cost).trigger('change');
               });
   var  lc_sqft=0;
                $('.table').each(function() {
   $(this).find('.l_cost_slab').each(function() {
       var precio = $(this).val();
       if (!isNaN(precio) && precio.length !== 0) {
         lc_sqft += parseFloat(precio);
       }
     });
   $(this).closest('table').find('.landingperslab').val(lc_sqft).trigger('change');
               });
}
function updateNetCalculations() {
      var $row = $(this).closest('tr');
   var netWidthId = $(this).attr('id');
    const indexLastDot = netWidthId.lastIndexOf('_');
    var rowId = netWidthId.slice(indexLastDot + 1);
 var netWidthId = 'net_width_' + rowId;
    var netHeightId = 'net_height_' + rowId;
    var net_sq_ft = 'net_sq_ft_' + rowId;
    var salesAmtSqFtId = 'sales_amt_sq_ft_' + rowId;
 var netWidth = parseFloat($row.find('#' + netWidthId).val()) || 0;
    var netHeight = parseFloat($row.find('#' + netHeightId).val()) || 0;
    var netSqFt = (netWidth * netHeight) / 144;
 $row.find('#' + net_sq_ft).val(netSqFt.toFixed(2));
  var salesAmtSqFt = parseFloat($('#' + salesAmtSqFtId).val()) || 0;
        var salesSlabAmt = salesAmtSqFt * netSqFt;
        $('#sales_slab_amt_' + rowId).val(salesSlabAmt.toFixed(2));
        $('#total_amt_' + rowId).val(salesSlabAmt.toFixed(2));
         var tableId = $row.closest('table').attr('id');
    updateTableTotals(tableId);
  updateOverallTotals(true);
}
// Gross Calculation
function updateGrossCalculations() {
    var $row = $(this).closest('tr');
   var grossWidthId = $(this).attr('id');
    const indexLastDot = grossWidthId.lastIndexOf('_');
    var rowId = grossWidthId.slice(indexLastDot + 1);
 var grossWidthId = 'gross_width_' + rowId;
    var grossHeightId = 'gross_height_' + rowId;
    var grossSqFtId = 'gross_sq_ft_' + rowId;
 var grossWidth = parseFloat($row.find('#' + grossWidthId).val()) || 0;
    var grossHeight = parseFloat($row.find('#' + grossHeightId).val()) || 0;
    var grossSqFt = (grossWidth * grossHeight) / 144;
 $row.find('#' + grossSqFtId).val(grossSqFt.toFixed(2));
 var tableId = $row.closest('table').attr('id');
    updateTableTotals(tableId);
  updateOverallTotals(true);
}
$(document).on('change input keyup', '.sales_amt_sq_ft', function() {
    var $row = $(this).closest('tr');
    var id_num = $(this).attr('id').split('_').pop();
    var salesAmtSqFt = parseFloat($('#sales_amt_sq_ft_' + id_num).val()) || 0;
    var netSqFt = parseFloat($('#net_sq_ft_' + id_num).val()) || 0;
var salesSlabAmt = salesAmtSqFt * netSqFt;
    $('#sales_slab_amt_' + id_num).val(salesSlabAmt.toFixed(2));
    $row.find('.total_price').val(salesSlabAmt.toFixed(2));
  updateTableTotals($row.closest('table').attr('id'));
  updateOverallTotals(true);
});
$(document).on('change input keyup', '.sales_slab_amt', function() {
    var $row = $(this).closest('tr');
    var id_num = $(this).attr('id').split('_').pop();
    var salesSlabAmt = parseFloat($('#sales_slab_amt_' + id_num).val()) || 0;
    var netSqFt = parseFloat($('#net_sq_ft_' + id_num).val()) || 0;
 var salesAmtSqFt = netSqFt ? salesSlabAmt / netSqFt : 0;
    $('#sales_amt_sq_ft_' + id_num).val(salesAmtSqFt.toFixed(2));
    $('#total_amt_' + id_num).val(salesSlabAmt.toFixed(2));
  updateTableTotals($row.closest('table').attr('id'));
  updateOverallTotals(true);
});
$(document).on('keyup', '.net_height, .net_width', updateNetCalculations);
$(document).on('input', '.gross_height, .gross_width', updateGrossCalculations);
               $(document).ready(function(){
     $(".normalinvoice").each(function(i,v){
       if($(this).find("tbody").html().trim().length === 0){
           $(this).hide()
       }
    })
               $(".sidebar-mini").addClass('sidebar-collapse') ;
               });
                    $('.normalinvoice tbody tr').each(function() {
        var tableId = $(this).closest('table').attr('id');
    updateTableTotals(tableId);
  updateOverallTotals(true);
                    });
               $("#insert_invoice").validate({
        rules: {
            customer_name: "trimRequired",
            payment_due_date: "required",
            billing_address: "required",
            terms: "required",
            commercial_invoice_number: "required"
        },
        messages: {
            customer_name: "Company Name is required",
            payment_due_date: "Payment Due Date is required",
           billing_address : "Billing Address is required" ,
           terms : "Payment Terms is required",
            commercial_invoice_number : "Invoice Number is required"
        },
        errorPlacement: function(error, element) {
            if (element.hasClass("select2-hidden-accessible")) {
                error.insertAfter(element.next('span.select2')); 
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            var formData = new FormData(form);
            formData.append(csrfName, csrfHash);
                $.ajax({
                    type:"POST",
                    dataType:"json",
                    url:"<?php echo base_url(); ?>Cinvoice/manual_sales_insert?id=<?php echo $_GET['id']; ?>",
                    data:formData,
                    contentType: false, 
                    processData: false, 
                    success:function (response) {
                      if (response.status === 'success') {
                     
            $('.error_display').html(succalert + response.msg + alert2);
          
            $('#inv_id').val(response.invoice_id);
            $('#inv_no').val(response.invoice_no);
            window.setTimeout(function() {
                window.location = "<?php echo base_url(); ?>Cinvoice/manage_invoice?id=<?php echo $_GET['id']; ?>";
            }, 2500);
        } else {
           $('.error_display').html(failalert + response.msg + alert2);
         }
                    }
                });
            event.preventDefault();
        }
    });
       $(document).on('click', '.delete', function(){
 var rowCount = $(this).closest('tbody').find('tr').length;
   var $row = $(this).closest('tr');
   if(rowCount>1){
   $(this).closest('tr').remove();
   }
updateTableTotals($row.closest('table').attr('id'));
updateOverallTotals(true);
   });
            </script>
         </div>
      </div>
</div>
</section>
</div>

<div class="modal fade" id="payment_history_modal" role="dialog">
   <div class="modal-dialog" style="margin-right: 1100px;">

      <div class="modal-content" style="margin-left: 200px;width: 1500px;justify-content: center;overflow-y: auto; height: 100vh;">
         <div class="modal-header btnclr" >
            <button type="button" id="history_close" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?php echo display('PAYMENT HISTORY') ?></h4>
         </div>
         <div class="modal-body1">
            <form  id='bulk_payment_form' action="<?php echo base_url(); ?>Cinvoice/bulk_payment" method="post">
                <div id="payment_error"></div>
               <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                <input type="hidden" value="<?php  echo $invoice_detail[0]['customer_id']; ?>" name="customer_id"/>
               <div id="salle_list"></div>
            </form>
         </div>
         <div class="modal-footer">
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="product_model_info" tabindex="-1" role="dialog" aria-labelledby="productModelInfoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 90vw; max-height: 90vh; margin: 0;">
        <div class="modal-content" style="margin-left: 100px;height: 90vh; width: 90vw; overflow: hidden;">
            <div class="modal-header btnclr" style="border-bottom: 1px solid #dee2e6;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #6f2937; background: #cdc222;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="productModelInfoLabel" style="margin: 0;"><?php echo ('PRODUCT') ?></h4>
            </div>
            <div class="modal-body" style="padding: 20px; overflow-y: auto; height: calc(90vh - 120px);">
                <div id="product_data_list"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
   $( document ).ready(function() {
     $('.hiden').css("display","none");
                       var data = {
          value: $('#customer_name').val()
       };
      data[csrfName] = csrfHash;
      $.ajax({
          type:'POST',
          data: data,
          dataType:"json",
          url:'<?php echo base_url();?>Cinvoice/getcustomer_byID',
          success: function(result, statut) {
              if(result.csrfName){
                 csrfName = result.csrfName;
                 csrfHash = result.csrfHash;
              }
           $(".cus").html(result[0]['currency_type']);
           $("label[for='custocurrency']").html(result[0]['currency_type']);
         $.getJSON('https://open.er-api.com/v6/latest/<?php echo $curn_info_default; ?>', 
   function(data) {
     var custo_currency=result[0]['currency_type'];
       var x=data['rates'][custo_currency];
     var Rate =parseFloat(x).toFixed(2);
      $('.hiden').show();
      $(".custocurrency_rate").val(Rate);
          }
   )}
       });
   });
    function payment_update(){
    $('.hidden_button').hide();
       var dataString = {
           dataString : $("#histroy").serialize()
      };
      dataString[csrfName] = csrfHash;
       $.ajax({
           type:"POST",
           dataType:"json",
           url:"<?php echo base_url(); ?>Cinvoice/payment_history",
           data:$("#histroy").serialize(),
           success:function (data) {
          debugger;
            var gt=$('#customer_gtotal').val();
            var amtpd=parseFloat(data.amt_paid);
            if (isNaN(amtpd) || amtpd === '') {
    amtpd = 0.00;
}
            console.log(data);
            var bal= gt - amtpd;
    if(amtpd){
    $('#amount_paid').val(amtpd.toFixed(2));
    }else{
       $('#amount_paid').val("0.00"); 
    }
    $('#balance').val(bal.toFixed(2));
    $('#amount_to_pay').val(bal.toFixed(2));
     }
       });
       event.preventDefault();
         }
 $(document).ready(function(){
        payment_update();
    });
       $('#terms').change(function(){
          $('#payment_due_date').val('');
     var sd = $(this).val().replace(/[^0-9]/gi, ''); 
   var number = parseFloat(sd, 10);
          var data = {
              sales_invoice_date : $('#date').val(),
              days :number,   
              pterms : $('#payment_terms').val()
          };
          data[csrfName] = csrfHash;
          $.ajax({
              type:'POST',
              data: data, 
             dataType:"json",
              url:'<?php echo base_url();?>Cinvoice/getdate',
              success: function(result, statut) {
                 $('#payment_due_date').val(result.toFixed(2));
             }
          });
      });
        function submit_redirect(){
          window.btn_clicked = true;      //set btn_clicked to true
      var input_hdn="Your Invoice No :"+$('#invoice_hdn').val()+" has been Updated Successfully";
      console.log(input_hdn);
      $('#myModal3').modal('hide');
      $("#bodyModal1").html(input_hdn);
      $('#myModal1').modal('show');
      window.setTimeout(function(){
           window.location = "<?php  echo base_url(); ?>Cinvoice/manage_invoice?id=<?php echo $_GET['id']; ?>";
         }, 2000);
        }
   $('#download').on('click', function (e) {
    var popout = window.open("<?php  echo base_url(); ?>Cinvoice/invoice_inserted_data/"+$('#invoice_hdn1').val());
   });  
   $('.final_submit').on('click', function (e) {
    var input_hdn='Your Invoice No : "'+$('#invoice_hdn').val()+" has been Updated Successfully";
 $('.error_display').html(succalert+input_hdn+'</div>');

   window.setTimeout(function(){
    window.location = "<?php  echo base_url(); ?>Cinvoice/manage_invoice?id=<?php echo $_GET['id']; ?>";
     }, 2000);
   });
      function configureDropDownLists(ddl1,ddl2) {
   var assets = ['CASH Operating Account', 'CASH Debitors', 'CASH Petty Cash'];
   var receivables = ['A/REC Trade', 'A/REC Trade Notes Receivable', 'A/REC Installment Receivables','A/REC Retainage Withheld','A/REC Allowance for Uncollectible Accounts'];
   var inventories = ['INV – Reserved', 'INV – Work-in-Progress', 'INV – Finished Goods','INV – Reserved','INV – Unbilled Cost & Fees','INV – Reserve for Obsolescence'];
   var prepaid_expense = ['PREPAID – Insurance', 'PREPAID – Real Estate Taxes', 'PREPAID – Repairs & Maintenance','PREPAID – Rent','PREPAID – Deposits'];
   var property_plant = ['PPE – Buildings', 'PPE – Machinery & Equipment', 'PPE – Vehicles','PPE – Computer Equipment','PPE – Furniture & Fixtures','PPE – Leasehold Improvements'];
   var acc_dep = ['ACCUM DEPR Buildings', 'ACCUM DEPR Machinery & Equipment', 'ACCUM DEPR Vehicles','ACCUM DEPR Computer Equipment','ACCUM DEPR Furniture & Fixtures','ACCUM DEPR Leasehold Improvements'];
   var noncurrenctreceivables = ['NCA – Notes Receivable', 'NCA – Installment Receivables', 'NCA – Retainage Withheld'];
   var intercompany_receivables = ['Organization Costs', 'Patents & Licenses', 'Intangible Assets – Capitalized Software Costs'];
   var liabilities = ['A/P Trade', 'A/P Accrued Accounts Payable', 'A/P Retainage Withheld','Current Maturities of Long-Term Debt','Bank Notes Payable','Construction Loans Payable'];
   var accrued_compensation = ['Accrued – Payroll', 'Accrued – Commissions', 'Accrued – FICA','Accrued – Unemployment Taxes','Accrued – Workmen’s Comp'];
   var other_accrued_expenses = ['Accrued – Rent', 'Accrued – Interest', 'Accrued – Property Taxes', 'Accrued – Warranty Expense'];
   var accrued_taxes= ['Accrued – Federal Income Taxes', 'Accrued – State Income Taxes', 'Accrued – Franchise Taxes','Deferred – FIT Current','Deferred – State Income Taxes'];
   var deferred_taxes= ['D/T – FIT – NON CURRENT', 'D/T – SIT – NON CURRENT'];
   var long_term_debt=['LTD – Notes Payable','LTD – Mortgages Payable','LTD – Installment Notes Payable'];
   var intercompany_payables=['Common Stock','Preferred Stock','Paid in Capital','Partners Capital','Member Contributions','Retained Earnings'];
   var revenue=['REVENUE – PRODUCT 1','REVENUE – PRODUCT 2','REVENUE – PRODUCT 3','REVENUE – PRODUCT 4','Interest Income','Other Income','Finance Charge Income','Sales Returns and Allowances','Sales Discounts'];
   var cost_goods= ['COGS – PRODUCT 1', 'COGS – PRODUCT 2','COGS – PRODUCT 3','COGS – PRODUCT 4','Freight','Inventory Adjustments','Purchase Returns and Allowances','Reserved'];
   var operating_expenses=['Advertising Expense','Amortization Expense','Auto Expense','Bad Debt Expense','Bad Debt Expense','Bank Charges','Cash Over and Short','Commission Expense','Depreciation Expense','Employee Benefit Program','Freight Expense','Gifts Expense','Insurance – General','Interest Expense','Professional Fees','License Expense','Maintenance Expense','Meals and Entertainment','Office Expense','Payroll Taxes','Printing','Postage','Rent','Repairs Expense','Salaries Expense','Supplies Expense','Taxes – FIT Expense','Utilities Expense','Gain/Loss on Sale of Assets'];
   switch (ddl1.value) {
   case 'ASSETS':
   ddl2.options.length = 0;
   for (i = 0; i < assets.length; i++) {
   createOption(ddl2, assets[i], assets[i]);
   }
   break;
   case 'RECEIVABLES':
   ddl2.options.length = 0;
   for (i = 0; i < receivables.length; i++) {
   createOption(ddl2, receivables[i], receivables[i]);
   }
   break;
   case 'INVENTORIES':
   ddl2.options.length = 0;
   for (i = 0; i < inventories.length; i++) {
   createOption(ddl2, inventories[i], inventories[i]);
   }
   break;
   case 'PREPAID EXPENSES & OTHER CURRENT ASSETS':
   ddl2.options.length = 0;
   for (i = 0; i < prepaid_expense.length; i++) {
   createOption(ddl2, prepaid_expense[i], prepaid_expense[i]);
   }
   break;
   case 'PROPERTY PLANT & EQUIPMENT':
   ddl2.options.length = 0;
   for (i = 0; i < property_plant.length; i++) {
   createOption(ddl2, property_plant[i], property_plant[i]);
   }
   break;
   case 'ACCUMULATED DEPRECIATION & AMORTIZATION':
   ddl2.options.length = 0;
   for (i = 0; i < acc_dep.length; i++) {
   createOption(ddl2, acc_dep[i], acc_dep[i]);
   }
   break;
   case 'NON – CURRENT RECEIVABLES':
   ddl2.options.length = 0;
   for (i = 0; i < noncurrenctreceivables.length; i++) {
   createOption(ddl2, noncurrenctreceivables[i], noncurrenctreceivables[i]);
   }
   break;
   case 'INTERCOMPANY RECEIVABLES & OTHER NON-CURRENT ASSETS':
   ddl2.options.length = 0;
   for (i = 0; i < intercompany_receivables.length; i++) {
   createOption(ddl2, intercompany_receivables[i], intercompany_receivables[i]);
   }
   break;
   case 'LIABILITIES & PAYABLES':
   ddl2.options.length = 0;
   for (i = 0; i < liabilities.length; i++) {
   createOption(ddl2, liabilities[i], liabilities[i]);
   }
   break;
   case 'ACCRUED COMPENSATION & RELATED ITEMS':
   ddl2.options.length = 0;
   for (i = 0; i < accrued_compensation.length; i++) {
   createOption(ddl2, accrued_compensation[i], accrued_compensation[i]);
   }
   break;
   case 'OTHER ACCRUED EXPENSES':
   ddl2.options.length = 0;
   for (i = 0; i < other_accrued_expenses.length; i++) {
   createOption(ddl2, other_accrued_expenses[i], other_accrued_expenses[i]);
   }
   break;
   case 'ACCRUED TAXES':
   ddl2.options.length = 0;
   for (i = 0; i < accrued_taxes.length; i++) {
   createOption(ddl2, accrued_taxes[i], accrued_taxes[i]);
   }
   break;
   case 'DEFERRED TAXES':
   ddl2.options.length = 0;
   for (i = 0; i < deferred_taxes.length; i++) {
   createOption(ddl2, deferred_taxes[i], deferred_taxes[i]);
   }
   break;
   case 'LONG-TERM DEBT':
   ddl2.options.length = 0;
   for (i = 0; i < long_term_debt.length; i++) {
   createOption(ddl2, long_term_debt[i], long_term_debt[i]);
   }
   break;
   case 'INTERCOMPANY PAYABLES & OTHER NON CURRENT LIABILITIES & OWNERS EQUITIES':
   ddl2.options.length = 0;
   for (i = 0; i < intercompany_payables.length; i++) {
   createOption(ddl2, intercompany_payables[i], intercompany_payables[i]);
   }
   break;
   case 'REVENUE':
   ddl2.options.length = 0;
   for (i = 0; i < revenue.length; i++) {
   createOption(ddl2, revenue[i], revenue[i]);
   }
   break;
   case 'COST OF GOODS SOLD':
   ddl2.options.length = 0;
   for (i = 0; i < cost_goods.length; i++) {
   createOption(ddl2, cost_goods[i], cost_goods[i]);
   }
   break;
   case 'OPERATING EXPENSES':
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
      $('#add_pay_type').submit(function(e){
       e.preventDefault();
         var data = {
           new_payment_type : $('#new_payment_type').val()
         };
         data[csrfName] = csrfHash;
         $.ajax({
             type:'POST',
             data: data, 
            dataType:"json",
             url:'<?php echo base_url();?>Cinvoice/add_payment_type',
             success: function(data1, statut) {
          var $select = $('select#paytype');
               $select.empty();
               console.log(data);
                 for(var i = 0; i < data1.length; i++) {
           var option = $('<option/>').attr('value', data1[i].payment_type).text(data1[i].payment_type);
           $select.append(option); // append new options
       }
         $('#new_payment_type').val('');
         $("#bodyModal1").html("Payment Added Successfully");
         $('#payment_type').modal('hide');
         $('#paytype').show();
          $('#myModal1').modal('show');
         window.setTimeout(function(){
           $('#payment_type').modal('hide');
          $('#myModal1').modal('hide');
       }, 2000);
        }
         });
     });
 $(document).ready(function() {
    $(document).on('click', '#pay_now', function(event) {
        event.preventDefault(); 
        var formData = $('#bulk_payment_form').serialize();
        formData += '&' + csrfName + '=' + csrfHash; 
        $.ajax({
            type: 'POST',
            data: formData, 
            dataType: 'text',
            url: $('#bulk_payment_form').attr('action'), 
            success: function(result) {
                
                  $('#payment_error').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + "Payment Completed Successfully" + '</div>');
                window.setTimeout(function() {
                  $('#payment_history_modal').modal('hide');
                    location.reload(); 
                }, 2000);
      
             }
        });
    });
});
   $(document).on('click', '#edit_payment', function (event) {
   var csrf_token = {
    <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
   };
    var tableData = [];
    $('#toggle_table tbody tr').each(function () {
        var rowData = {
            date: $(this).find('td:eq(0)').text(),
            referenceNo: $(this).find('td:eq(1)').text(),
            bankName: $(this).find('td:eq(2)').text(),
            amountPaid: $(this).find('td:eq(3)').text(),
             balanceamount: $(this).find('td:eq(4)').text(),
              detail: $(this).find('td:eq(5)').text(),
             payment : $('#payment_id_this_invoice').val(),
             gtotal : $('#customer_gtotal').val(),
             inv_no :$('#unq_inv').val()
        };
        tableData.push(rowData);
    });
    var postData = {
                          tableData: tableData
                     };
                     postData[csrfName] = csrfHash;
  
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url(); ?>Cinvoice/payment_edit",
        data: postData,
        success: function (response) {
        payment_update();
         $('#payment_error').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + 'Updated Successfully' + '</div>');
        },
        error: function (error) {
           $('#payment_error').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + 'Failed to Updated Successfully' + '</div>');
        }
    });
  
    event.preventDefault();
   });
   $('#payment_history').click(function (event) {
        $('#current_in_id').val($('#invoice').val());
    var dataString = {
        dataString: $("#histroy").serialize()
    };
    dataString[csrfName] = csrfHash;
    $.ajax({
        type: "POST",
        dataType: "json",
       url:"<?php echo base_url(); ?>Cinvoice/payment_history",
        data: $("#histroy").serialize(),
        success: function (data) { 
   var basedOnCustomer = data.based_on_customer;
   var overallGTotal = parseFloat(data.overall[0].overall_gtotal);
   var overall_due = parseFloat(data.overall[0].overall_due);
   var overall_paid = parseFloat(data.overall[0].overall_paid);
   console.log("OVER : "+overallGTotal);
   var gt = $('#customer_gtotal').val();
            var amtpd = data.amt_paid;
            var bal = $('#customer_gtotal').val() - data.amt_paid;
            var total = "<table id='table2' class='newtable table table-striped table-bordered'><tbody><tr><td rowspan='2' style='vertical-align: middle;text-align-last: center;'><b>Grand Total :  <?php  echo $currency;  ?>"+$('#customer_gtotal').val()+"<b></td>                       <td class='td' style='text-align:end;border-right: hidden;'><b>Total Amount Paid :<b></td>       <td style='text-align:start;'><?php  echo $currency;  ?><span class='amt_paid_update'><input type='text' id='tl_amt_pd' value='"+data.amt_paid+"' name='tl_amt_pd'/></span></td>            <td><input type='hidden' value='"+$('#customer_gtotal').val()+"' name='t_unique'/><span style='font-weight:bold;'>INVOICE NO</span> :<input type='hidden' id='unq_inv' value='"+$('#invoice').val()+"' name='unq_inv'/>"+$('#invoice').val()+"</td>     <td rowspan='2' style='vertical-align: middle;text-align-last: center;'><b>Advance :   <input type='text' name='advanceamount' id='advanceamount' readonly ></td>                                         </tr><tr><td class='td' style='text-align:end;'><b>Balance :<input type='text' id='my_bal_1' value='"+bal+"' name='my_bal_1'/><b></td><td class='due_pay' style='display:none;' id='balance-cell' data-currency='<?php  echo $currency;  ?>'>"+bal +"</td><td  data-currency='<?php echo $currency; ?>'><span style='font-weight:bold;'>Amount to Pay : </span><input type='text' id='amount_pay_unique' class='amount_pay' style='text-align:center;' readonly  name='amount_pay_1'/></td><td style='display:none'><input type='text'  value='<?php if($all_invoice[0]['payment_id']){ echo $all_invoice[0]['payment_id']; }else{ echo $payment_id_new;}?>' name='payment_id' class='payment_id_val' id='payment_id'/></td><td style='display:none' class='' data-currency='<?php echo $currency; ?>'><input type='text' name='updated_bal_uniq' class='balance-col'/></td><td> <input type='text' id='total-amount' placeholder='Enter Amount To Distribute' ></td> </tr></tbody></table>"
               var table_header1 = "<div></div>  <thead><tr><td ><input type='hidden'  value='<?php echo $all_invoice[0]['customer_id'];  ?>' name='customer_id' /></tr></thead><tbody>";
             var table_header = "<div class='toggle-button' onclick='toggleTable()'>Payment History &#9660;</div><table id='toggle_table' class='table table-striped table-bordered'><thead style='FONT-WEIGHT:BOLD;'><tr><td style='display:none;'><input type='text'  value='<?php if($invoice_detail[0]['payment_id']){ echo $invoice_detail[0]['payment_id']; }else{ echo $payment_id_new;}?>' name='payment_id_this_invoice' class='payment_id_val' id='payment_id_this_invoice'/></td><td>Payment Date</td><td>Reference.NO</td><td>Bank Name</td><td>Amount Paid</td><td>Balance</td><td>Details</td> <td>Payment Id</td>  </tr></thead><tbody>";
           var table_footer = "</tbody><tfoot><tr><td style='text-align: center;vertical-align: middle;' colspan='7' ><input type='button' class='btn' style='text-align:center;color:white;background-color:#38469f;font-weight:bold';  value='Update' id='edit_payment'/></td></tr></tfoot></table>";
             var html = "";
             var count = 1;
            data.payment_get.forEach(function (element) {
                html += "<tr>" +
    "<td contenteditable='true'>" + element.payment_date + "</td>" +
    "<td contenteditable='true'>" + element.reference_no + "</td>" +
    "<td contenteditable='true'>" + element.bank_name + "</td>" +
    "<td class='editable-amount-paid' contenteditable='true' data-currency='<?php echo $currency; ?>'>" +  "<span class='palist'>" + element.amt_paid + "</span>" +
    "<input type='hidden' class='editable-input-4' name='editable-input-4' /></td>" +
    "<td class='balance-cell' contenteditable='false'>" + "<span class='balist'>" +  element.balance +"</span>" +
    "<input type='text' class='edit_balance' name='edit_balance' /></td>" +
    "<td contenteditable='true'>" + element.details + "</td>" +
    "<td style='display:none;'><input type='text' class='payment_id_val' name='payment_id' id='payment_id'/></td>" +
    "<td><input type='text' value='<?php if($all_invoice[0]['payment_id']){ echo $all_invoice[0]['payment_id']; }else{ echo $payment_id_new;}?>' name='pay_id' class='pay_id' id='pay_id'/></td>" +
    +  "</tr>";
                  count++;
            });
                var all = total + table_header + html + table_footer +table_header1;
             var total1 = "<input type='hidden' name='<?php echo $this->security->get_csrf_token_name();?>' value='<?php echo $this->security->get_csrf_hash();?>'><table id='table1'  class='table table-striped table-bordered'><tr><td colspan='3' style='border-top: hidden!important;background-color: white;text-align:center;font-weight:bold;font-size:18px;'>LIST OF DUE INVOICES</td></tr><tr><td rowspan='2' style='vertical-align: middle;text-align-last: center;'><b>Grand Total :  <?php  echo $currency;  ?>"+overallGTotal.toFixed(2)+"<b></td><td class='td' style='text-align:center;border-right: hidden;'><b>Total Amount Paid :<b></td><td><?php  echo $currency;  ?>"+overall_paid.toFixed(2)+"</td></tr></tr><td class='td' style='border-right: hidden;'><b>Balance :<b></td><td style='text-align:start;' id='balance-cell'  class='bcm'   data-currency='<?php  echo $currency;  ?>'>"+parseFloat(overall_due.toFixed(2)) +"</td></tr></table>"
               var table_header1='';
         var table_footer1='';
            if (basedOnCustomer && basedOnCustomer.length > 0) {
    table_header1 = "<table class='newtable-second table table-striped table-bordered'><thead style='FONT-WEIGHT:BOLD;'><tr><td><div id='distribute-container'> </div></td><td style='width:60px;'>Invoice No</td><td style='width:100px;'>Total Amount</td><td style='width:200px;'>Amount Paid</td><td style='width:200px;'>Balance</td><td style='width:200px;'>Amount to Pay</td><td class='balance-column' style='width:200px;'>Updated Balance</td></tr></thead><tbody>";
    table_footer1 = "</tbody><tfoot><tr><td colspan='5'></td><td class='t_amt_pay'></td><td  style='display:none;' class='balance-col t_bal_pay'></td></tr></tfoot></table>";
   } else {
   
    table_header1 = "<div style='font-size:larger;text-align:center;'><b>No Dues</b>  &#x1F60A;</div>";
   }
             var html1 = "";
            var count1 = 1;
            for (var invoiceId in basedOnCustomer) {
    if (basedOnCustomer.hasOwnProperty(invoiceId)) {
        var element = basedOnCustomer[invoiceId];
             var pay_id=element.payment_id;
       console.log("PAY :"+pay_id);
      var random10DigitNumber='';
      if(pay_id=='' || pay_id =='0'){
   random10DigitNumber = generateRandom10DigitNumber();
      }else{
         random10DigitNumber=pay_id;
      }
            html1 += "<tr><td style='display:none;'><input type='hidden' value='"+random10DigitNumber+"' name='payment_id[]'/></td><td> <input type='checkbox' id='<?php echo $count1; ?>' class='checkbox-distribute'></td><td><input type='text' readonly style='text-align:center;'  value='" + element.commercial_invoice_number + "' name='invoice_no[]'/></td><td><input type='text' readonly  class='g_pament' value='" + element.gtotal + "' name='total_amt[]' style='text-align:center;'/></td><td>" + element.paid_amount + "</td><td class='due_pay' data-currency='<?php echo $currency; ?>'>" + element.due_amount + "</td><td  data-currency='<?php echo $currency; ?>'><input type='text' id='amount_pay' class='amount_pay' style='text-align:center;' name='amount_pay[]'/></td><td    class='balance-column' data-currency='<?php echo $currency; ?>'><input type='text' name='updated_bal[]' readonly class='balance-col'/></td></tr>";
            count1++;
    }
   }
   all +=  total1 + table_header1 + html1 + table_footer1;
   var total2 = ""
            var table_header2 = "<div id='pay_now_table'><table class='table table-striped table-bordered'><tr><th>Date</th><th>Bank</th><th>Reference No</th><th>Payment Amount</th><th>Action</th></tr><tr><td><input type='date' name='bulk_payment_date' value='<?php echo html_escape($date); ?>'/></td><td><select name='bulk_bank' id='bank'  class='form-control bankpayment' > <option value='JPMorgan Chase'>JPMorgan Chase</option> <option value='New York City'>New York City</option> <option value='Bank of America'>Bank of America</option> <option value='Citigroup'>Citigroup</option> <option value='Wells Fargo'>Wells Fargo</option> <option value='Goldman Sachs'>Goldman Sachs</option> <option value='Morgan Stanley'>Morgan Stanley</option> <option value='U.S. Bancorp'>U.S. Bancorp</option> <option value='PNC Financial Services'>PNC Financial Services</option> <option value='Truist Financial'>Truist Financial</option> <option value='Charles Schwab Corporation'>Charles Schwab Corporation</option> <option value='TD Bank, N.A.'>TD Bank, N.A.</option> <option value='Capital One'>Capital One</option> <option value='The Bank of New York Mellon'>The Bank of New York Mellon</option> <option value='State Street Corporation'>State Street Corporation</option> <option value='American Express'>American Express</option> <option value='Citizens Financial Group'>Citizens Financial Group</option> <option value='HSBC Bank USA'>HSBC Bank USA</option> <option value='SVB Financial Group'>SVB Financial Group</option> <option value='First Republic Bank '>First Republic Bank </option> <option value='Fifth Third Bank'>Fifth Third Bank</option> <option value='BMO USA'>BMO USA</option> <option value='USAA'>USAA</option> <option value='UBS'>UBS</option> <option value='M&T Bank'>M&T Bank</option> <option value='Ally Financial'>Ally Financial</option> <option value='KeyCorp'>KeyCorp</option> <option value='Huntington Bancshares'>Huntington Bancshares</option> <option value='Barclays'>Barclays</option> <option value='Santander Bank'>Santander Bank</option> <option value='RBC Bank'>RBC Bank</option> <option value='Ameriprise'>Ameriprise</option> <option value='Regions Financial Corporation'>Regions Financial Corporation</option> <option value='Northern Trust'>Northern Trust</option> <option value='BNP Paribas'>BNP Paribas</option> <option value='Discover Financial'>Discover Financial</option> <option value='First Citizens BancShares'>First Citizens BancShares</option> <option value='Synchrony Financial'>Synchrony Financial</option> <option value='Deutsche Bank'>Deutsche Bank</option> <option value='New York Community Bank'>New York Community Bank</option> <option value='Comerica'>Comerica</option> <option value='First Horizon National Corporation'>First Horizon National Corporation</option> <option value='Raymond James Financial'>Raymond James Financial</option> <option value='Webster Bank'>Webster Bank</option> <option value='Western Alliance Bank'>Western Alliance Bank</option> <option value='Popular, Inc.'>Popular, Inc.</option> <option value='CIBC Bank USA'>CIBC Bank USA</option> <option value='East West Bank'>East West Bank</option> <option value='Synovus'>Synovus</option> <option value='Valley National Bank'>Valley National Bank</option> <option value='Credit Suisse '>Credit Suisse </option> <option value='Mizuho Financial Group'>Mizuho Financial Group</option> <option value='Wintrust Financial'>Wintrust Financial</option> <option value='Cullen/Frost Bankers, Inc.'>Cullen/Frost Bankers, Inc.</option> <option value='John Deere Capital Corporation'>John Deere Capital Corporation</option> <option value='MUFG Union Bank'>MUFG Union Bank</option> <option value='BOK Financial Corporation'>BOK Financial Corporation</option> <option value='Old National Bank'>Old National Bank</option> <option value='South State Bank'>South State Bank</option> <option value='FNB Corporation'>FNB Corporation</option> <option value='Pinnacle Financial Partners'>Pinnacle Financial Partners</option> <option value='PacWest Bancorp'>PacWest Bancorp</option> <option value='TIAA'>TIAA</option> <option value='Associated Banc-Corp'>Associated Banc-Corp</option> <option value='UMB Financial Corporation'>UMB Financial Corporation</option> <option value='Prosperity Bancshares'>Prosperity Bancshares</option> <option value='Stifel'>Stifel</option> <option value='BankUnited'>BankUnited</option> <option value='Hancock Whitney'>Hancock Whitney</option> <option value='MidFirst Bank'>MidFirst Bank</option> <option value='Sumitomo Mitsui Banking Corporation'>Sumitomo Mitsui Banking Corporation</option> <option value='Beal Bank'>Beal Bank</option> <option value='First Interstate BancSystem'>First Interstate BancSystem</option> <option value='Commerce Bancshares'>Commerce Bancshares</option> <option value='Umpqua Holdings Corporation'>Umpqua Holdings Corporation</option> <option value='United Bank (West Virginia)'>United Bank (West Virginia)</option> <option value='Texas Capital Bank'>Texas Capital Bank</option> <option value='First National of Nebraska'>First National of Nebraska</option> <option value='FirstBank Holding Co'>FirstBank Holding Co</option> <option value='Simmons Bank'>Simmons Bank</option> <option value='Fulton Financial Corporation'>Fulton Financial Corporation</option> <option value='Glacier Bancorp'>Glacier Bancorp</option> <option value='Arvest Bank'>Arvest Bank</option> <option value='BCI Financial Group'>BCI Financial Group</option> <option value='Ameris Bancorp'>Ameris Bancorp</option> <option value='First Hawaiian Bank'>First Hawaiian Bank</option> <option value='United Community Bank'>United Community Bank</option> <option value='Bank of Hawaii'>Bank of Hawaii</option> <option value='Home BancShares'>Home BancShares</option> <option value='Eastern Bank'>Eastern Bank</option> <option value='Cathay Bank'>Cathay Bank</option> <option value='Pacific Premier Bancorp'>Pacific Premier Bancorp</option> <option value='Washington Federal'>Washington Federal</option> <option value='Customers Bancorp'>Customers Bancorp</option> <option value='Atlantic Union Bank'>Atlantic Union Bank</option> <option value='Columbia Bank'>Columbia Bank</option> <option value='Heartland Financial USA'>Heartland Financial USA</option> <option value='WSFS Bank'>WSFS Bank</option> <option value='Central Bancompany'>Central Bancompany</option> <option value='Independent Bank'>Independent Bank</option> <option value='Hope Bancorp'>Hope Bancorp</option> <option value='SoFi'>SoFi</option> <?php foreach($bank_list as $b){ ?> <option value='<?=$b['bank_name']; ?>'><?=$b['bank_name']; ?></option> <?php } ?> </select></td><td><input type='text' name='bulk_pay_ref' placeholder='Ref No'/></td><td class='t_amt_pay'></td>";
            var table_footer2 = "<td><input type='submit' style='color:white;background-color: #38469f;padding:2px;font-weight:bold;' id='pay_now' value='PAY NOW'/></td></tr></tbody></table></div>";
            var html2 = "";
            var count2 = 1;
   all +=  total2 + table_header2 + html2 + table_footer2;
    all = all.replace(/NaN/g, '');
            $('#salle_list').html(all);
            $('#payment_history_modal').modal('show');
              $('#pay_now_table').hide();
              $('.balance-column').hide();
   var amountPaidCells = document.querySelectorAll('#salle_list tbody tr td:nth-child(5)'); // Assuming "Amount Paid" is the 5th column
            amountPaidCells.forEach(function (cell) {
                cell.addEventListener('input', function () {
                    updateBalances();
                });
            });
        }
    });
    event.preventDefault();
   });
   var amountPaidCells = document.querySelectorAll('#salle_list tbody td.editable-amount-paid');
   amountPaidCells.forEach(function (cell) {
    cell.addEventListener('input', function () {
        updateBalance(cell);
    });
   });
     function generateRandom10DigitNumber() {
   
    const min = Math.pow(10, 9); 
    const max = Math.pow(10, 10) - 1; 
    const randomNumber = Math.floor(Math.random() * (max - min + 1)) + min;
    return randomNumber;
}
   function toggleTable() {
   const toggleTable = document.getElementById('toggle_table');
   const toggleButton = document.querySelector('.toggle-button');
   if (toggleTable.style.display === 'none' || toggleTable.style.display === '') {
    toggleTable.style.display = 'table'; 
    toggleButton.textContent = 'Hide Table \u25B2'; 
   } else {
    toggleTable.style.display = 'none'; 
    toggleButton.textContent = 'Payment History \u25BC'; 
   }
   }
  
   $(document).ready(function () {
    $(document).on('keyup', '#total-amount', function () {
        var totalAmount = parseFloat($(this).val().trim());
        if (isNaN(totalAmount)) {
            totalAmount = 0;
        }
        var t_amont = 0;
        var rows = $('.newtable tbody tr');
        var secondTableRows = $('.newtable-second tbody tr');
        var remainingAmount = totalAmount;
       
        rows.each(function () {
            var amountPayInput = $(this).find('.amount_pay');
            var balanceCell = $(this).find('.td input');
        
            var balance = parseFloat(balanceCell.val());
   balance = isNaN(balance) ? 0 : balance;
    if (balance > 0 && remainingAmount > 0) {
                var amountToPay = Math.min(balance, remainingAmount);
                amountPayInput.val(amountToPay.toFixed(2));
                remainingAmount -= amountToPay;
                t_amont += amountToPay;
                if (amountToPay > 0) {
                    $(this).find('.checkbox-distribute').prop('checked', true);
                }
            } else if (balance <= 0 && remainingAmount > 0) {
     
        var amountToPay = Math.min(Math.abs(balance), remainingAmount);
     
        t_amont += amountToPay;
        if (amountToPay > 0) {
            $(this).find('.checkbox-distribute').prop('checked', true);
        }
    } else {
        amountPayInput.val('0.00');
    }
        });
   $(document).on('change', '.checkbox-distribute', function () {
        if (!$(this).prop('checked')) {
            $(this).closest('tr').find('.amount_pay').val('');
            var due_pay= $(this).closest('tr').find('.due_pay').val();
             $(this).closest('tr').find('.balance-column input').val('');
        }
        updateTotalAmountToPay();
    });
      
        secondTableRows.each(function () {
            var checkbox = $(this).find('.checkbox-distribute');
            var amountPayInput = $(this).find('.amount_pay');
            var balanceCell = $(this).find('.due_pay');
            var balance = parseFloat(balanceCell.text());
      
            var balance = parseFloat(balanceCell.text());
   var amountPaid = parseFloat(amountPayInput.val());
   var amountToPay1 = Math.min(balance, remainingAmount);
                var b = balance - amountToPay1.toFixed(2);
   console.log('swd' +balance+'-'+ amountPaid+'='+b);
   $(this).closest('tr').find('.balance-col').val(b.toFixed(2));
            if (balance > 0 && remainingAmount > 0) {
                var amountToPay = Math.min(balance, remainingAmount);
 
                amountPayInput.val(amountToPay.toFixed(2));
                remainingAmount -= amountToPay;
                if (amountToPay > 0) {
                    checkbox.prop('checked', true);
                }
            } else {
                amountPayInput.val('0.00');
            }
        });
        oninputamount_pay();
        var amttopay = isNaN(t_amont) ? 0 : t_amont;
        if (amttopay == '' || amttopay == '0.00') {
            $('#pay_now_table').hide();
            $('.checkbox-distribute').prop('checked', false);
            $('.amount_pay').val('0.00');
        }
        $('.t_amt_pay').text(amttopay.toFixed(2));
    });
   });
   // Function to update the balance based on the edited "Amount Paid"
   function updateBalance(editedCell) {
    var row = editedCell.parentElement;
    var totalAmountCell = row.querySelector('td[data-currency]');
    var balanceCell = row.querySelector('td.balance-cell');
    var totalAmount = parseFloat(totalAmountCell.textContent);
    var editedAmountPaid = parseFloat(editedCell.textContent);
    var newBalance = totalAmount - editedAmountPaid;
   
    balanceCell.textContent = newBalance.toFixed(2);
   }
   function updateBalances() {
    var grandTotal = $('#grand-total').val();
    
        var totalPaid = 0;
    
        $('#toggle_table tr').each(function () {
            var $row = $(this);
            var $amountPaid = $row.find('.editable-amount-paid');
            var $balanceCell = $row.find('.balance_cell');
          
            var amountPaid = parseFloat($amountPaid.text());
           
            var balance = grandTotal - totalPaid - amountPaid;
            $balanceCell.text(balance);
           
            totalPaid += amountPaid;
        });
   }
   function updateTotalAmountToPay() {
   var totalAmountToPay = 0;
   // Iterate through each "Amount to Pay" input field and sum their values
   $('.amount_pay').each(function () {
    var amount = parseFloat($(this).val()) || 0; 
   if($(this).val() =='' || $(this).val() =='0.00'){
   $(this).closest('tr').find('.checkbox-distribute').prop('checked', false);
   }
    totalAmountToPay += amount;
   });
   var amttopay = isNaN(totalAmountToPay) ? 0 : totalAmountToPay;
   if(amttopay =='' || amttopay=='0.00'){
      $('#pay_now_table').hide();
   }

   $('.t_amt_pay').text(amttopay.toFixed(2));
   }
   function updateTotalbalanceToPay() {
   var totalbalanceToPay = 0;
 
   $('.updated_bal').each(function () {
    var amount1 = parseFloat($(this).val()) || 0; 
    totalbalanceToPay += amount1;
   });
   
   $('.t_bal_pay').text(totalbalanceToPay.toFixed(2));
   }
   var totalbalancetopay = 0;
  
   $(document).on('keyup change input', '.amount_pay,#total-amount', function () {
   oninputamount_pay();
   });
         $(document).on('keyup change input', '.amount_pay', function () {
    var total_balance_amount = parseFloat($('.t_amt_pay').html());
 var amount_to_distribute = parseFloat($('#total-amount').val());
 var final=parseFloat(amount_to_distribute)-parseFloat(total_balance_amount);
 if (final > 0) {
     $('#advanceamount').val(final);
 }else{
   $('#advanceamount').val('0.00');
 }
   });
   $(document).on('keyup change input', '.amount_pay,#total-amount', function () {
   updateTotalAmountToPay();
   var anyAmountPaid = false;
            $('.amount_pay').each(function () {
                if ($(this).val() !== '') {
                    anyAmountPaid = true;
                    return false;
                }
            });
            if (anyAmountPaid) {
                $('#pay_now_table').show();
                 $('.balance-column').show();
            } else {
                $('#pay_now_table').hide();
                 $('.balance-column').hide();
            } 
   var amountPaidCell = $(this).val(); 
    var balanceCell = $(this).closest('tr').find('.due_pay').text(); 
   var amountPaid = parseFloat(amountPaidCell) || 0; 
    var amountToPay = parseFloat(balanceCell) || 0;
    var updatedBalance = amountToPay-amountPaid; 
  
   $(this).closest('tr').find('.balance-column').html("<input type='text' id='updated_bal' readonly class='updated_bal' name='updated_bal[]' value="+updatedBalance.toFixed(2)+" />");
   updateTotalbalanceToPay();
   });
   function oninputamount_pay() {
   updateTotalAmountToPay();
   var anyAmountPaid = false;
            $('.amount_pay').each(function () {
                if ($(this).val() !== '') {
                    anyAmountPaid = true;
                    return false; 
                }else{
                   $(this).closest('tr').find('td.updated_bal').val('');
                }
            });
            if (anyAmountPaid) {
                $('#pay_now_table').show();
                 $('.balance-column').show();
            } else {
                $('#pay_now_table').hide();
                 $('.balance-column').hide();
            }
   var amountPaidCell =$(this).closest('tr').find('amount_pay').val(); 
    var balanceCell = $(this).closest('tr').find('.due_pay').text(); 
   var amountPaid = parseFloat(amountPaidCell) || 0; 
    var amountToPay = parseFloat(balanceCell) || 0; 
     updatedBalance  = amountToPay-amountPaid;
   console.log('up_bal :'+updatedBalance);
   $(this).closest('tr').find('.balance-col').val(updatedBalance.toFixed(2));
   updateTotalbalanceToPay();
   }
   $(document).on('input','#total-amount', function () {
 var total_balance_amount = parseFloat($('.bcm').html());
 var amount_to_distribute = parseFloat($('#total-amount').val());
  console.log('total_balance_amount: ' + total_balance_amount);
  console.log('amount_to_distribute: ' + amount_to_distribute);
 final=parseFloat(amount_to_distribute)-parseFloat(total_balance_amount);
 if (final > 0) {
     $('#advanceamount').val(final);
 }else{
   $('#advanceamount').val('0.00');
 }
});
  
   updateTotalAmountToPay();
   updateTotalbalanceToPay();
   function editRow(button) {
   var row = button.parentNode.parentNode;
   var cells = row.getElementsByTagName("td");
   for (var i = 0; i < cells.length - 1; i++) { 
    var cell = cells[i];
   
    var headerCell = row.parentNode.parentNode.querySelector("thead tr td:nth-child(" + (i + 1) + ")");
    if (headerCell.textContent.trim() !== "Balance" && headerCell.textContent.trim() !== "S.NO") {
      var currentValue = cell.innerHTML;
      var input = document.createElement("input");
      input.type = "text";
      input.value = currentValue;
       var uniqueClassName = "editable-input-" + i; 
      input.className = uniqueClassName;
        input.name = "inputField" + i;
      cell.innerHTML = "";
      cell.appendChild(input);
    }
   }
   var saveButton = document.createElement("button");
   saveButton.className = "save-button";
   saveButton.style.backgroundColor = '#38469f';
    saveButton.style.color  = 'white';
    saveButton.style.fontWeight = 'bold';
   saveButton.innerHTML = "Update";
   row.setAttribute("data-row-id", "unique_row_id_" + Date.now());
   saveButton.onclick = function () {
    if (saveButton.innerHTML === "Update") {
   
    saveButton.innerHTML = "Edit";
      saveButton.style.backgroundColor = '#38469f';
    saveButton.style.color  = 'white';
    saveButton.style.fontWeight = 'bold';
    for (var i = 0; i < cells.length - 1; i++) {
    var cell = cells[i];
    var input = cell.querySelector("input");
    var newValue = input.value;
    cell.innerHTML = newValue;
   
      input.setAttribute("readonly", "true");
   }
      saveButton.onclick = function () {
        editRow(saveButton);
      };
   } else {
   
    saveButton.innerHTML = "Update";
      saveButton.style.backgroundColor = '#38469f';
    saveButton.style.color  = 'white';
    saveButton.style.fontWeight = 'bold';
      saveButton.onclick = function () {
        saveRow(saveButton);
      };
   }
    saveRow(row);
   };
   var actionCell = row.getElementsByTagName("td")[cells.length - 1];
   actionCell.innerHTML = "";
   actionCell.appendChild(saveButton);
   }
   $(document).on('keyup', '.editable-amount-paid', function () {
   var gtotal=$('#customer_gtotal').val();
    const grandTotal = parseFloat(gtotal) || 0;
    console.log("grandTotal :"+grandTotal);
    let cumulativePayment = 0;
   let balance_payment = 0;
    $('#toggle_table tbody tr').each(function () {
        const inputField = $(this).find('.editable-amount-paid');
        const balanceCell = $(this).find('.balance-cell');
        const paymentAmount = parseFloat(inputField.text()) || 0;
         console.log("inputField :"+paymentAmount);
        cumulativePayment += paymentAmount;
   $(this).find('.editable-amount-paid input').val(paymentAmount);
        const balance = grandTotal - cumulativePayment;
        balance_payment +=balance;
           console.log("balance :"+grandTotal+"-"+cumulativePayment+"="+balance);
        balanceCell.text('$' + balance.toFixed(2));
          $(this).find('.edit_balance').val(balance.toFixed(2));
    });
     document.getElementById('tl_amt_pd').value = cumulativePayment.toFixed(2);
     var b=gtotal-cumulativePayment;
      document.getElementById('my_bal_1').value = b.toFixed(2);
   });
   $(document).on('click','.save-button',function (event) {
   var row1 = $(this).closest('tr');
      var row = $(this).closest('table').find('tr'); 
      var name =  $(this).closest('table').find('tr').find('td:eq(0)').text(); 
      var payment_date =  $(this).closest('table').find('tr').find('.editable-input-1').val(); 
   var ref =  $(this).closest('table').find('tr').find('.editable-input-2').val();
   var b_name =  $(this).closest('table').find('tr').find('.editable-input-3').val();
   var amt_paid =  $(this).closest('table').find('tr').find('.editable-input-4').val();
     var bal =  row1.find('td.balance-cell').text();
       var detail =  $(this).closest('table').find('tr').find('.editable-input-6').val();
        var payment_id = "<?php if($all_invoice[0]['payment_id']){ echo $all_invoice[0]['payment_id']; }else{ echo $payment_id_new;}?>";
    
      var data = {
        name: name,
        payment_date: payment_date,
        ref: ref,
        b_name: b_name,
        amt_paid: amt_paid,
        bal: bal,
        detail:detail,
        payment_id:payment_id
      };
     data[csrfName] = csrfHash;
     
      $.ajax({
        type: 'POST',
       url:"<?php echo base_url(); ?>Cinvoice/update_payment_data",
        data: data,
        success: function (response) {
        
          console.log(response);
        },
        error: function (error) {
        
          console.error(error);
        },
      });
         event.preventDefault();
    });
    function saveRow(row) {
      var cells = row.getElementsByTagName("td");
   var editButton = row.querySelector("button");
   for (var i = 0; i < cells.length - 1; i++) {
    var cell = cells[i];
    var input = cell.querySelector("input");
    var newValue = input.value;
    cell.innerHTML = newValue;
  
    if (editButton.innerHTML === "Edit") {
    
      input.setAttribute("readonly", "true");
    }
   }
   var actionCell = row.getElementsByTagName("td")[cells.length - 1];
 
   editButton.innerHTML = "Edit";
      editButton.onclick = function () {
        editRow(editButton);
      };
      actionCell.innerHTML = "";
      actionCell.appendChild(editButton);
    }
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    var succalert = '<div class="alert alert-success alert-dismissible" role="alert">';
    var failalert = '<div class="alert alert-danger alert-dismissible" role="alert">';
    var alert2 = '</div>';
		  $(document).ready(function(){
         $('.amt_update').hide();
   });
$(document).on('change select input', '.product_name, .bundle_no, .supplier_block_no', function (e) {
  var inputElementId = $(this).attr('id');
    var tableID = $(this).closest('table').attr('id');
   var idParts = inputElementId.split('_');
    var uniqueIdentifier = idParts[idParts.length - 1];
    $('#tableid_'+uniqueIdentifier).val(uniqueIdentifier);
    var tableIdSelector = '#prodt_' + uniqueIdentifier;
     sessionStorage.setItem('current_table_id', tableIdSelector);
     sessionStorage.setItem('current_table', tableID);
    var value = $(this).val();
    var requestType, requestDataKey;
    if ($(this).hasClass('product_name')) {
        requestType = 'product_info';
        requestDataKey = 'prodt';
    } else if ($(this).hasClass('bundle_no')) {
        requestType = 'bundle_info';
        requestDataKey = 'bundle_no';
    } else if ($(this).hasClass('supplier_block_no')) {
        requestType = 'supplier_block_info';
        requestDataKey = 'supplier_block_no';
    }
    var data = {
        requestType: requestType,
        search_value: value,
        [csrfName]: csrfHash
    };
    $.ajax({
        type: 'POST',
        data: data,
        dataType: 'json',
        url: '<?php echo base_url(); ?>Cinvoice/fetch_info_based_on_selection',
        success: function (result) {
            if (result.length > 0) {
                var total = '<table style="width: 100%;  text-align: center;"> <tr> <td style="width: 20%;"></td><td style="text-align: center;"> <input type="text" style="width: auto; max-width: 100%;" class="form-control" id="bundle_search" onkeyup="search()" placeholder="Search for Bundle no.."> </td> <td style="width: 10%;"></td><td style="text-align: center;"> <input type="text" style="width: auto; max-width: 100%;" class="form-control" id="block_search" onkeyup="search()" placeholder="Search for Supplier Block no.."> </td> <td style="width: 10%;"></td><td style="text-align: center;"> <input type="text" style="width: auto; max-width: 100%;" class="form-control" id="slab_search" onkeyup="search()" placeholder="Search for Supplier Slab no.."> </td> <td style="width: 10%;"></td> </tr> </table> <br/>';
                var table_header = "<table style='width:auto;word-wrap:break-word;' class='product_model table table-bordered table-hover'  id='product_table1'> <thead> <tr class='btnclr'><th rowspan='2' class='text-center'>Select All</th> <th rowspan='2' style='width: max-content;' class='text-center'>Product ID</th><th rowspan='2' style='width: max-content;' class='text-center'>Product Name</th>   <th rowspan='2' style='width: max-content;' class='text-center'>Bundle No</th> <th rowspan='2' style='width: max-content;' class='text-center'>Description</th> <th rowspan='2' class='text-center'>Thickness</th> <th rowspan='2' class='text-center'>Supplier Block No</th>  <th rowspan='2' class='text-center' >Supplier Slab No</th> <th colspan='2' style='width: max-content;' class='text-center'>Gross Measurement</th> <th rowspan='2' class='text-center'>Gross Sq. Ft</th> <th rowspan='2' style='width: min-content;' class='text-center'>Bundle No</th> <th rowspan='2' style='width: min-content;' class='text-center'>Slab No</th> <th colspan='2' style='width: max-content;' class='text-center'>Net Measurement</th> <th rowspan='2' class='text-center'>Net Sq. Ft</th> <th rowspan='2' style='width: 80px;' class='text-center'>Cost per Sq. Ft</th> <th rowspan='2' style='width: 80px;' class='text-center'>Cost per Slab</th> <th rowspan='2' style='width: 80px;' class='text-center'>Sales<br/>Price per Sq. Ft</th> <th rowspan='2'  style='width: 80px;' class='text-center'>Sales Slab Price</th> <th rowspan='2' class='text-center'>Weight</th>   <th rowspan='2' style='width: 100px' class='text-center'>Total</th> </tr>  <tr> <th class='btnclr text-center'>Width</th> <th class='btnclr text-center'>Height</th> <th class='btnclr text-center'>Width</th> <th class='btnclr text-center'>Height</th> </tr>  </thead><tbody>";
                var html = "";
                var count = 1;
                result.forEach(function (element) {
                    var sales_price = isNaN(element.price) ? 0 : element.price;
                    html += "<tr><td><input type='checkbox' name='case[]' class='checkbox'/></td><td>" + element.product_id+ "</td><td>" + element.product_name + '-' + element.product_model + "</td><td>" + element.bundle_no + "</td><td>" + element.description_table + "</td><td>" + element.thickness + "</td><td>" + element.supplier_block_no + "</td><td>" + element.supplier_slab_no + "</td><td>" + element.g_width + "</td><td>" + element.g_height + "</td><td>" + element.gross_sqft + "</td><td>" + element.bundle_no + "</td><td>" + count + "</td><td>" + element.n_width + "</td><td>" + element.n_height + "</td><td>" + element.net_sqft + "</td><td>" + element.cost_sqft + "</td><td>" + element.cost_slab + "</td><td>" + element.sales_price_sqft + "</td><td>" + element.sales_slab_price + "</td><td>" + element.weight + "</td><td>" + element.total_amt + "</td><td style='display:none'>" + sales_price + "</td></tr>";
                    count++;
                });
                var all = total + table_header + html;
                $('#product_data_list').html(all);
                $('#product_model_info').modal('show');
            } else {
                $('#product_model_info').modal('hide');
            }
        }
    });
});
$('#paypls').on('click',function(){
$('#amount_to_pay').val($('#balance').val());
});
   $('#payment_from_modal').on('input',function(e){
   var payment=parseFloat($('#payment_from_modal').val());
   var amount_to_pay=parseFloat($('#amount_to_pay').val());
   var value=parseFloat(amount_to_pay.toFixed(2))-parseFloat(payment.toFixed(2));
   $('#balance_modal').val(value.toFixed(2));
   if (isNaN(value)) {
   $('#balance_modal').val("0");
   }
   });
//Search in Product List Model - based on Product Name , Supplier Block Number and Bundle Number
function search() {
   const filterSupplierBlockNo = document.getElementById("block_search").value.toUpperCase();
    const filterSupplierSlabNo = document.getElementById("slab_search").value.toUpperCase();
    const filterBundleNo = document.getElementById("bundle_search").value.toUpperCase();
    const table = document.getElementById("product_table1");
    const rows = table.getElementsByTagName("tr");
  for (let i = 0; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName("td");
        if (cells.length > 6) {
            const supplierBlockNo = (cells[6].textContent || cells[6].innerText).toUpperCase();
            const supplierSlabNo = (cells[7].textContent || cells[7].innerText).toUpperCase();
            const bundleNo = (cells[3].textContent || cells[3].innerText).toUpperCase();
           if (
                supplierBlockNo.includes(filterSupplierBlockNo) &&
                supplierSlabNo.includes(filterSupplierSlabNo) &&
                bundleNo.includes(filterBundleNo)
            ) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    }
}
$(document).on('keyup', '.normalinvoice tbody tr:last', function (e) {
    var tableId = $(this).closest('table').attr('id');
    var dynamicId = tableId.split('_').pop();
    var $lastRow = $('#addPurchaseItem_' + dynamicId + ' tr:last');
    var $newRow = $lastRow.clone();
    var rowCount = $('#addPurchaseItem_' + dynamicId + ' tr').length;
    var newRowNumber = dynamicId+''+rowCount;
    $newRow.find('datalist, input, select, button').each(function () {
        var $element = $(this);
        var currentId = $element.attr('id');
        if (currentId) {
            var newId = currentId.replace(/\d+$/, newRowNumber);
            $element.attr('id', newId);
            if ($element.is('input') || $element.is('select')) {
                if ($element.hasClass('product_name')) {
                    $element.val('').prop('disabled', false);
                } else {
                    $element.val('');
                }
            }
        }
    });
    $newRow.appendTo('#addPurchaseItem_' + dynamicId);
    $('#normalinvoice_' + dynamicId + ' tbody tr').each(function (index) {
        $(this).find(".slab_no").val(index + 1);
    });
});
// Function to fill the table rows based on the selected row from the Product Model
$(document).on('click', '.checkbox', function() {
    $('#product_model_info').modal('hide');
    var storedTableIdSelector = sessionStorage.getItem('current_table_id');
    var storedTableId = sessionStorage.getItem('current_table');
   var values = $("input[name='case[]']:checked").closest("td").siblings("td").map(function() {
        return $(this).text();
    }).get();
      var $tableRow = $(storedTableIdSelector).closest("tr");
  var tableId = $(storedTableIdSelector).attr('id');
    var uniqueIdentifier = tableId.split('_').pop();
    var fields = [
        'selected_product_id_','prodt_', 'bundle_no_', 'description_', 'thickness_',
        'supplier_b_no_', 'supplier_s_no_', 'gross_width_', 'gross_height_',
        'gross_sq_ft_', 'net_width_', 'net_height_', 'net_sq_ft_',
        'cost_sq_ft_', 'cost_sq_slab_', 'sales_amt_sq_ft_', 'sales_slab_amt_',
        'weight_', 'total_amt_'
    ];
    $.each(fields, function(index, fieldPrefix) {
        var fieldIndex = index < values.length ? index : 0;
        $tableRow.find('#' + fieldPrefix + uniqueIdentifier).val(values[fieldIndex]);
    });
updateTableTotals(storedTableId);
updateOverallTotals(true);
});
//To show the Landing Cost Model On click Additional Cost
  $('#landing_cost').on('click', function (e) {
   var invoice_no = $('#invoice').val();
  $('#service_invoice').val(invoice_no);
   $('#landing_modal').modal('show');
   e.preventDefault();
   });
               $('#land_amt').on('click', function(e) {
                  updateOverallTotals();
            });
    $(document).on('change input keyup','.sp_total',function (e) {
   var sum = 0;
$(".sp_total").each(function() {
if(!isNaN(this.value) && this.value.length!=0) {
   				sum += parseFloat(this.value);
   			}
   		});
   		$("#landing_amount").val(sum.toFixed(2));
   });
    $(document).on('keyup', '.sp_qty,.sp_rate', function (e) {
      ;
   var rate=$(this).closest('table tr').find('.sp_rate').val();
   var qty=$(this).closest('table tr').find('.sp_qty').val();
   var total=rate * qty;
   $(this).closest('table tr').find('.sp_total').val(total);
   var sum = 0;
   		$(".sp_total").each(function() {
   			if(!isNaN(this.value) && this.value.length!=0) {
   				sum += parseFloat(this.value);
   			}
   		});
   	$(this).closest('table').find("#landing_amount").val(sum.toFixed(2));
     });
   $(document).on('keyup', '.serviceprovider > tbody > tr:last-child', function (e) {
   var tid=$(this).closest('table').attr('id');
   const indexLast = tid.lastIndexOf('_');
   var id = tid.slice(indexLast + 1);
    var $last = $('#service_pro tr:last');
       var num = ($last.index()+1);
       $('#service_pro tr:last').clone().find('datalist,input,select').attr('id', function(i, current) {
           return current.replace(/\d+$/, num);
       }).end().appendTo('#service_pro');
   });
 
 $(document).on('click', '.delete_provider', function(){
var rowCount = $(this).closest('tbody').find('tr').length;
   if(rowCount>1){
   $(this).closest('tr').remove();
   }
 });
   $("#land_form").validate({
   rules: {
   sp_qty: "required",
    sp_rate: "required",  
     s_p: "required",
 },
 messages: {
     sp_qty: "Supplier Quantity is required",
    sp_rate: "Supplier Rate is required",
    s_p: "Supplier Name is required",
 },
submitHandler: function(form) {
  var formData = new FormData(form);
  formData.append(csrfName, csrfHash);
  $.ajax({
    type: "POST",
    dataType: "json",
    url: "<?php echo base_url('Cinvoice/service_invoice_details'); ?>",
    data: formData,
    contentType: false,
    processData: false,
    success: function(response) {
       if (response.status == 'success') {
           var rowCount = $('.tbody tr').length;
   var l = $('#landing_amount').val();
   console.log("Count :"+rowCount);
   var l_amt=l/rowCount;
   $('#errormessage_landing_cost').html(succalert + response.msg + alert2);
    $('.normalinvoice tbody tr').each(function() {
        var tableId = $(this).closest('table').attr('id');
        var tableIndex = tableId.lastIndexOf('_');
        var tableSuffix = tableId.slice(tableIndex + 1);
        var slabCost = parseFloat($(this).find('.cost_sq_slab').val()) || 0;
        var netArea = parseFloat($(this).find('.net_sq_ft').val()) || 0;
        var totalAmount = parseFloat(l_amt) || 0;
        var finalAmount = totalAmount + slabCost;
        var costPerSqFt = (totalAmount + slabCost) / netArea;
        $(this).find('.landing_field').remove();
        $(this).find('td').eq(14).after(
            '<td class="landing_field"><span class="input-symbol-euro">' +
            '<input type="text" readonly style="width:80px;" name="l_cost[]" value="' + costPerSqFt.toFixed(2) + '" class="form-control l_cost">' +
            '</span></td>' +
            '<td class="landing_field"><span class="input-symbol-euro">' +
            '<input type="text" style="width:80px;" readonly name="l_cost_slab[]" value="' + finalAmount.toFixed(2) + '" class="form-control l_cost_slab">' +
            '</span></td>'
        );
    $('.land_th').show();
    $('.lc_tdfields').show();
     updateOverallTotals();
    });
 window.setTimeout(function(){
       $('#landing_modal').modal('hide');
   }, 2000);
}else{
     $('#errormessage_landing_cost').html(failalert + response.msg + alert2);
}                
    },
        error: function(xhr, status, error) {
        alert('An error occurred: ' + error);
    }
  })
}
});

     $('#customer_names').change(function(e) {
    var data = {
        value: $(this).val()
    };
    data[csrfName] = csrfHash;
    $.ajax({
        type: 'POST',
        data: data,
        dataType: 'json',
        url: '<?php echo base_url(); ?>Cinvoice/getcustomer_data',
        success: function(result, statut) {
            if (result.csrfName) {
                csrfName = result.csrfName;
                csrfHash = result.csrfHash;
            }
       $('#billing_address').html(result[0]['billing_address'] + '\n' +
                                        result[0]['city'] + '\n' +
                                        result[0]['state'] + "-" + result[0]['zip'] + "-" + result[0]['country'] + '\n' +
                                        result[0]['customer_email'] + '\n' + result[0]['phone']);
            $('#shipping_address').html(result[0]['shipping_address'] + '\n' +
                                         result[0]['city'] + '\n' +
                                         result[0]['state'] + "-" + result[0]['zip'] + "-" + result[0]['country'] + '\n' +
                                         result[0]['customer_email'] + '\n' + result[0]['phone']);
            $('#product_tax').val(result[0]['tax_status'] == 2 ? result[0]['tax_percent'] : 0);
            var custo_currency = result[0]['currency_type'];
            $("#autocomplete_customer_id").val(result[0]['customer_id']);
            $("label[for='custocurrency']").html(custo_currency);
            $(".cus").html(custo_currency);
            $.getJSON('https://open.er-api.com/v6/latest/<?php echo $curn_info_default; ?>', function(data) {
                var x = data['rates'][custo_currency];
                var Rate = parseFloat(x).toFixed(2);
                Rate = isNaN(Rate) ? 0 : Rate;
                console.log(Rate);
                $('.hiden').show();
                $(".custocurrency_rate").val(Rate);
            });
        }
    });
});
var succalert = '<div class="alert alert-success alert-dismissible" role="alert">';
    var failalert = '<div class="alert alert-danger alert-dismissible" role="alert">';
     // Custom method to trim input fields
     $.validator.addMethod("trimRequired", function(value, element) {
        return $.trim(value) !== "";
    }, "This field is required.");
    $("#insert_invoice").validate({
        rules: {
            customer_name: "trimRequired",
            payment_due_date: "required",
            billing_address: "required",
            terms: "required",
            commercial_invoice_number: "required"
        },
        messages: {
            customer_name: "Company Name is required",
            payment_due_date: "Payment Due Date is required",
           billing_address : "Billing Address is required" ,
           terms : "Payment Terms is required",
            commercial_invoice_number : "Invoice Number is required"
        },
        errorPlacement: function(error, element) {
            if (element.hasClass("select2-hidden-accessible")) {
                error.insertAfter(element.next('span.select2')); // Place error message after the Select2 element
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            var formData = new FormData(form);
            formData.append(csrfName, csrfHash);
                $.ajax({
                    type:"POST",
                    dataType:"json",
                    url:"<?php echo base_url(); ?>Cinvoice/manual_sales_insert?id=<?php echo $_GET['id']; ?>",
                    data:formData,
                    contentType: false, 
                    processData: false, 
                    success:function (response) {
                     debugger;
                      if (response.status === 'success') {
                         $('.hidden_button').show();
                         $('#errormessage_invoice').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
            $('.error_display').html(succalert + response.msg + alert2);
    
            $('#inv_id').val(response.invoice_id);
            $('#inv_no').val(response.invoice_no);
            window.setTimeout(function() {
                window.location = "<?php echo base_url(); ?>Cinvoice/manage_invoice?id=<?php echo $_GET['id']; ?>";
            }, 2500);
        } else {
           $('#errormessage_invoice').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
         }
                    }
                });
            event.preventDefault();
        }
    });
        $c= $("table.normalinvoice").length;
      let dynamic_id=$c+1;
         function addbundle(){

        $(this).closest('table').find('.addbundle').css("display","none");
     $(this).closest('table').find('.removebundle').css("display","block");

   var newdiv = document.createElement('div');
   var tabin="crate_wrap_"+dynamic_id;

   newdiv.innerHTML ='<table class="table normalinvoice table-bordered table-hover" id="normalinvoice_'+ dynamic_id +'"> <thead> <tr> <th rowspan="2" class="text-center" style="width: 170px;" ><?php echo display('product_name'); ?><i class="text-danger">*</i></th> <th rowspan="2"  class="text-center"><?php echo display('Bundle No'); ?><i class="text-danger">*</i></th> <th rowspan="2"  class="text-center"><?php echo display('description'); ?></th> <th rowspan="2" style="width:60px;" class="text-center"><?php echo display('Thick ness'); ?><i class="text-danger">*</i></th> <th rowspan="2" class="text-center"><?php echo display('Supplier Block No'); ?><i class="text-danger">*</i></th>  <th rowspan="2" class="text-center" ><?php echo display('Supplier Slab No'); ?><i class="text-danger">*</i> </th> <th colspan="2" style="width:150px;" class="text-center"><?php echo display('Gross Measurement'); ?><i class="text-danger">*</i> </th> <th rowspan="2" class="text-center"><?php echo display('Gross Sq.Ft'); ?></th>  <th rowspan="2" style="width:40px;" class="text-center"><?php echo display('Slab No'); ?><i class="text-danger">*</i></th> <th colspan="2" style="width:150px;" class="text-center"><?php echo display('Net Measure'); ?><i class="text-danger">*</i></th> <th rowspan="2" class="text-center"><?php echo display('Net Sq.Ft'); ?></th> <th rowspan="2" class="text-center"><?php echo display('Cost per Sq.Ft'); ?></th><th rowspan="2"  class="text-center"><?php echo display('Cost per Slab'); ?></th><th rowspan="2" class="land_th" style="width: 100px" class="text-center"><?php echo "Landing Cost per Sq.Ft" ?></th><th rowspan="2" class="land_th" style="width: 100px" class="text-center"><?php echo "Landing Cost per Slab" ?></th>  <th rowspan="2"  class="text-center"><?php echo display('sales'); ?><br/><?php echo display('Price per Sq.Ft'); ?></th> <th rowspan="2"  class="text-center"><?php echo display('Sales Slab Price'); ?></th> <th rowspan="2" class="text-center"><?php echo display('Weight'); ?></th>   <th rowspan="2" style="width: 100px" class="text-center"><?php echo display('total'); ?></th><th rowspan="2" class="text-center"><?php echo display('action'); ?></th> </tr>  <tr> <th class="text-center"><?php echo display('Width'); ?></th> <th class="text-center"><?php echo display('Height'); ?></th> <th class="text-center"><?php echo display('Width'); ?></th> <th class="text-center"><?php echo display('Height'); ?></th> </tr>  </thead> <tbody class="tbody" id="addPurchaseItem_'+ dynamic_id +'"> <tr> <input type="hidden" name="tableid[]" id="tableid_'+ dynamic_id +'"/><td> <input   list="magicHouses"  style="width:160px;" name="prodt[]" id="prodt_'+ dynamic_id +'"   class="form-control product_name"  placeholder="Search Product" > <datalist id="magicHouses"> <option value="Select the Product" selected>Select the Product</option> <?php foreach ($product as $tx) {?>  <option value="<?php echo $tx["product_name"] . "-" . $tx["product_model"]; ?>">  <?php echo $tx["product_name"] . "-" . $tx["product_model"]; ?></option> <?php }?> </datalist> <input type="hidden" class="common_product autocomplete_hidden_value  product_id_'+ dynamic_id +'" name="product_id[]"        id="selected_product_id_'+ dynamic_id +'" /> </td> <td>  <input list="magic_bundle" name="bundle_no[]" id="bundle_no_'+ dynamic_id +'"   class="form-control bundle_no"'+'onchange="this.reset();" /><datalist id="magic_bundle"><?php foreach ($bundle as $tx) {?> <option value="<?php echo $tx['bundle_no']; ?>">  <?php echo $tx['bundle_no']; ?></option> <?php }?>'+

   '</datalist></td> <td> <input type="text" id="description_'+ dynamic_id +'" name="description[]" class="form-control" /> </td>  <td > <input type="text" name="thickness[]" id="thickness_'+ dynamic_id +'" required="" class="form-control"/> </td>  <td><input list="magic_supplier_block" name="supplier_block_no[]"  id="supplier_b_no_'+ dynamic_id +'"   class="form-control supplier_block_no"  placeholder="Search Product"  onchange="this.blur();" /><datalist id="magic_supplier_block"><?php foreach ($supplier_block_no as $tx) {?><option value="<?php echo $tx['supplier_block_no']; ?>">  <?php echo $tx['supplier_block_no']; ?></option><?php }?></datalist> </td>  <td > <input type="text"  id="supplier_s_no_'+ dynamic_id +'" name="supplier_slab_no[]" required="" class="form-control"/> </td> <td> <input type="text" id="gross_width_'+ dynamic_id +'" name="gross_width[]" required="" class="gross_width  form-control" /> </td> <td> <input type="text" id="gross_height_'+ dynamic_id +'" name="gross_height[]"  required="" class="gross_height form-control" /> </td>  <td > <input type="text"   style="width:60px;" readonly id="gross_sq_ft_'+ dynamic_id +'" name="gross_sq_ft[]" class="gross_sq_ft form-control"/> </td>   <td style="text-align:center;" >  <input type="text"   style="width:20px;" value="1" class="slab_no" id="slab_no_'+ dynamic_id +'" name="slab_no[]"   readonly  required=""/>  </td> <td> <input type="text" id="net_width_'+ dynamic_id +'" name="net_width[]" required="" class="net_width form-control" /> </td> <td> <input type="text" id="net_height_'+ dynamic_id +'" name="net_height[]"    required="" class="net_height form-control" /> </td> <td > <input type="text"   style="width:60px;" readonly id="net_sq_ft_'+ dynamic_id +'" name="net_sq_ft[]" class="net_sq_ft form-control"/> </td> <td>   <span class="input-symbol-euro"><input type="text" id="cost_sq_ft_'+ dynamic_id +'"  name="cost_sq_ft[]"  readonly  style="width:70px;" placeholder="0.00"  class="cost_sq_ft form-control" ></span>   <td >  <span class="input-symbol-euro"> <input type="text"  id="cost_sq_slab_'+ dynamic_id +'" name="cost_sq_slab[]"  readonly  style="width:70px;" placeholder="0.00"  class="cost_sq_slab form-control"/></span>     </td> <td>  <span class="input-symbol-euro">  <input type="text" id="sales_amt_sq_ft_'+ dynamic_id +'"  name="sales_amt_sq_ft[]"  style="width:70px;"  placeholder="0.00" class="sales_amt_sq_ft form-control" /></span>     </td>  <td >  <span class="input-symbol-euro">   <input type="text"  id="sales_slab_amt_'+ dynamic_id +'" name="sales_slab_amt[]"  style="width:70px;" placeholder="0.00"  class="sales_slab_amt form-control"/></td> </span>     </td> <td> <input type="text" id="weight_'+ dynamic_id +'" name="weight[]"  class="weight form-control" /> </td>   <td > <span class="input-symbol-euro"><input  type="text" class="total_price form-control" style="width:80px;" readonly value="0.00"  id="total_amt_'+ dynamic_id +'"     name="total_amt[]"/></span> </td>  <td style="text-align:center;"> <button  class="delete btn btn-danger" id="delete_'+ dynamic_id +'" type="button" value="Delete" ><i class="fa fa-trash"></i></button> </td>  </tr> </tbody> <tfoot> <tr> <td style="text-align:right;" colspan="8"><b>Gross Sq.Ft :</b></td> <td > <input type="text" id="overall_gross_'+ dynamic_id +'" name="overall_gross[]"   class="overall_gross form-control" style="width: 60px"  readonly="readonly"  /> </td> <td style="text-align:right;" colspan="3"><b>Net Sq.Ft :</b></td> <td > <input type="text" id="overall_net_'+ dynamic_id +'" name="overall_net[]"  class="overall_net form-control"  style="width: 60px"  readonly="readonly"  /> </td>  <td><span class="input-symbol-euro"><input type="text" id="costpersqft_'+ dynamic_id +'"  name="costpersqft[]"   style="width:70px;" placeholder="0.00"  readonly class="costpersqft form-control" /></span></td>'+
   '<td ><span class="input-symbol-euro"> <input type="text"  id="costperslab_'+ dynamic_id +'" name="costperslab[]"    style="width:70px;" placeholder="0.00" readonly class="costperslab form-control"/></span></td><td class="lc_tdfields"><input type="text" id="landingpersqft_'+ dynamic_id +'" name="landingpersqft[]"  class="landingpersqft form-control"  style="width: 60px"  readonly="readonly"  /> </td><td class="lc_tdfields"><input type="text" id="landingperslab_'+ dynamic_id +'" name="landingperslab[]"  class="landingperslab form-control"  style="width: 60px"  readonly="readonly"  /> '+
   '</td><td><span class="input-symbol-euro">  <input type="text" id="salespricepersqft_'+ dynamic_id +'"  name="salespricepersqft[]" readonly  style="width:70px;"  placeholder="0.00" class="salespricepersqft form-control" /></span></td><td ><span class="input-symbol-euro">   <input type="text"  id="salesslabprice_'+ dynamic_id +'" name="salesslabprice[]" readonly  style="width:70px;" placeholder="0.00"  class="salesslabprice form-control"/></td> </span><td ><input type="text" id="overall_weight_'+ dynamic_id +'" name="overall_weight[]"  class="overall_weight form-control"  style="width: 70px"  readonly="readonly"  /></td><td ><span class="input-symbol-euro">    <input type="text" id="Total_'+ dynamic_id +'" name="total[]"   class="b_total form-control"  style="width: 80px" value="0.00"  readonly="readonly"  /></span></td>  <td  style="text-align:center;"><i id="buddle_'+ dynamic_id +'" onclick="removebundle(); " class="btn-danger removebundle fa fa-minus" aria-hidden="true"></i><i id="buddle_'+ dynamic_id +'"  style="color:white;"   onclick="addbundle(); " class="btnclr addbundle fa fa-plus" aria-hidden="true"></i></td>   </tr> </foot></table> ';



   document.getElementById('content').appendChild(newdiv);
   $("#normalinvoice_"+ dynamic_id).find('.land_th').hide();
   $("#normalinvoice_"+ dynamic_id).find('.landing_cost').hide();
   $("#normalinvoice_"+ dynamic_id).find('.lc_tdfields').hide();
   dynamic_id++;

   }
 $(document).on('click', '.removebundle', function(){
 var remove_id=$(this).closest('table').attr('id');
 $('#'+remove_id).remove();
updateOverallTotals(true);
 });
  </script>