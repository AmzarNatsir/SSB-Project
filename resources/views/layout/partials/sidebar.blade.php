    <!-- Search Modal -->
    <div class="modal fade" id="searchModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-transparent">
                <div class="card shadow-none mb-0">
                    <div class="px-3 py-2 d-flex flex-row align-items-center" id="search-top">
                        <i class="ti ti-search fs-22"></i>
                        <input type="search" class="form-control border-0" placeholder="Search">
                        <button type="button" class="btn p-0" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x fs-22"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidenav Menu Start -->
    <div class="sidebar" id="sidebar">
        
        <!-- Start Logo -->
        <div class="sidebar-logo">
            <div>
                <!-- Logo Normal -->
                <a href="{{url('index')}}" class="logo logo-normal">
                    <img src="{{URL::asset('build/img/logo.svg')}}" alt="Logo">
                </a>

                <!-- Logo Small -->
                <a href="{{url('index')}}" class="logo-small">
                    <img src="{{URL::asset('build/img/logo-small.svg')}}" alt="Logo">
                </a>

                <!-- Logo Dark -->
                <a href="{{url('index')}}" class="dark-logo">
                    <img src="{{URL::asset('build/img/logo-white.svg')}}" alt="Logo">
                </a>
            </div>
            <button class="sidenav-toggle-btn btn border-0 p-0 active" id="toggle_btn"> 
                <i class="ti ti-arrow-bar-to-left"></i>
            </button>

            <!-- Sidebar Menu Close -->
            <button class="sidebar-close">
                <i class="ti ti-x align-middle"></i>
            </button>                
        </div>
        <!-- End Logo -->

        <!-- Sidenav Menu -->
        <div class="sidebar-inner" data-simplebar>                
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="menu-title"><span>Main Menu</span></li>
                    <li>
                        <ul>
                            <li class="submenu">
                                <a href="javascript:void(0);" class="{{ Request::is('index', '/','leads-dashboard','project-dashboard') ? 'active subdrop' : '' }}">
                                    <i class="ti ti-dashboard"></i><span>Dashboard</span><span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="{{url('index')}}" class="{{ Request::is('index', '/') ? 'active' : '' }}">Deals Dashboard</a></li>
                                    <li><a href="{{url('leads-dashboard')}}" class="{{ Request::is('leads-dashboard') ? 'active' : '' }}">Leads Dashboard</a></li>
                                    <li><a href="{{url('project-dashboard')}}" class="{{ Request::is('project-dashboard') ? 'active' : '' }}">Project Dashboard</a></li>
                                </ul>
                            </li>
                            <li class="menu-title"><span>Project Settings</span></li>
                            <li class="submenu">
                                <a href="javascript:void(0);" class="{{ Request::is('common') ? 'subdrop active' : '' }}"><i class="ti ti-brand-airtable"></i><span>Common</span><span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{url('project-category')}}" class="{{ Request::is('project-category') ? 'active' : '' }}">Project Category</a></li>
                                    <li><a href="{{url('project-sub-category')}}" class="{{ Request::is('project-sub-category') ? 'active' : '' }}">Project Sub Category</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);" class="{{ Request::is('reference') ? 'subdrop active' : '' }}"><i class="ti ti-brand-airtable"></i><span>Reference</span><span class="menu-arrow"></span></a>
                                <ul>    
                                    <li><a href="{{url('equipment-rental-rates-hm')}}" class="{{ Request::is('equipment-rental-rates-hm') ? 'active' : '' }}">Equipment Rental Rates HM</a></li>
                                    <li><a href="{{url('scoring')}}" class="{{ Request::is('scoring') ? 'active' : '' }}">Scoring</a></li>
                                    <li><a href="{{ route('approval-flows.index') }}" class="{{ Request::is('approval-flows*') ? 'active' : '' }}">Approval Matrix</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-title"><span>APPLICATIONS</span></li>
                    <li>							
                        <ul>
                            <li class="{{ Request::is('projects') ? 'active' : '' }}"><a href="{{url('projects')}}"><i class="ti ti-atom-2"></i><span>Projects</span></a></li>
                            <li class="{{ Request::is('project-survey*') ? 'active' : '' }}"><a href="{{url('project-survey')}}"><i class="ti ti-clipboard-check"></i><span>Project Feasibility</span></a></li>
                            <li class="{{ Request::is('budgets*') ? 'active' : '' }}"><a href="{{url('budgets')}}"><i class="ti ti-wallet"></i><span>Project Budgets</span></a></li>
                            <li class="{{ Request::is('quotations*') ? 'active' : '' }}"><a href="{{url('quotations')}}"><i class="ti ti-file-dollar"></i><span>Project Quotations</span></a></li>
                            <li class="{{ Request::is('negotiations*') ? 'active' : '' }}"><a href="{{url('negotiations')}}"><i class="ti ti-scale"></i><span>Price Negotiation</span></a></li>
                        </ul>
                    </li>
                    
                    <li class="menu-title"><span>Reports</span></li>
                    <li>
                        <ul>
                            <li class="submenu">
                                <a href="javascript:void(0);" class="{{ Request::is('lead-reports', 'deal-reports', 'contact-reports', 'company-reports', 'project-reports', 'task-reports') ? 'subdrop active' : '' }}">
                                    <i class="ti ti-report-analytics"></i><span>Reports</span><span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a class="{{ Request::is('lead-reports') ? 'active' : '' }}"
                                            href="{{ url('lead-reports') }}">Lead Reports</a></li>
                                    <li><a class="{{ Request::is('deal-reports') ? 'active' : '' }}"
                                            href="{{ url('deal-reports') }}">Deal Reports</a></li>
                                    <li><a class="{{ Request::is('contact-reports') ? 'active' : '' }}"
                                            href="{{ url('contact-reports') }}">Contact Reports</a></li>
                                    <li><a class="{{ Request::is('company-reports') ? 'active' : '' }}"
                                            href="{{ url('company-reports') }}">Company Reports</a></li>
                                    <li><a class="{{ Request::is('project-reports') ? 'active' : '' }}"
                                            href="{{ url('project-reports') }}">Project Reports</a></li>
                                    <li><a class="{{ Request::is('task-reports') ? 'active' : '' }}"
                                            href="{{ url('task-reports') }}">Task Reports</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-title"><span>User Management</span></li>
                    <li>							
                        <ul>
                            <li class="{{ Request::is('manage-users') ? 'active' : '' }}"><a href="{{url('manage-users')}}"><i class="ti ti-users"></i><span>Manage Users</span></a></li>
                            <li class="{{ Request::is('roles-permissions','permission') ? 'active' : '' }}"><a href="{{url('roles-permissions')}}"><i class="ti ti-user-shield"></i><span>Roles & Permissions</span></a></li>
                            <li class="{{ Request::is('permissions') ? 'active' : '' }}"><a href="{{url('permissions')}}"><i class="ti ti-flag-question"></i><span>Permissions</span></a></li>
                        </ul>
                    </li>
                    <li class="menu-title"><span>Help</span></li>
                    <li>
                        <ul>
                            <li><a href="https://crms.dreamstechnologies.com/documentation/laravel.html" target="_blank"><i class="ti ti-file-stack"></i><span>Documentation</span></a></li>
                            <li><a href="https://crms.dreamstechnologies.com/documentation/changelog.html" target="_blank"><i class="ti ti-arrow-capsule"></i><span>Changelog v2.3.1</span></a></li>
                            <li class="submenu">
                                <a href="javascript:void(0);"><i class="ti ti-menu-deep"></i><span>Multi Level</span><span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="javascript:void(0);">Level 1.1</a></li>
                                    <li class="submenu submenu-two"><a href="javascript:void(0);">Level 1.2<span class="menu-arrow inside-submenu"></span></a>
                                        <ul>
                                            <li><a href="javascript:void(0);">Level 2.1</a></li>
                                            <li class="submenu submenu-two submenu-three"><a href="javascript:void(0);">Level 2.2<span class="menu-arrow inside-submenu inside-submenu-two"></span></a>
                                                <ul>
                                                    <li><a href="javascript:void(0);">Level 3.1</a></li>
                                                    <li><a href="javascript:void(0);">Level 3.2</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

    </div>
    <!-- Sidenav Menu End -->