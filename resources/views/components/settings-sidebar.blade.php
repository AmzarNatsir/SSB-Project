<div class="col-xl-3 col-lg-12 theiaStickySidebar">

    <div class="card mb-3 mb-xl-0">
        <div class="card-body">

            @if (Route::is(['connected-apps','notifications-settings','profile-settings','security-settings']))
            <div class="settings-sidebar">
                <h5 class="mb-3 fs-17">General Settings</h5>
                <div class="list-group list-group-flush settings-sidebar">
                    <a href="{{url('profile-settings')}}" class="d-block p-2 fw-medium {{ Request::is('profile-settings') ? 'active' : '' }}">Profile</a>
                    <a href="{{url('security-settings')}}" class="d-block p-2 fw-medium {{ Request::is('security-settings') ? 'active' : '' }}">Security</a>
                    <a href="{{url('notifications-settings')}}" class="d-block p-2 fw-medium {{ Request::is('notifications-settings') ? 'active' : '' }}">Notifications</a>
                    <a href="{{url('connected-apps')}}" class="d-block p-2 fw-medium {{ Request::is('connected-apps') ? 'active' : '' }}">Connected Apps</a>
                </div>
            </div>
            @endif

            @if (Route::is(['company-settings','localization-settings','prefixes-settings','preference-settings','appearance-settings','language-settings','language-web','language-web-edit']))
            <div class="settings-sidebar">
                <h5 class="mb-3 fs-17">Website Settings</h5>
                <div class="list-group list-group-flush settings-sidebar">
                    <a href="{{url('company-settings')}}" class="d-block p-2 fw-medium {{ Request::is('company-settings') ? 'active' : '' }}">Company Settings</a>
                    <a href="{{url('localization-settings')}}" class="d-block p-2 fw-medium {{ Request::is('localization-settings') ? 'active' : '' }}">Localization</a>
                    <a href="{{url('prefixes-settings')}}" class="d-block p-2 fw-medium {{ Request::is('prefixes-settings') ? 'active' : '' }}">Prefixes</a>
                    <a href="{{url('preference-settings')}}" class="d-block p-2 fw-medium {{ Request::is('preference-settings') ? 'active' : '' }}">Preference</a>
                    <a href="{{url('appearance-settings')}}" class="d-block p-2 fw-medium {{ Request::is('appearance-settings') ? 'active' : '' }}">Appearance</a>
                    <a href="{{url('language-settings')}}" class="d-block p-2 fw-medium {{ Request::is('language-settings', 'language-web', 'language-web-edit') ? 'active' : '' }}">Language</a>
                </div>
            </div>
            @endif

            @if (Route::is(['invoice-settings','printers-settings','custom-fields-setting']))
            <div class="settings-sidebar">
                <h5 class="mb-3 fs-17">App Settings</h5>
                <div class="list-group list-group-flush settings-sidebar">
                    <a href="{{url('invoice-settings')}}" class="d-block p-2 fw-medium {{ Request::is('invoice-settings') ? 'active' : '' }}">Invoice Settings</a>
                    <a href="{{url('printers-settings')}}" class="d-block p-2 fw-medium {{ Request::is('printers-settings') ? 'active' : '' }}">Printer</a>
                    <a href="{{url('custom-fields-setting')}}" class="d-block p-2 fw-medium {{ Request::is('custom-fields-setting') ? 'active' : '' }}">Custom Fields</a>
                </div>
            </div>
            @endif

            @if (Route::is(['email-settings','sms-gateways','gdpr-cookies']))
            <div class="settings-sidebar">
                <h5 class="mb-3 fs-17">System Settings</h5>
                <div class="list-group list-group-flush settings-sidebar">
                    <a href="{{url('email-settings')}}" class="d-block p-2 fw-medium {{ Request::is('email-settings') ? 'active' : '' }}">Email Settings</a>
                    <a href="{{url('sms-gateways')}}" class="d-block p-2 fw-medium {{ Request::is('sms-gateways') ? 'active' : '' }}">SMS Gateways</a>
                    <a href="{{url('gdpr-cookies')}}" class="d-block p-2 fw-medium {{ Request::is('gdpr-cookies') ? 'active' : '' }}">GDPR Cookies</a>
                </div>
            </div>
            @endif

            @if (Route::is(['payment-gateways','bank-accounts','tax-rates', 'currencies']))
            <div class="settings-sidebar">
                <h4 class="fw-bold mb-3 fs-17">Financial Settings</h4>
                <div class="list-group list-group-flush settings-sidebar">
                    <a href="{{url('payment-gateways')}}" class="d-block p-2 fw-medium {{ Request::is('payment-gateways') ? 'active' : '' }}">Payment Gateways</a>
                    <a href="{{url('bank-accounts')}}" class="d-block p-2 fw-medium {{ Request::is('bank-accounts') ? 'active' : '' }}">Bank Accounts</a>
                    <a href="{{url('tax-rates')}}" class="d-block p-2 fw-medium {{ Request::is('tax-rates') ? 'active' : '' }}">Tax Rates</a>
                    <a href="{{url('currencies')}}" class="d-block p-2 fw-medium {{ Request::is('currencies') ? 'active' : '' }}">Currencies</a>
                </div>
            </div>
            @endif

            @if (Route::is(['sitemap','clear-cache','storage','cronjob','ban-ip-address','system-backup','database-backup','system-update']))
            <div class="settings-sidebar">
                <h4 class="fs-17 mb-3">Other Settings</h4>
                <div class="list-group list-group-flush settings-sidebar">
                    <a href="{{url('sitemap')}}" class="d-block p-2 fw-medium {{ Request::is('sitemap') ? 'active' : '' }}">Sitemap</a>
                    <a href="{{url('clear-cache')}}" class="d-block p-2 fw-medium {{ Request::is('clear-cache') ? 'active' : '' }}">Clear Cache </a>
                    <a href="{{url('storage')}}" class="d-block p-2 fw-medium {{ Request::is('storage') ? 'active' : '' }}">Storage</a>
                    <a href="{{url('cronjob')}}" class="d-block p-2 fw-medium {{ Request::is('cronjob') ? 'active' : '' }}">Cronjob</a>
                    <a href="{{url('ban-ip-address')}}" class="d-block p-2 fw-medium {{ Request::is('ban-ip-address') ? 'active' : '' }}">Ban IP Address</a>
                    <a href="{{url('system-backup')}}" class="d-block p-2 fw-medium {{ Request::is('system-backup') ? 'active' : '' }}">System Backup</a>
                    <a href="{{url('database-backup')}}" class="d-block p-2 fw-medium {{ Request::is('database-backup') ? 'active' : '' }}">Database Backup</a>
                    <a href="{{url('system-update')}}" class="d-block p-2 fw-medium {{ Request::is('system-update') ? 'active' : '' }}">System Update</a>
                </div>
            </div>
            @endif

        </div> <!-- end card body -->
    </div> <!-- end card -->

</div> <!-- end col -->