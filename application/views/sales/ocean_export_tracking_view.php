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
                <h1> <?php echo display('Manage Ocean Export Invoice') ?> </h1>
            </div>
            <small></small>
            <ol class="breadcrumb" style=" border: 3px solid #d7d4d6;" >
                <li><a href="<?php   echo base_url(); ?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('invoice') ?></a></li>
                <li class="active" style="color:orange;"><?php echo display('Manage Ocean Export Invoice') ?></li>
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
                            <a href="<?php echo base_url('sales/createOceExpTracking?id='.$_GET['id']); ?>" class="btnclr btn btn-default dropdown-toggle boxes filip-horizontal mobile_para"   style="height:fit-content;"  ><i class="far fa-file-alt"> </i>  <?php echo display('Create ocean export') ?>   </a>

                                <?php break;
                            }
                        }
                        if ($_SESSION['u_type'] == 2) { ?>
  
                            <a href="<?php echo base_url('sales/createOceExpTracking?id='.$_GET['id']); ?>" class="btnclr btn btn-default dropdown-toggle boxes filip-horizontal mobile_para"   style="height:fit-content;"  ><i class="far fa-file-alt"> </i>  <?php echo display('Create ocean export') ?>  </a>

                            <?php 
                        } /* ?>&nbsp;&nbsp;
                        <a  class="btnclr btn btn-default dropdown-toggle  boxes filip-horizontal  mobile_para"  style="height:fit-content;"  id="s_icon"><b class="fa fa-search"></b>&nbsp;Advance search  </a>&nbsp;&nbsp;
                        <div class="dropdown bootcol" id="drop" style="    width: 300px;">
                            <button class="btnclr btn btn-default dropdown-toggle  boxes filip-horizontal mobile_para" type="button" id="dropdownMenu1" style="float:left;"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                                <span  class="fa fa-download"  ></span> <?php echo display('download') ?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><a href="#" onclick="generate()"> <img src="<?php echo base_url() ?>assets/images/pdf.png" width="24px"> <?php echo display('PDF') ?></a></li>
                                <li class="divider"></li>
                                <li><a href="#" onclick="$('#ProfarmaInvList').tableExport({type:'excel',escape:'false'});"> <img src="<?php echo base_url() ?>assets/images/xls.png" width="24px"> <?php echo display('XLS') ?></a></li>
                            </ul>&nbsp;&nbsp;
                        </div> */ ?>
                    </div>
                    <div class="col-sm-6" style="text-align: center;">
                        <?php echo form_open_multipart('Cinvoice/manage_ocean_export_tracking',array('class' => 'form-vertical', 'id' => 'insert_sale','name' => 'insert_sale'))?>
                        <?php
                        $today = date('Y-m-d');
                        /*
                        ?>            
                        <div class="col-sm-2">
                            <div class="form-group" style="display: inline-block; vertical-align: middle;">
                                <input type="text" class="form-control daterangepicker-field mobile_daterangepicker" name="daterangepicker-field" style="padding: 5px;width: 175px;border-radius: 8px;height: 35px;"/>&nbsp; &nbsp; &nbsp;
                            </div>
                    
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <button type="submit" class="btn btnclr dropdown-toggle boxes filip-horizontal mob_search" style="float:right;" ><i class="fa fa-search" aria-hidden="true"></i> <?php echo display('search') ?></button> 
                            </div>
                        </div>
                        <?php echo form_close() */ ?>
                    </div>
                    <div class="col-sm-2" style="float:right;">
                        <?php /*<div class="" style="float: right;">  <a onclick="reload();"  id="removeButton">  <i class="fa fa-refresh fa-spin" style="font-size:25px;float:right;" aria-hidden="true"></i> </a>    &nbsp;    &nbsp;    &nbsp;    &nbsp; <i class="fa fa-gear fa-spin"  aria-hidden="true" id="myBtn" style="margin-right:20px;font-size:25px;float:right;" onClick="columnSwitchMODAL()"></i>
                        </div> */ ?>
                    </div>
                </div>
                <?php /*<br>
                <br> 
                <br>
                <div id="search_area" style="border:4px solid #004d99;border-radius:7px;">
                    <table class="table">
                        <thead>
                            <tr class="filters">
                                <th class="search_dropdown" style="width: 22%;color: black;">
                                    <span><?php echo display('Booking No') ?> </span>
                                    <select id="pname-filter" class="form-control">
                                        <option>Any</option>
                                        <?php 
                                        $booking_no  = array();
                                        foreach ($ocean_exports as $invoice) {
                                            $booking_no [] = $invoice['booking_no'];
                                        }
                                        $unique_booking_no = array_unique($booking_no);
                                 
                                 
                                        $container_no = array();
                                        foreach ($ocean_exports as $invoice) {
                                            $container_no[] = $invoice['container_no'];
                                        }
                                        $unique_container_no = array_unique($container_no);
                                 
                                 
                                        $port_of_loading = array();
                                        foreach ($ocean_exports as $invoice) {
                                            $port_of_loading[] = $invoice['port_of_loading'];
                                        }
                                        $port_of_loading = array_unique($port_of_loading);
                                 
                                 
                                        $ocean_export_tracking_id = array();
                                        foreach ($ocean_exports as $invoice) {
                                            $ocean_export_tracking_id[] = $invoice['ocean_export_tracking_id'];
                                        }
                                        $ocean_export_tracking_id = array_unique($ocean_export_tracking_id);
                                 
                                        $supplier_name = array();
                                        foreach ($ocean_exports as $invoice) {
                                            $supplier_name[] = $invoice['supplier_name'];
                                        }
                                        $unique_supplier_name = array_unique($supplier_name);
                                 
                                
                                        foreach($unique_booking_no as $invoice){  ?>
                                            <option value="<?php echo $invoice; ?>"><?php echo $invoice; ?></option>
                                        <?php }  ?>
                                    </select>
                                </th>
                                <th class="search_dropdown" style="width: 22%;color: black;">
                                    <span>Container No</span>
                                    <select id="model-filter" class="form-control">
                                        <option>Any</option>
                                        <?php foreach($unique_container_no as $invoice){  ?>
                                        <option value="<?php echo $invoice; ?>"><?php echo $invoice; ?></option>
                                        <?php }  ?>
                                    </select>
                                </th>
                                <th class="search_dropdown" style="width: 22%;color: black;">
                                    <span>Port of Loading </span>
                                    <select id="category-filter" class="form-control">
                                        <option>Any</option>
                                        <?php foreach($port_of_loading as $invoice){  ?>
                                        <option value="<?php echo $invoice; ?>"><?php echo $invoice; ?></option>
                                        <?php }  ?>
                                    </select>
                                </th>
                                <th class="search_dropdown" style="width: 22%;color: black;">
                                    <span>Ocean Export Tracking Id</span>
                                    <select id="unit-filter" class="form-control">
                                        <option>Any</option>
                                        <?php foreach($unique_customs_broker_name as $invoice){  ?>
                                        <option value="<?php echo $invoice; ?>"><?php echo $invoice; ?></option>
                                        <?php }  ?>
                                    </select>
                                </th>
                                <th class="search_dropdown" style="width: 200px;color: black;">
                                    <span>Shipper</span>
                                    <select id="supplier-filter" class="form-control">
                                        <option>Any</option>
                                        <?php foreach($unique_supplier_name as $invoice){  ?>
                                        <option value="<?php echo $invoice; ?>"><?php echo $invoice; ?></option>
                                        <?php }  ?>
                                    </select>
                                </th>
                            </tr>
                        </thead>
                    </table>
                    <table>
                        <tr>
                            <td style="width:10px;"></td>
                            <td style="width:22%;">   <input type="text" style="height:inherit;"  class="form-control" id="myInput1" onkeyup="search()" placeholder="Search for Booking No.."></td>
                            <td style="width:10px;"></td>
                            <td style="width:22%;"> <input type="text" style="height:inherit;"  class="form-control" id="myInput2" onkeyup="search()" placeholder="Search for Container No.."></td>
                            <td style="width:10px;"></td>
                            <td style="width:20%;">  <input type="text" style="height:inherit;"  class="form-control" id="myInput3" onkeyup="search()" placeholder="Search for Customer Name.."></td>
                            <td style="width:10px;"></td>
                            <td style="width:20%;"> <input type="text" style="height:inherit;"  class="form-control" id="myInput4" onkeyup="search()" placeholder="Customer Broker Name.."></td>
                            <td style="width:10px;"></td>
                            <td style="width: 203px;"> <input type="text" style="height:inherit;"  class="form-control" id="myInput5" onkeyup="search()" placeholder="Shipper.."></td>
                        </tr>
                    </table>
                    <br/>
                    <div class="col-sm-12">
                        <input id="search" type="text" class="form-control" style="height:inherit;"  placeholder="Search for Ocean Export">
                        <br>
                    </div>
                    <br>
                </div> */ ?>
            </div>
        </div> <!--end of panel panel-bd lobidrag-->
       
       
        
         



<div class="row">
                <div class="col-sm-12">
                    <div class="error_display"></div>
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-body">
                            <div id="dataTableExample3">
                                <table class="table table-bordered" cellspacing="0" width="100%" id="oceanexport">
                                    <thead>

                                    <tr class="btnclr">
                                           <th width="2%"><?php echo display('ID') ?></th>
                                            <th width="4%"><?php echo display('Booking Number') ?></th>
                                            <th width="4%"><?php echo display('Container Number') ?></th>
                                            <th width="4%"><?php echo display('Seal Number') ?></th>
                                            <th width="4%"> <?php echo display('Ocean Export ID') ?></th>
                                             <th width="4%"><?php echo display('Purchase Date') ?></th>
                                            <th width="4%"><?php echo display('Place of Delivery') ?></th>
                                            <th width="4%"><?php echo display('Notify Party') ?></th>
                                            <th width="4%"><?php echo display('Vessel') ?></th>
                                            <th width="4%"><?php echo display('Voyage No') ?></th>
                                            <th width="4%"><?php echo display('Freight Forwarder') ?></th>
                                            <th width="4%"><?php echo display('HBL No') ?></th>
                                            <th width="4%"><?php echo display('OBL No') ?></th>
                                            <th width="4%"><?php echo display('AMS No') ?></th>
                                            <th width="4%"><?php echo display('ISF No') ?></th>
                                            <th width="4%"><?php echo display('MBL No') ?></th>
                                            <th width="4%"><?php echo display('Port of discharge') ?></th>
                                            <th width="4%"><?php echo display('Customs Broker Name') ?></th>
                                            <th width="4%"><?php echo display('Estimated time of departure') ?></th>
                                            <th width="4%"><?php echo display('Customer / Consignee') ?></th>
                                            <th width="4%"><?php echo display('Port of loading') ?></th>
                                            <th width="4%"><?php echo display('Estimated Time of Arrival') ?></th>
                                            <th width="4%"><?php echo display('Remarks / Particulars') ?></th>
                                            <th width="3%"><?php echo display('Invoice Date') ?></th>
                                            <th width="3%"><?php echo display('Action') ?></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



 

<script>
var oceanExportDataTable;
$(document).ready(function() {
    if ($.fn.DataTable.isDataTable('#oceanexport')) {
        $('#oceanexport').DataTable().clear().destroy();
    }
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    oceanExportDataTable = $('#oceanexport').DataTable({
        "processing": true,
        "serverSide": true,
        "lengthMenu": [
            [10, 25, 50, 100],
            [10, 25, 50, 100]
        ],
        "ajax": {
            "url": "<?php echo base_url('sales/getOceanExportInvoice?id='); ?>" +
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
            "data": "booking_no"
    },
    {
            "data": "container_no"
    },
    {
            "data": "seal_no"
    },
    {
            "data": "ocean_export_tracking_id"
    },
    {
            "data": "invoice_date"
    },
    {
            "data": "place_of_delivery"
    },
    {
            "data": "notify_party"
    },
    {
            "data": "vessel"
    },
    {
            "data": "voyage_no"
    },
    {
            "data": "freight_forwarder"
    },

    {
            "data": "hbl_no"
    },
    {
            "data": "obl_no"
    },
    {
            "data": "ams_no"
    },
    {
            "data": "isf_no"
    },
    {
            "data": "mbl_no"
    },
    {
            "data": "port_of_discharge"
    },
    {
            "data": "customs_broker_name"
    },
    {
            "data": "etd"
    },
    {
            "data": "consignee"
    },
    {
            "data": "port_of_loading"
    },
    {
            "data": "eta"
    },
    {
            "data": "particular"
    },
    {
            "data": "invoice_date"
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
function deleteOceanExpTrac(id,moid){
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
                url:"<?php echo base_url(); ?>sales/deleteOceanExportTrack",
                data:{id:id,moid:moid, <?php echo $this->security->get_csrf_token_name();?>:csrfHash},
                success:function (response) {
                if(response.status =='success'){
                    $('.error_display').html(succalert+response.msg+'</div>');
                    window.setTimeout(function(){
                        oceanExportDataTable.ajax.reload(null, false);
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