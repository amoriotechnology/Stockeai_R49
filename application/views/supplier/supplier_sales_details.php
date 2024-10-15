<?php error_reporting(1); ?>  

<!-- Supplier Sales Report Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	      
 	      
	      
	       <figure class="one">
               <img src="<?php echo base_url()  ?>asset/images/supplier.png"  class="headshotphoto" style="height:50px;" />
      </div>
      
	      
	      
	      
	           <div class="header-title">
          <div class="logo-holder logo-9">
		<h1><?php echo display('vendor_sales_details') ?></h1>
       </div>
         
	      
	      
	      
	      
	       
	        <ol class="breadcrumb" style=" border: 3px solid #d7d4d6;" >
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('vendor') ?></a></li>
	            <li class="active" style="color:orange"><?php echo display('vendor_sales_details') ?></li>
	       </ol>
	    </div>
	</section>
  
	<!-- Search Supplier -->
	<section class="content">

 


        <div class="panel panel-bd lobidrag" >
      <div class="panel-heading" style="height: 60px;border:3px solid #d7d4d6;">
         <div class="col-sm-12" >
<div class="col-sm-4" style="display: flex;align-items: left;">
 <a href="<?php echo base_url('Csupplier') ?>" class="btn btnclr"   style="height:fit-content;float:left;"  ><i class="far fa-file-alt"> </i> <?php echo display('Add Vendor') ?> </a>


    </div>
    <div class="col-sm-6" style="text-align: center;">

    <?php echo form_open('Csupplier/supplier_sales_details_datewise/'.$this->uri->segment(3).'/'.$this->uri->segment(4), array('class' => '', 'id' => 'validate')) ?>
                     <?php $today = date('Y-m-d'); ?>
                   
                      <div class="col-sm-6">
                        <div class="form-group row"     style="width: 300px;">
                        <input type="hidden" name="seg_3" value="<?php echo  $this->uri->segment(3) ; ?>"/>
                        <input type="hidden" name="seg_4" value="<?php echo  $this->uri->segment(4) ; ?>"/>
                         <input style="width: 300px;text-align:center;" class="form-control daterangepicker-field" name="daterangepicker-field" autocomplete="off" id="daterangepicker-field" <?php  if(empty($start)){ echo "value=''";}else{ echo "value=".$start ;}  ?>>
                           &nbsp; &nbsp; &nbsp;
                        </div>
                     </div>
                      <div class="col-sm-1">
                         <div class="form-group">
                             <button type="submit" class="btnclr btn" style="float:right;" ><i class="fa fa-search" aria-hidden="true"></i> <?php echo display('search') ?></button> 
                         </div>
                     </div>
                      <?php echo form_close() ?>
    </div>


      </div>
         

            </div>
            </div>
  

            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-body">
                            <div id="dataTableExample3">
                                <table class="table table-bordered" cellspacing="0" width="100%" id="vendor_sales_list">
                                    <thead>

                                   <tr class="btnclr">
                                            <th width="5%">S.No</th>
                                            <th width="15%"><?php echo display('date') ?></th>
                                            <th width="15%"><?php echo display('product_name') ?></th>
                                            <th width="20%"><?php echo display('supplier_name') ?></th>
                                            <th width="10%"><?php echo display('invoice_no') ?></th>
                                            <th width="10%"><?php echo display('quantity') ?></th>
                                            <th width="10%"><?php echo display('rate') ?></th>
                                            <th width="10%"><?php echo display('amount')?></th>
                                     </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
				</section>
  <script>
            $(document).ready(function() {
                
                if ($.fn.DataTable.isDataTable('#vendor_sales_list')) {
                    $('#vendor_sales_list').DataTable().clear().destroy();
                }
                var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
                var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
                        debugger;
                $('#vendor_sales_list').DataTable({

                    "processing": true,
                    "serverSide": true,
                    "lengthMenu": [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    "ajax": {
                        "url": "<?php echo base_url('Csupplier/getVendorSalesDeatilsDatas?id='); ?>" +
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
                    "columns": [{
                            "data": "sl"
                        },
                        {
                            "data": "date"
                        },
                        {
                            "data": "invoice"
                        },
                        {
                            "data": "invoice_id"
                        },
                        {
                            "data": "product_name"
                        },
                        {
                            "data": "product_model"
                        },
                        {
                            "data": "supplier_name"
                        },
                        {
                            "data": "supplier_rate"
                        },
                        {
                            "data": "total"
                        },
                        {
                            "data": "country"
                        },
                        {
                            "data": "created_date"
                        },
                        {
                            "data": "currency_type"
                        },
                        {
                            "data": "credit_limit"
                        },
                        {
                            "data": "action"
                        },
                    ],
                    "columnDefs": [{
                        "orderable": false,
                        "targets": [0, 13],
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



             
























