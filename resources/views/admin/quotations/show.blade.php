@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Quotation Details</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Quotation #{{ $quotation->id }}</h5>

            <p>
                <strong>User:</strong> {{ $quotation->user->name ?? 'N/A' }} <br>
                <strong>Email:</strong> {{ $quotation->user->email ?? 'N/A' }} <br>
                <strong>Phone:</strong> {{ $quotation->user->phone ?? 'N/A' }} <br>
                <strong>Address:</strong> {{ $quotation->address }} <br>
                <strong>Event Date:</strong> {{ $quotation->event_date ?? 'N/A' }} <br>
                {{-- <strong>summery:</strong> {{ $quotation->cart_id }}  <br> --}}
                <strong>Budget:</strong> {{ $quotation->budget ? '$'.$quotation->budget : 'N/A' }} <br>
                <strong>Discount:</strong> {{ $quotation->discount ? $quotation->discount.'%' : 'N/A' }} <br>
                <strong>Request Details:</strong> {{ $quotation->request_details ?? 'N/A' }} <br>
                <strong>Response Details:</strong> {{ $quotation->response_details ?? 'Not Responded' }}
            </p>

            <p>
                <strong>Status:</strong>
                <span class="badge 
                    @if($quotation->status == 'Pending') bg-warning 
                    @elseif($quotation->status == 'Confirmed') bg-success 
                    @elseif($quotation->status == 'Cancelled') bg-danger 
                    @endif
                ">
                    {{ $quotation->status }}
                </span>
            </p>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.quotations.index') }}" class="btn btn-secondary">← Back to Quotations</a>
    </div>
</div>
@endsection
