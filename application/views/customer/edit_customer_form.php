<script src="<?php echo base_url() ?>my-assets/js/countrypicker.js" type="text/javascript"></script>
 <div class="content-wrapper">
    <section class="content-header" style='height:70px;'>
        <div class="header-icon">
            <figure class="one">
               <img src="<?php echo base_url()  ?>asset/images/customer.png"  class="headshotphoto" style="height:50px;" />
      </div>
     <div class="header-title">
          <div class="logo-holder logo-9">
             <h1><?php echo ('Edit Customer') ?></h1> 
       </div> 


        <ol class="breadcrumb" style=" border: 3px solid #d7d4d6;" >
                <li><a href="<?php echo base_url(); ?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="<?php echo base_url('Ccustomer/manage_customer?id='.$_GET['id']); ?>"><?php echo display('customer') ?></a></li>
                <li class="active" style="color:orange;"><?php echo ('Edit Customer') ?></li>
             <div class="load-wrapp">
       <div class="load-10">
         <div class="bar"></div>
       </div>
       </div>
         </ol>
        </div>
    </section>
      <?php
      $message = $this->session->userdata('message');
      if (isset($message)) {
          ?>
        <div class="alert alert-info alert-dismissable" style="background-color:#38469f;color:white;font-weight:bold;">
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
 <section class="content">
  <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag" style="border:3px solid #d7d4d6;"  >
                    <div class="panel-heading" style="height: 55px;"> 
                        <div class="panel-title">

                               
    </div>

                        <div id="bloc2" style="float:right;margin-top:25px;"> 
                                   <a href="<?php echo base_url('Ccustomer/manage_customer') ?>?id=<?php echo $_GET['id']; ?>"
                                    class="btnclr btn"  style="position: relative;bottom: 25px;" ><i class="ti-align-justify"> </i>
                                    <?php echo display('manage_customer') ?> </a>
               </div>   
 </div>
 <div class="errormessage"></div>
 <form id="edit_customer_form">
                  <div class="panel-body">
                     <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="customer_name" class="col-sm-4 col-form-label"><?php echo display('Customer Name');?> <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input class="form-control" name ="customer_name" id="customer_name"  style="border:2px solid #d7d4d6;"   value="{company_name}"  type="text"   tabindex="1" >
                            </div>
                        </div>
                        <input type="hidden" value="<?php echo $customer_id;  ?>" name="customer_id"/>
                       <div class="form-group row">
<label for="customer_type" class="col-sm-4 col-form-label"><?php echo display('Customer Type');?><i class="text-danger">*</i></label>
<div class="col-sm-8">
 <select   name="customer_type" id="customer_type" class=" form-control" placeholder="Customer Type" value="<?php echo "{customer_type}"  ?>" style="width:100%;border:2px solid #d7d4d6;">
     <option value="<?php echo $customer_type  ?>"><?php echo $customer_type  ?></option>
  <option value="Distributor"><?php echo display('Distributor');?></option>
    <option value="Fabricator"><?php echo display('Fabricator');?></option>
    <option value="Kitchen"><?php echo display('Kitchen');?></option>
    <option value="Dealer"><?php echo display('Dealer');?></option>
    <option value="Contractor"><?php echo display('Contractor');?></option>
    <option value="Builder"><?php echo display('Builder');?></option>
    <option value="Others"><?php echo display('Others');?></option>
    </select>
</div> 
 </div>
<input type="hidden" name="admin_id" id="admin_id" value="{admin_id}"  >
<input type="hidden" name="customer_id" id="customer_id" value="{customer_id}"  >
                       	<div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label"><?php  echo  ('Primary Email');?><i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input class="form-control" name ="email" id="email" type="email" value="<?php echo $primary_email ; ?>"   style="border:2px solid #d7d4d6;"   placeholder="Primary Email" tabindex="2"> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="emailaddress" class="col-sm-4 col-form-label"><?php  echo  display('Secondary Email');?> </label>
                            <div class="col-sm-8">
                                <input class="form-control" name="emailaddress" id="emailaddress" type="email" value="<?php echo $secondary_email ; ?>" style="border:2px solid #d7d4d6;"   placeholder="Secondary Email"  >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mobile" class="col-sm-4 col-form-label"><?php  echo  display('Business Phone');?> <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                               <input class="form-control" name ="phone" id="mobile" type="tel"  value="<?php echo $bussiness_phone; ?>"   style="border: 2px solid #d7d4d6;"    placeholder="(XXX) XXX-XXXX"    tabindex="3"   >
                              </div>
                        </div>
                        <div class="form-group row">
                            <label for="contact" class="col-sm-4 col-form-label"><?php  echo  display('Contact Person');?> <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input class="form-control" name="contact" id="contact" value="<?php echo $contact_person; ?>" type="tel" style="border:2px solid #d7d4d6;"   oninput="formatPhoneNumber(this)"  placeholder="(XXX) XXX-XXXX"   >
                            </div>
                        </div>
 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                 <input type="hidden" name="admin_id" id="admin_id"
                                        value="<?php echo $_GET['admin']; ?>">         
                         <div class="form-group row">
                            <label for="mobile" class="col-sm-4 col-form-label"> <?php  echo  display('Mobile');?></label>
                            <div class="col-sm-8">
                                <input class="form-control" name="mobile" id="mobile" value="<?php echo $customer_mobile; ?>" type="number" style="border:2px solid #d7d4d6;"   placeholder="Mobile"  tabindex="2" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fax" class="col-sm-4 col-form-label"><?php  echo  display('Fax');?></label>
                            <div class="col-sm-8">
                                <input class="form-control" name="fax" id="fax" value="{fax}" type="text" style="border:2px solid #d7d4d6;"   placeholder="Fax" >
                            </div>
                        </div>
                        <div class="form-group row">
            <label for="previous_balance" class="col-sm-4 col-form-label"><?php  echo  display('Preferred currency');?><i class="text-danger">*</i></label>
            <div class="col-sm-6">
    <select class="form-control" id="currency" name="currency1" required
                                        style="max-width: -webkit-fill-available; width: 100%; border: 2px solid #d7d4d6;">
                                       <option value="<?php echo $currency_type; ?>"><?php echo $currency_type; ?></option>
                                        <?php if (!empty($currency_table)) : ?>
                                        <?php foreach ($currency_table as $currency) : ?>
                                        <option value="<?php echo $currency['code']; ?>">
                                            <?php echo $currency['code'] . ' - ' . $currency['description'] . ' - ' . $currency['symbol']; ?>
                                        </option>
                                        <?php endforeach; ?>
                                        <?php else : ?>
                                        <option value="">No currencies found</option>
                                        <?php endif; ?>
                                    </select>
</div>
                            <div id="pageLoader">
                            </div> 
                            </div>
                            <div class="form-group row">
<label for="ETA" class="col-sm-4 col-form-label"><?php  echo  display('Attachments');?></label>
<div class="col-sm-8">
    <input type="file" name="file" class="form-control">
</div>
</div> 
                    </div>
                    <div class="col-sm-6">
                    <div class="form-group row">
                            <label for="address2 " class="col-sm-4 col-form-label"><?php  echo  display('Billing Address');?><i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <textarea class="form-control"  name="address2" id="address2" rows="2"  style="border:2px solid #d7d4d6;"  placeholder="Billing Address" ><?php  echo $billing_address;  ?></textarea>
                            </div>
                        </div>
                    <div class="form-group row">
                            <label for="address " class="col-sm-4 col-form-label"><?php  echo  display('Shipping Address');?></label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="address" id="address "  rows="2"  style="border:2px solid #d7d4d6;"  placeholder="Shipping Address"><?php  echo $shipping_address; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="city" class="col-sm-4 col-form-label"><?php  echo  display('city');?> <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input class="form-control" name="city" id="city" type="text" value="<?php  echo $city; ?>"  style="border:2px solid #d7d4d6;"   placeholder="City"  >
                            </div>
                        </div>
                      <div class="form-group row">
                            <label for="state" class="col-sm-4 col-form-label"><?php  echo  display('state');?> <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input class="form-control" name="state" id="state" type="text" value="<?php  echo $state; ?>"  style="border:2px solid #d7d4d6;"  placeholder="State"  >
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="zip" class="col-sm-4 col-form-label"><?php  echo  display('zip');?> <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input class="form-control" name="zip" id="zip" type="text" value="<?php  echo $zip; ?>"  style="border:2px solid #d7d4d6;"  placeholder="Zip"  >
                            </div>
                        </div>
                        <div class="form-group row">
                                    <label for="country" class="col-sm-4 col-form-label"   ><?php  echo  display('country');?><i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                     <select name="country" id="country"  class="selectpicker countrypicker form-control" style="width:100%" data-default="<?php echo $country;?>"  >
     <option value="<?php echo $country;?>"><?php echo $country;?></option></select>
                                </div>
                        </div>
                        <div class="form-group row">
<label for="billing_address" class="col-sm-4 col-form-label"><?php echo display('Payment Terms');?><i class="text-danger">*</i></label>
<div class="col-sm-8">
    <select   name="payment" id="payment_terms" class=" form-control"   style="width:100%;border:2px solid #d7d4d6;">
     <option value="<?php echo "{payment}"  ?>"><?php echo $payment;  ?></option>   
      <option value="CAD">CAD</option>
        <option value="COD">COD</option>
        <option value="ADVANCE"><?php echo display('ADVANCE');?></option>
        <option value="7DAYS">7<?php echo display('DAYS');?></option>
        <option value="15DAYS">15<?php echo display('DAYS');?></option>
        <option value="30DAYS">30<?php echo display('DAYS');?></option>
        <option value="45DAYS">45<?php echo display('DAYS');?></option>
        <option value="60DAYS">60<?php echo display('DAYS');?></option>
        <option value="75DAYS">75<?php echo display('DAYS');?>S</option>
        <option value="90DAYS">90<?php echo display('DAYS');?></option>
        <option value="180DAYS">180<?php echo display('DAYS');?></option>
    </select>
</div>
</div>    
                        <div class="form-group row">
                            <label for="previous_balance" class="col-sm-4 col-form-label">Credit Limit <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input class="form-control" name="previous_balance" id="previous_balance" value="<?php echo $credit_limit; ?>" type="number" min="0"  style="border:2px solid #d7d4d6;"  tabindex="5" >
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">                    
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-4 col-form-label">Open Balance</label>
                        <div class="col-sm-8">
                            <input name="open_balance"  class="form-control open_balance"  type="number"  style="text-align: right;border:2px solid #d7d4d6;width: 102%;" value="<?php echo $open_balance ; ?>" placeholder="0.00"    tabindex="4">
                        </div>
                     </div> 
                     </div>
                    <div class="col-sm-6">
<div class="form-group row">
    <label for="invoice_no" class="col-sm-4 col-form-label"><?php echo display('Sales Tax') ?>
        <i class="text-danger">*</i>
    </label>
    <div class="col-sm-8">
    <select name="tax_status" class="form-control"  id="tax_dropdown" tabindex="3" style="width:100%;border:2px solid #d7d4d6;">
                               <?php if($tax_status =='1') { ?>     
                                       <option value="1"><?php echo display('NO')  ?></option>
                                     <?php } else{ ?>
                                         <option value="2"><?php echo display('YES')  ?></option>
                                          <?php } ?>
                                        <option value="1"><?php echo display('NO') ?></option>
                                        <option value="2"><?php echo display('YES') ?></option>
                         </select>
    </div>
</div>
<div class="form-group row" id="tax">
    <div class="row">
           <div class="col-sm-12">
    <label for="sales" class="col-sm-4 col-form-label"><?php echo display('State Tax') ?></label>
    <div class="col-sm-8">
    <select  class="form-control" name="tax" value="" tabindex="3" style="width:100%;border:2px solid #d7d4d6;"  >
    <option value="<?php echo $sales_tax;  ?>"><?php echo $sales_tax;  ?></option>
<?php if (!empty($states)) : ?>
                                                <?php foreach ($states as $state_name) : ?>
                                                <option value="<?php echo $state_name['state_name']; ?>">
                                                    <?php echo $state_name['state_name']; ?>
                                                </option>
                                                <?php endforeach; ?>
                                                <?php else : ?>
                                                <option value="">No currencies found</option>
                                                <?php endif; ?>
</select>
</div>
</div>
    </div>
    &nbsp;&nbsp;
                <div class="form-group row" id="tax">
                 <div class="col-sm-12">
                <label for="sales" class="col-sm-4 col-form-label"><?php echo  display('Tax Rates')?>  </label>
                <div class="col-sm-8">
                 <input name="taxes"  class="form-control taxes" value="<?php echo $tax_percent ; ?>"   placeholder="%"   style="width:100%;border:2px solid #d7d4d6;" tabindex="4">
                 </div>
    </div>
    </div>
</div>
</div>
<div class="form-group row">
        <div class="col-sm-12">
                        </div>
                           <div class="col-sm-12">
                            <label for="example-text-input" class="col-sm-0 col-form-label"></label>
                              <div class="col-sm-12 text-center">    
                                        <input type="submit" id="add-customer"   class="btnclr btn btn-large updateCustomer" name="add-customer" value="<?php echo display('save') ?>" tabindex="7"/>
                                        <a href="<?php echo base_url('Ccustomer/manage_customer?id='.$_GET['id']); ?>" class="btn btn-info">Cancel</a> 
                              </div>
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
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
     $('#tax_dropdown').on('change', function() {
  if ( this.value == '2'){
    $("#tax1").show();       $("#tax2").show();   
  }else{
    $("#tax1").hide();  $("#tax2").hide();
  }
}).trigger("change");
   $(document).ready(function() {
var sts=<?php  echo $tax_status; ?>;
console.log(sts);
if(sts=='1'){
      $("#tax1").hide();  $("#tax2").hide();
}else{
      $("#tax1").show();       $("#tax2").show();   
}
   });
   $('#tax_dropdown').on('change', function() {
  if ( this.value == '2')
    $("#tax").show();     
  else
    $("#tax").hide();
   }).trigger("change"); 
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
      templateResult: formatFlags,
      templateSelection: formatCountry,
      maximumInputLength: 3
    });
    info.innerHTML = "Result: "+data.result+"<br>Provider: "+data.provider+"<br>Documentation: "+data.documentation+"<br>Terms of use: "+data.terms_of_use+"<br>Time Last Update UTC: "+data.time_last_update_utc;
    $('#pageLoader').fadeOut();
  }).catch(function(error) {
    err.innerHTML = "Error: " + error;
    $('#pageLoader').fadeOut();
  });
  $('.currency').on('select2:select', function (e) {
    let currency1 = select[0].value;
    let currency2 = select[1].value;
    let num1 = num.value;
    convert(currency1, currency2, num1)
  });
}, false);
function display(data){
  const entries = Object.entries(data);
  for (var i = 0; i < entries.length; i++){
    select[0].innerHTML += `<option value="${entries[i][0]}">${entries[i][0]}</option>`;
    select[1].innerHTML += `<option value="${entries[i][0]}">${entries[i][0]}</option>`;
  }
  if ($('#currency2').find("option[value='CLP']").length) {
    $('#currency2').val('CLP').trigger('change');
    $('#num').val(1);
    let currency1 = select[0].value;
    let currency2 = select[1].value;
    let num1 = num.value;
    convert(currency1, currency2, num1)
  }
}
function formatFlags (country) {
  if (!country.id) {
    return country.text;
  }
  var $countryFlag = $('<span><img src="' + baseFlagsUrl + '/' + country.element.value.toLowerCase() + '.png" class="img-flag" /> ' + country.text + '</span>');
  return $countryFlag;
}
function formatCountry (country) {
  if (!country.id) {
    return country.text;
  }
  var $countryFlag = $('<span><img class="img-flag"/> <span></span></span>');
  $countryFlag.find("span").text(country.text);
  $countryFlag.find("img").attr("src", baseFlagsUrl + "/" + country.element.value.toLowerCase() + ".png");
  return $countryFlag;
}
function convert(currency1, currency2, value){
  fetch(`${currencyApiUrl}/${currency1}`)
    .then((val) => val.json())
    .then((val) => {
    console.log('Converting ' +currency1 + ' to '+currency2);
    var res  = val.rates[currency2] * value 
    ans.value = res.toFixed(2);
    err.innerHTML = "";
  }).catch(function(error) {
    err.innerHTML = "Error: " + error;
  });
}





$(document).ready(function() {
    $.validator.addMethod("trimRequired", function(value, element) {
        return $.trim(value) !== "";
    }, "This field is required.");
  $("#edit_customer_form").validate({
        rules: {
            customer_name: "trimRequired",
            customer_type: "required",
            email: "required",
            phone: "required",
            contact: "required",
            address2: "trimRequired",
            city: "required",
            state: "required",
            zip: "required",
            country: "required",
            payment: "required",
            previous_balance: "required",
            tax_status: "required"
        },
        messages: {
            customer_name: "Customer Name is required",
            customer_type: "Customer Type is required",
            email: "Email is required",
            phone: "Phone is required",
            contact: "Contact is required",
            address2: "Address is required",
            city: "City is required",
            state: "State is required",
            zip: "Zip is required",
            country: "Country is required",
            payment: "Payment is required",
            previous_balance: "Previous Balance is required",
            tax_status: "Tax Status is required"
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
   formData.append('csrfName', 'csrfHash');
  var customerId = '<?php echo $this->input->get('id'); ?>';
                 $.ajax({
          url: '<?php echo base_url('Ccustomer/customer_update'); ?>?id=' + customerId,
            type: 'POST',
            data: formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            headers: {'X-CSRF-TOKEN': '<?php echo $this->security->get_csrf_hash(); ?>'},
            success: function(response) {
                  debugger;
                  console.log(response);
                if (response.status == 'success') {
                    $('.errormessage').html(succalert + response.msg + alert2);
    setTimeout(function() {
        window.location.href = "<?php echo base_url('Ccustomer/manage_customer') ?>?id=" + (customerId);
    }, 3000);
                } else if (response.status == 'failure') {
                    $('.errormessage').html(failalert + response.msg + alert2);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
        }
    });
});
</script>