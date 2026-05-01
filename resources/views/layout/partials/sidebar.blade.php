<!-- Search Modal -->
<div class="modal fade" id="searchModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-transparent">
            <div class="card shadow-none mb-0">
                <div class="px-3 py-2 d-flex flex-row align-items-center" id="search-top">
                    <i class="ti ti-search fs-22"></i>
                    <input type="search" class="form-control border-0" placeholder="Search">
                    <button type="button" class="btn p-0" data-bs-dismiss="modal" aria-label="Close"><i
                            class="ti ti-x fs-22"></i></button>
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
                            <a href="javascript:void(0);"
                                class="{{ Request::is('index', '/', 'leads-dashboard', 'project-dashboard') ? 'active subdrop' : '' }}">
                                <i class="ti ti-dashboard"></i><span>Dashboard</span><span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="{{url('index')}}"
                                        class="{{ Request::is('index', '/') ? 'active' : '' }}">Fuel Usage</a></li>
                                <li><a href="{{url('leads-dashboard')}}"
                                        class="{{ Request::is('leads-dashboard') ? 'active' : '' }}">Spare Part
                                        Usage</a></li>
                                <li><a href="{{url('project-dashboard')}}"
                                        class="{{ Request::is('project-dashboard') ? 'active' : '' }}">Project Survey
                                        Results</a></li>
                                <li><a href="{{url('project-dashboard')}}"
                                        class="{{ Request::is('project-dashboard') ? 'active' : '' }}">Project Budget
                                        Realization</a></li>
                                <li><a href="{{url('project-dashboard')}}"
                                        class="{{ Request::is('project-dashboard') ? 'active' : '' }}">Project
                                        Realization</a></li>
                                <li><a href="{{url('project-dashboard')}}"
                                        class="{{ Request::is('project-dashboard') ? 'active' : '' }}">Accounts
                                        Receivable Aging</a></li>
                                <li><a href="{{url('project-dashboard')}}"
                                        class="{{ Request::is('project-dashboard') ? 'active' : '' }}">Collection
                                        Performance</a></li>
                                <li><a href="{{url('project-dashboard')}}"
                                        class="{{ Request::is('project-dashboard') ? 'active' : '' }}">Bad Debt
                                        Analysis</a></li>
                                <li><a href="{{url('project-dashboard')}}"
                                        class="{{ Request::is('project-dashboard') ? 'active' : '' }}">Project Petty
                                        Cash Transaction</a></li>
                            </ul>
                        </li>
                        <li class="menu-title"><span>Project Settings</span></li>
                        <li class="submenu">
                            <a href="javascript:void(0);" class="{{ Request::is('common') ? 'subdrop active' : '' }}"><i
                                    class="ti ti-brand-airtable"></i><span>Common</span><span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{url('project-category')}}"
                                        class="{{ Request::is('project-category') ? 'active' : '' }}">Project
                                        Category</a></li>
                                <li><a href="{{url('project-sub-category')}}"
                                        class="{{ Request::is('project-sub-category') ? 'active' : '' }}">Project Sub
                                        Category</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"
                                class="{{ Request::is('reference') ? 'subdrop active' : '' }}"><i
                                    class="ti ti-brand-airtable"></i><span>Reference</span><span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{url('equipment-rental-rates-hm')}}"
                                        class="{{ Request::is('equipment-rental-rates-hm') ? 'active' : '' }}">Equipment
                                        Rental Rates HM</a></li>
                                <li><a href="{{url('scoring')}}"
                                        class="{{ Request::is('scoring') ? 'active' : '' }}">Scoring</a></li>
                                <li><a href="{{ route('approval-flows.index') }}"
                                        class="{{ Request::is('approval-flows*') ? 'active' : '' }}">Approval Matrix</a>
                                </li>
                                <li><a href="{{ route('scoring-plan-project.index') }}"
                                        class="{{ Request::is('scoring-plan-project*') ? 'active' : '' }}">Scoring Plan
                                        Project</a>
                                </li>
                                <li><a href="{{ route('surveyor-flows.index') }}"
                                        class="{{ Request::is('surveyor-flows*') ? 'active' : '' }}">Pengaturan
                                        Surveyor</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="menu-title"><span>PROJECT</span></li>
                <li>
                    <ul>
                        <li class="{{ Request::is('projects') ? 'active' : '' }}"><a href="{{url('projects')}}"><i
                                    class="ti ti-atom-2"></i><span>Projects</span></a></li>
                        <li class="{{ Request::is('project-survey*') ? 'active' : '' }}"><a
                                href="{{url('project-survey')}}"><i class="ti ti-clipboard-check"></i><span>Project
                                    Survey</span></a></li>
                        <li class="{{ Request::is('budgets*') ? 'active' : '' }}"><a href="{{url('budgets')}}"><i
                                    class="ti ti-wallet"></i><span>Project Budgets</span></a></li>
                        <li class="{{ Request::is('quotations*') ? 'active' : '' }}"><a href="{{url('quotations')}}"><i
                                    class="ti ti-file-dollar"></i><span>Project Quotations/Penawaran</span></a></li>
                        <li class="{{ Request::is('negotiations*') ? 'active' : '' }}"><a
                                href="{{url('negotiations')}}"><i class="ti ti-scale"></i><span>Price
                                    Negotiation</span></a></li>
                        <li class="{{ Request::is('final-contracts*') ? 'active' : '' }}"><a
                                href="{{url('final-contracts')}}"><i class="ti ti-file"></i><span>Final
                                    Contract</span></a></li>
                        <li class="{{ Request::is('unit-requests*') ? 'active' : '' }}"><a
                                href="{{ route('unit-requests.index') }}"><i class="ti ti-car"></i><span>Unit
                                    Request</span></a></li>
                        <li class="{{ Request::is('unit-replacements*') ? 'active' : '' }}"><a
                                href="{{ route('unit-replacements.index') }}"><i class="ti ti-replace"></i><span>Unit
                                    Replacement (PTU)</span></a></li>
                        <li class="{{ Request::is('unit-returns*') ? 'active' : '' }}"><a
                                href="{{ route('unit-returns.index') }}"><i class="ti ti-arrow-back"></i><span>Unit
                                    Return (PPU)</span></a></li>
                        <li class="{{ Request::is('unit-transfer*') ? 'active' : '' }}"><a href="#"><i
                                    class="ti ti-car"></i><span>Unit Transfer</span></a></li>
                    </ul>
                </li>
                <li class="menu-title"><span>IMPLEMENTATION</span></li>
                <li>
                    <ul>
                        <li class="{{ Request::is('workforce-formation*') ? 'active' : '' }}"><a href="#"><i
                                    class="ti ti-users"></i><span>Workforce Formation</span></a></li>
                        <li class="{{ Request::is('unit-formation*') ? 'active' : '' }}"><a href="#"><i
                                    class="ti ti-car"></i><span>Unit Formation</span></a></li>
                        <li class="{{ Request::is('timesheet-journal*') ? 'active' : '' }}"><a href="#"><i
                                    class="ti ti-calendar"></i><span>Timesheet Journal</span></a></li>
                        <li class="{{ Request::is('work-realization*') ? 'active' : '' }}"><a href="#"><i
                                    class="ti ti-list"></i><span>Work Realization</span></a></li>
                        <li class="{{ Request::is('invoice*') ? 'active' : '' }}"><a href="#"><i
                                    class="ti ti-invoice"></i><span>Invoice</span></a></li>
                        <li class="{{ Request::is('receivables*') ? 'active' : '' }}"><a href="#"><i
                                    class="ti ti-invoice"></i><span>Receivables</span></a></li>
                        <li class="{{ Request::is('receivables-settlement*') ? 'active' : '' }}"><a href="#"><i
                                    class="ti ti-invoice"></i><span>Receivables Settlement</span></a></li>
                        <li class="{{ Request::is('project-adjustment') ? 'active' : '' }}"><a href="#"><i
                                    class="ti ti-invoice"></i><span>Project Adjustment</span></a></li>
                    </ul>
                </li>
                <li class="menu-title"><span>PETTY CASH MANAGEMENT</span></li>
                <li>
                    <ul>
                        <li class="{{ Request::is('petty-cash-request*') ? 'active' : '' }}"><a href="#"><i
                                    class="ti ti-cash"></i><span>Petty Cash Request</span></a></li>
                        <li class="{{ Request::is('payment-of-fees*') ? 'active' : '' }}"><a href="#"><i
                                    class="ti ti-cash"></i><span>Payment of Fees</span></a></li>
                        <li class="{{ Request::is('cash-purchase*') ? 'active' : '' }}"><a href="#"><i
                                    class="ti ti-cash"></i><span>Cash Purchase</span></a></li>
                    </ul>
                </li>
                <li class="menu-title"><span>REPORTS</span></li>
                <li>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);"
                                class="{{ Request::is('lead-reports', 'deal-reports', 'contact-reports', 'company-reports', 'project-reports', 'task-reports') ? 'subdrop active' : '' }}">
                                <i class="ti ti-report-analytics"></i><span>Reports</span><span
                                    class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a class="{{ Request::is('lead-reports') ? 'active' : '' }}"
                                        href="{{ url('lead-reports') }}">Fuel Usage</a></li>
                                <li><a class="{{ Request::is('deal-reports') ? 'active' : '' }}"
                                        href="{{ url('deal-reports') }}">Spare Part Usage</a></li>
                                <li><a class="{{ Request::is('contact-reports') ? 'active' : '' }}"
                                        href="{{ url('contact-reports') }}">Project Survey Results</a></li>
                                <li><a class="{{ Request::is('company-reports') ? 'active' : '' }}"
                                        href="{{ url('company-reports') }}">Project Budget Realization</a></li>
                                <li><a class="{{ Request::is('project-reports') ? 'active' : '' }}"
                                        href="{{ url('project-reports') }}">Project Realization</a></li>
                                <li><a class="{{ Request::is('task-reports') ? 'active' : '' }}"
                                        href="{{ url('task-reports') }}">Accounts Receivable Aging</a></li>
                                <li><a class="{{ Request::is('task-reports') ? 'active' : '' }}"
                                        href="{{ url('task-reports') }}">Collection Performance</a></li>
                                <li><a class="{{ Request::is('task-reports') ? 'active' : '' }}"
                                        href="{{ url('task-reports') }}">Bad Debt Analysis</a></li>
                                <li><a class="{{ Request::is('task-reports') ? 'active' : '' }}"
                                        href="{{ url('task-reports') }}">Project Petty Cash Transaction</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="menu-title"><span>User Management</span></li>
                <li>
                    <ul>
                        <li class="{{ Request::is('manage-users') ? 'active' : '' }}"><a
                                href="{{url('manage-users')}}"><i class="ti ti-users"></i><span>Manage Users</span></a>
                        </li>
                        <li class="{{ Request::is('roles-permissions', 'permission') ? 'active' : '' }}"><a
                                href="{{url('roles-permissions')}}"><i class="ti ti-user-shield"></i><span>Roles &
                                    Permissions</span></a></li>
                        <li class="{{ Request::is('permissions') ? 'active' : '' }}"><a href="{{url('permissions')}}"><i
                                    class="ti ti-flag-question"></i><span>Permissions</span></a></li>
                    </ul>
                </li>
                <li class="menu-title"><span>Help</span></li>
            </ul>
        </div>
    </div>

</div>
<!-- Sidenav Menu End -->