<div class="content-wrapper">
  <section class="content-header" style='padding:30px;'>
    <div class="header-icon"> <i class="pe-7s-note2" style='margin-top: -14px;'></i> </div>
    <div class="header-title">
      <h1><?php echo ('View cart') ?></h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
        <li><a href="#">View Cart</a></li>
        <li class="active">Cart</li>
      </ol>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
          <div class="panel-body">
            <form action="<?php echo base_url('Cinvoice/fetchData') ?>" method='post'>
              <div class="table-responsive">
                <table class="table table-bordered" id="">
                  <thead>
                    <tr>
                      <th rowspan="2" style="width: max-content;" class="text-center">Description</th>
                      <th rowspan="2" style="width:100px;" class="text-center">Thickness<i class="text-danger">*</i></th>
                      <th rowspan="2" style="width:100px;" class="text-center">Supplier<br />Block No<i class="text-danger">*</i></th>
                      <th rowspan="2" style="width:100px;" class="text-center">Supplier <br />Slab No<i class="text-danger">*</i> </th>
                      <th colspan="2" style="width:150px;" class="text-center">Gross Measurement<i class="text-danger">*</i> </th>
                      <th rowspan="2" class="text-center">Gross Sq.Ft</th>
                      <th rowspan="2" style="width: min-content;" class="text-center">Bundle No<i class="text-danger">*</i></th>
                      <th rowspan="2" style="width: min-content;" class="text-center">Slab No<i class="text-danger">*</i></th>
                      <th colspan="2" style="width:150px;" class="text-center">Net Measure<i class="text-danger">*</i></th>
                      <th rowspan="2" class="text-center">Net Sq.Ft</th>
                      <th rowspan="2" style="width: 70px;" class="text-center">Cost per Sq.Ft<?php echo  ' ( '.$currency[0]['currency'].' ) ';  ?></th>
                      <th rowspan="2" style="width: 70px;" class="text-center">Cost per Slab<?php echo  ' ( '.$currency[0]['currency'].' ) ';  ?></th>
                      <th rowspan="2" style="width: 70px;" class="text-center">Sales<br />Price per Sq.Ft <?php echo  ' ( '.$currency[0]['currency'].' ) ';  ?></th>
                      <th rowspan="2" class="text-center">Sales Slab Price<?php echo  ' ( '.$currency[0]['currency'].' ) ';  ?></th>
                      <th rowspan="2" class="text-center">Weight</th>
                      <th rowspan="2" class="text-center">Origin</th>
                      <th rowspan="2" style="width: 100px" class="text-center">Total<?php echo  ' ( '.$currency[0]['currency'].' ) ';  ?></th>
                      <th rowspan="2" style="width: 70px" class="text-center">Remove</th>
                    </tr>
                    <tr>
                      <th class="text-center">Width</th>
                      <th class="text-center">Height</th>
                      <th class="text-center">Width</th>
                      <th class="text-center">Height</th>
                    </tr>
                  </thead>
                  <tbody class="show-cart table" id="itemlist"> </tbody> <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                </table> <br /><br />
                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-check-inline"> <label class="form-check-label" for="radio1"> <input type="radio" style="position: relative; top: 1px;" class="form-check-input" name="radio_action" value="invoice" required> Create Invoice </label> </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-check-inline"> <button type="submit" class="btn btn-primary btn_invoice">Pass Data</button> </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-check-inline"> <label class="form-check-label" for="radio1"> <input type="radio" style="position: relative; top: 1px;" class="form-check-input" name="radio_action" value="quotation" required> Create Quotation </label> </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script type="text/javascript">
  $(function(){
  var data = sessionStorage.getItem("shoppingCart");
  var cartArray = JSON.parse(data);
  var output ="";
    for(var i = 0; i < cartArray.length; i++)  {
    	var j = 1;
     output += "<tr class='delete_row'>"
      + "<td prop='tableid' style='display: none;'>" +"<input type='hidden' class='form-control' name=tableid[] id='tableid' value="+'1'+i+"> "+  "</td>"
      + "<td prop='product_id' style='display: none;'>" +"<input type='hidden' class='form-control' name=product_id[] id='product_id' value="+cartArray[i].product_id+"> "+  "</td>"
      + "<td prop='description'>" +"<input type='text' name='description[]' class='form-control' id='description' readonly  value="+cartArray[i].description+">"+  "</td>"
      + "<td prop='thickness'>" +"<input type='text' class='form-control' name='thickness[]' id='thickness' readonly  value="+ cartArray[i].thickness+ ">"+ "</td>"
      + "<td prop='supplier_block_no'>" +"<input type='text' class='form-control' id='supplier_block_no' name='supplier_block_no[]' readonly  value="+ cartArray[i].supplier_block_no +">"+ "</td>"
      + "<td prop='supplier_slab_no'>" +"<input type='text' class='form-control' id='supplier_slab_no' name='supplier_slab_no[]' readonly  value="+ cartArray[i].supplier_slab_no +">"+ " </td>"
      + "<td prop='g_width'>" +"<input type='text' class='form-control' id='g_width' name='g_width[]' readonly  value="+ cartArray[i].g_width +">"+ " </td>"
      + "<td prop='g_height'>" +"<input type='text' class='form-control' id='g_height' name='g_height[]' readonly  value="+ cartArray[i].g_height +">"+ " </td>"
      + "<td prop='gross_sq_ft'>" +"<input type='text' class='form-control size_view' id='gross_sq_ft' name='gross_sq_ft[]' readonly  value="+ cartArray[i].gross_sq_ft+ ">"+ "</td>"
      + "<td prop='bundle_no'>" +"<input type='text' class='form-control size_view' id='bundle_no' name='bundle_no[]' readonly value="+ cartArray[i].bundle_no + ">"+"</td>"
      + "<td prop='slab_no'>" +"<input type='text' class='form-control size_view' id='slab_no' name='slab_no[]' readonly   value="+ cartArray[i].slab_no +">"+"</td>"
      + "<td prop='n_width'>" +"<input type='text' class='form-control' id='n_width' name='n_width[]' readonly  value="+ cartArray[i].n_width +">"+ " </td>"
      + "<td prop='n_height'>" +"<input type='text' class='form-control' id='n_height' name='n_height[]' readonly  value="+ cartArray[i].n_height +">"+ " </td>"
      + "<td prop='net_sq_ft'>" +"<input type='text' class='form-control size_view' id='net_sq_ft' name='net_sq_ft[]' readonly  value="+ cartArray[i].net_sq_ft+">"+ "</td>"
      + "<td prop='cost_sq_ft'>" +"<input type='text' class='form-control size_view' id='cost_sq_ft' name='cost_sq_ft[]' readonly  value="+ cartArray[i].cost_sq_ft +">"+ "</td>"
      + "<td prop='cost_sq_slab'>" +"<input type='text' class='form-control size_view' id='cost_sq_slab' name='cost_sq_slab[]' readonly  value="+ cartArray[i].cost_sq_slab+ ">"+ "</td>"
      + "<td prop='sales_amt_sq_ft'>" +"<input type='text' class='form-control size_view' id='sales_amt_sq_ft' name='sales_amt_sq_ft[]'  readonly  value="+ cartArray[i].sales_amt_sq_ft+">"+ "</td>"
      + "<td prop='sales_slab_amt'>" +"<input type='text' class='form-control size_view' id='sales_slab_amt'  name='sales_slab_amt[]' readonly  value="+ cartArray[i].sales_slab_amt+ ">"+"</td>"
      + "<td prop='weight'>" +"<input type='text' class='form-control size_view' id='weight' name='weight[]' readonly  value="+ cartArray[i].weight+ ">"+ "</td>"
      + "<td prop='origin'>" +"<input type='text' class='form-control size_view' id='origin' name='origin[]' readonly  value="+ cartArray[i].origin+ ">"+ "</td>"
      + "<td prop='total_amt'>" +"<input type='text' class='form-control size_view' id='total_amt'  name='total_amt[]' readonly  value="+ cartArray[i].total_amt+">"+"</td>"
      + "<td><button class='delete-item btn btn-danger' data-product_id=" + cartArray[i].product_id + " data-description=" + cartArray[i].description + " data-thickness=" + cartArray[i].thickness + " data-supplier_block_no = "+ cartArray[i].supplier_block_no +" data-gross_sq_ft = "+ cartArray[i].gross_sq_ft +" data-bundle_no = "+ cartArray[i].bundle_no +" data-slab_no = "+ cartArray[i].slab_no +" data-net_sq_ft = "+ cartArray[i].net_sq_ft +" data-cost_sq_ft = "+ cartArray[i].cost_sq_ft +" data-cost_sq_slab = "+ cartArray[i].cost_sq_slab +" data-sales_amt_sq_ft = "+ cartArray[i].sales_amt_sq_ft +" data-sales_slab_amt = "+ cartArray[i].sales_slab_amt +" data-weight = "+ cartArray[i].weight +" data-origin = "+ cartArray[i].origin +" data-total_amt = "+ cartArray[i].total_amt +"><i class='fa fa-trash' aria-hidden='true'></i></button></td>"
      "</tr>";
    }
    $(".show-cart").append(output);
  });
    var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
    var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
  $('.show-cart').on("click", ".delete-item", function(event) {
  event.preventDefault();
  var product_id = $(this).data('product_id');
  var bundle_no = $(this).data('bundle_no');
  $.get("<?php echo base_url('Cinvoice/deleteCart') ?>",{product_id: product_id, bundle_no: bundle_no}, function(data, status){
  	if(data){
  		$(this).closest('tr').find('td').remove();
  		sessionStorage.clear("shoppingCart");
  		location.reload();
  	}
  })
  });
</script>