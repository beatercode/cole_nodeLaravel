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
                        <h2>{{$cms[1]->title}}</h2>
                        <h3>{{$cms[1]->content}}</h3>
                    </div>
                    <div class="d-flex  align-items-center swap-clockicon">
                        <img class="pr-4 active" src="{{asset('/').('public/FbGDnwAZEgTX/image/settings.png')}}" alt="">
                        <img src="{{asset('/').('public/FbGDnwAZEgTX/image/swap/clock.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="swap-three pt-5 pb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 ">
                <div class="swap-cd1-1 liqlist">
                    <div class="d-flex justify-content-center">
                        <div class="spinner-grow loader-2-ch"></div>
                    </div>
                </div>
                <div class="text-center buy-token-btn pt-3 pb-3">
                    <a href="{{URL::to('/addLiquidity')}}"><button class="btn">Add liquidity</button></a>
                </div>
            </div>
        </div>
    </div>
    @include('front.layouts.footer')
</div>
<div class="pop-up">
    <!-- Modal -->
    <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-ind swap-cd1-modal" role="document">
            <div class="modal-content modal-content-connect-wallect add-ticket">
                <div class="modal-header">
                    <h5 class="modal-title">Settings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="{{asset('/').('public/FbGDnwAZEgTX/image/close.png')}}"></button>
                </div>
                <div class="modal-body model-body-connect-wallet model-body-connect-wallet-4">
                    <div class="resent-popup-1 resent-popup-2">
                        <h3>Transaction Settings</h3>
                        <h5>Slippage Tolerance <img src="{{asset('/').('public/FbGDnwAZEgTX/image/quest-green.png')}}" class="ml-2"></h5>
                        <div class="perc-div my-3">
                            <div class="val-div active">0.1%</div>
                            <div class="val-div">0.4%</div>
                            <div class="val-div">1%</div>
                            <div class="val-div"><input type="text" class="form-control" placeholder="0.50 %"></div>
                        </div>
                        <h5>Transaction Deadline<img src="{{asset('/').('public/FbGDnwAZEgTX/image/quest-green.png')}}" class="ml-2"></h5>
                        <div class="perc-div my-3 justify-content-start">
                            <div class="val-div mb-0">15</div> <span  class="ml-3">Minutes</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>           
<script>
    var addPairUrl = "{{URL::to('/addPair')}}";
    var getPoolUrl = "{{URL::to('/getPair')}}";
    var removeUrl  = "{{URL::to('/removeLiquidity')}}";
    var imageUrl   = "{{asset('/').('public/IuMzmYaMZE/')}}";
    var liqpair = "{{asset('/').('public/FbGDnwAZEgTX/image/liqpair.png')}}";
    var right_arrow = "{{asset('/').('public/FbGDnwAZEgTX/image/right-arrow.png')}}";
    
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
</script>
<script src="{{asset('/').('public/FbGDnwAZEgTX/scripts/liquidity.js')}}?{{date('Y-m-d h:i:s')}}"></script>
</body>
</html>