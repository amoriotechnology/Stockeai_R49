<style>
.error {
    color: red;
}
.select2-container--default .select2-selection--single {
    border-color: #ced4da;
    height: calc(1.5em + 0.75rem + 2px);
    padding: 0.375rem 0.75rem;
}
.select2-container--default .select2-selection--single.error {
    border-color: red !important;
}

.img-flag{
  max-height: 11px;
}

</style>

<!-- Edit supplier page start -->
 
<div class="content-wrapper">

    <section class="content-header">
        <div class="header-icon">
            <figure class="one">
               <img src="<?php echo base_url()  ?>asset/images/supplier.png"  class="headshotphoto" style="height:50px;" />
            <figure>
        </div>
      

      <div class="header-title">
            <div class="logo-holder logo-9">
                <h1><?php echo ('Edit Vendor') ?></h1>
            </div> &nbsp; &nbsp;
                <ol class="breadcrumb" style="border:3px solid #d7d4d6;" >
                    <li><a href="<?php echo base_url(); ?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                    <li><a href="<?php echo base_url('Csupplier/manage_supplier?id='.$_GET['id']); ?>"><?php echo display('vendor') ?></a></li>
                    <li class="active" style="color:orange"><?php echo ('Edit Vendor') ?></li>
                    <div class="load-wrapp">
                        <div class="load-10">
                            <div class="bar"></div>
                        </div>
                    </div>
                </ol>
        </div>
    </section>



    <section class="content">

       
       
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
    width: 130px;
  }
}
   
</style>


        <!-- New supplier -->

        <div class="row">

            <div class="col-sm-12">

                <div class="panel panel-bd lobidrag" style="border: 3px solid #D7D4D6;">
                <div class="panel-heading" >

                    <div class="panel-heading" style="height: 55px;" >

                        <div class="panel-title">

                            <div id="bloc2" style="float:right;">
                                <a href="<?php echo base_url('Csupplier/manage_supplier?id='.$_GET['id']); ?>"   class="btn btnclr dropdown-toggle"   style="float:right; "><i class="ti-align-justify"> </i>  <?php echo ('Manage Vendor') ?> </a>
                            </div>   
                        </div>

                    </div>
                   <form id="ven_update_supplier"  method="post" enctype="multipart/form-data">
                    <div class="panel-body">
                    <div class="error_display mt-2"></div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="" class="col-sm-4    col-form-label"   >Vendor Type<i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <select name="sup_vendor_type" id="sup_vendor_type" class=" form-control"  placeholder='' required="" id="vendor_type" style="width:100%;border:2px solid #d7d4d6;">
                                    <option value="productsupplier" <?php echo $vendor_type == 'productsupplier' ? 'selected' : ''; ?>>Product Supplier</option> 
                                    <option value="servicevendor" <?php echo $vendor_type == 'servicevendor' ? 'selected' : ''; ?>> Service Vendor</option> 
                                    <option value="others" <?php echo $vendor_type == 'others' ? 'selected' : ''; ?>> Others</option> 
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="supplier_name" class="col-sm-4 col-form-label"> Company Name<i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name ="ven_supplier_name" id="ven_supplier_name" type="text" placeholder="<?php echo display('supplier_name') ?>" value="{supplier_name}"  style="border:2px solid #d7d4d6;"  required="" tabindex="1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-sm-4 col-form-label">Business Phone <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                            
                                    <input class="form-control" name="ven_phone" id="ven_phone"  style="border:2px solid #d7d4d6;" type="tel" placeholder="(XXX) XXX-XXXX" required=""  value="<?php echo $businessphone; ?>"  tabindex="2" oninput="formatPhoneNumber(this)">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mobile" class="col-sm-4 col-form-label"> Mobile <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                <input class="form-control" name="ven_mobile" id="ven_mobile"  style="border:2px solid #d7d4d6;" type="number" placeholder="<?php echo display('mobile') ?>" value="{mobile}"  tabindex="2">
                                </div>
                            </div>
                         

                            <div class="form-group row">

                                <label for="contact" class="col-sm-4 col-form-label">Contact Person <i class="text-danger"></i></label>

                                <div class="col-sm-8">

                                    <input class="form-control" style="border:2px solid #d7d4d6;"  name="ven_contact" id="ven_contact" type="text" placeholder="<?php echo display('contactperson') ?>" value="{contactperson}" >

                                </div>
                            </div>
                            <div class="form-group row">

                                <label for="email" class="col-sm-4 col-form-label">Primary Email <i class="text-danger">*</i></label>

                                <div class="col-sm-8">

                                    <input class="form-control" name="ven_email" id="ven_email" type="email" placeholder="<?php echo display('primaryemail') ?>"  value="{primaryemail}"  style="border:2px solid #d7d4d6;" tabindex="2">

                                </div>

                            </div>


                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

                         <div class="form-group row">

                            <label for="emailaddress" class="col-sm-4 col-form-label">Secondary Email<i class="text-danger"></i></label>

                            <div class="col-sm-8">

                                <input class="form-control" name="ven_emailaddress" id="ven_emailaddress" type="text"  style="border:2px solid #d7d4d6;"  placeholder="<?php echo display('secondaryemail')?>" value="{secondaryemail}"  >

                            </div>

                        </div>
                        <div class="form-group row">

                            <label for="fax" class="col-sm-4 col-form-label">Fax <i class="text-danger"></i></label>

                            <div class="col-sm-8">

                                <input class="form-control" style="border:2px solid #d7d4d6;"  name="ven_fax" id="ven_fax" type="text" placeholder="<?php echo display('fax') ?>" value="{fax}" >

                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-4 col-form-label"  required >Tax Collected<i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                               <select class="form-control" name="ven_service_provider" id="ven_service_provider"  style="border:2px solid #d7d4d6;"  required="">
                                <option value="0" <?php echo $taxcollected ==0 ? 'selected' : ''; ?> >No</option>
                                <option value="1" <?php echo $taxcollected ==1 ? 'selected' : ''; ?>>yes</option>

                               </select>
                            </div> 
                        </div>
                               

                            <div class="form-group row">
                            <label for="Preferred currency" class="col-sm-4 col-form-label" > Preferred currency<i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <select  class="form-control" id="ven_currency" name="ven_currency"  style="width: 100%;border:2px solid #d7d4d" required=""  style="max-width: -webkit-fill-available;">
                                    <option value="">Select Currency</option>   
                                    <?php foreach (getAllCurrencies() as $cval){
                                            $selectcurr = $cval['code'] == $currency_type ? 'selected' : '';
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
                            <label for="address " class="col-sm-4 col-form-label">Address</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="ven_address" id="ven_address" rows="3" style="border:2px solid #d7d4d6;"  placeholder="<?php echo display('address') ?>" tabindex="4">{address}</textarea>
                                </div>
                        </div>
                        <div class="form-group row">

                            <label for="city" class="col-sm-4 col-form-label">City <i class="text-danger"></i></label>

                            <div class="col-sm-8">

                                <input class="form-control" name="ven_city" id="ven_city" style="border:2px solid #d7d4d6;"  type="text" placeholder="<?php echo display('city') ?>" value="{city}" >

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="state" class="col-sm-4 col-form-label"><?php echo display('state'); ?> <i class="text-danger"></i></label>
                            <div class="col-sm-8">
                                <input class="form-control" name="ven_state" id="ven_state" style="border:2px solid #d7d4d6;"   type="text" placeholder="<?php echo display('state') ?>" value="{state}"  >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="country" class="col-sm-4 col-form-label"  required="" >Country<i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <select class="selectpicker countrypicker form-control"  name="ven_country" id="ven_country"  style="border:2px solid #d7d4d6;"   id="country">   
                                    <?php foreach (getAllCountries() as $conval){
                                        $selectcon = $conval['iso3'] ==$country ? 'selected' : '';
                                        echo '<option '.$selectcon.' value="'.$conval['iso3'].'">'.$conval['iso3'].' - '.$conval['name'].'</option>';
                                    } ?>
                                </select>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="zip" class="col-sm-4 col-form-label"><?php echo display('zip'); ?> <i class="text-danger"></i></label>
                            <div class="col-sm-8">
                            <input class="form-control" name="ven_zip" id="ven_zip" type="text" placeholder="<?php echo display('zip') ?>"  style="border:2px solid #d7d4d6;"  value="{zip}">
                        </div>
                        </div>
                       
      
                        <div class="form-group row">

                            <label for="details" class="col-sm-4 col-form-label"><?php echo display('supplier_details') ?></label>

                            <div class="col-sm-8">

                                <textarea class="form-control" name="ven_details" id="ven_details" rows="3"  style="border:2px solid #d7d4d6;"  placeholder="<?php echo display('supplier_details') ?>" tabindex="4">{details}</textarea>

                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="previous_balance" class="col-sm-4 col-form-label">Credit Limit</label>
                            <div class="col-sm-8">
                                <input class="form-control" name="ven_previous_balance" style="border:2px solid #d7d4d6;"  id="ven_previous_balance" type="number"  placeholder="<?php echo display('credit_limit') ?>"  value="{credit_limit}" tabindex="5">
                                
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="previous_balance" class="col-sm-4 col-form-label"><?php echo "Previous Balance" ?></label>
                            <div class="col-sm-8">
                                <input class="form-control" name="ven_p_b" id="ven_p_b" value="{previous_balance}"  type="number" min="0" style="border:2px solid #d7d4d6;"  placeholder="Previous Balance" tabindex="5">
                            </div>

                        </div>    
                        <input type="hidden" name="supplier_id" value="{supplier_id}" />
                            <div class="form-group row">
                                <label for="payment_terms" class="col-sm-4 col-form-label">Payment Terms<i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <select   name="ven_terms" id="ven_terms" class="form-control"  style="border:2px solid #d7d4d6;"  required=""  placeholder='Payment Terms'>
                                        <?php /*<option value="<?php  echo  $paymentterms; ?>"><?php  echo $paymentterms; ?> </option>   */ 
                                        
                                        foreach(PAYMENT_TYPE as $payment_typ){
                                                $selectedpay  = $payment_typ == $paymentterms ? 'selected' :'';
                                                echo '<option '.$selectedpay.' value="'.$payment_typ.'">'.$payment_typ.'</option>';
                                        }
                                        foreach($paymentterms_add as $cn){
                                            $selectedpay  = $payment_typ ==$cn['paymentterms_add'] ? 'selected' :'';
                                            
                                            ?>
                                            <option <?php echo $selectedpay; ?> value="<?php echo $cn['paymentterms_add'];?>">  <?php echo $cn['paymentterms_add'];  ?></option>
                                           <?php } ?>
                                        </select>
                                    </div>
                                  
                                   </div>
                                    <div class="form-group row">
                                            <label for="adress" class="col-sm-4 col-form-label">Attachments
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="file" style="border:2px solid #d7d4d6;" name="ven_attachments" id="ven_attachments"  class="form-control">
                                                <?php if($attachments !=""){
                                                        $file_typ = checkFileType($attachments);
                                                        if($file_typ =='pdf'){
                                                            $path_url = '<a href="'.base_url().SUPPLIER_IMG_PATH.$attachments.'" download>View file</a>';
                                                        }else{
                                                            $path_url = '<img src ="'.base_url().SUPPLIER_IMG_PATH.$attachments.'" alt="image" height="100px" width="100px"/>';
                                                        }
                                                    ?>
                                                    <span class="fw-bold"><?php echo $path_url; ?></span>
                                                <?php } ?>
                                            </div>
                                    </div> 
                                </div> 
                            </div>

                            <div class="form-group row">
                                <input type="hidden" name="admin_company_id" id="admin_company_id" value="<?php echo $_GET['id']; ?>">
                                <input type="hidden" name="supplier_id" id="supplier_id" value="{supplier_id}">
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

        </div>

    </section>

</div>        
<div class="modal fade" id="myModal1" >
    <div class="modal-dialog">
      <div class="modal-content" style="    margin-top: 190px;text-align:center;">
        <div class="modal-header btnclr "    >
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Vendor</h4>
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
<script type="text/javascript">
var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
$(document).ready(function(){
    var succalert = '<div class="alert alert-success alert-dismissible" role="alert">';
    var failalert = '<div class="alert alert-danger alert-dismissible" role="alert">';
    $('#sup_vendor_type').select2();
    $('#ven_service_provider').select2();
    // Custom validation method for Select2
    $.validator.addMethod("select2Required", function(value, element, arg) {
        console.log("Checking value for Select2:", $(element).val());

        return $(element).val() !== null && $(element).val() !== "";
    }, "This field is required.");
    // Custom method to trim input fields
    $.validator.addMethod("trimRequired", function(value, element) {
        return $.trim(value) !== "";
    }, "This field is required.");
    $("#ven_update_supplier").validate({
        rules: {
            sup_vendor_type: {
                select2Required: true
            },
            ven_supplier_name: "trimRequired",
            ven_phone: {
                trimRequired: true,
            },
            ven_email:  {
                trimRequired: true,
                email: true
            },
            ven_emailaddress:{
                email: true
            },
            ven_service_provider: "required",
            ven_currency: "required",
            ven_country: "required",
            ven_terms: "required"
        },
        messages: {
            sup_vendor_type: "Vendor Type is required",
            ven_supplier_name: "Company Name is required",
            ven_phone: {
                trimRequired : 'Business phone is required',
            },
            ven_mobile :{
                number  : true
            },
            ven_email: {
                trimRequired: "Please enter your email",
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
        highlight: function(element, errorClass) {
            if ($(element).hasClass("select2-hidden-accessible")) {
                $(element).next(".select2-container").find(".select2-selection--single").addClass(errorClass);
            } else {
                $(element).addClass(errorClass);
            }
        },
        unhighlight: function(element, errorClass) {
            if ($(element).hasClass("select2-hidden-accessible")) {
                $(element).next(".select2-container").find(".select2-selection--single").removeClass(errorClass);
            } else {
                $(element).removeClass(errorClass);
            }
        },
        
        submitHandler: function(form) {
            var dataString = {
                    dataString : $("#ven_update_supplier").serialize()
            };
            var formData = new FormData(form);

            formData.append(csrfName, csrfHash);

                $.ajax({
                    type:"POST",
                    dataType:"json",
                    url:"<?php echo base_url(); ?>Csupplier/supplier_update",
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
    $('#sup_vendor_type').on('change', function() {
        $(this).valid();
    });
    $('#ven_service_provider').on('change', function() {
        $(this).valid();
    });
    $('#ven_terms').on('change', function() {
        $(this).valid();
    });
});



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







