@extends('layout.mainlayout')
@section('title', 'Buat Pembayaran Biaya')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Buat Pembayaran Biaya</h3>
                <nav class="mt-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('petty-cash-payments.index') }}">Pembayaran Biaya</a></li>
                        <li class="breadcrumb-item active">Buat</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if(session('error'))<div class="alert alert-danger alert-dismissible fade show"><i class="ti ti-alert-circle me-2"></i>{{ session('error') }}<button class="btn-close" data-bs-dismiss="alert"></button></div>@endif
        @if($errors->any())<div class="alert alert-danger alert-dismissible fade show"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul><button class="btn-close" data-bs-dismiss="alert"></button></div>@endif

        @if($availableRequests->isEmpty())
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="avatar-lg mx-auto mb-3"><div class="avatar-title bg-light rounded-circle text-muted fs-1"><i class="ti ti-file-off"></i></div></div>
                    <h5>Tidak ada Permintaan Kas Kecil yang tersedia</h5>
                    <p class="text-muted">Pastikan ada Permintaan dengan status <strong>Disetujui</strong> dan masih memiliki sisa saldo.</p>
                    <a href="{{ route('petty-cash-requests.index') }}" class="btn btn-outline-primary btn-sm"><i class="ti ti-arrow-left me-1"></i>Ke Permintaan</a>
                </div>
            </div>
        @else
        <form action="{{ route('petty-cash-payments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('petty-cash-payments._form', ['pettyCashPayment' => null])
        </form>
        @endif
    </div>
</div>
@endsection
