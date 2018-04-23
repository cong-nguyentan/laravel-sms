<aside class="left-side sidebar-offcanvas">
    <section class="sidebar ">
        <div class="page-sidebar  sidebar-nav">
            <div class="nav_icons">
                <ul class="sidebar_threeicons">
                    <li>
                        <a href="advanced_tables.html">
                            <i class="livicon" data-name="table" title="Advanced tables" data-c="#418BCA" data-hc="#418BCA" data-size="25" data-loop="true"></i>
                        </a>
                    </li>
                    <li>
                        <a href="tasks.html">
                            <i class="livicon" data-c="#EF6F6C" title="Tasks" data-hc="#EF6F6C" data-name="list-ul" data-size="25" data-loop="true"></i>
                        </a>
                    </li>
                    <li>
                        <a href="gallery.html">
                            <i class="livicon" data-name="image" title="Gallery" data-c="#F89A14" data-hc="#F89A14" data-size="25" data-loop="true"></i>
                        </a>
                    </li>
                    <li>
                        <a href="users_list.html">
                            <i class="livicon" data-name="users" title="Users List" data-size="25" data-c="#01bc8c" data-hc="#01bc8c" data-loop="true"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
            <!-- BEGIN SIDEBAR MENU -->
            <ul id="menu" class="page-sidebar-menu">
            @if (!empty($currentUser))
                @if ($currentUser->checkIsSuperAdmin())
                    @foreach ($backendSuperAdminMenu as $mainMenu)
                    <li class="@if ($aclObj->checkQueryingControllerAction($mainMenu['controller'], $mainMenu['action'])) active  @endif">
                        <a href="{{ action($mainMenu['controller'] . '@' . $mainMenu['action']) }}">
                            <i class="livicon" data-c="#EF6F6C" data-hc="#EF6F6C" data-name="list-ul" data-size="18" data-loop="true"></i>
                            <span class="title">{{ $mainMenu['name'] }}</span>
                            @if (!empty($mainMenu['childs']))
                            <span class="fa arrow"></span>
                            @endif
                        </a>
                        <ul class="sub-menu">
                            <li class="@if ($aclObj->checkQueryingControllerAction($mainMenu['controller'], $mainMenu['action'])) active  @endif">
                                <a href="{{ action($mainMenu['controller'] . '@' . $mainMenu['action']) }}">
                                    <i class="fa fa-angle-double-right"></i> {{ $mainMenu['name'] }}
                                </a>
                            </li>
                        @if (!empty($mainMenu['childs']))
                            @foreach ($mainMenu['childs'] as $childMenu)
                            <li class="@if ($aclObj->checkQueryingControllerAction($childMenu['controller'], $childMenu['action'])) active  @endif">
                                <a href="{{ action($childMenu['controller'] . '@' . $childMenu['action']) }}">
                                    <i class="fa fa-angle-double-right"></i> {{ $childMenu['name'] }}
                                </a>
                            </li>
                            @endforeach
                        @endif
                        </ul>
                    </li>
                    @endforeach
                @endif
                    @foreach ($backendUserMenu as $mainMenu)
                    <li class="@if ($aclObj->checkQueryingControllerAction($mainMenu['controller'], $mainMenu['action'])) active  @endif">
                        <a href="{{ action($mainMenu['controller'] . '@' . $mainMenu['action']) }}">
                            @if ($mainMenu['controller'] == 'UsersController')
                            <i class="livicon" data-name="users" data-size="18" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>
                            @else
                            <i class="livicon" data-c="#EF6F6C" data-hc="#EF6F6C" data-name="list-ul" data-size="18" data-loop="true"></i>
                            @endif
                            <span class="title">{{ $mainMenu['name'] }}</span>
                            @if (!empty($mainMenu['childs']))
                            <span class="fa arrow"></span>
                            @endif
                        </a>
                        <ul class="sub-menu">
                            <li class="@if ($aclObj->checkQueryingControllerAction($mainMenu['controller'], $mainMenu['action'])) active  @endif">
                                <a href="{{ action($mainMenu['controller'] . '@' . $mainMenu['action']) }}">
                                    <i class="fa fa-angle-double-right"></i> {{ $mainMenu['name'] }}
                                </a>
                            </li>
                        @if (!empty($mainMenu['childs']))
                            @foreach ($mainMenu['childs'] as $childMenu)
                            <li class="@if ($aclObj->checkQueryingControllerAction($childMenu['controller'], $childMenu['action'])) active  @endif">
                                <a href="{{ action($childMenu['controller'] . '@' . $childMenu['action']) }}">
                                    <i class="fa fa-angle-double-right"></i> {{ $childMenu['name'] }}
                                </a>
                            </li>
                            @endforeach
                        @endif
                        </ul>
                    </li>
                    @endforeach
            @endif
            </ul>
            <!-- END SIDEBAR MENU -->
        </div>
    </section>
    <!-- /.sidebar -->
</aside>