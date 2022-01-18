@extends('admin.layouts/admin')
@section('content')
<ul class="breadcrumb cm_breadcrumb">
  <li><a href="{{ URL::to($redirectUrl) }}">Home</a></li>
  <li><a href="{{ URL::to($redirectUrl.'/viewfaq') }}">Manage FAQ</a></li>
  <li><a href="#">FAQ Info</a></li>
</ul>
<div class="inn_content">
  {!! Form::open(array('url' => $redirectUrl.'/updateFaq', 'class'=>'cm_frm1 verti_frm1', 'id'=>'faq_form')) !!}
  <div class="cm_head1">
    <h3>FAQ Info</h3>
  </div>
  <input type="hidden" name="id" value="<?php if ($faq['type'] == 'edit') {echo encrypText($faq->id);} else {echo "";}?>" >
  <!-- English Content -->
  <div class="form-group row clearfix">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">Question :</label>
      <input type="text" class="form-control" name="question" id="question" value="<?php if ($faq['type'] == 'edit') {echo strip_tags($faq->question);} else {echo "";}?>">
    </div>
  </div>
  <div class="form-group row clearfix">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">Answer : </label>
      <textarea class="form-control mg-responsive" id="description" name="description" style="height: 150px;"><?php if ($faq['type'] == 'edit') {echo strip_tags($faq->description);} else {echo "";}?></textarea>
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
  $('#faq_form').validate({
    ignore:"",
    rules:{
      question:{
        required:true,
      },
      description:{
        required: true
      },
    },
    messages:{
      question:{
        required:"Enter FAQ Question",
      },
      description:{
        required:"Enter FAQ Answer",
      }
    }
  })
</script>

@stop