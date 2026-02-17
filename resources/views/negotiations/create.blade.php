@extends('layout.mainlayout')
@section('title', 'Start Negotiation')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Start New Negotiation</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('negotiations.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label">Select Quotation to Negotiate</label>
                                <select name="quotation_id" class="form-select select2" required>
                                    <option value="">-- Select Quotation --</option>
                                    @foreach($quotations as $quote)
                                    <option value="{{ $quote->id }}">
                                        {{ $quote->project->project_name }} - {{ $quote->uid }} (Rp {{ number_format($quote->selling_price, 0) }})
                                    </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Only quotations with status 'SUBMITTED' or 'APPROVED' (and not yet in negotiation) can be selected.</div>
                            </div>
                            
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('negotiations.index') }}" class="btn btn-light">Cancel</a>
                                <button type="submit" class="btn btn-primary">Start Negotiation</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
