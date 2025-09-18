@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">All Quotations</h2>

    <form action="{{ route('admin.quotations.index') }}" method="GET" class="mb-4">        
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by ID or User Name" value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>


    <div class="row">
        @forelse($quotations as $index => $quotation)
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Quotation {{ $quotations->firstItem() + $index }}</h5>
                        <p class="card-text">
                            <strong>User:</strong> {{ $quotation->user->name ?? 'N/A' }} <br>
                            <strong>Address:</strong> {{ $quotation->address }} <br>
                            <strong>Event Date:</strong> {{ $quotation->event_date ?? 'N/A' }} <br>
                        </p>
                        

                        {{-- Status Badge --}}
                        <span class="badge 
                            @if($quotation->status == 'Pending') bg-warning 
                            @elseif($quotation->status == 'Confirmed') bg-success 
                            @elseif($quotation->status == 'Cancelled') bg-danger 
                            @endif
                        ">
                            {{ $quotation->status }}
                        </span>

                        <div class="mt-3">
                            <a href="{{ route('admin.quotations.show', $quotation->id) }}" class="btn btn-outline-primary btn-sm">
                                View Quotation
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p>No quotations found.</p>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $quotations->links() }}
    </div>
</div>
@endsection
