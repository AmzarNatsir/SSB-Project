    <!-- jQuery -->
    <script src="{{URL::asset('build/js/jquery-3.7.1.min.js')}}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{URL::asset('build/js/bootstrap.bundle.min.js')}}"></script>    

	<!-- Simplebar JS -->
	<script src="{{URL::asset('build/plugins/simplebar/simplebar.min.js')}}"></script>

@if (Route::is(['activities', 'activity-calls', 'activity-mail', 'activity-meeting', 'activity-task', 'analytics', 'blog-categories', 'blog-comments', 'blog-tags', 'calls', 'campaign-archieve', 'campaign-complete', 'campaign', 'cities', 'companies-list', 'company-reports', 'company', 'contact-messages', 'contact-reports', 'contact-stage', 'contacts-list', 'contracts-list', 'countries', 'data-tables', 'deal-reports', 'deals-list', 'delete-request', 'domain', 'estimations-list', 'faq', 'index', 'industry', 'language-settings', 'language-web-edit', 'language-web', 'layout-dark', 'layout-fullwidth', 'layout-hidden', 'layout-hoverview', 'layout-mini', 'layout-rtl', 'lead-reports', 'leads-dashboard', 'leads-list', 'leads', 'lost-reason', 'manage-users', 'manage-users.index', 'membership-transactions', 'packages', 'pages', 'payments', 'permission', 'permissions.index', 'pipeline', 'printers-settings', 'project-category.index', 'project-sub-category.index', 'equipment-rental-rates-hm.index', 'scoring.index', 'scoring-plan-project.index', 'projects.index', 'project-dashboard', 'project-reports', 'projects-list', 'projects', 'proposals-list', 'purchase-transaction', 'roles-permissions', 'roles-permissions.index', 'sources', 'states', 'subscription', 'task-reports', 'testimonials', 'tickets', 'project-survey.index', 'budgets.index', 'approval-flows.*']))    
    <!-- Datatable JS -->
    <script src="{{URL::asset('build/plugins/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('build/plugins/datatables/js/dataTables.bootstrap5.min.js')}}"></script>
@endif 

@if (Route::is(['project-survey.index']))
    <!-- Datatable JS -->
    <script src="{{URL::asset('build/plugins/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('build/plugins/datatables/js/dataTables.bootstrap5.min.js')}}"></script>
@endif

@if (Route::is(['ui-sweetalerts', 'project-category.index', 'project-sub-category.index', 'equipment-rental-rates-hm.index', 'scoring.index', 'scoring-plan-project.*', 'projects.index', 'projects.show', 'project-survey.index', 'project-survey.create', 'project-survey.show', 'budgets.index', 'budgets.create', 'budgets.edit', 'budgets.show', 'manage-users.index', 'roles-permissions.index', 'permissions.index', 'approval-flows.*', 'quotations.*', 'unit-requests.*', 'final-contracts.*', 'surveyor-flows.index']))
    <!-- Sweet Alerts js -->
    <script src="{{URL::asset('build/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
@endif
@if (Route::is(['ui-sweetalerts']))
    <script src="{{URL::asset('build/js/sweetalerts.js')}}"></script>
@endif    

@if (Route::is(['activities', 'activity-calls', 'activity-mail', 'activity-meeting', 'activity-task', 'add-blog', 'add-invoices', 'add-page', 'appearance-settings', 'ban-ip-address', 'bank-accounts', 'blog-details', 'calendar', 'campaign-archieve', 'campaign-complete', 'campaign', 'clear-cache', 'companies-list', 'companies', 'company-details', 'company-reports', 'company-settings', 'company', 'contact-details', 'contact-reports', 'contacts-list', 'contacts', 'contracts-list', 'contracts', 'cronjob', 'currencies', 'custom-fields-setting', 'dashboard', 'database-backup', 'deal-reports', 'deals-details', 'deals-list', 'deals', 'delete-request', 'domain', 'edit-blog', 'edit-invoices', 'edit-page', 'email-settings', 'estimations-list', 'estimations', 'faq', 'form-select', 'form-wizard', 'gdpr-cookies', 'invoice-list', 'invoice-settings', 'invoices', 'kanban-view', 'language-settings', 'language-web-edit', 'language-web', 'lead-reports', 'leads-details', 'leads-list', 'leads', 'localization-settings', 'manage-users', 'manage-users.index', 'membership-addons', 'membership-plans', 'membership-transactions', 'notes', 'packages', 'pages', 'payments', 'pipeline', 'preference-settings', 'printer-settings', 'profile-settings', 'project-dashboard', 'project-details', 'project-reports', 'projects-list', 'projects', 'proposals-list', 'proposals', 'purchase-transaction', 'roles-permissions.index', 'permissions.index', 'approval-flows.*', 'security-settings', 'sitemap', 'sms-gateways', 'storage', 'subscription', 'system-backup', 'system-update', 'task-reports', 'tasks-completed', 'tasks-important', 'tasks', 'tax-rates', 'testimonials', 'tickets', 'todo-list', 'todo', 'equipment-rental-rates-hm.index', 'scoring.index', 'scoring-plan-project.*', 'projects.index', 'projects.show', 'project-survey.index', 'project-survey.create', 'project-survey.show', 'budgets.index', 'budgets.create', 'budgets.edit', 'budgets.show', 'quotations.*', 'unit-requests.*', 'final-contracts.*', 'surveyor-flows.index']))    
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