<link rel="stylesheet" href="<?php echo base_url() ?>my-assets/css/style.css">
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

<style>
.btnclr{
       background-color:<?php echo $setting_detail[0]['button_color']; ?>;
       color: white;

   }
   #pagesControllers{
   padding:20px;
   }
   .select2{
   display:none;
   }
   table {
   border-collapse: collapse;
   width: 100%;
   margin-bottom: 20px;
   }
   /* Style the table header */
   thead {
   background-color: #333;
   color: #fff;
   text-align: center;
   }
   thead th {
   padding: 10px;
   border: 1px solid #000;
   }
   
   tbody td {
   padding: 10px;
   border: 1px solid #000;
   text-align: center !important;
   }
   th{
   text-align:center !important;
   padding:10px !important;
   }
   .table1 td , .table1 tr{
   border:none !important;
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


.load-10 .bar {
  animation: loadingJ 2s cubic-bezier(0.17, 0.37, 0.43, 0.67) infinite;
}


@keyframes loadingJ {
  0%,
  100% {
    transform: translate(0, 0);
  }

  50% {
    transform: translate(80px, 0);
    background-color: #f5634a;
    width: 170px;
  }

   
}
   
</style>

<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>my-assets/css/balance_sheet.css" />
<div class="content-wrapper">
   <section class="content-header" style='height:70px;'>
      <div class="header-icon">
         <figure class="one">
               <img src="<?php echo base_url()  ?>asset/images/reportcustomer.png"  class="headshotphoto" style="height:50px;" />
      </div>
      
      
          
            <div class="header-title">
          <div class="logo-holder logo-9">
         <h1><?php echo "Product Information"; ?></h1>
       </div> 
         
         
         
         <small><?php //echo "Vocher Report"; ?></small>
         <ol class="breadcrumb" style="border: 3px solid #d7d4d6;" >
            <li><a href="<?php echo base_url(); ?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
            <li><a href="#"><?php echo "Reports"; ?></a></li>
            <li class="active" style="color:orange;"><?php echo "Product Information"; ?></li>
        
           <div class="load-wrapp">
       <div class="load-10">
         <div class="bar"></div>
       </div>
       </div>
      
        
         </ol>
      </div>
   </section>
   <section class="content">
      
     
      <div class="row">
         <div class="col-sm-12 panel panel-bd lobidrag" style="border: 3px solid #d7d4d6;">
            <div class="col-sm-8">
               <div class="panel-body" style='margin-bottom:-30px;'>
                  <table class="table1 table-bordered" cellspacing="0" width="100%" style='border:none;'>
                     <tr style="text-align: center; font-weight: bold;" class="filters">
                        <td style="width: 100px;"> </td>
                        <td class="search_dropdown" style="width: 100px; color: black; padding: 5px;">
                        Supplier Name : 
                        </td>
                        <td class="search_dropdown" id="datepicker-container" style="width: 15%; color: black; padding: 5px;">
                            <select style='width:300px;' id="customer-name-filter" class="form-control">
                                <option value="">Any</option>
                                <?php
                                    foreach ($getsupplier as $invoice) {
                                    ?>
                                <option value="<?php echo $invoice['supplier_id']; ?>"><?php echo $invoice['supplier_name']; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td style="width: 20px; padding: 5px;">
                           <input type="button" id="searchtrans" name="btnSave" class="btn btnclr" value="Search" />
                        </td>
                        <td style="width: 100px;"></td>
                     </tr>
                  </table>
                  <!-- </div> -->
               </div>
            </div>
                                          <div class='col-sm-2' style='margin-top: 20px;
    margin-left: 140px;text-align:end;'>
    
</div>
         </div>
      </div>
      <div class="row">
         <div class="col-sm-16 col-md-14">
            <div class="panel panel-bd lobidrag" id="printableArea"   style="border: 3px solid #d7d4d6;" >
               <div class="panel-body">
                   <div class="sortableTable__container">
                    <div class="sortableTable__discard">
                    </div>
                        <table class="table table-bordered" id="productReportTbl" cellspacing="0" width="100%">
                            <thead class="sortableTable">

                                <th class="btnclr" width="10%">S.No</th>
                                <th class="btnclr" width="15%">Product Id</th>
                                <th class="btnclr" width="15%"><?php echo display('product_name') ?></th>
                                <th class="btnclr" width="15%"><?php echo display('product_model') ?></th>
                                <th class="btnclr" width="15%"><?php echo display('category') ?></th>
                                <th class="btnclr" width="15%"><?php echo 'Supplier Name'; ?></th>
                                <th class="btnclr" width="15%"><?php echo display('Unit') ?></th>

                            </thead>
                               
                  </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
     
      <script src='<?php echo base_url();?>assets/js/moment.min.js'></script>
      <script src='https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.0/knockout-debug.js'></script>
      <script  src="<?php echo base_url() ?>assets/js/scripts.js"></script> 

      <script>
$(document).ready(function() {
    $('#datepicker-container').val();
    if ($.fn.DataTable.isDataTable('#productReportTbl')) {
        $('#productReportTbl').DataTable().clear().destroy();
    }
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    var dtable = $('#productReportTbl').DataTable({
        "processing": true,
        "serverSide": true,
        "lengthMenu": [
            [10, 25, 50, 100],
            [10, 25, 50, 100]
        ],
        "ajax": {
            "url": "<?php echo base_url('Creport/productReportData?id='); ?>" +
                encodeURIComponent('<?php echo $_GET['id']; ?>'),
            "type": "POST",
            "data": function(d) {
                d['<?php echo $this->security->get_csrf_token_name(); ?>'] =
                    '<?php echo $this->security->get_csrf_hash(); ?>',
                d['supplier_id'] = $('#customer-name-filter').val(); // Send the search input value
            },
            "dataSrc": function(json) {
                csrfHash = json[
                    '<?php echo $this->security->get_csrf_token_name(); ?>'];
                return json.data;
            }
        },
        "columns": [{
                "data": "supplier_id"
            },
            {
                "data": "product_id"
            },
            {
                "data": "product_name"
            },
            {
                "data": "product_model"
            },
            {
                "data": "category_name"
            },
            {
                "data": "supplier_name"
            },
            {
                "data": "unit"
            },
            
            
        ],
        "columnDefs": [{
            "orderable": false,
            "targets": [0],
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
    $('#searchtrans').on('click', function() {
        dtable.draw(); // Redraw the DataTable with the new search input value
    });
});

            </script>
     
   </section>
</div>