<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header">MENU</li>
            <li><a href="{{ route('admin_dashboard') }}"><i class="fa fa-home"></i><span>Home</span></a></li>
            <li><a href="{{ route('home') }}"><i class="fa fa-rocket"></i> Go To Front End</a></li>
            @if(Auth::user()->isAdmin == 2)
                <li class="treeview">
                    <a href="#"><i class="fa fa-cogs"></i> <span> Settings</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('adminGeneralSettings') }}">General</a></li>
                        <li><a href="{{ route('adminMediaSettings') }}">Media</a></li>
                        <li><a href="{{ route('adminUsersSettings') }}" >Users</a></li>
                        <!--<li><a href="{{ route('adminSecuritySettings') }}" >Security</a></li>-->
                        <li><a href="{{ route('adminLangSettings') }}" >Language</a></li>
                        <li><a href="{{ route('adminEmailSettings') }}" >E-mail</a></li>
                        <li><a href="{{ route('adminSlideshowSettings') }}" >Featured Slideshow</a></li>
                        <li><a href="{{ route('adminSiteImagesSettings') }}" >Site Images</a></li>
                        <li><a href="{{ route('adminCommentSettings') }}" >Comments</a></li>
                        <li><a href="{{ route('adminWidgetSettings') }}" >Widget</a></li>
                    </ul>
                </li>
            @endif
            <li><a href="{{ route('adminManageMedia') }}"><i class="fa fa-camera"></i><span>Manage Media</span></a></li>
            @if(Auth::user()->isAdmin == 2)<li><a href="{{ route('adminManageUsers') }}"><i class="fa fa-users"></i><span>Manage Users</span></a></li>@endif
            <li><a href="{{ route('adminCategories') }}"><i class="fa fa-archive"></i><span>Manage Categories</span></a></li>
            <li><a href="{{ route('adminMemes') }}"><i class="fa fa-smile-o"></i><span>Manage Memes</span></a></li>
            @if(Auth::user()->isAdmin == 2)<li><a href="{{ route('adminPages') }}"><i class="fa fa-map-signs"></i> <span>Manage Pages</span></a></li>@endif
            <li><a href="{{ route('adminBadges') }}"><i class="fa fa-shield"></i> <span>Manage Badges</span></a></li>
        </ul><!-- /.sidebar-menu -->
    </section>
</aside>