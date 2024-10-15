
<style>
  
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
   width: 200px;
   }
   }
</style>
<!-- Add New Purchase Start -->
<div class="content-wrapper">
   <section class="content-header">
      <div class="header-icon">
         <figure class="one">
         <img src="<?php echo base_url(); ?>asset/images/saleexport.png" class="headshotphoto" style="height:50px;" />
      </div>
      <div class="header-title">
         <div class="logo-holder logo-9">
            <h1 class="mobile_h1">Create Ocean Export Tracking</h1>
         </div>
         <small></small>
         <ol class="breadcrumb" style="border: 3px solid #d7d4d6;">
            <li><a href="<?php echo base_url(); ?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
            <li><a href="<?php echo base_url('sales/oceanExportTracking?id='.$_GET['id']); ?>"><?php echo display('Sale') ?></a></li>
            <li class="active" style="color:orange;"><?php echo display('Create Ocean Export Tracking') ?></li>
            <div class="load-wrapp">
               <div class="load-10">
                  <div class="bar"></div>
               </div>
            </div>
         </ol>
      </div>
   </section>
   <div class="modal fade" id="myModal1" role="dialog">
      <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content" style="margin-top: 190px;text-align:center;">
            <div class="modal-header btnclr" style="color:white;">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title"><?php echo display('Sales - Ocean Export') ?></h4>
            </div>
            <div class="modal-body" id="bodyModal1" style="font-weight:bold;text-align:center;">
            </div>
            <div class="modal-footer">
            </div>
         </div>
      </div>
   </div>
   <section class="content">
   <div class ="error_display"></div>
      <!-- Purchase report -->
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-bd lobidrag" style="border: 3px solid #d7d4d6;" >
				   <div class="panel-heading">
					  <div class="panel-title">
						 <div id="block_container">
							<div id="bloc1" style="float:left;">
							   <h4><?php //echo "Create Ocean Export Tracking" ?></h4>
							</div>
							<div id="bloc2" style="float:right;">
							   <a  href="<?php echo base_url('sales/oceanExportTracking?id='.$_GET['id']) ?>" class="btnclr btn  m-b-5 m-r-2" ><i class="ti-align-justify"> </i> <?php echo display('Manage Ocean Export Tracking')?> </a>
							</div>
						 </div>
					  </div>
				   </div>
					<div class="panel-body">
						<form id="insert_ocean_track" name="insert_ocean_track" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="col-sm-6">
								   <div class="form-group row">
									  <label for="supplier_sss" class="col-sm-4 col-form-label">Vendor
									  <i class="text-danger">*</i>
									  </label>
									  <div class="col-sm-7">
										 <select name="supplier_id" id="supplier_id" class="form-control " style="border:2px solid #d7d4d6;"   required="" tabindex="3" >
											<option value="" required=""><?php echo display('select_one') ?></option>
											<?php
											   foreach($all_supplier as $supplier)
											   {
											   ?>
											<option value="<?php echo $supplier['supplier_id']; ?>"><?php echo $supplier['supplier_name']; ?></option>
											<?php } ?>
										 </select>
									  </div>
 									  <div class="col-sm-1">
										 <a href="#" class="btnclr client-add-btn btn mobile_icon"   aria-hidden="true" data-toggle="modal" data-target="#add_vendor"><i class="fa fa-user"></i></a>
									  </div>
 								   </div>
								</div>
								<div class="col-sm-6">
								   <div class="form-group row">
									  <label for="booking_no" class="col-sm-4 col-form-label"><?php echo display('Booking No') ?>
									  <i class="text-danger">*</i>
									  </label>
									  <div class="col-sm-8">
										 <input type="text" tabindex="3" class="form-control" name="booking_no" placeholder="Booking or B/L number"  style="border:2px solid #d7d4d6;" id="booking_no" required />
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
										 <input type="date" required tabindex="2" class="form-control datepicker" name="invoice_date" value="<?php echo $date; ?>" id="date"  style="border:2px solid #d7d4d6;"   required/>
									  </div>
								   </div>
								</div>
								<div class="col-sm-6">
								   <div class="form-group row">
									  <label for="adress" class="col-sm-4 col-form-label"><?php echo display('Customer / Consignee')?> <i class="text-danger">*</i>
									  </label>
									  <div class="col-sm-7">
										 <select name="consignee" id="consignee" class="form-control " required="" tabindex="1" style="border:2px solid #d7d4d6;"   >
											<option value="" required=""><?php echo display('select_one') ?></option>
											<?php
											   foreach($customer_name as $cus_name)
											   {
											   ?>
											<option value="<?php echo $cus_name['customer_id']; ?>"><?php echo $cus_name['customer_name']; ?></option>
											<?php } ?>
										 </select>
									  </div>
									  <div class="col-sm-1">
 										 <a href="#" class="btnclr client-add-btn btn mobile_icon1" aria-hidden="true"    data-toggle="modal" data-target="#cust_info"><i class="fa fa-user-circle"></i></a>
 									  </div>
								   </div>
								</div>
							 </div>
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
							 <div class="row">
								<div class="col-sm-6">
								   <div class="form-group row">
									  <label for="etd" class="col-sm-4 col-form-label"><?php echo display('Notify Party')?>
									  <i class="text-danger">*</i>
									  </label>
									  <div class="col-sm-8">
										 <input type="text" tabindex="3" class="form-control" name="notify_party" placeholder="Notify Party" id="notify_party"  style="border:2px solid #d7d4d6;"  required=""/>
									  </div>
								   </div>
								</div>
								<div class="col-sm-6">
								   <div class="form-group row">
									  <label for="eta" class="col-sm-4 col-form-label"><?php echo display('Vessel ')?> <i class="text-danger">*</i>
									  </label>
									  <div class="col-sm-8">
										 <textarea class="form-control" tabindex="4" id="vessel" name="vessel" placeholder="Vessel"  rows="1" required=""></textarea>
									  </div>
								   </div>
								</div>
							 </div>
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
							 <div class="row">
								<div class="col-sm-6">
								   <div class="form-group row">
									  <label for="shipping_line" class="col-sm-4 col-form-label"><?php echo display('Voyage No')?>
									  </label>
									  <div class="col-sm-8">
										 <input type="text" tabindex="3" class="form-control" name="voyage_no" placeholder="Voyage No." style="border:2px solid #d7d4d6;"   id="voyage_no"  />
									  </div>
								   </div>
								</div>
								<div class="col-sm-6">
								   <div class="form-group row">
									  <label for="bl_number" class="col-sm-4 col-form-label"><?php echo display('Port of loading')?>
									  <i class="text-danger">*</i>
									  </label>
									  <div class="col-sm-8">
										 <input type="text" tabindex="3" class="form-control" name="port_of_loading" placeholder="Port of loading"  style="border:2px solid #d7d4d6;"  id="port_of_loading" required/>
									  </div>
								   </div>
								</div>
							 </div>
							 <div class="row">
								<div class="col-sm-6">
								   <div class="form-group row">
									  <label for="bl_number" class="col-sm-4 col-form-label"><?php echo display('Port of discharge')?>
									  <i class="text-danger">*</i>
									  </label>
									  <div class="col-sm-8">
										 <input type="text" tabindex="3" class="form-control" name="port_of_discharge" placeholder="Port of discharge" style="border:2px solid #d7d4d6;"  id="port_of_discharge" required/>
									  </div>
								   </div>
								</div>
								<div class="col-sm-6">
								   <div class="form-group row">
									  <label for="container_no" class="col-sm-4 col-form-label"><?php echo display('Place of Delivery')?> <i class="text-danger">*</i>
									  </label>
									  <div class="col-sm-8">
										 <textarea class="form-control" tabindex="4" id="place_of_delivery" name="place_of_delivery" placeholder="Place of Delivery" style="border:2px solid #d7d4d6;"   rows="1" required></textarea>
									  </div>
								   </div>
								</div>
							 </div>
							 <div class="row">
								<div class="col-sm-6">
								   <div class="form-group row">
									  <label for="customs_broker_name" class="col-sm-4 col-form-label"><?php echo display('Customs Broker Name')?></label>
									  <div class="col-sm-8">
										 <input class="form-control" tabindex="4" id="customs_broker_name" name="customs_broker_name" placeholder=" Customs Broker Name" style="border:2px solid #d7d4d6;"   rows="1">
									  </div>
								   </div>
								</div>
								<div class="col-sm-6">
								   <div class="form-group row">
									  <label for="mbl_no" class="col-sm-4 col-form-label"><?php echo display('MBL NO')?></label>
									  <div class="col-sm-8">
										 <input class="form-control" tabindex="4" id=" mbl_no" name="mbl_no" placeholder=" MBL NO"  style="border:2px solid #d7d4d6;"  rows="1">
									  </div>
								   </div>
								</div>
							 </div>
							 <div class="row">
								<div class="col-sm-6">
								   <div class="form-group row">
									  <label for="hbl_no" class="col-sm-4 col-form-label"><?php echo display('HBL NO')?></label>
									  <div class="col-sm-8">
										 <input class="form-control" tabindex="4" id=" hbl_no" name="hbl_no" placeholder=" HBL NO" style="border:2px solid #d7d4d6;"   rows="1">
									  </div>
								   </div>
								</div>
								<div class="col-sm-6">
								   <div class="form-group row">
									  <label for="obl_no" class="col-sm-4 col-form-label"><?php echo display('OBL NO')?> </label>
									  <div class="col-sm-8">
										 <input class="form-control" tabindex="4" id=" obl_no" name="obl_no" placeholder=" OBL NO" style="border:2px solid #d7d4d6;"   rows="1">
									  </div>
								   </div>
								</div>
							 </div>
							 <div class="row">
								<div class="col-sm-6">
								   <div class="form-group row">
									  <label for="ams_no" class="col-sm-4 col-form-label"><?php echo display('AMS NO')?></label>
									  <div class="col-sm-8"> 
										 <input class="form-control" tabindex="4" id=" ams_no" name="ams_no" placeholder=" AMS NO"  style="border:2px solid #d7d4d6;"  rows="1">
									  </div>
								   </div>
								</div>
								<div class="col-sm-6">
								   <div class="form-group row">
									  <label for="isf_no" class="col-sm-4 col-form-label"><?php echo display('ISF NO') ?></label>
									  <div class="col-sm-8">
										 <input class="form-control" tabindex="4" id=" isf_no" name="isf_no" placeholder=" ISF NO" style="border:2px solid #d7d4d6;"   rows="1">
									  </div>
								   </div>
								</div>
							 </div>
							 <div class="row">
								<div class="col-sm-6">
								   <div class="form-group row">
									  <label for="container_no" class="col-sm-4 col-form-label"><?php echo display('Container No')?>
									  <i class="text-danger">*</i>
									  </label>
									  <div class="col-sm-8">
										 <textarea class="form-control" tabindex="4" id="container_no" name="container_no" placeholder="Container No" rows="1" required></textarea>
									  </div>
								   </div>
								</div>
								<div class="col-sm-6">
								   <div class="form-group row">
									  <label for="seal_no" class="col-sm-4 col-form-label"><?php echo display('Seal No') ?> <i class="text-danger">*</i>
									  </label>
									  <div class="col-sm-8">
										 <textarea class="form-control" tabindex="4" id="seal_no" name="seal_no" placeholder="Seal No" rows="1" style="border:2px solid #d7d4d6;"  required></textarea>
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
										 <input class="form-control" tabindex="4" id="freight_forwarder" name="freight_forwarder" placeholder="Freight forwarder" rows="1" required>
									  </div>
								   </div>
								</div>
								<div class="col-sm-6">
								   <div class="form-group row">
									  <label for="adress" class="col-sm-4 col-form-label"><?php echo display('Attachments')?>
									  </label>
									  <div class="col-sm-6">
                              
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
										 <input type="date" required tabindex="2" class="form-control " name="esti_depart" id="esti_depart" value="<?php echo $date; ?>" style="border:2px solid #d7d4d6;"   id="date"  />
									  </div>
								   </div>
								</div>
								<div class="col-sm-6">
								   <div class="form-group row">
									  <label for="container_no" class="col-sm-4 col-form-label"><?php echo display('Estimated Time of Arrival') ?> <i class="text-danger">*</i>
									  </label>
									  <div class="col-sm-8">
										 <?php $date = date('Y-m-d'); ?>
										 <input type="date" required tabindex="2" class="form-control " name="est_time_arrival" value="<?php echo $date; ?>"  style="border:2px solid #d7d4d6;"   id="est_time_arrival"  />
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
                             <textarea class="form-control" tabindex="4" id="particular" name="particulars" style="border:2px solid #d7d4d6; text-align:left;" rows="2">
                              <?php if (!empty($ocean_remarks[0]->remarks)) {
                                 echo $ocean_remarks[0]->remarks;
                              } ?>
                           </textarea>

									  </div>
								   </div>
								</div>
							 </div>
                     <div class="form-group row">
                        <input type="hidden" name="admin_company_id" id="admin_company_id" value="<?php echo $_GET['id']; ?>">
                        <label for="example-text-input" class="col-sm-0 col-form-label"></label>
                        <div class="col-sm-12 text-center">
                            <input type="submit" id="add_oceantrack" class="btnclr btn btn-large" name="add_oceantrack" value="Submit" tabindex="7" />
                            <a href="<?php echo base_url('sales/oceanExportTracking?id='.$_GET['id']); ?>" class="btn btn-info">Cancel</a>
                        </div>
                    </div>
                     
                  </form>
               </div>
            </div>
         </div>
      </div>
   </section>
</div>


<div class="modal fade" id="myModal1" role="dialog" >
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content" style="margin-top: 190px;">
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

<?php
$bootdata   = array('bootstrap_model'=>array('vendor','customer'));
$this->load->view('include/bootstrap_model',$bootdata);
?>
<script type="text/javascript">
  /*
   $('#instant_customer').submit(function (event) {
   
   var dataString = {
   dataString : $("#instant_customer").serialize()
   };
   dataString[csrfName] = csrfHash;
   $.ajax({
   type:"POST",
   dataType:"json",
   url:"<?php echo base_url(); ?>Cinvoice/instant_customer",
   data:$("#instant_customer").serialize(),
   success:function (data1) {
   var $select = $('select#consignee');
   $select.empty();
   
     for(var i = 0; i < data1.length; i++) {
   var option = $('<option/>').attr('value', data1[i].customer_id).text(data1[i].customer_name);
   $select.append(option); // append new options
   }
   $("#instant_customer").find('input:text').val('');
   $("#bodyModal1").html("New Customer Added Successfully");
   $('#consignee').show();
   $('#myModal1').modal('show');
   $('#cust_info').modal('hide');
   $('#instant_customer')[0].reset();
   
   window.setTimeout(function(){
   $('#myModal1').modal('hide');
   $('.modal-backdrop').remove();
   
   },2500);
   //  console.log(data);
   }
   });
   event.preventDefault();
   });
   
   */
   
   
   $('#customer_modal').on('click',function (e){
   $('#cust_info').modal('show');
   e.preventDefault();
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
   
   
   
   $('#tax_dropdown').on('change', function() {
   if ( this.value == '2')
   $("#tax").show();     
   else
   $("#tax").hide();
   }).trigger("change");
   
  
   
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
   
   @media (min-width: 768px) {
    .mobile_icon {
        position: relative;
        right: 24px;
    }
    
    .mobile_icon1{
        position: relative;
        right: 26px;
    }
    .mobile_widthview{
        font-size: 11px;
    }
    
    .mobile_alignview{
        position: relative;
        right: 52px;
    }
    
    .mobile_h1{
        font-size: 20px !important;
    }

  }
</style>
<script type="text/javascript">
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
    $("#insert_ocean_track").validate({
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
            supplier_id: "Vendor is required",
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
                dataString : $("#insert_ocean_track").serialize()
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


</script>
<script>
   document.addEventListener('DOMContentLoaded', () => {
  const fileInput = document.getElementById('export_files');
  const fileList = document.getElementById('fileList');
  const fileCount = document.getElementById('fileCount');
  const uploadButton = document.getElementById('uploadButton');
  let files = [];

  // Handle file selection
  fileInput.addEventListener('change', (event) => {
    files = Array.from(event.target.files);
    renderFileList();
    updateFileCount();
  });

  // Render file list with delete option
  function renderFileList() {
    fileList.innerHTML = '';
    files.forEach((file, index) => {
      const li = document.createElement('li');
      li.className = 'file-item';
      li.textContent = `${file.name} (${file.size} bytes)`;

      const deleteButton = document.createElement('button');
      deleteButton.textContent = 'Delete';
      deleteButton.addEventListener('click', () => deleteFile(index));
      li.appendChild(deleteButton);

      fileList.appendChild(li);
    });
  }

  // Update file count
  function updateFileCount() {
    fileCount.textContent = `Selected files: ${files.length}`;
  }

  // Handle file deletion
  function deleteFile(index) {
    files.splice(index, 1);
    renderFileList();
    updateFileCount();
    resetFileInput();
  }

  // Reset file input to clear selected files
  function resetFileInput() {
    fileInput.value = ''; // Clear the input value to reset the selection
  }

  // Handle file upload
  uploadButton.addEventListener('click', () => {
    if (files.length === 0) {
      alert('No files selected.');
      return;
    }
    files.forEach(file => uploadFile(file));
  });


});
    $(function() {
         $('.datepicker').datepicker({
            { dateFormat: 'yyyy-mm-dd' }
         });
        
    });
</script>