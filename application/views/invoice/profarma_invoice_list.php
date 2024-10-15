<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/daterangepicker.css" />
<div class="content-wrapper">
   <section class="content-header" style="height: 60px;">
      <div class="header-icon">
         <figure class="one">
            <img src="<?php echo base_url() ?>asset/images/quota.png" class="headshotphoto" style="height:50px;" />
         </figure>
      </div>
      <div class="header-title">
         <div class="logo-holder logo-9">
         <h1><?php echo display('manage_quotation') ?></h1>
         </div>
            <ol class="breadcrumb" style=" border: 3px solid #d7d4d6;" >
                <li><a href="javascript:void(0);"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="javascript:void(0);"><?php echo display('invoice') ?></a></li>
                <li class="active" style="color:orange;"><?php echo display('manage_quotation') ?></li>
            <div class="load-wrapp">
               <div class="load-10">
                  <div class="bar"></div>
               </div>
            </div>
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
      <?php $this->session->unset_userdata('message'); }
         $error_message = $this->session->userdata('error_message');
         if (isset($error_message)) {
      ?>
      <div class="alert alert-danger alert-dismissable">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         <?php echo $error_message ?>                    
      </div>
      <?php $this->session->unset_userdata('error_message');}?>
      <div class="panel panel-bd lobidrag">
         <div class="panel-heading" style="height: 60px;border: 3px solid #D7D4D6;">
            <div class="col-sm-12">
             <div class="col-sm-6" style="display: flex; align-items: left; ">
               <?php foreach(  $this->session->userdata('perm_data') as $test){
                $split=explode('-',$test);
                if(trim($split[0])=='quotation' && $_SESSION['u_type'] ==3 && trim($split[1])=='1000'){
                   ?>
                  <a href="<?php echo base_url('Cinvoice/profarma_invoice?id=' . $_GET['id']); ?>" class="btnclr btn btn-default dropdown-toggle" style="height: fit-content;"><i class="far fa-file-alt"></i> <?php echo display('create'); ?> <?php echo display('quotation'); ?></a>
                  <a  class="btnclr btn btn-default dropdown-toggle"  style=" height:fit-content;"  id="s_icon"><b class="fa fa-search"></b>&nbsp;Advance search  </a> 
                  <?php break;}} 
                  if($_SESSION['u_type'] ==2){ ?>
                 <a href="<?php echo base_url('Cinvoice/profarma_invoice?id=' . $_GET['id']); ?>" class="btnclr btn btn-default dropdown-toggle" style="height: fit-content;"><i class="far fa-file-alt"></i> <?php echo display('create'); ?> <?php echo display('quotation'); ?></a>
               <?php  } ?>
               </div>
               <div class="col-md-6 col-sm-6">
                   <!-- <input type="text" class="form-control dateSearch" style="padding: 5px;width: 175px;border-radius: 8px;height: 35px;" id="reportrange"> -->
                    <div class="search">
                      <span class="fa fa-search"></span>
                      <input class="dateSearch" placeholder="Search term" id="reportrange">
                    </div>
               </div>
            </div>   
         </div>
         <div class="row">
            <div class="col-sm-12">
               <div class="error_display mb-2"></div>
               <div class="panel panel-bd lobidrag">
                  <div class="panel-body" style="border: 3px solid #D7D4D6;">
                     <table class="table table-bordered" cellspacing="0" width="100%" id="quotation_list">
                        <thead>
                           <tr class="btnclr">
                              <th><?php echo 'S.No'; ?></th>
                              <th><?php echo display('Invoice No') ?></th>
                              <th><?php echo display('Pre Carriage') ?></th>
                              <th><?php echo display('Country goods') ?></th>
                              <th><?php echo display('Country Destination') ?></th>
                              <th><?php echo display('Loading') ?></th>
                              <th><?php echo display('Discharge') ?></th>
                              <th><?php echo display('Terms payment') ?></th>
                              <th><?php echo display('Description goods') ?></th>
                              <th><?php echo display('Overall Gross') ?></th>
                              <th><?php echo display('Amount Paid') ?></th>
                              <th><?php echo display('Due Amount') ?></th>
                              <th><?php echo display('Total Amount') ?></th>
                              <th><?php echo display('Date') ?></th>
                              <th><?php echo display('Buyer / Customer') ?></th>
                              <th><?php echo display('Tax Details') ?></th>
                              <th><?php echo display('Grand Total') ?></th>
                              <th><?php echo display('Action') ?></th>
                           </tr>
                        </thead>
                     </table>
                  </div>
               </div>     
            </div>
         </div>
      </div>
   </section>
</div>

<?php 
$modaldata['bootstrap_model'] = array('sendemailmodal');
$this->load->view('include/bootstrap_model', $modaldata); 
?>
<script type="text/javascript">
var quotationDataTable;
$(document).ready(function() {
$(".sidebar-mini").addClass('sidebar-collapse') ;
    if ($.fn.DataTable.isDataTable('#quotation_list')) {
        $('#quotation_list').DataTable().clear().destroy();
    }
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    quotationDataTable = $('#quotation_list').DataTable({
        "processing": true,
        "serverSide": true,
        "lengthMenu": [
            [10, 25, 50, 100],
            [10, 25, 50, 100]
        ],
        "ajax": {
            "url": "<?php echo base_url('Cinvoice/getQuotationData?id='); ?>" +
                encodeURIComponent('<?php echo $_GET['id']; ?>'),
            "type": "POST",
            "data": function(d) {
                d['<?php echo $this->security->get_csrf_token_name(); ?>'] =
                    '<?php echo $this->security->get_csrf_hash(); ?>';
                d.date = $('.dateSearch').val();
            },
            "dataSrc": function(json) {
               csrfHash = json[
                    '<?php echo $this->security->get_csrf_token_name(); ?>'];
                return json.data;
            }
        },
         "columns": [
         { "data": "id" },
         { "data": "purchase_id" },
         { "data": "pre_carriage" },
         { "data": "country_goods" },
         { "data": "country_destination" },
         { "data": "loading" },
         { "data": "discharge" },
         { "data": "terms_payment" },
         { "data": "description_goods" },
         { "data": "total_gross" },
         { "data": "amt_paid" },
         { "data": "bal_amt" },
         { "data": "total" },
         { "data": "purchase_date" },
         { "data": "customer_name" },
         { "data": "tax_details" },
         { "data": "gtotal" },
         { "data": "action" }
         ],
        "columnDefs": [{
            "orderable": false,
            "targets": [0, 17],
            searchBuilder: {
                defaultCondition: '='
            },
            "initComplete": function() {
                this.api().columns().every(function() {
                    var column = this;
                    var select = $(
                            '<select><option value=""></option></select>'
                        )
                        .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util
                                .escapeRegex(
                                    $(this).val()
                                );
                            column.search(val ? '^' + val + '$' :
                                '', true, false).draw();
                        });
                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d +
                            '">' + d + '</option>')
                    });
                });
            },
        }],
        "pageLength": 10,
        "colReorder": true,
        "stateSave": true,
        "stateSaveCallback": function(settings, data) {
            localStorage.setItem('quotation', JSON.stringify(data));
        },
        "stateLoadCallback": function(settings) {
            var savedState = localStorage.getItem('quotation');
            return savedState ? JSON.parse(savedState) : null;
        },
        "dom": "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "buttons": [{
                "extend": "copy",
                "className": "btn-sm",
                "exportOptions": {
                    "columns": ':visible'
                }
            },
            {
                "extend": "csv",
                "title": "Report",
                "className": "btn-sm",
                "exportOptions": {
                    "columns": ':visible'
                }
            },
            {
                "extend": "pdf",
                "title": "Report",
                "className": "btn-sm",
                "exportOptions": {
                    "columns": ':visible'
                }
            },
            {
                "extend": "print",
                "className": "btn-sm",
                "exportOptions": {
                    "columns": ':visible'
                },
                "customize": function(win) {
                    $(win.document.body)
                        .css('font-size', '10pt')
                        .prepend(
                            '<div style="text-align:center;"><h3>Manage Quotation</h3></div>'
                        )
                        .append(
                            '<div style="text-align:center;"><h4>amoriotech.com</h4></div>'
                        );
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                    var rows = $(win.document.body).find('table tbody tr');
                    rows.each(function() {
                        if ($(this).find('td').length === 0) {
                            $(this).remove();
                        }
                    });
                    $(win.document.body).find('div:last-child')
                        .css('page-break-after', 'auto');
                    $(win.document.body)
                        .css('margin', '0')
                        .css('padding', '0');
                }
            },
            {
               "extend": "colvis",
               "className": "btn-sm"
            }
        ]
    });
    
    $('.dateSearch').on('change', function() {
        quotationDataTable.ajax.reload();
    });
});


// Send Email Modal - Madhu
function sendEmailproforma(id)
{
   $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url('Cinvoice/get_customer'); ?>",
        data: {[csrfName]: csrfHash, id: id},
        success: function(response){
            console.log(response);
          if(response.status == 'success'){
            $('.customerEmail').val(response.data[0]['primary_email']);
            $('.getproformaId').val(response.data[0]['purchase_id']);
          }else{
            console.log("No Data Found");
          }
        },
        error: function(xhr, status, error) {
            console.log(error, "Error");
        }
   });
}

// Delete Profoma Data - Madhu
function deleteProformadata(id) 
{
    var succalert = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
    
    var failalert = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
    if (id !== "") {
        var confirmDelete = confirm("Are you sure you want to delete this quotation?");
    
        if (confirmDelete) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo base_url(); ?>Cinvoice/profarmaDeleteInvoice",
                data: {[csrfName]: csrfHash, id: id},
                success: function(response) {
                    console.log(response, "response");
                    if (response.status === 'success') {
                        $('.error_display').html(succalert + response.msg + '</div>');
                        window.setTimeout(function() {
                            quotationDataTable.ajax.reload(null, false);
                            $('.error_display').html('');
                        }, 2500);
                    } else {
                        $('.error_display').html(failalert + response.msg + '</div>'); 
                    }
                },
                error: function() {
                    $('.error_display').html(failalert + 'An unexpected error occurred. Please try again.' + '</div>');
                }
            });
        }
    }
}


// Date Picker - Madhu
$(function() {
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },

        locale: {
            format: 'YYYY-MM-DD'
        }
    }, cb);

    cb(start, end);
});

</script>

<style type="text/css">
.search {
position: relative;
color: #aaa;
font-size: 16px;
}

.search {display: inline-block;}

.search input {
  width: 260px;
  height: 34px;

  background: #fff;
  border: 1px solid #fff;
  border-radius: 5px;
  box-shadow: 0 0 3px #ccc, 0 10px 15px #fff inset;
  color: #000;
}

.search input { text-indent: 32px;}
.search .fa-search { 
  position: absolute;
  top: 8px;
  left: 10px;
}

.search .fa-search {left: auto; right: 10px;}
</style>
