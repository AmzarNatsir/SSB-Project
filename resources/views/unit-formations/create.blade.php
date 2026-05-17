@extends('layout.mainlayout')
@section('title', 'Buat SK Penetapan Unit')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Buat SK Penetapan Unit</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit-formations.index') }}">SK Penetapan Unit</a></li>
                        <li class="breadcrumb-item active">Buat Baru</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @include('unit-formations._form', ['projects' => $projects, 'preselectedProjectId' => $preselectedProjectId])
            </div>
        </div>
    </div>
</div>
@endsection
