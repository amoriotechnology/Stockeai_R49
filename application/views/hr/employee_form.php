<script src="<?php echo base_url() ?>my-assets/js/countrypicker.js" type="text/javascript"></script>
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
<div class="content-wrapper">
   <section class="content-header">
      <div class="header-icon">
         <i class="pe-7s-note2"></i>
      </div>
      <div class="header-title">
         <h1 id="headpartemployeeadd"><?php echo ('Add Employee') ?></h1>
         <h1 id="headpartsalespartner" style="display: none;"><?php echo ('Add Sales Partner') ?></h1>
         <small></small>
         <ol class="breadcrumb">
            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
            <li class="active" style="color:orange  "><?php echo html_escape($title) ?></li>
         </ol>
      </div>
   </section>
   <style>
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
      }
      .popupsalespartner .row {
      margin-top: 10px;
      }
      .popupsalespartner .col-sm-6 {
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
       #desig-error , #payroll_type-error , #emp_type-error {
          top: 28px;
          position: absolute;
          bottom: 10px;
        }
        
   </style>
   <!-- New Employee Type -->
    <div class="col-sm-12">
      <div class="panel panel-bd lobidrag">
         <div class="panel-heading">
            <div class="panel-title" style="height:35px;">
                <div class="panel-title form_employee"  style="float:left ;">
                  <div class="row"> 
                     <div class="col-md-6">
                        <label for="ISF" class="col-form-label" style="font-size: 14px; margin-top: 7px;"><?php echo('Select Employee / Sales Partner');?>
                        <i class="text-danger">*</i>
                        </label>
                     </div>
                     <div class="col-md-6">
                        <select class="form-control" id="selectemployeeTypes" required>
                           <option value="">Select Employee / Sales Partner</option>
                           <option value="addEmployees">Employee</option>
                           <option value="salesPartner">Sales Partner</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="panel-title form_employee"  style="float:right ;">
                  <a   style="color:white;"  href="<?php echo base_url('Chrm/manage_employee') ?>?id=<?php echo $_GET['id']; ?>"
                                    class="btnclr btn"><i class="ti-align-justify"> </i>
                                    <?php echo  ('Manage Employee') ?> </a>
               </div>
            </div>
         </div>
         <!-- Create Employee -->
         <div class="panel-body" id="employeeForms" style="display: none;">
                    <div class="errormessage"></div>
                    <form id="employee_create"  enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-6">
                  <div class="form-group row">
                     <label for="first_name" class="col-sm-4 col-form-div"><?php echo display('first_name') ?> <i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <input name="first_name" class="form-control" type="text" placeholder="<?php echo display('first_name') ?>"   oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="middle_name" class="col-sm-4 col-form-div"><?php echo "Middle Name"; ?></label>
                     <div class="col-sm-8">
                        <input name="middle_name" class="form-control" type="text" placeholder="<?php echo "Middle Name"; ?>" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="last_name" class="col-sm-4 col-form-div"><?php echo display('last_name') ?><i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <input name="last_name" class="form-control" type="text" placeholder="<?php echo display('last_name') ?>"   oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">
                     </div>
                  </div>
                  <div class="form-group row" id="designation">
                     <label for="designation" class="col-sm-4 col-form-label"> <?php echo display('designation') ?> <i class="text-danger">*</i> </label>
                     <div class="col-sm-7">
                        <select name="designation"  id="desig"  class="form-control" style="width: 100%;" >
                           <option value="">Select Designation</option>
                           <?php  foreach($desig as $ds){ ?>
                           <option value="<?php  echo $ds['designation'] ;?>"><?php  echo $ds['designation'] ;?></option>
                           <?php  } ?>
                        </select>
                     </div>
                     <div class="col-sm-1">
                        <a  class="btnclr client-add-btn btn" aria-hidden="true"   data-toggle="modal" data-target="#designation_modal" ><i class="fa fa-plus"></i></a>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="phone" class="col-sm-4 col-form-div"><?php echo display('phone') ?> <i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                           <input class="form-control" name="phone" id="mobile" type="tel" style="border: 2px solid #d7d4d6;" placeholder="(XXX) XXX-XXXX" tabindex="3" oninput="formatPhoneNumber(this)">
                        </div>
                  </div>
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                  <input type="hidden" name="encodedId" id="encodedId" value="<?php echo $encodedId; ?>">

                  <div class="form-group row">
                     <label for="Profile Image" class="col-sm-4 col-form-label">
                     Email 
                     </label>
                     <div class="col-sm-8">
                        <input name="email" class="form-control" type="email" placeholder="<?php echo display('email') ?>" id="email" oninput="validateEmail(this)">
                        <span id="validateemails" style="margin-top: 10px;"></span>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="address_line_1" class="col-sm-4 col-form-div"><?php echo display('address_line_1') ?></label>
                     <div class="col-sm-8">
                        <textarea name="address_line_1" rows='1' class="form-control" placeholder="<?php echo display('address_line_1') ?>" id="address_line_1"></textarea> 
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="address_line_2" class="col-sm-4 col-form-div"><?php echo display('address_line_2') ?></label>
                     <div class="col-sm-8">
                        <textarea name="address_line_2" rows='1' class="form-control" placeholder="<?php echo display('address_line_2') ?>" id="address_line_2"></textarea> 
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="city" class="col-sm-4 col-form-div"><?php echo display('city') ?></label>
                     <div class="col-sm-8">
                        <input name="city" class="form-control" type="text" placeholder="<?php echo display('city') ?>" id="city" oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '')">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="state" class="col-sm-4 col-form-label"><?php echo display('state'); ?> <i class="text-danger"></i></label>
                     <div class="col-sm-8">
                        <input class="form-control" name="state" id="state" type="text" style="border:2px solid #D7D4D6;"    placeholder="<?php echo display('state') ?>"  oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="zip" class="col-sm-4 col-form-div"><?php echo display('zip') ?></label>
                     <div class="col-sm-8">
                        <input name="zip" class="form-control" type="text" placeholder="<?php echo display('zip') ?>" id="zip" oninput="exitnumbers(this, 10)">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="country" class="col-sm-4 col-form-div"><?php echo display('country') ?></label>
                     <div class="col-sm-8">
                     <select class="selectpicker countrypicker form-control"
                                        style="width:100%;border: 2px solid #d7d4d6;" data-live-search="true"
                                        data-default="United States" name="country" id="country">
                     </select>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="emergencycontact" class="col-sm-4 col-form-label"> <?php echo "Emergency Contact Person" ?> </label>
                     <div class="col-sm-8">
                        <input class="form-control" name="emergencycontact" id="emergencycontact" type="text"  style="border:2px solid #D7D4D6;"   placeholder="Emergency Contact person"  oninput="limitAlphabetical(this, 20)">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="emergencycontactnum" class="col-sm-4 col-form-label"> <?php echo "Emergency Contact  Number" ?> </label>
                     <div class="col-sm-8">
                        <input class="form-control" name="emergencycontactnum" id="emergencycontactnum" type="number"  style="border:2px solid #D7D4D6;"   placeholder="Emergency Contact  number"  oninput="exitnumbers(this, 10)">
                     </div>
                  </div>
               </div>



                <div class="col-sm-6">
                  <div class="form-group row">
                     <label for="employee_type" class="col-sm-4 col-form-div">
                     Employee Type <i class="text-danger">*</i>
                     </label>
                     <div class="col-sm-7">
                        <select  name="employee_type" id="emp_type" class="form-control"   style="width:450px;" >
                           <option value="">Select Employee Type</option>
                           <option value="Full Time (W4)">Full Time (W4)</option>
                            <option value="Part time">Part time</option>
                           <?php foreach($emp_data as $emp_type){ ?>
                           <option value="<?php  echo $emp_type['employee_type'] ;?>"><?php  echo $emp_type['employee_type'] ;?></option>
                           <?php  } ?>
                        </select>
                     </div>
                     <div class="col-sm-1">
                        <a  class="btnclr client-add-btn btn" aria-hidden="true"   data-toggle="modal" data-target="#employees_type" ><i class="fa fa-plus"></i></a>
                     </div>
                  </div>


                  
                  <div class="form-group row" id="payment_from">
                     <label for="city" class="col-sm-4 col-form-div"><?php echo  ('Sales Commission') ?></label>
                     <div class="col-sm-8">
                        <input name="sc" class="form-control" type="text" placeholder="<?php echo 'Sales Commission Percentage' ?>">
                     </div>
                  </div>
                       <div class="form-group row" id="payment_from">
                        <label for="choice" class="col-sm-4 col-form-div">Commission Withholding</label>
                     <div class="col-sm-8">
                      <input type="radio" name="choice" value="Yes">Yes &nbsp;
                        <input type="radio" name="choice" value="No">No
                        </div>
                  </div>
              <div class="form-group row" id="payment_from">
                     <label for="payroll_type" class="col-sm-4 col-form-label"> Payroll Type <i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <select  name="payroll_type" id="payroll_type"  class="form-control"  style="width:522px;" >
                           <option value="">Select the Payroll Type</option>
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
                     <div class="col-sm-1">
                      </div>
                  </div>
                  <div class="form-group row">
                     <label for="hourly_rate_or_salary" id="cost" class="col-sm-4 col-form-div"> Pay Rate(<?php echo $currency; ?>)  <i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <input name="hrate" class="form-control" type="text" placeholder="<?php echo "Pay Rate" ?>" id="hrate" oninput="validateInput(this)">
                     </div>
                  </div>
                  <div class="form-group row"  id="payment_from">
                     <label for="paytype" class="col-sm-4 col-form-label"> Payment Type </label>
                     <div class="col-sm-7" >
                        <select name="paytype"  id="paytype" class="form-control" style="width: 100%;" >
                           <option value="">Select Type</option>
                           <option value="Cheque">Cheque</option>
                           <option value="Direct Deposit">Direct Deposit</option>
                           <option value="Cash">Cash</option>
                           <?php  foreach($paytype as $ptype){ ?>
                           <option value="<?php  echo $ptype['payment_type'] ;?>"><?php  echo $ptype['payment_type'] ;?></option>
                           <?php  } ?>
                        </select>
                     </div>
                     <div class="col-sm-1">
                        <a  class="btnclr client-add-btn btn" aria-hidden="true"    data-toggle="modal" data-target="#payment_type" ><i class="fa fa-plus"></i></a>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="email" class="col-sm-4 col-form-div">Social Security Number <i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <input name="ssn" class="form-control" type="text" placeholder="Social Security Number"   oninput="exitsocialsecurity(this, 9)">
                     </div>
                  </div>
                  <div class="form-group row" id="bank_name">
                     <label for="bank_name" class="col-sm-4 col-form-label"> <?php echo display('Bank') ?>  </label>
                     <div class="col-sm-7">
                     <select name="bank_name" id="bank_name"  class="form-control bankpayment" required>
                           <?php foreach(getAllBanks() as $bank){ ?>
                           <option value="<?=$bank['bank_name']; ?>"><?=$bank['bank_name']; ?></option>
                           <?php } ?>
                        </select>
                     </div>
                     <div class="col-sm-1">
                        <a data-toggle="modal" href="#add_bank_info"   class="btn btnclr"><i class="fa fa-plus"></i></a>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="blood_group" class="col-sm-4 col-form-div">Routing Number </label>
                     <div class="col-sm-8">
                        <input name="routing_number" class="form-control" type="text" placeholder="Routing Number" oninput="routingrestrict(this, 15)">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="zip" class="col-sm-4 col-form-div"><?php echo 'Account Number' ?></label>
                     <div class="col-sm-8">
                        <input type="text" name="account_number" class="form-control" placeholder="Account Number" oninput="routingrestrict(this, 15)">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="zip" class="col-sm-4 col-form-div"><?php echo ('Employee Tax') ?><i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <select  name="emp_tax_detail" id="emp_tax_detail" class="form-control"  >
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
                              <input list="magic_state_tax" name="state_tax" id="stateTaxDropdown" class="form-control">
                              <datalist id="magic_state_tax">
                                 <?php foreach ($state_tx as $st) { ?>
                                 <option value="<?php echo $st['state']; ?>"><?php echo $st['state']; ?></option>
                                 <?php } ?>
                                 <option value="Not Applicable">Not Applicable</option>
                              </datalist>
                           </div>
                           <div class="form-group fg">
                              <label for="localTaxDropdown">City Tax<i class="text-danger">*</i></label>
                              <input list="magic_local_tax" name="city_tax" id="localTaxDropdown" class="form-control">
                              <datalist id="magic_local_tax">
                                 <?php foreach ($get_info_city_tax as $gtct) { ?>
                                 <option value="<?php echo $gtct['state']; ?>"><?php echo $gtct['state']; ?></option>
                                 <?php } ?>
                                 <option value="Not Applicable">Not Applicable</option>
                              </datalist>
                           </div>
                           <div class="form-group fg">
                              <label for="stateLocalTaxDropdown">County Tax<i class="text-danger">*</i></label>
                              <input list="magic_state_local_tax" name="county_tax" id="stateLocalTaxDropdown" class="form-control">
                              <datalist id="magic_state_local_tax">
                                 <?php foreach ($get_info_county_tax as $gtcty) { ?>
                                 <option value="<?php echo $gtcty['state']; ?>"><?php echo $gtcty['state']; ?></option>
                                 <?php } ?>
                                 <option value="Not Applicable">Not Applicable</option>
                              </datalist>
                           </div>
                           <div class="form-group fg">
                              <label for="stateTax2Dropdown">Other Work Tax<i class="text-danger">*</i></label>
                              <input list="magic_state_tax_2" name="other_working_tax" id="stateTax2Dropdown" class="form-control">
                              <datalist id="magic_state_tax_2">
                                 <option value="Not Applicable">Not Applicable</option>
                              </datalist>
                           </div>
                        </div>
                        <!-- Living Taxes -->
                        <div class="col-sm-6">
                           <h4 style="text-align:center;margin-left:140px;">LIVING LOCATION TAXES</h4>
                           <br>
                           <div class="form-group fg">
                              <label for="livingStateTax">State Tax<i class="text-danger">*</i></label>
                              <input list="magic_living_state_tax" name="living_state_tax" id="livingStateTax" class="form-control">
                              <datalist id="magic_living_state_tax">
                                 <?php foreach ($state_tx as $st) { ?>
                                 <option value="<?php echo $st['state']; ?>"><?php echo $st['state']; ?></option>
                                 <?php } ?>
                                 <option value="Not Applicable">Not Applicable</option>
                              </datalist>
                           </div>
                           <div class="form-group fg">
                              <label for="livingCityTax">City Tax<i class="text-danger">*</i></label>
                              <input list="magic_living_city_tax" name="living_city_tax" id="livingCityTax" class="form-control">
                              <datalist id="magic_living_city_tax">
                                 <?php foreach ($get_info_city_tax as $gtct) { ?>
                                 <option value="<?php echo $gtct['state']; ?>"><?php echo $gtct['state']; ?></option>
                                 <?php } ?>
                                 <option value="Not Applicable">Not Applicable</option>
                              </datalist>
                           </div>
                           <div class="form-group fg">
                              <label for="livingCountyTax">County Tax<i class="text-danger">*</i></label>
                              <input list="magic_living_county_tax" name="living_county_tax" id="livingCountyTax" class="form-control">
                              <datalist id="magic_living_county_tax">
                                 <?php foreach ($get_info_county_tax as $gtcty) { ?>
                                 <option value="<?php echo $gtcty['state']; ?>"><?php echo $gtcty['state']; ?></option>
                                 <?php } ?>
                                 <option value="Not Applicable">Not Applicable</option>
                              </datalist>
                           </div>
                           <div class="form-group fg">
                              <label for="livingOtherTax">Other living Tax<i class="text-danger">*</i></label>
                              <input list="magic_living_other_tax" name="other_living_tax" id="livingOtherTax" class="form-control">
                              <datalist id="magic_living_other_tax">                            
                                 <option value="Not Applicable">Not Applicable</option>
                              </datalist>
                           </div>
                        </div>
                     </div>
                     <br>
                     <div style='float:right;font-weight:bold;'>
                        <!-- Button to add popup data -->
                        <button type="button"   style="background-color:green;margin-left: 335px;width:60px;"  class="btn btnclr"   id="addPopupData">Save</button>
                        <button type="button" class="btn btn-danger"   onclick="closeModal()">Close</button>
                     </div>
                     <br>
                     <br>
                  </div>
                  <div class="form-group row">
                     <label for="withholding_tax" class="col-sm-4 col-form-label">Withholding Tax<i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <button type="button" class="btnclr btn" id="showPopup">Add Withholding Tax</button>
                     </div>
                  </div>
            



                  <div class="form-group row">
                     <label for="ETA" class="col-sm-4 col-form-label"><?php echo display('Attachments ') ?></label>
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



                  <div class="form-group row"  id="payrolltype">
                     <label for="profile_image" class="col-sm-4 col-form-label">
                     Profile Image
                     </label>
                     <div class="col-sm-8">
                        <input type="file" name="profile_image" class="form-control"  accept=".png, .jpg, .jpeg" >
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


            <?php echo form_close() ?>
         </div>
  <script>
   var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
   var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';   
   var employeeId = '<?php echo $this->input->get('id'); ?>';
   $(document).ready(function(){
   var succalert = '<div class="alert alert-success alert-dismissible" role="alert">';
   var failalert = '<div class="alert alert-danger alert-dismissible" role="alert">';
   $("#employee_create").validate({
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
      first_name: "First Name is required",
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
      url: "<?php echo base_url('Chrm/employee_create'); ?>",
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
  </script>
         <!-- Sales Partner -->
         <div class="panel-body" id="salesPartnerForms" style="display: none;">
         <div class="errormessage"></div>        
         <form id="salespartner_create"  enctype="multipart/form-data"  >

         <div class="row">
               <!-- Left Side -->
               <div class="col-sm-6">
                  <div class="form-group row">
                     <label for="first_name" class="col-sm-4 col-form-div"><?php echo display('first_name') ?> <i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <input name="sfirst_name" id="sfirstname" class="form-control" type="text" placeholder="<?php echo display('first_name') ?>"   oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">
                     </div>
                  </div>
 

                     <input type="hidden" name="id"  id="id"  value="<?php echo $decodedId  ; ?>" >

                     
                  <div class="form-group row">
                     <label for="middle_name" class="col-sm-4 col-form-div"><?php echo "Middle Name"; ?></label>
                     <div class="col-sm-8">
                        <input name="smiddle_name" id="smiddle_name" class="form-control" type="text" placeholder="<?php echo "Middle Name"; ?>" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="last_name" class="col-sm-4 col-form-div"><?php echo display('last_name') ?><i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <input name="last_name" class="form-control" type="text" placeholder="<?php echo display('last_name') ?>"   oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="last_name" class="col-sm-4 col-form-div"><?php echo ("Business Name") ?></label>
                     <div class="col-sm-8">
                        <input name="salesbusiness_name" class="form-control" type="text" placeholder="<?php echo "Business Name" ?>" id="salesbusiness_name" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="phone" class="col-sm-4 col-form-div"><?php echo display('phone') ?> <i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                         <input class="form-control" name="phone" id="mobile" type="tel" style="border: 2px solid #d7d4d6;" placeholder="(XXX) XXX-XXXX" tabindex="3" oninput="formatPhoneNumber(this)">

                     </div>
                  </div>
 
                  <div class="form-group row">
                     <label for="Profile Image" class="col-sm-4 col-form-label">
                     Email 
                     </label>
                     <div class="col-sm-8">
                        <input name="email" class="form-control" type="email" placeholder="<?php echo display('email') ?>" id="email" oninput="validateEmail(this)">
                        <span id="validateemails" style="margin-top: 10px;"></span>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="address_line_1" class="col-sm-4 col-form-div"><?php echo display('address_line_1') ?></label>
                     <div class="col-sm-8">
                        <textarea name="address_line_1" rows='1' class="form-control" placeholder="<?php echo display('address_line_1') ?>" id="address_line_1"></textarea> 
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="address_line_2" class="col-sm-4 col-form-div"><?php echo display('address_line_2') ?></label>
                     <div class="col-sm-8">
                        <textarea name="address_line_2" rows='1' class="form-control" placeholder="<?php echo display('address_line_2') ?>" id="address_line_2"></textarea> 
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="city" class="col-sm-4 col-form-div"><?php echo display('city') ?></label>
                     <div class="col-sm-8">
                        <input name="city" class="form-control" type="text" placeholder="<?php echo display('city') ?>" id="city" oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '')">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="state" class="col-sm-4 col-form-label"><?php echo display('state'); ?> <i class="text-danger"></i></label>
                     <div class="col-sm-8">
                        <input class="form-control" name="state" id="state" type="text" style="border:2px solid #D7D4D6;"    placeholder="<?php echo display('state') ?>"  oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="zip" class="col-sm-4 col-form-div"><?php echo display('zip') ?></label>
                     <div class="col-sm-8">
                        <input name="zip" class="form-control" type="text" placeholder="<?php echo display('zip') ?>" id="zip" oninput="exitnumbers(this, 10)">
                     </div>
                  </div>
                  <input type="hidden" name="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>">
                  <div class="form-group row">
                     <label for="country" class="col-sm-4 col-form-div"><?php echo display('country') ?></label>
                     <div class="col-sm-8">
                        <select class="selectpicker countrypicker form-control"
                                        style="width:397px;border: 2px solid #d7d4d6;" data-live-search="true"
                                        data-default="United States" name="country" id="country"></select>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="emergencycontact" class="col-sm-4 col-form-label"> <?php echo "Emergency Contact Person" ?> </label>
                     <div class="col-sm-8">
                        <input class="form-control" name="emergencycontact" id="emergencycontact" type="text"  style="border:2px solid #D7D4D6;"   placeholder="Emergency Contact Person"  oninput="limitAlphabetical(this, 20)">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="emergencycontactnum" class="col-sm-4 col-form-label"> <?php echo "Emergency Contact  number" ?> </label>
                     <div class="col-sm-8">
                        <input class="form-control" name="emergencycontactnum" id="emergencycontactnum" type="number"  style="border:2px solid #D7D4D6;"   placeholder="Emergency Contact Number"  oninput="exitnumbers(this, 10)">
                     </div>
                  </div>
               </div>
                <div class="col-sm-6">
                  <div class="form-group row" id="payment_from">
                     <label for="city" class="col-sm-4 col-form-div"><?php echo  ('Sales Commission') ?></label>
                     <div class="col-sm-8">
                        <input name="sc" class="form-control" type="text" placeholder="<?php echo 'Sales Commission Percentage' ?>">
                     </div>
                  </div>
                  <div class="form-group row" id="payment_from">
                        <label for="choice" class="col-sm-4 col-form-div">Commission Withholding</label>
                     <div class="col-sm-8">
                        <input type="radio" name="choice" value="Yes">Yes &nbsp;
                        <input type="radio" name="choice" value="No">No
                        </div>
                  </div>
                  <div class="form-group row">
                     <label for="email" class="col-sm-4 col-form-div">Social security number <i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <input id="ssnInput" name="ssnInput" class="form-control validation_group" type="text" placeholder="Social Security Number"   oninput="exitsocialsecurity(this, 9)">
                     </div>
                     <br><br>
                     <span style="margin-left: 532px; font-weight: bold;">(OR)</span>
                  </div>
                  <div class="form-group row">
                     <label for="hourly_rate_or_salary" id="cost" class="col-sm-4 col-form-div"><?php echo ('Federal Identification Number') ?> <i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <input id="federalidentificationnumber" name="federalidentificationnumber" class="form-control validation_group" type="text" placeholder="Federal Identification Number" oninput="exitsocialsecurity(this, 9)">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="hourly_rate_or_salary" id="cost" class="col-sm-4 col-form-div"><?php echo ('Federal Tax Classification') ?> <i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <select name="federaltaxclassification" id="federaltaxclassification" class="form-control" style="width: 100%;"  >
                           <option value="">Select Federal Tax Classification</option>
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
                     <div class="col-sm-7" >
                        <select name="paytype"  id="paytype" class="form-control" style="width: 100%;" >
                           <option value="">Select Type</option>
                           <option value="Cheque">Cheque</option>
                           <option value="Direct Deposit">Direct Deposit</option>
                           <option value="Cash">Cash</option>
                           <?php  foreach($paytype as $ptype){ ?>
                           <option value="<?php  echo $ptype['payment_type'] ;?>"><?php  echo $ptype['payment_type'] ;?></option>
                           <?php  } ?>
                        </select>
                     </div>
                     <div class="col-sm-1">
                        <a  class="btnclr client-add-btn btn" aria-hidden="true"    data-toggle="modal" data-target="#payment_type" ><i class="fa fa-plus"></i></a>
                     </div>
                  </div>
                  <div class="form-group row" id="bank_name">
                     <label for="bank_name" class="col-sm-4 col-form-label"> <?php echo display('Bank') ?>  </label>
                     <div class="col-sm-7">
                       <select name="bank_name" id="bank_name"  class="form-control bankpayment" style="width: 100%;" required>
                           <?php foreach(getAllBanks() as $bank){ ?>
                           <option value="<?=$bank['bank_name']; ?>"><?=$bank['bank_name']; ?></option>
                           <?php } ?>
                        </select>
                     </div>
                     <div class="col-sm-1">
                        <a data-toggle="modal" href="#add_bank_info"   class="btn btnclr"><i class="fa fa-plus"></i></a>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="blood_group" class="col-sm-4 col-form-div">Routing number </label>
                     <div class="col-sm-8">
                        <input name="routing_number" class="form-control" type="text" placeholder="Routing Number" oninput="routingrestrict(this, 15)">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="zip" class="col-sm-4 col-form-div"><?php echo 'Account Number' ?></label>
                     <div class="col-sm-8">
                        <input type="text" name="account_number" class="form-control" placeholder="Account Number" oninput="routingrestrict(this, 15)">
                     </div>
                  </div>

            <div class="form-group row">
                     <label for="zip" class="col-sm-4  "><?php echo ('Employee Tax') ?><i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <select  name="emp_tax_detail" id="emp_tax_detail" class="form-control" style="width:522px;"  >
                           <option value="">Select Tax</option>
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
                              <input list="magic_state_tax" name="state_tax" id="stateTaxDropdown" class="form-control">
                              <datalist id="magic_state_tax">
                                 <?php foreach ($state_tx as $st) { ?>
                                 <option value="<?php echo $st['state']; ?>"><?php echo $st['state']; ?></option>
                                 <?php } ?>
                                 <option value="Not Applicable">Not Applicable</option>
                              </datalist>
                           </div>
                           <div class="form-group fg">
                              <label for="localTaxDropdown">City Tax<i class="text-danger">*</i></label>
                              <input list="magic_local_tax" name="city_tax" id="localTaxDropdown" class="form-control">
                              <datalist id="magic_local_tax">
                                 <?php foreach ($get_info_city_tax as $gtct) { ?>
                                 <option value="<?php echo $gtct['state']; ?>"><?php echo $gtct['state']; ?></option>
                                 <?php } ?>
                                 <option value="Not Applicable">Not Applicable</option>
                              </datalist>
                           </div>
                           <div class="form-group fg">
                              <label for="stateLocalTaxDropdown">County Tax<i class="text-danger">*</i></label>
                              <input list="magic_state_local_tax" name="county_tax" id="stateLocalTaxDropdown" class="form-control">
                              <datalist id="magic_state_local_tax">
                                 <?php foreach ($get_info_county_tax as $gtcty) { ?>
                                 <option value="<?php echo $gtcty['state']; ?>"><?php echo $gtcty['state']; ?></option>
                                 <?php } ?>
                                 <option value="Not Applicable">Not Applicable</option>
                              </datalist>
                           </div>
                           <div class="form-group fg">
                              <label for="stateTax2Dropdown">Other Work Tax<i class="text-danger">*</i></label>
                              <input list="magic_state_tax_2" name="other_working_tax" id="stateTax2Dropdown" class="form-control">
                              <datalist id="magic_state_tax_2">
                                 <option value="Not Applicable">Not Applicable</option>
                              </datalist>
                           </div>
                        </div>
                        <!-- Living Taxes -->
                        <div class="col-sm-6">
                           <h4 style="text-align:center;margin-left:140px;">LIVING LOCATION TAXES</h4>
                           <br>
                           <div class="form-group fg">
                              <label for="livingStateTax">State Tax<i class="text-danger">*</i></label>
                              <input list="magic_living_state_tax" name="living_state_tax" id="livingStateTax" class="form-control">
                              <datalist id="magic_living_state_tax">
                                 <?php foreach ($state_tx as $st) { ?>
                                 <option value="<?php echo $st['state']; ?>"><?php echo $st['state']; ?></option>
                                 <?php } ?>
                                 <option value="Not Applicable">Not Applicable</option>
                              </datalist>
                           </div>
                           <div class="form-group fg">
                              <label for="livingCityTax">City Tax<i class="text-danger">*</i></label>
                              <input list="magic_living_city_tax" name="living_city_tax" id="livingCityTax" class="form-control">
                              <datalist id="magic_living_city_tax">
                                 <?php foreach ($get_info_city_tax as $gtct) { ?>
                                 <option value="<?php echo $gtct['state']; ?>"><?php echo $gtct['state']; ?></option>
                                 <?php } ?>
                                 <option value="Not Applicable">Not Applicable</option>
                              </datalist>
                           </div>
                           <div class="form-group fg">
                              <label for="livingCountyTax">County Tax<i class="text-danger">*</i></label>
                              <input list="magic_living_county_tax" name="living_county_tax" id="livingCountyTax" class="form-control">
                              <datalist id="magic_living_county_tax">
                                 <?php foreach ($get_info_county_tax as $gtcty) { ?>
                                 <option value="<?php echo $gtcty['state']; ?>"><?php echo $gtcty['state']; ?></option>
                                 <?php } ?>
                                 <option value="Not Applicable">Not Applicable</option>
                              </datalist>
                           </div>
                           <div class="form-group fg">
                              <label for="livingOtherTax">Other living Tax<i class="text-danger">*</i></label>
                              <input list="magic_living_other_tax" name="other_living_tax" id="livingOtherTax" class="form-control">
                              <datalist id="magic_living_other_tax">
                                 <option value="Not Applicable">Not Applicable</option>
                              </datalist>
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
                     <label for="ETA" class="col-sm-4 col-form-label"><?php echo display('Attachments') ?></label>
                     <div class="col-sm-8">
                     <input type="file" name="salefiles[]" class="form-control" multiple />
                  </div>
                  </div>

 

                  <div class="form-group row"  id="payrolltype">
                     <label for="profile_image" class="col-sm-4 col-form-label">
                     Profile Image
                     </label>
                     <div class="col-sm-8">
                        <input type="file" name="profile_image" class="form-control">
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
   $.validator.addMethod("validation_group", function(value, element, param) {
        var ssnInput = $('#ssnInput').val();
        var federalidentificationnumber = $('#federalidentificationnumber').val();
        return (ssnInput.length > 0 || federalidentificationnumber.length > 0);
    }, "Social security number or Federal Identification Number is required.");
 $("#salespartner_create").validate({
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
  var formData = new FormData($("#salespartner_create")[0]);
  formData.append(csrfName, csrfHash);
  $.ajax({
    type: "POST",
    dataType: "json",
    url: "<?php echo base_url('Chrm/salespartner_create'); ?>",
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
</script>
<div class="modal fade" id="myModal1" role="dialog" >
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content" style="margin-top: 190px;">
         <div class="modal-header btnclr"  style="text-align:center;" >
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?php echo ('Add Employee') ?></h4>
         </div>
         <div class="modal-body" id="bodyModal1" style="text-align:center;font-weight:bold;">
         </div>
         <div class="modal-footer">
         </div>
      </div>
   </div>
</div>
<!------ add new payroll Type -->
<div class="modal fade" id="proll_type" role="dialog">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header btnclr"  style="text-align:center;" >
            <a href="#" class="close" data-dismiss="modal">&times;</a>
            <h4 class="modal-title">Add Payroll Type</h4>
         </div>
         <div class="modal-body">
            <div id="customeMessage" class="alert hide"></div>
            <form id="add_payroll_type" method="post">
               <div class="panel-body">
                  <input type ="hidden" name="csrf_test_name" id="" value="<?php echo $this->security->get_csrf_hash();?>">
                  <div class="form-group row">
                     <label for="customer_name" class="col-sm-3 col-form-label" style="width: auto;">New Payroll Type <i class="text-danger">*</i></label>
                     <div class="col-sm-6">
                        <input class="form-control" name ="new_payroll_type" id="new_payroll_type" type="text" placeholder="New Payroll Type"    tabindex="1">
                     </div>
                  </div>
               </div>
         </div>
         <div class="modal-footer">
         <a href="#" class="btn btnclr"  data-dismiss="modal"><?php echo display('Close') ?> </a>
         <input type="submit" class="btn btnclr"  value=<?php echo display('Submit') ?>>
         </div>
         </form>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" id="employees_type" role="dialog">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header btnclr" style="text-align:center;">
            <a href="#" class="close" data-dismiss="modal">&times;</a>
            <h4 class="modal-title">Add Employee Type</h4>
         </div>
         <div class="modal-body">
            <div class="employeetypeMessage"  ></div>
            <form id="add_employee_type" method="post" >
               <div class="panel-body">
                  <input type="hidden" name="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>">
                  <input type="hidden" name="encodedId" id="encodedId" value="<?php echo $encodedId; ?>">
                  <div class="form-group row">
                     <label for="customer_name" class="col-sm-3 col-form-label" style="width: auto;">New Employee Type <i class="text-danger">*</i></label>
                     <div class="col-sm-6">
                        <input class="form-control" name="employee_type" id="emps_type" type="text" required placeholder="Employee Type" tabindex="1">
                     </div>
                  </div>
               </div>
            <div class="modal-footer">
               <input type="submit" class="btn btnclr" id="addemptype" value="<?php echo display('Submit'); ?>">
               <a href="#" class="btn btnclr" data-dismiss="modal"><?php echo display('Close'); ?></a>
            </div>
            </form>
         </div>
      </div>
   </div>
</div>
<!------ add new Payment Type -->  
<div class="modal fade" id="payment_type" role="dialog">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header btnclr"  style="text-align:center;" >
            <a href="#" class="close" data-dismiss="modal">&times;</a>
            <h4 class="modal-title"><?php echo display('PAYMENT TYPE') ?></h4>
         </div>
         <div class="modal-body">
            <div class="paymenttypeMessage" ></div>
            <form id="add_pay_type" method="post">
               <div class="panel-body">
                  <input type ="hidden" name="csrf_test_name" id="" value="<?php echo $this->security->get_csrf_hash();?>">
                  <input type="hidden" name="admin_company_id" id="encodedId" value="<?php echo $decodedId; ?>" >
                  <div class="form-group row">
                     <label for="customer_name" class="col-sm-3 col-form-label" style="width: auto;"><?php echo display('New Payment Type') ?> <i class="text-danger">*</i></label>
                     <div class="col-sm-6">
                        <input class="form-control" name ="new_payment_type" id="new_payment_type" type="text" requried=""  placeholder="New Payment Type"      tabindex="1">
                        </div>
                    </div>
                  </div>
               </div>
         <div class="modal-footer">
         <input type="submit" class="btn btnclr"  value=<?php echo display('Submit') ?>>
         <a href="#" class="btn btnclr"  data-dismiss="modal"><?php echo display('Close') ?> </a>
      </div>
         </form>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!------ add new designation_modal -->  
<div class="modal fade" id="designation_modal" role="dialog">
   <div class="modal-dialog" role="document">
      <!-- <div class="modal-dialog" role="document"> -->
      <div class="modal-content">
         <div class="modal-header btnclr"  style="text-align:center;" >
            <a href="#" class="close" data-dismiss="modal">&times;</a>
            <h4 class="modal-title"><?php echo ('Designation') ?></h4>
         </div>
         <div class="modal-body">
            <div class="designationMessage" ></div>
            <form id="add_designation" method="post">
               <div class="panel-body">
                  <input type ="hidden" name="csrf_test_name" id="" value="<?php echo $this->security->get_csrf_hash();?>">
                  <input type="hidden" name="encodedId" id="encodedId" value="<?php echo $encodedId; ?>" >
                  <div class="form-group row">
                     <label for="customer_name" class="col-sm-3 col-form-label" style="width: auto;"><?php echo ('New Designation') ?> <i class="text-danger">*</i></label>
                     <div class="col-sm-6">
                        <input class="form-control" name="designation" id="designation" type="text" placeholder="Designation" tabindex="1">
                     </div>
                  </div>
               </div>
         </div>
         <div class="modal-footer">
         <input type="submit" class="btn btnclr"   value=<?php echo display('Submit') ?>>
         <a href="#" class="btn btnclr"   data-dismiss="modal"><?php echo display('Close') ?> </a>
         </div>
         </form>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" id="add_bank_info">
   <div class="modal-dialog">
      <div class="modal-content" style="text-align:center;" >
         <div class="modal-header btnclr" >
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title"><?php echo display ('ADD BANK ') ?></h4>
         </div>
         <div class="container"></div>
         <div class="modal-body">
            <div class="bankMessage"></div>
            <form id="add_bank"  method="post">
               <div class="panel-body">
                  <input type ="hidden" name="csrf_test_name" id="" value="<?php echo $this->security->get_csrf_hash();?>">
                  <input type="hidden" name="encodedId" id="encodedId" value="<?php echo $encodedId; ?>" >
                  <div class="form-group row">
                     <label for="bank_name" class="col-sm-4 col-form-label"><?php echo display('bank_name') ?> <i class="text-danger">*</i></label>
                     <div class="col-sm-6">
                        <input type="text" class="form-control" name="bank_name" id="bank_name" required="" placeholder="<?php echo display('bank_name') ?>" tabindex="1"/>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="ac_name" class="col-sm-4 col-form-label"><?php echo display('ac_name') ?> <i class="text-danger">*</i></label>
                     <div class="col-sm-6">
                        <input type="text" class="form-control" name="ac_name" id="ac_name" required="" placeholder="<?php echo display('ac_name') ?>" tabindex="2"/>
                     </div>
                  </div>
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                  <div class="form-group row">
                     <label for="ac_no" class="col-sm-4 col-form-label"><?php echo display('ac_no') ?> <i class="text-danger">*</i></label>
                     <div class="col-sm-6">
                        <input type="text" class="form-control" name="ac_no" id="ac_no" required="" placeholder="<?php echo display('ac_no') ?>" tabindex="3"/>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="branch" class="col-sm-4 col-form-label"><?php echo display('branch') ?> <i class="text-danger">*</i></label>
                     <div class="col-sm-6">
                        <input type="text" class="form-control" name="branch" id="branch" required="" placeholder="<?php echo display('branch') ?>" tabindex="4"/>
                     </div>
                  </div>
         <div class="form-group row">
                                <label for="country"
                                    class="col-sm-4 col-form-label"><?php echo  display('country'); ?><i
                                        class="text-danger">&nbsp;*</i></label>
                                <div class="col-sm-6">
                                    <select class="selectpicker countrypicker form-control"
                                        style="width:100%;border: 2px solid #d7d4d6; " data-live-search="true"
                                        data-default="United States" name="country" id="country"></select>
                                </div>
                           </div>
                      </div>
                   </div>
         <div class="modal-footer">
         <div class="row">
         <div class="col-sm-8">
         </div>
         <div class="col-sm-4">
         <input type="submit" class="btn btnclr"   id="addBank" name="addBank"  value=<?php echo display('Submit') ?>>
         <a href="#" class="btn btnclr"   data-dismiss="modal"><?php echo display('Close') ?> </a>
      </div>
         </div>  </div>
         </form>
      </div>
   </div>
</div>
<script>
   var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
   var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
   $(document).ready(function () {
        $('#add_city_tax').submit(function (e) {
            e.preventDefault();
            var formData = $("#add_city_tax").serialize();
            formData += "&" + $.param({ csrf_test_name: csrfHash });
            $.ajax({
                type: 'POST',
                data: formData,
                dataType: "json",
                url: '<?php echo base_url(); ?>Cinvoice/add_city_tax',
                success: function (data1, statut) {
                    var $datalist = $('#magic_city_tax');
                    $datalist.empty();
                    for (var i = 0; i < data1.length; i++) {
                        var option = $('<option/>').attr('value', data1[i].city_tax).text(data1[i].city_tax);
                        $datalist.append(option);
                    }
                    $('#new_city_tax').val('');
                    $("#bodyModal1").html("City Tax Added Successfully");
                    $('#city_tax').modal('hide');
                    $('#citytx').show();
                    $('#myModal1').modal('show');
                    window.setTimeout(function () {
                        $('#city_tax').modal('hide');
                        $('#myModal1').modal('hide');
                    }, 2000);
                }
            });
        });
    });
   5.
   // Payroll Insert Data
     $('#add_payroll_type').submit(function(e){
       e.preventDefault();
         var data = {
           data : $("#add_payroll_type").serialize()
         };
         data[csrfName] = csrfHash;
         $.ajax({
             type:'POST',
             data: $("#add_payroll_type").serialize(),
            dataType:"json",
             url:'<?php echo base_url();?>Cinvoice/add_paymentroll_type',
             success: function(data2, statut) {
          var $select = $('select#payroll_type');
               $select.empty();
               console.log(data);
                 for(var i = 0; i < data2.length; i++) {
                    console.log(data2);
           var option = $('<option/>').attr('value', data2[i].proll_type).text(data2[i].proll_type);
           $select.append(option);  
       }
         $('#new_payroll_type').val('');
         $("#bodyModal1").html("Payroll Added Successfully");
         $('#proll_type').modal('hide');
         $('#payroll_type').show();
          $('#myModal1').modal('show');
         window.setTimeout(function(){
           $('#proll_type').modal('hide');
          $('#myModal1').modal('hide');
       }, 2000);
        }
         });
     });


 
   var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
   var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
     $("#add_pay_type").validate({
    rules: {
      new_payment_type: "required"
    },
    messages: {
      new_payment_type: "Payment Type is required"
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
        $.ajax({
            type: 'POST',
            url:'<?php echo base_url();?>Cinvoice/add_payment_type',
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(response) {
  
                 if (response.status === 'success') {
                  var $select = $('select#paytype');
                  $('select#paytype').empty();
                  for(var i = 0; i < response.pterms.length; i++) {
                     var option = $('<option/>').attr('value', response.pterms[i].payment_type).text(response.pterms[i].payment_type);
                     $select.append(option); 
                  }  
                  $('.paymenttypeMessage').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
                  setTimeout(function() {
                  $('#payment_type').modal('hide');
                  }, 1500);
                  } else {
                    $('.paymenttypeMessage').html('<div class="alert alert-danger alert-dismissible" role="alert">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">×</span></button>' +
                        response.msg + '</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
            }
        });
    }
});
 

 

     $(function() {  
       $("#instuc_p2").hide();
       $(".emply_form").hide();
       $(".next_pg").click(function(){  
       $("#instuc_p2").show();
       $("#instuc_p1").hide();
   });  
   $(".emply_form_btn").click(function(){
       $(".emply_form").show();
       $("#instuc_p2").hide();
       $("#instuc_p1").hide();
   })
   });  
     // Payroll Insert Data
     $('#add_payroll_type').submit(function(e){
       e.preventDefault();
         var data = {
           data : $("#add_payroll_type").serialize()
         };
         data[csrfName] = csrfHash;
         $.ajax({
             type:'POST',
             data: $("#add_payroll_type").serialize(), 
            dataType:"json",
             url:'<?php echo base_url();?>Cinvoice/add_paymentroll_type',
             success: function(data2, statut) {
          var $select = $('select#payrolltype');
               $select.empty();
               console.log(data);
                 for(var i = 0; i < data2.length; i++) {
                    console.log(data2);
           var option = $('<option/>').attr('value', data2[i].payroll_type).text(data2[i].payroll_type);
           $select.append(option); 
       }
         $('#new_payroll_type').val('');
         $("#bodyModal1").html("Payroll Added Successfully");
         $('#payroll_type').modal('hide');
         $('#payrolltype').show();
          $('#myModal1').modal('show');
         window.setTimeout(function(){
           $('#payroll_type').modal('hide');
          $('#myModal1').modal('hide');
       }, 2000);
        }
         });
     });
$("#add_designation").validate({
    rules: {
      designation: "required"
    },
    messages: {
      designation: "Designation  is required"
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
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>Chrm/add_designation_data',  
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(response) {
               console.log(response.get_designation, "response.get_designation");
                if (response.status === 'success') {
                  var $select = $('select#desig');
                  $('select#desig').empty();
                  for(var i = 0; i < response.get_designation.length; i++) {
                     var option = $('<option/>').attr('value', response.get_designation[i].designation).text(response.get_designation[i].designation);
                     $select.append(option); 
                  }  
                  $('.designationMessage').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
                  setTimeout(function() {
                  $('#designation_modal').modal('hide');
                  }, 1500);
                  } else {
                    $('.designationMessage').html('<div class="alert alert-danger alert-dismissible" role="alert">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">×</span></button>' +
                        response.msg + '</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
            }
        });
    }
});




 // Insert Employeee Type
   $("#add_employee_type").validate({
    rules: {
      employee_type: "required"
    },
    messages: {
      employee_type: "Employee Type is required"
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
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>Cinvoice/add_employee_type', 
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(response) {
                 if (response.status === 'success') {
                  var $select = $('select#emp_type');
                  $('select#emp_type').empty();
                  for(var i = 0; i < response.get_employeetype.length; i++) {
                     var option = $('<option/>').attr('value', response.get_employeetype[i].employee_type).text(response.get_employeetype[i].employee_type);
                     $select.append(option); 
                  }  
                  $('.employeetypeMessage').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
                  setTimeout(function() {
                  $('#employees_type').modal('hide');  
                  }, 1500);
                  } else {
                    $('.employeetypeMessage').html('<div class="alert alert-danger alert-dismissible" role="alert">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">×</span></button>' +
                        response.msg + '</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
            }
        });
    }
});
 
 
   $("#add_bank").validate({
    rules: {
      bank_name: "required",
      ac_name: "required",
      ac_no: "required",
      branch: "required"
  
    },
    messages: {
      bank_name: "Bank Name is required",
      ac_name: "A/C Name is required",
      ac_no: "A/C Number is required",
      branch: "Branch is required",
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
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>Csettings/add_new_bank',  
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(response) {
                 if (response.status === 'success') {
                  var $select = $('select#bank_name'); 
                  $('select#bank_name').empty();
                  for(var i = 0; i < response.get_bank.length; i++) {
                     var option = $('<option/>').attr('value', response.get_bank[i].bank_name).text(response.get_bank[i].bank_name);
                     $select.append(option); 
                  }  
                  $('.bankMessage').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
                  setTimeout(function() {
                  $('#add_bank_info').modal('hide');
                  }, 1500);
                  } else {
                    $('.bankMessage').html('<div class="alert alert-danger alert-dismissible" role="alert">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">×</span></button>' +
                        response.msg + '</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
            }
        });
    }
});
 




</script>
<script type="text/javascript">
   var payrollTypeSelect = document.getElementById('payroll_type');
       var asteriskSpan = document.getElementById('asterisk');
       payrollTypeSelect.addEventListener('change', function() {
           var hrateInput = document.getElementById('hrate');
           if (this.value === 'SalesCommission') {
               hrateInput.removeAttribute('required');
           }  
       });

       
       payrollTypeSelect.dispatchEvent(new Event('change'));
       $(document).ready(function(){
       $('#payroll_type').change(function(){
           var selectedOption = $(this).val();
           if(selectedOption === 'Hourly') {
                $('#cost').text('Pay Rate (Hourly)').append('<i class="text-danger">*</i>').show(); 
               $('#hrate').show(); 
           } else if (selectedOption === 'SalesCommission') {
               $('#cost').hide(); 
               $('#hrate').hide(); 
           } else {
                $('#cost').text('Pay Rate (Daily)').append('<i class="text-danger">*</i>').show(); 
               $('#hrate').show(); 
           }
       });
   });



      const dt = new DataTransfer(); 
      $("#attachment").on('change', function(e){
         // debugger;
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


 


      // $("#attachments").on('change', function(e){
      //    debugger;
      //      for(var i = 0; i < this.files.length; i++){
      //         let fileBloc = $('<span/>', {class: 'file-block'}),
      //              fileName = $('<span/>', {class: 'name', text: this.files.item(i).name});
      //         fileBloc.append('<span class="file-delete"><span><i class="fa fa-trash-o"></i></span></span>')
      //             .append(fileName);
      //         $("#filesList > #files-names").append(fileBloc);
      //     };
      //     for (let file of this.files) {
      //         dt.items.add(file);
      //     }
      //     this.files = dt.files;
      //     $('span.file-delete').click(function(){
      //         let name = $(this).next('span.name').text();
      //         $(this).parent().remove();
      //         for(let i = 0; i < dt.items.length; i++){
      //             if(name === dt.items[i].getAsFile().name){
      //                 dt.items.remove(i);
      //                 continue;
      //             }
      //         }
      //         document.getElementById('attachments').files = dt.files;
      //     });
      // });


 

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
      $(document).ready(function(){
         $('#selectemployeeTypes').change(function() {
              var selectedValue = $(this).val();
              if(selectedValue == 'addEmployees') {
                  $('#employeeForms').css('display', 'block');
                  $('#headpartemployeeadd').css('display', 'block');
                  $('#salesPartnerForms').css('display', 'none');
                  $('#headpartsalespartner').css('display', 'none');
              } else if(selectedValue == 'salesPartner') {
                  $('#salesPartnerForms').css('display', 'block');
                  $('#headpartsalespartner').css('display', 'block');
                  $('#employeeForms').css('display', 'none');
                  $('#headpartemployeeadd').css('display', 'none');
              }
          });
      });
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

  
      #bank_name-error , #ac_name-error , #ac_no-error  {
         margin-right: 90px;   
         width: 200px;
      }

      #branch-error{
         margin-right: 122px;   
      }

     
 
</style>
 