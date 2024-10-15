<?php error_reporting(1);  ?>
<style>
.Row {
    display: table;
    width: 100%; 
    table-layout: fixed; 
    border-spacing: 5px;
}
.Column {
    display: table-cell;
}
  </style>
<div class="content-wrapper">
    <section class="content-header"  style="height: 60px;">
        <div class="header-icon">
           <figure class="one">
               <img src="<?php echo base_url()  ?>asset/images/product.png"  class="headshotphoto" style="height:50px;" />
      </div>
          <div class="header-title">
          <div class="logo-holder logo-9">
          <h1>  <?php echo display('manage_product') ?></h1>
       </div>
            <ol class="breadcrumb" style=" border: 3px solid #d7d4d6;" >
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('product') ?></a></li>
                <li class="active" style="color:orange;"><?php echo display('manage_product') ?></li>
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
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $message ?>                    
            </div>
            <?php
            $this->session->unset_userdata('message');
        }
        $error_message = $this->session->userdata('error_message');
        if (isset($error_message)) {
            ?>
         <div class="alert alert-danger alert-dismissible" role="alert">
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
 <div class="col-sm-6" style="display: flex; align-items: left; ">
 <?php    foreach(  $this->session->userdata('perm_data') as $test){
    $split=explode('-',$test);
    if(trim($split[0])=='product' && $_SESSION['u_type'] ==3 && trim($split[1])=='1000'){
       ?>
 <a href="<?php echo base_url('Cproduct').'?id='.urlencode($_GET['id'])?>" class="btnclr btn btn-default dropdown-toggle" style=" height:fit-content;" ><i class="far fa-file-alt"> </i> <?php echo display('add_product') ?> </a>
                    <?php break;}} 
                    if($_SESSION['u_type'] ==2){ ?>
 <a href="<?php echo base_url('Cproduct').'?id='.urlencode($_GET['id']) ?>" class="btnclr btn btn-default dropdown-toggle" style=" height:fit-content;" ><i class="far fa-file-alt"> </i> <?php echo display('add_product') ?> </a>
                        <?php  } ?>
    </div>
  </div>     
</div>
<div class="row">
   <div class="col-sm-12">
      <div class="panel panel-bd lobidrag">
      <div class="panel-body" style="    border: 3px solid #D7D4D6;">
        <table class="table table-bordered" cellspacing="0" width="100%" id="product_list">
  <thead>
     <tr class="btnclr">
         <th><?php echo 'S.No'; ?></th>
      <th><?php echo display('product_name') ?></th>
        <th><?php echo display('product_model') ?></th>
            <th>Product Id</th>
        <th style="width:100px;"><?php echo display('Inventry')?></th>
        <th><?php echo display('category') ?></th>
          <th><?php echo display('Unit') ?></th>
                  <th><?php echo display('price') ?></th>
                <th><?php echo display('supplier_name')?></th>
                  <th><?php echo display('country')?></th>
                  <th><?php echo display('action')?></th>
      </tr>
    </thead>
                    </table>
            </div>
        </div>     
       </div>
</div>
    </section>
</div>
<script>
 $(document).ready(function() {
       $(".sidebar-mini").addClass('sidebar-collapse') ;
                if ($.fn.DataTable.isDataTable('#product_list')) {
                    $('#product_list').DataTable().clear().destroy();
                }
                var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
                var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
                $('#product_list').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "lengthMenu": [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    "ajax": {
                        "url": "<?php echo base_url('Cproduct/getProductDatas?id='); ?>" +
                            encodeURIComponent('<?php echo $_GET['id']; ?>'),
                        "type": "POST",
                        "data": function(d) {
                            d['<?php echo $this->security->get_csrf_token_name(); ?>'] =
                                '<?php echo $this->security->get_csrf_hash(); ?>';
                        },
                        "dataSrc": function(json) {
                           csrfHash = json[
                                '<?php echo $this->security->get_csrf_token_name(); ?>'];
                            return json.data;
                        }
                    },
             "columns": [
     { "data": "sl" },
    { "data": "product_name" },
    { "data": "product_model" },
    { "data": "product_id" },
    {
        "data": "inventry",
        "render": function(data, type, row) {
            return `<div class="row" style="text-align:center;padding:5px;width:200px;border: 1px solid #d3d3d366;margin: -1px;">
                        <div class="col-sm-6" style="font-weight:bold;"><?php echo display('In Stock')?></div>
                        <div class="col-sm-6">${row.p_quantity}</div>
                    </div>
                    <div class="row" style="text-align:center;padding:5px;width:200px;border: 1px solid #d3d3d366;margin: -1px;">
                        <div class="col-sm-6" style="font-weight:bold;"><?php echo ('Availability')?></div>
                        <div class="col-sm-6">${row.inventry}</div>
                    </div>`;
        }
    },
       { "data": "category_name" },
    { "data": "unit" },
    { "data": "price" },
    { "data": "supplier_name" },
    { "data": "country" },
    { "data": "action" }
],
                    "columnDefs": [{
                        "orderable": false,
                        "targets": [0, 10],
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
                        localStorage.setItem('customer', JSON.stringify(data));
                    },
                    "stateLoadCallback": function(settings) {
                        var savedState = localStorage.getItem('customer');
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
                                        '<div style="text-align:center;"><h3>Manage company</h3></div>'
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
            });
            </script>