<?php  error_reporting(1); ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>my-assets/css/css.css" />
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>my-assets/css/css.css" />

<style>

#select2-selection__placeholder{
  display:none;
}
#select2-search__field{
 display:none;
}

.select2-selection__placeholder{
    display:none;

}
.select2-user_type-container{
    display:none;
   
}
.select2-selection{
    display:none;
}

.btnclr{
       background-color:<?php echo $setting_detail[0]['button_color']; ?>;
       color: white;

   }

</style>
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo ('Edit Admin Assign Role') ?></h1>
            <small></small>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="<?php echo base_url('permission/company_role_index'); ?>">Admin Assign Role</a></li>
                <li class="active" style="color:orange">Edit Admin Assign Role</li>
            </ol>
        </div>
    </section>

    <section class="content">
        <!-- Alert Message -->
        <?php
        $message = $this->session->userdata('message');
        if (isset($message)) {
            ?>
            <div class="alert alert-info alert-dismissable">
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

      
        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                        </div>
                    </div>
                   
                    <div class="panel-body">

                     <?php echo form_open("Permission/editadmin_role_user") ?>
                    
            <div class="form-group row">
                        <label for="blood" class="col-sm-3 col-form-label">
                            <?php echo ('Company Name') ?> <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                      


                            <input name="user_id" class="form-control"  readonly   style=" width: 360px; " type="text"   id="user_type" value="<?php echo $admin_roleedit[0]['company_name']; ?>"  >



                        </div>
                     </div> 

              
                     <div class="form-group row">
                        <label for="company_admin"  class="col-sm-3 col-form-label">
                            <?php echo ('Company Admin') ?>  <span class="text-danger">*</span>
                        </label>
                        <div name="admin_comp">
    
                         <input name="admin_comp" class="form-control"  readonly style="margin-left: 426px;width: 360px; " type="text"   id="admin_comp" value="<?php echo $admin_roleedit[0]['username']  ?>"  >
                        </div>
                        <div class="col-sm-9">
                        </div>
                    </div>

 
                    <input name="unique_id" class="form-control"  readonly   type="hidden"  id="unique_id" value="<?php echo $role_name[0]['admin_comp'] ?>"  >

                    



<div class="form-group row">
                        <label for="blood" class="col-sm-3 col-form-label">
                            <?php echo display('role_name') ?>  <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            
 


<select class="form-control" name="user_type" style="width:30%;" id="user_type">
        

<option value="<?php echo  ($role_name[0]['roleid']); ?>"><?php echo  ($role_name[0]['type']); ?></option>
     
    <?php if (!empty($super_role_list) && is_array($super_role_list)) : ?>
        <?php foreach ($super_role_list as $data) : ?>
            <option value="<?php echo htmlspecialchars($data['id']); ?>"><?php echo htmlspecialchars($data['type']); ?></option>
        <?php endforeach; ?>
    <?php endif; ?>
</select>
    </div>
 </div>




                    <input type ="hidden" name="csrf_test_name" id="" value="<?php echo $this->security->get_csrf_hash();?>">
                        <div class="form-group row text-center"  >
                              <div class="col-md-12">
                             <button type="submit" class="btnclr btn m-b-5 m-r-2"  style="background-color: #424f5c;color: #fff;"  ><?php echo display('save') ?></button>
                            </div>
                        </div>
                    <?php echo form_close() ?>
                    </div>
                   
                </div>
            </div>
        </div>

    </section>
</div>









<script>


var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';





        $(document).ready(function () {
            $('#label').hide();
           $("#user_type").on('change', function () {


                var selectedItem = $(this).val();
                
           
                var data1 = {
    
                    countryId:selectedItem, };

                    data1[csrfName] = csrfHash;

           
                $.ajax({     // get states/towns from db from controller
                    cache: false,
                    type: "POST",
                    url:'<?php echo base_url();?>Permission/fill_dropdown_Admin',



                        data: data1,
                        success: function (states) { 
                        // debugger;
                        $("#get_state").html(states);
            //             var $select = $('select#company_admin');
            $('#label').show();
 
                    },



                    error: function (xhr, ajaxOptions, thrownError) {
                        alert('Failed to retrieve states.');
                      
                    }
                });
            });
        });
    </script>






 






 