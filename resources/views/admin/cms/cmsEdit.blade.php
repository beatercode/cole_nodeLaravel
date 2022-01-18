@extends('admin.layouts/admin')
@section('content')
<ul class="breadcrumb cm_breadcrumb">
  <li><a href="{{ URL::to($redirectUrl) }}">Home</a></li>
  <li><a href="{{ URL::to($redirectUrl.'/viewcms/'.$cms->type) }}">Manage CMS</a></li>
  <li><a href="#">CMS Info</a></li>
</ul>
<div class="inn_content">
  <?php if (Session::has('success')) {?>
    <div role="alert" class="alert alert-success" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><?php echo Session::get('success'); ?> </div>
  <?php }?>
  <?php if (Session::has('error')) {?>
    <div role="alert" class="alert alert-danger" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Oh!</strong><?php echo Session::get('error'); ?> </div>
  <?php }?>
  {!! Form::open(array('url' => $redirectUrl.'/updateCms', 'class'=>'cm_frm1 verti_frm1', 'id'=>'cms_form',  'enctype' => "multipart/form-data")) !!}
  <div class="cm_head1">
    <h3>CMS Info</h3>
  </div>
  <input type="hidden" name="id" value="<?php echo encrypText(strip_tags($cms->id)); ?>" >
  <?php
  $cms_content = $cms->content;
  $cms_title = strip_tags($cms->title);
  $cms_sub_title = $cms->sub_type;
  ?>
  <!-- English Content -->
  <div class="form-group row clearfix">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">CMS Heading :</label>
      <input type="text" class="form-control" name="title" id="title" value="{{$cms_title}}">
    </div>
  </div>
  <div class="form-group clearfix">
    <div class="col-sm-9 col-xs-12">
      <label class="form-control-label">CMS Content :</label>
      <textarea class="img-responsive" id="content" name="content"><?php echo $cms_content; ?></textarea>
    </div>
  </div>
  @if($cms->id == '35' || $cms->id == '36' || $cms->id == '37' || $cms->id == '38' || $cms->id == '39')
  
  <div class="form-group clearfix">
    <div class="col-sm-9 col-xs-12">
      <ul class="list-inline stng_lis1">
        <label class="form-control-label">CMS Image</label>
        <div class="input-group file-upload">
          <input id="uploadFile1" class="form-control" placeholder="Upload Fav Icon" disabled="disabled">
          <div class="input-group-addon">
            <div class="fileUpload btn btn-primary"> <span> Upload </span><input id="cms_image" class="upload" name="cms_image" type="file"></div>
          </div>
        </div>
        <input type="hidden" name="cms_old" value="{{$cms->image}}">
        <br>
        <img class="img-responsive" alt="image" src="{{$cms->image}}" id="cms_images">
      </ul>
    </div>
  </div>
  @endif
  <ul class="list-inline">
    <li>
      <button type="submit" class="cm_blacbtn1">Submit</button>
    </li>
    <li>
    </li>
  </ul>
  {!! Form::close() !!}
</div>
<script src="{{ asset('/').('public/AVKpqBqmVJ/ckeditor/ckeditor.js') }}"> </script>
<script>
  CKEDITOR.replace('content');

  $('#cms_form').validate({
    ignore: [],
    rules:{
      title:{
        required:true,
      },
      title_show:{
        required:true,
      },
      content:{
        required: function(textarea) {
          CKEDITOR.instances[textarea.id].updateElement(); // update textarea
          var editorcontent = textarea.value.replace(/<[^>]*>/gi, ''); // strip tags
          return editorcontent.length === 0;
        }
      }
    },
    messages:{
      title:{
        required:"Enter CMS Heading Name",
      },
      content:{
        required:"Enter content",
      },
      cms_image:{

      }
    }
  });

  function readURL1(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#cms_images').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#cms_image").change(function(){
    readURL1(this);
  });
</script>
@stop