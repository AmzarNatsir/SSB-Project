@extends('layout.mainlayout')
@section('title', 'Buat Timesheet')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Buat Timesheet</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('timesheets.index') }}">Timesheet Journal</a></li>
                        <li class="breadcrumb-item active">Buat Baru</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @include('timesheets._form', [
                    'projects' => $projects,
                    'preselectedProjectId' => $preselectedProjectId,
                    'preselectedDate' => $preselectedDate,
                ])
            </div>
        </div>
    </div>
</div>
@endsection
