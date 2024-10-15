<?php
$modaldata['bootstrap_model'] = array('vendor', 'tax_info', 'payment_model','payment_terms', 'bank_info','payment_type');

$data['payment_id'] = $purchase_info[0]['payment_id'];

$this->load->view('include/bootstrap_model', $modaldata ,$data);
?>
 <div class="panel-body">
<div class="with_po">  

 
           <form id="insert_purchase"  method="post">
             <div id="errormessage_expense" class="errormessage_expense"></div><br>
               <div class="row">
                           <div class="col-sm-6">  
                          <input type="hidden" id="admin_company_id" name="admin_company_id" value="<?php  echo $company_id; ?>">

                          <input type="hidden" id="makepaymentId" name="makepaymentId" value="<?php  echo $purchase_info[0]['payment_id']; ?>">
                          <input type="hidden" name="paid_customer_currency" id="paid_customer_currency"/>
                          <input type="hidden" name="balance_customer_currency" id="balance_customer_currency"/>
                           <div class="form-group row">
                                    <label for="supplier_sss" class="col-sm-4 col-form-label"><?php echo display('Vendor');?>
                                    <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                       <select name="supplier_id" id="supplier_id" class="form-control vendorNAME"  style="border:2px solid #d7d4d6;width:100%;"     required=""  tabindex="1">
                                          <?php foreach ($supplier_list as $key => $supplier) { ?>
                                          <option value="<?php echo $supplier_list[0]['supplier_id']; ?>"><?php echo $supplier['supplier_name'] ?></option>
                                          <?php } ?>
                                       </select>
                                    </div>
                                  
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
                                       <textarea class="form-control vendorAddress" tabindex="4" id="vendor_add" rows="4" cols="50"  style="border:2px solid #d7d4d6;" name="vendor_add" placeholder="" rows="1" required></textarea>
                                       <div id="loadingText" class="loading-text"></div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-6" id="">
                                 <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label"><?php echo display('invoice_no');  ?><i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                       <input  class=" form-control" type="" size="50"     style="border:2px solid #d7d4d6;"   name="invoice_no" id="invoice_no" value="<?php echo $purchase_info[0]['chalan_no']; ?>" tabindex="4" />
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
                                       <input type="date"  style="width:165%;border:2px solid #d7d4d6;" class="form-control" name="bill_date"   value="<?php echo $purchase_info[0]['purchase_date']; ?>" id="date"  />
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
                                       <input class="form-control" type="" size="50"  style="border:2px solid #d7d4d6;"  name="Port_of_discharge" id="date1"   tabindex="4" />
                                    </div>
                                 </div>

 
                                   <div class="form-group row">
                                    <label for="billing_address" class="col-sm-4     col-form-label"><?php echo display('Payment Terms');?>
                                    <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                       <select   name="payment_terms" id="payment_terms" style="width:100%;border:2px solid #d7d4d6;" class=" form-control" required placeholder='Payment Terms' id="payment_terms">
                                     <option value="<?php echo $purchase_info[0]['payment_terms']; ?>"><?php echo $purchase_info[0]['payment_terms']; ?></option>
											<?php
											foreach(PAYMENT_TYPE as $payment_typ){
												echo '<option value="'.$payment_typ.'">'.$payment_typ.'</option>';
											}
											?>
                                       </select>
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
                                       <input type="date"  tabindex="2" class="form-control datepicker productETA" style="border:2px solid #d7d4d6;" name="eta" value="<?php echo $purchase_info[0]['eta']; ?>" id="date1"  />
                                       <div id="loadingText" class="loading-text"></div>
                                    </div>
                                 </div>
                       

                                 <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label"><?php echo display('B/L No');?> </label>
                                    <div class="col-sm-8">
                                       <input type="text" name="bl_number" class="form-control" style="border:2px solid #d7d4d6;"   value="<?php echo $purchase_info[0]['bl_number']; ?>" placeholder="Bl Number">
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
                                          <input type="file" name="files[]" class="upload" id="attachment" style="visibility: hidden; position: absolute;" multiple/>
                                       </p>
                                        <?php foreach ($attachments as $key => $attachment) { ?> 
                                       <a href="<?php  echo base_url(); ?>uploads/purchase/<?php echo $attachment['files']; ?>" class="file-block" target=_blank><span class="file-delete"><span><i class="fa fa-trash-o"></i></span></span><?php echo $attachment['files']; ?></a>
                                       <?php } ?>
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
                                       <input class=" form-control" type="date" size="50" name="payment_due_date"   style="border:2px solid #d7d4d6;"  id="payment_due_date" value="<?php echo $purchase_info[0]['payment_due_date']; ?>" tabindex="4" />
                                    </div>
                                 </div>




                              </div>
                              <div class="col-sm-6">
 
                               <div class="form-group row">
                                    <label for="payment_type" class="col-sm-4 col-form-label"><?php
                                       echo display('payment_type');
                                       ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                       <select name="paytype_drop" id="paytype_drop" class="form-control" required=""  tabindex="3" style="width:100;border:2px solid #d7d4d6;">
                                           <option value="<?php echo $purchase_info[0]['payment_type']; ?>"><?php echo $purchase_info[0]['payment_type']; ?></option>
                                          <option value="CHEQUE"><?php echo display('cheque'); ?></option>
                                          <option value="CASH"><?php echo display('cash'); ?></option>
                                          <option value="CREDIT/DEBIT CARD"><?php echo display('CREDIT/DEBIT CARD');?></option>
                                          <option value="BANK TRANSFER"><?php echo display('BANK TRANSFER');?></option>
                                          <?php foreach($payment_type as $ptype){?>
                                          <option value="<?php echo $ptype['payment_type'];?>"><?php echo $ptype['payment_type'] ;?></option>
                                          <?php }?>
                                       </select>
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
                                       <input type="text" name="container_no" value="<?php echo $purchase_info[0]['container_no']; ?>" class="form-control container_no" style="border:2px solid #d7d4d6;"   placeholder="Container Number">
                                    </div>
                                 </div>



                                 <div class="form-group row">
                                    <label for="supplier_sss" class="col-sm-4 col-form-label"><?php echo 'Estimated Time Of Departure';?>
                                    </label>
                                    <div class="col-sm-8">
                                       <input type="date"  tabindex="2" class="form-control datepicker productETD"  style="border:2px solid #d7d4d6;"  name="etd" value="<?php echo $purchase_info[0]['etd']; ?>" id="date"  />
                                       <div id="loadingText" class="loading-text"></div>
                                    </div>
                                 </div>



                                      <div class="form-group row">
    <label for="invoice_no" class="col-sm-4 col-form-label">

        <?php echo display('ISF FIELD');?>  <i class="text-danger">*</i>

    </label>
    <div class="col-sm-8">
        <select name="isf_field" class="form-control"  id="isf_dropdown1" tabindex="3" style="width400%;border: 2px solid #d7d4d6;">
                              <option value="1" <?php if($purchase_info[0]['isf_filling']==''){ echo "selected"; } ?>><?php echo display('NO') ?></option>
                              <option value="2" <?php if($purchase_info[0]['isf_filling']){ echo "selected"; } ?>><?php echo display('YES') ?></option>
                           </select>
    </div>
</div>

                                 <div class="form-group row" >
                                    <label for="ISF" class="isf_no1 col-sm-4 col-form-label" ><?php echo display('ISF NO');?>
                                    <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                       <input name="isf_no" id="isf_no1"  class="form-control bankpayment"   style="width:100%;border: 2px solid #d7d4d6;" value="<?php echo $purchase_info[0]['isf_filling']; ?>"  >
                                    </div>
                                 </div>

                          

                


                              </div>
                           </div>
                           <?php  $tax_split= $purchase_info[0]['tax_details']; 
                  $tax_description='';
                  if($tax_split !=='' && !empty($tax_split)){
                     preg_match('#\((.*?)\)#', $tax_split, $match);
                  
                     $tax_description=$match[1];$tax_description=trim($tax_description);
                     
                   }else{
                  
                     $tax_description=$tax_description=trim($tax_description);
                     
                   }
                  ?>        
                            <div class="table-responsive">
                  <div id="content">
                     <?php
              
                        $count='';
                        $list_count=array();
                        foreach($purchase_info as $inv){
                            $count = substr($inv['tableid'], 0, 1);
                         $items[] =$count   ;                            
                                                      
                        
                        
                        
                        
                        }
                        
                        
                        
                        ?>
                     <?php 
                        for($m=0;$m<=count($purchase_info);$m++){ ?>
                     <table class="table table-bordered normalinvoice table-hover" id="normalinvoice_<?php  echo $m; ?>"  style="border: 2px solid #d7d4d6;" >
                        <thead>
                           <tr>
                              <th rowspan="2" class="text-center" style="width:180px;" ><?php echo display('product_name'); ?><i class="text-danger">*</i>  &nbsp;&nbsp; </th>
                              <th rowspan="2" class="text-center" style="width:60px;"><?php echo display('Bundle No');?><i class="text-danger">*</i></th>
                              <th rowspan="2"  class="text-center"><?php echo  display('description'); ?></th>
                              <th rowspan="2" class="text-center" style="width:60px;"><?php echo display('Thick ness');?><i class="text-danger">*</i></th>
                              <th rowspan="2" class="text-center"><?php echo display('Supplier Block No');?><i class="text-danger">*</i></th>
                              <th rowspan="2" class="text-center" ><?php echo display('Supplier Slab No');?><i class="text-danger">*</i> </th>
                              <th colspan="2"   style="width:150px;" class="text-center"><?php echo display('Gross Measurement');?><i class="text-danger">*</i> </th>
                              <th rowspan="2" class="text-center"><?php echo display('Gross Sq.Ft');?></th>
                              <th rowspan="2" style="width:80px;" class="text-center"><?php echo display('Slab No');?><i class="text-danger">*</i></th>
                              <th colspan="2"  style="width:150px;" class="text-center"><?php echo display('Net Measure');?><i class="text-danger">*</i></th>
                              <th rowspan="2" class="text-center"><?php echo display('Net Sq.Ft');?></th>
                              <th rowspan="2"  style="width:90px;" class="text-center"><?php echo display('Cost per Sq.Ft');?></th>
                              <th rowspan="2"  style="width:90px;" class="text-center"><?php echo display('Cost per Slab');?></th>
                              <th rowspan="2"  style="width:90px;" class="text-center"><?php echo display('sales'); ?><br/><?php echo display('Price per Sq.Ft');?></th>
                              <th rowspan="2"  style="width:90px;" class="text-center"><?php echo display('Sales Slab Price');?></th>
                              <th rowspan="2" class="text-center"><?php echo display('Weight');?></th>
                              <th rowspan="2" style="width:120px;" class="text-center"><?php echo display('Origin');?></th>
                              <th rowspan="2" style="width: 130px" class="text-center"><?php  echo  display('total'); ?></th>
                              <th rowspan="2" class="text-center"><?php  echo  display('action'); ?></th>
                           </tr>
                           <tr>
                              <th class="text-center"><?php echo display('Width');?></th>
                              <th class="text-center"><?php echo display('Height');?></th>
                              <th class="text-center"  ><?php echo display('Width');?></th>
                              <th class="text-center" ><?php echo display('Height');?></th>
                           </tr>
                        </thead>
                        <tbody id="addPurchaseItem_<?php echo $m;  ?>">
                           <?php  $n=0; ?>
                           <?php foreach($purchase_info as $inv){
                              $a = substr($inv['tableid'], 0, 1);
                              if($a==$m){
                              ?>
                           <tr>
                              <td>
                                 <input type="hidden" name="tableid[]" id="tableid_1" value="<?php  echo $inv['tableid'];   ?>"/>
                                 <input list="magicHouses" name="prodt[]" id="prodt_<?php  echo $m.$n; ?>" class="form-control product_name" value="<?php  echo $inv['product_name'];  ?>" style="width:160px;" />
                                 <datalist id="magicHouses">
                                    <?php                                
                                       foreach($product_list as $tx){?>
                                    <option value="<?php echo $tx['product_name'].'-'.$tx['product_model'];?>">  <?php echo $tx['product_name'].'-'.$tx['product_model'];  ?></option>
                                    <?php } ?>
                                 </datalist>
                                 <input type='hidden' class='common_product autocomplete_hidden_value  product_id_1' value="<?php  echo $inv['product_id'];  ?>" name='product_id[]' id='SchoolHiddenId_<?php  echo $m.$n; ?>' />
                              </td>
                              <td>
                                 <input type="text" id="bundle_no_<?php  echo $m.$n; ?>" name="bundle_no[]" value="<?php  echo $inv['bundle_no'];  ?>" class="form-control" />
                              </td>
                              <td>
                                 <input type="text" id="description_<?php  echo $m.$n; ?>" name="description[]" value="<?php  echo $inv['description'];  ?>" class="form-control" />
                              </td>
                              <td >
                                 <input type="text" name="thickness[]" id="thickness_<?php  echo $m.$n; ?>"  value="<?php  echo $inv['thickness'];  ?>" class="form-control"/>
                              </td>
                              <td>
                                 <input type="text" id="supplier_b_no_<?php  echo $m.$n; ?>" name="supplier_block_no[]"  value="<?php  echo $inv['supplier_block_no'];  ?>" class="form-control" />
                              </td>
                              <td >
                                 <input type="text"  id="supplier_s_no_<?php  echo $m.$n; ?>" name="supplier_slab_no[]" value="<?php  echo $inv['supplier_slab_no'];  ?>" class="form-control"/>
                              </td>
                              <td>
                                 <input type="text" id="gross_width_<?php  echo $m.$n; ?>" name="gross_width[]"  value="<?php  echo $inv['gross_width'];  ?>" class="gross_width  form-control" />
                              </td>
                              <td>
                                 <input type="text" id="gross_height_<?php  echo $m.$n; ?>" name="gross_height[]"    value="<?php  echo $inv['gross_height'];  ?>" class="gross_height form-control" />
                              </td>
                              <td >
                                 <input type="text"   style="width:60px;" readonly id="gross_sq_ft_<?php  echo $m.$n; ?>" name="gross_sq_ft[]" value="<?php  echo $inv['gross_sqft'];  ?>" class="gross_sq_ft form-control"/>
                              </td>
                              <td >
                                 <input type="text"  id="slab_no_<?php  echo $m.$n; ?>" name="slab_no[]" value="<?php  echo $n+1;  ?>" readonly   value="<?php  echo $c;  ?>" class="form-control"/>
                              </td>
                              <td>
                                 <input type="text" id="net_width_<?php  echo $m.$n; ?>" name="net_width[]"  value="<?php  echo $inv['n_width'];  ?>" class="net_width form-control" />
                              </td>
                              <td>
                                 <input type="text" id="net_height_<?php  echo $m.$n; ?>" name="net_height[]"    value="<?php  echo $inv['n_height'];  ?>" class="net_height form-control" />
                              </td>
                              <td >
                                 <input type="text"   style="width:60px;" readonly id="net_sq_ft_<?php  echo $m.$n; ?>" name="net_sq_ft[]" value="<?php  echo $inv['net_sqft'];  ?>" class="net_sq_ft form-control"/>
                              </td>
                           <td>

       <span class="input-symbol-euro"><input type="text" id="cost_sq_ft_<?php  echo $m.$n; ?>"    <?php foreach($this->session->userdata('perm_data') as $test) { $split=explode('-',$test);      if(trim($split[0])=='expenses'  && trim($split[1])=='0100'){  echo "";  } else{echo "readonly";}}?>   name="cost_sq_ft[]"   style="width:60px;"  value="<?php  echo $inv['cost_per_sqft'];  ?>"  class="cost_sq_ft form-control" ></span>

                                        
                                            <td >
                     
      <span class="input-symbol-euro"> <input type="text"  id="cost_sq_slab_<?php  echo $m.$n; ?>" name="cost_sq_slab[]"    style="width:60px;" value="<?php  echo $inv['cost_per_sqft'];  ?>"      placeholder="0.00"   class="cost_sq_slab form-control"/></span>
 


                                               
                                            </td>
                                            <td>
                                        
         <span class="input-symbol-euro">  <input type="text" id="sales_amt_sq_ft_<?php  echo $m.$n; ?>"  name="sales_amt_sq_ft[]"  style="width:60px;"  value="<?php  echo $inv['sales_price_sqft'];  ?>" class="sales_amt_sq_ft form-control" /></span>



                                               
                                            </td>
                                        
                                            <td >
                                    
      <span class="input-symbol-euro">   <input type="text"  id="sales_slab_amt_<?php  echo $m.$n; ?>" name="sales_slab_amt[]"  style="width:60px;" value="<?php  echo $inv['sales_slab_price'];  ?>"  class="sales_slab_amt form-control"/></td> </span>
      </td>
                              <td>
                                 <input type="text" id="weight_<?php  echo $m.$n; ?>" name="weight[]"  value="<?php  echo $inv['weight'];  ?>" class="weight form-control" />
                              </td>
                              <td >
                                  <select id="origin_<?php  echo $m.$n; ?>" name="origin[]" class="origin form-control">   
                                                    <option value="<?php echo $inv['origin']; ?>"><?php echo $inv['origin']; ?></option>   
                                                <?php foreach ($country_code as $key => $value) { ?>
                                                   <option value="<?php echo $value['iso']; ?>"><?php echo $value['iso']; ?></option>
                                                <?php } ?> </select>

                                            
                                            </td>
                              <td >
                                 <span class="input-symbol-euro"><input  type="text" class="total_price form-control" style="width:80px;" readonly  value="<?php  echo $inv['total_amount'];  ?>"  id="total_<?php  echo $m.$n; ?>"     name="total_amt[]"/></span>
                              </td>
                              <td style="text-align:center;">
                                 <button  class='delete btn btn-danger' type='button' value='Delete' ><i class='fa fa-trash'></i></button>
                              </td>
                           </tr>
                           <?php $n++;   } }  ?>
                        </tbody>
                        <tfoot>
                           <tr>
                              <td style="text-align:right;" colspan="8"><b><?php  echo display('Gross Sq.Ft');?>  :</b></td>
                              <td >
                                 <input type="text" id="overall_gross_<?php echo $m; ?>" name="overall_gross[]"    class="overall_gross form-control" style="width: 60px"   readonly="readonly"  /> 
                              </td>
                              <td style="text-align:right;" colspan="3"><b><?php  echo display('Net Sq.Ft');?> :</b></td>
                              <td >
                                 <input type="text" id="overall_net_<?php echo $m; ?>" name="overall_net[]"  class="overall_net form-control"  style="width: 60px"   readonly="readonly"  /> 
                              </td>
                                              <td >
             <input type="text" id="costpersqft_<?php echo $m; ?>" name="costpersqft[]"  class="costpersqft form-control"  style="width: 60px"  readonly="readonly"  /> 
            </td>
            
                                        <td >
             <input type="text" id="costperslab_<?php echo $m; ?>" name="costperslab[]"  class="costperslab form-control"  style="width: 60px"    /> 
            </td>
           
                                        <td >
             <input type="text" id="salespricepersqft_<?php echo $m; ?>" name="salespricepersqft[]"  class="salespricepersqft form-control"  style="width: 60px"  readonly="readonly"  /> 
            </td>
            
                                        <td >
             <input type="text" id="salesslabprice_<?php echo $m; ?>" name="salesslabprice[]"  class="salesslabprice form-control"  style="width: 60px"  readonly="readonly"  /> 
            </td>

                           
                              <td >
                                 <input type="text" id="overall_weight_<?php echo $m; ?>" name="overall_weight[]"  class="overall_weight form-control"  style="width: 70px"  readonly="readonly"  /> 
                              </td>
                              <td style="text-align:right;" colspan="1"><b><?php  echo display('total'); ?> :</b></td>
                              <td >
                                 <span class="input-symbol-euro">     <input type="text" id="Total_<?php echo $m; ?>" name="total[]"   class="b_total form-control"   style="padding-top: 6px;width: 80px"    readonly="readonly"  />
                              </td>
                              <td colspan="2" style="text-align: center;">
                             <i id="buddle_<?php echo $m; ?>"  class="btn-danger removebundle fa fa-minus" aria-hidden="true"></i>
                              
                              </td>
                           </tr>
                        </tfoot>
                     </table>
                     <?php   } ?>
                  
                  <i id="buddle_1" class="btnclr addbundle fa fa-plus" style=" padding: 10px 12px 10px 12px;margin-right: 18px;float:right; "   onclick="addbundle(); "aria-hidden="true"></i>
                
                    </div>
               </div>
                            <table class="taxtab table table-bordered table-hover" style="border:2px solid #d7d4d6;" >
                        <tr>
                           <td class="hiden" style="width:20%;border:none;text-align:end;font-weight:bold;">
                              <?php echo display('Live Rate') ?> :
                           </td>
                           <td class="hiden btnclr" style="width:13%;text-align-last: center;padding:5px; border:none;font-weight:bold;color:white;">1 <?php echo $curn_info_default; ?>
                              = <input style="width: 80px;text-align:center;color:black;padding:5px;" type="text" class="custocurrency_rate"/>&nbsp;<label for="custocurrency"  ></label>
                           </td>
                           <td style="border:none;text-align:right;font-weight:bold;"><?php echo display('Tax') ?> :
                           </td>
                           <td style="width:12%">
                           <input list="magic_tax" name="tx" id="Taxproduct_tax" class="form-control"  value="<?php echo $tax_description; ?>"  onchange="this.blur();" />
                              <datalist id="magic_tax">
                                 <?php foreach ($tax_data as $tx) {?>
                                 <option value="<?php echo $tx['tax_id'] . '-' . $tx['tax'] . '%'; ?>">  <?php echo $tx['tax_id'] . '-' . $tx['tax'] . '%'; ?></option>
                                 <?php }?>
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
                <input type="text" id="Over_all_Total" name="Over_all_Total" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" value="<?php echo $purchase_info[0]['total']; ?>" readonly="readonly" />
            </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="tax_details"><b><?php echo display('TAX DETAILS') ?> :</b></label>
                <input type="text" id="tax_details" name="tax_details" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" value="<?php echo $purchase_info[0]['tax_details']; ?>" readonly="readonly" />
          
            </td>
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="total_gross"><b><?php echo display('Overall Gross Sq.Ft') ?> :</b></label>
                <input type="text" id="total_gross" name="total_gross" value="<?php echo $purchase_info[0]['total_gross']; ?>" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" readonly="readonly" />
            </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
              <label style="width:150px;" for="gtotal"><b><?php echo display('GRAND TOTAL') ?> :</b></label>
                <input type="text" id="gtotal" name="gtotal" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" value="<?php echo $purchase_info[0]['grand_total_amount']; ?>" readonly="readonly" />
            </td>
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="total_net"><b><?php echo display('Overall Net Sq.Ft') ?> :</b></label>
                <input type="text" id="total_net" name="total_net" class="form-control" value="<?php echo $purchase_info[0]['total_net']; ?>" style="width: 150px; margin-left: 10px; display: inline-block;" readonly="readonly" />
            </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                  <label style="width:150px;" for="customer_gtotal"><b><?php echo display('Preferred Currency') ?> :</b></label>
                <input type="text" id="customer_gtotal" name="customer_gtotal" class="form-control" value="<?php echo $purchase_info[0]['gtotal_preferred_currency']; ?>" style="width: 150px; margin-left: 10px; display: inline-block;" readonly />
          </td>
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="total_weight"><b><?php echo display('Overall Weight') ?> :</b></label>
                <input type="text" id="total_weight" name="total_weight" class="form-control" value="<?php echo $purchase_info[0]['total_weight']; ?>" style="width: 150px; margin-left: 10px; display: inline-block;" readonly="readonly" />
            </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="amount_paid"><b><?php echo display('Amount Paid') ?> :</b></label>
                <input type="text" id="amount_paid" name="amount_paid" class="form-control" value="<?php echo $purchase_info[0]['paid_amount']; ?>" style="width: 150px; margin-left: 10px; display: inline-block;" readonly />
         </td>
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
             </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="balance"><b><?php echo display('Balance Amount') ?> :</b></label>
                <input type="text" id="balance" name="balance" class="form-control" value="<?php echo $purchase_info[0]['due_amount']; ?>" style="width: 150px; margin-left: 10px; display: inline-block;" readonly />
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr style="border-right:none; border-left:none; border-bottom:none; border-top:none;">
            <td colspan="2" style="text-align: right; padding: 20px;">
              <a class="paypls client-add-btn btn btnclr" aria-hidden="true" id="paypls" data-toggle="modal" data-target="#payment_modal">
                        Make Payment
             </a>
            </td>
        </tr>
    </tfoot>
</table>

               <script>

                  $('.paypls').on('click', function() {debugger;
                     var balance = $('#balance').val();
                     $('#amount_to_pay').val(balance);

                     var paymentid = "<?php echo  $purchase_info[0]['payment_id']; ?>";

                     $('#payment_id').val(paymentid);

                  });
               </script>

 
                         
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
                                       <tr> <td style="width:140px;">
                                             <input type="submit" id="insertPurchase" class="btnclr btn btn-large" value="<?php echo display('save'); ?>" />
                                        
                                             <a id="purchasefinal_submit" class='btnclr final_submit btn'><?php echo display('submit'); ?></a>
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
                    


 </div></div>
                    



<script>
   $(document).ready(function(){
   $(".sidebar-mini").addClass('sidebar-collapse') ;
   });
 $(document).ready(function(){
              var data = {
                 value: $('#supplier_id').val()
         
              };
             data[csrfName] = csrfHash;
             $.ajax({
                 type:'POST',
                 data: data,
               dataType:"json",
                 url:'<?php echo base_url();?>Cinvoice/getvendor',
                 success: function(result, statut) {
                     console.log(result);
                     if(result.csrfName){
                       csrfName = result.csrfName;
                        csrfHash = result.csrfHash;
                     }
                  console.log(result[0]['currency_type']);
                  $('#vendor_add').html(result[0]['address']);
                   $('#vendor_type_details').val(result[0]['vendor_type']);
                 $("#custocurrency_rate").html(result[0]['currency_type']);
                 $("#autocomplete_supplier_id").val(result[0]['supplier_id']);
                 $("label[for='custocurrency']").html(result[0]['currency_type']);
              
                $.getJSON('https://open.er-api.com/v6/latest/<?php echo $curn_info_default; ?>', 
         function(data) {
          var custo_currency=result[0]['currency_type'];
             var x=data['rates'][custo_currency];
          var Rate =parseFloat(x).toFixed(3);
          Rate = isNaN(Rate) ? 0 : Rate;
           console.log(Rate);
          
           $(".custocurrency_rate").val(Rate);
         });
               
                 }
             });
   
   $('#download_provider').hide();
   $('#final_submit_provider').hide();
   $('#print_provider').hide();
    });
    
   $('#isf_dropdown1').on('change', function() {
     if ( this.value == '2')
       $("#isf_no1").show();
     else
       $("#isf_no1").hide();
   }).trigger("change");
    $('.final_submit').on('click', function (e) {
    var input_hdn='Your Invoice No : "'+ $('#Final_invoice_number').val()+" has been Updated Successfully";

 $('.errormessage_expense').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + input_hdn + '</div>');

   window.setTimeout(function(){
      window.location = "<?php  echo base_url(); ?>Cpurchase/manage_purchase?id=<?php echo $_GET['id']; ?>";
     }, 2000);
   });
 $(document).ready(function(){
   if ( $('#isf_dropdown1').val() == '2'){
       $(".isf_no1").show();
   }else{
       $(".isf_no1").hide();
 }
    $('#current_in_id').val($('#invoice_no').val());
        payment_update();
    });
// Insert Expense Data
 
    function addbundle(){
   $(this).closest('table').find('.addbundle').css("display","none");
   $(this).closest('table').find('.removebundle').css("display","block");
   
   var newdiv = document.createElement('div');
   var tabin="crate_wrap_"+dynamic_id;
   
   newdiv = document.createElement("div");
   
   
   newdiv.innerHTML ='<table class="table normalinvoice table-bordered table-hover"     style="border:2px solid #d7d4d6;"               id="normalinvoice_'+ dynamic_id +'"> <thead> <tr> <th rowspan="2" class="text-center" style="width: 170px;" ><?php echo display('product_name'); ?><i class="text-danger">*</i></th> <th rowspan="2"  class="text-center"><?php echo display('Bundle No');?><i class="text-danger">*</i></th> <th rowspan="2"  class="text-center"><?php echo  display('description'); ?></th> <th rowspan="2" style="width:60px;" class="text-center"><?php echo display('Thick ness');?><i class="text-danger">*</i></th> <th rowspan="2" class="text-center"><?php echo display('Supplier Block No');?><i class="text-danger">*</i></th>  <th rowspan="2" class="text-center" ><?php echo display('Supplier Slab No');?><i class="text-danger">*</i> </th> <th colspan="2" style="width:150px;" class="text-center"><?php echo display('Gross Measurement');?><i class="text-danger">*</i> </th> <th rowspan="2" class="text-center"><?php echo display('Gross Sq.Ft');?></th>  <th rowspan="2" style="width:40px;" class="text-center"><?php echo display('Slab No');?><i class="text-danger">*</i></th> <th colspan="2" style="width:150px;" class="text-center"><?php echo display('Net Measure');?><i class="text-danger">*</i></th> <th rowspan="2" class="text-center"><?php echo display('Net Sq.Ft');?></th> <th rowspan="2" class="text-center"><?php echo display('Cost per Sq.Ft');?></th> <th rowspan="2"  class="text-center"><?php echo display('Cost per Slab');?></th> <th rowspan="2"  class="text-center"><?php echo display('sales'); ?><br/><?php echo display('Price per Sq.Ft');?></th> <th rowspan="2"  class="text-center"><?php echo display('Sales Slab Price');?></th> <th rowspan="2" class="text-center"><?php echo display('Weight');?></th> <th rowspan="2" class="text-center"><?php echo display('Origin');?></th>  <th rowspan="2" style="width: 100px" class="text-center"><?php  echo  display('total'); ?></th> <th rowspan="2" class="text-center"><?php  echo  display('action'); ?></th> </tr>  <tr> <th class="text-center"><?php echo display('Width');?></th> <th class="text-center"><?php echo display('Height');?></th> <th class="text-center"><?php echo display('Width');?></th> <th class="text-center"><?php echo display('Height');?></th> </tr>  </thead> <tbody id="addPurchaseItem_'+ dynamic_id +'"> <tr> <input type="hidden" name="tableid[]" id="tableid_'+ dynamic_id +'"/><td> <input   list="magicHouses"  style="width:160px;" name="prodt[]" id="prodt_'+ dynamic_id +'"   class="form-control product_name"  placeholder="Search Product" > <datalist id="magicHouses"> <option value="Select the Product" selected>Select the Product</option> <?php  foreach($product_list as $tx){?>  <option value="<?php echo $tx["product_name"]."-".$tx["product_model"];?>">  <?php echo $tx["product_name"]."-".$tx["product_model"];  ?></option> <?php } ?> </datalist> <input type="hidden" class="common_product autocomplete_hidden_value  product_id_'+ dynamic_id +'" name="product_id[]" id="SchoolHiddenId_'+ dynamic_id +'" /> </td> <td>  <input list="magic_bundle" name="bundle_no[]" id="bundle_no_'+ dynamic_id +'"   class="form-control bundle_no"'+
   'onchange="this.blur();" /><datalist id="magic_bundle"><?php foreach($bundle as $tx){?> <option value="<?php echo $tx['bundle_no'];?>">  <?php echo $tx['bundle_no'];  ?></option> <?php } ?>'+
   
   '</datalist></td> <td> <input type="text" id="description_'+ dynamic_id +'" name="description[]" class="form-control" /> </td>  <td > <input type="text" name="thickness[]" id="thickness_'+ dynamic_id +'" required="" class="form-control"/> </td>  <td><input list="magic_supplier_block" name="supplier_block_no[]"  id="supplier_b_no_'+ dynamic_id +'"   class="form-control supplier_block_no"  placeholder="Search Product"  onchange="this.blur();" /><datalist id="magic_supplier_block"><?php foreach($supplier_block_no as $tx){?><option value="<?php echo $tx['supplier_block_no'];?>">  <?php echo $tx['supplier_block_no'];  ?></option><?php } ?></datalist> </td>  <td > <input type="text"  id="supplier_s_no_'+ dynamic_id +'" name="supplier_slab_no[]" required="" class="form-control"/> </td> <td> <input type="text" id="gross_width_'+ dynamic_id +'" name="gross_width[]" required="" class="gross_width  form-control" /> </td> <td> <input type="text" id="gross_height_'+ dynamic_id +'" name="gross_height[]"  required="" class="gross_height form-control" /> </td>  <td > <input type="text"   style="width:60px;" readonly id="gross_sq_ft_'+ dynamic_id +'" name="gross_sq_ft[]" class="gross_sq_ft form-control"/> </td>   <td style="text-align:center;" >  <input type="text"   style="width:20px;" value="1" class="slab_no" id="slab_no_'+ dynamic_id +'" name="slab_no[]"   readonly  required=""/>  </td> <td> <input type="text" id="net_width_'+ dynamic_id +'" name="net_width[]" required="" class="net_width form-control" /> </td> <td> <input type="text" id="net_height_'+ dynamic_id +'" name="net_height[]"    required="" class="net_height form-control" /> </td> <td > <input type="text"   style="width:60px;" readonly id="net_sq_ft_'+ dynamic_id +'" name="net_sq_ft[]" class="net_sq_ft form-control"/> </td> <td>   <span class="input-symbol-euro"><input type="text" id="cost_sq_ft_'+ dynamic_id +'"  name="cost_sq_ft[]"   style="width:70px;" placeholder="0.00"  class="cost_sq_ft form-control" ></span>   <td >  <span class="input-symbol-euro"> <input type="text"  id="cost_sq_slab_'+ dynamic_id +'" name="cost_sq_slab[]"    style="width:70px;" placeholder="0.00"  class="cost_sq_slab form-control"/></span>     </td> <td>  <span class="input-symbol-euro">  <input type="text" id="sales_amt_sq_ft_'+ dynamic_id +'"  name="sales_amt_sq_ft[]"  style="width:70px;"  placeholder="0.00" class="sales_amt_sq_ft form-control" /></span>     </td>  <td >  <span class="input-symbol-euro">   <input type="text"  id="sales_slab_amt_'+ dynamic_id +'" name="sales_slab_amt[]"  style="width:70px;" placeholder="0.00"  class="sales_slab_amt form-control"/></td> </span>     </td> <td> <input type="text" id="weight_'+ dynamic_id +'" name="weight[]"  class="weight form-control" /> </td>  <td >  <select  id="origin_'+ dynamic_id +'"    name="origin[]" class="origin form-control">  <?php foreach ($country_code as $key => $value) { ?>  <option value="<?php echo $value['iso']; ?>"><?php echo $value['iso']; ?></option> <?php } ?> </select> </td>  <td > <span class="input-symbol-euro"><input  type="text" class="total_price form-control" style="width:80px;" readonly value="0.00"  id="total_amt_'+ dynamic_id +'"     name="total_amt[]"/></span> </td>  <td style="text-align:center;"> <button  class="delete btn btn-danger" id="delete_'+ dynamic_id +'" type="button" value="Delete" ><i class="fa fa-trash"></i></button> </td>  </tr> </tbody> <tfoot> <tr> <td style="text-align:right;" colspan="8"><b>Gross Sq.Ft :</b></td> <td > <input type="text" id="overall_gross_'+ dynamic_id +'" name="overall_gross[]"   class="overall_gross form-control" style="width: 60px"  readonly="readonly"  /> </td> <td style="text-align:right;" colspan="3"><b>Net Sq.Ft :</b></td> <td > <input type="text" id="overall_net_'+ dynamic_id +'" name="overall_net[]"  class="overall_net form-control"  style="width: 60px"  readonly /> </td>  <td><input type="text" id="costpersqft_'+ dynamic_id +'"  name="costpersqft[]"   style="width:60px;"   readonly   class="costpersqft form-control" /></span></td>'+
   '<td ><input type="text"  id="costperslab_'+ dynamic_id +'" name="costperslab[]"  readonly  style="width:60px;"   class="costperslab form-control"/></td><td>  <input type="text" id="salespricepersqft_'+ dynamic_id +'"  name="salespricepersqft[]"  readonly style="width:60px;"   class="salespricepersqft form-control" /></td><td >   <input type="text"  id="salesslabprice_'+ dynamic_id +'" name="salesslabprice[]"  style="width:60px;"  readonly  class="salesslabprice form-control"/></td> </span><td ><input type="text" id="overall_weight_'+ dynamic_id +'" name="overall_weight[]"  class="overall_weight form-control"  style="width: 60px"  readonly /></td><td style="text-align:right;font-size: 13px;" colspan="1"><b><?php echo "Total" ?> :</b></td><td ><span class="input-symbol-euro">    <input type="text" id="Total_'+ dynamic_id +'" name="total[]"   class="b_total form-control"  style="width: 80px" value="0.00"  readonly="readonly"  /></span></td>  <td  style="text-align:center;"><i id="buddle_'+ dynamic_id +'" onclick="removebundle(); " class="btn-danger removebundle fa fa-minus" aria-hidden="true"></i></td>   </tr> </foot></table> <i id="buddle_'+ dynamic_id +'"     onclick="addbundle(); " class="btnclr addbundle fa fa-plus" aria-hidden="true"></i>';  
   
   
   document.getElementById('content').appendChild(newdiv);
   
   dynamic_id++;
   }
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


// Insert Purchase
   // $("#insert_purchase").validate({
   //    rules: {
   //    supplier_id: "required",
   //    invoice_no: "required", 
   //    payment_due_date : "required", 
   //    bill_date : "required",
   //    payment_terms: "required",  
   //    paytype_drop : "required",
   //    isf_no: {
   //       isfNoRequired: true
   //    }
   //   },
   //    messages: {
   //    supplier_id: "Supplier Name is required",
   //    invoice_no: "Invoice Number is required",
   //    payment_terms: "Payment Term is required",
   //    paytype_drop: "Payment Type is required",
   //    payment_due_date: "Payment Due Date is required",
   //    bill_date: "Bill Date is required",
   //    isf_no: "ISF No is required when ISF Field is YES.",
   //   },
   //    errorPlacement: function(error, element) {
   //       if (element.hasClass("select2-hidden-accessible")) {
   //          error.insertAfter(element.next('span.select2')); 
   //       } else {
   //          error.insertAfter(element);
   //       }
   //    },
   //    submitHandler: function(form, event) {
   //       event.preventDefault();
   //       var formData = new FormData($("#insert_purchase")[0]);
   //       formData.append(csrfName, csrfHash);
   //       console.log(formData, "formData");
   //      //  $.ajax({
   //      //   type: "POST",
   //      //   dataType: "json",
   //      //   url:"<?php echo base_url(); ?>Cpurchase/insert_purchase",
   //      //   data: formData,
   //      //   contentType: false,
   //      //   processData: false,
   //      //   success: function(response) {
   //      //   console.log(response);
   //      //   if (response.status == 'success') {
   //      //     $('#errormessage_expense').html('<div class="alert alert-success">' + response.msg + '</div>');
   //      //     $('#Final_invoice_number').val(response.invoice_no);
   //      //     $('#Final_invoice_id').val(response.invoice_id);
   //      //   }else{
   //      //     $('#errormessage_expense').html(failalert+response.msg+'</div>'); 
   //      //     console.log(response.msg, "Error");
   //      //   }                  
   //      //   },
   //      //     error: function(xhr, status, error) {
   //      //     debugger;
   //      //     $('#errormessage_expense').html(failalert+error+'</div>'); 
   //      //   }
   //      // });
   //    }
   // });
});
</script>