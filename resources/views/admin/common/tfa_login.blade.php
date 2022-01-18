<!DOCTYPE html>
<?php
$getSite = App\Model\User::getSiteLogo();
?>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=320; user-scalable=no; initial-scale=1.0; maximum-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Admin</title>

  <link rel="icon" href="{{$getSite->site_favicon}}" type="image/x-icon">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{asset('/').('public/AVKpqBqmVJ/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('/').('public/AVKpqBqmVJ/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('/').('public/AVKpqBqmVJ/css/patternLock.css')}}"  type="text/css">

  <style>
    body{
      font-family:Arial, Helvetica, sans-serif;
    }
    .error{
      color:red;
    }
  </style>

</head>
<body class="loginBg">
  <div class="" id="forgot_div">
    <div class="container">
      <div class="loginForm col-md-4 col-sm-6 fn center-block">
       <?php if (Session::has('success')) {?>
        <div role="alert" class="alert alert-success" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><?php echo Session::get('success'); ?> </div>
      <?php }?>

      <?php if (Session::has('error')) {?>
        <div role="alert" class="alert alert-danger" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Oh!</strong><?php echo Session::get('error'); ?> </div>
      <?php }?>

      {!! Form::open(array('url' => $redirectUrl.'/tfaLogin', 'class'=>'form-horizontal', 'id'=>'tfa_form', 'onsubmit'=>'tfa_login()')) !!}

      <div class="form-group">
        <div class="col-md-12 col-sm-12 text-center">
          <h4 class="logTit">Two Factor Authentication</h4>
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-12 col-sm-12">
          <input type="text" name="auth_key" id="auth_key" class="form-control" onkeypress="return isNumberKey(event)" />
          <input type="hidden" name="aid" id="aid" class="form-control" value="{{$aid}}"/>
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-12 col-sm-12">
          <button type="submit" class="btn btn-block" id="tfa_submit">Submit</button>
          <img src="{{asset('/').('public/AVKpqBqmVJ/images/loader.gif')}}" class="btn_how" id="tfa_loader" style="display: none;">
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>

<!-- jQuery first, then Tether, then Bootstrap JS. -->
<script src="{{asset('/').('public/AVKpqBqmVJ/js/jquery-2.1.1.min.js')}}"> </script>
<script src="{{asset('/').('public/AVKpqBqmVJ/js/bootstrap.min.js')}}"> </script>
<script src="{{asset('/').('public/AVKpqBqmVJ/js/jquery.validate.min.js')}}"> </script>


<script>
  function tfa_login() {
    var length = $("#auth_key").val().length;
    if(length == 6) {
      setTimeout(function(){
        document.getElementById("tfa_form").submit();
        $('#tfa_submit').hide();
        $('#tfa_loader').show();
      },300);      
    } else {
      document.getElementById("tfa_form").validate();
      $('#tfa_submit').show();
      $('#tfa_loader').hide();
    }
  }


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
    },
    messages:{
      auth_key:{
        required:"Enter 2FA 6 Digit Code",
        number:"Enter Only Number",
        remote:"Email not exists",
        minlength:"Enter 6 Digit Code Only",
        maxlength:"Enter 6 Digit Code Only",

      },     
    }
  });

  function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if ((charCode > 34 && charCode < 41) || (charCode > 47 && charCode < 58) || (charCode == 46) || (charCode == 8) || (charCode == 9))
      return true;
    return false;
  }
</script>


</body>
</html>
