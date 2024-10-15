<?php error_reporting(1);  ?>
<div class="content-wrapper">
    <section class="content-header" style="height: 65px;">
        <div class="header-icon">
            <figure class="one">
            <img src="<?php echo base_url()  ?>asset/images/timesheet.png"  class="headshotphoto" style="height:50px;" />
         </div>
        <div class="header-title">
            <div class="logo-holder logo-9">
                <h1><strong><?php echo  ('Manage Time Sheet')  ?></strong></h1>
            </div>
            <ol class="breadcrumb" style=" border: 3px solid #d7d4d6;">
                <li><a href="<?php echo base_url(); ?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a>
                </li>
                <li class="active" style="color:orange;"><?php echo  ('Manage Time Sheet') ?></li>
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
        <div class="alert alert-info alert-dismissable" style="border-color: #d6e9c6; color: #3c763d ;background-color:#dff0d8;font-weight:bold;width:96%;margin-left:32px;">
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
       <div class="panel panel-bd lobidrag">
            <div class="panel-heading" style="height: 60px;border: 3px solid #D7D4D6; ">
                <div class="col-sm-18">
                    <div class="col-sm-6" style="display: flex; align-items: left;">
                       <div class="col-sm-4" style="display: flex; justify-content: space-between; align-items: left;">
                        <?php  foreach(  $this->session->userdata('perm_data') as $test){
                        $split=explode('-',$test);
                        if(trim($split[0])=='hrm' && $_SESSION['u_type'] ==3 && trim($split[1])=='1000'){  ?>
                        <a href="<?php echo base_url('Chrm/add_timesheet?id='.$_GET['id']); ?>" class="btn btnclr dropdown-toggle" style="color:white;border-color: #2e6da4;height: fit-content;"><i class="far fa-file-alt"> </i> <?php echo ('Add Time Sheet') ?></a>
           <?php break;}} 
                        if($_SESSION['u_type'] ==2){ ?>
                        <a href="<?php echo base_url('Chrm/add_timesheet?id='.$_GET['id']); ?>" class="btn btnclr dropdown-toggle" style="color:white;border-color: #2e6da4;height: fit-content;"><i class="far fa-file-alt"> </i> <?php echo ('Add Time Sheet') ?></a>
                        <?php  } ?>
                          </div>
                       </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-body">
                            <div id="dataTableExample3">
                                <table class="table table-bordered" cellspacing="0" width="100%" id="timesheet_list">
                                    <thead>
                                        <tr style="background-color: #424f5c;color:#fff;">
                                            <th width="2%">S.No</th>                               
                                            <th width="10%">Employee Name</th>
                                            <th width="8%">Job title</th>
                                            <th width="8%">Payroll Type</th>
                                            <th width="7%">  month</th>
                                            <th width="7%">Payslip Status</th>
                                             <th width="7%"><?php echo display('action') ?></th>
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
         if ($.fn.DataTable.isDataTable('#timesheet_list')) {
            $('#timesheet_list').DataTable().clear().destroy();
        }
         var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
         var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
        $('#timesheet_list').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu":[[10,25,50,100],[10,25,50,100]],
            "ajax": {
                 "url": "<?php echo base_url('Chrm/getTimesheetDatas?id='); ?>" +encodeURIComponent('<?php echo $_GET['id']; ?>'),
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
                 { "data": "payroll_type" },
                 { "data": "month" },          
                 {  "data": "uneditable" },
                 { "data": "action" },
            ],
            "columnDefs": [
                    { "orderable": false, "targets": [0, 6] } 
            ],
            "pageLength": 10,
            "colReorder": true, 
            "stateSave": true, 
            "stateSaveCallback": function(settings, data) {
                localStorage.setItem('timesheet', JSON.stringify(data));
            },
            "stateLoadCallback": function(settings) {
                var savedState = localStorage.getItem('timesheet');
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
                "title": "Timesheet Info",
                "className": "btn-sm",
                "exportOptions": { "columns": ':visible' }
            },
            {
                "extend": "pdf",
                "title": "Timesheet Info",
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
 