@include('front.layouts.header')
@include('front.layouts.sidebar')
</div>
</div>
<div class=" col-auto rightcontent ">
    @include('front.layouts.menu')
    <div class="main container">        
        <div class="swap-cd-1">
            <h2>Stake</h2>                       
        </div>             
        <div class=" farm-tabs d-flex align-items-center flex-wrap justify-content-between">
            <div class=" mb-2 farm-tabs d-flex align-items-center flex-wrap">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active font-w400 font-size16" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Live</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white font-w400 font-size16" id="profile-tab" data-toggle="tab"  href="#profile" role="tab" aria-controls="profile" aria-selected="false">Finished</a>
                    </li>
                </ul>
                <ul class="list-unstyled">
                    <li class="mt-3 mx-3 font-size16 text-white">Stake only</li>
                </ul>
                <ul class="list-unstyled">
                    <li class="mt-3 mx-3 stake-switch">
                        <label class="switch">
                            <input type="checkbox">
                            <span class="slider round"></span>
                        </label>
                    </li>
                </ul>
                <ul class="list-unstyled d-flex mt-3 mx-3 farm-icon">
                    <li>
                        <img src="{{asset('/').('public/FbGDnwAZEgTX/image/stake/grid.png')}}" alt="">
                    </li>
                    <li class="mx-3">
                        <img src="{{asset('/').('public/FbGDnwAZEgTX/image/stake/set.png')}}" alt="">
                    </li>
                </ul>
            </div>

            <div class="input-group search-stake w-25 mb-3">
                <input type="text" class="form-control" id="filter" placeholder="Search Farms" aria-label="Recipient's username" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-search"></i></span>
                </div>
            </div>
        </div>
        <div>
            <div class="tab-content " id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="swap-three">
                        <div class="row justify-content-center" id="results">
                            <?php if(count($pairs) > 0) { foreach($pairs as $value) { 
                             $from_image = URL::to('public/IuMzmYaMZE/'.$value->from_image);
                             $to_image = URL::to('public/IuMzmYaMZE/'.$value->to_image);
                             ?>
                             <div class="col-lg-4 col-md-6 my-2 results" id="pair_view_{{$value->pair_address}}">
                                <div class="swap-cd1-1 p-3">                                              
                                    <div class="text-center">
                                        <div class="icon-stake">
                                            <img class="imgCls-1" src="{{$from_image}}" alt="">
                                            <img class="imgCls-1" src="{{$to_image}}" alt="">
                                        </div>
                                        <h5 class="text-white my-3 font-w500">{{$value->pair}}</h5>
                                        <h5 class="text-white my-3 font-w500" style="display:none">{{strtolower($value->pair)}} {{strtoupper($value->pair)}}</h5>
                                    </div>
                                    <div class="px-2 stake-inner-border pt-3 pb-2">
                                        <div class="d-flex justify-content-between">
                                            <p class="font-size15 mb-0 text-white">Earn</p>
                                            <p class="font-size15 mb-0 text-gray">Joint</p>
                                        </div>
                                    </div>
                                    <div class="text-center py-2">
                                        <p class="font-size15 font-w400 text-white">Joint Earned</p>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control form-control-lg" id="pending_amt_{{$value->pair_address}}" readonly>
                                        <input type="hidden" class="form-control form-control-lg" id="deposit_amt_{{$value->pair_address}}" readonly>
                                        <input type="hidden" class="form-control form-control-lg" id="pairBal_{{$value->pair_address}}">
                                        <?php if(session('userId') != '') { ?>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">
                                                    <button class="primary-btn text-black font-size14 font-w400 px-3 py-2" id="harvest_{{$value->pair_address}}" onclick="harvest('{{$value->pair_address}}', '{{$value->pair}}');" disabled>Harvest</button>
                                                </span>
                                            </div>
                                        <?php } else { ?>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">
                                                    <button class="primary-btn text-black font-size14 font-w400 px-3 py-2" disabled>Harvest</button>
                                                </span>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="text-center py-2">
                                        <p class="font-size15 font-w400 text-white">Joint - BTC LP STAKED</p>
                                    </div>
                                    <div class="text-center">
                                        <?php if(session('userId') != '' && $value->status == 1) { ?>
                                            <button class="primary-btn my-2 text-black px-4 py-3" data-toggle="modal" data-target="#exampleModal1" id="dep_but_{{$value->pair_address}}" onclick="getPair('{{$value->pair_address}}', '{{$value->pair}}', '{{$value->from_address}}', '{{$value->to_address}}')">Deposit</button>
                                            <button class="primary-btn my-2 text-black px-4 py-3" data-toggle="modal" data-target="#exampleModal2" id="with_but_{{$value->pair_address}}" onclick="getPair('{{$value->pair_address}}', '{{$value->pair}}', '{{$value->from_address}}', '{{$value->to_address}}')">Withdraw</button>
                                        <?php } elseif($value->status == 1) { ?>
                                            <button class="primary-btn my-2 text-black px-4 py-3">Deposit</button>
                                            <button class="primary-btn my-2 text-black px-4 py-3">Withdraw</button>
                                        <?php } else { ?>
                                            <button class="primary-btn my-2 text-black px-4 py-3">Live Soon</button>
                                        <?php } ?>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center my-3">
                                        <div class="farm-bg px-3 py-1">
                                            <p class="mb-0"> <img src="{{asset('/').('public/FbGDnwAZEgTX/image/stake/check-circle .png')}}" class="pr-2 tick" alt=""> Core</p>
                                        </div>
                                        <div data-toggle="collapse" class="accordion" href="#collapseExample_{{$value->pair_address}}" role="button" aria-expanded="false" aria-controls="collapseExample_{{$value->pair_address}}">
                                            <p class="text-green mb-0 font-w400">Details <i class="fas fa-chevron-down ont-w400"></i></p>
                                        </div>
                                    </div>
                                    <div class="collapse" id="collapseExample_{{$value->pair_address}}">
                                        <div class="card card-body">                                                      
                                            <div class="">
                                                <div class="d-flex justify-content-between">
                                                    <p class="font-size16 font-w400 text-white">Total Staked</p>
                                                    <p class="font-size16 font-w400  mb-0  text-gray"><span id="total_staked_{{$value->pair_address}}">0</span></p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-end pt-3 collapse-details">
                                                    <div>
                                                        <a href="https://rinkeby.etherscan.io/address/{{$value->pair_address}}" target="_blank" class="text-green font-size14">View Contract</a>                                                                       
                                                    </div>
                                                    <div class="ml-2">
                                                        <a href="https://rinkeby.etherscan.io/address/0x64508bB9123C4f7C7C7E701d9b89744036de123F" class="text-green font-size14 ml-3" target="_blank">See Token Info</a>    <br>
                                                        <a href="#" class="text-green font-size14">View Project Site</a>
                                                    </div>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } } else { ?>
                            <p class="emty-pool">No pool</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="swap-two pt-5">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-6">
                            <div class="swap-cd-1 text-center">
                                <h2>Stake History</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="table-responsive swap-history-table mt-4 p-3">
                        <table class="table table-borderless table-hover text-nowrap" id="stake_history">
                            <thead>
                                <tr>
                                    <th class="text-white font-w400">Pair</th>
                                    <th class="text-white font-w400">Amount</th>
                                    <th class="text-white font-w400"> Transation ID</th>
                                    <th class="text-white font-w400">Date & Time </th>
                                    <th class="text-white font-w400"> Status</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>

    </div>
</div>
@include('front.layouts.footer')
</div>
<div class="pop-up">
    <!-- Modal -->
    <span id="fromAddress" style="display: none;"></span>
    <span id="toAddress" style="display: none;"></span>
    <span id="pairAddress" style="display: none;"></span>
    <span id="poolId" style="display: none;"></span>
    <span id="pairSymbol" style="display: none;"></span>

    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-ind swap-cd1-modal swap-cd1-modal-2 " role="document">
            <div class="modal-content modal-content-connect-wallect add-ticket">
                <div class="modal-header">
                    <h5 class="modal-title">Deposit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="{{asset('/').('public/FbGDnwAZEgTX/image/close.png')}}"></button>
                </div>
                <div class="modal-body model-body-connect-wallet model-body-connect-wallet-4">
                    <div class="resent-popup-1 resent-popup-2">
                        <h3 class="d-flex justify-content-between align-items-center"> <span class="h2-span-cd-popup"><span class="pair_Symbol"></span> <span class="pl-1">Balance :</span> </span> <span id="pairBalance"></span></h3>
                        <div class="input-group pop-input-3 mb-3">                                        
                            <input type="text" class="form-control form-control-lg" placeholder="0.00" id="dep_amt" onkeypress="return isNumberKey(event, this)">
                        </div>
                        <div class="input-group-append">
                            <button class="primary-btn text-black font-size14 font-w400 px-3 py-2" id="approve_button" onclick="approveDeposit();">Approve</button>
                            <button class="primary-btn text-black font-size14 font-w400 px-3 py-2" id="deposit_button" onclick="deposit();" style="display:none;">Deposit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-ind swap-cd1-modal swap-cd1-modal-2 " role="document">
            <div class="modal-content modal-content-connect-wallect add-ticket">
                <div class="modal-header">
                    <h5 class="modal-title">Withdraw</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="{{asset('/').('public/FbGDnwAZEgTX/image/close.png')}}"></button>
                </div>
                <div class="modal-body model-body-connect-wallet model-body-connect-wallet-4">
                    <div class="resent-popup-1 resent-popup-2">
                        <h3 class="d-flex justify-content-between align-items-center"> <span class="h2-span-cd-popup"><span class="pair_Symbol"></span> <span class="pl-1">Balance :</span> </span> <span id="withBalance"></span></h3>
                        <div class="input-group pop-input-3 mb-3">                                        
                            <input type="text" class="form-control form-control-lg" placeholder="0.00" id="with_amt" onkeypress="return isNumberKey(event, this)">
                        </div>
                        <div class="input-group-append">
                            <button class="primary-btn text-black font-size14 font-w400 px-3 py-2" id="withdraw_button" onclick="withdraw();">Withdraw</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
<script type="text/javascript" src="{{asset('/').('public/FbGDnwAZEgTX/js/jquery.dataTables.min.js')}}"></script>
<script>

    var stakingUrl    = "{{URL::to('/createTransaction')}}";
    var pairs         = '<?php echo json_encode($pairs); ?>';
    var userId         = '<?php echo (session('userId') != '') ? encrypText(session('userId')) : 0; ?>';
    $(document).ready(function () {
        $('.laptop').click(function () {
            $('.sidenav').toggleClass('fliph');
        });
        $(window).scroll(function () {
            $('.navbarss').toggleClass("navbars", ($(window).scrollTop() >
                10));
        });
        if(userId != 0) {
            history();
        } else {
            $('#tbody').html("<div>No Records Available</div>");
        }
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

    function history() {
        $('#stake_history').DataTable({
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
            "url": "{{ URL::to('transactionHistory/Deposit') }}",
        },
    });
    }

    $('#filter').keyup(function(){
        $('.results').hide();
        var txt = $('#filter').val();
        if(txt == '') {
            $('.results').show();
        } else {
            $('.results:contains("'+txt+'")').show();
        }
    });
</script>
<script src="{{asset('/').('public/FbGDnwAZEgTX/scripts/stake.js')}}?{{date('Y-m-d h:i:s')}}"></script>
</body>
</html>