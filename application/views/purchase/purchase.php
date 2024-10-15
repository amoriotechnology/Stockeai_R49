
<div class="content-wrapper">
   <section class="content-header">
      <div class="header-icon">
         <figure class="one">
         <img src="<?php echo base_url()  ?>asset/images/expenses.png"  class="headshotphoto" style="height:50px;" />      
      </div>
      <div class="header-title">
         <div class="logo-holder logo-9">
            <h1><strong><?php echo display('manage_purchase') ?></strong></h1>
         </div>
         <small><?php //echo display('manage_your_purchase') ?></small>
         <ol class="breadcrumb"  style="border: 3px solid #d7d4d6;"  >
            <li><a href="<?php   echo base_url(); ?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
            <li><a href="#"><?php echo display('purchase') ?></a></li>
            <li class="active" style="color:orange;"><?php echo display('manage_purchase') ?></li>
            <div class="load-wrapp">
               <div class="load-10">
                  <div class="bar"></div>
               </div>
            </div>
         </ol>
      </div>
   </section>
   <section class="content">
      <!-- Alert Message -->
      <?php
         $message = $this->session->userdata('show');
         
         if (isset($message)) {
         
             ?>
      <div class="alert alert-info alert-dismissable" style="background-color:#38469f;color:white;font-weight:bold;">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         <?php echo $message; ?>                    
      </div>
      <?php
         // $this->session->unset_userdata('message');
         
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
   
      <div class="panel panel-bd lobidrag" >
         <div class="panel-heading" style="height: 60px;    border: 3px solid #d7d4d6;">
            <div class="col-sm-12" style="height:69px;">
               <div class="col-sm-4" style="display: flex; justify-content: space-between; align-items: left;">
                  <?php foreach($this->session->userdata('perm_data') as $test) {
                     $split = explode('-', $test);
                     if(trim($split[0])=='expense' && $_SESSION['u_type'] ==3 && trim($split[1])=='1000'){
                        ?>
                  <a href="<?php echo base_url('Cpurchase').'?id='.urlencode($_GET['id'])?>" class="btnclr btn btn-default dropdown-toggle boxes filip-horizontal"   style="height:fit-content;"  ><i class="far fa-file-alt"> </i> <?php echo display('Create Expense') ?> </a>
                  <?php break;
                     }
                     }
                     if ($_SESSION['u_type'] == 2) { ?>
                  <a href="<?php echo base_url('Cpurchase').'?id='.urlencode($_GET['id'])?>" class="btnclr btn btn-default dropdown-toggle boxes filip-horizontal"   style="height:fit-content;"  ><i class="far fa-file-alt"> </i> <?php echo display('Create Expense') ?> </a>
                  <?php } ?>
              </div>
          
            </div>
           
      <div class="row">
         <div class="col-sm-12"  >
            <div class="panel panel-bd lobidrag"    id="panel"  style="border: 3px solid #d7d4d6;">
               <div class="panel-body">
                
                        <table class="table table-bordered" cellspacing="0" width="100%" id="purchase">
                           <thead>
                              <tr class="btnclr">
                                 <th><?php echo ('S.No')?></th>
                                 <th><?php echo  ('Purchase ID')?></th>
                                 <th><?php echo  ('Bill No')?></th>
                                 <th><?php echo ('Supplier Name')?></th>
                                 <th><?php echo ('Total Amount')?></th>
                                 <th><?php echo ('Total Tax')?></th>
                                  <th><?php echo ('Grand Total')?></th>
                                 <th><?php echo ('Paid Amount')?></th>
                                 <th><?php echo ('Balance')?></th>
                                 <th><?php echo ('Payment ID')?></th>
                                 <th><?php echo ('Grand Total Preferred Currency')?></th>
                                 <th><?php echo ('Purchase Date')?></th>
                                 <th><?php echo ('Payment Date')?></th>
                                 <th><?php echo ('Created Date')?></th>
                                  <th><?php echo ('Bill Type')?></th>
                                 <th><?php echo  ('Action')?></th>
                              </tr>
                           </thead>
                        </table>
               </div>
            </div>
         </div>
      
      </div>
     
</div>
</div>
</section>
</div>

<script>
     $(document).ready(function() {
                var invoicetable;
                if ($.fn.DataTable.isDataTable('#purchase')) {
                    $('#purchase').DataTable().clear().destroy();
                }
                var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
                var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
           invoicetable=     $('#purchase').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "lengthMenu": [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    "ajax": {
                        "url": "<?php echo base_url('Cpurchase/getpurchaseDatas?id='); ?>" +
                            encodeURIComponent('<?php echo $_GET['id']; ?>'),
                        "type": "POST",
                        "data": function(d) {
                            d['<?php echo $this->security->get_csrf_token_name(); ?>'] =
                                '<?php echo $this->security->get_csrf_hash(); ?>';
                                  d.date = $('.dateSearch').val();
                        },
                        "dataSrc": function(json) {
                           csrfHash = json[
                                '<?php echo $this->security->get_csrf_token_name(); ?>'];
                            return json.data;
                        }
                    },
                    "columns": [
                        { "data": "sl" },
                        {
                            "data": "purchase_id"
                        },
                        {
                            "data": "chalan_no"
                        },
                        {
                            "data": "supplier_id"
                        },
                        {
                            "data": "total_amt"
                        },
                        {
                            "data": "total_tax"
                        },
                        {
                            "data": "grand_total_amount"
                        },
                        {
                            "data": "paid_amount"
                        },
                        {
                            "data": "balance"
                        },
                        {
                            "data": "payment_id"
                        },
                        {
                            "data": "gtotal_preferred_currency"
                        },
                        {
                            "data": "purchase_date"
                        },
                          {
                            "data": "payment_due_date"
                        },
                          {
                            "data": "create_date"
                        },
                         {
                            "data": "source"
                        },
                        {
                            "data": "action"
                        },
                    ],
                    "columnDefs": [{
                        "orderable": false,
                        "targets": [0, 15],
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
                        localStorage.setItem('invoice', JSON.stringify(data));
                    },
                    "stateLoadCallback": function(settings) {
                        var savedState = localStorage.getItem('invoice');
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
                                        '<div style="text-align:center;"><h3>Manage Sale</h3></div>'
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
                $('.dateSearch').on('change', function() {
        invoicetable.ajax.reload();
    });
            });
            function deleteExpensedata(id) {
    var succalert = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
    var failalert = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';

    if (id !== "") {
        var confirmDelete = confirm("Are you sure you want to delete this expense?");
    
        if (confirmDelete) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo base_url(); ?>Cpurchase/deleteExpensedata",
                data: {[csrfName]: csrfHash, id: id},
                success: function(response) {
                    console.log(response, "response");
                    if (response.status === 'success') {
                        $('.error_display').html(succalert + response.msg + '</div>');
                        window.setTimeout(function() {
                            location.reload();
                            // quotationDataTable.ajax.reload();
                            // $('.error_display').html('');
                        }, 2500);
                    } else {
                        $('.error_display').html(failalert + response.msg + '</div>'); 
                    }
                },
                error: function() {
                    $('.error_display').html(failalert + 'An unexpected error occurred. Please try again.' + '</div>');
                }
            });
        }
    }
}

 </script>