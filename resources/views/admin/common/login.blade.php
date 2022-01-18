<!DOCTYPE html>
<?php
$getSite = App\Model\User::getSiteLogo();
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=320; user-scalable=no; initial-scale=1.0; maximum-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Admin</title>
  <link rel="icon" href="{{$getSite->site_favicon}}" type="image/x-icon">
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


  <div class="" id="login_div">
    <div class="container">
      <div class="loginForm col-md-4 col-sm-6 col-xs-12 fn center-block">
        <?php if (Session::has('success')) {?>
          <div role="alert" class="alert alert-success" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><?php echo Session::get('success'); ?> </div>
        <?php }?>

        <?php if (Session::has('error')) {?>
          <div role="alert" class="alert alert-danger" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Oh!</strong><?php echo Session::get('error'); ?> </div>
        <?php }?>

        {!! Form::open(array('url' => $redirectUrl.'/adminLogin', 'class'=>'form-horizontal', 'id'=>'login_form', 'onsubmit'=>'login_loader_show()')) !!}

        <div class="form-group">
          <div class="col-md-12 col-sm-12 text-center">
            <h4 class="logTit">Login</h4>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-12 col-sm-12">Email</label>
          <div class="col-md-12 col-sm-12">
            <input type="text" name="username" id="username" class="form-control" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-12 col-sm-12">Password</label>
          <div class="col-md-12 col-sm-12">
            <input type="password" name="user_pwd" id="user_pwd" class="form-control" />
          </div>
        </div>

        <div class="control-group">
          <label class="col-md-12 col-sm-12">Pattern Code</label>
          <div class="col-md-12 col-sm-12">
            <div id="patternContainer"></div>
            <input type="hidden"  name="pattern_code" id="patterncode">
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6 text-right">
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12 col-sm-12">
            <button type="submit" class="btn btn-block" id="login_submit">Login</button>
            <img src="{{asset('/').('public/AVKpqBqmVJ/images/loader.gif')}}" class="btn_how" id="login_loader" style="display: none;">
          </div>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>

  <div class="" style="display:none;" id="forgot_div">
    <div class="container">
      <div class="loginForm col-md-4 col-sm-6 fn center-block">
        {!! Form::open(array('class'=>'form-horizontal', 'id'=>'forgot_form', 'onsubmit'=>'forgot_loader_show()')) !!}
        <div class="form-group">
          <div class="col-md-12 col-sm-12 text-center">
            <h4 class="logTit">Forgot Password </h4>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-12 col-sm-12">Email</label>
          <div class="col-md-12 col-sm-12">
            <input type="text" name="useremail" id="useremail" class="form-control" />
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12 col-sm-12">
            <button type="submit" class="btn btn-block" id="forgot_submit">Reset Password</button>
            <img src="{{asset('/').('public/AVKpqBqmVJ/images/loader.gif')}}" class="btn_how" id="forgot_loader" style="display: none;">
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12 col-sm-12 text-center">
            <p>
              <a href="#" id="login_show">Login</a>
            </p>
          </div>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>

  <div class="" style="display:none;" id="pattern_div">
    <div class="container">
      <div class="loginForm col-md-4 col-sm-6 col-xs-12 fn center-block">
        {!! Form::open(array('class'=>'form-horizontal', 'id'=>'pattern_form', 'onsubmit'=>'loader_show()')) !!}
        <div class="form-group">
          <div class="col-md-12 col-sm-12 text-center">
            <h4 class="logTit">Forgot Pattern </h4>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-12 col-sm-12">Email</label>
          <div class="col-md-12 col-sm-12">
            <input type="text" name="useremail" id="useremail" class="form-control" />
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12 col-sm-12">
            <button type="submit" class="btn btn-block" id="pattern_submit">Reset Pattern</button>
            <img src="{{asset('/').('public/AVKpqBqmVJ/images/loader.gif')}}" class="btn_how" id="pattern_loader" style="display: none;">
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12 col-sm-12 text-center">
            <p>
              <a href="#" id="login_show">Login</a>
            </p>
          </div>
        </div> 
        {!! Form::close() !!}
      </div>
    </div>
  </div> 
  <script src="{{asset('/').('public/AVKpqBqmVJ/js/jquery-2.1.1.min.js')}}"> </script>
  <script src="{{asset('/').('public/AVKpqBqmVJ/js/bootstrap.min.js')}}"> </script>
  <script src="{{asset('/').('public/AVKpqBqmVJ/js/patternLock.js')}}"> </script>
  <script src="{{asset('/').('public/AVKpqBqmVJ/js/jquery.validate.min.js')}}"> </script>
  <script>
    var redirectUrl = "<?php echo $redirectUrl;?>";
    jQuery.validator.addMethod("validEmail", function(value, element) {
      return this.optional( element ) || /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/.test( value );
    }, 'Please enter a valid email address.');
    var lock = new PatternLock("#patternContainer",{
     onDraw:function(pattern){
      word();
    }
  });
    function word()
    {
      var pat=lock.getPattern();

      $("#patterncode").val(pat);
      $('#patterncode').valid()
    }

    function login_loader_show() {
      if($('#login_form').valid() == true) {
        $('#login_submit').hide();
        $('#login_loader').show();
      }
    }

    function loader_show() {
      if($('#forgot_form').valid() == true) {
        $('#forgot_submit').hide();
        $('#forgot_loader').show();
      }
    }

    function forgot_loader_show() {
      if($('#pattern_form').valid() == true) {
        $('#pattern_submit').hide();
        $('#pattern_loader').show();
      }
    }


    $('#login_form').validate({
      ignore:"",
      rules:{
        username:{
          required:true,
          validEmail:true,
        },
        user_pwd:{
          required:true,
        },
        pattern_code:{
          required:true,
        }
      },
      messages:{
       username:{
        required:"Enter email",
      },
      user_pwd:{
        required:"Enter password",
      },
      pattern_code:{
        required:"Draw pattern",
      }
    }
  });

    $('#forgot_show').click(function(){
      $('#login_div').hide();
      $('#forgot_div').show();
      $('#pattern_div').hide();
    });

    $('#login_show').click(function(){
      $('#login_div').show();
      $('#forgot_div').hide();
      $('#pattern_div').hide();
    });

    $('#pattern_show').click(function(){
      $('#login_div').hide();
      $('#forgot_div').hide();
      $('#pattern_div').show();
    });

    $('#forgot_form').validate({
      rules:{
        useremail:{
          required:true,
          validEmail:true,
          remote:{
            url: "{{URL::to('/')}}" +"/"+ redirectUrl +"/checkResetEmail",
            type: 'POST',
            headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
            data: {
              email_addr: function() {
                return $('#forgot_form #useremail').val();
              }
            }
          }
        }
      },
      messages:{
        useremail:{
          required:"Enter your email",
          validEmail:"Enter valid email",
          remote:"Email not exists"
        }
      },
      submitHandler:function() {
       $.ajax({
        url:"{{URL::to('/')}}" +"/"+ redirectUrl +"/forgotPassword",
        method:"POST",
        data:$('#forgot_form').serialize(),
        headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
        success:function(data)
        {
          $('#forgot_form').trigger('reset');
          data = $.parseJSON(data);
          alert(data.msg);
          $('#forgot_submit').show();
          $('#forgot_loader').hide();
        }
      })
     }
   });

    $('#pattern_form').validate({
      rules:{
        useremail:{
          required:true,
          validEmail:true,
          remote:{
            url: "{{URL::to('/')}}" +"/"+ redirectUrl +"/checkResetEmail",
            type: 'POST',
            headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
            data: {
              email_addr: function() {
                return $('#pattern_form #useremail').val();
              }
            }
          }
        }
      },
      messages:{
        useremail:{
          required:"Enter your email",
          validEmail:"Enter valid email",
          remote:"Email not exists"
        }
      },
      submitHandler:function() {
        $.ajax({
          url:"{{URL::to('/')}}" +"/"+ redirectUrl +"/forgotPattern",
          method:"POST",
          data:$('#pattern_form').serialize(),
          headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
          success:function(data) {
            $('#pattern_form').trigger('reset');
            data = $.parseJSON(data);
            alert(data.msg);
            $('#pattern_submit').show();
            $('#pattern_loader').hide();
          }
        })
      }
    });

    $(document).ready(function(){
      setTimeout(function() {
        $('.alert').fadeOut('fast');
      }, 3000);  
    });
  </script>


</body>
</html>
