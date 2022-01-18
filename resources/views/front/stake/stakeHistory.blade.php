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
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    @include('front.layouts.footer')
</div> 
<!-- connect-wallet -->
<!-- Button trigger modal -->      
<!-- Modal -->
       
<script type="text/javascript" src="{{asset('/').('public/FbGDnwAZEgTX/js/jquery.dataTables.min.js')}}"></script>
<script>

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
</script>
</body>
</html>