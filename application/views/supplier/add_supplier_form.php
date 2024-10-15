<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <figure class="one">
            <img src="<?php echo base_url()  ?>asset/images/supplier.png"  class="headshotphoto" style="height:50px;" />
        </div>
        
        <div class="header-title">
            <div class="logo-holder logo-9">
                <h1><?php echo display('Create vendor') ?></h1>
            </div>
            <small> </small>
            <ol class="breadcrumb" style=" border: 3px solid #d7d4d6;" >
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('vendor') ?></a></li>
                <li class="active" style="color:orange;"><?php echo display('Add vendor') ?></li>
            </ol>
        </div>
    </section>

    <section class="content">
        <div class="panel panel-bd lobidrag"  style="border:3px solid #D7D4D6;"  >
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag" style="border:3px solid #D7D4D6;">
                    <div class="panel-heading" style="height: 55px;" >
                        <div class="panel-title">
                            
                            <div id="bloc2" style="float:right;">
                                <a href="<?php echo base_url('Csupplier/manage_supplier?id='.$_GET['id']); ?>"  style="float: right;" class="btnclr btn btn-large"  ><i class="ti-align-justify"> </i>  <?php echo ('Manage Vendor') ?> </a>
                            </div>             
                            <h4></h4>
                            
                        </div>
                    </div>

                <form id="ven_insert_supplier"  method="post">
                    <div class="panel-body">
                        <div class="error_display mt-2"></div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label"><?php echo display('Vendor Type') ?><i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <select name="sup_vendor_type" id="sup_vendor_type" class="form-control" placeholder='' style="border:2px solid #D7D4D6;" required>
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
                                    <input class="form-control" name="ven_phone" id="ven_phone" type="tel" placeholder="(XXX) XXX-XXXX" required=""   tabindex="2" oninput="formatPhoneNumber(this)">
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
                                        <option value="1">YES</option>
                                        <option value="0" selected>NO</option>
                                    </select>
                                </div> 
                            </div>
                            <div class="form-group row">
                            <label for="Preferred currency1" class="col-sm-4 col-form-label" > <?php echo display('Preferred currency') ?><i class="text-danger">*</i></label>
                               
                                <div class="col-sm-6">
                                    <select name="ven_currency" id="ven_currency" class=" form-control" placeholder='' style="border:2px solid #D7D4D6;" required>
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
                                                echo '<option '.$selectcon.' value="'.$conval['iso3'].'">'.$conval['iso3'].' - '.$conval['name'].'</option>';
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
                                <div class="col-sm-7">
                                    <select name="ven_terms" id="ven_terms" class=" form-control"  style="border:2px solid #D7D4D6;"   required=""  placeholder='Payment Terms'>
                                        <option value=""><?php echo display('Select Payment Terms') ?></option>
                                            <?php
                                            foreach(PAYMENT_TYPE as $payment_typ){
                                                echo '<option value="'.$payment_typ.'">'.$payment_typ.'</option>';
                                            }
                                            ?>
                                    </select>
                                </div>
                                <div class="col-sm-1">
                                    <a href="#" class="btnclr client-add-btn btn " aria-hidden="true" style="border:2px solid #D7D4D6;"  data-toggle="modal" data-target="#payment_type_new" ><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                             
                            <div class="form-group row">
                                <label for="adress" class="col-sm-4 col-form-label"><?php echo display('Attachments') ?>
                                </label>
                                <div class="col-sm-8">
                                    <input type="file" name="ven_attachments" class="form-control">
                                </div>
                            </div> 
                        </div> 
                    </div>      
                    <div class="form-group row">
                        <input type="hidden" name="admin_company_id" id="admin_company_id" value="<?php echo $_GET['id']; ?>">
                        <label for="example-text-input" class="col-sm-0 col-form-label"></label>
                        <div class="col-sm-12 text-center">
                            <input type="submit" id="add-supplier" class="btnclr btn btn-large" name="add-supplier" value="Submit" tabindex="7" />
                            <a href="<?php echo base_url('Csupplier/manage_supplier?id='.$_GET['id']); ?>" class="btn btn-info">Cancel</a>
                        </div>
                    </div>
                </div>

             </div>
        </form>
    </div>
    </div>
                
        <div class="modal fade" id="myModal1" >
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content" style="margin-top: 190px;text-align:center;" >
                    <div class="modal-header btnclr"   >
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><?php echo display('Vendor') ?></h4>
                    </div>
                    <div class="modal-body" id="bodyModal1" style="font-weight:bold;text-align:center;">
                    
                    <h4></h4>
                
                    </div>
                    <div class="modal-footer">
          
                </div>
            </div>
        </div>
  </div>

  </div>
</div>
    </section>
</div>
<!-- Add new supplier end -->
<script type="text/javascript">
var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';



$(document).ready(function(){

    var succalert = '<div class="alert alert-success alert-dismissible" role="alert">';
    var failalert = '<div class="alert alert-danger alert-dismissible" role="alert">';
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
                error.insertAfter(element.next('span.select2')); // Place error message after the Select2 element
            } else {
                error.insertAfter(element);
            }
        },
       
        submitHandler: function(form) {
            var dataString = {
                    dataString : $("#insert_supplier").serialize()
            };

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
                            $('.error_display').html(succalert+response.msg+'</div>');
                        
                            window.setTimeout(function(){
                            
                                window.location = "<?php echo base_url(); ?>Csupplier/manage_supplier?id=<?php echo $_GET['id']; ?>"
                            },2500);
                        }else{
                            $('.error_display').html(failalert+response.msg+'</div>'); 

                        }
                    }
                });
            event.preventDefault();
        }
    });

});


</script>
<script type="text/javascript">
  
    function formatPhoneNumber(input) {
        // Remove non-numeric characters from the input
        var phoneNumber = input.value.replace(/\D/g, '');

        // Check if the input is not empty
        if (phoneNumber.length > 0) {
            // Format the phone number
            var formattedPhoneNumber = '(' + phoneNumber.substring(0, 3) + ') ' + phoneNumber.substring(3, 6) + ' ' + phoneNumber.substring(6, 10);

            // Set the formatted value back to the input
            input.value = formattedPhoneNumber;
        }
    }
 
  </script>
  
  <style>
  .ui-selectmenu-text{
        display:none;
      }
      .ui-menu {
        display:none;
      }
      </style>

<?php 
$CI = & get_instance();
$data['bootstrap_model'] = array('payment_terms');
$CI->load->view('include/bootstrap_model',$data);
?>