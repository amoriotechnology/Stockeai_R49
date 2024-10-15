<?php error_reporting(1);  ?>
<div class="content-wrapper">
    <section class="content-header" style="height: 65px;">
        <div class="header-icon">
        <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <div class="logo-holder">
            <h1><?php echo display('manage_company') ?></h1>
         <small></small>
         <ol class="breadcrumb">
            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
            <li><a href="#"><?php echo display('web_settings') ?></a></li>
            <li class="active" style="color:orange;" ><?php echo display('manage_company') ?></li>
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
                       <a href="<?php echo base_url('company_setup/company_branch?id='.$_GET['id']); ?>" class="btnclr btn m-b-5 m-r-2" style="color:white;" ><i class="ti-plus"> </i> <?php echo display('Add Company') ?>  </a>

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
                                <table class="table table-bordered" cellspacing="0" width="100%" id="company_list">
                                    <thead>
                                        <tr style="background-color: #424f5c;color:#fff;">
                                            <th width="2%">S.No</th>                               
                                            <th width="10%"><?php echo display('name') ?></th>
                                            <th width="8%"><?php echo display('address') ?></th>
                                            <th width="8%"><?php echo display('mobile') ?></th>
                                            <th width="7%"><?php echo display('City') ?></th>
                                            <th width="7%"><?php echo display('State') ?></th>
                                            <th width="7%"><?php echo display('website') ?></th>
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
         if ($.fn.DataTable.isDataTable('#company_list')) {
            $('#company_list').DataTable().clear().destroy();
        }
         var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
         var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
        $('#company_list').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu":[[10,25,50,100],[10,25,50,100]],
            "ajax": {
                 "url": "<?php echo base_url('Company_setup/getCompanyDatas?id='); ?>" +encodeURIComponent('<?php echo $_GET['id']; ?>'),
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
                 { "data": "company_name" },
                 { "data": "address" },
                 { "data": "mobile" },
                 { "data": "c_city" },          
                 {  "data": "c_state" },
                 {  "data": "website" },
                 { "data": "action" },
            ],
            "columnDefs": [
                    { "orderable": false, "targets": [0, 7] } 
            ],
            "pageLength": 10,
            "colReorder": true, 
            "stateSave": true, 
            "stateSaveCallback": function(settings, data) {
                localStorage.setItem('managecompany', JSON.stringify(data));
            },
            "stateLoadCallback": function(settings) {
                var savedState = localStorage.getItem('managecompany');
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
                "title": "Manage Company",
                "className": "btn-sm",
                "exportOptions": { "columns": ':visible' }
            },
            {
                "extend": "pdf",
                "title": "Manage Company",
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
                        .prepend('<div style="text-align:center;"><h3>Manage Company</h3></div>')
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
 