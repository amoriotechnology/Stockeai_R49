<?php error_reporting(1);  ?>
<div class="content-wrapper">
   <section class="content-header" style="height: 70px;">
         <div class="header-icon" style="margin-top: -8px;">
            <figure class="one">
               <img src="<?php echo base_url()  ?>asset/images/supplier.png"  class="headshotphoto" style="height:50px;" />
            </figure>
         </div>

         <div class="header-title">
            <div class="logo-holder logo-9">
               <h1>  <?php echo display('Manage Vendor') ?></h1>
            </div>
           <ol class="breadcrumb" style=" border: 3px solid #d7d4d6;" >
               <li><a href="<?php echo base_url(); ?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
               <li><a href="<?php echo base_url('Csupplier/manage_supplier?id='.$_GET['id']); ?>"><?php echo display('Vendor') ?></a></li>
               <li class="active" style="color:orange;"><?php echo display('Manage Vendor') ?></li>
                  <div class="load-wrapp">
                     <div class="load-10">
                     <div class="bar"></div>
                     </div>
                  </div>
            </ol>

         </div>
   </section>
   <section class="content">
      
      <div class="panel panel-bd lobidrag">
         <div class="panel-heading" style="height: 60px;border: 3px solid #D7D4D6;">
            <div class="col-sm-12">
               <div class="col-sm-6" style="display: flex; align-items: left;">
                  <?php    
                  foreach(  $this->session->userdata('perm_data') as $test){
                     $split=explode('-',$test);
                     if(trim($split[0])=='supplier' && $_SESSION['u_type'] ==3 && trim($split[1])=='1000'){
                        ?>
                        <a href="<?php echo base_url('Csupplier?id='.$_GET['id']); ?>" class="btnclr btn btn-default dropdown-toggle"   style="height:fit-content;"  ><i class="far fa-file-alt"> </i> <?php echo display('Add Vendor') ?> </a>                  
                        <?php break;}
                  } 
                  if($_SESSION['u_type'] ==2){ ?>
                     <a href="<?php echo base_url('Csupplier?id='.$_GET['id']); ?>" class="btnclr btn btn-default dropdown-toggle"    style="height:fit-content;"   ><i class="far fa-file-alt"> </i>  <?php echo display('Add Vendor') ?> </a>
                  <?php  } ?>
                  </div>
               </div>
         </div>
      </div>
                  
            <div class="row">
               <div class="col-sm-12">
                  <div class="panel panel-bd">
                     <div class="panel-body" >
                        <div class="error_display mb-2"></div>
                        <div id="dataTableExample3">
                          <table class="table table-bordered" cellspacing="0" id="suppliertbl">
                              <thead>
                                    <tr style="background-color: #424f5c;color:#fff;">
                                       <th width="2%">S No.</th>
                                       <th width="5%">Company Name</th>
                                       <th width="5%"><?php echo display('Address')?></th>
                                       <th width="5%"><?php echo display('Mobile')?></th>
                                       <th width="5%"><?php echo display('Business Phone')?></th>
                                       <th width="5%"><?php echo display('Primary Email')?></th>
                                       <th width="5%"><?php echo display('City')?></th>
                                       <th width="5%"><?php echo display('State')?></th>
                                       <th width="5%"><?php echo display('Country')?></th>
                                       <th width="2%"><?php echo display('Credit limit')?></th>
                                       <th width="3%">Open Balance</th>
                                       <th width="5%"><?php echo display('Vendor Type')?></th>
                                       <th width="5%"><?php echo display('Secondary Email')?></th>
                                       <th width="5%"><?php echo display('Contact Person')?></th>
                                       <th width="5%"><?php echo display('Fax')?></th>
                                       <th width="5%"><?php echo display('Tax Collected')?></th>
                                       <th width="5%"><?php echo display('Zip code')?></th>
                                       <th width="5%"><?php echo display('Supplier Details')?></th>
                                       <th width="5%"><?php echo display('Preferred currency')?></th>
                                       <th width="5%"><?php echo display('Payment Terms')?></th>
                                       <th width="3%"><?php echo display('Action')?></th>
                                    </tr>
                              </thead>
                           </table>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" value="Vendor/Vendor" id="url"/>
   <script>
      var supplierDataTable;
   $(document).ready(function() {
      
         if ($.fn.DataTable.isDataTable('#suppliertbl')) {
            $('#suppliertbl').DataTable().clear().destroy();
         }
         var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
         var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
         supplierDataTable = $('#suppliertbl').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [
               [10, 25, 50, 100],
               [10, 25, 50, 100]
            ],
            "ajax": {
               "url": "<?php echo base_url('Csupplier/getVendorDatas?id='); ?>" +
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
                     "data": "supplier_name"
               },
               {
                     "data": "address"
               },
               {
                     "data": "mobile"
               },
               {
                     "data": "businessphone"
               },
               {
                     "data": "primaryemail"
               },
			   {
                     "data": "city"
               },
			   {
                     "data": "state"
               },
			    {
                     "data": "country"
               },
			    {
                     "data": "credit_limit"
               },
			   {
                     "data": "previous_balance"
               },
			   {
                     "data": "vendor_type"
               },
               {
                     "data": "secondaryemail"
               },
               {
                     "data": "contactperson"
               },
               {
                     "data": "fax"
               },
               {
                     "data": "taxcollected"
               },
               {
                     "data": "zip"
               },
               {
                     "data": "details"
               },
               {
                     "data": "currency_type"
               },
               {
                     "data": "paymentterms"
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
   function deleteSupplier(id){
      var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
      var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
      var succalert = '<div class="alert alert-success alert-dismissible" role="alert">';
      var failalert = '<div class="alert alert-danger alert-dismissible" role="alert">';
      if(id !=""){
         $.ajax({
            type:"POST",
            dataType:"json",
            url:"<?php echo base_url(); ?>Csupplier/supplier_delete",
            data:{id:id,<?php echo $this->security->get_csrf_token_name();?>:csrfHash},
            success:function (response) {
               if(response.status =='success'){
                     $('.error_display').html(succalert+response.msg+'</div>');
                     window.setTimeout(function(){
                        supplierDataTable.ajax.reload(null, false);
                        $('.error_display').html('');
                     },2500);
               }else{
                     $('.error_display').html(failalert+response.msg+'</div>'); 
               }
            }
         });
      }
   }
</script>
<style>
   .select2-selection__rendered{
   display:none;
   }
   .ads{
   max-width: 0px !important;
   white-space: nowrap;
   overflow: hidden;
   text-overflow: ellipsis;
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
    width: 130px;
  }

</style>