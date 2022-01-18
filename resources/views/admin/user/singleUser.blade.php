@extends('admin.layouts/admin')
@section('content')
<link rel="stylesheet" href="{{asset('/').('public/frontend/css/notifIt.css')}}">
<link href="{{asset('/').('public/frontend/build/css/intlTelInput.css?1533313793009')}}" rel="stylesheet">
<style type="text/css">
.form-control[readonly] {
  background-color: white;
}
</style>
<ul class="breadcrumb cm_breadcrumb">
  <li><a href="{{ URL::to($redirectUrl) }}">Home</a></li>
  <li><a href="{{ URL::to($redirectUrl.'/viewuser') }}">Manage Users</a></li>
  <li><a href="#">User Info</a></li>
</ul>
<div class="inn_content">

  <?php if (Session::has('success')) {?>
    <div role="alert" class="alert alert-success" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><?php echo ' ' . Session::get('success'); ?> </div>
  <?php }?>

  <?php if (Session::has('error')) {?>
    <div role="alert" class="alert alert-danger" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Oh!</strong><?php echo ' ' . Session::get('error'); ?> </div>
  <?php }
  $kyc = $userinfo->verification;
  $verified_status = $userinfo->verified_status;
  $id = encrypText($userinfo->id);
  ?>

  {!! Form::open(array('class'=>'cm_frm1 verti_frm1', 'id'=>'userinfo_form', 'onsubmit' => 'profile_load()')) !!}
  <div class="cm_head1">
    <h3>User Info | <a class="" href="{{ URL::to($redirectUrl.'/viewHistory/'.$id) }}">Login history</a></h3>
  </div>
  <div class="form-group row clearfix">
    <div class="col-sm-6 col-xs-12 cls_resp50">
      <label class="form-control-label">Name and Surname</label>
      <label class="form-control"><?php echo strip_tags($userinfo->consumer_name); ?></label>
    </div>
  </div>
  <div class="form-group row clearfix">
    <div class="col-sm-6 col-xs-12 cls_resp50">
      <label class="form-control-label">Date of Birth</label>
      <label class="form-control"><?php echo $userinfo->dob; ?>
    </div>
    <div class="col-sm-6 col-xs-12 cls_resp50 xrs_mat10">
      <label class="form-control-label">Email</label>
      <label class="form-control"><?php echo decrypText(strip_tags($userinfo->user_mail_id)) . "@" . decrypText(strip_tags($userinfo->unusual_user_key)); ?></label>
    </div>
  </div>
  <div class="form-group row clearfix">
    <div class="col-sm-6 col-xs-12 cls_resp50">
      <label class="form-control-label">Mobile number</label><BR>
      <label class="form-control"><?php echo $userinfo->phone; ?>
    </div>
    <div class="col-sm-6 col-xs-12 cls_resp50 xrs_mat10">
      <label class="form-control-label">IP Address</label>
      <label class="form-control"><?php echo strip_tags($userinfo->ip_address); ?></label>
    </div>
  </div>
  <div class="form-group row clearfix">
    <div class="col-sm-6 col-xs-12 cls_resp50">
      <label class="form-control-label">Registered At</label>
      <label class="form-control"><?php echo strip_tags($userinfo->created_at); ?></label>
    </div>
    <div class="col-sm-6 col-xs-12 cls_resp50 xrs_mat10">
      <label class="form-control-label">Status</label>
      <label class="form-control"><?php echo ucfirst(strip_tags($userinfo->status)); ?></label>
    </div>
  </div>
  <div class="form-group row clearfix">
    <div class="col-sm-6 col-xs-12 cls_resp50">
      <label class="form-control-label">TFA Status</label>
      <label class="form-control"><?php echo strip_tags($userinfo->tfa_status); ?></label>
    </div>
  </div>
  <div class="form-group  row clearfix">
    <div class="col-sm-6 col-xs-12 cls_resp50 xrs_mat10">
      <label class="form-control-label">Address </label>
      <label class="form-control"><?php echo $userinfo->address; ?>
    </div>
    <div class="col-sm-6 col-xs-12 cls_resp50 xrs_mat10">
      <label class="form-control-label">City</label>
      <label class="form-control"><?php echo $userinfo->city; ?>
    </div>
  </div>
  <div class="form-group row clearfix">
   <div class="col-sm-6 col-xs-12 cls_resp50">
    <label class="form-control-label">State</label>
    <label class="form-control"><?php echo $userinfo->state; ?>
  </div>
  <div class="col-sm-6 col-xs-12 cls_resp50">
    <label class="form-control-label">Country</label>
    <label class="form-control"><?php echo $userinfo->country; ?>
  </div>
</div>
<div class="form-group row clearfix">
 <div class="col-sm-6 col-xs-12 cls_resp50">
  <label class="form-control-label">Postal</label>
  <label class="form-control"><?php echo $userinfo->postal; ?>
</div>
</div>
{!! Form::close() !!}
<div class="form-group row clearfix">
  <div class="col-sm-12">
    <?php if (count($addresslist)) {
     ?>
     <div class="cm_head1">
      <h4 style="font-weight: bold;">Coin Address Info</h4>
      </div> <?php
      foreach ($addresslist as $key => $value) {
       ?>
       <div class="form-group  row clearfix">
        <div class="col-sm-6 col-xs-12 cls_resp50 xrs_mat10">
          <label class="form-control-label">Currency </label>
          <label class="form-control"><?php echo strip_tags($value->currency); ?></label>
        </div>
        <div class="col-sm-6 col-xs-12 cls_resp50 xrs_mat10">
          <label class="form-control-label"><?php echo ($value->address != '') ? 'Address' : 'Tag';?></label>
          <label class="form-control"><?php echo ($value->address != '') ? strip_tags($value->address) : strip_tags($value->secret); ?>                  
        </label>
      </div>
    </div>
  <?php }}
  ?>
</div>
</div>
<script src="{{asset('/').('public/frontend/js/notifIt.min.js')}}"></script>
<script>
  var date = new Date();
  var currentMonth = date.getMonth();
  var currentDate = date.getDate();
  var currentYear = date.getFullYear();

  $(function() {
    $("#datepickers").datepicker({
      dateFormat: "dd-mm-yy",
      changeMonth: true,
      maxDate: new Date(currentYear -18, currentMonth, currentDate),
      yearRange: "-80:-18",
      defaultDate : "-18Y",
      changeYear: true,
    });
  });

  function profile_load(){
    if($('#userinfo_form').valid() == true) {
      $('#profile_submit').hide();
      $('#profile_loader').show();
    }  else  {
      $('#profile_submit').show();
      $('#profile_loader').hide();
    }
  }

</script>
@stop