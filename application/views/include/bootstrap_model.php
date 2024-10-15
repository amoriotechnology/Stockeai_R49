<style>
.select2 {
    width: 100%; 
    width: -webkit-fill-available !important; 
    box-sizing: border-box; 
}

.alert-danger{
    text-align: left;
}

.modal-md{
	max-width: 500px;
}

.modal-lg{
	max-width: 700px;
}

.modal-xl{
	max-width: 1000px;
}

.select2-selection__rendered{
	text-align: left !important;
}

@media (min-width: 768px) {
    .modal-dialog {
        width: 80% !important;
        margin: 30px auto;
    }
}
label.error {
  display: block; 
  text-align: left; 
  margin-left: 0;
  margin-top: 5px; 
  color: red; 
}
</style>

<?php 

if(in_array(BOOTSTRAP_MODELS['vendor'],$bootstrap_model)){ ?>
   <div class="modal fade model success" id="add_vendor" role="dialog">
	<div class="modal-dialog modal-lg" role="document" style="width: auto;">
		<div class="modal-content" style="text-align:center">
		   <div class="modal-header btnclr">
			  <a href="#" class="close" data-dismiss="modal" >&times;</a>
			  <h3 class="modal-title"  ><?php echo  ('VENDOR');?></h3>
		   </div>
		   <div class="modal-body">
             <div id="errormessage_vendor" class="alert hide"></div>
				<form id="ven_insert_supplier" name="ven_insert_supplier" method="post" enctype="multipart/form-data">
					<div class="panel-body">
						<div class="col-sm-6">
							<input type ="hidden" name="csrf_test_name" id="" value="<?php echo $this->security->get_csrf_hash();?>">
							<div class="form-group row">
								<label for="" class="col-sm-4 col-form-label"><?php echo display('Vendor Type') ?><i class="text-danger">*</i></label>
								<div class="col-sm-8">
									<select name="sup_vendor_type" id="sup_vendor_type" class="form-control" placeholder='' style="width:135%;border:2px solid #D7D4D6;" required>
										<option value=""><?php echo  ('Selected vendor type') ?></option>   
										<option value="Product Supplier"><?php echo ('Product Supplier') ?></option> 
										<option value="Service Vendor"> <?php echo ('Service Vendor') ?></option> 
										<option value="Others"> <?php echo display('Others') ?></option> 
									</select>
								</div> 
							</div>
							<div class="form-group row">
								<label for="supplier_name" class="col-sm-4 col-form-label"> <?php echo display('Company Name') ?><i class="text-danger">*</i></label>
								<div class="col-sm-8">
									<input class="form-control" name ="ven_supplier_name" id="ven_supplier_name" type="text" placeholder="Company Name"  style="border:2px solid #D7D4D6;" tabindex="1">
								</div>
							</div>

							<div class="form-group row">
								<label for="phone" class="col-sm-4 col-form-label"><?php echo display('Business Phone') ?> <i class="text-danger">*</i></label>
								<div class="col-sm-8">                            
									<input class="form-control" name="ven_phone" id="ven_phone" type="tel" placeholder="(XXX) XXX-XXXX" required="" tabindex="2">
								</div>
							</div>

							<div class="form-group row">
								<label for="mobile" class="col-sm-4 col-form-label"> <?php echo display('Mobile') ?> <i class="text-danger"></i></label>
								<div class="col-sm-8">
									<input class="form-control" name="ven_mobile" id="ven_mobile" type="number" placeholder="Mobile" style="border:2px solid #D7D4D6;" tabindex="2">
								</div>
							</div>
					
							<div class="form-group row">
								<label for="contact" class="col-sm-4 col-form-label"> <?php echo display('Contact Person') ?> <i class="text-danger"></i></label>
								<div class="col-sm-8">
									<input class="form-control" name="ven_contact" id="ven_contact" type="text"  style="border:2px solid #D7D4D6;"   placeholder="Contact person"  >
								</div>
							</div>
							<div class="form-group row">
								<label for="email" class="col-sm-4 col-form-label"><?php echo display('Primary Email') ?> <i class="text-danger">*</i></label>
								<div class="col-sm-8">
									<input class="form-control" name="ven_email" id="ven_email" type="email" placeholder="Primary email"  style="border:2px solid #D7D4D6;"   required=""    tabindex="2">
								</div>
							</div>
							<div class="form-group row">
								<label for="" class="col-sm-4 col-form-label"> <?php echo display('Secondary Email') ?> <i class="text-danger"></i></label>
								<div class="col-sm-8">
									<input class="form-control" name="ven_emailaddress" id="ven_emailaddress" type="email" style="border:2px solid #D7D4D6;"    placeholder="Secondary email"  >
								</div>
								
							</div>
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
							<div class="form-group row">
								<label for="fax" class="col-sm-4 col-form-label"><?php echo display('fax'); ?> <i class="text-danger"></i></label>
								<div class="col-sm-8">
									<input class="form-control" name="ven_fax" id="ven_fax" type="text"  style="border:2px solid #D7D4D6;"   placeholder="<?php echo display('fax') ?>" />
								</div>
							</div>
							<div class="form-group row">
								<label for="" class="col-sm-4 col-form-label"><?php echo display('Tax Collected') ?><i class="text-danger">*</i></label>
								<div class="col-sm-8">
									<select class="form-control" name="ven_service_provider"  id="ven_service_provider" required="">
										  <option value="1"><?php  echo display('yes'); ?></option>
									<option value="0" selected><?php  echo display('no'); ?></option>
									</select>
								</div> 
							</div>
							<div class="form-group row">
								<label for="Preferred currency1" class="col-sm-4 col-form-label" > <?php echo display('Preferred currency') ?><i class="text-danger">*</i></label>
						   
								<div class="col-sm-8">
									<select name="ven_currency" id="ven_currency" class="form-control" placeholder='' style="width:135%;border:2px solid #D7D4D6;" required>
									<option value="">Select Currency</option>   
									<?php foreach (getAllCurrencies() as $cval){
											$selectcurr = $cval['code'] =='USD' ? 'selected' : '';
											echo '<option '.$selectcurr.' value="'.$cval['code'].'">'.$cval['code'].' - '.$cval['description'].' - '.$cval['symbol'].'</option>';
										} ?>
									</select>
								</div> 
								<div id="pageLoader">
								</div>
		  
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group row">
								<label for="address " class="col-sm-4 col-form-label"><?php echo display('Address') ?></label>
								<div class="col-sm-8">
									<textarea class="form-control" name="ven_address" id="ven_address " rows="3"  col="2"    style="border:2px solid #D7D4D6;"   placeholder="<?php echo display('supplier_address') ?>" ></textarea>
								</div>
							</div>
							<div class="form-group row">
								<label for="city" class="col-sm-4 col-form-label"><?php echo display('city'); ?> <i class="text-danger"></i></label>
								<div class="col-sm-8">
									<input class="form-control" name="ven_city" id="ven_city" type="text"   style="border:2px solid #D7D4D6;"   placeholder="<?php echo display('city') ?>"  >
								</div>
							</div>
							<div class="form-group row">
								<label for="state" class="col-sm-4 col-form-label"><?php echo display('state'); ?> <i class="text-danger"></i></label>
								<div class="col-sm-8">
									<input class="form-control" name="ven_state" id="ven_state" type="text" style="border:2px solid #D7D4D6;"    placeholder="<?php echo display('state') ?>"  >
								</div>
							</div>
							<div class="form-group row">
								<label for="country" class="col-sm-4 col-form-label"  required="" ><?php echo display('Country') ?><i class="text-danger">*</i></label>
								<div class="col-sm-8">
									<select class="form-control"  data-live-search="true" data-default="United States" style="border:2px solid #D7D4D6;" name="ven_country" id="ven_country" >
									<?php foreach (getAllCountries() as $conval){
												$selectcon = $conval['iso3'] =='USA' ? 'selected' : '';
												echo '<option '.$selectcon.' value="'.$conval['name'].'">'.$conval['name'].'</option>';
											} ?>
									</select>
								</div>
							</div>

							<div class="form-group row">
								<label for="zip" class="col-sm-4 col-form-label"><?php echo display('zip'); ?> <i class="text-danger"></i></label>
								<div class="col-sm-8">
									<input class="form-control" name="ven_zip" id="ven_zip" type="text"  style="border:2px solid #D7D4D6;" placeholder="<?php echo display('zip') ?>"  >
								</div>
							</div>
							<div class="form-group row">
								<label for="details" class="col-sm-4 col-form-label"><?php echo display('supplier_details') ?></label>
								<div class="col-sm-8">
									<textarea class="form-control" name="ven_details" id="ven_details" rows="2" placeholder="<?php echo display('supplier_details') ?>" tabindex="4"></textarea>
								</div>
							</div>
							<div class="form-group row">
								<label for="previous_balance" class="col-sm-4 col-form-label"><?php echo display('Credit Limit') ?></label>
								<div class="col-sm-8">
									<input class="form-control" name="ven_previous_balance" id="ven_previous_balance" type="number" min="0" placeholder="Credit Limit" style="border:2px solid #D7D4D6;"   tabindex="5">
								</div>
							</div>
							<div class="form-group row">
								<label for="previous_balance" class="col-sm-4 col-form-label"><?php echo "Previous Balance" ?></label>
								<div class="col-sm-8">
									<input class="form-control" name="ven_p_b" id="ven_p_b" type="number" min="0"  style="border:2px solid #D7D4D6;"   placeholder="Previous Balance" tabindex="5">
								</div>
							</div> 
							<div class="form-group row">
								<label for="payment_terms" class="col-sm-4 col-form-label"><?php echo display('Payment Terms') ?><i class="text-danger">*</i></label>
								<div class="col-sm-8">
									<select name="ven_terms" id="ven_terms" class=" form-control"  style="border:2px solid #D7D4D6;"   required=""  placeholder='Payment Terms'>
										<option value=""><?php echo display('Select Payment Terms') ?></option>
											<?php
											foreach(PAYMENT_TYPE as $payment_typ){
												echo '<option value="'.$payment_typ.'">'.$payment_typ.'</option>';
											}
											?>
									</select>
								</div>
							</div>
								 
							<div class="form-group row">
								<label for="adress" class="col-sm-4 col-form-label"><?php echo display('Attachments') ?>
								</label>
								<div class="col-sm-8">
									<input type="file" name="ven_attachments" id="ven_attachments" class="form-control">
								</div>
							</div> 
							<input type="hidden" name="admin_company_id" id="admin_company_id" value="<?php echo $_GET['id']; ?>">
						
							
						</div> 
						 <div class="col-sm-12 text-center">
							<label for="example-text-input" class="col-sm-0 col-form-label"></label>
							<div class="col-sm-12 text-center">
								<input type="submit" id="add_supplier" class="btnclr btn btn-large" name="add_supplier" value="Submit" tabindex="7" />
								 <a href="#" class="btnclr btn"   data-dismiss="modal"><?php echo display('Close')?></a>
							</div> 

						</div>
					</div><!--panel body end -->
				</form>
			</div><!--model body end -->
		</div>
	</div>
</div>
<script type="text/javascript">
var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';



$(document).ready(function(){

    var succalert = '<div class="alert alert-success alert-dismissible text-left" role="alert">';
    var failalert = '<div class="alert alert-danger alert-dismissible text-left" role="alert">';
    $('#sup_vendor_type').select2();

    $('#ven_service_provider').select2();
     // Custom method to trim input fields
     $.validator.addMethod("trimRequired", function(value, element) {
        return $.trim(value) !== "";
    }, "This field is required.");
    $("#ven_insert_supplier").validate({
        rules: {
            sup_vendor_type: "trimRequired",
            ven_supplier_name: "trimRequired",
            ven_phone: {
                trimRequired: true,
            },
            ven_mobile :{
                number  : true
            },
            ven_email:  {
                trimRequired: true,
                email: true
            },
            ven_emailaddress:{
                email: true
            },
            ven_service_provider: "trimRequired",
            ven_currency: "trimRequired",
            ven_country: "trimRequired",
            ven_terms: "trimRequired"
        },
        messages: {
            sup_vendor_type: "Vendor Type is required",
            ven_supplier_name: "Company Name is required",
            ven_phone: {
                required : 'Business phone is required',
            },
            ven_email: {
                required: "Please enter your email",
                email: "Please enter a valid email address"
            },
            ven_service_provider: 'Tax Collected is required',
            ven_currency:'Preferred Currency is required',
            ven_country:'Country is required',
            ven_terms:'Payment Terms is required',
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
                    type:"POST",
                    dataType:"json",
                    url:"<?php echo base_url(); ?>Csupplier/insert_supplier",
                    data:formData,
                    contentType: false, 
                    processData: false, 
                    success:function (response) {
                        console.log(response);
                        if(response.status =='success'){
                            $('#errormessage_vendor').html(succalert+response.msg+'</div>');
                         window.setTimeout(function(){
                                $('#supplier_id').append('<option selected value="'+response.result.supplier_id+'">'+response.result.name+'</option>');
                                var custo_currency = response.result.currency_type;
                                    $(".cus").html(custo_currency);
                                    $("label[for='custocurrency']").html(custo_currency);
                                    $.getJSON('https://open.er-api.com/v6/latest/<?php echo $curn_info_default; ?>', function(data) {
                                                var x = data['rates'][custo_currency];
                                                var Rate = parseFloat(x).toFixed(2);
                                                Rate = isNaN(Rate) ? 0 : Rate;
                                               $('#vendor_type_details').val(response.result.vendor_type);
                                  $('#vendor_add').val(response.result.vendor_add);
                                                $('#sp_address').val(response.result.vendor_add);
                                                $(".custocurrency_rate").val(Rate);
                                                   $(".custocurrency_rate_provider").val(Rate);
                                             });
                                $('#ven_insert_supplier')[0].reset();
                               $('#add_vendor').modal('hide');
                            },1000);
                        
                        }else{
                            $('#errormessage_vendor').html(failalert+response.msg+'</div>'); 

                        }
                    }
                });
            event.preventDefault();
        }
    });

});


</script>
<?php 
}
if(in_array(BOOTSTRAP_MODELS['customer'],$bootstrap_model)){ ?>
<!-- Customer Insert Modal Start -->
<div class="modal fade" id="cust_info">
   <div class="modal-dialog modal-xl" role="document" style="width: auto;">
      <div class="modal-content" style="text-align:center;" >
		<form id="addcustomer" name="addcustomer" method="post" enctype="multipart/form-data">
         <div class="modal-header btnclr" >
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title text-uppercase"><?php echo display('CUSTOMER') ?></h4>
         </div>
         <div class="container"></div>
             <div class="modal-body">
                <div id="customererrormessage"></div>
                   <div class="panel-body">
                      <div class="col-sm-6">
                         <div class="form-group row">
                            <label for="customer_name" class="col-sm-4 col-form-label"><?php echo display('Company Name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                               <input class="form-control" name ="customer_name" id="customer_name" type="text" placeholder="Company Name"  tabindex="1" required oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '')">
                            </div>
                         </div>
                         <input type ="hidden" name="csrf_test_name" id="" value="<?php echo $this->security->get_csrf_hash();?>">
                         <div class="form-group row">
                            <label for="customer_type" class="col-sm-4 col-form-label"><?php echo display('Customer Type') ?></label>
                            <div class="col-sm-8">
                              <select   name="customer_type" id="customer_type" class=" form-control" placeholder="Customer Type" >
                                  <option value=""><?php echo display('Select Customer Type') ?></option>
                                    <?php
                                        foreach(CUSTOMER_TYPE as $customer_value){
                                            echo '<option value="'.$customer_value.'">'.$customer_value.'</option>';
                                        }
                                    ?>
                               </select>
                            </div>
                         </div>
                         <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label"><?php echo "Primary Email"; ?><i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                               <input class="form-control" name ="primary_email" id="primary_email" type="email" placeholder="Primary Email" required>
                               <input type="hidden" name="admin_company_id" id="admin_company_id" value="<?php echo $_GET['id']; ?>">
                            </div>
                         </div>
                         <div class="form-group row">
                            <label for="emailaddress" class="col-sm-4 col-form-label"><?php echo display('Secondary Email') ?> </label>
                            <div class="col-sm-8">
                               <input class="form-control" name="emailaddress" id="sec_emailaddress" type="email" placeholder="Secondary Email"  >
                            </div>
                         </div>
                         <div class="form-group row">
                            <label for="mobile" class="col-sm-4 col-form-label"><?php echo display('Business Phone') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                               <input class="form-control" name ="business_mobile" id="business_mobile" type="number" placeholder="Business Phone" min="0" tabindex="3" required>
                            </div>
                         </div>
                         <div class="form-group row">
                            <label for="mobile" class="col-sm-4 col-form-label"> <?php echo display('Mobile') ?></label>
                            <div class="col-sm-8">
                               <input class="form-control" name="mobile" id="mobile" type="number" placeholder="Mobile"  min="0" tabindex="2" >
                            </div>
                         </div>
                         <div class="form-group row">
                            <label for="contact" class="col-sm-4 col-form-label"><?php echo display('Contact Person') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                               <input class="form-control" name="contact_person" id="contact_person" type="text" placeholder="Contact Person" required oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '')">
                            </div>
                         </div>
                         <div class="form-group row">
                            <label for="ETA" class="col-sm-4 col-form-label"><?php echo display('Attachments') ?></label>
                            <div class="col-sm-8">
                               <input type="file" name="customer_attachment" class="form-control">
                            </div>
                         </div>
                         <div class="form-group row">
                            <label for="Preferred currency" class="col-sm-4 col-form-label"><?php echo display('Preferred currency') ?><i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <select  class="form-control" id="preferred_currency" name="preferred_currency"  style="width: 100%;"  style="max-width: -webkit-fill-available;" required>
                                 <option value="">Select your Preferred currency</option>
                                <?php 
                                    foreach (getAllCurrencies() as $currency) { ?>
                                    <option value="<?php echo $currency['code']; ?>"><?php echo $currency['description'] .' - '. $currency['code'] .' - '.  $currency['symbol'];?></option>
                                <?php } ?>

                                </select>
                            </div>
                         </div>
                         <div class="form-group row">
                            <label for="fax" class="col-sm-4 col-form-label"><?php echo display('fax'); ?> <i class="text-danger"></i></label>
                            <div class="col-sm-8">
                               <input class="form-control" name="fax" id="fax" type="text" placeholder="Fax" >
                            </div>
                         </div>
                      </div>
                      <div class="col-sm-6">
                         
                         <div class="form-group row">
                            <label for="address2 " class="col-sm-4 col-form-label"><?php echo display('Billing Address') ?><i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                               <textarea class="form-control" name="address2" id="address2" rows="2" placeholder="Billing Address" required></textarea>
                            </div>
                         </div>
                         <div class="form-group row">
                            <label for="address " class="col-sm-4 col-form-label"><?php echo display('Shipping Address') ?></label>
                            <div class="col-sm-8">
                               <textarea class="form-control" name="address" id="address"  rows="2" placeholder="Shipping Address"></textarea>
                            </div>
                         </div>
                         <div class="form-group row">
                            <label for="city" class="col-sm-4 col-form-label"><?php echo display('City') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                               <input class="form-control" name="cust_city" id="cust_city" type="text" placeholder="City" required oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '')">
                            </div>
                         </div>
                         <div class="form-group row">
                            <label for="state" class="col-sm-4 col-form-label"><?php echo display('State') ?><i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                               <select  class="form-control" name="cust_state"  id="cust_state" tabindex="3" style="width:95%">
                                 <option value=""><?php echo "Select your State" ?></option>
                                 <?php 
                                    $states = getAllStates();
                                    foreach ($states as $key => $state) { ?>
                                    <option value="<?php echo $state['state_name']; ?>"><?php echo $state['state_name'];?></option>
                                 <?php } ?>
                              </select>
                            </div>
                         </div>
                         <div class="form-group row">
                            <label for="zip" class="col-sm-4 col-form-label"><?php echo display('Zip') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                               <input class="form-control" name="cust_zip" id="cust_zip" type="number" placeholder="Zip" required>
                            </div>
                         </div>
                         <div class="form-group row">
                            <label for="country" class="col-sm-4 col-form-label"><?php echo display('Country') ?><i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                               <select class="form-control" name="cust_country" id="cust_country">
                                    <?php foreach (getAllCountries() as $conval){
                                            $selectcon = $conval['iso3'] =='USA' ? 'selected' : '';
                                            echo '<option '.$selectcon.' value="'.$conval['name'].'">'.$conval['name'].'</option>';
                                        } ?>
                                </select>
                            </div>
                         </div>
                         <div class="form-group row">
                            <label for="billing_address" class="col-sm-4 col-form-label"><?php echo display('Payment Terms') ?><i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                               <select name="payment_terms" id="payment_terms" class=" form-control" placeholder='Payment Terms' required>
                                  <option value=""><?php echo display('Select Payment Terms ') ?></option>
                                    <?php
                                        foreach(PAYMENT_TYPE as $payment_typ){
                                            echo '<option value="'.$payment_typ.'">'.$payment_typ.'</option>';
                                        }
                                    ?>
                               </select>
                            </div>
                         </div>
                         <div class="form-group row">
                            <label for="previous_balance" class="col-sm-4 col-form-label"><?php echo display('Credit Limit') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                               <input class="form-control" name="previous_balance" id="previous_balance" type="number" min="0" placeholder="Credit Limit" tabindex="5">
                            </div>
                         </div>
                         <div class="form-group row">
                           <label for="invoice_no" class="col-sm-4 col-form-label"><?php echo display('Sales Tax') ?>
                           <i class="text-danger">*</i>
                           </label>
                           <div class="col-sm-8">
                              <select name="sales_taxes" class="form-control" id="sales_taxes" tabindex="3">
                              <option value="" selected><?php echo display('Select Sales Tax') ?></option>
                              <option value="1"><?php echo display('NO') ?></option>
                              <option value="2"><?php echo display('YES') ?></option>
                              </select>
                           </div>
						      </div>
                        <div class="form-group row">
                           <label for="sales" class="col-sm-4 col-form-label"><?php echo display('Tax Rates') ?></label>
                           <div class="col-sm-8">
                              <input name="taxes" id="taxes" class="form-control taxes" value="" placeholder="%" >
                           </div>
                        </div>
                        </div>
                        <div class="col-sm-12 text-center">
							<label for="example-text-input" class="col-sm-0 col-form-label"></label>
							<div class="col-sm-12 text-center">
								<input type="submit" id="add_supplier" class="btnclr btn btn-large" name="add_supplier" value="Submit" tabindex="7" />
								 <a href="#" class="btnclr btn"   data-dismiss="modal"><?php echo display('Close')?></a>
							</div> 
						</div>
                    
                </div>
			</div>
         </form>
			
      </div>
   </div>
</div>
<!-- Customer Insert Modal End -->

<script type="text/javascript">
var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
$(document).ready(function(){

    var succalert = '<div class="alert alert-success alert-dismissible text-left" role="alert">';
    var failalert = '<div class="alert alert-danger alert-dismissible text-left" role="alert">';
    
     // Custom method to trim input fields
     $.validator.addMethod("trimRequired", function(value, element) {
        return $.trim(value) !== "";
    }, "This field is required.");
    $("#addcustomer").validate({
        rules: {
            customer_name: "trimRequired",
            primary_email: {
                trimRequired: true,
                email:true
            },
           
            business_mobile: {
               trimRequired: true,
               number:true
            },
            contact_person: "trimRequired",
            preferred_currency: "required",
            address2: "trimRequired",
            cust_city : "required",
            cust_state : "required",
            cust_zip   : 'required',
            cust_country : 'required',
            payment_terms : 'required',
            previous_balance : 'required',
            sales_taxes : 'required',
        },
        messages: {
            customer_name: "Company Name is required",
            primary_email: {
                trimRequired: "Primary Email is required",
                email: "Please enter a valid email address"
            },
            
            business_mobile: {
                trimRequired: "Business Phone is required",
                number: "Please enter a valid phone number"
            },
            contact_person:'Contact Person is required',
            preferred_currency:'Preferred Currency is required',
            address2:'Billing Address is required',
            cust_city : "City is required",
            cust_state : 'State is required',
            cust_zip : 'Zip is required',
            cust_country : 'Country is required',
            payment_terms : 'Payment terms is required',
            previous_balance : 'Credit limit is required',
            sales_taxes : 'Sales Tax is required'
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
                    type:"POST",
                    dataType:"json",
                    url:"<?php echo base_url(); ?>Cinvoice/instant_customer",
                    data:formData,
                    contentType: false, 
                    processData: false, 
                    success:function (response) {
                    console.log(response, "response");
                        if (response.status == 'success') {
                            $('#customererrormessage').html('<div class="alert alert-success alert-dismissible text-left" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
                            $('select#customer_id').empty();
                            $.each(response.customerdata, function(index, customer) {
                                $('select#customer_id').append(
                                    $('<option/>').attr('value', customer.customer_id).text(customer.customer_name)
                                );
                            });

                            setTimeout(function() {
                                $('#cust_info').modal('hide');
                            }, 1500);

                        } else {
                            $('#customererrormessage').html('<div class="alert alert-danger alert-dismissible text-left" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
                        }
                    }
                });
            event.preventDefault();
        }
    });

});


</script>

<?php 
}
if(in_array(BOOTSTRAP_MODELS['payment_terms'],$bootstrap_model)){ ?>

<div class="modal fade" id="payment_type_new" tabindex="-1" role="dialog" aria-labelledby="paymentTypeNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="display: flex; justify-content: center; align-items: center; min-height: 40vh;">
            <div class="modal-content" style="width: 600px; margin: auto;">
                <form id="add_pay_terms" method="post">
                    <div class="modal-header btnclr">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="paymentTypeNewLabel"><?php echo ('PAYMENT TERMS') ?></h4>
                    </div>
                    <div class="modal-body">
                    	<div id="payment_term_errormessage"></div>
                        <div class="panel-body">
                            <input type="hidden" name="csrf_test_name" value="<?php echo $this->security->get_csrf_hash();?>">
                            <div id="errormessage_paymenttype" class="alert"></div>
                            <div class="form-group row">
                                <label for="new_payment_terms" class="col-sm-4 col-form-label"><?php echo ('Payment Terms') ?><i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input type="hidden" name="admin_company_id" id="admin_company_id" value="<?php echo $_GET['id']; ?>">
                                    <input class="form-control" name="new_payment_terms" id="new_payment_terms" type="text" placeholder="New Payment Terms" tabindex="1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btnclr"><?php echo display('Submit') ?></button>
                        <button type="button" class="btn btnclr" data-dismiss="modal"><?php echo display('Close') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script type="text/javascript">
   // Insert Payment
   $("#add_pay_terms").validate({
    rules: {
        new_payment_terms: "required"
    },
    messages: {
        new_payment_terms: "Payment Term  is required"
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
           url: '<?php echo base_url(); ?>Cinvoice/PaymentTerms',
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(response) {
                $('#payment_term_errormessage').html("");
                if (response.status === 'success') {
                   $('#payment_term_errormessage').html('<div class="alert alert-success alert-dismissible text-left" role="alert">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">×</span></button>' +
                        response.msg + '</div>');
                       var $select = $('select#terms');
                     $('select#terms').empty();
                     $.each(response.pterms, function(index, customer) {
                        $('select#terms').append(
                              $('<option/>').attr('value', customer.payment_terms).text(customer.payment_terms)
                        );
                     });
                     setTimeout(function() {
                        $('#payment_type_new').modal('hide');
                     }, 1500);
                     } else {
                    $('#payment_term_errormessage').html('<div class="alert alert-danger alert-dismissible text-left" role="alert">' +
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

<?php 
}

if(in_array(BOOTSTRAP_MODELS['payment_model'],$bootstrap_model)){ ?>

<div class="modal fade" id="payment_modal" role="dialog">
   <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content" style=" margin-top: 190px;text-align:center;">
         <div class="modal-header btnclr">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"> <?php echo display('ADD PAYMENT') ?></h4>
         </div>
         <div class="modal-body">
            <form id="add_payment_info" name="add_payment_info" method="post">
            <div id="paymenterrormessage"></div>
            <br>
               <div class="row">
                  <div class="form-group row">
                     <label for="date" style="text-align:end;" class="col-sm-3 col-form-label">  <?php echo display('Payment Date') ?> <i class="text-danger">*</i></label>
                     <div class="col-sm-5">
                        <?php $date = date('Y-m-d');  ?>
                        <input class=" form-control" type="date"  name="payment_date" id="payment_date"  value="<?php echo $date; ?>" tabindex="4" required>
                        <input type="hidden" name="admin_company_id" id="admin_company_id" value="<?php echo $_GET['id']; ?>">
                     </div>
                  </div>
                  <input type="hidden" id="custocurrencyrate"/>
                  <input type="hidden" id="cutomer_name" name="cutomer_name" value="<?php  echo $payment_id ;?>"/>
                  
                  
                  <input type="hidden" value="<?php echo isset($payment_id) ? $payment_id : rand(); ?>"  name="payment_id" id="payment_id"/>
                  <input type='hidden'  name="invoice_number" id="invoice_number"/>
                  <div class="form-group row">
                     <label for="billing_address" style="text-align:end;" class="col-sm-3 col-form-label"><?php echo display('Reference No') ?><i class="text-danger">*</i></label>
                     <div class="col-sm-5">
                        <input class=" form-control" type="text"  name="ref_no" id="ref_no">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="bank" style="text-align:end;" class="col-sm-3 col-form-label"><?php echo display('Select Bank') ?>:<i class="text-danger">*</i></label>
                     <a data-toggle="modal" href="#bank_info" class="btn btnclr"><i class="fa fa-university"></i></a>
                     <div class="col-sm-5">
                        <select name="bank" id="bank" class="form-control bankpayment">
                           <?php foreach(getAllBanks() as $bank){ ?>
                           <option value="<?php echo $bank['bank_name']; ?>"><?php echo $bank['bank_name']; ?></option>
                           <?php } ?>
                        </select>
                     </div>
                  </div>
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                 <div class="form-group row">
                     <label for="billing_address" style="text-align:end;" class="col-sm-3 col-form-label"><?php echo display ('Amount to be paid') ?> : </label>
                     <div class="col-sm-5">
                        <table border="0">
                           <tr>
                              <td class="cus" name="cus" style="position: absolute; left: 170px; top: 6px;"></td>
                              <td><input  type="text" readonly name="amount_to_pay" id="amount_to_pay" style="width:270px;" class="form-control"/></td>
                           </tr>
                        </table>
                     </div>
                  </div>
                  <div class="form-group row" style="display:none;">
                     <label for="billing_address" style="text-align:end;" class="col-sm-3 col-form-label"><?php echo display ('Amount Received ') ?>: </label>
                     <div class="col-sm-5">
                        <table border="0">
                           <tr>
                              <td class="cus" name="cus" style="position: absolute; left: 170px; top: 6px;"></td>
                              <td><input  type="text"  readonly name="amount_received" value="0.00"  style="width:270px;" id="amount_received" class="form-control" /></td>
                           </tr>
                        </table>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="billing_address" style="text-align:end;" class="col-sm-3 col-form-label"><?php echo "Paid Amount"; ?>: <i class="text-danger">*</i></label>
                     <div class="col-sm-5">
                        <table border="0">
                           <tr>
                              <td class="cus" name="cus" style="position: absolute; left: 170px; top: 6px;"></td>
                              <td><input type="text" name="paid_amount" id="payment_from_modal" style="width:270px;" class="form-control" onkeyup="cal_balanceamt();"></td>
                           </tr>
                        </table>
                     </div>
                  </div>
                   <div class="form-group row">
                     <label for="billing_address" style="text-align:end;" class="col-sm-3 col-form-label"><?php echo display ('Balance ') ?> : </label>
                     <div class="col-sm-5">
                        <table border="0">
                           <tr>
                              <td class="cus" name="cus" style="position: absolute; left: 170px; top: 6px;"></td>
                              <td><input  type="text" readonly name="balance_modal" style="width:270px;" id="balance_modal" class="form-control" /></td>
                           </tr>
                        </table>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="billing_address" style="text-align:end;" class="col-sm-3 col-form-label"><?php echo display ('Additional Information') ?>  : </label>
                     <div class="col-sm-5">
                        <input class=" form-control" type="text"  name="details"/>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="billing_address" style="text-align:end;" class="col-sm-3 col-form-label"><?php echo display ('Attachments ') ?> : </label>
                     <div class="col-sm-5">
                        <input class=" form-control" type="file"  name="payment_attachement" id="attachement" />
                     </div>
                  </div>
               </div>
         </div>
         <div class="modal-footer">
         <div class="col-sm-8"></div>
         <div class="col-sm-4">
         <input class="btn btnclr" type="submit" name="submit_pay" id="submit_pay" value=<?php echo display ('submit') ?>>
         <a href="#" class="btn btnclr" data-dismiss="modal"><?php echo display ('Close') ?></a>
         </div>
         </div>
      </div>
      </form>
   </div>
</div>
<script type="text/javascript">
function cal_balanceamt(){
   var pay = $('#amount_to_pay').val();
   var amount_received = $('#payment_from_modal').val();
   var bal = pay-amount_received;
   $('#balance_modal').val(bal.toFixed(2));
}
var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
$(document).ready(function(){
    
    var succalert = '<div class="alert alert-success alert-dismissible" role="alert">';
    var failalert = '<div class="alert alert-danger alert-dismissible" role="alert">';
   
    $("#add_payment_info").validate({
        rules: {
            payment_date: "trimRequired",
            ref_no: "trimRequired",
            bank: "trimRequired",
            paid_amount: "trimRequired"
        },
        messages: {
            payment_date: "Payment date is required",
            ref_no:'Reference No is required',
            bank:'Select bank is required',
            paid_amount : 'Paid Amount is required'
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
                    type:"POST",
                    url:"<?php echo base_url(); ?>Cinvoice/insertPayment",
                    data:formData,
                    dataType:"json",
                    contentType: false, 
                    processData: false, 
                    success:function (response) {
                    	console.log(response, 'response');
                    //	debugger;
                        if (response.status == 'success') {
                           var already_paid = parseFloat($('#amount_paid').val()) || 0;
                           var current_paid = parseFloat(response.paymentData[0]['amt_paid']) || 0;
                           var total_paid = already_paid + current_paid;
				                $('#paymenterrormessage').html('<div class="alert alert-success alert-dismissible text-left" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
				                $('.amt').css('display', 'table-cell');
				                if (response.paymentData && response.paymentData.length > 0) {
					                $('#makepaymentId').val(response.paymentData[0]['payment_id']);
                                $('#makepaymentProvider').val(response.paymentData[0]['payment_id']);
					                $('#amount_paid').val(total_paid);
                               $('#amount_paid_provider').val(total_paid);
					                $('#Balance').val(response.paymentData[0]['balance']);
					                $('#balance').val(response.paymentData[0]['balance']);
                               $('#balance_provider').val((response.paymentData[0]['balance']));
                               var customer_currency = $('#custocurrencyrate').val();
                               $('#balance_customer_currency').val((customer_currency*response.paymentData[0]['balance']).toFixed(2));
                                $('#paid_customer_currency').val((customer_currency*total_paid).toFixed(2));
					            }
				                setTimeout(function() {
				                    $('#payment_modal').modal('hide');
				                    $('#add_payment_info')[0].reset();
				                }, 1500);
			                } else {
			                    $('#paymenterrormessage').html('<div class="alert alert-danger alert-dismissible text-left" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
			            }
                    }
                });
            event.preventDefault();
        }
    });

});
</script>
<?php }

if(in_array(BOOTSTRAP_MODELS['tax_info'],$bootstrap_model)){ ?>
<!-- Tax Model -->
<div class="modal fade" id="tax_info" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="text-align:center;" >
           <div class="modal-header btnclr">
              <a href="#" class="close" data-dismiss="modal">&times;</a>
              <h4 class="modal-title"> Add Tax </h4>
           </div>
            <form id="tax_btn" name="tax_btn" class="frm" method="post">
               <div class="modal-body">
                  <div id="taxerrormessage"></div>
                     <div class="panel-body">
                        <input type ="hidden" name="csrf_test_name" id="" value="<?php echo $this->security->get_csrf_hash();?>">
                        <input type ="hidden" name="status_type" value="sales">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group text-left">
                                 <label>Enter Tax percent % <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="tax_percent" id="tax_percent" step="0.01" maxlength="3" placeholder="%" required />
                                 <input type="hidden" name="admin_company_id" id="admin_company_id" value="<?php echo $_GET['id']; ?>">
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group text-left">
                                 <label>Description</label>
                                 <input type="text" class="form-control" name ="description" id="description" type="text" placeholder="Description">
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group text-left">
                                 <label>State <span class="text-danger">*</span></label>
                                 <select name="tax_state" id="tax_state" class="form-control" required>
                                    <option selected="true" disabled="disabled" value="">Select your State</option>
                                    <?php
                                        $states = getAllStates();
                                        foreach ($states as $key => $state) { ?>
                                        <option value="<?php echo $state['state_name']; ?>"><?php echo $state['state_name'];?></option>
                                    <?php } ?>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group text-left">
                                 <label>Tax Agency <span class="text-danger">*</span></label>
                                 <select name="tax_agency" class="form-control" required>
                                    <option selected="true" disabled="disabled" value="">Please Select Taxes</option>
                                    <option value="Federal Taxes">Federal Taxes</option>
                                    <option value="State Taxes">State Taxes</option>
                                    <option value="Municipal Taxes">Municipal Taxes</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group text-left">
                                 <label>Account <span class="text-danger">*</span></label>
                                 <select name="tax_account" id="tax_account" class="form-control" required>
                                    <option selected="true" disabled="disabled" value="">Please Select Accounts</option>
                                    <option value="Accounts receivable">Accounts receivable</option>
                                    <option value="Accounts payable">Accounts payable</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group text-left">
                                 <label>Show Tax On Return Line <span class="text-danger">*</span></label>
                                 <select name="show_taxonreturn" id="show_taxonreturn" class="form-control" required>
                                    <option selected="true" disabled="disabled" value="">Please Select tax on return line</option>
                                    <option>Tax collected on sales</option>
                                    <option>Adjustments to tax on sales</option>
                                    <option>Other adjustments</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                    </div>
                </div>
            <div class="modal-footer">
               <input type="submit" class="btn btnclr"   value=<?php echo display('Submit') ?>>
               <a href="#" class="btn btnclr"   data-dismiss="modal"><?php echo display('Close') ?> </a>
            </div>
           </form>
           <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
     <!-- /.modal -->
</div>
<script type="text/javascript">
var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
$(document).ready(function(){
    var succalert = '<div class="alert alert-success alert-dismissible text-left" role="alert">';
    var failalert = '<div class="alert alert-danger alert-dismissible text-left" role="alert">';
     $.validator.addMethod("trimRequired", function(value, element) {
        return $.trim(value) !== "";
    }, "This field is required.");
    $("#tax_btn").validate({
        rules: {
         tax_percent: "trimRequired",
         tax_state: "trimRequired",
         tax_agency: "trimRequired",
         tax_account: "trimRequired",
         show_taxonreturn: "trimRequired",
        },
        messages: {
         tax_percent: "Tax percent is required",
         tax_state: "State is required",
         tax_agency: {
                required : 'Tax agency is required',
            },
         tax_account: {
                required: "Account is required"
            },
         show_taxonreturn: 'Show Tax On Return Line is required'
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
                    type:"POST",
                    dataType:"json",
                    url:"<?php echo base_url(); ?>Cinvoice/insert_proformataxinfo",
                    data:formData,
                    contentType: false,
                    processData: false,
                    success:function (response) {
                        console.log(response);
                        if (response.status == 'success') {
                           $('#taxerrormessage').html('<div class="alert alert-success alert-dismissible text-left" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
                           $('#magic_tax').empty();
                           $.each(response.taxdata, function(index, taxes) {
                              
                              $('#magic_tax').append(
                                    $('<option/>').attr('value', taxes.tax_id + '-' + taxes.tax) .text(taxes.tax_id + '-' + taxes.tax + '%')
                              );
                           });
                           setTimeout(function() {
                              // $('#tax_info').modal('hide');
                           }, 1500);
                        } else {
                           $('#taxerrormessage').html('<div class="alert alert-danger alert-dismissible text-left" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
                        }
                    }
                });
            event.preventDefault();
        }
    });
});
 </script>                 
<?php } if(in_array(BOOTSTRAP_MODELS['bank_info'],$bootstrap_model)){ ?>
<!-- Bank Modal -->
<div class="modal fade" id="bank_info">
   <div class="modal-dialog modal-md">
      <div class="modal-content" style="text-align:center;" >
         <div class="modal-header btnclr"  >
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title"><?php echo display('ADD BANK') ?></h4>
         </div>
         <div class="container"></div>
         <form id="add_bank"  method="post">
         <div id="customererrormessage"></div>
            <div class="modal-body">
                <div id="bankerrormessage"></div>
                <div class="panel-body">
                  <input type ="hidden" name="csrf_test_name" id="" value="<?php echo $this->security->get_csrf_hash();?>">
                  <div class="form-group row">
                     <label for="bank_name" class="col-sm-4 col-form-label"><?php echo display('bank_name') ?> <i class="text-danger">*</i></label>
                     <div class="col-sm-6">
                        <input type="text" class="form-control" name="bank_name" id="bank_name" placeholder="<?php echo display('bank_name') ?>" tabindex="1" required>
                        <input type="hidden" name="admin_company_id" id="admin_company_id" value="<?php echo $_GET['id']; ?>">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="ac_name" class="col-sm-4 col-form-label"><?php echo display('ac_name') ?> <i class="text-danger">*</i></label>
                     <div class="col-sm-6">
                        <input type="text" class="form-control" name="ac_name" id="ac_name" required placeholder="<?php echo display('ac_name') ?>" tabindex="2"/>
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
                        <input type="text" class="form-control" name="branch" id="branch" required placeholder="<?php echo display('branch') ?>" tabindex="4"/>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="shipping_line" class="col-sm-4 col-form-label"><?php echo display('Country') ?>
                     <i class="text-danger"></i>
                     </label>
                     <div class="col-sm-6">
                        <select class="selectpicker countrypicker form-control"  data-live-search="true" data-default="United States"  name="country" id="country" style="width:100%">
                            <?php foreach (getAllCountries() as $conval){
                                $selectcon = $conval['iso3'] =='USA' ? 'selected' : '';
                                echo '<option '.$selectcon.' value="'.$conval['name'].'">'.$conval['name'].'</option>';
                            } ?>
                        </select>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="previous_balance" class="col-sm-4 col-form-label"><?php echo display('Currency') ?></label>
                     <div class="col-sm-6">
                        <select id="currency" name="currency1" class="form-control" style="max-width: -webkit-fill-available;">
                           <option>Select your currency</option>
                            <?php 
							    $defaultCurrency = 'USD';
							    foreach (getAllCurrencies() as $currency) { 
							        $isSelected = ($currency['code'] === $defaultCurrency) ? 'selected' : '';
							?>
							    <option value="<?php echo $currency['code']; ?>" <?php echo $isSelected; ?>>
							        <?php echo $currency['description'] . ' - ' . $currency['code'] . ' - ' . $currency['symbol']; ?>
							    </option>
							<?php } ?>
                        </select>
                     </div>
                  </div>
               </div>
         </div>
         <div class="modal-footer">
             <div class="row">
                 <div class="col-sm-12">
                 <input type="submit" id="addBank" class="btn btnclr" name="addBank" value="<?php echo display('submit') ?>"/>
                 <a href="#" class="btn btnclr" data-dismiss="modal"><?php echo display('Close') ?></a>
                 </div>
             </div>  
         </div>
         </form>
      </div>
   </div>
</div>
<script type="text/javascript">




var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
$(document).ready(function(){

var succalert = '<div class="alert alert-success alert-dismissible text-left" role="alert">';
var failalert = '<div class="alert alert-danger alert-dismissible text-left" role="alert">';
   
$("#add_bank").validate({
    rules: {
        bank_name: "trimRequired",
        ac_name: "trimRequired",
        ac_no: "trimRequired",
        branch: "trimRequired"
    },
    messages: {
        bank_name: "Bank name is required",
        ac_name:'Account name is required',
        ac_no:'Account number is required',
        branch : 'Branch is required'
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
                type:"POST",
                url:"<?php echo base_url(); ?>Cinvoice/add_bank",
                data:formData,
                dataType:"json",
                contentType: false, 
                processData: false, 
                success:function (response) {
                    if (response.status == 'success') {
		                $('#bankerrormessage').html('<div class="alert alert-success alert-dismissible text-left" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
		                var result = '';

		                $.each(response.bankdata, function (i, item) {
		                    result += '<option value="' + item.bank_name + '">' + item.bank_name + '</option>';
		                });
		                $('.bankpayment').selectmenu();
		                $('.bankpayment').append(result).selectmenu('refresh', true);
		                setTimeout(function() {
		                    $('#bank_info').modal('hide');
		                    $('#bank_info')[0].reset();
		                }, 1500);

		            } else {
		                $('#bankerrormessage').html('<div class="alert alert-danger alert-dismissible text-left" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
		            }
                }
            });
        event.preventDefault();
    }
});

});
</script>
<?php }
if(in_array(BOOTSTRAP_MODELS['sendemailmodal'],$bootstrap_model)){ ?>
<div class="modal fade" id="sendemailmodal" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="text-align:center;" >
           <div class="modal-header btnclr">
              <a href="#" class="close" data-dismiss="modal">&times;</a>
              <h4 class="modal-title">Send Proforma Invoice</h4>
           </div>
            <form id="send_mailform" class="frm" method="post">
               <div class="modal-body">
                  <div id="mailerrormessage"></div>
                     <div class="panel-body">
                        <input type ="hidden" name="csrf_test_name" id="" value="<?php echo $this->security->get_csrf_hash();?>">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group text-left">
                                 <label>To: <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control customerEmail" name="to_email" required>
                                 <input type="hidden" name="admin_company_id" id="admin_company_id" value="<?php echo $_GET['id']; ?>">
                                 <input type="hidden" class="getproformaId">
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group text-left">
                                 <label>CC:</label>
                                 <input type="text" class="form-control" name ="cc_email">
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group text-left">
                                 <label>Subject </label>
                                 <textarea class="form-control" name="subject"></textarea>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group text-left">
                                 <label>Message</label>
                                 <textarea class="form-control" name="message"></textarea>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group text-left">
                                 <img src="<?php echo base_url('assets/images/pdf.png'); ?>">
                              </div>
                           </div>
                        </div>
                    </div>
                </div>
            <div class="modal-footer">
               <input type="submit" class="btn btnclr submitemailButton" value=<?php echo display('Send') ?>>
               <a href="#" class="btn btnclr" data-dismiss="modal"><?php echo display('Close') ?> </a>
            </div>
           </form>
           <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
     <!-- /.modal -->
</div>
<script type="text/javascript">
var emailform = document.getElementById('send_mailform');

$('#send_mailform').submit(function (event) {
    event.preventDefault();
    var $button = $('.submitemailButton');
    $button.val('Sending...').prop('disabled', true);
    var formData = new FormData(emailform);
    formData.append(csrfName, csrfHash);

    $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url('Cinvoice/sendemailProforma'); ?>",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            console.log(response, "response");

            if (response.status == 'success') {
                toastr.success(response.msg, 'Success', {
                    timeOut: 1500,
                    closeButton: true,
                    progressBar: true
                });

                setTimeout(function() {
                    $('#sendemailmodal').modal('hide');
                    $('#send_mailform')[0].reset();
                }, 1500);

            } else {
                toastr.error(response.msg, 'Error', {
                    closeButton: true,
                    progressBar: true
                });
            }

            $button.val('<?php echo display('Send'); ?>').prop('disabled', false);
        },
       
    });
});

</script>
<?php } 
if(in_array(BOOTSTRAP_MODELS['payment_type'],$bootstrap_model)){ ?>
   <div class="modal fade" id="payment_type" tabindex="-1" role="dialog" aria-labelledby="paymentTypeNewLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document" style="display: flex; justify-content: center; align-items: center; min-height: 40vh;">
              <div class="modal-content" style="width: 600px; margin: auto;">
          <div class="modal-header btnclr"  >
              <a href="#" class="close" data-dismiss="modal">&times;</a>
              <h4 class="modal-title"><?php echo ('PAYMENT TYPE') ?></h4>
          </div>
            <div id="paymenttypeerrormessage" class="alert"></div>
          <div class="modal-body">
            <div id="errormessage_payment_type" class="alert"></div>
              <form id="add_pay_type" method="post">
                    <div class="panel-body">
                       <input type ="hidden" name="csrf_test_name" id="" value="<?php echo $this->security->get_csrf_hash();?>">
                       <div class="form-group row">
                             <label for="customer_name" style="width: auto;" class="col-sm-3 col-form-label"><?php echo ('Payment Type') ?><i class="text-danger">*</i></label>
                             <div class="col-sm-6">
                                  <input type="hidden" name="admin_company_id" id="admin_company_id" value="<?php echo $_GET['id']; ?>">
                                <input class="form-control" name ="new_payment_type" id="new_payment_type" type="text" placeholder="New Payment Type" tabindex="1" required>
                             </div>
                       </div>
                    </div>
                 </div>
                 <div class="modal-footer">
                       <input type="submit" class="btnclr btn"   value="<?php echo display('Submit') ?>">
                       <a href="#" class="btnclr btn"   data-dismiss="modal"><?php echo display('Close')?></a>
                 </div>
              </form>
           </div><!-- /.modal-body -->
        </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
     <script type="text/javascript">
      $("#add_pay_type").validate({
         rules: {
            new_payment_type: "required"
         },
         messages: {
            new_payment_type: "Payment Type  is required"
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
               url: '<?php echo base_url(); ?>Cinvoice/add_payment_type', 
               data: formData,
               dataType: "json",
               contentType: false,
               processData: false,
               success: function(response) {
                  $('#errormessage_payment_type').html("");
                  if (response.status === 'success') {
                     $('#errormessage_payment_type').html('<div class="alert alert-success alert-dismissible" role="alert">' +
                           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                           '<span aria-hidden="true">×</span></button>' +
                           response.msg + '</div>');
                        var $select = $('select#paytype');
                  $('select#paytype').empty();
                  $.each(response.pterms, function(index, customer) {
                     $('select#paytype').append(
                           $('<option/>').attr('value', customer.payment_type).text(customer.payment_type)
                     );
                  });
                  setTimeout(function() {
                     $('#payment_type').modal('hide');
                  }, 1500);
                  } else {
                     $('#errormessage_payment_type').html('<div class="alert alert-danger alert-dismissible" role="alert">' +
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
?>

<?php } ?>

<!-- For Sales - SOLD BY field - Sales Partner Start -->
<div class="modal fade salespartnerAddModalsdata" id="salesPartners" role="dialog">
   <div class="modal-dialog modal-xl" role="document" style='width:auto;'>
      <div class="modal-content" style="text-align:center;">
         <div class="modal-header btnclr">
            <a href="#" class="close" data-dismiss="modal">&times;</a>
            <h4 class="modal-title"> <?php echo ('SALES PARTNER'); ?> </h4>
         </div>
         <div class="modal-body" style="max-height: 800px; overflow-y: auto;">
            <div id="errormessage_salespartner" class="alert"></div>
          <form id="add_salesPartners"  method="post" enctype="multipart/form-data">
               <div class="row">
                    <input type ="hidden"  id="id" value="<?php echo $_GET['id'];  ?>" name="id" />
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                  <!-- Left Side -->
               <div class="col-sm-6">
                  <div class="form-group row">
                     <label for="first_name" class="col-sm-4 col-form-div"><?php echo display('first_name') ?> <i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <input name="sfirst_name" id="sfirst_name" class="form-control" type="text"  required placeholder="<?php echo display('first_name') ?>">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="middle_name" class="col-sm-4 col-form-div"><?php echo "Middle Name"; ?></label>
                     <div class="col-sm-8">
                        <input name="smiddle_name" id="smiddle_name" class="form-control" type="text" placeholder="<?php echo "Middle Name"; ?>" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="last_name" class="col-sm-4 col-form-div"><?php echo display('last_name') ?><i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <input name="last_name" id="last_name" class="form-control" type="text"  required placeholder="<?php echo display('last_name') ?>"   oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="last_name" class="col-sm-4 col-form-div"><?php echo ("Business Name") ?></label>
                     <div class="col-sm-8">
                        <input name="salesbusiness_name" id="salesbusiness_name" class="form-control" type="text" placeholder="<?php echo "Business Name" ?>" id="salesbusiness_name" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="phone" class="col-sm-4 col-form-div"><?php echo display('phone') ?> <i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <input class="form-control" name ="phone" id="phone" type="tel"   required style="border: 2px solid #d7d4d6;"  placeholder="(XXX) XXX-XXXX"   tabindex="3"  oninput="formatPhoneNumber(this)" >
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="Profile Image" class="col-sm-4 col-form-label">
                     Email
                     </label>
                     <div class="col-sm-8">
                        <input name="email" class="form-control" type="email" placeholder="<?php echo display('email') ?>" id="semail" oninput="validateEmail(this)">
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
                        <input class="form-control" name="state" id="state" type="text"  style="border:2px solid #D7D4D6;"    placeholder="<?php echo display('state') ?>"  oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
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
                        <select name="country" id="country" class="form-control">
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
                  <div class="form-group row" id="payment_from">
                     <label for="city" class="col-sm-4 col-form-div"><?php echo ('Sales Commission') ?></label>
                     <div class="col-sm-8">
                        <input name="sc" class="form-control" type="text" placeholder="<?php echo 'sales commission percentage' ?>">
                     </div>
                  </div>
                  <div class="form-group row" id="payment_from">
                        <label for="choice" class="col-sm-4 col-form-div">Commission Withholding</label>
                     <div class="col-sm-8">
                        <input type="radio" name="choice" id="choice" value="Yes">Yes &nbsp;
                        <input type="radio" name="choice" id="choice" value="No">No
                        </div>
                  </div>
                  <div class="form-group row">
                     <label for="email" class="col-sm-4 col-form-div">Social security number <i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <input id="ssnInput" name="ssnInput"  class="form-control" type="text"   placeholder="Social security number"   oninput="exitsocialsecurity(this, 9)">
                     </div>
                     <br><br>
                     <span style="font-weight: bold;">(OR)</span>
                  </div>
                  <div class="form-group row">
                     <label for="hourly_rate_or_salary" id="cost" class="col-sm-4 col-form-div"><?php echo ('Federal Identification Number') ?> <i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <input id="federalidentificationnumber" name="federalidentificationnumber" class="form-control" type="text" placeholder="Federal Identification Number" oninput="exitsocialsecurity(this, 9)">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="hourly_rate_or_salary" id="cost" class="col-sm-4 col-form-div"><?php echo ('Federal Tax Classification') ?> <i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <select name="federaltaxclassification" id="federaltaxclassification" required class="form-control" style="width: 100%;"  >
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
                     <div class="col-sm-8" >
                        <select name="paytype"  id="paytype" class="form-control" style="width: 100%;" >
                           <option value="">Select Type</option>
                           <?php foreach ($paytype as $ptype) {?>
                           <option value="<?php echo $ptype['payment_type']; ?>"><?php echo $ptype['payment_type']; ?></option>
                           <?php }?>
                        </select>
                     </div>
                  </div>
                  <div class="form-group row" id="bank_name">
                     <label for="bank_name" class="col-sm-4 col-form-label"> <?php echo display('Bank') ?>  </label>
                     <div class="col-sm-8">
                        <select name="bank_name" id="bank_name"  class="form-control bankpayment"  style="width:455px;" >
                           <option>Select Bank</option>
                            <?php foreach (getAllBanks() as $bank) {?>
                           <option value="<?=$bank['bank_name'];?>"><?=$bank['bank_name'];?></option>
                           <?php }?>
                        </select>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="blood_group" class="col-sm-4 col-form-div">Routing number </label>
                     <div class="col-sm-8">
                        <input name="routing_number" id="routing_number" class="form-control" type="text" placeholder="Routing number" oninput="routingrestrict(this, 15)">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="zip" class="col-sm-4 col-form-div"><?php echo 'Account Number' ?></label>
                     <div class="col-sm-8">
                        <input type="text" name="account_number" name="account_number" class="form-control" placeholder="Account Number" oninput="routingrestrict(this, 15)">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="zip" class="col-sm-4 col-form-div"><?php echo ('Employee Tax') ?><i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <select  name="emp_tax_detail" id="emp_tax_detail" class="form-control" style="width:522px;" >
                           <option value="">Select Tax</option>
                           <option value="single">Single</option>
                           <option value="tax_filling">Tax Filling</option>
                           <option value="married">Married</option>
                           <option value="head_household">Head Household</option>
                        </select>
                     </div>
                  </div>
                  <div id="popupsalespartner" class="popup btnclr popupsalespartner" style='padding-left: 20px;padding-right: 20px;padding-bottom: 50px;display:none;'>
                     <!-- Popup content -->
                     <div class="row">
                        <!-- Working Taxes -->
                        <div class="col-sm-6">
                           <h4 style="text-align:center;margin-left: 140px;">WORK LOCATION TAXES</h4>
                           <br>
                           <div class="form-group fg" >
                              <label for="stateTaxDropdown">State Tax<i class="text-danger">*</i></label>
                              <input list="magic_state_tax" name="state_tax" id="state_tax" class="form-control">
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
                        <!-- Living Taxes -->
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
                     <div style='float:right;font-weight:bold;'>
                        <!-- Button to add popup data -->
                        <button type="button"   style="background-color:green;"  class="btn btnclr addPopupData"   id="addPopupsalespartnerData">Save</button>
                     </div>
                  </div>
                  <br/>
                  <div class="form-group row">
                     <label for="withholding_tax" class="col-sm-4 col-form-label">Withholding Tax <i class="text-danger">*</i></label>
                     <div class="col-sm-8">
                        <button type="button" class="btnclr btn showPopup">Add Withholding Tax</button>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="ETA" class="col-sm-4 col-form-label"><?php echo display('Attachments ') ?></label>
                        <div class="col-sm-6">
                            <input type="file" name="files[]" class="form-control"  style="width: 522px;"  multiple/>
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
            <div class="row">
               <div class="col-md-12" style="text-align:right;">
                  <div class="form-group">
                     <button type="submit" id="salesCheckSubmit" class="btnclr btn w-md m-b-5"><?php echo display('save') ?></button>
                     <a href="#" class="btn btnclr"  data-dismiss="modal"><?php echo display('Close') ?> </a>
                    </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
</div>
