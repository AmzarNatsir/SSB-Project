@extends('layout.mainlayout')
@section('title', 'Buat SK Penugasan Tim')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Buat SK Penugasan Tim</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('workforce-formations.index') }}">SK Penugasan Tim</a></li>
                        <li class="breadcrumb-item active">Buat Baru</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @include('workforce-formations._form', ['projects' => $projects])
            </div>
        </div>
    </div>
</div>
@endsection
