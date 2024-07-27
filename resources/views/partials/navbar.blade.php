USER POV


@inject('basketAtViews', 'App\Support\Basket\BasketAtViews')

<!-- Navbar (shop) start -->
<div id="header-wrap">
    <header id="header">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <div class="main-logo">
                        <a id="shop-name" href="{{ route('shop.home') }}">PETZONE</a>
                    </div>
                </div>
                <div class="col-md-10">
                    <nav id="navbar">
                        <div class="main-menu stellarnav">
                            <ul class="menu-list">
                                <li class="menu-item active"><a href="{{ route('shop.home') }}" data-effect="Home">Home</a></li>
                                <li class="menu-item"><a href="{{ route('api.products.index') }}" class="nav-link" data-effect="Shop">Shop</a></li>
                                <li class="menu-item"><a href="{{ route('shop.basket.index') }}" class="nav-link" data-effect="Cart" id="nav-cart">Cart({{ $basketAtViews->countBasket()}})</a></li>
                                <li class="menu-item has-sub">
                                    <a class="nav-link" data-effect="Auth">Auth</a>
                                    @guest
                                        <ul>
                                            <li><a href="{{ route('register') }}">Register</a></li>
                                            <li><a href="{{ route('login') }}">Login</a></li>
                                        </ul>
                                    @endguest
                                    @auth
                                        <ul>
                                            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                                            @csrf
                                                <button type="submit" class="logout-btn">Logout</button>
                                            </form>
                                            <li><a href="{{ route('my-panel') }}">MyPanel</a></li>
                                            <li><a href="{{ route('my-orders') }}" class="nav-link" data-effect="Orders">MyOrders</a></li>
                                        </ul>
                                    @endauth
                                </li>
                                @guest
                                    <li class="menu-item"><a class="nav-link" data-effect="Contact"></a></li>
                                    <li class="menu-item"><a href="#" class="nav-link" data-effect="Contact" id="user-status">Guest</a></li>
                                @endguest
                                @auth

                                                <li class="menu-item"><a class="nav-link" data-effect="Contact"></a></li>

                                                @if(Auth::user()->image_path)
                                                        <img src="{{ asset('storage/' . Auth::user()->image_path) }}" alt="Profile Image" width="50" height="50" class="rounded-circle" style="margin-left: 5px;">
                                                    @else
                                                        <div class="profile-placeholder" style="display: inline-block; margin-left: 1px;"></div>
                                                    @endif
                                                </a>
                                                
                                    <li class="menu-item"><a href="{{ route('my-panel') }}" class="nav-link" data-effect="Contact" id="user-status">{{ Auth::user()->name }}</a>


                                </li>

                                @endauth
                            </ul>
                            <div class="hamburger">
                                <span class="bar"></span>
                                <span class="bar"></span>
                            </div>
                        </div>
                    </nav>
                </div>   
            </div>
        </div>
    </header>
</div>
<!-- Navbar (shop) end -->