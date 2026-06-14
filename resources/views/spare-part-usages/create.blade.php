@extends('layout.mainlayout')
@section('title', 'Input Spare Part Usage')

@section('content')
<div class="page-wrapper">
    <div class="content">

        <div class="mb-3">
            <h4 class="fw-bold mb-1"><i class="ti ti-tool text-warning me-2"></i>Input Pemakaian Spare Part</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('spare-part-usages.index') }}">Spare Part Usage</a></li>
                    <li class="breadcrumb-item active">Tambah Baru</li>
                </ol>
            </nav>
        </div>

        <form method="POST" action="{{ route('spare-part-usages.store') }}">
            @csrf
            @include('spare-part-usages._form')
        </form>

    </div>
</div>
@endsection
