    <!-- Favicon -->
    <link rel="shortcut icon" href="{{URL::asset('build/img/favicon.png')}}">

    <!-- Apple Icon -->
    <link rel="apple-touch-icon" href="{{URL::asset('build/img/apple-icon.png')}}">

@if (!Route::is(['layout-mini', 'layout-hoverview', 'layout-hidden', 'layout-fullwidth', 'layout-rtl', 'layout-dark', 'login', 'register', 'forgot-password','reset-password', 'success', 'email-verification', 'two-step-verification', 'lock-screen', 'error-404', 'error-500', 'coming-soon', 'under-maintenance']))
    <!-- Theme Config Js -->
    <script src="{{URL::asset('build/js/theme-script.js')}}"></script>
@endif

@if (!Route::is(['layout-rtl']))
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/css/bootstrap.min.css')}}">
@endif

@if (Route::is(['layout-rtl']))
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/css/bootstrap.rtl.min.css')}}">
@endif

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/tabler-icons/tabler-icons.min.css')}}">

@if (Route::is(['icon-bootstrap']))
    <!-- Bootstrap Icon CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/bootstrap/bootstrap-icons.min.css')}}">
@endif

@if (Route::is(['icon-feather']))
    <!-- Feather CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/feather/feather.css')}}">
@endif

@if (Route::is(['icon-flag']))
    <!-- Flag CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/flags/flags.css')}}">
@endif

@if (Route::is(['add-invoices', 'calendar', 'edit-invoices', 'file-manager', 'icon-fontawesome', 'invoice', 'kanban-view', 'notes', 'todo']))
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/fontawesome/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('build/plugins/fontawesome/css/all.min.css')}}">
@endif

@if (Route::is(['icon-ionic']))
    <!-- Ionic CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/ionic/ionicons.css')}}">
@endif

@if (Route::is(['icon-material']))
    <!-- Material CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/material/materialdesignicons.css')}}">
@endif

@if (Route::is(['icon-pe7']))
    <!-- Pe7 CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/pe7/pe-icon-7.css')}}">
@endif

@if (Route::is(['icon-remix', 'quotations.*']))
    <!-- Remix Icon CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/remix/remixicon.css')}}">
@endif

@if (Route::is(['icon-simpleline']))
    <!-- Simpleline CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/simpleline/simple-line-icons.css')}}">
@endif

@if (Route::is(['icon-themify']))
    <!-- Themify CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/themify/themify.css')}}">
@endif

@if (Route::is(['icon-typicon']))
    <!-- Typicon CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/typicons/typicons.css')}}">
@endif

@if (Route::is(['icon-weather']))
    <!-- Weather CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/weather/weathericons.css')}}">
@endif

    <!-- Simplebar CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/simplebar/simplebar.min.css')}}">

@if (Route::is(['activities', 'activity-calls', 'activity-mail', 'activity-meeting', 'activity-task', 'analytics', 'blog-categories', 'blog-comments', 'blog-tags', 'calls', 'campaign-archieve', 'campaign-complete', 'campaign', 'cities', 'companies-list', 'company-reports', 'company', 'contact-messages', 'contact-reports', 'contact-stage', 'contacts-list', 'contracts-list', 'countries', 'data-tables', 'deal-reports', 'deals-list', 'delete-request', 'domain', 'estimations-list', 'faq', 'index', 'industry', 'language-settings', 'language-web-edit', 'language-web', 'layout-dark', 'layout-fullwidth', 'layout-hidden', 'layout-hoverview', 'layout-mini', 'layout-rtl', 'lead-reports', 'leads-dashboard', 'leads-list', 'leads', 'lost-reason', 'manage-users', 'manage-users.index', 'membership-transactions', 'packages', 'pages', 'payments', 'permission', 'permissions.index', 'pipeline', 'printers-settings', 'project-category.index', 'project-sub-category.index', 'equipment-rental-rates-hm.index', 'scoring.index', 'scoring-plan-project.index', 'projects.index', 'project-dashboard', 'project-reports', 'projects-list', 'projects', 'proposals-list', 'purchase-transaction', 'roles-permissions', 'roles-permissions.index', 'sources', 'states', 'subscription', 'task-reports', 'testimonials', 'tickets', 'project-survey.index', 'budgets.index', 'approval-flows.*', 'quotations.*']))
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/datatables/css/dataTables.bootstrap5.min.css')}}">
@endif

@if (Route::is(['project-survey.index']))
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/datatables/css/dataTables.bootstrap5.min.css')}}">
@endif

@if (Route::is(['ui-sweetalerts', 'project-category.index', 'project-sub-category.index', 'equipment-rental-rates-hm.index', 'scoring.index', 'scoring-plan-project.*', 'projects.index', 'projects.show', 'project-survey.index', 'project-survey.create', 'project-survey.show', 'budgets.index', 'budgets.create', 'budgets.edit', 'budgets.show', 'manage-users.index', 'roles-permissions.index', 'permissions.index', 'approval-flows.*', 'quotations.*', 'unit-requests.*', 'unit-replacements.*', 'final-contracts.*', 'surveyor-flows.index', 'workforce-formations.*', 'unit-formations.*', 'timesheets.*', 'work-realizations.*', 'invoices.*', 'receivables.*', 'receivable-settlements.*', 'petty-cash-categories.*', 'petty-cash-requests.*', 'petty-cash-payments.*', 'petty-cash-purchases.*', 'unit-transfers.*']))
    <!-- Sweetalert2 CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/sweetalert2/sweetalert2.min.css')}}">
@endif

@if (Route::is(['activities', 'activity-calls', 'activity-mail', 'activity-meeting', 'activity-task', 'add-blog', 'add-invoices', 'add-page', 'appearance-settings', 'ban-ip-address', 'bank-accounts', 'blog-details', 'calendar', 'campaign-archieve', 'campaign-complete', 'campaign', 'clear-cache', 'companies-list', 'companies', 'company-details', 'company-reports', 'company-settings', 'company', 'contact-details', 'contact-reports', 'contacts-list', 'contacts', 'contracts-list', 'contracts', 'cronjob', 'currencies', 'custom-fields-setting', 'dashboard', 'database-backup', 'deal-reports', 'deals-details', 'deals-list', 'deals', 'delete-request', 'domain', 'edit-blog', 'edit-invoices', 'edit-page', 'email-settings', 'estimations-list', 'estimations', 'faq', 'form-select', 'form-wizard', 'gdpr-cookies', 'invoice-list', 'invoice-settings', 'invoices', 'kanban-view', 'language-settings', 'language-web-edit', 'language-web', 'lead-reports', 'leads-details', 'leads-list', 'leads', 'localization-settings', 'manage-users', 'manage-users.index', 'membership-addons', 'membership-plans', 'membership-transactions', 'notes', 'packages', 'pages', 'payments', 'pipeline', 'preference-settings', 'printer-settings', 'profile-settings', 'project-dashboard', 'project-details', 'project-reports', 'projects-list', 'projects', 'proposals-list', 'proposals', 'purchase-transaction', 'roles-permissions.index', 'permissions.index', 'approval-flows.*', 'security-settings', 'sitemap', 'sms-gateways', 'storage', 'subscription', 'system-backup', 'system-update', 'task-reports', 'tasks-completed', 'tasks-important', 'tasks', 'tax-rates', 'testimonials', 'tickets', 'todo-list', 'todo', 'equipment-rental-rates-hm.index', 'scoring.index', 'scoring-plan-project.*', 'projects.index', 'projects.show', 'project-survey.index', 'project-survey.create', 'project-survey.show', 'budgets.index', 'budgets.create', 'budgets.edit', 'budgets.show', 'quotations.*', 'unit-requests.*', 'unit-replacements.*', 'final-contracts.*', 'surveyor-flows.index', 'workforce-formations.*', 'unit-formations.*', 'timesheets.*', 'work-realizations.*', 'invoices.*', 'receivables.*', 'receivable-settlements.*', 'petty-cash-categories.*', 'petty-cash-requests.*', 'petty-cash-payments.*', 'petty-cash-purchases.*', 'unit-transfers.*']))
    <!-- Select2 CSS -->
	<link rel="stylesheet" href="{{URL::asset('build/plugins/select2/css/select2.min.css')}}">
@endif

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/css/style.css')}}" id="app-style">
