@include('front.layouts.header')
@include('front.layouts.sidebar')
</div>
</div>
<div class=" col-auto rightcontent ">
    @include('front.layouts.menu')
    <div class="main container index-body">                        
        <section class="index-one pt-5">
            <div class="container">
                <div class="index-one-hd text-center pt-5">
                    <h2>{{strip_tags($cms->content)}}</h2>
                    <h3>Chipit Presale Feature Time Start On : </h3>
                </div>
                <div class="row justify-content-center pt-4" id="timer_div">
                    <div class="col-12 col-lg-6 col-md-8 ">
                        <div class="times">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6">
                                    <div class="days  text-center ">
                                        <h4>Days</h4>
                                        <label id="dayss" class="active"></label>
                                        <p>:</p>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6">
                                    <div class=" days text-center ">
                                        <h4>Hours</h4>
                                        <label id="hours"></label>

                                        <p class="d-sm-none index-1-time d-lg-flex">:</p>

                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6">
                                    <div class=" days text-center ">
                                        <h4>Minutes</h4>
                                        <label id="minutes"></label>
                                        <p>:</p>


                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6">
                                    <div class=" days text-center ">
                                        <h4>Seconds</h4>
                                        <label id="seconds"></label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="text-center buy-token-btn pt-4 pb-3" id="buy_div">
                    <a href="{{URL::to('/presale')}}"><button class="btn">Buy Token</button></a>
                </div>
            </div>
        </section>

    </div>
    @include('front.layouts.footer')
</div>
<script>
    var chnw = "<?php echo session('network');?>";
    $(document).ready(function () {
        const second = 1000,
        minute = second * 60,
        hour = minute * 60,
        day = hour * 24;

        let birthday = "<?php echo $start_time;?>";
        let start_time = new Date(birthday).getTime();
        let today = new Date().getTime();
        if(start_time > today) {
            countDown = new Date(birthday).getTime(),
            x = setInterval(function () {
                let now = new Date().getTime(),
                distance = countDown - now;

                document.getElementById("dayss").innerText = Math.floor(distance / (day)),
                document.getElementById("hours").innerText = Math.floor((distance % (day)) / (hour)),
                document.getElementById("minutes").innerText = Math.floor((distance % (hour)) / (minute)),
                document.getElementById("seconds").innerText = Math.floor((distance % (minute)) / second);
            }, 0);
            $('#buy_div').css('display', 'none');
        } else {
            $('#timer_div').css('display', 'none');
        }
    })

    $(document).ready(function () {
        $('.laptop').click(function () {
            $('.sidenav').toggleClass('fliph');
        });
    }); 

    $(document).ready(function () {
        $('.laptop').click(function () {
            $('.rightcontent').toggleClass('fliph');
        });
    }); 

    $(document).ready(function () {
        $('.laptop').click(function () {
            $('.navbarss').toggleClass('fliph');
        });
    });

    $(document).ready(function () {
        if(chnw == '') {
            chooseNw('BSC');
        }
    });
</script>
<script src="{{asset('/').('public/FbGDnwAZEgTX/scripts/changeNetwork.js')}}?{{date('Y-m-d h:i:s')}}"></script>
</body>
</html>