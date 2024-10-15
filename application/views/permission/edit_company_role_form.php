<?php  error_reporting(1); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo "Edit  Role Permission" ?></h1>
            <small></small>
            <ol class="breadcrumb">
               <li><a href="<?php echo base_url(); ?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="<?php echo base_url('Permission/super_role_list'); ?>">Roles List</a></li>
                <li class="active"><?php  echo "Edit Role" ?></li>
 </ol>
        </div>
    </section>
 <section class="content">
      <?php
        $message = $this->session->userdata('message');
        if (isset($message)) {
            ?>
            <div class="alert alert-success alert-dismissable">
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
 <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                               <div class="alert alert-danger alert-dismissable" id="validationStatus"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div> 
                        </div>
                    </div>
                     <?php echo form_open("Permission/super_update_roles/",array('name' =>'adminRoles','id'=>'adminRoles')) ?>
                     <input type="hidden" name="id" value="<?php echo $details_list_info[0]['id']; ?>">
                     <div class="errormessage"></div>
                    <div class="panel-body">
                         <div class="form-group row">
                            <label for="type" class="col-sm-3 col-form-label"><?php echo display('role_name') ?> <i class="text-danger">*</i></label>
 <div class="col-sm-6">
                                <input type="text" tabindex="2" class="form-control" name="rolename" id="type"  value="<?php echo  $details_list_info[0]['type']; ?>" />
                            </div>
                        </div>
  <div class="panel-body">
                       <div class="table-responsive">
                        <table id="" class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr style="color:white;background-color: #424f5c;">
                            <th style="text-align: center;     width: 50%;"><?php echo ('Name') ?></th>
                            <th style="text-align: center;"><?php echo ('Access Permission') ?> </th>
                          </tr>
                        </thead>
                        <tbody>
 <table class="table table-striped">
             <?php
   $m=1;
  $split=array();
                  foreach($crt  as $test){
$split[] =$test['menu'];
}
$i=0;
            foreach($details_permission_list as $key=>$value) {   
                ?>  
                    <tr style="text-align: center;">   <td ><?php echo display($value['name']);?></td>
 <td><input type="checkbox" name="<?php echo $value['name'];?>_create"  <?php  for($i=0;$i<count($split);$i++){if(trim($split[$i])==trim($value['name'])){echo 'checked';}} ?> ></td> 
 </tr>
                <?php $m++; } ?>
  <?php $sl = 0; $i++; ?>
    </table>
 <div class="form-group text-center">
                <button type="reset" class="btnclr btn btn-success" style="color:white;background-color: #424f5c;"><?php echo display('reset') ?></button>
                <button type="submit"  class="btnclr btn btn-success" style="color:white;background-color: #424f5c;">Update</button>
 </div>
            <?php echo form_close() ?>
           </div>
             </div>
            </div>
        </div>
 </section>
</div>
<script type="text/javascript">
     function isAtleastCheckInputChecked(selector) {
    var inputGroup = document.querySelectorAll(selector);
  if (inputGroup === undefined) {
        return false;
    }
 var isChecked = false;
 inputGroup.forEach(function(currentValue) {
        if (currentValue.checked) {
            isChecked = true;
        }
    });
 return isChecked;
}
function validateForm(evt) {
    evt.preventDefault(); 
    var validationStatus = isAtleastCheckInputChecked("input[type='checkbox']");
    if (!validationStatus) {
      var validationStatusElement = document.querySelector("#validationStatus");
        validationStatusElement.innerText = "Please select at least one checkbox.";
        validationStatusElement.style.display = "block";
   } else {
       var formData = new FormData(document.getElementById("adminRoles")); 
  $.ajax({
            url: '<?php echo base_url('permission/super_update_roles'); ?>', 
            type: 'POST',
            data: formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status == 'success') {
                    $('.errormessage').html('<div class="alert alert-success alert-dismissible" role="alert">' + response.msg + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    setTimeout(function() {
                        window.location.href = "<?php echo base_url(); ?>permission/super_role_list";
                    }, 5000);
                } else if (response.status == 'failure') {
                    $('.errormessage').html('<div class="alert alert-danger alert-dismissible" role="alert">' + response.msg + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            }
        });
    }
}
$(document).ready(function() {
    document.querySelector("#validationStatus").style.display = "none";
  $("#adminRoles").submit(function(event) {
        validateForm(event);
    });
});
</script> 
