@extends('admin.layouts/admin')
<div class="loader" id="dexLoader" style="display:none;">
  <div class="spinner">
    <div class="double-bounce1"></div>
    <div class="double-bounce2"></div>
  </div>
</div>
@section('content')
<ul class="breadcrumb cm_breadcrumb">
  <li><a href="{{ URL::to($redirectUrl) }}">Home</a></li>
  <li><a href="{{ URL::to($redirectUrl.'/viewPairs') }}">Manage Pair</a></li>
  <li><a href="#">Pair Info</a></li>
</ul>
<div class="inn_content">
  {!! Form::open(array('class'=>'cm_frm1 verti_frm1', 'id'=>'pair_form')) !!}
  <div class="cm_head1">
    <h3>Add {{session('adminNetwork')}} Pair Info</h3>
  </div>
  <div class="form-group row clearfix">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">Pair Type :</label>
      <select class="form-control" id="pair_type">
        <option value="1">Liquidity</option>
        <option value="2">Staking</option>
      </select>
    </div>
  </div>
  <div class="form-group row clearfix">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">From Symbol :</label>
      <input type="text" class="form-control" name="fromSymbol" id="fromSymbol">
    </div>
  </div>
  <div class="form-group row clearfix">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">To Symbol :</label>
      <input type="text" class="form-control" name="toSymbol" id="toSymbol">
    </div>
  </div>
  <div class="form-group row clearfix">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">From Address :</label>
      <input type="text" class="form-control" name="from_address" id="from_address">
    </div>
  </div>
  <div class="form-group row clearfix">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">To Address :</label>
      <input type="text" class="form-control" name="to_address" id="to_address">
    </div>
  </div>
  <div class="form-group row clearfix" id="pool_div" style="display:none;">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">Pool Limit :</label>
      <input type="text" class="form-control" name="pool_limit" id="pool_limit">
      <input type="hidden" class="form-control" name="reward" id="reward" value="1">
    </div>
  </div>
  <ul class="list-inline">
    <li>
      <button type="button" class="cm_blacbtn1" onclick="addPair();">Submit</button>
    </li>
    <li>
    </li>
  </ul>
  {!! Form::close() !!}
</div>

<script>
  var adminurl = "{{URL::to('/')}}";
  var redirectUrl = '<?php echo $redirectUrl;?>';
  var stakingUrl = adminurl + '/' + redirectUrl + '/addStakingPair';
  var viewPairs  = adminurl + '/' + redirectUrl + '/viewPairs';
  var csrf_token = {'X-CSRF-TOKEN':"{{ csrf_token() }}"};

  $('#pair_form').validate({
    ignore:"",
    rules:{
      pair:{
        required:true,
      },
      from_address:{
        required: true
      },
      to_address:{
        required:true,
      },
      pair_address:{
        required: true
      },
    }
  });

  $('#pair_type').change(function() {
    var pair_type =  $('#pair_type').val();
    if(pair_type == 2) {
      $('#pool_div').css('display', 'block');
    } else {
      $('#pool_div').css('display', 'none');
    }
  });
</script>
@stop