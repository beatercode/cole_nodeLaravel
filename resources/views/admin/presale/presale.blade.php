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
  <li><a href="#">Presale Info</a></li>
</ul>
<div class="inn_content">
  {!! Form::open(array('class'=>'cm_frm1 verti_frm1', 'id'=>'presale_form')) !!}
  <div class="cm_head1">
    <h3>Presale Info</h3>
  </div>
  <div class="form-group row clearfix">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">Start time(MM/DD/YYYY HH:mm:ss) :</label>
      <div class='input-group date datetimepicker1' id="datetimepicker1">
        <input type='text' class="form-control" name="start_time" id="start_time" value="<?php echo $presale['startdatetime'];?>"/>
        <span class="input-group-addon">
          <span class="glyphicon glyphicon-calendar"></span>
        </span>
      </div>
    </div>
  </div>
  <div class="form-group row clearfix">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">End time(MM/DD/YYYY HH:mm:ss) :</label>
      <div class='input-group date datetimepicker1' id="datetimepicker3">
        <input type='text' class="form-control" name="end_time" id="end_time" value="<?php echo $presale['enddatetime'];?>"/>
        <span class="input-group-addon">
          <span class="glyphicon glyphicon-calendar"></span>
        </span>
      </div>
    </div>
  </div>
  <ul class="list-inline">
    <li>
      <button type="button" class="cm_blacbtn1" onclick="compare_date();">Change Time</button>
    </li>
  </ul>
  {!! Form::close() !!}

  {!! Form::open(array('class'=>'cm_frm1 verti_frm1', 'id'=>'presale_form1')) !!}
  <div class="form-group row clearfix">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">USD Price/Token :</label>
      <input type="text" class="form-control" name="price" id="price" value="<?php echo strip_tags($presale['usd_price']);?>">
    </div>
  </div>
  <ul class="list-inline">
    <li>
      <button type="button" class="cm_blacbtn1" onclick="setPreSalePrice();">Change Token Price</button>
    </li>
  </ul>
  {!! Form::close() !!}

  {!! Form::open(array('class'=>'cm_frm1 verti_frm1', 'id'=>'presale_form1')) !!}
  <div class="form-group row clearfix">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">Minimum :</label>
      <input type="text" class="form-control" name="min" id="min" value="<?php echo strip_tags($presale['min']);?>">
    </div>
  </div>
  <div class="form-group row clearfix">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">Maximum :</label>
      <input type="text" class="form-control" name="max" id="max" value="<?php echo strip_tags($presale['max']);?>">
    </div>
  </div>
  <ul class="list-inline">
    <li>
      <button type="button" class="cm_blacbtn1" onclick="setMinAndMaxAmount();">Change Min/Max</button>
    </li>
  </ul>
  {!! Form::close() !!}
</div>
<link rel="stylesheet" href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
<script>
 var adminurl = "{{URL::to('/')}}";
 var redirectUrl = '<?php echo $redirectUrl;?>';
 var timeUrl = adminurl + '/' + redirectUrl + '/setpresaleTime';
 var priceUrl = adminurl + '/' + redirectUrl + '/setpresalePrice';
 var minmaxUrl = adminurl + '/' + redirectUrl + '/setMinmax';
 var equiv_usdprice  = "{{$presale['equiv_usdPrice']}}";
 var network        = localStorage.getItem('network');

 $('#presale_form').validate({
  ignore:"",
  rules:{
    start_time:{
      required:true,
    },
    end_time:{
      required: true
    },
  },
})

 $('#presale_form1').validate({
  ignore:"",
  rules:{
    price:{
      required:true,
      number:true,
    },
  },
})

 $(function () {
  $('.datetimepicker1').datetimepicker({
    format: 'MM/DD/YYYY HH:mm:ss',
  });
});

 function compare_date(){
  var startDate = $('#start_time').val();
  var endDate = $('#end_time').val();
  var start = toTimestamp(startDate);
  var end = toTimestamp(endDate);
  if(start >= end) {
    alert('End date should be greater than start date');
  } else {
    setPreSaleTime(start, end);
  }
}

function toTimestamp(strDate){
 var datum = Date.parse(strDate);
 return datum/1000;
}
</script>
<script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script>
<script src="{{asset('/').('public/AVKpqBqmVJ/scripts/contract.js')}}?{{date('Y-m-d h:i:s')}}"></script>
@stop