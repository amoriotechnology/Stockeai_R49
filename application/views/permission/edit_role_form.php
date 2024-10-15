<?php error_reporting(1);  ?>
<style type="text/css">
    .alert-success
    {
        background-color: #dff0d8;
        color: #000;
        display: none;
    }    
.btnclr{
       background-color:<?php echo $setting_detail[0]['button_color']; ?>;
       color: white;
   }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo $title ?></h1>
            <small></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('permission') ?></a></li>
                <li class="active" style="color:orange;"><?php echo $title ?></li>
            </ol>
        </div>
    </section>
    <section class="content">
 <div class="alert alert-success" >
  <strong>Success!</strong>Roles Updated Successfully
</div>
  <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
 <div class="panel-heading" style="height: 50px;">
 <a style="float:right;color:white;" href="<?php echo base_url('Permission/role_list') ?>" class="btnclr btn  m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo ('Manage Role List')?> </a>
<div class="panel-title">
                        </div>
                    </div>
                     <form action="<?php echo base_url('Permission/update_roles'); ?>"  method="post">
                        <input type="hidden" name="rid" value="<?php echo $role[0]['role_id']; ?>">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

                    <div class="panel-body">
                         <div class="form-group row">
                            <label for="type" class="col-sm-3 col-form-label"><?php echo display('role_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" tabindex="2" class="form-control" name="rolename" id="type" value="<?php echo $type[0]['type']; ?>" required />
                            </div>
                        </div>
                        <table class="table table-striped">
             <?php
  $m=1;
          $split=array();
                           foreach($name  as $test['items']){
                      foreach($test['items']  as $t){
  $split=explode(',',$t);
}
}
foreach($split as $sp){
     $c=explode('-',$sp);
     $l=array();
    $l['nam']=$c[0];
         $l['num']=$c[1];
}
  $expense = "expense";
  $i=0;
         foreach($accounts as $value) {
  ?>
 <tr>     
<td><?php   echo $value['name'];?></td>
  <td> <input type="checkbox" name="<?php echo $value['name'];?>_create" <?php for($i=0;$i<count($split);$i++){    if (strpos($split[$i],$value['name']) !== false) { if (strpos($split[$i],"1000") !== false){ echo 'checked';}}} ?>>Create<?php  ?>
<?php   if($value['name'] ==$expense  ){ ?> <div> 
 <input type="checkbox" name="<?php echo $expense  ;?>_price" >&nbsp;<?php echo "Price Adjustment" ?>               
   </div>  </td> <?php } ?>
       <td><input type="checkbox" name="<?php echo $value['name'];?>_update" <?php for($i=0;$i<count($split);$i++){    if (strpos($split[$i],$value['name']) !== false) { if (strpos($split[$i],"0010") !== false){ echo 'checked';}}} ?> >Update</td> 
    <td><input type="checkbox" name="<?php echo $value['name'];?>_delete"  <?php for($i=0;$i<count($split);$i++){    if (strpos($split[$i],$value['name']) !== false) { if (strpos($split[$i],"0001") !== false){ echo 'checked';}}} ?>>Delete</td> 
 </tr>
 <?php $sl = 0 ?>
  <?php  $i++;
  }  ?>
                </table>
                <br>
                <div class="form-group text-left">
                <input type="hidden" name="uid" value="<?php echo $_SESSION['user_id'];?>">  
                <button type="submit" class="btnclr btn "><?php echo display('update') ?></button>
            </div>
    </form>
                    </div>
                </div>
            </div>
        </div>
  </section>
</div>

