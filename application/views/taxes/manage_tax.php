<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/calanderstyle.css">
<div class="content-wrapper">
    <section class="content-header">
       <div class="header-icon">
          <figure class="one">
          <img src="<?php echo base_url() ;?>asset/images/tax.png" class="headshotphoto" style="height:50px;" />
       </div>
       <div class="header-title">
          <div class="logo-holder logo-9">
             <h1><?php echo display('manage_tax') ?></h1>
          </div>
          <small></small>
          <ol class="breadcrumb" style="border: 3px solid #d7d4d6;">
             <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
             <li><a href="#"><?php echo 'Taxes' ?></a></li>
             <li class="active" style="color:orange;"><?php echo display('manage_tax') ?></li>
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
             <div class="col-sm-6" style="display: flex; align-items: left; ">
               <a href="<?php echo base_url('Caccounts/add_taxes?id=' . $_GET['id']); ?>" class="btnclr btn btn-default dropdown-toggle" style="height: fit-content;"><i class="far fa-file-alt"></i> <?php echo display('create'); ?> <?php echo display('taxes'); ?></a>
               </div>
               <div class="col-md-6 col-sm-6">
                    <div class="search">
                      <span class="fa fa-search"></span>
                      <input class="dateSearch daterangepicker_field" placeholder="Search term">
                    </div>
               </div>
            </div>   
         </div>
         <div class="row">
            <div class="col-sm-12">
               <div class="panel panel-bd lobidrag">
                <br>
                <div class="error_display"></div>
                <br>
                  <div class="panel-body" style="border: 3px solid #D7D4D6;">
                     <table class="table table-bordered" cellspacing="0" width="100%" id="tax_list">
                        <thead>
                           <tr class="btnclr">
                              <th><?php echo 'S.No'; ?></th>
                              <th><?php echo 'Tax ID'; ?></th>
                              <th><?php echo 'Tax'; ?></th>
                              <th><?php echo 'Description'; ?></th>
                              <th><?php echo 'Tax Agency'; ?></th>
                              <th><?php echo 'Account'; ?></th>
                              <th><?php echo 'Show Tax On Return Line'; ?></th>
                              <th><?php echo 'Type'; ?></th>
                              <th><?php echo 'Date'; ?></th>
                              <th><?php echo display('Action'); ?></th>
                           </tr>
                        </thead>
                     </table>
                  </div>
               </div>     
            </div>
         </div>
       </div>
    </section>
</div>

<script src='<?php echo base_url();?>assets/js/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.0/knockout-debug.js'></script>
<script  src="<?php echo base_url() ?>assets/js/scripts.js"></script> 
<script type="text/javascript">
var taxDataTable;
$(document).ready(function() {
$(".sidebar-mini").addClass('sidebar-collapse') ;
    if ($.fn.DataTable.isDataTable('#tax_list')) {
        $('#tax_list').DataTable().clear().destroy();
    }
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    taxDataTable = $('#tax_list').DataTable({
        "processing": true,
        "serverSide": true,
        "lengthMenu": [
            [10, 25, 50, 100],
            [10, 25, 50, 100]
        ],
        "ajax": {
            "url": "<?php echo base_url('Caccounts/getTaxesData?id='); ?>" +
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
         { "data": "id" },
         { "data": "tax_id" },
         { "data": "tax" },
         { "data": "description" },
         { "data": "tax_agency" },
         { "data": "account" },
         { "data": "show_taxonreturn" },
         { "data": "status_type" },
         { "data": "created_date" },
         { "data": "action" }
         ],
        "columnDefs": [{
            "orderable": false,
            "targets": [0, 9],
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
            localStorage.setItem('taxes', JSON.stringify(data));
        },
        "stateLoadCallback": function(settings) {
            var savedState = localStorage.getItem('taxes');
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
                            '<div style="text-align:center;"><h3>Manage Taxes</h3></div>'
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
    
    $('.apply-btn').on('click', function() {
        taxDataTable.ajax.reload();
    });
});


// Delete Tax Data - Madhu
function deleteTaxdata(id) 
{
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

    var succalert = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
    
    var failalert = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
    if (id !== "") {
        var confirmDelete = confirm("Are you sure you want to delete this tax information?");
    
        if (confirmDelete) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo base_url(); ?>Caccounts/taxdelete",
                data: {[csrfName]: csrfHash, id: id},
                success: function(response) {
                    console.log(response, "response");
                    if (response.status === 'success') {
                        $('.error_display').html(succalert + response.msg + '</div>');
                        window.setTimeout(function() {
                            taxDataTable.ajax.reload(null, false);
                            $('.error_display').html('');
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

<style type="text/css">
.search {
position: relative;
color: #aaa;
font-size: 16px;
}

.search {display: inline-block;}

.search input {
  width: 260px;
  height: 34px;

  background: #fff;
  border: 1px solid #fff;
  border-radius: 5px;
  box-shadow: 0 0 3px #ccc, 0 10px 15px #fff inset;
  color: #000;
}

.search input { text-indent: 32px;}
.search .fa-search { 
  position: absolute;
  top: 8px;
  left: 10px;
}

.bg-success{
    background-color: green !important;
    color: #fff;
}

.bg-warning{
    background-color: #ffc107 !important;
    color: #fff;
}

.bg-info{
    background-color: #0dcaf0 !important;
    color: #fff;
}


.search .fa-search {left: auto; right: 10px;}
</style>
