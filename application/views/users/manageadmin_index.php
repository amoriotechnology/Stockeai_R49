<?php error_reporting(1);  ?>
<script src="<?php echo base_url() ?>my-assets/js/admin_js/account.js" type="text/javascript"></script>
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
     <div class="content-wrapper">
        <section class="content-header">
            <div class="header-icon"> <i class="pe-7s-note2"></i> </div>
            <div class="header-title">
                 <h1>Manage Admin</h1>
                <small></small>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url(); ?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                    <li class="active" style="color:orange;">Manage Admin</li>
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
<div class="panel panel-bd lobidrag">
            <div class="panel-heading" style="height: 60px;border: 3px solid #D7D4D6;">
            <div class="col-sm-18">
            <div class="col-sm-6" style="display: flex; align-items: left;">
            <div class="col-sm-12">
            <a href="<?php echo base_url('User/adadmin')?>"   style="background-color:#424f5c; color:#fff;" class="btnclr btn"><i class="ti-align-justify"> </i>Add Admin</a>
            </div>
            </div>
        </div>
        </div>
<div class="row">
   <div class="col-sm-12">
      <div class="panel panel-bd lobidrag">
      <div class="panel-body" style="    border: 3px solid #D7D4D6;">
                  <div id="dataTableExample3">
                           <table class="table table-bordered"  cellspacing="0" width="100%" id="addadminList">                             
                            <thead>     
                            <tr  style="background-color:#424f5c; color:#fff;">
                                 <th>S.NO</th>
                            <th>Company Name</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Action</th>      
                            </tr>
                            </thead>
                            </table>
                            </div>
                        </div>
                     </div>
                  </div>
<script>
  $(document).ready(function() {
         if ($.fn.DataTable.isDataTable('#addadminList')) {
            $('#addadminList').DataTable().clear().destroy();
        }
         var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
         var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
        $('#addadminList').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu":[[10,25,50,100],[10,25,50,100]],
            "ajax": {
                "url": "<?php echo base_url('user/getAdminDatas'); ?>",
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
                { "data": "company_id" },
               { "data": "company_name" },
                { "data": "username" },
                { "data": "email_id" },
                { "data": "action" },
            ],
             "columnDefs": [
                    { "orderable": false, "targets": [0, 4] } 
            ],
            "pageLength": 10,
            "colReorder": true, 
            "stateSave": true, 
            "stateSaveCallback": function(settings, data) {
                localStorage.setItem('superadmin_adminuser', JSON.stringify(data));
            },
            "stateLoadCallback": function(settings) {
                var savedState = localStorage.getItem('superadmin_adminuser');
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
                "title": "Report",
                "className": "btn-sm",
                "exportOptions": { "columns": ':visible' }
            },
            {
                "extend": "pdf",
                "title": "Report",
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
                        .prepend('<div style="text-align:center;"><h3>Manage company</h3></div>')
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
