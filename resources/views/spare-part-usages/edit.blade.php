@extends('layout.mainlayout')
@section('title', 'Edit Spare Part Usage')

@section('content')
<div class="page-wrapper">
    <div class="content">

        <div class="mb-3">
            <h4 class="fw-bold mb-1"><i class="ti ti-edit text-warning me-2"></i>Edit: {{ $spu->usage_number }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('spare-part-usages.index') }}">Spare Part Usage</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('spare-part-usages.show', $spu->uid) }}">{{ $spu->usage_number }}</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>

        <form method="POST" action="{{ route('spare-part-usages.update', $spu->uid) }}">
            @csrf @method('PUT')
            @include('spare-part-usages._form', ['spu' => $spu])
        </form>

    </div>
</div>
@endsection
