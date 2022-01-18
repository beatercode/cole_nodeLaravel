@extends('admin.layouts/admin')
@section('content')
<ul class="breadcrumb cm_breadcrumb">
  <li><a href="{{ URL::to($redirectUrl) }}">Home</a></li>
  <li><a href="{{ URL::to($redirectUrl.'/viewfaq') }}">Manage Roadmap</a></li>
  <li><a href="#">Roadmap Info</a></li>
</ul>
<div class="inn_content">
  {!! Form::open(array('url' => $redirectUrl.'/updateRoadmap', 'class'=>'cm_frm1 verti_frm1', 'id'=>'roadmap_form')) !!}
  <div class="cm_head1">
    <h3>Roadmap Info</h3>
  </div>
  <input type="hidden" name="id" value="<?php if ($roadmap['type'] == 'edit') {echo encrypText($roadmap->id);} else {echo "";}?>" >
  <!-- English Content -->
  <div class="form-group row clearfix">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">Title :</label>
      <input type="text" class="form-control" name="title" id="title" value="<?php if ($roadmap['type'] == 'edit') {echo strip_tags($roadmap->title);} else {echo "";}?>">
    </div>
  </div>
  <div class="form-group row clearfix">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">Description : </label>
      <textarea class="form-control mg-responsive" id="description" name="description" style="height: 150px;"><?php if ($roadmap['type'] == 'edit') {echo strip_tags($roadmap->description);} else {echo "";}?></textarea>
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
  $('#roadmap_form').validate({
    ignore:"",
    rules:{
      title:{
        required:true,
      },
      description:{
        required: true
      },
    },
    messages:{
      title:{
        required:"Enter title",
      },
      description:{
        required:"Enter description",
      }
    }
  })
</script>

@stop