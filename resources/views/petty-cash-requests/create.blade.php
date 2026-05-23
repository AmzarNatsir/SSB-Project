@extends('layout.mainlayout')
@section('title', 'Buat Permintaan Kas Kecil')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Buat Permintaan Kas Kecil</h3>
                <nav class="mt-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('petty-cash-requests.index') }}">Permintaan Kas Kecil</a></li>
                        <li class="breadcrumb-item active">Buat</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if(session('error'))<div class="alert alert-danger alert-dismissible fade show"><i class="ti ti-alert-circle me-2"></i>{{ session('error') }}<button class="btn-close" data-bs-dismiss="alert"></button></div>@endif
        @if($errors->any())<div class="alert alert-danger alert-dismissible fade show"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul><button class="btn-close" data-bs-dismiss="alert"></button></div>@endif

        <form action="{{ route('petty-cash-requests.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('petty-cash-requests._form', ['pettyCashRequest' => null])
        </form>
    </div>
</div>
@endsection
