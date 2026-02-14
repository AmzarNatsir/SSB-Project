    <!-- jQuery -->
    <script src="{{URL::asset('build/js/jquery-3.7.1.min.js')}}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{URL::asset('build/js/bootstrap.bundle.min.js')}}"></script>    

	<!-- Simplebar JS -->
	<script src="{{URL::asset('build/plugins/simplebar/simplebar.min.js')}}"></script>

@if (Route::is(['activities', 'activity-calls', 'activity-mail', 'activity-meeting', 'activity-task', 'analytics', 'blog-categories', 'blog-comments', 'blog-tags', 'calls', 'campaign-archieve', 'campaign-complete', 'campaign', 'cities', 'companies-list', 'company-reports', 'company', 'contact-messages', 'contact-reports', 'contact-stage', 'contacts-list', 'contracts-list', 'countries', 'data-tables', 'deal-reports', 'deals-list', 'delete-request', 'domain', 'estimations-list', 'faq', 'index', 'industry', 'language-settings', 'language-web-edit', 'language-web', 'layout-dark', 'layout-fullwidth', 'layout-hidden', 'layout-hoverview', 'layout-mini', 'layout-rtl', 'lead-reports', 'leads-dashboard', 'leads-list', 'leads', 'lost-reason', 'manage-users', 'membership-transactions', 'packages', 'pages', 'payments', 'permission', 'pipeline', 'printers-settings', 'project-category.index', 'project-sub-category.index', 'equipment-rental-rates-hm.index', 'scoring.index', 'projects.index', 'project-dashboard', 'project-reports', 'projects-list', 'projects', 'proposals-list', 'purchase-transaction', 'roles-permissions', 'sources', 'states', 'subscription', 'task-reports', 'testimonials', 'tickets', 'project-survey.index']))    
    <!-- Datatable JS -->
    <script src="{{URL::asset('build/plugins/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('build/plugins/datatables/js/dataTables.bootstrap5.min.js')}}"></script>
@endif 

@if (Route::is(['project-survey.index']))
    <!-- Datatable JS -->
    <script src="{{URL::asset('build/plugins/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('build/plugins/datatables/js/dataTables.bootstrap5.min.js')}}"></script>
@endif

@if (Route::is(['activities', 'activity-calls', 'activity-mail', 'activity-meeting', 'activity-task', 'analytics', 'blog-categories', 'blog-comments', 'blog-tags', 'call-history', 'calls', 'campaign-archieve', 'campaign-complete', 'campaign', 'companies-list', 'companies', 'company-details', 'company-reports', 'company', 'contact-details', 'contact-messages', 'contact-reports', 'contact-stage', 'contacts-list', 'contacts', 'contracts-list', 'contracts', 'dashboard', 'deal-reports', 'deals-details', 'deals-list', 'deals', 'delete-request', 'domain', 'estimations-list', 'estimations', 'index', 'industry', 'invoice-list', 'invoices', 'layout-dark', 'layout-fullwidth', 'layout-hidden', 'layout-hoverview', 'layout-mini', 'layout-rtl', 'lead-reports', 'leads-dashboard', 'leads-details', 'leads-list', 'leads', 'lost-reason', 'manage-users', 'membership-transactions', 'packages', 'pages', 'payments', 'pipeline', 'project-dashboard', 'project-details', 'project-reports', 'projects-list', 'projects', 'proposals-list', 'proposals', 'purchase-transaction', 'sources', 'subscription', 'task-reports', 'tasks-completed', 'tasks-important', 'tasks', 'tickets']))    
	<!-- Daterangepicker JS -->
	<script src="{{URL::asset('build/js/moment.min.js')}}"></script>
	<script src="{{URL::asset('build/plugins/daterangepicker/daterangepicker.js')}}"></script> 
@endif    

@if (Route::is(['activities', 'add-blog', 'blog-details', 'campaign-archieve', 'campaign-complete', 'campaign', 'companies-list', 'companies', 'company-details', 'contact-details', 'contacts-list', 'contacts', 'contracts-list', 'cronjob', 'deals-details', 'deals-list', 'deals', 'edit-blog', 'email-reply', 'email', 'estimations-list', 'estimations', 'form-select', 'form-wizard', 'leads-details', 'leads-list', 'leads', 'localization-settings', 'notes', 'payments', 'pipeline', 'project-details', 'projects-list', 'projects', 'proposals-list', 'proposals', 'tasks-completed', 'tasks-important', 'tasks', 'tax-rates']))    
    <!-- Choices Js -->	
    <script src="{{URL::asset('build/plugins/choices.js/public/assets/scripts/choices.min.js')}}"></script>    
@endif    

@if (Route::is(['activities', 'activity-calls', 'activity-mail', 'activity-meeting', 'activity-task', 'add-blog', 'add-invoices', 'calendar', 'campaign-archieve', 'campaign-complete', 'campaign', 'companies-list', 'companies', 'company-details', 'company', 'contact-details', 'contacts-list', 'contacts', 'contracts-list', 'contracts', 'dashboard', 'deals-details', 'deals-list', 'deals', 'domain', 'edit-invoices', 'estimations-list', 'estimations', 'form-pickers', 'invoice-list', 'invoices', 'kanban-view', 'leads-details', 'leads-list', 'leads', 'notes', 'packages', 'payments', 'pipeline', 'project-dashboard', 'project-details', 'projects-list', 'projects', 'proposals-list', 'proposals', 'purchase-transaction', 'subscription', 'tasks-completed', 'tasks-important', 'tasks', 'todo']))    
    <!-- Flatpickr JS -->
    <script src="{{URL::asset('build/plugins/flatpickr/flatpickr.min.js')}}"></script>
@endif

@if (Route::is(['email-reply', 'social-feed']))
    <!-- Fancybox JS -->
    <script src="{{URL::asset('build/plugins/fancybox/jquery.fancybox.min.js')}}"></script>
@endif    

@if (Route::is(['activities', 'activity-calls', 'activity-mail', 'activity-meeting', 'activity-task', 'add-blog', 'blog-details', 'blogs', 'campaign-archieve', 'campaign-complete', 'campaign', 'companies-list', 'companies', 'company-details', 'company', 'contact-details', 'contacts-list', 'contacts', 'contracts-list', 'contracts', 'deals-details', 'deals-list', 'deals', 'edit-blog', 'estimations-list', 'estimations', 'file-manager', 'form-editors', 'gdpr-cookies', 'invoice-list', 'invoice-settings', 'invoices', 'leads-details', 'leads-list', 'leads', 'notes', 'payments', 'pipeline', 'project-details', 'projects-list', 'projects', 'proposals-list', 'proposals', 'ticket-details', 'todo-list', 'todo']))    
    <!-- Quill JS -->
    <script src="{{URL::asset('build/plugins/quill/quill.min.js')}}"></script>
@endif   

@if (Route::is(['form-editors']))
    <!-- Quill JS -->
    <script src="{{URL::asset('build/js/form-quill.js')}}"></script>
@endif    

@if (Route::is(['file-manager', 'gdpr-cookies', 'invoice-settings', 'notes', 'todo-list', 'todo']))
    <script src="{{URL::asset('build/js/form-quilljs.js')}}"></script>
@endif    

@if (Route::is(['blog-categories', 'blog-comments', 'blog-tags', 'companies-list', 'companies', 'company-details', 'contact-messages', 'contact-details', 'contacts-list', 'contacts', 'deals-details', 'deals-list', 'delete-request', 'leads-details', 'leads-list', 'leads', 'manage-users', 'membership-transactions', 'pages', 'permission', 'pipeline', 'project-details', 'projects-list', 'projects', 'security-settings']))    
    <!-- Mobile Input -->
    <script src="{{URL::asset('build/plugins/intltelinput/js/intlTelInput.js')}}"></script>
@endif    

@if (Route::is(['appearance-settings', 'ban-ip-address', 'bank-accounts', 'clear-cache', 'company-details', 'company-settings', 'connected-apps', 'contact-details', 'cronjob', 'currencies', 'custom-fields-setting', 'database-backup', 'deals-details', 'email-settings', 'file-manager', 'gdpr-cookies', 'invoice-settings', 'language-settings', 'language-web-edit', 'language-web', 'leads-details', 'localization-settings', 'notes', 'notifications-settings', 'payment-gateways', 'preference-settings', 'prefixes-settings', 'printers-settings', 'profile-settings', 'project-details', 'security-settings', 'sitemap', 'sms-gateways', 'social-feed', 'storage', 'system-backup', 'system-update', 'tax-rates']))
	<!-- Sticky Sidebar JS -->
	<script src="{{URL::asset('build/plugins/theia-sticky-sidebar/ResizeSensor.js')}}"></script>
	<script src="{{URL::asset('build/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js')}}"></script>
@endif

@if (Route::is(['calendar']))
    <!-- Fullcalendar JS -->
    <script src="{{URL::asset('build/plugins/fullcalendar/index.global.min.js')}}"></script>
    <script src="{{URL::asset('build/plugins/fullcalendar/calendar-data.js')}}"></script>
@endif    

@if (Route::is(['analytics', 'calls', 'chart-apex', 'company-reports', 'contact-reports', 'contact-stage', 'dashboard', 'deal-reports', 'index', 'layout-dark', 'layout-fullwidth', 'layout-hidden', 'layout-hoverview', 'layout-mini', 'layout-rtl', 'lead-reports', 'leads-dashboard', 'lost-reason', 'project-dashboard', 'project-reports', 'sources', 'task-reports']))
	<!-- Apexchart JS -->
	<script src="{{URL::asset('build/plugins/apexchart/apexcharts.min.js')}}"></script>
	<script src="{{URL::asset('build/plugins/apexchart/chart-data.js')}}"></script>
@endif 

@if (Route::is(['chart-c3']))
    <!-- Chart JS -->
    <script src="{{URL::asset('build/plugins/c3-chart/d3.v5.min.js')}}"></script>
    <script src="{{URL::asset('build/plugins/c3-chart/c3.min.js')}}"></script>
    <script src="{{URL::asset('build/plugins/c3-chart/chart-data.js')}}"></script>
@endif    

@if (Route::is(['chart-flot']))
    <!-- Chart JS -->
    <script src="{{URL::asset('build/plugins/flot/jquery.flot.js')}}"></script>
    <script src="{{URL::asset('build/plugins/flot/jquery.flot.fillbetween.js')}}"></script>
    <script src="{{URL::asset('build/plugins/flot/jquery.flot.pie.js')}}"></script>
    <script src="{{URL::asset('build/plugins/flot/chart-data.js')}}"></script>
@endif

@if (Route::is(['chart-js']))
    <!-- Chart JS -->
    <script src="{{URL::asset('build/plugins/chartjs/chart.min.js')}}"></script>
    <script src="{{URL::asset('build/plugins/chartjs/chart-data.js')}}"></script>
@endif    

@if (Route::is(['chart-morris']))
    <!-- Chart JS -->
    <script src="{{URL::asset('build/plugins/morris/raphael-min.js')}}"></script>
    <script src="{{URL::asset('build/plugins/morris/morris.min.js')}}"></script>
    <script src="{{URL::asset('build/plugins/morris/chart-data.js')}}"></script>
@endif  
	
@if (Route::is(['chart-peity', 'dashboard']))
    <!-- Chart JS -->
    <script src="{{URL::asset('build/plugins/peity/jquery.peity.min.js')}}"></script>
    <script src="{{URL::asset('build/plugins/peity/chart-data.js')}}"></script>
@endif    

@if (Route::is(['deals', 'estimations', 'leads']))
    <!-- Drag Card -->
	<script src="{{URL::asset('build/js/jquery-ui.min.js')}}"></script>
	<script src="{{URL::asset('build/js/jquery.ui.touch-punch.min.js')}}"></script>
@endif    

@if (Route::is(['form-fileupload']))
    <!-- Dropzone File Js -->
    <script src="{{URL::asset('build/plugins/dropzone/dropzone-min.js')}}"></script>
@endif    

@if (Route::is(['form-mask']))
	<!-- Inputmask JS -->
	<script src="{{URL::asset('build/plugins/inputmask/inputmask.min.js')}}"></script>
@endif    

@if (Route::is(['form-wizard']))
	<!-- Wizrd JS -->
	<script src="{{URL::asset('build/plugins/vanilla-wizard/js/wizard.min.js')}}"></script>

    <!-- Wizard JS -->
    <script src="{{URL::asset('build/js/form-wizard.js')}}"></script>
@endif


@if (Route::is(['maps-leaflet']))
    <!-- Leaflet Maps JS -->
    <script src="{{URL::asset('build/plugins/leaflet/leaflet.js')}}"></script>
    <script src="{{URL::asset('build/js/leaflet.js')}}"></script>
@endif    

@if (Route::is(['maps-vector']))
    <!-- JSVector Maps JS -->
	<script src="{{URL::asset('build/plugins/jsvectormap/js/jsvectormap.min.js')}}"></script>
    <script src="{{URL::asset('build/plugins/jsvectormap/maps/world-merc.js')}}"></script>
    <script src="{{URL::asset('build/js/us-merc-en.js')}}"></script>
    <script src="{{URL::asset('build/js/russia.js')}}"></script>
    <script src="{{URL::asset('build/js/spain.js')}}"></script>
    <script src="{{URL::asset('build/js/canada.js')}}"></script>
    <script src="{{URL::asset('build/js/jsvectormap.js')}}"></script>
@endif    

@if (Route::is(['kanban-view', 'ui-dragula']))
    <!-- Dragula Js-->
    <script src="{{URL::asset('build/plugins/dragula/dragula.min.js')}}"></script>
    <script src="{{URL::asset('build/js/dragula.js')}}"></script>
@endif    

@if (Route::is(['ui-clipboard']))
    <!-- Clipboard JS -->
    <script src="{{URL::asset('build/plugins/clipboard/clipboard.min.js')}}"></script>
    <script src="{{URL::asset('build/js/clipboard.js')}}"></script>
@endif    

@if (Route::is(['ui-lightbox']))
    <!-- Glightbox JS -->
    <script src="{{URL::asset('build/plugins/lightbox/glightbox.min.js')}}"></script>
    <script src="{{URL::asset('build/plugins/lightbox/lightbox.js')}}"></script>
@endif    

@if (Route::is(['ui-rangeslider']))
    <!-- noUiSlider js -->
    <script src="{{URL::asset('build/plugins/nouislider/nouislider.min.js')}}"></script>
    <script src="{{URL::asset('build/plugins/wnumb/wNumb.min.js')}}"></script>

    <!-- Rangeslider JS -->
    <script src="{{URL::asset('build/js/range-slider.js')}}"></script>
@endif    

@if (Route::is(['ui-rating']))
    <!-- Rater JS -->
    <script src="{{URL::asset('build/plugins/rater-js/index.js')}}"></script>
    <script src="{{URL::asset('build/js/ratings.js')}}"></script>
@endif    

@if (Route::is(['ui-sweetalerts', 'project-category.index', 'project-sub-category.index', 'equipment-rental-rates-hm.index', 'scoring.index', 'projects.index', 'projects.show', 'project-survey.index', 'project-survey.create', 'project-survey.show']))
    <!-- Sweet Alerts js -->
    <script src="{{URL::asset('build/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
@endif
@if (Route::is(['ui-sweetalerts']))
    <script src="{{URL::asset('build/js/sweetalerts.js')}}"></script>
@endif    

@if (Route::is(['activities', 'activity-calls', 'activity-mail', 'activity-meeting', 'activity-task', 'add-blog', 'add-invoices', 'add-page', 'appearance-settings', 'ban-ip-address', 'bank-accounts', 'blog-details', 'calendar', 'campaign-archieve', 'campaign-complete', 'campaign', 'clear-cache', 'companies-list', 'companies', 'company-details', 'company-reports', 'company-settings', 'company', 'contact-details', 'contact-reports', 'contacts-list', 'contacts', 'contracts-list', 'contracts', 'cronjob', 'currencies', 'custom-fields-setting', 'dashboard', 'database-backup', 'deal-reports', 'deals-details', 'deals-list', 'deals', 'delete-request', 'domain', 'edit-blog', 'edit-invoices', 'edit-page', 'email-settings', 'estimations-list', 'estimations', 'faq', 'form-select', 'form-wizard', 'gdpr-cookies', 'invoice-list', 'invoice-settings', 'invoices', 'kanban-view', 'language-settings', 'language-web-edit', 'language-web', 'lead-reports', 'leads-details', 'leads-list', 'leads', 'localization-settings', 'manage-users', 'membership-addons', 'membership-plans', 'membership-transactions', 'notes', 'packages', 'pages', 'payments', 'pipeline', 'preference-settings', 'printer-settings', 'profile-settings', 'project-dashboard', 'project-details', 'project-reports', 'projects-list', 'projects', 'proposals-list', 'proposals', 'purchase-transaction', 'security-settings', 'sitemap', 'sms-gateways', 'storage', 'subscription', 'system-backup', 'system-update', 'task-reports', 'tasks-completed', 'tasks-important', 'tasks', 'tax-rates', 'testimonials', 'tickets', 'todo-list', 'todo', 'equipment-rental-rates-hm.index', 'scoring.index', 'projects.index', 'projects.show', 'project-survey.index', 'project-survey.create', 'project-survey.show']))    
    <!-- Select2 JS -->
	<script src="{{URL::asset('build/plugins/select2/js/select2.min.js')}}"></script>
@endif    


@if (Route::is(['chat', 'video-call']))
	<script src="{{URL::asset('build/js/chat.js')}}"></script>
@endif   

@if (Route::is(['custom-fields-setting', 'gdpr-cookies', 'invoice-settings', 'profile-settings', 'sms-gateways']))
	<!-- Profile Upload JS -->
	<script src="{{URL::asset('build/js/profile-upload.js')}}"></script>
@endif    

@if (Route::is(['email-reply', 'email', 'social-feed']))
    <script src="{{URL::asset('build/js/email.js')}}"></script>
@endif    

@if (Route::is(['todo-list', 'todo']))
    <script src="{{URL::asset('build/js/todo.js')}}"></script>
@endif    

@if (Route::is(['activities'])) 
    <script src="{{URL::asset('build/json/activity-list.js')}}"></script>
@endif  

@if (Route::is(['leads-dashboard'])) 
    <script src="{{URL::asset('build/json/lead-project.js')}}"></script>
@endif

@if (Route::is(['activity-calls'])) 
    <script src="{{URL::asset('build/json/activity-calls.js')}}"></script>
@endif

@if (Route::is(['activity-mail'])) 
    <script src="{{URL::asset('build/json/activity-mail.js')}}"></script>
@endif


@if (Route::is(['activity-meeting'])) 
    <script src="{{URL::asset('build/json/activity-meeting.js')}}"></script>
@endif


@if (Route::is(['activity-task'])) 
    <script src="{{URL::asset('build/json/activity-task.js')}}"></script>
@endif


@if (Route::is(['blog-categories'])) 
    <script src="{{URL::asset('build/json/categories-list.js')}}"></script>
@endif


@if (Route::is(['blog-comments'])) 
    <script src="{{URL::asset('build/json/blog-comment-list.js')}}"></script>
@endif

@if (Route::is(['blog-tags'])) 
    <script src="{{URL::asset('build/json/tags-list.js')}}"></script>
@endif


@if (Route::is(['analytics'])) 
    <script src="{{URL::asset('build/json/analytic-contact.js')}}"></script>
    <script src="{{URL::asset('build/json/analytic-deal.js')}}"></script>
    <script src="{{URL::asset('build/json/analytic-company.js')}}"></script>
@endif

@if (Route::is(['calls'])) 
    <script src="{{URL::asset('build/json/calls-list.js')}}"></script>
@endif


@if (Route::is(['campaign-archieve'])) 
    <script src="{{URL::asset('build/json/campaign-archieve.js')}}"></script>
@endif


@if (Route::is(['campaign-complete'])) 
    <script src="{{URL::asset('build/json/campaign-complete.js')}}"></script>
@endif


@if (Route::is(['campaign'])) 
    <script src="{{URL::asset('build/json/campaign-list.js')}}"></script>
@endif


@if (Route::is(['cities'])) 
    <script src="{{URL::asset('build/json/cities-list.js')}}"></script>
@endif


@if (Route::is(['companies-list'])) 
    <script src="{{URL::asset('build/json/companies-list.js')}}"></script>
@endif


@if (Route::is(['contact-messages'])) 
    <script src="{{URL::asset('build/json/contact-messages-list.js')}}"></script>
@endif


@if (Route::is(['contact-reports'])) 
    <script src="{{URL::asset('build/json/contact-reports.js')}}"></script>
@endif


@if (Route::is(['contacts-list'])) 
    <script src="{{URL::asset('build/json/contacts-list.js')}}"></script>
@endif


@if (Route::is(['company-reports'])) 
    <script src="{{URL::asset('build/json/company-reports.js')}}"></script>
@endif


@if (Route::is(['contact-stage'])) 
    <script src="{{URL::asset('build/json/contact-stage.js')}}"></script>
@endif


@if (Route::is(['contracts-list'])) 
    <script src="{{URL::asset('build/json/contracts-list.js')}}"></script>
@endif

@if (Route::is(['countries'])) 
    <script src="{{URL::asset('build/json/countries-list.js')}}"></script>
@endif

@if (Route::is(['deal-reports'])) 
    <script src="{{URL::asset('build/json/deal-reports.js')}}"></script>
@endif

@if (Route::is(['deals-list'])) 
    <script src="{{URL::asset('build/json/deal-list.js')}}"></script>
@endif

@if (Route::is(['delete-request'])) 
    <script src="{{URL::asset('build/json/delete-request.js')}}"></script>
@endif

@if (Route::is(['faq'])) 
    <script src="{{URL::asset('build/json/faq-list.js')}}"></script>
@endif

@if (Route::is(['industry'])) 
    <script src="{{URL::asset('build/json/industry-list.js')}}"></script>
@endif

@if (Route::is(['language-web'])) 
    <script src="{{URL::asset('build/json/language-web.js')}}"></script>
@endif

@if (Route::is(['leads-list'])) 
    <script src="{{URL::asset('build/json/leads-list.js')}}"></script>
@endif

@if (Route::is(['lost-reason'])) 
    <script src="{{URL::asset('build/json/reason-list.js')}}"></script>
@endif

@if (Route::is(['manage-users'])) 
    <script src="{{URL::asset('build/json/manage-users-list.js')}}"></script>
@endif

@if (Route::is(['membership-transactions'])) 
    <script src="{{URL::asset('build/json/transactions-list.js')}}"></script>
@endif

@if (Route::is(['pages'])) 
    <script src="{{URL::asset('build/json/pages-list.js')}}"></script>
@endif

@if (Route::is(['payments'])) 
    <script src="{{URL::asset('build/json/payments-list.js')}}"></script>
@endif

@if (Route::is(['permission'])) 
    <script src="{{URL::asset('build/json/permission-list.js')}}"></script>
@endif

@if (Route::is(['pipeline'])) 
    <script src="{{URL::asset('build/json/pipeline-list.js')}}"></script>
@endif

@if (Route::is(['project-dashboard'])) 
    <script src="{{URL::asset('build/json/recent-project.js')}}"></script>
@endif

@if (Route::is(['project-reports'])) 
    <script src="{{URL::asset('build/json/project-reports.js')}}"></script>
@endif

@if (Route::is(['projects-list'])) 
    <script src="{{URL::asset('build/json/project-list.js')}}"></script>
@endif

@if (Route::is(['proposals-list'])) 
    <script src="{{URL::asset('build/json/proposals-list.js')}}"></script>
@endif

@if (Route::is(['roles-permissions'])) 
    <script src="{{URL::asset('build/json/roles-list.js')}}"></script>
@endif

@if (Route::is(['sources'])) 
    <script src="{{URL::asset('build/json/source-list.js')}}"></script>
@endif

@if (Route::is(['states'])) 
    <script src="{{URL::asset('build/json/states-list.js')}}"></script>
@endif

@if (Route::is(['testimonials'])) 
    <script src="{{URL::asset('build/json/testimonials-list.js')}}"></script>
@endif

@if (Route::is(['lead-reports'])) 
    <script src="{{URL::asset('build/json/leads-reports.js')}}"></script>
@endif

@if (Route::is(['tickets'])) 
    <script src="{{URL::asset('build/json/tickets-list.js')}}"></script>
@endif

@if (Route::is(['index', 'layout-rtl', 'layout-mini', 'layout-hoverview', 'layout-fullwidth', 'layout-hidden', 'layout-dark'])) 
    <script src="{{URL::asset('build/json/deals-project.js')}}"></script>
@endif  

    <!-- Main JS -->
    <script src="{{URL::asset('build/js/script.js')}}"></script>