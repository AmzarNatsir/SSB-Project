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
                <img src="{{URL::asset('assets/logo_perusahaan/logo_ssb.png')}}" alt="Logo">
            </a>

            <!-- Logo Small -->
            <a href="{{url('index')}}" class="logo-small">
                <img src="{{URL::asset('build/img/logo-small.svg')}}" alt="Logo">
            </a>

            <!-- Logo Dark -->
            <a href="{{url('index')}}" class="dark-logo">
                <img src="{{URL::asset('assets/logo_perusahaan/logo_ssb.png')}}" alt="Logo">
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
                                class="{{ Request::is('index', '/', 'leads-dashboard', 'project-dashboard', 'executive-dashboard') ? 'active subdrop' : '' }}">
                                <i class="ti ti-dashboard"></i><span>Dashboard</span><span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="{{route('executive-dashboard')}}"
                                        class="{{ Request::is('executive-dashboard') ? 'active' : '' }}"><i class="ti ti-chart-bar me-2 text-primary"></i>Executive Dashboard</a></li>
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
                        <li class="{{ Request::is('unit-transfers*') ? 'active' : '' }}"><a href="{{ route('unit-transfers.index') }}"><i
                                    class="ti ti-car"></i><span>Unit Transfer</span></a></li>
                    </ul>
                </li>
                <li class="menu-title"><span>IMPLEMENTATION</span></li>
                <li>
                    <ul>
                        <li class="{{ Request::is('workforce-formations*') ? 'active' : '' }}"><a
                                href="{{ route('workforce-formations.index') }}"><i
                                    class="ti ti-users"></i><span>SK Penugasan Tim</span></a></li>
                        <li class="{{ Request::is('unit-formations*') ? 'active' : '' }}"><a
                                href="{{ route('unit-formations.index') }}"><i
                                    class="ti ti-truck"></i><span>SK Penetapan Unit</span></a></li>
                        <li class="{{ Request::is('timesheets*') ? 'active' : '' }}"><a
                                href="{{ route('timesheets.index') }}"><i
                                    class="ti ti-calendar"></i><span>Timesheet Journal</span></a></li>
                        {{-- <li class="{{ Request::is('spare-part-usages*') ? 'active' : '' }}"><a
                                href="{{ route('spare-part-usages.index') }}"><i
                                    class="ti ti-tool"></i><span>Spare Part Usage</span></a></li> --}}
                        <li class="{{ Request::is('work-realizations*') ? 'active' : '' }}"><a
                                href="{{ route('work-realizations.index') }}"><i
                                    class="ti ti-list"></i><span>Work Realization</span></a></li>
                        <li class="{{ Request::is('invoices*') ? 'active' : '' }}"><a
                                href="{{ route('invoices.index') }}"><i
                                    class="ti ti-invoice"></i><span>Invoice</span></a></li>
                        <li class="{{ Request::is('receivables') || Request::is('receivables/*') ? 'active' : '' }}"><a
                                href="{{ route('receivables.index') }}"><i
                                    class="ti ti-cash"></i><span>Penerimaan Dana</span></a></li>
                        <li class="{{ Request::is('receivable-settlements*') ? 'active' : '' }}"><a
                                href="{{ route('receivable-settlements.index') }}"><i
                                    class="ti ti-arrows-exchange"></i><span>Pelunasan Piutang</span></a></li>
                        <li class="{{ Request::is('project-adjustment') ? 'active' : '' }}"><a href="#"><i
                                    class="ti ti-invoice"></i><span>Project Adjustment</span></a></li>
                    </ul>
                </li>
                <li class="menu-title"><span>PENGELOLAAN KAS KECIL</span></li>
                <li>
                    <ul>
                        <li class="{{ Request::is('petty-cash-categories*') ? 'active' : '' }}"><a href="{{ route('petty-cash-categories.index') }}"><i
                                    class="ti ti-tag"></i><span>Jenis Biaya (Master)</span></a></li>
                        <li class="{{ Request::is('petty-cash-requests*') ? 'active' : '' }}"><a href="{{ route('petty-cash-requests.index') }}"><i
                                    class="ti ti-cash"></i><span>Permintaan Kas Kecil</span></a></li>
                        <li class="{{ Request::is('petty-cash-payments*') ? 'active' : '' }}"><a href="{{ route('petty-cash-payments.index') }}"><i
                                    class="ti ti-receipt"></i><span>Pembayaran Biaya</span></a></li>
                        <li class="{{ Request::is('petty-cash-purchases*') ? 'active' : '' }}"><a href="{{ route('petty-cash-purchases.index') }}"><i
                                    class="ti ti-shopping-cart"></i><span>Pembelian Tunai</span></a></li>
                    </ul>
                </li>
                <li class="menu-title"><span>REPORTS</span></li>
                <li>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);"
                                class="{{ Request::is('lead-reports*', 'deal-reports*', 'survey-reports*', 'contact-reports', 'company-reports*', 'project-realization-reports*', 'accounts-receivable-aging*', 'collection-performance*', 'bad-debt-analysis*', 'petty-cash-transaction*', 'task-reports') ? 'subdrop active' : '' }}">
                                <i class="ti ti-report-analytics"></i><span>Reports</span><span
                                    class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a class="{{ Request::is('lead-reports*') ? 'active' : '' }}"
                                        href="{{ route('lead-reports') }}"><i class="ti ti-droplet me-1 text-info"></i>Fuel Usage</a></li>
                                {{-- <li><a class="{{ Request::is('deal-reports*') ? 'active' : '' }}"
                                        href="{{ route('deal-reports') }}"><i class="ti ti-tool me-1 text-warning"></i>Spare Part Usage</a></li> --}}
                                <li><a class="{{ Request::is('survey-reports*') ? 'active' : '' }}"
                                        href="{{ route('survey-reports') }}"><i class="ti ti-check me-1 text-success"></i>Project Survey Results</a></li>
                                <li><a class="{{ Request::is('company-reports*') ? 'active' : '' }}"
                                        href="{{ route('company-reports') }}"><i class="ti ti-wallet me-1 text-success"></i>Project Budget Realization</a></li>
                                <li><a class="{{ Request::is('project-realization-reports*') ? 'active' : '' }}"
                                        href="{{ route('project-realization-reports') }}"><i class="ti ti-chart-area me-1 text-danger"></i>Project Realization</a></li>
                                <li><a class="{{ Request::is('accounts-receivable-aging*') ? 'active' : '' }}"
                                        href="{{ route('accounts-receivable-aging') }}"><i class="ti ti-calendar-time me-1 text-warning"></i>Accounts Receivable Aging</a></li>
                                <li><a class="{{ Request::is('collection-performance*') ? 'active' : '' }}"
                                        href="{{ route('collection-performance') }}"><i class="ti ti-users-group me-1 text-success"></i>Collection Performance</a></li>
                                <li><a class="{{ Request::is('bad-debt-analysis*') ? 'active' : '' }}"
                                        href="{{ route('bad-debt-analysis') }}"><i class="ti ti-alert-circle me-1 text-danger"></i>Bad Debt Analysis</a></li>
                                <li><a class="{{ Request::is('petty-cash-transaction*') ? 'active' : '' }}"
                                        href="{{ route('petty-cash-transaction.index') }}"><i class="ti ti-cash-banknote me-1 text-info"></i>Project Petty Cash Transaction</a></li>
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
