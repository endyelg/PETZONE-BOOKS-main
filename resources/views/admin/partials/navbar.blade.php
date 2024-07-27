<!-- Navbar (admin) start -->

<div class="page-container">
        <div class="sidebar-menu">
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            <li class="for-li">
                                <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-users"></i><span>User Management</span></a>
                                <ul class="collapse">
                                    <li><a href="{{ route('admin.users.all') }}">List</a></li>
                                    <li><a href="{{ route('admin.users.create') }}">Add</a></li>
                                </ul>
                            </li>
                            <li class="for-li">
                                <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-cube"></i><span>Product Management</span></a>
                                <ul class="collapse">
                                    <li><a href="{{ route('admin.products.all')}}">List</a></li>
                                    <li><a href="{{ route('admin.products.create')}}">Add</a></li>
                                </ul>
                            </li>
                            <li class="for-li">
                                <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-users"></i><span>Supplier Management</span></a>
                                <ul class="collapse">
                                    <li><a href="{{ route('admin.suppliers.all') }}">List</a></li>
                                    <li><a href="{{ route('admin.suppliers.create') }}">Add</a></li>
                                </ul>
                            </li>
                            <li class="for-li">
                                <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-dollar"></i><span>Expenses Management</span></a>
                                <ul class="collapse">
                                    <li><a href="{{ route('admin.expenses.all') }}">List</a></li>
                                    <li><a href="{{ route('admin.expenses.create') }}">Add</a></li>
                                </ul>
                            </li>
                            <li class="for-li"><a href="{{ route('admin.categories.index') }}"><i class="fa fa-shopping-basket"></i> <span>Order Management</span></a></li>
                            <li class="for-li">
                                <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-area-chart"></i><span>Charts</span></a>
                                <ul class="collapse">
                                   <li><a href="{{ route('admin.charts.pie') }}"><i class="fa fa-pie-chart" aria-hidden="true"></i> <span>Pie Chart</span></a></li>
                                   <li><a href="{{ route('admin.charts.bar') }}"><i class="fa fa-bar-chart" aria-hidden="true"></i></i></i> <span>Bar Chart</span></a></li>
                                   <li><a href="{{ route('admin.charts.line') }}"><i class="fa fa-line-chart" aria-hidden="true"></i></i> <span>Line Chart</span></a></li>
                                </ul>
                            </li>
                            <li class="for-li"><a href="{{ route('admin.categories.index') }}"><i class="fa fa-object-group"></i> <span>Categories</span></a></li>
                    </nav>
                </div>
            </div>
        </div>
            <div class="header-area">
                <div class="row align-items-center">
                    <div class="col-md-6 col-sm-8 clearfix">
                        {{-- <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div> --}}
                    </div>
                </div>
            </div>
<!-- Navbar (admin) end -->