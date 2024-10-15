<?php error_reporting(1);  ?>
<div class="content-wrapper">
    <section class="content-header" style="height: 65px;">
        <div class="header-icon">
            <figure class="one">
             <img src="<?php echo base_url()  ?>asset/images/payslip.png"  class="headshotphoto" style="height:50px;" />
         </div>
        <div class="header-title">
            <div class="logo-holder logo-9">
                <h1><strong><?php echo  ('Generated Pay Slips List')  ?></strong></h1>
            </div>
            <ol class="breadcrumb" style=" border: 3px solid #d7d4d6;">
            <li><a href="<?php echo base_url(); ?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a>
                </li>
                 <li class="active" style="color:orange">Generated Pay Slips List</li>
                <div class="load-wrapp">
                    <div class="load-10">
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
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-body">
                            <div id="dataTableExample3">
                                <table class="table table-bordered" cellspacing="0" width="100%" id="payslip_list">
                                    <thead>
                                        <tr style="background-color: #424f5c;color:#fff;">
                                            <th width="5%">S.No</th>
                                            <th width="7%">Employee Name</th>
                                            <th width="7%">Job Title</th>
                                            <th width="10%">Month</th>
                                            <th width="7%">Total Hours/ Days</th>
                                            <th width="8%">Total Amount</th>
                                            <th width="7%">Over Time</th>
                                            <th width="7%">Sales Commission</th>
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
         if ($.fn.DataTable.isDataTable('#payslip_list')) {
            $('#payslip_list').DataTable().clear().destroy();
        }
         var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
         var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
        $('#payslip_list').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu":[[10,25,50,100],[10,25,50,100]],
            "ajax": {
                 "url": "<?php echo base_url('Chrm/getPayslipDatas?id='); ?>" +encodeURIComponent('<?php echo $_GET['id']; ?>'),
                "type": "POST",
               "data": function(d) {
                  d['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
               },
               "dataSrc": function(json) {
                   csrfHash = json['<?php echo $this->security->get_csrf_token_name(); ?>'];
                  return json.data;
               }
            },
            "columns": [
                 { "data": "id" },
                  { "data": "first_name" },
                 { "data": "job_title" },
                 { "data": "month" },
                 { "data": "total_hours" },
                 { "data": "total" },
                 { "data": "extra_this_hour" },
                 { "data": "sales_c_amount" },
                  { "data": "action" },
            ],
            "columnDefs": [
                    { "orderable": false, "targets": [0, 6] } 
            ],
            "pageLength": 10,
            "colReorder": true, 
            "stateSave": true, 
            "stateSaveCallback": function(settings, data) {
                localStorage.setItem('Payslip', JSON.stringify(data));
            },
            "stateLoadCallback": function(settings) {
                var savedState = localStorage.getItem('Payslip');
                return savedState ? JSON.parse(savedState) : null;
            },
           "dom": "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            "buttons": [
            {
                "extend": "copy",
                "className": "btn-sm",
                "exportOptions": { "columns": ':visible' }
            },
            {
                "extend": "csv",
                "title": "Payslip",
                "className": "btn-sm",
                "exportOptions": { "columns": ':visible' }
            },
            {
                "extend": "pdf",
                "title": "Payslip",
                "className": "btn-sm",
                "exportOptions": { "columns": ':visible' }
            },
            {
                "extend": "print",
                "className": "btn-sm",
                "exportOptions": { "columns": ':visible' },
                "customize": function(win) {
                    $(win.document.body)
                        .css('font-size', '10pt')
                        .prepend('<div style="text-align:center;"><h3>Manage Employee</h3></div>')
                        .append('<div style="text-align:center;"><h4>amoriotech.com</h4></div>');
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
            { "extend": "colvis", "className": "btn-sm" }
        ]
        });
    });
</script>
 