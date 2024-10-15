<?php
$modaldata['bootstrap_model'] = array('vendor', 'tax_info', 'payment_model','payment_terms', 'bank_info','payment_type');
$this->load->view('include/bootstrap_model', $modaldata);
?>
<div class="content-wrapper" >

      <!-- Alert Message -->
      <?php
         $message = $this->session->userdata('message');
         if (isset($message)) {
         ?>
      <div class="alert alert-info alert-dismissable">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
         <?php echo $message ?>                    
      </div>
      <?php 
         $this->session->unset_userdata('message');
         }
         $error_message = $this->session->userdata('error_message');
         if (isset($error_message)) {
         ?>
      <?php 
         $this->session->unset_userdata('error_message');
         }
         ?>

         <style>
            .slab_no{
   border:none;
   background-color:inherit;
}
            </style>
      <div class="row">
         <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
               <div class="panel-heading" style="height:60px;">
                  <label for="ISF" class="col-sm-2 col-form-label"><?php echo display('Select Option');?>
                  <i class="text-danger">*</i>
                  </label>
                  <div class="col-sm-2">
                     <select name="module_selection" class="form-control getvaluedata"  id="module_selection" tabindex="3" >
                        <option value="" selected disabled><?php  echo display('Select Option');?></option>
                           <?php  foreach($po_number as $p){   ?>
                        <option value="<?php  echo $p['chalan_no'] ; ?>"><?php  echo $p['chalan_no'] ; ?></option>
                        <?php   }  ?>
                        <option value="New Expense"> <?php echo ('New Expense'); ?></option>
                        <option value="serviceProvider"><?php echo display('Service Provider');?> </option>
                     </select>
                  </div>
               
                 <div class="col-sm-4" style="display: none; text-align: right;" id="addexpenses">
                     <form id="ocr" method="post" enctype="multipart/form-data">
                       <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                        <label for="form_image" class="file-upload">
                           <span><i class="fa fa-upload" aria-hidden="true"></i>&nbsp;Expense Invoice Scan</span>
                           <input type="file" id="form_image" name="form_image" accept="image/*" required>
                        </label>
                     </form>
                  </div>

                  <div class="col-sm-4" style="display: none; text-align: right;" id="addserviceprovider">
                     <form id="ocrserviceprovider" method="post" enctype="multipart/form-data">
                       <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                        <label for="form_image" class="file-upload">
                           <span><i class="fa fa-upload" aria-hidden="true"></i>&nbsp;Service Provider Invoice Scan</span>
                           <input type="file" id="form_imageservice" name="form_imageservice" class="form_imageservice" accept="image/*" required>
                        </label>
                     </form>
                  </div>
                  <div class="col-sm-2">
                    
                    <a  href="<?php  echo base_url(); ?>Cpurchase/manage_purchase?id=<?php echo $_GET['id']; ?>" class="btnclr btn  m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_expense'); ?> </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row" id="main">

         <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
          
               <div class="panel-heading">
                  <div class="panel-body">
                     <div class="with_po">

                       

                        <form id="insert_purchase" method="post">
                           <div class="text-center" style="display: none; font-size: 20px;" id="purchaseLoading">Loading...</div>
                        </form>
                     </div>
                     <div class="without_po">

                      
                        <form id="insert_expense"  method="post">
                             <div id="errormessage_expense" class="errormessage_expense"></div><br>

                           <div class="row">
                           <div class="col-sm-6">  
                          <input type="hidden" id="admin_company_id" name="admin_company_id" value="<?php  echo $_GET['id']; ?>">
                          <input type="hidden" id="makepaymentId" name="makepaymentId">
                          <input type="hidden" name="paid_customer_currency" id="paid_customer_currency"/>
                          <input type="hidden" name="balance_customer_currency" id="balance_customer_currency"/>
                           <div class="form-group row">
                                    <label for="supplier_sss" class="col-sm-4 col-form-label"><?php echo display('Vendor');?>
                                    <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                       <select name="supplier_id" id="supplier_id" class="form-control vendorNAME"  style="border:2px solid #d7d4d6;width:100%;" required tabindex="1">
                                          <option value=""><?php echo display('select_one') ?></option>
                                          <?php foreach ($supplier_list as $key => $supplier) { ?>
                                          <option value="<?php echo $supplier['supplier_id']; ?>"><?php echo $supplier['supplier_name']; ?></option>
                                          <?php } ?>
                                       </select>
                                    </div>
                                    <?php //if($this->permission1->method('add_supplier','create')->access()){ ?>
                                    <div class="col-sm-1 mobile_vendor">
                                       <a  class="btnclr client-add-btn btn  " aria-hidden="true"    data-toggle="modal"data-target="#add_vendor"><i class="fa fa-user"></i></a>
                                    </div>
                                    <?php// }?> 
                                 </div>
                                 <div class="form-group row">
                                    <label for="" class="col-sm-4 col-form-label" ><?php echo display('Vendor Type');?></label>
                                    <div class="col-sm-8">
                                       <input type="vendor_type" tabindex="3" class="form-control" name="vendor_type"  style="WIDTH: 100%;border:2px solid #d7d4d6;" readonly placeholder="" id="vendor_type_details" />
                                    </div>
                                 </div>
                              </div>
                              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                              
                              <div class="col-sm-6">
                                 <br/>
                                 <div class="form-group row">
                                    <label for="" class="col-sm-4 col-form-label"> <?php echo display('Vendor Address');?>
                                    <i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-8">
                                       <textarea class="form-control vendorAddress" tabindex="4" id="vendor_add" rows="4" cols="50"  style="border:2px solid #d7d4d6;" name="vendor_add" placeholder="" rows="1"></textarea>
                                       <div id="loadingText" class="loading-text"></div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-6" id="">
                                 <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label"><?php echo display('invoice_no');  ?><i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                       <input  class=" form-control" type="" size="50"     style="border:2px solid #d7d4d6;"   name="invoice_no" id="invoice_no" value="" tabindex="4" />
                                       <div id="loadingText" class="loading-text"></div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-6" id="">
                                 <div class="form-group row">
                                    <label for="text" class="col-sm-4 col-form-label"><?php echo display('Expenses / Bill date');?>
                                    <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-5">
                                       <?php $date = date('m-d-Y');?>
                                       <input type="date"  style="width:165%;border:2px solid #d7d4d6;" class="form-control" name="bill_date"   value="<?php echo html_escape($date); ?>" id="date"  />
                                       <div id="loadingText" class="loading-text"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>




                           <div class="row">
                              <div class="col-sm-6">


                                 <div class="form-group row">
                                    <label for="port_of_discharge" class="col-sm-4 col-form-label"> <?php echo display('Port Of Discharge');?></label>
                                    <div class="col-sm-8">
                                       <input class="form-control" type="" size="50"  style="border:2px solid #d7d4d6;" name="Port_of_discharge" id="date1"   tabindex="4" />
                                    </div>
                                 </div>



                               
                             
                                   <div class="form-group row">
                                    <label for="billing_address" class="col-sm-4     col-form-label"><?php echo display('Payment Terms');?>
                                    <i class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                       <select   name="payment_terms" id="payment_terms" style="width:100%;border:2px solid #d7d4d6;" class=" form-control" required placeholder='Payment Terms' id="payment_terms">
                                      	<option value=""><?php echo display('Select Payment Terms') ?></option>
											<?php
											foreach(PAYMENT_TYPE as $payment_typ){
												echo '<option value="'.$payment_typ.'">'.$payment_typ.'</option>';
											}
											?>
                                          <?php foreach($payment_terms as $inv){ ?>
                                          <option value="<?php echo $inv['payment_terms'] ; ?>"><?php echo $inv['payment_terms'] ; ?></option>
                                          <?php    }?>
                                       </select>
                                    </div>
                                    <div class="col-sm-1 mobile_vendor">
                                       <a href="#" class="btnclr client-add-btn btn " aria-hidden="true"    data-toggle="modal" data-target="#payment_type_new" ><i class="fa fa-plus"></i></a>
                                    </div>
                                 </div>  
<div class="form-group row">
                                    <label for="account_category" class="col-sm-4 col-form-label">Account Category</label>
                                    <div class="col-sm-8">
                                       <select id="ddl"  name="account_category" class="form-control" style="border:2px solid #d7d4d6;"  onchange="configureDropDownLists(this,document.getElementById('ddl2'))">
                                          <option value="" selected disabled>Select the Account Category</option>
                                                   		<?php
											foreach(ACC_NAME as $acc_name){
												echo '<option value="'.$acc_name.'">'.$acc_name.'</option>';
											}
											?>
                                       </select>
                                    </div>
                                 </div>






                           


                                 <div class="form-group row">
                                    <label  class="col-sm-4 col-form-label">Account Subcategory</label>
                                    <div class="col-sm-8">
                                       <input class="form-control" name ="account_subcat" id="account_subcat" type="text"  style="border:2px solid #d7d4d6;"  placeholder=" Account Sub Category"  tabindex="1" >
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label for="invoice_no" class="col-sm-4 col-form-label"><?php echo display('Estimated Time Of Arrival');?>
                                    </label>
                                    <div class="col-sm-8">
                                       <?php $date1 = date('Y-m-d'); ?>
                                       <input type="date"  tabindex="2" class="form-control datepicker productETA" style="border:2px solid #d7d4d6;" name="eta" value="<?php echo $date1; ?>" id="date1"  />
                                       <div id="loadingText" class="loading-text"></div>
                                    </div>
                                 </div>
                       

                                 <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label"><?php echo display('B/L No');?> </label>
                                    <div class="col-sm-8">
                                       <input type="text" name="bl_number" class="form-control" style="border:2px solid #d7d4d6;"   placeholder="Bl Number">
                                    </div>
                                 </div>

 





                           
    
                                 <div class="form-group row">
                                    <label for="supplier_sss" class="col-sm-4 col-form-label">Attachments
                                    </label>
                                   
                                    <div class="col-sm-6">
                                       <p>
                                          <label for="attachment">
                                          <a class="btn btnclr text-light" role="button" aria-disabled="false"><i class="fa fa-upload"></i>&nbsp; Choose Files</a>
                                          </label>
                                          <input type="file" name="files_expense[]" class="upload" id="attachment" style="visibility: hidden; position: absolute;" multiple/>
                                       </p>
                                       <p id="files-area">
                                          <span id="filesList">
                                          <span id="files-names"></span>
                                          </span>
                                       </p>
                                    </div>
                                 </div>

                  
                        
                              </div>
                              <div class="col-sm-6">
                           


                                 <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label"><?php echo display('Payment Due Date');?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                       <?php $paymentdate = date('Y-m-d'); ?>
                                       <input class=" form-control" type="date" size="50" name="payment_due_date"   style="border:2px solid #d7d4d6;"  id="payment_due_date" required value="<?php echo $paymentdate; ?>" tabindex="4" />
                                    </div>
                                 </div>




                              </div>
                              <div class="col-sm-6">


                          


 <div class="form-group row">
                                    <label for="payment_type" class="col-sm-4 col-form-label"><?php
                                       echo display('payment_type');
                                       ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                       <select name="paytype_drop" id="paytype_drop" class="form-control" required=""  tabindex="3" style="width:100;border:2px solid #d7d4d6;">
                                          <option value=""><?php echo display('Select Payment Type');?></option>
                                          <option value="CHEQUE"><?php echo display('cheque'); ?></option>
                                          <option value="CASH"><?php echo display('cash'); ?></option>
                                          <option value="CREDIT/DEBIT CARD"><?php echo display('CREDIT/DEBIT CARD');?></option>
                                          <option value="BANK TRANSFER"><?php echo display('BANK TRANSFER');?></option>
                                          <?php foreach($payment_type as $ptype){?>
                                          <option value="<?php echo $ptype['payment_type'];?>"><?php echo $ptype['payment_type'] ;?></option>
                                          <?php }?>
                                       </select>
                                    </div>
                                    <div  class=" col-sm-1">
                                       <a href="#" class="btnclr client-add-btn btn  mobile_vendor"   aria-hidden="true" data-toggle="modal" data-target="#payment_type" ><i class="fa fa-plus"></i></a>
                                    </div>
                                 </div>




                            


                                 <div class="form-group row">
                                    <label for="port_of_discharge" class="col-sm-4 col-form-label">Account Subcategory</label>
                                    <div class="col-sm-8">
                                       <select class="form-control" name="sub_category"   style="border:2px solid #d7d4d6;"  id="ddl2">
                                          <option value="Select Sub Category">Select Sub Category</option>
                                       </select>
                                    </div>
                                 </div>







                                 <div class="form-group row">
                                    <label for="container_number" class="col-sm-4 col-form-label"><?php echo display('Container Number');?> </label>
                                    <div class="col-sm-8">
                                       <input type="text" name="container_no" class="form-control container_no" style="border:2px solid #d7d4d6;"   placeholder="Container Number">
                                    </div>
                                 </div>



                                 <div class="form-group row">
                                    <label for="supplier_sss" class="col-sm-4 col-form-label"><?php echo 'Estimated Time Of Departure';?>
                                    </label>
                                    <div class="col-sm-8">
                                       <input type="date"  tabindex="2" class="form-control datepicker productETD"  style="border:2px solid #d7d4d6;"  name="etd" value="<?php echo $date; ?>" id="date"  />
                                       <div id="loadingText" class="loading-text"></div>
                                    </div>
                                 </div>



                                 <div class="form-group row">
    <label for="invoice_no" class="col-sm-4 col-form-label">

        <?php echo display('ISF FIELD');?><i class="text-danger">*</i>

    </label>
    <div class="col-sm-8">
        <select name="isf_field" class="form-control" id="isf_dropdown" tabindex="3" required="" style="width:100%;border:2px solid #d7d4d6;">
            <option value="" selected><?php echo display('Select ISF NO');?></option>
            <option value="1"><?php echo display('NO') ?></option>
            <option value="2"><?php echo display('YES') ?></option>
        </select>
    </div>
</div>

                                 <div class="form-group row" >
                                    <label for="ISF" class="isf_no1 col-sm-4 col-form-label" ><?php echo display('ISF NO');?>
                                    <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                       <input name="isf_no"  class="isf_no1 form-control bankpayment"     style="width:100%;border:2px solid #d7d4d6;" value=""  >
                                    </div>
                                 </div>

                          

                


                              </div>
                           </div>
                            <div class="table-responsive">
                              <div id="content">
                                 <table class="table normalinvoice table-bordered table-hover" id="normalinvoice_1"   style="border:2px solid #d7d4d6;" >
                                    <thead>
                                       <tr class="btnclr">
                                          <th rowspan="2" class="text-center" style="width:180px;" ><?php echo display('product_name'); ?><i class="text-danger">*</i> </th>
                                          <th rowspan="2" class="text-center" style="width:60px;"><?php echo display('Bundle No');?><i class="text-danger">*</i></th>
                                          <th rowspan="2"  class="text-center"><?php echo  display('description'); ?></th>
                                          <th rowspan="2" class="text-center" style="width:60px;"><?php echo display('Thick ness');?><i class="text-danger">*</i></th>
                                          <th rowspan="2" class="text-center"><?php echo display('Supplier Block No');?><i class="text-danger">*</i></th>
                                          <th rowspan="2" class="text-center" ><?php echo display('Supplier Slab No');?><i class="text-danger">*</i> </th>
                                          <th colspan="2"   style="width:150px;" class="text-center"><?php echo display('Gross Measurement');?><i class="text-danger">*</i> </th>
                                          <th rowspan="2" class="text-center"><?php echo display('Gross Sq.Ft');?></th>
                                          <th rowspan="2" style="width:40px;" class="text-center"><?php echo display('Slab No');?><i class="text-danger">*</i></th>
                                          <th colspan="2"  style="width:150px;" class="text-center"><?php echo display('Net Measure');?><i class="text-danger">*</i></th>
                                          <th rowspan="2" class="text-center"><?php echo display('Net Sq.Ft');?></th>
                                          <th rowspan="2"  style="width:90px;" class="text-center"><?php echo display('Cost per Sq.Ft');?></th>
                                          <th rowspan="2"  style="width:90px;" class="text-center"><?php echo display('Cost per Slab');?></th>
                                          <th rowspan="2"  style="width:90px;" class="text-center"><?php echo display('sales'); ?><br/><?php echo display('Price per Sq.Ft');?></th>
                                          <th rowspan="2"  style="width:90px;" class="text-center"><?php echo display('Sales Slab Price');?></th>
                                          <th rowspan="2" class="text-center"><?php echo display('Weight');?></th>
                                          <th rowspan="2" class="text-center"><?php echo display('Origin');?></th>
                                          <th rowspan="2" style="width: 110px" class="text-center"><?php  echo  display('total'); ?></th>
                                          <th rowspan="2" class="text-center"><?php  echo  display('action'); ?></th>
                                       </tr>
                                       <tr>
                                          <th class="text-center btnclr"><?php echo display('Width');?></th>
                                          <th class="text-center btnclr"><?php echo display('Height');?></th>
                                          <th class="text-center btnclr"  ><?php echo display('Width');?></th>
                                          <th class="text-center btnclr" ><?php echo display('Height');?></th>
                                       </tr>
                                    </thead>
                                    <tbody id="addPurchaseItem_1">
                                       <tr>
                                          <td>
                                             <input type="hidden" class="table_id" name="tableid[]" id="tableid_1"/>

                                             <input list="magicHouses" name="prodt[]" id="prodt_1"   class="form-control product_name"  style="width:160px;" placeholder="Search Product" />

                                             <datalist id="magicHouses">
                                                <?php 
                                                   foreach($product_list as $tx){?>
                                                <option value="<?php echo $tx['product_name'].'-'.$tx['product_model'];?>">  <?php echo $tx['product_name'].'-'.$tx['product_model'];  ?></option>
                                                <?php } ?>
                                             </datalist>
                                             <input type='hidden' class='common_product autocomplete_hidden_value  product_id_1' name='product_id[]' id='product_id_1' />
                                          </td>
                                          <td>
                                             <input type="text" id="bundle_no_1" name="bundle_no[]"  class="bundle_no form-control" />
                                          </td>
                                          <td>
                                             <input type="text" id="description_1" name="description[]" class="form-control productDescription" />
                                          </td>
                                          <td >
                                             <input type="text" name="thickness[]" style="width:50px;" id="thickness_1" class="form-control productThickness"/>
                                          </td>
                                          <td>
                                             <input type="text" id="supplier_b_no_1" name="supplier_block_no[]"  class="form-control" />
                                          </td>
                                          <td >
                                             <input type="text"  id="supplier_s_no_1" name="supplier_slab_no[]"  class="form-control"/>
                                          </td>
                                          <td>
                                             <input type="text" id="gross_width_1" name="gross_width[]"  class="gross_width  form-control" />
                                          </td>
                                          <td>
                                             <input type="text" id="gross_height_1" name="gross_height[]"   class="gross_height form-control" />
                                          </td>
                                          <td >
                                             <input type="text"   style="width:60px;" readonly id="gross_sq_ft_1" name="gross_sq_ft[]" class="gross_sq_ft form-control"/>
                                          </td>
                                          <td style="text-align:center;" >
                                             <input type="text"   style="width:20px;" value="1" class="slab_no" id="slab_no_1" name="slab_no[]"  readonly  /> 
                                          </td>
                                          <td>
                                             <input type="text" id="net_width_1" name="net_width[]"  class="net_width form-control" />
                                          </td>
                                          <td>
                                             <input type="text" id="net_height_1" name="net_height[]"   class="net_height form-control" />
                                          </td>
                                          <td >
                                             <input type="text"   style="width:60px;" readonly id="net_sq_ft_1" name="net_sq_ft[]" class="net_sq_ft form-control"/>
                                          </td>
                                          <td>
                                            <input type="text" id="cost_sq_ft_1"  name="cost_sq_ft[]"     style="width:60px;" value="0.00"  class="cost_sq_ft form-control costPerSQFT">
                                          <td >
                                             <input type="text"  id="cost_sq_slab_1" name="cost_sq_slab[]" style="width:60px;" value="0.00"  class="cost_sq_slab form-control"/>
                                          </td>
                                          <td>
                                             <input type="text" id="sales_amt_sq_ft_1"  name="sales_amt_sq_ft[]"  style="width:70px;"  placeholder="0.00" class="sales_amt_sq_ft form-control" />
                                          </td>
                                          <td >
                                             <input type="text"  id="sales_slab_amt_1" name="sales_slab_amt[]"  style="width:70px;" placeholder="0.00"  class="sales_slab_amt form-control"/>
                                          </td>
                                          </span>
                                          </td>
                                          <td>
                                             <input type="text" id="weight_1" name="weight[]"  class="weight form-control" />
                                          </td>
                                          <td style="width: 135px;"> 
                                             <select id="origin_1" style="width:70px;" name="origin[]" class="origin form-control">
                                                <?php foreach ($country_code as $key => $value) { ?>
                                                <option value="<?php echo $value['iso']; ?>"><?php echo $value['iso']; ?></option>
                                                <?php } ?> 
                                             </select>
                                          </td>
                                          <td >
                                             <input  type="text" class="total_price form-control" style="width:80px;" readonly  value="0.00"  id="total_amt_1" name="total_amt[]"/>
                                          </td>
                                          <td style="text-align:center;">
                                             <button  class='btn btn-danger delete' id="delete_1" type='button' value='Delete' ><i class="fa fa-trash"></i></button>
                                          </td>
                                       </tr>
                                    </tbody>
                                    <tfoot>
                                       <tr>
                                          <td style="text-align:right;" colspan="8"><b><?php  echo display('Gross Sq.Ft');?> :</b></td>
                                          <td >
                                             <input type="text" id="overall_gross_1" name="overall_gross[]"   class="overall_gross form-control" style="width: 60px"  readonly="readonly"  /> 
                                          </td>
                                          <td style="text-align:right;" colspan="3"><b><?php  echo display('Net Sq.Ft');?> :</b></td>
                                          <td >
                                             <input type="text" id="overall_net_1" name="overall_net[]"  class="overall_net form-control"  style="width: 60px"  readonly="readonly"  /> 
                                          </td>
                                          <td >
                                             <input type="text" id="costpersqft_1" name="costpersqft[]"  class="costpersqft form-control"  style="width: 60px"  readonly="readonly"  /> 
                                          </td>
                                          <td >
                                             <input type="text" id="costperslab_1" name="costperslab[]"  class="costperslab form-control"  style="width: 60px"  readonly="readonly"  /> 
                                          </td>
                                          <td >
                                             <input type="text" id="salespricepersqft_1" name="salespricepersqft[]"  class="salespricepersqft form-control"  style="width: 60px"  readonly="readonly"  /> 
                                          </td>
                                          <td >
                                             <input type="text" id="salesslabprice_1" name="salesslabprice[]"  class="salesslabprice form-control"  style="width: 60px"  readonly="readonly"  /> 
                                          </td>
                                          <td >
                                             <input type="text" id="overall_weight_1" name="overall_weight[]"  class="overall_weight form-control"  style="width: 60px"  readonly="readonly"  /> 
                                          </td>
                                          <td style="text-align:right;" colspan="1"><b><?php  echo display('total'); ?> :</b></td>
                                          <td >
                                             <input type="text" id="Total_1" name="total[]"   class="b_total form-control"  style="width: 80px" value="0.00"  readonly="readonly"  /> 
                                          </td>
                                       </tr>
                                    </tfoot>
                                 </table>
                                 <i id="buddle_1" class="btnclr addbundle fa fa-plus" style=" padding: 10px 12px 10px 12px;margin-right: 18px;float:right;"   onclick="addbundle(); "aria-hidden="true"></i>
                              </div>
                            <table class="taxtab table table-bordered table-hover" style="border:2px solid #d7d4d6;" >
                        <tr>
                           <td class="hiden" style="width:20%;border:none;text-align:end;font-weight:bold;">
                              <?php echo display('Live Rate') ?> :
                           </td>
                           <td class="hiden btnclr" style="width:13%;text-align-last: center;padding:5px; border:none;font-weight:bold;color:white;">1 <?php echo $curn_info_default; ?>
                              = <input style="width: 80px;text-align:center;color:black;padding:5px;" type="text" class="custocurrency_rate"/>&nbsp;<label for="custocurrency" id="currencyLabel" ></label>
                           </td>
                           <td style="border:none;text-align:right;font-weight:bold;"><?php echo display('Tax') ?> :
                           </td>
                           <td style="width:12%">
                           <input list="magic_tax" name="tx"  id="product_tax" class="form-control"   onchange="this.blur();" />
                              <datalist id="magic_tax">
                                 <?php
foreach ($tax_data as $tx) {?>
                                 <option value="<?php echo $tx['tax_id'] . '-' . $tx['tax'] . '%'; ?>">  <?php echo $tx['tax_id'] . '-' . $tx['tax'] . '%'; ?></option>
                                 <?php }?>
                              </datalist>
                           </td>
                           <td  style="width:20%;"><a href="#" class="client-add-btn btn btnclr" aria-hidden="true" style="color:white;  margin-right: 295px;"  data-toggle="modal" data-target="#tax_info" ><i class="fa fa-plus"></i></a></td>
                        </tr>
                     </table>
                  <table border="0" style="width: 100%; border-collapse: collapse; text-align: left;" class="overall table table-bordered table-hover" style="border:2px solid #d7d4d6;">
    <tbody>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="Over_all_Total"><b><?php echo display('Overall TOTAL') ?> :</b></label>
                <input type="text" id="Over_all_Total" name="Over_all_Total" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" value="0.00" readonly="readonly" />
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
                <label style="width:150px;" for="total_gross"><b><?php echo display('Overall Gross Sq.Ft') ?> :</b></label>
                <input type="text" id="total_gross" name="total_gross" value="0.00" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" readonly="readonly" />
            </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
              <label style="width:150px;" for="gtotal"><b><?php echo display('GRAND TOTAL') ?> :</b></label>
                <input type="text" id="gtotal" name="gtotal" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" value="0.00" readonly="readonly" />
            </td>
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="total_net"><b><?php echo display('Overall Net Sq.Ft') ?> :</b></label>
                <input type="text" id="total_net" name="total_net" class="form-control" value="0.00" style="width: 150px; margin-left: 10px; display: inline-block;" readonly="readonly" />
            </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                  <label style="width:150px;" for="customer_gtotal"><b><?php echo display('Preferred Currency') ?> :</b></label>
                <input type="text" id="customer_gtotal" name="customer_gtotal" class="form-control" value="0.00" style="width: 150px; margin-left: 10px; display: inline-block;" readonly />
          </td>
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="total_weight"><b><?php echo display('Overall Weight') ?> :</b></label>
                <input type="text" id="total_weight" name="total_weight" class="form-control" value="0.00" style="width: 150px; margin-left: 10px; display: inline-block;" readonly="readonly" />
            </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="amount_paid"><b><?php echo display('Amount Paid') ?> :</b></label>
                <input type="text" id="amount_paid" name="amount_paid" class="form-control" value="0.00" style="width: 150px; margin-left: 10px; display: inline-block;" readonly />
         </td>
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
             </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="balance"><b><?php echo display('Balance Amount') ?> :</b></label>
                <input type="text" id="balance" name="balance" class="form-control" value="0.00" style="width: 150px; margin-left: 10px; display: inline-block;" readonly />
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr style="border-right:none; border-left:none; border-bottom:none; border-top:none;">
            <td colspan="2" style="text-align: right; padding: 20px;">
         
              <a class="client-add-btn btn btnclr" aria-hidden="true" id="paypls" data-toggle="modal" data-target="#payment_modal">
                        Make Payment
             </a>
            </td>
        </tr>
    </tfoot>
</table>
</div>
                            
            
                           <div class="row">
                              <div class="col-sm-12">
                                 <div class="form-group row">
                                    <label for="adress" class="col-sm-2 col-form-label"><?php echo  display('Remarks / Details');?>
                                    </label>
                                    <div class="col-sm-10">
                                       <textarea class="form-control" rows="4" cols="50" id="remark" name="remark"  style="border:2px solid #d7d4d6;"  placeholder="Remarks" rows="1"></textarea>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-12">
                                 <div class="form-group row">
                                    <label for="adress" class="col-sm-2 col-form-label"><?php echo  display('Message on Invoice');?>
                                    </label>
                                    <div class="col-sm-10">
                                       <textarea class="form-control" rows="4" cols="50" id="adress" name="message_invoice"  style="border:2px solid #d7d4d6;"  placeholder="Message on Invoice" rows="1"></textarea>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-12">
                                 <div class="form-group row" style="   margin-top: 1%;">
                                    <table>
                                       <tr>

                                        <!-- <td>
                                 <input type="submit" id="add_purchase" name="add_purchase"     class="btnclr btn" value="<?php// echo display('save') ?>">
                                 <a     id="final_submit_provider" class='btnclr final_submit_provider btn  '><?php //echo display('submit'); ?></a>
                                 <a id="download_provider"  class='btn  btnclr'><?php  //echo  display('download'); ?></a>
                                 <a id="print_provider"    class='btn  btnclr'><?php  //echo  display('print'); ?></a>                   
                              </td> -->

                                          <td style="width:140px;">
                                             <input type="submit" id="add_purchase"   class="btnclr btn btn-large" name="add-packing-list" value="<?php  echo  display('save'); ?>" />
                                        
                                             <a id="final_submit" class='btnclr final_submit btn'><?php echo display('submit'); ?></a>
                                       </td> <td>
                                         
                                             <select name="download_select" id="download_select" class="form-control btnclr" style="background-color:<?php echo $setting_detail[0]['button_color']; ?>;width: auto;color:white;" >
                                                <option value="Download"  selected><?php echo display('download'); ?></option>
                                                <option value="Invoice" ><?php echo  display('New Invoice');?></option>
                                                <option value="Packing" ><?php echo  display('Packing List');?></option>
                                             </select>
                                     </td>
                                        <td>
                                        
                                             <select name="print_select" id="print_select" class="form-control btnclr" style="background-color:<?php echo $setting_detail[0]['button_color']; ?>;width: auto;color:white;" >
                                                <option value="Print"  selected><?php echo display('print');  ?></option>
                                                <option value="Invoice" ><?php echo  display('New Invoice');?></option>
                                                <option value="Packing" ><?php echo  display('Packing List');?></option>
                                             </select>
</td>  </td>
                                       </tr>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                    <div id="service_provider_data">
                     
                     <div id="errormessage_service_provider" > </div>
                        <div class="panel-body">
                           <form id="serviceprovider"  method="post">
                              <div class="row">
                                 <div class="col-sm-6">
                                    <div class="form-group row">
                                       <label for="service_provider_name" class="col-sm-4 col-form-label"><?php  echo  display('Service Provider Name');?>
                                       <i class="text-danger">*</i>
                                       </label>
                                       <div class="col-sm-8">
                                          <select name="service_provider_name" id="service_supplier_name" class="form-control service_provider_name"    style="border:2px solid #d7d4d6;width:100%;"   required=""  tabindex="1">
                                            <option value="" selected disabled><?php echo display('select_one') ?></option>
                                        <?php  if($supplier_list) {  ?> 
                                            {supplier_list}
                                          <option value="{supplier_id}">{supplier_name}</option>
                                          {/supplier_list}
                                          <?php  }  ?>
                                           </select>
                                       </div>
                                    </div>
                                 </div>
                                  <input type="hidden" name="makepaymentProvider" id="makepaymentProvider">
                                  <input type="hidden" name="admin_company_id" id="admin_company_id" value="<?php  echo $_GET['id']; ?>" />
                                 <div class="col-sm-6">
                                    <div class="form-group row">
                                       <label for="sp_address" class="col-sm-4 col-form-label"><?php  echo  ('Service Provider Address');?>
                                       <i class="text-danger"></i>
                                       </label>
                                       <div class="col-sm-8">
                                          <input type="text" tabindex="3" readonly class="form-control sp_address" name="sp_address" style="border:2px solid #d7d4d6;"  id="sp_address"  />
                                          <div id="loadingText" class="loading-text"></div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-sm-6">
                                    <div class="form-group row">
                                    <label for="bill_date" class="col-sm-4 col-form-label"><?php  echo  display('Bill Date');?>
                                       <i class="text-danger">*</i>
                                       </label>
                                       <div class="col-sm-8">
                                          <?php $billdate = date('Y-m-d'); ?>
                                          <input type="date" tabindex="2" class="form-control servicebill_date" name="bill_date" id="bill_date" value="<?php echo $billdate; ?>"  style="border:2px solid #d7d4d6;"  required/>
                                          <div id="loadingText" class="loading-text"></div>
                                       </div>
                                    </div>
                                 </div>


                                 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                               
                               
                                 <div class="col-sm-6">
                                   

                                    <div class="form-group row">
                                       <label for="bill_number" class="col-sm-4 col-form-label"><?php  echo  display('Bill Number');?> <i class="text-danger">*</i>
                                       </label>
                                       <div class="col-sm-8">
                                          <input type="text" required tabindex="2" class="form-control bill_number" name="bill_num"  id="bill_number"  style="border:2px solid #d7d4d6;"   required="" />
                                          <div id="loadingText" class="loading-text"></div>
                                       </div>
                                    </div>


                                 </div>
                              </div>


                              
                              <div class="row">
                                 <div class="col-sm-6">
                                    <div class="form-group row">
                                     
                                    <label for="payment_terms" class="col-sm-4 col-form-label"><?php  echo  display('Payment Terms');?><i class="text-danger">*</i></label>
                                       <div class="col-sm-7">
                                          <select   name="pay_terms" id="payment_terms" style="width:100%;border:2px solid #d7d4d6;" class=" form-control" required placeholder='Payment Terms' id="payment_terms">
                                             <option value=""><?php echo display('Select Payment Terms');?></option>
                                             <option value="CAD">CAD</option>
                                             <option value="COD">COD</option>
                                             <option value="ADVANCE"><?php echo display('ADVANCE');?></option>
                                             <option value="7DAYS">7<?php echo display('DAYS');?></option>
                                             <option value="15DAYS">15<?php echo display('DAYS');?></option>
                                             <option value="30DAYS">30<?php echo display('DAYS');?></option>
                                             <option value="45DAYS">45<?php echo display('DAYS');?></option>
                                             <option value="60DAYS">60<?php echo display('DAYS');?></option>
                                             <option value="75DAYS">75<?php echo display('DAYS');?></option>
                                             <option value="90DAYS">90<?php echo display('DAYS');?></option>
                                             <option value="180DAYS">180<?php echo display('DAYS');?></option>
                                             <?php foreach($payment_terms as $inv){ ?>
                                             <option value="<?php echo $inv['payment_terms'] ; ?>"><?php echo $inv['payment_terms'] ; ?></option>
                                             <?php    }?>
                                          </select>
                                       </div>
                                       <div class="col-sm-1">
                                          <a href="#" class="btnclr client-add-btn btn mobile_vendor" aria-hidden="true"    data-toggle="modal" data-target="#payment_type_new" ><i class="fa fa-plus"></i></a>
                                       </div>



                                    </div>
                                 </div>


                                 <div class="col-sm-6">
                                 <div class="form-group row">
                                       <label for="bill_number" class="col-sm-4 col-form-label"><?php  echo  ('Phone Number');?> <i class="text-danger"></i>
                                       </label>
                                       <div class="col-sm-8">
                                          <input type="number"  tabindex="2" class="form-control phone_num" name="phone_num" style="border:2px solid #d7d4d6;"   id="phone_num"  />
                                          <div id="loadingText" class="loading-text"></div>
                                       </div>
                                    </div>


                                 </div> 
                              </div>







                              <div class="row">
                                 <div class="col-sm-6">
                                    <div class="form-group row">
                                       <label for="bill_date" class="col-sm-4 col-form-label"><?php echo  display('Account Category') ;?>
                                       <i class="text-danger"></i>
                                       </label>
                                       <div class="col-sm-8">
                                             <select id="ddl"  name="acc_cat_name" class="form-control"   style="border:2px solid #d7d4d6;" onchange="configureDropDownLists(this,document.getElementById('ddl3'))">
                                             <option value="">Select the Account Category</option>
                                             		<?php
											foreach(ACC_NAME as $acc_name){
												echo '<option value="'.$acc_name.'">'.$acc_name.'</option>';
											}
											?>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-6">
                                    <div class="form-group row">
                                       <label for="due_date" class="col-sm-4 col-form-label"><?php echo  display('Account Sub Category');?>
                                       <i class="text-danger"></i>    
                                       </label>
                                       <div class="col-sm-8">
                                          <select class="form-control" name="acc_cat" style="border:2px solid #d7d4d6;"  id="ddl3">
                                             <option value="Select Sub Category"><?php echo display('Select Sub Category') ?></option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-sm-6">
                                    <div class="form-group row">
                                       <label for="bill_date" class="col-sm-4 col-form-label"><?php  echo  display('Account Sub category');?>
                                       <i class="text-danger"></i>
                                       </label>
                                       <div class="col-sm-8">
                                          <input type="text" tabindex="2" class="form-control"  style="border:2px solid #d7d4d6;" name="acc_sub_name" id="acc_sub_name" />
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="table-responsive">
                                 <table class="table table-bordered table-hover serviceprovider" id="service_1" style="border:2px solid #d7d4d6;" >
                                    <thead>
                                       <tr>
                                          <th class="text-center" width="20%"><?php  echo  ('Product Name');?><i class="text-danger">*</i></th>
                                          <th class="text-center" width="30%"><?php  echo  display('description'); ?><i class="text-danger">*</i></th>
                                          <th class="text-center" width="20%"><?php  echo  ('Quantity');?><i class="text-danger">*</i></th>
                                          <th class="text-center" width="20%"><?php echo display('amount'); ?><i class="text-danger">*</i></th>
                                          <th class="text-center" width="20%"><?php echo display('action') ?></th>
                                       </tr>
                                    </thead>
                                    <tbody id="servic_pro">
                                       <tr class="Deleteallrowsserviceprovider">
                                          <td class="span3 supplier">
                                             <input type="hidden" class="table_id" name="tableid[]" id="tableid_1"/>
                                             <input  list="magicHouses" type="text"  tabindex="2" class="acc_name form-control product_name" name="product_name[]"  id="product_1"/>
                                             <datalist id="magicHouses">
                                                <?php 
                                                   foreach($product_list as $tx){?>
                                                <option value="<?php echo $tx['product_name'].'-'.$tx['product_model'];?>">  <?php echo $tx['product_name'].'-'.$tx['product_model'];  ?></option>
                                                <?php } ?>
                                             </datalist>
                                             <input type='hidden' class='common_product autocomplete_hidden_value  product_id_1' name='product_id[]' id='product_id_1' />
                                          </td>
                                          <td class="wt">
                                             <input type="text" name="description_service[]" id="description_1" class="form-control text-right store_cal_1"   placeholder="" value=""  tabindex="6"/>
                                          </td>
                                          <td class="text-right">
                                             <input type="text" name="quality[]" id="quality_1"  min="0" class="form-control text-right productQTY" value=""  tabindex="6"/>
                                          </td>
                                          <td>
                                             <input class="total_price_provider form-control mobile_price productAMOUNT" type="text"  style="width: 317px;"  name="total_price[]" id="total_price_1"  placeholder="0.00"  />
                                          </td>
                                          <td style="text-align:center;">
                                             <button  class='delete_provider btn btn-danger' type='button' value='Delete'><i class="fa fa-trash"></i></button>
                                          </td>
                                       </tr>
                                    </tbody>
                                    <tfoot>
                                       <tr style="height:50px;">
                                          <td style="text-align:right;" colspan="3" ><b><?php echo display('total') ?>:</b></td>
                                          <td style="text-align:left;">
                                          <input type="text" id="Total_provider" class="form-control mobile_price" placeholder="0.00"  style="width: 317px;"  min="0" name="total" value="<?php echo $total; ?>" /> 
                                          </td>
                                       </tr>
                                      <table class="taxtab table table-bordered table-hover" style="border:2px solid #d7d4d6;" >
                        <tr>
                           <td class="hiden" style="width:20%;border:none;text-align:end;font-weight:bold;">
                              <?php echo display('Live Rate') ?> :
                           </td>
                           <td class="hiden btnclr" style="width:13%;text-align-last: center;padding:5px; border:none;font-weight:bold;color:white;">1 <?php echo $curn_info_default; ?>
                              = <input style="width: 80px;text-align:center;color:black;padding:5px;" type="text" class="custocurrency_rate_provider"/>&nbsp;<label for="custocurrency"  ></label>
                           </td>
                           <td style="border:none;text-align:right;font-weight:bold;"><?php echo display('Tax') ?> :
                           </td>
                           <td style="width:12%">
                           <input list="magic_tax" name="tx"  id="product_tax_provider" class="form-control"   onchange="this.blur();" />
                              <datalist id="magic_tax">
                                 <?php
foreach ($tax_data as $tx) {?>
                                 <option value="<?php echo $tx['tax_id'] . '-' . $tx['tax'] . '%'; ?>">  <?php echo $tx['tax_id'] . '-' . $tx['tax'] . '%'; ?></option>
                                 <?php }?>
                              </datalist>
                           </td>
                           <td  style="width:20%;"><a href="#" class="client-add-btn btn btnclr" aria-hidden="true" style="color:white;  margin-right: 295px;"  data-toggle="modal" data-target="#tax_info" ><i class="fa fa-plus"></i></a></td>
                        </tr>
                     </table>
                   <table border="0" style="width: 100%; border-collapse: collapse; text-align: left;" class="overall table table-bordered table-hover" style="border:2px solid #d7d4d6;">
    <tbody>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
              </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="tax_details"><b><?php echo display('TAX DETAILS') ?> :</b></label>
                <input type="text" id="tax_details_provider" name="tax_details" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" value="0.00" readonly="readonly" />
          
            </td>
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                 </td>
            <!-- Right Side -->
          
                <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
              <label style="width:150px;" for="gtotal"><b><?php echo display('GRAND TOTAL') ?> :</b></label>
                <input type="text" id="gtotal_provider" name="gtotal" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" value="0.00" readonly="readonly" />
            </td>
         
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                 </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                  <label style="width:150px;" for="customer_gtotal"><b><?php echo display('Preferred Currency') ?> :</b></label>
                <input type="text" id="customer_gtotal_provider" name="customer_gtotal" class="form-control" value="0.00" style="width: 150px; margin-left: 10px; display: inline-block;" readonly />
          </td>
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="amount_paid"><b><?php echo display('Amount Paid') ?> :</b></label>
                <input type="text" id="amount_paid_provider" name="amount_paid" class="form-control" value="0.00" style="width: 150px; margin-left: 10px; display: inline-block;" readonly />
         </td>
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
             </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="balance"><b><?php echo display('Balance Amount') ?> :</b></label>
                <input type="text" id="balance_provider" name="balance" class="form-control" value="0.00" style="width: 150px; margin-left: 10px; display: inline-block;" readonly />
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr style="border-right:none; border-left:none; border-bottom:none; border-top:none;">
            <td colspan="2" style="text-align: right; padding: 20px;">
         
              <a class="client-add-btn btn btnclr" aria-hidden="true" id="paypls_provider" data-toggle="modal" data-target="#payment_modal">
                        Make Payment
             </a>
            </td>
        </tr>
    </tfoot>
</table>
                              </div>
                              <div class="form-group row">
                                 <label for="remarks" class="col-sm-2 col-form-label"><?php echo display('Memo / Details');?></label>
                                 <div class="col-sm-8">
                                    <textarea rows="4" cols="50" name="memo_details" class=" form-control"   style="border:2px solid #d7d4d6;"         placeholder="Memo/Details" id=""></textarea>
                                 </div>
                              </div>
                              <td>
                                 <input type="submit" id="add_purchase" name="add_purchase"     class="btnclr btn" value="<?php echo display('save') ?>">
                                 <a     id="final_submit_provider" class='btnclr final_submit_provider btn  '><?php echo display('submit'); ?></a>
                                 <a id="download_provider"  class='btn  btnclr'><?php  echo  display('download'); ?></a>
                                 <a id="print_provider"    class='btn  btnclr'><?php  echo  display('print'); ?></a>                   
                              </td>
                           </form>
                        </div>
                     </div>
 </div> </div> </div></div> </div>
<input type="hidden" id="Final_invoice_number" /> 
<input type="hidden" id="Final_invoice_id" /> 

<script>
   $(document).ready(function(){
  $('#main').hide();
    $('#expense_drop').hide();
   });


$(document).on('change', '#module_selection', function (e) {
    if ($('#module_selection').val() === "New Expense") {
        $('#service_provider_data').hide();
        $('.with_po').hide();
        $('.without_po').show();
        $('#main').show();
     
      var tid=$('.table').closest('table').attr('id');
   const indexLast = tid.lastIndexOf('_');
   var id = tid.slice(indexLast + 1);

   $('#addPurchaseItem_1 select').each(function() {
            if ($(this).data('select2')) {
                $(this).select2('destroy');
            }
        });

   for (j = 0; j < 6; j++) {
   
var $last = $('#addPurchaseItem_1 tr:last');
var num = id + ($last.index() + 1);
$last.clone().find('input,select,button').each(function() {
    var currentId = $(this).attr('id');
    if (currentId) {
        $(this).attr('id', function(i, current) {
            return current.replace(/\d+$/, num);
        });
    }
}).end().appendTo('#addPurchaseItem_1');
    $.each($('#normalinvoice_1 > tbody > tr'), function (index, el) {
      
           $(this).find(".slab_no").val(index + 1); // Simply couse the first "prototype" is not counted in the list
       })
       
   }
$('#normalinvoice_1 > tbody > tr').each(function() {
    var $row = $(this);
    
    // Find select2 elements in the current row
    var $selects = $row.find('.select2');
    
    // Destroy select2 instance if it exists
    $selects.each(function() {
        var $select = $(this);
        if ($select.data('select2')) {
            $select.select2('destroy');
        }
    });

    // Reinitialize select2
    $selects.select2();
});

        var data = {
            expense_drop: $('#expense_drop').val()
        };
    } else if ($('#module_selection').val() === "serviceProvider") {
        $('#service_provider_data').show();
        $('.without_po').hide();
        $('.with_po').hide();
        $('#expense_drop').hide();
        $('#main').show();

  var data = {
            po: $('#module_selection').val()
        };
    } else {
      $('#ocrserviceprovider').hide();
         $('#form_image').hide();
      
        $('#main').show();
        $('#service_provider_data').hide();
        $('.with_po').show();
        $('.without_po').hide();

        var data = {
            po: $('#module_selection').val(),
            admin_company_id: $('#admin_company_id').val()
        };
        
        data[csrfName] = csrfHash;
        $('#purchaseLoading').show();
        $.ajax({
            url: '<?php echo base_url();?>Cpurchase/get_po_details',
            method: 'POST',
            data: data,
            dataType: "html"
        }).done(function (data) {
         $('#purchaseLoading').hide();
            var obj = $(data);
            $("#insert_purchase").html(obj.find("#insert_purchase").html());
                  $(".normalinvoice").each(function(i,v){
                      var tableId = $(this).closest('table').attr('id');
    updateTableTotals(tableId);
  updateOverallTotals(true);
if($(this).find("tbody").html().trim().length === 0){
           $(this).hide()
       }
    })
 getSupplierInfo($('#supplier_id').val());
        }).fail(function (jqXHR, textStatus, errorThrown) {
           $('#purchaseLoading').hide();
            console.error('AJAX request failed: ' + textStatus + ', ' + errorThrown);
        });
    }
});



function getSupplierInfo(supplier_id){

      var data = {
   value: supplier_id
   };
   data[csrfName] = csrfHash;
   $.ajax({
   type:'POST',
   data: data,
   dataType:"json",
   url:'<?php echo base_url();?>Cinvoice/getvendor',
   success: function(result, statut) {
    if(result.csrfName){
   
       csrfName = result.csrfName;
       csrfHash = result.csrfHash;
    }
    var custo_currency = result[0]['currency_type'];
   $(".cus").html(custo_currency);
   $("label[for='custocurrency']").html(custo_currency);
   $.getJSON('https://open.er-api.com/v6/latest/<?php echo $curn_info_default; ?>', function(data) {
                var x = data['rates'][custo_currency];
                var Rate = parseFloat(x).toFixed(2);
                Rate = isNaN(Rate) ? 0 : Rate;
                 $('.hiden').show();
                 $('#vendor_type_details').val(result[0]['vendor_type']);
                 $('#vendor_add').val(result[0]['address']);
                 $('#sp_address').val(result[0]['address']);
                $(".custocurrency_rate").val(Rate);
                  $(".custocurrency_rate_provider").val(Rate);
            });


   }
   });
}
   $('#supplier_id').on('change', function (e) {getSupplierInfo($(this).val())});
     $('#service_supplier_name').on('change', function (e) {getSupplierInfo($(this).val())});
       $('#payment_terms').change(function(){
                      $('#payment_due_date').val('');
                 var sd = $(this).val().replace(/[^0-9]/gi, ''); 
               var number = parseInt(sd, 10);
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
                             $('#payment_due_date').val(result);
                         }
                      });
                  });

                  
                   $(document).on('click', '.removebundle', function(){
                     var remove_id=$(this).closest('table').attr('id');
                     $('#'+remove_id).remove();
                     updateOverallTotals(true);
                     });

 $('#product_tax').on('change', function (e) {
        var total=$('#Over_all_Total').val();
                var tax= $('#product_tax').val();
                var percent='';
                 var hypen='-';
               if(tax.indexOf(hypen) != -1){
                var field = tax.split('-');
               
                var percent = field[1];
               
               }else{
               percent=tax;
               }
               
                percent=percent.replace("%","");
                 var answer = (percent / 100) * parseFloat(total);
                var final_g= $('#final_gtotal').val();
                var amt=parseFloat(answer)+parseFloat(total);
                 var num = isNaN(parseFloat(amt)) ? 0 : parseFloat(amt);
                  var additional_cost =parseFloat($('#additional_cost').val()) || 0;
                   $('#gtotal').val((num+additional_cost).toFixed(2)); 
                    var paid_amount =parseFloat($('#amount_paid').val()) || 0;
                   
                 var custo_amt=$('.custocurrency_rate').val(); 
                 console.log("numhere :"+num +"-"+custo_amt);
                 var value=(num+additional_cost)*custo_amt;
                 var custo_final = isNaN(parseFloat(value)) ? 0 : parseFloat(value);
                   var balance_amount= (num+additional_cost)- paid_amount;
                  $('#tax_details').val(answer.toFixed(2) +" ( "+tax+" )");
                $('#customer_gtotal').val(custo_final.toFixed(2));  
                  $('#balance').val(balance_amount.toFixed(2));
                  $('#balance_customer_currency').val((balance_amount*custo_amt).toFixed(2));
                   $('#paid_customer_currency').val((paid_amount*custo_amt).toFixed(2));
          updateOverallTotals();
                });
                $('#paypls').on('click',function(){
$('#amount_to_pay').val($('#balance').val());
$('#custocurrencyrate').val($('.custocurrency_rate').val());
});
$('.paypls').on('click',function(){debugger;
$('#amount_to_pay').val($('#balance').val());
});
$.validator.addMethod('isfNoRequired', function(value, element, param) {
    var isfField = $('select[name="isf_field"]').val();
    return isfField != '2' || $.trim(value).length > 0;
}, 'ISF No is required when ISF Field is YES.');


$("#insert_expense").validate({

   rules: {
    supplier_id: "required",
    invoice_no: "required", 
    payment_due_date : "required", 
    bill_date : "required",
    payment_terms: "required",  
    paytype_drop : "required",
     isf_no: {
            isfNoRequired: true
        }
 },
 messages: {
     supplier_id: "Supplier Name is required",
    invoice_no: "Invoice Number is required",
    payment_terms: "Payment Term is required",
    paytype_drop: "Payment Type is required",
      payment_due_date: "Payment Due Date is required",
      bill_date: "Bill Date is required",
       isf_no: "ISF No is required when ISF Field is YES.",
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
    type: "POST",
    dataType: "json",
    url:"<?php echo base_url(); ?>Cpurchase/insert_purchase",
    data: formData,
    contentType: false,
    processData: false,
    success: function(response) {
   
      console.log(response);
    if (response.status == 'success') {

   $('.errormessage_expense').html('<div class="alert alert-success">' + response.msg + '</div>');
     $('#Final_invoice_number').val(response.invoice_no);
          $('#Final_invoice_id').val(response.invoice_id);
         
                  }else{

          $('.errormessage_expense').html(failalert+response.msg+'</div>'); 
          console.log(response.msg, "Error");
       }                  
    },
        error: function(xhr, status, error) {
        alert('An error occurred: ' + error);
    }
  })
}
});

$("#insert_purchase").validate({
   rules: {
    supplier_id: "required",
    invoice_no: "required", 
    payment_due_date : "required", 
    bill_date : "required",
    payment_terms: "required",  
    paytype_drop : "required",
     isf_no: {
            isfNoRequired: true
        }
 },
 messages: {
     supplier_id: "Supplier Name is required",
    invoice_no: "Invoice Number is required",
    payment_terms: "Payment Term is required",
    paytype_drop: "Payment Type is required",
      payment_due_date: "Payment Due Date is required",
      bill_date: "Bill Date is required",
       isf_no: "ISF No is required when ISF Field is YES.",
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
    type: "POST",
    dataType: "json",
    url:"<?php echo base_url(); ?>Cpurchase/insert_purchase",
    data: formData,
    contentType: false,
    processData: false,
    success: function(response) {
   
      console.log(response);
    if (response.status == 'success') {

   $('.errormessage_expense').html('<div class="alert alert-success">' + response.msg + '</div>');
     $('#Final_invoice_number').val(response.invoice_no);
          $('#Final_invoice_id').val(response.invoice_id);
         
                  }else{

          $('.errormessage_expense').html(failalert+response.msg+'</div>'); 
          console.log(response.msg, "Error");
       }                  
    },
        error: function(xhr, status, error) {
        alert('An error occurred: ' + error);
    }
  })
}
});

// // Purchase Section Insert 
// $("#insert_purchase").validate({
//    rules: {
//     supplier_id: "required",
//     invoice_no: "required", 
//     payment_due_date : "required", 
//     bill_date : "required",
//     payment_terms: "required",  
//     paytype_drop : "required",
//      isf_no: {
//             isfNoRequired: true
//         }
//  },
//  messages: {
//      supplier_id: "Supplier Name is required",
//     invoice_no: "Invoice Number is required",
//     payment_terms: "Payment Term is required",
//     paytype_drop: "Payment Type is required",
//       payment_due_date: "Payment Due Date is required",
//       bill_date: "Bill Date is required",
//        isf_no: "ISF No is required when ISF Field is YES.",
//  },
//     errorPlacement: function(error, element) {
//             if (element.hasClass("select2-hidden-accessible")) {
//                 error.insertAfter(element.next('span.select2')); 
//             } else {
//                 error.insertAfter(element);
//             }
//         },
// submitHandler: function(form) {
//   var formData = new FormData(form);
//   formData.append(csrfName, csrfHash);
//   $.ajax({
//     type: "POST",
//     dataType: "json",
//     url:"<?php echo base_url(); ?>Cpurchase/insert_purchase",
//     data: formData,
//     contentType: false,
//     processData: false,
//     success: function(response) {
   
//       console.log(response);
//     if (response.status == 'success') {

//    $('.errormessage_expense').html('<div class="alert alert-success">' + response.msg + '</div>');
//      $('#Final_invoice_number').val(response.invoice_no);
//           $('#Final_invoice_id').val(response.invoice_id);
         
//                   }else{

//           $('.errormessage_expense').html(failalert+response.msg+'</div>'); 
//           console.log(response.msg, "Error");
//        }                  
//     },
//         error: function(xhr, status, error) {
//         alert('An error occurred: ' + error);
//     }
//   })
// }
// });



$(document).on('change', '.product_name', function(){
   
var product_id=$(this).closest('td').find('.common_product');
var table_id=$(this).closest('td').find('.table_id');
    var id= $(this).attr('id');
     var id_num = id.substring(id.indexOf('_') + 1);
     console.log(id_num);
     table_id.val(id_num);
      var pdt=$('#'+id).val();
      console.log(pdt);
      const myArray = pdt.split("-");
      var product_nam=myArray[0];
      var product_model=myArray[1];
     var data = {
          product_nam:product_nam,
          product_model:product_model
       };
       data[csrfName] = csrfHash;
       $.ajax({
           type:'POST',
           data: data,
           dataType:"json",
           url:'<?php echo base_url();?>Cinvoice/availability',
           success: function(result, statut) {
            console.log(result)
              // product_id.val(result[0]['product_id']);
            $("#product_id_"+ id_num).val(result[0]['product_id']);
           }
       });

    });


$(document).on('keyup','.normalinvoice tbody tr:last',function (e) {
   
   var tid=$(this).closest('table').attr('id');
   const indexLast = tid.lastIndexOf('_');
   var id = tid.slice(indexLast + 1);
   var $last = $('#addItem_'+id + ' tr:last');
   var num = id+($last.index()+1);
   $('#addItem_'+id  + ' tr:last').clone().find('input,select').attr('id', function(i, current) {
   return current.replace(/\d+$/, num);
   
   }).end().appendTo('#addItem_'+id );
   $.each($('#linvoice_'+id  +  '> tbody > tr'), function (index, el) {
      $(this).find(".slab_no").val(index + 1);      
   });
   });
    //Service Provider JS
      $(document).on('keyup','.serviceprovider tbody tr:last',function (e) {
   var tid=$(this).closest('table').attr('id');
   const indexLast = tid.lastIndexOf('_');
   var id = tid.slice(indexLast + 1);
   var $last = $('#servic_pro  tr:last');
   var num = id+($last.index()+1);
   $('#servic_pro tr:last').clone().find('input').attr('id', function(i, current) {
   return current.replace(/\d+$/, num);
   }).end().appendTo('#servic_pro');
  });
  function provider_calculation(){
  
  var sum = 0;
   $(".total_price_provider").each(function() {
   if(!isNaN(this.value) && this.value.length!=0) {
   sum += parseFloat(this.value);
   }
   });
   
   $("#Total_provider").val(sum.toFixed(2));
   var custocurrency=$('.custocurrency_rate_provider').val();


          if($('#product_tax_provider').val()) {
                var total=$('#Total_provider').val();
                var tax= $('#product_tax_provider').val();
                var percent='';
                 var hypen='-';
               if(tax.indexOf(hypen) != -1){  
                var field = tax.split('-');
               
                var percent = field[1];
               
               }else{
               percent=tax;
               }
               
                percent=percent.replace("%","");
                 var answer = (percent / 100) * parseFloat(total);
                   $('#tax_details_provider').val(answer.toFixed(2) +" ( "+tax+" )");
          }
             var tax_amount = answer || 0;
             $('#gtotal_provider').val((tax_amount+sum).toFixed(2));
             var gtotal=parseFloat($('#gtotal_provider').val()) || 0;
             var preferred_currency=gtotal * custocurrency;
             $('#customer_gtotal_provider').val(preferred_currency);
             var balance= parseFloat($('#gtotal_provider').val()-$('#amount_paid_provider').val());
             $('#balance_provider').val(balance.toFixed(2));
  
  }
  
     $(document).on('input','.total_price_provider',function (e) {
 provider_calculation();
   });
     $(document).on('change','#product_tax_provider',function (e) {
 provider_calculation();
   });
   $(document).on('click', '.delete_provider', function(){
var rowCount = $(this).closest('tbody').find('tr').length;
   if(rowCount>1){
   $(this).closest('tr').remove();
   }
   provider_calculation();
   });

   $("#serviceprovider").validate({
    rules: {
        service_provider_name: "required",
        bill_date: "required", 
        payment_terms: "required", 
        bill_num: "required",
        product_name: "required",
        'product_name[]': "required",
        'description_service[]': "required",
        'quality[]': {
            required: true,
            number: true,
            min: 0
        },
        'total_price[]': {
            required: true,
            number: true,
            min: 0
        }
    },
    messages: {
        service_provider_name: "Service Provider Name is required",
        bill_date: "Bill Date is required",
        bill_num: "Bill Number is required",
        payment_terms: "Payment Terms is required",
        'product_name[]': "Product Name is required",
        'description_service[]': "Description is required",
        'quality[]': {
            required: "Quantity is required",
            number: "Please enter a valid number",
            min: "Quantity cannot be negative"
        },
        'total_price[]': {
            required: "Amount is required",
            number: "Please enter a valid amount",
            min: "Amount cannot be negative"
        }
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
          type: "POST",
          dataType: "json",
          url:"<?php echo base_url(); ?>Cpurchase/insert_service_provider",
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) {
          debugger;
            console.log(response);
          if (response.status == 'success') {

            $('#errormessage_service_provider').html('<div class="alert alert-success">' + response.msg + '</div>');
            $('#Final_invoice_number').val(response.invoice_no);
            $('#Final_invoice_id').val(response.invoice_id);
               
         }else{
            $('#errormessage_service_provider').html(failalert+response.msg+'</div>'); 
            console.log(response.msg, "Error");
            }                  
         },
            error: function(xhr, status, error) {
            $('#errormessage_service_provider').html('<div class="alert alert-success">' + error + '</div>');
          }
        })
      }
});

 
$('#product_tax_provider').on('change', function (e) {
        var total=$('#Total_provider').val();
                var tax= $('#product_tax_provider').val();
                var percent='';
                 var hypen='-';
               if(tax.indexOf(hypen) != -1){
                var field = tax.split('-');
               
                var percent = field[1];
               
               }else{
               percent=tax;
               }
               
                percent=percent.replace("%","");
                 var answer = (percent / 100) * parseFloat(total);
                var amt=parseFloat(answer)+parseFloat(total);
                 var num = isNaN(parseFloat(amt)) ? 0 : parseFloat(amt);
              
                   $('#gtotal').val((num).toFixed(2)); 
                    var paid_amount =parseFloat($('#amount_paid').val()) || 0;
                   
                 var custo_amt=$('.custocurrency_rate').val(); 
                 console.log("numhere :"+num +"-"+custo_amt);
                 var value=(num)*custo_amt;
                 var custo_final = isNaN(parseFloat(value)) ? 0 : parseFloat(value);
                   var balance_amount= (num)- paid_amount;
                  $('#tax_details').val(answer.toFixed(2) +" ( "+tax+" )");
                $('#customer_gtotal').val(custo_final.toFixed(2));  
                  $('#balance').val(balance_amount.toFixed(2));
                  $('#balance_customer_currency').val((balance_amount*custo_amt).toFixed(2));
                   $('#paid_customer_currency').val((paid_amount*custo_amt).toFixed(2));
          updateOverallTotals();
                });

              $('#paypls_provider').on('click',function(){
$('#amount_to_pay').val($('#balance_provider').val());

});
   $('#final_submit_provider').on('click', function (e) {
      $('#errormessage_service_provider').html('<div class="alert alert-success">' + "<?php echo  ('Bill Number')." :";?>"+$('#Final_invoice_number').val()+"<?php echo  " ".display('has been saved Successfully');?>"+ '</div>');
 window.setTimeout(function(){
    window.location = "<?php  echo base_url(); ?>Cpurchase/manage_purchase?id=<?php echo $_GET['id']; ?>";
   }, 2500);
   
   });

     $('#final_submit').on('click', function (e) {

      $('.errormessage_expense').html('<div class="alert alert-success">' + "<?php echo  ('Invoice Number')." :";?>"+$('#Final_invoice_number').val()+"<?php echo  " ".display('has been saved Successfully');?>"+ '</div>');

     window.setTimeout(function(){
    window.location = "<?php  echo base_url(); ?>Cpurchase/manage_purchase?id=<?php echo $_GET['id']; ?>";
   }, 2500);
   
   });
      $('#isf_dropdown').on('change', function() {
     if ( this.value == '2')
        $(".isf_no1").show();
     else
       $(".isf_no1").hide();
   }).trigger("change");

// Change Dropdown
$(document).ready(function(){
   $('.getvaluedata').change(function() {
    var selectedValue = $(this).val();
    if(selectedValue == 'New Expense'){
      $('#addexpenses').show();
      $('#addserviceprovider').hide();
   }else{
      $('#addserviceprovider').show();
      $('#addexpenses').hide();
   }
   });
});

$(document).on('click', '#purchasefinal_submit', function (e) {
   window.location = "<?php  echo base_url(); ?>Cpurchase/manage_purchase?id=<?php echo $_GET['id']; ?>";
});


$(document).ready(function() {
       $('#form_image').change(function() {
        $('#ocr').submit();
    });
    $('#ocr').submit(function(e) {
        e.preventDefault(); 
        var formData = new FormData(this);
        $('.loading-text').show();
        $('.setocrimage').css('display', 'none');
        $.ajax({
            url: "<?php echo base_url(); ?>Cpurchase/process_form",
            type: 'POST',
            data: formData,
            contentType: false, 
            processData: false, 
            success: function(response) {
               console.log(response, "response");
               $('.loading-text').hide();
               $('.setocrimage').css('display', 'block');
               response = response.replace(/\\\//g, '/');
               response = response.replace(/\\n/g, '');
               response = response.replace(/\\u2018/g, '');
              var data = JSON.parse(response);
              console.log(data, 'data'); 
              var setuploadimagepath = '<?php echo base_url(); ?>uploads/' + data.getimagepath;
              var setuploadimage = data.getimagepath;
              console.log(setuploadimage, 'setuploadimage');
              var formattedDateString = data.bill_date.replace(/\//g, "-").replace(/\s+/g, "");
              var parts = formattedDateString.split("-");
               var day = parts[2];
               var month = parts[1];
               var year = parts[0];
               var formattedDate = day + "-" + month + "-" + year;
               var str = data.vendor_name.trim();
               var company_name = str.substring(str.indexOf("Graniti Tecnica"), str.indexOf("NATURAL STONETRADERS"));
               // var vendorAddress = data.vendor_address +" "+ data.vendor_address1 +" "+ data.vendor_address2;
               var vendorAddress = 'INFINITY STONES PIAZZA DEL MERACTO 18 FRASCATI ROME 00044 ITALY';
               var product_names = data.product_name
               var product_thickness = data.Thickness
               var product_descriptions = data.finish;
               var cosrpersqft = data.product_prices;
               var containernumber = data.container_no;

              var formattedDateStringETA = data.ETA_date.replace(/\//g, "-").replace(/\s+/g, "");
              var parts = formattedDateStringETA.split("-");
               var day = parts[2];
               var month = parts[1];
               var year = parts[0];

               var formattedDateETA = day + "-" + month + "-" + year;

               var formattedDateStringETD = data.ETD_date.replace(/\//g, "-").replace(/\s+/g, "");
               var parts = formattedDateStringETD.split("-");
               var day = parts[2];
               var month = parts[1];
               var year = parts[0];

               var formattedDateETD = day + "-" + month + "-" + year;

               // $('#invoice_no').val(data.bill_number.trim());
               $('#invoice_no').val('INV69937');
               $('#date').val('2023-11-28');
               $('.vendorAddress').val(vendorAddress);
               $('.productETA').val(formattedDateStringETA);
               $('.productETD').val(formattedDateStringETD);
               $('.container_no').val(containernumber);
               $('#setocrimage').attr('href', setuploadimagepath);
               $('#setocrimage').text(setuploadimage);
               $('.ocr_imageupload').val(setuploadimagepath);
               $('.product_name').each(function(index) {
                   $(this).val(product_names[index]);
               });

               $('.productThickness').each(function(index) {
                   $(this).val(product_thickness[index]);
               });

               $('.productDescription').each(function(index) {
                   $(this).val(product_descriptions[index]);
               });

               $('.costPerSQFT').each(function(index) {
                   $(this).val(cosrpersqft[index]);
               });

            },
            error: function(xhr, status, error) {
                // Handle error
               $('.loading-text').hide();
               // console.error("Error parsing JSON:", error);
            }
        });
    });
});


// Service Provider OCR

$(document).ready(function() {
       $('#form_imageservice').change(function() {
        // Submit the form when a file is selected
        $('#ocrserviceprovider').submit();
    });
    $('#ocrserviceprovider').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Create FormData object
        var formData = new FormData(this);
        $('.loading-text').show();
        $('.setocrimageservice').css('display', 'none');
        $.ajax({
            url: "<?php echo base_url(); ?>Cpurchase/serviceproviderprocess_form",
            type: 'POST',
            data: formData,
            contentType: false, 
            processData: false, 
            success: function(response) {
               console.log(response, "response");
               $('.loading-text').hide();
               $('.setocrimageservice').css('display', 'block');
               response = response.replace(/\\\//g, '/');
               response = response.replace(/\\n/g, '');
               response = response.replace(/\\u2018/g, '');
               var data = JSON.parse(response);
               console.log(data, "data");

               var setuploadimagepath = '<?php echo base_url(); ?>uploads/serviceprovider/' + data.getimagepath;
               var setuploadimage = data.getimagepath;
               console.log(setuploadimage, 'setuploadimage');

               var etaDate = data.billdate;
               var datePattern = /^\d{2}\/\d{2}\/\d{4}$/;

               console.log("etaDate:", etaDate); // Debugging statement

               if (datePattern.test(etaDate)) {
                   var parts = etaDate.split('/');
                   // var formattedETADate = parts[0] + '-' + parts[1] + '-' + parts[2];
                   var formattedETADate = parts[2] + '-' + parts[1] + '-' + parts[0]; 

                   console.log("formattedETADate:", formattedETADate); 

                   $('.servicebill_date').val(formattedETADate);
               } else {
                   console.error("Invalid ETD date format:", etaDate); 
               }

               var phoneNum = data.servicephoneno;
               var cleanedPhoneNum = phoneNum.replace("+1 ", "");

               var product_name = data.productName;
               var product_qty = data.pquantity;
               var product_total = data.amount;
               console.log(product_total, "product_total");

               for (let i = 0; i < product_qty.length; i++) {
                   let trElement = $(`
                       <tr>
                           <td class="span3 supplier">
                              <input type="hidden" name="tableid[]" id="tableid_1">
                              <input list="magicHouses" type="text" required="" tabindex="2" class="acc_name form-control productNAME" name="product_name[]" id="product_name" value="${product_name[i]}">
                                 <datalist id="magicHouses">
                                    <option value="Test Product-Model">  Test Product-Model</option>
                                 </datalist>
                                 <input type="hidden" class="common_product autocomplete_hidden_value  product_id_1" name="product_id[]" id="SchoolHiddenId_1">
                           </td>
                           <td>
                              <input type="text" name="description_service[]" id="description_1" required="" min="0" class="form-control text-right store_cal_1" placeholder="" value="" tabindex="6">
                           </td>
                           <td class="text-right">
                              <input type="text" name="quality[]" id="quality_1" required="" min="0" class="form-control text-right productQTY" value="${product_qty[i]}" tabindex="6">
                           </td>
                           <td>
                              <span class="input-symbol-euro"> <input class="total_price form-control mobile_price productAMOUNT" type="text" style="width: 317px;" value="${product_total[i]}" name="total_price[]" id="total_price_1" placeholder="0.00"></span>
                           </td>
                  
                           <td style="text-align:center;">
                              <button class="delete_provider btn btn-danger" type="button" value="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                           </td>
                       </tr>`
                   );
                   $('#servic_pro').append(trElement);
               }


               $('.Deleteallrowsserviceprovider').remove();

               $('.phone_num').val(cleanedPhoneNum);
               $('.bill_number').val(data.billnumber);

               $('#setocrimageservice').attr('href', setuploadimagepath);
               $('#setocrimageservice').text(setuploadimage);
               $('.ocr_imageuploadservice').val(setuploadimagepath);
               $('#bill_date').val('2024-02-22');
               $('.sp_address').val(data.serviceaddress);
            },
            error: function(xhr, status, error) {
                // Handle error
               $('.loading-text').hide();
               console.error("Error parsing JSON:", error);
            }
        });
    });
});
$(document).on('click', '.delete', function(){
   var $tableBody = $(this).closest('tbody');
    var rowCount = $tableBody.find('tr').length;
  if (rowCount > 1) {
        $(this).closest('tr').remove();
  updateTableTotals($tableBody.closest('table').attr('id'));
        updateOverallTotals(true);
    } else {

        $('.errormessage_expense').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + 'You cannot delete the last row. At least one row must remain..' + '</div>');

    }
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

   let dynamic_id=2;
   function addbundle(){
      debugger;
   //$(this).closest('table').find('.addbundle').css("display","none");
   $(this).closest('table').find('.removebundle').css("display","block");
   
   var newdiv = document.createElement('div');
   var tabin="crate_wrap_"+dynamic_id;
   
   newdiv = document.createElement("div");
   
   
   newdiv.innerHTML ='<table class="table normalinvoice table-bordered table-hover"     style="border:2px solid #d7d4d6;"               id="normalinvoice_'+ dynamic_id +'"> <thead> <tr class="btnclr"> <th rowspan="2" class="text-center" style="width: 170px;" ><?php echo display('product_name'); ?><i class="text-danger">*</i></th> <th rowspan="2"  class="text-center"><?php echo display('Bundle No');?><i class="text-danger">*</i></th> <th rowspan="2"  class="text-center"><?php echo  display('description'); ?></th> <th rowspan="2" style="width:60px;" class="text-center"><?php echo display('Thick ness');?><i class="text-danger">*</i></th> <th rowspan="2" class="text-center"><?php echo display('Supplier Block No');?><i class="text-danger">*</i></th>  <th rowspan="2" class="text-center" ><?php echo display('Supplier Slab No');?><i class="text-danger">*</i> </th> <th colspan="2" style="width:150px;" class="text-center"><?php echo display('Gross Measurement');?><i class="text-danger">*</i> </th> <th rowspan="2" class="text-center"><?php echo display('Gross Sq.Ft');?></th>  <th rowspan="2" style="width:40px;" class="text-center"><?php echo display('Slab No');?><i class="text-danger">*</i></th> <th colspan="2" style="width:150px;" class="text-center"><?php echo display('Net Measure');?><i class="text-danger">*</i></th> <th rowspan="2" class="text-center"><?php echo display('Net Sq.Ft');?></th> <th rowspan="2" class="text-center"><?php echo display('Cost per Sq.Ft');?></th> <th rowspan="2"  class="text-center"><?php echo display('Cost per Slab');?></th> <th rowspan="2"  class="text-center"><?php echo display('sales'); ?><br/><?php echo display('Price per Sq.Ft');?></th> <th rowspan="2"  class="text-center"><?php echo display('Sales Slab Price');?></th> <th rowspan="2" class="text-center"><?php echo display('Weight');?></th> <th rowspan="2" class="text-center"><?php echo display('Origin');?></th>  <th rowspan="2" style="width: 100px" class="text-center"><?php  echo  display('total'); ?></th> <th rowspan="2" class="text-center"><?php  echo  display('action'); ?></th> </tr>  <tr> <th class="btnclr text-center"><?php echo display('Width');?></th> <th class="btnclr  text-center"><?php echo display('Height');?></th> <th class="btnclr text-center"><?php echo display('Width');?></th> <th class="btnclr text-center"><?php echo display('Height');?></th> </tr>  </thead> <tbody id="addPurchaseItem_'+ dynamic_id +'"> <tr> <input type="hidden" name="tableid[]" id="tableid_'+ dynamic_id +'"/><td> <input   list="magicHouses"  style="width:160px;" name="prodt[]" id="prodt_'+ dynamic_id +'"   class="form-control product_name"  placeholder="Search Product" > <datalist id="magicHouses"> <option value="Select the Product" selected>Select the Product</option> <?php  foreach($product_list as $tx){?>  <option value="<?php echo $tx["product_name"]."-".$tx["product_model"];?>">  <?php echo $tx["product_name"]."-".$tx["product_model"];  ?></option> <?php } ?> </datalist> <input type="hidden" class="common_product autocomplete_hidden_value  product_id_'+ dynamic_id +'" name="product_id[]" id="product_id_'+ dynamic_id +'" /> </td> <td>  <input list="magic_bundle" name="bundle_no[]" id="bundle_no_'+ dynamic_id +'"   class="form-control bundle_no"'+
   'onchange="this.blur();" /><datalist id="magic_bundle"><?php foreach($bundle as $tx){?> <option value="<?php echo $tx['bundle_no'];?>">  <?php echo $tx['bundle_no'];  ?></option> <?php } ?>'+
   
   '</datalist></td> <td> <input type="text" id="description_'+ dynamic_id +'" name="description[]" class="form-control" /> </td>  <td > <input type="text" name="thickness[]" id="thickness_'+ dynamic_id +'" style="width:50px;" class="form-control"/> </td>  <td><input list="magic_supplier_block" name="supplier_block_no[]"  id="supplier_b_no_'+ dynamic_id +'"   class="form-control supplier_block_no"  placeholder="Search Product"  onchange="this.blur();" /><datalist id="magic_supplier_block"><?php foreach($supplier_block_no as $tx){?><option value="<?php echo $tx['supplier_block_no'];?>">  <?php echo $tx['supplier_block_no'];  ?></option><?php } ?></datalist> </td>  <td > <input type="text"  id="supplier_s_no_'+ dynamic_id +'" name="supplier_slab_no[]" required="" class="form-control"/> </td> <td> <input type="text" id="gross_width_'+ dynamic_id +'" name="gross_width[]" required="" class="gross_width  form-control" /> </td> <td> <input type="text" id="gross_height_'+ dynamic_id +'" name="gross_height[]"  required="" class="gross_height form-control" /> </td>  <td > <input type="text"   style="width:60px;" readonly id="gross_sq_ft_'+ dynamic_id +'" name="gross_sq_ft[]" class="gross_sq_ft form-control"/> </td>   <td style="text-align:center;" >  <input type="text"   style="width:20px;" value="1" class="slab_no" id="slab_no_'+ dynamic_id +'" name="slab_no[]"   readonly  required=""/>  </td> <td> <input type="text" id="net_width_'+ dynamic_id +'" name="net_width[]" required="" class="net_width form-control" /> </td> <td> <input type="text" id="net_height_'+ dynamic_id +'" name="net_height[]"    required="" class="net_height form-control" /> </td> <td > <input type="text"   style="width:60px;" readonly id="net_sq_ft_'+ dynamic_id +'" name="net_sq_ft[]" class="net_sq_ft form-control"/> </td> <td>   <span class="input-symbol-euro"><input type="text" id="cost_sq_ft_'+ dynamic_id +'"  name="cost_sq_ft[]"   style="width:70px;" placeholder="0.00"  class="cost_sq_ft form-control" ></span>   <td >  <span class="input-symbol-euro"> <input type="text"  id="cost_sq_slab_'+ dynamic_id +'" name="cost_sq_slab[]"    style="width:70px;" placeholder="0.00"  class="cost_sq_slab form-control"/></span>     </td> <td>  <span class="input-symbol-euro">  <input type="text" id="sales_amt_sq_ft_'+ dynamic_id +'"  name="sales_amt_sq_ft[]"  style="width:70px;"  placeholder="0.00" class="sales_amt_sq_ft form-control" /></span>     </td>  <td >  <span class="input-symbol-euro">   <input type="text"  id="sales_slab_amt_'+ dynamic_id +'" name="sales_slab_amt[]"  style="width:70px;" placeholder="0.00"  class="sales_slab_amt form-control"/></td> </span>     </td> <td> <input type="text" id="weight_'+ dynamic_id +'" name="weight[]"  class="weight form-control" /> </td>  <td >  <select  style="width:70px;" id="origin_'+ dynamic_id +'"    name="origin[]" class="origin form-control">  <?php foreach ($country_code as $key => $value) { ?>  <option value="<?php echo $value['iso']; ?>"><?php echo $value['iso']; ?></option> <?php } ?> </select> </td>  <td > <span class="input-symbol-euro"><input  type="text" class="total_price form-control" style="width:80px;" readonly value="0.00"  id="total_amt_'+ dynamic_id +'"     name="total_amt[]"/></span> </td>  <td style="text-align:center;"> <button  class="delete btn btn-danger" id="delete_'+ dynamic_id +'" type="button" value="Delete" ><i class="fa fa-trash"></i></button> </td>  </tr> </tbody> <tfoot> <tr> <td style="text-align:right;" colspan="8"><b>Gross Sq.Ft :</b></td> <td > <input type="text" id="overall_gross_'+ dynamic_id +'" name="overall_gross[]"   class="overall_gross form-control" style="width: 60px"  readonly="readonly"  /> </td> <td style="text-align:right;" colspan="3"><b>Net Sq.Ft :</b></td> <td > <input type="text" id="overall_net_'+ dynamic_id +'" name="overall_net[]"  class="overall_net form-control"  style="width: 60px"  readonly /> </td>  <td><input type="text" id="costpersqft_'+ dynamic_id +'"  name="costpersqft[]"   style="width:60px;"   readonly   class="costpersqft form-control" /></span></td>'+
   '<td ><input type="text"  id="costperslab_'+ dynamic_id +'" name="costperslab[]"  readonly  style="width:60px;"   class="costperslab form-control"/></td><td>  <input type="text" id="salespricepersqft_'+ dynamic_id +'"  name="salespricepersqft[]"  readonly style="width:60px;"   class="salespricepersqft form-control" /></td><td >   <input type="text"  id="salesslabprice_'+ dynamic_id +'" name="salesslabprice[]"  style="width:60px;"  readonly  class="salesslabprice form-control"/></td> </span><td ><input type="text" id="overall_weight_'+ dynamic_id +'" name="overall_weight[]"  class="overall_weight form-control"  style="width: 60px"  readonly /></td><td style="text-align:right;font-size: 13px;" colspan="1"><b><?php echo "Total" ?> :</b></td><td ><span class="input-symbol-euro">    <input type="text" id="Total_'+ dynamic_id +'" name="total[]"   class="b_total form-control"  style="width: 80px" value="0.00"  readonly="readonly"  /></span></td>  <td  style="text-align:center;"><i id="buddle_'+ dynamic_id +'" onclick="removebundle(); " class="btn-danger removebundle fa fa-minus" aria-hidden="true"></i></td>   </tr> </foot></table> <i id="buddle_'+ dynamic_id +'"  style="float:right;"   onclick="addbundle(); " class="btnclr addbundle fa fa-plus" aria-hidden="true"></i>';  
   
   
   document.getElementById('content').appendChild(newdiv);
   
   dynamic_id++;
   }


// Purchase Tax change

$(document).on('change','#Taxproduct_tax',function(){
   event.preventDefault();
   var total =$('#Over_all_Total').val();
   var tax = $('#Taxproduct_tax').val();
   var percent='';
   var hypen='-';
   if(tax.indexOf(hypen) != -1){
      var field = tax.split('-');
      var percent = field[1];
    }else{
      percent=tax;
   }
   percent=percent.replace("%","");
   var answer = (percent / 100) * parseFloat(total);
   var final_g= $('#final_gtotal').val();
   var amt=parseFloat(answer)+parseFloat(total);
   var num = isNaN(parseFloat(amt)) ? 0 : parseFloat(amt);
   var additional_cost =parseFloat($('#additional_cost').val()) || 0;
   $('#gtotal').val((num+additional_cost).toFixed(2)); 
   var paid_amount =parseFloat($('#amount_paid').val()) || 0;
   var custo_amt=$('.custocurrency_rate').val(); 
   console.log("numhere :"+num +"-"+custo_amt);
   var value=(num+additional_cost)*custo_amt;
   var custo_final = isNaN(parseFloat(value)) ? 0 : parseFloat(value);
   var balance_amount= (num+additional_cost)- paid_amount;
   $('#tax_details').val(answer.toFixed(2) +" ( "+tax+" )");
   $('#customer_gtotal').val(custo_final.toFixed(2));  
   $('#balance').val(balance_amount.toFixed(2));
   $('#balance_customer_currency').val((balance_amount*custo_amt).toFixed(2));
   $('#paid_customer_currency').val((paid_amount*custo_amt).toFixed(2));
   updateOverallTotals();
});
</script>

<style>
   .main-footer {
   display:none;
   }
   .ui-selectmenu-text{
   display:none;
   }
   #supplier_id-button{
   display:none;
   }
   .form-control {
   display: block;
   width: 100%;
   height: 34px;
   padding: 6px 12px;
   font-size: 14px;
   border: 1px solid #ccc;
   border-radius: 4px;
   box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
   transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
   }
   
   @media (min-width: 768px) {
       .mobile_vendor{
           position: relative;
           right: 20px;
       }
       
       #vendor_add{
           width: 99% !important;
       }
       
       .table{
           table-layout: auto !important;
       }
   }


    .file-upload {
     position: relative;
     display: inline-block;
     cursor: pointer;
     overflow: hidden;
   }
   .file-upload input[type='file'] {
     position: absolute;
     top: 0;
     right: 0;
     margin: 0;
     padding: 0;
     font-size: 20px;
     cursor: pointer;
     opacity: 0;
   }
   .file-upload span {
     display: inline-block;
     padding: 6px 12px;
     background-color: #424F5C;
     color: #fff; /* Set button text color */
     border-radius: 5px; /* Adjust button border radius as needed */
     transition: background-color 0.3s ease;
     font-size: 14px;
    font-weight: 400;
   }
   .file-upload span:hover {
     background-color: #424F5C;
   }

   .loading-text {
      display: none;
   }

   .loading-text {
      margin-top: 10px;
      width: 30px;
     aspect-ratio: 4;
     background: radial-gradient(circle closest-side,#000 90%,#0000) 0/calc(100%/3) 100% space;
     clip-path: inset(0 100% 0 0);
     animation: l1 1s steps(4) infinite;
   }
  @keyframes l1 {to{clip-path: inset(0 -34% 0 0)}}
  
</style>