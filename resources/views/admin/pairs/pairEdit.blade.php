@extends('admin.layouts/admin')
@section('content')
<ul class="breadcrumb cm_breadcrumb">
  <li><a href="{{ URL::to($redirectUrl) }}">Home</a></li>
  <li><a href="{{ URL::to($redirectUrl.'/viewPairs') }}">Manage Pair</a></li>
  <li><a href="#">Pair Info</a></li>
</ul>
<div class="inn_content">
  {!! Form::open(array('url' => $redirectUrl.'/updatePair', 'class'=>'cm_frm1 verti_frm1', 'id'=>'pair_form', 'enctype' => "multipart/form-data")) !!}
  <div class="cm_head1">
    <h3>Pair Info</h3>
  </div>
  <input type="hidden" name="id" id="stakeId" value="<?php if ($pair['type'] == 'edit') {echo encrypText($pair->id);} else {echo "";}?>" >
  <input type="hidden" name="from_symbol" id="from_symbol" value="<?php if ($pair['type'] == 'edit') {echo $pair->from_symbol;} else {echo "";}?>" >
  <input type="hidden" name="to_symbol" id="to_symbol" value="<?php if ($pair['type'] == 'edit') {echo $pair->to_symbol;} else {echo "";}?>" >
  <div class="form-group row clearfix">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">Pair :</label>
      <input type="text" class="form-control" name="pair" id="pair" value="<?php if ($pair['type'] == 'edit') {echo strip_tags($pair->pair); } else {echo "";}?>" <?php if ($pair['type'] == 'edit') { echo 'readonly'; } ?>>
    </div>
  </div>
  <div class="form-group row clearfix">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">From Address :</label>
      <input type="text" class="form-control" name="from_address" id="from_address" value="<?php if ($pair['type'] == 'edit') {echo strip_tags($pair->from_address);} else {echo "";}?>" <?php if ($pair['type'] == 'edit') { echo 'readonly'; } ?>>
    </div>
  </div>
  <div class="form-group row clearfix">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">To Address :</label>
      <input type="text" class="form-control" name="to_address" id="to_address" value="<?php if ($pair['type'] == 'edit') {echo strip_tags($pair->to_address);} else {echo "";}?>" <?php if ($pair['type'] == 'edit') { echo 'readonly'; } ?>>
    </div>
  </div>
  <div class="form-group row clearfix">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">Pair address :</label>
      <input type="text" class="form-control" name="pair_address" id="pair_address" value="<?php if ($pair['type'] == 'edit') {echo strip_tags($pair->pair_address);} else {echo "";}?>" <?php if ($pair['type'] == 'edit') { echo 'readonly'; } ?>>
    </div>
  </div>
  <div class="form-group clearfix">
    <div class="col-sm-9 col-xs-12">
      <ul class="list-inline stng_lis1">
        <li class="sfd1">
          <label class="form-control-label">From symbol Logo</label>
          <div class="input-group file-upload">
            <input id="uploadFile1" class="form-control" placeholder="Upload From symbol logo" disabled="disabled">
            <div class="input-group-addon">
              <div class="fileUpload btn btn-primary"> <span> Upload </span><input id="from_image" class="upload" name="from_image" type="file"></div>
            </div>
          </div>
        </li>
        <input type="hidden" name="from_image_old" value="{{$pair->from_image}}">
        <li class="sfd2"> <img class="img-responsive" alt="image" src="{{asset('/').('public/IuMzmYaMZE/').$pair->from_image}}" id="from_symbol_image"> </li>
      </ul>
    </div>
  </div>
  <div class="form-group clearfix">
    <div class="col-sm-9 col-xs-12">
      <ul class="list-inline stng_lis1">
        <li class="sfd1">
          <label class="form-control-label">To symbol Logo</label>
          <div class="input-group file-upload">
            <input id="uploadFile1" class="form-control" placeholder="Upload To symbol logo" disabled="disabled">
            <div class="input-group-addon">
              <div class="fileUpload btn btn-primary"> <span> Upload </span><input id="to_image" class="upload" name="to_image" type="file"></div>
            </div>
          </div>
        </li>
        <input type="hidden" name="to_image_old" value="{{$pair->to_image}}">
        <li class="sfd2"> <img class="img-responsive" alt="image" src="{{asset('/').('public/IuMzmYaMZE/').$pair->to_image}}" id="to_symbol_image"> </li>
      </ul>
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
  $('#pair_form').validate({
    ignore:"",
    rules:{
      pair:{
        required:true,
      },
    }
  });


  //goto
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#from_symbol_image').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#from_image").change(function(){
    readURL(this);
  });

  function readURL1(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#to_symbol_image').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#to_image").change(function(){
    readURL1(this);
  });

</script>
@stop