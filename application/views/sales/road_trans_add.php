<!-- Product Purchase js -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/product_purchase.js.php" ></script>
<!-- Supplier Js -->
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/supplier.js.php" ></script>
<script src="<?php echo base_url()?>my-assets/js/admin_js/purchase.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>my-assets/js/countrypicker.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>my-assets/js/admin_js/trucking.js" type="text/javascript"></script>
</script>
<!-- Add New Purchase Start -->
<div class="content-wrapper">
   <section class="content-header">
      <div class="header-icon">
         <figure class="one"
         <img src="<?php echo base_url()  ?>asset/images/trucking.png"  class="headshotphoto" style="height:50px;" />
      </div>
      <div class="header-title">
         <div class="logo-holder logo-9">
            <h1><?php echo display('Create Road Transport') ?></h1>
         </div>
         <small></small>
         <ol class="breadcrumb" style="border: 3px solid #d7d4d6;">
            <li><a href="<?php echo base_url(); ?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
            <li><a href="<?php echo base_url('sales/roadTransport?id='.$_GET['id']); ?>"><?php echo display('Sale') ?></a></li>
            <li class="active" style="color:orange;"><?php echo display('Create Road Transport') ?></li>
            <div class="load-wrapp">
               <div class="load-10">
                  <div class="bar"></div>
               </div>
            </div>
         </ol>
      </div>
   </section>
   <style>
      tfoot tr{
      height: 35px;
      }
      input {
      border: none;
      }
      .ui-selectmenu-text{
      display:none;
      }
      .ui-front{
      display:none;
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
      width: 155px;
      }
      }
      .btnclr{
      background-color:<?php echo $setting_detail[0]['button_color']; ?>;
      color: white;
      }
   </style>
   <section class="content">
      
      <?php $payment_id=rand(); /* ?>
      <form id="histroy" style="display:none;" method="post" >
         <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
         <input type="hidden"  value="<?php echo $payment_id; ?>" name="makepaymentId" class="makepaymentId" id="makepaymentId"/>
         <input type="submit" id="payment_history" name="payment_history" class="btn" style="float:right;color:white;background-color: #38469f;" value="Payment History" style="float:right;margin-bottom:30px;"/>
      </form> <?php */ ?>
      <!-- Purchase report -->
      <div class="row">
         <div class="col-sm-12">
            <div class="panel panel-bd lobidrag"     style="border: 3px solid #d7d4d6;"    >
               <div class="panel-heading">
                  <div class="panel-title">
                     <div id="block_container">
                        <div id="bloc1" style="float:left;">
                           <h4><?php //echo "Create New Trucking Invoice" ?></h4>
                        </div>
                        <div id="bloc2" style="float:right;">
                           <a   href="<?php echo base_url('sales/roadTransport?id='.$_GET['id']) ?>" class="btnclr btn  m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo "Manage Road Transport" ?> </a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="panel-body">
               <div class="displaymessage"></div>
               <br>
                  <form id="insert_trucking" name="insert_trucking" method="post">
                  
                  <input type="hidden" name="makepaymentId" class="payment_id" id="makepaymentId" value="<?php echo $payment_id; ?>"/>
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group row">
                              <label for="invoice_no" class="col-sm-4 col-form-label"><?php echo display('invoice_no') ?>
                              <i class="text-danger"></i>
                              </label>
                              <div class="col-sm-8">
                                 <input type="text" tabindex="3" class="form-control" name="invoice_no" style="border:2px solid #d7d4d6;"   value="<?php if(!empty($voucher_no[0]['voucher'])){
                                    $curYear = date('Y'); 
                                    $month = date('m');
                                    $voucher_no[0]['voucher']=str_replace("T","",$voucher_no[0]['voucher']);
                                    $x=explode("-",$voucher_no[0]['voucher']);
                                    
                                    
                                    $vn=$x[1]+1;
                                    
                                    echo $voucher_n = 'T'. $curYear.$month.'-'.$vn;
                                    }else{
                                        $curYear = date('Y'); 
                                    $month = date('m');
                                    echo $voucher_n = 'T'. $curYear.$month.'-'.'1';
                                    } ?>" readonly />
                              </div>
                              <input type="hidden" tabindex="3" class="form-control" name="attachment_id" id="attachment_id" value="<?php if(!empty($voucher_no[0]['voucher'])){
                                 $curYear = date('Y'); 
                                 $month = date('m');
                                 $voucher_no[0]['voucher']=str_replace("T","",$voucher_no[0]['voucher']);
                                 $x=explode("-",$voucher_no[0]['voucher']);
                                 
                                 
                                 $vn=$x[1]+1;
                                 
                                 echo $voucher_n = 'T'. $curYear.$month.'-'.$vn;
                                 }else{
                                     $curYear = date('Y'); 
                                 $month = date('m');
                                 echo $voucher_n = 'T'. $curYear.$month.'-'.'1';
                                 } ?>" />
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group row">
                              <label for="date" class="col-sm-4 col-form-label"><?php echo display('Invoice Date') ?>
                              <i class="text-danger">*</i>
                              </label>
                              <div class="col-sm-8">
                                 <?php $date = date('Y-m-d'); ?>
                                 <input type="date" required tabindex="2" class="form-control "  style="border:2px solid #d7d4d6;"    name="invoice_date" value="<?php echo $date; ?>" id="date"  />
                              </div>
                           </div>
                        </div>
                     </div>
                     <input type="hidden" id="invoice_hdn"/> <input type="hidden" id="invoice_hdn1"/>
                     <div class="row">
                        
                        <div class="col-sm-6">
                           <div class="form-group row">
                              <label for="supplier_sss" class="col-sm-4 col-form-label"><?php echo display('Customer Name') ?>
                              <i class="text-danger">*</i>
                              </label>
                              <div class="col-sm-8">
                                 <select name="bill_to" id="bill_to" class="form-control" onchange="" required style="border:2px solid #d7d4d6;"   >
                                    <option value=""><?php echo display('Select Customer ') ?></option>
                                    <?php foreach ($customer_list as $customer) {?>
                                    <option value="<?php echo html_escape($customer->customer_id);?>"><?php echo html_escape($customer->customer_name);?></option>
                                    <?php }?>
                                 </select>
                               </div>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group row">
                              <label for="supplier_sss" class="col-sm-4 col-form-label"><?php echo display('Shipment company') ?>
                              <i class="text-danger">*</i>
                              </label>
                              <div class="col-sm-7">
                                 <select name="supplier_id" id="supplier_id" class="form-control " required=""  style="border:2px solid #d7d4d6;"  tabindex="1"> 
                                        <?php 
                                        foreach($all_supplier as $supplier_data) { 
                                            ?>
                                        <option <?php echo $select_supp; ?> value="<?php echo $supplier_data['supplier_id']; ?>"><?php echo $supplier_data['supplier_name']; ?></option>
                                        <?php } ?>
                                    </select>
                              </div>
                              <?php //if($this->permission1->method('add_supplier','create')->access()){ ?>
                              <div class="col-sm-1 mobilewidth_view">
                                 <!--    <a class="btn btn-success" title="Add New Supplier" href="<?php echo base_url('Csupplier'); ?>"><i class="fa fa-user"></i></a> -->
                                 <a href="#" class="client-add-btn btn  btnclr "   aria-hidden="true" data-toggle="modal" data-target="#add_vendor"><i class="fa fa-user"></i></a>
                              </div>
                              <?php// }?>
                           </div>
                        </div>
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                     </div>
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group row">
                              <label for="supplier_sss" class="col-sm-4 col-form-label"><?php echo display('Delivery to') ?>
                              <i class="text-danger">*</i>
                              </label>
                              <div class="col-sm-8">
                                 <select name="delivery_to" id="delivery_to" class="form-control" onchange="" required style="border:2px solid #d7d4d6;"  >
                                    <option value=""><?php echo display('Select Customer ') ?></option>
                                    <?php foreach ($customer_list as $customer) {?>
                                    <option value="<?php echo html_escape($customer->customer_name);?>"><?php echo html_escape($customer->customer_name);?></option>
                                    <?php }?>
                                 </select>
                               </div>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group row">
                              <label for="supplier_sss" class="col-sm-4 col-form-label"> <?php echo display('Container / Goods Pick up date') ?>
                              <i class="text-danger">*</i>
                              </label>
                              <div class="col-sm-8">
                                 <?php $date = date('Y-m-d'); ?>
                                 <input type="date" required tabindex="2" class="form-control " name="container_pick_up_date" style="border:2px solid #d7d4d6;"   value="<?php echo $date; ?>" id="date"  />
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group row">
                              <label for="supplier_sss" class="col-sm-4 col-form-label"><?php echo display('Delivery date') ?>
                              <i class="text-danger">*</i>
                              </label>
                              <div class="col-sm-8">
                                 <?php $date = date('Y-m-d'); ?>
                                 <input type="date" required tabindex="2" class="form-control " name="delivery_date" style="border:2px solid #d7d4d6;"   value="<?php echo $date; ?>" id="date"  />
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group row">
                              <label for="supplier_sss" class="col-sm-4 col-form-label"> <?php echo display('Delivery Time') ?>
                              <i class="text-danger">*</i>
                              </label>
                              <label for="supplier_sss" class="col-sm-1 col-form-label"> <?php echo display('From') ?>
                              </label>
                              <div class="col-sm-3">
                                 <input type="time"  style="border:2px solid #d7d4d6;"   required tabindex="2" class="form-control " name="delivery_time_from" value="" id="time"  />
                              </div>
                              <label for="supplier_sss" class="col-sm-1 col-form-label"> <?php echo display('TO') ?>
                              </label>
                              <div class="col-sm-3">
                                 <input type="time"  style="border:2px solid #d7d4d6;"    required tabindex="2" class="form-control " name="delivery_time_to" value="" id="time"  />
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group row">
                              <label for="supplier_sss" class="col-sm-4 col-form-label"> <?php echo display('Attachments ') ?>
                              </label>
                              <div class="col-sm-6">
                               <p>
                                 <label for="attachment">
                                 <a class="btnclr btn   text-light" role="button" aria-disabled="false"><i class="fa fa-upload"></i>&nbsp; Choose Files</a>
                                 </label>
                                 <input type="file" name="files[]" class="upload" id="attachment" style="visibility: hidden; position: absolute;" multiple accept=".pdf, .docx, .txt, .png, .jpeg, .jpg" />
                                
                              <p id="files-area">
                                  <label for="adress" class="col-form-label">Allowed File types : <?php echo IMAGE_ALLOWED_TYPES; ?></label>
                              </p>
                                 <span id="filesList">
                                 <span id="files-names"></span>
                                 </span>
                              </p>
                              
									  </div>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group row">
                              <label for="supplier_sss" class="col-sm-4 col-form-label"> <?php echo display('Truck No') ?>
                              <i class="text-danger">*</i>
                              </label>
                              <div class="col-sm-8">
                                 <input type="text" class="form-control" required tabindex="2" class="form-control "   style="border:2px solid #d7d4d6;"    name="truck_no" id="truck_no" value=""/>
                              </div>
                           </div>
                        </div>
                     </div>
                     <br>
                     <div class="table-responsive">
                        <table class="table table-bordered table-hover"  style="border:2px solid #d7d4d6;"  >
                           <tr>
                              <td class="hiden" style="width:50%;border:none;text-align:end;font-weight:bold;">
                                 <?php echo display('live rate') ?> : 
                              </td>
                              <td class="hiden btnclr" style="width:180px;padding:5px; border:none;font-weight:bold;color:white;">1 <?php  echo $curn_info_default;  ?>
                                 = <input style="width:70px;text-align:center;color:black;padding:5px;" type="text" id="custocurrency_rate"/>&nbsp;<label for="custocurrency"   ></label>
                              </td>
                              <td style="border:none;text-align:right;font-weight:bold;"><?php echo display('Tax') ?> : 
                              </td>
                              <td style="width:12%">
                                 <select name="tx" id="product_tax" class="form-control" >
                                        
                                    <?php foreach($trucking_data as $tx){
                                            //$selecttx = strtoupper($match[1]) == $tx['tax_id'].'-'.$tx['tax'].'%' ? 'selected' : ''; ?>
                                            <option <?php //echo $selecttx; ?> value="<?php echo $tx['tax_id'].'-'.$tx['tax'].'%';?>">  <?php echo $tx['tax_id'].'-'.$tx['tax'].'%';  ?></option>
                                        <?php } ?> 
                                    </select>
                                
                              </td>
                              <td  style="width:20%;"><a href="#" class="btnclr client-add-btn btn " aria-hidden="true" style="margin-right: 295px;"  data-toggle="modal" data-target="#tax_info" ><i class="fa fa-plus"></i></a></td>
                           </tr>
                        </table>
                        <table class="table table-bordered table-hover" id="truckingTable_1" style="border:2px solid #d7d4d6;"  >
                           <thead>
                              <tr>
                                 <th class="text-center" width="15%"><?php echo display('Date') ?><i class="text-danger">*</i></th>
                                 <th class="text-center"><?php echo display('Quantity') ?><i class="text-danger">*</i></th>
                                 <th class="text-center"><?php echo display('Description') ?><i class="text-danger">*</i></th>
                                 <th class="text-center" width="20%"><?php echo display('Rate') ?>($)<i class="text-danger">*</i></th>
                                 <th class="text-center"><?php echo display('Pro No / Reference') ?><i class="text-danger">*</i></th>
                                 <th class="text-center"><?php echo display('total') ?>($)</th>
                                 <th class="text-center"><?php echo display('action') ?></th>
                              </tr>
                           </thead>
                           <tbody id="addPurchaseItem_1">
                              <tr>
                                 <td class="span3 supplier"> 
                                    <?php $date = date('Y-m-d'); ?>
                                    <input type="date" required tabindex="2" class="form-control " name="trucking_date[]" value="<?php echo $date; ?>" id="date"/>
                                 </td>
                                 <td class="wt">
                                    <input type="text" name="product_quantity[]" id="cartoon_1" required="" min="0" class="quantity form-control text-right store_cal_1"  placeholder="0.00" value=""  tabindex="6"/>
                                 </td>
                                 <td class="text-right">
                                    <input type="text" name="description[]" id="description" required="" class="form-control text-right" value=""  tabindex="6"/>
                                 </td>
                                 <td>
                                   <input type="text" name="product_rate[]" required="" style="width:100%;" class="productrate form-control mobile_inputview"  id="product_rate_1"  placeholder="0.00" value="" min="0" tabindex="7"/>
                                 </td>
                                 <td class="text-right">
                                    <select name="pro_no[]" id="invoice_no_1" class="form-control" tabindex="1" required="">
                                       <option value=""><?php echo display('select_one') ?></option>
                                       <?php foreach($invoice as $inv){ ?>
                                       <option value="<?php echo $inv['commercial_invoice_number'] ; ?>"><?php echo $inv['commercial_invoice_number'] ; ?></option>
                                       <?php } ?>
                                    </select>
                                 </td>
                                 <td>
                                    <input class="total_price form-control mobile_price" type="text"  name="total_price[]" id="total_price_1" value="0.00" readonly="readonly" />
                                 </td>
                                 <td style="text-align:center;">
                                    <button  class="rdelete btn btn-danger text-right red"  type="button" value="<?php echo display('delete')?>"  tabindex="8"><i class="fa fa-trash"></i></button>
                                 </td>
                              </tr>
                           </tbody>
                           <tfoot>
                              <tr>
                                 <td style="padding-top: 20px;text-align:right;" colspan="5" ><b><?php echo display('total') ?>:</b></td>
                                 <td style="text-align:left;">
                                    <span class="input-symbol-euro"><input type="text" id="Total" class="form-control text-right mobile_price"  name="total" value="0.00" readonly="readonly" /></span>
                                 </td>
                              </tr>
                              <tr>
                                 <td style="text-align:right;" colspan="5"><b><?php echo display('Tax Details') ?> :</b></td>
                                 <td style="text-align:left;">
                                    <table border="0">
                                       <tr>
                                          <td style="padding-bottom:30px;"><span class="input-symbol-euro"> <input type="text" id="tax_details"  class="form-control mobile_price" class="text-right" value="0.00" name="tax_details"  readonly="readonly" /></span></td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                              <tr>
                                 <td style="text-align:right;" colspan="5"><b><?php echo display('Grand Total') ?>:</b></td>
                                 <td>
                                    <table border="0">
                                       <tr>
                                          <td style="padding-bottom:30px;">  <span class="input-symbol-euro"><input type="text" id="gtotal" class="form-control mobile_price" name="gtotal" onchange=""value="0.00" readonly="readonly" /></span></td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                              <tr>
                                 <td style="text-align:right;"  colspan="5"><b><?php echo display('Grand Total') ?>:</b><br/><b><?php echo display('Preferred Currency') ?></b></td>
                                 <td>
                                    <table border="0">
                              
                                       <tr>
                                          <td class="cus" name="cus"></td> &nbsp; 
                                          <td><input  type="text" class="form-control" readonly id="customer_gtotal" value="0.00"  name="customer_gtotal"  required  /></td>
                                       </tr>

                                    </table>
                                 </td>
                                 <input type="hidden" id="final_gtotal"  name="final_gtotal" />
                                 <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/></td>
                              </tr>
                              <tr id="amt">
                                 <td style="text-align:right;"  colspan="5"><b><?php echo display('Amount Paid') ?>:</b></td>
                                 <td>
                                    <table border="0">
                                       <tr>
                                          <td class="cus" name="cus"></td> &nbsp;&nbsp;&nbsp; 
                                          <td ><input  type="text"  class="form-control" readonly id="amount_paid"  name="amount_paid" value="0.00"  required /></td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                              <tr id="bal">
                                 <td style="text-align:right;"  colspan="5"><b><?php echo display('Balance Amount ') ?>:</b></td>
                                 <td>
                                    <table border="0">
                                       <tr>
                                          <td class="cus" name="cus"></td> &nbsp;&nbsp;&nbsp;
                                          <td><input class="balance_modal form-control" type="text"  readonly id="balance"  name="balance" value="0.00"/></td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                              <tr style="border-right:none;border-left:none;border-bottom:none;border-top:none">
                                  <td colspan="6" style="text-align: end;">
                                    <button type="button" value = "<?php  echo display('Make Payment') ?>" class="btnclr btn btn-large" id="paypls" >Make Payment</button>
                                  </td> 

                        
                              </tr>
                           </tfoot>
                           </tfoot>
                        </table>
                     </div>
                
                     <!-- </div> -->
                     <div class="form-group row">
                        <label for="remarks" class="col-sm-2 col-form-label"><?php echo display('Remarks') ?></label>
                        <div class="col-sm-8">
                        <textarea rows="4" cols="30" name="remarks" class="form-control" style="border:2px solid #d7d4d6; text-align: start;" id="remarks">
                           <?php if (!empty($remarks[0]->remarks)) {
                              echo $remarks[0]->remarks;
                           } ?>
                        </textarea>

                     
                        </div>
                     </div>
                     <div class="form-group row">
                     <div class="form-group row">
                        <input type="hidden" name="admin_company_id" id="admin_company_id" value="<?php echo $_GET['id']; ?>">
                        <label for="example-text-input" class="col-sm-0 col-form-label"></label>
                        <div class="col-sm-12 text-center">
                            <input type="submit" id="add_oceantrack" class="btnclr btn btn-large" name="add_oceantrack" value="Submit" tabindex="7" />
                            <a href="<?php echo base_url('sales/roadTransport?id='.$_GET['id']); ?>" class="btn btn-info">Cancel</a>
                        </div>
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
<!-- Purchase Report End -->


<?php
$modaldata['bootstrap_model'] = array('vendor','tax_info','payment_model','bank_info');
$modaldata['payment_id'] = $payment_id;

$this->load->view('include/bootstrap_model', $modaldata);
?>

<!-- Payment script -->
<script>
  
   $(document).ready(function () {
   $('#bank').selectize({
       sortField: 'text'
   });
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
   $('#paypls').on('click', function (e) {
      e.preventDefault();
      var Balance = $('.balance_modal').val();
      $('#amount_to_pay').val(Balance);
      $('#payment_modal').modal('show');
   });
   
</script>
<script>
   var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
   var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
   function discard(){
   $.get(
   "<?php echo base_url(); ?>Cinvoice/delete_trucking/", 
   { val: $("#invoice_hdn1").val(), csrfName:csrfHash,payment_id:$('#payment_id').val() }, // put your parameters here
   function(responseText){
   console.log(responseText);
   window.btn_clicked = true;      //set btn_clicked to true
   var input_hdn="Your Invoice No :"+$('#invoice_hdn').val()+" has been Discared";
   
   console.log(input_hdn);
   $('#myModal3').modal('hide');
   $("#bodyModal1").html(input_hdn);
   $('#myModal1').modal('show');
   window.setTimeout(function(){
   
   
   window.location = "<?php  echo base_url(); ?>Cinvoice/manage_trucking";
   }, 2000);
   }
   ); 
   }
  
  
   
   
   $('#download').on('click', function (e) {
   
   var popout = window.open("<?php  echo base_url(); ?>Cinvoice/trucking_details_data/"+$('#invoice_hdn1').val());
   
   
   
   });  
   $('#print').on('click', function (e) {
   
   var popout = window.open("<?php  echo base_url(); ?>Cinvoice/trucking_details_data_print/"+$('#invoice_hdn1').val());
   
   
   
   });  
   
   $('.final_submit').on('click', function () {
   
      window.location.href = "<?php echo base_url(); ?>Cinvoice/manage_trucking?id=<?php echo $_GET['id']; ?>";
   
   });
   
   
   
   
   
   $(document).ready(function(){
   $('#final_submit').hide();
   $('#download').hide();
   $('#email_btn').hide();
   });
   
   var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
   var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
   $(document).on('keyup','#truckingTable_1 #addPurchaseItem_1 tr:last',function (e) {
    
// Append the new row to the table
var tid = $(this).closest('table').attr('id');
const indexLast = tid.lastIndexOf('_');
var id = tid.slice(indexLast + 1);
var $lastRow = $('#addPurchaseItem_' + id + ' tr:last');
var num = id + ($lastRow.index() + 1);

// Destroy existing Select2 instances on all select elements in the table
$('#addPurchaseItem_' + id + ' select').each(function() {
    if ($(this).data('select2')) {
        $(this).select2('destroy');
    }
});

// Clone the last row including td elements
var $newRow = $('<tr></tr>');
$lastRow.find('td').each(function() {
    var $td = $(this);
    var $clonedTd = $td.clone(); // Clone the td element
    
    $clonedTd.find('select, input').each(function() {
        var $element = $(this).clone(); // Clone the element
        var newId = $element.attr('id') ? $element.attr('id').replace(/\d+$/, num) : null;
        if (newId) {
            $element.attr('id', newId); // Update ID
        }
        $(this).replaceWith($element);
    });
    
    // Append the cloned td to the new row
    $newRow.append($clonedTd);
});

$newRow.appendTo('#addPurchaseItem_' + id);


$newRow.find('select').each(function() {
    var $select = $(this);
    
    
    if ($select.data('select2')) {
        $select.select2('destroy');
    }
    
    $select.select2();
});

//end of clone
   var sum=0;
   $(this).closest('table').find('.total_price').each(function() {
   var v=$(this).val();
   sum += parseFloat(v);
   
   });
   $(this).closest('table').find('#Total').val(sum).trigger('change');
   
   calculate_ONROWADD();
   
   });
   
   
   function calculate_ONROWADD(){
   
   
   var first=$("#Total").val();
   var tax= $('#product_tax').val();
   
   var field = tax.split('-');
   
   var percent = field[1];
   var answer=0;
   var answer =(parseInt(percent) / 100) * parseInt(first);
   console.log(answer);
   answer = isNaN(parseInt(answer)) ? 0 : parseInt(answer);
   $('#tax_details').val(answer +" ( "+tax+" )");
   
   var gtotal = parseInt(first + answer);
   console.log(gtotal);
   var amt=parseInt(answer)+parseInt(first);
   var num = isNaN(parseInt(amt)) ? 0 : parseInt(amt)
   var custo_amt=$('#custocurrency_rate').val();
   $("#gtotal").val(num);  
   console.log(num +"-"+custo_amt);
   var value=parseInt(num*custo_amt);
   var custo_final = isNaN(parseInt(value)) ? 0 : parseInt(value)
   $('#customer_gtotal').val(custo_final);
   var bal_amt=custo_final-$('#amount_paid').val();
   $('#balance').val(bal_amt);
     
    }
   
   
   
    
   
   $(document).ready(function(){
   $(document).on('click', '.rdelete', function(){
   var tid=$(this).closest('table').attr('id');
   var $row = $(this).closest('tr');
   var rowIndex = $row.index();
   if (rowIndex > 0) {
      localStorage.setItem("delete_table", tid);
      console.log(localStorage.getItem("delete_table"));
      $row.remove();
   } 
   

   var sum=0;
   $('#'+localStorage.getItem("delete_table")).find('.total_price').each(function() {
   var v=$(this).val();
   sum += parseFloat(v);
   });
   $('#'+localStorage.getItem("delete_table")).find('#Total').val(sum).trigger('change');
   var first=$("#Total").val();
   var tax= $('#product_tax').val();
   var field = tax.split('-');
   var percent = field[1];
   var answer=0;
   var answer =(parseInt(percent) / 100) * parseInt(first);
   console.log(answer);
   answer = isNaN(parseInt(answer)) ? 0 : parseInt(answer);
   $('#tax_details').val(answer.toFixed(2)+" ( "+tax+" )");
   var gtotal = parseInt(first + answer);
   console.log(gtotal);
   var amt=parseInt(answer)+parseInt(first);
   var num = isNaN(parseInt(amt)) ? 0 : parseInt(amt)
   var custo_amt=$('#custocurrency_rate').val();
   $("#gtotal").val(num);  
   console.log(num +"-"+custo_amt);
   var value=parseInt(num*custo_amt);
   var custo_final = isNaN(parseInt(value)) ? 0 : parseInt(value)
   $('#customer_gtotal').val(custo_final);
   var bal_amt=custo_final-$('#amount_paid').val();
   $('#balance').val(bal_amt);
   gt();
   });




   $('#product_tax').on('change', function (e) {

   var first=$("#Total").val();
   var tax= $('#product_tax').val();
   var field = tax.split('-');
   
   var percent = field[1];
   var answer=0;
   var answer = parseInt((percent / 100) * first);
   console.log("Answer : "+answer);
   var gtotal = parseInt(first + answer);
   console.log("gtotal :" +gtotal);
   var final_g= $('#final_gtotal').val();
   
   
   var amt=parseInt(answer)+parseInt(first);
   var num = isNaN(parseInt(amt)) ? 0 : parseInt(amt)
   var custo_amt=$('#custocurrency_rate').val(); 
   console.log("numhere :"+num +"-"+custo_amt);
   var value=parseInt(num*custo_amt);
   var custo_final = isNaN(parseInt(value)) ? 0 : parseInt(value)
   $('#customer_gtotal').val(custo_final);  
   calculate();
   });
   });
   $( document ).ready(function() {
               $('.hiden').css("display","none");
   
   
   
   $('#custocurrency_rate').on('change textInput input', function (e) {
   calculate();
   });
   
   $('.common_qnt').on('change textInput input', function (e) {
   calculate();
   });
   
   });
   
   var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
   var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
   function available_quantity (id) {
   $('.product_name').on('change', function (e) {
   var name = 'available_quantity_'+ id;
   
   var amount = 'product_rate_'+ id;
   var pdt=$('#prodt_'+id).val();
   const myArray = pdt.split("-");
   var product_nam=myArray[0];
   var product_model=myArray[1];
   var data = {
   amount:'product_rate_'+ id,
   name:'available_quantity_'+ id,
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
   if(result.csrfName){
    
      csrfName = result.csrfName;
      csrfHash = result.csrfHash;
   }
   $(".available_quantity_"+ id).val(result[0]['p_quantity']);
   $("#product_rate_"+ id).val(result[0]['price']);
   $(".product_id_"+ id).val(result[0]['product_id']);
   console.log(result);
   }
   });
   });
   }
   
   
    
   
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
   
   $("#custocurrency_rate").inputFilter(function(value) {
   return /^-?\d*[.,]?\d*$/.test(value); }, "Must be a floating (real) Number");
   $('#bill_to').on('change', function (e) {
   
      billtaxes();
   
   
   });
   function billtaxes(){
      var data = {
      value: $('#bill_to').val()
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
      // var parsedData = JSON.parse(result);
      //  alert(result[0].p_quantity);
      console.log(result[0]['currency_type']);
      $(".cus").html(result[0]['currency_type']);
      $("label[for='custocurrency']").html(result[0]['currency_type']);
      console.log('https://open.er-api.com/v6/latest/<?php echo $curn_info_default; ?>');
      $.getJSON('https://open.er-api.com/v6/latest/<?php echo $curn_info_default; ?>', 
      function(data) {
      var custo_currency=result[0]['currency_type'];
      var x=data['rates'][custo_currency];
      var Rate =parseFloat(x).toFixed(3);
      Rate = isNaN(Rate) ? 0 : Rate;
      console.log(Rate);
      $('.hiden').show();
      $("#custocurrency_rate").val(Rate);
      });
      
      }
      });
   }
   $('#product_tax').on('change', function (e) {
   var optionSelected = $("option:selected", this);
   var valueSelected = this.value;
   if(valueSelected==""){
      valueSelected ='0';
   }
   var total=$('#Total').val();
   var tax= $('#product_tax').val();
   
   var field = tax.split('-');
   
   var percent = field[1];
   percent=percent.replace("%","");
   var answer = (percent / 100) * parseInt(total);
   $('#final_gtotal').val(answer);
   $('#hdn').val(valueSelected);
   console.log("taxi :"+valueSelected);
   $('#tax_details').val(answer +" ( "+tax+" )");
   calculate();
   });
   var arr=[];
   $(document).on("input change", ".quantity", function(e){
   
   
   
   
   var total=$(this).closest('tr').find('.total_price').attr('id');
   
   var quantity=$(this).closest('tr').find('.quantity').attr('id');
   var amount = $(this).closest('tr').find('.productrate').attr('id');
   var grand=$('#gtotal').val();
   var quan=$('#'+quantity).val();
   var amt=$('#'+amount).val();
   var result=parseInt(quan) * parseInt(amt);
   result = isNaN(result) ? 0 : result;
   arr.push(result);
   $('#'+total).val(result);
   
   gt();
   
   });
   $(document).on("input change", ".quantity", function(e){
    
   var total=$(this).closest('tr').find('.total_price').attr('id');
   
   var quantity=$(this).closest('tr').find('.quantity').attr('id');
   var amount = $(this).closest('tr').find('.productrate').attr('id');
   var grand=$('#gtotal').val();
   var quan=$('#'+quantity).val();
   var amt=$('#'+amount).val();
   var result=parseInt(quan) * parseInt(amt);
   result = isNaN(result) ? 0 : result;
   arr.push(result);
   $('#'+total).val(result);
   var first=$("#Total").val();
   var tax= $('#product_tax').val();
   
   var field = tax.split('-');
   
   var percent = field[1];
   var answer=0;
   var answer =(parseInt(percent) / 100) * parseInt(first);
   console.log(answer);
   answer = isNaN(parseInt(answer)) ? 0 : parseInt(answer);
   $('#tax_details').val(answer +" ( "+tax+" )");
   
   var gtotal = parseInt(first + answer);
   console.log(gtotal);
   var amt=parseInt(answer)+parseInt(first);
   var num = isNaN(parseInt(amt)) ? 0 : parseInt(amt)
   var custo_amt=$('#custocurrency_rate').val();
   $("#gtotal").val(num);  
   console.log(num +"-"+custo_amt);
   var value=parseInt(num*custo_amt);
   var custo_final = isNaN(parseInt(value)) ? 0 : parseInt(value)
   $('#customer_gtotal').val(custo_final);
   var bal_amt=custo_final-$('#amount_paid').val();
   $('#balance').val(bal_amt);
   gt();
   
   });
   $(document).on("input change", ".productrate", function(e){
   
   var total=$(this).closest('tr').find('.total_price').attr('id');
   
   var quantity=$(this).closest('tr').find('.quantity').attr('id');
   var amount = $(this).closest('tr').find('.productrate').attr('id');
   var grand=$('#gtotal').val();
   var quan=$('#'+quantity).val();
   var amt=$('#'+amount).val();
   var result=parseInt(quan) * parseInt(amt);
   result = isNaN(result) ? 0 : result;
   arr.push(result);
   $('#'+total).val(result);
   var first=$("#Total").val();
   var tax= $('#product_tax').val();
   
   var field = tax.split('-');
   
   var percent = field[1];
   var answer=0;
   var answer =(parseInt(percent) / 100) * parseInt(first);
   console.log(answer);
   answer = isNaN(parseInt(answer)) ? 0 : parseInt(answer);
   $('#tax_details').val(answer +" ( "+tax+" )");
   
   var gtotal = parseInt(first + answer);
   console.log(gtotal);
   var amt=parseInt(answer)+parseInt(first);
   var num = isNaN(parseInt(amt)) ? 0 : parseInt(amt)
   var custo_amt=$('#custocurrency_rate').val();
   $("#gtotal").val(num);  
   console.log(num +"-"+custo_amt);
   var value=parseInt(num*custo_amt);
   var custo_final = isNaN(parseInt(value)) ? 0 : parseInt(value)
   $('#customer_gtotal').val(custo_final);
   var bal_amt=custo_final-$('#amount_paid').val();
   $('#balance').val(bal_amt);
   gt();
   
   });


   function gt(){
      // debugger;
   var sum=0;
   $('.total_price').each(function() {
   sum += parseFloat($(this).val());
   });
   $('#Total').val(sum);
   var final_g= $('#final_gtotal').val();
   if(final_g !=''){
   var first=$("#Total").val();
   var tax= $('#product_tax').val();
   
   var field = tax.split('-');
   
   var percent = field[1];
   var answer=0;
   var answer =(parseInt(percent) / 100) * parseInt(first);
   console.log(answer);
   answer = isNaN(parseInt(answer)) ? 0 : parseInt(answer);
   $('#tax_details').val(answer +" ( "+tax+" )");
   
   var gtotal = parseInt(first + answer);
   console.log(gtotal);
   var amt=parseInt(answer)+parseInt(first);
   var num = isNaN(parseInt(amt)) ? 0 : parseInt(amt)
   var custo_amt=$('#custocurrency_rate').val();
   $("#gtotal").val(num);  
   console.log(num +"-"+custo_amt);
   var value=parseInt(num*custo_amt);
   var custo_final = isNaN(parseInt(value)) ? 0 : parseInt(value)
   $('#customer_gtotal').val(custo_final);
   var bal_amt=custo_final-$('#amount_paid').val();
   $('#balance').val(bal_amt);
   }  
   }



   function calculate(){
   // debugger;
   var first=$("#Total").val();
   var tax= $('#product_tax').val();
   var field = tax.split('-');
   
   var percent = field[1];
   var answer=0;
   var answer = parseInt((percent / 100) * first);
   var gtotal = parseInt(first + answer);
   console.log(gtotal);
   var final_g= $('#final_gtotal').val();
   
   
   var amt=parseInt(final_g)+parseInt(first);
   var num = isNaN(parseInt(amt)) ? 0 : parseInt(amt);
   $("#gtotal").val(num);  
   var custo_amt=$('#custocurrency_rate').val();
   
   console.log(num +"-"+custo_amt);
   var value=parseInt(num*custo_amt);
   var custo_final = isNaN(parseInt(value)) ? 0 : parseInt(value)
   $('#customer_gtotal').val(custo_final);  

   $('#balance').val(custo_final);

   }
   
   
   $( document ).ready(function() {
   $('#final_submit').hide();
   $('#download').hide();
   $('#print').hide();
                   $('.hiden').css("display","none");
   
   
   
   $('#Total').on('change textInput input', function (e) {
   calculate();
   });
   
   $('#custocurrency_rate').on('change textInput input', function (e) {
   calculate();
   });
  
   });
</script>
<style>
   .select2, .ui-selectmenu-text{
   display:none;
   }
</style>
<script>
   const select = document.querySelectorAll(".currency");
   const btn = document.getElementById("btn");
   const num = document.getElementById("num");
   const ans = document.getElementById("ans");
   const err = document.getElementById("errorMSG");
   const info = document.getElementById("info");
   const baseFlagsUrl = "https://wise.com/public-resources/assets/flags/rectangle";
   const currencyApiUrl = "https://open.er-api.com/v6/latest";
   
   document.addEventListener('DOMContentLoaded', function(){ 
     fetch(currencyApiUrl)
       .then((data) => data.json())
       .then((data) => {
       err.innerHTML = "";
       display(data.rates);
       $('.currency').select2({
         width: 'resolve',
     
         maximumInputLength: 3
       });
       info.innerHTML = "Result: "+data.result+"<br>Provider: "+data.provider+"<br>Documentation: "+data.documentation+"<br>Terms of use: "+data.terms_of_use+"<br>Time Last Update UTC: "+data.time_last_update_utc;
       $('#pageLoader').fadeOut();
     }).catch(function(error) {
       err.innerHTML = "Error: " + error;
       $('#pageLoader').fadeOut();
     });
   function display(data){
     const entries = Object.entries(data);
     for (var i = 0; i < entries.length; i++){
       select[0].innerHTML += `<option value="${entries[i][0]}">${entries[i][0]}</option>`;
       select[1].innerHTML += `<option value="${entries[i][0]}">${entries[i][0]}</option>`;
     }
     
   }
   });
    
</script>

<script type="text/javascript">

var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';


   // Form validation
   $("#insert_trucking").validate({
        rules: {
            bill_to: {
               required: true,
            },
            invoice_date: {
               required: true,
            },
            delivery_to: {
               required: true,
            },
            supplier_id: {
               required: true,
            },
            delivery_date: {
               required: true,
            },
            delivery_time_from: {
               required: true,
            },
            delivery_time_to: {
               required: true,
            },
            truck_no: {
               required: true,
            },
        },
        messages: {
            bill_to: "Please choose a customer from the list",
            invoice_date: "Please choose the date for the invoice",
            delivery_to: "Please choose a delivery to",
            supplier_id: "Please choose a shipping company",
            delivery_date: "Please choose a delivery date",
            delivery_time_from: "delivery from time",
            delivery_time_to: "delivery to time",
            truck_no: "Please choose a truck no",
        },
         errorPlacement: function(error, element) {
            if (element.hasClass("select2-hidden-accessible")) {
                error.insertAfter(element.next('span.select2'));
            } else {
                error.insertAfter(element);
            }
         },
        submitHandler: function(form, event) {
            event.preventDefault();
            var formData = new FormData(form);
            formData.append(csrfName, csrfHash);
            formData.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
            //formData.append('attachment_id', document.getElementById('attachment_id').value);
            //    form_data.append('csrfName', '{{ csrfHash }}');
            
             $.ajax({
              type: "POST",
              url: "<?php echo base_url(); ?>Sales/insertTrucking",
              data: formData,
              dataType: "json",
              contentType: false,
              processData: false,
              success: function(response) {
                  console.log(response, "response");
                  if(response.status == 'success') {
                    
                     $('.displaymessage').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
                     window.setTimeout(function(){
                        document.getElementById('insert_trucking').reset();
                        window.location = "<?php echo base_url(); ?>sales/roadTransport?id=<?php echo $_GET['id']; ?>"
                     },2500);
                  } else {
                     $('.displaymessage').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
                  }
                  
              }
            });
         return false;
        }
    });
  function deleteRoadTrans(id,moid){
   var isConfirmed = confirm("Are you sure you want to delete this item?");
    if (isConfirmed && id !="") {
        var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
        var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
        var succalert = '<div class="alert alert-success alert-dismissible" role="alert">';
        var failalert = '<div class="alert alert-danger alert-dismissible" role="alert">';
        if(id !=""){
            $.ajax({
                type:"POST",
                dataType:"json",
                url:"<?php echo base_url(); ?>sales/deleteOceanExportTrack",
                data:{id:id,moid:moid, <?php echo $this->security->get_csrf_token_name();?>:csrfHash},
                success:function (response) {
                if(response.status =='success'){
                    $('.error_display').html(succalert+response.msg+'</div>');
                    window.setTimeout(function(){
                        oceanExportDataTable.ajax.reload(null, false);
                        $('.error_display').html('');
                    },2500);
                }else{
                        $('.error_display').html(failalert+response.msg+'</div>'); 
                }
                }
            });
        }
    }

  }
</script>
<style>
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
   
   @media (min-width: 768px) {
       .mobilewidth_view{
           position: relative;
           right: 26px;
       }

   }
</style>
