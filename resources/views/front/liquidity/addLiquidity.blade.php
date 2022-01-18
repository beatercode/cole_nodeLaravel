<?php 
$from = $to = $pairs;
$_data = $_data1 = array();

foreach ($from as $v) {
  if (isset($_data[$v['from_symbol']])) {
    continue;
}
$_data[$v['from_symbol']] = $v;
}
$from = array_values($_data);

foreach ($to as $v) {
  if (isset($_data1[$v['to_symbol']])) {
    continue;
}
$_data1[$v['to_symbol']] = $v;
}
$to = array_values($_data1);

?>
@include('front.layouts.header')
@include('front.layouts.sidebar')
</div>
</div>
<div class=" col-auto rightcontent ">
    @include('front.layouts.menu')
    <div class="swap-one pt-3">
        <div class="text-center swap-hd">
            <img class="img-fluid" src="{{asset('/').('public/FbGDnwAZEgTX/image/swap/hd.png')}}" alt="">
        </div>
    </div>
    <div class="swap-two pt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <div class=" d-flex flex-wrap align-items-center justify-content-between">
                    <div class="swap-cd-1">
                        <h2>Add Liquidity</h2>
                        <h3>Add liquidity to receive LP tokens </h3>
                    </div>
                    <div class="d-flex  align-items-center swap-clockicon">
                        <img class="pr-4" src="{{asset('/').('public/FbGDnwAZEgTX/image/swap/sliders.png')}}" alt="">
                        <img src="{{asset('/').('public/FbGDnwAZEgTX/image/swap/clock.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="swap-three pt-5 pb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 ">
                <div class="swap-cd1-1">
                    <div class="swap-cd1-1-inner-1 mt-2">
                        <h2>From</h2>
                        <div class="input-group swap-cd1-1-inner-1-input  mb-1 pt-2">
                            <input type="text" class="form-control pl-0" id="from_amount" placeholder="0.0" onkeyup="fromAmtChanged();" onkeypress="return isNumberKey(event, this)">
                            <div class="input-group-append exchange--trade-tk-1-bt">
                                <button class="btn exchange--trade-tk-1-bt-1" type="button" data-toggle="modal" data-target="#from_popup"> <img class="pr-xl-3 pr-lg-3 pr-2" id="selected_from_image" src="{{asset('/').('public/FbGDnwAZEgTX/image/swap/iconcoin1.png')}}" alt="" style="display:none;"><span id="selected_from">Select</span><img class="pl-2 pl-xl-3 pl-lg-3 " src="{{asset('/').('public/FbGDnwAZEgTX/image/chevron-down.png')}}" alt="">
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="text-center swap-icon-1">
                        <img src="{{asset('/').('public/FbGDnwAZEgTX/image/swap/icon1.png')}}" alt="">
                    </div>
                    <div class="swap-cd1-1-inner-1 mt-2">
                        <h2>TO</h2>
                        <div class="input-group swap-cd1-1-inner-1-input  mb-1 pt-2">
                            <input type="text" class="form-control pl-0" id="to_amount" placeholder="0.0" onkeyup="toAmtChanged();" onkeypress="return isNumberKey(event, this)">
                            <div class="input-group-append exchange--trade-tk-1-bt">
                                <button class="btn exchange--trade-tk-1-bt-1" type="button" data-toggle="modal" data-target="#to_popup"> <img class="pr-xl-3 pr-lg-3 pr-2" id="selected_to_image" src="{{asset('/').('public/FbGDnwAZEgTX/image/chip.png')}}" alt="" style="display:none;"><span id="selected_to">Select</span><img class="pl-2 pl-xl-3 pl-lg-3 " src="{{asset('/').('public/FbGDnwAZEgTX/image/chevron-down.png')}}" alt="">
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="eth-chip-div my-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><span class="from_symbol">ETC</span> per <span class="to_symbol">CHIP</span></span>
                            <span class="val price_val">0</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><span class="to_symbol">CHIP</span> per <span class="from_symbol">ETC</span></span>
                            <span class="val amount_val">0</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Share of pool</span>
                            <span class="val pool_share">0%</span>
                        </div>
                    </div>
                    <div class="text-center buy-token-btn pt-3 pb-3">
                        <?php if(session('userId') != '') { ?>
                            <button class="btn" onclick="approve();" id="approve_button">Approve</button>
                            <button class="btn" onclick="addLiquidity();" id="liquidity_button" style="display: none;">Supply</button>
                        <?php } else { ?>
                           <button class="btn">Approve</button>
                           <button class="btn">Supply</button>
                       <?php } ?>
                   </div>
               </div>
           </div>
       </div>
   </div>
   @include('front.layouts.footer')
</div>
</div>
<div class="pop-up">
    <div class="modal fade" id="from_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-ind swap-cd1-modal" role="document">
            <div class="modal-content modal-content-connect-wallect add-ticket">
                <div class="modal-header">
                    <h5 class="modal-title">Select a Token <img src="{{asset('/').('public/FbGDnwAZEgTX/image/quest.png')}}" class="ml-2"></h5>
                    <button type="button" class="close" id="from_close" data-dismiss="modal" aria-label="Close"><img src="{{asset('/').('public/FbGDnwAZEgTX/image/close.png')}}"></button>
                </div>
                <div class="modal-body model-body-connect-wallet model-body-connect-wallet-4"> 
                    <div class="resent-popup-1 resent-popup-2 mt-3">
                        <div class="form-group has-search">                                        
                            <input type="text" class="form-control" placeholder="Search" id="from_search">
                            <span class="fa fa-search form-control-feedback"></span>
                        </div>
                        <h5>Token Name</h5>
                        <div class="token-list">
                            <?php foreach($from as $value) { 
                                $from_image = URL::to('public/IuMzmYaMZE/'.$value->from_image);
                                ?>
                                <div class="mb-2 from_token_list from_{{$value->from_symbol}}" onclick="chooseFrom('{{$from_image}}', '{{$value->from_symbol}}')">
                                    <div class="ldiv ldiv-1 justify-content-between align-items-center ">
                                        <h2 class="funsion1">
                                            <img class="imgCls-1" src="{{$from_image}}">
                                            <span class="ml-2">{{$value->from_symbol}}</span>
                                            <span class="ml-2" style="display:none;">{{$value->from_address}}</span>
                                        </h2>
                                        <span class="funsion2" id="bal_{{$value->from_symbol}}">0</span>
                                    </div>
                                    <input type="hidden" id="fromAddr_{{$value->from_symbol}}" value="{{$value->from_address}}">
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="to_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-ind swap-cd1-modal" role="document">
            <div class="modal-content modal-content-connect-wallect add-ticket">
                <div class="modal-header">
                    <h5 class="modal-title">Select a Token <img src="{{asset('/').('public/FbGDnwAZEgTX/image/quest.png')}}" class="ml-2"></h5>
                    <button type="button" class="close" id="to_close" data-dismiss="modal" aria-label="Close"><img src="{{asset('/').('public/FbGDnwAZEgTX/image/close.png')}}"></button>
                </div>
                <div class="modal-body model-body-connect-wallet model-body-connect-wallet-4"> 
                    <div class="resent-popup-1 resent-popup-2 mt-3">
                        <div class="form-group has-search">                                        
                            <input type="text" class="form-control" placeholder="Search" id="to_search">
                            <span class="fa fa-search form-control-feedback"></span>
                        </div>
                        <h5>Token Name</h5>
                        <div class="token-list">
                            <?php foreach($to as $value) { 
                                $to_image = URL::to('public/IuMzmYaMZE/'.$value->to_image);
                                ?>
                                <div class="d-flex justify-content-between align-items-center mb-2 to_token_list to_{{$value->to_symbol}}" onclick="chooseTo('{{$to_image}}', '{{$value->to_symbol}}')">
                                    <div class="ldiv ldiv-1  justify-content-between align-items-center ">
                                        <h2 class="funsion1">
                                            <img class="imgCls-1" src="{{$to_image}}">
                                            <span class="ml-2">{{$value->to_symbol}}</span>
                                            <span class="ml-2" style="display:none;">{{$value->to_address}}</span>
                                        </h2>
                                        <span class="funsion2" id="bal_{{$value->to_symbol}}">0</span>
                                    </div>
                                    <input type="hidden" id="toAddr_{{$value->to_symbol}}" value="{{$value->to_address}}">
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>           
<script>
    var liquidityUrl   = "{{URL::to('/createTransaction')}}";
    var currencyUrl    = "{{URL::to('/getCurrency')}}";
    var liquidityPage  = "{{URL::to('/liquidity')}}";

    $(document).ready(function () {
        $('.laptop').click(function () {
            $('.sidenav').toggleClass('fliph');
        });
        $(window).scroll(function () {
            $('.navbarss').toggleClass("navbars", ($(window).scrollTop() >
                10));
        });

    }); 

    $(document).ready(function () {
        $('.laptop').click(function () {
            $('.rightcontent').toggleClass('fliph');
        });
        $(window).scroll(function () {
            $('.navbarss').toggleClass("navbars", ($(window).scrollTop() >
                10));
        });

    }); 

    $(document).ready(function () {
        $('.laptop').click(function () {
            $('.navbarss').toggleClass('fliph');
        });
    });

    $("#from_search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".from_token_list div").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
      });
    });

    $("#to_search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".to_token_list div").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
      });
    });
</script>
<script src="{{asset('/').('public/FbGDnwAZEgTX/scripts/addLiquidity.js')}}?{{date('Y-m-d h:i:s')}}"></script>
</body>
</html>