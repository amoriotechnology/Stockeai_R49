<style>
.switch-input[disabled] + .switch-label {
    pointer-events: none;
    background-color: #f2f2f2;  
}
.switch-input[disabled] + .switch-label::after {
    border-color: #999; 
}
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
 .btnclr ,th{
   background-color:<?php echo $setting_detail[0]['button_color']; ?>;
   color: white;
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
   #administrator_person-error{
    position: absolute;
    top: 32px;
    width: 270px;
    font-size: 12px;
   }
  #selector-error{
    position: absolute;
    top: 30px;
    width: 270px;
    font-size: 12px;
  }

  #bank_name-error ,#payment_refno-error {
    font-size: 12px;
  }
  #cheque_no-error , #cheque_date-error{
    font-size: 12px;
  }
</style>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
<div class="content-wrapper">
    <section class="content-header" style="height:70px;">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Payment Administration</h1>
            <small></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#">HRM</a></li>
                <li class="active" style="color:orange">Payment Administration</li>
            </ol>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-sm-12">                
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading" style="height:50px;">
                        <div class="panel-title">      
                         <a style="float:right;color:white;" href="<?php echo base_url('Chrm/manage_timesheet?id='.$_GET['id']); ?>" class="btnclr btn  m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo "Manage TimeSheet" ?> </a>
                        </div>
                    </div>
            <div class="error_display"></div>
                    <form id="administration_approval" name="administration_approval"  method="post" >
                    <div class="panel-body">
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="customer" class="col-sm-4 col-form-label">Employee Name<i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input  type="hidden"   readonly id="tsheet_id" value="<?php echo $time_sheet_data[0]['timesheet_id'];?>" name="tsheet_id" />
                                    <input  type="hidden"   readonly id="unique_id" value="<?php echo $time_sheet_data[0]['unique_id'];?>" name="unique_id" />
                                        <select name="templ_name" id="templ_name" class="form-control"    tabindex="3" style="width100">
                                            <?php if (empty($employee_name[0]['id'])): ?>
                                            <option value="<?php echo $employee[0]['id'];  ?>"><?php echo $employee[0]['first_name'] . " " . $employee[0]['last_name']; ?></option>
                                            <?php else: ?>
                                            <option value="<?php echo $employee_name[0]['id']; ?>">
                                            <?php echo $employee_name[0]['first_name'] . " " . $employee_name[0]['last_name']; ?>
                                            </option>
                                            <?php endif; ?>
                                            <?php  foreach($employee_name as $pt){ ?>
                                            <option value="<?php  echo $pt['id'] ;?>"><?php  echo $pt['first_name']." " ;?><?php  echo $pt['last_name'] ;?></option>
                                            <?php  } ?>
                                        </select>
                                </div>
                            </div>
                         <div class="col-sm-6">
                                <label for="qdate" class="col-sm-4 col-form-label">Job title</label>
                              <div class="col-sm-8">
                              <input type="text" name="job_title" id="job_title" readonly placeholder="Job title" value="<?php echo empty($employee_name[0]['designation']) ? 'Sales Partner' : $employee_name[0]['designation']; ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="dailybreak" class="col-sm-4 col-form-label">Date Range<i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                <input id="reportrange" type="text"    readonly name="date_range" <?php if($time_sheet_data[0]['uneditable']==1){ echo 'readonly';}  ?> value="<?php echo $time_sheet_data[0]['month'] ; ?>" class="form-control"/>
                            </div>
                        </div>
                        <input type="hidden" name="id"  id="id" value="<?php echo  $encodedId; ?>">
                        <div class="form-group row">
                             <div class="col-sm-6">
                                <label for="dailybreak" class="col-sm-4 col-form-label">Payroll Type <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                <input id="payroll_type" name="payroll_type" type="text" value="<?php echo $time_sheet_data[0]['payroll_type'] ; ?>" style="margin-left: -4px;width:493px;" readonly class="form-control"/>
                                </div>
                             </div>
                        </div>
                            <input id="week_one" name="week_one" type="hidden" value="<?php echo $time_sheet_data[0]['week_one'] ; ?>"       readonly class="form-control"/>
                            <input id="week_two" name="week_two" type="hidden" value="<?php echo $time_sheet_data[0]['week_two'] ; ?>"       readonly class="form-control"/>
                            <input id="week_three" name="week_three" type="hidden" value="<?php echo $time_sheet_data[0]['week_three'] ; ?>"   readonly class="form-control"/>
                        <div class="table-responsive work_table col-md-12">
		                    <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="PurList"> 
								<thead class="btnclr">
									<tr style="text-align:center;">
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
                                            <th style='height:25px; ' class="col-md-5">Hours</th>
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
                                <?php if($employee_name[0]['payroll_type'] == 'Hourly') { ?>
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
                                 $weeklycount=1;
                                foreach($time_sheet_data as $tsheet) {
                                    if(!empty($tsheet['hours_per_day']) && !in_array($tsheet['Date'], $printedDates) ) {
                                        $printedDates[] = $tsheet['Date'];
                                    ?>
                                    <tr>
                                        <?php if ($employee_name[0]['payroll_type'] == 'Hourly') {
                                         ?>
                                        <td class="date">
                                            <input type="text" <?php if ($tsheet['uneditable'] == 1) { echo 'readonly'; } ?> value="<?php echo empty($tsheet['Date']) ? 'readonly' : $tsheet['Date']; ?>" name="date[]">
                                        </td>
                                        <?php } elseif ($employee_name[0]['payroll_type'] == 'Salaried-weekly' || $employee_name[0]['payroll_type'] == 'Salaried-BiWeekly' || $employee_name[0]['payroll_type'] == 'Salaried-Monthly' || $employee_name[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>
                                            <td class="date">
                                                <input type="text" <?php if ($tsheet['uneditable'] == 1) { echo 'readonly'; } ?> value="<?php echo empty($tsheet['Date']) ? 'readonly' : $tsheet['Date']; ?>" name="date[]">
                                            </td>
                                        <?php } elseif ($employee_name[0]['payroll_type'] == 'SalesCommission') { ?>
                                        <?php } ?>
                                        <?php if ($employee_name[0]['payroll_type'] == 'Hourly') { ?>
                                            <td class="day">
                                                <input type="text" <?php if ($tsheet['uneditable'] == 1) { echo 'readonly'; } ?> value="<?php echo empty($tsheet['Day']) ? 'readonly' : $tsheet['Day']; ?>" name="day[]">
                                            </td>
                                        <?php } elseif ($employee_name[0]['payroll_type'] == 'Salaried-weekly' || $employee_name[0]['payroll_type'] == 'Salaried-BiWeekly' || $employee_name[0]['payroll_type'] == 'Salaried-Monthly' || $employee_name[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>
                                            <td class="day">
                                                <input type="text" <?php if ($tsheet['uneditable'] == 1) { echo 'readonly'; } ?> value="<?php echo empty($tsheet['Day']) ? 'readonly' : $tsheet['Day']; ?>" name="day[]">
                                            </td>
                                        <?php } elseif ($employee_name[0]['payroll_type'] == 'SalesCommission') { ?>
                                        <?php } ?>
                                        <?php if ($employee_name[0]['payroll_type'] == 'Hourly') { ?>
                                            <td style="text-align:center;" class="daily-break">
                                                <select name="dailybreak[]" class="form-control datepicker dailybreak" style="width: 100px;margin: auto; display: block;">
                                                    <?php foreach ($dailybreak as $dbd) { 
                                                        $selected = $dbd['dailybreak_name'] == $tsheet['daily_break'] ? 'selected' : '';
                                                        ?>
                                                        <option <?php echo $selected; ?> value="<?php echo $dbd['dailybreak_name']; ?>"><?php echo $dbd['dailybreak_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        <?php } elseif ($employee_name[0]['payroll_type'] == 'Salaried-weekly' || $employee_name[0]['payroll_type'] == 'Salaried-BiWeekly' || $employee_name[0]['payroll_type'] == 'Salaried-Monthly' || $employee_name[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>
                                        <?php } elseif ($employee_name[0]['payroll_type'] == 'SalesCommission') { ?>
                                        <?php } ?>
                                        <?php if ($employee_name[0]['payroll_type'] == 'Hourly') { ?>
                                            <td class="start-time">
                                                <input <?php if ($tsheet['uneditable'] == 1) { echo 'readonly'; } ?> name="start[]" class="hasTimepicker start" value="<?php echo empty($tsheet['Day']) ? 'readonly' : $tsheet['time_start']; ?>" type="time" id="<?php echo $weeklycount; ?>">
                                            </td>
                                        <?php } elseif ($employee_name[0]['payroll_type'] == 'Salaried-weekly' || $employee_name[0]['payroll_type'] == 'Salaried-BiWeekly' || $employee_name[0]['payroll_type'] == 'Salaried-Monthly' || $employee_name[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>
                                            <?php } elseif ($employee_name[0]['payroll_type'] == 'SalesCommission') { ?>
                                            <?php } ?>
                                        <?php if ($employee_name[0]['payroll_type'] == 'Hourly') { ?>
                                            <td class="finish-time">
                                                <input <?php if ($tsheet['uneditable'] == 1) { echo 'readonly'; } ?> name="end[]" class="hasTimepicker end" value="<?php echo empty($tsheet['Day']) ? 'readonly' : $tsheet['time_end']; ?>" type="time" id="<?php echo $weeklycount; ?>">
                                            </td>
                                        <?php } elseif ($employee_name[0]['payroll_type'] == 'Salaried-weekly' || $employee_name[0]['payroll_type'] == 'Salaried-BiWeekly' || $employee_name[0]['payroll_type'] == 'Salaried-Monthly' || $employee_name[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>                
                                        <?php } elseif ($employee_name[0]['payroll_type'] == 'SalesCommission') { ?>
                                        <?php } ?>
                                        <?php if ($employee_name[0]['payroll_type'] == 'Salaried-weekly' || $employee_name[0]['payroll_type'] == 'Salaried-BiWeekly' || $employee_name[0]['payroll_type'] == 'Salaried-Monthly' || $employee_name[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>
                                            <td class="hours-worked">
                                                <input name="sum[]" class="timeSum" type="checkbox" style="width: 20px;height: 20px"
                                               <?php echo (isset($tsheet['present']) && $tsheet['present'] === "no"   ) ? 'checked' : ''; ?>
                                                <?php echo (!isset($tsheet['present']) || $tsheet['present'] === '') ? 'disabled' : ''; ?>
                                               value="<?php echo $tsheet['present'] ; ?>" 
                                               >
                                            </td>
                                        <?php } elseif ($employee_name[0]['payroll_type'] == 'Hourly') { ?>
                                            <td class="hours-worked">
                                                <input readonly name="sum[]" class="timeSum" value="<?php echo empty($tsheet['Day']) ? 'readonly' : $tsheet['hours_per_day']; ?>" type="text"  id="weekly_<?php echo $weeklycount; ?>">
                                            </td>
                                        <?php } ?>
                                        <?php if ($employee_name[0]['payroll_type'] == 'Hourly') { 
                                            ?>
                                            <td><a style='color:white;' class="delete_day btnclr btn  m-b-5 m-r-2"><i class="fa fa-trash" aria-hidden="true"></i> </a></td>
                                        <?php } elseif ($employee_name[0]['payroll_type'] == 'Salaried-weekly' || $employee_name[0]['payroll_type'] == 'Salaried-BiWeekly' || $employee_name[0]['payroll_type'] == 'Salaried-Monthly' || $employee_name[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>
                                        <?php } elseif ($employee_name[0]['payroll_type'] == 'SalesCommission') { ?>
                                        <?php } ?>
                                    </tr>
                                  <?php 
                                    }
                                }  
                                ?>
                            </tbody>
                            <?php  } else{  ?>
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
                    if(empty($tsheet['hours_per_day']) && !in_array($tsheet['Date'], $printedDates) ) {
                        $printedDates[] = $tsheet['Date'];
                    ?>
                <tr>
                    <?php if ($employee_name[0]['payroll_type'] == 'Hourly') { ?>
                    <td class="date">
                    <input type="text" <?php if ($tsheet['uneditable'] == 1) { echo 'readonly'; } ?> value="<?php echo empty($tsheet['Date']) ? 'readonly' : $tsheet['Date']; ?>" name="date[]">
                </td><?php } elseif ($employee_name[0]['payroll_type'] == 'Salaried-weekly' || $employee_name[0]['payroll_type'] == 'Salaried-BiWeekly' || $employee_name[0]['payroll_type'] == 'Salaried-Monthly' || $employee_name[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>
                    <td class="date">
                    <input type="text" <?php if ($tsheet['uneditable'] == 1) { echo 'readonly'; } ?> value="<?php echo empty($tsheet['Date']) ? 'readonly' : $tsheet['Date']; ?>" name="date[]">
                    </td><?php } elseif ($employee_name[0]['payroll_type'] == 'SalesCommission') { ?>
                     <?php } ?>
                    <?php if ($employee_name[0]['payroll_type'] == 'Hourly') { ?>
                    <td class="day">
                        <input type="text" <?php if ($tsheet['uneditable'] == 1) { echo 'readonly'; } ?> value="<?php echo empty($tsheet['Day']) ? 'readonly' : $tsheet['Day']; ?>" name="day[]">
                    </td>
                    <?php } elseif ($employee_name[0]['payroll_type'] == 'Salaried-weekly' || $employee_name[0]['payroll_type'] == 'Salaried-BiWeekly' || $employee_name[0]['payroll_type'] == 'Salaried-Monthly' || $employee_name[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>
                    <td class="day">
                        <input type="text" <?php if ($tsheet['uneditable'] == 1) { echo 'readonly'; } ?> value="<?php echo empty($tsheet['Day']) ? 'readonly' : $tsheet['Day']; ?>" name="day[]">
                    </td>
                    <?php } elseif ($employee_name[0]['payroll_type'] == 'SalesCommission') { ?>
                     <?php } ?>
                    <?php if ($employee_name[0]['payroll_type'] == 'Hourly') { ?>
                        <td style="text-align:center;" class="daily-break">
                            <select name="dailybreak[]" class="form-control datepicker dailybreak" style="width: 100px;margin: auto; display: block;">
                            <option value="<?php echo $tsheet['daily_break']; ?>"><?php echo $tsheet['daily_break']; ?></option>
                                <?php foreach ($dailybreak as $dbd) { ?>
                                    <option value="<?php echo $dbd['dailybreak_name']; ?>"><?php echo $dbd['dailybreak_name']; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <?php } elseif ($employee_name[0]['payroll_type'] == 'Salaried-weekly' || $employee_name[0]['payroll_type'] == 'Salaried-BiWeekly' || $employee_name[0]['payroll_type'] == 'Salaried-Monthly' || $employee_name[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>
                        <?php } elseif ($employee_name[0]['payroll_type'] == 'SalesCommission') { ?>
                         <?php } ?>
            <?php if ($employee_name[0]['payroll_type'] == 'Hourly') { ?>
                <td class="start-time">
                    <input <?php if ($tsheet['uneditable'] == 1) { echo 'readonly'; } ?> name="start[]" class="hasTimepicker start" value="<?php echo empty($tsheet['Day']) ? 'readonly' : $tsheet['time_start']; ?>" type="time">
                </td>
                <?php } elseif ($employee_name[0]['payroll_type'] == 'Salaried-weekly' || $employee_name[0]['payroll_type'] == 'Salaried-BiWeekly' || $employee_name[0]['payroll_type'] == 'Salaried-Monthly' || $employee_name[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>
                <?php } elseif ($employee_name[0]['payroll_type'] == 'SalesCommission') { ?>
                <?php } ?>
                <?php if ($employee_name[0]['payroll_type'] == 'Hourly') { ?>
                    <td class="finish-time">
                    <input <?php if ($tsheet['uneditable'] == 1) { echo 'readonly'; } ?> name="end[]" class="hasTimepicker end" value="<?php echo empty($tsheet['Day']) ? 'readonly' : $tsheet['time_end']; ?>" type="time">
                </td>
                <?php } elseif ($employee_name[0]['payroll_type'] == 'Salaried-weekly' || $employee_name[0]['payroll_type'] == 'Salaried-BiWeekly' || $employee_name[0]['payroll_type'] == 'Salaried-Monthly' || $employee_name[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>
                <?php } elseif ($employee_name[0]['payroll_type'] == 'SalesCommission') { ?>
            <?php } ?>
                    <?php if ($employee_name[0]['payroll_type'] == 'Salaried-weekly' || $employee_name[0]['payroll_type'] == 'Salaried-BiWeekly' || $employee_name[0]['payroll_type'] == 'Salaried-Monthly' || $employee_name[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>
                <td class="hours-worked">
                    <label class="switch" style="width:100px;">
                        <input type="checkbox" class="timeSum present checkbox switch-input" id="blockcheck_<?php echo $i; ?>" name="present[]" <?php echo (isset($tsheet['present']) && $tsheet['present'] === 'present') ? 'checked="checked"' : ''; ?> data-present="<?php echo $tsheet['present'] ?? ''; ?>" disabled>
                        <span contenteditable="false" class="switch-label" data-on="Present" data-off="Absent"></span>
                        <span class="switch-handle"></span>
                    </label>
                    <input readonly type="hidden" name="block[]" id="block_<?php echo $i++; ?>" value="<?php echo (isset($tsheet['present']) && $tsheet['present'] === 'absent') ? 'absent' : 'present'; ?>" />
                </td>
                <?php }
    elseif ($employee_name[0]['payroll_type'] == 'Hourly') { ?>
    <td class="hours-worked">
                    <input readonly name="sum[]" class="timeSum" value="<?php echo empty($tsheet['Day']) ? 'readonly' : $tsheet['hours_per_day']; ?>" type="text">
                </td>
        <?php } ?>
         <?php if ($employee_name[0]['payroll_type'] == 'Hourly') { ?>
            <td>
                <a style='color:white;' class="delete_day btnclr btn  m-b-5 m-r-2"><i class="fa fa-trash" aria-hidden="true"></i> </a>
         </td>
                <?php } elseif ($employee_name[0]['payroll_type'] == 'Salaried-weekly' || $employee_name[0]['payroll_type'] == 'Salaried-BiWeekly' || $employee_name[0]['payroll_type'] == 'Salaried-Monthly' || $employee_name[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>
                <?php } elseif ($employee_name[0]['payroll_type'] == 'SalesCommission') { ?>
        <?php } ?>
            </tr>
       <?php   }  } ?>
      </tbody>
        <?php  }  ?>                 
        <tfoot>
        <tr style="text-align:end"> 
        <?php if ($employee_name[0]['payroll_type'] == 'Hourly') { ?>
        <td colspan="5" class="text-right" style="font-weight:bold;">Total Hours :</td>
        <td style="text-align: center;"> <input  type="text"   readonly id="total_net" value="<?php echo $time_sheet_data[0]['total_hours'] ; ?>" name="total_net" />    </td>
        <?php  if($time_sheet_data[0]['total_hours'] > $extratime_info[0]['work_hour']) { ?>
        <input  type="hidden"   readonly id="above_extra_beforehours"
        value="<?php
        $mins  =  $time_sheet_data[0]['total_hours'] - $extratime_info[0]['work_hour'];
        $get_value  =  $time_sheet_data[0]['total_hours'] - $mins;
        echo $get_value  ; ?>"  name="above_extra_beforehours" /> 
        <input type="hidden" id="above_extra_rate" name="above_extra_rate" value="<?php echo  $employee_name[0]['hrate']; ?>" /> 
        <input type="hidden" id="above_extra_sum" name="above_extra_sum" value="<?php echo  $get_value * $employee_name[0]['hrate'] ; ?>" /> 
        <input type="hidden" id="above_this_hours" name="above_this_hours" value="<?php echo  $get_value; ?>" /> 
        <input type="hidden" id="above_extra_ytd" name="above_extra_ytd" value="<?php echo  $get_value * $employee_name[0]['hrate'] ; ?>" />
        <?php } else{ ?>
        <input type="hidden" readonly id="above_extra_beforehours"
        value="<?php   echo $time_sheet_data[0]['total_hours'];
        ?>" name="above_extra_beforehours" />
        <input type="hidden" id="above_extra_rate" name="above_extra_rate" value="<?php echo  $employee_name[0]['hrate']; ?>" />
        <input type="hidden" id="above_extra_sum" name="above_extra_sum" value="<?php echo  $time_sheet_data[0]['total_hours'] * $employee_name[0]['hrate'] ; ?>" />
        <input type="hidden" id="above_this_hours" name="above_this_hours" value="<?php echo $time_sheet_data[0]['total_hours']; ?>" />
        <input type="hidden" id="above_extra_ytd" name="above_extra_ytd" value="<?php echo  $time_sheet_data[0]['total_hours'] * $employee_name[0]['hrate']; ?>" />
        <?php } ?>
        <?php } elseif ($employee_name[0]['payroll_type'] == 'Salaried-weekly' || $employee_name[0]['payroll_type'] == 'Salaried-BiWeekly' || $employee_name[0]['payroll_type'] == 'Salaried-Monthly' || $employee_name[0]['payroll_type'] == 'Salaried-BiMonthly') { ?>
        <td colspan="2" class="text-right" style="font-weight:bold;">No of Days:</td>
        <td style="text-align: center;"> <input  type="text"   readonly id="total_net" value="<?php echo $time_sheet_data[0]['total_hours'] ; ?>" name="total_net" />    </td>
        <?php  if($time_sheet_data[0]['total_hours'] > $extratime_info[0]['work_hour']) { ?>
        <input  type="hidden"   readonly id="above_extra_beforehours"
        value="<?php
        $mins  =  $time_sheet_data[0]['total_hours'] - $extratime_info[0]['work_hour'];
        $get_value  =  $time_sheet_data[0]['total_hours'] - $mins;
        echo $get_value
        ; ?>"   name="above_extra_beforehours" />
        <input type="hidden" id="above_extra_rate" name="above_extra_rate" value="<?php echo  $employee_name[0]['hrate']; ?>" />
        <input type="hidden" id="above_extra_sum" name="above_extra_sum" value="<?php echo  $get_value * $employee_name[0]['hrate'] ; ?>" />
        <input type="hidden" id="above_this_hours" name="above_this_hours" value="<?php echo  $get_value; ?>" />
        <input type="hidden" id="above_extra_ytd" name="above_extra_ytd" value="<?php echo  $get_value * $employee_name[0]['hrate'] ; ?>" />
        <?php } else{ ?>
        <input type="hidden" readonly id="above_extra_beforehours"
        value="<?php   echo $time_sheet_data[0]['total_hours'];
        ?>" name="above_extra_beforehours" />
        <input type="hidden" id="above_extra_rate" name="above_extra_rate" value="<?php echo  $employee_name[0]['hrate']; ?>" />
        <input type="hidden" id="above_extra_sum" name="above_extra_sum" value="<?php echo  $time_sheet_data[0]['total_hours'] * $employee_name[0]['hrate'] ; ?>" />
        <input type="hidden" id="above_this_hours" name="above_this_hours" value="<?php echo $time_sheet_data[0]['total_hours']; ?>" />
        <input type="hidden" id="above_extra_ytd" name="above_extra_ytd" value="<?php echo  $time_sheet_data[0]['total_hours'] * $employee_name[0]['hrate']; ?>" />
        <?php } ?>
                      <?php } elseif ($employee_name[0]['payroll_type'] == 'SalesCommission') { ?>
                   <?php } ?>                     
                </tr>

 
                                    <?php 
                                    $weektotal = 0;
                                    if ($time_sheet_data[0]['week_one'] > $extratime_info[0]['work_hour']) {
                                        $weekone =   $time_sheet_data[0]['week_one'] - $extratime_info[0]['work_hour'] ;
                                    } else {
                                        $weekone = 0;
                                    }
                                    if ($time_sheet_data[0]['week_two'] > $extratime_info[0]['work_hour']) {
                                        $weektwo =   $time_sheet_data[0]['week_two'] - $extratime_info[0]['work_hour'];
                                    } else {
                                        $weektwo = 0; 
                                    }
                                    if ($time_sheet_data[0]['week_three'] > $extratime_info[0]['work_hour']) {
                                        $weekthree =   $time_sheet_data[0]['week_three'] - $extratime_info[0]['work_hour'];
                                    } else {
                                        $weekthree = 0;
                                    }
                                    $weektotal = $weekone + $weektwo + $weekthree;
                                    ?>
                                 <br>
                 
                                 <?php  if($time_sheet_data[0]['total_hours'] > $extratime_info[0]['work_hour']) { ?>
                                 <input type="hidden" id="extra_hour" name="extra_hour"  value="<?php echo $weektotal; ?>"   />
                                 <input type="hidden" id="extra_rate" name="extra_rate" value="<?php echo  $employee_name[0]['hrate'] * $extratime_info[0]['extra_workamount']; ?>" />
                                 <input type="hidden" id="extra_thisrate" name="extra_thisrate" value="<?php echo ($weektotal) * ($employee_name[0]['hrate'] * $extratime_info[0]['extra_workamount']); ?>" />
                                 <input type="hidden" id="extra_this_hour" name="extra_this_hour" value="<?php echo $weektotal;  ?>" />
                                 <input type="hidden" id="extra_ytd" name="extra_ytd" value="<?php echo ($weektotal) * ($employee_name[0]['hrate'] * $extratime_info[0]['extra_workamount']); ?>"   />
                                 <?php    } else{  ?>
                                 <input type="hidden" id="extra_hour" name="extra_hour" value="<?php echo $time_sheet_data[0]['total_hours']; ?>" />
                                 <input type="hidden" id="extra_rate" name="extra_rate" value="<?php echo  $employee_name[0]['hrate']; ?>" />
                                 <input type="hidden" id="extra_thisrate" name="extra_thisrate" value="<?php echo ($time_sheet_data[0]['total_hours']  * $employee_name[0]['hrate']); ?>" />
                                 <input type="hidden" id="extra_rate" name="extra_rate" value="<?php echo  $employee_name[0]['hrate']; ?>" />
                                 <input type="hidden" id="extra_thisrate" name="extra_thisrate" value="<?php echo ($time_sheet_data[0]['total_hours']  * $employee_name[0]['hrate']); ?>" />
                                <?php } ?>
                                </tfoot>
		                    </table>
		                </div>
   <div class="form-group row">
    <div class="col-sm-4"></div>
     <div class="col-sm-4" style="border: 5px solid gainsboro; border-radius: 20px; ">
       <div class="">
       <div class="panel-title">
         <br/>
        <div class="form-group row">
            <div class="col-sm-12">
              <div class="col-sm-5">
              <label for="administrator_person">Administrator Name<i class="text-danger">*</i></label> 
             </div>
            <div class="col-sm-6">
              <select name="administrator_person" id="administrator_person"    class="form-control"   data-placeholder="<?php echo display('select_one'); ?>">                                   
                <option value="<?php  echo $time_sheet_data[0]['admin_name']; ?>"><?php  echo $time_sheet_data[0]['admin_name']; ?> </option>
                <?php foreach($administrator as $adv){ ?>
                <option value="<?php echo $adv['adm_id'] ; ?>"><?php echo $adv['adm_name'] ; ?></option>
                <?php    }?>
              </select>

              
            </div>

            <input type="hidden" name="id"  id="id" value="<?php echo  $encodedId; ?>">


            <?php if($time_sheet_data[0]['uneditable']==0)  {  ?>
                <div class="col-sm-1">
               <a  class="btnclr client-add-btn btn" aria-hidden="true" style="color:white;"  data-toggle="modal" data-target="#add_admst" ><i class="fa fa-plus"></i></a>
                </div>
            <?php } ?>

        


              </div>
            <div>
          </div>
        </div>
        <div class="panel-title">
        <div class="col-sm-12">
        <div class="col-sm-5">
        <label for="selector">Payment Method
        <i class="text-danger">*</i>
        </label>
        </div>
        <div class="col-sm-6">
          <select id="selector" name="payment_method" onchange="yesnoCheck(this);"  class="form-control"  >
                <option value="<?php  echo $time_sheet_data[0]['payment_method']; ?>"><?php  echo $time_sheet_data[0]['payment_method']; ?></option>
                <option value="Cheque">Cheque/Check </option>
                <option value="Bank">Bank</option>
                <option value="Cash">Cash</option>
          </select>
         </div>
         <div id="adc" >
            <br/>
                <div class="col-sm-10" style="padding-top:20px;">
        <div class="col-sm-6">
        <label for="aadhar">Cheque No<i class="text-danger">*</i></label> 
                </div>
            <div class="col-sm-6"> 
        <input type="number" id="cheque_no" name="cheque_no" style="width: 141%;"  value="<?php  echo $time_sheet_data[0]['cheque_no']; ?>"  class="form-control" requried /><br />
                </div>
                <div class="col-sm-6">
        <label for="aadhar">Cheque Date<i class="text-danger">*</i></label> 
        </div> 
            <div class="col-sm-6"> 
        <input type="text" id="datepicker_cheque" name="cheque_date" style="width: 141%;" value="<?php  echo $time_sheet_data[0]['cheque_date']; ?>"  class="form-control"  requried/><br />
                </div></div>
        </div> 
        <div id="pc" > 
            <div class="col-sm-10" style="padding-top:20px;">
        <div class="col-sm-6">
        <label for="pan">Bank Name<i class="text-danger">*</i></label> 
        </div>
        <div class="col-sm-6">
        <input type="text" id="bank_name" name="bank_name" style="width: 141%;" value="<?php  echo $time_sheet_data[0]['bank_name']; ?>"  class="form-control" requried /><br />
                </div>
        <div class="col-sm-6">
        <label for="pan">Payment Ref No<i class="text-danger">*</i></label> 
                </div>
        <div class="col-sm-6">
        <input type="text" id="payment_refno" name="payment_refno" style="width: 142%;" value="<?php  echo $time_sheet_data[0]['payment_ref_no']; ?>"  class="form-control"  requried/><br />
        </div>
        </div>
        </div>
        <div id="ps" style="display:none;">
            <div class="col-sm-12" style="padding-top:20px;">
            <div class="col-sm-6">
            <label for="pass">Cash<i class="text-danger">*</i></label> 
        </div>
            <div class="col-sm-4">
            <input type="text" id="cash" name="cash"  class="form-control"  value="Cash" readonly /><br />
            </div>
        </div>
        </div>
        <!--Cash Method -->
        <div id="Cashmethod">
            <br/>
            <div class="col-sm-12" style="padding-top:20px;">
            <div class="col-sm-6">
                <label for="aadhar">Date<i class="text-danger">*</i></label> 
            </div>
               <div class="col-sm-6"> 
                    <input type="text" id="datepicker" name="cash_date" value="<?php echo $time_sheet_data[0]['cheque_date']; ?>"  class="form-control" requried /><br />
                </div>
            </div>
        </div>
        </div>
        </div>
 <br>
 <br>
 <br>
                <div class="col-sm-12 text-center">
                    <label for="example-text-input" class="col-sm-0 col-form-label"></label>


                   <?php if($time_sheet_data[0]['uneditable']==0)  {  ?>
                       <div class="col-sm-12">  
                          <input type="submit"   class="btnclr btn btn-large"   value="Submit" tabindex="7" />
                          <a href="<?php echo base_url('Chrm/manage_timesheet?id='.$_GET['id']); ?>" class="btn btn-info">Cancel</a>      
                       </div>
                  <?php  }  else { ?>
                    <h3> <?php echo  'The timesheet has been generated and is available for viewing only.'; ?></h3>

                 <?php } ?>

                </div>
<br>
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
$("#administration_approval").validate({
  rules: {
    administrator_person: "required",  
    payment_method: "required",  
    cheque_no  :"required",
    cheque_date :"required",
    bank_name :"required",
    payment_refno :"required"

  },
  messages: {
    administrator_person: "Administrator  Name is required",
    payment_method: "Payment Method is required",
    cheque_no: "Cheque No is required",
    cheque_date: "Cheque Date is required",
    bank_name: "Bank Name is required",
    payment_refno: "Payment Ref No is required",

  },

 
  submitHandler: function(form) {
    var formData = new FormData(form);
    formData.append(csrfName, csrfHash);
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "<?php echo base_url('Chrm/second_pay_slip'); ?>",
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
         console.log(response, "response");
         if(response.status == 'success')
         {
          $('.error_display').html(succalert+response.msg+'</div>');
          console.log(response.msg, "Success");
          window.setTimeout(function(){
            window.location = "<?php echo base_url('Chrm/manage_timesheet?id='.$_GET['id']); ?>"
          },500);
         }else{
          $('.error_display').html(failalert+response.msg+'</div>'); 
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
        function yesnoCheck(that) 
    {
    if (that.value == "Cheque") 
        {
            document.getElementById("adc").style.display = "block";
            document.getElementById("pc").style.display = "none";
            document.getElementById("Cashmethod").style.display = "none";
        }
        else   if (that.value == "Bank")
        {
            document.getElementById("adc").style.display = "none";
            document.getElementById("pc").style.display = "block";      
            document.getElementById("Cashmethod").style.display = "none";
        }
        else if (that.value == "Cash")
        {
            document.getElementById("adc").style.display = "none";
            document.getElementById("pc").style.display = "none";
            document.getElementById("Cashmethod").style.display = "block";
        }
        else
        {
            document.getElementById("adc").style.display = "none";
            document.getElementById("pc").style.display = "none";
            document.getElementById("Cashmethod").style.display = "none";
        }
    }
    $(document).ready(function(){
        var that=$('#selector').val();
        if (that == "Cheque") 
        {
            $('#adc').show();
            $('#pc').hide();
            $('#Cashmethod').hide();
        }
        else   if (that == "Bank")
        {
        $('#adc').hide();
        $('#pc').show();
        $('#Cashmethod').hide();
        }
        else if (that == "Cash")
        {
            $('#adc').hide();
            $('#pc').hide(); 
            $('#Cashmethod').show();
        }else{
            $('#adc').hide();
            $('#pc').hide();
            $('#Cashmethod').hide();
        }
    })
    </script>
 <div class="modal fade" id="add_admst" role="dialog">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="btnclr modal-header" style="color:white;text-align:center;" >
            <a href="#" class="close" data-dismiss="modal">&times;</a>
            <h4 class="modal-title"><?php echo ('ADMINISTRATOR NAME') ?></h4>
        </div>
        <div class="modal-body">
             <div class="administratorMessage"></div>
   <form id="insert_adm" method="post">
      <div class="panel-body">
       <input type ="hidden" name="csrf_test_name" id="" value="<?php echo $this->security->get_csrf_hash();?>">
        <div class="form-group row">
            <label for="adms_name" class="col-sm-4 col-form-label" ><?php echo ('Administrator Name') ?> <i class="text-danger">*</i></label>
            <div class="col-sm-6">
            <input class="form-control" name ="adms_name" id="adms_name" type="text" placeholder="Administrator Name"    tabindex="1">
        </div>
    </div>

    <input type="hidden" name="id"  id="id" value="<?php echo  $encodedId; ?>">

    <input type ="hidden" name="csrf_test_name" id="" value="<?php echo $this->security->get_csrf_hash();?>">
    <div class="form-group row">
    <label for="address" class="col-sm-4 col-form-label" ><?php echo ('Administrator Address') ?> </label>
    <div class="col-sm-6">
        <input class="form-control" name ="address" id="address" type="text" placeholder="Administrator Adress"  tabindex="1">
    </div>
    </div>
    </div>
    </div>
        <div class="modal-footer">
            <input type="submit" class="btnclr btn" style="color:white; " value=<?php echo display('Submit') ?>>
            <a href="#" class="btnclr btn" style="color:white; " data-dismiss="modal"><?php echo display('Close') ?> </a>
        </div>
        </form>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js"></script>
<script>
$("#insert_adm").validate({
    rules: {
        adms_name: "required"
    },
    messages: {
        adms_name: "Administrator Name is required"
    },
    errorPlacement: function(error, element) {
        if (element.hasClass("select2-hidden-accessible")) {
            error.insertAfter(element.next('span.select2'));
        } else {
            error.insertAfter(element);
        }
    },
    submitHandler: function(form, event) {
        event.preventDefault(); 
        var formData = new FormData(form);
        formData.append(csrfName, csrfHash);
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>Chrm/insert_data_adsr',       
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(response) {
                 if (response.status === 'success') {
                  var $select = $('select#administrator_person');
                  $('select#administrator_person').empty();       
                  for(var i = 0; i < response.get_administrator.length; i++) {
                     var option = $('<option/>').attr('value', response.get_administrator[i].adm_name).text(response.get_administrator[i].adm_name);
                     $select.append(option); 
                  }  
                  $('.administratorMessage').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.msg + '</div>');
                  setTimeout(function() {
                  $('#add_admst').modal('hide');
                  }, 1500);
                  } else {
                    $('.administratorMessage').html('<div class="alert alert-danger alert-dismissible" role="alert">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">×</span></button>' +
                        response.msg + '</div>');
                  }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
            }
        });
    }
});
 
var data = {
    value:$('#customer_name').val()
};
var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
$('body').on('input select change','#reportrange',function(){
    var date = $(this).val();
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
            <td style="text-align:center;" class="daily-break_${i}">
                    <select name="dailybreak[]" class="form-control datepicker dailybreak" style="width: 100px;margin: auto; display: block;">
                        <?php foreach ($dailybreak as $dbd) { ?>
                            <option value="<?php echo $dbd['dailybreak_name']; ?>"><?php echo $dbd['dailybreak_name']; ?></option>
                        <?php } ?>
                    </select>
                </td>
            <td class="start-time_`+i+`">    <input    id="startTime${monStartWeekDays[i]}"  name="start[]"  class="hasTimepicker start" type="time"   /></td>
            <td class="finish-time_`+i+`">   <input    id="finishTime${monStartWeekDays[i]}"   name="end[]" class="hasTimepicker end"   type="time"   /></td></td>
            <td class="hours-worked_`+i+`">  <input    id="hoursWorked${monStartWeekDays[i]}"  name="sum[]" class="timeSum"      readonly       type="text"   /></td> <td>
                    <a style="color:white;" class="delete_day btnclr btn  m-b-5 m-r-2"><i class="fa fa-trash" aria-hidden="true"></i> </a>
              </td>             
            </tr> ` );
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
    }
}
$(document).ready(function() {
    function updateCounter() {
        var sumOfDays = $('input[type="checkbox"].present:checked').length;
        $('#total_net').val(sumOfDays); 
    }
    $(document).on('change', 'input[type="checkbox"].present', updateCounter);
      var t=$('#payroll_type').val();
    if(t !=='Hourly'){
    updateCounter(); 
    }
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


$(function() {
    $("#datepicker").datepicker({
        dateFormat: 'mm-dd-yy'  
    });

    $("#datepicker_cheque").datepicker({
        dateFormat: 'mm-dd-yy'  
    });
});
</script>  
