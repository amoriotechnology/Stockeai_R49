<script src="https://kit.fontawesome.com/38e0f06f81.js" crossorigin="anonymous"></script>
<?php
$CI = &get_instance();
$CI->load->model('Web_settings');
$CI->load->model('Reports');
$CI->load->model('Users');
$CI->load->model('Hrm_model');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
$retrieve_user_data = $CI->Web_settings->retrieve_user_data();
$retrieve_admin_data = $CI->Web_settings->retrieve_admin_data();
$state_tax_list = $CI->Hrm_model->state_tax_list();
$retrieve_company_data = $CI->Web_settings->retrieve_companyall_data();
$users = $CI->Users->profile_edit_data();
$setting_detail = $CI->Web_settings->retrieve_setting_editdata();
$superadmin_logo = $CI->Users->superadmin_logo();
?>
<style>
.alert {
    font-weight: bold;
}

.navbar-custom-menu>.navbar-nav>li>.dropdown-menu {
    position: absolute;
    right: 0;
    left: auto;
    width: 850px;
    top: 111%;
    padding: 20px;
    border-radius: 10px;
}

ul.dropdown-submenu {
    padding: 0;
}

ul.dropdown-submenu>li {
    list-style: none;
}

ul.dropdown-submenu>li>a {
    padding: 5px 10px;
    color: #777;
    display: block;
    clear: both;
    font-weight: 400;
    line-height: 1.42857143;
    white-space: nowrap;
}

ul.dropdown-submenu>li>.menu-title a {
    color: #777;
    font-size: 16px;
    font-weight: 500;
}

ul.dropdown-submenu>li>a:hover {
    color: #333;
}

ul.dropdown-submenu>li>a>i {
    font-size: 16px;
    margin-right: 10px;
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
.img-flag{
  max-height: 11px;
  display: none;
}
.ui-selectmenu-text, .ui-front{
        display:none;
    }

.load-10 .bar {
  animation: loadingJ 2s cubic-bezier(0.17, 0.37, 0.43, 0.67) infinite;
}

 .btnclr{
    text-align:center;
       background-color:<?php echo $setting_detail[0]['button_color']; ?>;
       color: white;

   }
     td{
         text-align:center;
    }
@keyframes loadingJ {
  0%,
  100% {
    transform: translate(0, 0);
  }

  50% {
    transform: translate(80px, 0);
    background-color: #f5634a;
    width: 140px;
  }
}
</style>
<script>
$(document).ready(function() {
    function load_unseen_notification() {
        var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
        var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
        var data = {};
        data[csrfName] = csrfHash;
        $.ajax({
            url: '<?php echo base_url(); ?>Cweb_setting/show_all_bell_notification',
            method: "POST",
            data: data,
            dataType: "json",
            success: function(response) {
                $('.notify').empty();
                if (response) {
                    $.each(response, function(index, item) {
                        var id = item.id;
                        var invoice_id = item.invoice_id;
                        var invoice_no = item.invoice_no;
                        var description = item.description;
                        var bell_notification = item.bell_notification;
                        var listItem = '<li data-invoice-id="' + invoice_id +
                            '" data-id="' + id + '">';
                        listItem +=
                            '<a href="<?php echo base_url(); ?>Cinvoice/invoice_update_form/' +
                            invoice_id + '">' + description + '</a>';
                        listItem += '</li>';
                        $('.notify').append(listItem);
                    });
                    var bellNotificationCount = response.length;
                    if (bellNotificationCount > 0) {
                        $('.count').html(bellNotificationCount);
                    } else {
                        $('.count').html('');
                    }
                } else {
                    $('.notify').html("No Notifications to Show");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", error);
            }
        });
    }

    $(document).on('click', '.notify li', function() {
        var invoice_id = $(this).data('invoice-id');
        var notificationId = $(this).data('id');
        var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
        var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
        var data = {
            id: notificationId,
            [csrfName]: csrfHash
        };
        $.ajax({
            url: '<?php echo base_url(); ?>Cweb_setting/update_bell_notification',
            method: "POST",
            data: data,
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    load_unseen_notification();
                } else {
                    console.error("Failed to update notification status");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", error);
            }
        });
    });
});
</script>
<header class="main-header" style="background-color:#424f5c">
    <a href="<?php echo base_url() ?>" class="logo">
        <span class="logo-mini">
            <img src="<?php
                if (isset($Web_settings[0]['favicon'])) {
                        echo html_escape($Web_settings[0]['favicon']);
                }  ?>" alt="" style="float: left;">
        </span>
        <span class="logo-lg">
            <img src="<?php echo base_url() . $retrieve_company_data[0]['logo']; ?>" alt=""
                style="float:left;margin-top:10px;"><?php echo $this->session->userdata('company_name'); ?>
        </span>
    </a>
    <nav class="navbar navbar-static-top text-center" style="background-color:#424f5c">
        <nav class="navbar navbar-static-top text-center" style="background-color:#424f5c">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="pe-7s-keypad"></span>
            </a>
            <?php 
           
            $user_comp_id = $this->session->userdata('user_id');
            $encode_com_id   = encodeBase64UrlParameter($user_comp_id);
           
            $urcolp = '0';
            if($this->uri->segment(2) =="gui_pos" ){
                $urcolp = "gui_pos";
            }
            if($this->uri->segment(2) =="pos_invoice" ){
                $urcolp = "pos_invoice";
            }?> 
			 <div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
						 <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count" style="border-radius:10px;"></span> <span class="glyphicon glyphicon-bell" style="font-size:18px;"></span></a>
						 <ul class="notify dropdown-menu"></ul>
					</li>
			   
					<li class="dropdown notifications-menu">
						<a href="<?php echo base_url('Cinvoice/addCart') ?>">
							<i class="pe-7s-cart" title="View Cart"></i>
							<span class="label total-count"></span>
						</a>
					</li>
					<li class="dropdown notifications-menu">
						<a href="<?php echo base_url('Cservice/help_desk_show') ?>">
							<i class="pe-7s-help1" title="Help"></i>
							<span class="label" style="background-color: #e53952;">?</span>
						</a>
					</li>
					<li class="dropdown dropdown-user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="pe-7s-settings"></i></a>
						<div class="dropdown-menu">
							<?php
							if ($_SESSION['u_type'] == 2) { ?>
							<div class="row">
								<div class="menuCol col-xl-3 col-lg-3 col-md-12">
									<ul class="dropdown-submenu">
										<?php
							  foreach ($this->session->userdata('admin_data') as $admtest) {
								 $split = explode('-', $admtest);
								 if (trim($split[0]) == 'setting') {
							  ?>
										<li class="menu-title" style="color:#17202a">
											<b><?php echo display('role_permission');  ?></b>
										</li>
										<li><a href=" <?php echo base_url('Permission/add_role') ?>"><i
													class="pe-7s-users"></i><?php echo display('add_role'); ?></a>
										</li>
										<li><a href="<?php echo base_url('Permission/role_list') ?>"><i
													class="ti-dashboard"></i><?php echo display('role_list'); ?></a>
										</li>
										<li><a href=" <?php echo base_url('Permission/user_assign') ?>"><i
													class="pe-7s-settings"></i><?php echo display('user_assign_role'); ?></a>
										</li>
										<?php
									break;
								 }
							  } ?>
									</ul>
								</div>
								<div class="menuCol col-xl-3 col-lg-3 col-md-12">
									<ul class="dropdown-submenu">
										<?php
										foreach ($this->session->userdata('admin_data') as $admtest) {
											$split = explode('-', $admtest);
											if (trim($split[0]) == 'setting') {
												?>
												<li class="menu-title" style="color:#17202a"><b>SMS</b></li>
												<li><a href=" <?php echo base_url('Csms/configure') ?>"><i class="pe-7s-users"></i><?php echo display('sms_configure'); ?></a>
												</li>
												<li><a href="<?php echo base_url('') ?>"><i
															class="pe-7s-users"></i>&nbsp;&nbsp;Email Template </a></li>
												<li><a href="<?php echo base_url('') ?>"><i
															class="pe-7s-users"></i>&nbsp;&nbsp;Alerts Template </a></li>
												<li class="menu-title" style="color:#17202a">
													<b><?php echo display('Help');  ?></b>
												</li>
												<li><a href="<?php echo base_url('Cservice/help_desk') ?>"><i
															class="fa fa-comments"></i>&nbsp;&nbsp; Help </a></li>
												<?php
												break;
											}      
										} ?>
									</ul>
								</div>
								<div class="menuCol col-xl-3 col-lg-3 col-md-12">
									<ul class="dropdown-submenu">
										<li class="menu-title" style="color:#17202a">
											<b><?php echo display('Admin Details');  ?></b>
										</li>
										<li><a href="<?php echo base_url('Cweb_setting/invoice_template') ?>"><i
													class="ti-settings"></i>&nbsp;&nbsp;Sales Invoice </a></li>
										<li><a href="<?php echo base_url('Cweb_setting/invoice_design') ?>"><i
													class="ti-settings"></i>&nbsp;&nbsp;Invoice Design </a></li>
										<li><a href="<?php echo base_url('Cweb_setting/invoice_content') ?>"><i
													class="ti-settings"></i>&nbsp;&nbsp;Invoice Content </a>
										</li>
										<li><a href="<?php echo base_url('Company_setup/manage_company') ?>"><i
													class="ti-settings"></i>&nbsp;&nbsp;Manage My Company</a></li>
										<li><a href="<?php echo base_url('/Language') ?>"><i
													class="ti-settings"></i>&nbsp;&nbsp;Language </a></li>
										<li><a href="<?php echo base_url('User/manage_user') ?>"><i
													class="ti-settings"></i>&nbsp;&nbsp;Manage Users </a></li>
										<li><a href="  <?php echo base_url('Admin_dashboard/edit_profile') ?>"><i
													class="pe-7s-users"></i>
												<?php echo  display('user_profile'); ?></a>
										</li>
										<li><a href=" <?php echo base_url('Admin_dashboard/change_password_form') ?>"><i
													class="pe-7s-settings"></i><?php echo display('Change Password'); ?></a>
										</li>
									</ul>
								</div>
								<div class="menuCol col-xl-3 col-lg-3 col-md-12">
									<ul class="dropdown-submenu">
										<?php
										foreach ($this->session->userdata('admin_data') as $admtest) {
											$split = explode('-', $admtest);
											if (trim($split[0]) == 'setting') {
										?>
										<li class="menu-title" style="color:#17202a">
											<b><?php echo display('Admin Details');  ?></b>
										</li>
										<li><a href="<?php echo base_url('Currency/currency_form') ?>"><i
													class="ti-settings"></i>&nbsp;&nbsp;<?php echo display('currency');  ?></a>
										</li>
										<li><a href="<?php echo base_url('/Cweb_setting') ?>"><i
													class="ti-settings"></i>&nbsp;&nbsp;Setting </a></li>
										<li><a href="<?php echo base_url('Cweb_setting/mail_setting') ?>"><i
													class="ti-settings"></i>&nbsp;&nbsp;<?php echo display('mail_setting'); ?>
											</a></li>
										<li><a href="<?php echo base_url('Language/import_page') ?>"><i
													class="ti-settings"></i>&nbsp;&nbsp;Import Csv </a></li>
										<li><a href=" <?php echo base_url('Admin_dashboard/dashboardsetting') ?>"><i
													class="ti-dashboard"></i>Dashboard Settings</a></li>
										<br>
										<li class="menu-title" style="color:#17202a">
											<b><?php echo ('LogOut');  ?></b>
										</li>
										<?php
									break;
											}
									} ?>
										<li><a href="<?php echo base_url('Admin_dashboard/logout') ?>"><i
													class="fa fa-sign-out"></i>&nbsp;&nbsp;<?php echo display('logout');  ?></a>
										</li>
									</ul>
								</div>
							</div>
							<?php } 
							if ($_SESSION['u_type'] == 1) { ?>
							<div class="menuCol col-xl-3 col-lg-3 col-md-12">
								<ul class="dropdown-submenu">
									<li class="menu-title" style="color:#17202a">
										<b><?php echo display('Admin Details');  ?></b>
									</li>
									<li><a href=" <?php echo base_url('Admin_dashboard/change_password_form') ?>"><i
												class="pe-7s-settings"></i><?php   echo display('Change Password'); ?>
										</a></li>
									<li><a href="<?php echo base_url('Admin_dashboard/logout') ?>"><i
												class="pe-7s-key"></i>&nbsp;&nbsp;<?php echo display('logout');  ?></a>
									</li>
								</ul>
							</div>
							<?php } 
							if ($_SESSION['u_type'] == 3) { ?>
							<div class="menuCol col-xl-3 col-lg-3 col-md-12">
								<ul class="dropdown-submenu" style="width: auto;">
									<li class="menu-title" style="color:#17202a">
										<b><?php echo display('User Setting');  ?> </b>
									</li>
									<li><a href="  <?php echo base_url('Admin_dashboard/edit_profile') ?>"><i
												class="pe-7s-users"></i><?php echo  display('user_profile'); ?> </a>
									</li>
									<!-- <li><a href=" <?php echo base_url('Admin_dashboard/dashboardsetting') ?>"><i class="ti-dashboard"></i>Dashboard Settings</a></li> -->
									<li><a href=" <?php echo base_url('Admin_dashboard/change_password_form') ?>"><i
												class="pe-7s-settings"></i><?php echo display('Change Password'); ?>
										</a></li>
									<li><a href="<?php echo base_url('Admin_dashboard/logout') ?>"><i
												class="fa fa-sign-out"></i>&nbsp;&nbsp;<?php echo display('logout');  ?></a>
									</li>
								</ul>
							</div>
							<?php } ?>
						</div>
					</li>
				</ul>
			</div>
        </nav>
    </nav>
</header>
<aside class="main-sidebar" style="background-color:#424f5c;">
    <div class="sidebar">
        <div class="user-panel text-center row" style="display: flex; align-items: center;">
            <div class="image col-md-6">
                <?php
                if ($_SESSION['u_type'] == 1) { ?>
                    <img src="<?php
                            if (isset($superadmin_logo[0]['logo'])) {
                                echo base_url() . html_escape($superadmin_logo[0]['logo']);
                            }
                            ?>" class="img-circle" alt="User Image">
                    <?php  } elseif ($_SESSION['u_type'] == 2) { ?>
                    <img src="<?php
                            if (isset($Web_settings[0]['logo'])) {
                                echo base_url() . html_escape($Web_settings[0]['logo']);
                            }
                            ?>" class="img-circle" alt="User Image">
                    <?php } elseif ($_SESSION['u_type'] == 3) {
                ?>
                    <img src="<?php
                            echo base_url() . html_escape($users[0]['logo']);
                            ?>" class="img-circle" alt="User Image">
                    <?php
                }
                ?>
            </div>
            <div class="info col-md-6">
                <?php
                if ($_SESSION['u_type'] == 1) {
                    ?>
                    <p>Super User </p>
                    <?php } elseif ($_SESSION['u_type'] == 2) { ?>
                    <p style="margin-left: -30px;text-wrap: wrap;">
                        <?php echo ($retrieve_admin_data[0]['first_name'] . ' ' . $retrieve_admin_data[0]['last_name']); ?>
                    </p>
                    <p style="color:white;"> <?php echo $_SESSION['unique_id']; ?> </p>
                    <?php } elseif ($_SESSION['u_type'] == 3) { ?>
                    <p style="margin-left: -30px;text-wrap: wrap;">
                        <?php echo ($retrieve_user_data[0]['first_name'] . ' ' . $retrieve_user_data[0]['last_name']); 
                        $data = $this->session->all_userdata();
                        ?>
                    </p>
                    <p style="color:white;"> <?php echo $_SESSION['unique_id']; ?> </p>
                    <?php 
                } ?>
            </div>
        </div><!---user-panel text-center row --ends here -->
        <?php
        if ($_SESSION['u_type'] == 1) {
            ?>
            <ul class="sidebar-menu">
                <li class="<?php echo ($this->uri->segment(2) == '') ? 'active' : ''; ?>">
                    <a href="<?php echo base_url(); ?>"><i class="ti-dashboard"></i>
                        <span><?php echo  display('dashboard'); ?></span>
                        <span class="pull-right-container">
                            <span class="label label-success pull-right"></span>
                        </span>
                    </a>
                </li>
                <li class="<?php echo ($this->uri->segment(2) == 'managecompany') ? 'active' : ''; ?>">
                    <a href="<?php echo base_url(); ?>user/managecompany"><i class="ti-dashboard"></i>
                        <span><?php echo display('manage_company'); ?></span>
                        <span class="pull-right-container">
                            <span class="label label-success pull-right"></span>
                        </span>
                    </a>
                </li>
                <li class="<?php echo ($this->uri->segment(2) == 'adadmin_index') ? 'active' : ''; ?>">
                    <a href="<?php echo base_url(); ?>user/adadmin_index"><i class="ti-dashboard"></i>
                        <span><?php echo  display('manage_admin');  ?></span>
                        <span class="pull-right-container">
                            <span class="label label-success pull-right"></span>
                        </span>
                    </a>
                </li>
                <li class="treeview  <?php echo ($this->uri->segment(1) == 'Permission') ? 'active' : ''; ?>">
                    <a href="#">
                        <i class="ti-key"></i> <span><?php echo ('Admin Role');  ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview  "><a href="<?php echo base_url(); ?>Permission/super_role_list"><?php echo ('Role List');  ?></a>
                        </li>
                        <li class="treeview  "><a href="<?php echo base_url(); ?>Permission/company_role_index"><?php echo ("Admin Assign Role");  ?></a>
                        </li>
                    </ul>
                </li>
            </ul>
        <?php      
        } 
        if ($_SESSION['u_type'] == 2) { ?>
			<ul class="sidebar-menu">
				<li class="<?php echo ($this->uri->segment(2) == '') ? 'active' : ''; ?>">
					<a href="<?php echo base_url(); ?>?id=<?php echo $encode_com_id; ?>"><i class="ti-dashboard"></i>
						<span><?php echo display('dashboard'); ?></span>
						<span class="pull-right-container">
							<span class="label label-success pull-right"></span>
						</span>
					</a>
				</li>
				<?php
				foreach ($this->session->userdata('admin_data') as $admtest) {
				   $split = explode('-', $admtest);
				   if (trim($split[0]) == 'sale') { ?>
					<li class="treeview  <?php echo ($this->uri->segment(1) == 'Cinvoice' || $this->uri->segment(1) == 'sales') ? 'active' : ''; ?>">
						<a href="#">
							<i class="fa fa-balance-scale"></i><span><?php echo display('invoice'); ?></span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="treeview  <?php echo ($this->uri->segment(2) == 'manage_invoice') ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>Cinvoice/manage_invoice?id=<?php echo $encode_com_id; ?>"><?php echo display('Create Invoice'); ?></a>
							</li>
							<li class="treeview  <?php echo ($this->uri->segment(2) == 'manage_profarma_invoice') ? 'active' : ''; ?>">
								<a href="<?php echo base_url(); ?>Cinvoice/manage_profarma_invoice?id=<?php echo $encode_com_id; ?>"><?php echo display('Quote'); ?></a>
							</li>
							<li class="treeview  <?php echo ($this->uri->segment(2) == 'oceanExportTracking') ? 'active' : ''; ?>">
								<a href="<?php echo base_url(); ?>sales/oceanExportTracking?id=<?php echo $encode_com_id; ?>"><?php echo display('Ocean Export Tracking'); ?></a>
							</li>
							<li class="treeview  <?php echo ($this->uri->segment(2) == 'roadTransport') ? 'active' : ''; ?>">
								<!-- <a href="<?php //echo base_url(); ?>sales/manage_trucking"><?php echo display('Road Transport'); ?></a> -->
						
								<a href="<?php echo base_url(); ?>sales/roadTransport?id=<?php echo $encode_com_id; ?>"><?php echo display('Road Transport'); ?></a>

						
							</li>
						</ul>
					</li>
				<?php
				   }
				}  
				foreach ($this->session->userdata('admin_data') as $admtest) {
				   $split = explode('-', $admtest);
				   if (trim($split[0]) == 'customer') {
					?>
					<li class="treeview <?php echo ($this->uri->segment(1) == 'Ccustomer') ? 'active' : ''; ?>">
					<a href="<?php echo base_url(); ?>Ccustomer/manage_customer?id=<?php echo $encode_com_id; ?>">
							<i class="fa fa-handshake-o"></i><span><?php echo  display('customer'); ?></span>
						</a>
					</li>
					<?php
					  break;
				   }
				} 
				foreach ($this->session->userdata('admin_data') as $admtest) {
				   $split = explode('-', $admtest);
				   if (trim($split[0]) == 'product') {
					?>
					<li class="treeview <?php echo ($this->uri->segment(1) == 'Cproduct') ? 'active' : ''; ?>">
						<a href="<?php echo base_url(); ?>Cproduct/manage_product?id=<?php echo $encode_com_id; ?>">
							<i class="ti-bag"></i><span><?php echo display('product'); ?></span>
						</a>
					</li>
					<?php
					  break;
				   }
				} 
				foreach ($this->session->userdata('admin_data') as $admtest) {
				   $split = explode('-', $admtest);
				   if (trim($split[0]) == 'vendor') {
					?>
					<li class="treeview <?php echo ($this->uri->segment(1) == 'Csupplier') ? 'active' : ''; ?>">
						<a href="<?php echo base_url(); ?>Csupplier/manage_supplier?id=<?php echo $encode_com_id; ?>">
							<i class="ti-user"></i><span><?php echo display('Vendor'); ?></span>
						</a>
					</li>
					<?php
					  break;
				   }
				}
				foreach ($this->session->userdata('admin_data') as $admtest) {
				   $split = explode('-', $admtest);
				   if (trim($split[0]) == 'expense') {
					?>
					<li class="treeview  <?php echo ($this->uri->segment(1) == 'Cpurchase') ? 'active' : ''; ?>">
						<a href="#">
							<i class="ti-shopping-cart"></i><span><?php echo display('purchase'); ?></span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="treeview  <?php echo ($this->uri->segment(2) == 'manage_purchase') ? 'active' : ''; ?>">
								<a href="<?php echo base_url(); ?>Cpurchase/manage_purchase?id=<?php echo $encode_com_id; ?>"><?php echo display('Create Expense'); ?></a>
							</li>
							<li class="treeview  <?php echo ($this->uri->segment(2) == 'manage_purchase_order') ? 'active' : ''; ?>">
								<a href="<?php echo base_url(); ?>Cpurchase/manage_purchase_order"><?php echo display('Purchase Order'); ?></a>
							</li>
							<li class="treeview  <?php echo ($this->uri->segment(2) == 'manage_ocean_import_tracking') ? 'active' : ''; ?>">
								<a href="<?php echo base_url(); ?>Ccpurchase/manage_ocean_import_tracking"><?php echo display('Ocean Import Tracking'); ?></a>
							</li>
							<li class="treeview  <?php echo ($this->uri->segment(2) == 'manage_trucking') ? 'active' : ''; ?>">
								<a  href="<?php echo base_url(); ?>Ccpurchase/manage_trucking"><?php echo display('Road Transport'); ?></a>
							</li>
						</ul>
					</li>
					<?php
					  break;
				   }
				}
				foreach ($this->session->userdata('admin_data') as $admtest) {
				   $split = explode('-', $admtest);
				   if (trim($split[0]) == 'quotation') {
					  break;
				   }
				} 
				foreach ($this->session->userdata('admin_data') as $admtest) {
				   $split = explode('-', $admtest);
				   if (trim($split[0]) == 'taxes') {
					?>
					<li class="treeview <?php echo ($this->uri->segment(1) == 'Caccounts') ? 'active' : ''; ?>">
						<a href="<?php echo base_url(); ?>Caccounts/manage_tax?id=<?php echo $encode_com_id; ?>">
							<i class="ti-bar-chart"></i><span><?php echo display('Taxes'); ?></span>
						</a>
					</li>
					<?php
					  break;
				   }
				} 
				foreach ($this->session->userdata('admin_data') as $admtest) {
				   $split = explode('-', $admtest);
				   if (trim($split[0]) == 'return') {
				
					  break;
				   }
				} 
				foreach ($this->session->userdata('admin_data') as $admtest) {
				   $split = explode('-', $admtest);
				   if (trim($split[0]) == 'report') {
					?>
					<li class="treeview  <?php echo ($this->uri->segment(1) == 'Creport') ? 'active' : ''; ?>">
						<a href="#">
							<i class="ti-book"></i><span><?php echo display('report'); ?></span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="treeview ">
								<a href="fa fa-asl-interpreting">
									<i class="ti-user"></i><span><?php echo "Accounts" ?></span>
								</a>
								<ul class="treeview-menu">
									<li class="treeview">
										<a href="<?php echo base_url('accounts/treeview_form?id='.$encode_com_id) ?>"><?php echo 'Account List'; ?></a>
									</li>
									<li class="treeview">
										<a href="<?php echo base_url('accounts/balance_sheet_compare?id='.$encode_com_id) ?>"><?php echo 'Balance Sheet Comparison '; ?></a>
									</li>
									<li class="treeview">
										<a href="<?php echo base_url('accounts/balance_sheet?id='.$encode_com_id) ?>"><?php echo 'Balance Sheet'; ?></a>
									</li>
									<li class="treeview">
										<a href="<?php echo base_url('accounts/transaction_split?id='.$encode_com_id) ?>"><?php echo 'Transaction List with Splits'; ?></a>
									</li>
									<li class="treeview">
										<a href="<?php echo base_url('accounts/cash_flow_report?id='.$encode_com_id) ?>"><?php echo 'Statement of Cash Flows'; ?></a>
									</li>
									<li class="treeview">
										<a href="<?php echo base_url(); ?>accounts/trail_balance_reports?id=<?php echo $encode_com_id; ?>"><?php echo display('trial_balance');  ?></a>
									</li>
									<li class="treeview">
										<a href="<?php echo base_url('accounts/transcation_details?id='.$encode_com_id) ?>"><?php echo 'Transaction Details'; ?></a>
									</li>
									<li class="treeview">
										<a href="<?php echo base_url('accounts/generalLedger?id='.$encode_com_id) ?>"><?php echo 'General Ledger'; ?></a>
									</li>
									<li class="treeview">
										<a href="<?php echo base_url('accounts/journal?id='.$encode_com_id) ?>"><?php echo 'Journal'; ?></a>
									</li>
									<li class="treeview">
										<a href="<?php echo base_url('accounts/profit_loss?id='.$encode_com_id) ?>"><?php echo 'Profit Loss'; ?></a>
									</li>
									<li class="treeview">
										<a  href="<?php echo base_url('accounts/profit_loss_comparison?id='.$encode_com_id) ?>"><?php echo 'Profit Loss Comparison'; ?></a>
									</li>
								</ul>
							</li>
							<li class="treeview <?php echo ($this->uri->segment(2) == 'customerReport' || $this->uri->segment(2) == 'customerSalesReport' || $this->uri->segment(2) == 'customerTransaction') ? 'active' : ''; ?>">
								<a href="fa fa-asl-interpreting">
									<i class="ti-user"></i><span><?php echo "Customer" ?></span>
								</a>
								<ul class="treeview-menu">
									<li class="treeview  <?php echo ($this->uri->segment(2) == 'customerReport') ? 'active' : ''; ?>">
										<a href="<?php echo base_url('Creport/customerReport?id='.$encode_com_id) ?>" <?php echo ($this->uri->segment(2) == 'customerReport') ? 'active' : ''; ?>><?php echo 'Customer Information'; ?>
										</a>
									</li>
									<li class="treeview  <?php echo ($this->uri->segment(2) == 'customerSalesReport') ? 'active' : ''; ?>">
										<a href="<?php echo base_url('Creport/customerSalesReport?id='.$encode_com_id) ?>"><?php echo 'Sales By Customer'; ?></a>
									</li>
									<li class="treeview  <?php echo ($this->uri->segment(2) == 'customerTransaction') ? 'active' : ''; ?>">
										<a href="<?php echo base_url('Creport/customerTransaction?id='.$encode_com_id) ?>"><?php echo 'Transaction By Customer'; ?></a>
									</li>
								</ul>
							</li>
							<li class="treeview <?php echo ($this->uri->segment(2) == 'vendorList' || $this->uri->segment(2) == 'purchaseByvendorList' || $this->uri->segment(2) == 'supplierTransactionList') ? 'active' : ''; ?>">
								<a href="fa fa-asl-interpreting">
									<i class="ti-user"></i><span><?php echo "Vendor" ?></span>
								</a>
								<ul class="treeview-menu">
									<li class="treeview <?php echo ($this->uri->segment(2) == 'vendorList') ? 'active' : ''; ?>">
										<a href="<?php echo base_url('Creport/vendorList?id='.$encode_com_id) ?>"><?php echo 'Vendor Information'; ?>
										</a>
									</li>
									<li class="treeview <?php echo ($this->uri->segment(2) == 'purchaseByvendorList') ? 'active' : ''; ?>">							
						          	  <a href="<?php echo base_url('Creport/purchaseByvendorList?id='.$encode_com_id) ?>"><?php echo 'Purchase By Vendor'; ?></a> 
									</li>
									<li class="treeview <?php echo ($this->uri->segment(2) == 'supplierTransactionList') ? 'active' : ''; ?>">
										<a href="<?php echo base_url('Creport/supplierTransactionList?id='.$encode_com_id) ?>"><?php echo 'Transaction to Vendor'; ?></a>
									</li>
								</ul>
							</li>

							<li class="treeview  <?php echo ($this->uri->segment(2) == 'productReport' || $this->uri->segment(2) == 'productReportStock') ? 'active' : ''; ?>">

								<a href="fa fa-asl-interpreting">
									<i class="ti-user"></i><span><?php echo "Product" ?></span>
								</a>
								<ul class="treeview-menu">
									<li class="treeview <?php echo ($this->uri->segment(2) == 'productReport') ? 'active' : ''; ?>">
										<a href="<?php echo base_url('Creport/productReport?id='.$encode_com_id) ?>"><?php echo 'Product Information'; ?>
										</a>
									</li>
									<li class="treeview <?php echo ($this->uri->segment(2) == 'productReportStock') ? 'active' : ''; ?>">
										<a href="<?php echo base_url('Creport/productReportStock?id='.$encode_com_id) ?>"><?php echo 'Product Stock'; ?></a>
									</li>
								</ul>
							</li>
							<li class="treeview">
								<a href="fa fa-asl-interpreting">
									<i class="ti-user"></i><span><?php echo "Tax Details" ?></span>
								</a>
								<ul class="treeview-menu">
									<li class="treeview">
										<a href="<?php echo base_url('Cinvoice/sales_tax') ?>"><?php echo 'Taxable Sales Detail'; ?>
										</a>
									</li>
									<li class="treeview">
										<a href="<?php echo base_url('Cinvoice/expense_tax') ?>"><?php echo 'Taxable Expense  Detail'; ?></a>
									</li>
								</ul>
							</li>
							<li class="treeview">
								<a href="fa fa-asl-interpreting">
									<i class="ti-user"></i><span><?php echo "Debtor" ?></span>
								</a>
								<ul class="treeview-menu">
									<li class="treeview">
										<a href="<?php echo base_url('Accounts/account_receivable_ageing') ?>"><?php echo 'Receivables Ageing Details'; ?>
										</a>
									</li>
									<li class="treeview">
										<a href="<?php echo base_url('Accounts/account_receivable_ageing_summary') ?>"><?php echo 'Receivables Ageing Summary'; ?></a>
									</li>
									<li class="treeview">
										<a href="<?php echo base_url('Accounts/open_invoices') ?>"><?php echo 'Unpaid Invoices'; ?></a>
									</li>
								</ul>
							</li>
							<li class="treeview">
								<a href="fa fa-asl-interpreting">
									<i class="ti-user"></i><span><?php echo "Debt" ?></span>
								</a>
								<ul class="treeview-menu">
									<li class="treeview">
										<a href="<?php echo base_url('Accounts/payable_ageing_details') ?>"><?php echo 'Payables Ageing Details'; ?>
										</a>
									</li>
									<li class="treeview">
										<a href="<?php echo base_url('Accounts/account_payable_ageing_summary') ?>"><?php echo 'Payables Ageing Summary'; ?></a>
									</li>
									<li class="treeview">
										<a  href="<?php echo base_url('Accounts/open_invoices_debt') ?>"><?php echo 'Unpaid Bills'; ?></a>
									</li>
								</ul>
							</li>
							<li class="treeview"><a href="<?php echo base_url(); ?>Csettings/bank_ledgers"><?php echo 'Bank Ledger'; ?></a>
							</li>
							<li class="treeview"><a href="<?php echo base_url('accounts/salesReport') ?>"><?php echo 'Sales Report'; ?> </a>
							</li>
							<li class="treeview"><a href="<?php echo base_url('accounts/expenseReport') ?>"><?php echo 'Expense Report'; ?> </a>
							</li>
							<li class="treeview"><a href="<?php echo base_url(); ?>Admin_dashboard/closing"><?php echo display('closing'); ?></a>
							</li>
							<li class="treeview"><a href="<?php echo base_url(); ?>Admin_dashboard/closing_report"><?php echo display('closing_report'); ?></a>
							</li>
							<li class="treeview"><a href="<?php echo base_url(); ?>Admin_dashboard/all_report"><?php echo  display('todays_report');  ?></a>
							</li>
						</ul>
					</li>
				<?php
                  break;
					}
				} 
				foreach ($this->session->userdata('admin_data') as $admtest) {
				   $split = explode('-', $admtest);
				   if (trim($split[0]) == 'accounts') {
				?>
					<li class="treeview">
						<a href="#">
							<i class="fa fa-money"></i><span><?php echo display('accounts'); ?></span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="treeview"><a
									href="<?php echo base_url(); ?>accounts/financial_manager"><?php echo display('Financial Year');  ?></a>
							</li>
							<li class="treeview"><a
									href="<?php echo base_url(); ?>accounts/financial_year_end"><?php echo display('Financial Year Ending');  ?></a>
							</li>
							<li class="treeview"><a
									href="<?php echo base_url(); ?>accounts/show_tree"><?php echo display('c_o_a');  ?></a>
							</li>
							<li class="treeview"><a
									href="<?php echo base_url(); ?>accounts/supplier_payment_manager"><?php echo display('supplier_payment');  ?></a>
							</li>
							<li class="treeview"><a
									href="<?php echo base_url(); ?>accounts/customer_receive_manager"><?php echo  display('customer_receive');  ?></a>
							</li>
							<li class="treeview"><a
									href="<?php echo base_url(); ?>accounts/debit_manager"><?php echo display('debit_voucher'); ?></a>
							</li>
							<li class="treeview"><a
									href="<?php echo base_url(); ?>accounts/credit_voucher_manager"><?php echo display('credit_voucher'); ?></a>
							</li>
							<li class="treeview"><a
									href="<?php echo base_url(); ?>accounts/contra_voucher_manager"><?php echo display('contra_voucher'); ?></a>
							</li>
							<li class="treeview"><a
									href="<?php echo base_url(); ?>accounts/journal_voucher_manager"><?php echo display('journal_voucher'); ?></a>
							</li>
							<li class="treeview">
								<a href=""><?php echo  display('report'); ?> <span class="pull-right-container">
										<i class="fa fa-angle-left pull-right"></i>
									</span>
								</a>
								<ul class="treeview-menu">
									<li class="treeview"><a
											href="<?php echo base_url(); ?>accounts/voucher_report"><?php echo display('Voucher Report'); ?></a>
									</li>
									<li class="treeview"><a
											href="<?php echo base_url(); ?>accounts/cash_book"><?php echo display('cash_book'); ?></a>
									</li>
									<li class="treeview"><a
											href="<?php echo base_url(); ?>accounts/inventory_ledger"><?php echo display('inventory_ledger');  ?></a>
									</li>
									<li class="treeview"><a
											href="<?php echo base_url(); ?>accounts/bank_book"><?php echo display('bank_book');  ?></a>
									</li>
									<li class="treeview"><a
											href="<?php echo base_url(); ?>accounts/general_ledger"><?php echo display('general_ledger');  ?></a>
									</li>
									<li class="treeview"><a
											href="<?php echo base_url(); ?>accounts/profit_loss_report"><?php echo  display('profit_loss'); ?></a>
									</li>
									<li class="treeview"><a
											href="<?php echo base_url(); ?>accounts/cash_flow_report"><?php echo  display('cash_flow'); ?></a>
									</li>
									<li class="treeview"><a
											href="<?php echo base_url(); ?>accounts/coa_print"><?php echo  display('coa_print'); ?></a>
									</li>
									<li class="treeview"><a
											href="<?php echo base_url(); ?>accounts/balance_sheet"><?php echo display('Balance Sheet'); ?></a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<?php
                  break;
					}
				}
				foreach ($this->session->userdata('admin_data') as $admtest) {
				   $split = explode('-', $admtest);
				   if (trim($split[0]) == 'bank') {
				?>
				<li class="treeview  <?php echo ($this->uri->segment(1) == 'Csettings') ? 'active' : ''; ?>">
					<a href="#">
						<i class="ti-briefcase"></i><span><?php echo display('bank'); ?></span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="treeview <?php echo ($this->uri->segment(2) == 'bank_list') ? 'active' : ''; ?>"><a
								href="<?php echo base_url(); ?>Csettings/bank_list"><?php echo display('manage_bank'); ?></a>
						</li>
						<li
							class="treeview <?php echo ($this->uri->segment(2) == 'bank_transaction_list') ? 'active' : ''; ?>">
							<a
								href="<?php echo base_url(); ?>Csettings/bank_transaction_list"><?php echo display('bank_transaction'); ?></a>
						</li>
						<li class="treeview <?php echo ($this->uri->segment(2) == 'ledger_lists') ? 'active' : ''; ?>">
							<a
								href="<?php echo base_url(); ?>Csettings/ledger_lists"><?php echo display('bank_ledger'); ?></a>
						</li>
					</ul>
				</li>
				<?php
					  break;
				   }
				} 
				foreach ($this->session->userdata('admin_data') as $admtest) {
				   $split = explode('-', $admtest);
				   if (trim($split[0]) == 'hrm') {
					?>
					<li class="treeview <?php echo ($this->uri->segment(1) == 'Chrm') ? 'active' : ''; ?>">
						<a href="#">
							<i class="fa fa-balance-scale"></i><span><?php echo display('hrm_management'); ?></span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="treeview  "><a
									href="<?php echo base_url(); ?>Chrm/manage_employee?id=<?php echo $encode_com_id; ?>"><?php echo display('Employee Info (W4 form)'); ?></a>

								</li>
							<li class="treeview <?php echo ($this->uri->segment(2) == 'manage_timesheet') ? 'active' : ''; ?>">
								<a
									href="<?php echo base_url(); ?>Chrm/manage_timesheet?id=<?php echo $encode_com_id; ?>"><?php echo display('Time sheet'); ?></a>
							</li>
							<li class="treeview <?php echo ($this->uri->segment(2) == 'pay_slip_list') ? 'active' : ''; ?>">
								<a
									href="<?php echo base_url(); ?>Chrm/pay_slip_list?id=<?php echo $encode_com_id; ?>"><?php echo display('Pay slip / Checks per user'); ?></a>
							</li>
	
							<li class="treeview <?php echo ($this->uri->segment(2) == 'payroll_setting') ? 'active' : ''; ?>">
								<a
									href="<?php echo base_url(); ?>Chrm/payroll_setting?id=<?php echo $encode_com_id; ?>"><?php echo display('Payroll settings'); ?></a>
							</li>
							<li class="treeview <?php echo ($this->uri->segment(2) == 'payslip_setting') ? 'active' : ''; ?>">
								<a href="<?php echo base_url(); ?>Chrm/payslip_setting"><?php echo ('Payslip settings'); ?></a>
							</li>
							<li class="treeview <?php echo ($this->uri->segment(2) == 'expense_list') ? 'active' : ''; ?>">
								<a href="<?php echo base_url(); ?>Chrm/expense_list"><?php echo display("expense"); ?></a>
							</li>
							<li class="treeview <?php echo ($this->uri->segment(2) == 'manage_officeloan') ? 'active' : ''; ?>">
								<a
									href="<?php echo base_url(); ?>Chrm/manage_officeloan"><?php echo display("office_loan"); ?></a>
							</li>
							<li class="treeview  ">
								<a href="#">
									<i class=""></i> <span><?php echo ('Reports'); ?></span>
									<span class="pull-right-container">
										<i class="fa fa-angle-left pull-right"></i>
									</span>
								</a>
								<ul class="treeview-menu">
									<li class="treeview  ">
										<a href="#">
											<i class=""></i> <span><?php echo ('Federal Tax'); ?></span>
											<span class="pull-right-container">
												<i class="fa fa-angle-left pull-right"></i>
											</span>
										</a>
										<ul class="treeview-menu">
											<li class="treeview  "><a
													href="<?php echo base_url(); ?>Chrm/federal_tax_report?id=<?php echo $encode_com_id; ?>"><?php echo ('Income Tax'); ?></a>
											</li>
											<li class="treeview  "><a
													href="<?php echo base_url(); ?>Chrm/social_tax_report?id=<?php echo $encode_com_id; ?>"><?php echo ('Social Security'); ?>
												</a></li>
											<li class="treeview  "><a
													href="<?php echo base_url(); ?>Chrm/medicare_tax_report?id=<?php echo $encode_com_id; ?>"><?php echo ('Medicare'); ?></a>
											</li>
											<li class="treeview  "><a
													href="<?php echo base_url(); ?>Chrm/unemployment_tax_report?id=<?php echo $encode_com_id; ?>"><?php echo ('Unemployment'); ?></a>
											</li>
											<li class="treeview  "><a
													href="<?php echo base_url(); ?>Chrm/federal_summary?id=<?php echo $encode_com_id; ?>"><?php echo ('Overall Summary'); ?></a>
											</li>
										</ul>
									</li>
									<li class="treeview  ">
										<a href="#">
											<i class=""></i> <span><?php echo ('State Tax'); ?></span>
											<span class="pull-right-container">
												<i class="fa fa-angle-left pull-right"></i>
											</span>
										</a>
										<ul class="treeview-menu">
											<?php if (!empty($state_tax_list)) : ?>
											<?php foreach ($state_tax_list as $st) : ?>
											<li class="treeview">
												<a
													href="<?php echo base_url('Chrm/report/' . $st['tax']) . '?id=' . $encode_com_id; ?>"><?php echo $st['tax']; ?></a>
											</li>
											<?php endforeach; ?>
											<?php else : ?>
											<li>No state taxes available</li>
											<?php endif; ?>
											<li class="treeview  "><a
													href="<?php echo base_url(); ?>Chrm/state_summary"><?php echo ('Overall Summary'); ?></a>
											</li>
										</ul>
									</li>
									<li class="treeview  "><a
											href="<?php echo base_url(); ?>Chrm/city_local_tax"><?php echo ('City Tax'); ?></a>
									</li>
									<li class="treeview  "><a
											href="<?php echo base_url(); ?>Chrm/city_tax_report"><?php echo ('County Tax'); ?></a>
									</li>
									<li class="treeview  "><a
											href="<?php echo base_url(); ?>Chrm/other_tax"><?php echo ('Other Taxes'); ?></a>
									</li>
									
									<li class="treeview  "><a
											href="<?php echo base_url(); ?>Chrm/OverallSummary?id=<?php echo $encode_com_id; ?>"><?php echo ('Overall Summary'); ?></a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
				<?php
					  break;
				   }
				} 
				foreach ($this->session->userdata('admin_data') as $admtest) {
				   $split = explode('-', $admtest);
				   if (trim($split[0]) == 'email') {
				?>
					<li class="treeview <?php echo ($this->uri->segment(2) == 'email_setting') ? 'active' : ''; ?>">
						<a href="<?php echo base_url(); ?>Cweb_setting/email_setting">
							<i class="ti-email"></i><span><?php echo display('email'); ?></span>
						</a>
					</li>
				<?php
					  break;
				   }
				} 
				foreach ($this->session->userdata('admin_data') as $admtest) {
				   $split = explode('-', $admtest);
				   if (trim($split[0]) == 'setting') {
				?>
					<li class="treeview  <?php echo ($this->uri->segment(2) == 'calender_view') ? 'active' : ''; ?>">
						<a href="<?php echo base_url(); ?>Cweb_setting/calender_view?id=<?php echo $encode_com_id; ?>">
							<i class="ti-calendar"></i><span><?php echo 'Calendar'; ?></span>
						</a>
					</li>
				<?php if (isset($Web_settings[0]['agree_share']) && $Web_settings[0]['agree_share'] == 'Yes') { ?>
					<li class="treeview  <?php echo ($this->uri->segment(2) == 'agree_view') ? 'active' : ''; ?>">
						<a href="<?php echo base_url(); ?>Cweb_setting/agree_view">
							<i class="fa fa-eye"></i><span>Advanced Product Search</span>
						</a>
					</li>
				<?php } 
					  break;
				   }
				} ?>
				<li class="treeview">
					<a href="<?php echo base_url(); ?>onlinehelp/index" target="_blank">
						<i class="fa fa-info-circle"></i><span><?php echo ('Online Help'); ?></span>
					</a>
				</li>




				<li class="treeview <?php echo in_array($this->uri->segment(1), ['Cweb_setting', 'Company_setup']) ? 'active' : ''; ?>">
				<a href="#">
					<i class="ti-settings"></i> <span><?php echo display('settings'); ?></span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="treeview <?php echo in_array($this->uri->segment(2), ['invoice_template', 'invoice_design', 'invoice_content']) ? 'active' : ''; ?>">
						<a href="#">
							 </i> <span><?php echo ('Invoice Template') ?></span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="<?php echo ($this->uri->segment(2) == 'invoice_template') ? 'active' : ''; ?>">
								<a href="<?php echo base_url(); ?>Cweb_setting/invoice_template?id=<?php echo $encode_com_id; ?>">
									<?php echo display('Sales Invoice'); ?>
								</a>
							</li>
							<li class="<?php echo ($this->uri->segment(2) == 'invoice_design') ? 'active' : ''; ?>">
								<a href="<?php echo base_url(); ?>Cweb_setting/invoice_design?id=<?php echo $encode_com_id; ?>">
									<?php echo display('Invoice Design'); ?>
								</a>
							</li>
							<li class="<?php echo ($this->uri->segment(2) == 'invoice_content') ? 'active' : ''; ?>">
								<a href="<?php echo base_url(); ?>Cweb_setting/invoice_content?id=<?php echo $encode_com_id; ?>">
									<?php echo display('Invoice Content'); ?>
								</a>
							</li>
						</ul>
					</li>
 

					<li class="treeview  ">
							<a href="">
 								<span><?php echo display('Template Content') ?></span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<li class="treeview"><a href=""><?php echo display('Email Template') ?></a></li>
								<li class="treeview  ">
									<a href="#">
										<i class=" "></i> <span><?php echo display('Alerts Template') ?></span>
										<span class="pull-right-container">
											<i class="fa fa-angle-left pull-right"></i>
										</span>
									</a>
									<ul class="treeview-menu">
										<li class="treeview  ">
											<a href="#">
												<i class=""></i> <span><?php echo display('Sale Template') ?></span>
												<span class="pull-right-container">
													<i class="fa fa-angle-left pull-right"></i>
												</span>
											</a>
											<ul class="treeview-menu">
												<li class="treeview  ">
													<a href="#">
														<i class=""></i>
														<span><?php echo display('new_invoice'); ?></span>
														<span class="pull-right-container">
															<i class="fa fa-angle-left pull-right"></i>
														</span>
													</a>
													<ul class="treeview-menu">
														<li class="treeview  "><a
																href="#"><?php echo display('Payment Due date'); ?></a>
														</li>
														<li class="treeview  "><a
																href="#"><?php echo display('Estimated Time of Arrival'); ?>
															</a></li>
														<li class="treeview  "><a
																href="#"><?php echo display('Estimated Time of Departure'); ?></a>
														</li>
													</ul>
												</li>
												<li class="treeview  ">
													<a href="#">
														<i class=""></i>
														<span><?php echo display('Ocean Export tracking'); ?></span>
														<span class="pull-right-container">
															<i class="fa fa-angle-left pull-right"></i>
														</span>
													</a>
													<ul class="treeview-menu">
														<li class="treeview  "><a
																href="#"><?php echo display('Estimated Time of Arrival'); ?>
															</a></li>
														<li class="treeview  "><a
																href="#"><?php echo display('Estimated Time of Departure'); ?></a>
														</li>
													</ul>
												</li>
												<li class="treeview  ">
													<a href="#">
														<i class=""></i>
														<span><?php echo display('Road Transport'); ?></span>
														<span class="pull-right-container">
															<i class="fa fa-angle-left pull-right"></i>
														</span>
													</a>
													<ul class="treeview-menu">
														<li class="treeview  "><a
																href="#"><?php echo display('Container / Goods Pick up date'); ?></a>
														</li>
														<li class="treeview  "><a href="#">
																<?php echo display('Delivery date'); ?></a></li>
													</ul>
												</li>
											</ul>
										</li>
									</ul>
								</li>
								<li class="treeview  ">
									<a href="#">
										<i class=""></i> <span>Expense Template</span>
										<span class="pull-right-container">
											<i class="fa fa-angle-left pull-right"></i>
										</span>
									</a>
									<ul class="treeview-menu">
										<li class="treeview  ">
											<a href="#">
												<i class=""></i> <span><?php echo display('new_purchase'); ?></span>
												<span class="pull-right-container">
													<i class="fa fa-angle-left pull-right"></i>
												</span>
											</a>
											<ul class="treeview-menu">
												<li class="treeview  "><a href="#"><?php echo display('Payment Due Date'); ?>
													</a></li>
												<li class="treeview  "><a
														href="#"><?php echo display('Estimated Time of Arrival'); ?> </a>
												</li>
												<li class="treeview  "><a
														href="#"><?php echo display('Estimated Time of Departure'); ?>
													</a>
												</li>
											</ul>
										</li>
										<li class="treeview  ">
											<a href="#">
												<i class=""></i> <span><?php echo display('Purchase Order'); ?></span>
												<span class="pull-right-container">
													<i class="fa fa-angle-left pull-right"></i>
												</span>
											</a>
											<ul class="treeview-menu">
												<li class="treeview  "><a href="#">Est. Shipment date </a></li>
											</ul>
										</li>
										<li class="treeview  ">
											<a href="#">
												<i class=""></i>
												<span><?php echo display('Ocean Import tracking'); ?></span>
												<span class="pull-right-container">
													<i class="fa fa-angle-left pull-right"></i>
												</span>
											</a>
											<ul class="treeview-menu">
												<li class="treeview  "><a
														href="#"><?php echo display('Estimated Time of Arrival'); ?> </a>
												</li>
												<li class="treeview  "><a
														href="#"><?php echo display('Estimated Time of Departure'); ?></a>
												</li>
											</ul>
										</li>
										<li class="treeview  ">
											<a href="#">
												<i class=""></i> <span><?php echo display('Road Transport'); ?></span>
												<span class="pull-right-container">
													<i class="fa fa-angle-left pull-right"></i>
												</span>
											</a>
											<ul class="treeview-menu">
												<li class="treeview  "><a href="#">
														<?php echo display('Container / Goods Pick up date'); ?> </a>
												</li>
												<li class="treeview  "><a
														href="#"><?php echo display('Delivery date'); ?></a></li>
											</ul>
										</li>
									</ul>
								</li>
							</ul>
						</li>





					<li class="<?php echo ($this->uri->segment(2) == 'manage_company') ? 'active' : ''; ?>">
						<a href="<?php echo base_url(); ?>Company_setup/manage_company?id=<?php echo $encode_com_id; ?>">
							<?php echo display('Manage my Company'); ?>
						</a>
					</li>


					<li class="treeview  "><a
								href="<?php echo base_url(); ?>Language"><?php echo display('language'); ?> </a></li>
						
								<li class="treeview  "><a
								href="<?php echo base_url(); ?>Currency"><?php echo display('currency'); ?> </a></li>
					
								<li class="treeview  "><a
								href="<?php echo base_url(); ?>Cweb_setting"><?php echo display('setting'); ?> </a>
						</li>
					
						<li class="treeview  "><a
								href="<?php echo base_url(); ?>Cweb_setting/mail_setting"><?php echo display('mail_setting'); ?>
							</a></li>
					
							<li class="treeview "><a
								href="<?php echo base_url(); ?>Language/import_page"><?php echo ('Import CSV'); ?> </a>
						</li>

						<li style="display:none" class="treeview  "><a
								href="<?php echo base_url(); ?>Cweb_setting/app_setting"><?php echo  display('app_setting');  ?>
						</a></li>



				</ul>
			</li>

				 

				<li class="treeview">
					<a href="#">
						<i class="ti-key"></i> <span><?php echo display('role_permission');  ?></span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="treeview  "><a
								href="<?php echo base_url(); ?>Permission/add_role"><?php echo display('add_role'); ?></a>
						</li>
						<li class="treeview  "><a
								href="<?php echo base_url(); ?>Permission/role_list"><?php echo display('role_list');  ?></a>
						</li>
						<li class="treeview  "><a
								href="<?php echo base_url(); ?>Permission/user_assign"><?php echo  display("user_assign_role");  ?></a>
						</li>
					</ul>
				</li>
				<li class="treeview">
					<a href="#">
						<i class="fa fa-comments"></i> <span>SMS</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="treeview  "><a
								href="<?php echo base_url(); ?>Csms/configure"><?php echo display('sms_configure'); ?></a>
						</li>
					</ul>
				</li>
				<li class="treeview"><a
						href="<?php echo base_url(); ?>User/manage_user"><?php echo display('manage_users'); ?></a></li>
				<li><a href="<?php echo base_url('Chrm/working_hours') ?>"><i class="ti-timer"></i>&nbsp;&nbsp;Work Hour
						Per/Week </a></li>
				<li class="treeview  ">
					<a href="<?php echo base_url(); ?>Cservice/help_desk">
						<i class="fa fa-comments"></i> <span><?php echo display('Help'); ?></span>
					</a>
				</li>
			</ul>
            <?php } // end of $_SESSION['u_type'] == 2
			if ($_SESSION['u_type'] == 3) {
				?>
				<ul class="sidebar-menu">
					<li class="treeview <?php echo ($this->uri->segment(2) == '') ? 'active' : ''; ?>">
						<a href="<?php echo base_url(); ?>"><i class="ti-dashboard"></i>
							<span><?php echo display('dashboard'); ?></span>
							<span class="pull-right-container">
								<span class="label label-success pull-right"></span>
							</span>
						</a>
					</li>
					<?php
				   foreach ($this->session->userdata('perm_data') as $test) {
					  $split = explode('-', $test);
					  if (trim($split[0]) == 'sales') {
				   ?>
					<li class="treeview <?php echo ($this->uri->segment(1) == 'Cinvoice') ? 'active' : ''; ?>">
						<a href="#">
							<i class="fa fa-balance-scale"></i><span><?php echo display('invoice'); ?></span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="treeview  "><a href="<?php echo base_url(); ?>Cinvoice/manage_invoice?id=<?php echo $encode_com_id; ?>"><?php echo display('Create Invoice'); ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>Cinvoice/manage_profarma_invoice"><?php echo display('Quote'); ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>Cinvoice/manage_ocean_export_tracking"><?php echo display('Ocean Export Tracking'); ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>Cinvoice/manage_trucking"><?php echo display('Road Transport'); ?></a>
							</li>
						</ul>
					</li>
					<?php
						 break;
					  }
				   }
				   foreach ($this->session->userdata('perm_data') as $test) {
					  $split = explode('-', $test);
					  if (trim($split[0]) == 'customer') {
					  ?>
					<li class="treeview <?php echo ($this->uri->segment(1) == 'Ccustomer') ? 'active' : ''; ?>">
					   <a href="<?php echo base_url(); ?>Ccustomer/manage_customer?id=<?php echo $encode_com_id; ?>&admin=<?php echo $encode_admin_id; ?>">

							<i class="fa fa-handshake-o"></i><span><?php echo  display('customer');  ?></span>
						</a>
					</li>
					<?php
						 break;
					  }
				   }
				   foreach ($this->session->userdata('perm_data') as $test) {
					  $split = explode('-', $test);
					  if (trim($split[0]) == 'product') {
					  ?>
					<li class="treeview <?php echo ($this->uri->segment(1) == 'Cproduct') ? 'active' : ''; ?>">
						<a href="<?php echo base_url(); ?>Cproduct/manage_product?id=<?php echo $encode_com_id; ?>&admin=<?php echo $encode_admin_id; ?>">
							<i class="ti-bag"></i><span><?php echo  display('product'); ?></span>
						</a>
					</li>
					<?php
						 break;
					  }
				   }
				   foreach ($this->session->userdata('perm_data') as $test) {
					  $split = explode('-', $test);
					  if (trim($split[0]) == 'supplier') {
					  ?>
					<li class="treeview <?php echo ($this->uri->segment(1) == 'Csupplier') ? 'active' : ''; ?>">
						<a href="<?php echo base_url(); ?>Csupplier/manage_supplier">
							<i class="ti-user"></i><span><?php echo  display('Vendor'); ?></span>
						</a>
					</li>
					<?php break;
					  }
				   }
				   foreach ($this->session->userdata('perm_data') as $test) {
					  $split = explode('-', $test);
					  if (trim($split[0]) == 'expense') {
					  ?>
					<li class="treeview <?php echo ($this->uri->segment(1) == 'Cpurchase') ? 'active' : ''; ?>">
						<a href="#">
							<i class="ti-shopping-cart"></i><span><?php echo  display('purchase');  ?></span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="treeview  "><a href="<?php echo base_url(); ?>Cpurchase/manage_purchase"><?php echo display('Create Expense'); ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>Cpurchase/manage_purchase_order"><?php echo display('Purchase Order'); ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>Ccpurchase/manage_ocean_import_tracking"><?php echo display('Ocean Import Tracking'); ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>Ccpurchase/manage_trucking"><?php echo display('Road Transport'); ?></a>
							</li>
						</ul>
					</li>
					<?php
						 break;
					  }
				   }
				   foreach ($this->session->userdata('perm_data') as $test) {
					  $split = explode('-', $test);
					  if (trim($split[0]) == 'tax') {
					  ?>
					<li class="treeview <?php echo ($this->uri->segment(1) == 'Caccounts') ? 'active' : ''; ?>">
						<a href="<?php echo base_url(); ?>Caccounts/manage_tax?id=<?php echo $encode_com_id; ?>">
							<i class="ti-bar-chart"></i><span><?php echo  display('Taxes'); ?></span>
						</a>
					</li>
					<?php
						 break;
					  }
				   }
				   foreach ($this->session->userdata('perm_data') as $test) {
					  $split = explode('-', $test);
					  if (trim($split[0]) == 'report') {
					  ?>
					<li class="treeview <?php echo ($this->uri->segment(1) == 'Admin_dashboard') ? 'active' : ''; ?>">
						<a href="#">
							<i class="ti-book"></i><span><?php echo display('report'); ?></span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="treeview  "><a href="<?php echo base_url(); ?>Admin_dashboard/closing"><?php echo display('closing'); ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>Admin_dashboard/closing_report"><?php echo display('closing_report'); ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>Admin_dashboard/all_report"><?php echo  display('todays_report');  ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>Admin_dashboard/todays_customer_receipt"><?php echo  display('todays_customer_receipt');  ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>Admin_dashboard/todays_sales_report"><?php echo display('sales_report'); ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>Admin_dashboard/user_sales_report"><?php echo display('user_wise_sales_report'); ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>Admin_dashboard/retrieve_dateWise_DueReports"><?php echo  display('due_report');  ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>Admin_dashboard/retrieve_dateWise_Shippingcost"><?php echo  display('shipping_cost_report');  ?></a>
							</li>
							<li><a href="<?php echo base_url(); ?>Admin_dashboard/todays_purchase_report"><?php echo  display('purchase_report');  ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>Admin_dashboard/purchase_report_category_wise"><?php echo  display('purchase_report_category_wise');  ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>Admin_dashboard/product_sales_reports_date_wise"><?php echo  display('sales_report_product_wise');  ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>Admin_dashboard/sales_report_category_wise"><?php echo  display('sales_report_category_wise');  ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>Admin_dashboard/sales_return"><?php echo  display('invoice_return');  ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>Admin_dashboard/supplier_return"><?php echo display('supplier_return'); ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>Admin_dashboard/retrieve_dateWise_tax"><?php echo display('tax_report'); ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>Admin_dashboard/total_profit_report"><?php echo display('profit_report'); ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>Creport/product_stock"><?php echo display('stock_report_product_wise'); ?></a>
							</li>
						</ul>
					</li>
					<?php
						 break;
					  }
				   }
				   foreach ($this->session->userdata('perm_data') as $test) {
					  $split = explode('-', $test);
					  if (trim($split[0]) == 'accounts') {
					  ?>
					<li class="treeview <?php echo ($this->uri->segment(1) == 'accounts') ? 'active' : ''; ?>">
						<a href="#">
							<i class="fa fa-money"></i><span><?php echo display('accounts'); ?></span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="treeview  "><a href="<?php echo base_url(); ?>accounts/financial_manager"><?php echo display('Financial Year'); ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>accounts/financial_year_end"><?php echo display('Financial Year Ending'); ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>accounts/show_tree"><?php echo display('c_o_a');  ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>accounts/supplier_payment_manager"><?php echo display('supplier_payment');  ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>accounts/customer_receive_manager"><?php echo  display('customer_receive');  ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>accounts/debit_manager"><?php echo display('debit_voucher'); ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>accounts/credit_voucher_manager"><?php echo display('credit_voucher');  ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>accounts/contra_voucher_manager"><?php echo display('contra_voucher'); ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>accounts/journal_voucher"><?php echo display('journal_voucher'); ?></a>
							</li>
							<li class="treeview  ">
								<a href=""><?php echo display('report'); ?> <span class="pull-right-container">
										<i class="fa fa-angle-left pull-right"></i>
									</span>
								</a>
								<ul class="treeview-menu">
									<li class="treeview  "><a
											href="<?php echo base_url(); ?>accounts/voucher_report"><?php echo display('Voucher Report'); ?></a>
									</li>
									<li class="treeview  "><a
											href="<?php echo base_url(); ?>accounts/cash_book"><?php echo display('cash_book'); ?></a>
									</li>
									<li class="treeview  "><a
											href="<?php echo base_url(); ?>accounts/inventory_ledger"><?php echo display('inventory_ledger');  ?></a>
									</li>
									<li class="treeview  "><a
											href="<?php echo base_url(); ?>accounts/bank_book"><?php echo display('bank_book');  ?></a>
									</li>
									<li class="treeview  "><a
											href="<?php echo base_url(); ?>accounts/general_ledger"><?php echo display('general_ledger'); ?></a>
									</li>
									<li class="treeview  "><a
											href="<?php echo base_url(); ?>accounts/trial_balance"><?php echo display('trial_balance');  ?></a>
									</li>
									<li class="treeview  "><a
											href="<?php echo base_url(); ?>accounts/profit_loss_report"><?php echo  display('profit_loss'); ?></a>
									</li>
									<li class="treeview  "><a
											href="<?php echo base_url(); ?>accounts/cash_flow_report"><?php echo  display('cash_flow'); ?></a>
									</li>
									<li class="treeview  "><a
											href="<?php echo base_url(); ?>accounts/coa_print"><?php echo  display('coa_print'); ?></a>
									</li>
									<li class="treeview  "><a
											href="<?php echo base_url(); ?>accounts/balance_sheet"><?php echo display('Balance Sheet'); ?></a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<?php
						 break;
					  }
				   }
				   foreach ($this->session->userdata('perm_data') as $test) {
					  $split = explode('-', $test);
					  if (trim($split[0]) == 'bank') {
					  ?>

					<li class="treeview <?php echo ($this->uri->segment(1) == 'Csettings') ? 'active' : ''; ?>">
						<a href="#">
							<i class="ti-briefcase"></i><span><?php echo display('bank'); ?></span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="treeview  "><a href="<?php echo base_url(); ?>Csettings/bank_list"><?php echo display('manage_bank'); ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>Csettings/bank_transaction_list"><?php echo display('bank_transaction'); ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>Csettings/bank_ledger"><?php echo display('bank_ledger'); ?></a>
							</li>
						</ul>
					</li>
					<?php
						 break;
					  }
				   }
				   foreach ($this->session->userdata('perm_data') as $test) {
					  $split = explode('-', $test);
					  if (trim($split[0]) == 'hrm') {
					  ?>
					<li class="treeview <?php echo ($this->uri->segment(1) == 'Chrm') ? 'active' : ''; ?>">
						<a href="#">
							<i class="fa fa-balance-scale"></i><span><?php echo display('hrm_management'); ?></span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="treeview  "><a href="<?php echo base_url(); ?>Chrm/manage_timesheet"><?php echo display('Time sheet'); ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>Chrm/pay_slip_list"><?php echo display('Pay slip / Checks per user'); ?></a>
							</li>
							<li class="treeview  "><a href="<?php echo base_url(); ?>Chrm/expense_list"><?php echo display("expense"); ?></a>
							</li>
						</ul>
					</li>
					<?php
						 break;
					  }
				   }
				   foreach ($this->session->userdata('perm_data') as $test) {
					  $split = explode('-', $test);
					  if (trim($split[0]) == 'email') {
					  ?>
					<li class="treeview  ">
						<a href="<?php echo base_url(); ?>Cweb_setting/email_setting">
							<i class="ti-user"></i><span><?php echo display('email'); ?></span>
						</a>
					</li>
					<?php
						 break;
					  }
				   }
				   ?>
				</ul>
			<?php 	
			} ?>
	</div>
</aside>
 