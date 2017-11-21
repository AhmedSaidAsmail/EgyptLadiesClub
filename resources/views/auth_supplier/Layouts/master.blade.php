<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Supplier Administration</title>
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="{{asset('css/register-area.css')}}">
    </head>
    <body>
        @if(session('confirmMail'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p>{{session('confirmMail')}}</p>
        </div>
        @endif
        <div class="row text-right main-header-holder">
            <div class="container">
                <a href="{{route('home')}}"><div class="main-nav-logo"></div></a>
                <span class="heder-labels">Vendors Administration</span>
                <ul class="list-inline top-header black-almost">
                    <li><a href="{{route('supplier.index')}}"><i class="fa fa-bars"></i> Overview
                        </a></li>
                    <li>
                        <a href="{{route('supplier.login')}}"><i class="fa fa-user"></i> Login</a>
                    </li>
                    <li>
                        <a href="{{route('supplier.reigister')}}"><i class="fa fa-user"></i> Register</a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="row supplier-body">
            <div class="container">
                @yield('container')
            </div>
        </div>




        <div class="row text-center footer-rights">© 2017 A2ZTravelMarket.com All Rights Reserved</div>

        <script type="text/javascript" src="http://localhost/A2ZTravelMarketNew.com/public/js/jquery-2.2.3.min.js"></script>
        <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="http://localhost/A2ZTravelMarketNew.com/public/js/min.js"></script>
    </body>
</html>
