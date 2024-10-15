<?php
$modaldata['bootstrap_model'] = array('vendor','tax_info','payment_model','payment_terms');

$this->load->view('include/bootstrap_model', $modaldata);
?>

<script src="<?php echo base_url() ?>my-assets/js/countrypicker.js" type="text/javascript"></script>
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <figure class="one">
                <img src="<?php echo base_url()  ?>asset/images/customer.png" class="headshotphoto"
                    style="height:50px;" />
        </div>
        <div class="header-title">
            <div class="logo-holder logo-9">
                <h1><?php echo display('add_customer') ?></h1>
            </div>
            <small></small>
            <ol class="breadcrumb" style=" border: 3px solid #d7d4d6;">
                <li><a href="<?php echo base_url(); ?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="<?php echo base_url('Ccustomer/manage_customer?id='.$_GET['id']); ?>"><?php echo display('customer') ?></a></li>
                <li class="active" style="color:orange;"><?php echo display('add_customer') ?></li>
                <div class="load-wrapp">
                    <div class="load-10">
                        <div class="bar"></div>
                    </div>
                </div>
            </ol>
        </div>
    </section>
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
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $error_message ?>
        </div>
        <?php
      $this->session->unset_userdata('error_message');
      }
      ?>
       <section class="content">
       <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag" style="border:3px solid #d7d4d6;">
                    <div class="panel-heading" style="height: 55px;">
                        <div class="panel-title">
                            <div id="bloc2" style="float:left;">
                            </div>
                            <div id="bloc2" style="float:right;">
                                <a href="<?php echo base_url('Ccustomer/manage_customer') ?>?id=<?php echo $_GET['id']; ?>"
                                    class="btnclr btn"><i class="ti-align-justify"> </i>
                                    <?php echo display('manage_customer') ?> </a>
                            </div>
                        </div>
                        
                    </div>
                    <div class="errormessage"></div>
                   <form id="insert_customer_form" name="insert_customer_form" enctype="multipart/form-data">
                    <div class="panel-body">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                 

                                <label for="customer_name"
                                    class="col-sm-4 col-form-label"><?php echo display('Customer Name'); ?> <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name="customer_name" id="customer_name" type="text" placeholder="Customer Name" style="border: 2px solid #d7d4d6;" 
                                        tabindex="1">
                                </div>
                            </div>
                            <div class="form-group row">
                                
                                <label for="customer_type"
                                    class="col-sm-4 col-form-label"><?php echo display('Customer Type'); ?><i class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <select name="customer_type" id="customer_type" class=" form-control"
                                        style="border:2px solid #d7d4d6;" placeholder="Customer Type">
                                        <option value=""></option>
                                        <option value="Distributor"><?php echo display('Distributor'); ?></option>
                                        <option value="Fabricator"><?php echo display('Fabricator'); ?></option>
                                        <option value="Kitchen"><?php echo display('Kitchen'); ?></option>
                                        <option value="Dealer"><?php echo display('Dealer'); ?></option>
                                        <option value="Contractor"><?php echo display('Contractor'); ?></option>
                                        <option value="Builder"><?php echo display('Builder'); ?></option>
                                        <option value="Others"><?php echo display('Others'); ?></option>
                                        <?php foreach ($customertype_detail  as $custype) { ?>
                                        <option value="<?php echo $custype['c_type']; ?>">
                                            <?php echo $custype['c_type']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class=" col-sm-1">
                                    <a href="#" class="client-add-btn btn btnclr" aria-hidden="true" data-toggle="modal"
                                        data-target="#payment_type"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label"><?php echo ('Primary Email '); ?><i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name="email" id="email" type="email" 
                                        style="border: 2px solid #d7d4d6;" placeholder="Primary Email" tabindex="2">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="emailaddress"
                                    class="col-sm-4 col-form-label"><?php echo  display('Secondary Email'); ?> </label>
                                <div class="col-sm-8">
                                    <input class="form-control" name="emailaddress" id="emailaddress" type="email"
                                        style="border: 2px solid #d7d4d6;" placeholder="Secondary Email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mobile"
                                    class="col-sm-4 col-form-label"><?php echo  display('Business Phone'); ?> <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name="phone" id="mobile" type="tel"
                                        style="border: 2px solid #d7d4d6;"  oninput="formatPhoneNumber(this)" placeholder="(XXX) XXX-XXXX"
                                         tabindex="3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="contact"
                                    class="col-sm-4 col-form-label"><?php echo  display('Contact Person'); ?> <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name="contact" id="contact" type="tel"
                                        style="border: 2px solid #d7d4d6;" oninput="formatPhoneNumber(this)" placeholder="(XXX) XXX-XXXX">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mobile" class="col-sm-4 col-form-label">
                                    <?php echo  display('Mobile'); ?></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name="mobile" id="mobile" type="tel"
                                        style="border: 2px solid #d7d4d6;" oninput="formatPhoneNumber(this)" placeholder="(XXX) XXX-XXXX" tabindex="2">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fax" class="col-sm-4 col-form-label"><?php echo  display('Fax'); ?></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name="fax" id="fax" style="border: 2px solid #d7d4d6;"
                                        type="text" placeholder="Fax">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Preferred currency" class="col-sm-4 col-form-label">
                                    <?php echo  display('Preferred currency'); ?><i class="text-danger">&nbsp;*</i></label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="currency" name="currency1" required
                                        style="max-width: -webkit-fill-available; width: 100%; border: 2px solid #d7d4d6;">
                                        <?php $default_currency = 'USD'; ?>
                                        <?php if (!empty($currency_table)) : ?>
                                        <?php foreach ($currency_table as $currency) : ?>
                                        <option value="<?php echo $currency['code']; ?>"
                                            <?php echo ($currency['code'] == $default_currency) ? 'selected' : ''; ?>>
                                            <?php echo $currency['code'] . ' - ' . $currency['description'] . ' - ' . $currency['symbol']; ?>
                                        </option>
                                        <?php endforeach; ?>
                                        <?php else : ?>
                                        <option value="">No currencies found</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div id="pageLoader">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ETA"
                                    class="col-sm-4 col-form-label"><?php echo  display('Attachments'); ?></label>
                                <div class="col-sm-8">
                                    <input type="file" name="file" class="form-control" accept=".pdf, .docx, .txt" >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="address2 "
                                    class="col-sm-4 col-form-label"><?php echo  display('Billing Address'); ?><i
                                        class="text-danger">&nbsp;*</i></label>
                                <div class="col-sm-8">
                                    <textarea class="form-control"  name="address2" id="address2" rows="2"
                                        style="border: 2px solid #d7d4d6;" placeholder="Billing Address"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address "
                                    class="col-sm-4 col-form-label"><?php echo  display('Shipping Address'); ?></label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" name="address" id="address " rows="2"
                                        style="border: 2px solid #d7d4d6;" placeholder="Shipping Address"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="city" class="col-sm-4 col-form-label"><?php echo  display('city'); ?> <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name="city" id="city" type="text"
                                        style="border: 2px solid #d7d4d6;" placeholder="City" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="state" class="col-sm-4 col-form-label"><?php echo  display('state'); ?> <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name="state" id="state" type="text"
                                        style="border: 2px solid #d7d4d6;" placeholder="State" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="zip" class="col-sm-4 col-form-label"><?php echo  display('zip'); ?> <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name="zip" id="zip" type="text"
                                        style="border: 2px solid #d7d4d6;" placeholder="Zip" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="country"
                                    class="col-sm-4 col-form-label"><?php echo  display('country'); ?><i
                                        class="text-danger">&nbsp;*</i></label>
                                <div class="col-sm-8">
                                    <select class="selectpicker countrypicker form-control"
                                        style="width:100%;border: 2px solid #d7d4d6;" data-live-search="true"
                                        data-default="United States" name="country" id="country"></select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="billing_address"
                                    class="col-sm-4 col-form-label"><?php echo display('Payment Terms'); ?><i
                                        class="text-danger">&nbsp;*</i></label>
                                <div class="col-sm-7">
                                    <select name="payment" id="payment_terms" class=" form-control"
                                        placeholder='Payment Terms' style="border: 2px solid #d7d4d6;" >
                                        <option value=""></option>
                                        <option value="" ><?php echo display('Select Payment Terms'); ?>
                                        </option>
                                        <option value="CAD">CAD</option>
                                        <option value="COD">COD</option>
                                        <option value="ADVANCE"><?php echo display('ADVANCE'); ?></option>
                                        <option value="7DAYS">7<?php echo display('DAYS'); ?></option>
                                        <option value="15DAYS">15<?php echo display('DAYS'); ?></option>
                                        <option value="30DAYS">30<?php echo display('DAYS'); ?></option>
                                        <option value="45DAYS">45<?php echo display('DAYS'); ?></option>
                                        <option value="60DAYS">60<?php echo display('DAYS'); ?></option>
                                        <option value="75DAYS">75<?php echo display('DAYS'); ?>S</option>
                                        <option value="90DAYS">90<?php echo display('DAYS'); ?></option>
                                        <option value="180DAYS">180<?php echo display('DAYS'); ?></option>
                                        <?php foreach ($payment_terms as $inv) { ?>
                                        <option value="<?php echo $inv['payment_terms']; ?>">
                                            <?php echo $inv['payment_terms']; ?></option>
                                        <?php    } ?>
                                    </select>
                                </div>
                                <div class="col-sm-1">
                                    <a href="#" class="client-add-btn btn btnclr" aria-hidden="true" data-toggle="modal"
                                        data-target="#payment_type_new"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="previous_balance"
                                    class="col-sm-4 col-form-label"><?php echo display('Credit Limit'); ?> <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name="previous_balance" id="previous_balance"
                                        type="number" min="0" style="border: 2px solid #d7d4d6;"
                                        placeholder="Credit Limit" tabindex="5" >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Open Balance</label>
                                <div class="col-sm-8">
                                    <input name="open_balance" type="number" class="form-control open_balance"
                                        style="border: 2px solid #d7d4d6; " placeholder="0.00"
                                        tabindex="4">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="invoice_no"
                                    class="col-sm-4 col-form-label"><?php echo display('Sales Tax') ?>
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="tax_dropdown" name="tax_status" tabindex="3"
                                        style="border: 2px solid #d7d4d6;" >
                                        <option value="" selected><?php echo display('Select Sales Tax') ?></option>
                                        <option value="1"><?php echo display('NO') ?></option>
                                        <option value="2"><?php echo display('YES') ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row" id="tax">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="sales"
                                            class="col-sm-4 col-form-label"><?php echo ('State Tax') ?></label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="tax" value="" tabindex="3"
                                                style=" width: 100%;border: 2px solid #d7d4d6;">
                                                <option value=""><?php echo display('state') ?></option>
                                                <?php $default_currency = 'USD'; ?>
                                                <?php if (!empty($states)) : ?>
                                                <?php foreach ($states as $state_name) : ?>
                                                <option value="<?php echo $state_name['state_name']; ?>">
                                                    <?php echo $state_name['state_name']; ?>
                                                </option>
                                                <?php endforeach; ?>
                                                <?php else : ?>
                                                <option value="">No currencies found</option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                &nbsp;&nbsp;
                                <div class="form-group row" id="tax">
                                    <div class="col-sm-12">
                                        <label for="sales"
                                            class="col-sm-4 col-form-label"><?php echo  display('Tax Rates') ?> </label>
                                        <div class="col-sm-8">
                                            <input name="taxes" class="form-control taxes" style="text-align: right;"
                                                value="%" placeholder="%"
                                                style="    width: 102%;border: 2px solid #d7d4d6;" tabindex="4">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                          
                                <div class="col-sm-12 text-center">
                                    <label for="example-text-input" class="col-sm-0 col-form-label"></label>
                                    <div class="col-sm-12">
                                        <input type="hidden" name="enc_company_id" id="enc_company_id" value="<?php echo $this->input->get('id'); ?>">
                                        <input type="hidden" name="admin_id" id="admin_id" value="<?php echo $_GET['admin']; ?>">
                                        <input type="submit" id="add-customer" class="btnclr btn btn-large"
                                            name="add-customer" value="Submit" tabindex="7" />
                                          <a href="<?php echo base_url('Ccustomer/manage_customer?id='.$_GET['id']); ?>" class="btn btn-info">Cancel</a>

                                        
                                   
                                </div>
                            </div>
                        </div>
                           <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                          <input type="hidden" name="admin" id="admin" value="<?php echo $admin_id;?>">                     
                        
                        </form>
                    </div>
                </div>
            </div>
            <div id="Customer_modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><?php echo display('customer_csv_upload'); ?></h4>
                        </div>
                        <div class="modal-body">
                            <div class="panel">
                                <div class="panel-heading">
                                    <div><a href="<?php echo base_url('assets/data/csv/customer_csv_sample.csv') ?>"
                                            class="btn btn-primary pull-right"><i
                                                class="fa fa-download"></i><?php echo display('download_sample_file') ?>
                                        </a> </div>
                                </div>
                                <div class="panel-body">
                                    <?php echo form_open_multipart('Ccustomer/uploadCsv_Customer', array('class' => 'form-vertical', 'id' => 'validate', 'name' => 'insert_customer')) ?>
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="upload_csv_file"
                                                class="col-sm-4 col-form-label"><?php echo display('upload_csv_file') ?>
                                                <i class="text-danger">*</i></label>
                                            <div class="col-sm-8">
                                                <input class="form-control" name="upload_csv_file" type="file"
                                                    id="upload_csv_file"
                                                    placeholder="<?php echo display('upload_csv_file') ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                <input type="submit" id="add-product" class="btn btn-primary btn-large"
                                                    name="add-product" value="Submit" />
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal"><?php echo display('close') ?></button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php echo form_close() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>
<div class="modal fade" id="payment_type_new" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="text-align:center">
            <div class="modal-header btnclr">
                <a href="#" class="close" data-dismiss="modal">&times;</a>
                <h4 class="modal-title"><?php echo  ('PAYMENT TERMS') ?></h4>
            </div>
            <div class="modal-body"    style='margin-top: -30px;'>
            <div id="errormessage_paymenttype" class="alert"></div>
                <form id="add_pay_terms" method="post">
                    <div class="panel-body">
                        <input type="hidden" name="csrf_test_name" id=""
                            value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <div class="form-group row">
                            <label for="customer_name" style="width: auto;"
                                class="col-sm-3 col-form-label"><?php echo  ('Payment Terms') ?> <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name="new_payment_terms" id="new_payment_terms" type="text"
                                    placeholder="Add New Payment Terms"  tabindex="1">
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                 <input type="submit" class="btn btnclr" value="<?php echo  display('submit') ?>">
                <a href="#" class="btn btnclr" data-dismiss="modal"><?php echo  display('close') ?></a>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="payment_type" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="text-align:center;width: 600px;margin-left: 440px;">
            <div class="modal-header btnclr">
                <a href="#" class="close" data-dismiss="modal">&times;</a>
                <h4 class="modal-title"><?php echo  ('CUSTOMER TYPE') ?></h4>
            </div>
            <div class="modal-body"    style='margin-top: -30px;'>
                <div id="errormessage_customertype" class="alert"></div>
                <form id="add_customer_type" method="post">
                    <div class="panel-body">
                        <input type="hidden" name="csrf_test_name" id=""
                            value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <div class="form-group row">
                            <label for="customer_name"
                                class="col-sm-4 col-form-label"><?php echo  ('Customer Type') ?> <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name="new_customer_type" id="new_customer_type" type="text"
                                    placeholder=" Add New Customer Type"  tabindex="1">
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                   <input type="submit" class="btn btnclr" value="<?php echo  display('submit') ?>">
                <a href="#" class="btn btnclr" data-dismiss="modal"><?php echo  display('close') ?></a>
          </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
$('#tax_dropdown').on('change', function() {
    if (this.value == '2')
        $("#tax").show();
    else
        $("#tax").hide();
}).trigger("change");
const select = document.querySelectorAll(".currency");
const btn = document.getElementById("btn");
const num = document.getElementById("num");
const ans = document.getElementById("ans");
const err = document.getElementById("errorMSG");
const info = document.getElementById("info");
const baseFlagsUrl = "https://wise.com/public-resources/assets/flags/rectangle";
const currencyApiUrl = "https://open.er-api.com/v6/latest";
document.addEventListener('DOMContentLoaded', function() {
    fetch(currencyApiUrl)
        .then((data) => data.json())
        .then((data) => {
            err.innerHTML = "";
            display(data.rates);
            $('.currency').select2({
                width: 'resolve',
                templateResult: formatFlags,
                templateSelection: formatCountry,
                maximumInputLength: 3
            });
            info.innerHTML = "Result: " + data.result + "<br>Provider: " + data.provider +
                "<br>Documentation: " + data.documentation + "<br>Terms of use: " + data.terms_of_use +
                "<br>Time Last Update UTC: " + data.time_last_update_utc;
            $('#pageLoader').fadeOut();
        }).catch(function(error) {
            err.innerHTML = "Error: " + error;
            $('#pageLoader').fadeOut();
        });
    $('.currency').on('select2:select', function(e) {
        let currency1 = select[0].value;
        let currency2 = select[1].value;
        let num1 = num.value;
        convert(currency1, currency2, num1)
    });
}, false);
function display(data) {
    const entries = Object.entries(data);
    for (var i = 0; i < entries.length; i++) {
        select[0].innerHTML += `<option value="${entries[i][0]}">${entries[i][0]}</option>`;
        select[1].innerHTML += `<option value="${entries[i][0]}">${entries[i][0]}</option>`;
    }
    if ($('#currency2').find("option[value='CLP']").length) {
        $('#currency2').val('CLP').trigger('change');
        $('#num').val(1);
        let currency1 = select[0].value;
        let currency2 = select[1].value;
        let num1 = num.value;
        convert(currency1, currency2, num1)
    }
}
function formatFlags(country) {
    if (!country.id) {
        return country.text;
    }
    var $countryFlag = $('<span><img src="' + baseFlagsUrl + '/' + country.element.value.toLowerCase() +
        '.png" class="img-flag" /> ' + country.text + '</span>');
    return $countryFlag;
}
function formatCountry(country) {
    if (!country.id) {
        return country.text;
    }
    var $countryFlag = $('<span><img class="img-flag"/> <span></span></span>');
    $countryFlag.find("span").text(country.text);
    $countryFlag.find("img").attr("src", baseFlagsUrl + "/" + country.element.value.toLowerCase() + ".png");
    return $countryFlag;
}
function convert(currency1, currency2, value) {
    fetch(`${currencyApiUrl}/${currency1}`)
        .then((val) => val.json())
        .then((val) => {
            console.log('Converting ' + currency1 + ' to ' + currency2);
            var res = val.rates[currency2] * value
            ans.value = res.toFixed(2);
            err.innerHTML = "";
        }).catch(function(error) {
            err.innerHTML = "Error: " + error;
        });
}
 var succalert = '<div class="alert alert-success alert-dismissible" role="alert">';
        var failalert = '<div class="alert alert-danger alert-dismissible" role="alert">';
        var alert2 = '<button type="button" style="margin-top: -20px;" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
$('#add_pay_terms').submit(function(e) {
    e.preventDefault();
    var data = {
        new_payment_terms: $('#new_payment_terms').val()
    };
    data[csrfName] = csrfHash;
    $.ajax({
        type: 'POST',
        data: data,
        dataType: "json",
        url: '<?php echo base_url(); ?>Cpurchase/add_payment_terms',
        success: function(response, status) {
    console.log(response); 
    $('#errormessage_paymenttype').html("");
    if (response.status == 'success') {
        $('#payment_terms').empty();
  $.each(response.data, function(index, item) {
            var option = '<option value="' + item.payment_terms + '">' + item.payment_terms + '</option>';
            $('#payment_terms').append(option);
        });
  var newlyAddedType = response.data[response.data.length - 1].payment_terms; 
        $('#payment_terms').val(newlyAddedType);
        if (!$('#payment_terms').data('ui-selectmenu')) {
            $('#payment_terms').selectmenu();
        }
   $('#payment_terms').selectmenu('refresh', true);
        $('#payment_terms').show();
       $('#errormessage_paymenttype').html(succalert + response.msg + alert2);
 window.setTimeout(function() {
            $('#payment_type_new').modal('hide');
        }, 2500);
    } else {
       $('#errormessage_paymenttype').html(failalert + response.msg + alert2);
    }
}
    });
});
 $("#add_customer_type").validate({
   rules: {
     new_customer_type: "required",
   },
   messages: {
     new_customer_type: "Customer Type is required",
   },
   errorPlacement: function (error, element) {
     if (element.hasClass("select2-hidden-accessible")) {
       error.insertAfter(element.next("span.select2"));
     } else {
       error.insertAfter(element);
     }
   },
   submitHandler: function (form, event) {
     event.preventDefault();
     var formData = new FormData(form);
     formData.append(csrfName, csrfHash);
     $.ajax({
       type: "POST",
       url: "<?php echo base_url(); ?>Ccustomer/add_customertype_new",
       data: formData,
       dataType: "json",
       contentType: false,
       processData: false,
       success: function (response) {
         console.log(response);
         $("#errormessage_customertype").html("");
         if (response.status == "success") {
           $("#customer_type").empty();
           $.each(response.data, function (index, item) {
             var option =
               '<option value="' +
               item.c_type +
               '">' +
               item.c_type +
               "</option>";
             $("#customer_type").append(option);
           });
           var newlyAddedType = response.data[response.data.length - 1].c_type;
           $("#customer_type").val(newlyAddedType);
           if (!$("#customer_type").data("ui-selectmenu")) {
             $("#customer_type").selectmenu();
           }
           $("#customer_type").selectmenu("refresh", true);
           $("#customer_type").show();
           $("#errormessage_customertype").html(
             succalert + response.msg + alert2
           );
           window.setTimeout(function () {
             $("#payment_type").modal("hide");
           }, 2500);
         } else {
           $("#errormessage_customertype").html(
             failalert + response.msg + alert2
           );
         }
       },
       error: function (xhr, status, error) {
         console.error("AJAX error:", status, error);
       },
     });
   },
 });


    $.validator.addMethod("trimRequired", function(value, element) {
        return $.trim(value) !== "";
    }, "This field is required.");

    $("#insert_customer_form").validate({
        rules: {
            customer_name: "trimRequired",
            customer_type: "required",
            email: "required",
            phone: "required",
            contact: "required",
			address2: "trimRequired",
            city: "required",
            state: "required",
            zip: "required",
            country: "required",
			payment: "required",
			previous_balance: "required",
			tax_status: "required",
			
        },
        messages: {
            customer_name: "Customer Name is required",
            customer_type: "Customer Type is required",
           email : "Email is required" ,
            phone : "Phone is required",
            contact : "Contact is required",
			address2 : "Address is required",
            state : "State is required",
			zip : "Zip is required",
            country : "Country is required",
			payment : "Payment is required",
            previous_balance : "Previous Balance is required",
			tax_status : "Tax Status is required"
        },
        errorPlacement: function(error, element) {
            if (element.hasClass("select2-hidden-accessible")) {
                error.insertAfter(element.next('span.select2')); 
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            event.preventDefault();
            var formData = new FormData(form);
            formData.append(csrfName, csrfHash);
            formData.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
                $.ajax({
                    type:"POST",
                    url:'<?php echo base_url('Ccustomer/insert_customer'); ?>',
                    dataType: "json",
                    contentType: false,
                    processData: false, 
                    data: formData,
                    success:function (response) {
                        console.log(response);
                        if (response.status == 'success') {
                            $('.errormessage').html(succalert + response.msg + alert2);
                            setTimeout(function() {
                                window.location.href = "<?php echo base_url('Ccustomer/manage_customer') ?>?id=<?php echo $_GET['id']; ?>";
                            }, 2500);

                        } else if (response.status == 'failure') {
                            $('.errormessage').html(failalert + response.msg + alert2);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            event.preventDefault();
        }
    });
</script>
