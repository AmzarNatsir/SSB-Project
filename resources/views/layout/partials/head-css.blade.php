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

@if (Route::is(['icon-remix']))
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

@if (Route::is(['activities', 'activity-calls', 'activity-mail', 'activity-meeting', 'activity-task', 'analytics', 'blog-categories', 'blog-comments', 'blog-tags', 'calls', 'campaign-archieve', 'campaign-complete', 'campaign', 'cities', 'companies-list', 'company-reports', 'company', 'contact-messages', 'contact-reports', 'contact-stage', 'contacts-list', 'contracts-list', 'countries', 'data-tables', 'deal-reports', 'deals-list', 'delete-request', 'domain', 'estimations-list', 'faq', 'index', 'industry', 'language-settings', 'language-web-edit', 'language-web', 'layout-dark', 'layout-fullwidth', 'layout-hidden', 'layout-hoverview', 'layout-mini', 'layout-rtl', 'lead-reports', 'leads-dashboard', 'leads-list', 'leads', 'lost-reason', 'manage-users', 'membership-transactions', 'packages', 'pages', 'payments', 'permission', 'pipeline', 'printers-settings', 'project-category.index', 'project-sub-category.index', 'equipment-rental-rates-hm.index', 'scoring.index', 'projects.index', 'project-dashboard', 'project-reports', 'projects-list', 'projects', 'proposals-list', 'purchase-transaction', 'roles-permissions', 'sources', 'states', 'subscription', 'task-reports', 'testimonials', 'tickets', 'project-survey.index']))    
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/datatables/css/dataTables.bootstrap5.min.css')}}">
@endif    

@if (Route::is(['project-survey.index']))
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/datatables/css/dataTables.bootstrap5.min.css')}}">
@endif

@if (Route::is(['activities', 'activity-calls', 'activity-mail', 'activity-meeting', 'activity-task', 'analytics', 'blog-categories', 'blog-comments', 'blog-tags', 'call-history', 'calls', 'campaign-archieve', 'campaign-complete', 'campaign', 'companies-list', 'companies', 'company-details', 'company-reports', 'company', 'contact-details', 'contact-messages', 'contact-reports', 'contact-stage', 'contacts-list', 'contacts', 'contracts-list', 'contracts', 'dashboard', 'deal-reports', 'deals-details', 'deals-list', 'deals', 'delete-request', 'domain', 'estimations-list', 'estimations', 'index', 'industry', 'invoice-list', 'invoices', 'layout-dark', 'layout-fullwidth', 'layout-hidden', 'layout-hoverview', 'layout-mini', 'layout-rtl', 'lead-reports', 'leads-dashboard', 'leads-details', 'leads-list', 'leads', 'lost-reason', 'manage-users', 'membership-transactions', 'packages', 'pages', 'payments', 'pipeline', 'project-dashboard', 'project-details', 'project-reports', 'projects-list', 'projects', 'proposals-list', 'proposals', 'purchase-transaction', 'sources', 'subscription', 'task-reports', 'tasks-completed', 'tasks-important', 'tasks', 'tickets']))    
	<!-- Daterangepicker CSS -->
	<link rel="stylesheet" href="{{URL::asset('build/plugins/daterangepicker/daterangepicker.css')}}">
@endif    

@if (Route::is(['activities', 'add-blog', 'blog-details', 'campaign-archieve', 'campaign-complete', 'campaign', 'companies-list', 'companies', 'company-details', 'contact-details', 'contacts-list', 'contacts', 'contracts-list', 'cronjob', 'deals-details', 'deals-list', 'deals', 'edit-blog', 'email-reply', 'email', 'estimations-list', 'estimations', 'form-select', 'form-wizard', 'leads-details', 'leads-list', 'leads', 'localization-settings', 'notes', 'payments', 'pipeline', 'project-details', 'projects-list', 'projects', 'proposals-list', 'proposals', 'tasks-completed', 'tasks-important', 'tasks', 'tax-rates']))        
    <!-- Choices CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/choices.js/public/assets/styles/choices.min.css')}}"> 
@endif    
    
@if (Route::is(['activities', 'activity-calls', 'activity-mail', 'activity-meeting', 'activity-task', 'add-blog', 'add-invoices', 'calendar', 'campaign-archieve', 'campaign-complete', 'campaign', 'companies-list', 'companies', 'company-details', 'company', 'contact-details', 'contacts-list', 'contacts', 'contracts-list', 'contracts', 'dashboard', 'deals-details', 'deals-list', 'deals', 'domain', 'edit-invoices', 'estimations-list', 'estimations', 'form-pickers', 'invoice-list', 'invoices', 'kanban-view', 'leads-details', 'leads-list', 'leads', 'notes', 'packages', 'payments', 'pipeline', 'project-dashboard', 'project-details', 'projects-list', 'projects', 'proposals-list', 'proposals', 'purchase-transaction', 'subscription', 'tasks-completed', 'tasks-important', 'tasks', 'todo']))    
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/flatpickr/flatpickr.min.css')}}">   
@endif     

@if (Route::is(['email-reply', 'social-feed']))
    <!-- Fancybox CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/fancybox/jquery.fancybox.min.css')}}">
@endif    

@if (Route::is(['activities', 'activity-calls', 'activity-mail', 'activity-meeting', 'activity-task', 'add-blog', 'blog-details', 'blogs', 'campaign-archieve', 'campaign-complete', 'campaign', 'companies-list', 'companies', 'company-details', 'company', 'contact-details', 'contacts-list', 'contacts', 'contracts-list', 'contracts', 'deals-details', 'deals-list', 'deals', 'edit-blog', 'estimations-list', 'estimations', 'file-manager', 'form-editors', 'gdpr-cookies', 'invoice-list', 'invoice-settings', 'invoices', 'leads-details', 'leads-list', 'leads', 'notes', 'payments', 'pipeline', 'project-details', 'projects-list', 'projects', 'proposals-list', 'proposals', 'ticket-details', 'todo-list', 'todo']))        
    <!-- Quill CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/quill/quill.snow.css')}}">    
@endif    

@if (Route::is(['form-editors', 'file-manager']))
    <!-- Quill css -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/quill/quill.core.css')}}">
    <link rel="stylesheet" href="{{URL::asset('build/plugins/quill/quill.bubble.css')}}">
@endif

@if (Route::is(['blog-categories', 'blog-comments', 'blog-tags', 'companies-list', 'companies', 'company-details', 'contact-messages', 'contact-details', 'contacts-list', 'contacts', 'deals-details', 'deals-list', 'delete-request', 'leads-details', 'leads-list', 'leads', 'manage-users', 'membership-transactions', 'pages', 'permission', 'pipeline', 'project-details', 'projects-list', 'projects', 'security-settings']))    
    <!-- Mobile CSS-->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/intltelinput/css/intlTelInput.css')}}">
    <link rel="stylesheet" href="{{URL::asset('build/plugins/intltelinput/css/demo.css')}}">
@endif    

@if  (Route::is(['chart-c3']))
    <!-- ChartC3 CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/c3-chart/c3.min.css')}}">
@endif    

@if (Route::is(['chart-morris']))
    <!-- Morris CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/morris/morris.css')}}">
@endif    

@if (Route::is(['maps-leaflet']))
    <!-- Leaflet Maps CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/leaflet/leaflet.css')}}">
@endif    

@if (Route::is(['maps-vector']))
    <!-- Jsvector Maps -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/jsvectormap/css/jsvectormap.min.css')}}">
@endif    

@if (Route::is(['ui-lightbox']))
    <!-- Glightbox CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/lightbox/glightbox.min.css')}}">
@endif    

@if (Route::is(['ui-rangeslider']))
    <!-- Rangeslider CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/nouislider/nouislider.min.css')}}">
@endif    

@if (Route::is(['ui-sweetalerts', 'project-category.index', 'project-sub-category.index', 'equipment-rental-rates-hm.index', 'scoring.index', 'projects.index', 'projects.show', 'project-survey.index', 'project-survey.create', 'project-survey.show']))
    <!-- Sweetalert2 CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/sweetalert2/sweetalert2.min.css')}}">
@endif    

@if (Route::is(['activities', 'activity-calls', 'activity-mail', 'activity-meeting', 'activity-task', 'add-blog', 'add-invoices', 'add-page', 'appearance-settings', 'ban-ip-address', 'bank-accounts', 'blog-details', 'calendar', 'campaign-archieve', 'campaign-complete', 'campaign', 'clear-cache', 'companies-list', 'companies', 'company-details', 'company-reports', 'company-settings', 'company', 'contact-details', 'contact-reports', 'contacts-list', 'contacts', 'contracts-list', 'contracts', 'cronjob', 'currencies', 'custom-fields-setting', 'dashboard', 'database-backup', 'deal-reports', 'deals-details', 'deals-list', 'deals', 'delete-request', 'domain', 'edit-blog', 'edit-invoices', 'edit-page', 'email-settings', 'estimations-list', 'estimations', 'faq', 'form-select', 'form-wizard', 'gdpr-cookies', 'invoice-list', 'invoice-settings', 'invoices', 'kanban-view', 'language-settings', 'language-web-edit', 'language-web', 'lead-reports', 'leads-details', 'leads-list', 'leads', 'localization-settings', 'manage-users', 'membership-addons', 'membership-plans', 'membership-transactions', 'notes', 'packages', 'pages', 'payments', 'pipeline', 'preference-settings', 'printer-settings', 'profile-settings', 'project-dashboard', 'project-details', 'project-reports', 'projects-list', 'projects', 'proposals-list', 'proposals', 'purchase-transaction', 'security-settings', 'sitemap', 'sms-gateways', 'storage', 'subscription', 'system-backup', 'system-update', 'task-reports', 'tasks-completed', 'tasks-important', 'tasks', 'tax-rates', 'testimonials', 'tickets', 'todo-list', 'todo', 'equipment-rental-rates-hm.index', 'scoring.index', 'projects.index', 'projects.show', 'project-survey.index', 'project-survey.create', 'project-survey.show']))    
    <!-- Select2 CSS -->
	<link rel="stylesheet" href="{{URL::asset('build/plugins/select2/css/select2.min.css')}}">
@endif

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/css/style.css')}}" id="app-style">