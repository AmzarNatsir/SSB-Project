<div class="card border-0">
    <div class="card-body pb-0 pt-0 px-2">
        <ul class="nav nav-tabs nav-bordered nav-bordered-primary">
            <li class="nav-item me-3">
                <a href="{{url('profile-settings')}}" class="nav-link p-2 {{ Request::is('connected-apps','notifications-settings','profile-settings','security-settings') ? 'active' : '' }}">
                    <i class="ti ti-settings-cog me-2"></i>General Settings
                </a>
            </li>
            <li class="nav-item me-3">
                <a href="{{url('company-settings')}}" class="nav-link p-2 {{ Request::is('company-settings','localization-settings','prefixes-settings','preference-settings','appearance-settings','language-settings','language-web','language-web-edit') ? 'active' : '' }}">
                    <i class="ti ti-world-cog me-2"></i>Website Settings
                </a>
            </li>
            <li class="nav-item me-3">
                <a href="{{url('invoice-settings')}}" class="nav-link p-2 {{ Request::is('invoice-settings','printers-settings','custom-fields-setting') ? 'active' : '' }}">
                    <i class="ti ti-apps me-2"></i>App Settings
                </a>
            </li>
            <li class="nav-item me-3">
                <a href="{{url('email-settings')}}" class="nav-link p-2 {{ Request::is('email-settings','sms-gateways','gdpr-cookies') ? 'active' : '' }}">
                    <i class="ti ti-device-laptop me-2"></i>System Settings
                </a>
            </li>
            <li class="nav-item me-3">
                <a href="{{url('payment-gateways')}}" class="nav-link p-2 {{ Request::is('payment-gateways','bank-accounts','tax-rates', 'currencies') ? 'active' : '' }}">
                    <i class="ti ti-moneybag me-2"></i>Financial Settings
                </a>
            </li>
            <li class="nav-item">
                <a href="{{url('sitemap')}}" class="nav-link p-2 {{ Request::is('sitemap','clear-cache','storage','cronjob','ban-ip-address','system-backup','database-backup','system-update') ? 'active' : '' }}">
                    <i class="ti ti-flag-cog me-2"></i>Other Settings
                </a>
            </li>
        </ul>
    </div> <!-- end card body -->
</div> <!-- end card -->

