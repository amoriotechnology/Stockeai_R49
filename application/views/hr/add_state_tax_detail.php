<!-- Add new tax start -->
<?php  error_reporting(1); ?>
 <div class="content-wrapper">
   <section class="content-header" style="height:70px;">
      <div class="header-icon">
         <i class="pe-7s-note2"></i>
      </div>
      <div class="header-title">
         <h1><?php echo display('setup_tax') ?></h1>
         <ol class="breadcrumb">
            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
            <li><a href="#"><?php echo display('tax') ?></a></li>
            <li class="active" style="color:orange;"><?php echo display('add_incometax') ?></li>
         </ol>
      </div>
   </section>
   <section class="content">
      <!-- Alert Message -->
      <?php
         $message = $this->session->userdata('message');
         if (isset($message)) {
         ?>
      <div class="alert alert-info alert-dismissable" style="color:white;background-color:#38469f;">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         <?php echo $message ?>                    
      </div>
      <script>
         $('.alert').delay(1000).fadeOut('slow');
      </script>
      <?php 
         $this->session->unset_userdata('message');
         }
         $error_message = $this->session->userdata('error_message');
         if (isset($error_message)) {
         ?>
      <div class="alert alert-danger alert-dismissable" style="color:white;background-color:#38469f;">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         <?php echo $error_message ?>                    
      </div>
      <?php 
         $this->session->unset_userdata('error_message');
         }
         ?>
      <style>
         td,th{
         text-align:center;
         }
         body
         {
         counter-reset: Serial;           
         }
         table
         {
         border-collapse: separate;
         }
         tbody tr td:first-child:before
         {
         counter-increment: Serial;    
         content: counter(Serial); 
         }
         .btnclr{
       background-color:<?php echo $setting_detail[0]['button_color']; ?>;
       color: white;
   }
      </style>
      <div class="row">
         <div class="col-sm-12 col-md-12">
            <div class="panel">
            <div class="panel-heading">
                  <div class="panel-title">
                   <a style="float:right; color:white;" href="<?php echo base_url('Chrm/payroll_setting?id='.$_GET['id']) ?>" class="btnclr btn  m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('Taxes') ?> </a>
                  </div>
               </div>
 <br>
               <div class="panel-body">
                  <div id="error_display"></div>
                  <form  id="state_incometax" method="post" >    
                  <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                  <input type="hidden" name="tax_name" value="<?php echo $_GET['tax'];  ?>"/>
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                  <input type="hidden" name="encodedId" id="encodedId" value="<?php echo $_GET['id']; ?>"/>
                  <table class="table table-bordered table-hover"   id="POITable"  border="0">
                     <thead>
                        <tr class="btnclr" >
                           <th rowspan="2" style="padding-bottom: 45px;"><?php echo display('sl') ?></th>
                           <th rowspan="2" style="padding-bottom: 45px;">Employer%<strong><i class="text-danger">*</i></strong></th>
                           <th rowspan="2" style="padding-bottom: 45px;">Employee%<strong><i class="text-danger">*</i></strong></th>
                           <th rowspan="2" style="padding-bottom: 45px;">Details<strong><i class="text-danger">*</i></strong></th>
                           <th colspan="2">Single<strong><i class="text-danger">*</i></strong></th>
                           <th colspan="2">Tax filling jointly / Married<strong><i class="text-danger">*</i></strong></th>
                           <th colspan="2">Married - file separately<strong><i class="text-danger">*</i></strong></th>
                           <th colspan="2">Head of household<br>(single mom / father - have children)<strong><i class="text-danger">*</i></strong></th>
                           <th rowspan="2" style="padding-bottom: 45px;"><?php echo display('delete') ?></th>
                           <th rowspan="2" class="btnclr"  style="padding-bottom: 45px;"><?php echo display('add_more') ?></th>
                           <tr class="btnclr" >
                           <th>From</th>
                           <th>To</th>
                           <th>From</th>
                           <th>To</th>
                           <th>From</th>
                           <th>To</th>
                           <th>From</th>
                           <th>To</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php  $s=1; if($taxinfo){foreach ($taxinfo as $tax) {  ?>
                        <tr>
                           <td><input  type="hidden" class="form-control" id="row_id" value="<?php if($tax['id']){ echo $tax['id'];}else{echo "0";} ?>" /></td>
                           <td class="paddin5ps" required><input  type="text" class="form-control" id="start_amount" value="<?php if($tax['employer']){ echo $tax['employer'];}else{echo "0";} ?>" name="employer[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="end_amount" value="<?php if($tax['employee']){ echo $tax['employee'];}else{echo "0";} ?>"  name="employee[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="details"  value="<?php if($tax['details']){ echo $tax['details'];}else{echo "0";} ?>" name="details[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="single_from" value="<?php if($tax['single']){ $split=explode('-',$tax['single']); if($split[0]){ echo $split[0];}else{echo "0";}} ?>"  name="single_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="single_to" value="<?php if($tax['single']){ $split=explode('-',$tax['single']); if($split[1]){ echo $split[1];}else{echo "0";}} ?>"  name="single_to[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="tax_filling_from" value="<?php if($tax['tax_filling']){ $split=explode('-',$tax['tax_filling']); if($split[0]){ echo $split[0];}else{echo "0";}} ?>"  name="tax_filling_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="tax_filling_to" value="<?php if($tax['tax_filling']){ $split=explode('-',$tax['tax_filling']); if($split[1]){ echo $split[1];}else{echo "0";}} ?>"  name="tax_filling_to[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="married_from" value="<?php if($tax['married']){ $split=explode('-',$tax['married']); if($split[0]){ echo $split[0];}else{echo "0";}} ?>"  name="married_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="married_to" value="<?php if($tax['married']){ $split=explode('-',$tax['married']); if($split[1]){ echo $split[1];}else{echo "0";}} ?>"  name="married_to[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="head_household_from" value="<?php if($tax['head_household']){ $split=explode('-',$tax['head_household']); if($split[0]){ echo $split[0];}else{echo "0";}} ?>"  name="head_household_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="head_household_to" value="<?php if($tax['head_household']){ $split=explode('-',$tax['head_household']); if($split[1]){ echo $split[1];}else{echo "0";}} ?>"  name="head_household_to[]"  required/></td>
                           <td class="paddin5ps"><button type="button" id="delPOIbutton" class="btn btnclr getDataRow"  value="Delete" onclick="deleteTaxRow(this)"><i class="fa fa-trash"></i></button></td>
                           <td class="paddin5ps"><button type="button" id="addmorePOIbutton" style="color:white; " class="btnclr btn"  value="Add More POIs" onclick="TaxinsRow()"><i class="fa fa-plus-circle"></button></td>
                        </tr>
                        <?php $s++; }}else{  ?>
                        <tr>
                           <td></td>
                           <td class="paddin5ps" required><input  type="text" class="form-control" id="start_amount"  name="employer[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="end_amount"   name="employee[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="rate"   name="details[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="rate"   name="single_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="rate"   name="single_to[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="rate"   name="tax_filling_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="rate"   name="tax_filling_to[]"  required/></td>
                           <td><input  type="text" class="form-control" id="rate"   name="married_from[]"  required/></td>
                           <td><input  type="text" class="form-control" id="rate"   name="married_to[]"  required/></td>
                           <td><input  type="text" class="form-control" id="rate"   name="head_household_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="rate"   name="head_household_to[]"  required/></td>
                           <td class="paddin5ps"><button type="button" id="delPOIbutton" class="btn btnclr"  value="Delete" onclick="deleteTaxRow(this)"><i class="fa fa-trash"></i></button></td>
                           <td class="paddin5ps"><button type="button" id="addmorePOIbutton" style="color:white; " class="btnclr btn"  value="Add More POIs" onclick="TaxinsRow()"><i class="fa fa-plus-circle"></button></td>
                        </tr>
                        <?php $s++; }   ?>
                     </tbody>
                  </table>
                  <br>
                  <div class="form-group text-center">
                     <button type="submit" style="color:white; " class="btnclr btn w-md m-b-5"><?php echo display('setup') ?></button>
                  </div>
                  <?php //echo form_close() ?>
                        </form>
               </div>
               <script>
$('#state_incometax').submit(function (event) {
    event.preventDefault();
    var form = $(this);
    var formData = form.serialize(); 
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url(); ?>Caccounts/create_tax_setup",
        data: formData,
        success: function (response) {
    console.log(response); 
    if (response.status === 'success') {
        $('#error_display').html('<div class="alert alert-success">' + response.msg + '</div>');
        console.log(response.msg, "Success");
        window.setTimeout(function(){
              window.location = "<?php echo base_url('Chrm/payroll_setting?id='.$_GET['id']); ?>"
            },500);
    } else {
        $('#error_display').html('<div class="alert alert-danger">' + response.msg + '</div>');
        console.log(response.msg, "Error");
    }
},
        error: function (xhr, status, error) {
            $('.error_display').html('<div class="alert alert-danger">An error occurred. Please try again later.</div>');
            console.error("AJAX error:", status, error);
        }
    });
});
</script>
               <br>
 <?php  if(trim($taxinfo[0]['tax']) == trim($trimmed_tax))   { ?>
      <div class="  row">
         <div class="   col-sm-12" >
            <div class=" panel panel-default" style="border:3px solid #d7d4d6;margin-left: 15px;width: 1602px;" >
               <div class="panel-body btnclr ">
                  <div class="row">
                     <h3 class="col-sm-3" style="margin: 0;">WEEKLY PAYROLL</h3>
                     <div class="col-sm-9 text-right">                    
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>                
      <div class="panel-body">
                  <?php echo  form_open('Caccounts/weekly_create_tax_setup') ?>
                  <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                  <input type="hidden" name="tax_name" value="Weekly <?php echo $_GET['tax']; ?>"/>
                  <table class="table table-bordered table-hover"   id="POITable11"  border="0">
                     <thead> 
                        <tr class="btnclr">
                           <th rowspan="2" style="padding-bottom: 45px;"><?php echo display('sl') ?></th>
                           <th rowspan="2" style="padding-bottom: 45px;">Employer%<strong><i class="text-danger">*</i></strong></th>
                           <th rowspan="2" style="padding-bottom: 45px;">Employee%<strong><i class="text-danger">*</i></strong></th>
                           <th rowspan="2" style="padding-bottom: 45px;">Details<strong><i class="text-danger">*</i></strong></th>
                           <th colspan="2">Single<strong><i class="text-danger">*</i></strong></th>
                           <th colspan="2">Tax filling jointly / Married<strong><i class="text-danger">*</i></strong></th>
                           <th colspan="2">Married - file separately<strong><i class="text-danger">*</i></strong></th>
                           <th colspan="2">Head of household<br>(single mom / father - have children)<strong><i class="text-danger">*</i></strong></th>
                           <th rowspan="2" style="padding-bottom: 45px;"><?php echo display('delete') ?></th>
                           <th rowspan="2" class="btnclr" style="padding-bottom: 45px;"><?php echo display('add_more') ?></th>
                           <tr class="btnclr">
                           <th>From</th>
                           <th>To</th>
                           <th>From</th>
                           <th>To</th>
                           <th>From</th>
                           <th>To</th>
                           <th>From</th>
                           <th>To</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php  $w=1; if($weekly_taxinfo){foreach ($weekly_taxinfo as $weeklytax) {  ?>
                        <tr>
                           <td><input  type="hidden" class="form-control" id="row_id11" value="<?php if($weeklytax['id']){ echo $weeklytax['id'];}  ?>" /></td>
                           <td class="paddin5ps" required><input  type="text" class="form-control" id="start_amount" value="<?php if($weeklytax['employer']){ echo $weeklytax['employer'];}  ?>" name="employer[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="end_amount" value="<?php if($weeklytax['employee']){ echo $weeklytax['employee'];}  ?>"  name="employee[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="details"  value="<?php if($weeklytax['details']){ echo $weeklytax['details'];} ?>" name="details[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="single_from" value="<?php if($weeklytax['single']){ $split=explode('-',$weeklytax['single']); if($split[0]){ echo $split[0];}else{echo "0";}} ?>"  name="single_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="single_to" value="<?php if($weeklytax['single']){ $split=explode('-',$weeklytax['single']); if($split[1]){ echo $split[1];}else{echo "0";}} ?>"  name="single_to[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="tax_filling_from" value="<?php if($weeklytax['tax_filling']){ $split=explode('-',$weeklytax['tax_filling']); if($split[0]){ echo $split[0];}else{echo "0";}} ?>"  name="tax_filling_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="tax_filling_to" value="<?php if($weeklytax['tax_filling']){ $split=explode('-',$weeklytax['tax_filling']); if($split[1]){ echo $split[1];}else{echo "0";}} ?>"  name="tax_filling_to[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="married_from" value="<?php if($weeklytax['married']){ $split=explode('-',$weeklytax['married']); if($split[0]){ echo $split[0];}else{echo "0";}} ?>"  name="married_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="married_to" value="<?php if($weeklytax['married']){ $split=explode('-',$weeklytax['married']); if($split[1]){ echo $split[1];}else{echo "0";}} ?>"  name="married_to[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="head_household_from" value="<?php if($weeklytax['head_household']){ $split=explode('-',$weeklytax['head_household']); if($split[0]){ echo $split[0];}else{echo "0";}} ?>"  name="head_household_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="head_household_to" value="<?php if($weeklytax['head_household']){ $split=explode('-',$weeklytax['head_household']); if($split[1]){ echo $split[1];}else{echo "0";}} ?>"  name="head_household_to[]"  required/></td>
                           <td class="paddin5ps"><button type="button" id="delPOIbutton" class="btn btn-danger getDataRow11"  value="Delete" onclick="deleteTaxRow11(this)"><i class="fa fa-trash"></i></button></td>
                           <td class="paddin5ps"><button type="button" id="addmorePOIbutton11" style="color:white;" class="btnclr btn"  value="Add More POIs" onclick="TaxinsRow11()"><i class="fa fa-plus-circle"></button></td>
                        </tr>
                        <?php $w++; }}else{  ?>
                        <tr> 
                           <td></td>
                           <td class="paddin5ps" required><input  type="text" class="form-control" id="start_amount"  name="employer[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="end_amount"   name="employee[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="rate"   name="details[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="rate"   name="single_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="rate"   name="single_to[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="rate"   name="tax_filling_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="rate"   name="tax_filling_to[]"  required/></td>
                           <td><input  type="text" class="form-control" id="rate"   name="married_from[]"  required/></td>
                           <td><input  type="text" class="form-control" id="rate"   name="married_to[]"  required/></td>
                           <td><input  type="text" class="form-control" id="rate"   name="head_household_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="rate"   name="head_household_to[]"  required/></td>
                           <td class="paddin5ps"><button type="button" id="delPOIbutton" class="btn btn-danger"  value="Delete" onclick="deleteTaxRow11(this)"><i class="fa fa-trash"></i></button></td>
                           <td class="paddin5ps"><button type="button" id="addmorePOIbutton11" style="color:white;" class="btnclr btn" value="Add More POIs" onclick="TaxinsRow11()"><i class="fa fa-plus-circle"></button></td>
                        </tr>
                        <?php $w++; }   ?>
                     </tbody>
                  </table>
                  <br>
                  <div class="form-group text-center">
                     <button type="submit" style="color:white; " class="btnclr btn w-md m-b-5"><?php echo display('setup') ?></button>
                  </div>
                  <?php echo form_close() ?>
               </div>
               <?php  }  else {  ?>
   <?php } ?>
               <br>
               <?php  if(trim($taxinfo[0]['tax']) == trim($trimmed_tax_bi))   { ?>
<div class="row">
   <div class="col-sm-12">
      <div class="panel panel-default" style="border:3px solid #d7d4d6;margin-left:15px;width:1602px;" >
         <div class="panel-body btnclr ">
            <div class="row">
               <h3 class="col-sm-4" style="margin: 0;">BIWEEKLY PAYROLL</h3>
               <div class="col-sm-8 text-right">                    
               </div>
            </div>
         </div>
      </div>
   </div>
</div>                
<div class="panel-body">
                  <?php echo  form_open('Caccounts/biweekly_create_tax_setup') ?>
                  <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                  <input type="hidden" name="tax_name" value="BIWeekly <?php echo $_GET['tax']; ?>"/>
                  <table class="table table-bordered table-hover"   id="POITable22"  border="0">
                     <thead> 
                        <tr class="btnclr" >
                           <th rowspan="2" style="padding-bottom: 45px;"><?php echo display('sl') ?></th>
                           <th rowspan="2" style="padding-bottom: 45px;">Employer%<strong><i class="text-danger">*</i></strong></th>
                           <th rowspan="2" style="padding-bottom: 45px;">Employee%<strong><i class="text-danger">*</i></strong></th>
                           <th rowspan="2" style="padding-bottom: 45px;">Details<strong><i class="text-danger">*</i></strong></th>
                           <th colspan="2">Single<strong><i class="text-danger">*</i></strong></th>
                           <th colspan="2">Tax filling jointly / Married<strong><i class="text-danger">*</i></strong></th>
                           <th colspan="2">Married - file separately<strong><i class="text-danger">*</i></strong></th>
                           <th colspan="2">Head of household<br>(single mom / father - have children)<strong><i class="text-danger">*</i></strong></th>
                           <th rowspan="2" style="padding-bottom: 45px;"><?php echo display('delete') ?></th>
                           <th rowspan="2"  class="btnclr" style="padding-bottom: 45px;"><?php echo display('add_more') ?></th>
                        <tr class="btnclr" >
                           <th>From</th>
                           <th>To</th>
                           <th>From</th>
                           <th>To</th>
                           <th>From</th>
                           <th>To</th>
                           <th>From</th>
                           <th>To</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php  $w=1; if($biweekly_taxinfo){foreach ($biweekly_taxinfo as $biweeklytax) {  ?>
                        <tr>
                           <td><input  type="hidden" class="form-control" id="row_id22" value="<?php if($biweeklytax['id']){ echo $biweeklytax['id'];}else{echo "0";} ?>" /></td>
                           <td class="paddin5ps" required><input  type="text" class="form-control" id="start_amount" value="<?php if($biweeklytax['employer']){ echo $biweeklytax['employer'];}else{echo "0";} ?>" name="employer[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="end_amount" value="<?php if($biweeklytax['employee']){ echo $biweeklytax['employee'];}else{echo "0";} ?>"  name="employee[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="details"  value="<?php if($biweeklytax['details']){ echo $biweeklytax['details'];}else{echo "0";} ?>" name="details[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="single_from" value="<?php if($biweeklytax['single']){ $split=explode('-',$biweeklytax['single']); if($split[0]){ echo $split[0];}else{echo "0";}} ?>"  name="single_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="single_to" value="<?php if($biweeklytax['single']){ $split=explode('-',$biweeklytax['single']); if($split[1]){ echo $split[1];}else{echo "0";}} ?>"  name="single_to[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="tax_filling_from" value="<?php if($biweeklytax['tax_filling']){ $split=explode('-',$biweeklytax['tax_filling']); if($split[0]){ echo $split[0];}else{echo "0";}} ?>"  name="tax_filling_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="tax_filling_to" value="<?php if($biweeklytax['tax_filling']){ $split=explode('-',$biweeklytax['tax_filling']); if($split[1]){ echo $split[1];}else{echo "0";}} ?>"  name="tax_filling_to[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="married_from" value="<?php if($biweeklytax['married']){ $split=explode('-',$biweeklytax['married']); if($split[0]){ echo $split[0];}else{echo "0";}} ?>"  name="married_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="married_to" value="<?php if($biweeklytax['married']){ $split=explode('-',$biweeklytax['married']); if($split[1]){ echo $split[1];}else{echo "0";}} ?>"  name="married_to[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="head_household_from" value="<?php if($biweeklytax['head_household']){ $split=explode('-',$biweeklytax['head_household']); if($split[0]){ echo $split[0];}else{echo "0";}} ?>"  name="head_household_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="head_household_to" value="<?php if($biweeklytax['head_household']){ $split=explode('-',$biweeklytax['head_household']); if($split[1]){ echo $split[1];}else{echo "0";}} ?>"  name="head_household_to[]"  required/></td>
                           <td class="paddin5ps"><button type="button" id="delPOIbutton22" class="btn btn-danger getDataRow22"  value="Delete" onclick="deleteTaxRow22(this)"><i class="fa fa-trash"></i></button></td>
                           <td class="paddin5ps"><button type="button" id="addmorePOIbutton22" style="color:white;" class="btnclr btn"  value="Add More POIs" onclick="TaxinsRow22()"><i class="fa fa-plus-circle"></button></td>
                        </tr>
                        <?php $w++; }}else{  ?>
                        <tr> 
                           <td></td>
                           <td class="paddin5ps" required><input  type="text" class="form-control" id="start_amount"  name="employer[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="end_amount"   name="employee[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="rate"   name="details[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="rate"   name="single_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="rate"   name="single_to[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="rate"   name="tax_filling_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="rate"   name="tax_filling_to[]"  required/></td>
                           <td><input  type="text" class="form-control" id="rate"   name="married_from[]"  required/></td>
                           <td><input  type="text" class="form-control" id="rate"   name="married_to[]"  required/></td>
                           <td><input  type="text" class="form-control" id="rate"   name="head_household_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="rate"   name="head_household_to[]"  required/></td>
                           <td class="paddin5ps"><button type="button" id="delPOIbutton22" class="btn btn-danger"  value="Delete" onclick="deleteTaxRow22(this)"><i class="fa fa-trash"></i></button></td>
                           <td class="paddin5ps"><button type="button" id="addmorePOIbutton22" style="color:white;" class="btnclr btn" value="Add More POIs" onclick="TaxinsRow22()"><i class="fa fa-plus-circle"></button></td>
                        </tr>
                        <?php $w++; }   ?>
                     </tbody>
                  </table>
                  <br>
                  <div class="form-group text-center">
                     <button type="submit" style="color:white; " class="btnclr btn w-md m-b-5"><?php echo display('setup') ?></button>
                  </div>
                  <?php echo form_close() ?>
               </div>
                <?php  }  else {   ?>
        <?php        }?>
<br>
<?php  if(trim($taxinfo[0]['tax']) == trim($trimmed_tax_monly))   { ?>
<div class="row">
   <div class="col-sm-12">
      <div class="panel panel-default" style="border:3px solid #d7d4d6;margin-left:15px;width:1602px;" >
         <div class="panel-body btnclr">
            <div class="row">
               <h3 class="col-sm-4" style="margin: 0;">MONTHLY PAYROLL</h3>
               <div class="col-sm-8 text-right">                    
               </div>
            </div>
         </div>
      </div>
   </div>
</div>          
<div class="panel-body">
                  <?php echo  form_open('Caccounts/monthly_create_tax_setup') ?>
                  <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                  <input type="hidden" name="tax_name" value="Monthly <?php echo $_GET['tax']; ?>"/>
                  <table class="table table-bordered table-hover"   id="POITable33"  border="0">
                     <thead> 
                        <tr class="btnclr">
                           <th rowspan="2" style="padding-bottom: 45px;"><?php echo display('sl') ?></th>
                           <th rowspan="2" style="padding-bottom: 45px;">Employer%<strong><i class="text-danger">*</i></strong></th>
                           <th rowspan="2" style="padding-bottom: 45px;">Employee%<strong><i class="text-danger">*</i></strong></th>
                           <th rowspan="2" style="padding-bottom: 45px;">Details<strong><i class="text-danger">*</i></strong></th>
                           <th colspan="2">Single<strong><i class="text-danger">*</i></strong></th>
                           <th colspan="2">Tax filling jointly / Married<strong><i class="text-danger">*</i></strong></th>
                           <th colspan="2">Married - file separately<strong><i class="text-danger">*</i></strong></th>
                           <th colspan="2">Head of household<br>(single mom / father - have children)<strong><i class="text-danger">*</i></strong></th>
                           <th rowspan="2" style="padding-bottom: 45px;"><?php echo display('delete') ?></th>
                           <th rowspan="2" class="btnclr"  style="padding-bottom: 45px;"><?php echo display('add_more') ?></th>
                           <tr class="btnclr">
                           <th>From</th>
                           <th>To</th>
                           <th>From</th>
                           <th>To</th>
                           <th>From</th>
                           <th>To</th>
                           <th>From</th>
                           <th>To</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php  $w=1; if($monthly_taxinfo){foreach ($monthly_taxinfo as $monthlytax) {  ?>
                           <tr  >
                           <td><input  type="hidden" class="form-control" id="row_id33" value="<?php if($monthlytax['id']){ echo $monthlytax['id'];}else{echo "0";} ?>" /></td>
                           <td class="paddin5ps" required><input  type="text" class="form-control" id="start_amount" value="<?php if($monthlytax['employer']){ echo $monthlytax['employer'];}else{echo "0";} ?>" name="employer[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="end_amount" value="<?php if($monthlytax['employee']){ echo $monthlytax['employee'];}else{echo "0";} ?>"  name="employee[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="details"  value="<?php if($monthlytax['details']){ echo $monthlytax['details'];}else{echo "0";} ?>" name="details[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="single_from" value="<?php if($monthlytax['single']){ $split=explode('-',$monthlytax['single']); if($split[0]){ echo $split[0];}else{echo "0";}} ?>"  name="single_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="single_to" value="<?php if($monthlytax['single']){ $split=explode('-',$monthlytax['single']); if($split[1]){ echo $split[1];}else{echo "0";}} ?>"  name="single_to[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="tax_filling_from" value="<?php if($monthlytax['tax_filling']){ $split=explode('-',$monthlytax['tax_filling']); if($split[0]){ echo $split[0];}else{echo "0";}} ?>"  name="tax_filling_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="tax_filling_to" value="<?php if($monthlytax['tax_filling']){ $split=explode('-',$monthlytax['tax_filling']); if($split[1]){ echo $split[1];}else{echo "0";}} ?>"  name="tax_filling_to[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="married_from" value="<?php if($monthlytax['married']){ $split=explode('-',$monthlytax['married']); if($split[0]){ echo $split[0];}else{echo "0";}} ?>"  name="married_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="married_to" value="<?php if($monthlytax['married']){ $split=explode('-',$monthlytax['married']); if($split[1]){ echo $split[1];}else{echo "0";}} ?>"  name="married_to[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="head_household_from" value="<?php if($monthlytax['head_household']){ $split=explode('-',$monthlytax['head_household']); if($split[0]){ echo $split[0];}else{echo "0";}} ?>"  name="head_household_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="head_household_to" value="<?php if($monthlytax['head_household']){ $split=explode('-',$monthlytax['head_household']); if($split[1]){ echo $split[1];}else{echo "0";}} ?>"  name="head_household_to[]"  required/></td>
                           <td class="paddin5ps"><button type="button" id="delPOIbutton33" class="btn btn-danger getDataRow11"  value="Delete" onclick="deleteTaxRow33(this)"><i class="fa fa-trash"></i></button></td>
                           <td class="paddin5ps"><button type="button" id="addmorePOIbutton33" style="color:white;" class="btn btnclr "  value="Add More POIs" onclick="TaxinsRow33()"><i class="fa fa-plus-circle"></button></td>
                        </tr>
                        <?php $w++; }}else{  ?>
                        <tr> 
                           <td></td>
                           <td class="paddin5ps" required><input  type="text" class="form-control" id="start_amount"  name="employer[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="end_amount"   name="employee[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="rate"   name="details[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="rate"   name="single_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="rate"   name="single_to[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="rate"   name="tax_filling_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="rate"   name="tax_filling_to[]"  required/></td>
                           <td><input  type="text" class="form-control" id="rate"   name="married_from[]"  required/></td>
                           <td><input  type="text" class="form-control" id="rate"   name="married_to[]"  required/></td>
                           <td><input  type="text" class="form-control" id="rate"   name="head_household_from[]"  required/></td>
                           <td class="paddin5ps"><input  type="text" class="form-control" id="rate"   name="head_household_to[]"  required/></td>
                           <td class="paddin5ps"><button type="button" id="delPOIbutton33" class="btn btn-danger"  value="Delete" onclick="deleteTaxRow33(this)"><i class="fa fa-trash"></i></button></td>
                           <td class="paddin5ps"><button type="button" id="addmorePOIbutton33" style="color:white;" class="btn btnclr" value="Add More POIs" onclick="TaxinsRow33()"><i class="fa fa-plus-circle"></button></td>
                        </tr>
                        <?php $w++; }   ?>
                     </tbody>
                  </table>
                  <br>
                  <div class="form-group text-center">
                     <button type="submit" style="color:white;" class="btnclr btn w-md m-b-5"><?php echo display('setup') ?></button>
                  </div>
                  <?php echo form_close() ?>
               </div>
               <?php  }  else {  ?>
             <?php  }?>
            </div>
         </div>
      </div>
   </section>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
     $('body').on('click', '#addmorePOIbutton11', function() {
        var $lastRow = $('#POITable11 tbody>tr:last');
        var $newRow = $lastRow.clone(true);
        $newRow.find('input').val('');  
        $newRow.find('input[type="hidden"]').val('0');  
        $('#POITable11 tbody').append($newRow);  
    });
     $('body').on('click', '.getDataRow11', function() {
        if ($('#POITable11 tbody>tr').length > 1) {  
            $(this).closest('tr').remove();  
        } else {
            alert('At least one row must remain.');
        }
    });
});
$(document).ready(function() {
     $('body').on('click', '#addmorePOIbutton22', function() {
        var $lastRow = $('#POITable22 tbody>tr:last');
        var $newRow = $lastRow.clone(true);
        $newRow.find('input').val('');  
        $newRow.find('input[type="hidden"]').val('0');  
        $('#POITable22 tbody').append($newRow);  
    });
     $('body').on('click', '.getDataRow22', function() {
        if ($('#POITable22 tbody>tr').length > 1) {  
            $(this).closest('tr').remove();  
        } else {
            alert('At least one row must remain.');
        }
    });
});
</script>
<script>
    var csrfName = $('.txt_csrfname').attr('name'); 
    var csrfHash = $('.txt_csrfname').val();
    $('.getDataRow').on('click', function() {
      alert('Are you sure ?');
        var rowId = $(this).closest('tr').find('#row_id').val();
       $.ajax({
           url:"<?php echo base_url(); ?>Caccounts/delete_row",
           type: 'POST',
           data: {[csrfName]: csrfHash,rowId:rowId},
           success: function(data){
               console.log(data);
           }
       });
    });
    $('.getDataRow11').on('click', function() {
     alert('Are you sure ?');
     var rowId = $(this).closest('tr').find('#row_id11').val();
     $.ajax({
     url:"<?php echo base_url(); ?>Caccounts/weekly_delete_row",
     type: 'POST',
     data: {[csrfName]: csrfHash,rowId:rowId},
     success: function(data){
         console.log(data);
     }
 });
});
    $('.getDataRow22').on('click', function() {
      alert('Are you sure ?');
      var rowId = $(this).closest('tr').find('#row_id22').val();
      $.ajax({
           url:"<?php echo base_url(); ?>Caccounts/bi_weekly_delete_row",
           type: 'POST',
           data: {[csrfName]: csrfHash,rowId:rowId},
           success: function(data){
               console.log(data);
           }
       });
    });
    $('.getDataRow33').on('click', function() {
      alert('Are you sure ?');
      var rowId = $(this).closest('tr').find('#row_id33').val();
      $.ajax({
           url:"<?php echo base_url(); ?>Caccounts/monthly_delete_row",
           type: 'POST',
           data: {[csrfName]: csrfHash,rowId:rowId},
           success: function(data){
               console.log(data);
           }
       });
    });
    $(document).ready(function() {
     $('body').on('click', '#addmorePOIbutton33', function() {
        var $lastRow = $('#POITable33 tbody>tr:last');
        var $newRow = $lastRow.clone(true);
        $newRow.find('input').val('');  
        $newRow.find('input[type="hidden"]').val('0');  
        $('#POITable33 tbody').append($newRow);  
    });
     $('body').on('click', '.getDataRow33', function() {
        if ($('#POITable33 tbody>tr').length > 1) {  
            $(this).closest('tr').remove();  
        } else {
            alert('At least one row must remain.');
        }
    });
});
</script>
