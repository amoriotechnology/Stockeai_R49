<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/daterangepicker.css" />
<div class="content-wrapper">
   <section class="content-header" style='height:60px;'>
      <div class="header-icon">
<img src="<?php echo base_url()  ?>asset/images/sales.png"  class="headshotphoto" style="height:50px;" />
      </div>
          <div class="header-title">
          <div class="logo-holder logo-9">
          <h1>  <?php echo display('manage_invoice') ?></h1>
       </div>
      
         <ol class="breadcrumb"   style=" border: 3px solid #d7d4d6;"   >
            <li><a href="<?php   echo base_url(); ?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
            <li><a href="#"><?php echo display('invoice') ?></a></li>
            <li class="active" style="color:orange;"><?php echo display('manage_invoice') ?></li>
    </ol>
      </div>
   </section>
   <section class="content">
       <div class="panel panel-bd lobidrag">
         <div class="panel-heading" style="height: 60px;border: 3px solid #D7D4D6;">
            <div class="col-sm-12">
             <div class="col-sm-4" style="display: flex; align-items: left; ">
              <?php foreach($this->session->userdata('perm_data') as $test) {
            $split = explode('-', $test);
            if (trim($split[0]) == 'sales' && $_SESSION['u_type'] == 3 && trim($split[1]) == '1000') {
                ?>
                         <a href="<?php echo base_url('Cinvoice').'?id='.urlencode($_GET['id'])?>" class="btnclr btn btn-default dropdown-toggle boxes filip-horizontal mobile_para"   style="height:fit-content;"  ><i class="far fa-file-alt"> </i> <?php echo display('Create Sale') ?> </a>
                <?php break;
            }
        }
        if ($_SESSION['u_type'] == 2) { ?>
                                 <a href="<?php echo base_url('Cinvoice').'?id='.urlencode($_GET['id'])?>" class="btnclr btn btn-default dropdown-toggle boxes filip-horizontal mobile_para"   style="height:fit-content;"  ><i class="far fa-file-alt"> </i> <?php echo display('Create Sale') ?> </a>
        <?php } ?>
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
       <div class="error_display"></div>
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-body">
                            <div id="dataTableExample3">
                                <table class="table table-bordered" cellspacing="0" width="100%" id="invoice">
                                    <thead>

                                    <tr class="btnclr">
                                            <th width="5%">S.No</th>
                                            <th width="7%">Invoice Number</th>
                                            <th width="7%">Invoice Id</th>
                                            <th width="10%">Customer Name</th>
                                            <th width="7%">Payment Term</th>
                                            <th width="8%">Payment Due Date</th>
                                            <th width="7%">Payment Type</th>
                                            <th width="7%">Tax Details</th>
                                            <th width="7%">Total Amount</th>
                                            <th width="7%">Paid Amount</th>
                                            <th width="7%">Due Amount</th>
                                            <th width="7%">Created Date</th>
                                           
                                            <th width="7%">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
  <script>
            $(document).ready(function() {
                var invoicetable;
                if ($.fn.DataTable.isDataTable('#invoice')) {
                    $('#invoice').DataTable().clear().destroy();
                }
                var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
                var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
           invoicetable=     $('#invoice').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "lengthMenu": [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    "ajax": {
                        "url": "<?php echo base_url('Cinvoice/getinvoiceDatas?id='); ?>" +
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
                        { "data": "sl" },
                        {
                            "data": "commercial_invoice_number"
                        },
                        {
                            "data": "invoice_id"
                        },
                        {
                            "data": "customer_id"
                        },
                        {
                            "data": "payment_terms"
                        },
                        {
                            "data": "payment_due_date"
                        },
                        {
                            "data": "payment_type"
                        },
                        {
                            "data": "total_tax"
                        },
                        {
                            "data": "gtotal"
                        },
                        {
                            "data": "paid_amount"
                        },
                        {
                            "data": "due_amount"
                        },
                        {
                            "data": "created_date"
                        },
                        {
                            "data": "action"
                        },
                    ],
                    "columnDefs": [{
                        "orderable": false,
                        "targets": [0, 12],
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
                        localStorage.setItem('invoice', JSON.stringify(data));
                    },
                    "stateLoadCallback": function(settings) {
                        var savedState = localStorage.getItem('invoice');
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
                                        '<div style="text-align:center;"><h3>Manage Sale</h3></div>'
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
        invoicetable.ajax.reload();
    });
            });
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
function deleteInvoicedata(id) 
{
    var succalert = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
    
    var failalert = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
    if (id !== "") {
        var confirmDelete = confirm("Are you sure you want to delete this invoice?");
    
        if (confirmDelete) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo base_url(); ?>Cinvoice/InvoiceDeleteInvoice",
                data: {[csrfName]: csrfHash, id: id},
                success: function(response) {
                    console.log(response, "response");
                    if (response.status === 'success') {
                        $('.error_display').html(succalert + response.msg + '</div>');
                        window.setTimeout(function() {
                            invoicetable.ajax.reload(null, false);
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
