<style>
.switch {
  margin-top: 5px;
  position: relative;
  display: inline-block;
  vertical-align: top;
  width: 56px;
  height: 20px;
  padding: 3px;
  background-color: white;
  border-radius: 18px;
  box-shadow: inset 0 -1px white, inset 0 1px 1px rgba(0, 0, 0, 0.05);
  cursor: pointer;
  background-image: -webkit-linear-gradient(top, #EEEEEE, white 25px);
  background-image: -moz-linear-gradient(top, #EEEEEE, white 25px);
  background-image: -o-linear-gradient(top, #EEEEEE, white 25px);
  background-image: linear-gradient(to bottom, #EEEEEE, white 25px);
}
.switch-input {
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0;
}
.switch-label {
  position: relative;
  display: block;
  height: inherit;
  font-size: 10px;
  text-transform: uppercase;
  background: #ECEEEF;
  border-radius: inherit;
  box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.12), inset 0 0 2px rgba(0, 0, 0, 0.15);
  -webkit-transition: 0.15s ease-out;
  -moz-transition: 0.15s ease-out;
  -o-transition: 0.15s ease-out;
  transition: 0.15s ease-out;
  -webkit-transition-property: opacity background;
  -moz-transition-property: opacity background;
  -o-transition-property: opacity background;
  transition-property: opacity background;
}
.switch-label:before, .switch-label:after {
  position: absolute;
  top: 50%;
  margin-top: -.5em;
  line-height: 1;
  -webkit-transition: inherit;
  -moz-transition: inherit;
  -o-transition: inherit;
  transition: inherit;
}
.switch-label:before {
  content: attr(data-off);
  right: 11px;
  color: #aaa;
  text-shadow: 0 1px rgba(255, 255, 255, 0.5);
}
.switch-label:after {
  content: attr(data-on);
  left: 11px;
  color: white;
  text-shadow: 0 1px rgba(0, 0, 0, 0.2);
  opacity: 0;
}
.switch-input:checked ~ .switch-label {
  background: #38469F;
  box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.15), inset 0 0 3px rgba(0, 0, 0, 0.2);
}
.switch-input:checked ~ .switch-label:before {
  opacity: 0;
}
.switch-input:checked ~ .switch-label:after {
  opacity: 1;
}
.switch-handle {
  position: absolute;
  top: 4px;
  left: 4px;
  width: 18px;
  height: 18px;
  background: white;
  border-radius: 10px;
  box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.2);
  background-image: -webkit-linear-gradient(top, white 40%, #F0F0F0);
  background-image: -moz-linear-gradient(top, white 40%, #F0F0F0);
  background-image: -o-linear-gradient(top, white 40%, #F0F0F0);
  background-image: linear-gradient(to bottom, white 40%, #F0F0F0);
  -webkit-transition: left 0.15s ease-out;
  -moz-transition: left 0.15s ease-out;
  -o-transition: left 0.15s ease-out;
  transition: left 0.15s ease-out;
}
.switch-handle:before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  margin: -6px 0 0 -6px;
  width: 12px;
  height: 12px;
  background: #F9F9F9;
  border-radius: 6px;
  box-shadow: inset 0 1px rgba(0, 0, 0, 0.02);
  background-image: -webkit-linear-gradient(top, #EEEEEE, white);
  background-image: -moz-linear-gradient(top, #EEEEEE, white);
  background-image: -o-linear-gradient(top, #EEEEEE, white);
  background-image: linear-gradient(to bottom, #EEEEEE, white);
}
.switch-input:checked ~ .switch-handle {
  left: 85px;
  box-shadow: -1px 1px 5px rgba(0, 0, 0, 0.2);
}
.switch-green > .switch-input:checked ~ .switch-label {
  background: #4FB845;
}
a.disabled {
  pointer-events: none;
  cursor: default;
}
.table {
    width: 100%;  
    table-layout: fixed;  
}
.table th,
.table td {
    width: auto;  
     border: 1px solid #ccc;
    padding: 8px;
 }
.table input[type="text"],input[type="time"] {
    text-align:center;
    background-color: inherit; 
     border-radius: 4px;
    padding: 8px;
 }
.btnclr{
       background-color:<?php echo $setting_detail[0]['button_color']; ?>;
       color: white;
   }
      input {border:0;outline:0;}
    .work_table td {
        height: 36px;
    }
th,td{
    text-align:center;
}
    .select2-selection{
        display :none;
    }
    .btnclr{
       background-color:<?php echo $setting_detail[0]['button_color']; ?>;
       color: white;
   }
</style>
<div class="content-wrapper">
    <section class="content-header" style="height:70px;">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Edit TimeSheet</h1>
            <small></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#">HRM</a></li>
                <li class="active" style="color:orange">Edit Timesheet</li>
            </ol>
        </div>
    </section>
    <section class="content">
        <!-- New category -->
        <div class="row">
            <div class="col-sm-12">                
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading" style="height:50px;">
                        <div class="panel-title">
                         <a style="float:right;color:white;" href="<?php echo base_url('Chrm/manage_timesheet?id='.$_GET['id']); ?>" class="btnclr btn  m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo "Manage TimeSheet" ?> </a>
                        </div>
                    </div>
                    <div class="panel-body">
                    <div class="errormessage"></div>
                    <div class="error_display"></div>
                   <form id="create_timesheet"  method="post">
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="customer" class="col-sm-4 col-form-label">Employee Name<i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                       <input  type="hidden"   readonly id="tsheet_id" value="<?php echo $time_sheet_data[0]['timesheet_id'];?>" name="tsheet_id" />
                       <input  type="hidden"   readonly id="unique_id" value="<?php echo $time_sheet_data[0]['unique_id'];?>" name="unique_id" />          
                              <select name="templ_name"  readonly    id="templ_name" class="form-control"     tabindex="3" style="width100" >
        <option   value="<?php  echo $employee_name[0]['id'] ;?>"> <?php echo $employee_name[0]['first_name']." ".$employee_name[0]['last_name'] ?></option>
        </select>
                                </div>
                            </div>
                         <div class="col-sm-6">
                                <label for="qdate" class="col-sm-4 col-form-label">Job title</label>
                              <div class="col-sm-8">
                              <input type="text" name="job_title" id="job_title"  readonly  placeholder="Job title" value="<?php  echo $time_sheet_data[0]['job_title']; ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                            <div class="form-group row">
                            <div class="col-sm-6">
                            <label for="dailybreak" class="col-sm-4 col-form-label">Date Range<i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                            <input id="reportrange" type="text" readonly name="date_range" <?php if($time_sheet_data[0]['uneditable']==1){ echo 'readonly';}  ?> value="<?php echo $time_sheet_data[0]['month'] ; ?>" class="form-control"/>
                            </div>
                            </div>
                        <div class="form-group row">
                             <div class="col-sm-6">
                             <label for="dailybreak" class="col-sm-4 col-form-label">Payroll Type <i class="text-danger"></i></label>
                             <div class="col-sm-8">
                             <input id="payroll_type" name="payroll_type" type="text" value="<?php echo $employee_name[0]['payroll_type'] ; ?>" style="margin-left: -4px;width: 493px;" readonly class="form-control"/>
                            </div>
                             </div>
                            </div>
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                            <input id="week_one" name="week_one" type="hidden" value="<?php echo $time_sheet_data[0]['week_one'] ; ?>"       readonly class="form-control"/>
                            <input id="week_two" name="week_two" type="hidden" value="<?php echo $time_sheet_data[0]['week_two'] ; ?>"       readonly class="form-control"/>
                            <input id="week_three" name="week_three" type="hidden" value="<?php echo $time_sheet_data[0]['week_three'] ; ?>"   readonly class="form-control"/>
                            <input type="hidden" name="id"  id="id" value="<?php echo  $encodedId; ?>">
                            <div class="table-responsive work_table col-md-12">
                        <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="PurList"> 
                                        <thead>
									<tr style="text-align:center;" class ="btnclr" >
                                        <?php if ($employee_name[0]['payroll_type'] == 'Hourly') { ?>
                                            <th style='height:25px;' class="col-md-2">Date</th>
                        <?php } elseif ($employee_name[0]['payroll_type'] == 'Salaried-weekly' || $employee_name[0]['payroll_type'] == 'Salaried-BiWeekly' || $employee_name[0]['payroll_type'] == 'Salaried-Monthly' || $employee_name[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>
                            <th style='height:25px;' class="col-md-2">Date</th>
                            <?php } elseif ($employee_name[0]['payroll_type'] == 'SalesCommission') { ?>
                        <?php } ?>
                                                                <?php if ($employee_name[0]['payroll_type'] == 'Hourly') { ?>
                                                                    <th style='height:25px;' class="col-md-1">Day</th>
                        <?php } elseif ($employee_name[0]['payroll_type'] == 'Salaried-weekly' || $employee_name[0]['payroll_type'] == 'Salaried-BiWeekly' || $employee_name[0]['payroll_type'] == 'Salaried-Monthly' || $employee_name[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>
                            <th style='height:25px;' class="col-md-1">Day</th>
                            <?php } elseif ($employee_name[0]['payroll_type'] == 'SalesCommission') { ?>
                        <?php } ?>
                                                                <?php if ($employee_name[0]['payroll_type'] == 'Hourly') { ?>
                                                                    <th class="col-md-1">Daily Break in mins</th>
                        <?php } elseif ($employee_name[0]['payroll_type'] == 'Salaried-weekly' || $employee_name[0]['payroll_type'] == 'Salaried-BiWeekly' || $employee_name[0]['payroll_type'] == 'Salaried-Monthly' || $employee_name[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>
                        <?php } elseif ($employee_name[0]['payroll_type'] == 'SalesCommission') { ?>
                        <?php } ?>
                                                                <?php if ($employee_name[0]['payroll_type'] == 'Hourly') { ?>
                                                                    <th style='height:25px;' class="col-md-2">Start Time (HH:MM)</th>
                        <?php } elseif ($employee_name[0]['payroll_type'] == 'Salaried-weekly' || $employee_name[0]['payroll_type'] == 'Salaried-BiWeekly' || $employee_name[0]['payroll_type'] == 'Salaried-Monthly' || $employee_name[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>
                        <?php } elseif ($employee_name[0]['payroll_type'] == 'SalesCommission') { ?>
                        <?php } ?>
                                                                <?php if ($employee_name[0]['payroll_type'] == 'Hourly') { ?>
                                                                    <th style='height:25px;' class="col-md-2">End Time (HH:MM)</th>
                        <?php } elseif ($employee_name[0]['payroll_type'] == 'Salaried-weekly' || $employee_name[0]['payroll_type'] == 'Salaried-BiWeekly' || $employee_name[0]['payroll_type'] == 'Salaried-Monthly' || $employee_name[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>
                        <?php } elseif ($employee_name[0]['payroll_type'] == 'SalesCommission') { ?>
                        <?php } ?>
                                                                <?php if ($employee_name[0]['payroll_type'] == 'Hourly') { ?>
                            <th style='height:25px;' class="col-md-5">Hours</th>
                        <?php } elseif ($employee_name[0]['payroll_type'] == 'Salaried-weekly' || $employee_name[0]['payroll_type'] == 'Salaried-BiWeekly' || $employee_name[0]['payroll_type'] == 'Salaried-Monthly' || $employee_name[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>
                            <th style='height:25px; ' class="col-md-5">Present / Absence</th>
                        <?php } elseif ($employee_name[0]['payroll_type'] == 'SalesCommission') { ?>
                        <?php } ?>
                                                                <?php if ($employee_name[0]['payroll_type'] == 'Hourly') { ?>
                                                                    <th style='height:25px;' class="col-md-5">Action</th>
                        <?php } elseif ($employee_name[0]['payroll_type'] == 'Salaried-weekly' || $employee_name[0]['payroll_type'] == 'Salaried-BiWeekly' || $employee_name[0]['payroll_type'] == 'Salaried-Monthly' || $employee_name[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>
                        <?php } elseif ($employee_name[0]['payroll_type'] == 'SalesCommission') { ?>
                        <?php } ?> 
                                    </tr>
								</thead>
                                <?php   if($employee_name[0]['payroll_type'] == 'Hourly') { ?>
								<tbody id="tBody">
                          <?php
     function compareDates($a, $b) {
        $dateA = DateTime::createFromFormat('d/m/Y', $a['Date']);
        $dateB = DateTime::createFromFormat('d/m/Y', $b['Date']);
        if ($dateA === false || $dateB === false) {
            return 0;  
        }
        return $dateA <=> $dateB;
    }
     usort($time_sheet_data, 'compareDates');
     $printedDates = array();
     foreach($time_sheet_data as $tsheet) {
        if( !empty($tsheet['hours_per_day']) && !in_array($tsheet['Date'], $printedDates)) {
             $printedDates[] = $tsheet['Date'];
?>
         <tr>
                <td class="date">
                    <input type="text" <?php if ($tsheet['uneditable'] == 1) { echo 'readonly'; } ?> value="<?php echo empty($tsheet['Date']) ? 'readonly' : $tsheet['Date']; ?>" name="date[]">
                </td>
                <td class="day">
                    <input type="text" <?php if ($tsheet['uneditable'] == 1) { echo 'readonly'; } ?> value="<?php echo empty($tsheet['Day']) ? 'readonly' : $tsheet['Day']; ?>" name="day[]">
                </td>
                <td style="text-align:center;" class="daily-break">
                 <select name="dailybreak[]" 
                 <?php if ($tsheet['uneditable'] == 1) { echo 'disabled'; } ?>  
                  class="form-control datepicker dailybreak" 
                  style="width: 100px; margin: auto; display: block;">
                  <option value="<?php echo $tsheet['daily_break']; ?>">
                  <?php echo $tsheet['daily_break']; ?>
                  </option>
                  <?php foreach ($dailybreak as $dbd) { ?>
                        <option value="<?php echo $dbd['dailybreak_name']; ?>">
                            <?php echo $dbd['dailybreak_name']; ?>
                        </option>
                    <?php } ?>
                    </select>
                </td>
                <td class="start-time">
                    <input <?php if ($tsheet['uneditable'] == 1) { echo 'readonly'; } ?> name="start[]" class="hasTimepicker start" value="<?php echo empty($tsheet['Day']) ? 'readonly' : $tsheet['time_start']; ?>" type="time">
                </td>
                <td class="finish-time">
                    <input <?php if ($tsheet['uneditable'] == 1) { echo 'readonly'; } ?> name="end[]" class="hasTimepicker end" value="<?php echo empty($tsheet['Day']) ? 'readonly' : $tsheet['time_end']; ?>" type="time">
                </td>
                <td class="hours-worked">
                    <input readonly name="sum[]" class="timeSum" value="<?php echo empty($tsheet['Day']) ? 'readonly' : $tsheet['hours_per_day']; ?>" type="text">
                </td>
                <td>
                    <a style="color:white;" class="delete_day btnclr btn  m-b-5 m-r-2 <?php if ($tsheet['uneditable'] == 1) { echo 'disabled'; } ?> "><i class="fa fa-trash" aria-hidden="true"></i> </a>
             </td>
            </tr>
<?php
        }
    }
?>
		</tbody>
         <?php } elseif ($employee_name[0]['payroll_type'] == 'Salaried-weekly' || $employee_name[0]['payroll_type'] == 'Salaried-BiWeekly' || $employee_name[0]['payroll_type'] == 'Salaried-Monthly' || $employee_name[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>
           <tbody id="tBody">
    <?php
     $i = 0;
     function compareDates($a, $b) {
        $dateA = DateTime::createFromFormat('d/m/Y', $a['Date']);
        $dateB = DateTime::createFromFormat('d/m/Y', $b['Date']);
        if ($dateA === false || $dateB === false) {
            return 0; 
        }
        return $dateA <=> $dateB;
    }
     usort($time_sheet_data, 'compareDates');
     $printedDates = array();
     foreach($time_sheet_data as $tsheet) {
        if( empty($tsheet['hours_per_day']) && !in_array($tsheet['Date'], $printedDates)) {
             $printedDates[] = $tsheet['Date'];
            ?>
            <tr>
                <td class="date">
                    <input type="text" <?php if ($tsheet['uneditable'] == 1) { echo 'readonly'; } ?> value="<?php echo empty($tsheet['Date']) ? 'readonly' : $tsheet['Date']; ?>" name="date[]">
                </td>
                <td class="day">
                    <input type="text" <?php if ($tsheet['uneditable'] == 1) { echo 'readonly'; } ?> value="<?php echo empty($tsheet['Day']) ? 'readonly' : $tsheet['Day']; ?>" name="day[]">
                </td>
                <?php if ($employee_name[0]['payroll_type'] == 'Salaried-weekly' || $employee_name[0]['payroll_type'] == 'Salaried-BiWeekly' || $employee_name[0]['payroll_type'] == 'Salaried-Monthly' || $employee_name[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>
                    <td class="hours-worked">
                        <label class="switch" style="width:100px;">
                                                <input type="checkbox" class="timeSum present checkbox switch-input"
                            id="blockcheck_<?php echo $i; ?>" name="present[]"
                            <?php if ($tsheet['uneditable'] == 1) { echo 'disabled'; } ?>
                            <?php echo (isset($tsheet['present']) && $tsheet['present'] === 'present') ? 'checked="checked"' : ''; ?>
                            data-present="<?php echo $tsheet['present'] ?? ''; ?>">
                            <span class="switch-label" data-on="Present" data-off="Absent"></span>
                            <span class="switch-handle"></span>
                        </label>
                        <input type="hidden" name="block[]" id="block_<?php echo $i; ?>"  value="<?php echo (isset($tsheet['present']) && $tsheet['present'] === 'absent') ? 'absent' : 'present'; ?>" />
                    </td>
                <?php } ?>
            </tr>
            <?php
             $i++;
        }
    }
    ?>
</tbody>             
        <?php  }   ?>
                                <tfoot>
                                            <tr style="text-align:end"> 
 <?php if ($employee_name[0]['payroll_type'] == 'Hourly') { ?>
   <td colspan="5" class="text-right" style="font-weight:bold;">Total Hours :</td> 
 <td style="text-align: center;"> <input  type="text"   readonly id="total_net" value="<?php echo $time_sheet_data[0]['total_hours'] ; ?>" name="total_net" />    </td> 
<?php } elseif ($employee_name[0]['payroll_type'] == 'Salaried-weekly' || $employee_name[0]['payroll_type'] == 'Salaried-BiWeekly' || $employee_name[0]['payroll_type'] == 'Salaried-Monthly' || $employee_name[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>
<td colspan="2" class="text-right" style="font-weight:bold;">No of Days:</td> 
 <td style="text-align: center;"> <input  type="text"   readonly id="total_net" value="<?php echo $time_sheet_data[0]['total_hours'] ; ?>" name="total_net" />    </td> 
<?php } elseif ($employee_name[0]['payroll_type'] == 'SalesCommission') { ?>
<?php } ?>
            </tr> 
                                </tfoot>
		                    </table>     
		                </div>
                    <div class="col-sm-12 text-center">
                        <label for="example-text-input" class="col-sm-0 col-form-label"></label>
                          <div class="col-sm-12">  
                          <?php if ($time_sheet_data[0]['uneditable'] == 0): ?>
    <input type="submit" class="btnclr btn btn-large" value="Submit" tabindex="7" />
<?php else: ?>
    <h3>The timesheet has been generated and is not editable.</h3>
<?php endif; ?>
                               <a href="<?php echo base_url('Chrm/manage_timesheet?id='.$encodedId); ?>" class="btn btn-info">Cancel</a>      
                         </div>
                    </div>
                     </form>
                  </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
$(document).ready(function(){
var succalert = '<div class="alert alert-success alert-dismissible" role="alert">';
var failalert = '<div class="alert alert-danger alert-dismissible" role="alert">';
$("#create_timesheet").validate({
  rules: {
    templ_name: "required",  
  },
  messages: {
    templ_name: "Employee Name is required",
  },
  submitHandler: function(form) {
    var formData = new FormData(form);
    formData.append(csrfName, csrfHash);
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "<?php echo base_url('Chrm/pay_slip'); ?>",
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
         console.log(response, "response");
         if(response.status == 'success')
         {
          $('.error_display').html(succalert + 'TimeSheet Updated Successfully' + '</div>');
          console.log(response.msg, "Success");
          window.setTimeout(function(){
            window.location = "<?php echo base_url('Chrm/manage_timesheet?id='.$encodedId); ?>"
          },2500);
         }else{
          $('.error_display').html(failalert+response.Time+'</div>'); 
          console.log(response.msg, "Error");
         }
      },
      error: function(xhr, status, error) {
        alert('An error occurred: ' + error);
      }
    })
  }
});
});
</script>
<!------ add new Duration-->  
<div class="modal fade" id="add_admst" role="dialog">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header"  >
            <a href="#" class="close" data-dismiss="modal">&times;</a>
            <h4 class="modal-title"><?php echo ('Add New Administrator ') ?></h4>
        </div>
        <div class="modal-body">
            <div id="customeMessage" class="alert hide"></div>
  <form id="insert_adm" method="post">
    <div class="panel-body">
<input type ="hidden" name="csrf_test_name" id="" value="<?php echo $this->security->get_csrf_hash();?>">
        <div class="form-group row">
            <label for="adms_name" class="col-sm-4 col-form-label" ><?php echo ('Administrator Name') ?> <i class="text-danger">*</i></label>
            <div class="col-sm-6">
                <input class="form-control" name ="adms_name" id="adms_name" type="text" placeholder="Administrator Name"   required="" tabindex="1">
            </div>
</div>
<input type ="hidden" name="csrf_test_name" id="" value="<?php echo $this->security->get_csrf_hash();?>">
<div class="form-group row">
<label for="address" class="col-sm-4 col-form-label" ><?php echo ('Administrator Address') ?> </label>
<div class="col-sm-6">
    <input class="form-control" name ="address" id="address" type="text" placeholder="Administrator Adress"   required="" tabindex="1">
</div>
</div>
    </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" style="color:white;background-color:#38469f;" data-dismiss="modal"><?php echo display('Close') ?> </a>
            <input type="submit" class="btn" style="color:white;background-color: #38469f;" value=<?php echo display('Submit') ?>>
        </div>
                                </form>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js"></script>
<script>
 var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
    $('#insert_adm').submit(function (event) {
        event.preventDefault();
var dataString = {
    dataString : $("#insert_adm").serialize()
};
dataString[csrfName] = csrfHash;
$.ajax({
    type:"POST",
    dataType:"json",
    url:"<?php echo base_url(); ?>Chrm/insert_data_adsr",
    data:$("#insert_adm").serialize(),
    success:function (data1) {
    var $select = $('select#insert_adm');
        $select.empty();
          for(var i = 0; i < data1.length; i++) {
    var option = $('<option/>').attr('value', data1[i].adms_name).text(data1[i].adms_name);
    $select.append(option);  
}
    }
});
});
var data = {
    value:$('#customer_name').val()
};
var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
$('body').on('input select change','#reportrange',function(){
    var date = $(this).val();
    $('#tBody').empty();
    const myArray = date.split("-");
    var start = myArray[0];
    var s_split=start.split("/");
    var end = myArray[1];
    var e_split=end.split("/");
    const weekDays = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    let chosenDate = start;  
    var Date1 = new Date (s_split[2], s_split[0], s_split[1]);
var Date2 = new Date (e_split[2], e_split[0], e_split[1]);
var Days = Math.round((Date2.getTime() - Date1.getTime())/(1000*60*60*24));
console.log(s_split[2]+"/"+ s_split[1]+"/"+ s_split[0]+"/"+Days);
    const validDate = new Date(chosenDate);
    let newDate;
        const monStartWeekDays = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
        for(let i = 0; i <= Days; i++) {  
          newDate = new Date(validDate);  
          newDate.setDate(validDate.getDate() + i);  
            var date=$('#date_'+i).html();
     var day=$('#day_'+i).html();
           $('#tBody').append( `
          <tr >
            <td  class="date" id="date_`+i+`"><input type="hidden" value="`+`${newDate.getDate()}/${newDate.getMonth() + 1}/${newDate.getFullYear()}" name="date[]"   />`+`${newDate.getDate()} / ${newDate.getMonth() + 1} / ${newDate.getFullYear()}</td>
            <td  class="day" id="day_`+i+`"><input type="hidden" value="`+`${weekDays[newDate.getDay()].slice(0,10)}" name="day[]"   />`+`${weekDays[newDate.getDay()].slice(0,10)}</td>
            <?php if ($time_sheet_data[0]['payroll_type'] == 'Hourly') { ?>
    <td style="text-align:center;" class="daily-break_<?php echo $i; ?>">
        <select name="dailybreak[]" class="form-control datepicker dailybreak" style="width: 100px; margin: auto; display: block;">
            <?php foreach ($dailybreak as $dbd) { ?>
                <option value="<?php echo $dbd['dailybreak_name']; ?>"><?php echo $dbd['dailybreak_name']; ?></option>
            <?php } ?>
        </select>
    </td>
    <td class="start-time_<?php echo $i; ?>"><input id="startTime<?php echo $monStartWeekDays[$i]; ?>" name="start[]" class="hasTimepicker start" type="time" /></td>
    <td class="finish-time_<?php echo $i; ?>"><input id="finishTime<?php echo $monStartWeekDays[$i]; ?>" name="end[]" class="hasTimepicker end" type="time" /></td>
    <td class="hours-worked_<?php echo $i; ?>"><input id="hoursWorked<?php echo $monStartWeekDays[$i]; ?>" name="sum[]" class="timeSum" readonly type="text" /></td>
<?php } elseif ($time_sheet_data[0]['payroll_type'] == 'Salaried-weekly' || $time_sheet_data[0]['payroll_type'] == 'Salaried-BiWeekly' || $time_sheet_data[0]['payroll_type'] == 'Salaried-Monthly' || $time_sheet_data[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>
    <td style="display:none;" class="start-time_<?php echo $i; ?>"><input id="startTime<?php echo $monStartWeekDays[$i]; ?>" name="start[]" class="hasTimepicker start" type="time" /></td>
    <td style="display:none;" class="finish-time_<?php echo $i; ?>"><input id="finishTime<?php echo $monStartWeekDays[$i]; ?>" name="end[]" class="hasTimepicker end" type="time" /></td>
    <td class="hours-worked_<?php echo $i; ?>">
        <input id="hoursWorked<?php echo $monStartWeekDays[$i]; ?>" name="present[]" class="timeSum present" readonly type="checkbox" style="width: 20px; height: 20px" />
    </td>
<?php } ?>
            <a style="color:white;" class="delete_day btnclr btn  m-b-5 m-r-2"><i class="fa fa-trash" aria-hidden="true"></i> </a>
         </td>
            </tr>
          ` );
 }
});
function converToMinutes(s) {
    var c = s.split('.');
    return parseInt(c[0]) * 60 + parseInt(c[1]);
}
function parseTime(s) {
    return Math.floor(parseInt(s) / 60) + "." + parseInt(s) % 60
}
$(document).on('select change'  ,'.end','.dailybreak', function () {
 var $begin = $(this).closest('tr').find('.start').val();
    var $end = $(this).closest('tr').find('.end').val();
     let valuestart = moment($begin, "HH:mm");
    let valuestop = moment($end, "HH:mm");
    let timeDiff = moment.duration(valuestop.diff(valuestart));
     var dailyBreakValue = parseInt($(this).closest('tr').find('.dailybreak').val()) || 0;
     var totalMinutes = timeDiff.asMinutes() - dailyBreakValue;
     var hours = Math.floor(totalMinutes / 60);
    var minutes = totalMinutes % 60;
     var formattedTime = hours.toString().padStart(2, '0') + '.' + minutes.toString().padStart(2, '0');
    $(this).closest('tr').find('.timeSum').val(formattedTime);
debugger;
var total_net = 0;
$('.table').each(function () {
    var tableTotal = 0;
    $(this).find('.timeSum').each(function () {
        var precio = $(this).val();
        if (!isNaN(precio) && precio.length !== 0) {
            var [hours, minutes] = precio.split('.').map(parseFloat);
            tableTotal += hours + minutes / 100;  
        }
    });
    total_net += tableTotal;
});
 var hours = Math.floor(total_net);
var minutes = Math.round((total_net % 1) * 100);  
if (minutes === 100) {
    hours += 1;
    minutes = 0;
}
$('#total_net').val(hours.toString().padStart(2, '0') + '.' + minutes.toString().padStart(2, '0')).trigger('change');
});
$(document).on('select change'  ,'.start','.dailybreak', function () {
 var $begin = $(this).closest('tr').find('.start').val();
    var $end = $(this).closest('tr').find('.end').val();
     let valuestart = moment($begin, "HH:mm");
    let valuestop = moment($end, "HH:mm");
    let timeDiff = moment.duration(valuestop.diff(valuestart));
     var dailyBreakValue = parseInt($(this).closest('tr').find('.dailybreak').val()) || 0;
     var totalMinutes = timeDiff.asMinutes() - dailyBreakValue;
     var hours = Math.floor(totalMinutes / 60);
    var minutes = totalMinutes % 60;
     var formattedTime = hours.toString().padStart(2, '0') + '.' + minutes.toString().padStart(2, '0');
    $(this).closest('tr').find('.timeSum').val(formattedTime);
debugger;
var total_net = 0;
$('.table').each(function () {
    var tableTotal = 0;
    $(this).find('.timeSum').each(function () {
        var precio = $(this).val();
        if (!isNaN(precio) && precio.length !== 0) {
            var [hours, minutes] = precio.split('.').map(parseFloat);
            tableTotal += hours + minutes / 100;  
        }
    });
    total_net += tableTotal;
});
 var hours = Math.floor(total_net);
var minutes = Math.round((total_net % 1) * 100); 
if (minutes === 100) {
    hours += 1;
    minutes = 0;
}
$('#total_net').val(hours.toString().padStart(2, '0') + '.' + minutes.toString().padStart(2, '0')).trigger('change');
});
$(document).on('input','.timeSum', function () {
    var $addtotal = $(this).closest('tr').find('.timeSum').val();
    });
$('body').on('keyup','.end',function(){
     var start=$(this).closest('tr').find('.strt').val();
     var end=$(this).closest('td').find('.end').val();
var breakv=$('#dailybreak').val();
var calculate=parseInt(start)+parseInt(end);
var final =calculate-parseInt(breakv);
console.log(start+"/"+end+"/"+breakv);
$(this).closest('tr').find('.hours-worked').html(final);
});
    $(document).on('select change'  ,'#templ_name', function () {
var data = {
      value:$('#templ_name').val()
  };
  data[csrfName] = csrfHash;
  $.ajax({
      type:'POST',
      data: data, 
     dataType:"json",
      url:'<?php echo base_url();?>Chrm/getemployee_data',
      success: function(result, statut) {
           $('#job_title').val(result[0]['designation']);
                $('#payroll_type').val(result[0]['payroll_type']);
      }
  });
    });
function sumHours () {
    var time1 = $begin.timepicker().getTime();
    var time2 = $end.timepicker().getTime();
    if ( time1 && time2 ) {
      if ( time1 > time2 ) {
        v = new Date(time2);
        v.setDate(v.getDate() + 1);
      } else {
        v = time2;
      }
      var diff = ( Math.abs( v - time1) / 36e5 ).toFixed(2);
      $input.val(diff); 
    } else {
      $input.val(''); 
      alert($input);
    }
}
$(document).on('click','.delete_day',function(){
$(this).closest('tr').remove();
 var total_net=0;
 $('.table').each(function() {
    $(this).find('.timeSum').each(function() {
        var precio = $(this).val();
        if (!isNaN(precio) && precio.length !== 0) {
          total_net += parseFloat(precio);
        }
      });
  });
 $('#total_net').val(total_net.toFixed(2)).trigger('change');
  var firstDate = $('.date input').first().val();  
    var lastDate = $('.date input').last().val();  
     function convertDateFormat(dateStr) {
        const [day, month, year] = dateStr.split('/');
        return `${month}/${day}/${year}`;
    }
     var firstDateMDY = convertDateFormat(firstDate);
    var lastDateMDY = convertDateFormat(lastDate);
  $('#reportrange').val(firstDateMDY + ' - ' + lastDateMDY);
});
document.addEventListener('DOMContentLoaded', function() {
    var checkboxes = document.querySelectorAll('.checkbox.switch-input');  
     checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var idSuffix = this.id.split('_')[1];  
            var correspondingInputField = document.getElementById('block_' + idSuffix);  
             correspondingInputField.value = this.checked ? "present" : "absent";
        });
    });
});
 $(document).ready(function() {
    function updateCounter() {
         var sumOfDays = 0;  
         sumOfDays = $('input[type="checkbox"].present:checked').length;
         $('#total_net').val(sumOfDays);
    }
     $(document).on('change', 'input[type="checkbox"].present', function() {
        updateCounter();
    });
    var t=$('#payroll_type').val();
    if(t !=='Hourly'){
    updateCounter();
    }
});
</script>