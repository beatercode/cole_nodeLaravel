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
                        <h2>Remove Liquidity</h2>
                    </div>
                    <div class="d-flex  align-items-center swap-clockicon">
                        <img src="{{asset('/').('public/FbGDnwAZEgTX/image/quest-green.png')}}" alt="" style="filter: none;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="swap-three pt-5 pb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 ">
                <div class="swap-cd1-1 mb-3">
                    <div class="d-flex justify-content-between align-items-center amt-det-div mb-3">
                        <span>Amount </span>
                        <a href="#">Detailed</a>
                    </div>
                    <div class="top-div mb-3">
                        <div class="rSlider">
                            <span class="slide"></span>
                            <input id="range" type="range" class="selected_perc" min="0" max="100" value="0" >
                        </div>
                        <div class="perc-div mt-3">
                            <div class="liquid_percent val-div" data-amount="25">25%</div>
                            <div class="liquid_percent val-div" data-amount="50">50%</div>
                            <div class="liquid_percent val-div" data-amount="75">75%</div>
                            <div class="liquid_percent val-div active" data-amount="100">100%</div>
                        </div>
                    </div>
                    <div class="pool-div">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Pooled CHIP</span>
                            <div class="rdiv">
                                <img src="{{asset('/').('public/FbGDnwAZEgTX/image/chip-small.png')}}">
                                <span class="ml-2 val my_val1">0</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Pooled ETC</span>
                            <div class="rdiv">
                                <img src="{{asset('/').('public/FbGDnwAZEgTX/image/eth-small.png')}}">
                                <span class="ml-2 val my_val2">0</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end align-items-center mb-2">                                            
                            <div class="rdiv">                                                
                                <span>Receive</span><span class="ml-2 val">ETC</span>
                            </div>
                        </div>
                    </div>
                    <div class="price-div mb-3">
                        <div class="">
                            <h5>Price</h5>
                        </div>
                        <div class="">
                            <div class="d-flex justify-content-end">
                                <h5 class="val">1 <span class="from_symbol">CHIP</span></h5>
                                <span class="mx-2">=</span>
                                <h5 class="val"><span class="price_val">0</span> <span class="to_symbol">ETC</span></h5>
                            </div>
                            <div class="d-flex justify-content-end">
                                <h5 class="val">1 <span class="to_symbol">ETC</span></h5>
                                <span class="mx-2">=</span>
                                <h5 class="val"><span class="amount_val">0</span> <span class="from_symbol">CHIP</span></h5>
                            </div>
                        </div>
                    </div>
                    <div style="display:none;">
                        <input type="hidden" id="my_t_b">
                        <input type="hidden" id="from_symbol">
                        <input type="hidden" id="to_symbol">
                        <span class="share_my"></span>
                    </div>
                    <div class="btndiv">
                        <?php if(session('userId') != '') { ?>
                            <button class="btn approve-btn" id="approve_button" onclick="approve();">Approve</button>
                            <button class="btn remove-btn ml-2" id="liquidity_button" onclick="removeLiquidity();" style="display:none;">Remove</button>
                        <?php } else { ?>
                            <button class="btn approve-btn">Approve</button>
                            <button class="btn remove-btn ml-2">Remove</button>
                        <?php } ?>
                    </div>
                </div>
                <div class="swap-cd1-1">
                    <h6 class="lpwal">LP Token in your walllet</h6>                              
                    <div class="eth-chip-div my-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="ldiv d-flex align-items-center">
                                <img src="{{asset('/').('public/FbGDnwAZEgTX/image/liqpair.png')}}"><h4 class="ml-2">ETC/CHIP</h4>
                            </div>
                            <span class="val my_t_b">0</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>ETC</span>
                            <span class="val hole_val2">0</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>CHIP</span>
                            <span class="val hole_val1">0</span>
                        </div>                                        
                    </div>                                   
                </div>
            </div>
        </div>
    </div>
    @include('front.layouts.footer')
</div>
</div>
<div class="pop-up">
    <!-- Modal -->
    <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-ind swap-cd1-modal" role="document">
            <div class="modal-content modal-content-connect-wallect add-ticket">
                <div class="modal-header">
                    <h5 class="modal-title">Select a Token <img src="{{asset('/').('public/FbGDnwAZEgTX/image/quest.png')}}" class="ml-2"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="{{asset('/').('public/FbGDnwAZEgTX/image/close.png')}}"></button>
                </div>
                <div class="modal-body model-body-connect-wallet model-body-connect-wallet-4">
                    <div class="resent-popup-1 resent-popup-2 mt-3">
                        <div class="form-group has-search">                                        
                            <input type="text" class="form-control" placeholder="Search">
                            <span class="fa fa-search form-control-feedback"></span>
                        </div>
                        <h5>Token Name</h5>
                        <div class="token-list">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="ldiv">
                                    <img src="{{asset('/').('public/FbGDnwAZEgTX/image/eth.png')}}">
                                    <span class="ml-2">ETC</span>
                                </div>
                                <span>0</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="ldiv">
                                    <img src="{{asset('/').('public/FbGDnwAZEgTX/image/usdt.png')}}">
                                    <span class="ml-2">USDT</span>
                                </div>
                                <span>0</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="ldiv">
                                    <img src="{{asset('/').('public/FbGDnwAZEgTX/image/chip.png')}}">
                                    <span class="ml-2">CHIP</span>
                                </div>
                                <span>0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>           
<script>
    var liquidityUrl  = "{{URL::to('/createTransaction')}}";
    var liquidityPage  = "{{URL::to('/liquidity')}}";
    var removeAddress = "{{ Request::segment(2) }}";

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
    $(window).on("load", function(){ 
      var range = $("#range").attr("value");
      $("#demo").html(range);
      $(document).on('input change', '#range', function() {
        $('#demo').html( $(this).val() );
        var slideWidth = $(this).val() * 100 / 100;
        console.log('slideWidth', slideWidth);
        $(".slide").css("width", slideWidth + "%");
    });
  });
</script>
<script src="{{asset('/').('public/FbGDnwAZEgTX/scripts/removeLiquidity.js')}}?{{date('Y-m-d h:i:s')}}"></script>
</body>
</html>