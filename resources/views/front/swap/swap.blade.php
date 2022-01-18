@include('front.layouts.header')
@include('front.layouts.sidebar')
</div>
</div>
<div class="col-auto rightcontent ">
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
                        <h2>{{$cms[2]->title}}</h2>
                        <h3>{{$cms[2]->content}}</h3>
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
                            <input type="text" placeholder="0.00" class="form-control" id="from_amount" onkeyup="fromAmtChanged();" onkeypress="return isNumberKey(event, this)">
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
                            <input type="text" placeholder="0.00" class="form-control" id="to_amount" onkeyup="toAmtChanged();" onkeypress="return isNumberKey(event, this)">
                            <div class="input-group-append exchange--trade-tk-1-bt">
                                <button class="btn exchange--trade-tk-1-bt-1" type="button" data-toggle="modal" data-target="#to_popup"> <img class="pr-xl-3 pr-lg-3 pr-2" id="selected_to_image" src="{{asset('/').('public/FbGDnwAZEgTX/image/chip.png')}}" alt="" style="display:none;"><span id="selected_to">Select</span><img class="pl-2 pl-xl-3 pl-lg-3 " src="{{asset('/').('public/FbGDnwAZEgTX/image/chevron-down.png')}}" alt="">
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php if(session('userId') != '') { ?>
                        <div class="text-center buy-token-btn pt-3 pb-3">
                            <button class="btn" onclick="approve();" id="approve_button">Swap</button>
                        </div>
                    <?php } else { ?>
                        <div class="text-center buy-token-btn pt-3 pb-3">
                            <button class="btn">Swap</button>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="swap-two pt-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6">
                    <div class="swap-cd-1 text-center">
                        <h2>Swap History</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="table-responsive swap-history-table mt-4 p-3">
                <table class="table table-borderless table-hover text-nowrap" id="swap_history">
                    <thead>
                        <tr>
                            <th class="text-white font-w400">Pair</th>
                            <th class="text-white font-w400">Amount</th>
                            <th class="text-white font-w400"> Transation ID</th>
                            <th class="text-white font-w400">Date & Time </th>
                            <th class="text-white font-w400"> Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('front.layouts.footer')
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
                        <div class="token-list from_currency">
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
                        <div class="token-list to_currency">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<script type="text/javascript" src="{{asset('/').('public/FbGDnwAZEgTX/js/jquery.dataTables.min.js')}}"></script>
<script>
    var swapUrl       = "{{URL::to('/createTransaction')}}";
    var currencyUrl   = "{{URL::to('/getCurrency')}}";
    var imageUrl      = "{{asset('/').('public/IuMzmYaMZE/')}}";
    $(document).ready(function () {
        $('.laptop').click(function () {
            $('.sidenav').toggleClass('fliph');
        });
        $(window).scroll(function () {
            $('.navbarss').toggleClass("navbars", ($(window).scrollTop() >
                10));
        });
        history();
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

    function history() {
        $('#swap_history').DataTable({
            dom: 'lBfrtip',
            "destroy": true,
            "sServerMethod": "GET",
            "processing": true,
            "serverSide": true,
            "aoColumns": [
            { "sClass": "text-gray font-w400" },{ "sClass": "text-gray font-w400" },{ "sClass": "text-gray font-w400" },{ "sClass": "text-gray font-w400" },{ "sClass": "pending-c font-w400" }
            ],
            oLanguage: { "sSearch": "",sProcessing: "<div id='loader'><i style='font-size:30px' class='fa fa-spinner fa-spin fa-pulse'></i></div>",
            sEmptyTable: "No Records Available",
            sSearch: "Search:",
        },
        "ajax": {
            "url": "{{ URL::to('transactionHistory/Swap') }}",
        },
    });
    }
</script>
<script src="{{asset('/').('public/FbGDnwAZEgTX/scripts/swap.js')}}?{{date('Y-m-d h:i:s')}}"></script>
</body>
</html>