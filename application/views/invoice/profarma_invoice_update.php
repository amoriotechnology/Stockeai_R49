<div class="content-wrapper">
<section class="content-header">
   <div class="header-icon">
     <figure class="one">
         <img src="<?php echo base_url()  ?>asset/images/quota.png"  class="headshotphoto" style="height:50px;" />
      </figure>
   </div>
      
     <div class="header-title">
         <div class="logo-holder logo-9">
         <h1><?php echo display ('Edit Quotation') ?></h1>
      </div>

      <small></small>
         <ol class="breadcrumb" style="border: 3px solid #d7d4d6;">
         <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
         <li><a href="#"> <?php echo display ('Sale') ?></a></li>
         <li class="active" style="color:orange;"><?php echo display ('Edit Quotation') ?></li>
    
        <div class="load-wrapp">
            <div class="load-10">
               <div class="bar"></div>
            </div>   
         </div>
    
      </ol>
   </div>
     
</section>
<section class="content">
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
   <div class="alert alert-danger alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <?php echo $error_message ?>                    
   </div>
   <?php 
      $this->session->unset_userdata('error_message');
      }
      ?>
   <style>
      th{
      font-size:14px;
      }
      .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
      padding: 5px; 
      }
      .ui-front{
      display:none;
      } 
      .ui-selectmenu-text{
      display:none;
      }
      input {
      border: none;
      }
      textarea:focus, input:focus{
      outline: none;
      }
      .text-right {
      text-align: left; 
      }
      .input-symbol-euro {
      position: absolute;
      font-size: 14px;
      }
      .input-symbol-euro input {
      padding-left: 18px;
      }
      .input-symbol-euro:after {
      position: absolute;
      top: 7px;
      content: '<?php echo $currency; ?>';
      left: 5px;
      }
      .select2-selection{
      display:none;
      }
      
      
     .logo-9 i{
    font-size:80px;
    position:absolute;
    z-index:0;
    text-align:center;
    width:100%;
    left:0;
    top:-10px;
    color:#34495e;
    -webkit-animation:ring 2s ease infinite;
    animation:ring 2s ease infinite;
}
.logo-9 h1{
    font-family: 'Lora', serif;
    font-weight:600;
    text-transform:uppercase;
    font-size:40px;
    position:relative;
    z-index:1;
    color:#e74c3c;
    text-shadow: 3px 3px 0 #fff, -3px -3px 0 #fff, 3px -3px 0 #fff, -3px 3px 0 #fff;
}
   
   
  
   .logo-9{
    position:relative;
} 
   
   /*//side*/
   
.bar {
  float: left;
  width: 25px;
  height: 3px;
  border-radius: 4px;
  background-color: #4b9cdb;
}


.load-10 .bar {
  animation: loadingJ 2s cubic-bezier(0.17, 0.37, 0.43, 0.67) infinite;
}


@keyframes loadingJ {
  0%,
  100% {
    transform: translate(0, 0);
  }

  50% {
    transform: translate(80px, 0);
    background-color: #f5634a;
    width: 120px;
  }
}

    #details {
      width: 100%;
    height: 106px;
}
#remarks{
      width: 100%;
    height: 106px;
}
    
      
   </style>
   <!-- Purchase report -->
   <div class="row">
      <div class="col-sm-12">
         <div class="panel panel-bd lobidrag"  style="border: 3px solid #d7d4d6;"   >
            <div class="panel-heading" style="height: 60px;">
               <div class="panel-title">
                  <div class="Row">
                     <div class="Column" style="float: left;">
                        <h4><?php //echo "Create Invoice" ?></h4>
                     </div>
                     <div class="Column" style="float: right;">
                        <form id="histroy" method="post">
                           <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                           <input type="submit" id="payment_history" name="payment_history" class="btn btnclr" style="float:right;" value="<?php echo display('Payment History') ?>" style="float:right;margin-bottom:30px;"/>
                           <input type="hidden" name="paymentIds" id="paymentIds" value="<?php echo $paymentid; ?>"/>
                        </form>
                     </div>
                     <div class="Column" style="float: right;">
                        <a   href="<?php echo base_url('Cinvoice/manage_profarma_invoice?id=' . $_GET['id']); ?>" class="btnclr btn  m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo "Manage Quotation" ?> </a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="panel-body">
               <form id="insert_trucking"  method="post">
               <div class="displaymessage"></div>
               <br>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group row">
                           <label for="date" class="col-sm-4 col-form-label"> <?php echo display('Date') ?>
                           <i class="text-danger">*</i>
                           </label>
                           <div class="col-sm-8">
                              <?php $date = date('Y-m-d'); ?>
                              <input type="date" required tabindex="2" class="form-control datepicker" name="purchase_date" value="<?php echo $date; ?>" id="date"  style="border: 2px solid #d7d4d6;width:100%;"> 

                              <input type="hidden" name="admin_company_id" id="admin_company_id" value="<?php echo $_GET['id']; ?>">
                              <input type="hidden" name="makepaymentId" id="makepaymentId" value="<?php echo $paymentid; ?>"/>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group row">
                           <label for="adress" class="col-sm-4 col-form-label"><?php echo display('Buyer / Customer') ?> <i class="text-danger">*</i>
                           </label>
                           <div class="col-sm-8">
                              <select name="customer_id" id="customer_id" class="form-control"  style="border: 2px solid #d7d4d6;width:100%;" >
                                 <option selected value="<?php echo $customer_id; ?>"><?php echo $customer_name; ?></option>
                                 <?php foreach($customer as $customer){ ?>
                                 <option value="<?=$customer['customer_id']; ?>"><?=$customer['customer_name']; ?></option>
                                 <?php } ?>
                              </select>
                              
                           </div>
                        </div>
                     </div>
                  </div>
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group row">
                           <label for="invoice_no" class="col-sm-4 col-form-label"><?php echo display('invoice_no') ?>
                           <i class="text-danger"></i>
                           </label>
                           <div class="col-sm-8">
                              <input type="text" tabindex="3" class="form-control" id="chalan_no" name="chalan_no"  style="border: 2px solid #d7d4d6;"   value="<?php echo $chalan_no; ?>" readonly />
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group row">
                           <label for="eta" class="col-sm-4 col-form-label"><?php echo display('Place of Receipt') ?>
                           </label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control" tabindex="4" id="eta" name="receipt" value="<?php echo $receipt; ?>" placeholder="Place of Receipt"  style="border: 2px solid #d7d4d6;width:100%;"   />
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group row">
                           <label for="etd" class="col-sm-4 col-form-label"><?php echo display('Pre Carriage') ?>
                           <i class="text-danger"></i>
                           </label>
                           <div class="col-sm-8">
                              <input type="text" tabindex="3" class="form-control" name="pre_carriage" value="<?php echo $pre_carriage; ?>" id="pre_carriage" style="border: 2px solid #d7d4d6;"  placeholder="Pre Carriage By" id="etd" />
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group row">
                           <label for="bl_number" class="col-sm-4 col-form-label"><?php echo display('Description of goods') ?>
                           <i class="text-danger"></i>
                           </label>
                           <div class="col-sm-8">
                              <input type="text"  name="description_goods" value="<?php echo $description_goods; ?>"  class=" form-control" style="border: 2px solid #d7d4d6;"  placeholder='Polished Granite slabs' id="goods"> 
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group row">
                           <label for="shipping_line" class="col-sm-4 col-form-label"><?php echo display('Country of origin of goods') ?>
                           <i class="text-danger"></i>
                           </label>
                           <div class="col-sm-8">
                              <select class="selectpicker countrypicker form-control"  data-live-search="true"  name="country_goods" id="shipping_line" style="border: 2px solid #d7d4d6;width:100%;">
                                 <?php 
                                 foreach (getAllCountries() as $conval) {
                                    $selectcon = $conval['iso3'] == $country_goods ? 'selected' : '';
                                    echo '<option ' . $selectcon . ' value="' . $conval['name'] . '">' . $conval['name'] . '</option>';
                                 } ?>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group row">
                           <label for="container_no" class="col-sm-4 col-form-label"><?php echo display('Country of final destination') ?>
                           </label>
                           <div class="col-sm-8">
                              <select class="selectpicker countrypicker form-control" data-live-search="true" id="container_no" name="country_destination" placeholder="Country of final destination" style="border: 2px solid #d7d4d6;width:100%;" >
                                 <?php 
                                 foreach (getAllCountries() as $conval) {
                                    $selectcon = $conval['iso3'] == $country_destination ? 'selected' : '';
                                    echo '<option ' . $selectcon . ' value="' . $conval['name'] . '">' . $conval['name'] . '</option>';
                                 } ?>
                              </select>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group row">
                           <label for="bl_number" class="col-sm-4 col-form-label"><?php echo display('Port of loading') ?>
                           <i class="text-danger"></i>
                           </label>
                           <div class="col-sm-8">
                              <input type="text" tabindex="3" class="form-control" value="<?php echo $loading; ?>" name="loading" placeholder="Port of loading"  style="border: 2px solid #d7d4d6;"  id="bl_number" />
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group row">
                           <label for="bl_number" class="col-sm-4 col-form-label"><?php echo display('Port of discharge') ?>
                           <i class="text-danger"></i>
                           </label>
                           <div class="col-sm-8">
                              <input type="text" tabindex="3" value="<?php echo $discharge; ?>" class="form-control" name="discharge" placeholder="Port of discharge"  style="border: 2px solid #d7d4d6;"  id="bd_number" />
                           </div>
                        </div>
                     </div>
                  </div>
                  <input type="hidden" id="invoice_hdn"/> <input type="hidden" id="invoice_hdn1"/>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group row">
                           <label for="bl_number" class="col-sm-4 col-form-label"><?php echo display('Terms of payment and delivery') ?>
                           <i class="text-danger"></i>
                           </label>
                           <div class="col-sm-8">
                              <input type="text" tabindex="3" class="form-control" value="<?php echo $terms_payment; ?>" name="terms_payment" style="border: 2px solid #d7d4d6;"   placeholder="Terms of payment and delivery" id="delivery" />
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group row">
                           <label for="bl_number" class="col-sm-4 col-form-label"><?php echo display('Attachments')?>
                           <i class="text-danger"></i>
                           </label>
                           <div class="col-sm-8">
                              <p>
                                 <label for="attachment">
                                 <a class="btnclr btn   text-light" role="button" aria-disabled="false"><i class="fa fa-upload"></i>&nbsp; Choose Files</a>
                                 </label>
                                 <input type="file" name="files[]" class="upload" id="attachment" style="visibility: hidden; position: absolute;" multiple accept=".pdf, .docx, .txt, .png, .jpeg, .jpg" />
                                 <br>
                                 <?php if (!empty($viewattachments)) { ?>
                                    <?php foreach ($viewattachments as $attachment) { ?>
                                    <a href="<?php echo base_url() . rtrim($attachment['image_dir'], '/') . '/' . $attachment['files']; ?>" class="image-block name" target="_blank"><i class="fa fa-trash-o proforma-file-delete" aria-hidden="true"></i>
                                          <?php echo $attachment['files']; ?>
                                    </a>
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
                           for($m=1;$m<count($purchase_info);$m++){ ?>
                        <table class="table normalinvoice table-bordered table-hover" id="normalinvoice_<?php  echo $m; ?>" style="width: -webkit-fill-available;border: 2px solid #d7d4d6;"    >
                           <thead>
                              <tr>
                                 <th rowspan="2" class="text-center" style="width:180px;" ><?php echo display('product_name')?><i class="text-danger">*</i>  &nbsp;&nbsp; </th>
                                 <th rowspan="2" class="text-center" style="width:60px;"><?php echo display('Bundle No')?><i class="text-danger">*</i></th>
                                 <th rowspan="2"  class="text-center"><?php echo display('Description')?></th>
                                 <th rowspan="2" class="text-center" style="width:60px;"><?php echo display('Thick ness')?><i class="text-danger">*</i></th>
                                 <th rowspan="2" class="text-center"><?php echo display('Supplier Block No')?><i class="text-danger">*</i></th>
                                 <th rowspan="2" class="text-center" ><?php echo display('Supplier Slab No')?><i class="text-danger">*</i> </th>
                                 <th colspan="2"   style="width:150px;" class="text-center"><?php echo display('Gross Measurement')?><i class="text-danger">*</i> </th>
                                 <th rowspan="2" class="text-center"><?php echo display('Gross Sq.Ft')?></th>
                                 <th rowspan="2" style="width:40px;" class="text-center"><?php echo display('Slab No')?><i class="text-danger">*</i></th>
                                 <th colspan="2"  style="width:150px;" class="text-center"><?php echo display('Net Measure')?><i class="text-danger">*</i></th>
                                 <th rowspan="2" class="text-center"><?php echo display('Net Sq. Ft')?></th>
                                 <th rowspan="2"  style="width:90px;" class="text-center"><?php echo display('Cost per Sq.Ft')?>($)</th>
                                 <th rowspan="2"  style="width:90px;" class="text-center"><?php echo display('Cost per Slab')?>($)</th>
                                 <th rowspan="2"  style="width:90px;" class="text-center"><?php echo display('Sales Price per Sq.Ft')?>($)</th>
                                 <th rowspan="2"  style="width:90px;" class="text-center"><?php echo display('Sales Slab Price')?>($)</th>
                                 <th rowspan="2" class="text-center"><?php echo display('Weight')?></th>
                                 <th rowspan="2" style="width: 100px" class="text-center"><?php echo display('Total')?></th>
                                 <th rowspan="2" style="width: 100px" class="text-center"><?php echo "Hold"; ?></th>
                                 <th rowspan="2" class="text-center"><?php echo display('Action')?></th>
                              </tr>
                              <tr>
                                 <th class="text-center"><?php echo display('Width')?></th>
                                 <th class="text-center"><?php echo display('Height')?></th>
                                 <th class="text-center"  ><?php echo display('Width')?></th>
                                 <th class="text-center" >
                                    <?php echo display ('Height')?>
                                 </th>
                              </tr>
                           </thead>
                           <style>
                              input{
                              border:none;
                              }
                              textarea:focus, input:focus{
                              outline: none;
                              }
                              .text-right {
                              text-align: left; 
                              }
                              th,
                              td {
                              word-wrap: break-word
                              border: 1px solid black;
                              width: 80px;
                              }
                              .select2 {
                              display:none;
                              }
                              .Row {
                              display: table;
                              width: 100%; /*Optional*/
                              table-layout: fixed; /*Optional*/
                              border-spacing: 10px; /*Optional*/
                              }
                              .Column {
                              display: table-cell;
                              }
                              .input-symbol-euro {
                              position: absolute;
                              font-size: 14px;
                              }
                              .input-symbol-euro input {
                              padding-left: 18px;
                              }
                              .input-symbol-euro:after {
                              position: absolute;
                              top: 7px;
                              content: '<?php echo $currency; ?>';
                              left: 5px;
                              }
                              #download_select:focus option:first-of-type , #print_select:focus option:first-of-type{
                              display: none;
                              }
                           </style>
                           <tbody id="addPurchaseItem_<?php echo $m;  ?>">
                              <?php  $n=0; ?>
                              <?php foreach($purchase_info as $inv){
                                 $a = substr($inv['tableid'], 0, 1);
                                  if($a==$m){
                               ?>



                              <tr>
                                 <td>
                                    <input type="hidden" name="tableid[]" id="tableid_1" value="<?php  echo $inv['tableid'];   ?>"/>
                                    <input list="magicHouses" name="prodt[]" id="prodt_<?php  echo $m.$n; ?>" class="form-control product_name" value="<?php  echo $inv['product_name'].'-'.$inv['product_model'];  ?>"  onchange="this.blur();" style="width:160px;" />
                                    <datalist id="magicHouses">
                                       <?php                                
                                          foreach($product as $tx){?>
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
                                    <input type="text"   style="width:60px;" readonly id="gross_sq_ft_<?php  echo $m.$n; ?>" name="gross_sq_ft[]" value="<?php  echo $inv['gross_sq_ft'];  ?>" class="gross_sq_ft form-control"/>
                                 </td>
                                 <td >
                                    <input type="text"  id="slab_no_<?php  echo $m.$n; ?>" name="slab_no[]"  readonly  required="" value="<?php  echo $n+1;  ?>" class="form-control"/>
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
                                    <input type="text" id="cost_sq_ft_<?php  echo $m.$n; ?>"  name="cost_sq_ft[]" readonly  style="width:60px;" value="<?php  echo $inv['cost_sq_ft'];  ?>"  placeholder="0.00"   class="cost_sq_ft form-control" >
                                 <td >
                                    <input type="text"  id="cost_sq_slab_<?php  echo $m.$n; ?>" name="cost_sq_slab[]" readonly   style="width:60px;" value="<?php  echo $inv['cost_sq_slab'];  ?>" placeholder="0.00"   class="cost_sq_slab form-control"/>
                                 </td>
                                 <td>
                                    <input type="text" id="sales_amt_sq_ft_<?php  echo $m.$n; ?>"  name="sales_amt_sq_ft[]"  style="width:60px;"  value="<?php  echo $inv['sales_amt_sq_ft'];  ?>" class="sales_amt_sq_ft form-control" />
                                 </td>
                                 <td >
                                   <input type="text"  id="sales_slab_amt_<?php  echo $m.$n; ?>" name="sales_slab_amt[]"  style="width:60px;" value="<?php  echo $inv['sales_slab_amt'];  ?>"  class="sales_slab_amt form-control"/>
                                 </td>
                                 </td>
                                 <td>
                                    <input type="text" id="weight_<?php  echo $m.$n; ?>" name="weight[]"  value="<?php  echo $inv['weight'];  ?>" class="weight form-control" />
                                 </td>
                                
                                 <td >
                                    <input  type="text" class="total_price form-control" style="width:80px;"   value="<?php  echo $inv['sales_slab_amt'];  ?>"  id="total_<?php  echo $m.$n; ?>"     name="total_amt[]"/>
                                 </td>
                                 <td>
                                    <input type="checkbox" name="hold_product[]" class="form-control hold-product" id="hold_product" value="1" style="height: 12px !important" <?php echo $inv['hold_product'] == 0 ? 'checked' : ''; ?>>
                                 </td>
                                 <td style="text-align:center;">
                                    <button  class='delete btn btn-danger' type='button' value='Delete' ><i class='fa fa-trash'></i></button>
                                 </td>
                              </tr>
                              <?php $n++;   } }  ?>
                           </tbody>
                           <tfoot  style="border: 2px solid #d7d4d6;" >
                              <tr>
                                 <td style="text-align:right;" colspan="8"><b><?php echo display ('Gross weight') ?> :</b></td>
                                 <td >
                                    <input type="text" id="overall_gross_<?php echo $m; ?>" name="overall_gross[]"    class="overall_gross form-control" style="width: 60px"   readonly="readonly"  /> 
                                 </td>
                                 <td style="text-align:right;" colspan="3"><b>  <?php echo display('Net Sq.Ft')?> :</b></td>
                                 <td >
                                    <input type="text" id="overall_net_<?php echo $m; ?>" name="overall_net[]"  class="overall_net form-control"  style="width: 60px"   readonly="readonly"  /> 
                                 </td>
                                 <td >
                                    <input type="text" id="costpersqft_<?php echo $m; ?>" name="costpersqft[]"  class="costpersqft form-control"  style="width: 60px"  readonly="readonly"  /> 
                                 </td>
                                 <td >
                                    <input type="text" id="costperslab_<?php echo $m; ?>" name="costperslab[]"  class="costperslab form-control"  style="width: 60px"  readonly="readonly"  /> 
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
                                 <td >
                                    <input type="text" id="Total_<?php echo $m; ?>" name="total[]" class="b_total form-control"   style="padding-top: 6px;width: 80px"    readonly="readonly"  />
                                 </td>
                                 <td  style="text-align: center;">
                                    <i id="buddle_<?php echo $m; ?>" class="btn-danger removebundle fa fa-minus"  aria-hidden="true"   onclick="removebundle(); "></i>    
                                 </td>
                              </tr>
                           </tfoot>
                        </table>
                        <?php   } ?>
                         <i id="buddle_1" class="btnclr addbundle fa fa-plus" style=" margin-left:20px;padding: 10px 12px 10px 12px;margin-right: 18px;float:right;"   onclick="addbundle(); "aria-hidden="true"></i>
                     </div>
                  </div>
                  <table class="taxtab table table-bordered table-hover"  style="border: 2px solid #d7d4d6;" >
                     <tr>
                        <td class="hiden" style="width:22%;border:none;text-align:end;font-weight:bold;">
                           <?php echo display('Live Rate') ?> : 
                        </td>
                        <td class="hiden btnclr" style="width:12%;text-align-last: center;padding:5px; border:none;font-weight:bold; ">1 <?php  echo $curn_info_default;  ?>
                           = <input style="width: 80px;text-align:center;color:black;padding:5px;" type="text" class="custocurrency_rate"/>&nbsp;<label for="custocurrency"  ></label>
                        </td>
                        <td style="border:none;text-align:right;font-weight:bold;"><?php echo display('Tax') ?> : 
                        </td>
                        <td style="width:12%">
                           <input list="magic_tax" name="tx"  id="product_tax" value="<?php  echo $t; ?>" class="form-control"   onchange="this.blur();" />
                           <input type="hidden" class="get_taxid" value="<?php echo $edit_profarmadata[0]['id'];  ?>" />
                           <datalist id="magic_tax">
                              <?php                                
                                foreach($edit_profarmadata as $tx){?>
                                 <option value="<?php echo $tx['tax_id'].'-'.$tx['tax'].'%';?>">  <?php echo $tx['tax_id'].'-'.$tx['tax'].'%';  ?></option>
                              <?php } ?>
                           </datalist>
                        </td>
                        <td  style="width:20%;"></td>
                     </tr>
                  </table>
                  <table border="0"   class="overall table table-bordered table-hover"  style="border: 2px solid #d7d4d6;table-layout: auto;" >
                     <tr>
                        <td   style="vertical-align:top;text-align:right;border:none;"></td>
                        <td  style="text-align:right;border:none;"></td>
                        <td  style="text-align:right;border:none;"></td>
                        <td  style="text-align:right;border:none;"> </td>
                     </tr>
                     <tr>
                        <td  colspan="2" style="vertical-align:top;text-align:right;border:none;"><b><?php echo display('Overall TOTAL')?> :</b></td>
                        <td colspan="1" style="border:none;padding-bottom: 40px; text-align: left !important; position: relative;left: 40px;"><span class="input-symbol-euro"><input type="text" id="Over_all_Total" name="Over_all_Total"  style="width:179px;" class="form-control" value="<?php echo $purchase_info[0]['total'];  ?>"  readonly="readonly"  /> </span></td>

                        <td colspan="4" style="text-align:right;border:none;width:250px;"><b><?php echo display('TAX DETAILS')?> :</b></td>
                        <td colspan="1" style="border:none; text-align: left !important; position: relative; left: 40px;">  <span class="input-symbol-euro"> <input type="text" class="form-control" style="width:150px;"  id="tax_details" value="<?php echo $purchase_info[0]['tax_details'];  ?>" name="tax_details"  readonly="readonly" /></span></td>
                     </tr>
                     <tr>
                        <td  colspan="2" style="vertical-align:top;text-align:right;border:none;"><b><?php echo display('Overall Gross Sq.Ft')?> :</b></td>
                        <td colspan="1" style="border:none; position: relative;left: 40px;"><input type="text" id="total_gross" name="total_gross" value="<?php echo $purchase_info[0]['total_gross'];  ?>"  class="form-control"   readonly="readonly"  /> </td>

                        <td colspan="4" style="text-align:right;border:none;"><b><?php echo display('GRAND TOTAL')?> :</b></td>
                        <td colspan="1" style="border:none; text-align: left !important; position: relative; left: 40px;">  <span class="input-symbol-euro">    <span class="input-symbol-euro">   <input type="text" id="gtotal"   class="form-control" style="width:150px;" name="gtotal" value="<?php echo $purchase_info[0]['gtotal'];  ?>"  readonly="readonly" /></td>
                     </tr>
                     <tr>
                        <td  colspan="2" style="vertical-align:top;text-align:right;border:none;"><b><?php echo display('Overall Net Sq.Ft')?> :</b></td>
                        <td colspan="1" style="border:none; position: relative;left: 40px;"><input type="text" id="total_net" name="total_net" value="<?php echo $purchase_info[0]['total_net'];   ?>" class="form-control"    readonly="readonly"  /> </td>
                        <td colspan="4" style="text-align:right;border:none;"><b><?php echo display('GRAND TOTAL')?> :<br/><?php echo display('Preferred Currency')?></b></td>
                        <td colspan="1" style="border:none;">
                           <table>
                              <tr>
                                 <td class="cus" name="cus" style="width: 40px;"></td>
                                 <td><input  type="text"  readonly id="customer_gtotal"  value="<?php echo $invoice_detail[0]['gtotal_preferred_currency'];  ?>"   name="customer_gtotal"  required  class="form-control" style="width: 150px;" /></td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                     <tr>
                        <td colspan="2"  style="vertical-align:top;text-align:right;border:none;"><b><?php echo display('Overall Weight')?> :</b></td>
                        <td colspan="1" style="border:none; position: relative;left: 40px;"><input type="text" id="total_weight" name="total_weight"  value="<?php echo $purchase_info[0]['total_weight'];   ?>" class="form-control"   readonly="readonly"  /></td>
                        <td colspan="4" class="amt" style="text-align:right;border:none;"><b><?php echo display('Amount Paid')?> :</b></td>
                        <td style="border: none;">
                           <table border="0">
                              <tr>
                                 <td class="cus" name="cus" style="width: 40px;"></td>
                                 <td> <input  type="text"   readonly id="amount_paid" value="<?php echo  $purchase_info[0]['amt_paid'];  ?>" name="amount_paid" class="form-control" style="width:150px;" /></td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                     <tr id="bal">
                        <td colspan="2"  style="vertical-align:top;text-align:right;border:none;"></td>
                        <td colspan="1" style="border:none;"></td>
                        <td class="amt" colspan="4"  style="vertical-align:top;text-align:right;border:none;"><b><?php echo display('Balance Amount')?> :</b></td>
                        <td style="border: none;">
                           <table border="0">
                              <tr>
                                 <td class="cus" name="cus" style="width: 40px;"></td>
                                 <td>
                                    <input type="text" readonly value="<?php echo $purchase_info[0]['bal_amt']; ?>" name="balance" id="Balance" required class="form-control balance_modal" style="width: 150px;" />            
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                     <td colspan="21" style="text-align: end;">
                        <input type="submit" value="<?php echo display('Make Payment') ?>" class="btnclr btn btn-large" id="paypls"/>
                     </td>
                     <tr>
                  </table>
             <div class="form-group row">
            <label for="billing_address" class="col-sm-2 col-form-label"><?php echo display('Account Details/Additional Information')?></label>
            <div class="col-sm-8">
            <textarea rows="4" cols="50" id="details"   style="border: 2px solid #d7d4d6;"  name="ac_details" class=" form-control" placeholder='Account Details/Additional Information' ><?php   if(!empty($purchase_info[0]['ac_details'])){echo $purchase_info[0]['ac_details'];} ?></textarea>
            <br>
            </div>
            </div>
            <div class="form-group row">
            <label for="remark" class="col-sm-2 col-form-label"><?php echo display('Remarks/Conditions')?></label>
            <div class="col-sm-8">
            <textarea rows="4" cols="50" id="remarks" name="remark"  style="border: 2px solid #d7d4d6;"  class=" form-control" placeholder='Remarks/Conditions' ><?php   if(!empty($remarks)){ echo $remarks;} ?></textarea>
            </div>
            </div>
            <div class="form-group row">
            <div class="col-sm-6">
            <table>
            <tr>
            <td>
            <input type="hidden" name="uid" value="<?php echo $_SESSION['user_id']; ?>">
            <input type="submit" id="add_trucking" class="btnclr btn btn-large"   name="add-trucking" value=<?php echo display('Save')?> >
            </td><td class="amt">    <a     id="final_submit" class='btnclr final_submit btn'><?php echo display('Submit')?></a></td>
            <td><a id="download"   class='btnclr btn'><?php echo display('Download')?></a>
            </td>
            <td class="amt" style="width: 20px;"></td>
            <td class="amt"><a id="print"   class='btnclr btn'><?php echo display('Print')?></a>
            </td>
            <td class="amt">&nbsp;</td>
            <td class="amt" id="btn1_download">
            <div class="col-sm-6">
            </td>
            <td>&nbsp;</td>
            </tr>
            </table>
            </div>
            </div>
            <input type="hidden" id="currency"/>
            </form>
            </div>
         </div>
      </div>
   </div>
</section>
<div class="modal fade" id="payment_history_modal" role="dialog">
   <div class="modal-dialog modal-dialog-centered modal-xl">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header btnclr">
            <button type="button" id="history_close"   class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"  style="color:white;"  ><?php echo display('PAYMENTHISTORY')?></h4>
         </div>
         <div class="modal-body1">
            <div id="salle_list"></div>
         </div>
         <div class="modal-footer">
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="product_model_info" role="dialog" style="margin-right: 900px;width:2000px;text-align:center;">
   <div class="modal-dialog" style="float:left;">
      <!-- Modal content-->
      <div class="modal-content" style="width: fit-content;margin-top: 100px;margin-left:300px;">
         <div class="modal-header btnclr"  >
          
          
              <button type="button" class="close" data-dismiss="modal"  style="color: #6f2937; background: #cdc222;" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
          
          
            <h4 class="modal-title"><?php echo display('Product') ?></h4>
         </div>
         <div class="modal-body1">
            <div id="salle_list5" style="padding:20px;"></div>
         </div>
         <div class="modal-footer">
         </div>
      </div>
   </div>
</div>
<input type="hidden" id="hdn"/>
<input type="hidden" id="gtotal_dup"/>
<div class="modal fade" id="myModal1" role="dialog" >
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content" style="margin-top: 190px;">
         <div class="modal-header btnclr" >
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?php echo display('Sales - Profarma Invoice')?></h4>
         </div>
         <div class="modal-body" id="bodyModal1" style="text-align:center;font-weight:bold;">
         </div>
         <div class="modal-footer">
         </div>
      </div>
   </div>
</div>


<!-- Purchase Report End -->
<input type="text" id="hdn" name="hdn"/>
<div id="result" style="display:none;"></div>
<?php 
$modaldata['bootstrap_model'] = array('customer', 'tax_info', 'payment_model', 'bank_info');
$this->load->view('include/bootstrap_model', $modaldata); 
?>
<script>
   var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
   var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
   
   function discard(){
      $.get(
       "<?php echo base_url(); ?>Cinvoice/deleteprofarma/", 
      { val: $("#invoice_hdn1").val(), csrfName:csrfHash }, // put your parameters here
      function(responseText){
     
       window.btn_clicked = true;      //set btn_clicked to true
       var input_hdn="Your Invoice No :"+$('#invoice_hdn').val()+" has been Discared";
     
      
       $('#myModal3').modal('hide');
       $("#bodyModal1").html(input_hdn);
           $('#myModal1').modal('show');
       window.setTimeout(function(){
          
   
           window.location = "<?php  echo base_url(); ?>Cinvoice/manage_profarma_invoice";
         }, 2000);
      }
   ); 
   }
   
   
   
   $("#insert_trucking").validate({
        rules: {
            purchase_date: {
               required: true,
            },
            customer_id: {
               required: true,
            },
        },
        messages: {
            purchase_date: "Please select your purchase date",
            customer_id: "Please select your customer name",
        },
         errorPlacement: function(error, element) {
            if (element.hasClass("select2-hidden-accessible")) {
                error.insertAfter(element.next('span.select2'));
            } else {
                error.insertAfter(element);
            }
         },
        submitHandler: function(form) {
            // var formData = $(form).serialize();
            var formData = new FormData($("#insert_trucking")[0]);
            formData.append(csrfName, csrfHash);

            $(".hold-product").each(function() {
               var checkboxValue = $(this).is(':checked') ? '1' : '0';
               formData.append($(this).attr('name'), checkboxValue);
            });
            
             $.ajax({
              type: "POST",
              url: "<?php echo base_url(); ?>Cinvoice/performer_ins",
              data: formData,
              dataType: "json",
              processData: false,
              contentType: false, 
              success: function(response) {
                  console.log(response, "response");
                  if(response.status == 'success') {
                      var input_hdn = response.msg;
                      var purchaseId = response.purchase_id;
                      $('.amt').show();
                      $('.final_submit').show();
                      $('#download').show();
                      $('#print').show();

                     $('.displaymessage').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
                     
                  } else {
                     $('.displaymessage').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
                  }

              }
            });
         return false;
        }
    });


   $('#download').on('click', function (e) {
    var popout = window.open("<?php  echo base_url(); ?>Cinvoice/performa_pdf/"+$('#invoice_hdn1').val());
   });  

   $('#print').on('click', function (e) {
    var popout = window.open("<?php  echo base_url(); ?>Cinvoice/performa_print/"+$('#invoice_hdn1').val());
    
     
   
   }); 
   
   
   $('.final_submit').on('click', function (e) {
   
      window.location.href = "<?php echo base_url(); ?>Cinvoice/manage_profarma_invoice?id=<?php echo $_GET['id']; ?>";
          
   });
   
    
   
   
   
   
      $(document).ready(function(){
       $('.hiden').css("display","none");
         // $('.removebundle').hide();
   
      });
      
   $( document ).ready(function() {
     $('.hiden').css("display","none");
        // var t_id = $('.get_taxid').val();
        var data = {value: $('#customer_id').val()};
     data[csrfName] = csrfHash;
     console.log('Sending AJAX request...');
     $.ajax({
         type:'POST',
         data: data,
      
         //dataType tells jQuery to expect JSON response
         dataType:"json",
         url:'<?php echo base_url();?>Cinvoice/getcustomer_byID',
         success: function(result, statut) {
            console.log('AJAX request successful');
            console.log(result, "result");
             if(result.csrfName){
                //assign the new csrfName/Hash
                csrfName = result.csrfName;
                csrfHash = result.csrfHash;
             }
    //           if(result[0]['tax_status']==1){
    //       $('#product_tax').val(result[0]['tax_percent']);
    //   }else{
    //       $('#product_tax').val(0);
    //   }
    //         // var parsedData = JSON.parse(result);
    //       //  alert(result[0].p_quantity);
      console.log(result[0]['currency_type']);
           $(".cus").html(result[0]['currency_type']);
           $("label[for='custocurrency']").html(result[0]['currency_type']);
          console.log('https://open.er-api.com/v6/latest/<?php echo $curn_info_default; ?>');
          $.getJSON('https://open.er-api.com/v6/latest/<?php echo $curn_info_default; ?>', 
   function(data) {
    var custo_currency=result[0]['currency_type'];
       var x=data['rates'][custo_currency];
    var Rate =parseFloat(x).toFixed(3);
     console.log(Rate);
     $('.hiden').show();
     $(".custocurrency_rate").val(Rate);
     var num=$("#gtotal").val();
   
       var value=parseInt(num*Rate);
       
   var custo_final = isNaN(parseInt(value)) ? 0 : parseInt(value)
   $('#customer_gtotal').val(custo_final);  
   var v_g_t=$('#gtotal').val();
      var amount_paid =$("#amount_paid").val();
      var bal= parseInt(v_g_t-amount_paid);
      console.log(bal);
      $('#balance').val(bal.toFixed(2));
   
           calculate();
   });
       },
       error: function (xhr, status, error) {
        console.log('AJAX request failed');
        console.log(error);
    }
     });
   
   });
   
    $(document).ready(function(){
      
    $(".normalinvoice").each(function(i,v){
      if($(this).find("tbody").html().trim().length === 0){
          $(this).hide()
      }
   })
           $('.normalinvoice').each(function(){
           
   var tid=$(this).attr('id');
    const indexLast = tid.lastIndexOf('_');
   var idt = tid.slice(indexLast + 1);
   
     var sum=0;
   
    $('#normalinvoice_'+idt  +  '> tbody > tr').find('.total_price').each(function() {
   var v=$(this).val();
     sum += parseFloat(v);
   
   });
   
   $('#Total_'+idt).val(sum.toFixed(3));
   
     var sum_net=0;
   
    $('#normalinvoice_'+idt  +  '> tbody > tr').find('.net_sq_ft').each(function() {
   var v=$(this).val();
     sum_net += parseFloat(v);
   
   });
   
   $('#overall_net_'+idt).val(sum_net.toFixed(3));
      var sum_weight=0;
   
    $('#normalinvoice_'+idt  +  '> tbody > tr').find('.weight').each(function() {
   var v=$(this).val();
     sum_weight += parseFloat(v);
   
   });
   
   $('#overall_weight_'+idt).val(sum_weight.toFixed(3));
     var sum_gross=0;
   
    $('#normalinvoice_'+idt  +  '> tbody > tr').find('.gross_sq_ft').each(function() {
   var v=$(this).val();
     sum_gross += parseFloat(v);
   
   });
   
   $('#overall_gross_'+idt).val(sum_gross.toFixed(3));
         var sum_cq=0;
   
    $('#normalinvoice_'+idt  +  '> tbody > tr').find('.cost_sq_ft').each(function() {
   var v=$(this).val();
    if (!isNaN(v) && v.length !== 0) {
             sum_cq += parseFloat(v);
           }
           
   
   
   });
   
   $('#costpersqft_'+idt).val(sum_cq.toFixed(3));
   
     var sum_ss=0;
   
    $('#normalinvoice_'+idt  +  '> tbody > tr').find('.cost_sq_slab').each(function() {
   var v=$(this).val();
     sum_ss += parseFloat(v);
   
   });
   
   var costPerSlab = isNaN(sum_ss) ? 0.00 : sum_ss.toFixed(3);
   $('#costperslab_'+idt).val(costPerSlab);
   
     var sum_amt=0;
   
    $('#normalinvoice_'+idt  +  '> tbody > tr').find('.sales_amt_sq_ft').each(function() {
   var v=$(this).val();
     sum_amt += parseFloat(v);
   
   });
   
   $('#salespricepersqft_'+idt).val(sum_amt.toFixed(3));
     var sum_st=0;
   
    $('#normalinvoice_'+idt  +  '> tbody > tr').find('.sales_slab_amt').each(function() {
   var v=$(this).val();
     sum_st += parseFloat(v);
   
   });
   
   $('#salesslabprice_'+idt).val(sum_st.toFixed(3));
   
   var total_w=0;
    $('.table').each(function() {
       $(this).find('.weight').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             total_w += parseFloat(precio);
           }
         });
   
     });
   $('#total_weight').val(total_w.toFixed(3)).trigger('change');
   
   
       });
   });
    
   $(document).ready(function () {
       $('#final_submit').hide();
           $('#download').hide();
            $('#print').hide();
       $('#customer_id').on('change', function (e) {

     var data = {
         value: $('#customer_id').val()
      };
     data[csrfName] = csrfHash;
     $.ajax({
         type:'POST',
         data: data,
      
         //dataType tells jQuery to expect JSON response
         dataType:"json",
         url:'<?php echo base_url();?>Cinvoice/getcustomer_byID',
         success: function(result, statut) {
             if(result.csrfName){
                //assign the new csrfName/Hash
                csrfName = result.csrfName;
                csrfHash = result.csrfHash;
             }
                   if(result[0]['tax_status']==1){
           $('#product_tax').val(result[0]['tax_percent']);
       }else{
          $('#product_tax').val(0);
       }
           console.log(result[0]['currency_type']);
           $(".cus").html(result[0]['currency_type']);
           $("label[for='custocurrency']").html(result[0]['currency_type']);
          console.log('https://open.er-api.com/v6/latest/<?php echo $curn_info_default; ?>');
          $.getJSON('https://open.er-api.com/v6/latest/<?php echo $curn_info_default; ?>', 
   function(data) {
    var custo_currency=result[0]['currency_type'];
       var x=data['rates'][custo_currency];
    var Rate =parseFloat(x).toFixed(3);
     console.log(Rate);
     $('.hiden').show();
     $(".custocurrency_rate").val(Rate);
   });
       
         }
     });
   calculate();
   
   });
   $(document).ready(function(){
    
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
         console.log(data, "datahistory");
        var gt=$('#customer_gtotal').val();
        var amtpd=data.amt_paid;
        console.log(data);
        var bal= gt - amtpd;
        if(amtpd){
         $('#amount_paid').val(amtpd);
         }
         // else{
         //    $('#amount_paid').val("0.00"); 
         // }
         $('#balance').val(bal.toFixed(2));
    }
   
   });
      event.preventDefault();
   });
   
   
       $(document).on('show.bs.modal', '.modal', function (event) {
           var zIndex = 1040 + (10 * $('.modal:visible').length);
           $(this).css('z-index', zIndex);
           setTimeout(function() {
               $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
           }, 0);
       });
   
   
   });
   
   
     
   
   $('#insert_product').submit(function (event) {
        event.preventDefault();
   if($('#product_name').val()!='' && $('#product_model').val()!='' && $('#sell_price').val()!='' && $('#quantity').val()!='' && $('#supplier_id').val()!='' && $('#product_sub_category').val()!='')
   {
      
   
       var dataString = {
           dataString : $("#insert_product").serialize()
      };
      dataString[csrfName] = csrfHash;
       $.ajax({
           type:"POST",
           dataType:"json",
           url:"<?php echo base_url(); ?>Cproduct/insert_product",
           data:$("#insert_product").serialize(),
           success:function (data1) {
           console.log(data1);
   
           $("#magicHouses").empty();
           for (var i in data1) {
              $("<option/>").html(data1[i].product_name +'-'+ data1[i].product_model).appendTo("#magicHouses");
           }
         
          $("#magicHouses").focus();
   
         $("#bodyModal1").html("Product Added Successfully");
          
         $('#myModal1').modal('show');
   
          $('#insert_product')[0].reset();
   
   
         window.setTimeout(function(){
           $('#product_info').modal('hide');
           $('.modal-backdrop').remove();
          $('#myModal1').modal('hide');
       }, 2500);
   }
   });
   }
   });
   function calculate(){
   
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
     var answer = (percent / 100) * parseInt(total);
   
     
      var gtotal = parseInt(total + answer);
      console.log("gtotal :" +gtotal);
   
   
   
     var final_g= $('#final_gtotal').val();
   
   
     var amt=parseInt(answer)+parseInt(total);
     var num = isNaN(parseInt(amt)) ? 0 : parseInt(amt)
       $('#gtotal').val(num); 
     var custo_amt=$('.custocurrency_rate').val(); 
     console.log("numhere :"+num +"-"+custo_amt);
     var value=num*custo_amt;
     var custo_final = isNaN(parseInt(value)) ? 0 : parseInt(value)
    $('#customer_gtotal').val(custo_final); 
     $('#tax_details').val(answer.toFixed(3) +" ( "+tax+" )");
   var bal_amt=custo_final-$('#amount_paid').val();
   $('#balance').val(bal_amt.toFixed(2));
   
   }
   
   
   
   
                     
                     
            function search() {
                     // debugger;
                       var input_supplier_block_no,
                               input_supplier_slab_no,
                               input_bundle_no,
                               // input_origin,
                     
                     
                          
                     
                             filter_supplier_block_no,filter_supplier_slab_no,filter_bundle_no,
                             table,
                             tr,
                             td,
                             i,
                             name;
                             
                     
                     
                     
                            input_supplier_block_no = document.getElementById("myInput1");
                            input_supplier_slab_no = document.getElementById("myInput2");
                            input_bundle_no = document.getElementById("myInput3");
                           //  input_origin = document.getElementById("myInput4");
                             
                     
                           filter_supplier_block_no = input_supplier_block_no.value.toUpperCase();    
                           filter_supplier_slab_no = input_supplier_slab_no.value.toUpperCase();    
                           filter_bundle_no = input_bundle_no.value.toUpperCase();   
                           // filter_origin = input_origin.value.toUpperCase();
                     
                     
                           
                         table = document.getElementById("product_table1");
                         tr = table.getElementsByTagName("tr");
                     
                             for (i = 0; i < tr.length; i++) {
                                 td = tr[i].getElementsByTagName("td")[5];
                                 td1 = tr[i].getElementsByTagName("td")[6];
                                 td2 = tr[i].getElementsByTagName("td")[2];
                               //   td3 = tr[i].getElementsByTagName("td")[5];
                                
                           
                               if (td && td1 && td2  ) {
                     
                                 supplier_block_no = (td.textContent || td.innerText).toUpperCase();
                                 supplier_slab_no = (td1.textContent || td1.innerText).toUpperCase();
                                 bundle_no = (td2.textContent || td2.innerText).toUpperCase();
                               //   origin = (td3.textContent || td3.innerText).toUpperCase();
                                
                     
                     
                                 if (
                                   supplier_block_no.indexOf(filter_supplier_block_no) > -1 &&
                                   supplier_slab_no.indexOf(filter_supplier_slab_no) > -1 &&
                                   bundle_no.indexOf(filter_bundle_no) > -1 
                                   //   origin.indexOf(filter_origin) > -1  
                     
                                 ) {
                                     tr[i].style.display = "";
                                 } else {
                                     tr[i].style.display = "none";
                                 }
                             }
                         }
                     }
                     
                     
                     
   
   $( document ).ready(function() {

   $("#insert_trucking").validate({
        rules: {
            purchase_date: {
               required: true,
            },
            customer_id: {
               required: true,
            },
        },
        messages: {
            purchase_date: "Please select your purchase date",
            customer_id: "Please select your customer name",
        },
         errorPlacement: function(error, element) {
            if (element.hasClass("select2-hidden-accessible")) {
                error.insertAfter(element.next('span.select2'));
            } else {
                error.insertAfter(element);
            }
         },
        submitHandler: function(form) {
            var formData = $(form).serialize();
            var dataString = {
               dataString: $("#insert_trucking").serialize()
            };
            dataString[csrfName] = csrfHash;
             $.ajax({
              type: "POST",
              dataType: "json",
              url: "<?php echo base_url(); ?>Cinvoice/performer_ins",
              data: $("#insert_trucking").serialize(),
              success: function(response) {
                  console.log(response, "response");
                  if(response.status == 'success') {
                      var input_hdn = response.msg;
                      var purchaseId = response.purchase_id;
                      $("#bodyModal1").html(input_hdn);
                      $("#viewPurchaseid").val(purchaseId);
                      $('#myModal1').modal('show');
                      $('.amt').show();
                      $('.final_submit').show();
                      // $('#download').show();
                      // $('#print').show();
                      
                      window.setTimeout(function(){
                          $('.modal').modal('hide');
                          $('.modal-backdrop').remove();
                          $('#instant_customer')[0].reset();  
                      }, 2500);

                      $('.displaymessage').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
                     
                  } else {
                      $('.displaymessage').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
                  }

                  var split = response.msg.split("/");
                  $('#invoice_hdn1').val(split[0]);
                  $('#invoice_hdn').val(split[1]);
              }
            });
         return false;
        }
    });

   

   $('.hiden').css("display","none");
   
   });
   $(document).on('change input keyup','.sales_amt_sq_ft', function (e) {
   
      var netheight = $(this).attr('id');
   const indexLastDot = netheight.lastIndexOf('_');
   var id_num = netheight.slice(indexLastDot + 1);
      var sales_amt_sq_ft=$('#sales_amt_sq_ft_'+id_num).val();
      var net_sq_ft=$('#net_sq_ft_'+id_num).val();
    var netresult =sales_amt_sq_ft* net_sq_ft;
   netresult = isNaN(netresult) ? 0 : netresult;
   var nresult=netresult.toFixed(3);
   $('#'+'sales_slab_amt_'+id_num).val(netresult.toFixed(3));
   $(this).closest('tr').find('.total_price').val(netresult.toFixed(3));
   var overall_sum=0;
        $('.table').find('.total_price').each(function() {
   var v=$(this).val();
     overall_sum += parseFloat(v);
   });
    $('#Over_all_Total').val(overall_sum.toFixed(3)).trigger('change');
          var sum=0;
        $(this).closest('table').find('.total_price').each(function() {
   var v=$(this).val();
     sum += parseFloat(v);
   });
    $(this).closest('table').find('.b_total').val(sum.toFixed(3)).trigger('change');
      var sales_amt_sq_ft=0;
      $(this).closest('table').find('.sales_amt_sq_ft').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             sales_amt_sq_ft += parseFloat(precio);
           }
         });
    $(this).closest('table').find('.salespricepersqft').val(sales_amt_sq_ft).trigger('change');
      var sales_slab_amt=0;
      $(this).closest('table').find('.sales_slab_amt').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             sales_slab_amt += parseFloat(precio);
           }
         });
   $(this).closest('table').find('.salesslabprice').val(sales_slab_amt).trigger('change');
      
    calculate();
     });
        $(document).on('change input keyup','.cost_sq_slab', function (e) {
      var sales_slab_amt=0;
      $(this).closest('table').find('.cost_sq_slab').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             sales_slab_amt += parseFloat(precio);
           }
         });
   $(this).closest('table').find('.costperslab').val(sales_slab_amt).trigger('change');
    
   
     });
    $(document).on('change input keyup','.cost_sq_ft', function (e) {
   
      var sales_amt_sq_ft=0;
      $(this).closest('table').find('.cost_sq_ft').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             sales_amt_sq_ft += parseFloat(precio);
           }
         });
    $(this).closest('table').find('.costpersqft').val(sales_amt_sq_ft).trigger('change');
   
     });
         $(document).on('change input keyup','.sales_slab_amt', function (e) {
         
     var netheight = $(this).attr('id');
   const indexLastDot = netheight.lastIndexOf('_');
   var id_num = netheight.slice(indexLastDot + 1);
     
      var sales_slab_amt=$('#sales_slab_amt_'+id_num).val();
      var net_sq_ft=$('#net_sq_ft_'+id_num).val();
    var netresult =sales_slab_amt/net_sq_ft;
   netresult = isNaN(netresult) ? 0 : netresult;
   var nresult=netresult.toFixed(3);
   $('#'+'sales_amt_sq_ft_'+id_num).val(netresult.toFixed(3));
   $('#total_'+id_num).val(sales_slab_amt);
   var overall_sum=0;
        $('.table').find('.total_price').each(function() {
   var v=$(this).val();
     overall_sum += parseFloat(v);
   });
    $('#Over_all_Total').val(overall_sum.toFixed(3)).trigger('change');
          var sum=0;
        $(this).closest('table').find('.total_price').each(function() {
   var v=$(this).val();
     sum += parseFloat(v);
   });
    $(this).closest('table').find('.b_total').val(sum.toFixed(3)).trigger('change');
     var sales_slab_amt=0;
      $(this).closest('table').find('.sales_slab_amt').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             sales_slab_amt += parseFloat(precio);
           }
         });
   $(this).closest('table').find('.salesslabprice').val(sales_slab_amt).trigger('change');
       var sales_amt_sq_ft=0;
      $(this).closest('table').find('.sales_amt_sq_ft').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             sales_amt_sq_ft += parseFloat(precio);
           }
         });
    $(this).closest('table').find('.salespricepersqft').val(sales_amt_sq_ft).trigger('change');
    
   calculate();
     });
   $(document).on('change', '.product_name', function(){
   
    var netheight = $(this).attr('id');
   const indexLastDot = netheight.lastIndexOf('_');
   var id = netheight.slice(indexLastDot + 1);
   $('#tableid_'+id).val(id);
   var net_width='net_width_'+id;
   var net_height = 'net_height_'+ id;
   var netwidth=$('#'+net_width).val();
   var netheight=$('#'+net_height).val();
   var netresult=parseInt(netwidth) * parseInt(netheight);
   netresult=netresult/144;
   netresult = isNaN(netresult) ? 0 : netresult;
   var nresult=netresult.toFixed(3);
   
   $('#'+'net_sq_ft_'+id).val(netresult.toFixed(3));
   var sales_slab_price=$('#sales_slab_amt_'+id).val();
   
   var sales_amt_sq_ft=sales_slab_price / nresult;
   
   sales_amt_sq_ft = isNaN(sales_amt_sq_ft) ? 0 : sales_amt_sq_ft;
   $('#'+'sales_amt_sq_ft_'+id).val(sales_amt_sq_ft.toFixed(3));
   $('#'+'total_'+id).val(sales_slab_price.toFixed(3));
   calculate();
   });
   
   // Restricts input for each element in the set of matched elements to the given inputFilter.
   (function($) {
     $.fn.inputFilter = function(callback, errMsg) {
       return this.on("input keydown keyup mousedown mouseup select contextmenu drop focusout", function(e) {
         if (callback(this.value)) {
           // Accepted value
           if (["keydown","mousedown","focusout"].indexOf(e.type) >= 0){
             $(this).removeClass("input-error");
             this.setCustomValidity("");
           }
           this.oldValue = this.value;
           this.oldSelectionStart = this.selectionStart;
           this.oldSelectionEnd = this.selectionEnd;
         } else if (this.hasOwnProperty("oldValue")) {
           // Rejected value - restore the previous one
           $(this).addClass("input-error");
           this.setCustomValidity(errMsg);
           this.reportValidity();
           this.value = this.oldValue;
           this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
         } else {
           // Rejected value - nothing to restore
           this.value = "";
         }
       });
     };
   }(jQuery));
   
   $(".custocurrency_rate").inputFilter(function(value) {
     return /^-?\d*[.,]?\d*$/.test(value); }, "Must be a floating (real) Number");
   
   
   
   
   $('#product_tax').on('change', function (e) {
   

    calculate();
       payment_info();
    });
   var arr=[];
   
   
   function gt(id){
   
   var final_g= $('#final_gtotal').val();
   
   var first=$("#Over_all_Total").val();
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
   // var field = tax.split('-');
   
   // var percent = field[1];
   var answer=0;
     var answer =(parseInt(percent) / 100) * parseInt(first);
      console.log(answer);
      $('#tax_details').val(answer.toFixed(3) +" ( "+tax+" )");
   
     var gtotal = parseInt(first + answer);
     console.log(gtotal);
   var amt=parseInt(answer)+parseInt(first);
    var num = isNaN(parseInt(amt)) ? 0 : parseInt(amt)
    var custo_amt=$('.custocurrency_rate').val();
    $("#gtotal").val(num);  
    console.log(num +"-"+custo_amt);
    localStorage.setItem("customer_grand_amount_sale",num);
   
    var value=num*custo_amt;
    var custo_final = isNaN(parseInt(value)) ? 0 : parseInt(value)
   $('#customer_gtotal').val(custo_final);
   var bal_amt=custo_final-$('#amount_paid').val();
   $('#balance').val(bal_amt.toFixed(2));
   
   
   
   }
   
   
      function payment_info(){
      
     var data = {
          gtotal:$('#gtotal').val(),
          customer_name:$('#customer_id').val()
     
       };
       data[csrfName] = csrfHash;
   
       $.ajax({
           type:'POST',
           data: data, 
        dataType:"json",
           url:'<?php echo base_url();?>Cinvoice/get_payment_info',
           success: function(result, statut) {
              
             $("#amount_paid").val(result[0]['amt_paid']);
             $("#balance").val(parseFloat(result[0]['balance']).toFixed(2));
               console.log(result);
           }
       });
   }
     function configureDropDownLists(ddl1,ddl2) {
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
   case '1800 INTERCOMPANY RECEIVABLES & 1900 OTHER NON-CURRENT ASSETS':
   ddl2.options.length = 0;
   for (i = 0; i < intercompany_receivables.length; i++) {
   createOption(ddl2, intercompany_receivables[i], intercompany_receivables[i]);
   }
   break;
   case '2000 LIABILITIES & 2100 PAYABLES':
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
   case '2800 INTERCOMPANY PAYABLES & 2900 OTHER NON CURRENT LIABILITIES & 3000 OWNERS EQUITIES':
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
   case '6000 – 7000 OPERATING EXPENSES':
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
   
    $c= $("table.normalinvoice").length;
      let dynamic_id=$c+1;
       function addbundle(){
            $(this).closest('table').find('.addbundle').css("display","none");
         $(this).closest('table').find('.removebundle').css("display","block");
   
   var newdiv = document.createElement('div');
   var tabin="crate_wrap_"+dynamic_id;
   
   newdiv = document.createElement("div");
   
   
   newdiv.innerHTML ='<table class="table normalinvoice table-bordered table-hover"  style="border: 2px solid #d7d4d6;"  id="normalinvoice_'+ dynamic_id +'"> <thead> <tr> <th rowspan="2" class="text-center" style="width: 170px;" ><?php echo display('product_name'); ?><i class="text-danger">*</i></th> <th rowspan="2"  class="text-center"><?php echo display('Bundle No');?><i class="text-danger">*</i></th> <th rowspan="2"  class="text-center"><?php echo  display('description'); ?></th> <th rowspan="2" style="width:60px;" class="text-center"><?php echo display('Thick ness');?><i class="text-danger">*</i></th> <th rowspan="2" class="text-center"><?php echo display('Supplier Block No');?><i class="text-danger">*</i></th>  <th rowspan="2" class="text-center" ><?php echo display('Supplier Slab No');?><i class="text-danger">*</i> </th> <th colspan="2" style="width:150px;" class="text-center"><?php echo display('Gross Measurement');?><i class="text-danger">*</i> </th> <th rowspan="2" class="text-center"><?php echo display('Gross Sq.Ft');?></th>  <th rowspan="2" style="width:40px;" class="text-center"><?php echo display('Slab No');?><i class="text-danger">*</i></th> <th colspan="2" style="width:150px;" class="text-center"><?php echo display('Net Measure');?><i class="text-danger">*</i></th> <th rowspan="2" class="text-center"><?php echo display('Net Sq.Ft');?></th> <th rowspan="2" class="text-center"><?php echo display('Cost per Sq.Ft');?>($)</th> <th rowspan="2"  class="text-center"><?php echo display('Cost per Slab');?>($)</th> <th rowspan="2"  class="text-center"><?php echo display('sales'); ?><br/><?php echo display('Price per Sq.Ft');?>($)</th> <th rowspan="2"  class="text-center"><?php echo display('Sales Slab Price');?>($)</th> <th rowspan="2" class="text-center"><?php echo display('Weight');?></th> <th rowspan="2" style="width: 100px" class="text-center"><?php  echo  display('total'); ?>($)</th> <th rowspan="2" style="width: 100px" class="text-center"><?php  echo "Hold"; ?></th> <th rowspan="2" class="text-center"><?php  echo  display('action'); ?></th> </tr>  <tr> <th class="text-center"><?php echo display('Width');?></th> <th class="text-center"><?php echo display('Height');?></th> <th class="text-center"><?php echo display('Width');?></th> <th class="text-center"><?php echo display('Height');?></th> </tr>  </thead> <tbody id="addPurchaseItem_'+ dynamic_id +'"> <tr> <input type="hidden" name="tableid[]" id="tableid_'+ dynamic_id +'"/><td> <input   list="magicHouses"  style="width:160px;" name="prodt[]" id="prodt_'+ dynamic_id +'"   class="form-control product_name"  placeholder="Search Product" > <datalist id="magicHouses"> <option value="Select the Product" selected>Select the Product</option> <?php  foreach($product as $tx){?>  <option value="<?php echo $tx["product_name"]."-".$tx["product_model"];?>">  <?php echo $tx["product_name"]."-".$tx["product_model"];  ?></option> <?php } ?> </datalist> <input type="hidden" class="common_product autocomplete_hidden_value  product_id_'+ dynamic_id +'" name="product_id[]" id="SchoolHiddenId_'+ dynamic_id +'" /> </td> <td>  <input list="magic_bundle" name="bundle_no[]" id="bundle_no_'+ dynamic_id +'"   class="form-control bundle_no"'+
     'onchange="this.blur();" /><datalist id="magic_bundle"><?php foreach($bundle as $tx){?> <option value="<?php echo $tx['bundle_no'];?>">  <?php echo $tx['bundle_no'];  ?></option> <?php } ?>'+
   
   '</datalist></td> <td> <input type="text" id="description_'+ dynamic_id +'" name="description[]" class="form-control" /> </td>  <td > <input type="text" name="thickness[]" id="thickness_'+ dynamic_id +'" required="" class="form-control"/> </td>  <td><input list="magic_supplier_block" name="supplier_block_no[]"  id="supplier_b_no_'+ dynamic_id +'"   class="form-control supplier_block_no"  placeholder="Search Product"  onchange="this.blur();" /><datalist id="magic_supplier_block"><?php foreach($supplier_block_no as $tx){?><option value="<?php echo $tx['supplier_block_no'];?>">  <?php echo $tx['supplier_block_no'];  ?></option><?php } ?></datalist> </td>  <td > <input type="text"  id="supplier_s_no_'+ dynamic_id +'" name="supplier_slab_no[]" required="" class="form-control"/> </td> <td> <input type="text" id="gross_width_'+ dynamic_id +'" name="gross_width[]" required="" class="gross_width  form-control" /> </td> <td> <input type="text" id="gross_height_'+ dynamic_id +'" name="gross_height[]"  required="" class="gross_height form-control" /> </td>  <td > <input type="text"   style="width:60px;" readonly id="gross_sq_ft_'+ dynamic_id +'" name="gross_sq_ft[]" class="gross_sq_ft form-control"/> </td>   <td style="text-align:center;" >  <input type="text"   style="width:20px;" value="1" class="slab_no" id="slab_no_'+ dynamic_id +'" name="slab_no[]"   readonly  required=""/>  </td> <td> <input type="text" id="net_width_'+ dynamic_id +'" name="net_width[]" required="" class="net_width form-control" /> </td> <td> <input type="text" id="net_height_'+ dynamic_id +'" name="net_height[]"    required="" class="net_height form-control" /> </td> <td > <input type="text"   style="width:60px;" readonly id="net_sq_ft_'+ dynamic_id +'" name="net_sq_ft[]" class="net_sq_ft form-control"/> </td> <td>   <input type="text" id="cost_sq_ft_'+ dynamic_id +'"  name="cost_sq_ft[]" readonly  style="width:70px;" value="0.00"  class="cost_sq_ft form-control" >   <td > <input type="text"  id="cost_sq_slab_'+ dynamic_id +'" name="cost_sq_slab[]" readonly   style="width:70px;" value="0.00"  class="cost_sq_slab form-control"/>    </td> <td><input type="text" id="sales_amt_sq_ft_'+ dynamic_id +'"  name="sales_amt_sq_ft[]"  style="width:70px;"  value="0.00" class="sales_amt_sq_ft form-control" /></td>  <td ><input type="text"  id="sales_slab_amt_'+ dynamic_id +'" name="sales_slab_amt[]"  style="width:70px;" value="0.00"  class="sales_slab_amt form-control"/></td> <td> <input type="text" id="weight_'+ dynamic_id +'" name="weight[]"  class="weight form-control" /> </td><td><input  type="text" class="total_price form-control" style="width:80px;" readonly value="0.00"  id="total_'+ dynamic_id +'"     name="total_amt[]"/></td><td ><input  type="checkbox" class="form-control hold-product" value="1" id="hold_product_'+ dynamic_id +'" name="hold_product[]" style="height: 12px !important"/> </td>  <td style="text-align:center;"> <button  class="delete btn btn-danger" id="delete_'+ dynamic_id +'" type="button" value="Delete" ><i class="fa fa-trash"></i></button> </td>  </tr> </tbody> <tfoot> <tr> <td style="text-align:right;" colspan="8"><b>Gross Sq.Ft :</b></td> <td > <input type="text" id="overall_gross_'+ dynamic_id +'" name="overall_gross[]"   class="overall_gross form-control" style="width: 60px"  readonly="readonly"  /> </td> <td style="text-align:right;" colspan="3"><b>Net Sq.Ft :</b></td> <td > <input type="text" id="overall_net_'+ dynamic_id +'" name="overall_net[]"  class="overall_net form-control"  style="width: 60px"  readonly="readonly"  /> </td> <td ><input type="text" id="costpersqft'+ dynamic_id +'" name="costpersqft[]"  class="costpersqft form-control"  style="width: 60px"  readonly="readonly"  /></td><td > <input type="text" id="costperslab_'+ dynamic_id +'" name="costperslab[]"  class="costperslab form-control"  style="width: 60px"  readonly="readonly"  /> </td>  <td > <input type="text" id="salespricepersqft_'+ dynamic_id +'" name="salespricepersqft[]"  class="salespricepersqft form-control"  style="width: 60px"  readonly="readonly"  /> </td>  <td > <input type="text" id="salesslabprice_'+ dynamic_id +'" name="salesslabprice[]"  class="salesslabprice form-control"  style="width: 60px"  readonly="readonly"  /> </td> <td ><input type="text" id="overall_weight_'+ dynamic_id +'" name="overall_weight[]"  class="overall_weight form-control"  style="width: 70px"  readonly="readonly"  /></td><td ><input type="text" id="Total_'+ dynamic_id +'" name="total[]"   class="b_total form-control"  style="width: 80px" value="0.00"  readonly="readonly"  /></td>  <td style="text-align:right; position: relative; right: 10px;" colspan="2"><i id="buddle_'+ dynamic_id +'" onclick="removebundle(); " class="btn-danger removebundle fa fa-minus" aria-hidden="true"></i></td>   </tr> </foot></table> <i id="buddle_'+ dynamic_id +'"  style="margin-right:20px;float:right;"   onclick="addbundle(); " class="btnclr addbundle fa fa-plus" aria-hidden="true"></i>';  
   
   
   document.getElementById('content').appendChild(newdiv);
   
   dynamic_id++;
   
   }
   localStorage.setItem('currency', '<?php echo $currency;?>');  
           var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
   var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
   //document.querySelector('input[class="product_name"]').addEventListener('change', onInput);
   $(document).on('change select input','.product_name', function (e) {
   //function onInput (e) {
      
       var id= $(this).attr('id');
     //  var id_num = id.match(/\d/g);
   var parts = id.split('_');
   var answer_id = parts[parts.length - 1];
   
       var pdt=$('#prodt_'+answer_id).val();
          //   var tid=$(this).closest('table').attr('id');
   
   
       localStorage.setItem('tab_id', '#prodt_'+answer_id);  
       console.log('#prodt_'+answer_id);
     //  var bun_num=$('#bundle_no_'+id_num).val();
       console.log(pdt);
       const myArray = pdt.split("-");
       var product_nam=myArray[0];
       var product_model=myArray[1];
      var data = {
       
           product_nam:product_nam,
           product_model:product_model,
         //  bun_num:bun_num
        };
        data[csrfName] = csrfHash;
   
        $.ajax({
            type:'POST',
            data: data, 
         dataType:"json",
            url:'<?php echo base_url();?>Cinvoice/product_info',
            success: function(result, statut) {
                console.log(' result length :'+result.length);
                if(result.length >0){
            var total="<table style='width:100%;table-layout: fixed' > <tr> <td style='width: 130px;'></td>  <td><input type='text' style='width: max-content;'  class='form-control' id='myInput1' onkeyup='search()' placeholder='Search for Supplier Block no..'></td> <td></td> <td> <input type='text' style='width: max-content;'  class='form-control' id='myInput2' onkeyup='search()' placeholder='Search for Supplier Slab no..'></td> <td></td> <td>  <input type='text' style='width: max-content;' class='form-control' id='myInput3' onkeyup='search()' placeholder='Search for Bundle no..'></td> <td></td> <td></td>  </tr></table><br/>";
        var table_header = "<table style='width:auto;table-layout: fixed;word-wrap:break-word;' class='table table-bordered table-hover'  id='product_table1'> <thead> <tr><th rowspan='2' class='text-center'>Select All</th>   <th rowspan='2' style='width: max-content;' class='text-center'>Bundle No</th> <th rowspan='2' style='width: max-content;' class='text-center'>Description</th> <th rowspan='2' class='text-center'>Thick ness<i class='text-danger'>*</i></th> <th rowspan='2' class='text-center'>Supplier Block No<i class='text-danger'>*</i></th>  <th rowspan='2' class='text-center' >Supplier Slab No<i class='text-danger'>*</i> </th> <th colspan='2' style='width: max-content;' class='text-center'>Gross Measurement<i class='text-danger'>*</i> </th> <th rowspan='2' class='text-center'>Gross Sq. Ft</th> <th rowspan='2' style='width: min-content;' class='text-center'>Bundle No<i class='text-danger'>*</i></th> <th rowspan='2' style='width: min-content;' class='text-center'>Slab No<i class='text-danger'>*</i></th> <th colspan='2' style='width: max-content;' class='text-center'>Net Measure<i class='text-danger'>*</i></th> <th rowspan='2' class='text-center'>Net Sq. Ft</th> <th rowspan='2' style='width: 80px;' class='text-center'>Cost per Sq. Ft</th> <th rowspan='2' style='width: 80px;' class='text-center'>Cost per Slab</th> <th rowspan='2' style='width: 80px;' class='text-center'>Sales<br/>Price per Sq. Ft</th> <th rowspan='2'  style='width: 80px;' class='text-center'>Sales Slab Price</th> <th rowspan='2' class='text-center'>Weight</th> <th rowspan='2' style='width: 100px' class='text-center'>Total</th> </tr>  <tr> <th class='text-center'>Width</th> <th class='text-center'>Height</th> <th class='text-center'>Width</th> <th class='text-center'>Height</th> </tr>  </thead><tbody>";
                var html ="";
var count=1;
               result.forEach(function(element) {
              html += "<tr><td><input type='checkbox' name='case[]' class='checkbox'/></td><td>"+element.bundle_no+"</td><td  class='ads' >"+element.description_table +"</td><td>"+element.thickness+"</td><td>"+element.supplier_block_no+"</td><td>"+element.supplier_slab_no+"</td><td>"+element.g_width+"</td><td>"+element.g_height+"</td><td>"+element.gross_sqft+"</td><td>"+element.bundle_no+"</td><td>"+count+"</td><td>"+element.n_height+"</td><td>"+element.n_width+"</td><td>"+element.net_sqft+"</td><td>"+element.cost_sqft+"</td><td>"+element.cost_slab+"</td><td>"+element.sales_price_sqft+"</td><td>"+element.sales_slab_price+"</td><td>"+element.weight+"</td><td>"+element.sales_slab_price+"</td></tr>";
         count++;
               });
   
   
   
                 //  var all = total+table_header +html+ table_footer;
   
                  var all = total+table_header+html ;
   
                   $('#salle_list5').html(all);
                               $('#product_model_info').modal('show');
           
   
              }else{
                 $('#product_model_info').modal('hide');
              }
           //    $(".product_id_"+ id_num).val(result[0]['product_id']);
           //      console.log(result);
            }
        });
    });
    var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
   var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
   
   
   
     $( "body" ).on( "click", ".checkbox", function() {
   
    $('#product_model_info').modal('hide');
        var values = new Array();
   
          $.each($("input[name='case[]']:checked").closest("td").siblings("td"),
                 function () {
                      values.push($(this).text());
                 });
             console.log(values);
             console.log(table_id_product);
      var table_id_product=localStorage.getItem("tab_id");
   var netheight = $(table_id_product).attr('id');
const indexLastDot = netheight.lastIndexOf('_');
var id = netheight.slice(indexLastDot + 1);

     $(table_id_product).closest("tr").find('#bundle_no_'+id).val(values[0]);
       $(table_id_product).closest("tr").find('#description_'+id).val(values[1]);
         $(table_id_product).closest("tr").find('#thickness_'+id).val(values[2]);
           $(table_id_product).closest("tr").find('#supplier_b_no_'+id).val(values[3]);
             $(table_id_product).closest("tr").find('#supplier_s_no_'+id).val(values[4]);
               $(table_id_product).closest("tr").find('#gross_width_'+id).val(values[5]);
                 $(table_id_product).closest("tr").find('#gross_height_'+id).val(values[6]);
                   $(table_id_product).closest("tr").find('#gross_sq_ft_'+id).val(values[7]);
                     $(table_id_product).closest("tr").find('#net_width_'+id).val(values[10]);
                       $(table_id_product).closest("tr").find('#net_height_'+id).val(values[11]);
                         $(table_id_product).closest("tr").find('#net_sq_ft_'+id).val(values[12]);
                           $(table_id_product).closest("tr").find('#cost_sq_ft_'+id).val(values[13]);
                             $(table_id_product).closest("tr").find('#cost_sq_slab_'+id).val(values[14]);
                               $(table_id_product).closest("tr").find('#sales_amt_sq_ft_'+id).val(values[15]);
                                 $(table_id_product).closest("tr").find('#sales_slab_amt_'+id).val(values[16]);
                                   $(table_id_product).closest("tr").find('#weight_'+id).val(values[17]);
                                   /*  $(table_id_product).closest("tr").find('#origin_'+id).val(values[18]);*/
                                       $(table_id_product).closest("tr").find('#total_'+id).val(values[16]);
                          var tid=$(table_id_product).closest('table').attr('id');
   
                            
   const indexLast = tid.lastIndexOf('_');
   var idt = tid.slice(indexLast + 1);
     var sum_net_val=0;
      $(table_id_product).closest('table').find('.net_sq_ft').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             sum_net_val += parseFloat(precio);
           }
         });
   $('#overall_net_'+idt).val(sum_net_val).trigger('change');
     var sum_w=0;
      $(table_id_product).closest('table').find('.weight').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             sum_w += parseFloat(precio);
           }
         });
   $('#overall_weight_'+idt).val(sum_w).trigger('change');
     var sum_gross_val=0;
      $(table_id_product).closest('table').find('.gross_sq_ft').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             sum_gross_val += parseFloat(precio);
           }
         });
   $('#overall_gross_'+idt).val(sum_gross_val).trigger('change');
     var sum_total_val=0;
      $(table_id_product).closest('table').find('.total_price').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             sum_total_val += parseFloat(precio);
           }
         });
   $('#Total_'+idt).val(sum_total_val).trigger('change');
   
   var total_net=0;
    $('.table').each(function() {
       $(this).find('.net_sq_ft').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             total_net += parseFloat(precio);
           }
         });
   
     });
   $('#total_net').val(total_net.toFixed(3)).trigger('change');
   var total_w=0;
    $('.table').each(function() {
       $(this).find('.weight').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             total_w += parseFloat(precio);
           }
         });
   
     });
   $('#total_weight').val(total_w.toFixed(3)).trigger('change');
     var overall_gs=0;
    $('.table').each(function() {
       $(this).find('.gross_sq_ft').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             overall_gs += parseFloat(precio);
           }
         });
    });
   
   $('#total_gross').val(overall_gs).trigger('change');
   
   var overall_sum=0;
    $('.table').each(function() {
       $(this).find('.total_price').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             overall_sum += parseFloat(precio);
           }
         });
   
   
     });
   
   $('#Over_all_Total').val(overall_sum.toFixed(3)).trigger('change');
    
      calculate();
   });
    $(document).on('click', '.delete', function(){
   
   
   var tid=$(this).closest('table').attr('id');
   localStorage.setItem("delete_table",tid);
   console.log(localStorage.getItem("delete_table"));
    var netheight = $('#'+localStorage.getItem("delete_table")).find('.net_height').attr('id');
    const indexLastDot = netheight.lastIndexOf('_');
   var id = netheight.slice(indexLastDot + 1);
   var rowCount = $(this).closest('tbody').find('tr').length;
   
   if(rowCount>1){
   $(this).closest('tr').remove();
   }

    var costpersqft=0;
     $('#'+localStorage.getItem("delete_table")).find('.cost_sq_ft').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             costpersqft += parseFloat(precio);
           }
         });
   $('#'+localStorage.getItem("delete_table")).find('.costpersqft').val(costpersqft).trigger('change');
     var cost_sq_slab=0;
      $('#'+localStorage.getItem("delete_table")).find('.cost_sq_slab').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             cost_sq_slab += parseFloat(precio);
           }
         });
   $('#'+localStorage.getItem("delete_table")).find('.costperslab').val(cost_sq_slab).trigger('change');
     var sales_amt_sq_ft=0;
       $('#'+localStorage.getItem("delete_table")).find('.sales_amt_sq_ft').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             sales_amt_sq_ft += parseFloat(precio);
           }
         });
    $('#'+localStorage.getItem("delete_table")).find('.salespricepersqft').val(sales_amt_sq_ft).trigger('change');
     var sales_slab_amt=0;
     $('#'+localStorage.getItem("delete_table")).find('.sales_slab_amt').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             sales_slab_amt += parseFloat(precio);
           }
         });
    $('#'+localStorage.getItem("delete_table")).find('.salesslabprice').val(sales_slab_amt).trigger('change');
      var sum=0;
       $('#'+localStorage.getItem("delete_table")).find('.total_price').each(function() {
   var v=$(this).val();
     sum += parseFloat(v);
   });
     $('#'+localStorage.getItem("delete_table")).find('.b_total').val(sum).trigger('change');
      var sumnet=0;
   
      $('#'+localStorage.getItem("delete_table")).find('.net_sq_ft').each(function() {
   var v=$(this).val();
    if (!isNaN(v) && v.length !== 0) {
             sumnet += parseFloat(v);
           }
   
   });
     $('#'+localStorage.getItem("delete_table")).find('.overall_net').val(sumnet.toFixed(3));
   
   
       var sumgross=0;
   
       $('#'+localStorage.getItem("delete_table")).find('.gross_sq_ft').each(function() {
   var v=$(this).val();
    if (!isNaN(v) && v.length !== 0) {
             sumgross += parseFloat(v);
           }
   
   });
     $('#'+localStorage.getItem("delete_table")).find('.overall_gross').val(sumgross.toFixed(3));
   var total_net=0;
    $('.table').each(function() {
       $(this).find('.net_sq_ft').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             total_net += parseFloat(precio);
           }
         });
   
        
   
   
     });
   $('#total_net').val(total_net.toFixed(3)).trigger('change');
     var overall_gs=0;
    $('.table').each(function() {
       $(this).find('.gross_sq_ft').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             overall_gs += parseFloat(precio);
           }
         });
    });
   
   $('#total_gross').val(overall_gs).trigger('change');
     var sum_w=0;
     $('.table').each(function() {
       $(this).find('.weight').each(function() {
    
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             sum_w += parseFloat(precio);
           }
         });
         });
   $('#'+localStorage.getItem("delete_table")).find('.overall_weight').val(sum_w).trigger('change');
   var total_w=0;
    $('.table').each(function() {
       $(this).find('.overall_weight').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             total_w += parseFloat(precio);
           }
         });
   
     });
   $('#total_weight').val(total_w.toFixed(3)).trigger('change');
   var overall_sum=0;
   $('.table').each(function() {
        $(this).find('.b_total').each(function() {
       
   var v=$(this).val();
     overall_sum += parseFloat(v);
   
   });});
    $('#Over_all_Total').val(overall_sum).trigger('change');
   
   
   
   gt(id);
   
   
   
   
   
    });
   
   
        $('#payment_from_modal').on('input',function(e){
         var payment = parseFloat($('#payment_from_modal').val().replace(/,/g, '')) || 0;
         var amount_to_pay = parseFloat($('#amount_to_pay').val().replace(/,/g, '')) || 0;
         console.log('payment: ' + payment + ', amount to pay: ' + amount_to_pay);
         var bal_value = amount_to_pay - payment;

         /*console.log('balance: ' + value);
    var payment=parseInt($('#payment_from_modal').val());
   var amount_to_pay=$('#amount_to_pay').val();
   console.log('payment:'+payment+', amount to_pay:'+amount_to_pay);
   var value=parseFloat(amount_to_pay)-parseFloat(payment); */
   console.log('balance:'+bal_value);
   //$('#balance_modal').val(bal_value);
  // if (isNaN(bal_value)) {
     //$('#balance_modal').val("0");
     // }
    });
         $('#bank_id').change(function(){
           localStorage.setItem("selected_bank_name",$('#bank_id').val());
   
         });
   
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
   $(document).on('click', '.addbundle', function(){
            $(this).css("display","none");
         $(this).closest('table').find('.removebundle').css("display","block");
    });
   
     $(document).ready(function(){
   
   
   
   var tid=$('.table').closest('table').attr('id');
   const indexLast = tid.lastIndexOf('_');
   var id = tid.slice(indexLast + 1);
   
   
   for (j = 0; j < 6; j++) {
          var $last = $('#addPurchaseItem_1 tr:last');
   
       var num = id+($last.index()+1);
       
       
   
   
        $('#addPurchaseItem_1 tr:last').clone().find('input,select,button').attr('id', function(i, current) {
           return current.replace(/\d+$/, num);
           
       }).end().appendTo('#addPurchaseItem_1');
        $.each($('#normalinvoice_1 > tbody > tr'), function (index, el) {
               $(this).find(".slab_no").val(index + 1); // Simply couse the first "prototype" is not counted in the list                
           })
         
   }
   
   
   
   });
   
   
   
   
   
   
   
  $(document).on('keyup','.normalinvoice tbody tr:last',function (e) {
      // debugger;
   var tid=$(this).closest('table').attr('id');
   const indexLast = tid.lastIndexOf('_');
   var id = tid.slice(indexLast + 1);
   
   
   
    var $last = $('#addPurchaseItem_'+id + ' tr:last');
   
   var num = id+($last.index()+1);
   
   $('#addPurchaseItem_'+id  + ' tr:last').clone().find('datalist,input,select').attr('id', function(i, current) {
       return current.replace(/\d+$/, num);
       
   }).end().appendTo('#addPurchaseItem_'+id );
   
   $.each($('#normalinvoice_'+id  +  '> tbody > tr'), function (index, el) {
           $(this).find(".slab_no").val(index + 1); // Simply couse the first "prototype" is not counted in the list                
       })
   
   var id1= $(this).closest('tr').find('.product_name').attr('id');
   var id_num = id1.substring(id1.indexOf('_') + 1);
   var pdt=$('#'+id1).val();
   console.log(pdt);
   const myArray = pdt.split("-");
   var product_nam=myArray[0];
   var product_model=myArray[1];
   var product_model=myArray[1];
  // var sales_slab_amt =myArray[14];  
   
   
   var data = {
      product_nam:product_nam,
      product_model:product_model,

      //sales_slab_amt:sales_slab_amt

   };
   data[csrfName] = csrfHash;
   $.ajax({
       type:'POST',
       data: data,
    dataType:"json",
       url:'<?php echo base_url();?>Cinvoice/availability',
       success: function(result, statut) {
           console.log(result);
           if(result.csrfName){
              csrfName = result.csrfName;
              csrfHash = result.csrfHash;
           }
           $("#total_amt_"+ id_num).val(result[0]['price']);
          // $("#sales_slab_amt_"+ id_num).val(result[0]['price']);
         $("#SchoolHiddenId_"+ id_num).val(result[0]['product_id']);
           console.log(result);
       }
   });

      debugger;

   var sum=0;
     $(this).closest('table').find('.total_price').each(function() {
   var v=$(this).val();
   sum += parseFloat(v);
   
   });
   $(this).closest('table').find('.b_total').val(sum).trigger('change');



   var sum=0;
     $(this).closest('table').find('.weight').each(function() {
   var v=$(this).val();
   sum += parseFloat(v);
   
   });
   $(this).closest('table').find('.overall_weight').val(sum).trigger('change');




   var sum=0;
     $(this).closest('table').find('.sales_slab_amt').each(function() {
   var v=$(this).val();
   sum += parseFloat(v);
   
   });
   $(this).closest('table').find('.salesslabprice').val(sum).trigger('change');


   var sum=0;
     $(this).closest('table').find('.sales_amt_sq_ft').each(function() {
   var v=$(this).val();
   sum += parseFloat(v);
   
   });
   $(this).closest('table').find('.salespricepersqft').val(sum).trigger('change');


   var sum=0;
     $(this).closest('table').find('.cost_sq_slab').each(function() {
   var v=$(this).val();
   sum += parseFloat(v);
   
   });
   $(this).closest('table').find('.costperslab').val(sum).trigger('change');



   var sum=0;
     $(this).closest('table').find('.cost_sq_ft').each(function() {
   var v=$(this).val();
   sum += parseFloat(v);
   
   });
   $(this).closest('table').find('.costpersqft').val(sum).trigger('change');




   var sum=0;
     $(this).closest('table').find('.gross_sq_ft ').each(function() {
   var v=$(this).val();
   sum += parseFloat(v);
   
   });
   $(this).closest('table').find('.overall_gross').val(sum).trigger('change');

   var sum=0;
     $(this).closest('table').find('.net_sq_ft').each(function() {
   var v=$(this).val();
   sum += parseFloat(v);
   
   });
   $(this).closest('table').find('.overall_net').val(sum).trigger('change');

  
 
  var overall_sum=0;
     $('.table').find('.total_price').each(function() {
    var v=$(this).val();
    overall_sum += parseFloat(v);
   }); 
   $('#Over_all_Total').val(overall_sum.toFixed(2)).trigger('change');
   $('#gtotal').val(overall_sum.toFixed(2)).trigger('change');
   $('#customer_gtotal').val(overall_sum.toFixed(2)).trigger('change');
   

   var overall_gs=0;
     $('.table').find('.gross_sq_ft').each(function() {
    var v=$(this).val();
    overall_gs += parseFloat(v);
   }); 
   $('#total_gross').val(overall_gs.toFixed(2)).trigger('change');
   

   var total_net=0;
     $('.table').find('.net_sq_ft').each(function() {
    var v=$(this).val();
    total_net += parseFloat(v);
   }); 
   $('#total_net').val(total_net.toFixed(2)).trigger('change');
   

   var overall_weight=0;
     $('.table').find('.weight').each(function() {
    var v=$(this).val();
    overall_weight += parseFloat(v);
   }); 
   $('#total_weight').val(overall_weight.toFixed(2)).trigger('change');
   

      calculate_ONROWADD();

       });
   

       function calculate_ONROWADD(){
   
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
                  var gtotal = parseFloat(total + answer);//fix
                  console.log("gtotal :" +gtotal);
                  var final_g= $('#final_gtotal').val();
                  var amt=parseFloat(answer)+parseFloat(total);
                  var num = isNaN(parseFloat(amt)) ? 0 : parseFloat(amt)
                  $('#gtotal').val(num.toFixed(2)); 
                  var custo_amt=$('.custocurrency_rate').val(); 
                  console.log("numhere :"+num +"-"+custo_amt);
                  var value=num*custo_amt;
                  var custo_final = isNaN(parseFloat(value)) ? 0 : parseFloat(value)
                  $('#customer_gtotal').val(custo_final.toFixed(2)); 
                  $('#tax_details').val(answer.toFixed(2) +" ( "+tax+" )");
                  var bal_amt=custo_final-$('#amount_paid').val();
                  $('#balance').val(bal_amt.toFixed(2));
                
                }



   

   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   function cal_all(){
      var netheight = $(this).closest('table').find('.net_height').attr('id');
   const indexLastDot = netheight.lastIndexOf('_');
   var id = netheight.slice(indexLastDot + 1);
   var net_width='net_width_'+id;
   var net_height = 'net_height_'+ id;
   var netwidth=$('#'+net_width).val();
   var netheight=$('#'+net_height).val();
   var netresult=parseInt(netwidth) * parseInt(netheight);
   netresult=netresult/144;
   netresult = isNaN(netresult) ? 0 : netresult;
   var nresult=netresult.toFixed(3);
   $('#'+'net_sq_ft_'+id).val(netresult.toFixed(3));
   var cost_sqft=$('#cost_sq_ft_'+id).val();
   var tid=$(this).closest('table').attr('id');
   const indexLast = tid.lastIndexOf('_');
   var idt = tid.slice(indexLast + 1);
   var sales_sqft=cost_sqft *nresult;
   var x = $('#slab_no_'+id).val();
   var sales_slab_price=cost_sqft *nresult*x;
   
   console.log(parseInt(cost_sqft) +"*"+parseInt(nresult)+"*"+idt);
   $('#'+'sales_slab_amt_'+id).val(sales_slab_price.toFixed(3));
   $(this).closest('tr').find('.total_price').val(sales_slab_price.toFixed(3));
   sales_sqft = isNaN(sales_sqft) ? 0 : sales_sqft;
   $('#'+'sales_amt_sq_ft_'+id).val(sales_sqft.toFixed(3));
    $('.table').each(function() {
       
         var sum=0;
   
        $(this).closest('table').find('.total_price').each(function() {
   var v=$(this).val();
     sum += parseFloat(v);
   
   });
   $('#Total_'+idt).val(sum).trigger('change');
   var total_net=0;
    $('.table').each(function() {
       $(this).find('.net_sq_ft').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             total_net += parseFloat(precio);
           }
         });
   
        
   
   
     });
   $('#total_net').val(total_net.toFixed(3)).trigger('change');
    var costpersqft=0;
      $(this).find('.cost_sq_ft').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             costpersqft += parseFloat(precio);
           }
         });
   $('#costpersqft_'+idt).val(costpersqft).trigger('change');
     var cost_sq_slab=0;
     $(this).find('.cost_sq_slab').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             cost_sq_slab += parseFloat(precio);
           }
         });
   $('#costperslab_'+idt).val(cost_sq_slab).trigger('change');
     var sales_amt_sq_ft=0;
      $(this).find('.sales_amt_sq_ft').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             sales_amt_sq_ft += parseFloat(precio);
           }
         });
   $('#salespricepersqft_'+idt).val(sales_amt_sq_ft).trigger('change');
     var sales_slab_amt=0;
      $(this).find('.sales_slab_amt').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             sales_slab_amt += parseFloat(precio);
           }
         });
   $('#salesslabprice_'+idt).val(sales_slab_amt).trigger('change');
     var overall_gs=0;
    $('.table').each(function() {
       $(this).find('.gross_sq_ft').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             overall_gs += parseFloat(precio);
           }
         });
    });
   
   $('#total_gross').val(overall_gs).trigger('change');
   
   var overall_sum=0;
        $('.table').find('.b_total').each(function() {
   var v=$(this).val();
     overall_sum += parseFloat(v);
   
   });
    $('#Over_all_Total').val(overall_sum.toFixed(3)).trigger('change');
   
   
   
   
    });
   
   
   
   gt(id);
   }
     $(document).on('click', '.removebundle', function(){
      
      
      var tid=$(this).closest('table').attr('id');
      localStorage.setItem("delete_table",tid);
      console.log(localStorage.getItem("delete_table"));
      var remove_id=$(this).closest('table').attr('id');
      $('#'+remove_id).remove();
        var sum=0;
         $('#'+localStorage.getItem("delete_table")).find('.total_price').each(function() {
      var v=$(this).val();
       sum += parseFloat(v);
      });
       $('#'+localStorage.getItem("delete_table")).find('.b_total').val(sum).trigger('change');
        var sumnet=0;
      
        $('#'+localStorage.getItem("delete_table")).find('.net_sq_ft').each(function() {
      var v=$(this).val();
      if (!isNaN(v) && v.length !== 0) {
               sumnet += parseFloat(v);
             }
      
      });
       $('#'+localStorage.getItem("delete_table")).find('.overall_net').val(sumnet.toFixed(3));
      
      
         var sumgross=0;
      
         $('#'+localStorage.getItem("delete_table")).find('.gross_sq_ft').each(function() {
      var v=$(this).val();
      if (!isNaN(v) && v.length !== 0) {
               sumgross += parseFloat(v);
             }
      
      });
       $('#'+localStorage.getItem("delete_table")).find('.overall_gross').val(sumgross.toFixed(3));
      var total_net=0;
      $('.table').each(function() {
         $(this).find('.net_sq_ft').each(function() {
             var precio = $(this).val();
             if (!isNaN(precio) && precio.length !== 0) {
               total_net += parseFloat(precio);
             }
           });
      
      
      
       });
      $('#total_net').val(total_net.toFixed(3)).trigger('change');
       var overall_gs=0;
      $('.table').each(function() {
         $(this).find('.gross_sq_ft').each(function() {
             var precio = $(this).val();
             if (!isNaN(precio) && precio.length !== 0) {
               overall_gs += parseFloat(precio);
             }
           });
      });
      
      $('#total_gross').val(overall_gs).trigger('change');
       var sum_w=0;
       $('#'+localStorage.getItem("delete_table")).find('.weight').each(function() {
             var precio = $(this).val();
             if (!isNaN(precio) && precio.length !== 0) {
               sum_w += parseFloat(precio);
             }
           });
       $('#'+localStorage.getItem("delete_table")).find('.overall_weight').val(sum_w).trigger('change');
      var total_w=0;
      $('.table').each(function() {
         $(this).find('.weight').each(function() {
             var precio = $(this).val();
             if (!isNaN(precio) && precio.length !== 0) {
               total_w += parseFloat(precio);
             }
           });
      
       });
      $('#total_weight').val(total_w.toFixed(3)).trigger('change');
      var overall_sum=0;
          $('.table').find('.total_price').each(function() {
      var v=$(this).val();
       overall_sum += parseFloat(v);
      
      });
      $('#Over_all_Total').val(overall_sum.toFixed(3)).trigger('change');
   
   
   
   gt(id);
   
   
   
   
   
    });
   $('#paypls').on('click', function (e) {
      e.preventDefault();
      var Balance = $('.balance_modal').val();
      $('#amount_to_pay').val(Balance);
      $('#payment_modal').modal('show');
   });
   $('#insert_product').submit(function (event) {
        event.preventDefault();
   if($('#product_name').val()!='' && $('#product_model').val()!='' && $('#sell_price').val()!='' && $('#quantity').val()!='' && $('#supplier_id').val()!='' && $('#product_sub_category').val()!='')
   {
      
   
       var dataString = {
           dataString : $("#insert_product").serialize()
      };
      dataString[csrfName] = csrfHash;
       $.ajax({
           type:"POST",
           dataType:"json",
           url:"<?php echo base_url(); ?>Cproduct/insert_product",
           data:$("#insert_product").serialize(),
           success:function (data1) {
           console.log(data1);
   
           $("#magicHouses").empty();
           for (var i in data1) {
              $("<option/>").html(data1[i].product_name +'-'+ data1[i].product_model).appendTo("#magicHouses");
           }
         
          $("#magicHouses").focus();
   
         $("#bodyModal1").html("Product Added Successfully");
          
         $('#myModal1').modal('show');
   
         window.setTimeout(function(){
           $('#product_info').modal('hide');
           $('.modal-backdrop').remove();
          $('#myModal1').modal('hide');
       }, 2000);
   }
   });
   }
   });
   
   
   
   
   
   $('#add_payment_info').submit(function (event) {    
      var dataString = {
          dataString : $("#add_payment_info").serialize()
     };
     dataString[csrfName] = csrfHash;
    
      $.ajax({
          type:"POST",
          dataType:"json",
          url:"<?php echo base_url(); ?>Cinvoice/add_payment_info",
          data:$("#add_payment_info").serialize(),
   
          success:function (data) {
    $('.amt').show();
   
       $('#payment_modal').modal('hide');
       $("#bodyModal1").html("Payment Successfully Completed");
          $('#myModal1').modal('show');
       
       window.setTimeout(function(){
           $('#myModal1').modal('hide');
   },2500);
   
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
           console.log(data);
           var gt=$('#customer_gtotal').val();
           var amtpd=data.amt_paid;
           console.log(data);
           var bal= $('#gtotal').val() - data.amt_paid;
           console.log(bal, "bal");
          $('#balance').val(bal.toFixed(2));
          
          if(amtpd){
         $('#amount_paid').val(amtpd);
         }else{
            $('#amount_paid').val("0.00"); 
         }
   
   
   
      var t_rate=$('.custocurrency_rate').val();
      document.getElementById("paid_convert").value=
      (amtpd /t_rate ).toFixed(2);
       document.getElementById("bal_convert").value=
      (bal /t_rate ).toFixed(2);
   
         }
       });
         $('#add_payment_info')[0].reset();
         }
   
      });
      event.preventDefault();
   });
   
   $('#payment_history').click(function (event) {
      
          
      var dataString = {
          dataString : $("#histroy").serialize()
      
     };
     dataString[csrfName] = csrfHash;
    
      $.ajax({
          type:"POST",
          dataType:"json",
          url:"<?php echo base_url(); ?>Cinvoice/performapayment_history",
          data:$("#histroy").serialize(),
          success:function (data) {
           var gt=$('#customer_gtotal').val();
           var amtpd = data.amt_paid !== null ? data.amt_paid : 0;
           var bal= $('#gtotal').val() - data.amt_paid;
           var total= "<table class='table table-striped table-bordered' id='paymentTable'><tr><td rowspan='2' style='vertical-align: middle;text-align-last: center;'><b>Grand Total :  <?php  echo $currency;  ?>"+$('#gtotal').val()+"<b></td><td class='td' style='border-right: hidden;'><b>Total Amount Paid :<b></td><td><?php  echo $currency;  ?>"+amtpd+"</td></tr></tr><td class='td' style='border-right: hidden;'><b>Balance :<b></td><td><?php  echo $currency;  ?>"+bal +"</td></tr></table>"
           var table_header = "<table class='table table-striped table-bordered'><thead style='FONT-WEIGHT:BOLD;'><tr><td>S.NO</td><td>Payment Date</td><td>Reference.NO</td><td>Bank Name</td><td>Amount Paid</td><td>Balance</td><td>Details</td></tr></thead><tbody>";
            var table_footer = "</tbody></table>";
            var html ="";
            var count=1;
            if (data.payment_get && data.payment_get.length > 0) {
                data.payment_get.forEach(function(element) {
                    html += "<tr><td>"+count+"</td><td>"+element.payment_date+"</td><td>"+element.reference_no+"</td><td>"+element.bank_name+"</td><td><?php echo $currency; ?>"+element.amt_paid+"</td><td><?php echo $currency; ?>"+element.balance+"</td><td>" + (element.details ? element.details : '') + "</td></tr>";
                    count++;
                });
            } else {
               html = "<tr><td colspan='7' style='text-align:center;'>No data available</td></tr>";
            }
            var all = total+table_header +html+ table_footer;
            $('#salle_list').html(all);
            $('#payment_history_modal').modal('show');
         }
   
      });
      event.preventDefault();
   });
   
       $('#add_bank').submit(function (event) {
      
          
      var dataString = {
          dataString : $("#add_bank").serialize()
      
     };
     dataString[csrfName] = csrfHash;
    
      $.ajax({
          type:"POST",
          dataType:"json",
          url:"<?php echo base_url(); ?>Csettings/add_new_bank",
          data:$("#add_bank").serialize(),
   
          success: function (data) {
           $.each(data, function (i, item) {
              
               result = '<option value=' + data[i].bank_name + '>' + data[i].bank_name + '</option>';
           });
         
           $('.bankpayment').selectmenu(); 
           $('.bankpayment').append(result).selectmenu('refresh',true);
          $("#bodyModal1").html("Bank Added Successfully");
          $('#myModal3').modal('hide');
          $('#add_bank_info').modal('hide');
          $('#bank').show();
           $('#myModal1').modal('show');
          window.setTimeout(function(){
         
           $('#myModal5').modal('hide');
           $('#myModal1').modal('hide');
       
        }, 2000);
        
         }
   
      });
      event.preventDefault();
   });
   
   
   
         $(document).ready(function () {
         $('#bank').selectize({
             sortField: 'text'
         });
     });
   
   var isChange;
   $("input[type='text'], textarea").keyup(function () {
     
       isChange = true;
   
   });
   
   
   $(document).ready(function () {
   
   $('#openBtn').click(function () {
       $('#payment_modal').modal({
           show: true
       })
   });
   
       $(document).on('show.bs.modal', '.modal', function (event) {
           var zIndex = 1040 + (10 * $('.modal:visible').length);
           $(this).css('z-index', zIndex);
           setTimeout(function() {
               $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
           }, 0);
       });
   
   
   });
   $(document).on('keyup', '.weight', function(){
   var weight=0;
        $(this).closest('table').find('.weight').each(function() {
   var v=$(this).val();
    if (!isNaN(v) && v.length !== 0) {
             weight += parseFloat(v);
           }
   });
    $(this).closest('table').find('.overall_weight').val(weight.toFixed(3));
   var total_weight=0;
    $('.table').each(function() {
       $(this).find('.weight').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             total_weight += parseFloat(precio);
           }
         });
   
        
   
   
     });
   $('#total_weight').val(total_weight.toFixed(3)).trigger('change');
   
   });
   $(document).on('keyup', '.net_height,.net_width', function(){
     
   var tid=$(this).closest('table').attr('id');
   const indexLast1 = tid.lastIndexOf('_');
   var idt = tid.slice(indexLast1 + 1);
    var netheight = $(this).attr('id');
   const indexLastDot = netheight.lastIndexOf('_');
   var id = netheight.slice(indexLastDot + 1);
   var net_width='net_width_'+id;
   var net_height = 'net_height_'+ id;
   var netwidth=$('#'+net_width).val();
   var netheight=$('#'+net_height).val();
   var netresult=parseInt(netwidth) * parseInt(netheight);
   netresult=netresult/144;
   netresult = isNaN(netresult) ? 0 : netresult;
   var nresult=netresult.toFixed(3);
   $('#'+'net_sq_ft_'+id).val(netresult.toFixed(3));
   var sales_slab_price=$('#sales_slab_amt_'+id).val();
   var tid=$(this).closest('table').attr('id');
   const indexLast = tid.lastIndexOf('_');
   var idt = tid.slice(indexLast + 1);
   var sales_amt_sq_ft=sales_slab_price / nresult;
   
   sales_amt_sq_ft = isNaN(sales_amt_sq_ft) ? 0 : sales_amt_sq_ft;
   $('#'+'sales_amt_sq_ft_'+id).val(sales_amt_sq_ft.toFixed(3));
    var sumnet=0;
    $(this).closest('table').find('.net_sq_ft').each(function() {
   var v=$(this).val();
    if (!isNaN(v) && v.length !== 0) {
             sumnet += parseFloat(v);
           }
   
   });
   $('#overall_net_'+idt).val(sumnet.toFixed(3));
   var total_net=0;
    $('.table').each(function() {
       $(this).find('.net_sq_ft').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             total_net += parseFloat(precio);
           }
         });
   
        
   
   
     });
   $('#total_net').val(total_net.toFixed(3)).trigger('change');
   
   
     var sum=0;
   
        $(this).closest('table').find('.total_price').each(function() {
   var v=$(this).val();
     sum += parseFloat(v);
   
   });
   
   var overall_sum=0;
    $('.table').each(function() {
       $(this).find('.total_price').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             overall_sum += parseFloat(precio);
           }
         });
   
        
   
   
     });
   
   $('#Over_all_Total').val(overall_sum.toFixed(3)).trigger('change');
   $('#Total_'+idt).val(sum);
   var total_net=0;
    $('.table').each(function() {
       $(this).find('.sales_amt_sq_ft').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             total_net += parseFloat(precio);
           }
         });
   
        
   
   
     });
    
   $('#salespricepersqft_'+idt).val(total_net.toFixed(3)).trigger('change');
   calculate();
   });
   
   $(document).on('input', '.gross_height,.gross_width', function(){
   
    var netheight = $(this).attr('id');
   const indexLastDot = netheight.lastIndexOf('_');
   var id = netheight.slice(indexLastDot + 1);
   var net_width='gross_width_'+id;
   var net_height = 'gross_height_'+ id;
   var tid=$(this).closest('table').attr('id');
   const indexLast = tid.lastIndexOf('_');
   var idt = tid.slice(indexLast + 1);
   var netwidth=$('#'+net_width).val();
   var netheight=$('#'+net_height).val();
   var netresult=parseInt(netwidth) * parseInt(netheight);
   netresult=netresult/144;
   netresult = isNaN(netresult) ? 0 : netresult;
   var nresult=netresult.toFixed(3);
   
   $('#'+'gross_sq_ft_'+id).val(netresult.toFixed(3));
   
       var sumgross=0;
   
        $(this).closest('table').find('.gross_sq_ft').each(function() {
   var v=$(this).val();
    if (!isNaN(v) && v.length !== 0) {
             sumgross += parseFloat(v);
           }
   
   });
   $('#overall_gross_'+idt).val(sumgross.toFixed(3));
      
   
   var overall_gs=0;
    $('.table').each(function() {
       $(this).find('.gross_sq_ft').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             overall_gs += parseFloat(precio);
           }
         });
    });
   
   $('#total_gross').val(overall_gs).trigger('change');
   
   gt(id);
   
   });
   $(document).on("input change", ".total_price", function(e){
   
   var netheight = $(this).attr('id');
   const indexLastDot = netheight.lastIndexOf('_');
   var id = netheight.slice(indexLastDot + 1);
   var net_width='net_width_'+id;
   var net_height = 'net_height_'+ id;
   var netwidth=$('#'+net_width).val();
   var netheight=$('#'+net_height).val();
   var netresult=parseInt(netwidth) * parseInt(netheight);
   netresult=netresult/144;
   netresult = isNaN(netresult) ? 0 : netresult;
   var nresult=netresult.toFixed(3);
   $('#'+'net_sq_ft_'+id).val(netresult.toFixed(3));
   var cost_sqft=$('#cost_sq_ft_'+id).val();
   var tid=$(this).closest('table').attr('id');
   const indexLast = tid.lastIndexOf('_');
   var idt = tid.slice(indexLast + 1);
   var sales_sqft=cost_sqft *nresult;
   var x = $('#slab_no_'+id).val();
   var sales_slab_price=cost_sqft *nresult*x;
   
   console.log(parseInt(cost_sqft) +"*"+parseInt(nresult)+"*"+idt);
   $('#'+'sales_slab_amt_'+id).val(sales_slab_price.toFixed(3));
   $(this).closest('tr').find('.total_price').val(sales_slab_price.toFixed(3));
   sales_sqft = isNaN(sales_sqft) ? 0 : sales_sqft;
   $('#'+'sales_amt_sq_ft_'+id).val(sales_sqft.toFixed(3));
       var sum_net=0;
   
         $(this).closest('table').find('.net_sq_ft').each(function() {
           var v=$(this).val();
          
       sum_net += parseFloat(v);
       
       sum_net = isNaN(sum_net) ? 0 : sum_net;
      
   });
   $('#overall_net_'+idt).val(sum_net.toFixed(3));
       var sum_gross=0;
       
       $(this).closest('table').find('.gross_sq_ft').each(function() {
           var v=$(this).val();
          
       sum_gross += parseFloat(v);
        
         
       sum_gross = isNaN(sum_gross) ? 0 : sum_gross;
       
   });
   $('#overall_gross_'+idt).val(sum_gross.toFixed(3));
   var total_net=0;
    $('.table').each(function() {
       $(this).find('.net_sq_ft').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             total_net += parseFloat(precio);
           }
         });
   
        
   
   
     });
   $('#total_net').val(total_net.toFixed(3)).trigger('change');
     var overall_gs=0;
    $('.table').each(function() {
       $(this).find('.gross_sq_ft').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             overall_gs += parseFloat(precio);
           }
         });
    });
   
   $('#total_gross').val(overall_gs).trigger('change');
     var sum=0;
   
        $(this).closest('table').find('.total_price').each(function() {
   var v=$(this).val();
     sum += parseFloat(v);
   
   });
   
   var overall_sum=0;
    $('.table').each(function() {
       $(this).find('.total_price').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             overall_sum += parseFloat(precio);
           }
         });
   
   
   calculate();
     });
   
   
   $('#Over_all_Total').val(overall_sum.toFixed(3)).trigger('change');
   $('#Total_'+idt).val(sum);
   });
   
   $('#Total').on('change textInput input', function (e) {
       calculate();
   });
   
   $('.custocurrency_rate').on('change textInput input', function (e) {
       calculate();
   });
   
   $(document).on('change select input','.product_name', function (e) {
   var netheight = $(this).attr('id');
   const indexLastDot = netheight.lastIndexOf('_');
   var id = netheight.slice(indexLastDot + 1);
   var net_width='net_width_'+id;
   var net_height = 'net_height_'+ id;
   var netwidth=$('#'+net_width).val();
   var netheight=$('#'+net_height).val();
   var netresult=parseInt(netwidth) * parseInt(netheight);
   netresult=netresult/144;
   netresult = isNaN(netresult) ? 0 : netresult;
   var nresult=netresult.toFixed(3);
   $('#'+'net_sq_ft_'+id).val(netresult.toFixed(3));
   var cost_sqft=$('#cost_sq_ft_'+id).val();
   var tid=$(this).closest('table').attr('id');
   const indexLast = tid.lastIndexOf('_');
   var idt = tid.slice(indexLast + 1);
   var sales_slab_price=$('#sales_slab_amt_'+id).val();
   var tid=$(this).closest('table').attr('id');
   
   var sales_amt_sq_ft=sales_slab_price / nresult;
   
   sales_amt_sq_ft = isNaN(sales_amt_sq_ft) ? 0 : sales_amt_sq_ft;
   $('#'+'sales_amt_sq_ft_'+id).val(sales_amt_sq_ft.toFixed(3));
   $('#'+'total_'+id).val(sales_amt_sq_ft.toFixed(3));
   var costpersqft=0;
       $(this).closest('table').find('.cost_sq_ft').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             costpersqft += parseFloat(precio);
           }
         });
   $('#costpersqft_'+idt).val(costpersqft).trigger('change');
     var cost_sq_slab=0;
     $(this).closest('table').find('.cost_sq_slab').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             cost_sq_slab += parseFloat(precio);
           }
         });
   $('#costperslab_'+idt).val(cost_sq_slab).trigger('change');
     var sales_amt_sq_ft=0;
        $(this).closest('table').find('.sales_amt_sq_ft').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             sales_amt_sq_ft += parseFloat(precio);
           }
         });
   $('#salespricepersqft_'+idt).val(sales_amt_sq_ft).trigger('change');
     var sales_slab_amt=0;
      $(this).closest('table').find('.sales_slab_amt').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             sales_slab_amt += parseFloat(precio);
           }
         });
   $('#salesslabprice_'+idt).val(sales_slab_amt).trigger('change');
    var sumnet=0;
   
        $(this).closest('table').find('.net_sq_ft').each(function() {
   var v=$(this).val();
    if (!isNaN(v) && v.length !== 0) {
             sumnet += parseFloat(v);
           }
   
   });
   $('#overall_net_'+idt).val(sumnet.toFixed(3));
       var sumgross=0;
   
        $(this).closest('table').find('.gross_sq_ft').each(function() {
   var v=$(this).val();
    if (!isNaN(v) && v.length !== 0) {
             sumgross += parseFloat(v);
           }
   
   });
   $('#overall_gross_'+idt).val(sumgross.toFixed(3));
   var total_net=0;
    $('.table').each(function() {
       $(this).find('.net_sq_ft').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             total_net += parseFloat(precio);
           }
         });
   
   
     });
   $('#total_net').val(total_net.toFixed(3)).trigger('change');
     var overall_gs=0;
    $('.table').each(function() {
       $(this).find('.gross_sq_ft').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             overall_gs += parseFloat(precio);
           }
         });
    });
   
   $('#total_gross').val(overall_gs).trigger('change');
   
   
   var overall_sum=0;
    $('.table').each(function() {
       $(this).find('.total_price').each(function() {
           var precio = $(this).val();
           if (!isNaN(precio) && precio.length !== 0) {
             overall_sum += parseFloat(precio);
           }
         });
   
   
     });
   
   
   $('#Over_all_Total').val(overall_sum.toFixed(3)).trigger('change');
     var sum=0;
   
        $(this).closest('table').find('.total_price').each(function() {
   var v=$(this).val();
     sum += parseFloat(v);
   
   });
   $('#Total_'+idt).val(sum);
   
   
   gt(id);
      var id= $(this).attr('id');
     var id_num = id.substring(id.indexOf('_') + 1);
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
       // $.ajax({
       //     type:'POST',
       //     data: data,
       //  dataType:"json",
       //     url:'<?php echo base_url();?>Cinvoice/availability',
       //     success: function(result, statut) {
       //         console.log(result);
       //         if(result.csrfName){
       //           csrfName = result.csrfName;
       //           csrfHash = result.csrfHash;
       //         }
       //          $("#cost_sq_ft_"+ id_num).val(result[0]['cost_persqft']);
       //       $("#cost_sq_slab_"+ id_num).val(result[0]['cost_perslab']);
       //       $("#sales_slab_amt_"+id_num).val(result[0]['price'])
              
              
             $("#SchoolHiddenId_"+ id_num).val(result[0]['product_id']);
       //         console.log(result);
       //     }
       // });
   });
   
</script>

<style type="text/css">
   .image-block{
      border-radius: 10px;
      background-color: #38469f;
      margin: 5px;
      color: #fff;
      display: inline-flex;
      padding: 5px 13px 6px 6px;
   }
   .image-block i {
      margin-right: 10px; 
      cursor: pointer; 
      position: relative;
      top: 4px;
   }
</style>