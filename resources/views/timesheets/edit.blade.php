@extends('layout.mainlayout')
@section('title', 'Edit Timesheet')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Edit Timesheet — {{ $journal->journal_number }}</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('timesheets.index') }}">Timesheet Journal</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('timesheets.show', $journal->uid) }}">{{ $journal->journal_number }}</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
            <div>
                <span class="badge bg-{{ $journal->status->color() }}-subtle text-{{ $journal->status->color() }} fs-12 text-uppercase">
                    {{ $journal->status->label() }}
                </span>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @include('timesheets._form', ['projects' => $projects, 'journal' => $journal])
            </div>
        </div>
    </div>
</div>
@endsection
