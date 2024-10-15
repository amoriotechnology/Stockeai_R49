<div class="content-wrapper">
<section class="content-header">
   <div class="header-icon">
      <figure class="one">
         <img src="<?php echo base_url()?>asset/images/tax.png" class="headshotphoto" style="height:50px;" />
      </figure>
   </div>
   <div class="header-title">
      <div class="logo-holder logo-9">
         <h1><?php echo display('tax_edit') ?></h1>
      </div>
      <small></small>
      <ol class="breadcrumb" style="border: 3px solid #d7d4d6;">
         <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
         <li><a href="#"><?php echo "Taxes" ?></a></li>
         <li class="active" style="color:orange;"><?php echo display('tax_edit') ?></li>
         <div class="load-wrapp">
            <div class="load-10">
               <div class="bar"></div>
            </div>
         </div>
      </ol>
   </div>
</section>
<section class="content">
   <div class="row">
     <div class="col-sm-12">
      <div class="panel panel-bd lobidrag" style="border: 3px solid #d7d4d6;">
         <div class="panel-heading">
            <div class="panel-title">
               <div id="block_container">
                  <div id="bloc2" style="float:right; position: relative;bottom: 18px;">
                     <a href="<?php echo base_url('Caccounts/manage_tax?id=' . $_GET['id']); ?>" class="btnclr btn m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo 'Manage Tax'; ?> </a>
                  </div>
               </div>
            </div>
         </div>
         <div class="panel-body">
      <form id="edittax_entry" class="edittax_entry" method="post">
         <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
      <div class="displaymessage"></div>
      <br>
      <div class="row">
         <div class="col-sm-6">
            <div class="form-group row">
               <label for="enter_tax" class="col-sm-3 col-form-label">Enter Tax percent<i class="text-danger">*</i></label>
               <div class="col-sm-6">
                 <input type="text" class="form-control" name="enter_tax" id="enter_tax" step="0.01" style="border: 2px solid #d7d4d6;width:100%" value="<?php echo $getTaxdata[0]['tax']; ?>">
                  <input type="hidden" name="admin_company_id" id="admin_company_id" value="<?php echo $_GET['id']; ?>">
                  <input type="hidden" name="taxId" value="<?php echo $getTaxdata[0]['id']; ?>">
               </div>
               <div class="col-sm-2"><i class="text" style="position: relative; left: 0px; top: 4px; font-size: 14px;">%</i></div>
            </div>
         </div>
          <div class="col-sm-6">
            <div class="form-group row">
               <label for="description" class="col-sm-3 col-form-label"><?php echo display('Description') ?></label>
               <div class="col-sm-8">
                 <textarea class="form-control" name="description"  style="border:2px solid #d7d4d6;width:100%" id="description"><?php echo $getTaxdata[0]['description']; ?></textarea>
               </div>
            </div>
          </div>
      </div>
      <div class="row">
         <div class="col-sm-6">
            <div class="form-group row">
               <label for="tax_agency" id="tax_agency" class="col-sm-3 col-form-label">State <i class="text-danger">*</i></label>
               <div class="col-sm-8">
                  <select name="state" id="state" class="form-control" style="width:100%;border:2px solid #d7d4d6;">
                     <option selected="true" disabled="disabled" value="">Please Select State</option>
                     <?php 
                        foreach (getAllStates() as $state) {
                           $selected = '';
                           if (isset($getTaxdata[0]['state']) && $getTaxdata[0]['state'] == $state['id']) {
                               $selected = 'selected';
                           }
                           ?>
                          <option value="<?php echo htmlspecialchars($state['id']); ?>" <?php echo $selected; ?>>
                       <?php echo htmlspecialchars($state['state_name']); ?>
                    </option>
                    <?php } ?>
                  </select>
               </div>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="form-group row">
               <label for="tax_agency" class="col-sm-3 col-form-label"><?php echo display('Tax Agency') ?> <i class="text-danger">*</i></label>
               <div class="col-sm-8">
                  <select name="tax_agency"   style="width:100%;border:2px solid #d7d4d6;"class="form-control">
                     <option selected disabled value="">Please Select Taxes</option>
                     <option value="Federal Taxes" <?= isset($getTaxdata[0]['tax_agency']) && $getTaxdata[0]['tax_agency'] == 'Federal Taxes' ? 'selected' : '' ?>>
                          Federal Taxes
                     </option>
                     <option value="State Taxes" <?= isset($getTaxdata[0]['tax_agency']) && $getTaxdata[0]['tax_agency'] == 'State Taxes' ? 'selected' : '' ?>>
                          State Taxes
                     </option>
                     <option value="Municipal Taxes" <?= isset($getTaxdata[0]['tax_agency']) && $getTaxdata[0]['tax_agency'] == 'Municipal Taxes' ? 'selected' : '' ?>>
                          Municipal Taxes
                     </option>
                  </select>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-sm-6">
            <div class="form-group row">
               <label for="account" class="col-sm-3 col-form-label"><?php echo display('Account') ?><i class="text-danger">*</i></label>
               <div class="col-sm-8">
                  <select name="account" style="width:100%;border:2px solid #d7d4d6;" class="form-control">
                     <option selected="true" disabled="disabled" value="">Please Select Accounts</option>
                     <option value="Accounts receivable" <?= isset($getTaxdata[0]['account']) && $getTaxdata[0]['account'] == 'Accounts receivable' ? 'selected' : '' ?>>
                          Accounts receivable
                      </option>
                      <option value="Sales tax payable" <?= isset($getTaxdata[0]['account']) && $getTaxdata[0]['account'] == 'Sales tax payable' ? 'selected' : '' ?>>
                          Sales tax payable
                      </option>
                      <option value="Tax Account Payable" <?= isset($getTaxdata[0]['account']) && $getTaxdata[0]['account'] == 'Tax Account Payable' ? 'selected' : '' ?>>
                          Tax Account Payable
                      </option>
                  </select>
               </div>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="form-group row">
               <label for="show_taxonreturn" class="col-sm-3 col-form-label"><?php echo display('Show Tax On Return Line') ?> <i class="text-danger">*</i></label>
               <div class="col-sm-8">
                  <select name="show_taxonreturn" style="width:100%;border:2px solid #d7d4d6;" class="form-control">
                     <option selected="true" disabled="disabled" value="">Please Select tax on return line</option>
                     <option value="Tax collected on sales" <?= isset($getTaxdata[0]['show_taxonreturn']) && $getTaxdata[0]['show_taxonreturn'] == 'Tax collected on sales' ? 'selected' : '' ?>>
                          Tax collected on sales
                     </option>
                     <option value="Adjustments to tax on sales" <?= isset($getTaxdata[0]['show_taxonreturn']) && $getTaxdata[0]['show_taxonreturn'] == 'Adjustments to tax on sales' ? 'selected' : '' ?>>
                          Adjustments to tax on sales
                     </option>
                     <option value="Other adjustments" <?= isset($getTaxdata[0]['show_taxonreturn']) && $getTaxdata[0]['show_taxonreturn'] == 'Other adjustments' ? 'selected' : '' ?>>
                          Other adjustments
                     </option>
                  </select>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-sm-6">
            <div class="form-group row">
               <label for="status_type" class="col-sm-3 col-form-label">Status Type <i class="text-danger">*</i></label>
               <div class="col-sm-8">
                  <select name="status_type" style="width:100%;border:2px solid #d7d4d6;" class="form-control">
                  <option selected="true" disabled="disabled" value="">Please Select</option>
                  <option value="sales" <?= isset($getTaxdata[0]['status_type']) && $getTaxdata[0]['status_type'] == 'sales' ? 'selected' : '' ?>>
                       Sales
                   </option>
                   <option value="expenses" <?= isset($getTaxdata[0]['status_type']) && $getTaxdata[0]['status_type'] == 'expenses' ? 'selected' : '' ?>>
                       Expenses
                   </option>
                   <option value="both" <?= isset($getTaxdata[0]['status_type']) && $getTaxdata[0]['status_type'] == 'both' ? 'selected' : '' ?>>
                       Both
                   </option>
                  </select>
               </div>
            </div>
         </div>
      </div>
      <div class="form-group row" style="margin-top: 70px;">
         <div class="col-sm-12" style="display: flex; justify-content: center;">
            <input type="submit" id="add-deposit" class="btnclr btn" name="add-deposit" value="<?php echo display('save') ?>" />
            &nbsp;&nbsp;
            <a href="<?php echo base_url('Caccounts/manage_tax?id=' . $_GET['id']); ?>" class="btn btn-info">Cancel</a>
         </div>
      </div>
      </form>
         </div>
      </div>
     </div>
   </div>
</section>
</div>


<script type="text/javascript">
   $(".edittax_entry").validate({
        rules: {
            enter_tax: {
               required: true,
               number: true
            },
            state: {
               required: true,
            },
            tax_agency: {
               required: true,
            },
            account: {
               required: true,
            },
            show_taxonreturn: {
               required: true,
            },
            status_type: {
               required: true,
            },
        },
        messages: {
            enter_tax: {
               required: 'Please enter your tax percent',
               number: 'Please enter a valid number'
            },
            state: "Please select your state",
            tax_agency: "Please select your tax agency",
            account: "Please select your account",
            show_taxonreturn: "Please select your tax on return line",
            status_type: "Please select your status type",
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
            var formData = new FormData($(".edittax_entry")[0]);
              $.ajax({
                 url: '<?php echo base_url('Caccounts/updatetaxentry'); ?>', 
                 type: 'POST',
                 data: formData,
                 dataType:'json',
                  processData: false,
                  contentType: false, 
                 success: function(response) {
                   if(response.status =='success'){
                     $('.displaymessage').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
                     setTimeout(function() {
                       $('.edittax_entry')[0].reset();
                       window.location.href = '<?php echo base_url(); ?>Caccounts/manage_tax?id=<?php echo $_GET['id']; ?>';
                     }, 3000); 
                   }else{
                      $('.displaymessage').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
                   }
                 },
                 error: function(xhr, status, error) {
                   alert('An error occurred: ' + error);
                 }
             });
         return false;
        }
    });
</script>

<style type="text/css">
   .panel-heading{
      padding: 25px 15px !important;
   }
</style>
