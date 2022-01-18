@extends('admin.layouts/admin')
@section('content')
<ul class="breadcrumb cm_breadcrumb">
  <li><a href="{{ URL::to($redirectUrl) }}">Home</a></li>
  <li><a href="#">General Settings</a></li>
</ul>
<div class="inn_content">
  <div class="cm_frm1 verti_frm1">
    <div class="cm_head1">
      <h3>General Settings</h3>
    </div>
    <?php if (Session::has('success')) {?>
      <div role="alert" class="alert alert-success" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><?php echo Session::get('success'); ?> </div>
    <?php }?>
    <?php if (Session::has('error')) {?>
      <div role="alert" class="alert alert-danger" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Oh!</strong><?php echo Session::get('error'); ?> </div>
    <?php }?>
    {!! Form::open(array('url' => $redirectUrl.'/updateSite', 'id'=>'basic_form', 'enctype' => "multipart/form-data")) !!}
    <div class="row">
      <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group clearfix">
          <label class="form-control-label">Site Name</label>
          <input class="form-control" placeholder="Site Name" type="text" name="site_name" value="{{$adminsettings->site_name}}">
        </div>
        <div class="form-group clearfix">
          <label class="form-control-label">Contact Mail Id</label>
          <input class="form-control" type="text" name="contact_email" value="{{$adminsettings->contact_email}}" readonly>
        </div>
        <div class="form-group clearfix">
          <label class="form-control-label">Copy Rights</label>
          <input class="form-control"  type="text" name="copy_right_text" value="{{$adminsettings->copy_right_text}}">
        </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group clearfix">
          <ul class="list-inline stng_lis1">
            <li class="sfd1">
              <label class="form-control-label">Site Logo</label>
              <div class="input-group file-upload">
                <input id="uploadFile1" class="form-control" placeholder="Upload site logo" disabled="disabled">
                <div class="input-group-addon">
                  <div class="fileUpload btn btn-primary"> <span> Upload </span><input id="site_logo" class="upload" name="site_logo" type="file"></div>
                </div>
              </div>
            </li>
            <input type="hidden" name="site_logo_old" value="{{$adminsettings->site_logo}}">
            <li class="sfd2"> <img class="img-responsive" alt="image" src="{{asset('/').('public/IuMzmYaMZE/').$adminsettings->site_logo}}" id="site_log_image"> </li>
          </ul>
        </div>
        <div class="form-group clearfix">
          <ul class="list-inline stng_lis1">
            <li class="sfd1">
              <label class="form-control-label">Site Fav icon</label>
              <div class="input-group file-upload">
                <input id="uploadFile1" class="form-control" placeholder="Upload Fav Icon" disabled="disabled">
                <div class="input-group-addon">
                  <div class="fileUpload btn btn-primary"> <span> Upload </span><input id="site_favicon" class="upload" name="site_favicon" type="file"></div>
                </div>
              </div>
            </li>
            <input type="hidden" name="site_favicon_old" value="{{$adminsettings->site_favicon}}">
            <li class="sfd2"> <img class="img-responsive" alt="image" src="{{asset('/').('public/IuMzmYaMZE/').$adminsettings->site_favicon}}" id="site_favicon_image"> </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="cm_head1">
          <h4>Address (Where to Find Us)</h4>
        </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group clearfix">
          <label class="form-control-label">Telephone No</label>
          <input class="form-control"  type="text" name="contact_no"  value="{{$adminsettings->contact_number}}">
        </div>
        <div class="form-group clearfix">
          <label class="form-control-label">Contact Address</label>
          <input class="form-control"  type="text" name="contact_address" value="{{$adminsettings->contact_address}}">
        </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group clearfix">
          <label class="form-control-label">City</label>
          <input class="form-control"  type="text" name="city" value="{{$adminsettings->city}}">
        </div>
        <div class="form-group clearfix">
          <label class="form-control-label">State</label>
          <input class="form-control"  type="text" name="state" value="{{$adminsettings->state}}">
        </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group clearfix">
          <label class="form-control-label">Country</label>
          <input class="form-control"  type="text" name="country" value="{{$adminsettings->country}}">
        </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group clearfix">
          <label class="form-control-label">Postal</label>
          <input class="form-control"  type="text" name="postal" value="{{$adminsettings->postal}}">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="cm_head1">
          <h4>Social Media Links</h4>
        </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group clearfix">
          <label class="form-control-label">Telegram Url</label>
          <input class="form-control"  type="text" name="tele_url" value="{{$adminsettings->tele_url}}">
        </div>
        <div class="form-group clearfix">
          <label class="form-control-label">Twitter Url</label>
          <input class="form-control"  type="text" name="twitter_url" value="{{$adminsettings->twitter_url}}">
        </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group clearfix">
          <label class="form-control-label">Medium Url</label>
          <input class="form-control"  type="text" name="medium_url" value="{{$adminsettings->medium_url}}">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="cm_head1">
          <h4>Maintenance</h4>
        </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group clearfix">
          <label class="form-control-label">Site Maintenance</label>
          <div class="select_style1">
            <select name="site_status">
              <option value="1" <?php echo $adminsettings->site_status == 1 ? 'selected' : '' ?>>Live</option>
              <option value="0" <?php echo $adminsettings->site_status == 0 ? 'selected' : '' ?>>Maintenance</option>
            </select>
          </div>
        </div>
        <div class="form-group clearfix">
          <label class="form-control-label">Maintenance content</label>
          <textarea class="form-control" name="maintenance_text">{{$adminsettings->maintenance_text}}</textarea>
        </div>
      </div>
    </div>
  </div>

  <div class="form-group stng_btn1 clearfix">
    <button type="submit" class="cm_blacbtn1">Submit</button>
  </div>
  {!! Form::close() !!}
</div>
</div>
<script>
//goto
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#site_log_image').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$("#site_logo").change(function(){
  readURL(this);
});

function readURL1(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#site_favicon_image').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$("#site_favicon").change(function(){
  readURL1(this);
});
</script>
<script>
  jQuery.validator.addMethod("fiatCurrency", function(value, element) {
    return this.optional(element) || /^\d{0,50}(\.\d{0,2})?$/i.test(value);
  }, "Please enter valid currency limit");
  $('#basic_form').validate({
    rules:{
      site_name:{
        required:true,
      },
      contact_no:{
        required:true,
      },
      contact_address:{
        required:true,
      },
      city:{
        required:true,
      },
      country:{
        required:true,
      },
      postal:{
        required:true,
        number:true
      },
      copy_right_text:{
        required:true,
      },
      twitter_url:{
        required:true,url:true,
      },
      medium_url:{
        required:true,url:true,
      },
      tele_url:{
        required:true,url:true,
      },
      coin_fee:{
        required: true,
      },
      auto_with: {
        required : true,
      },
    }
  })
</script>
@stop