<?php
    $CI =& get_instance();
    $CI->load->model('Web_settings');
    $Web_settings = $CI->Web_settings->retrieve_setting_editdata();
    $currency_list = $CI->Web_settings->getCurrencyDetails();
    $setting_detail = $CI->Web_settings->retrieve_setting_editdata();
    $country_list = $CI->Web_settings->getCountryDetails();
?>
<footer class="main-footer" style="display: none;">
    <strong>
      <?php if (isset($Web_settings[0]['footer_text'])) { echo html_escape($Web_settings[0]['footer_text']); }?>
    </strong><i >
   <span style="font-style: normal;" ><?php echo date('Y'); ?> © Copyright : Amorio Technologies </span>
    </i>
      <input type ="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash();?>">
       <input type ="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
</footer>
<style>
      .removebundle, .addbundle{
   padding: 10px 12px 10px 12px;
   border-radius:5px;
   }
.error {
    color: red;
}
.select2-container--default .select2-selection--single {
    border-color: #ced4da;
  
}
.select2-container--default .select2-selection--single.error {
    border-color: red !important;
}
  .dt-button ,.buttons-html5 {
 text-align:center;
       background-color:<?php echo $setting_detail[0]['button_color']; ?>;
       color: white;
   }
   label{
      text-align:left;
   }
  input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0; 
}
a{
   color:inherit;
}
.alert {
    margin-bottom: 0px;
}
  .img-flag {
    max-height: 11px;
    display: none;
}
.select2-container, .select2-choice,.select2-arrow,.select2-selection {
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #d7d4d6;
    border-radius: 4px;
}

.notify li {
      padding: 10px;
      margin-bottom: 5px;
      background-color: #f0f0f0;
      border: 1px solid #ccc;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
   }
   .notify li:hover,  .notify ul:hover{
         background-color: brown;
   border-color: #999; 
   }
   .notify li a {
      text-decoration: none;
      font-weight: bold;
   }
  </style>
<script type="text/javascript">
function formatPhoneNumber(input) {
    var phoneNumber = input.value.replace(/\D/g, '');
 if (phoneNumber.length > 0) {
        var formattedPhoneNumber = '(' + phoneNumber.substring(0, 3) + ') ' + phoneNumber.substring(3, 6) + ' ' + phoneNumber.substring(6, 10);
        input.value = formattedPhoneNumber;
    } else {
        input.value = '';
    }
}
  function mail(id,table,col)
  {
 var res = id;
  var id=id+'-'+table+'-'+col;
    $('.get_invoiceid').val(res);
        var url='<?php echo base_url('Cinvoice/get_customer/'); ?>';
       $.ajax({
        url:url+id,
        type: 'GET',
        success: function(res) {
       $('#customer_emailid').val(res);
           const myArray = id.split("-");
            let word = myArray[0];
            $("#sendmail").attr("href", "<?php echo base_url()?>Cinvoice/sendmail_with_attachments/"+word);
        }
    });
  }
</script>
<script type="text/javascript">
  function profarmamail(id,table,col)
  {
    var id = id+'-'+table+'-'+col;
    alert(id);
        var url='<?php echo base_url('cinvoice/get_customer/'); ?>';
       $.ajax({
        url:url+id,
        type: 'GET',
        success: function(res) {
            $('#customer_emailid').val(res);
            console.log(id);
            const myArray = id.split("-");
            let word = myArray[0];
            $("#sendmail").attr("href", "<?php echo base_url()?>Cinvoice/proforma_with_attachment_cus/"+word);
        }
    });
  }
</script>
<script type="text/javascript">
  function packingmail(id,table,col)
  {
  var id=id+'-'+table+'-'+col;
        var url='<?php echo base_url('cinvoice/get_customer/'); ?>';
       $.ajax({
        url:url+id,
        type: 'GET',
        success: function(res) {
            $('#customer_emailid').val(res);
            console.log(id);
            const myArray = id.split("-");
            let word = myArray[0];
            $("#sendmail").attr("href", "<?php echo base_url()?>Cinvoice/packing_with_attachment_cus/"+word);
        }
    });
  }
</script>
<script type="text/javascript">
  function oceanexportmail(id,table,col)
  {
  var res = id;
  var id=id+'-'+table+'-'+col;
  $('.get_oceanexportid').val(res);
        var url='<?php echo base_url('cinvoice/get_customer/'); ?>';
       $.ajax({
        url:url+id,
        type: 'GET',
        success: function(res) {
            $('#customer_emailid').val(res);
            console.log(id);
            const myArray = id.split("-");
            let word = myArray[0];
            $("#sendmail").attr("href", "<?php echo base_url()?>Cinvoice/ocean_with_attachment_cus/"+word);
        }
    });
  }
</script>
<script type="text/javascript">
  function truckingmail(id,table,col)
  {
  var res = id;
  var id=id+'-'+table+'-'+col;
  $('.get_truck_id').val(res);
        var url='<?php echo base_url('cinvoice/get_customer/'); ?>';
       $.ajax({
        url:url+id,
        type: 'GET',
        success: function(res) {
            $('#customer_emailid').val(res);
            console.log(id);
            const myArray = id.split("-");
            let word = myArray[0];
            $("#sendmail").attr("href", "<?php echo base_url()?>Cinvoice/trucking_with_attachment_cus/"+word);
        }
    });
  }
</script>
<style>
   #files-area{
   margin: 0 auto;
   }
   .file-block{
   border-radius: 10px;
   background-color: #38469f;
   margin: 5px;
   color: #fff;
   display: inline-flex;
   padding: 4px 10px 4px 4px;
   }
   .file-delete{
   display: flex;
   width: 24px;
   color: initial;
   background-color: #38469f;
   font-size: large;
   justify-content: center;
   margin-right: 3px;
   cursor: pointer;
   color: #fff;
   }
   span.name{
   position: relative;
   top: 2px;
   }
   .btn-primary {
   color: #fff;
   background-color: #38469f !important;
   border-color: #38469f !important;
   }
   a:active{
    color: #fff !important;
   }
   a:hover{
    color: #000 !important;
   }
   a:focus{
    color: #fff !important;
   }


/*  Sales*/
#salefiles-area{
    margin: 0 auto;
}

</style>
<script type="text/javascript">
  
  $(document).ready(function() {
  $('#isattachment').change(function() {
    if ($(this).is(':checked')) {
    var rowinvoiceId = $('#get_inid').val();
    $.ajax({
           url:"<?php echo base_url(); ?>Cinvoice/Get_attachments",
           type: 'POST',
           dataType: 'json',
           data: {[csrfName]: csrfHash,rowinvoiceId:rowinvoiceId},
           success: function(data){
           $('#check_attach').html("");
            for(var i = 0; i < data.length; i++) {
               console.log(data[i]['files']);
               if(data[i]['files']){
                  $('#check_attach').append('<a href='+base_url+'uploads/'+encodeURI(data[i]["files"])+' class="file-block" target=_blank><span class="file-delete"><span><i class="fa fa-trash-o"></i></span></span>'+encodeURI(data[i]["files"])+'</a>');
               }else{
                  $('#check_attach').html("No attachment Found");
               }
            }
           }
       });
    }
  });
});


$(document).ready(function() {
  $('#isOceanattachment').change(function() {
    if ($(this).is(':checked')) {
    var ocean_id = $('#get_oceanid').val();
    $.ajax({
           url:"<?php echo base_url(); ?>Cinvoice/Get_oceanattachments_view",
           type: 'POST',
           dataType: 'json',
           data: {[csrfName]: csrfHash,ocean_id:ocean_id},
           success: function(data){
           $('.ocean_check_attach').html("");
            for(var i = 0; i < data.length; i++) {
               console.log(data[i]['files']);
               if(data[i]['files']){
                  $('.ocean_check_attach').append('<a href='+base_url+'uploads/'+encodeURI(data[i]["files"])+' class="file-block" target=_blank><span class="file-delete"><span><i class="fa fa-trash-o"></i></span></span>'+encodeURI(data[i]["files"])+'</a>');
               }else{
                  $('.ocean_check_attach').html("No attachment Found");
               }
            }
           }
       });
    }
  });
});
$(document).ready(function() {
  $('#isTruckingattachment').change(function() {
    if ($(this).is(':checked')) {
    var trucking_id = $('#get_truckingid').val();
    $.ajax({
           url:"<?php echo base_url(); ?>Cinvoice/Get_truckingattachments_view",
           type: 'POST',
           dataType: 'json',
           data: {[csrfName]: csrfHash,trucking_id:trucking_id},
           success: function(data){
           $('.ocean_check_attach').html("");
            for(var i = 0; i < data.length; i++) {
               console.log(data[i]['files']);
               if(data[i]['files']){
                  $('.ocean_check_attach').append('<a href='+base_url+'uploads/'+encodeURI(data[i]["files"])+' class="file-block" target=_blank><span class="file-delete"><span><i class="fa fa-trash-o"></i></span></span>'+encodeURI(data[i]["files"])+'</a>');
               }else{
                  $('.ocean_check_attach').html("No attachment Found");
               }
            }
           }
       });
    } else {
    }
  });
});


 var succalert = '<div class="alert alert-success alert-dismissible" role="alert">';
        var failalert = '<div class="alert alert-danger alert-dismissible" role="alert">';
        var alert2 = '<button type="button" style="margin-top: -20px;" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
$('#add_pay_terms').submit(function(e) {
    e.preventDefault();
    var data = {
        new_payment_terms: $('#new_payment_terms').val()
    };
    data[csrfName] = csrfHash;
    $.ajax({
        type: 'POST',
        data: data,
        dataType: "json",
        url: '<?php echo base_url(); ?>Cpurchase/add_payment_terms',
        success: function(response, status) {
    console.log(response); 
    $('#errormessage_paymenttype').html("");
    if (response.status == 'success') {
        $('#payment_terms').empty();
        $('#ven_terms').empty();
  $.each(response.data, function(index, item) {
            var option = '<option value="' + item.payment_terms + '">' + item.payment_terms + '</option>';
            $('#payment_terms').append(option);
            $('#ven_terms').append(option);
        });
  var newlyAddedType = response.data[response.data.length - 1].payment_terms; 
        $('#payment_terms').val(newlyAddedType);
        $('#ven_terms').val(newlyAddedType);
        if (!$('#payment_terms').data('ui-selectmenu')) {
            $('#payment_terms').selectmenu();
        }
        if (!$('#ven_terms').data('ui-selectmenu')) {
            $('#ven_terms').selectmenu();
        }
   $('#payment_terms').selectmenu('refresh', true);
        $('#payment_terms').show();
       $('#errormessage_paymenttype').html(succalert + response.msg + alert2);
 window.setTimeout(function() {
            $('#payment_type_new').modal('hide');
        }, 2500);
    } else {
       $('#errormessage_paymenttype').html(failalert + response.msg + alert2);
    }
}
    });
});
// Function for Calculation for Sales

function calculateSum(context, selector) {

    var sum = 0;
    $(context).find(selector).each(function() {
        sum += parseFloat($(this).val()) || 0;
    });
    return sum;
}
// To calculate the values for the fields in Table footer
function updateTableTotals(tableId) { 
 var tableIdentifier = tableId.split('_').pop();
    var sumNet = calculateSum('#' + tableId, '.net_sq_ft');
    $('#overall_net_' + tableIdentifier).val(sumNet.toFixed(2));
 var sumTotalPrice = calculateSum('#' + tableId, '.total_price');
    $('#Total_' + tableIdentifier).val(sumTotalPrice.toFixed(2));
 var sumGross = calculateSum('#' + tableId, '.gross_sq_ft');
    $('#overall_gross_' + tableIdentifier).val(sumGross.toFixed(2));
 var totalNetSalesPrice = calculateSum('#' + tableId, '.sales_amt_sq_ft');
    $('#salespricepersqft_' + tableIdentifier).val(totalNetSalesPrice.toFixed(2));
    var totalNetSalesSlabPrice = calculateSum('#' + tableId, '.sales_slab_amt');
    $('#salesslabprice_' + tableIdentifier).val(totalNetSalesSlabPrice.toFixed(2));
        var totalNetCost = calculateSum('#' + tableId, '.cost_sq_ft');
    $('#costpersqft_' + tableIdentifier).val(totalNetCost.toFixed(2));
        var totalNetCostSlabPrice = calculateSum('#' + tableId, '.cost_sq_slab');
    $('#costperslab_' + tableIdentifier).val(totalNetCostSlabPrice.toFixed(2));
   var totalWeightvalue = calculateSum('#' + tableId, '.weight');
    $('#overall_weight_' + tableIdentifier).val(totalWeightvalue.toFixed(2));
}
// To calculate the overall total
function updateOverallTotals(includeGross = false) {

    var totalNet = calculateSum('.table', '.net_sq_ft');
    $('#total_net').val(totalNet.toFixed(2)).trigger('change');

    var overallSum = calculateSum('.table', '.total_price');
    $('#Over_all_Total').val(overallSum.toFixed(2)).trigger('change');
 var totalWeight = calculateSum('.table', '.weight');
    $('#total_weight').val(totalWeight.toFixed(2)).trigger('change');
    if (includeGross) {
        var totalGross = calculateSum('.table', '.gross_sq_ft');
        $('#total_gross').val(totalGross.toFixed(2)).trigger('change');
    }
   
  var gtotal = parseFloat($('#gtotal').val()) || 0; 
 var overall_total = parseFloat($('#Over_all_Total').val()) || 0;

          if($('#product_tax').val()) {
                var total=$('#Over_all_Total').val();
                var tax= $('#product_tax').val();
                var percent='';
                 var hypen='-';
               if(tax.indexOf(hypen) != -1){
                var field = tax.split('-');
               
                var percent = field[1];
               
               }else{
               percent=tax;
               }
               
                percent=percent.replace("%","");
                 var answer = (percent / 100) * parseFloat(total);
                   $('#tax_details').val(answer.toFixed(2) +" ( "+tax+" )");
          }
        var additional_cost='';
         if($('#landing_amount').val()){
           $('#additional_cost').val(parseFloat($('#landing_amount').val()));
 additional_cost= parseFloat($('#additional_cost').val()) || 0; 
         }
        var tax_amount = (overall_total * tax) / 100;
      
         overall_total = parseFloat(overall_total) || 0;
 tax_amount = parseFloat(tax_amount) || 0;
 additional_cost = parseFloat(additional_cost) || 0;
  var amt=parseFloat(answer)+parseFloat(total);
                 var num = isNaN(parseFloat(amt)) ? 0 : parseFloat(amt);
                  var additional_cost =parseFloat($('#additional_cost').val()) || 0;
                   $('#gtotal').val((num+additional_cost).toFixed(2)); 
if(num <= 0){
   $('#gtotal').val((overall_total+additional_cost).toFixed(2)); 
}
 var paid_amount =parseFloat($('#amount_paid').val()) || 0;
    
       var balance_amount= gtotal- paid_amount;
    $('#balance').val(balance_amount);

 var custo_amt = parseFloat($('.custocurrency_rate').val()) || 1;
        var customer_prefered_currency = gtotal * custo_amt;
        $('#customer_gtotal').val(customer_prefered_currency.toFixed(2));
        $('#balance_customer_currency').val((balance_amount*custo_amt).toFixed(2));
      $('#paid_customer_currency').val((paid_amount*custo_amt).toFixed(2));

 
   
     var lc_cost=0;
               $('.table').each(function() {
   $(this).find('.l_cost').each(function() {
       var precio = $(this).val();
       if (!isNaN(precio) && precio.length !== 0) {
         lc_cost += parseFloat(precio);
       }
     });

   $(this).closest('table').find('.landingpersqft').val(lc_cost).trigger('change');
               });
   var  lc_sqft=0;
                $('.table').each(function() {

   $(this).find('.l_cost_slab').each(function() {
       var precio = $(this).val();
       if (!isNaN(precio) && precio.length !== 0) {
         lc_sqft += parseFloat(precio);
       }
     });

   $(this).closest('table').find('.landingperslab').val(lc_sqft).trigger('change');
               });

 
}
function updateNetCalculations() {
      var $row = $(this).closest('tr');
   var netWidthId = $(this).attr('id');

    const indexLastDot = netWidthId.lastIndexOf('_');
    var rowId = netWidthId.slice(indexLastDot + 1);
 var netWidthId = 'net_width_' + rowId;
    var netHeightId = 'net_height_' + rowId;
    var net_sq_ft = 'net_sq_ft_' + rowId;
    var salesAmtSqFtId = 'sales_amt_sq_ft_' + rowId;
 var netWidth = parseFloat($row.find('#' + netWidthId).val()) || 0;
    var netHeight = parseFloat($row.find('#' + netHeightId).val()) || 0;
    var netSqFt = (netWidth * netHeight) / 144;
 $row.find('#' + net_sq_ft).val(netSqFt.toFixed(2));

  var salesAmtSqFt = parseFloat($('#' + salesAmtSqFtId).val()) || 0;
        var salesSlabAmt = salesAmtSqFt * netSqFt;
        $('#sales_slab_amt_' + rowId).val(salesSlabAmt.toFixed(2));
        $('#total_amt_' + rowId).val(salesSlabAmt.toFixed(2));
         var tableId = $row.closest('table').attr('id');
    updateTableTotals(tableId);
  updateOverallTotals(true);
}
// Gross Calculation
function updateGrossCalculations() {
    var $row = $(this).closest('tr');
   var grossWidthId = $(this).attr('id');
    const indexLastDot = grossWidthId.lastIndexOf('_');
    var rowId = grossWidthId.slice(indexLastDot + 1);
 var grossWidthId = 'gross_width_' + rowId;
    var grossHeightId = 'gross_height_' + rowId;
    var grossSqFtId = 'gross_sq_ft_' + rowId;
 var grossWidth = parseFloat($row.find('#' + grossWidthId).val()) || 0;
    var grossHeight = parseFloat($row.find('#' + grossHeightId).val()) || 0;
    var grossSqFt = (grossWidth * grossHeight) / 144;
 $row.find('#' + grossSqFtId).val(grossSqFt.toFixed(2));
 var tableId = $row.closest('table').attr('id');
    updateTableTotals(tableId);
  updateOverallTotals(true);
}
$(document).on('change input keyup', '.sales_amt_sq_ft', function() {
    var $row = $(this).closest('tr');
    var id_num = $(this).attr('id').split('_').pop();
    var salesAmtSqFt = parseFloat($('#sales_amt_sq_ft_' + id_num).val()) || 0;
    var netSqFt = parseFloat($('#net_sq_ft_' + id_num).val()) || 0;
var salesSlabAmt = salesAmtSqFt * netSqFt;
    $('#sales_slab_amt_' + id_num).val(salesSlabAmt.toFixed(2));
    $row.find('.total_price').val(salesSlabAmt.toFixed(2));
  updateTableTotals($row.closest('table').attr('id'));
  updateOverallTotals(true);
});

$(document).on('change input keyup', '.sales_slab_amt', function() {
    var $row = $(this).closest('tr');
    var id_num = $(this).attr('id').split('_').pop();
    var salesSlabAmt = parseFloat($('#sales_slab_amt_' + id_num).val()) || 0;
    var netSqFt = parseFloat($('#net_sq_ft_' + id_num).val()) || 0;
 var salesAmtSqFt = netSqFt ? salesSlabAmt / netSqFt : 0;
    $('#sales_amt_sq_ft_' + id_num).val(salesAmtSqFt.toFixed(2));
    $('#total_amt_' + id_num).val(salesSlabAmt.toFixed(2));
  updateTableTotals($row.closest('table').attr('id'));
  updateOverallTotals(true);
});


$(document).on('keyup', '.net_height, .net_width', updateNetCalculations);
$(document).on('input', '.gross_height, .gross_width', updateGrossCalculations);
   // To show 7 rows in the table on page load
$(document).ready(function(){

var tid=$('.table').closest('table').attr('id');
   const indexLast = tid.lastIndexOf('_');
   var id = tid.slice(indexLast + 1);
   for (j = 0; j < 6; j++) {
      var $last = $('#addPurchaseItem_1 tr:last');
   var num = id+($last.index()+1);
    $('#addPurchaseItem_1 tr:last').clone().find('input,select,button').attr('id', function(i, current) {
       return current.replace(/\d+$/, num);
   }).end().appendTo('#addPurchaseItem_1');
    $.each($('#normalinvoice_1 > tbody > tr'), function (index, el) {
           $(this).find(".slab_no").val(index + 1); // Simply couse the first "prototype" is not counted in the list
       })
   }
   });
   $(document).on('click', '.delete', function(){
 var rowCount = $(this).closest('tbody').find('tr').length;
   var $row = $(this).closest('tr');
   if(rowCount>1){
   $(this).closest('tr').remove();
   }
updateTableTotals($row.closest('table').attr('id'));
updateOverallTotals(true);
   });
  
    $(document).on('click', '.addbundle', function(){
        $(this).css("display","none");
     $(this).closest('table').find('.removebundle').css("display","block");
   });
// On key add new row
$(document).on('keyup', '.normalinvoice tbody tr:last', function (e) {
debugger;

    var tableId = $(this).closest('table').attr('id');
    var dynamicId = tableId.split('_').pop();


    var $lastRow = $('#addPurchaseItem_' + dynamicId + ' tr:last');
    var $newRow = $lastRow.clone();


    var rowCount = $('#addPurchaseItem_' + dynamicId + ' tr').length;
    var newRowNumber = dynamicId+''+rowCount;


    $newRow.find('datalist, input, select, button').each(function () {
        var $element = $(this);
        var currentId = $element.attr('id');

        if (currentId) {

            var newId = currentId.replace(/\d+$/, newRowNumber);
            $element.attr('id', newId);


            if ($element.is('input') || $element.is('select')) {
                if ($element.hasClass('product_name')) {

                    $element.val('').prop('disabled', false);
                } else {
                    $element.val('');
                }
            }
        }
    });


    $newRow.appendTo('#addPurchaseItem_' + dynamicId);
    $('#normalinvoice_' + dynamicId + ' tbody tr').each(function (index) {
        $(this).find(".slab_no").val(index + 1);
    });
});
</script>

<script type="text/javascript">
    
// Attachment Script
const dt = new DataTransfer();
$("#attachment").on('change', function(e){
    for(var i = 0; i < this.files.length; i++){
        let fileBloc = $('<span/>', {class: 'file-block'}),
        fileName = $('<span/>', {class: 'name', text: this.files.item(i).name});
        fileBloc.append('<span class="file-delete"><span><i class="fa fa-trash-o"></i></span></span>').append(fileName);
        $("#filesList > #files-names").append(fileBloc);
   };
   for (let file of this.files) {
       dt.items.add(file);
   }
   this.files = dt.files;
   $('span.file-delete').click(function(){
       let name = $(this).next('span.name').text();
       $(this).parent().remove();
       for(let i = 0; i < dt.items.length; i++){
           if(name === dt.items[i].getAsFile().name){
               dt.items.remove(i);
               continue;
           }
       }
       document.getElementById('attachment').files = dt.files;
   });
});

// Proforma Edit Image Delete
$('.proforma-file-delete').click(function(){
   let name = $(this).next('.name').text();
   $(this).parent().remove();
   for(let i = 0; i < dt.items.length; i++){
      if(name === dt.items[i].getAsFile().name){
         dt.items.remove(i);
         continue;
      }
   }
   document.getElementById('attachment').files = dt.files;
});
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/select2.min.css">
<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>assets/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>assets/datatables/dataTables.colReorder.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/datatables/buttons.dataTables.min.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables/dataTables.buttons.min.js"></script>
 <script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables/buttons.colVis.min.js"></script>
<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>assets/datatables/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>assets/datatables/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/buttons.print.min.js"></script>
<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/daterangepicker.css"> -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/css.css" />

                                   