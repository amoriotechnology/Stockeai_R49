
    
     <div class="content-wrapper">
   <section class="content-header">
      <div class="header-icon">
        <figure class="one">
               <img src="<?php echo base_url()  ?>asset/images/service.png"  class="headshotphoto" style="height:50px;" />
      </div>
      <div class="header-title">
          <div class="logo-holder logo-9">
         <h1><?php echo ('Edit Service Provider') ?></h1>

       </div>
         <ol class="breadcrumb" style="border: 3px solid #d7d4d6;">
            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
            <li><a href="#"><?php echo display('purchase') ?></a></li>
            <li class="active" style="color:orange;"> <?php echo ('Edit Service Provider') ?></li>
        
            <div class="load-wrapp">
      <div class="load-10">
         <div class="bar"></div>
      </div>
    </div>
           <style>
           #bulk_payment_form input[type="text"]  { border: none; 
    background: inherit;
    padding: 0; 
    margin: 0; 
    box-shadow: none; 
    outline: none; 
}
            </style>
        
         </ol>
      </div>
   
      </section>

    <?php $date = date('Y-m-d');  ?>
   
   
   
         <?php  $payment_id_new=rand(); ?>
   
   <section class="content">
      <?php  $d= $info_service[0]['tax_detail']; 
         $t='';
         if($d !=='' && !empty($d)){
            preg_match('#\((.*?)\)#', $d, $match);
         
            $t=$match[1];$t=trim($t);
            
          }else{
         
            $t=$t=trim($t);
            
          }
       
         ?> 
      <?php
         $message = $this->session->userdata('message');
         
         if (isset($message)) {
         
             ?>
      <div class="alert alert-info alert-dismissable">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
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
      <div class="row">
         <div class="col-sm-12">
            <div class="panel panel-bd lobidrag" style="border:3px solid #d7d4d6;" >
               <div class="panel-heading" style="height: 60px;">
                  <div class="panel-title">
                     <div class="Row">
                       
                        <div class="Column" style="float: right;">
       <form id="histroy" method="post" >
                              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                              <input type="hidden"  value="<?php if($info_service[0]['payment_id']){ echo $info_service[0]['payment_id']; }?>" name="makepaymentId" class="payment_id" id="makepaymentId"/>
                              <input type="hidden" value="<?php echo $info_service[0]['bill_number']; ?>" id='current_in_id' name="current_in_id"/>
                              <input type="hidden" value="<?php  echo  $info_service[0]['supplier_id'] ; ?>" name="supplier_id_payment"/>
                            <?php if($info_service[0]['payment_id']){ ?>
                              <input type="submit" id="payment_history" name="payment_history" class="btnclr btn" style="float:right;color:white;float:right;margin-bottom:30px;"   value="<?php echo display('Payment History') ?>"/>
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
                     <div id="errormessage_service_provider" > </div>
                  <form id="serviceprovider" method="post">
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group row">
                              <label for="service_provider_name" class="col-sm-4 col-form-label">Service Provider Name <i class="text-danger">*</i> </label>
                              <div class="col-sm-8">
                                 <select name="service_provider_name" id="supplier_id"  class="service_provider_2 form-control "  style="width:100%;border:2px solid #d7d4d6;" required=""  tabindex="1">
                                    <option value="<?php  echo $info_service[0]['supplier_id']; ?>"><?php  echo $info_service[0]['supplier_name']; ?></option>
                                    {supplier_info}
                                    <option value="{supplier_id}">{supplier_name}</option>
                                    {/supplier_info}
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group row">
                              <label for="sp_address" class="col-sm-4 col-form-label">Service Provider complete address <i class="text-danger"></i> </label>
                              <div class="col-sm-8"> <input type="text" tabindex="3" class="form-control" name="sp_address"  style="border:2px solid #d7d4d6;" value="<?php  echo $info_service[0]['sp_address']; ?>" id="sp_address"  /> </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group row">
                             
                           <label for="bill_date" class="col-sm-4 col-form-label">Bill Date <i class="text-danger">*</i> </label>
                              <div class="col-sm-8">
                                <input type="date" tabindex="2" class="form-control"   style="border:2px solid #d7d4d6;"  value="<?php echo $info_service[0]['bill_date']; ?>" name="bill_date" id="bill_date" />
                              </div>

                           </div>
                         
                        </div>


                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                       
                       
                        <div class="col-sm-6">
                           <div class="form-group row">
                               <label for="bill_number" class="col-sm-4 col-form-label">Bill Number<i class="text-danger">*</i> </label>
                              <div class="col-sm-8"> <input type="text" tabindex="2"  class="form-control"  style="border:2px solid #d7d4d6;"  name="bill_num" value="<?php  echo $info_service[0]['bill_number']; ?>" id="bill_number"  /> </div>
                           </div>
                        </div>
                     </div>



                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group row">
                        


                              <label for="payment_terms" class="col-sm-4 col-form-label">Payment Terms <i class="text-danger">*</i></label>
                              <div class="col-sm-8">
                                 <select   name="pay_terms" id="payment_terms" style="width:100%;border:2px solid #d7d4d6;" required="" class=" form-control"  value="<?php  echo $payment_terms; ?>"  id="payment_terms">
                                    <option value="<?php  echo $info_service[0]['payment_terms']; ?>"><?php  echo $info_service[0]['payment_terms']; ?></option>
                                  	<?php
											foreach(PAYMENT_TYPE as $payment_typ){
												echo '<option value="'.$payment_typ.'">'.$payment_typ.'</option>';
											}
											?>
                                 
                                 </select>
                              </div>



                           </div>
                        </div>



                        <div class="col-sm-6">
                           <div class="form-group row">
                             
                           <label for="phone_num" class="col-sm-4 col-form-label">Phone Number <i class="text-danger"></i> </label>
                              <div class="col-sm-8"> <input type="number"  tabindex="2" class="form-control "  style="border:2px solid #d7d4d6;"  name="phone_num" value="<?php  echo $info_service[0]['phone_num']; ?>" id="phone_num"   /> </div>
                           </div>
                        </div>
                     </div>




                     <input type="hidden" name="serviceprovider_id" id="serviceprovider_id"  style="border:2px solid #d7d4d6;"  value="<?php echo $info_service[0]['serviceprovider_id']; ?>"  >
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group row">
                              <label for="bill_date" class="col-sm-4 col-form-label"><?php echo  display('Account Category') ;?>
                              <i class="text-danger"></i>
                              </label>
                              <div class="col-sm-8">
                                 <select id="ddl"  name="acc_cat_name" class="form-control" style="border:2px solid #d7d4d6;"  onchange="configureDropDownLists(this,document.getElementById('ddl3'))">
                                            <option value="<?php echo $info_service[0]['acc_cat_name']; ?>" <?php if($info_service[0]['acc_cat_name']) { echo 'selected'; } ?>>
                                          <?php echo $info_service[0]['acc_cat_name']; ?>
                                        </option>
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
                                   <select class="form-control" name="acc_cat"  style="border:2px solid #d7d4d6;" id="ddl3">
                                       <option value="" disabled>Select Sub Category</option>
                                       <option value="<?php echo $info_service[0]['acc_cat'] ?>" <?php if($info_service[0]['acc_cat']) { echo 'selected'; } ?>>
                                          <?php echo $info_service[0]['acc_cat']; ?>
                                        </option>
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
                                 <input type="text" tabindex="2" class="form-control" name="acc_sub_name"  style="border:2px solid #d7d4d6;"  value="<?php  echo $info_service[0]['acc_sub_name']; ?>"  id="acc_sub_name" />
                              </div>
                           </div>
                        </div>
                     </div>
                        
                     <input type="hidden" name="makepaymentProvider" id="makepaymentProvider" value="<?php if($info_service[0]['payment_id']){ echo $info_service[0]['payment_id']; }?>"  >
                     <div class="table-responsive">
                        <table class="table table-bordered table-hover serviceprovider" id="service_1" style="border:2px solid #d7d4d6;" >
                           <thead>
                              <tr>
                                 <th class="text-center" width="20%">Product Name<i class="text-danger">*</i></th>
                                 <th class="text-center" width="20%">Description<i class="text-danger">*</i></th>
                                 <th class="text-center" width="20%">Quantity<i class="text-danger">*</i></th>
                                 <th class="text-center" width="20%">Amount<i class="text-danger">*</i></th>
                                 <th class="text-center" width="20%"><?php echo display('action') ?></th>
                              </tr>
                           </thead>
                           <tbody id="servic_pro">
                              <?php $cnt=1;
                                 $n=0;
                                 
                                 foreach($info_service as $di){ 
                                   ?> 
                              <tr>
                                 <td class="span3 supplier">
                                    <select  name="product_name[]"  id="product_name_<?php echo $cnt.$n; ?>"  class="form-control " required=""     tabindex="1">
                                        <option value="<?php echo $di['productname'];  ?>"><?php  echo $di['productname'];  ?></option>    
                                       <?php foreach($product_list as $tx){ ?>
                                       <option value="<?php echo $tx['product_name'].'-'.$tx['product_model']; ; ?>"><?php echo $tx['product_name'].'-'.$tx['product_model']; ; ?></option>
                                       <?php    }?>
                                    </select>
                                 </td>
                                 <td class="text-right"> <input type="text" name="description_service[]" id="description_<?php echo $cnt.$n; ?>" class="form-control text-right store_cal_1" placeholder="" value="<?php  echo $di ['description'];  ?>" tabindex="6" /> </td>
                                 <td class="wt"> <input type="text" name="quality[]" id="quality_<?php echo $cnt.$n; ?>" min="0" class="form-control text-right store_cal_1" value="<?php  echo $di['quality'];  ?>" placeholder="" value="" tabindex="6" /> </td>
                                 <td> <span class="input-symbol-euro"><input  style="width: 100%;" class="total_price form-control" type="text" name="total_price[]" id="total_price_<?php echo $cnt.$n; ?>" value="<?php  echo $di['total_price'];  ?>" /> </td>
                                 <td style="text-align:center;"> <button class='delete btn btn-danger' type='button' value='Delete'><i class="fa fa-trash"></i></button> </td>
                              </tr>
                              <?php $cnt++; $n++; } ?>
                           </tbody>
                          <tfoot>
                                       <tr style="height:50px;">
                                          <td style="text-align:right;" colspan="3" ><b><?php echo display('total') ?>:</b></td>
                                          <td style="text-align:left;">
                                          <input type="text" id="Total_provider" style='width:300px;' class="form-control mobile_price" placeholder="0.00"   min="0" name="total" value="<?php echo $info_service[0]['total']; ?>" /> 
                                          </td>
                                       </tr>
                                      <table class="taxtab table table-bordered table-hover" style="border:2px solid #d7d4d6;" >
                        <tr>
                           <td class="hiden" style="width:20%;border:none;text-align:end;font-weight:bold;">
                              <?php echo display('Live Rate') ?> :
                           </td>
                           <td class="hiden btnclr" style="width:13%;text-align-last: center;padding:5px; border:none;font-weight:bold;color:white;">1 <?php echo $curn_info_default; ?>
                              = <input style="width: 80px;text-align:center;color:black;padding:5px;" id="custocurrency_rate_provider" type="text" class="custocurrency_rate_provider"/>&nbsp;<label for="custocurrency"  ></label>
                           </td>
                           <td style="border:none;text-align:right;font-weight:bold;"><?php echo display('Tax') ?> :
                           </td>
                           <td style="width:12%">
                           <input list="magic_tax" name="tx"  id="product_tax_provider" class="form-control"  value="<?php echo $t; ?>" onchange="this.blur();" />
                              <datalist id="magic_tax">
                                 <?php
foreach ($expensetax as $tx) {?>
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
              </td>
            <!-- Right Side -->
            <td style="width: 40%; padding-left: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="tax_details"><b><?php echo display('TAX DETAILS') ?> :</b></label>
                <input type="text" id="tax_details_provider" name="tax_details" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" value="<?php echo $info_service[0]['tax_detail']; ?>" readonly="readonly" />
          
            </td>
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                 </td>
            <!-- Right Side -->
          
                <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
              <label style="width:150px;" for="gtotal"><b><?php echo display('GRAND TOTAL') ?> :</b></label>
                <input type="text" id="gtotal_provider" name="gtotal" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" value="<?php echo $info_service[0]['gtotals']; ?>" readonly="readonly" />
            </td>
         
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                 </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                  <label style="width:150px;" for="customer_gtotal"><b><?php echo display('Preferred Currency') ?> :</b></label>
                <input type="text" id="customer_gtotal_provider" name="customer_gtotal" class="form-control" value="<?php echo $info_service[0]['gtotal_preferred_currency']; ?>" style="width: 150px; margin-left: 10px; display: inline-block;" readonly />
          </td>
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="amount_paid"><b><?php echo display('Amount Paid') ?> :</b></label>
                <input type="text" id="amount_paid_provider" name="amount_paid" class="form-control" value="<?php echo $info_service[0]['amount_paids']; ?>"  style="width: 150px; margin-left: 10px; display: inline-block;" readonly />
         </td>
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
             </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="balance"><b><?php echo display('Balance Amount') ?> :</b></label>
                <input type="text" id="balance_provider" name="balance" class="form-control" value="<?php echo $info_service[0]['balances']; ?>" style="width: 150px; margin-left: 10px; display: inline-block;" readonly />
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr style="border-right:none; border-left:none; border-bottom:none; border-top:none;">
            <td colspan="2" style="text-align: right; padding: 20px;">
          <?php if($info_service[0]['payment_id']==''){ ?>
              <a class="client-add-btn btn btnclr" aria-hidden="true" id="paypls_provider" data-toggle="modal" data-target="#payment_modal">
                        Make Payment
             </a>
             <?php  }   ?>
            </td>
        </tr>
    </tfoot>
</table>
                     </div>
                     <div class="form-group row">
                        <label for="remarks" class="col-sm-2 col-form-label">Memo / Details</label>
                        <div class="col-sm-8"> <textarea rows="4" cols="50" name="memo_details" style="border:2px solid #d7d4d6;"   class=" form-control" placeholder="Memo/Details" id="" ><?php echo $info_service[0]['memo_details']; ?></textarea> </div>
                     </div>
                     <td>
                        <input type="submit" id="add-supplier-from-expense" name="add-supplier-from-expense"  class="btnclr btn" value="<?php echo display('save') ?>">
                        <a     id="final_submit_provider" class='btnclr final_submit_provider btn  '><?php echo display('submit'); ?></a>
                        <a id="download_provider"          class='btn btnclr'><?php  echo  display('download'); ?></a>
                        <a id="print_provider"          class='btn btnclr'><?php  echo  display('print'); ?></a>                   
                     </td>
                  </form>
               </div>
            </div>
        <input type="hidden" id="Final_invoice_number" /> 
<input type="hidden" id="Final_invoice_id" /> 
         </div>
      </div>
</div>
</div>
</div> 
</section>

<!-- Invoice Report End -->
<div class="modal fade" id="payment_history_modal" role="dialog">
   <div class="modal-dialog" style="margin-right: 1100px;">
      <!-- Modal content-->
      <div class="modal-content" style="width: 1500px;margin-top: 190px;text-align:center;">
         <div class="modal-header btnclr">
            <button type="button" id="history_close" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?php echo display('PAYMENT HISTORY') ?></h4>
         </div>
         <div class="modal-body1">
            <form id='bulk_payment_form' action="<?php echo base_url(); ?>Cpurchase/bulk_payment_ser_pro" method="post">
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

<script>
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
                 $("#custocurrency_rate_provider").html(result[0]['currency_type']);
                 $("#autocomplete_supplier_id").val(result[0]['supplier_id']);
                 $("label[for='custocurrency']").html(result[0]['currency_type']);
              
                $.getJSON('https://open.er-api.com/v6/latest/<?php echo $curn_info_default; ?>', 
         function(data) {
          var custo_currency=result[0]['currency_type'];
             var x=data['rates'][custo_currency];
          var Rate =parseFloat(x).toFixed(3);
          Rate = isNaN(Rate) ? 0 : Rate;
           console.log(Rate);
           $('.hiden').show();
           $(".custocurrency_rate_provider").val(Rate);
         });
               
                 }
             });
   
   $('#download_provider').hide();
   $('#final_submit_provider').hide();
   $('#print_provider').hide();
   
   
   
   });
  $("#serviceprovider").validate({
   rules: {
    service_provider_name: "required",
    bill_date: "required", 
    payment_terms : "required", 
    bill_num : "required",
   },
 messages: {
     service_provider_name: "Service Provider Name is required",
    bill_date: "Bill Date is required",
    bill_num: "Bill Number is required",
    payment_terms: "Payment Terms is required",
},
    errorPlacement: function(error, element) {
            if (element.hasClass("select2-hidden-accessible")) {
                error.insertAfter(element.next('span.select2')); // Place error message after the Select2 element
            } else {
                error.insertAfter(element);
            }
        },
submitHandler: function(form) {
      $('#download_provider').show();
   $('#final_submit_provider').show();
   $('#print_provider').show();
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
        alert('An error occurred: ' + error);
    }
  })
}
});
   $(document).on('keyup','.serviceprovider tbody tr:last',function (e) {
 
   var tid=$(this).closest('table').attr('id');
   const indexLast = tid.lastIndexOf('_');
   var id = tid.slice(indexLast + 1);
   var $last = $('#servic_pro  tr:last');
   var num = id+($last.index()+1);
   $('#servic_pro tr:last').clone().find('input').attr('id', function(i, current) {
   return current.replace(/\d+$/, num);
   }).end().appendTo('#servic_pro');
   var sum = 0;
   $(".total_price").each(function() {
   if(!isNaN(this.value) && this.value.length!=0) {
   sum += parseFloat(this.value);
   }
   });
   $("#Total_provider").val(sum.toFixed(2));

   $("#gtotal_provider").val(sum.toFixed(2));
   $("#customer_gtotal_provider").val(sum.toFixed(2));

   });
 $(document).on('click', '.delete', function(){
   
   $(this).closest('tr').remove();
   
   
   });
   
   
   
   

   
      $('#final_submit_provider').on('click', function (e) {
    var input_hdn='Your Invoice No : "'+ $('#Final_invoice_number').val()+" has been Updated Successfully";
 $('#errormessage_service_provider').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + input_hdn + '</div>');
   window.setTimeout(function(){
      window.location = "<?php  echo base_url(); ?>Cpurchase/manage_purchase?id=<?php echo $_GET['id']; ?>";
     }, 2000);
   });
 

   function payment_info(){
      
      var data = {
           gtotal:$('#vendor_gtotalss').val(),   
        };
        data[csrfName] = csrfHash;
    
        $.ajax({
            type:'POST',
            data: data, 
         dataType:"json",
            url:'<?php echo base_url();?>Cinvoice/get_payment_info',
            success: function(result, statut) {
               
               
               var amt= parseInt(result[0]['amt_paid'])
   
   
              $("#amount_paids").val(result[0]['amt_paid']);
              $("#balances").val(result[0]['balance']);
                console.log(result);
            }
        });
    }
    
   
   
   
    
    $('#payment_from_modals').on('input',function(e){
    var payment=parseInt($('#payment_from_modals').val());
    var amount_to_pay=parseInt($('#amount_to_pays').val());
    console.log(payment+"/"+amount_to_pay);
    console.log(parseInt(amount_to_pay)-parseInt(payment));
    var value=parseInt(amount_to_pay)-parseInt(payment);
    $('#balance_modals').val(value);
    if (isNaN(value)) {
     $('#balance_modals').val("0");
      }
    });
   
   
   
   // $('#add_payment_infos').submit(function (event) {    
   //    var dataString = {
   //        dataString : $("#add_payment_infos").serialize()
   //   };
   //   dataString[csrfName] = csrfHash;
    
   //    $.ajax({
   //        type:"POST",
   //        dataType:"json",
   //        url:"<?php echo base_url(); ?>Cinvoice/add_payment_infos",
   //        data:$("#add_payment_infos").serialize(),
   
   //        success:function (data) {
   //  $('.amt').show();
   
   //     $('#service_payment_modal').modal('hide');
   //     $("#bodyModal1").html("<?php echo display('Payment Successfully Completed');?>");
   //        $('#myModal1').modal('show');
   //        var b=$('#balance_modals').val();
   //        var a=$('#payment_from_modals').val();
   //     $('#balances').val(b);
   //     $('#amount_paids').val(a);
   //     window.setTimeout(function(){
   //         $('#myModal1').modal('hide');
   // },2500);
   
   
   
   
   //    var dataString = {
   //        dataString : $("#histroy").serialize()
      
   //   };
   //   dataString[csrfName] = csrfHash;
    
   //    $.ajax({
   //        type:"POST",
   //        dataType:"json",
   //        url:"<?php echo base_url(); ?>Cpurchase/payment_history_purchase_serv_provider",
   //        data:$("#histroy").serialize(),
   
   //        success:function (data) {
   //         console.log(data);
   //         var gt=$('#vendor_gtotalss').val();
   //         var amtpd=data.amt_paid;
   //         console.log(data);
   //         var bal= $('#vendor_gtotalss').val() - data.amt_paid;
   //  $('#balance').val(bal);
   //    $('#amount_paid').val(amtpd);
   //       var t_rate=$('.custocurrency_rate').val();
   //    document.getElementById("paid_convert").value=
   //  	(amtpd /t_rate ).toFixed(2);
   //     document.getElementById("bal_convert").value=
   //  	(bal /t_rate ).toFixed(2);
   
   //       }
   //     });
   //       $('#add_payment_info')[0].reset();
   //       }
   
   //    });
   //    event.preventDefault();
   // });
                  
   
   
   
   
   
   
   
   
   function paypls(){
       
   $('#amount_to_pay').val($('#vendor_gtotalss').val()-$('#amount_paid').val());
       $('#payment_modal').modal('show');
   
   }
   
   $(document).ready(function() {
    $(document).on('click', '#pay_now', function(event) {
        event.preventDefault(); 
        var formData = $('#bulk_payment_form').serialize();
        formData += '&' + csrfName + '=' + csrfHash; 
        $.ajax({
            type: 'POST',
            data: formData, 
            dataType: 'json',
            url: $('#bulk_payment_form').attr('action'), 
            success: function(response) {
               debugger;
                    if (response.status == 'success') {

        payment_update();
         $('#payment_error').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + 'Payment Details Updated Successfully' + '</div>');
        window.setTimeout(function() {
                  location.reload(); 
                }, 2000);   
      }else{
             $('#payment_error').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + 'Failed to Update.Try Again..' + '</div>');
    
          }
          
      
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
             gtotal : $('#customer_gtotal_provider').val(),
              t_amt_paid : $('#tl_amt_pd').val(),
            t_bal_amt : $('#my_bal_1').val(),
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
        url: "<?php echo base_url(); ?>Cinvoice/payment_edit_serv_pro",
        data: postData,
        success: function (response) {
          if (response.status == 'success') {
        payment_update();
         $('#payment_error').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + 'Payment for the Current Bill is Updated Successfully' + '</div>');
        window.setTimeout(function() {
                  location.reload(); 
                }, 2000);   
      }else{
             $('#payment_error').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + 'Failed to Update.Try Again..' + '</div>');
    
          }
      },
        error: function (error) {
           $('#payment_error').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + 'Failed to Updated.Try Again..' + '</div>');
        }
    });
  
    event.preventDefault();
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
            var gt=$('#customer_gtotal_provider').val();
            var amtpd=parseFloat(data.amt_paid);
            if (isNaN(amtpd) || amtpd === '') {
    amtpd = 0.00;
}
            console.log(data);
            var bal= gt - amtpd;
    if(amtpd){
    $('#amount_paid_provider').val(amtpd.toFixed(2));
    }else{
       $('#amount_paid_provider').val("0.00"); 
    }
    $('#balance_provider').val(bal.toFixed(2));
    $('#amount_to_pay').val(bal.toFixed(2));
     }
       });
       event.preventDefault();
         }
 $(document).ready(function(){
        payment_update();
    });
   $('#payment_history').click(function (event) {
        $('#current_in_id').val($('#bill_number').val());
    var dataString = {
        dataString: $("#histroy").serialize()
    };
    dataString[csrfName] = csrfHash;
    $.ajax({
        type: "POST",
        dataType: "json",
       url:"<?php echo base_url(); ?>Cpurchase/payment_history_purchase_serv_provider",
        data: $("#histroy").serialize(),
        success: function (data) { 
   var basedOnCustomer = data.based_on_customer;
   var overallGTotal = parseFloat(data.overall[0].overall_gtotal);
   var overall_due = parseFloat(data.overall[0].overall_due);
   var overall_paid = parseFloat(data.overall[0].overall_paid);
   console.log("OVER : "+overallGTotal);
   var gt = $('#customer_gtotal_provider').val();
                    var amtpd = data.amt_paid;
            var bal = $('#customer_gtotal_provider').val() - data.amt_paid;
            var total = "<table id='table2' class='newtable table table-striped table-bordered'><tbody><tr><td rowspan='2' style='vertical-align: middle;text-align-last: center;'><b>Grand Total :  <?php  echo $currency;  ?>"+$('#customer_gtotal_provider').val()+"<b></td>                       <td class='td' style='text-align:end;border-right: hidden;'><b>Total Amount Paid :<b></td>       <td style='text-align:start;'><?php  echo $currency;  ?><span class='amt_paid_update'><input type='text' id='tl_amt_pd' value='"+data.amt_paid+"' name='tl_amt_pd'/></span></td>            <td><input type='hidden' value='"+$('#customer_gtotal_provider').val()+"' name='t_unique'/><span style='font-weight:bold;'>INVOICE NO</span> :<input type='hidden' id='unq_inv' value='"+$('#bill_number').val()+"' name='unq_inv'/>"+$('#bill_number').val()+"</td>     <td rowspan='2' style='vertical-align: middle;text-align-last: center;'><b>Advance :   <input type='text' name='advanceamount' id='advanceamount' readonly ></td>                                         </tr><tr><td class='td' style='text-align:end;'><b>Balance :<input type='text' id='my_bal_1' value='"+bal+"' name='my_bal_1'/><b></td><td class='due_pay' style='display:none;' id='balance-cell' data-currency='<?php  echo $currency;  ?>'>"+bal +"</td><td  data-currency='<?php echo $currency; ?>'><span style='font-weight:bold;'>Amount to Pay : </span><input type='text' id='amount_pay_unique' class='amount_pay' style='text-align:center;' readonly  name='amount_pay_1'/></td><td style='display:none'><input type='text'  value='<?php if($info_service[0]['payment_id']){ echo $info_service[0]['payment_id']; }else{ echo $payment_id_new;}?>' name='payment_id' class='payment_id_val' id='payment_id'/></td><td style='display:none' class='' data-currency='<?php echo $currency; ?>'><input type='text' name='updated_bal_uniq' class='balance-col'/></td><td> <input type='text' id='total-amount' placeholder='Enter Amount To Distribute' ></td> </tr></tbody></table>"
               var table_header1 = "<div></div>  <thead><tr><td ><input type='hidden'  value='<?php echo $info_service[0]['customer_id'];  ?>' name='customer_id' /></tr></thead><tbody>";
             var table_header = "<div class='toggle-button' onclick='toggleTable()'>Payment History &#9660;</div><table id='toggle_table' class='table table-striped table-bordered'><thead style='FONT-WEIGHT:BOLD;'><tr><td style='display:none;'><input type='text'  value='<?php if($info_service[0]['payment_id']){ echo $info_service[0]['payment_id']; }else{ echo $payment_id_new;}?>' name='payment_id_this_invoice' class='payment_id_val' id='payment_id_this_invoice'/></td><td>Payment Date</td><td>Reference.NO</td><td>Bank Name</td><td>Amount Paid</td><td>Balance</td><td>Details</td> </tr></thead><tbody>";
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
    "<td style='display:none;'>" +
    "<input type='hidden' value='<?php if($info_service[0]['payment_id']){ echo $info_service[0]['payment_id']; }else{ echo $payment_id_new;}?>' name='payment_id' class='pay_id' id='payment_id'/></td>" +
    +  "</tr>";
                  count++;
            });
                var all = total + table_header + html + table_footer +table_header1;
             var total1 = "<input type='hidden' name='<?php echo $this->security->get_csrf_token_name();?>' value='<?php echo $this->security->get_csrf_hash();?>'><table id='table1'  class='table table-striped table-bordered'><tr><td colspan='3' style='border-top: hidden!important;background-color: white;text-align:center;font-weight:bold;font-size:18px;'>LIST OF DUE INVOICES</td></tr><tr><td rowspan='2' style='vertical-align: middle;text-align-last: center;'><b>Grand Total :  <?php  echo $currency;  ?>"+overallGTotal.toFixed(2)+"<b></td><td class='td' style='text-align:center;border-right: hidden;'><b>Total Amount Paid :<b></td><td style='text-align:justify'><?php  echo $currency;  ?>"+overall_paid.toFixed(2)+"</td></tr></tr><td class='td' style='border-right: hidden;'><b>Balance :<b></td><td style='text-align:start;' id='balance-cell'  class='bcm'   data-currency='<?php  echo $currency;  ?>'>"+parseFloat(overall_due.toFixed(2)) +"</td></tr></table>"
               var table_header1='';
         var table_footer1='';
            if (basedOnCustomer && basedOnCustomer.length > 0) {
    table_header1 = "<table class='newtable-second table table-striped table-bordered'><thead style='FONT-WEIGHT:BOLD;'><tr><td><div id='distribute-container'> </div></td><td style='width:60px;'>Invoice No</td><td style='width:100px;'>Total Amount</td><td style='width:200px;'>Amount Paid</td><td style='width:200px;'>Balance</td><td style='width:200px;'>Amount to Pay</td><td class='balance-column' style='width:200px;'>Updated Balance</td></tr></thead><tbody>";
    table_footer1 = "</tbody><tfoot><tr><td colspan='5'></td><td class='t_amt_pay'></td><td  style='display:none;' class='balance-col t_bal_pay'></td></tr></tfoot></table>";
   } else {
   
    table_header1 = "<div style='font-size:larger;text-align:center;'><b>No Dues</b>  &#x1F60A;</div>";
   }
             var html1 = "";
             debugger;
            var increment = 1;
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
            html1 += "<tr><td style='display:none;'><input type='hidden' value='"+random10DigitNumber+"' name='payment_id[]'/></td><td> <input type='checkbox' id='"+increment+"' class='checkbox-distribute'></td><td><input type='text' readonly style='text-align:center;'  value='" + element.bill_number + "' name='invoice_no[]'/></td><td><input type='text' readonly  class='g_pament' value='" + element.gtotals + "' name='total_amt[]' style='text-align:center;'/></td><td>" + element.amount_paids + "</td><td class='due_pay' data-currency='<?php echo $currency; ?>'>" + element.balances + "</td><td  data-currency='<?php echo $currency; ?>'><input type='text' id='amount_pay' class='amount_pay' style='text-align:center;' name='amount_pay[]'/></td><td    class='balance-column' data-currency='<?php echo $currency; ?>'><input type='text' name='updated_bal[]' readonly class='balance-col'/></td></tr>";
            increment++;
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
      debugger;
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
   var gtotal=$('#customer_gtotal_provider').val();
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
        var payment_id = "<?php if($info_service[0]['payment_id']){ echo $info_service[0]['payment_id']; }else{ echo $payment_id_new;}?>";
    
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



<script type="text/javascript">
   function configureDropDownLists(ddl1,ddl3) {
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
   ddl3.options.length = 0;
   for (i = 0; i < assets.length; i++) {
   createOption(ddl3, assets[i], assets[i]);
   }
   break;
   case 'RECEIVABLES':
   ddl3.options.length = 0;
   for (i = 0; i < receivables.length; i++) {
   createOption(ddl3, receivables[i], receivables[i]);
   }
   break;
   case 'INVENTORIES':
   ddl3.options.length = 0;
   for (i = 0; i < inventories.length; i++) {
   createOption(ddl3, inventories[i], inventories[i]);
   }
   break;
   case 'PREPAID EXPENSES & OTHER CURRENT ASSETS':
   ddl3.options.length = 0;
   for (i = 0; i < prepaid_expense.length; i++) {
   createOption(ddl3, prepaid_expense[i], prepaid_expense[i]);
   }
   break;
   case 'PROPERTY PLANT & EQUIPMENT':
   ddl3.options.length = 0;
   for (i = 0; i < property_plant.length; i++) {
   createOption(ddl3, property_plant[i], property_plant[i]);
   }
   break;
   case 'ACCUMULATED DEPRECIATION & AMORTIZATION':
   ddl3.options.length = 0;
   for (i = 0; i < acc_dep.length; i++) {
   createOption(ddl3, acc_dep[i], acc_dep[i]);
   }
   break;
   case 'NON – CURRENT RECEIVABLES':
   ddl3.options.length = 0;
   for (i = 0; i < noncurrenctreceivables.length; i++) {
   createOption(ddl3, noncurrenctreceivables[i], noncurrenctreceivables[i]);
   }
   break;
   case 'INTERCOMPANY RECEIVABLES & OTHER NON-CURRENT ASSETS':
   ddl3.options.length = 0;
   for (i = 0; i < intercompany_receivables.length; i++) {
   createOption(ddl3, intercompany_receivables[i], intercompany_receivables[i]);
   }
   break;
   case 'LIABILITIES & PAYABLES':
   ddl3.options.length = 0;
   for (i = 0; i < liabilities.length; i++) {
   createOption(ddl3, liabilities[i], liabilities[i]);
   }
   break;
   case 'ACCRUED COMPENSATION & RELATED ITEMS':
   ddl3.options.length = 0;
   for (i = 0; i < accrued_compensation.length; i++) {
   createOption(ddl3, accrued_compensation[i], accrued_compensation[i]);
   }
   break;
   case 'OTHER ACCRUED EXPENSES':
   ddl3.options.length = 0;
   for (i = 0; i < other_accrued_expenses.length; i++) {
   createOption(ddl3, other_accrued_expenses[i], other_accrued_expenses[i]);
   }
   break;
   case 'ACCRUED TAXES':
   ddl3.options.length = 0;
   for (i = 0; i < accrued_taxes.length; i++) {
   createOption(ddl3, accrued_taxes[i], accrued_taxes[i]);
   }
   break;
   case 'DEFERRED TAXES':
   ddl3.options.length = 0;
   for (i = 0; i < deferred_taxes.length; i++) {
   createOption(ddl3, deferred_taxes[i], deferred_taxes[i]);
   }
   break;
   case 'LONG-TERM DEBT':
   ddl3.options.length = 0;
   for (i = 0; i < long_term_debt.length; i++) {
   createOption(ddl3, long_term_debt[i], long_term_debt[i]);
   }
   break;
   case 'INTERCOMPANY PAYABLES & OTHER NON CURRENT LIABILITIES & OWNERS EQUITIES':
   ddl3.options.length = 0;
   for (i = 0; i < intercompany_payables.length; i++) {
   createOption(ddl3, intercompany_payables[i], intercompany_payables[i]);
   }
   break;
   case 'REVENUE':
   ddl3.options.length = 0;
   for (i = 0; i < revenue.length; i++) {
   createOption(ddl3, revenue[i], revenue[i]);
   }
   break;
   case 'COST OF GOODS SOLD':
   ddl3.options.length = 0;
   for (i = 0; i < cost_goods.length; i++) {
   createOption(ddl3, cost_goods[i], cost_goods[i]);
   }
   break;
   case 'OPERATING EXPENSES':
   ddl3.options.length = 0;
   for (i = 0; i < operating_expenses.length; i++) {
   createOption(ddl3, operating_expenses[i], operating_expenses[i]);
   }
   break;
   default:
   ddl3.options.length = 0;
   break;
   }
   }
   function createOption(ddl, text, value) {
   var opt = document.createElement('option');
   opt.value = value;
   opt.text = text;
   ddl.options.add(opt);
   }


   function generateRandom10DigitNumber() {
    // Generate a random 10-digit number
    const min = Math.pow(10, 9); // 10^9
    const max = Math.pow(10, 10) - 1; // 10^10 - 1
    const randomNumber = Math.floor(Math.random() * (max - min + 1)) + min;
    return randomNumber;
}
 
</script>