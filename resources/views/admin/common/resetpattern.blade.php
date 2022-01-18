<?php
$getSite = App\Model\User::getSiteLogo();
?>
<!DOCTYPE html>
<html lang="en">
<head> 
  <meta charset="utf-8">
  <meta name="viewport" content="width=320; user-scalable=no; initial-scale=1.0; maximum-scale=1.0">
  <title>Admin</title> 
  <link rel="stylesheet" href="{{asset('/').('public/AVKpqBqmVJ/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('/').('public/AVKpqBqmVJ/css/style.css')}}">
  <link rel="icon" href="{{$getSite->site_favicon}}" type="image/x-icon">
  <style>
    body { font-family:Arial, Helvetica, sans-serif; }
    .error { color:red; }
  </style>
</head>
<body class="loginBg">
  <div class="" id="login_div">
    <div class="container">
      <div class="loginForm col-md-4 col-sm-6 col-xs-12 fn center-block">
        {!! Form::open(array('url' => $redirectUrl.'/updatePattern', 'class'=>'form-horizontal', 'id'=>'Pattern_form', 'onsubmit'=>'loader_show()')) !!}
        <div class="form-group">
          <div class="col-md-12 col-sm-12 text-center">
            <h4 class="logTit">Forgot Pattern </h4>
          </div>
        </div>
        <div class="col-sm-12 col-xs-12 cls_resp50">
          <div class="form-group clearfix">
            <label class="form-control-label">New Patternlock</label>
            <div id="patternContainernew" style='width: 320px!important;'></div>
            <input type="hidden" name="pattern_code" id="pattern_code">
          </div>
        </div>
        <div class="col-sm-12 col-xs-12 cls_resp50">
          <div class="form-group clearfix">
            <label class="form-control-label">Confirm Patternlock</label>
            <div id="patternContainerconfirm" style='width: 320px!important;'></div>
            <input type="hidden" name="pattern_code_confirmation" id="pattern_code_confirmation">
          </div>
        </div>
        <input type="hidden" name="fcode" value="<?php echo strip_tags($data['fcode']); ?>">
        <input type="hidden" name="ucode" value="<?php echo strip_tags($data['ucode']); ?>">
        <div class="form-group">
          <div class="col-md-12 col-sm-12">
            <button type="submit" class="btn btn-block" id="Pattern_submit">Reset Pattern</button>
            <img src="{{asset('/').('public/AVKpqBqmVJ/images/loader.gif')}}" class="btn_how" id="Pattern_loader" style="display: none;">
          </div>
        </div>

        {!! Form::close() !!}
      </div>
    </div>
  </div> 
  <script src="{{asset('/').('public/AVKpqBqmVJ/js/jquery-2.1.1.min.js')}}"> </script>
  <script src="{{asset('/').('public/AVKpqBqmVJ/js/bootstrap.min.js')}}"> </script>
  <script src="{{asset('/').('public/AVKpqBqmVJ/js/patternLock.js')}}"> </script>
  <link rel="stylesheet" href="{{asset('/').('public/AVKpqBqmVJ/css/patternLock.css')}}"  type="text/css">
  <script src="{{asset('/').('public/AVKpqBqmVJ/js/jquery.validate.min.js')}}"> </script>
  <script src="{{asset('/').('public/assets/js/additional-methods.js')}}"> </script>
  <script>
    jQuery.validator.addMethod("notEqualTo", function(value, element, param) {
      var notEqual = true;
      value = $.trim(value);
      for (i = 0; i < param.length; i++) {
        if (value == $.trim($(param[i]).val())) { notEqual = false; }
      }
      return this.optional(element) || notEqual;
    },"Please enter a diferent value."
    );

    function loader_show() { 
      if($('#Pattern_form').valid() == true) {
        $('#Pattern_submit').hide();
        $('#Pattern_loader').show();
      }
    }

    var lock2 = new PatternLock("#patternContainernew",{
      onDraw:function(pattern){
        word1();
      }
    });var lock3 = new PatternLock("#patternContainerconfirm",{
      onDraw:function(pattern){
        word2();
      }
    }); 
    function word1() {
      var pat1=lock2.getPattern();
      $("#pattern_code").val(pat1);
    }function word2() {
      var pat2=lock3.getPattern();
      $("#pattern_code_confirmation").val(pat2);
    } 


    $('#Pattern_form').validate({
      ignore:"",
      rules:{ 
        pattern_code:
        {
          required:true,
          minlength:3, 
        },
        pattern_code_confirmation:
        {
          required:true,
          minlength:3,
          equalTo : '[name="pattern_code"]',
        }
      },
      messages:{ 
        pattern_code_confirmation:{
          equalTo:"Enter same pattern",
        },
      }
    })
  </script>
</body>
</html>