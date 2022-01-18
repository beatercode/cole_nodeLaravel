<footer class="index-footer">
    <div class="container">
        <h2 class="footer-copy-1"> {{$site->copy_right_text}} </h2>
    </div>
</footer>
<div class="connect-w">
    <div class="modal fade" id="connect-wallet" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content px-4">
                <div class="modal-header">
                    <h5 class="modal-title font-size16 font-w400 text-white" id="exampleModalLongTitle">Connect wallet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> <img src="{{asset('/').('public/FbGDnwAZEgTX/image/stake/X.png')}}" alt=""> </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-around align-items-center">
                        <div class="wallet-border text-center login-auto">
                            <img src="{{asset('/').('public/FbGDnwAZEgTX/image/stake/meta.png')}}" alt="">
                            <p class="text-white">Metamask</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="disconnect-wallet" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content px-4">
                <div class="modal-header">
                    <h5 class="modal-title font-size16 font-w400 text-white" id="exampleModalLongTitle">Disconnect wallet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> <img src="{{asset('/').('public/FbGDnwAZEgTX/image/close.png')}}" alt=""> </span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="text" ><?php echo session('network');?> Wallet</label>
                    <?php 
                    $address = session('userName');
                    $addr1 = substr($address, 0, 6);
                    $addr2 = substr($address, 38, 42);
                    $addr = $addr1.'..'.$addr2;
                    $exp = (session('network') == 'ETC') ? 'Ethercan' : 'Bscscan';
                    $link = (session('network') == 'ETC') ? 'https://rinkeby.etherscan.io/address/'.$address : 'https://testnet.bscscan.com/address/'.$address;
                    ?>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control form-control-lg" aria-label="Recipient's username" aria-describedby="basic-addon2" value="{{$addr}}">
                        <input type="text" id="metamask_address" value="{{$address}}" style="display:none;">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2"  onclick="copyAddress('metamask_address')"> <img src="{{asset('/').('public/FbGDnwAZEgTX/image/stake/copy.png')}}" alt=""> </span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{$link}}" class="text-green" target="_blank">View {{$exp}}</a>
                        <div class="d-flex">
                            <a href="{{URL::to('/logout')}}"><button type="button" class="connect-wallet-btn-nav" onclick="logout();">Disconnect Wallet</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var base_url = redirectUrl = "{{URL::to('/')}}";
    var unlock = "{{URL::to('/unlock')}}";
    var chooseNw = "{{URL::to('/chooseNw')}}";
    var networkUrl = "{{URL::to('/saveNetwork')}}";
    var csrf_token = {'X-CSRF-TOKEN':"{{ csrf_token() }}"};


    $( document ).ready(function() {
        <?php if (Session::has('success')) {?>
          var sucess= "{{ Session::get('success') }}";
          notif({ msg: '<i class="fa fa-check-circle" aria-hidden="true"></i>'+" "+sucess, type: "success", multiline: true });
      <?php }?>
      <?php if (session()->has('error')) {?>
          var error= "{{ Session::get('error') }}";
          notif({ msg: '<i class="fa fa-exclamation-circle" aria-hidden="true"></i>'+" "+error, type: "error", multiline: true });
      <?php }?>

      var body_theme = localStorage.getItem('body_theme');
       $('#body_theme').removeClass('dark-mode light-mode');
       $('#body_theme').addClass(body_theme);
  });

    function copyAddress(element) {
        var copyText = document.getElementById(element);
        copyText.select();
        copyText.setSelectionRange(0, 99999);  
        navigator.clipboard.writeText(copyText.value);
        notif({ msg: '<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Copied', type: "success" });
    }

    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if ((charCode > 34 && charCode < 41) || (charCode > 47 && charCode < 58) || (charCode == 46) || (charCode == 8) || (charCode == 9))
            return true;
        return false;
    }

    function toFixed(x) {
        x = parseFloat(x);
        if (Math.abs(x) < 1.0) {
            var e = parseInt(x.toString().split('e-')[1]);
            if (e) {
                x *= Math.pow(10,e-1);
                x = '0.' + (new Array(e)).join('0') + x.toString().substring(2);
            }
        } else {
            var e = parseInt(x.toString().split('+')[1]);
            if (e > 20) {
                e -= 20;
                x /= Math.pow(10,e);
                x += (new Array(e+1)).join('0');
            }
        }
        return x;
    }

    function get_number(x) {
        if (Math.abs(x) < 1.0) {
            var e = parseInt(x.toString().split('e-')[1]);
            if (e) {
                x *= Math.pow(10,e-1);
                x = '0.' + (new Array(e)).join('0') + x.toString().substring(2);
            }
        } else {
            var e = parseInt(x.toString().split('+')[1]);
            if (e > 20) {
                e -= 20;
                x /= Math.pow(10,e);
                x += (new Array(e+1)).join('0');
            }
        }
        return x;
    }

    function startLoader() {
        $('#loader').css('display', 'flex');
    }

    function stopLoader() {
        $('#loader').css('display', 'none');
    }

    function logout() {
        localStorage.removeItem('adminAddr');
        localStorage.removeItem('adminNetwork');
    }

    $('#sun').click(function(){
        $('#body_theme').removeClass('dark-mode');
        $('#body_theme').addClass('light-mode');
        localStorage.setItem('body_theme','light-mode');
    });

    $('#moon').click(function(){
        $('#body_theme').removeClass('light-mode');
        $('#body_theme').addClass('dark-mode');
        localStorage.setItem('body_theme','dark-mode');
    });

    window.oncontextmenu = function () {
        return false;
    }

    $(document).keydown(function (event) {
        if (event.keyCode == 123) {
            return false;
        } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { 
            return false;
        }
    });

</script>
<script src="{{asset('/').('public/FbGDnwAZEgTX/scripts/changeNetwork.js')}}?{{date('Y-m-d h:i:s')}}"></script>
<?php if (session('network') == 'ETC') {?>
    <script src="{{asset('/').('public/COWDEKuFKdJx/ETC/contract.js')}}?{{date('Y-m-d h:i:s')}}"></script>
<?php } else { ?>
    <script src="{{asset('/').('public/COWDEKuFKdJx/BSC/contract.js')}}?{{date('Y-m-d h:i:s')}}"></script>
    <?php } ?>