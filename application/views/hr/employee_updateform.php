<script src="<?php echo base_url() ?>my-assets/js/countrypicker.js" type="text/javascript"></script>
<style>
   input::-webkit-outer-spin-button,
   input::-webkit-inner-spin-button {
   -webkit-appearance: none;
   margin: 0;
   }
    input[type=number] {
   -moz-appearance: textfield;
   }
   .select2-selection{
   display:none;
   }
   .btnclr{
   background-color:<?php echo $setting_detail[0]['button_color']; ?>;
   color: white;
   }
   .popup label{
   color:white;
   }
   .popup {
   border-top-right-radius: 20px;
   border-bottom-left-radius: 20px;
   display: none;
   position: fixed;
   top: 50%;
   left: 50%;
   transform: translate(-50%, -50%);
   border: 1px solid #000;
   padding: 20px;
   background-color: #fff;
   z-index: 9999;
   width: 90%;
   max-width: 800px;
   box-sizing: border-box;
   }
   .popup .row {
   margin-top: 10px;
   }
   .popup .col-sm-6 {
   width: 50%;
   box-sizing: border-box;
   }
   input[type=number]::-webkit-inner-spin-button, 
   input[type=number]::-webkit-outer-spin-button { 
   -webkit-appearance: none;
   -moz-appearance: none;
   appearance: none;
   margin: 0; 
   }
   .select2-selection{
   display:none;
   }
   .btnclr{
   background-color:<?php echo $setting_detail[0]['button_color']; ?>;
   color: white;
   }
   .ui-selectmenu-text{
   display:none;
   }
   .fg {
   display: flex;
   flex-direction: row;
   justify-content: space-between;
   align-items: center;
   margin-bottom: 15px;
   }
   .fg label {
   width: 40%; 
   }
   .fg input {
   width: 60%;  
   }
</style>
<div class="content-wrapper">
   <section class="content-header">
      <div class="header-icon">
         <i class="pe-7s-note2"></i>
      </div>
      <div class="header-title">
         <h1><?php echo ('Edit Employee') ?></h1>
         <small></small>
         <ol class="breadcrumb">
            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
             <li class="active" style="color:orange;"><?php echo ('Edit Employee') ?></li>
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




      <!-- New Employee Type -->
      <div class="row">
         <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
               <div class="panel-heading" style="height: 50px;">
                  <div class="panel-title">
                  <a   style="float:right;color:white;"  href="<?php echo base_url('Chrm/manage_employee') ?>?id=<?php echo $_GET['id']; ?>"
                                    class="btnclr btn"><i class="ti-align-justify"> </i>
                                    <?php echo  ('Manage Employee') ?> </a>
                  </div>
               </div>
               <div class="panel-title">
                </div>
               <div class="panel-body">


                   <?php if (!$employee_data[0]['sales_partner'] == 'Sales_Partner') { ?>

               <div class="errormessage"></div>


               <form id="update_employee" name="update_employee" method="post" enctype="multipart/form-data" >
 
                    <!-- <form id="update_employee" > -->
                    <div class="row">
                     <!-- Left Side -->
                     <div class="col-sm-6">
                        <div class="form-group row">
                           <label for="first_name" class="col-sm-4 col-form-div"><?php echo display('first_name') ?> <i class="text-danger">*</i></label>
                           <div class="col-sm-8">
                              <input name="first_name" class="form-control" type="text" placeholder="<?php echo display('first_name') ?>" id="first_name" value="<?php echo html_escape($employee_data[0]['first_name'])?>" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">
                              <input type="hidden" name="employee_id" value="<?php echo html_escape($employee_data[0]['id']);?>">
                              <input type="hidden" name="old_first_name" value="<?php echo html_escape($employee_data[0]['first_name'])?>">
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="middle_name" class="col-sm-4 col-form-div"><?php echo "Middle Name"; ?></label>
                           <div class="col-sm-8">
                              <input name="middle_name" class="form-control" type="text" placeholder="<?php echo "Middle Name"; ?>" value="<?php echo html_escape($employee_data[0]['middle_name'])?>" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">
                              <input type="hidden" name="old_middle_name" value="<?php echo html_escape($employee_data[0]['middle_name'])?>">
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="last_name" class="col-sm-4 col-form-div"><?php echo display('last_name') ?><i class="text-danger">*</i></label>
                           <div class="col-sm-8">
                              <input name="last_name" class="form-control" type="text" placeholder="<?php echo display('last_name') ?>" id="last_name" value="<?php echo html_escape($employee_data[0]['last_name'])?>" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">
                              <input type="hidden" name="old_last_name" value="<?php echo html_escape($employee_data[0]['last_name'])?>">
                           </div>
                        </div>
                        <div class="form-group row" id="payment_from_1">
                           <label for="designation" class="col-sm-4 col-form-label"> <?php echo display('designation') ?> <i class="text-danger">*</i> </label>
                           <div class="col-sm-8">
                              <select name="designation" id="designation" class="form-control"  >
                                 <option value="<?php echo html_escape($employee_data[0]['designation'])?>"><?php echo html_escape($employee_data[0]['designation'])?></option>
                                 <?php  foreach($desig as $ds){ ?>
                                 <option value="<?php  echo $ds['designation'] ;?>"><?php  echo $ds['designation'] ;?></option>
                                 <?php  } ?>
                              </select>
                           </div>
                        </div>
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                        <div class="form-group row">
                           <label for="phone" class="col-sm-4 col-form-div"><?php echo display('phone') ?> <i class="text-danger">*</i></label>
                           <div class="col-sm-8">
                           
                           <input class="form-control" name="phone" id="mobile" type="tel" style="border: 2px solid #d7d4d6;" value="<?php echo html_escape($employee_data[0]['phone'])?>"     tabindex="3" oninput="formatPhoneNumber(this)">

                        </div>
                        </div>
                        <div class="form-group row">
                           <label for="Profile Image" class="col-sm-4 col-form-label">
                           Email 
                           </label>
                           <div class="col-sm-8">
                              <input name="email" class="form-control" type="email" placeholder="<?php echo display('email') ?>" id="email" value="<?php echo html_escape($employee_data[0]['email'])?>" oninput="validateEmail(this)">
                              <span id="validateemails" style="margin-top: 10px;"></span>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="address_line_1" class="col-sm-4 col-form-div"><?php echo display('address_line_1') ?></label>
                           <div class="col-sm-8">
                              <textarea name="address_line_1" rows='1' class="form-control" placeholder="<?php echo display('address_line_1') ?>" id="address_line_1"><?php echo html_escape($employee_data[0]['address_line_1'])?></textarea> 
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="address_line_2" class="col-sm-4 col-form-div"><?php echo display('address_line_2') ?></label>
                           <div class="col-sm-8">
                              <textarea name="address_line_2" rows='1' class="form-control" placeholder="<?php echo display('address_line_2') ?>" id="address_line_2"><?php echo html_escape($employee_data[0]['address_line_2'])?></textarea> 
                           </div>
                        </div>
                        <div class="form-group row" id="payment_from">
                           <label for="city" class="col-sm-4 col-form-div"><?php echo display('city') ?></label>
                           <div class="col-sm-8">
                              <input name="city" class="form-control" type="text" placeholder="<?php echo display('city') ?>" id="city" value="<?php echo html_escape($employee_data[0]['city']);?>" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">
                           </div>
                        </div>

                        <input name="salespartner" class="form-control" type="hidden"  id="salespartner" value="<?php echo html_escape($employee_data[0]['sales_partner']);?>"  >

                        <div class="form-group row">
                           <label for="state" class="col-sm-4 col-form-label"><?php  echo  display('state');?> <i class="text-danger"></i></label>
                           <div class="col-sm-8">
                              <input name="state" class="form-control" type="text" placeholder="<?php echo display('state') ?>" id="state" value="<?php echo html_escape($employee_data[0]['state']);?>" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="zip" class="col-sm-4 col-form-div"><?php echo display('zip') ?></label>
                           <div class="col-sm-8">
                              <input name="zip" class="form-control" type="text" placeholder="<?php echo display('zip') ?>" id="zip" value="<?php echo html_escape($employee_data[0]['zip']);?>" oninput="exitnumbers(this, 10)">
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="country" class="col-sm-4 col-form-div"><?php echo display('country') ?></label>
                           <div class="col-sm-8">
                           <select class="selectpicker countrypicker form-control"
                                        style="width:100%;border: 2px solid #d7d4d6;" data-live-search="true"
                                        data-default="United States" name="country" id="country" value="<?php echo $employee_data[0]['country'];?>" >
                           </select>
                           </div>
                        </div>

 

                        <div class="form-group row">
                           <label for="emergencycontact" class="col-sm-4 col-form-label"> <?php echo "Emergency Contact Person" ?> </label>
                           <div class="col-sm-8">
                              <input class="form-control" name="emergencycontact" id="emergencycontact" type="text"  style="border:2px solid #D7D4D6;"   placeholder="Emergency Contact Person" value="<?php echo html_escape($employee_data[0]['emergencycontact'])?>"  oninput="limitAlphabetical(this, 20)">
                           </div>
                        </div>



                        <div class="form-group row">
                           <label for="emergencycontactnum" class="col-sm-4 col-form-label"> <?php echo "Emergency Contact Number" ?> </label>
                           <div class="col-sm-8">
                              <input class="form-control" name="emergencycontactnum" id="emergencycontactnum" type="number"  style="border:2px solid #D7D4D6;"   placeholder="Emergency Contact Number" value="<?php echo html_escape($employee_data[0]['emergencycontactnum'])?>"  oninput="exitnumbers(this, 10)">
                           </div>
                        </div>
                     </div>

                     <!-- Right Side -->
  
                     <div class="col-sm-6">
                        <div class="form-group row" id="payment_from">
                        <label for="employee_type" class="col-sm-4 col-form-label">Employee Type <i class="text-danger">*</i></label>
                        <div class="col-sm-8">
                              <select  name="employee_type" id="emp_type" class=" form-control" >
                                 <option value="<?php echo html_escape($employee_data[0]['employee_type'])?>"><?php echo html_escape($employee_data[0]['employee_type'])?></option>
                                 <option value="Full Time (W4)">Full Time (W4)</option>
                                 <option value="Contractor (W9)">Contractor (W9)</option>
                                 <option value="Part time">Part time</option>
                                 <?php foreach($emp_data as $emp_type){ ?>
                                 <option value="<?php  echo $emp_type['employee_type'] ;?>"><?php  echo $emp_type['employee_type'] ;?></option>
                                 <?php  } ?>
                              </select>
                           </div>
                        </div>


                        <div class="form-group row">
                        <label for="city" class="col-sm-4 col-form-div"><?php echo  ('Sales Commission') ?></label>
                        <div class="col-sm-8">
                        <input name="sc" class="form-control" type="text" value="<?php echo html_escape($employee_data[0]['sc']);?>" placeholder="<?php echo 'Sales Commission' ?>"  oninput="exitsalecommission(this, 2)">
                        </div>
                        </div>
               
                     <div class="form-group row" id="payment_from">
                           <label for="payroll_type" class="col-sm-4 col-form-label"> Payroll Type <i class="text-danger">*</i></label>
                           <div class="col-sm-8">
                              <select  name="payroll_type" id="payroll_type"    class="form-control" >
                                 <option value="<?php echo html_escape($employee_data[0]['payroll_type'])?>"><?php echo html_escape($employee_data[0]['payroll_type'])?></option>
                                 <option value="Hourly">Hourly</option>
                                 <option value="Salaried-weekly">Salaried-Weekly</option>
                                 <option value="Salaried-BiWeekly">Salaried-BiWeekly</option>
                                 <option value="Salaried-Monthly">Salaried-Monthly</option>
                                 <option value="Salaried-BiMonthly">Salaried-BiMonthly</option>
                                 <option value="SalesCommission">SalesCommission</option>
                                 <?php foreach($payroll_data as $prolltype){ ?>
                                 <option value="<?php  echo $prolltype['payroll_type'] ;?>"><?php  echo $prolltype['payroll_type'] ;?></option>
                                 <?php  } ?>
                              </select>
                           </div>
                        </div>
 
                        <div class="form-group row">
                           <label for="hour_rate_or_salary"  id="cost" class="col-sm-4 col-form-div">Pay Rate(<?php echo $currency; ?>)  <i class="text-danger">*</i></label>
                           <div class="col-sm-8">
                              <input name="hrate" class="form-control" type="text" placeholder="<?php echo "Pay Rate" ?>" id="hrate" value="<?php echo html_escape($employee_data[0]['hrate'])?>" oninput="validateInput(this)">
                           </div>
                        </div>
 
                        <div class="form-group row" id="payment_from">
                           <label for="paytype" class="col-sm-4 col-form-label"> Payment Type </label>
                           <div class="col-sm-8">
                              <select name="paytype"  id="paytype" class="form-control" style="width: 100%;" >
                                 <option value="<?php echo html_escape($employee_data[0]['rate_type'])?>"><?php echo html_escape($employee_data[0]['rate_type'])?></option>
                                 <option value="Cheque">Cheque</option>
                                 <option value="Direct Deposit">Direct Deposit</option>
                                 <option value="Cash">Cash</option>
                                 <?php  foreach($paytype as $ptype){ ?>
                                 <option value="<?php  echo $ptype['payment_type'] ;?>"><?php  echo $ptype['payment_type'] ;?></option>
                                 <?php  } ?>
                              </select>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="email" class="col-sm-4 col-form-div">Social security number <i class="text-danger">*</i></label>
                           <div class="col-sm-8">
                               <?php
                               if (strlen($employee_data[0]['social_security_number']) >= 4) {
                                 $hiddenDigits = substr($employee_data[0]['social_security_number'], 0, -4);
                                 $hiddenDigits .= str_repeat("*", 4);
                              } else {
                                 $hiddenDigits = str_repeat("*", strlen($employee_data[0]['social_security_number']));
                              }
                                                            ?>
                              <input name="ssn" class="form-control" type="text" placeholder="Social security Number" value="<?php echo $hiddenDigits;?>"  oninput="exitsocialsecurity(this, 9)">
                           </div>
                        </div>
                        <div class="form-group row" id="bank_name">
                           <label for="bank_name" class="col-sm-4 col-form-label"> <?php echo display('Bank') ?> <i class="text-danger"></i> </label>
                           <div class="col-sm-8">
                      <select name="bank_name" id="bank_name"  class="form-control bankpayment" required>
                      <option value="<?php echo $employee_data[0]['bank_name']; ?>" <?php if($employee_data[0]['bank_name']) { echo 'selected'; } ?>>
                                    <?php echo $employee_data[0]['bank_name']; ?>
                                 </option>
                      <?php foreach(getAllBanks() as $bank){ ?>
                              <option value="<?=$bank['bank_name']; ?>"><?=$bank['bank_name']; ?></option>
                           <?php } ?>
                        </select>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="blood_group" class="col-sm-4 col-form-div">Routing number </label>
                           <div class="col-sm-8">
                              <input name="routing_number" class="form-control" type="text" placeholder="Routing Number" value="<?php echo html_escape($employee_data[0]['routing_number'])?>" oninput="routingrestrict(this, 15)">
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="zip" class="col-sm-4 col-form-div"><?php echo 'Account Number' ?></label>
                           <div class="col-sm-8">
                              <input type="text" name="account_number" class="form-control" placeholder="Account Number"  value="<?php echo $employee_data[0]['account_number']; ?>" oninput="routingrestrict(this, 15)">
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="zip" class="col-sm-4 col-form-div"><?php echo ('Employee Tax') ?><i class="text-danger">*</i></label>
                           <div class="col-sm-8">
                              <select  name="emp_tax_detail" id="emp_tax_detail" class="form-control" >
                                 <option value="<?php echo html_escape($employee_data[0]['employee_tax'])?>"><?php echo html_escape($employee_data[0]['employee_tax'])?></option>
                                 <option value="">Select Tax</option>
                                 <option value="single">Single</option>
                                 <option value="tax_filling">Tax Filling</option>
                                 <option value="married">Married</option>
                                 <option value="head_household">Head Household</option>
                              </select>
                           </div>
                        </div>
                        <div id="popup" class="btnclr popup">
                           <!-- Popup content -->
                           <div class="row">
                              <!-- Working Taxes -->
                              <div class="col-sm-6">
                                 <h4 style="text-align:center;margin-left: 140px;">WORK LOCATION TAXES</h4>
                                 <br>
                                 <div class="form-group fg" >
                                    <label for="stateTaxDropdown">State Tax<i class="text-danger">*</i></label>
                                    <input list="magic_state_tax" name="state_tax" id="stateTaxDropdown"  value="<?php echo html_escape($employee_data[0]['edit_working_state'])?>"   class="form-control">
                                    <datalist id="magic_state_tax">
                                       <?php foreach ($state_tx as $st) { ?>
                                       <option value="<?php echo $st['state']; ?>"><?php echo $st['state']; ?></option>
                                       <?php } ?>
                                       <option value="Not Applicable">Not Applicable</option>
                                    </datalist>
                                 </div>
                                 <div class="form-group fg">
                                    <label for="localTaxDropdown">City Tax<i class="text-danger">*</i></label>
                                    <input list="magic_local_tax" name="city_tax" id="localTaxDropdown"  value="<?php echo html_escape($employee_data[0]['edit_working_city'])?>"    class="form-control">
                                    <datalist id="magic_local_tax">
                                       <?php foreach ($get_info_city_tax as $gtct) { ?>
                                       <option value="<?php echo $gtct['state']; ?>"><?php echo $gtct['state']; ?></option>
                                       <?php } ?>
                                       <option value="Not Applicable">Not Applicable</option>
                                    </datalist>
                                 </div>
                                 <div class="form-group fg">
                                    <label for="stateLocalTaxDropdown">County Tax<i class="text-danger">*</i></label>
                                    <input list="magic_state_local_tax" name="county_tax" id="stateLocalTaxDropdown"  value="<?php echo html_escape($employee_data[0]['edit_working_county'])?>"   class="form-control">
                                    <datalist id="magic_state_local_tax">
                                       <?php foreach ($get_info_county_tax as $gtcty) { ?>
                                       <option value="<?php echo $gtcty['state']; ?>"><?php echo $gtcty['state']; ?></option>
                                       <?php } ?>
                                       <option value="Not Applicable">Not Applicable</option>
                                    </datalist>
                                 </div>
                                 <div class="form-group fg">
                                    <label for="stateTax2Dropdown">Other Working Tax<i class="text-danger">*</i></label>
                                    <input list="magic_state_tax_2" name="other_working_tax" id="stateTax2Dropdown"   value="<?php echo html_escape($employee_data[0]['edit_working_other'])?>"  class="form-control">                                  
                                 </div>
                              </div>
                               <div class="col-sm-6">
                                 <h4 style="text-align:center;margin-left:140px;">LIVING LOCATION TAXES</h4>
                                 <br>
                                 <div class="form-group fg">
                                    <label for="livingStateTax">State Tax<i class="text-danger">*</i></label>
                                    <input list="magic_living_state_tax" name="living_state_tax"  value="<?php echo html_escape($employee_data[0]['edit_living_state'])?>"    id="livingStateTax" class="form-control">
                                    <datalist id="magic_living_state_tax">
                                       <?php foreach ($state_tx as $st) { ?>
                                       <option value="<?php echo $st['state']; ?>"><?php echo $st['state']; ?></option>
                                       <?php } ?>
                                       <option value="Not Applicable">Not Applicable</option>
                                    </datalist>
                                 </div>
                                 <div class="form-group fg">
                                    <label for="livingCityTax">City Tax<i class="text-danger">*</i></label>
                                    <input list="magic_living_city_tax" name="living_city_tax" id="livingCityTax"  value="<?php echo html_escape($employee_data[0]['edit_living_city'])?>"   class="form-control">
                                    <datalist id="magic_living_city_tax">
                                       <?php foreach ($get_info_city_tax as $gtct) { ?>
                                       <option value="<?php echo $gtct['state']; ?>"><?php echo $gtct['state']; ?></option>
                                       <?php } ?>
                                       <option value="Not Applicable">Not Applicable</option>
                                    </datalist>
                                 </div>
                                 <div class="form-group fg">
                                    <label for="livingCountyTax">County Tax<i class="text-danger">*</i></label>
                                    <input list="magic_living_county_tax" name="living_county_tax" id="livingCountyTax"   value="<?php echo html_escape($employee_data[0]['edit_living_county'])?>"      class="form-control">
                                    <datalist id="magic_living_county_tax">
                                       <?php foreach ($get_info_county_tax as $gtcty) { ?>
                                       <option value="<?php echo $gtcty['state']; ?>"><?php echo $gtcty['state']; ?></option>
                                       <?php } ?>
                                       <option value="Not Applicable">Not Applicable</option>
                                    </datalist>
                                 </div>
                                 <div class="form-group fg">
                                    <label for="livingOtherTax">Other Living Tax<i class="text-danger">*</i></label>
                                    <input list="magic_living_other_tax" name="other_living_tax" id="livingOtherTax"  value="<?php echo html_escape($employee_data[0]['edit_living_other'])?>"   class="form-control">
                                 </div>
                              </div>
                           </div>
                           <br>
                           <div style='float:right;font-weight:bold;'>
                              <!-- Button to add popup data -->
                              <button type="button"  style="background-color:green;margin-left: 335px;width:60px;" class="btn btnclr"   id="addPopupData">Save</button>
                              <button type="button" class="btn btn-danger"   onclick="closeModal()">Close</button>
                           </div>
                           <br>
                           <br>
                        </div>
                        <div class="form-group row">
                           <label for="withholding_tax" class="col-sm-4 col-form-label">Withholding Tax</label>
                           <div class="col-sm-8">
                              <button type="button" class="btnclr btn" id="showPopup">Add Withholding Tax</button>
                           </div>
                        </div>



                        <div class="form-group row">
    <label for="ETA" class="col-sm-4 col-form-label"><?php echo display('Attachments ') ?></label>
    <div class="col-sm-6">
        <p>
            <label for="attachment">
                <a class="btnclr btn text-light" role="button" aria-disabled="false">
                    <i class="fa fa-upload"></i>&nbsp; Choose Files
                </a>
            </label>
            <input type="file" name="files[]" class="upload" id="attachment" style="visibility: hidden; position: absolute;" multiple accept=".pdf, .docx, .txt" />
        </p>
        <p id="files-area">
            <span id="filesList">
                <span id="files-names"></span>
            </span>
        </p>
        <?php
        echo '<div class="file-container">';
        foreach ($employee_data as $attachment) {
            $Final_files = explode(",", $attachment['files']);
            foreach ($Final_files as $file) {
                $encoded_file = rawurlencode(trim($file));
                echo '<p><a href="' . base_url() . 'uploads/employeedetails/' . $encoded_file . '" target="_blank">' . trim($file) . '</a></p>';
                 echo '<input type="hidden" name="old_image[]" value="' . trim($file) . '">';
            }
        }
        echo '</div>';
        ?>
    </div>
</div>


<div class="form-group row" id="payrolltype">
    <label for="profile_image" class="col-sm-4 col-form-label">
        Profile Image 
    </label>
    <div class="col-sm-8">
        <input type="file" name="profile_image" class="form-control" accept=".png, .jpg, .jpeg">
        <input type="hidden" name="old_profileimage" value="<?php echo html_escape($employee_data[0]['profile_image']); ?>">
        <br>
        <?php if (!empty($employee_data[0]['profile_image'])): ?>
            <img src="<?php echo base_url(); ?>uploads/profile/<?php echo html_escape($employee_data[0]['profile_image']); ?>" height="40px" width="40px">
        <?php endif; ?>
    </div>
</div>



                     </div>
                  </div>
                  <br>

         
                <div class="col-md-12">
                  <div class="form-group" style="text-align: center;" >
                  <button type="submit" style="float:center;color:white;" id="checkSubmit" class="btnclr btn  w-md m-b-5"><?php echo display('Submit') ?></button>
                  <a href="<?php echo base_url('Chrm/manage_employee') ?>?id=<?php echo $_GET['id']; ?>"  style="margin-top:-5px;"  class="btn btn-info">Cancel</a>
                  </div>
            
               
               </form>


               <?php } else { ?>

                  <div class="errormessagesales"></div>
                  <form id="salespartner_update" name="salespartner_update" method="post" enctype="multipart/form-data" >
         <div class="row">
                <div class="col-sm-6">
                  <div class="form-group row">
                     <label for="first_name" class="col-sm-4 col-form-div"><?php echo display('first_name') ?> <i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <input name="sfirst_name" id="sfirstname" class="form-control"  value="<?php echo html_escape($employee_data[0]['first_name'])?>"  type="text" placeholder="<?php echo display('first_name') ?>"   oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">
                     </div>
                  </div>
 
                     <input type="hidden" name="id"  id="id"  value="<?php echo $encodedId ; ?>" >
                     <input type="hidden" name="updatedid"  id="updatedid"  value="<?php echo html_escape($employee_data[0]['id'])?>"  >

                  <div class="form-group row">
                     <label for="middle_name" class="col-sm-4 col-form-div"><?php echo "Middle Name"; ?></label>
                     <div class="col-sm-8">
                        <input name="smiddle_name" id="smiddle_name" class="form-control" type="text"  value="<?php echo html_escape($employee_data[0]['middle_name'])?>" placeholder="<?php echo "Middle Name"; ?>" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="last_name" class="col-sm-4 col-form-div"><?php echo display('last_name') ?><i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <input name="last_name" class="form-control" type="text" placeholder="<?php echo display('last_name') ?>"   value="<?php echo html_escape($employee_data[0]['last_name'])?>"  oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="last_name" class="col-sm-4 col-form-div"><?php echo ("Business Name") ?></label>
                     <div class="col-sm-8">
                        <input name="salesbusiness_name" value="<?php echo html_escape($employee_data[0]['salesbusiness_name'])?>"  class="form-control" type="text" placeholder="<?php echo "Business Name" ?>" id="salesbusiness_name" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="phone" class="col-sm-4 col-form-div"><?php echo display('phone') ?> <i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                         <input class="form-control" name="phone" id="mobile" type="tel"  value="<?php echo html_escape($employee_data[0]['phone'])?>"  style="border: 2px solid #d7d4d6;" placeholder="(XXX) XXX-XXXX" tabindex="3" oninput="formatPhoneNumber(this)">

                     </div>
                  </div>
 
                  <div class="form-group row">
                     <label for="Profile Image" class="col-sm-4 col-form-label">
                     Email 
                     </label>
                     <div class="col-sm-8">
                        <input name="email" class="form-control" type="email"  value="<?php echo html_escape($employee_data[0]['email'])?>"    placeholder="<?php echo display('email') ?>" id="email" oninput="validateEmail(this)">
                        <span id="validateemails" style="margin-top: 10px;"></span>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="address_line_1" class="col-sm-4 col-form-div"><?php echo display('address_line_1') ?></label>
                     <div class="col-sm-8">
                        <input name="address_line_1" rows='1' value="<?php echo html_escape($employee_data[0]['address_line_1'])?>"  class="form-control" placeholder="<?php echo display('address_line_1') ?>" id="address_line_1"> 
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="address_line_2" class="col-sm-4 col-form-div"><?php echo display('address_line_2') ?></label>
                     <div class="col-sm-8">
                        <input name="address_line_2" rows='1' value="<?php echo html_escape($employee_data[0]['address_line_2'])?>"  class="form-control" placeholder="<?php echo display('address_line_2') ?>" id="address_line_2"> 
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="city" class="col-sm-4 col-form-div"><?php echo display('city') ?></label>
                     <div class="col-sm-8">
                        <input name="city" class="form-control"value="<?php echo html_escape($employee_data[0]['city'])?>"   type="text" placeholder="<?php echo display('city') ?>" id="city" oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '')">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="state" class="col-sm-4 col-form-label"><?php echo display('state'); ?> <i class="text-danger"></i></label>
                     <div class="col-sm-8">
                        <input class="form-control" name="state" id="state"  value="<?php echo html_escape($employee_data[0]['state'])?>" type="text" style="border:2px solid #D7D4D6;"    placeholder="<?php echo display('state') ?>"  oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="zip" class="col-sm-4 col-form-div"><?php echo display('zip') ?></label>
                     <div class="col-sm-8">
                        <input name="zip" class="form-control" type="text"   value="<?php echo html_escape($employee_data[0]['zip'])?>"  placeholder="<?php echo display('zip') ?>" id="zip" oninput="exitnumbers(this, 10)">
                     </div>
                  </div>
                  <input type="hidden" name="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>">
                  <div class="form-group row">
                     <label for="country" class="col-sm-4 col-form-div"><?php echo display('country') ?></label>
                     <div class="col-sm-8">
                        <select class="selectpicker countrypicker form-control"
                                        style="width:455px;border: 2px solid #d7d4d6;" data-live-search="true"
                                        data-default="United States" name="country" id="country"></select>
                     </div>
                  </div>

                  <div class="form-group row">
                     <label for="emergencycontact" class="col-sm-4 col-form-label"> <?php echo "Emergency Contact Person" ?> </label>
                     <div class="col-sm-8">
                        <input class="form-control" name="emergencycontact" id="emergencycontact" type="text"  value="<?php echo html_escape($employee_data[0]['emergencycontact'])?>"   style="border:2px solid #D7D4D6;"   placeholder="Emergency Contact Person"  oninput="limitAlphabetical(this, 20)">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="emergencycontactnum" class="col-sm-4 col-form-label"> <?php echo "Emergency Contact  number" ?> </label>
                     <div class="col-sm-8">
                        <input class="form-control" name="emergencycontactnum" id="emergencycontactnum" type="number"   value="<?php echo html_escape($employee_data[0]['emergencycontactnum'])?>" style="border:2px solid #D7D4D6;"   placeholder="Emergency Contact Number"  oninput="exitnumbers(this, 10)">
                     </div>
                  </div>
               </div>






                <div class="col-sm-6">
                  <div class="form-group row" id="payment_from">
                     <label for="city" class="col-sm-4 col-form-div"><?php echo  ('Sales Commission') ?></label>
                     <div class="col-sm-8">
                        <input name="sc" class="form-control" type="text" value="<?php echo html_escape($employee_data[0]['sc'])?>"  placeholder="<?php echo 'Sales Commission Percentage' ?>">
                     </div>
                  </div>
                  <div class="form-group row" id="payment_from">
                        <label for="choice" class="col-sm-4 col-form-div">Commission Withholding</label>
                     <div class="col-sm-8">

                     
                     <input type="radio" name="choice" value="Yes" <?php echo ($employee_data[0]['choice'] == 'Yes') ? 'checked' : ''; ?>> Yes &nbsp;
                     <input type="radio" name="choice" value="No" <?php echo ($employee_data[0]['choice'] == 'No') ? 'checked' : ''; ?>> No

                        </div>
                  </div>
                  <div class="form-group row">
                     <label for="email" class="col-sm-4 col-form-div">Social security number <i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <input id="ssnInput" name="ssnInput" class="form-control validation_group" value="<?php echo html_escape($employee_data[0]['social_security_number'])?>" type="text" placeholder="Social Security Number"   oninput="exitsocialsecurity(this, 9)">
                     </div>
                     <br><br>
                     <span style="margin-left: 532px; font-weight: bold;">(OR)</span>
                  </div>
                  <div class="form-group row">
                     <label for="hourly_rate_or_salary" id="cost" class="col-sm-4 col-form-div"><?php echo ('Federal Identification Number') ?> <i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <input id="federalidentificationnumber" name="federalidentificationnumber" value="<?php echo html_escape($employee_data[0]['federalidentificationnumber'])?>"  class="form-control validation_group" type="text" placeholder="Federal Identification Number" oninput="exitsocialsecurity(this, 9)">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="hourly_rate_or_salary" id="cost" class="col-sm-4 col-form-div"><?php echo ('Federal Tax Classification') ?> <i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <select name="federaltaxclassification" id="federaltaxclassification" class="form-control" style="width: 100%;"  >
                           <option value="<?php echo html_escape($employee_data[0]['federaltaxclassification'])?>"><?php echo html_escape($employee_data[0]['federaltaxclassification'])?></option>
                           <option value="Individual/sole proprietor">Individual/sole proprietor</option>
                           <option value="C corporation">C corporation</option>
                           <option value="S corporation">S corporation</option>
                           <option value="Partnership">Partnership</option>
                           <option value="Trust/estate">Trust/estate</option>
                        </select>
                     </div>
                  </div>
                  <div class="form-group row"  id="payment_from">
                     <label for="paytype" class="col-sm-4 col-form-label"> Payment Type </label>
                     <div class="col-sm-8" >
                        <select name="paytype"  id="paytype" class="form-control" style="width: 100%;" >
                           <option value="<?php echo html_escape($employee_data[0]['rate_type'])?>"><?php echo html_escape($employee_data[0]['rate_type'])?></option>
                           <option value="Cheque">Cheque</option>
                           <option value="Direct Deposit">Direct Deposit</option>
                           <option value="Cash">Cash</option>
                           <?php  foreach($paytype as $ptype){ ?>
                           <option value="<?php  echo $ptype['payment_type'] ;?>"><?php  echo $ptype['payment_type'] ;?></option>
                           <?php  } ?>
                        </select>
                     </div>
                    
                  </div>
                  <div class="form-group row" id="bank_name">
                     <label for="bank_name" class="col-sm-4 col-form-label"> <?php echo display('Bank') ?>  </label>
                     <div class="col-sm-8">
                       <select name="bank_name" id="bank_name"  class="form-control bankpayment" style="width: 100%;" required>
                           <?php foreach(getAllBanks() as $bank){ ?>
                           <option value="<?=$bank['bank_name']; ?>"><?=$bank['bank_name']; ?></option>
                           <?php } ?>
                        </select>
                     </div>
                     
                  </div>
                  <div class="form-group row">
                     <label for="blood_group" class="col-sm-4 col-form-div">Routing number </label>
                     <div class="col-sm-8">
                        <input name="routing_number" class="form-control" type="text" value="<?php echo html_escape($employee_data[0]['routing_number'])?>"  placeholder="Routing Number" oninput="routingrestrict(this, 15)">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="zip" class="col-sm-4 col-form-div"><?php echo 'Account Number' ?></label>
                     <div class="col-sm-8">
                        <input type="text" name="account_number"  value="<?php echo html_escape($employee_data[0]['account_number'])?>" class="form-control" placeholder="Account Number" oninput="routingrestrict(this, 15)">
                     </div>
                  </div>

            <div class="form-group row">
                     <label for="zip" class="col-sm-4  "><?php echo ('Employee Tax') ?><i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <select  name="emp_tax_detail" id="emp_tax_detail" class="form-control" style="width:522px;"  >
                           <option value="<?php echo html_escape($employee_data[0]['employee_tax'])?>"><?php echo html_escape($employee_data[0]['employee_tax'])?></option>
                           <option value="single">Single</option>
                           <option value="tax_filling">Tax Filling</option>
                           <option value="married">Married</option>
                           <option value="head_household">Head Household</option>
                        </select>
                     </div>
                  </div> 

 

                  <div id="popupsalespartner" class="btnclr popupsalespartner">
                      <div class="row">
                         <div class="col-sm-6">
                           <h4 style="text-align:center;margin-left: 140px;">WORK LOCATION TAXES</h4>
                           <br>
                           <div class="form-group fg" >
                                    <label for="stateTaxDropdown">State Tax<i class="text-danger">*</i></label>
                                    <input list="magic_state_tax" name="state_tax" id="stateTaxDropdown"  value="<?php echo html_escape($employee_data[0]['edit_working_state'])?>"   class="form-control">
                                    <datalist id="magic_state_tax">
                                       <?php foreach ($state_tx as $st) { ?>
                                       <option value="<?php echo $st['state']; ?>"><?php echo $st['state']; ?></option>
                                       <?php } ?>
                                       <option value="Not Applicable">Not Applicable</option>
                                    </datalist>
                                 </div>
                                 <div class="form-group fg">
                                    <label for="localTaxDropdown">City Tax<i class="text-danger">*</i></label>
                                    <input list="magic_local_tax" name="city_tax" id="localTaxDropdown"  value="<?php echo html_escape($employee_data[0]['edit_working_city'])?>"    class="form-control">
                                    <datalist id="magic_local_tax">
                                       <?php foreach ($get_info_city_tax as $gtct) { ?>
                                       <option value="<?php echo $gtct['state']; ?>"><?php echo $gtct['state']; ?></option>
                                       <?php } ?>
                                       <option value="Not Applicable">Not Applicable</option>
                                    </datalist>
                                 </div>
                                 <div class="form-group fg">
                                    <label for="stateLocalTaxDropdown">County Tax<i class="text-danger">*</i></label>
                                    <input list="magic_state_local_tax" name="county_tax" id="stateLocalTaxDropdown"  value="<?php echo html_escape($employee_data[0]['edit_working_county'])?>"   class="form-control">
                                    <datalist id="magic_state_local_tax">
                                       <?php foreach ($get_info_county_tax as $gtcty) { ?>
                                       <option value="<?php echo $gtcty['state']; ?>"><?php echo $gtcty['state']; ?></option>
                                       <?php } ?>
                                       <option value="Not Applicable">Not Applicable</option>
                                    </datalist>
                                 </div>
                                 <div class="form-group fg">
                                    <label for="stateTax2Dropdown">Other Working Tax<i class="text-danger">*</i></label>
                                    <input list="magic_state_tax_2" name="other_working_tax" id="stateTax2Dropdown"   value="<?php echo html_escape($employee_data[0]['edit_working_other'])?>"  class="form-control">                                  
                                 </div>
                              </div>
                               <div class="col-sm-6">
                                 <h4 style="text-align:center;margin-left:140px;">LIVING LOCATION TAXES</h4>
                                 <br>
                                 <div class="form-group fg">
                                    <label for="livingStateTax">State Tax<i class="text-danger">*</i></label>
                                    <input list="magic_living_state_tax" name="living_state_tax"  value="<?php echo html_escape($employee_data[0]['edit_living_state'])?>"    id="livingStateTax" class="form-control">
                                    <datalist id="magic_living_state_tax">
                                       <?php foreach ($state_tx as $st) { ?>
                                       <option value="<?php echo $st['state']; ?>"><?php echo $st['state']; ?></option>
                                       <?php } ?>
                                       <option value="Not Applicable">Not Applicable</option>
                                    </datalist>
                                 </div>
                                 <div class="form-group fg">
                                    <label for="livingCityTax">City Tax<i class="text-danger">*</i></label>
                                    <input list="magic_living_city_tax" name="living_city_tax" id="livingCityTax"  value="<?php echo html_escape($employee_data[0]['edit_living_city'])?>"   class="form-control">
                                    <datalist id="magic_living_city_tax">
                                       <?php foreach ($get_info_city_tax as $gtct) { ?>
                                       <option value="<?php echo $gtct['state']; ?>"><?php echo $gtct['state']; ?></option>
                                       <?php } ?>
                                       <option value="Not Applicable">Not Applicable</option>
                                    </datalist>
                                 </div>
                                 <div class="form-group fg">
                                    <label for="livingCountyTax">County Tax<i class="text-danger">*</i></label>
                                    <input list="magic_living_county_tax" name="living_county_tax" id="livingCountyTax"   value="<?php echo html_escape($employee_data[0]['edit_living_county'])?>"      class="form-control">
                                    <datalist id="magic_living_county_tax">
                                       <?php foreach ($get_info_county_tax as $gtcty) { ?>
                                       <option value="<?php echo $gtcty['state']; ?>"><?php echo $gtcty['state']; ?></option>
                                       <?php } ?>
                                       <option value="Not Applicable">Not Applicable</option>
                                    </datalist>
                                 </div>
                                 <div class="form-group fg">
                                    <label for="livingOtherTax">Other Living Tax<i class="text-danger">*</i></label>
                                    <input list="magic_living_other_tax" name="other_living_tax" id="livingOtherTax"  value="<?php echo html_escape($employee_data[0]['edit_living_other'])?>"   class="form-control">
                                 </div>
                              </div>
                           </div>
                     <br>
                     <div style='float:right;font-weight:bold;'>
                        <!-- Button to add popup data -->
                        <button type="button"   style="background-color:green;margin-left: 335px;width:60px;"  class="btn btnclr"   id="addPopupsalespartnerData">Save</button>
                        <button type="button" class="btn btn-danger"   onclick="closeModalsalepartner()">Close</button>
                     </div>
                     <br>
                     <br>
                  </div>
                  <div class="form-group row">
                     <label for="withholding_tax" class="col-sm-4 col-form-label">Withholding Tax<i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <button type="button" class="btnclr btn" id="showPopupsalespartner">Add Withholding Tax</button>
                     </div>
                  </div>
           

         

                  <div class="form-group row">
    <label for="bl_number" class="col-sm-4 col-form-label">
        <?php echo display('Attachments')?>
        <i class="text-danger"></i>
    </label>
    <div class="col-sm-8">
        <p>
            <label for="attachment">
                <a class="btnclr btn text-light" role="button">
                    <i class="fa fa-upload"></i>&nbsp; Choose Files
                </a>
            </label>
            <input type="file" name="files[]" class="upload" id="attachment" style="visibility: hidden; position: absolute;" multiple accept=".pdf, .docx, .txt, .png, .jpeg, .jpg" />
        </p>
        <br>
        <?php if (!empty($attachmentData)) { ?>
            <?php foreach ($attachmentData as $attachment) { ?>
                <div class="attachment-item">
                    <a href="<?php echo base_url() . rtrim($attachment['image_dir'], '/') . '/' . $attachment['files']; ?>" class="image-block name" target="_blank">
                        <?php echo $attachment['files']; ?>
                    </a>
                    <a href="javascript:void(0);" class="delete-attachment" data-id="<?php echo $attachment['id']; ?>">
                        
                    </a>
                </div>
            <?php } ?>
            
        <?php } ?>
        <p id="files-area">
            <span id="filesList">
                <span id="files-names"></span>
            </span>
        </p>
    </div>
</div>



 

                  <div class="form-group row"  id="payrolltype">
                     <label for="profile_image" class="col-sm-4 col-form-label">
                     Profile Image
                     </label>
                     <div class="col-sm-8">
                       <div class="col-sm-6">
                        <input class="form-control" type="file" name="profile_image" style="width: 100%;" />
                        <input type="hidden" name="profile_image" value="<?php echo htmlspecialchars($employee_data[0]['profile_image'], ENT_QUOTES, 'UTF-8'); ?>">
                        <?php
                        $image_url = !empty($employee_data[0]['profile_image']) 
                                    ? base_url() . 'uploads/profile/salespartner/' . htmlspecialchars($employee_data[0]['profile_image'], ENT_QUOTES, 'UTF-8') 
                                    : '';
                        $alt_text = !empty($employee_data[0]['profile_image']) 
                                    ? htmlspecialchars($employee_data[0]['first'], ENT_QUOTES, 'UTF-8') 
                                    : 'Profile image';
                        if ($image_url) {
                           echo '<img src="' . htmlspecialchars($image_url, ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($alt_text, ENT_QUOTES, 'UTF-8') . '" width="100">';
                        } else {
                         }
                        ?>
                        </div>
                     </div>
                  </div>


               </div>
            </div>




            <br><br><br>
            <div class="row">
               <div class="col-md-12">
                     <div class="form-group" style="text-align: center;" >
                     <button type="submit" id="checkSubmit"   class="btnclr btn btn-success w-md m-b-5"><?php echo display('Submit') ?></button> 
                     <a href="<?php echo base_url('Chrm/manage_employee') ?>?id=<?php echo $_GET['id']; ?>"  style="margin-top:-5px;"  class="btn btn-info">Cancel</a>
                   
                  </div>
               </div>
            </div>
         </form>

<script>
    document.getElementById("showPopupsalespartner").addEventListener("click", function() {
       document.getElementById("popupsalespartner").style.display = "block";
       });
       function closeModalsalepartner() {
       document.getElementById("showPopupsalespartner").style.display = "none";
       }
       document.getElementById("showPopupsalespartner").addEventListener("click", function() {
       document.getElementById("popupsalespartner").style.display = "block";
       });
       function closeModalsalepartner() {
       document.getElementById("showPopupsalespartner").style.display = "none";
       }
       document.getElementById("addPopupsalespartnerData").addEventListener("click", function() {
           document.getElementById("popupsalespartner").style.display = "none";
       });
        function closeModalsalepartner() {
           document.getElementById("popupsalespartner").style.display = "none";
       }
</script>

<style>
     .popupsalespartner label{
      color:white;
      }
      .popupsalespartner {
      border-top-right-radius: 20px;
      border-bottom-left-radius: 20px;
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      border: 1px solid #000;
      padding: 20px;
      background-color: #fff;
      z-index: 9999;
      width: 90%;
      max-width: 800px;
      box-sizing: border-box;
      background-color: #424f5c;

      }
      .popupsalespartner .row {
      margin-top: 10px;
      }
      .popupsalespartner .col-sm-6 {
      width: 50%;
      box-sizing: border-box;
      }
</style>
               <?php } ?>


               </div>
            </div>
         </div>
      </div>
   </section>
</div>






<script>


    var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
   var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';   
   var employeeId = '<?php echo $this->input->get('id'); ?>';
   $(document).ready(function(){
 
   var succalert = '<div class="alert alert-success alert-dismissible" role="alert">';
   var failalert = '<div class="alert alert-danger alert-dismissible" role="alert">';
   $("#update_employee").validate({
 
   rules: {
      first_name: "required",
      last_name: "required",  
      designation: "required",  
      phone: "required",  
      employee_type: "required",  
      payroll_type: "required",  
      hrate: "required",  
      ssn: "required",  
      emp_tax_detail: "required",  
   },
   messages: {
      first_name: "Frist Name is required",
      last_name: "Last Name is required",
      designation: "Designation is required",
      phone: "Phone is required",
      employee_type: "Employee Type is required",
      payroll_type: "Payroll Type is required",
      hrate: "Pay Rate is required",
      ssn: "Social Security Number is required",
      emp_tax_detail: "Employee Tax is required",
   },
    
  submitHandler: function(form) {
    var formData = new FormData(form);
    formData.append(csrfName, csrfHash);
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "<?php echo base_url('Chrm/update_employee'); ?>",
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
           console.log(response, "response");
           if(response.status == 'success')
         {
          $('.errormessage').html(succalert+response.msg+'</div>');
            console.log(response.msg, "Success");
            window.setTimeout(function(){
            window.location.href = "<?php echo base_url('Chrm/manage_employee') ?>?id=" + (employeeId)  ;
         },500);
         }else{
            $('.errormessage').html(failalert+response.msg+'</div>'); 
            console.log(response.msg, "Error");
         }                  
      },
          error: function(xhr, status, error) {
          alert('An error occurred: ' + error);
      }
    })
  }
});
});








var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
   var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';   
   var employeeId = '<?php echo $this->input->get('id'); ?>';
   $(document).ready(function(){
   var succalert = '<div class="alert alert-success alert-dismissible" role="alert">';
   var failalert = '<div class="alert alert-danger alert-dismissible" role="alert">';
   $.validator.addMethod("validation_group", function(value, element, param) {
        var ssnInput = $('#ssnInput').val();
        var federalidentificationnumber = $('#federalidentificationnumber').val();
        return (ssnInput.length > 0 || federalidentificationnumber.length > 0);
    }, "Social security number or Federal Identification Number is required.");
 $("#salespartner_update").validate({
   rules: {
   sfirst_name: "required",
    last_name: "required",  
     phone: "required",
      federalidentificationnumber: {
         validation_group: true
      },
      ssnInput: {
         validation_group: true
      },
    federaltaxclassification : "required",
    emp_tax_detail: "required",  
 },
 messages: {
     sfirst_name: "First Name is required",
    last_name: "Last Name is required",
     phone: "Phone is required",
     ssnInput: {
      require_from_group: "Social security number or Federal Identification Number is required"
     },
     federaltaxclassification: {
       require_from_group: "Social security number or Federal Identification Number is required"
     },
      federaltaxclassification: "Federal Tax Classification Tax is required",
      emp_tax_detail: "Employee Tax is required",
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
    url: "<?php echo base_url('Chrm/salespartner_update'); ?>",
    data: formData,
    contentType: false,
    processData: false,
    success: function(response) {
         console.log(response, "response");
         if(response.status == 'success')
       {
        $('.errormessagesales').html(succalert+response.msg+'</div>');
          console.log(response.msg, "Success");
          window.setTimeout(function(){
          window.location.href = "<?php echo base_url('Chrm/manage_employee') ?>?id=" + (employeeId)  ;
       },500);
       }else{
          $('.errormessagesales').html(failalert+response.msg+'</div>'); 
          console.log(response.msg, "Error");
       }                  
    },
        error: function(xhr, status, error) {
        alert('An error occurred: ' + error);
    }
  })
}
});
});













   const dt = new DataTransfer();  
      $("#attachment").on('change', function(e){
           for(var i = 0; i < this.files.length; i++){
              let fileBloc = $('<span/>', {class: 'file-block'}),
                   fileName = $('<span/>', {class: 'name', text: this.files.item(i).name});
              fileBloc.append('<span class="file-delete"><span><i class="fa fa-trash-o"></i></span></span>')
                  .append(fileName);
              $("#filesList > #files-names").append(fileBloc);
          };
           for (let file of this.files) {
              dt.items.add(file);
          }
           this.files = dt.files;
           $('span.file-delete').click(function(){
              let name = $(this).next('span.name').text();
               $(this).parent().remove();
              for(let i = 0; i < dt.items.length; i++){
                   if(name === dt.items[i].getAsFile().name){
                       dt.items.remove(i);
                      continue;
                  }
              }
               document.getElementById('attachment').files = dt.files;
          });
      });


      
   document.getElementById("showPopup").addEventListener("click", function() {
       document.getElementById("popup").style.display = "block";
       });
       function closeModal() {
       document.getElementById("showPopup").style.display = "none";
       }
       document.getElementById("addPopupData").addEventListener("click", function() {
           document.getElementById("popup").style.display = "none";
       });
      function closeModal() {
           document.getElementById("popup").style.display = "none";
       }
   const stateTaxCheckbox = document.getElementById('stateTaxCheckbox');
       const localTaxCheckbox = document.getElementById('localTaxCheckbox');
       const stateLocalTaxCheckbox = document.getElementById('stateLocalTaxCheckbox');
       const stateTaxDropdown = document.getElementById('stateTaxDropdown');
       const stateTaxDropdown1 = document.getElementById('stateTaxDropdown1');
       const localTaxDropdown = document.getElementById('localTaxDropdown');
       const stateLocalTaxDropdown = document.getElementById('stateLocalTaxDropdown');
       stateTaxCheckbox.addEventListener('change', function () {
           if (this.checked) {
               stateLocalTaxCheckbox.disabled = false;
                stateLocalTaxCheckbox.checked = false;
                stateLocalTaxDropdown.style.display = 'none';
            } else {
               stateLocalTaxCheckbox.disabled = false;
            }
           stateTaxDropdown.style.display = this.checked ? 'block' : 'none';
           stateTaxDropdown1.style.display = this.checked ? 'block' : 'none';
       });
       localTaxCheckbox.addEventListener('change', function () {
           if (this.checked) {
               stateLocalTaxCheckbox.disabled = false;
                stateLocalTaxCheckbox.checked = false;
                stateLocalTaxDropdown.style.display = 'none';
            } else {
               stateLocalTaxCheckbox.disabled = false;
            }
           localTaxDropdown.style.display = this.checked ? 'block' : 'none';
       });
       stateLocalTaxCheckbox.addEventListener('change', function () {
           if (this.checked) {
               stateTaxCheckbox.disabled = true;
               localTaxCheckbox.disabled = true;
               stateTaxCheckbox.checked = false;
               localTaxCheckbox.checked = false;
               stateTaxDropdown.style.display = 'none';
               stateTaxDropdown1.style.display = 'none';
               localTaxDropdown.style.display = 'none';
           } else {
               stateTaxCheckbox.disabled = false;
               localTaxCheckbox.disabled = false;
           }
           stateLocalTaxDropdown.style.display = this.checked ? 'block' : 'none';
       });
    function toggleDropdown(checkboxId, dropdownId) {
           var checkbox = document.getElementById(checkboxId);
           var dropdown = document.getElementById(dropdownId);
           checkbox.addEventListener('change', function () {
               if (this.checked) {
                   dropdown.style.display = 'inline-block';
               } else {
                   dropdown.style.display = 'none';
               }
           });
       }
       toggleDropdown('stateTaxCheckbox', 'stateTaxDropdown');
       toggleDropdown('stateTaxCheckbox', 'stateTaxDropdown1');
       toggleDropdown('localTaxCheckbox', 'localTaxDropdown');
       toggleDropdown('stateLocalTaxCheckbox', 'stateLocalTaxDropdown');
     document.getElementById('employee_type').addEventListener('change', function() {
       validateDropdown('employee_type');
     });
     document.getElementById('emp_tax_detail').addEventListener('change', function() {
       validateDropdown('emp_tax_detail');
     });
     document.getElementById('in_department').addEventListener('change', function() {
       validateDropdown('in_department');
     });
     function validateDropdown(dropdownId) {
       var dropdown = document.getElementById(dropdownId);
       var selectedValue = dropdown.options[dropdown.selectedIndex].value;
       if (selectedValue === '') {
         alert('Please select a value for ' + dropdownId.replace('_', ' '));
         dropdown.focus();
       }
     }
     function validateForm() {
       validateDropdown('employee_type');
       validateDropdown('emp_tax_detail');
       validateDropdown('in_department');
       return false;
     }
   var payrollTypeSelect = document.getElementById('payroll_type');
       var asteriskSpan = document.getElementById('asterisk');
       payrollTypeSelect.addEventListener('change', function() {
           var hrateInput = document.getElementById('hrate');
           if (this.value === 'SalesCommission') {
               hrateInput.removeAttribute('required');
           }  
       });
        payrollTypeSelect.dispatchEvent(new Event('change'));
   $(document).on('change', '#payroll_type', function() {
       var selectedOption = $(this).val();
       if (selectedOption === 'Hourly') {
           $('#cost').text('Pay rate (Hourly)').show();  
           $('#hrate').show();  
       } else if (selectedOption === 'SalesCommission') {
           $('#cost').hide();  
           $('#hrate').hide();  
       } else {
           $('#cost').text('Pay rate (Daily)').show(); 
           $('#hrate').show();  
       }
   });
    function validateEmail(input) {
         var regex = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
         var submitButton = document.getElementById("checkSubmit");
          input.addEventListener("input", function(event) {
              var value = input.value;
              var newValue = '';
              for (var i = 0; i < value.length; i++) {
                  var char = value.charAt(i);
                  if (/[@._A-Za-z0-9-]/.test(char) || event.shiftKey) {
                      newValue += char;
                  }
              }
              input.value = newValue;
              var isValid = regex.test(input.value);
              if (isValid) {
                   var lastPart = input.value.split('.').pop();
                  if (lastPart !== 'com' && lastPart !== 'in') {
                      isValid = false;
                  }
              }
              if (isValid) {
                  document.getElementById("validateemails").style.color = "green";
                  document.getElementById("validateemails").textContent = "Valid email address";
                  submitButton.disabled = false;
              } else {
                  document.getElementById("validateemails").style.color = "red";
                  document.getElementById("validateemails").textContent = "Invalid email address";
                  submitButton.disabled = true;
              }
          });
      }
        function validateInput(input) {
          input.value = input.value.replace(/[^0-9.]/g, '');
       }
        function exitnumbers(input, maxLength) {
         input.value = input.value.replace(/\D/g, '');
         if (input.value.length > maxLength) {
            input.value = input.value.slice(0, maxLength);
         }
       }
        function limitAlphabetical(input, maxLength) {
         input.value = input.value.replace(/[^A-Za-z ]/g, '');
         if (input.value.length > maxLength) {
            input.value = input.value.slice(0, maxLength);
         }
       }
        function exitsalecommission(input, maxLength) {
         input.value = input.value.replace(/\D/g, '');
         if (input.value.length > maxLength) {
            input.value = input.value.slice(0, maxLength);
         }
       }
       function exitsocialsecurity(input, maxLength) {
         input.value = input.value.replace(/\D/g, '');
         if (input.value.length > maxLength) {
            input.value = input.value.slice(0, maxLength);
         }
      }
       function routingrestrict(input, maxLength) {
         input.value = input.value.replace(/\D/g, '');
         if (input.value.length > maxLength) {
            input.value = input.value.slice(0, maxLength);
         }
      }
      function formatPhoneNumber(input) {
            var phoneNumber = input.value.replace(/\D/g, '');
            if (phoneNumber.length > 0) {
                var formattedPhoneNumber = '(' + phoneNumber.substring(0, 3) + ') ' + phoneNumber.substring(3, 6) + ' ' + phoneNumber.substring(6, 10);
                input.value = formattedPhoneNumber;
            }
         }
</script>
<style>
   #files-area{
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
   .fg {
   display: flex;
   flex-direction: row;
   justify-content: space-between;
   align-items: center;
   margin-bottom: 15px;
   }
   .fg label {
   width: 40%;  
   }
   .fg input {
   width: 60%;  
   }
</style>
 