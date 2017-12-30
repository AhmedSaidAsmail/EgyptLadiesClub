<!DOCTYPE html>
<html>
    <head>
        <title>Egypt Ladies Club</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        @yield('styles')
    </head>
    <body>

        <div class="menu-container">
            <ul>
                <li><a href="">Home</a></li>
                <li><a href="">Contact Us</a></li>
                <li><a href="">My Account</a></li>
                <li><a href="">Computers and Networking
                        <span class="pull-right-container">
                            <i class="fa fa-angle-down pull-right"></i>
                        </span>
                    </a></li>
            </ul>
        </div>
        <div class="body-container">
            <div class="body-shdow"></div>
            <div class="first-nav-conatiner">
                <div class="row top-nav">
                    <div class="container">
                        <ul class="list-inline top-nav-list">
                            <li><a href="#"><i class="fa fa-ambulance" aria-hidden="true"></i> <label> Free shipping</label></a></li>
                            <li><a href="#"><i class="fa fa-refresh" aria-hidden="true"></i> Free Returns</a></li>
                            <li><a href="#"><i class="fa fa-usd" aria-hidden="true"></i> Cash on Delivery</a></li>
                            <li class="float-right arabic"><a href="">العربية <img src="images/eg.gif" class="lanaguge-flag" alt="arabic"></a></li>
                        </ul>

                    </div>
                </div>
                <div class="row second-nav">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="menu-logo-container">
                                    <div class="menu-ord">
                                        <div class="hamburger"></div>
                                    </div>
                                    <div class="header-logo">

                                    </div>
                                </div>

                            </div>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="What are you looking for?">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button"><i class="fa fa-search fa-lg"></i></button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <ul class="list-inline second-nav-list text-right">
                                    <li class="login-in"><a href="#">Hello.Log In <i class="fa fa-caret-down"></i></a></li>
                                    <li class="cart"><a href="#"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i> Cart</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-nav row">
                    <div class="container">
                        <ul class="list-inline">
                            <li><a href="">All Categories</a></li>
                            <li><a href=""><span>Ladies Club</span> Fashion</a></li>
                            <li><a href="">Mobile & Tablets</a></li>
                            <li><a href="">Home & Appliances</a></li>
                            <li><a href="">Healthy & Beauty</a></li>
                            <li><a href="">Laptops & Electronices</a></li>
                            <li><a href="">Babies & Toys</a></li>
                            <li><a href="">Brands Store</a></li>
                        </ul>   
                    </div>
                </div>
            </div>

            <div class="second-nav-conatiner"> 
                @yield('cursor')
                <div class="container">
                    <!-- container -->
                    @yield('container')
                    <!-- container -->
                </div>

            </div>
        </div>

        <script type="text/javascript" src="{{asset('js/jquery-2.2.3.min.js')}}"></script>
        <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="{{asset('js/js.min.js')}}"></script>
        @yield('scripts')
    </body>
</html>
