<?php error_reporting(1);  ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>my-assets/css/css.css" />
<style>
.btnclr{
       background-color:<?php echo $setting_detail[0]['button_color']; ?>;
       color: white;

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
    width: 200px;
  }
} 
  @media (max-width:1024px){
       #insert_sale{
       display: flex !important;
       justify-content: flex-end !important;
       }
       .mob_topview{
       position: relative;
       right: 33px;
       }
       #removeButton{
       position: absolute;
       left: 145px;
       }
       .fa.fa-gear::before {
       position: absolute;
       left: 111px;
       }
       .mobile_daterangepicker{
       position: relative;
       right: 36px;
       }
       .mob_search{
       position: absolute;
       left: 108px;
       font-size: 11px;
       }
       .mobile_para{
          font-size: 11px !important; 
       }
   }
   
</style>
 


<div class="content-wrapper">
   <section class="content-header">
        <div class="header-icon">
                <figure class="one">
                <img src="<?php echo base_url()  ?>asset/images/export.png"  class="headshotphoto" style="height:50px;" /> 
        </div>
        <div class="header-title">
            <div class="logo-holder logo-9">
                <h1> <?php echo display('Manage Road Transport') ?> </h1>
            </div>
            <small></small>
            <ol class="breadcrumb" style=" border: 3px solid #d7d4d6;" >
                <li><a href="<?php   echo base_url(); ?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('invoice') ?></a></li>
                <li class="active" style="color:orange;"><?php echo display('Trucking Invoice') ?></li>
                    <div class="load-wrapp">
                        <div class="load-10">
                            <div class="bar"></div>
                        </div>
                    </div>
            </ol>
        </div>
   </section>
   <section class="content">
      
 
        <div class="panel panel-bd lobidrag" >
            <div class="panel-heading" style="height: 60px;    border: 3px solid #d7d4d6;">
                <div class="col-sm-12 mob_topview" style="height:69px;">
                    <div class="col-sm-4" style="display: flex; justify-content: space-between; align-items: left;">
                    <?php foreach($this->session->userdata('perm_data') as $test) {
                        $split = explode('-', $test);
                        if (trim($split[0]) == 'sales' && $_SESSION['u_type'] == 3 && trim($split[1]) == '1000') {
                            ?>
                            
            
                                    <a href="<?php echo base_url('sales/createRoadTrans?id='.$_GET['id']) ?>" class="btnclr btn btn-default dropdown-toggle boxes filip-horizontal mobile_para"   style="height:fit-content;"  ><i class="far fa-file-alt"> </i> <?php echo display('Create Road Transport') ?> </a>

            

                            <?php break;
                        }
                    }
                    if ($_SESSION['u_type'] == 2) { ?>
  
                                 <a href="<?php echo base_url('sales/createRoadTrans?id='.$_GET['id']) ?>" class="btnclr btn btn-default dropdown-toggle boxes filip-horizontal mobile_para"   style="height:fit-content;"  ><i class="far fa-file-alt"> </i> <?php echo display('Create Road Transport') ?> </a>

                    <?php }  ?>
                </div>
            </div> 
        </div> <!--end of panel panel-bd lobidrag-->
       
       
        
         

        

<div class="row">
                <div class="col-sm-12">
                    <div class="error_display"></div>
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-body">
                            <div id="dataTableExample3">
                                <table class="table table-bordered" cellspacing="0" width="100%" id="trucking">
                                    <thead>

                                    <tr class="btnclr">
                                           <th width="4%"><?php echo display('ID') ?></th>
                                            <th width="5%"><?php echo display('Invoice No') ?></th>
                                            <th width="5%"><?php echo display('Invoice Date') ?></th>
                                            <th width="5%"><?php echo display('Bill to') ?></th>
                                            <th width="5%"> <?php echo display('Trucking ID') ?></th>
                                             <th width="5%">Container Pickup Date</th>
                                            <th width="5%"><?php echo display('Delivery Date') ?></th>
                                            <th width="5%"><?php echo display('Shipment Company') ?></th>
                                            <th width="5%"><?php echo display('From') ?></th>
                                            <th width="5%"><?php echo display('To') ?></th>
                                            <th width="5%"><?php echo display('Truck No') ?></th>
                                            <th width="5%"><?php echo display('Delivery To') ?></th>
                                            <th width="5%"><?php echo display('Tax Details') ?></th>
                                            <th width="5%"><?php echo display('Total Amount') ?></th>
                                            <th width="5%"><?php echo display('Grand Total') ?></th>
                                            <th width="5%"><?php echo display('Amount Paid') ?></th>
                                            <th width="5%"><?php echo display('Balance Amount') ?></th>
                                            <th width="5%"><?php echo display('Remarks') ?></th>
                                            <th width="10%"><?php echo display('Action') ?></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



  
            <script>
                var roadTruckDT;
            $(document).ready(function() {
                if ($.fn.DataTable.isDataTable('#trucking')) {
                    $('#trucking').DataTable().clear().destroy();
                }
                var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
                var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
                roadTruckDT = $('#trucking').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "lengthMenu": [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    "ajax": {
                        "url": "<?php echo base_url('sales/getTruckingInvoice?id='); ?>" +
                            encodeURIComponent('<?php echo $_GET['id']; ?>')+'&admin='+encodeURIComponent('<?php echo $_GET['admin']; ?>'),
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
                     "data": "invoice_no"
               },
               {
                     "data": "invoice_date"
               },
               {
                     "data": "customer_name"
               },
               {
                     "data": "trucking_id"
               },
			   {
                     "data": "container_pickup_date"
               },
			   {
                     "data": "delivery_date"
               },
			    {
                     "data": "shipment_company"
               },
			    {
                     "data": "delivery_time_from"
               },
			   {
                     "data": "delivery_time_to"
               },
			   {
                     "data": "truck_no"
               },

               {
                     "data": "delivery_to"
               },
               {
                     "data": "tax"
               },
               {
                     "data": "grand_total_amount"
               },
               {
                     "data": "customer_gtotal"
               },
               {
                     "data": "amt_paid"
               },
               {
                     "data": "balance"
               },
               {
                     "data": "remarks"
               },
               
               {
                     "data": "button"
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
                        localStorage.setItem('OceanExport ', JSON.stringify(data));
                    },
                    "stateLoadCallback": function(settings) {
                        var savedState = localStorage.getItem('OceanExport');
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
                            "title": "Ocean Export",
                            "className": "btn-sm",
                            "exportOptions": {
                                "columns": ':visible'
                            }
                        },
                        {
                            "extend": "pdf",
                            "title": "Ocean Export ",
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

function deleteRoadTrans(id,moid){
    var isConfirmed = confirm("Are you sure you want to delete this item?");
    if (isConfirmed && id !="") {
        var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
        var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
        var succalert = '<div class="alert alert-success alert-dismissible" role="alert">';
        var failalert = '<div class="alert alert-danger alert-dismissible" role="alert">';
        if(id !=""){
            $.ajax({
                type:"POST",
                dataType:"json",
                url:"<?php echo base_url(); ?>sales/deleteRoadTrack",
                data:{id:id,moid:moid, <?php echo $this->security->get_csrf_token_name();?>:csrfHash},
                success:function (response) {
                if(response.status =='success'){
                    $('.error_display').html(succalert+response.msg+'</div>');
                    window.setTimeout(function(){
                        roadTruckDT.ajax.reload(null, false);
                        $('.error_display').html('');
                    },2500);
                }else{
                        $('.error_display').html(failalert+response.msg+'</div>'); 
                }
                }
            });
        }
    }

}
            </script>