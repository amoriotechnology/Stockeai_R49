<div class="content-wrapper">
<section class="content-header">
   <div class="header-icon">
      <figure class="one">
      <img src="<?php echo base_url()  ?>asset/images/quota.png"  class="headshotphoto" style="height:50px;" />
   </div>
   <div class="header-title">
      <div class="logo-holder logo-9">
         <h1>Create Quotation</h1>
      </div>
      <small></small>
      <ol class="breadcrumb" style="border: 3px solid #d7d4d6;">
         <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
         <li><a href="#"><?php echo display('Sale') ?></a></li>
         <li class="active" style="color:orange;"><?php echo display('Create Quotation') ?></li>
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
      .removebundle, .addbundle{
      padding: 10px 12px 10px 12px;
      border-radius:5px;
      }
      .ui-front{
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
      #block_container
      {height:40px;
      text-align:center;
      }
      th{
      font-size:12px;
      }
      #bloc1, #bloc2
      {text-align:center;
      font-weight:bold;
      display:inline;
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
   </style>
   <?php    $payment_id=rand(); ?>
   <form id="histroy" style="display:none;" method="post" >
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
      <input type="hidden"  value="<?php echo $payment_id; ?>" name="paymentIds" class="payment_id" id="paymentIds"/>
      <input type="submit" id="payment_history" name="payment_history" class="btn" style="float:right;" value="Payment History" style="float:right;margin-bottom:30px;"/>
   </form>
   <!-- Purchase report -->
   <div class="row">
   <div class="col-sm-12">
   <div class="panel panel-bd lobidrag"    style="border: 3px solid #d7d4d6;">
   <div class="panel-heading">
      <div class="panel-title">
         <div id="block_container">
            <div id="bloc2" style="float:right;">
               <a href="<?php echo base_url('Cinvoice/manage_profarma_invoice?id=' . $_GET['id']); ?>" class="btnclr btn  m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('Manage Quotation') ?> </a>
            </div>
         </div>
      </div>
   </div>
   <div class="panel-body">
   <form id="insert_trucking" method="post">
		<div class="displaymessage"></div>
		<br>
      <input type="hidden"  value="<?php echo $payment_id; ?>" name="paymentIds" class="payment_id" id="paymentIds"/>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group row">
				   <label for="date" class="col-sm-4 col-form-label"><?php echo display('date') ?>
				   <i class="text-danger">*</i>
				   </label>
				   <div class="col-sm-8">
					  <?php $date = date('Y-m-d'); ?>
					  <input type="date" required tabindex="2" class="form-control datepicker" name="purchase_date" value="<?php echo htmlspecialchars($date); ?>" id="date" style="border: 2px solid #d7d4d6;width:100%">
				   </div>
				</div>
			</div>
			 <div class="col-sm-6">
				<div class="form-group row">
				   <label for="adress" class="col-sm-4 col-form-label"><?php echo display('Buyer / Customer') ?> <i class="text-danger">*</i>
				   </label>
				   <div class="col-sm-7">
					  <select name="customer_id" id="customer_id" style="border: 2px solid #d7d4d6;"  class="form-control">
						 <option value="Select the Customer" selected disabled><?php echo 'Select the Customer'; ?></option>
						 <?php foreach($customer as $customervalue){ ?>
						 <option value="<?=$customervalue['customer_id']; ?>"><?=$customervalue['customer_name']; ?></option>
						 <?php } ?>
					  </select>
				   </div>
				   <div class="col-sm-1">
					  <a href="#" class="client-add-btn btn btnclr mobile_icon" aria-hidden="true" data-toggle="modal" data-target="#cust_info"><i class="fa fa-user-circle"></i></i></a>
				   </div>
				</div>
			 </div>
		</div>
		<div class="row">
         <div class="col-sm-6">
            <div class="form-group row">
               <label for="invoice_no" class="col-sm-4 col-form-label"><?php echo display('Invoice Number')?>
               <i class="text-danger"></i>
               </label>
               <div class="col-sm-8">
                  <input type="text" tabindex="3" style="border: 2px solid #d7d4d6;"    class="form-control" id="chalan_no" readonly name="chalan_no" value="<?php if(!empty($voucher_no[0]['voucher'])){
                     $curYear = date('Y'); 
                     $month = date('m');
                     $vn = substr($voucher_no[0]['voucher'],9)+1;
                     echo $voucher_n = 'PI'. $curYear.$month.'-'.$vn;
                     }else{
                         $curYear = date('Y'); 
                     $month = date('m');
                     echo $voucher_n = 'PI'. $curYear.$month.'-'.'1';
                     } ?>"  />
               </div>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="form-group row">
               <label for="eta" class="col-sm-4 col-form-label"><?php echo display('Place of Receipt') ?>
               </label>
               <div class="col-sm-8">
                  <textarea class="form-control" tabindex="4" id="eta" name="receipt" placeholder="Place of Receipt" rows="1"    style="border: 2px solid #d7d4d6;width:100%"  ></textarea>
               </div>
            </div>
         </div>
      </div>
      <!-- <input type="hidden"  value="<?php echo $payment_id; ?>"  name="payment_id"/> -->
      <input type="hidden" id="makepaymentId" name="makepaymentId">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
      <input type="hidden" id="invoice_hdn"/>
      <input type="hidden" name="admin_company_id" id="admin_company_id" value="<?php echo $_GET['id']; ?>">
      <input type="hidden" id="viewPurchaseid">
      <div class="row">
         <div class="col-sm-6">
            <div class="form-group row">
               <label for="etd" class="col-sm-4 col-form-label"><?php echo display('Pre Carriage') ?>
               <i class="text-danger"></i>
               </label>
               <div class="col-sm-8">
                  <input type="text" tabindex="3" class="form-control" name="pre_carriage"  style="border: 2px solid #d7d4d6;" id="pre_carriage" placeholder="Pre Carriage By" id="etd" />
               </div>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="form-group row">
               <label for="bl_number" class="col-sm-4 col-form-label"><?php echo display('Description goods') ?>
               <i class="text-danger"></i>
               </label>
               <div class="col-sm-8">
                  <input type="text"  name="description_goods" class="form-control" style="border: 2px solid #d7d4d6;"  placeholder='Polished Granite slabs' id="goods"> 
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-sm-6">
            <div class="form-group row">
               <label for="shipping_line" class="col-sm-4 col-form-label"><?php echo display('Country of origin of goods')?>
               <i class="text-danger"></i>
               </label>
               <div class="col-sm-8">
                  <select class="selectpicker countrypicker form-control"  data-live-search="true" data-default="United States"  name="country_goods" id="shipping_line" style="border: 2px solid #d7d4d6;width:100%" >
                     <?php foreach (getAllCountries() as $conval){
                        $selectcon = $conval['iso3'] =='USA' ? 'selected' : '';
                        echo '<option '.$selectcon.' value="'.$conval['name'].'">'.$conval['name'].'</option>';
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
                  <select class="selectpicker countrypicker form-control" data-live-search="true" data-default="United States" id="container_no" name="country_destination" placeholder="Country of final destination" style="border: 2px solid #d7d4d6;width:100%" >
                     <?php foreach (getAllCountries() as $country){
                        $selectcon = $country['iso3'] =='USA' ? 'selected' : '';
                        echo '<option '.$selectcon.' value="'.$country['name'].'">'.$country['name'].'</option>';
                     } ?>
                  </select>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-sm-6">
            <div class="form-group row">
               <label for="bl_number" class="col-sm-4 col-form-label"> <?php echo display('Port of loading') ?>
               <i class="text-danger"></i>
               </label>
               <div class="col-sm-8">
                  <input type="text" tabindex="3" class="form-control" name="loading" placeholder="Port of loading" style="border: 2px solid #d7d4d6;"  id="bl_number" />
               </div>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="form-group row">
               <label for="bl_number" class="col-sm-4 col-form-label"><?php echo display('Port of discharge') ?>
               <i class="text-danger"></i>
               </label>
               <div class="col-sm-8">
                  <input type="text" tabindex="3" class="form-control" name="discharge" placeholder="Port of discharge" style="border: 2px solid #d7d4d6;"  id="bd_number" />
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-sm-6">
            <div class="form-group row">
               <label for="bl_number" class="col-sm-4 col-form-label"><?php echo display('Terms of payment and delivery')?>
               <i class="text-danger"></i>
               </label>
               <div class="col-sm-8">
                  <input type="text" tabindex="3" class="form-control" name="terms_payment" placeholder="Terms of payment and delivery"  style="border: 2px solid #d7d4d6;"  id="delivery" />
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
      <br>
      <div class="table-responsive">
         <div id="content">
            <table class="table normalinvoice table-bordered table-hover" id="normalinvoice_1" style="border: 2px solid #d7d4d6;" >
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
                     <th rowspan="2" style="width: 100px" class="text-center"><?php echo display('Total')?>($)</th>
                     <th rowspan="2" style="width: 100px" class="text-center"><?php echo "Hold"; ?></th>
                     <th rowspan="2" class="text-center"><?php echo display('Action')?></th>
                  </tr>
                  <tr>
                     <th class="text-center"><?php echo display('Width')?></th>
                     <th class="text-center"><?php echo display('Height')?></th>
                     <th class="text-center"  ><?php echo display('Width')?></th>
                     <th class="text-center" ><?php echo display('Height')?></th>
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
                  .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
                  padding:5px;
                  }
                  table {
                  width: 100px;
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
                  #download_select:focus option:first-of-type , #print_select:focus option:first-of-type{
                  display: none;
                  }
               </style>
               <tbody id="addPurchaseItem_1">
                  <tr>
                     <td>
                        <input type="hidden" name="tableid[]" id="tableid_1"/>
                        <input list="magicHouses" name="prodt[]" id="prodt_1"  class="form-control product_name"  onchange="this.blur();"  placeholder="Search Product" />
                        <datalist id="magicHouses">
                           <?php 
                              foreach($product as $tx){?>
                           <option value="<?php echo $tx['product_name'].'-'.$tx['product_model'];?>">  <?php echo $tx['product_name'].'-'.$tx['product_model'];  ?></option>
                           <?php } ?>
                        </datalist>
                        <input type='hidden' class='common_product autocomplete_hidden_value  product_id_1' name='product_id[]' id='SchoolHiddenId_1' />
                     </td>
                     <td>
                        <input type="text" id="bundle_no_1" name="bundle_no[]" class="bundle_no form-control"/>
                     </td>
                     <td>
                        <input type="text" id="description_1" name="description[]" class="form-control" />
                     </td>
                     <td >
                        <input type="number" name="thickness[]" id="thickness_1" class="form-control"/>
                     </td>
                     <td>
                        <input type="number" id="supplier_b_no_1" name="supplier_block_no[]" class="form-control"/>
                     </td>
                     <td >
                        <input type="number"  id="supplier_s_no_1" name="supplier_slab_no[]" class="form-control"/>
                     </td>
                     <td>
                        <input type="number" id="gross_width_1" name="gross_width[]" class="gross_width  form-control"/>
                     </td>
                     <td>
                        <input type="number" id="gross_height_1" name="gross_height[]" class="gross_height form-control"/>
                     </td>
                     <td >
                        <input type="text"   style="width:60px;" readonly id="gross_sq_ft_1" name="gross_sq_ft[]" class="gross_sq_ft form-control"/>
                     </td>
                     <td style="text-align:center;" >
                        <input type="text"   style="width:20px;" value="1" class="slab_no" id="slab_no_1" name="slab_no[]"  readonly  /> 
                     </td>
                     <td>
                        <input type="number" id="net_width_1" name="net_width[]" class="net_width form-control"/>
                     </td>
                     <td>
                        <input type="number" id="net_height_1" name="net_height[]" class="net_height form-control"/>
                     </td>
                     <td >
                        <input type="text"   style="width:60px;" readonly id="net_sq_ft_1" name="net_sq_ft[]" class="net_sq_ft form-control"/>
                     </td>
                     <td>
                        <input type="text" id="cost_sq_ft_1"  name="cost_sq_ft[]" readonly  style="width:70px;"  placeholder="0.00"   class="cost_sq_ft form-control">
                     <td >
                        <input type="text"  id="cost_sq_slab_1" name="cost_sq_slab[]" readonly   style="width:70px;"   placeholder="0.00"  class="cost_sq_slab form-control"/>
                     </td>
                     <td>
                        <input type="number" id="sales_amt_sq_ft_1"  name="sales_amt_sq_ft[]"  style="width:70px;"  placeholder="0.00" class="sales_amt_sq_ft form-control" />
                     </td>
                     <td >
                       <input type="text"  id="sales_slab_amt_1" name="sales_slab_amt[]"  style="width:70px;" placeholder="0.00"  class="sales_slab_amt form-control"/>
                     </td>
                     </span>
                     </td>
                     <td>
                        <input type="number" id="weight_1" name="weight[]"  class="weight form-control" />
                     </td>
                     <td >
                        <input type="text" class="total_price form-control" style="width:80px;" readonly value="0.00"  id="total_amt_1"  name="total_amt[]"/>
                     </td>
                     <td>
                        <input type="checkbox" name="hold_product[]" class="form-control hold-product" id="hold_product" value="1" style="height: 12px !important">
                     </td>
                     <td style="text-align:center;">
                        <button  class='delete btn btn-danger' id="delete_1" type='button' value='Delete'><i class="fa fa-trash"></i></button>
                     </td>
                  </tr>
               </tbody>
               <tfoot>
                  <tr>
                     <td style="text-align:right;" colspan="8"><b><?php echo display('Gross Sq.Ft')?> :</b></td>
                     <td >
                        <input type="text" id="overall_gross_1" name="overall_gross[]"   class="overall_gross form-control" style="width: 60px"  readonly="readonly"  /> 
                     </td>
                     <td style="text-align:right;" colspan="3"><b><?php echo display('Net Sq.Ft')?> :</b></td>
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
                        <input type="text" id="overall_weight_1" name="overall_weight[]"  class="overall_weight form-control"  style="width: 70px"  readonly="readonly"  /> 
                     </td>
                     <td >
                        <input type="text" id="Total_1" name="total[]"   class="b_total form-control"  style="width: 80px" value="0.00"  readonly="readonly"  />
                     </td>
                  </tr>
               </tfoot>
            </table>
            <!--<i id="buddle_1" class="addbundle fa fa-plus" style="float:right;color:white;background-color: #38469f; font-size:24px; " aria-hidden="true" onclick="addbundle(); "></i>  -->
            <i id="buddle_1" class="btnclr addbundle fa fa-plus" style=" padding: 10px 12px 10px 12px;margin-right: 18px;float:right; "   onclick="addbundle(); "aria-hidden="true"></i>
         </div>
         <table class="taxtab table table-bordered table-hover" style="border: 2px solid #d7d4d6;">
            <tr>
               <td class="hiden" style="width:22%;border:none;text-align:end;font-weight:bold;">
                  <?php echo display('Live Rate') ?>: 
               </td>
               <td class="hiden btnclr " style="width:12%; text-align-last: center;padding:5px; border:none;font-weight:bold; ">1 <?php  echo $curn_info_default;  ?>
                  = <input style="width: 80px;text-align:center;color:black;padding:5px;" type="text" class="custocurrency_rate"/>&nbsp;<label for="custocurrency"  ></label>
               </td>
               <td style="border:none;text-align:right;font-weight:bold;"><?php echo display('Tax') ?> : 
               </td>
               <td style="width:12%">
                  <input list="magic_tax" name="tx" id="product_tax" class="form-control product_tax"   onchange="this.blur();" />
                  <datalist id="magic_tax">
                     <?php                                
                        foreach($profarma_data as $tx){?>
                     <option value="<?php echo $tx['tax_id'].'-'.$tx['tax'].'%';?>">  <?php echo $tx['tax_id'].'-'.$tx['tax'].'%';  ?></option>
                     <?php } ?>
                  </datalist>
               </td>
               <td  style="width:20%;"><a href="#" class="client-add-btn btn btnclr" aria-hidden="true" style="margin-right: 295px;"  data-toggle="modal" data-target="#tax_info" ><i class="fa fa-plus"></i></a></td>
            </tr>
         </table>
         
         <table border="0" class="overall table table-bordered table-hover" style="border: 2px solid #d7d4d6;table-layout: auto;" >
            <tr>
               <td style="vertical-align:top;text-align:right;border:none;"></td>
               <td style="text-align:right;border:none;"></td>
               <td style="text-align:right;border:none;"></td>
               <td style="text-align:right;border:none;"> </td>
            </tr>
            <tr>
               <td colspan="2" style="vertical-align:top;text-align:center;border:none;"><b><?php echo "Overall Total" ?> :</b></td>
               <td colspan="1" style="border:none;padding-bottom: 40px; position: relative; right: 2px;"><span class="input-symbol-euro"><input type="text" id="Over_all_Total" name="Over_all_Total"  style="width:203px;" class="form-control" value="0.00"  readonly="readonly"  /> </span></td>
               <td colspan="4" style="width:250px;text-align:center;border:none;"><b><?php echo display('TAX DETAILS')?> :</b></td>
               <td colspan="1" style="border:none; text-align: justify;">  <span class="input-symbol-euro"> <input type="text" class="form-control" style="width:150px;"  id="tax_details" value="0.00" name="tax_details"  readonly="readonly" /></span></td>
            </tr>
            <tr>
               <td  colspan="2" style="vertical-align:top;text-align:center;border:none;"><b><?php echo display('Overall Gross Sq.Ft')?> :</b></td>
               <td colspan="1" style="border:none; position: relative; left: 100px;"><input type="text" id="total_gross" name="total_gross" class="form-control"   readonly="readonly"> </td>
               <td colspan="4" style="text-align:center;border:none;"><b><?php echo display('GRAND TOTAL') ?> :</b></td>
               <td colspan="1" style="border:none; text-align: justify;"> <span class="input-symbol-euro"><input type="text" id="gtotal"   class="form-control" style="width:150px;" name="gtotal" value="0.00"  readonly="readonly"></span></td>
            </tr>
            <tr>
               <td  colspan="2" style="vertical-align:top;text-align:center;border:none;"><b><?php echo display('Overall Net Sq.Ft') ?> :</b></td>
               <td colspan="1" style="border:none; position: relative; left: 100px;"><input type="text" id="total_net" name="total_net"  class="form-control"    readonly="readonly"  /> </td>
               <td colspan="4" style="text-align:center;border:none;"><b><?php echo display('GRAND TOTAL') ?> :<br/><?php echo display('Preferred Currency') ?></b></td>
               <td colspan="1" style="border:none;">
                  <table>
                     <tr>
                        <td class="cus" name="cus" style="width: auto; position: relative;right: 25px; top: 17px;"></td>
                        <td>&nbsp</td>
                        <td style="position: relative; right: 60px; text-align: justify;"><span class="input-symbol-euro"><input type="text" style="width: 150px !important;" class="form-control" id="customer_gtotal"  name="customer_gtotal" readonly/></span></td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr>
               <td colspan="2"  style="vertical-align:top;text-align:center;border:none;"><b><?php echo display('Overall Weight') ?> :</b></td>
               <td colspan="1" style="border:none; position: relative; left: 100px;"><input type="text" id="total_weight" name="total_weight"   class="form-control"   readonly="readonly"  /></td>
               <td colspan="4" class="amt" style="text-align:center;border:none;"><b><?php echo display('Amount Paid') ?> :</b></td>
               <td style="border:none;">
                  <table border="0">
                     <tr class="amt">
                        <td class="cus" name="cus" style="width: auto; position: relative;right: 25px; top: 2px;"></td>
                        <td>&nbsp</td>
                        <td style="position: relative;right: 21px;text-align: justify;"> <input type="text" class="form-control" readonly id="amount_paid" style="width: 150px !important;"  name="amount_paid"  required style="position: relative; top: 1px;"  /></td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr>
               <td colspan="2"  style="vertical-align:top;text-align:right;border:none;"></td>
               <td colspan="1" style="border:none;"></td>
               <td class="amt" colspan="4"  style="vertical-align:top;text-align:center;border:none;"><b><?php echo display('Balance Amount') ?> :</b></td>
               <td class="amt" style="border:none;" colspan="1">
                  <table border="0">
                     <tr class="amt">
                        <td class="cus" name="cus" style="border:none; width: auto; position: relative;right: 25px; top: 2px;"></td>
                        <td>&nbsp</td>
                        <td style="position: relative;right: 21px;text-align: justify;">
                           <input type="text" class="form-control balance_modal" readonly id="balance" name="balance"  required  style="width: 150px !important;" />                     
                        </td> 
                     </tr>
                  </table>
               </td>
            </tr>
            <tr>
               <td style="border:none;">
               </td>
            </tr>
            <input type="hidden" id="final_gtotal"  name="final_gtotal" />
            <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/></td>
            <!-- -->
            <tr style="border-right:none;border-left:none;border-bottom:none;border-top:none">
               <td colspan="21" style="text-align: end;">
                  <input type="button" value="Make Payment" style="color:white;" class="client-add-btn btn btnclr btn-large" id="paypls">
               </td>
            </tr>
            </tfoot>
         </table>
         
      </div><!--end of table-responsive-->
      <div class="form-group row">
         <label for="billing_address" class="col-sm-2 col-form-label"><?php echo display('Account Details/Additional Information')?></label>
         <div class="col-sm-8">
            <textarea rows="4" cols="50" id="details" style="border: 2px solid #d7d4d6;"  name="ac_details" class=" form-control" placeholder='Account Details/Additional Information' ><?php   if(!empty($update_invoice_set[0]->account)){echo $update_invoice_set[0]->account;} ?></textarea>
         </div>
      </div>
      <div class="form-group row">
         <label for="remark" class="col-sm-2 col-form-label"><?php echo display('Remarks/Conditions')?></label>
         <div class="col-sm-8">
            <textarea rows="4" cols="50" id="remarks" style="border: 2px solid #d7d4d6;"  name="remark" class=" form-control" placeholder='Remarks/Conditions' ><?php   if(!empty($update_invoice_set[0]->remarks)){ echo $update_invoice_set[0]->remarks;} ?></textarea>
         </div>
      </div>
      <div class="form-group row">
         <div class="col-sm-12 ">
            <table>
               <tr>
                  <td>
                     <input type="hidden" name="uid" value="<?php echo $_SESSION['user_id']; ?>">
                     <input type="submit" id="add_trucking" class="btnclr btn btn-large"   name="add-trucking" value=<?php echo display('Save') ?> />
                  </td>
                  <td>&nbsp;</td>
                  <td class="amt">    <a    id="final_submit" class='final_submit btn btnclr'><?php echo display('Submit') ?></a></td>
                  <td class="amt">&nbsp;</td>
                  <td class="amt"><a id="download"   class='btn btnclr'><?php echo display('Download')?></a>
                  </td>
                  <td  class="amt" style="width: 20px;">&nbsp;</td>
                  <td class="amt"><a id="print"   class='btn btnclr'><?php echo display('Print')?></a>
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
         <div class="table-responsive" >
            <table class='table' style="display:none;">
               <tr>
                  <th colspan='7'>
                  </th>
               </tr>
            </table>
         </div>
         <input type="hidden" id="currency"/>
   </form>
   </div>
</section>
<input type="hidden" id="hdn"/>
<input type="hidden" id="gtotal_dup"/>
<div class="modal fade" id="myModal1" role="dialog" >
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content" style="margin-top: 190px;">
         <div class="modal-header" style="color:white;background-color:#38469f;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"> <?php echo display ('Sales - Profarma Invoice') ?></h4>
         </div>
         <div class="modal-body" id="bodyModal1" style="text-align:center;font-weight:bold;">
         </div>
         <div class="modal-footer">
         </div>
      </div>
   </div>
</div>
<!------ add new customer -->

<div class="modal fade" id="product_model_info" role="dialog" style="margin-right: 900px;width:2000px;">
   <div class="modal-dialog" style="float:left;">
      <!-- Modal content-->
      <div class="modal-content" style="width: fit-content;margin-top: 100px;margin-left:300px;text-align:center;">
         <div class="modal-header btnclr" >
           
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


<!------ add new product-->

   <div class="modal fade" id="product_info" role="dialog">
      <div class="modal-dialog">
         <div class="modal-content" style="width: 150%; height: 140%;text-align:center;">
            <div class="modal-header btnclr" >
               <a href="#" class="close" data-dismiss="modal">&times;</a>
               <h3 class="modal-title"><?php echo display('Add New Product')?></h3>
            </div>
            <div class="modal-body">
               <div id="customeMessage" class="alert hide"></div>
					<form action="ada">
						<div class="panel-body">
							<input type ="hidden" name="csrf_test_name" id="" value="<?php echo $this->security->get_csrf_hash();?>">
							<div class="col-sm-6">
								<div class="form-group row">
									<label for="product_name" class="col-sm-4 col-form-label"><?php echo display('product_name') ?> <i class="text-danger">*</i></label>
									<div class="col-sm-8">
									<input class="form-control" name="product_name" type="text" id="product_name" placeholder="<?php echo display('product_name') ?>" required tabindex="1" >
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group row">
								<label for="barcode_or_qrcode" class="col-sm-4 col-form-label"><?php echo display('barcode_or_qrcode') ?> <i class="text-danger"></i></label>
								<div class="col-sm-8">
								<input type="text" tabindex="3" class="form-control"  style="width: 100%;" name="barcode" value=""  placeholder="Barcode/QR-code"   />
								</div>
								</div>
							</div>
								<div class="col-sm-6">
								<div class="form-group row">
								<label for="quantity" class="col-sm-4 col-form-label"><?php echo display('Quantity') ?> <i class="text-danger">*</i></label>
								<div class="col-sm-8">
								<input class="form-control" name="quantity" type="number" id="quantity" placeholder="Enter Product Quantity only" required tabindex="1" >
								</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group row">
								<label for="product_model" class="col-sm-4 col-form-label"><?php echo display('model') ?> <i class="text-danger">*</i></label>
								<div class="col-sm-8">
								<input type="text" tabindex="" class="form-control" id="product_model" name="model" required placeholder="<?php echo display('model') ?>" />
								</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group row">
								<label for="category_id" class="col-sm-4 col-form-label"><?php echo display('category') ?></label>
								<div class="col-sm-7">
								<select class="form-control" id="category_id" style="width: 250px;"  name="category_id" tabindex="3">
								<option value="">Select the Category</option>
								<?php if ($category_list) {
								   foreach($category_list as $cn){
								   ?>
								<option value="<?php   echo $cn['category_name']; ?>"><?php   echo $cn['category_name']; ?></option>
								<?php }} ?>
								</select>
								</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group row">
								<label for="sell_price" class="col-sm-4 col-form-label"><?php echo display('sell_price') ?> <i class="text-danger"></i> </label>
								<div class="col-sm-8">
								<input class="form-control" id="sell_price" name="price" type="text"  placeholder="0.00" tabindex="5" min="0">
								</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group row">
								<label for="" class="col-sm-4 col-form-label"><?php echo display('Supplier') ?> <i class="text-danger">*</i> </label>
								<div class="col-sm-7">
								<select name="supplier_id" id="supplier_id" required="" class="form-control " style="width:118%;"  tabindex="1">
								<option value="">Select Supplier</option>
								<?php  foreach ($all_supplier as $sup_data){  ?>
								<option value="<?php echo $sup_data['supplier_id'];  ?>"><?php echo $sup_data['supplier_name'];  ?></option>
								<?php }  ?>
								</select>
								</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group row">
								<label for="unit" class="col-sm-4 col-form-label"><?php echo display('unit') ?></label>
								<div class="col-sm-7">
								<select class="form-control" id="unit" name="unit"  style="width:250px;" tabindex="-1" aria-hidden="true">
								<option value="">Select the Unit</option>
								<?php if ($unit_list) {
								   foreach($unit_list as $sup_data){
								   ?>
								<option value="<?php echo $sup_data['unit_name'];  ?>"><?php echo $sup_data['unit_name'];  ?></option>
								<?php }} ?>
								</select>
								</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="col-sm-6">
										<div class="form-group row">
										<label for="account_category_name" class="col-sm-4 col-form-label"><?php echo display('Account Category Name')?></label>
										<div class="col-sm-8">
										<input class="form-control" name ="account_category_name" id="account_category_name" type="text" placeholder=" Account Category Name"   tabindex="1" >
										</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group row">
										<label for="account_sub_category"  class="col-sm-4 col-form-label"><?php echo display('Account Sub Category')?></label>
										<div class="col-sm-8">
										<input class="form-control" name ="account_sub_category" id="account_sub_category" type="text" placeholder=" Account Sub Category"  tabindex="1" >
										</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="col-sm-6">
										<div class="form-group row">
										<label for="account_category" class="col-sm-4 col-form-label"><?php echo display('Account Category')?></label>
										<div class="col-sm-8">
										<select id="ddl"  name="account_category" class="form-control" onchange="configureDropDownLists(this,document.getElementById('ddl2'))">
										<option value=""><?php echo display('Select the Account Category')?></option>
										<option value="1000 ASSETS">1000 ASSETS</option>
										<option value="1200 RECEIVABLES">1200 RECEIVABLES</option>
										<option value="1300 INVENTORIES">1300 INVENTORIES</option>
										<option value="1400 PREPAID EXPENSES & OTHER CURRENT ASSETS">1400 PREPAID EXPENSES & OTHER CURRENT ASSETS</option>
										<option value="1500 PROPERTY PLANT & EQUIPMENT">1500 PROPERTY PLANT & EQUIPMENT</option>
										<option value="1600 ACCUMULATED DEPRECIATION & AMORTIZATION">1600 ACCUMULATED DEPRECIATION & AMORTIZATION</option>
										<option value="1700 NON – CURRENT RECEIVABLES">1700 NON – CURRENT RECEIVABLES</option>
										<option value="1800 INTERCOMPANY RECEIVABLES & 1900 OTHER NON-CURRENT ASSETS">1800 INTERCOMPANY RECEIVABLES & 1900 OTHER NON-CURRENT ASSETS</option>
										<option value="2000 LIABILITIES & 2100 PAYABLES">2000 LIABILITIES & 2100 PAYABLES</option>
										<option value="2200 ACCRUED COMPENSATION & RELATED ITEMS">2200 ACCRUED COMPENSATION & RELATED ITEMS</option>
										<option value="2300 OTHER ACCRUED EXPENSES">2300 OTHER ACCRUED EXPENSES</option>
										<option value="2500 ACCRUED TAXES">2500 ACCRUED TAXES</option>
										<option value="2600 DEFERRED TAXES">2600 DEFERRED TAXES</option>
										<option value="2700 LONG-TERM DEBT">2700 LONG-TERM DEBT</option>
										<option value="2800 INTERCOMPANY PAYABLES & 2900 OTHER NON CURRENT LIABILITIES & 3000 OWNERS EQUITIES">2800 INTERCOMPANY PAYABLES & 2900 OTHER NON CURRENT LIABILITIES & 3000 OWNERS EQUITIES</option>
										<option value="4000 REVENUE">4000 REVENUE</option>
										<option value="5000 COST OF GOODS SOLD">5000 COST OF GOODS SOLD</option>
										<option value="6000 – 7000 OPERATING EXPENSES">6000 – 7000 OPERATING EXPENSES</option>
										</select>
										</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group row">
										<label for="product_sub_category" class="col-sm-4 col-form-label"><?php echo display('Product Sub Category')?><i class="text-danger">*</i></label>
										<div class="col-sm-8">
										<select   name="product_sub_category" id="product_sub_category" class=" form-control"  required placeholder="product_sub_category" style="width:100%;">
										<option value=""><?php echo display('Select the Product Sub Category') ?></option>
										<option value="Granite"><?php echo display('Granite') ?></option>
										<option value="Marble"><?php echo display('Marble')?></option>
										<option value="Quartz"><?php echo display('Quartz') ?></option>
										<option value="Quartzite"><?php echo display('Quartzite') ?></option>
										<option value="Lime Stone"><?php echo display('Lime Stone') ?></option>
										<option value="Dolomite"><?php echo display('Dolomite') ?></option>
										<option value="Sand Stone"><?php echo display('Sand Stone') ?></option>
										<option value="Soap Stone"><?php echo display('Soap Stone') ?></option>
										</select>
										</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group row">
								<label for="sub_category"  class="col-sm-4 col-form-label"><?php echo display('Account Sub Category') ?></label>
								<div class="col-sm-8">
								<select class="form-control" name="sub_category" id="ddl2">
								<option value="Select Sub Category"><?php echo display('Select Sub Category') ?></option>
								</select>
								</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group row">
								<label for="image" class="col-sm-4 col-form-label"><?php echo display('Product Image ') ?></label>
								<div class="col-sm-8">
								<input type="file" name="product_image" class="form-control" id="product_image"  tabindex="4">
								</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="col-sm-6">
										<div class="form-group row">
										<label for="cost_per_sqft" class="col-sm-4 col-form-label"><?php echo display('Cost perSqFt') ?> </label>
										<div class="col-sm-8">
										<input type="text" name="costpersqft" class="form-control" id="cost_per_sqft" tabindex="4" placeholder="cost persqft" />
										</div>
										</div>
										<div class="form-group row">
										<label for="cost_per_slab" class="col-sm-4 col-form-label"><?php echo display('Cost per Slab') ?> <i class="text-danger">*</i></label>
										<div class="col-sm-8">
										<input type="text" name="costperslab" class="form-control" id="cost_per_slab" tabindex="4"   required=""    placeholder="Cost per Slab" />
										</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group row">
										<label for="sales_price" class="col-sm-4 col-form-label"><?php echo display('Sales') ?>
										Price per Sq.Ft </label>
										<div class="col-sm-8">
										<input type="text" name="salespricepersqft" class="form-control" id="sales_price_per_sqft" tabindex="4"  placeholder=" Sales Price perSq.Ft" />
										</div>
										</div>
										<div class="form-group row">
										<label for="sales_slab_price" class="col-sm-4 col-form-label"><?php echo display('Sales Slab Price') ?> </label>
										<div class="col-sm-8">
										<input type="text" name="salesslabprice" class="form-control" id="sales_slab_price" tabindex="4" placeholder=" Sales Slab Price"  />
										</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="col-sm-6">
										<div class="form-group row">
										<label for="tax_id" class="col-sm-4 col-form-label"><?php echo display('Tax')?> </label>
										<div class="col-sm-8">
										<input type="text" name="tax" class="form-control" id="tax_id" tabindex="4" placeholder=" Tax" />
										</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group row">
										<label for="country" class="col-sm-4 col-form-label"><?php echo display('Country') ?></label>
										<div class="col-sm-8">
										<select class="selectpicker countpicker form-control"  data-live-search="true" data-default="US-United States"
										   name="country" id="country" ></select>  
										</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group row">
										<label for="serial_no" class="col-sm-4 col-form-label"><?php echo display('Serial No') ?></label>
										<div class="col-sm-8">
										<input type="text" tabindex="" class="form-control " id="serial_no" name="serial_no" placeholder="111,abc,XYz"   />
										</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
										<center><label for="description" class="col-form-label"><?php echo display('product_details') ?></label></center>
										<textarea class="form-control" name="description" id="description" rows="2" placeholder="<?php echo display('product_details') ?>" tabindex="2"></textarea>
										</div>
									</div><br>
									<div class="form-group row">
										<div class="col-sm-6"></div>
										<div class="col-sm-6" style="text-align: -webkit-right;">
										<a href="#" class="btn btnclr " style="color:white;" data-dismiss="modal"><?php echo display('Close') ?></a>
										<input type="submit" id="add-product" style="color:white;" class="btn btnclr" name="insert_product" value="<?php echo display('save') ?>" tabindex="10"/>
										</div>
									</div>
								</div>
							</div>
						</div><!--end of <div class="panel-body"-->
					</form>
				</div><!-- /.modal-body -->
			</div><!-- /.modal-content -->
		</div><!-- /.modal -dialog -->
	</div>
        
	<div class="modal fade" id="payment_history_modal" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content" style="width: 1000px;min-width: max-content;margin-top: 190px;text-align:center;">
				<div class="modal-header btnclr"  >
				<button type="button" id="history_close" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><?php echo display('PAYMENT HISTORY') ?></h4>
				</div>
				<div class="modal-body1">
				<div id="salle_list"></div>
				</div>
				<div class="modal-footer">
				</div>
			</div>
		</div>
	</div>

<?php 
$modaldata['bootstrap_model'] = array('customer', 'tax_info', 'payment_model', 'bank_info');
$this->load->view('include/bootstrap_model', $modaldata); 
?>

<script>
   $('#customer_id').on('change', function (e) {
   
   var data = {
       value: $('#customer_id').val()
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
         console.log(result[0]['currency_type']);
          if(result[0]['tax_status']==1){
       $('#product_tax').val(result[0]['tax_percent']);
   }else{
      $('#product_tax').val(0);
   }
      $(".cus").html(result[0]['currency_type']);
       $("label[for='custocurrency']").html(result[0]['currency_type']);
      console.log('https://open.er-api.com/v6/latest/<?php echo $curn_info_default; ?>');
      $.getJSON('https://open.er-api.com/v6/latest/<?php echo $curn_info_default; ?>', 
   function(data) {
   var custo_currency=result[0]['currency_type'];
   var x=data['rates'][custo_currency];
   //  $('.cus').html(x);
   var Rate =parseFloat(x).toFixed(3);
   console.log(Rate);
   $('.hiden').show();
   Rate = isNaN(Rate) ? 0 : Rate;
   $(".custocurrency_rate").val(Rate);
   });
     
       }
   });
   
   });
    $(document).on('change', '.product_name', function(){

    var id= $(this).attr('id');
     var id_num = id.substring(id.indexOf('_') + 1);
     // debugger;
     $('#tableid_'+id_num).val(id_num);
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
               console.log(result);
               if(result.csrfName){
                  csrfName = result.csrfName;
                  csrfHash = result.csrfHash;
               }
   
             $("#SchoolHiddenId_"+ id_num).val(result[0]['product_id']);
               console.log(result);
           }
       });

    });

   $(document).on('keyup','.weight',function(){
      var $row = $(this).closest('tr');
      var tableId = $row.closest('table').attr('id');
      updateTableTotals(tableId);
      updateOverallTotals();
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
   

   // Data Insert & Validation
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
            var formData = new FormData($("#insert_trucking")[0]);
            formData.append(csrfName, csrfHash);

            $(".hold-product").each(function() {
               var checkboxValue = $(this).is(':checked') ? '1' : '0';
               formData.append($(this).attr('name'), checkboxValue);
            });

             $.ajax({
              type: "POST",
              url: "<?php echo base_url(); ?>Caccounts/tax_entry",
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
                     // $('#download').show();
                     // $('#print').show();

                     $('.displaymessage').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
                  } else {
                     $('.displaymessage').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
                  }

              }
            });
         return false;
        }
    });


   // Tax 
   $('.product_tax').on('change', function (e) {
      e.preventDefault();
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
      var value=(num+additional_cost)*custo_amt;
      var custo_final = isNaN(parseFloat(value)) ? 0 : parseFloat(value);
      var balance_amount= (num+additional_cost)- paid_amount;
      $('#tax_details').val(answer.toFixed(2) +" ( "+tax+" )");
      $('#customer_gtotal').val(custo_final.toFixed(2));  
      $('#balance').val(balance_amount.toFixed(2));
      updateOverallTotals();
   });
   
   


   $(document).ready(function(){
      $('.removebundle').hide();
      $('.amt').hide();
      $('.bal').hide();
   });

   $(document).on('click', '.removebundle', function(){
      var remove_id=$(this).closest('table').attr('id');
      $('#'+remove_id).remove();
      updateOverallTotals(true);
   });

   $('.final_submit').on('click', function () {
     window.location.href = "<?php echo base_url(); ?>Cinvoice/manage_profarma_invoice?id=<?php echo $_GET['id']; ?>";
   });
   
   
   $('#tax_dropdown').on('change', function() {
      if ( this.value == '2')
       $("#tax").show();     
      else
       $("#tax").hide();
   }).trigger("change");
   
   $(document).ready(function() {
      $('#paypls').on('click', function(e) {
         e.preventDefault();
          Balance = $('.balance_modal').val();
         $('#amount_to_pay').val(Balance);
         $('#payment_modal').modal('show');
      });
   });
   

</script>
