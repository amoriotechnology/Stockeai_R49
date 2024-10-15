<!-- Manage Language Start -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>my-assets/css/css.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet' href='https://fullcalendar.io/js/fullcalendar-2.4.0/fullcalendar.css'>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
<div class="content-wrapper">
   <section class="content-header">
      <div class="header-icon">
         <i class="pe-7s-note2"></i>
      </div>
      <div class="header-title">
         <h1><?php echo 'Calendar View' ?></h1>
         <small></small>
         <ol class="breadcrumb">
            <li><a href="javascript:void(0);"><i class="pe-7s-home"></i> <?php echo 'Home' ?></a></li>
            <li class="active" style="color: orange;"><?php echo 'Calendar' ?></li>
         </ol>
      </div>
   </section>
   <style>
      th{
      text-align:center;
      }
   </style>
   <section class="content">
      <!-- Manage Language -->
      <?php
         $message = $this->session->userdata('message');
         if (isset($message)) {
         ?>
      <div class="alert alert-info alert-dismissable" style="background-color:#38469f;color:white;font-weight:bold;">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         <?php echo $message ?>                    
      </div>
      <?php 
         }
         ?>
      <div class="row">
         <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
               <div class="panel-heading">
                  <div class="panel-title">
                     <button class="btn btnclr" id="reminder_task" data-toggle="modal" data-target="#reminderModal">+ Add Reminder</button>
                     <a href="<?php echo base_url('Cweb_setting') ?>" class="btn btnclr text-white">Manage Setting</a>
                     <button class="btn btnclr" data-toggle="modal" data-target="#schedulerModal"><i class="ti-alarm-clock"></i>&nbsp;Scheduler Status</button>
                  </div>
               </div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <div id="calendar"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
</div>

<!-- Scheuler List -->

<div class="modal fade" id="schedulerModal" role="dialog">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header" style="color:white;background-color:#38469f;">
            <a href="#" class="close" data-dismiss="modal">&times;</a>
            <h4 class="modal-title"><?php echo 'Scheduler List' ?></h4>
         </div>
         <div class="modal-body">
            <div class="panel-body">
               <table class="table table-bordered">
                     <thead>
                       <tr>
                           <th class="color_text">S.No</th>
                           <th class="color_text">ID</th>
                           <th class="color_text">Name</th>
                           <th class="color_text">Date / Time</th>
                           <th class="color_text">Status</th>
                       </tr>
                     </thead>
                     <tbody>
                     <?php 
                     $status1 = 'Scheduled';
                     if(!empty($allData)){ $s=1; foreach ($allData as $value) { ?>
                        <tr>
                           <td><?php echo $s; ?></td>
                           <td><b><?php echo $value->invoice_id; ?></b></td>
                           <td><?php echo $value->title; ?></td>
                           <td><?php echo date('Y-m-d H:i:A',strtotime($value->start)); ?></td>
                           <td>
                              <?php if($value->schedule_status == 1){echo "<span class='badge badge-success'>".$status1."</span>";}else{echo "<span class='badge badge-success'>No Scheduled List</span>";} ?>
                           </td>
                        </tr>
                     <?php $s++; } }else { ?> 
                        <tr>
                           <td colspan="5" class="text-center">No Schedule Found</td>
                        </tr>
                     <?php } ?>    
                     </tbody>
                  </table>
            </div>
         </div>
   </div>
</div>
</div>

<!-- Calandar View -->

<div class="modal fade" id="reminderModal" role="dialog">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header" style="color:white;background-color:#38469f;">
            <a href="#" class="close" data-dismiss="modal">&times;</a>
            <h4 class="modal-title"><?php echo 'Add Reminder' ?></h4>
         </div>
         <div class="modal-body">
            <form id="addreminder" class="addreminder" method="post">
               <div class="panel-body">
                  <div id="errormessage"></div>
                    <div class="row">
                       <div class="col-md-12">
                         <label>Title <span class="text-danger">*</span></label>
                         <input type="text" name="title" id="title" class="form-control" placeholder="Enter your Title">
                         <div id="error_title" class="text-danger"></div>
                         <input type="hidden" id="admin_company_id" name="admin_company_id" value="<?php echo $_GET['id']; ?>">
                         <br>
                       </div>
                       <div class="col-md-12">
                         <label>Description</label>
                         <input type="text" name="description" id="description" class="form-control" placeholder="Enter your Description">
                         <br>
                       </div>
                       <div class="col-md-12">
                         <label>Schedule From <span class="text-danger">*</span></label>
                         <input type="datetime-local" name="start" id="start" class="form-control">
                         <div id="error_start" class="text-danger"></div>
                         <br>
                       </div>
                       <div class="col-md-12">
                         <label>Schedule To <span class="text-danger">*</span></label>
                         <input type="datetime-local" name="end" id="end" class="form-control">
                         <div id="error_end" class="text-danger"></div>
                         <br>
                       </div>
                       <div class="col-md-12">
                         <button type="submit" id="insertreminder" class="btn btn-primary btn-md">Save</button>
                       </div>
                    </div>
               </div>
            </form>
      </div>
   </div>
</div>

<style type="text/css">
   .btn-info{
      background-color: #38469f !important;
      border-color: #38469f !important;
   }

   .badge{
      background-color: #28a745 !important;
   }
   
   .color_text{
       color: #000 !important;
   }

   .fc-time{
      display: none !important;
   }
   .fc-event{
      border: 1px solid #424f5c;
      background-color: #424f5c;
   }
</style>

<script src='https://fullcalendar.io/js/fullcalendar-2.4.0/lib/moment.min.js'></script>
<script src='https://fullcalendar.io/js/fullcalendar-2.4.0/lib/jquery.min.js'></script>
<script src='https://fullcalendar.io/js/fullcalendar-2.4.0/fullcalendar.min.js'></script>

<script type="text/javascript">
  $(document).ready(function() {
    var insertdata = '<?php echo $insertdata; ?>';
    var eventData = JSON.parse(insertdata);
    var currentDate = new Date();
    
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay',
        },
        defaultDate: currentDate,
        editable: true,
        eventLimit: true,
        events: eventData, 
        eventRender: function(event, element) {
            var start = moment(event.start);
            var end = moment(event.end);
            if (start.isValid() && end.isValid()) {
                element.find('.fc-title').append(
                    "<br/>Start: " + start.format('MM-DD-YYYY hh:mm A') + 
                    "<br/>End: " + end.format('MM-DD-YYYY hh:mm A')
                );
            } else {
                console.warn('Invalid start or end date', event);
            }
        }
    });

    $('#calendar').on('click', '.fc-prev-button, .fc-next-button', function() {
        $('#calendar').fullCalendar('removeEvents');
        $('#calendar').fullCalendar('addEventSource', eventData);
    });
});




// Validation in Add Reminder
$(document).ready(function(){
    var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
    var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
    var succalert = '<div class="alert alert-success alert-dismissible text-left" role="alert">';
    var failalert = '<div class="alert alert-danger alert-dismissible text-left" role="alert">';

    $('#insertreminder').on('click', function(event) {
       event.preventDefault(); 
       
       var title = $('#title').val().trim();
       var start = $('#start').val().trim();
       var end = $('#end').val().trim();
       var adminid = $('#admin_company_id').val();
       
       $('#error_title').text('');
       $('#error_start').text('');
       $('#error_end').text('');

       var isValid = true;

       if (title === '') {
           $('#error_title').text('Title is required.');
           isValid = false;
       }

       if (start === '') {
           $('#error_start').text('Start date is required.');
           isValid = false;
       }

       if (end === '') {
           $('#error_end').text('End date is required.');
           isValid = false;
       } else if (start !== '' && new Date(start) > new Date(end)) {
           $('#error_end').text('End date must be after start date.');
           isValid = false;
       }
       if (isValid) {
         $.ajax({
              type:"POST",
              dataType:"json",
              url:"<?php echo base_url(); ?>Cweb_setting/add_reminder",
              data:{<?php echo $this->security->get_csrf_token_name();?>: csrfHash, title: title, start: start, end: end, adminid: adminid},
              success:function (response) {
                  console.log(response);
                  if(response.status =='success'){
                     $('#errormessage').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
                  
                     window.setTimeout(function(){
                        $('#reminderModal').modal('hide');
                        $('.addreminder')[0].reset();
                        location.reload();
                     },2000);
                  }else{
                     $('#errormessage').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
                  }
              }
          });
      }
   });

});

$(document).ready(function(){
  $('body').removeClass('hold-transition');
  $('.pe-7s-keypad').click(function(event){
   event.preventDefault();
   if ($('body').hasClass('sidebar-collapse')) {
      $('body').removeClass('sidebar-collapse');
   } else {
      $('body').addClass('sidebar-mini pace-done sidebar-collapse');
   }
  });

  $('.treeview').click(function(event){
   event.preventDefault();
    // $('.treeview').addClass('active');
    $('.treeview-menu').addClass('menu-open');
  });
});
</script>

