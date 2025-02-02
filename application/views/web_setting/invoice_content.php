<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Invoice Content</h1>
            <small></small>
        <ol class="breadcrumb"   style=" border: 3px solid #D7D4D6;"   >
                <li><a href="<?php echo base_url(); ?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('web_settings') ?></a></li>
                <li class="active" style="color:orange;"><?php echo display('Invoice Content') ?></li>
            </ol>
        </div>
    </section>
    <section class="content">
        <!-- Alert Message -->      
        <?php
        $message = $this->session->userdata('message');
        if (isset($message)) {
            ?>
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $message ?>                    
            </div>
            <?php
            $this->session->unset_userdata('message');
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
        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                      <div class="container">
                          <div class="row">
                              <div class="col-sm-4  "> <div class="panel panel-default">
<form action="updateinvoice2" method="post">
    <div class="panel-body"> 
       <div class="form-group">
           <label>Business Name</label>
           <input type="text" name="name" class="form-control" value="<?php if($cname!=''){echo $cname ; }?>">
       </div>
       <div class="form-group">
           <label>Business Address</label>
           <input type="text" name="address" class="form-control" value="<?php if($address!=''){
            echo $address;
             }?>">
       </div>
       <div class="form-group">
           <label>Business Phone</label>
           <input type="text" name="phone" class="form-control" value="<?php if($phone!=''){echo $phone ; }?>">
       </div>
       <div class="form-group">
           <label>Business Email</label>
           <input type="text" name="email" class="form-control" value="<?php if($email!=''){echo $email ; }?>">
       </div>
      
       <div class="form-group">
           <label>Business Register no</label>
           <input type="text" name="regno" class="form-control" value="<?php if($reg_number!=''){
            echo $reg_number;
             }?>">
       </div>
       <input type="hidden"   name="encodedId" value="<?php echo $encodedId;  ?>"  >
       <input type="hidden"   name="decodedId" value="<?php echo $decodedId;  ?>"  >
        <div class="form-group">
           <label>Website</label>
           <input type="text" name="website" class="form-control" value="<?php if($website!=''){
            echo $website;
             }?>">
       </div>
       <div class="form-group">
           <input type="submit"  class="btnclr btn m-b-5 m-r-2" name="add-customer"   style="color:white;border-color: #2e6da4;"  value="ADD" >
       </div>
    </div>
  </div>    </div>
                              <div class="col-sm-8"> <div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-3"><?php  
            if($cname!=='')
            { 
            echo $cname; 
        }
        ?> <br>
                <p>
                  <?php if($address!=='')
            { 
            echo $address; 
        }; ?>   <br> 
            
   <?php if($phone!=='')
            {  echo $phone; } ?> 

        <br>

        <?php
if($email!=='')
            {
                   echo $email;
               }
                    ?><br>
 
        <?php if($reg_number!=='')
            { 
            echo $reg_number; 
        }; ?>
            <br> 
                
                 
                <?php
                  if($website!=='')
            {
                   echo $website;
               }
                    ?><br>
              
                   <br>
                   <br>
                </p>
              </div>
             <div class="col-sm-6 text-center"><?php echo $header; ?></div>
            <div class="col-sm-3">
           <!-- <img src="<?php //echo base_url() .$invoice_logo[0]['invoice_logo']; ?>" style="width: 40%;"> -->
           <img src="<?php echo base_url().$logo; ?>" style="width: 40%;">

          </div>
        </div>
        <div class="row">
<table width="95%" height='100%'  style="margin-left:19px;" border="1">
  <tr style="background-color: #<?php echo $color; ?>;color:white;">
    <td>Product Name</td>
    <td>Description</td>
    <td>Qty</td>
    <td>Rate</td>
    <td>Amount</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br>
<br>
 
 <div class="form-group"  style="margin-left:20px;" >

 <th class="heading avoid-page-break " style="font-size: 9px;"><b><?php echo display('Account Details/Additional Information') ?></b> : </th>
      </br> <textarea name="example" readonly id="example"></textarea><br/>
      <th class="heading avoid-page-break" style="font-size: 9px;"><b><?php echo display('Remarks/Conditions') ?>:</b> </th>
      </br> <textarea name="example" readonly id="example"></textarea><br/>
      </div>


<div class="form-group"  style="margin-left:15px;" >
           <!-- <label>Remarks :</label> -->
           <td>&nbsp;</td>
       </div>
        </div>
         <br>

        <div class="form-group"  style="margin-left:15px;" >
           <label></label>
       </div>
        </div>
    </div>
  </div>
 
       </div>                    </div>
                          </div>
                      </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new customer end -->
<script type="text/javascript">
     $('#colorcombo').hide();
    $('#templateformart').hide();
    $('#uploadlogo').hide();
    $('#template').click(function(){
        $("#templateformart").toggle();
    });
     $('#templatecolor').click(function(){
        $("#colorcombo").toggle();
    });
      $('#templatelogo').click(function(){
        $("#uploadlogo").toggle();
    });
          $("#header").blur(function(){
    var value=$(this).val();
    var uid='<?php echo $decodedId; ?>';
    $.ajax({url: "http://localhost//assets/update_templates.php?value="+value+"&input=header&id="+uid, success: function(result){
   location.reload();
  }
});
});
///////////////Ajax Dot////////
function dot(value)
{
    var uid='<?php echo $decodedId; ?>';
     $.ajax({url: "http://localhost//assets/update_templates.php?value="+value+"&input=color&id="+uid, success: function(result){
         alert('Color '+result);  
        location.reload();
  }});
 }
</script>
<style type="text/css">
.btnclr{
       background-color:<?php echo $setting_detail[0]['button_color']; ?>;
       color: white;
   }
    .dot1 {
  height: 25px;
  width: 25px;
  background-color: #D7163A;
  border-radius: 50%;
  display: inline-block;
}
.dot2 {
  height: 25px;
  width: 25px;
  background-color: #720303;
  border-radius: 50%;
  display: inline-block;
}
.dot3 {
  height: 25px;
  width: 25px;
  background-color: #71D716;
  border-radius: 50%;
  display: inline-block;
}
.dot4 {
  height: 25px;
  width: 25px;
  background-color: #3616D7;
  border-radius: 50%;
  display: inline-block;
}
.dot5 {
  height: 25px;
  width: 25px;
  background-color: #D7B916;
  border-radius: 50%;
  display: inline-block;
}
.dot6 {
  height: 25px;
  width: 25px;
  background-color: #D79A16;
  border-radius: 50%;
  display: inline-block;
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
  background-color: #4B9CDB;
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
    background-color: #F5634A;
    width: 170px;
  }
}
</style>
