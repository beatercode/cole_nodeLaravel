<script src="{{asset('/').('public/AVKpqBqmVJ/js/jquery-ui.js')}}"> </script>
<script src="{{asset('/').('public/AVKpqBqmVJ/js/bootstrap.min.js')}}"> </script>
<script src="{{asset('/').('public/AVKpqBqmVJ/js/dashboard.js')}}"> </script>
<script src="{{asset('/').('public/AVKpqBqmVJ/js/lc_switch.js')}}"> </script>
<script src="{{asset('/').('public/AVKpqBqmVJ/js/jquery.dataTables.min.js')}}"> </script>
<script src="{{asset('/').('public/FbGDnwAZEgTX/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"> </script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"> </script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
<script src="{{asset('/').('public/FbGDnwAZEgTX/js/notifIt.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script>
<script src="{{asset('/').('public/AVKpqBqmVJ/scripts/connectWallet.js')}}?{{date('Y-m-d h:i:s')}}"></script>
<?php if (session('adminNetwork') == 'ETC') {?>
  <script src="{{asset('/').('public/COWDEKuFKdJx/ETC/contract.js')}}?{{date('Y-m-d h:i:s')}}"></script>
<?php } else { ?>
  <script src="{{asset('/').('public/COWDEKuFKdJx/BSC/contract.js')}}?{{date('Y-m-d h:i:s')}}"></script>
<?php } ?>
<script src="{{asset('/').('public/AVKpqBqmVJ/scripts/contract.js')}}?{{date('Y-m-d h:i:s')}}"></script>
<script>

  var csrf_token = {'X-CSRF-TOKEN':"{{ csrf_token() }}"};
  var adminurl = "{{URL::to('/')}}";
  var redirectUrl = '<?php echo $redirectUrl;?>';
  var unlockUrl = adminurl + '/' + redirectUrl + '/unlockWallet';
  var networkUrl = adminurl + '/' + redirectUrl + '/saveAdminNetwork';
  var pairUrl = adminurl + '/' + redirectUrl + '/createPair';
  
  jQuery.validator.addMethod("validEmail", function(value, element) {
    return this.optional( element ) || /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/.test( value );
  }, 'Please enter a valid email address.');

  $.validator.addMethod('lessThan', function(value, element, param) {
    return this.optional(element) || parseInt(value) < parseInt($(param).val());
  }, "Must be less than to Max Amount");

  $.validator.addMethod('greaterThan', function(value, element, param) {
    return this.optional(element) || parseInt(value) > parseInt($(param).val());
  }, "Must be greater than to Min Amount");

  $.validator.addMethod('positiveNumber',function(value) {
    return Number(value) > 0;
  }, 'Enter a positive number.');


  $(document).ajaxSuccess(function(event, jqXHR, settings) {
    resetAjaxToken(jqXHR);
  });

  function resetAjaxToken(jqXHR) {
    var token = jqXHR.getResponseHeader("CI-CSRF-Token");
    $('input[name="csrf_test_name"]').val(token);
  }

  $(document).ready(function(){
    setTimeout(function() {
      $('.alert').fadeOut('fast');
    }, 3000); 
  });

  (function($){
    $(window).on("load",function(){
      var height = $(window).height();
      $(".notscroll").mCustomScrollbar({
        scrollButtons:{
          enable:true
        },

        scrollbarPosition: 'inside',
        autoExpandScrollbar:true,
        theme: 'minimal-dark',
        axis:"y",
        setWidth: "auto"
      });

    });
  })(jQuery);

  $('#decreasecount').click(function(){
    $('#re_count').text('0');
    $.ajax({
      url:"{{ URL::to($redirectUrl.'/decreaseNotifyCount') }}",
      method:"GET",
      data:"",
      success:function(data){

      }
    })
  })

  $(function() {
    $('#disconnect').on('click', function() {
      $('#disconnect-wallet').modal('show');
    });
  });

  function logout() {
    localStorage.clear();
  }
</script>