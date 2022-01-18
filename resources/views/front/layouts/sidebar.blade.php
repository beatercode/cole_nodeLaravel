<?php $uri = Request::segment(1);?>

<nav class="navbar navbar-nav-1 side-menu-container " role="navigation">
    <ul class="nav navbar-nav sidenav-1">
     <?php if(session('network') == 'ETC') { ?>
         <li class="navicon <?php echo ($uri == 'liquidity') ? "active" : ""; ?>" id="liquidity_li">
            <a href="{{URL::to('/liquidity')}}" class="d-flex"><img src="{{asset('/').('public/FbGDnwAZEgTX/image/swap/box.png')}}" alt=""><span class="setting">Liquidity</span></a>
        </li>
        <li class="navicon <?php echo ($uri == 'swap') ? "active" : ""; ?>">
            <a href="{{URL::to('/swap')}}" class="d-flex"><img src="{{asset('/').('public/FbGDnwAZEgTX/image/swap/box2.png')}}" alt=""><span class="setting">Swap</span></a>
        </li>
    <?php } else { ?>
        <li class="navicon <?php echo ($uri == 'swap') ? "active" : ""; ?>">
            <a href="https://pancakeswap.finance/swap" class="d-flex" target="_blank"><img src="{{asset('/').('public/FbGDnwAZEgTX/image/swap/box2.png')}}" alt=""><span class="setting">Swap</span></a>
        </li>
    <?php } ?>
    <li class="navicon <?php echo ($uri == 'staking') ? "active" : ""; ?>">
        <a href="{{URL::to('/staking')}}" class="d-flex"><img src="{{asset('/').('public/FbGDnwAZEgTX/image/swap/airplay.png')}}" alt=""><span class="setting">Staking</span></a>
    </li>
    <li class="navicon <?php echo ($uri == 'presale') ? "active" : ""; ?>">
        <a href="{{URL::to('/presale')}}" class="d-flex"><img src="{{asset('/').('public/FbGDnwAZEgTX/image/swap/pocket.png')}}" alt=""><span class="setting">Presale</span></a>
    </li>
    <li class="navicon <?php echo ($uri == 'roadmap') ? "active" : ""; ?>">
        <a href="{{URL::to('/roadmap')}}" class="d-flex"><img src="{{asset('/').('public/FbGDnwAZEgTX/image/swap/map-pin.png')}}" alt=""><span class="setting">Roadmap</span></a>
    </li>
</ul>
<ul class="nav navbar-nav  side-nav-content-value1">
    <li class="active navicon d-flex flex-wrap ">
        <a href="https://www.coingecko.com" target="_blank" class="d-flex align-items-center justify-content-center icon-semi-1 text-center ">
            <div class="side-nav-content-icon2 spn side-nav-content-icontg"><img src="{{asset('/').('public/FbGDnwAZEgTX/image/coingecko.png')}}" alt=""></div>
        </a>  
        <a href="https://coinmarketcap.com" target="_blank" class="d-flex align-items-center justify-content-center icon-semi-1 text-center ">
            <div class="side-nav-content-icon2 spn side-nav-content-icontg"><img src="{{asset('/').('public/FbGDnwAZEgTX/image/coinmarketcap.png')}}" alt=""></div>
        </a> 
        <a href="https://www.certik.com" target="_blank" class="d-flex align-items-center justify-content-center icon-semi-2 text-center ">
            <div class="side-nav-content-icon2 spn side-nav-content-icontg"><img src="{{asset('/').('public/FbGDnwAZEgTX/image/certik1.png')}}" alt=""></div>
        </a> 
        <a href="https://www.certik.com" target="_blank" class="d-flex align-items-center justify-content-center icon-semi-1 text-center icon-hide ">
            <div class="side-nav-content-icon2 side-nav-content-icontg"><img src="{{asset('/').('public/FbGDnwAZEgTX/image/certik.png')}}" alt=""></div>
        </a> 
    </li>
    <li class="active navicon d-flex flex-wrap justify-content-between">
        <a href="{{$site->twitter_url}}" target="_blank" class="d-flex align-items-center justify-content-center text-center ">
            <div class="side-nav-content-icon2 side-nav-content-icontg"><img src="{{asset('/').('public/FbGDnwAZEgTX/image/swap/Twitter.png')}}" alt=""></div>
        </a>
        <a href="{{$site->tele_url}}" target="_blank" class="d-flex align-items-center justify-content-center text-center ">
            <div class="side-nav-content-icon2 side-nav-content-icontg"><img src="{{asset('/').('public/FbGDnwAZEgTX/image/swap/telegram.png')}}" alt=""></div>
        </a>
        <a href="{{$site->medium_url}}" target="_blank" class="d-flex align-items-center justify-content-center text-center ">
            <div class="side-nav-content-icon2 side-nav-content-icontg"><img src="{{asset('/').('public/FbGDnwAZEgTX/image/swap/medium.png')}}" alt=""></div>
        </a>
    </li>
    <li class="text-center py-3">
        @if(session('network') == 'ETC')
        <a href="https://rinkeby.etherscan.io/address/0x64508bB9123C4f7C7C7E701d9b89744036de123F" target="_blank" class="bottom-txt">Contract</a>
        @else
        <a href="https://testnet.bscscan.com/address/0x884E33f72D627bae269a6c3f27E4bc5A6e437dFd" target="_blank" class="bottom-txt">Contract</a>
        @endif
    </li>
</ul>
</nav>