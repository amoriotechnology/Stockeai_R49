<?php error_reporting(1); ?>
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Add Admin User</h1>
            <small></small>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="<?php echo base_url('user/adadmin_index'); ?>">Manage Admin</a></li>
                <li class="active" style="color:orange">Add Admin User</li>
            </ol>
        </div>
    </section>
    <section class="content">
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
        <div class="alert alert-danger alert-dismissable" style="background-color:#38469f;color:white;font-weight:bold;">
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
                    <div class="panel-body">
                    <div class="errormessage"></div>
                    <?php echo form_open('User/insert_admin_user',array('name' => 'addAdmin', 'id' =>'addAdmin'));?>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Company Name<i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select name="companyid"  class="form-control" >
                                    <option value="">Select company name</option>
                                    <?php
                                    for ($i=0;$i<count($company_info); $i++) { 
                                                                        ?>
                                    <option value="<?php echo $company_info[$i]['company_id']; ?>"><?php echo $company_info[$i]['company_name']; ?></option>
                                <?php  } ?>
                                </select>  
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label">User name<i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" tabindex="4"  class="form-control" id="user_name"  name="user_name" placeholder="<?php echo display('username') ?>" autocomplete="off"/>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label"><?php echo display('password') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="password" tabindex="4"  class="form-control" id="admin_password" name="admin_password" placeholder="<?php echo display('password') ?>" autocomplete="off" />
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label"><?php echo display('email') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" tabindex="4"  class="form-control" id="email"  name="email"  placeholder="email"  autocomplete="off"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                    <input type="hidden" name="uid" value="<?php echo $_SESSION['user_id']; ?>">
                                <input type="submit" id="add-customer" class="btn btn-primary btn-large" style="background-color:#424f5c !important;" name="add-user" value="<?php echo display('save') ?>" tabindex="6"/>
                            </div>
                        </div>
                   <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $("#addAdmin").submit(function(event) {
        event.preventDefault();
        var formData = new FormData(this); 
        var succalert = '<div class="alert alert-success alert-dismissible" role="alert">';
        var failalert = '<div class="alert alert-danger alert-dismissible" role="alert">';
        var alert2 ='<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $.ajax({
            url: '<?php echo base_url('user/insert_admin_user'); ?>', 
            type: 'POST',
            data: formData,
            dataType : 'json',
            cache:false,
            contentType: false,
            processData: false,
            success: function(response){
                if(response.status =='success'){
                    $('.errormessage').html(succalert+response.msg +alert2);
                    setTimeout(function () {
                        window.location.href = "<?php echo base_url(); ?>user/managecompany"; 
                    }, 3000);
                }else if(response.status =='failure'){
                    $('.errormessage').html(failalert+response.msg+alert2);
                }
            }
        });
    });
});
</script>
