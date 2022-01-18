@extends('admin.layouts/admin')
@section('content')
<ul class="breadcrumb cm_breadcrumb">
  <li><a href="{{ URL::to($redirectUrl) }}">Home</a></li>
  <li><a href="{{ URL::to($redirectUrl.'/viewteam') }}">Manage Team</a></li>
  <li><a href="#">Team Info</a></li>
</ul>
<div class="inn_content">
  {!! Form::open(array('url' => $redirectUrl.'/updateteam', 'class'=>'cm_frm1 verti_frm1', 'id'=>'team_form', 'enctype' => "multipart/form-data")) !!}
  <div class="cm_head1">
    <h3>Team Info</h3>
  </div>
  <input type="hidden" name="id" value="<?php if ($team['type'] == 'edit') {echo encrypText($team->id);} else {echo "";}?>" >
  <div class="form-group row clearfix">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">Name :</label>
      <input type="text" class="form-control" name="name" id="name" value="<?php if ($team['type'] == 'edit') {echo strip_tags($team->name);} else {echo "";}?>">
    </div>
  </div>
  <div class="form-group row clearfix">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">Role :</label>
      <input type="text" class="form-control" name="role" id="role" value="<?php if ($team['type'] == 'edit') {echo strip_tags($team->role);} else {echo "";}?>">
    </div>
  </div>
  <div class="form-group row clearfix">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">Description : </label>
      <textarea class="form-control mg-responsive" id="description" name="description" style="height: 150px;"><?php if ($team['type'] == 'edit') {echo strip_tags($team->description);} else {echo "";}?></textarea>
    </div>
  </div>
  <div class="form-group clearfix">
    <ul class="list-inline stng_lis1">
      <li class="sfd1">
        <label class="form-control-label">Profile</label>
        <div class="input-group file-upload">
          <input id="uploadFile1" class="form-control" placeholder="Upload site logo" disabled="disabled">
          <div class="input-group-addon">
            <div class="fileUpload btn btn-primary"> <span> Upload </span><input id="profile" class="upload" name="profile" type="file"></div>
          </div>
        </div>
      </li>
      <input type="hidden" name="profile_old" value="<?php if ($team['type'] == 'edit') {echo strip_tags($team->profile);} else {echo "";}?>">
      <li class="sfd2"> <img class="img-responsive" alt="image" src="<?php if ($team['type'] == 'edit') {echo strip_tags($team->profile);} else {echo "";}?>" id="profile_image"> </li>
    </ul>
  </div>
  <div class="form-group row clearfix">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">Twitter Link :</label>
      <input type="text" class="form-control" name="social_url1" id="social_url1" value="<?php if ($team['type'] == 'edit') {echo strip_tags($team->social_url1);} else {echo "";}?>">
    </div>
  </div>
  <div class="form-group row clearfix">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">LinkedIn Link :</label>
      <input type="text" class="form-control" name="social_url2" id="social_url2" value="<?php if ($team['type'] == 'edit') {echo strip_tags($team->social_url2);} else {echo "";}?>">
    </div>
  </div>

  <ul class="list-inline">
    <li>
      <button type="submit" class="cm_blacbtn1">Submit</button>
    </li>
    <li>
    </li>
  </ul>
  {!! Form::close() !!}
</div>

<script>
  $('#team_form').validate({
    ignore:"",
    rules:{
      name:{
        required:true,
      },
      role:{
        required:true,
      },
      description:{
        required: true
      },
    }
  })

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#profile_image').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#profile").change(function(){
    readURL(this);
  });
</script>

@stop