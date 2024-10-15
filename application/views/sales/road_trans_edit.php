    <!-- Product Purchase js -->
    <script src="<?php echo base_url()?>my-assets/js/admin_js/json/product_purchase.js.php" ></script>
<!-- Supplier Js -->
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/supplier.js.php" ></script>

<script src="<?php echo base_url()?>my-assets/js/admin_js/purchase.js" type="text/javascript"></script>

<script src="<?php echo base_url() ?>my-assets/js/countrypicker.js" type="text/javascript"></script>

<style>
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 6px;
    }

    .btnclr{
       background-color:<?php echo $setting_detail[0]['button_color']; ?>;
       color: white;

   }
    </style>
 
    
    <div class="content-wrapper">
        <section class="content-header">
            <div class="header-icon">
                <figure class="one">
                <img src="<?php echo base_url()  ?>asset/images/trucking.png"  class="headshotphoto" style="height:50px;" />

            </div>
            <div class="header-title">
                <div class="logo-holder logo-9">
                <h1><?php echo display('Edit Road Transport') ?></h1>

            </div>
            <small></small>
            <ol class="breadcrumb" style="border: 3px solid #d7d4d6;">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('Sale') ?></a></li>
                <li class="active" style="color:orange;"><?php echo display('Edit Road Transport') ?></li>
                
                    <div class="load-wrapp">
                        <div class="load-10">
                            <div class="bar"></div>
                        </div>
                    </div>
            </ol>
        </div>
    </section>
<style>
    
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
.td{
    width: 200px;
    text-align-last: end;
    border-right: hidden;
}
        input {
    border: none;

 }
 .ui-selectmenu-menu,.ui-front{
    display:none;
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
tfoot tr{
    height:45px;
}
</style>
<section class="content">
        
    <div class="row">

        <div class="col-sm-12">

            <div class="panel panel-bd lobidrag">

                <div class="panel-heading" style="height:60px;">
                    <div class="panel-title">
                        <div class="Row">
                            <div class="Column" style="float: left;">
                                <h4><?php //echo "Edit New Trucking Invoice" ?></h4>
              
                            </div> 
                            <div class="Column" style="float: right;"> 
                                <form id="histroy" method="post" >
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                    <input type="hidden"  value="<?php echo $payment_id; ?>" name="makepaymentId" class="payment_id" id="makepaymentId"/>
                                    <input type="hidden"  value="<?php echo html_escape($customer_id);?>" name="customer_id" class="customer_id" id="customer_id"/>
                                    <input type="hidden"  value="<?php echo $_GET['id']; ?>" name="admin_id" class="admin_id" id="admin_id"/>
                                    <input type="hidden"  value="<?php echo $trucking_id; ?>" name="trucking_id" class="trucking_id" id="trucking_id"/>
                                  
                                    <input type="submit" id="payment_history" name="payment_history" class="btn btnclr" style="float:right; " value="Payment History" style="float:right;margin-bottom:30px;"/>
                                </form>
                               <?php /* <a href="#" class="client-add-btn btn  btnclr " aria-hidden="true" data-toggle="modal" data-target="#payment_modal">Payment History</a> */ ?>
                            </div> 
                            <div class="Column" style="float: right;">
                                <a   href="<?php echo base_url('sales/roadTransport?id='.$_GET['id']); ?>" class="btnclr btn  m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo "Manage Road Transports" ?> </a>


                            </div>    
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                <div class="displaymessage"></div>
                <br/>
                   <form id="update_trucking" name="update_trucking" method="post">        
                        <input type="hidden"  value="<?php echo $payment_id; ?>" name="makepaymentId" class="payment_id" id="makepaymentId"/>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="invoice_no" class="col-sm-4 col-form-label"><?php echo display('invoice_no') ?>
                                        <i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" tabindex="3" class="form-control"  style="border:2px solid #d7d4d6;" name="invoice_no" value="<?php echo $purchase_info[0]['invoice_no']; ?>" readonly />
                                        <input type="hidden" tabindex="3" class="form-control" name="attachment_id" id="attachment_id" value="<?php echo $purchase_info[0]['invoice_no']; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label"><?php echo display('Invoice Date') ?>
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <?php $date = date('Y-m-d'); ?>
                                        <input type="date" required tabindex="2" class="form-control "  style="border:2px solid #d7d4d6;" name="invoice_date" value="<?php echo $purchase_info[0]['invoice_date']; ?>" id="date"  />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="invoice_hdn"/> <input type="hidden" id="invoice_hdn1"/>
                        <div class="row">
                            <?php /*<input type="hidden"  value="<?php echo $payment_id; ?>"  name="payment_id"/> */ ?>
                            <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="supplier_sss" class="col-sm-4 col-form-label"><?php echo display('Customer Name') ?>
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-8">
                                    <select name="bill_to" id="bill_to" class="form-control" onchange=""  style="border:2px solid #d7d4d6;">
                                        
                                            <?php foreach ($customer_list as $customer) {
                                            $selected_cus =  $purchase_info[0]['customer_id'] ==$customer->customer_id ? 'selected' : ''; ?>
                                            <option <?php echo $selected_cus; ?> value="<?php echo html_escape($customer->customer_id);?>"><?php echo html_escape($customer->customer_name);?></option>

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
                                <div class="col-sm-8">
                                    <?php //print_r($get_supplier); ?>
                                    <select name="supplier_id" id="supplier_id" class="form-control " required=""  style="border:2px solid #d7d4d6;"  tabindex="1"> 
                                        <?php 
                                        foreach($get_supplier as $supplier_data) { 
                                            $select_supp    = $purchase_info[0]['shipment_company'] ==$supplier_data['supplier_id'] ? 'selected' : '';
                                            ?>
                                        <option <?php echo $select_supp; ?> value="<?php echo $supplier_data['supplier_id']; ?>"><?php echo $supplier_data['supplier_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <?php if($this->permission1->method('add_supplier','create')->access()){ ?>
                                    <div class="col-sm-2">
                                    </div>
                                <?php }?>
                            </div> 
                        </div>

                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                           
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="delivery_to" class="col-sm-4 col-form-label"><?php echo display('Delivery to') ?>
                                <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-8">
                                    <select name="delivery_to" id="delivery_to" class="form-control" onchange="" required style="border:2px solid #d7d4d6;" >
                                        
                                        <?php foreach ($customer_list as $customer) {
                                            $selecteddel = $delivery_to ==$customer->customer_name ? 'selected' : '';
                                            ?>
                                        <option <?php echo $selecteddel; ?> value="<?php echo html_escape($customer->customer_name);?>"><?php echo html_escape($customer->customer_name);?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div> 
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group row">
                                    <label for="container_pick_up_date" class="col-sm-4 col-form-label"><?php echo display('Container / Goods Pick up date') ?>
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <?php $date = date('Y-m-d'); ?>
                                        <input type="date" required tabindex="2" class="form-control " name="container_pick_up_date" style="border:2px solid #d7d4d6;"  value="<?php echo $purchase_info[0]['container_pickup_date']; ?>" id="container_pick_up_date"  />
                                    </div>
                                
                                </div> 
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="delivery_date" class="col-sm-4 col-form-label"><?php echo display('Delivery date') ?>
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-8">
                                    <?php $date = date('Y-m-d'); ?>
                                    <input type="date" required tabindex="2" class="form-control " name="delivery_date" style="border:2px solid #d7d4d6;" value="<?php echo $purchase_info[0]['delivery_date']; ?>" id="delivery_date"  />
                                </div>
                                
                            </div> 
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="delivery_time" class="col-sm-4 col-form-label"><?php echo display('Delivery Time') ?>
                                    <i class="text-danger">*</i>
                                </label>
                                <label for="supplier_sss" class="col-sm-1 col-form-label"><?php echo display('From')?>
                                </label>
                                    <div class="col-sm-3">
                                
                                    <input type="time" required tabindex="2" class="form-control " style="border:2px solid #d7d4d6;"  name="delivery_time_from" value="{delivery_time_from}" id="time"  />
                                </div>
                                <label for="delivery_time" class="col-sm-1 col-form-label"><?php echo display('TO' )?>
                                </label>
                                <div class="col-sm-3"> 
                                
                                    <input type="time" required tabindex="2" class="form-control " style="border:2px solid #d7d4d6;" name="delivery_time_to" value="{delivery_time_to}" id="time"  />
                                </div>
                            
                            </div> 
                        </div>
                        <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label"><?php echo display('Attachments') ?>
                                    </label>
                                    <div class="col-sm-8">
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

                                    
                                        <?php foreach ($trucking_data as $key => $attachment) { ?> 
                                            <span class="attach_<?php echo $key; ?>"><span class="file-block"><span class="file-delete" onClick="deleteAttachment(<?php echo $attachment['id']; ?>,<?php echo $key; ?>);"><i class="fa fa-trash-o"></i></span><a href="<?php  echo base_url(TRUCK_IMG_PATH.$attachment['files']); ?>" target=_blank><?php echo $attachment['files']; ?></a></span></span>
                                        <?php } ?>
                                    
                                    </div>
                                </div> 
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="truck_no" class="col-sm-4 col-form-label"><?php echo display('Truck No') ?> <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" required tabindex="2" class="form-control "  style="border:2px solid #d7d4d6;" name="truck_no" value="{truck_no}" id="truck_no"/>
                                    </div>
                                    
                                </div> 
                            </div>

       
                        </div>
                        <?php  $d= $purchase_info[0]['tax']; 
                        preg_match('#\((.*?)\)#', $d, $match);
                       //echo $match[1]; exit;
                        ?>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" style="border:2px solid #d7d4d6;" >
                        <tr>
                       <td class="hiden" style="width:50%;border:none;text-align:end;font-weight:bold;">
                       <?php echo display('live rate') ?> : 
                         </td>
                
                                <td class="hiden btnclr" style="width:180px;padding:5px; border:none;font-weight:bold;color:white;">1 <?php  echo $curn_info_default;  ?>
                                 = <input style="width:70px;text-align:center;color:black;padding:5px;" type="text" id="custocurrency_rate"/>&nbsp;<label for="custocurrency"  ></label></td>
                       <td style="border:none;text-align:right;font-weight:bold;"><?php echo display('Tax') ?> : 
                                 </td>
                                <td style="width:20%">
                                    <select name="tx" id="product_tax" class="form-control" >
                                        
                                    <?php foreach($edit_tax as $tx){
                                            $selecttx = strtoupper($match[1]) == $tx['tax_id'].'-'.$tx['tax'].'%' ? 'selected' : ''; ?>
                                            <option <?php echo $selecttx; ?> value="<?php echo $tx['tax_id'].'-'.$tx['tax'].'%';?>">  <?php echo $tx['tax_id'].'-'.$tx['tax'].'%';  ?></option>
                                        <?php } ?> 
                                    </select>
                            </td>
                            </tr>
                        </table>
                        <input type="hidden"  value="<?php echo $payment_id; ?>" name="payment_id" class="payment_id"/>
                             <table class="table table-bordered table-hover" id="truckingTable_1" style="border:2px solid #d7d4d6;" >
                                <thead>
                                     <tr>
                                            <th class="text-center" width="15%"><?php echo display('Date') ?><i class="text-danger">*</i></th> 
                                            <th class="text-center"><?php echo display('Quantity') ?><i class="text-danger">*</i></th>
                                            <th class="text-center"><?php echo display('Description') ?><i class="text-danger">*</i></th>
                                            <th class="text-center" width="20%"><?php echo display('Rate') ?><i class="text-danger">*</i></th>
                                            <th class="text-center"><?php echo display('Pro No / Reference') ?><i class="text-danger">*</i></th>

                                            <th class="text-center"><?php echo display('total') ?></th>
                                            <th class="text-center"><?php echo display('action') ?></th>
                                        </tr>
                                </thead>
                             <tbody id="addPurchaseItem_1">
                             
                                <?php $cnt=1;
                                 foreach($purchase_info as $pf){ ?>

                                    <tr>
                                        <td class="span3 supplier">
                                                
                                            <?php $date = date('Y-m-d'); ?>
                                               <input type="date" required tabindex="2" class="form-control " name="trucking_date[]" value="<?php echo $pf['trucking_date'] ; ?>"  id="date"/>
                                        </td>

                                       <td class="wt">
                                            <input type="text" name="product_quantity[]" id="cartoon_<?php echo $cnt; ?>" required="" min="0" class="quantity form-control text-right store_cal_<?php echo $cnt; ?>"  placeholder="0.00" value="<?php echo $pf['qty'] ; ?>" tabindex="6"/>
                                        </td>
                                        
                                        <td class="text-right">
                                            <input type="text" name="description[]" id="description" required="" class="form-control text-right" value="<?php echo $pf['description'] ; ?>" tabindex="7"/>
                                        </td>
                                        <td class="text-right">
                                            <span class=""> 
                                                <input type="text" name="product_rate[]" required=""  id="product_rate_<?php echo $cnt; ?>" class="form-control text-right productrate" value="<?php echo $pf['rate'] ; ?>" min="0" tabindex="8"/>
                                            </span>
                                       </td>

                                       <td class="text-right">
                                        <select name="pro_no[]" id="invoice_no_<?php echo $cnt; ?>" class="form-control" required="" tabindex="1">
                                        
                                           <?php foreach($invoice as $inv){ 
                                                $selec_pre = $pf['pro_no_reference'] ==$inv['commercial_invoice_number'] ? 'selected' : ''; 
                                            ?>
                                            <option <?php echo $selec_pre; ?> value="<?php echo $inv['commercial_invoice_number']; ?>"><?php echo $inv['commercial_invoice_number'] ; ?></option>
                                        <?php    }?>
                                        </select>
                                        </td>
                                        <td class="text-right"> 
                                            <span class="">   
                                            <input class="form-control total_price" type="text" name="total_price[]" id="total_price_<?php echo $cnt; ?>"  value="<?php echo $pf['total'] ; ?>"   readonly="readonly" /></span>
                                        </td>
     
                                        <td style="text-align: center;">
                                            <button  class="rdelete btn btn-danger text-right red" type="button" value="<?php echo display('delete')?>" tabindex="9"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php $cnt++; } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td style="padding-top: 20px;text-align:right;" colspan="5" ><b><?php echo display('total') ?>:</b></td>
                                      
                                        <td style="text-align:left;">   <span class="input-symbol-euro">   
                                            <input type="text" id="Total" class="form-control text-right" name="total"  value="<?php echo $purchase_info[0]['total_amt']; ?>" readonly="readonly" /></span>
                                        </td>
                                    </tr>
                                    <tr>
                                   
                                        <td style="text-align:right;" colspan="5"><b><?php echo display('Tax Details') ?> :</b></td>
                                        <td style="text-align:left;">
                                        <span class="input-symbol-euro">   
                                            <input type="text" id="tax_details" class="form-control text-right" value="<?php echo $purchase_info[0]['tax']; ?>" name="tax_details"  readonly="readonly" /></span>
                                        </td>
                                    </tr>
                                    <tr> 
                                        <td style="text-align:right;" colspan="5"><b><?php echo display('Grand Total') ?>:</b></td>
                                        <td style="text-align:left;"><span class="input-symbol-euro">   
                                            <input type="text" id="gtotal"  class="form-control" name="gtotal" onchange="" value="<?php echo $purchase_info[0]['grand_total_amount']; ?>"  readonly="readonly" /></span>
                                        </td>
                                    </tr>
                                  
                                    <tr>
                                        <td style="text-align:right;"  colspan="5"><b><?php echo display('Grand Total') ?>:</b><br/><b><?php echo display('Preferred Currency') ?></b></td>
                                        <td>
                                            <table border="0">
                                                <tr>
                                                    <td class="cus" name="cus"></td>
                                                    <td><input class="form-control" type="text"  readonly id="customer_gtotal"  name="customer_gtotal" value="<?php echo $purchase_info[0]['customer_gtotal']; ?>"/></td>
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
                                                    <td class="cus" name="cus"></td>
                                                    <td><input class="form-control" type="text"  readonly id="amount_paid"  name="amount_paid" value="<?php echo $purchase_info[0]['amt_paid']; ?>"  required   /></td>
                                                </tr>
                                            </table>
                                        
                                            </td>
                                            </tr> 
                                            <tr id="bal">
                                            <td style="text-align:right;"  colspan="5"><b><?php echo display('Balance Amount') ?>:</b></td>
                                            <td>
                                            <table border="0">
                                                <tr>
                                                    <td class="cus" name="cus"></td>
                                                    <td><input class="form-control balance_modal"  type="text"  readonly id="balance"  value="<?php echo $purchase_info[0]['balance']; ?>" name="balance"  required/></td>
                                                </tr>
                                            </table>
                                         
                                            </td>
                                            </tr> 
                                            <tr style="border-right:none;border-left:none;border-bottom:none;border-top:none">
                                               <td colspan="5" >
                                               </div> 
                                 
                                            </td>
                                            <td colspan="6" style="">
                                        <input type="button" value="<?php echo display('Make Payment') ?>" style="float:left; " class="btnclr btn btn-large" id="paypls"/>
                                            </td>
                                            </tr>
                                </tfoot>
                                </tfoot>
                            </table>
                        </div>
                        <div class="form-group row">
                            <label for="remarks" class="col-sm-2 col-form-label"><?php echo display('Remarks') ?></label>
                            <div class="col-sm-8">
                                <textarea rows="4" cols="50" name="remarks" class=" form-control" style="border:2px solid #d7d4d6;"  id=""><?php if(!empty($purchase_info[0]['remarks'])){ echo $purchase_info[0]['remarks'];} ?></textarea>
                                            
                  
                            </div>
                        </div>

                        <div class="form-group row">
                        <input type="hidden" name="admin_company_id" id="admin_company_id" value="<?php echo $_GET['id']; ?>">
                        <label for="example-text-input" class="col-sm-0 col-form-label"></label>
                        <div class="col-sm-12 text-center">
                            <input type="submit" id="add_oceantrack" class="btnclr btn btn-large" name="add_oceantrack" value="Update" tabindex="7" />
                            <a href="<?php echo base_url('sales/roadTransport?id='.$_GET['id']); ?>" class="btn btn-info">Cancel</a>
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
<!-- Purchase Report End -->


            <?php
$modaldata['bootstrap_model'] = array('vendor','tax_info','payment_model','bank_info');
$this->load->view('include/bootstrap_model', $modaldata);
?>
<script>
    billtaxes(); //for live currency show
 var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
   var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
   function discard(){
   $.get(
   "<?php echo base_url(); ?>Cinvoice/delete_trucking/", 
   { val: $("#invoice_hdn1").val(), csrfName:csrfHash,payment_id:$('#makepaymentId').val() }, // put your parameters here
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
   
   $('#paypls').on('click', function (e) {
      e.preventDefault();
      var Balance = $('.balance_modal').val();
      $('#amount_to_pay').val(Balance);
      $('#payment_modal').modal('show');
   });
   
   
   
   $(document).ready(function(){
   $('#final_submit').hide();
   $('#download').hide();
   $('#email_btn').hide();
   });
   
   var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
   var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
   $(document).on('keyup','#truckingTable_1 #addPurchaseItem_1 tr:last',function (e) {
   

        var tid=$(this).closest('table').attr('id');
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
              // $('.hiden').css("display","none");
   
   
   
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
/*
   $(document).on("input change", ".quantity,.productrate", function(e){
   
   
   
   
   var total=$(this).closest('tr').find('.total_price').attr('id');
   alert('teeee');
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
*/
   $(document).on("input change", ".quantity,.productrate", function(e){
    //alert('teeee1');
   var total=$(this).closest('tr').find('.total_price').attr('id');
   
   var quantity=$(this).closest('tr').find('.quantity').attr('id');
    
   var amount = $(this).closest('tr').find('.productrate').attr('id');
   
   var grand=$('#gtotal').val();
   var quan=$('#'+quantity).val();
   var amt=$('#'+amount).val();
   var result=parseInt(quan) * parseInt(amt);
   result = isNaN(result) ? 0 : result;
   arr.push(result);
   console.log('totalid:'+total+', quantityid:'+quantity+', amountid:'+amount);
   console.log('quan:'+quan+', amt:'+amt);
   $('#'+total).val(result);
   var first=$("#Total").val();
   var tax= $('#product_tax').val();
   
   var field = tax.split('-');
   
   var percent = field[1];
   var answer=0;
   var answer =(parseInt(percent) / 100) * parseInt(first);
   answer = isNaN(parseInt(answer)) ? 0 : parseInt(answer);
   $('#tax_details').val(answer +" ( "+tax+" )");
   
   var gtotal = parseInt(first + answer);
   var amt=parseInt(answer)+parseInt(first);
   var num = isNaN(parseInt(amt)) ? 0 : parseInt(amt)
   var custo_amt=$('#custocurrency_rate').val();
   $("#gtotal").val(num);  
   var value=parseInt(num*custo_amt);
   var custo_final = isNaN(parseInt(value)) ? 0 : parseInt(value)
   $('#customer_gtotal').val(custo_final);
   var bal_amt=custo_final-$('#amount_paid').val();
   $('#balance').val(bal_amt);
   gt();
   
   });




   

   function gt(){
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

     console.log('calcultatee');
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
   }
   
   
   $( document ).ready(function() {
   $('#final_submit').hide();
   $('#download').hide();
   $('#print').hide();
                   //$('.hiden').css("display","none");
   
   
   
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
   
    function deleteAttachment(id,key){
        if (confirm("Are you sure you want to delete this attachment?")) {

            var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
            var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
            if(id!=""){
                $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>Sales/deleteAttachment",
                data: {id:id, [csrfName]: csrfHash},
                
                success: function(response) {
                    if(response) {
                        $('.attach_' + key).html('');
                    } else {
                        
                    }
                    
                }
                });
            }
        }
    }

    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
   
   // Form validation
   $("#update_trucking").validate({
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
            formData.append('attachment_id', document.getElementById('attachment_id').value);
           
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
                    
                     $('.displaymessage').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Road transport has been updated successfully</div>');
                     window.setTimeout(function(){
                        document.getElementById('update_trucking').reset();
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
    $('#payment_history').click(function (event) {
      
          
      var dataString = {
          dataString : $("#histroy").serialize()
      
     };
     dataString[csrfName] = csrfHash;
    
      $.ajax({
          type:"POST",
          dataType:"json",
          url:"<?php echo base_url(); ?>Cinvoice/payment_history_trucking",
          data:$("#histroy").serialize(),
   
          success:function (data) {
           console.log(data, "data");
           var gt=$('#customer_gtotal').val();
           var amtpd = data.amt_paid !== null ? data.amt_paid : 0;
           console.log(data.amt_paid, 'amt_paid');
           var bal= $('#gtotal').val() - data.amt_paid;
           var total= "<table class='table table-striped table-bordered' id='paymentTable'><tr><td rowspan='2' style='vertical-align: middle;text-align-last: center;'><b>Grand Total :  <?php  echo $currency;  ?>"+data.overall[0]['overall_gtotal']+"<b></td><td class='td' style='border-right: hidden;'><b>Total Amount Paid :<b></td><td><?php  echo $currency;  ?>"+amtpd+"</td></tr></tr><td class='td' style='border-right: hidden;'><b>Balance :<b></td><td><?php  echo $currency;  ?>"+bal +"</td></tr></table>"
           var table_header = "<table class='table table-striped table-bordered'><thead style='FONT-WEIGHT:BOLD;'><tr><td>S.NO</td><td>Payment Date</td><td>Reference.NO</td><td>Bank Name</td><td>Amount Paid</td><td>Balance</td><td>Details</td></tr></thead><tbody>";
            var table_footer = "</tbody></table>";
            var html ="";
            var count=1;
            if (data.payment_get && data.payment_get.length > 0) {
                console.log(data.payment_get);
                data.payment_get.forEach(function(element) {
                    html += "<tr><td>"+count+"</td><td>"+element.payment_date+"</td><td>"+element.reference_no+"</td><td>"+element.bank_name+"</td><td><?php echo $currency; ?>"+element.amt_paid+"</td><td><?php echo $currency; ?>"+element.balance+"</td><td>" + (element.description ? element.description : '') + "</td></tr>";
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

   /*function total_amt(id_name){
    var lastValue = id_name.split('_').pop();
    var quan      = $('#cartoon_'+lastValue).val();
    var rate      = $('#product_rate_'+lastValue).val();
    var tot_pri   = quan* rate;
    $('#total_price_'+lastValue).val(tot_pri);
   }*/
   
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


  
    


