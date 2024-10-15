
<style>
    .select2{
        display:none;
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


.btnclr{
       background-color:<?php echo $setting_detail[0]['button_color']; ?>;
       color: white;

   }
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
    width: 190px;
  }
}

</style>

<!-- Add New Purchase Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <figure class="one">
            <img src="<?php echo base_url()  ?>asset/images/saleexport.png"  class="headshotphoto" style="height:50px;" />
        </div>
      
        <div class="header-title">
            <div class="logo-holder logo-9">
            <h1>Edit Ocean Export Tracking</h1>
            </div>
        <small></small>
            <ol class="breadcrumb" style="border: 3px solid #d7d4d6;">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('Sale') ?></a></li>
                <li class="active" style="color:orange;"><?php echo display('Edit Ocean Export Tracking') ?></li>
                <div class="load-wrapp">
                    <div class="load-10">
                        <div class="bar"></div>
                    </div>
                </div>
            </ol>
        </div>
    </section>
    <section class="content">
       
        <div class ="error_display"></div>
        <!-- Purchase report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag"    style="border: 3px solid #d7d4d6;" >
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div id="block_container">
                                <div id="bloc1" style="float:left;">
                                    <h4><?php //echo "Edit Ocean Export Tracking" ?></h4>
                               </div> 
                             <div id="bloc2" style="float:right;">
                                <a href="<?php echo base_url('sales/oceanExportTracking?id='.$_GET['id']) ?>" class="btnclr btn  m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display ('Manage Ocean Export Tracking') ?> </a>
                            </div>    
                        </div>

                    </div>

                </div>
                <div class="panel-body">
                   <form id="update_ocean_track" name="update_ocean_track" method="post" enctype ="multipart/form-data">  
                        <div class="row">
                           
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="supplier_sss" class="col-sm-4 col-form-label">Vendor
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <select name="supplier_id" id="supplier_id" class="form-control " style="border:2px solid #d7d4d6;"   required="" >
                                            <?php 
                                            foreach($supplier_list as $supplies){
                                                $selected_sup = $ocean_edit_details['shipper'] == $supplies['supplier_id'] ? 'selected' : '';
                                                echo '<option '.$selected_sup.' value="'.$supplies['supplier_id'].'">'.$supplies['supplier_name'].'</option>';
                                            } ?>
                                           
                                        </select>
                                    </div>
                                  <?php if($this->permission1->method('add_supplier','create')->access()){ ?>
                                    <div class="col-sm-2">
                                    </div>
                                <?php }?>
                                </div> 
                            </div>

                            


                           <div class="col-sm-6">
                              <div class="form-group row">
                                  <label for="booking_no" class="col-sm-4 col-form-label"><?php echo display('Booking No') ?>.
                                      <i class="text-danger">*</i>
                                  </label>
                                  <div class="col-sm-8">
                                      <input type="text" tabindex="3" class="form-control" name="booking_no" placeholder="Booking or B/L number" value="{booking_no}" id="booking_no"  style="border:2px solid #d7d4d6;"   readonly  required />
                                      <input type="hidden" id="ocean_export_tracking_id" name="ocean_export_tracking_id" value="<?php echo $ocean_edit_details['id']; ?>">
                                  </div>
                              </div>
                          </div>
                          
                      </div>

                      <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group row">
                                  <label for="date" class="col-sm-4 col-form-label"><?php echo display('Invoice Date') ?>
                                      <i class="text-danger">*</i>
                                  </label>
                                  <div class="col-sm-8">
                                      <?php $date = date('Y-m-d'); ?>
                                      <input type="date" required tabindex="2" class="form-control datepicker" name="invoice_date"  style="border:2px solid #d7d4d6;"  value="<?php echo $ocean_edit_details['invoice_date']; ?>" id="date"  required/>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label"><?php echo display('Customer / Consignee') ?>
                                    </label>
                                    <div class="col-sm-8">
                                    <select id="consignee" name="consignee" class="form-control "  style="border:2px solid #d7d4d6;"   required=""> 
                                    <option value="<?php echo $customer_id ;?>" selected="">{customer_name}</option>
                                          {customer}
                                          <option value="{customer_id}">{customer_name}</option>
                                          {/customer} 
                                        
                                      </select>
                                       
                                    </div>
                                </div> 
                            </div>
                           
                        </div>
                         
                      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
 

                      <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group row">
                                  <label for="etd" class="col-sm-4 col-form-label"><?php echo display('Notify Party') ?>
                                      <i class="text-danger">*</i>
                                  </label>
                                  <div class="col-sm-8">
                                      <input type="text" tabindex="3" class="form-control" name="notify_party" value="{notify_party}" placeholder="Notify Party" style="border:2px solid #d7d4d6;"   id="notify_party" required/>
                                  </div>
                              </div>
                          </div>

                          <div class="col-sm-6">
                             <div class="form-group row">
                                  <label for="eta" class="col-sm-4 col-form-label"><?php echo display('Vessel') ?>
                                  </label>
                                  <div class="col-sm-8">
                                      <textarea class="form-control" tabindex="4" id="vessel" name="vessel" placeholder="Vessel" style="border:2px solid #d7d4d6;"   rows="1">{vessel}</textarea>
                                  </div>
                              </div> 
                          </div>
                      </div>

                      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
 


                       <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group row">
                                  <label for="shipping_line" class="col-sm-4 col-form-label"><?php echo display('Voyage No') ?>.
                                      
                                  </label>
                                  <div class="col-sm-8">
                                      <input type="text" tabindex="3" class="form-control" name="voyage_no" value="{voyage_no}" placeholder="Voyage No."  style="border:2px solid #d7d4d6;"   id="voyage_no" />
                                  </div>
                              </div>
                          </div>

                           <div class="col-sm-6">
                              <div class="form-group row">
                                  <label for="bl_number" class="col-sm-4 col-form-label"><?php echo display('Port of loading') ?>
                                      <i class="text-danger">*</i>
                                  </label>
                                  <div class="col-sm-8">
                                      <input type="text" tabindex="3" class="form-control" name="port_of_loading" value="{port_of_loading}" placeholder="Port of loading"  style="border:2px solid #d7d4d6;"   id="port_of_loading" required/>
                                  </div>
                              </div>
                          </div>


                        
                      </div>


                        <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group row">
                                  <label for="bl_number" class="col-sm-4 col-form-label"><?php echo display('Port of discharge')  ?>
                                      <i class="text-danger">*</i>
                                  </label>
                                  <div class="col-sm-8">
                                      <input type="text" tabindex="3" class="form-control" name="port_of_discharge" value="{port_of_discharge}" placeholder="Port of discharge" style="border:2px solid #d7d4d6;"   id="port_of_discharge" required/>
                                  </div>
                              </div>
                          </div>


                              <div class="col-sm-6">
                             <div class="form-group row">
                                  <label for="container_no" class="col-sm-4 col-form-label"><?php echo display('Place of Delivery') ?> <i class="text-danger">*</i>
                                  </label>
                                  <div class="col-sm-8">
                                      <textarea class="form-control" tabindex="4" id="place_of_delivery" name="place_of_delivery"  style="border:2px solid #d7d4d6;"   placeholder="Place of Delivery" rows="1" required>{place_of_delivery}</textarea>
                                  </div>
                              </div> 
                          </div>
                      </div>

                      <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group row">
                                  <label for="customs_broker_name" class="col-sm-4 col-form-label"><?php echo display('Customs Broker Name') ?></label>
                                  <div class="col-sm-8">
                                  <input  class="form-control" tabindex="4" id=" customs_broker_name" name="customs_broker_name"  style="border:2px solid #d7d4d6;"   placeholder=" Customs Broker Name" value="{customs_broker_name}" rows="1">
                                  
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-6">
                             <div class="form-group row">
                                  <label for="mbl_no" class="col-sm-4 col-form-label"><?php echo display('MBL NO') ?></label>
                                  <div class="col-sm-8">
                                  <input  class="form-control" tabindex="4" id=" mbl_no" name="mbl_no"  placeholder=" MBL NO" style="border:2px solid #d7d4d6;"   value="{mbl_no}" rows="1">
                                  </div>
                              </div> 
                          </div>
                      </div>

                      <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group row">
                                  <label for="hbl_no" class="col-sm-4 col-form-label"><?php echo display('HBL NO') ?></label>
                                  <div class="col-sm-8">
                                  <input class="form-control" tabindex="4" id=" hbl_no" name="hbl_no"  placeholder=" HBL NO" style="border:2px solid #d7d4d6;"   value="{hbl_no}" rows="1">
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-6">
                             <div class="form-group row">
                                  <label for="obl_no" class="col-sm-4 col-form-label"><?php echo display('OBL NO') ?></label>
                                  <div class="col-sm-8">
                                  <input  class="form-control" tabindex="4" id=" obl_no" name="obl_no"  placeholder=" OBL NO" style="border:2px solid #d7d4d6;"  value="{obl_no}" rows="1">
                                  </div>
                              </div> 
                          </div>
                      </div>


                      <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group row">
                                  <label for="ams_no" class="col-sm-4 col-form-label"><?php echo display('AMS NO') ?></label>
                                  <div class="col-sm-8">
                                  <input  class="form-control" tabindex="4" id=" ams_no" name="ams_no"  placeholder=" AMS NO" style="border:2px solid #d7d4d6;"   value="{ams_no}" rows="1">
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-6">
                             <div class="form-group row">
                                  <label for="isf_no" class="col-sm-4 col-form-label"><?php echo display('ISF NO') ?></label>
                                  <div class="col-sm-8">
                                  <input  class="form-control" tabindex="4" id=" isf_no" name="isf_no"  placeholder=" ISF NO"  style="border:2px solid #d7d4d6;"   value="{isf_no}" rows="1">
                                  </div>
                              </div> 
                          </div>
                      </div>


                      <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group row">
                                  <label for="container_no" class="col-sm-4 col-form-label"><?php echo display('Container No') ?>
                                      <i class="text-danger">*</i>
                                  </label>
                                  <div class="col-sm-8">
                                     <textarea class="form-control" tabindex="4" id="container_no" name="container_no" placeholder="Container No"  style="border:2px solid #d7d4d6;"  rows="1" required>{container_no}</textarea>
                                  </div>
                              </div>
                          </div>
                         

                              <div class="col-sm-6">
                             <div class="form-group row">
                                  <label for="seal_no" class="col-sm-4 col-form-label"><?php echo display('Seal No') ?> <i class="text-danger">*</i>
                                  </label>
                                  <div class="col-sm-8">
                                      <textarea class="form-control" tabindex="4" id="seal_no" name="seal_no"  style="border:2px solid #d7d4d6;"  placeholder="Seal No" value="{seal_no}" rows="1" required>{seal_no}</textarea>
                                  </div>
                              </div> 
                          </div>
                      </div>
                      <input type="hidden" id="invoice_hdn"/> <input type="hidden" id="invoice_hdn1"/>
                      <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group row">
                                  <label for="Freight forwarder" class="col-sm-4 col-form-label"><?php echo display('Freight forwarder') ?>
                                      <i class="text-danger">*</i>
                                  </label>
                                  <div class="col-sm-8">
                                  <textarea class="form-control" tabindex="4" id="freight_forwarder" name="freight_forwarder" style="border:2px solid #d7d4d6;"   placeholder="Freight Forwarder" rows="1">{freight_forwarder}</textarea>
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

                                       
                                        <?php foreach ($view_attachments as $key => $attachment) { ?> 
                                            <span class="attach_<?php echo $key; ?>"><span class="file-block"><span class="file-delete" onClick="deleteAttachment(<?php echo $attachment['id']; ?>,<?php echo $key; ?>);"><i class="fa fa-trash-o"></i></span><a href="<?php  echo base_url(OCEAN_EXPORT_IMG_PATH.$attachment['files']); ?>" target=_blank><?php echo $attachment['files']; ?></a></span></span>
                                       <?php } ?>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    
                      <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group row">
                                  <label for="bl_number" class="col-sm-4 col-form-label"><?php echo display('Estimated time of departure') ?>
                                      <i class="text-danger">*</i>
                                  </label>
                                  <div class="col-sm-8">
                                  <?php $date = date('Y-m-d'); ?>
                                      <input type="date" required tabindex="2" class="form-control " id="esti_depart" name="esti_depart" style="border:2px solid #d7d4d6;"   value="<?php echo $ocean_edit_details['etd']; ?>" id="date"  />
                                  </div>
                              </div>
                          </div>


                              <div class="col-sm-6">
                             <div class="form-group row">
                                  <label for="container_no" class="col-sm-4 col-form-label"><?php echo display('Estimated Time of Arrival') ?> <i class="text-danger">*</i>
                                  </label>
                                  <div class="col-sm-8">
                                  <?php $date = date('Y-m-d'); ?>
                                      <input type="date" required tabindex="2" class="form-control " name="est_time_arrival" id="est_time_arrival"  style="border:2px solid #d7d4d6;"   value="<?php echo $ocean_edit_details['eta']; ?>" id="date"  />
                                  </div>
                              </div> 
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-sm-12">
                              <div class="form-group row">
                                  <label for="particulars" class="col-sm-2 col-form-label"><?php echo display('Remarks / Particulars') ?>
                                      <i class="text-danger"></i>
                                  </label>
                                  <div class="col-sm-4">
                                     <textarea class="form-control" tabindex="4" id="particular" name="particulars"  style="border:2px solid #d7d4d6;"   rows="2">{particular}</textarea>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="form-group row">
                        <input type="hidden" name="admin_company_id" id="admin_company_id" value="<?php echo $_GET['id']; ?>">
                        <label for="example-text-input" class="col-sm-0 col-form-label"></label>
                        <div class="col-sm-12 text-center">
                            <input type="submit" id="update_oceantrack" class="btnclr btn btn-large" name="update_oceantrack" value="Update" tabindex="7" />
                            <a href="<?php echo base_url('sales/oceanExportTracking?id='.$_GET['id']); ?>" class="btn btn-info">Cancel</a>
                        </div>
                    </div>
                    <?php /*
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <input type="submit" id="add_purchase" class="btnclr btn btn-large"   name="add-ocean-Export" value="<?php echo display('Save') ?>" >
                                                       
                               <a id="final_submit" class='btnclr final_submit btn  '><?php echo display('Submit') ?></a>

<a id="download"   class='btnclr btn  '><?php echo display('Download') ?></a>  
<a id="print"   class='btnclr btn  '><?php echo display('Print') ?></a>  


                            </div>
                        </div>

                        <?php */ ?>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
<!-- Purchase Report End -->


    <div class="modal fade" id="myModal1" role="dialog" >
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content" style="margin-top: 190px;text-align:center;">
       <div class="modal-header btnclr"  >
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo display('Sales - Ocean') ?></h4>
        </div>
        <div class="modal-body" id="bodyModal1" style="font-weight:bold;text-align:center;">
          
      
     
        </div>
        <div class="modal-footer">
          
        </div>
      </div>
      
    </div>
  </div>
  <?php /*
           <div id="myModal3" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content" style="text-align:center;" >
			 <div class="modal-header btnclr"  >
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?php echo display('Confirmation') ?></h4>
			</div>
			<div class="modal-body">
				<p><?php echo display('Your Invoice is not submitted. Would you like to submit or discard') ?>
				</p>
				<p class="text-warning">
					<small><?php echo display('If you dont submit your changes will not be saved') ?>.</small>
				</p>
			</div>
			<div class="modal-footer">
				<input type="submit" id="ok" class="btn btnclr"   onclick="submit_redirect()"  value="<?php echo display('Submit') ?>"/>
                <button id="btdelete" type="button" class="btn btnclr"  onclick="discard()"><?php echo display('Discard') ?></button>
			
			</div>
		</div>
	</div>
</div> 
*/ ?>
<script type="text/javascript">
var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
        $(document).ready(function(){

            $('#final_submit').hide();
$('#download').hide();
$('#print').hide(); 
        });

var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';



$(document).ready(function(){

    var succalert = '<div class="alert alert-success alert-dismissible" role="alert">';
    var failalert = '<div class="alert alert-danger alert-dismissible" role="alert">';
    $('#supplier_id').select2();

    $('#supplier_id').select2();
     // Custom method to trim input fields
     $.validator.addMethod("trimRequired", function(value, element) {
        return $.trim(value) !== "";
    }, "This field is required.");
    $("#update_ocean_track").validate({
        rules: {
            supplier_id: "required",
            invoice_date: "trimRequired",
            notify_party: "trimRequired",
           
            port_of_discharge:  {
                trimRequired: true,
            },
            container_no:{
                trimRequired: true,
            },
            freight_forwarder: "trimRequired",
            esti_depart: "trimRequired",
            booking_no: "trimRequired",
            ven_terms: "trimRequired",
            consignee : "required",
            vessel : "required",
            port_of_loading : "required",
            place_of_delivery :"required",
            seal_no : "required",
            est_time_arrival : "required"
        },
        messages: {
            supplier_id: "Shipper is required",
            invoice_date: "Invoice Date is required",
            notify_party: "Notify Party is required",
           
            port_of_discharge: "Port Of Discharge is required",
            container_no: 'Container No is required',
            freight_forwarder:'Freight forwarder is required',
            esti_depart:'Estimated Time of Departure is required',
            booking_no:'Booking No is required',
            consignee: "Customer / Consignee is required",
            vessel: "Vessel is required",
            port_of_loading : 'Port of loading is required',
            place_of_delivery : 'Place of Delivery is required',
            seal_no : 'Seal No is required',
            est_time_arrival : 'Estimated Time of Arrival'
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
                dataString : $("#update_ocean_track").serialize()
            };

            var formData = new FormData(form);

            formData.append(csrfName, csrfHash);
          
                $.ajax({
                    type:"POST",
                    dataType:"json",
                    url:"<?php echo base_url(); ?>sales/insert_ocean_export",

                    data:formData,
                    contentType: false, 
                    processData: false, 
                    success:function (response) {
                        console.log(response);
                        if(response.status =='success'){
                            $('.error_display').html(succalert+response.msg+'</div>');
                        
                            window.setTimeout(function(){
                            
                                window.location = "<?php echo base_url(); ?>sales/oceanExportTracking?id=<?php echo $_GET['id']; ?>"
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
$('#download').on('click', function (e) {
var link= $('#invoice_hdn').val();
console.log(link);
 var popout = window.open("<?php  echo base_url(); ?>Cinvoice/ocean_export_tracking_details_data/"+link);
 
   

});  
$('#print').on('click', function (e) {
var link= $('#invoice_hdn').val();
console.log(link);
 var popout = window.open("<?php  echo base_url(); ?>Cinvoice/ocean_export_tracking_details_data_print/"+link);
 
  

});
$('#add_purchase').on('click', function (e) {
    

});
function discard(){
   $.get(
    "<?php echo base_url(); ?>Cinvoice/delete_ocean_export/", 
   { val: $("#invoice_hdn1").val(), csrfName:csrfHash }, // put your parameters here
   function(responseText){
    console.log(responseText);
    window.btn_clicked = true;      //set btn_clicked to true
    var input_hdn="Your Booking No :"+$('#invoice_hdn1').val()+" has been Discarded";
  
    console.log(input_hdn);
    //$('#myModal3').modal('hide');
    $("#bodyModal1").html(input_hdn);
        $('#myModal1').modal('show');
    window.setTimeout(function(){
       

        window.location = "<?php echo base_url('sales/oceanExportTracking?id='.$_GET['id']); ?>";
      }, 2000);
   }
); 
}
     function submit_redirect(){
        window.btn_clicked = true;      //set btn_clicked to true
        var input_hdn="Your Booking List No :"+$('#invoice_hdn1').val()+" has been Updated Successfully";
  
    console.log(input_hdn);
    //$('#myModal3').modal('hide');
    $("#bodyModal1").html(input_hdn);
        $('#myModal1').modal('show');
    window.setTimeout(function(){
       

        window.location = "<?php echo base_url('sales/oceanExportTracking?id='.$_GET['id']); ?>";
      }, 2000);
     }

$('#final_submit').on('click', function (e) {

    window.btn_clicked = true;      //set btn_clicked to true
    var input_hdn="Your Booking  No :"+$('#invoice_hdn1').val()+" has been Updated Successfully";
  
    console.log(input_hdn);
    $("#bodyModal1").html(input_hdn);
        $('#myModal1').modal('show');
    window.setTimeout(function(){
       

        window.location = "<?php echo base_url('sales/oceanExportTracking?id='.$_GET['id']); ?>";
      }, 2000);
       
});

/*window.onbeforeunload = function(){
    if(!window.btn_clicked){
       // window.btn_clicked = true; 
        $('#myModal3').modal('show');
       return false;
    }
} */
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
</script>    
    
 






