<!DOCTYPE html>
@if (Route::is('layout-hidden'))
    <html lang="en" data-layout="hidden">
@elseif (Route::is('layout-hover-view'))
    <html lang="en" data-layout="hoverview">
@elseif (Route::is('layout-mini'))
    <html lang="en" data-layout="mini">
@elseif (Route::is('layout-rtl'))
    <html lang="en" dir="rtl">
@elseif (Route::is('layout-dark'))
    <html lang="en" data-bs-theme="dark">
@elseif (Route::is('layout-fullwidth'))
    <html lang="en" data-layout="full-width">
@else
    <html lang="en">
@endif

{{-- HEAD TAG --}}

<head>

    @include('layout.partials.title-meta')

    @include('layout.partials.head-css')
    @stack('styles')

</head>

{{-- BODY TAG --}}

@if (!Route::is(['layout-mini', 'login', 'email-verification', 'forgot-password', 'register', 'reset-password', 'success', 'two-step-verification','error-404', 'error-500', 'under-maintenance', 'coming-soon']))
<body>
@endif

@if (Route::is(['layout-mini']))
<body class="mini-sidebar">
@endif

@if (Route::is(['login']))
<body class="account-page bg-white">
@endif

@if (Route::is(['coming-soon']))
<body class="comming-soon">
@endif

@if (Route::is(['email-verification', 'forgot-password', 'register', 'reset-password', 'success', 'two-step-verification']))
<body class="account-page">
@endif

@if (Route::is(['error-404', 'error-500', 'under-maintenance']))
<body class="error-page">
@endif

    <!-- Start Main Wrapper -->
    <div class="main-wrapper">

    @if (!Route::is(['login', 'register', 'forgot-password','reset-password', 'success', 'email-verification', 'two-step-verification', 'lock-screen', 'error-404', 'error-500', 'coming-soon', 'under-maintenance']))
        @include('layout.partials.header')

        @include('layout.partials.sidebar')
    @endif

        @yield('content')   

        @component('components.modal-popup')
        @endcomponent

    </div>
    <!-- End Main Wrapper -->

    @include('layout.partials.footer-scripts')
    @stack('scripts')

</body>
</html>