@extends('admin.layouts/admin')
@section('content')
<?php $type = $subadmin['type'];?>
<style type="text/css">
#patternContainer {
  width: 320px!important;
}
</style>
<ul class="breadcrumb cm_breadcrumb">
  <li><a href="{{ URL::to($redirectUrl) }}">Home</a></li>
  <li><a href="{{ URL::to($redirectUrl.'/viewSubadmin') }}">Manage Subadmin</a></li>
  <li><a href="#">Add Subadmin</a></li>
</ul>
<div class="inn_content">
  <?php if (Session::has('success')) {?>
    <div role="alert" class="alert alert-success" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><?php echo Session::get('success'); ?> </div>
  <?php }?>

  <?php if (Session::has('error')) {?>
    <div role="alert" class="alert alert-danger" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Oh!</strong><?php echo Session::get('error'); ?> </div>
  <?php }?>

  {!! Form::open(array('class'=>'cm_frm1 verti_frm1', 'url' => $redirectUrl.'/updateSubadmin',  'id'=>'subad_form', 'onsubmit'=>'return check_box_validation()')) !!}
  <div class="cm_head1">
    <h3>Manage Subadmin</h3>
  </div>
  <div class="row">
    <div class="col-sm-6 col-xs-12 cls_resp50">
      <div class="form-group clearfix">
        <label class="form-control-label">Username</label>
        <input type="text" id="username" name="username" class="form-control" placeholder="Username" value="<?php if ($type == "edit") {echo strip_tags($subadmin->admin_username);}?>" <?php if ($type == "edit") {?> readonly <?php }?>>
      </div>
      <div class="form-group clearfix">
        <label class="form-control-label">Email Address</label>

        <input type="text" name="email_addr" class="form-control" placeholder="mail@mail.com" id="email_addr" value="<?php if ($type == "edit") {echo decrypText(strip_tags($subadmin->admin_desc)) . "@" . decrypText(strip_tags($subadmin->admin_sub_key));}?>"<?php if ($type == "edit") {?> readonly <?php }?>>

        <label style="color:red;" id="email_addr_error" for="email_addr"></label>
      </div>
      <div class="form-group clearfix">
        <label class="form-control-label">Password</label>
        <?php if ($type == "edit") {?>
          <input class="form-control" name="password" type="password" placeholder="********" >
        <?php } else {?>
          <input type="text" name="password" class="form-control" readonly>
        <?php }?>
      </div>
      <?php if ($type != "edit") {?>
        <button type="button" id="generate_pwd" class="cm_blacbtn1">Generate Password</button>
      <?php }?>
      <div class="form-group clearfix">
        <label class="form-control-label">Patternlock</label>
        <div id="patternContainer"></div>
        <?php if ($type == "edit") {?>
          <input type="hidden"  name="pattern_code" id="patterncode" value="<?php echo decrypText(strip_tags($subadmin->admin_pattern)); ?>">
        <?php } else {?>
          <input type="hidden"  name="pattern_code" id="patterncode">
        <?php }?>
      </div>
    </div>
    <input type="hidden" name="id" value="" id="id">
    <input type="hidden" name="type" value="<?php echo $type; ?>">
    <input type="hidden" id="securl" value="">
    <div class="col-sm-6 col-xs-12 cls_resp50">
      <div class="cm_head1">
        <h5>Access Permission</h5>
      </div>
      <div class="cm_chk">
        <div class="">
          <label><input value="1" type="checkbox" class="permission" name="permission[]"> Manage Users </label>
        </div>

        <div class="">
          <label><input value="2" type="checkbox" class="permission" name="permission[]"> Manage Pairs & Presale</label>
        </div>

        <div class="">
          <label><input value="3" type="checkbox" class="permission" name="permission[]"> Block IP</label>
        </div> 

        <div class="">
          <label><input value="4" type="checkbox" class="permission" name="permission[]"> Whitelist IP</label>
        </div> 

        <div class="">
          <label><input value="5" type="checkbox" class="permission" name="permission[]"> Manage FAQ</label>
        </div>

        <div class="">
          <label><input value="6" type="checkbox" class="permission" name="permission[]"> Manage Roadmap</label>
        </div>

        <div class="">
          <label><input value="7" type="checkbox" class="permission" name="permission[]"> CMS Management</label>
        </div>

        <label style="color:red;" id="permission_error" for="permission"></label>

      </div>
    </div>
  </div>
  <ul class="list-inline">
    <li>
      <button type="submit" class="cm_blacbtn1">Submit</button>
    </li>
    <li>
      <button type="button" onclick="window.location='{{ URL::to($redirectUrl."/viewSubadmin") }}'" class="cm_blacbtn1">Cancel</button>
    </li>
  </ul>
  {!! Form::close() !!}
</div>
<?php if ($type == "edit") {?>
  <div class="inn_content">
    <div class="cm_head1">
      <h3>Subadmin Info</h3>
    </div>
    <div class="form-group row clearfix">
      <div class="col-sm-6 col-xs-12 cls_resp50">
        <label class="form-control-label">Phone No :</label>
        <label class="form-control-label"><?php if ($subadmin->admin_phone != "") {echo strip_tags($subadmin->admin_phone);} else {echo "---";}?></label>
      </div>
      <div class="col-sm-6 col-xs-12 cls_resp50 xrs_mat10">
        <label class="form-control-label">Address :</label>
        <label class="form-control-label"><?php if ($subadmin->admin_address) {echo strip_tags($subadmin->admin_address);} else {echo "---";}?></label>
      </div>
    </div>
    <div class="form-group row clearfix">
      <div class="col-sm-6 col-xs-12 cls_resp50">
        <label class="form-control-label">City :</label>
        <label class="form-control-label"><?php if ($subadmin->admin_city) {echo strip_tags($subadmin->admin_city);} else {echo "---";}?></label>
      </div>
      <div class="col-sm-6 col-xs-12 cls_resp50 xrs_mat10">
        <label class="form-control-label">State / Province :</label>
        <label class="form-control-label"><?php if ($subadmin->admin_state) {echo strip_tags($subadmin->admin_state);} else {echo "---";}?></label>
      </div>
    </div>
    <div class="form-group row clearfix">
      <div class="col-sm-6 col-xs-12 cls_resp50">
        <label class="form-control-label">Country :</label>
        <label class="form-control-label"><?php if ($subadmin->country) {echo strip_tags($subadmin->country);} else {echo "---";}?></label>
      </div>
      <div class="col-sm-6 col-xs-12 cls_resp50 xrs_mat10">
        <label class="form-control-label">Postal Code :</label>
        <label class="form-control-label"><?php if ($subadmin->admin_postal) {echo strip_tags($subadmin->admin_postal);} else {echo "---";}?></label>
      </div>
    </div>
    <div class="form-group row clearfix">
      <div class="col-sm-6 col-xs-12 cls_resp50">
        <label class="form-control-label">Profile Picture</label>
        <img src="{{$subadmin->admin_profile}}">
      </div>
    </div>
  </div>
<?php }?>

<script src="{{asset('/').('public/AVKpqBqmVJ/js/patternLock.js')}}"> </script>
<link rel="stylesheet" href="{{asset('/').('public/AVKpqBqmVJ/css/patternLock.css')}}"  type="text/css">

<?php if ($type == "edit") {?>
  <script>
    $('document').ready(function(){
      $('[name=username]').val('<?php echo strip_tags($subadmin->admin_username); ?>');
      $('[name=email_addr]').val('<?php echo decrypText(strip_tags($subadmin->admin_desc)) . "@" . decrypText(strip_tags($subadmin->admin_sub_key)); ?>');
      $('[name=password]').attr('type','password');
      $('[name=id]').val('<?php echo encrypText(strip_tags($subadmin->id)); ?>')
      var pattern = "<?php echo decrypText(strip_tags($subadmin->admin_pattern)); ?>";
      var lock = new PatternLock("#patternContainer");

      var lock = new PatternLock('#patternContainer',{enableSetPattern : true});
      lock.setPattern(pattern);

      var data = "<?php echo strip_tags($subadmin->admin_permission); ?>";
      selecteddata = data.split(',');
      $('.permission').val(selecteddata);
    })

  </script>
<?php }?>
<script>
  var lock = new PatternLock("#patternContainer",{
   onDraw:function(pattern){
    word();
  }
});
  function word() {
    var pat=lock.getPattern();
    $("#patterncode").val(pat);
    $('#subad_form').valid()
  }

  function gen_pwd() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!#$%^&*()";

    for (var i = 0; i < 8; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
  }


  $('document').ready(function(){
    <?php if ($type != "edit") {?>
      $('[name=password]').val(gen_pwd());
    <?php }?>
  })

  $('#generate_pwd').click(function(){
    $('[name=password]').val(gen_pwd());
  })

  function check_box_validation() {
   var fields = $('input[type=checkbox]:checked').serializeArray();
   if(fields.length == 0) {
    $('#permission_error').text('Choose At least One Module');
    flag = 1;
  } else {
    $('#permission_error').text('');
    flag = 0;
  }

  if(flag == 0) {
    return true;
  } else {
    return false;
  }
}


jQuery.validator.addMethod("atcheckbox", function(value, element) {
  var fileds = $('input[type=checkbox]:checked').serializeArray();
  return (fileds.length > 0);
}, "Choose atleast One Module");


$('#subad_form').validate({
  ignore:"",
  rules:{
    username:{
      required:true,
      <?php if ($type != "edit") {?>
        remote:{
          url: "checkUsernameExists",
          type: 'POST',
          headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },
          data: {
            username: function() {
              return $('#subad_form #username').val();
            }
          }
        }
      <?php }?>
    },
    email_addr:{
      required:true,
      email:true,
      <?php if ($type != "edit") {?>
        remote:{
          url: "checkEmailExists",
          type: 'POST',
          headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
          data: {
            email_addr: function() {
              return $('#subad_form #email_addr').val();
            }
          }
        }
      <?php }?>
    },
    permission:{
      required:true,
      atcheckbox:true,
    },
    <?php if ($type != "edit") {?>
      pattern_code:{
        required:true,
      }
    <?php }?>
  },
  messages:{
    username:{
      required:"Enter Username",
      remote:"Username Already Taken",
    },
    email_addr:{
      required:"Enter Email Id",
      email:"Please enter valid email",
      remote:"Email Id Already Taken",
    },
    pattern_code:{
      required:"Draw Pattern",
    }
  }
})
</script>

@stop