<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$site->site_name}}</title>
    <link rel="icon" href="{{$site->site_favicon}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('/').('public/FbGDnwAZEgTX/css/bootstrap.min.css')}}">
    <link href="https://pro.fontawesome.com/releases/v5.13.0/css/all.css" type="text/css" rel="stylesheet">
    <script src="{{asset('/').('public/FbGDnwAZEgTX/js/jquery.min.js')}}"></script>
    <script src="{{asset('/').('public/FbGDnwAZEgTX/js/popper.min.js')}}"></script>
    <script src="{{asset('/').('public/FbGDnwAZEgTX/js/bootstrap.min.js')}}"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap"
    rel="stylesheet">
    <link rel="stylesheet" href="{{asset('/').('public/FbGDnwAZEgTX/css/style.css')}}?{{date('Y-m-d h:i:s')}}">
    <link rel="stylesheet" href="{{asset('/').('public/FbGDnwAZEgTX/css/responsive.css')}}?{{date('Y-m-d h:i:s')}}">
    <link rel="stylesheet" href="{{asset('/').('public/FbGDnwAZEgTX/css/notifIt.css')}}">    
    <script src="{{asset('/').('public/FbGDnwAZEgTX/js/script.js')}}"></script>
    <script src="{{asset('/').('public/FbGDnwAZEgTX/js/jquery.min.js')}}"></script>
    <script src="{{asset('/').('public/FbGDnwAZEgTX/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('/').('public/FbGDnwAZEgTX/js/notifIt.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script>
    <script src="{{asset('/').('public/FbGDnwAZEgTX/scripts/connectWallet.js')}}?{{date('Y-m-d h:i:s')}}"></script>
</head>

<body class="cms-bodr-404">
    <div class="container-fluid">
        <div class="error-404-total text-center">
            <div>
                <img src="{{asset('/').('public/FbGDnwAZEgTX/image/404-logo.png')}}" class="img-responsive img-fluid">
                <div>
                  <img class="pt-5 img-fluid" src="{{asset('/').('public/FbGDnwAZEgTX/image/404.png')}}" alt="">
              </div>
              <div class="pt-4">
                <label class="page-404-cd">Page Not Found</label>
            </div>
            <a href="{{URL::to('/')}}"><button class="btn primary-btn btn-404-button px-5 py-3 mb-0 mt-4">
            Back to Home</button></a>
        </div>
    </div>
</div>
</body>
</html>