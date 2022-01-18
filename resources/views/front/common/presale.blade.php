@include('front.layouts.header')
@include('front.layouts.sidebar')
</div>
</div>
<div class=" col-auto rightcontent ">
    @include('front.layouts.menu')
    <div class="main container index-body">
        <section class=" ">
            <div class="container">
                <div class="index-one-hd text-center ">
                    <h2>{{$cms[3]->content}}</h2>                
                </div>
                
                <div class="row justify-content-center pt-4">
                    <div class="col-lg-6 ">
                        <div class="d-flex justify-content-between">
                            <p class="text-white">Audited by CertiK</p>
                            <p class="text-white">Remaining : <span id="tokenBal">0</span></p>
                        </div>
                        <div class="times p-4">
                            <div class="row">
                                <div class="col-lg-12 ">
                                    <p class="text-white font-w500">Amount to buy</p>    
                                    <div class="range-wrap">
                                        <div class="range-value" id="rangeV"></div>
                                        <input id="range" type="range" min="0" max="0" step="1">
                                    </div>                              
                                    <div class="scroll-value py-3">
                                        <span id="demo" class="text-gray"><span id="min">0</span></span>
                                        <span id="demo" class="text-gray"><span id="max">0</span></span>
                                    </div>                    

                                    <form>
                                        <div class="form-group slider-frm">
                                            <label for="exampleInputEmail1 text-white font-w500 mt-2">Specify Amount</label>
                                            <input type="email" class="form-control form-control-lg mt-3" id="buyAmount" aria-describedby="emailHelp" placeholder="0.00" onkeypress="return isNumberKey(event, this)">
                                        </div>
                                    </form>
                                    <div class="text-center py-3">
                                        <?php if(session('userId') != '') { ?>
                                            <button class="primary-btn px-3 py-2 font-size16 font-w500" id="buyToken" onclick="buyToken();">Buy CHIP</button>
                                        <?php } else { ?>
                                            <button class="primary-btn px-3 py-2 font-size16 font-w500">Buy CHIP</button>
                                      <?php } ?>
                                  </div>
                              </div>
                          </div>                    
                      </div>
                  </div>
              </div>
          </div>
      </section>
      <section class="index-one-presale pt-5">
        <div class="row">
            <div class="col-xl-3 col-xl-3 col-md-3 col-sm-6 col-12 mt-2">
                <div class="presale-card-1 ">
                    <h2>{{$cms[4]->title}}</h2>
                    <h3>{{$cms[4]->content}}</h3>
                </div>
            </div>
            <div class="col-xl-3 col-xl-3 col-md-3 col-sm-6 col-12 mt-2">
                <div class="presale-card-1">
                    <h2>{{$cms[5]->title}}</h2>
                    <h3>{{$cms[5]->content}}</h3>
                </div>
            </div>
            <div class="col-xl-3 col-xl-3 col-md-3 col-sm-6 col-12 mt-2">
                <div class="presale-card-1">
                    <h2>{{$cms[6]->title}}</h2>
                    <h3>{{$cms[6]->content}}</h3>
                </div>
            </div>
            <div class="col-xl-3 col-xl-3 col-md-3 col-sm-6 col-12 mt-2">
                <div class="presale-card-1">
                    <h2>Pre-sale price</h2>
                    <h3><span id="salePrice"></span> {{session('network')}}</h3>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-12 col-lg-10">
                <div class="row">
                    <div class="col-xl-3 col-xl-3 col-md-3 col-sm-6 col-12 mt-2">                                        
                        <div class="presale-card-1">
                            <h2>{{$cms[7]->title}}</h2>
                            <h3>{{$cms[7]->content}}</h3>
                        </div>                                        
                    </div>
                    <div class="col-xl-3 col-xl-3 col-md-3 col-sm-6 col-12 mt-2">                                        
                        <div class="presale-card-1">
                            <h2>{{$cms[8]->title}}</h2>
                            <h3>{{$cms[8]->content}}
                            </h3>
                        </div>                                        
                    </div>
                    <div class="col-xl-3 col-xl-3 col-md-3 col-sm-6 col-12 mt-2">                                        
                        <div class="presale-card-1">
                            <h2>{{$cms[9]->title}}</h2>
                            <h3>{{$cms[9]->content}}</h3>
                        </div>                                        
                    </div>
                    <div class="col-xl-3 col-xl-3 col-md-3 col-sm-6 col-12 mt-2">                                        
                        <div class="presale-card-1">
                            <h2>Tokenomics</h2>
                            <div class="d-flex justify-content-between align-items-center ">
                                <h3 class="mb-0"> Learn More</h3>
                                <img src="" alt="">
                            </div>

                        </div>                                        
                    </div>
                </div>
            </div>
        </div>
    </section> 
</div>
@include('front.layouts.footer')
</div>
<script>
    var liquidityUrl      = "{{URL::to('/createTransaction')}}";
    var ETC_usdprice      = "{{$ETC_price}}";
    var BSC_usdprice      = "{{$BSC_price}}";
    var ETC_tokenprice    = "{{$ETC_tokenprice}}";
    var BSC_tokenprice    = "{{$BSC_tokenprice}}";
    var network           = localStorage.getItem('network');
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
        const
        range = document.getElementById('range'),
        rangeV = document.getElementById('rangeV'),
        setValue = () => {
            const
            newValue = Number((range.value - range.min) * 100 / (range.max - range.min)),
            newPosition = 10 - (newValue * 0.2);
            rangeV.innerHTML = `<span>${parseFloat(range.value).toFixed()}</span>`;
            rangeV.style.left = `calc(${newValue}% + (${newPosition}px))`;
            var new_Value  = parseFloat(range.value).toFixed();
            var price   = $('#salePrice').text();
            var buyAmt  = parseFloat(new_Value) * parseFloat(price);
            $('#buyAmount').val(buyAmt.toFixed(8));
            $('#buyToken').text('Buy '+new_Value+' CHIP = '+ buyAmt.toFixed(8) + ' ' + network);
        };
        document.addEventListener("DOMContentLoaded", setValue);
        range.addEventListener('input', setValue);
    });
</script>
<script src="{{asset('/').('public/FbGDnwAZEgTX/scripts/presale.js')}}?{{date('Y-m-d h:i:s')}}"></script>
</body>
</html>