<header>
    <div class="mainnav">
        <nav class="navbar navbarss navbar-swap-1 navbar-expand-lg ">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <label class="mb-0">
                        <a class="nav-link laptop nav-icon-menu-bar" href="#"><img src="{{asset('/').('public/FbGDnwAZEgTX/image/swap/menu.png')}}" alt="">
                        </a>
                    </label>
                </div>
                <div class="d-flex">
                    <button class="navbar-toggler pr-3" type="button" data-toggle="collapse" data-target="#navbarcollapse" aria-controls="navbarcollapse" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"><i class="fas fa-align-left"></i></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse login " id="navbarcollapse">
                    <ul class="navbar-nav list-one ml-auto align-items-center">
                        <li class="nav-item pr-lg-2 mt-2">
                            <div class="header-select-box-1">
                              <select class="form-control" id="sel1" onchange="chooseNw()">
                                <option value="BSC" <?php echo (session('network') == 'BSC') ? 'selected' : '';?> >BSC</option>
                                <option value="ETC" <?php echo (session('network') == 'ETC') ? 'selected' : '';?> >ETC</option>
                            </select>
                        </div>
                    </li>
                    <li class="nav-item pr-lg-2 mt-2">
                        <?php if(session('userId') == '') { ?>
                            <button type="button" class="connect-wallet-btn-nav" data-toggle="modal"
                            data-target="#connect-wallet">Connect Wallet</button>
                        <?php } else { 
                            $address = session('userName');
                            $addr1 = substr($address, 0, 6);
                            $addr2 = substr($address, 38, 42);
                            $addr = $addr1.'..'.$addr2;
                            ?>
                            <button type="button" class="connect-wallet-btn-nav" data-toggle="modal"
                            data-target="#disconnect-wallet"><span class="metamask_address">{{$addr}}</span></button>
                        <?php } ?>
                    </li>
                    <li class="nav-item d-flex pr-lg-5 mt-2">
                        <a class="nav-link lottery-rs-nav" onclick="myFunction()" href="javascript:;" id="sun"> <img src="{{asset('/').('public/FbGDnwAZEgTX/image/themeicon.png')}}" alt=""></a>
                        <a class="nav-link lottery-rs-nav1" onclick="myFunction()" href="javascript:;" id="moon"> <img src="{{asset('/').('public/FbGDnwAZEgTX/image/stake/moon.png')}}" alt=""></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
</header>