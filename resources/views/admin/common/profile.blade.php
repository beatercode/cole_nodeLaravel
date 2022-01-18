@extends('admin.layouts/admin')
@section('content')

<ul class="breadcrumb cm_breadcrumb">
  <li><a href="{{ URL::to($redirectUrl) }}">Home</a></li>
  <li><a href="#">Profile</a></li>
</ul>
<div class="inn_content">
  <div class="cm_frm1 verti_frm1">
    <div class="cm_head1">
      <h3>Profile</h3>
    </div>

    <?php if (Session::has('success')) {?>
      <div role="alert" class="alert alert-success" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><?php echo Session::get('success'); ?> </div>
    <?php }?>

    <?php if (Session::has('error')) {?>
      <div role="alert" class="alert alert-danger" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Oh!</strong><?php echo Session::get('error'); ?> </div>
    <?php }?>

    {!! Form::open(array('url' => $redirectUrl.'/updateProfile', 'id'=>'profile_form', 'enctype' => "multipart/form-data")) !!}
    <div class="form-group row clearfix">
      <div class="col-sm-6 col-xs-12 cls_resp50">
        <label class="form-control-label">Username</label>
        <input type="text" class="form-control" placeholder="Username" name="admin_username" value="<?php echo strip_tags($profile->admin_username); ?>" readonly>
      </div>
      <div class="col-sm-6 col-xs-12 cls_resp50 xrs_mat10">
        <label class="form-control-label">Email</label>
        <input type="text" class="form-control" placeholder="Email" value="<?php echo decrypText(strip_tags($profile->admin_desc)) . "@" . decrypText(strip_tags($profile->admin_sub_key)); ?>" readonly>
      </div>
    </div>
    <div class="form-group row clearfix">
      <div class="col-sm-6 col-xs-12 cls_resp50">
        <label class="form-control-label">Phone No</label>
        <input type="text" class="form-control" placeholder="Phone " name="admin_phno" value="<?php echo strip_tags($profile->admin_phone); ?>">
      </div>

      <div class="col-sm-6 col-xs-12 cls_resp50 xrs_mat10">
        <label class="form-control-label">Address</label>
        <input type="text" class="form-control" placeholder="Address" name="admin_address" value="<?php echo strip_tags($profile->admin_address); ?>">
      </div>
    </div>
    <div class="form-group row clearfix">
      <div class="col-sm-6 col-xs-12 cls_resp50">
        <label class="form-control-label">City</label>
        <input type="text" class="form-control" placeholder="City" name="admin_city" value="<?php echo strip_tags($profile->admin_city); ?>">
      </div>
      <div class="col-sm-6 col-xs-12 cls_resp50 xrs_mat10">
       <label class="form-control-label">State / Province</label>
       <input type="text" class="form-control" placeholder="State" name="admin_state" value="<?php echo strip_tags($profile->admin_state); ?>">
     </div>
   </div>
   <div class="form-group row clearfix">
    <div class="col-sm-6 col-xs-12 cls_resp50">
      <label class="form-control-label">Country</label>
      <input type="text" class="form-control" placeholder="Country" name="country" value="<?php echo strip_tags($profile->country); ?>">
    </div>
    <div class="col-sm-6 col-xs-12 cls_resp50 xrs_mat10">
      <label class="form-control-label">Postal Code</label>
      <input type="text" class="form-control" placeholder="Postal Code" name="admin_postal" value="<?php echo strip_tags($profile->admin_postal); ?>">
    </div>
  </div>
  <div class="form-group clearfix">
    <ul class="list-inline stng_lis1">
      <li class="sfd1">
        <label class="form-control-label">Profile Picture</label>
        <div class="input-group file-upload">
          <input id="uploadFile1" class="form-control" placeholder="Upload profile picture" disabled="disabled">
          <div class="input-group-addon">
            <div class="fileUpload btn btn-primary"> <span> Upload </span>
              <input id="admin_profile" class="upload" name="admin_profile" type="file">
            </div>
          </div>
        </div>
      </li>
      <input type="hidden" name="admin_profile_old" value="<?php echo strip_tags($profile->admin_profile); ?>">
      <li class="sfd2"> <img class="img-responsive" alt="" src="{{asset('/').('public/IuMzmYaMZE/').$profile->admin_profile}}" id="admin_profile_image"> </li>
    </ul>
  </div>

  <div class="form-group row clearfix">
    <div class="col-sm-6 col-xs-12 cls_resp50">
      <button type="submit" class="cm_blacbtn1">Submit</button>
    </div>

  </div>
  {!! Form::close() !!}


  <div class="cm_head1">
    <h3>Two Factor Authentication</h3>
  </div>

  {!! Form::open(array('url' => $redirectUrl.'/enableDisableTFa', 'id'=>'tfa_form')) !!}
  <div class="form-group row clearfix">
    <div class="col-sm-6 col-xs-12 cls_resp50">
     @if($profile->tfa_status == "disable")
     <div class="tfa_qr"><img src="{{$profile->tfa_url}}" alt="QR Code"></div>
     <input type="text" class="form-control" value="{{$profile->secret}}" readonly>
     @endif
   </div>
   <input type="hidden" name="tfa_url"  value="{{$profile->tfa_url}}">
   <input type="hidden" name="secret_code" value="{{$profile->secret}}">
   <input type="hidden" name="tfa_status" value="{{$profile->tfa_status}}">
 </div>
 <div class="form-group row clearfix">
  <div class="col-sm-6 col-xs-12 cls_resp50">
    <input type="text" class="form-control" name="auth_key" id="auth_key" autocomplete="off" onkeypress="return isNumberKey(event)">
    <label id="auth_key-error" class="error" for="auth_key"></label><br>
    <button type="submit" class="cm_blacbtn1"><?php if ($profile->tfa_status == "enable") {echo 'Disable Security'; } else {echo 'Enable Security';}?></button>
  </div>
</div>
{!! Form::close() !!}

<div class="cm_head1">
  <h3>Change Password</h3>
</div>

{!! Form::open(array('url' => $redirectUrl.'/changePassword', 'id'=>'pwd_form')) !!}

<div class="form-group row clearfix">
  <div class="col-sm-6 col-xs-12 cls_resp50">
    <label class="form-control-label">Current Password</label>
    <input type="password" class="form-control" placeholder="***************" name="current_pwd" id="current_pwd">
  </div>
  <div class="col-sm-6 col-xs-12 cls_resp50 xrs_mat10">
    <label class="form-control-label">New Password</label>
    <input type="password" class="form-control" placeholder="***************" name="new_pwd" id="new_pwd">
  </div>
</div>
<div class="form-group row clearfix">
  <div class="col-sm-6 col-xs-12 cls_resp50">
    <label class="form-control-label">Confirm New Password</label>
    <input type="password" class="form-control" placeholder="***************" name="confirm_pwd" id="confirm_pwd">
    <button type="submit" class="cm_blacbtn1">Submit</button>
  </div>
</div>
{!! Form::close() !!}

</div>
</div>
<?php $url = 'checkPassword';?>
<script>
 var redirectUrl = "<?php echo $redirectUrl;?>";
 jQuery.validator.addMethod("notEqualTo",
  function(value, element, param) {
    var notEqual = true;
    value = $.trim(value);
    for (i = 0; i < param.length; i++) {
      if (value == $.trim($(param[i]).val())) { notEqual = false; }
    }
    return this.optional(element) || notEqual;
  },
  "Please enter a diferent value."
  );

 function readURL(input)
 {
  if (input.files && input.files[0])
  {
    var reader = new FileReader();

    reader.onload = function (e)
    {
      $('#admin_profile_image').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

$("#admin_profile").change(function(){
  readURL(this);
});


$('#pwd_form').validate({
  rules:{
    current_pwd:{
      required:true,
      remote: {
        url: "{{URL::to('/')}}" +"/"+ redirectUrl +"/checkPassword",
        type: 'GET',
        data: {
          current_pwd: function() {
            return $('#pwd_form #current_pwd').val();
          }
        }
      }
    },
    new_pwd:{
      required:true,
      minlength:8,

      notEqualTo: ['#current_pwd'],
    },
    confirm_pwd:{
      required:true,
      minlength:8,
      equalTo : '[name="new_pwd"]',
    },


  },
  messages:{
    current_pwd:{
      remote:"Wrong Password",
    }
  }
});


$('#profile_form').validate({
  rules:{
    admin_username:{
      required:true,
    },
    admin_phno:{
      required:true,
    },
    admin_address:{
      required:true,
    },
    admin_city:{
      required:true,
    },
    admin_state:{
      required:true,
    },
    country:{
      required:true,
    },
    admin_postal:{
      required:true,
    },

  },
});


jQuery.validator.addMethod("begiendspace", function(value, element) { return (value.trim() != "" && value.charAt(0) != " " && value.charAt(value.length - 1) != " "); 
},"Enter valid input! Avoid space(s) in the beginning and end!!");


$('#tfa_form').validate({ 
  ignore:"",
  rules:{
    auth_key:{
      required:true,
      number:true,
      minlength:6,
      maxlength:6,
      begiendspace:true,
    },      
  }
});
</script>
@stop