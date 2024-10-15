 <div class="content-wrapper">
   <section class="content-header">
      <div class="header-icon">
        <figure class="one">
               <img src="<?php echo base_url()  ?>asset/images/expenses.png"  class="headshotphoto" style="height:50px;" />

      </div>
      <div class="header-title">
         
          <div class="logo-holder logo-9">
      <h1><?php echo ('Edit Expense') ?></h1>

       </div>
         <ol class="breadcrumb" style="border: 3px solid #d7d4d6;">
            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
            <li><a href="#"><?php echo display('purchase') ?></a></li>
         <li class="active" style="color:orange"><?php echo ('Edit Expense') ?></li>
         <div class="load-wrapp">
      <div class="load-10">
         <div class="bar"></div>
      </div>
    </div>
        </ol>
      </div>
 
</section>
           <style>
           #bulk_payment_form input[type="text"]  { border: none; 
    background: inherit;
    padding: 0; 
    margin: 0; 
    box-shadow: none; 
    outline: none; 
}
            </style>
<section class="content">
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
<div class="alert alert-danger alert-dismissable">
   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
   <?php echo $error_message ?>                    
</div>
<?php 
   $this->session->unset_userdata('error_message');
   
   }
   
   ?>
   <?php  $payment_id_new=rand(); ?>
<div class="row">
   <div class="col-sm-12">
      <div class="panel panel-bd lobidrag"  style="border:3px solid #d7d4d6;" >
         <div class="panel-heading" style="height:60px;">
            <div class="panel-title">
               <div class="Row">
                  <div class="Column" style="float: left;">
                  </div>
                  <div class="Column" style="float: right;">
                     <form id="histroy" method="post" >
                              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                              <input type="hidden"  value="<?php if($purchase_info[0]['payment_id']){ echo $purchase_info[0]['payment_id']; }else{ echo $payment_id_new;}?>" name="makepaymentId" class="payment_id" id="makepaymentId"/>
                                <input type="hidden" id='current_in_id' name="current_in_id"/>
                    <input type="hidden" value="<?php  echo  $purchase_info[0]['supplier_id']; ?>" name="supplier_id_payment"/>
                            <?php   if($purchase_info[0]['payment_id']){ ?>
                              <input type="submit" id="payment_history" name="payment_history" class="btnclr btn" style="float:right;float:right;margin-bottom:30px;"   value="<?php echo display('Payment History') ?>"/>
                            <?php  }  ?>
                           </form>

                 
                  </div>
                  <div class="Column" style="float: right;">
                     <a  href="<?php  echo base_url(); ?>Cpurchase/manage_purchase?id=<?php echo $_GET['id']; ?>" class="btnclr btn  m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_expense'); ?> </a>
                  </div>
               </div>
            </div>
         </div>
         <div class="panel-body">

             <div id="errormessage_expense"></div>

           <form id="insert_expense"  method="post">
                           <div class="row">
                           <div class="col-sm-6">  
                          <input type="hidden" id="admin_company_id" name="admin_company_id" value="<?php  echo $_GET['id']; ?>">
                          <input type="hidden" id="payment_id" name="payment_id">
                          <input type="hidden" name="paid_customer_currency" id="paid_customer_currency"/>
                          <input type="hidden" name="balance_customer_currency" id="balance_customer_currency"/>
                           <div class="form-group row">
                                    <label for="supplier_sss" class="col-sm-4 col-form-label"><?php echo display('Vendor');?>
                                    <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <select name="supplier_id" id="supplier_id" class="form-control "  style="width:100%;border: 2px solid #d7d4d6;" required=""  tabindex="1">
                              <option value="<?php echo $purchase_info[0]['supplier_id'] ?> "><?php echo $purchase_info[0]['supplier_name']; ?></option>
                              {all_supplier}
                              <option value="{supplier_id}">{supplier_name}</option>
                              {/all_supplier}
                           </select>
                                    </div>
                                   
                                 </div>
                                <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label" ><?php  echo  display('Vendor Type');?></label>
                        <div class="col-sm-8">

                           <input type="vendor_type" tabindex="3" readonly class="form-control" name="vendor_type"  style="WIDTH: 100%;border: 2px solid #d7d4d6;"   id="vendor_type_details" />

                        </div>
                     </div> </div>
                  
                              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                              
                              <div class="col-sm-6">
                                
                                 <div class="form-group row">
                                    <label for="" class="col-sm-4 col-form-label"> <?php echo display('Vendor Address');?>
                                    <i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-8">
                                         <textarea class="form-control" tabindex="4" id="vendor_add" rows="4" cols="50"  name="vendor_add" style="border:2px solid #d7d4d6;" ></textarea>
                                       <div id="loadingText" class="loading-text"></div>
                                    </div>
                                 </div>
                              </div>
                                <input type="hidden"  value="<?php if($purchase_info[0]['payment_id']){ echo $purchase_info[0]['payment_id']; }else{ echo $payment_id_new;}?>" name="makepaymentId" class="payment_id" id="makepaymentId"/>
                              <div class="col-sm-6" id="">
                                 <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label"><?php echo display('invoice_no');  ?><i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input  class=" form-control" type="" size="50" name="invoice_no" id="invoice_no" style="border: 2px solid #d7d4d6;"   value="<?php echo $purchase_info[0]['chalan_no']; ?>"  tabindex="4" />
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
                                       <input type="date"  style="width:165%;border: 2px solid #d7d4d6;" required tabindex="2" class="form-control datepicker" name="bill_date"  placeholder="Expenses/Billdate"  value="<?php echo $purchase_info[0]['purchase_date']; ?>" id="date"  />
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
                                       <input class="form-control" type="" size="50" name="Port_of_discharge" id="date1" style="border: 2px solid #d7d4d6;"  value="<?php echo $purchase_info[0]['Port_of_discharge']; ?>"  tabindex="4" />
                                    </div>
                                 </div>
                          <div class="form-group row">
                                    <label for="billing_address" class="col-sm-4     col-form-label"><?php echo display('Payment Terms');?>
                                    <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                       <select  required  name="payment_terms" id="payment_terms" style="width:100%;border: 2px solid #d7d4d6;" class=" form-control" placeholder='Payment Terms' id="payment_terms">
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
                                      <select id="ddl"  name="account_category" class="form-control"  style="border:2px solid #d7d4d6;"  onchange="configureDropDownLists(this,document.getElementById('ddl2'))">
                                          <option value="<?php echo $purchase_info[0]['account_category']; ?>" <?php if($purchase_info[0]['account_category']) { echo 'selected'; } ?>>
                                            <?php echo $purchase_info[0]['account_category']; ?>
                                         </option>
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
                                         <input class="form-control" name ="account_subcat" id="account_subcat"  style="border: 2px solid #d7d4d6;"  value="<?php echo $purchase_info[0]['account_subcat']; ?>" type="text" tabindex="1" >
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label for="invoice_no" class="col-sm-4 col-form-label"><?php echo display('Estimated Time Of Arrival');?>
                                    </label>
                                    <div class="col-sm-8">
                                       <input type="date"  tabindex="2" class="form-control datepicker" name="eta"   style="border: 2px solid #d7d4d6;" value="<?php echo $purchase_info[0]['eta']; ?>" id="date1"  />
                                       <div id="loadingText" class="loading-text"></div>
                                    </div>
                                 </div>
                       

                                 <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label"><?php echo display('B/L No');?> </label>
                                    <div class="col-sm-8">
                                      <input type="text" name="bl_number" class="form-control"  value="<?php echo $purchase_info[0]['bl_number']; ?>"  style="border: 2px solid #d7d4d6;"  >
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
                                         <?php foreach ($attachments as $key => $attachment) { ?> 
                                       <a href="<?php  echo base_url(); ?>uploads/expense/<?php echo $attachment['files']; ?>" class="file-block" target=_blank><span class="file-delete"><span><i class="fa fa-trash-o"></i></span></span><?php echo $attachment['files']; ?></a>
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
                                       <input class=" form-control" type="date" size="50" name="payment_due_date"   style="border:2px solid #d7d4d6;"  id="payment_due_date"  value="<?php echo $purchase_info[0]['payment_due_date']; ?>" tabindex="4" />
                                    </div>
                                 </div>




                              </div>
                              <div class="col-sm-6">


                          


 <div class="form-group row">
                                    <label for="payment_type" class="col-sm-4 col-form-label"><?php
                                       echo display('payment_type');
                                       ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                       <select name="paytype_drop" id="paytype_drop" class="form-control"   tabindex="3" style="width:100;border: 2px solid #d7d4d6;">
                              <option value="<?php echo $purchase_info[0]['payment_type']; ?>"> <?php echo  $purchase_info[0]['payment_type']; ?></option>
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
                                       <select class="form-control" name="sub_category"  style="border: 2px solid #d7d4d6;"  id="ddl2">
                                         <option value="<?php echo $purchase_info[0]['sub_category']; ?>" <?php if($purchase_info[0]['sub_category']) { echo 'selected'; } ?>>
                                            <?php echo $purchase_info[0]['sub_category']; ?>
                                         </option>
                                      </select>
                                    </div>
                                 </div>







                                 <div class="form-group row">
                                    <label for="container_number" class="col-sm-4 col-form-label"><?php echo display('Container Number');?> </label>
                                    <div class="col-sm-8">
                                       <input type="text" name="container_no" value="<?php echo $purchase_info[0]['container_no']; ?>" class="form-control"   style="border: 2px solid #d7d4d6;"  >
                                    </div>
                                 </div>



                                 <div class="form-group row">
                                    <label for="supplier_sss" class="col-sm-4 col-form-label"><?php echo 'Estimated Time Of Departure';?>
                                    </label>
                                    <div class="col-sm-8">
                                       <input type="date"  tabindex="2" class="form-control datepicker" name="etd"  style="border: 2px solid #d7d4d6;"  value="<?php echo $purchase_info[0]['etd']; ?>" id="date"  />
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
               <br>
               <?php  $tax_split= $purchase_info[0]['total_tax']; 
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
                   //  print_r($purchase_info);
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
                                 <input type="text" id="bundle_no_<?php  echo $m.$n; ?>" name="bundle_no[]" required="" value="<?php  echo $inv['bundle_no'];  ?>" class="form-control" />
                              </td>
                              <td>
                                 <input type="text" id="description_<?php  echo $m.$n; ?>" name="description[]" value="<?php  echo $inv['description'];  ?>" class="form-control" />
                              </td>
                              <td >
                                 <input type="text" name="thickness[]" id="thickness_<?php  echo $m.$n; ?>" required="" value="<?php  echo $inv['thickness'];  ?>" class="form-control"/>
                              </td>
                              <td>
                                 <input type="text" id="supplier_b_no_<?php  echo $m.$n; ?>" name="supplier_block_no[]" required="" value="<?php  echo $inv['supplier_block_no'];  ?>" class="form-control" />
                              </td>
                              <td >
                                 <input type="text"  id="supplier_s_no_<?php  echo $m.$n; ?>" name="supplier_slab_no[]" required="" value="<?php  echo $inv['supplier_slab_no'];  ?>" class="form-control"/>
                              </td>
                              <td>
                                 <input type="text" id="gross_width_<?php  echo $m.$n; ?>" name="gross_width[]" required="" value="<?php  echo $inv['gross_width'];  ?>" class="gross_width  form-control" />
                              </td>
                              <td>
                                 <input type="text" id="gross_height_<?php  echo $m.$n; ?>" name="gross_height[]"  required=""  value="<?php  echo $inv['gross_height'];  ?>" class="gross_height form-control" />
                              </td>
                              <td >
                                 <input type="text"   style="width:60px;" readonly id="gross_sq_ft_<?php  echo $m.$n; ?>" name="gross_sq_ft[]" value="<?php  echo $inv['gross_sqft'];  ?>" class="gross_sq_ft form-control"/>
                              </td>
                              <td >
                                 <input type="text"  id="slab_no_<?php  echo $m.$n; ?>" name="slab_no[]" value="<?php  echo $n+1;  ?>" readonly  required="" value="<?php  echo $c;  ?>" class="form-control"/>
                              </td>
                              <td>
                                 <input type="text" id="net_width_<?php  echo $m.$n; ?>" name="net_width[]" required="" value="<?php  echo $inv['net_width'];  ?>" class="net_width form-control" />
                              </td>
                              <td>
                                 <input type="text" id="net_height_<?php  echo $m.$n; ?>" name="net_height[]"    required="" value="<?php  echo $inv['net_height'];  ?>" class="net_height form-control" />
                              </td>
                              <td >
                                 <input type="text"   style="width:60px;" readonly id="net_sq_ft_<?php  echo $m.$n; ?>" name="net_sq_ft[]" value="<?php  echo $inv['net_sq_ft'];  ?>" class="net_sq_ft form-control"/>
                              </td>
                           <td>

       <span class="input-symbol-euro"><input type="text" id="cost_sq_ft_<?php  echo $m.$n; ?>"    <?php foreach($this->session->userdata('perm_data') as $test) { $split=explode('-',$test);      if(trim($split[0])=='expenses'  && trim($split[1])=='0100'){  echo "";  } else{echo "readonly";}}?>   name="cost_sq_ft[]"   style="width:60px;"  value="<?php  echo $inv['cost_sq_ft'];  ?>"  class="cost_sq_ft form-control" ></span>

                                        
                                            <td >
                     
      <span class="input-symbol-euro"> <input type="text"  id="cost_sq_slab_<?php  echo $m.$n; ?>" name="cost_sq_slab[]"    style="width:60px;" value="<?php  echo $inv['cost_sq_slab'];  ?>"      placeholder="0.00"   class="cost_sq_slab form-control"/></span>
 


                                               
                                            </td>
                                            <td>
                                        
         <span class="input-symbol-euro">  <input type="text" id="sales_amt_sq_ft_<?php  echo $m.$n; ?>"  name="sales_amt_sq_ft[]"  style="width:60px;"  value="<?php  echo $inv['sales_amt_sq_ft'];  ?>" class="sales_amt_sq_ft form-control" /></span>



                                               
                                            </td>
                                        
                                            <td >
                                    
      <span class="input-symbol-euro">   <input type="text"  id="sales_slab_amt_<?php  echo $m.$n; ?>" name="sales_slab_amt[]"  style="width:60px;" value="<?php  echo $inv['sales_slab_amt'];  ?>"  class="sales_slab_amt form-control"/></td> </span>
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
                                 <span class="input-symbol-euro"><input  type="text" class="total_price form-control" style="width:80px;" readonly  value="<?php  echo $inv['total'];  ?>"  id="total_<?php  echo $m.$n; ?>"     name="total_amt[]"/></span>
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
                  
                   <i id="buddle_1" class="btnclr addbundle fa fa-plus" style=" padding: 10px 12px 10px 12px;margin-right: 18px;float:right;"   onclick="addbundle(); "aria-hidden="true"></i>

                    </div>
               </div>
              <table class="taxtab table table-bordered table-hover" style="border:2px solid #d7d4d6;" >
                        <tr>
                           <td class="hiden" style="width:20%;border:none;text-align:end;font-weight:bold;">
                              <?php echo display('Live Rate') ?> :
                           </td>
                           <td class="hiden btnclr" style="width:13%;text-align-last: center;padding:5px; border:none;font-weight:bold;color:white;">1 <?php echo $curn_info_default; ?>
                              = <input style="width: 80px;text-align:center;color:black;padding:5px;" type="text" id="custocurrency_rate" class="custocurrency_rate"/>&nbsp;<label for="custocurrency"  ></label>
                           </td>
                           <td style="border:none;text-align:right;font-weight:bold;"><?php echo display('Tax') ?> :
                           </td>
                           <td style="width:12%">
                           <input list="magic_tax" name="tx"  id="product_tax" class="form-control" value="<?php echo $tax_description;  ?>"  onchange="this.blur();" />
                              <datalist id="magic_tax">
                                 <?php
foreach ($tax_data as $tx) {?>
                                 <option value="<?php echo $tx['tax_id'] . '-' . $tx['tax'] . '%'; ?>">  <?php echo $tx['tax_id'] . '-' . $tx['tax'] . '%'; ?></option>
                                 <?php }?>
                              </datalist>
                           </td>
                           <td  style="width:20%;"></td>
                        </tr>
                     </table>

                  <table border="0" style="width: 80%; border-collapse: collapse; float:right;text-align: left;border:none;" class="overall table table-bordered table-hover" style="border:2px solid #d7d4d6;">

    <tbody>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="Over_all_Total"><b><?php echo display('Overall TOTAL') ?> :</b></label>
                <input type="text" id="Over_all_Total" name="Over_all_Total" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" value="<?php  echo $purchase_info[0]['total_amt'];  ?>" readonly="readonly" />
            </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="tax_details"><b><?php echo display('TAX DETAILS') ?> :</b></label>
                <input type="text" id="tax_details" name="tax_details" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" value="<?php  echo $purchase_info[0]['total_tax'];  ?>" readonly="readonly" />
          
            </td>
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="total_gross"><b><?php echo display('Overall Gross Sq.Ft') ?> :</b></label>
                <input type="text" id="total_gross" name="total_gross" value="<?php  echo $purchase_info[0]['overall_gross'];  ?>" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" readonly="readonly" />
            </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
              <label style="width:150px;" for="gtotal"><b><?php echo display('GRAND TOTAL') ?> :</b></label>
                <input type="text" id="gtotal" name="gtotal" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" value="<?php  echo $purchase_info[0]['grand_total_amount'];  ?>" readonly="readonly" />
            </td>
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="total_net"><b><?php echo display('Overall Net Sq.Ft') ?> :</b></label>
                <input type="text" id="total_net" name="total_net" class="form-control" value="<?php  echo $purchase_info[0]['overall_net'];  ?>" style="width: 150px; margin-left: 10px; display: inline-block;" readonly="readonly" />
            </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                  <label style="width:150px;" for="customer_gtotal"><b><?php echo display('Preferred Currency') ?> :</b></label>
                <input type="text" id="customer_gtotal" name="customer_gtotal" class="form-control" value="<?php  echo $purchase_info[0]['gtotal_preferred_currency']; ?>" style="width: 150px; margin-left: 10px; display: inline-block;" readonly />
          </td>
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="total_weight"><b><?php echo display('Overall Weight') ?> :</b></label>
                <input type="text" id="total_weight" name="total_weight" class="form-control" value="<?php  echo $purchase_info[0]['total_weight']; ?>"  style="width: 150px; margin-left: 10px; display: inline-block;" readonly="readonly" />
            </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="amount_paid"><b><?php echo display('Amount Paid') ?> :</b></label>
                <input type="text" id="amount_paid" name="amount_paid" class="form-control" value="<?php  echo $purchase_info[0]['paid_amount']; ?>"  style="width: 150px; margin-left: 10px; display: inline-block;" readonly />
         </td>
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
             </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="balance"><b><?php echo display('Balance Amount') ?> :</b></label>
                <input type="text" id="balance" name="balance" class="form-control" value="<?php  echo $purchase_info[0]['balance']; ?>" style="width: 150px; margin-left: 10px; display: inline-block;" readonly />
            </td>
        </tr>
    </tbody>
<tfoot>
        <tr style="border-right:none; border-left:none; border-bottom:none; border-top:none;">
            <td colspan="2" style="text-align: right; padding: 20px;">
           <?php   if($purchase_info[0]['payment_id']=='') { ?>
              <a class="client-add-btn btn btnclr" aria-hidden="true" id="paypls" data-toggle="modal" data-target="#payment_modal">
                        Make Payment
             </a>
           <?php  }  ?>
            </td>
        </tr>
    </tfoot>
</table>
                           
      <div class="row">
      <div class="col-sm-12">
      <div class="form-group row">
      <label for="adress" class="col-sm-2 col-form-label"><?php echo  display('Remarks / Details');?>
      </label>
      <div class="col-sm-10">
           <textarea class="form-control" rows="4" cols="50" id="remark" name="remark" placeholder="Remarks"  style="border: 2px solid #d7d4d6;" rows="1"><?php echo  $purchase_info[0]['remarks']; ?></textarea>

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
             <textarea class="form-control" rows="4" cols="50" id="adress" name="message_invoice"  style="border: 2px solid #d7d4d6;"  placeholder="Message on Invoice" rows="1"><?php echo  $purchase_info[0]['message_invoice']; ?></textarea>

      </div>
      </div> 
      </div>
      </div>
         
      </div>
      <div class="form-group row" style="
         margin-top: 1%;
         ">
      <div class="col-sm-6">
      <table>
      <tr>
      <td>
      <input type="submit" id="add_purchase"   class="btnclr btn btn-large" name="add-packing-list" value="<?php echo display('save'); ?>" />
      </td>
        <td style="width:20px;"></td>
      <td class="button_hide"> 
      <a    id="final_submit"  class='btnclr final_submit btn expense_submit'><?php echo display('submit'); ?></a>
      </td>
        <td style="width:20px;"></td>
      <td class="button_hide">         
      <select name="download_select" id="download_select" class="form-control" style="background-color:<?php echo $setting_detail[0]['button_color']; ?>;width: auto;color:white;" >
      <option value="Download" selected><?php echo display('download'); ?></option>
      <option value="Invoice" ><?php echo  display('New Invoice');?></option>
      <option value="Packing" ><?php echo  display('Packing List');?></option>
      </select>
      </td>   
      <td style="width:20px;"></td>
      <td class="button_hide">
   
      <select name="print_select" id="print_select" class="form-control" style="background-color:<?php echo $setting_detail[0]['button_color']; ?>;width: auto;color:white;" >
      <option value="Print" selected><?php echo display('print');  ?></option>
      <option value="Invoice" ><?php echo  display('New Invoice');?></option>
      <option value="Packing" ><?php echo  display('Packing List');?></option>
      </select>
      </td>                   
      </tr>
      </table>
      </div>
      </div> </div>
      </form>
   </div>
  <div class="modal fade" id="payment_history_modal" role="dialog">
   <div class="modal-dialog" style="margin-right: 1100px;">
      <!-- Modal content-->
      <div class="modal-content" style="width: 1500px;margin-top: 190px;text-align:center;">
         <div class="modal-header btnclr" >
            <button type="button" id="history_close" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?php echo display('PAYMENT HISTORY') ?></h4>
         </div>
         <div class="modal-body1">
            <form method='post' id='bulk_payment_form'>
                 <div id="payment_error"></div>
                 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
            <div id="salle_list"></div>
                                       </form>
         </div>
         <div class="modal-footer">
         </div>
      </div>
   </div>
</div>

<input type="hidden" id="Final_invoice_number" /> 
<input type="hidden" id="Final_invoice_id" /> 


<div id="packmodal" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content" style="width: 163%;">
      <div class="modal-header btnclr " >
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Choose your Package </h4>
         </div>
         <div class="modal-body">
            <table class="table table-bordered">
               <tr>
                  <th>Choose your Package   </th>
                  <th>Sno</th>
                  <th>Novice No</th>
                  <th>Expense Packing ID</th>
                  <th>Gross Weight</th>
                  <th>Container NO</th>
                  <th>Thickness</th>
                  <th>Invoice Date</th>
               </tr>
               <?php 
                  $i=0;
                  foreach($packinglist as $pack)
                      { ?>
               <tr>
                  <td><input type="radio" name="packing" id="packing" onclick="packing('<?php echo $pack['invoice_no']; ?>')" ></td>
                  <td><?php echo $j=$i+1; ?></td>
                  <td><?php echo $pack['invoice_no']; ?></td>
                  <td><?php echo $pack['expense_packing_id']; ?></td>
                  <td><?php echo $pack['gross_weight']; ?></td>
                  <td><?php echo $pack['container_no']; ?></td>
                  <td><?php echo $pack['thickness']; ?></td>
                  <td><?php echo $pack['invoice_date']; ?></td>
               </tr>
               <?php $i++; } ?>
            </table>
         </div>
      </div>
   </div>
</div>
 <?php $date = date('Y-m-d');  ?>
<input type="hidden" id="invoice_hdn"/> <input type="hidden" id="invoice_hdn1"/>
<script type="text/javascript">
   var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
    var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
   $(document).ready(function(){
      $(".normalinvoice").each(function(i,v){

          $(this).find('select').each(function() {
    var $select = $(this);
   if ($select.data('select2')) {
        $select.select2('destroy');
    }
    $select.select2();
});

       if($(this).find("tbody").html().trim().length === 0){
           $(this).hide()
       }
    })

                              

    $('.normalinvoice tbody tr').each(function() {
        var tableId = $(this).closest('table').attr('id');
 
        updateTableTotals(tableId);
        updateOverallTotals(true);
                    });
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
   // $('#supplier_id').on('change', function (e) {getSupplierInfo($(this).val())});
   // $(document).ready(function(){ getSupplierInfo($('#supplier_id').val()) });

   $('#isf_dropdown1').on('change', function() {
     if ( this.value == '2')
       $("#isf_no1").show();
     else
       $("#isf_no1").hide();
   }).trigger("change");
   

      $('.final_submit').on('click', function (e) {
    var input_hdn='Your Invoice No : "'+ $('#Final_invoice_number').val()+" has been Updated Successfully";
 $('#errormessage_expense').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + input_hdn + '</div>');
   window.setTimeout(function(){
      window.location = "<?php  echo base_url(); ?>Cpurchase/manage_purchase?id=<?php echo $_GET['id']; ?>";
     }, 2000);
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
           url:"<?php echo base_url(); ?>Cpurchase/payment_history_purchase",
           data:$("#histroy").serialize(),
           success:function (data) {
       
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
   if ( $('#isf_dropdown1').val() == '2'){
       $(".isf_no1").show();
   }else{
       $(".isf_no1").hide();
 }
    $('#current_in_id').val($('#invoice_no').val());
        payment_update();
    });
   
   
  function payment_info(){
      
     var data = {
          gtotal:$('#customer_gtotal').val(),
          customer_name:$('#customer_name').val()
     
       };
       data[csrfName] = csrfHash;
   
       $.ajax({
           type:'POST',
           data: data, 
        dataType:"json",
           url:'<?php echo base_url();?>Cpurchase/payment_history_purchase',
           success: function(result, statut) {
               if(result[0]['amt_paid']){
      $('#amount_paid').val(amtpd);
    }else{
       $('#amount_paid').val("0.00");
    }
          $("#balance").val(result[0]['balance']);
               console.log(result);
           }
       });
   }
   $('#payment_from_modal').on('input',function(e){
   
   var payment=parseFloat($('#payment_from_modal').val());
   var amount_to_pay=parseFloat($('#amount_to_pay').val());
   console.log(payment.toFixed(2)+"/"+amount_to_pay.toFixed(2));
   console.log(parseFloat(amount_to_pay.toFixed(2))-parseFloat(payment.toFixed(2)));
   var value=parseFloat(amount_to_pay.toFixed(2))-parseFloat(payment.toFixed(2));
   $('#balance_modal').val(value.toFixed(2));
   if (isNaN(value)) {
    $('#balance_modal').val("0");
     }
   });
       
    
   $(document).on('click','.paypls',function (e) {
   $('#amount_to_pay').val($('#balance').val());
       $('#payment_modal').modal('show');
     e.preventDefault();
   
   });
      

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
   
  var gtotal = parseFloat($('#gtotal').val()) || 0; 
 var overall_total = parseFloat($('#Over_all_Total').val()) || 0;

          if($('#product_tax').val()) {
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
                   $('#tax_details').val(answer.toFixed(2) +" ( "+tax+" )");
          }
        var additional_cost='';
         if($('#landing_amount').val()){
           $('#additional_cost').val(parseFloat($('#landing_amount').val()));
 additional_cost= parseFloat($('#additional_cost').val()) || 0; 
         }
        var tax_amount = (overall_total * tax) / 100;
      
         overall_total = parseFloat(overall_total) || 0;
 tax_amount = parseFloat(tax_amount) || 0;
 additional_cost = parseFloat(additional_cost) || 0;
  var amt=parseFloat(answer)+parseFloat(total);
                 var num = isNaN(parseFloat(amt)) ? 0 : parseFloat(amt);
                  var additional_cost =parseFloat($('#additional_cost').val()) || 0;
                   $('#gtotal').val((num+additional_cost).toFixed(2)); 
if(num <= 0){
   $('#gtotal').val((overall_total+additional_cost).toFixed(2)); 
}
 var paid_amount =parseFloat($('#amount_paid').val()) || 0;
    
       var balance_amount= gtotal- paid_amount;
    $('#balance').val(balance_amount);

 var custo_amt = parseFloat($('.custocurrency_rate').val()) || 1;
        var customer_prefered_currency = gtotal * custo_amt;
        $('#customer_gtotal').val(customer_prefered_currency.toFixed(2));
        $('#balance_customer_currency').val((balance_amount*custo_amt).toFixed(2));
      $('#paid_customer_currency').val((paid_amount*custo_amt).toFixed(2));

 
   
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
         // var tableId = $row.closest('table').attr('id');
         var tableId = $(this).closest('table').attr('id');

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
//  var tableId = $row.closest('table').attr('id');
 var tableId = $(this).closest('table').attr('id');

    updateTableTotals(tableId);
  updateOverallTotals(true);
}

 


$(document).on('click', '.delete', function(){
   var $tableBody = $(this).closest('tbody');
    var rowCount = $tableBody.find('tr').length;
  if (rowCount > 1) {
        $(this).closest('tr').remove();
  updateTableTotals($tableBody.closest('table').attr('id'));
//   updateTableTotals($tableBody.closest('table').attr('id'));

        updateOverallTotals(true);
    } else {
        $('#errormessage_expense').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + 'You cannot delete the last row. At least one row must remain..' + '</div>');
    }
});


              
$('#supplier_id').on('change', function (e) {
  var data = {
    value: $('#supplier_id').val()
  };
  data[csrfName] = csrfHash;
  
  $.ajax({
    type: 'POST',
    data: data,
    dataType: 'json',
    url: '<?php echo base_url();?>Cinvoice/getvendor',
    success: function (result, statut) {
      if (result.csrfName) {
        csrfName = result.csrfName;
        csrfHash = result.csrfHash;
      }

 $('#vendor_add').html(result[0]['address']);
                   $('#vendor_type_details').val(result[0]['vendor_type']);
               

      console.log(result[0]['currency_type']);
      $(".cus").html(result[0]['currency_type']);
      $("label[for='custocurrency']").html(result[0]['currency_type']);
      console.log('https://open.er-api.com/v6/latest/<?php echo $curn_info_default; ?>');
      
      $.getJSON('https://open.er-api.com/v6/latest/<?php echo $curn_info_default; ?>', function (data) {
        var custo_currency = result[0]['currency_type'];
        var x = data['rates'][custo_currency];
        var Rate = parseFloat(x).toFixed(3);
        Rate = isNaN(Rate) ? 0 : Rate;
        console.log(Rate);
      
        $(".custocurrency_rate").val(Rate);
      });



    }
  });
});
 $('#product_tax').on('change', function (e) {
  
  var total=$('#Over_all_Total').val();
 var tax= $('#product_tax').val();
if(tax.indexOf(hypen) != -1){
 var field = tax.split('-');

 var percent = field[1];

}else if(tax=='Select the Tax'){

  percent="0";
}

else{
percent=tax;
}
 percent=percent.replace("%","");
  var answer = (percent / 100) * parseFloat(total);

  
   var gtotal = parseFloat(total + answer);
   var amt=parseFloat(answer)+parseFloat(total);
  var num = isNaN(parseFloat(amt)) ? 0 : parseFloat(amt)
    $('#gtotal').val(num); 
  var custo_amt=$('.custocurrency_rate').val(); 
  console.log("numhere :"+num +"-"+custo_amt);
  var value=num*custo_amt;
  var custo_final = isNaN(parseFloat(value)) ? 0 : parseFloat(value)
 $('#customer_gtotal').val(custo_final);  

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

   $('#errormessage_expense').html('<div class="alert alert-success">' + response.msg + '</div>');
     $('#Final_invoice_number').val(response.invoice_no);
          $('#Final_invoice_id').val(response.invoice_id);
         
                  }else{

          $('#errormessage_expense').html(failalert+response.msg+'</div>'); 
          console.log(response.msg, "Error");
       }                  
    },
        error: function(xhr, status, error) {
        alert('An error occurred: ' + error);
    }
  })
}
});
   function generateRandom10DigitNumber() {
    const min = Math.pow(10, 9); // 10^9
    const max = Math.pow(10, 10) - 1; // 10^10 - 1
    const randomNumber = Math.floor(Math.random() * (max - min + 1)) + min;
    return randomNumber;
}

$(document).on('click', '#pay_now', function (event) {
    event.preventDefault();
 var dataString = {
                          dataString : $('#bulk_payment_form').serialize()
                     };
                     dataString[csrfName] = csrfHash;
    $.ajax({
        type: 'POST',
        data: $('#bulk_payment_form').serialize(),
        dataType: 'json',
         url: '<?php echo base_url();?>Cpurchase/bulk_payment',
 


success: function (response) {
    if (response.status == 'success') {
        $('#payment_error').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + 'Payment Details Updated Successfully' + '</div>');
       
   
           
      window.setTimeout(function(){
       
   location.reload();

      
  });
    }}
});
});
 $('#product_tax').on('change', function (e) {
  
  var total=$('#Over_all_Total').val();
 var tax= $('#product_tax').val();
if(tax.indexOf(hypen) != -1){
 var field = tax.split('-');

 var percent = field[1];

}else if(tax=='Select the Tax'){

  percent="0";
}

else{
percent=tax;
}
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
               t_amt_paid : $('#tl_amt_pd').val(),
            t_bal_amt : $('#my_bal_1').val(),
            bill_bo : $('#invoice_no').val(),
            create_by : $('#admin_company_id').val()
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
        url: "<?php echo base_url(); ?>Cinvoice/payment_edit_exp",
        data: postData,
         success: function (response) {
             $('#payment_history_modal').modal('hide');
              $("#bodyModal1").html("Updated Successfully");
   $('#myModal1').modal('show');
   window.setTimeout(function(){
       $('.modal').modal('hide');
      
$('.modal-backdrop').remove();
},2000);
        },
        error: function (error) {
          $('#payment_history_modal').modal('hide');
            $("#bodyModal1").html("Updated Successfully");
   $('#myModal1').modal('show');
   window.setTimeout(function(){
       $('.modal').modal('hide');
      
$('.modal-backdrop').remove();
},2000);
        }
    });

  
    event.preventDefault();
});
    $('#payment_history').click(function (event) {
        $('#current_in_id').val($('#invoice_no').val());
    var dataString = {
        dataString: $("#histroy").serialize()
    };
    dataString[csrfName] = csrfHash;

    $.ajax({
        type: "POST",
        dataType: "json",
      url:"<?php echo base_url(); ?>Cpurchase/payment_history_purchase",
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
            
            
          
               var total = "<table id='table2' class='newtable table table-striped table-bordered'><tbody><tr><td rowspan='2' style='vertical-align: middle;text-align-last: center;'><b>Grand Total :  <?php  echo $currency;  ?>"+$('#customer_gtotal').val()+"<b></td><td class='td' style='text-align:end;border-right: hidden;'><b>Total Amount Paid :<b></td><td style='text-align:start;'><?php  echo $currency;  ?><span class='amt_paid_update'><input type='text' id='tl_amt_pd' value='"+data.amt_paid+"' name='tl_amt_pd'/></span></td><td><input type='hidden' value='"+$('#customer_gtotal').val()+"' name='t_unique'/><span style='font-weight:bold;'>INVOICE NO</span> :<input type='hidden' id='unq_inv' value='"+$('#invoice_no').val()+"' name='unq_inv'/>"+$('#invoice_no').val()+"</td>               <td rowspan='2' style='vertical-align: middle;text-align-last: center;'><b>Advance :   <input type='text' name='advanceamount' id='advanceamount' readonly ></td>                                                      </tr><tr><td class='td' style='text-align:end;'><b>Balance :<input type='text' id='my_bal_1' value='"+bal+"' name='my_bal_1'/><b></td><td class='due_pay' style='display:none;' id='balance-cell' data-currency='<?php  echo $currency;  ?>'>"+bal +"</td><td  data-currency='<?php echo $currency; ?>'><span style='font-weight:bold;'>Amount to Pay : </span><input type='text' id='amount_pay_unique' class='amount_pay' readonly='readonly' style='text-align:center;' name='amount_pay_1'/></td><td style='display:none'><input type='text'  value='<?php if($purchase_info[0]['payment_id']){ echo $purchase_info[0]['payment_id']; }else{ echo $payment_id_new;}?>' name='payment_id_this_invoice' class='payment_id_val' id='payment_id'/></td><td style='display:none' class='' data-currency='<?php echo $currency; ?>'><input type='text' name='updated_bal_uniq' class='balance-col'/></td><td> <input type='text' id='total-amount' placeholder='Enter Amount To Distribute'></td></tr></tbody></table>"
             var table_header1 = "<div> </div>  <thead><tr><td ><input type='hidden'  value='<?php  echo $purchase_info[0]['supplier_id'];  ?>' name='supplier_id' /></tr></thead><tbody>";
                   var table_header = "<div class='toggle-button' onclick='toggleTable()'>Payment History &#9660;</div><table id='toggle_table' class='table table-striped table-bordered'><thead style='FONT-WEIGHT:BOLD;'><tr><td style='display:none;'><input type='text'  value='<?php if($purchase_info[0]['payment_id']){ echo $purchase_info[0]['payment_id']; }else{ echo $payment_id_new;}?>' name='payment_id_this_invoice' class='payment_id_val' id='payment_id_this_invoice'/></td><td>Payment Date</td><td>Reference.NO</td><td>Bank Name</td><td>Amount Paid</td><td>Balance</td><td>Details</td>   </tr></thead><tbody>";
                   
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
    "<td class='balance-cell' contenteditable='false'>" + "<span class='balist' style='pointer-events: none;'>" +  element.balance +"</span>" +
    "<input type='text' class='edit_balance' name='edit_balance' /></td>" +
    "<td contenteditable='true'>" + element.details + "</td>" +
    "<td style='display:none;'><input type='text' class='payment_id_val' id='payment_id'/></td>" +
     "</tr>";
                count++;
            });
            

            var all = total + table_header + html + table_footer +table_header1;

         
            var total1 = "<input type='hidden' name='<?php echo $this->security->get_csrf_token_name();?>' value='<?php echo $this->security->get_csrf_hash();?>'><table id='table1'  class='table table-striped table-bordered'><tr><td colspan='3' style='border-top: hidden!important;background-color: white;text-align:center;font-weight:bold;font-size:18px;'>LIST OF DUE INVOICES</td></tr><tr><td rowspan='2' style='vertical-align: middle;text-align-last: center;'><b>Grand Total :  <?php  echo $currency;  ?>"+overallGTotal.toFixed(2)+"<b></td><td class='td' style='text-align:center;border-right: hidden;'><b>Total Amount Paid :<b></td><td><?php  echo $currency;  ?>"+overall_paid.toFixed(2)+"</td></tr></tr><td class='td' style='border-right: hidden;'><b>Balance :<b></td><td style='text-align:start;' class='bcm'  id='balance-cell' data-currency='<?php  echo $currency;  ?>'>"+parseFloat(overall_due.toFixed(2)) +"</td></tr></table>"

          
            var table_header1 = "<table class='newtable-second table table-striped table-bordered'><thead style='FONT-WEIGHT:BOLD;'><tr><td style='width:30px;'><div id='distribute-container'> </div></td><td style='width:60px;'>Invoice No</td><td style='width:100px;'>Total Amount</td><td style='width:200px;'>Amount Paid</td><td style='width:200px;'>Balance</td><td style='width:200px;'>Amount to Pay</td><td class='balance-column' style='width:200px;'>Updated Balance</td></tr></thead><tbody>";
            var table_footer1 = "</tbody><tfoot><tr><td colspan='5'></td><td class='t_amt_pay'></td><td  style='display:none;' class='balance-col t_bal_pay'></td></tr></tfoot></table>";

           
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
            html1 += "<tr><td style='display:none;'><input type='hidden' value='"+random10DigitNumber+"' name='payment_id[]'/></td><td> <input type='text'  value='"+count1+"' class='checkbox-distribute'></td><td><input type='text' readonly style='text-align:center;'  value='" + element.chalan_no + "' name='invoice_no[]'/></td><td><input type='text' readonly  class='g_pament' value='" + element.grand_total_amount + "' name='total_amt[]' style='text-align:center;'/></td><td>" + element.paid_amount + "</td><td class='due_pay' data-currency='<?php echo $currency; ?>'>" + element.balance + "</td><td  data-currency='<?php echo $currency; ?>'><input type='text' id='amount_pay' class='amount_pay' style='text-align:center;' name='amount_pay[]'/></td><td    class='balance-column' data-currency='<?php echo $currency; ?>'><input type='text' name='updated_bal[]' readonly class='balance-col'/></td></tr>";
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
 final=parseFloat(amount_to_distribute)-parseFloat(total_balance_amount);
 if (final > 0) {
     $('#advanceamount').val(final);
 }else{
   $('#advanceamount').val('0.00');
 }
});
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
        var payment_id = "<?php if($payment_id){ echo $payment_id; }else{ echo $payment_id_new;}?>";

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
   
   
  
   
</script>

<style>
   .table  tbody td{
      text-align:initial;
   }
     .newtable-second,.table th ,.table tbody {
    text-align:center;
  }
 #toggle_table{
  text-align:center;
 }
   
   #table1,#table2,.newtable {
   text-align:center;
}
   .ui-front,  .ui-selectmenu-text{
   display:none;
   }
   #files-area{
   /*  width: 30%;*/
   margin: 0 auto;
   }
   .file-block{
   border-radius: 10px;
   background-color: #38469f;
   margin: 5px;
   color: #fff;
   display: inline-flex;
   padding: 4px 10px 4px 4px;
   }
   .file-delete{
   display: flex;
   width: 24px;
   color: initial;
   background-color: #38469f;
   font-size: large;
   justify-content: center;
   margin-right: 3px;
   cursor: pointer;
   color: #fff;
   }
   span.name{
   position: relative;
   top: 2px;
   }
   .btn-primary {
   color: #fff;
   background-color: #38469f !important;
   border-color: #38469f !important;
   }
   a:active{
    color: #fff !important;
   }

   a:hover{
    color: #fff !important;
   }

   a:focus{
    color: #fff !important;
   }
 
</style>


<script type="text/javascript">

   
   
   
   
   
   
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
 


 $(document).on('click', '.removebundle', function(){
                     var remove_id=$(this).closest('table').attr('id');
                     $('#'+remove_id).remove();
                     updateOverallTotals(true);
                     });




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
</script>

 















