<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
<!--                <li class="menu-title">	<span>Main</span>
                </li>-->
                <li class="{{ Request::is('admin/index_admin') ? 'active' : '' }}">
                    <a href="{{route('dashboard')}}"><i class="feather-home"></i><span>Dashboard</span></a>
                </li>

                <li class="{{ Request::is('admin/roles') ? 'active' : '' }}">
                    <a href="{{route('roles')}}"><i class="feather-layers"></i><span>Roles Management</span></a>
                </li>
                <li class="{{ (Request::is('admin/profile') || Request::is('profile/settings')) ? 'active' : '' }}">
                    <a href="{{route('admin.profile')}}"><i class="fas fa-user-cog"></i><span>Switch Theme</span></a>
                </li>

                <li class="{{ Request::is('admin/site/settings') ? 'active' : '' }}">
                    <a href="{{route('admin.site.settings')}}"><i class="feather-settings"></i><span>Site Settings</span></a>
                </li>




<!--

                <li class="{{ Request::is('admin/mentor') ? 'active' : '' }}">
                    <a href="mentor"><i class="feather-user"></i><span>Mentor</span></a>
                </li>
                <li class="{{ Request::is('admin/booking-list') ? 'active' : '' }}">
                    <a href="booking-list"><i class="feather-list"></i><span>Booking List</span></a>
                </li>
                <li class="{{ Request::is('admin/categories') ? 'active' : '' }}">
                    <a href="categories"><i class="feather-disc"></i><span>Categories</span></a>
                </li>
                <li class="{{ Request::is('admin/transactions-list') ? 'active' : '' }}">
                    <a href="transactions-list"><i class="feather-dollar-sign"></i><span>Transactions</span></a>
                </li>
                <li class="submenu">
                    <a href="#"><i class="feather-book"></i><span> Reports</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a class="{{ Request::is('admin/invoice-report') ? 'active' : '' }}" href="{{ url('admin/invoice-report') }}">Invoice Reports</a></li>
                    </ul>
                </li>
                <li class="menu-title">
                    <span>Pages</span>
                </li>
                <li class="{{ (Request::is('admin/profile') || Request::is('profile-settings')) ? 'active' : '' }}">
                    <a href="profile"><i class="feather-user-plus"></i><span>My Profile</span></a>
                </li>
                <li class="submenu">
                    <a href="#"><i class="feather-book-open"></i><span>Blog</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a class="{{ Request::is('admin/blog') ? 'active' : '' }}" href="{{ url('admin/blog') }}"> Blog </a></li>
                        <li><a class="{{ Request::is('admin/blog-details') ? 'active' : '' }}" href="{{ url('admin/blog-details') }}"> Blog Details </a></li>
                        <li><a class="{{ Request::is('admin/add-blog') ? 'active' : '' }}" href="{{ url('admin/add-blog') }}"> Add Blog </a></li>
                        <li><a class="{{ Request::is('admin/edit-blog') ? 'active' : '' }}" href="{{ url('admin/edit-blog') }}"> Edit Blog </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="feather-lock"></i><span> Authentication </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a class="{{ Request::is('admin/login') ? 'active' : '' }}" href="{{ url('admin/login') }}"> Login </a></li>
                        <li><a class="{{ Request::is('admin/register') ? 'active' : '' }}" href="register"> Register </a></li>
                        <li><a class="{{ Request::is('admin/forgot-password') ? 'active' : '' }}" href="forgot-password"> Forgot Password </a></li>
                        <li class="{{ Request::is('admin/lock-screen') ? 'active' : '' }}" href="lock-screen"> Lock Screen </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="feather-alert-octagon"></i><span> Error Pages </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li class="{{ Request::is('admin/error-404') ? 'active' : '' }}"><a href="error-404">404 Error </a></li>
                        <li class="{{ Request::is('admin/error-500') ? 'active' : '' }}"><a href="error-500">500 Error </a></li>
                    </ul>
                </li>
                <li class="{{ Request::is('admin/blank-page') ? 'active' : '' }}">
                    <a href="blank-page"><i class="feather-file"></i><span>Blank Page</span></a>
                </li>
                <li class="menu-title">
                    <span>UI Interface</span>
                </li>
                <li class="{{ Request::is('admin/components') ? 'active' : '' }}">
                    <a href="components"><i class="feather-layers"></i><span>Components</span></a>
                </li>
                <li class="submenu">
                    <a href="#"><i class="feather-sidebar"></i><span> Forms </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a class="{{ Request::is('admin/form-basic-inputs') ? 'active' : '' }}" href="{{ url('admin/form-basic-inputs') }}">Basic Inputs </a></li>
                        <li><a class="{{ Request::is('admin/form-input-groups') ? 'active' : '' }}" href="{{ url('admin/form-input-groups') }}">Input Groups </a></li>
                        <li><a class="{{ Request::is('admin/form-horizontal') ? 'active' : '' }}" href="{{ url('admin/form-horizontal') }}">Horizontal Form </a></li>
                        <li><a class="{{ Request::is('admin/form-vertical') ? 'active' : '' }}" href="{{ url('admin/form-vertical') }}"> Vertical Form </a></li>
                        <li><a class="{{ Request::is('admin/form-mask') ? 'active' : '' }}" href="{{ url('admin/form-mask') }}"> Form Mask </a></li>
                        <li><a class="{{ Request::is('admin/form-validation') ? 'active' : '' }}" href="{{ url('admin/form-validation') }}"> Form Validation </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="feather-layout"></i><span> Tables </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a class="{{ Request::is('admin/tables-basic') ? 'active' : '' }}" href="{{ url('admin/tables-basic') }}">Basic Tables </a></li>
                        <li><a class="{{ Request::is('admin/data-tables') ? 'active' : '' }}" href="{{ url('admin/data-tables') }}">Data Table </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><i class="feather-align-left"></i><span>Multi Level</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li class="submenu">
                            <a href="javascript:void(0);"> <span>Level 1</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="javascript:void(0);"><span>Level 2</span></a></li>
                                <li class="submenu">
                                    <a href="javascript:void(0);"> <span> Level 2</span> <span class="menu-arrow"></span></a>
                                    <ul style="display: none;">
                                        <li><a href="javascript:void(0);">Level 3</a></li>
                                        <li><a href="javascript:void(0);">Level 3</a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0);"> <span>Level 2</span></a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0);"> <span>Level 1</span></a>
                        </li>
                    </ul>
                </li>-->
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
