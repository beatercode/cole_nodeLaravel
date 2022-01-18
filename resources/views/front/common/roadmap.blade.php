@include('front.layouts.header')
@include('front.layouts.sidebar')
</div>
</div>
<div class=" col-auto rightcontent ">
    @include('front.layouts.menu')
    <div class="main container index-body">
        <div class="pt-3 pb-3">
            <div class="index-one-hd text-center pt-5">
                <h2>Road Map</h2>                            
            </div>
        </div>
        <div class="road-map">                        
            <section class="ps-timeline-sec">
                <div class="container">
                    <ol class="ps-timeline">
                        <?php $i=1; 
                        foreach ($roadmap as $value) { 
                            $divCls = ($i % 2 == 0) ? 'ps-top' : 'ps-bot';
                            $spanCls = ($i % 2 == 0) ? 'ps-sp-bot' : 'ps-sp-top';
                            ?>
                            <li>
                                <div class="{{$divCls}}">
                                    <h2 class="pb-2">{{$value->title}}</h2>
                                    <p>{{$value->description}}</p>
                                </div>
                                <span class="{{$spanCls}}"></span>
                            </li>
                            <?php $i++; } ?>
                        </ol>
                    </div>
                </section>
            </div>
        </div>
        @include('front.layouts.footer')
    </div>
</div>
<script>
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
</script>
<script src="{{asset('/').('public/FbGDnwAZEgTX/scripts/changeNetwork.js')}}?{{date('Y-m-d h:i:s')}}"></script>
</body>
</html>