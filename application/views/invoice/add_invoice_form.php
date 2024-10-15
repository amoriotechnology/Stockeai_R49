<?php
$modaldata['bootstrap_model'] = array('customer', 'tax_info', 'payment_model','payment_terms', 'bank_info','payment_type');
$this->load->view('include/bootstrap_model', $modaldata);
?>
<style>
.content-header {
    margin-top: -20px;
    height: 60px;
}
.slab_no{
   border:none;
   background-color:inherit;
}
   </style>
<div class="content-wrapper">
<!-- For Sale - Landing cost -->
<div class="modal fade" id="landing_modal" role="dialog" aria-labelledby="landingModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl" role="document">
     <div class="modal-content" style='padding:6px;'>
         <div class="modal-header btnclr" style="text-align:center;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h5 class="modal-title" id="landingModalLabel"><?php echo ('LANDING COST') ?></h5>
         </div>
         <div class="modal-body">
              <div id="errormessage_landing_cost" class="alert"></div>
            <form id="land_form" method="post">
                  <input type ="hidden"  id="admin_company_id" value="<?php echo $_GET['id'];  ?>" name="admin_company_id" />
                  <input type ="hidden"  id="service_invoice" name="service_invoice"  value="<?php echo $voucher_no[0]['voucher'];  ?>" />
                    <input type ="hidden" name="csrf_test_name" id="" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <div style="overflow-x:auto;">
                    <table class="serviceprovider table table-bordered" id="service_1">
                        <thead>
                           <tr style="text-align:center;">
                              <th style="font-size:15px;width: 35px;text-align:center;">Service Provider</th>
                              <th style="font-size:15px;width: 35px;text-align:center;">Description</th>
                              <th style="font-size:15px;width: 35px;text-align:center;">Quantity</th>
                              <th style="font-size:15px;width: 35px;text-align:center;">Rate</th>
                              <th style="font-size:15px;width: 35px;text-align:center;">Total</th>
                              <th style="font-size:15px;width: 5px;text-align:center;">Action</th>
                           </tr>
                        </thead>
                        <tbody id="service_pro">
                           <tr>
                              <td style="text-align:center;">
                                 <input list="magic_pro" id="service_provider_1" class="form-control sp" name="s_p[]" onchange="this.blur();" />
                                 <datalist id="magic_pro">
                                    <?php foreach ($servic_provider as $tx): ?>
                                    <option value="<?php echo $tx['service_provider_name']; ?>"><?php echo $tx['service_provider_name']; ?></option>
                                    <?php endforeach;?>
                                 </datalist>
                              </td>
                              <td style="text-align:center;"><input type="text" id="sp_description_0" class="sp_description form-control" name="sp_description[]"/></td>
                              <td style="text-align:center;"><input type="text" id="sp_qty_0" class="sp_qty form-control" name="sp_qty[]"/></td>
                              <td style="text-align:center;"><input type="text" id="sp_rate_0" class="sp_rate form-control" name="sp_rate[]"/></td>
                              <td style="text-align:center;"><input type="text" id="sp_total_0" readonly class="form-control sp_total" name="sp_total[]"/></td>
                              <td style="text-align:center;">
                                 <button class='delete_provider btn btn-danger' type='button' value='Delete'><i class="fa fa-trash"></i></button>
                              </td>
                           </tr>
                        </tbody>
                        <tfoot>
                           <tr>
                              <td colspan="4" style="text-align:right;font-weight:bold;">Total :</td>
                              <td colspan="2"><input type="text" class="form-control" id="landing_amount" style="float: left;" readonly/></td>
                           </tr>
                           <tr>
                              <td colspan="2"></td>
                              <td colspan="2" style='text-align:left;'>
                                <input type="submit" id="land_amt" class="btnclr" style="border-radius: 5px;padding: 4px;float:right;color:white;font-weight:bold;" value="Apply to the Invoice"/>
                              </td>
                              <td colspan="2">  <button type="button" class="btn btnclr" data-dismiss="modal"><?php echo display('Close'); ?></button></td>
                           </tr>
                        </tfoot>
                     </table>
                </div>
            </form>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- For Sales - To show Product while input in Product Name -->
<div class="modal fade" id="product_model_info" tabindex="-1" role="dialog" aria-labelledby="productModelInfoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 90vw; max-height: 90vh; margin: 0;">
        <div class="modal-content" style="margin-left: 100px;height: 90vh; width: 90vw; overflow: hidden;">
            <div class="modal-header btnclr" style="border-bottom: 1px solid #dee2e6;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #6f2937; background: #cdc222;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="productModelInfoLabel" style="margin: 0;"><?php echo ('PRODUCT') ?></h4>
            </div>
            <div class="modal-body" style="padding: 20px; overflow-y: auto; height: calc(90vh - 120px);">
                <div id="product_data_list"></div>
            </div>
        </div>
    </div>
</div>
   <!--For Sales - SOLD BY Field -  Employee Create Start -->
<div class="modal fade employeeAddModalsdata" id="add_agent" role="dialog">
   <div class="modal-dialog" role="document" style='width: 80% !important;'>
      <div class="modal-content" style="text-align:center;">
         <div class="modal-header btnclr">
            <a href="#" class="close" data-dismiss="modal">&times;</a>
            <h4 class="modal-title"> <?php echo ('EMPLOYEE'); ?> </h4>
         </div>
         <div class="modal-body" style="max-height: 760px; overflow-y: auto;">
         <div id="errormessage_agent"></div>
         <br>
          <form id="add_agent_data" method="post">
             <input type ="hidden"  id="admin_company_id" value="<?php echo $_GET['id'];  ?>" name="admin_company_id" />
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
                     <div class="col-sm-8">
                        <select name="designation"  id="desig"  class="form-control" style="width: 100%;" >
                           <option value="">Select Designation</option>
                           <?php foreach ($desig as $ds) {?>
                           <option value="<?php echo $ds['designation']; ?>"><?php echo $ds['designation']; ?></option>
                           <?php }?>
                        </select>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="phone" class="col-sm-4 col-form-div"><?php echo display('phone') ?> <i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                           <input class="form-control" name ="phone" id="phone" type="tel"  style="border: 2px solid #d7d4d6;"   placeholder="(XXX) XXX-XXXX"    oninput="formatPhoneNumber(this)" >
                     </div>
                  </div>
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                  <div class="form-group row">
                     <label for="Profile Image" class="col-sm-4 col-form-label">
                     Email
                     </label>
                     <div class="col-sm-8">
                        <input name="email" class="form-control" type="email" placeholder="<?php echo display('email') ?>" id="email">
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
                        <select name="country" class="form-control"  style="width:522px;" >
                               <?php foreach (getAllCountries() as $conval) {
    $selectcon = $conval['iso3'] == 'USA' ? 'selected' : '';
    echo '<option ' . $selectcon . ' value="' . $conval['name'] . '">' . $conval['name'] . '</option>';
}?>
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
                     <label for="emergencycontactnum" class="col-sm-4 col-form-label"> <?php echo "Emergency Contact  number" ?> </label>
                     <div class="col-sm-8">
                        <input class="form-control" name="emergencycontactnum" id="emergencycontactnum" type="number"  style="border:2px solid #D7D4D6;"   placeholder="Emergency Contact  number"  oninput="exitnumbers(this, 10)">
                     </div>
                  </div>
               </div>
               <!-- Right Side -->
               <div class="col-sm-6">
                  <div class="form-group row">
                     <label for="employee_type" class="col-sm-4 col-form-div">
                     Employee Type <i class="text-danger">*</i>
                     </label>
                     <div class="col-sm-8">
                        <select  name="employee_type" id="emp_type" class="form-control"   style="width:450px;" >
                           <option value="">Select Employee Type</option>
                           <option value="Full Time (W4)">Full Time (W4)</option>
                            <option value="Part time">Part time</option>
                           <?php foreach ($emp_data as $emp_type) {?>
                           <option value="<?php echo $emp_type['employee_type']; ?>"><?php echo $emp_type['employee_type']; ?></option>
                           <?php }?>
                        </select>
                     </div>
                  </div>
                  <div class="form-group row" id="payment_from">
                     <label for="city" class="col-sm-4 col-form-div"><?php echo ('Sales Commission') ?></label>
                     <div class="col-sm-8">
                        <input name="sc" class="form-control" type="text" placeholder="<?php echo 'sales commission percentage' ?>">
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
                           <?php foreach ($payroll_data as $prolltype) {?>
                           <option value="<?php echo $prolltype['payroll_type']; ?>"><?php echo $prolltype['payroll_type']; ?></option>
                           <?php }?>
                        </select>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="hourly_rate_or_salary" id="cost" class="col-sm-4 col-form-div"> Pay rate(<?php echo $currency; ?>) <i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <input name="hrate" class="form-control" type="text" placeholder="<?php echo "Pay rate" ?>" id="hrate" oninput="validateInput(this)">
                     </div>
                  </div>
                  <div class="form-group row"  id="payment_from">
                     <label for="paytype" class="col-sm-4 col-form-label"> Payment Type </label>
                     <div class="col-sm-8" >
                        <select name="paytype"  id="paytype" class="form-control" style="width: 100%;" >
                           <option value="">Select Type</option>
                           <option value="Cheque">Cheque</option>
                           <option value="Direct Deposit">Direct Deposit</option>
                           <option value="Cash">Cash</option>
                           <?php foreach ($paytype as $ptype) {?>
                           <option value="<?php echo $ptype['payment_type']; ?>"><?php echo $ptype['payment_type']; ?></option>
                           <?php }?>
                        </select>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="email" class="col-sm-4 col-form-div">Social security number <i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <input name="ssn" class="form-control" type="text" placeholder="Social security number"  >
                     </div>
                  </div>
                  <div class="form-group row" id="bank_name">
                     <label for="bank_name" class="col-sm-4 col-form-label"> <?php echo display('Bank') ?>  </label>
                     <div class="col-sm-8">
                        <select name="bank_name" id="bank_name"  class="form-control bankpayment">
                           <option>Select Bank</option>
                           <?php foreach ($bank_data as $bank) {?>
                           <option value="<?php echo $bank['bank_name']; ?>"><?php echo $bank['bank_name']; ?></option>
                           <?php }?>
                        </select>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="blood_group" class="col-sm-4 col-form-div">Routing number </label>
                     <div class="col-sm-8">
                        <input name="routing_number" class="form-control" type="text" placeholder="Routing number" oninput="routingrestrict(this, 15)">
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
                  <div id="popup" class="btnclr popup" style='display:none;padding:20px;'>
                     <div class="row">
                       <div class="col-sm-6">
                           <h4 style="text-align:center;margin-left: 140px;">WORK LOCATION TAXES</h4>
                           <br>
                           <div class="form-group fg" >
                              <label for="stateTaxDropdown">State Tax<i class="text-danger">*</i></label>
                              <input list="magic_state_tax" name="state_tax" id="stateTaxDropdown" class="form-control">
                              <datalist id="magic_state_tax">
                                 <?php foreach ($state_tx as $st) {?>
                                 <option value="<?php echo $st['state']; ?>"><?php echo $st['state']; ?></option>
                                 <?php }?>
                                 <option value="Not Applicable">Not Applicable</option>
                              </datalist>
                           </div>
                           <div class="form-group fg">
                              <label for="localTaxDropdown">City Tax<i class="text-danger">*</i></label>
                              <input list="magic_local_tax" name="city_tax" id="localTaxDropdown" class="form-control">
                              <datalist id="magic_local_tax">
                                 <?php foreach ($get_info_city_tax as $gtct) {?>
                                 <option value="<?php echo $gtct['state']; ?>"><?php echo $gtct['state']; ?></option>
                                 <?php }?>
                                 <option value="Not Applicable">Not Applicable</option>
                              </datalist>
                           </div>
                           <div class="form-group fg">
                              <label for="stateLocalTaxDropdown">County Tax<i class="text-danger">*</i></label>
                              <input list="magic_state_local_tax" name="county_tax" id="stateLocalTaxDropdown" class="form-control">
                              <datalist id="magic_state_local_tax">
                                 <?php foreach ($get_info_county_tax as $gtcty) {?>
                                 <option value="<?php echo $gtcty['state']; ?>"><?php echo $gtcty['state']; ?></option>
                                 <?php }?>
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
                        <div class="col-sm-6">
                           <h4 style="text-align:center;margin-left:140px;">LIVING LOCATION TAXES</h4>
                           <br>
                           <div class="form-group fg">
                              <label for="livingStateTax">State Tax<i class="text-danger">*</i></label>
                              <input list="magic_living_state_tax" name="living_state_tax" id="livingStateTax" class="form-control">
                              <datalist id="magic_living_state_tax">
                                 <?php foreach ($state_tx as $st) {?>
                                 <option value="<?php echo $st['state']; ?>"><?php echo $st['state']; ?></option>
                                 <?php }?>
                                 <option value="Not Applicable">Not Applicable</option>
                              </datalist>
                           </div>
                           <div class="form-group fg">
                              <label for="livingCityTax">City Tax<i class="text-danger">*</i></label>
                              <input list="magic_living_city_tax" name="living_city_tax" id="livingCityTax" class="form-control">
                              <datalist id="magic_living_city_tax">
                                 <?php foreach ($get_info_city_tax as $gtct) {?>
                                 <option value="<?php echo $gtct['state']; ?>"><?php echo $gtct['state']; ?></option>
                                 <?php }?>
                                 <option value="Not Applicable">Not Applicable</option>
                              </datalist>
                           </div>
                           <div class="form-group fg">
                              <label for="livingCountyTax">County Tax<i class="text-danger">*</i></label>
                              <input list="magic_living_county_tax" name="living_county_tax" id="livingCountyTax" class="form-control">
                              <datalist id="magic_living_county_tax">
                                 <?php foreach ($get_info_county_tax as $gtcty) {?>
                                 <option value="<?php echo $gtcty['state']; ?>"><?php echo $gtcty['state']; ?></option>
                                 <?php }?>
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
                         <button type="button"   style="background-color:green;margin-left: 335px;width:60px;"  class="btn btnclr addPopupData"   id="addPopupData">Save</button>
                     </div>
                     <br>
                     <br>
                  </div>
                  <div class="form-group row">
                     <label for="withholding_tax" class="col-sm-4 col-form-label">Withholding Tax</label>
                     <div class="col-sm-8">
                        <button type="button" class="btnclr btn showPopup">Add Withholding Tax</button>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="ETA" class="col-sm-4 col-form-label"><?php echo display('Attachments ') ?></label>
                        <div class="col-sm-6">
                          <input type="file" name="files[]" class="form-control" multiple  accept=".pdf, .docx, .txt" />
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
                  <div class="form-group">
                     <button type="submit" id="checkSubmit" class="btnclr btn btn-success w-md m-b-5"><?php echo display('save') ?></button>
                  </div>
               </div>
            </div>
            <?php echo form_close() ?>
         </form>
      </div>
   </div>
    </div>   </div>
<section class="content-header">
   <div class="header-icon">
      <figure class="one">
      <img src="<?php echo base_url() ?>asset/images/sales.png"  class="headshotphoto" style="height:50px;" />
   </div>
   <div class="header-title">
      <div class="logo-holder logo-9">
         <h1>Create Sale</h1>
      </div>
        <input type="hidden" name="id" id="id" value="<?php echo $this->input->get('id'); ?>">
      <ol class="breadcrumb" style="border: 3px solid #d7d4d6;">
         <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
         <li><a href="#"><?php echo display('invoice') ?></a></li>
         <li class="active" style="color:orange;"> <?php echo display('Create Sale') ?></li>
      </ol>
   </div>
</section>
<section class="content">
   <div class="row">
          <div class="error_display alert" style='margin-top:-20px;'></div>
      <div class="col-sm-12" style='margin-top:-10px;'>
         <div class="panel panel-bd lobidrag" style="border: 3px solid #d7d4d6;" >
            <div class="panel-heading" style='height:50px;'>
               <div class="panel-title">
                  <div id="block_container">
                     <div id="bloc1" style="float:left;">
                    </div>
                     <div id="bloc2" style="float:right;">
                        <?php //if($this->permission1->method('manage_invoice','read')->access()){ ?>
                        <a   href="<?php  echo base_url(); ?>Cinvoice/manage_invoice?id=<?php echo $_GET['id']; ?>"; class="btnclr btn  m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_invoice') ?> </a>
                        <?php //}?>
                     </div>
                  </div>
               </div>
            </div>
            <div class="panel-body">
             <form id="insert_invoice"  method="post" enctype='multipart/form-data'>
                <input type="hidden" id="makepaymentId" name="makepaymentId">
               <input type="hidden" value='<?php echo $_GET['id']; ?>' name="admin_company_id"/>
                  <div class="row">
                     <div class="col-sm-6" id="payment_from_1">
                        <div class="form-group row">
                           <label for="customer_name" class="col-sm-4 col-form-label"><?php
echo display('customer_name');
?><i class="text-danger">*</i> </label>
                           <div class="col-sm-7">
                              <select name="customer_name"  class="form-control customer_name"  id="customer_id" style="border:2px solid #d7d4d6;" >
                                 <option value=""><?php echo display('Select Customer'); ?></option>
                                 <?php foreach ($customer_details as $customer) {?>
                                 <option value="<?php echo html_escape($customer['customer_id']) ?>"><?php echo html_escape($customer['customer_name']); ?></option>
                                 <?php }?>
                              </select>
                              <input id="autocomplete_customer_id" class="customer_hidden_value abc" style="border: 2px solid #d7d4d6;"  type="hidden" name="customer_id"  >
                           </div>
                           <div class="col-sm-1 mobile_iconcus">
                              <?php //if($this->permission1->method('add_customer','create')->access()){ ?>
                              <a href="#" class="client-add-btn btn btnclr" aria-hidden="true" data-toggle="modal" data-target="#cust_info"><i class="fa fa-user-circle"></i></a>
                              <?php //} ?>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-6" id="payment_from">
                        <div class="form-group row">
                           <label for="date" class="col-sm-4 col-form-label"> <?php echo display('invoice_no') ?><i class="text-danger">*</i></label>
                           <div class="col-sm-8">
                              <input class="form-control" id="invoice" placeholder="Commercial Invoice Number" type="text" name="commercial_invoice_number"  value="<?php if (!empty($voucher_no[0]['voucher'])) {
    $curYear        = date('Y');
    $month          = date('m');
    $vn             = substr($voucher_no[0]['voucher'], 9) + 1;
    echo $voucher_n = 'NS' . $curYear . $month . '-' . $vn;
} else {
    $curYear        = date('Y');
    $month          = date('m');
    echo $voucher_n = 'NS' . $curYear . $month . '-' . '1';
}?>"  />
                           </div>
                           <input class="form-control" type="hidden" name="attachment_id" id="attachment_id"  value="<?php if (!empty($voucher_no[0]['voucher'])) {
    $curYear        = date('Y');
    $month          = date('m');
    $vn             = substr($voucher_no[0]['voucher'], 9) + 1;
    echo $voucher_n = 'NS' . $curYear . $month . '-' . $vn;
} else {
    $curYear        = date('Y');
    $month          = date('m');
    echo $voucher_n = 'NS' . $curYear . $month . '-' . '1';
}?>" readonly />
                        </div>
                     </div>
                  </div>
    <!-- Hidden Inputs -->
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
    <input type="hidden" id="inv_id"/>
    <input type="hidden" id="inv_no"/>
  
    <!-- Invoice Details -->
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group row">
                <label for="date" class="col-sm-4 col-form-label"><?php echo display('Sales Invoice date') ?> <i class="text-danger">*</i></label>
                <div class="col-sm-8">
                    <?php $date = date('Y-m-d');?>
                    <input class="form-control" type="date" name="invoice_date" style="border: 2px solid #d7d4d6;" id="date"  value="<?php echo html_escape($date); ?>" tabindex="4" />
                </div>
            </div>
            <div class="form-group row">
                <label for="billing_address" class="col-sm-4 col-form-label"><?php echo display('Billing Address') ?><i class="text-danger">*</i></label>
                <div class="col-sm-8">
                    <textarea rows="5" cols="50" style="border:2px solid #d7d4d6;" name="billing_address" class="form-control" placeholder='Billing Address' id="billing_address"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="shipping_address" class="col-sm-4 col-form-label"><?php echo display('Shipping Address') ?></label>
                <div class="col-sm-8">
                    <textarea rows="5" cols="50" style="border:2px solid #d7d4d6;" name="shipping_address" class="form-control" placeholder='Shipping Address' id="shipping_address"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="payment_terms" class="col-sm-4 col-form-label"><?php echo display('Payment Terms') ?><i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <select name="terms" id="terms" class="form-control" style="border: 2px solid #d7d4d6;" >
                        <option value=""><?php echo display('Select Payment Terms') ?></option>
                        <?php foreach (PAYMENT_TYPE as $payment_typ) {?>
                            <option value="<?php echo $payment_typ; ?>"><?php echo $payment_typ; ?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="col-sm-1 mobile_iconcus">
                    <a href="#" class="client-add-btn btn btnclr" aria-hidden="true" data-toggle="modal" data-target="#payment_type_new">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
            </div>
            <div class="form-group row">
                <label for="port_of_discharge" class="col-sm-4 col-form-label"><?php echo display('Payment Due date') ?><i class="text-danger">*</i></label>
                <div class="col-sm-8">
                    <input class="form-control" type="date" name="payment_due_date" id="payment_due_date" style="border: 2px solid #d7d4d6;"  tabindex="4" />
                </div>
            </div>
            <div class="form-group row">
                <label for="payment_type" class="col-sm-4 col-form-label"><?php echo display('payment_type') ?></label>
                <div class="col-sm-7">
                   <select name="paytype" id="paytype" class="form-control" style="border: 2px solid #d7d4d6;" tabindex="3">
    <option value=""><?php echo display('Select Payment Type'); ?></option>
    <?php foreach ($paytype as $pt) { ?>
        <option value="<?php echo htmlspecialchars($pt['payment_type']); ?>"><?php echo htmlspecialchars($pt['payment_type']); ?></option>
    <?php } ?>
</select>
                </div>
                <div class="col-sm-1 mobile_iconcus">
                    <a class="client-add-btn btn btnclr" aria-hidden="true" id="myBtn2" data-toggle="modal" data-target="#payment_type">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- Additional Details -->
        <div class="col-sm-6">
            <div class="form-group row">
                <label for="container_number" class="col-sm-4 col-form-label"><?php echo display('Container Number') ?></label>
                <div class="col-sm-8">
                    <input type="text" name="container_no" style="border: 2px solid #d7d4d6;" placeholder="Container Number" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="bl_no" class="col-sm-4 col-form-label"><?php echo display('B/L No') ?></label>
                <div class="col-sm-8">
                    <input type="text" name="bl_no" style="border: 2px solid #d7d4d6;" placeholder="B/L No" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="eta" class="col-sm-4 col-form-label"><?php echo display('Estimated Time of Arrival') ?></label>
                <div class="col-sm-8">
                    <input class="form-control" type="date" name="eta" id="date2" style="border: 2px solid #d7d4d6;" tabindex="4" />
                </div>
            </div>
            <div class="form-group row">
                <label for="etd" class="col-sm-4 col-form-label"><?php echo display('Estimated Time of Departure') ?></label>
                <div class="col-sm-8">
                    <input type="date" name="etd" style="border: 2px solid #d7d4d6;" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="port_of_discharge" class="col-sm-4 col-form-label"><?php echo display('Port Of Discharge') ?></label>
                <div class="col-sm-8">
                    <input class="form-control" type="" size="50" name="Port_of_discharge" style="border: 2px solid #d7d4d6;" placeholder="Port Of Discharge" id="date1" tabindex="4" />
                </div>
            </div>
            <div class="form-group row">
                <label for="account_category" class="col-sm-4 col-form-label">Account Category</label>
                <div class="col-sm-8">
                    <select id="ddl" name="account_category" class="form-control" style="border: 2px solid #d7d4d6;" onchange="configureDropDownLists(this, document.getElementById('ddl2'))">
                        <option value="">Select the Account Category</option>
                        <option value="ASSETS"><?php echo display('ASSETS'); ?></option>
                        <option value="RECEIVABLES"><?php echo display('RECEIVABLES'); ?></option>
                        <option value="INVENTORIES"><?php echo display('INVENTORIES'); ?></option>
                        <option value="PREPAID EXPENSES & OTHER CURRENT ASSETS"><?php echo display('PREPAID EXPENSES & OTHER CURRENT ASSETS'); ?></option>
                        <option value="PROPERTY PLANT & EQUIPMENT"><?php echo display('PROPERTY PLANT & EQUIPMENT'); ?></option>
                        <option value="ACCUMULATED DEPRECIATION & AMORTIZATION"><?php echo display('ACCUMULATED DEPRECIATION & AMORTIZATION'); ?></option>
                        <option value="NON – CURRENT RECEIVABLES"><?php echo display('NON – CURRENT RECEIVABLES'); ?></option>
                        <option value="INTERCOMPANY RECEIVABLES & OTHER NON-CURRENT ASSETS"><?php echo display('INTERCOMPANY RECEIVABLES & OTHER NON-CURRENT ASSETS'); ?></option>
                        <option value="LIABILITIES & PAYABLES"><?php echo display('LIABILITIES & PAYABLES'); ?></option>
                        <option value="ACCRUED COMPENSATION & RELATED ITEMS"><?php echo display('ACCRUED COMPENSATION & RELATED ITEMS'); ?></option>
                        <option value="OTHER ACCRUED EXPENSES"><?php echo display('OTHER ACCRUED EXPENSES'); ?></option>
                        <option value="ACCRUED TAXES"><?php echo display('ACCRUED TAXES'); ?></option>
                        <option value="DEFERRED TAXES"><?php echo display('DEFERRED TAXES'); ?></option>
                        <option value="LONG-TERM DEBT"><?php echo display('LONG-TERM DEBT'); ?></option>
                        <option value="INTERCOMPANY PAYABLES & OTHER NON CURRENT LIABILITIES & OWNERS EQUITIES"><?php echo display('INTERCOMPANY PAYABLES & OTHER NON CURRENT LIABILITIES & OWNERS EQUITIES'); ?></option>
                        <option value="REVENUE"><?php echo display('REVENUE'); ?></option>
                        <option value="COST OF GOODS SOLD"><?php echo display('COST OF GOODS SOLD'); ?></option>
                        <option value="OPERATING EXPENSES"><?php echo display('OPERATING EXPENSES'); ?></option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Account Subcategory</label>
                <div class="col-sm-8">
                    <input class="form-control" name="account_subcat" id="account_subcat" type="text" style="border: 2px solid #d7d4d6;" placeholder="Account Sub Category" tabindex="1">
                </div>
            </div>
            <?php if ($_SESSION['u_type'] == 3) {?>
                <input type="hidden" name="emp_id" id="emp_id" value="<?php echo $get_user_id[0]['user_id']; ?>">
            <?php }?>
            <div class="form-group row">
                <label for="sub_category" class="col-sm-4 col-form-label">Account Subcategory</label>
                <div class="col-sm-8">
                    <select class="form-control" style="border: 2px solid #d7d4d6;" name="sub_category" placeholder="Account Subcategory" id="ddl2">
                        <option value="" disabled>Select Sub Category</option>
                    </select>
                </div>
            </div>
            <?php if ($_SESSION['u_type'] == 2) {?>
                <div class="form-group row">
                    <label for="sold_by" class="col-sm-4 col-form-label">Sold By</label>
                    <div class="col-sm-7">
                        <select name="emp_id" id="emp_id" class="form-control" style="border: 2px solid #D7D4D6;" tabindex="4">
                            <option value="">Select Employee / Sales Partner</option>
                            <?php foreach ($employee_id_get as $pt) {?>
                                <option value="<?php echo $pt['id']; ?>"><?php echo $pt['first_name'] . ' ' . $pt['last_name']; ?></option>
                            <?php }?>
                            <?php foreach ($get_agent_data as $agent) {?>
                                <option value="<?php echo $agent['id']; ?>"><?php echo $agent['agent_name']; ?></option>
                            <?php }?>
                        </select>
                        <input type="hidden" name="selected_text" id="selected_text">
                    </div>
                    <div class="col-sm-1 mobile_iconcus">
                        <a href="#" class="client-add-btn btn btnclr" aria-hidden="true" data-toggle="modal" data-target="#checkemployeeModal">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
            <?php }?>


                  <div class="form-group row">

                            <label for="attachments" class="col-sm-4 col-form-label"><?php echo display('Attachments') ?></label>

                            <div class="col-sm-6">
                                <p>
                                    <label for="attachment">
                                        <a class="btnclr btn text-light" role="button" aria-disabled="false">
                                            <i class="fa fa-upload"></i>&nbsp; Choose Files
                                        </a>
                                    </label>
                                    <input type="file" name="invoicefiles[]" class="upload" id="attachment" style="visibility: hidden; position: absolute;" multiple/>
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

                 <div class="table-responsive">
                     <div id="content" style="overflow-x: auto;">
                        <table class="table normalinvoice table-bordered table-hover" id="normalinvoice_1" style="border:2px solid #d7d4d6;" >
                           <thead>
                              <tr>
                                 <th rowspan="2" class="text-center" style="width:170px;" ><?php echo display('product_name') ?><i class="text-danger">*</i>  &nbsp;&nbsp; </th>
                                 <th rowspan="2" style="width:40px;" class="text-center" ><?php echo display('Bundle No') ?><i class="text-danger">*</i></th>
                                 <th rowspan="2"  class="text-center"><?php echo display('Description') ?></th>
                                 <th rowspan="2" class="text-center" style="width:60px;"><?php echo display('Thick ness') ?><i class="text-danger">*</i></th>
                                 <th rowspan="2" class="text-center"><?php echo display('Supplier Block No') ?><i class="text-danger">*</i></th>
                                 <th rowspan="2" class="text-center" ><?php echo display('Supplier Slab No') ?><i class="text-danger">*</i> </th>
                                 <th colspan="2"   style="width:150px;" class="text-center"><?php echo display('Gross Measurement') ?><i class="text-danger">*</i> </th>
                                 <th rowspan="2" class="text-center"><?php echo display('Gross Sq.Ft') ?></th>
                                 <th rowspan="2" style="width:40px;" class="text-center"><?php echo display('Slab No') ?><i class="text-danger">*</i></th>
                                 <th colspan="2"  style="width:150px;" class="text-center"><?php echo display('Net Measure') ?><i class="text-danger">*</i></th>
                                 <th rowspan="2" class="text-center"><?php echo display('Net Sq.Ft') ?></th>
                                 <th rowspan="2"  class="text-center"><?php echo display('Cost per Sq.Ft') ?></th>
                                 <th rowspan="2"  class="text-center"><?php echo display('Cost per Slab') ?></th>
                                 <th rowspan="2" class="land_th" style="width: 100px" class="text-center"><?php echo "Landing Cost per Sq.Ft" ?></th>
                                 <th rowspan="2" class="land_th" style="width: 100px" class="text-center"><?php echo "Landing Cost per Slab" ?></th>
                                 <th rowspan="2"  class="text-center"><?php echo display('Sales') ?><br/><?php echo display('Price per Sq.Ft') ?></th>
                                 <th rowspan="2"  class="text-center"><?php echo display('Sales Slab Price') ?></th>
                                 <th rowspan="2" class="text-center"><?php echo display('Weight') ?></th>
                                 <th rowspan="2" style="width: 100px" class="text-center"><?php echo display('total') ?></th>
                                 <th rowspan="2" class="text-center"><?php echo display('Action') ?></th>
                              </tr>
                              <tr>
                                 <th class="text-center"><?php echo display('Width') ?></th>
                                 <th class="text-center"><?php echo display('Height') ?></th>
                                 <th class="text-center"  ><?php echo display('Width') ?></th>
                                 <th class="text-center" ><?php echo display('Height') ?></th>
                              </tr>
                           </thead>
                           <tbody class="tbody" id="addPurchaseItem_1">
                              <tr>
                                 <td>
                                    <input type="hidden" name="tableid[]" id="tableid_1"/>
                                    <input list="magicHouses" name="prodt[]" id="prodt_1"  style="width:160px;" class="form-control product_name"  placeholder="Search Product"       onchange="this.blur();" />
                                    <datalist id="magicHouses">
                                       <?php
foreach ($product as $tx) {?>
                                       <option value="<?php echo $tx['product_name'] . '-' . $tx['product_model']; ?>">  <?php echo $tx['product_name'] . '-' . $tx['product_model']; ?></option>
                                       <?php }?>
                                    </datalist>
                                    <input type='hidden' class='common_product autocomplete_hidden_value  product_id_1' name='product_id[]' id='selected_product_id_1' />
                                 </td>
                                 <td>
                                    <input list="magic_bundle" style='width:70px;' name="bundle_no[]" id="bundle_no_1"   class="form-control bundle_no"  placeholder="Search Bundle"  onchange="this.blur();" />
                                    <datalist id="magic_bundle">
                                       <?php
foreach ($bundle as $tx) {?>
                                       <option value="<?php echo $tx['bundle_no']; ?>">  <?php echo $tx['bundle_no']; ?></option>
                                       <?php }?>
                                    </datalist>
                                 </td>
                                 <td>
                                    <input type="text" id="description_1" name="description[]" class="form-control" />
                                 </td>
                                 <td >
                                    <input type="text" name="thickness[]" id="thickness_1"  class="form-control"/>
                                 </td>
                                 <td>
                                    <input list="magic_supplier_block" name="supplier_block_no[]"  id="supplier_b_no_1"   class="form-control supplier_block_no"  placeholder="Search Product"        onchange="this.blur();" />
                                    <datalist id="magic_supplier_block">
                                       <?php
foreach ($supplier_block_no as $tx) {?>
                                       <option value="<?php echo $tx['supplier_block_no']; ?>">  <?php echo $tx['supplier_block_no']; ?></option>
                                       <?php }?>
                                    </datalist>
                                 </td>
                                 <td >
                                    <input type="text"  id="supplier_s_no_1" name="supplier_slab_no[]"  class="form-control"/>
                                 </td>
                                 <td>
                                    <input type="text" id="gross_width_1" name="gross_width[]"  class="gross_width  form-control" />
                                 </td>
                                 <td>
                                    <input type="text" id="gross_height_1" name="gross_height[]"   class="gross_height form-control" />
                                 </td>
                                 <td >
                                    <input type="text"   style="width:60px;" readonly id="gross_sq_ft_1" name="gross_sq_ft[]" class="gross_sq_ft form-control"/>
                                 </td>
                                 <td style="text-align:center;" >
                                    <input type="text"   style="border:none;width:20px;" value="1" class="slab_no" id="slab_no_1" name="slab_no[]"  readonly />
                                 </td>
                                 <td>
                                    <input type="text" id="net_width_1" name="net_width[]"   class="net_width form-control" />
                                 </td>
                                 <td>
                                    <input type="text" id="net_height_1" name="net_height[]"    class="net_height form-control" />
                                 </td>
                                 <td >
                                    <input type="text"   style="width:60px;" readonly id="net_sq_ft_1" name="net_sq_ft[]" class="net_sq_ft form-control"/>
                                 </td>
                                 <td>
                                    <span class="input-symbol-euro"><input type="text" id="cost_sq_ft_1"  name="cost_sq_ft[]"  readonly  style="width:70px;" value="0.00"  class="cost_sq_ft form-control" ></span>
                                 <td >
                                    <span class="input-symbol-euro"> <input type="text"  id="cost_sq_slab_1" name="cost_sq_slab[]"  readonly  style="width:70px;" value="0.00"  class="cost_sq_slab form-control"/></span>
                                 </td>
                                 <td>
                                    <span class="input-symbol-euro">  <input type="text" id="sales_amt_sq_ft_1"  name="sales_amt_sq_ft[]"  style="width:70px;"  placeholder="0.00" class="sales_amt_sq_ft form-control" /></span>
                                 </td>
                                 <td >
                                    <span class="input-symbol-euro">   <input type="text"  id="sales_slab_amt_1" name="sales_slab_amt[]"  style="width:70px;" placeholder="0.00"  class="sales_slab_amt form-control"/>
                                 </td>
                                 </span>
                                 </td>
                                 <td>
                                    <input type="text" id="weight_1" name="weight[]"  class="weight form-control" />
                                 </td>
                                 <td >
                                    <span class="input-symbol-euro"><input  type="text" class="total_price form-control" style="width:80px;" readonly value="0.00"  id="total_amt_1"     name="total_amt[]"/></span>
                                 </td>
                                 <td style="text-align:center;">
                                    <button  class='delete btn btn-danger' id="delete_1" type='button' value='Delete'><i class="fa fa-trash"></i></button>
                                 </td>
                              </tr>
                           </tbody>
                           <tfoot>
                              <tr>
                                 <td style="text-align:right;" colspan="8"><b><?php echo display('Gross Sq.Ft') ?> </b></td>
                                 <td >
                                    <input type="text" id="overall_gross_1" name="overall_gross[]"   class="overall_gross form-control" style="width: 60px"  readonly="readonly"  />
                                 </td>
                                 <td style="text-align:right;" colspan="3"><b><?php echo display('Net Sq.Ft') ?> :</b></td>
                                 <td >
                                    <input type="text" id="overall_net_1" name="overall_net[]"  class="overall_net form-control"  style="width: 60px"  readonly="readonly"  />
                                 </td>
                                 <td >
                                    <input type="text" id="costpersqft_1" name="costpersqft[]"  class="costpersqft form-control"  style="width: 60px"  readonly="readonly"  />
                                 </td>
                                 <td >
                                    <input type="text" id="costperslab_1" name="costperslab[]"  class="costperslab form-control"  style="width: 60px"  readonly="readonly"  />
                                 </td>
                                 <td class="lc_tdfields">
                                    <input type="text" id="landingpersqft_1" name="landingpersqft[]"  class="landingpersqft form-control"  style="width: 60px"  readonly="readonly"  />
                                 </td>
                                 <td class="lc_tdfields">
                                    <input type="text" id="landingperslab_1" name="landingperslab[]"  class="landingperslab form-control"  style="width: 60px"  readonly="readonly"  />
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
                                    <span class="input-symbol-euro">    <input type="text" id="Total_1" name="total[]"   class="b_total form-control"  style="width: 80px" value="0.00"  readonly="readonly"  /> </span>
                                 </td>
                              </tr>
                           </tfoot>
                        </table>
                        <i id="buddle_1" class="btnclr addbundle fa fa-plus" style="margin-right:25px; padding: 10px 12px 10px 12px;float:right;color:white;"   onclick="addbundle(); "aria-hidden="true"></i>
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
                           <input list="magic_tax" name="tx"  id="product_tax" class="form-control"   onchange="this.blur();" />
                              <datalist id="magic_tax">
                                 <?php
foreach ($tax_data as $tx) {?>
                                 <option value="<?php echo $tx['tax_id'] . '-' . $tx['tax'] . '%'; ?>">  <?php echo $tx['tax_id'] . '-' . $tx['tax'] . '%'; ?></option>
                                 <?php }?>
                              </datalist>
                           </td>
                           <td  style="width:20%;"><a href="#" class="client-add-btn btn btnclr" aria-hidden="true" style="color:white;  margin-right: 295px;"  data-toggle="modal" data-target="#tax_info" ><i class="fa fa-plus"></i></a></td>
                        </tr>
                     </table>
                     <input type="hidden" id="paid_convert" name="paid_convert"/>   <input type="hidden" id="bal_convert" name="bal_convert"/>
                    <table border="0" style="width: 100%; border-collapse: collapse; text-align: left;" class="overall table table-bordered table-hover" style="border:2px solid #d7d4d6;">
    <tbody>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="Over_all_Total"><b><?php echo display('Overall TOTAL') ?> :</b></label>
                <input type="text" id="Over_all_Total" name="Over_all_Total" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" value="0.00" readonly="readonly" />
            </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="additional_cost"><b><?php echo ('Additional Cost') ?> :</b></label>
                <input type="text" id="additional_cost" name="additional_cost" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" readonly="readonly" />
            </td>
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="total_gross"><b><?php echo display('Overall Gross Sq.Ft') ?> :</b></label>
                <input type="text" id="total_gross" name="total_gross" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" readonly="readonly" />
            </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="tax_details"><b><?php echo display('TAX DETAILS') ?> :</b></label>
                <input type="text" id="tax_details" name="tax_details" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" value="0.00" readonly="readonly" />
            </td>
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="total_net"><b><?php echo display('Overall Net Sq.Ft') ?> :</b></label>
                <input type="text" id="total_net" name="total_net" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" readonly="readonly" />
            </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="gtotal"><b><?php echo display('GRAND TOTAL') ?> :</b></label>
                <input type="text" id="gtotal" name="gtotal" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" value="0.00" readonly="readonly" />
            </td>
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="total_weight"><b><?php echo display('Overall Weight') ?> :</b></label>
                <input type="text" id="total_weight" name="total_weight" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" readonly="readonly" />
            </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="customer_gtotal"><b><?php echo display('Preferred Currency') ?> :</b></label>
                <input type="text" id="customer_gtotal" name="customer_gtotal" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" readonly />
            </td>
        </tr>
        <tr>
            <!-- Left Side -->
            <td style="width: 50%; padding-right: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="amount_paid"><b><?php echo display('Amount Paid') ?> :</b></label>
                <input type="text" id="amount_paid" name="amount_paid" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" readonly />
            </td>
            <!-- Right Side -->
            <td style="width: 50%; padding-left: 20px; border:none; vertical-align: middle;">
                <label style="width:150px;" for="balance"><b><?php echo display('Balance Amount') ?> :</b></label>
                <input type="text" id="balance" name="balance" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block;" readonly />
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr style="border-right:none; border-left:none; border-bottom:none; border-top:none;">
            <td colspan="2" style="text-align: right; padding: 20px;">
                <input type="submit" value="<?php echo "Additional Cost"; ?>" class="btnclr btn btn-large" id="landing_cost" style="color:white; margin-right: 10px;" />
              <a class="client-add-btn btn btnclr" aria-hidden="true" id="paypls" data-toggle="modal" data-target="#payment_modal">
                        Make Payment
             </a>
            </td>
        </tr>
    </tfoot>
</table>
                  </div>
                  <div class="form-group row">
                     <div class="col-sm-12 ">
                        <table>
                        <tr>
                           <td>
                              <input type="submit" id="add_purchase"   class="btn btn-large btnclr" name="add-packing-list" value=<?php echo display('Save') ?>>
                           </td>
                           <td class="hidden_button">
                              <a    id="final_submit"   class='final_submit btn btnclr'> <?php echo display('submit') ?></a>
                           </td>
                            <td class="hidden_button">
                     <select name="download_select" id="download_select" class="form-control"   style="background-color:<?php echo $setting_detail[0]['button_color']; ?>; color:white;width:auto;"  >
                     <option value="Download"  class="btnclr"   selected><?php echo display('Download') ?></option>
                     <option value="Invoice" ><?php echo display('New Invoice') ?></option>
                     <option value="Packing" ><?php echo display('Packing List') ?></option>
                     </select>
                     </td>
                            <td style="width:20px;" class="hidden_button"></td>
                     <td class="hidden_button">
                     <select name="print_select" id="print_select" class="form-control"  style="background-color:<?php echo $setting_detail[0]['button_color']; ?>; color:white;width:auto;"  >
                     <option class="btnclr"  value="Print" selected><?php echo display('Print') ?></option>
                     <option value="Invoice" ><?php echo display('New Invoice') ?></option>
                     <option value="Packing" ><?php echo display('Packing List') ?></option>
                     </select>
                     </td>
                        </tr>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="billing_address" class="col-sm-2 col-form-label"><?php echo display('Account Details/Additional Information') ?></label>
                     <div class="col-sm-8">
                        <textarea cols="50" rows="4" id="details" name="ac_details" class=" form-control" style="border:2px solid #d7d4d6;"  placeholder='Account Details/Additional Information' id="ac_details" ><?php if (!empty($update_invoice_set[0]->account)) {echo trim($update_invoice_set[0]->account);}?></textarea>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="remark" class="col-sm-2 col-form-label"><?php echo display('Remarks/Conditions') ?></label>
                     <div class="col-sm-8">
                        <textarea rows="3" cols="50" id="remarks" name="remark" class="tass form-control"  style="border:2px solid #d7d4d6;"  placeholder='Remarks/Conditions'     ><?php if (!empty($update_invoice_set[0]->remarks)) {echo trim($update_invoice_set[0]->remarks);}?></textarea>
                     </div>
                  </div>
               </form>
            </div>
            <input type="hidden" id="hdn"/>
            <input type="hidden" id="gtotal_dup"/>
         </div>
      </div>
	  </div>
</section>
<script>
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    var succalert = '<div class="alert alert-success alert-dismissible" role="alert">';
    var failalert = '<div class="alert alert-danger alert-dismissible" role="alert">';
    var alert2 = '</div>';
		  $(document).ready(function(){
         $('.amt_update').hide(); 
         $('.hidden_button').hide();
    $('.land_th').hide();$('.lc_tdfields').hide();
   });
$(document).on('change select input', '.product_name, .bundle_no, .supplier_block_no', function (e) {
  var inputElementId = $(this).attr('id');
    var tableID = $(this).closest('table').attr('id');
   var idParts = inputElementId.split('_');
    var uniqueIdentifier = idParts[idParts.length - 1];
    $('#tableid_'+uniqueIdentifier).val(uniqueIdentifier);
    var tableIdSelector = '#prodt_' + uniqueIdentifier;
     sessionStorage.setItem('current_table_id', tableIdSelector);
     sessionStorage.setItem('current_table', tableID);
    var value = $(this).val();
    var requestType, requestDataKey;
    if ($(this).hasClass('product_name')) {
        requestType = 'product_info';
        requestDataKey = 'prodt';
    } else if ($(this).hasClass('bundle_no')) {
        requestType = 'bundle_info';
        requestDataKey = 'bundle_no';
    } else if ($(this).hasClass('supplier_block_no')) {
        requestType = 'supplier_block_info';
        requestDataKey = 'supplier_block_no';
    }
    var data = {
        requestType: requestType,
        search_value: value,
        [csrfName]: csrfHash
    };
    $.ajax({
        type: 'POST',
        data: data,
        dataType: 'json',
        url: '<?php echo base_url(); ?>Cinvoice/fetch_info_based_on_selection',
        success: function (result) {
            if (result.length > 0) {
                var total = '<table style="width: 100%;  text-align: center;"> <tr> <td style="width: 20%;"></td><td style="text-align: center;"> <input type="text" style="width: auto; max-width: 100%;" class="form-control" id="bundle_search" onkeyup="search()" placeholder="Search for Bundle no.."> </td> <td style="width: 10%;"></td><td style="text-align: center;"> <input type="text" style="width: auto; max-width: 100%;" class="form-control" id="block_search" onkeyup="search()" placeholder="Search for Supplier Block no.."> </td> <td style="width: 10%;"></td><td style="text-align: center;"> <input type="text" style="width: auto; max-width: 100%;" class="form-control" id="slab_search" onkeyup="search()" placeholder="Search for Supplier Slab no.."> </td> <td style="width: 10%;"></td> </tr> </table> <br/>';
                var table_header = "<table style='width:auto;word-wrap:break-word;' class='product_model table table-bordered table-hover'  id='product_table1'> <thead> <tr class='btnclr'><th rowspan='2' class='text-center'>Select All</th> <th rowspan='2' style='width: max-content;' class='text-center'>Product ID</th><th rowspan='2' style='width: max-content;' class='text-center'>Product Name</th>   <th rowspan='2' style='width: max-content;' class='text-center'>Bundle No</th> <th rowspan='2' style='width: max-content;' class='text-center'>Description</th> <th rowspan='2' class='text-center'>Thickness</th> <th rowspan='2' class='text-center'>Supplier Block No</th>  <th rowspan='2' class='text-center' >Supplier Slab No</th> <th colspan='2' style='width: max-content;' class='text-center'>Gross Measurement</th> <th rowspan='2' class='text-center'>Gross Sq. Ft</th> <th rowspan='2' style='width: min-content;' class='text-center'>Bundle No</th> <th rowspan='2' style='width: min-content;' class='text-center'>Slab No</th> <th colspan='2' style='width: max-content;' class='text-center'>Net Measurement</th> <th rowspan='2' class='text-center'>Net Sq. Ft</th> <th rowspan='2' style='width: 80px;' class='text-center'>Cost per Sq. Ft</th> <th rowspan='2' style='width: 80px;' class='text-center'>Cost per Slab</th> <th rowspan='2' style='width: 80px;' class='text-center'>Sales<br/>Price per Sq. Ft</th> <th rowspan='2'  style='width: 80px;' class='text-center'>Sales Slab Price</th> <th rowspan='2' class='text-center'>Weight</th>   <th rowspan='2' style='width: 100px' class='text-center'>Total</th> </tr>  <tr> <th class='btnclr text-center'>Width</th> <th class='btnclr text-center'>Height</th> <th class='btnclr text-center'>Width</th> <th class='btnclr text-center'>Height</th> </tr>  </thead><tbody>";
                var html = "";
                var count = 1;
                result.forEach(function (element) {
                    var sales_price = isNaN(element.price) ? 0 : element.price;
                    html += "<tr><td><input type='checkbox' name='case[]' class='checkbox'/></td><td>" + element.product_id+ "</td><td>" + element.product_name + '-' + element.product_model + "</td><td>" + element.bundle_no + "</td><td>" + element.description_table + "</td><td>" + element.thickness + "</td><td>" + element.supplier_block_no + "</td><td>" + element.supplier_slab_no + "</td><td>" + element.g_width + "</td><td>" + element.g_height + "</td><td>" + element.gross_sqft + "</td><td>" + element.bundle_no + "</td><td>" + count + "</td><td>" + element.n_width + "</td><td>" + element.n_height + "</td><td>" + element.net_sqft + "</td><td>" + element.cost_sqft + "</td><td>" + element.cost_slab + "</td><td>" + element.sales_price_sqft + "</td><td>" + element.sales_slab_price + "</td><td>" + element.weight + "</td><td>" + element.total_amt + "</td><td style='display:none'>" + sales_price + "</td></tr>";
                    count++;
                });
                var all = total + table_header + html;
                $('#product_data_list').html(all);
                $('#product_model_info').modal('show');
            } else {
                $('#product_model_info').modal('hide');
            }
        }
    });
});
//Search in Product List Model - based on Product Name , Supplier Block Number and Bundle Number
function search() {
   const filterSupplierBlockNo = document.getElementById("block_search").value.toUpperCase();
    const filterSupplierSlabNo = document.getElementById("slab_search").value.toUpperCase();
    const filterBundleNo = document.getElementById("bundle_search").value.toUpperCase();
    const table = document.getElementById("product_table1");
    const rows = table.getElementsByTagName("tr");
  for (let i = 0; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName("td");
        if (cells.length > 6) {
            const supplierBlockNo = (cells[6].textContent || cells[6].innerText).toUpperCase();
            const supplierSlabNo = (cells[7].textContent || cells[7].innerText).toUpperCase();
            const bundleNo = (cells[3].textContent || cells[3].innerText).toUpperCase();
           if (
                supplierBlockNo.includes(filterSupplierBlockNo) &&
                supplierSlabNo.includes(filterSupplierSlabNo) &&
                bundleNo.includes(filterBundleNo)
            ) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    }
}

// Function to fill the table rows based on the selected row from the Product Model
$(document).on('click', '.checkbox', function() {
    $('#product_model_info').modal('hide');
    var storedTableIdSelector = sessionStorage.getItem('current_table_id');
    var storedTableId = sessionStorage.getItem('current_table');
   var values = $("input[name='case[]']:checked").closest("td").siblings("td").map(function() {
        return $(this).text();
    }).get();
      var $tableRow = $(storedTableIdSelector).closest("tr");
  var tableId = $(storedTableIdSelector).attr('id');
    var uniqueIdentifier = tableId.split('_').pop();
    var fields = [
        'selected_product_id_','prodt_', 'bundle_no_', 'description_', 'thickness_',
        'supplier_b_no_', 'supplier_s_no_', 'gross_width_', 'gross_height_',
        'gross_sq_ft_', 'net_width_', 'net_height_', 'net_sq_ft_',
        'cost_sq_ft_', 'cost_sq_slab_', 'sales_amt_sq_ft_', 'sales_slab_amt_',
        'weight_', 'total_amt_'
    ];
    $.each(fields, function(index, fieldPrefix) {
        var fieldIndex = index < values.length ? index : 0;
        $tableRow.find('#' + fieldPrefix + uniqueIdentifier).val(values[fieldIndex]);
    });
updateTableTotals(storedTableId);
updateOverallTotals(true);
});
//To show the Landing Cost Model On click Additional Cost
    $('#landing_cost').on('click', function (e) {
   var invoice_no = $('#invoice').val();
  $('#service_invoice').val(invoice_no);
   $('#landing_modal').modal('show');
   e.preventDefault();
   });
  $(document).ready(function(){
var employeeId = $('#encodedId').val();
   var succalert = '<div class="alert alert-success alert-dismissible" role="alert">';
   var failalert = '<div class="alert alert-danger alert-dismissible" role="alert">';
$.validator.addMethod("validation_group", function(value, element, param) {
    var ssnInput = $('#ssnInput').val();
    var federalidentificationnumber = $('#federalidentificationnumber').val();
    return (ssnInput.length > 0 || federalidentificationnumber.length > 0);
}, "Social security number or Federal Identification Number is required.");
 $("#add_salesPartners").validate({
   rules: {
   sfirst_name: "required",
    last_name: "required",  
     //sphone: "required",
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
    // sphone: "Phone is required",
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
    url: "<?php echo base_url('Chrm/salespartner_create'); ?>",
    data: formData,
    contentType: false,
    processData: false,
    success: function(response) {
    if (response.status == 'success') {

   $('#errormessage_salespartner').html('<div class="alert alert-success">' + response.msg + '</div>');
                       
                        var $select = $('select#emp_id');
                        $select.empty();
                        $.each(response.data, function(index, item) {
                            var option = '<option value="' + item.first_name + '">' + item.first_name + '</option>';
$select . append(option);
              
                    });
                       window.setTimeout(function(){
           $('#salesPartners').modal('hide');
           }, 2500);
         
                  }else{
          $('#errormessage_salespartner').html(failalert+response.msg+'</div>'); 
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
 $(document).on('click', '.removebundle', function(){
 var remove_id=$(this).closest('table').attr('id');
 $('#'+remove_id).remove();
updateOverallTotals(true);
 });
    $(document).on('change input keyup','.sp_total',function (e) {
   var sum = 0;
$(".sp_total").each(function() {
if(!isNaN(this.value) && this.value.length!=0) {
   				sum += parseFloat(this.value);
   			}
   		});
   		$("#landing_amount").val(sum.toFixed(2));
   });
    $(document).on('keyup', '.sp_qty,.sp_rate', function (e) {
      ;
   var rate=$(this).closest('table tr').find('.sp_rate').val();
   var qty=$(this).closest('table tr').find('.sp_qty').val();
   var total=rate * qty;
   $(this).closest('table tr').find('.sp_total').val(total);
   var sum = 0;
   		$(".sp_total").each(function() {
   			if(!isNaN(this.value) && this.value.length!=0) {
   				sum += parseFloat(this.value);
   			}
   		});
   	$(this).closest('table').find("#landing_amount").val(sum.toFixed(2));
     });
     $(document).on('keyup', '.normalinvoice tbody tr:last', function (e) {


    var tableId = $(this).closest('table').attr('id');
    var dynamicId = tableId.split('_').pop();


    var $lastRow = $('#addPurchaseItem_' + dynamicId + ' tr:last');
    var $newRow = $lastRow.clone();


    var rowCount = $('#addPurchaseItem_' + dynamicId + ' tr').length;
    var newRowNumber = dynamicId+''+rowCount;


    $newRow.find('datalist, input, select, button').each(function () {
        var $element = $(this);
        var currentId = $element.attr('id');

        if (currentId) {

            var newId = currentId.replace(/\d+$/, newRowNumber);
            $element.attr('id', newId);


            if ($element.is('input') || $element.is('select')) {
                if ($element.hasClass('product_name')) {

                    $element.val('').prop('disabled', false);
                } else {
                    $element.val('');
                }
            }
        }
    });


    $newRow.appendTo('#addPurchaseItem_' + dynamicId);
    $('#normalinvoice_' + dynamicId + ' tbody tr').each(function (index) {
        $(this).find(".slab_no").val(index + 1);
    });
});
   $(document).on('keyup', '.serviceprovider > tbody > tr:last-child', function (e) {
   var tid=$(this).closest('table').attr('id');
   const indexLast = tid.lastIndexOf('_');
   var id = tid.slice(indexLast + 1);
    var $last = $('#service_pro tr:last');
       var num = ($last.index()+1);
       $('#service_pro tr:last').clone().find('datalist,input,select').attr('id', function(i, current) {
           return current.replace(/\d+$/, num);
       }).end().appendTo('#service_pro');
   });
 $(document).on('click', '.delete_provider', function(){
var rowCount = $(this).closest('tbody').find('tr').length;
   if(rowCount>1){
   $(this).closest('tr').remove();
   }
   debugger;
   //    var rate=$(this).closest('table tr').find('.sp_rate').val();
   // var qty=$(this).closest('table tr').find('.sp_qty').val();
   // var total=rate * qty;
   // $(this).closest('table tr').find('.sp_total').val(total);
   var sum = 0;
   		$(".sp_total").each(function() {
   			if(!isNaN(this.value) && this.value.length!=0) {
   				sum += parseFloat(this.value);
   			}
   		});
   	$("#landing_amount").val(sum.toFixed(2));
 });
   $(document).ready(function() {
    // Initialize jQuery Validate
    $("#land_form").validate({
        rules: {
            'sp_qty[]': {
                required: true,
                number: true // Validate that it is a number
            },
            'sp_rate[]': {
                required: true,
                number: true // Validate that it is a number
            },
            's_p[]': {
                required: true
            }
        },
        messages: {
            'sp_qty[]': {
                required: "Supplier Quantity is required",
                number: "Please enter a valid number"
            },
            'sp_rate[]': {
                required: "Supplier Rate is required",
                number: "Please enter a valid number"
            },
            's_p[]': {
                required: "Supplier Name is required"
            }
        },
        submitHandler: function(form) {
            var formData = new FormData(form);
            formData.append(csrfName, csrfHash);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo base_url('Cinvoice/service_invoice_details'); ?>",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status == 'success') {
                        var rowCount = $('.tbody tr').length;
                        var l = $('#landing_amount').val();
                        var l_amt = l / rowCount;
                        $('#errormessage_landing_cost').html(succalert + response.msg + alert2);
                        $('.normalinvoice tbody tr').each(function() {
                            var tableId = $(this).closest('table').attr('id');
                            var tableIndex = tableId.lastIndexOf('_');
                            var tableSuffix = tableId.slice(tableIndex + 1);
                            var slabCost = parseFloat($(this).find('.cost_sq_slab').val()) || 0;
                            var netArea = parseFloat($(this).find('.net_sq_ft').val()) || 0;
                            var totalAmount = parseFloat(l_amt) || 0;
                            var finalAmount = totalAmount + slabCost;
                            var costPerSqFt = (totalAmount + slabCost) / netArea;
                            $(this).find('.landing_field').remove();
                            $(this).find('td').eq(14).after(
                                '<td class="landing_field"><span class="input-symbol-euro">' +
                                '<input type="text" readonly style="width:80px;" name="l_cost[]" value="' + costPerSqFt.toFixed(2) + '" class="form-control l_cost">' +
                                '</span></td>' +
                                '<td class="landing_field"><span class="input-symbol-euro">' +
                                '<input type="text" style="width:80px;" readonly name="l_cost_slab[]" value="' + finalAmount.toFixed(2) + '" class="form-control l_cost_slab">' +
                                '</span></td>'
                            );
                            $('.land_th').show();
                            $('.lc_tdfields').show();
                            updateOverallTotals();
                        });
                        window.setTimeout(function() {
                            $('#landing_modal').modal('hide');
                        }, 2000);
                    } else {
                        $('#errormessage_landing_cost').html(failalert + response.msg + alert2);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        }
    });
});



     $('#customer_id').change(function(e) {
    var data = {
        value: $(this).val()
    };
    data[csrfName] = csrfHash;
    $.ajax({
        type: 'POST',
        data: data,
        dataType: 'json',
        url: '<?php echo base_url(); ?>Cinvoice/getcustomer_data',
        success: function(result, statut) {
            if (result.csrfName) {
                csrfName = result.csrfName;
                csrfHash = result.csrfHash;
            }
       $('#billing_address').html(result[0]['billing_address'] + '\n' +
                                        result[0]['city'] + '\n' +
                                        result[0]['state'] + "-" + result[0]['zip'] + "-" + result[0]['country'] + '\n' +
                                        result[0]['customer_email'] + '\n' + result[0]['phone']);
            $('#shipping_address').html(result[0]['shipping_address'] + '\n' +
                                         result[0]['city'] + '\n' +
                                         result[0]['state'] + "-" + result[0]['zip'] + "-" + result[0]['country'] + '\n' +
                                         result[0]['customer_email'] + '\n' + result[0]['phone']);
            $('#product_tax').val(result[0]['tax_status'] == 1 ? result[0]['tax_percent'] : 0);
            var custo_currency = result[0]['currency_type'];
            $("#autocomplete_customer_id").val(result[0]['customer_id']);
            $("label[for='custocurrency']").html(custo_currency);
            $(".cus").html(custo_currency);
            $.getJSON('https://open.er-api.com/v6/latest/<?php echo $curn_info_default; ?>', function(data) {
                var x = data['rates'][custo_currency];
                var Rate = parseFloat(x).toFixed(2);
                Rate = isNaN(Rate) ? 0 : Rate;
                console.log(Rate);
                $('.hiden').show();
                $(".custocurrency_rate").val(Rate);
            });
        }
    });
});
var succalert = '<div class="alert alert-success alert-dismissible" role="alert">';
    var failalert = '<div class="alert alert-danger alert-dismissible" role="alert">';
     // Custom method to trim input fields
     $.validator.addMethod("trimRequired", function(value, element) {
        return $.trim(value) !== "";
    }, "This field is required.");
    $("#insert_invoice").validate({
        rules: {
            customer_name: "trimRequired",
            payment_due_date: "required",
            billing_address: "required",
            terms: "required",
            commercial_invoice_number: "required"
        },
        messages: {
            customer_name: "Company Name is required",
            payment_due_date: "Payment Due Date is required",
           billing_address : "Billing Address is required" ,
           terms : "Payment Terms is required",
            commercial_invoice_number : "Invoice Number is required"
        },
        errorPlacement: function(error, element) {
            if (element.hasClass("select2-hidden-accessible")) {
                error.insertAfter(element.next('span.select2')); 
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {

            var formData = new FormData($("#insert_invoice")[0]);
            formData.append(csrfName, csrfHash);
                $.ajax({
                    type:"POST",
                    dataType:"json",
                    url:"<?php echo base_url(); ?>Cinvoice/manual_sales_insert?id=<?php echo $_GET['id']; ?>",
                    data:formData,
                    contentType: false, 
                    processData: false, 
                    success:function (response) {
                      if (response.status === 'success') {
                        debugger;
                        $('.hidden_button').show();
                        // $('#errormessage_invoice').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
            $('.error_display').html(succalert + response.msg + alert2);
        
            $('#inv_id').val(response.invoice_id);
            $('#inv_no').val(response.invoice_no);
            window.setTimeout(function() {
                window.location = "<?php echo base_url(); ?>Cinvoice/manage_invoice?id=<?php echo $_GET['id']; ?>";
            }, 2500);
        } else {
           $('.error_display').html(failalert + response.msg + alert2);
         }
                    }
                });
            event.preventDefault();
        }
    });
      $('#product_tax').on('change', function (e) {
             debugger;
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
                 console.log("numhere :"+num +"-"+custo_amt);
                 var value=(num+additional_cost)*custo_amt;
                 var custo_final = isNaN(parseFloat(value)) ? 0 : parseFloat(value);
                   var balance_amount= (num+additional_cost)- paid_amount;
                  $('#tax_details').val(answer.toFixed(2) +" ( "+tax+" )");
                $('#customer_gtotal').val(custo_final.toFixed(2));  
                  $('#balance').val(balance_amount.toFixed(2));
          updateOverallTotals();
                });
 // Employee/Sales Partner - Witholding popup close
   $(document).on('click','.addPopupData',function(){
$(".popup").hide();
   });
   $(document).on('click','.showPopup',function(){
$(".popup").show();
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
  // get Employee select dropdown
      $(document).ready(function(){
         $('.popup').css('display','none');
         $('#getemployeeTypes').change(function() {
              var selectedValue = $(this).val();
              if(selectedValue == 'addEmployees') {
                  $('.employeeAddModalsdata').modal('show');
                  $('#checkemployeeModal').modal('hide');
              } else if(selectedValue == 'salesPartner') {
                  $('.salespartnerAddModalsdata').modal('show');
                  $('#checkemployeeModal').modal('hide');
              }
          });
      });
    // Trigger change event to add payroll rate based on payroll type
   //payrollTypeSelect.dispatchEvent(new Event('change'));
   $(document).ready(function(){
       $('#payroll_type').change(function(){
           var selectedOption = $(this).val();
           if(selectedOption === 'Hourly') {
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
   });
   var payrollTypeSelect = document.getElementById('payroll_type');
       var asteriskSpan = document.getElementById('asterisk');
       payrollTypeSelect.addEventListener('change', function() {
           var hrateInput = document.getElementById('hrate');
           if (this.value === 'SalesCommission') {
               hrateInput.removeAttribute('required');
           } else {
               hrateInput.setAttribute('required', '');
           }
       });
    $('#terms').change(function(){
                      $('#payment_due_date').val('');
                 var sd = $(this).val().replace(/[^0-9]/gi, ''); 
               var number = parseInt(sd, 10);
                      var data = {
                          sales_invoice_date : $('#date').val(),
                          days :number,   
                          pterms : $('#payment_terms').val()
                      };
                      data[csrfName] = csrfHash;
                      $.ajax({
                          type:'POST',
                          data: data, 
                         dataType:"json",
                          url:'<?php echo base_url();?>Cinvoice/getdate',
                          success: function(result, statut) {
                             $('#payment_due_date').val(result);
                         }
                      });
                  });
        // $("#add_agent_data").validate({
   var admin_id = $('#admin_company_id').val();
   $(document).ready(function(){
   var succalert = '<div class="alert alert-success alert-dismissible" role="alert">';
   var failalert = '<div class="alert alert-danger alert-dismissible" role="alert">';
   $("#add_agent_data").validate({
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
   errorPlacement: function(error, element) {
        if (element.hasClass("select2-hidden-accessible")) {
            error.insertAfter(element.next('span.select2'));
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
      url: "<?php echo base_url('Chrm/employee_create'); ?>",
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
             console.log(response, "response");
           if(response.status == 'success')
         {
          $('#errormessage_agent').html(succalert+response.msg+'</div>');
            var $select = $('select#emp_id');
            $select.empty();
            $.each(response.employee_list, function(index, item) {
                        var option = '<option value="' + item.first_name + '">' + item.first_name + '</option>';
                         $select.append(option);
                    });
           $('#new_agent').val('');
           $('#add_agent').modal('hide');
           $('#new_agent').show();
           window.setTimeout(function(){
           $('#add_agent').modal('hide');
           }, 2500); 
         }else{
            $('#errormessage_agent').html(failalert+response.msg+'</div>'); 
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
$('#paypls').on('click',function(){
$('#amount_to_pay').val($('#balance').val());
});
    $('.final_submit').on('click', function (e) {
    var input_hdn='Your Invoice No : "'+$('#inv_no').val()+" has been Created Successfully";

 $('.error_display').html(succalert+input_hdn+'</div>');
   window.setTimeout(function(){
      window.location = "<?php  echo base_url(); ?>Cinvoice/manage_invoice?id=<?php echo $_GET['id']; ?>";
     }, 2000);
   });
     let dynamic_id=2;
      function addbundle(){

        $(this).closest('table').find('.addbundle').css("display","none");
     $(this).closest('table').find('.removebundle').css("display","block");

   var newdiv = document.createElement('div');
   var tabin="crate_wrap_"+dynamic_id;

   newdiv.innerHTML ='<table class="table normalinvoice table-bordered table-hover" id="normalinvoice_'+ dynamic_id +'"> <thead> <tr> <th rowspan="2" class="text-center" style="width: 170px;" ><?php echo display('product_name'); ?><i class="text-danger">*</i></th> <th rowspan="2"  class="text-center"><?php echo display('Bundle No'); ?><i class="text-danger">*</i></th> <th rowspan="2"  class="text-center"><?php echo display('description'); ?></th> <th rowspan="2" style="width:60px;" class="text-center"><?php echo display('Thick ness'); ?><i class="text-danger">*</i></th> <th rowspan="2" class="text-center"><?php echo display('Supplier Block No'); ?><i class="text-danger">*</i></th>  <th rowspan="2" class="text-center" ><?php echo display('Supplier Slab No'); ?><i class="text-danger">*</i> </th> <th colspan="2" style="width:150px;" class="text-center"><?php echo display('Gross Measurement'); ?><i class="text-danger">*</i> </th> <th rowspan="2" class="text-center"><?php echo display('Gross Sq.Ft'); ?></th>  <th rowspan="2" style="width:40px;" class="text-center"><?php echo display('Slab No'); ?><i class="text-danger">*</i></th> <th colspan="2" style="width:150px;" class="text-center"><?php echo display('Net Measure'); ?><i class="text-danger">*</i></th> <th rowspan="2" class="text-center"><?php echo display('Net Sq.Ft'); ?></th> <th rowspan="2" class="text-center"><?php echo display('Cost per Sq.Ft'); ?>($)</th><th rowspan="2"  class="text-center"><?php echo display('Cost per Slab'); ?>($)</th><th rowspan="2" class="land_th" style="width: 100px" class="text-center"><?php echo "Landing Cost per Sq.Ft" ?></th><th rowspan="2" class="land_th" style="width: 100px" class="text-center"><?php echo "Landing Cost per Slab" ?></th>  <th rowspan="2"  class="text-center"><?php echo display('sales'); ?><br/><?php echo display('Price per Sq.Ft'); ?>($)</th> <th rowspan="2"  class="text-center"><?php echo display('Sales Slab Price'); ?>($)</th> <th rowspan="2" class="text-center"><?php echo display('Weight'); ?></th>   <th rowspan="2" style="width: 100px" class="text-center"><?php echo display('total'); ?></th><th rowspan="2" class="text-center"><?php echo display('action'); ?></th> </tr>  <tr> <th class="text-center"><?php echo display('Width'); ?></th> <th class="text-center"><?php echo display('Height'); ?></th> <th class="text-center"><?php echo display('Width'); ?></th> <th class="text-center"><?php echo display('Height'); ?></th> </tr>  </thead> <tbody class="tbody" id="addPurchaseItem_'+ dynamic_id +'"> <tr> <input type="hidden" name="tableid[]" id="tableid_'+ dynamic_id +'"/><td> <input   list="magicHouses"  style="width:160px;" name="prodt[]" id="prodt_'+ dynamic_id +'"   class="form-control product_name"  placeholder="Search Product" > <datalist id="magicHouses"> <option value="Select the Product" selected>Select the Product</option> <?php foreach ($product as $tx) {?>  <option value="<?php echo $tx["product_name"] . "-" . $tx["product_model"]; ?>">  <?php echo $tx["product_name"] . "-" . $tx["product_model"]; ?></option> <?php }?> </datalist> <input type="hidden" class="common_product autocomplete_hidden_value  product_id_'+ dynamic_id +'" name="product_id[]"        id="selected_product_id_'+ dynamic_id +'" /> </td> <td>  <input list="magic_bundle" style="width:70px;" name="bundle_no[]" id="bundle_no_'+ dynamic_id +'"   class="form-control bundle_no"'+'onchange="this.reset();" /><datalist id="magic_bundle"><?php foreach ($bundle as $tx) {?> <option value="<?php echo $tx['bundle_no']; ?>">  <?php echo $tx['bundle_no']; ?></option> <?php }?>'+

   '</datalist></td> <td> <input type="text" id="description_'+ dynamic_id +'" name="description[]" class="form-control" /> </td>  <td > <input type="text" name="thickness[]" id="thickness_'+ dynamic_id +'" required="" class="form-control"/> </td>  <td><input list="magic_supplier_block" name="supplier_block_no[]"  id="supplier_b_no_'+ dynamic_id +'"   class="form-control supplier_block_no"  placeholder="Search Product"  onchange="this.blur();" /><datalist id="magic_supplier_block"><?php foreach ($supplier_block_no as $tx) {?><option value="<?php echo $tx['supplier_block_no']; ?>">  <?php echo $tx['supplier_block_no']; ?></option><?php }?></datalist> </td>  <td > <input type="text"  id="supplier_s_no_'+ dynamic_id +'" name="supplier_slab_no[]" required="" class="form-control"/> </td> <td> <input type="text" id="gross_width_'+ dynamic_id +'" name="gross_width[]" required="" class="gross_width  form-control" /> </td> <td> <input type="text" id="gross_height_'+ dynamic_id +'" name="gross_height[]"  required="" class="gross_height form-control" /> </td>  <td > <input type="text"   style="width:60px;" readonly id="gross_sq_ft_'+ dynamic_id +'" name="gross_sq_ft[]" class="gross_sq_ft form-control"/> </td>   <td style="text-align:center;" >  <input type="text"   style="width:20px;" value="1" class="slab_no" id="slab_no_'+ dynamic_id +'" name="slab_no[]"   readonly  required=""/>  </td> <td> <input type="text" id="net_width_'+ dynamic_id +'" name="net_width[]" required="" class="net_width form-control" /> </td> <td> <input type="text" id="net_height_'+ dynamic_id +'" name="net_height[]"    required="" class="net_height form-control" /> </td> <td > <input type="text"   style="width:60px;" readonly id="net_sq_ft_'+ dynamic_id +'" name="net_sq_ft[]" class="net_sq_ft form-control"/> </td> <td><input type="text" id="cost_sq_ft_'+ dynamic_id +'"  name="cost_sq_ft[]"  readonly  style="width:70px;" placeholder="0.00"  class="cost_sq_ft form-control" ><td><input type="text"  id="cost_sq_slab_'+ dynamic_id +'" name="cost_sq_slab[]"  readonly  style="width:70px;" placeholder="0.00"  class="cost_sq_slab form-control"/></td><td><input type="text" id="sales_amt_sq_ft_'+ dynamic_id +'"  name="sales_amt_sq_ft[]"  style="width:70px;"  placeholder="0.00" class="sales_amt_sq_ft form-control" /></td><td ><input type="text"  id="sales_slab_amt_'+ dynamic_id +'" name="sales_slab_amt[]"  style="width:70px;" placeholder="0.00"  class="sales_slab_amt form-control"/></td><td><input type="text" id="weight_'+ dynamic_id +'" name="weight[]"  class="weight form-control" /> </td> <td><input  type="text" class="total_price form-control" style="width:80px;" readonly value="0.00"  id="total_amt_'+ dynamic_id +'"  name="total_amt[]"/></td><td style="text-align:center;"> <button  class="delete btn btn-danger" id="delete_'+ dynamic_id +'" type="button" value="Delete" ><i class="fa fa-trash"></i></button> </td>  </tr> </tbody> <tfoot> <tr> <td style="text-align:right;" colspan="8"><b>Gross Sq.Ft :</b></td> <td > <input type="text" id="overall_gross_'+ dynamic_id +'" name="overall_gross[]"   class="overall_gross form-control" style="width: 60px"  readonly="readonly"  /> </td> <td style="text-align:right;" colspan="3"><b>Net Sq.Ft :</b></td> <td > <input type="text" id="overall_net_'+ dynamic_id +'" name="overall_net[]"  class="overall_net form-control"  style="width: 60px"  readonly="readonly"  /> </td>  <td><input type="text" id="costpersqft_'+ dynamic_id +'"  name="costpersqft[]"   style="width:70px;" placeholder="0.00"  readonly class="costpersqft form-control" /></td>'+
   '<td ><input type="text"  id="costperslab_'+ dynamic_id +'" name="costperslab[]"    style="width:70px;" placeholder="0.00" readonly class="costperslab form-control"/></td><td class="lc_tdfields"><input type="text" id="landingpersqft_'+ dynamic_id +'" name="landingpersqft[]"  class="landingpersqft form-control"  style="width: 60px"  readonly="readonly"  /> </td><td class="lc_tdfields"><input type="text" id="landingperslab_'+ dynamic_id +'" name="landingperslab[]"  class="landingperslab form-control"  style="width: 60px" readonly="readonly"  /> '+
   '</td><td><input type="text" id="salespricepersqft_'+ dynamic_id +'"  name="salespricepersqft[]" readonly  style="width:70px;"  placeholder="0.00" class="salespricepersqft form-control" /></td><td><input type="text"  id="salesslabprice_'+ dynamic_id +'" name="salesslabprice[]" readonly  style="width:70px;" placeholder="0.00"  class="salesslabprice form-control"/></td> <td ><input type="text" id="overall_weight_'+ dynamic_id +'" name="overall_weight[]"  class="overall_weight form-control"  style="width: 70px"  readonly="readonly"  /></td><td ><input type="text" id="Total_'+ dynamic_id +'" name="total[]"   class="b_total form-control"  style="width: 80px" value="0.00"  readonly="readonly"  /></td>  <td  style="text-align:center;"><i id="buddle_'+ dynamic_id +'" onclick="removebundle(); " class="btn-danger removebundle fa fa-minus" aria-hidden="true"></i></td>   </tr> </foot></table> <i id="buddle_'+ dynamic_id +'"  style="margin-right:25px;float:right;color:white;"   onclick="addbundle(); " class="btnclr addbundle fa fa-plus" aria-hidden="true"></i>';
  document.getElementById('content').appendChild(newdiv);
   $("#normalinvoice_"+ dynamic_id).find('.land_th').hide();
   $("#normalinvoice_"+ dynamic_id).find('.landing_cost').hide();
   $("#normalinvoice_"+ dynamic_id).find('.lc_tdfields').hide();
   dynamic_id++;

   }
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
   </script>
	  </div>
      <!-- For Sale - SOLD BY Field -  Add Employee / Sales Partner -->
<div class="modal fade" id="checkemployeeModal" role="dialog">
   <div class="modal-dialog modal-xl" role="document">
     <div class="modal-content" style='padding:6px;'>
         <div class="modal-header btnclr"  style="text-align:center;" >
            <a href="#" class="close" data-dismiss="modal">&times;</a>
            <h5 class="modal-title"><?php echo ('ADD EMPLOYEE / SALES PARTNER') ?></h5>
         </div>
         <div class="modal-body">
            <select class="form-control" id="getemployeeTypes" >
               <option value="" selected>Select Employee / Sales Partner</option>
               <option value="addEmployees">Add Employee</option>
               <option value="salesPartner">Add Sales Partner</option>
            </select>
         </div>
         <div class="modal-footer">
            <a href="#" class="btn btnclr"   data-dismiss="modal"><?php echo display('Close') ?> </a>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>