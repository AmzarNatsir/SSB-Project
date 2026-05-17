@extends('layout.mainlayout')
@section('title', 'Edit SK Penugasan Tim')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Edit SK — {{ $formation->formation_number }}</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('workforce-formations.index') }}">SK Penugasan Tim</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('workforce-formations.show', $formation->uid) }}">{{ $formation->formation_number }}</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
            <div>
                <span class="badge bg-{{ $formation->status->color() }}-subtle text-{{ $formation->status->color() }} fs-12 text-uppercase">
                    {{ $formation->status->label() }}
                </span>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @include('workforce-formations._form', ['projects' => $projects, 'formation' => $formation])
            </div>
        </div>
    </div>
</div>
@endsection
