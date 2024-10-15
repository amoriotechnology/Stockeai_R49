<?php  error_reporting(1); ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>my-assets/css/css.css" />
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>"
    value="<?php echo $this->security->get_csrf_hash();?>">
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />

<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>my-assets/css/css.css" />

<style>
#select2-selection__placeholder {
    display: none;
}

#select2-search__field {
    display: none;
}

.select2-selection__placeholder {
    display: none;

}

.select2-user_type-container {
    display: none;

}

.select2-selection {
    display: none;
}
</style>
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo ('Add Admin Assign Role') ?></h1>
            <small></small>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a>
                </li>
                <li><a href="<?php echo base_url('permission/company_role_index'); ?>">Admin Assign Role</a></li>
                <li class="active" style="color:orange">Add Admin Assign Role</li>
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
                        <div class="errormessage"></div>
                        <?php echo form_open("Permission/companycreate", array('name' =>'companyrole', 'id'=>'companyrole')) ?>

                        <div class="form-group row">
                            <label for="blood" class="col-sm-3 col-form-label">
                                <?php echo ('Company Name') ?> <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control" name="user_id" id="user_type" style="width:30%;"
                                    onchange="userRole(this.value)">
                                    <option value=""><?php echo display('select_one') ?></option>
                                    <?php
                                        for ($i=0;$i<count($company_info); $i++) { 
                                        ?>
                                    <option value="<?php echo $company_info[$i]['company_id']; ?>">
                                        <?php echo $company_info[$i]['company_name']; ?></option>
                                    <?php  } ?>

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="company_admin" id="label" class="col-sm-3 col-form-label">
                                <?php echo ('Company Admin') ?> <span class="text-danger">*</span>
                            </label>
                            <div id="get_state" name="admin_comp">

                            </div>
                            <div class="col-sm-9">



                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="blood" class="col-sm-3 col-form-label">
                                <?php echo display('role_name') ?> <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control" name="user_type" style="width:30%;" id="user_type">
                                    <option value=""><?php echo display('select_one') ?></option>
                                    <?php
                                foreach($super_role_list as $data){
                                    ?>
                                    <option value="<?php echo $data['id'] ?>"><?php echo $data['type'] ?></option>
                                    <?php
                                }
                                ?>
                                </select>
                            </div>
                        </div>




                        <input type="hidden" name="csrf_test_name" id=""
                            value="<?php echo $this->security->get_csrf_hash();?>">



                        <div class="form-group row text-center">
                            <div class="col-md-12">
                                <button type="reset" class="btnclr btn m-b-5 m-r-2"
                                    style="color:white;background-color: #424f5c;"><?php echo display('reset') ?></button>
                                <button type="submit" class="btnclr btn m-b-5 m-r-2"
                                    style="color:white;background-color: #424f5c;"><?php echo display('save') ?></button>
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

$(document).ready(function() {
    $('#label').hide();
    $("#user_type").on('change', function() {

        var selectedItem = $(this).val();


        var data1 = {

            countryId: selectedItem,
        };

        data1[csrfName] = csrfHash;


        $.ajax({ // get states/towns from db from controller
            cache: false,
            type: "POST",
            url: '<?php echo base_url();?>Permission/fill_dropdown_Admin',



            data: data1,
            success: function(states) {
                // debugger;
                $("#get_state").html(states);
                //             var $select = $('select#company_admin');
                $('#label').show();

            },



            error: function(xhr, ajaxOptions, thrownError) {
                alert('Failed to retrieve states.');

            }
        });
    });
});
</script>
<script type="text/javascript">
$(document).ready(function() {
    $("#companyrole").submit(function(event) {
        event.preventDefault();

        var formData = new FormData(this);
        var succalert = '<div class="alert alert-success alert-dismissible" role="alert">';

        var failalert = '<div class="alert alert-danger alert-dismissible" role="alert">';

        var alert2 =
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $.ajax({
            url: '<?php echo base_url('permission/companycreate'); ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status == 'success') {
                    $('.errormessage').html(succalert + response.msg + alert2);
                    setTimeout(function() {
                        window.location.href =
                            "<?php echo base_url(); ?>Permission/company_role_index";
                    }, 3000);
                } else if (response.status == 'failure') {
                    $('.errormessage').html(failalert + response.msg + alert2);
                }

            }
        });
    });
});
</script>