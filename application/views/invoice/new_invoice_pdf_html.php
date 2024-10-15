<style>
   .book {
  margin: 0;
  padding: 0;
  background-color: #FAFAFA;
  font: 12pt "Tahoma";
}

* {
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}

.page {
  display: block;
  width: 21cm;
  height: 29.7cm;
  margin: 1cm auto;
  border: 1px #D3D3D3 solid;
  border-radius: 5px;
  background: white;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

.subpage {
  margin: 1cm;
  width: 19cm;
  height: 27.7cm;
  outline: 0cm #FAFAFA solid;
}

@page {
  size: A4;
  margin: 0;
}

@media print {
  .page {
    margin: 0;
    border: initial;
    border-radius: initial;
    width: initial;
    min-height: initial;
    box-shadow: initial;
    background: initial;
    page-break-after: always;
  }
}
</style>

 
<div class="container-fluid">
  <div class="book">
 
    <div class="page">

         <div class="brand-section" >
            <div class="row" >
            
               <div class="col-sm-5" style="color:black;font-weight:bold;">
               <img src="<?php echo base_url().$logo; ?>" style="width:30%;margin-left:25px;margin-top:20px;" />
               </div>
             
               <div class="col-sm-4" style="color:black;font-weight:bold;text-align:center;margin-top:40px;margin-left:-95px;">
                  <h3  style="text-align: center;font-weight:bold;" >Commerical Invoice</h3>
               </div>

              <div class="col-sm-4" style="margin-top: 45px;">
                  <b><?php echo display('Invoice Number') ?>: </b> <?php  echo $all_invoice[0]['commercial_invoice_number'] ; ?> <br>
                  <b>  <?php echo ('Date') ?>: </b><?php  echo $invoice_detail[0]['date']  ; ?><br>
               </div>

            </div>
         </div>

       <hr>
   <!-- //start -->
       <div class="subpage" id='editor-container'>
   <!-- //start -->
 
       <div class="brand-section" >
            <div class="row" >
            
               <div class="col-sm-6" style="color:black;margin-top:-30px;margin-left: -16px;">
              
                <div class="col-sm-8"  >
               <b><span style="font-weight:bold;">Company Information</span><br> 
               <b><?php echo $company[0]['company_name']; ?><br>
               <b><?php echo $company[0]['address']; ?><br>
               <b><?php echo $company[0]['email']; ?><br>
               <b><?php echo $company[0]['mobile']; ?><br>
               </div>
               </div>
              
              <div class="col-sm-5" style="margin-top:-30px;margin-left: 78px;">
              <b><span style="font-weight:bold;">Bill To</span><br> 
                <?php  echo $all_invoice[0]['billing_address'] ; ?><br>
                </div>
            </div>

            <hr>
 
            <table style="width:100%;border: 1px solid;color: darkgray;">
                <thead style="background-color:#424f5c;">
                <tr class="avoid-page-break" >
                <th class="text-center text-white">Total Due</th>
                        <th class="text-center text-white">Payment Terms</th>
                        <th class="text-center text-white">Due Date</th>
                     </tr>
               </thead>
               <tbody>
                  <tr >
                     <td style="border: 1px solid;color: black;"> <?php echo $customer_currency." ".$due_amount;?></td>
                     <td style="border: 1px solid;color: black;"> <?php  echo $payment_terms ; ?></td>
                     <td style="border: 1px solid;color: black;"> <?php  echo $payment_terms ; ?></td>
                  </tr>
               </tbody>
            </table>
           
            <hr>
 
            <?php for($m=1;$m<count($all_invoice);$m++){   ?>
              
               <table  style="width:100%;border: 1px solid;color: black;" class="table table-bordered normalinvoice table-hover" id="normalinvoice_<?php  echo $m; ?>" >
                  <thead style="background-color:#424f5c;" >
                     <tr class="avoid-page-break">
                        <th class="text-center text-white ;" style="width:230px">Product Name</th>
                        <th class="text-center text-white">Description</th>
                        <th class="text-center text-white">Quantity</th>
                        <th class="text-center text-white">Rate</th>
                        <th class="text-center text-white">Total</th>
                     </tr>
                  </thead>

 
                  <tbody id="addPurchaseItem_<?php echo $m;  ?>">
                     <?php  $n=0; ?>
                     <?php foreach($all_invoice as $inv){
                        $a = substr($inv['tableid'], 0, 1);
                        if($a==$m){
                                                            
                                                                ?>
                        <tr class="avoid-page-break">
                        <td style="font-size: 9px;"><?php echo $n+1; ?></td>
                        <td style="font-size: 9px;word-wrap: break-word;"><?php  echo $inv['product_name'];  ?></td>
                        <td style="font-size: 9px;word-wrap: break-word;"><?php  echo $inv['description'];  ?></td>
                     
                        <td style="font-size: 9px;"><?php echo $n+1; ?></td>
                        <td style="font-size: 9px;"><?php echo $n+1; ?></td>


                     </tr>
                     <?php $n++;   } }  ?>
                  </tbody>


                  <tfoot>
                     <tr class="avoid-page-break" >
                     
                        <td style="text-align:right;font-size: 8px;" colspan="4"><b><?php echo display('TOTAL') ?> :</b></td>
                        <td style="text-align:start;font-size: 8px;">
                           <input type="text" id="Total_<?php echo $m; ?>" name="total[]"   class="b_total"   style="padding-top: 6px;width: 50px;font-size: 9px;"    readonly="readonly"  />
                        </td>
                     </tr>
                  </tfoot>
   
               </table>
               <?php   } ?>


             
         <table border="0" class="overall table table-hover">
         <tr class="avoid-page-break" >
         <td colspan="2"  style="vertical-align:top;text-align:right;border:none;"></td>
         <td colspan="1" style="border:none;"></td>
            <td style="text-align:right;border:none;" colspan="5"><b><?php echo  display('tax')." (".$tax_des;  ?></b>:</td>
            <td style='border:none;'><?php  echo $currency; ?><?php echo $tax_amt;  ?></td>
         </tr>


         <tr class="avoid-page-break">
            <td colspan="2"  style="vertical-align:top;text-align:right;border:none;"></td>
            <td colspan="1" style="border:none;"></td>
            <td class="amt" colspan="5"  style="vertical-align:top;text-align:right;border:none;"><b>Additional Cost :</b></td>
            <td class="amt" style="border:none;" colspan="1">
            <table border="0">
                   
            </table>
         </tr>

 
         <tr class="avoid-page-break" >
         <td colspan="2"  style="vertical-align:top;text-align:right;border:none;"></td>
         <td colspan="1" style="border:none;"></td>
         <td colspan="5" style="text-align:right;border:none;"><b><?php  echo display('GRAND TOTAL');?> :</b></td>
         <td colspan="1" style="border:none;"><?php  echo $currency ; ?><?php  echo $all_invoice[0]['gtotal'];    ?></td>
         </tr>

         <tr class="avoid-page-break" >
         <td colspan="2"  style="vertical-align:top;text-align:right;border:none;"></td>
         <td colspan="1" style="border:none;"></td>

            <td colspan="5" class="amt" style="text-align:right;border:none;"><b><?php  echo display('Amount Paid');?> :</b></td>
            <td style="border:none;">
               <table border="0">
                  <tr class="amt">
                     <td class="cus" name="cus" style="text-align:left;"></td>
                     <td>  <?php echo $customer_currency." ".$paid_amount ;?></td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>

 

      <br>
      <th class="heading avoid-page-break " style="font-size: 9px;"><b><?php echo display('Account Details/Additional Information') ?></b> : </th>
      </br><?php echo $all_invoice[0]['ac_details'];  ?>  <br/><br/>
      <th class="heading avoid-page-break" style="font-size: 9px;"><b><?php echo display('Remarks/Conditions') ?>:</b> </th>
      </br><?php  echo $all_invoice[0]['remark']; ?>  <br/><br/> 

         

         </div>
         </div>
 
   <!-- //end -->
 </div>
   <!-- //end -->











  </div>
</div>