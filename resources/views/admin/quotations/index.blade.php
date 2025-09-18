@extends('layouts.app')

@section('content')

<style>
        /* Status badges */
        .badge-status {
            padding: 6px 12px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 5px;
            color: white;
        }

        .badge-active {
            background-color: #90ee90;
            /* Light green */
        }

        .badge-inactive {
            background-color: #ff4d4d;
            /* Red */
        }

        .icon-lg {
            font-size: 35px;
        }
    </style>



<div class="container">
    <h2 class="mb-4">All Quotations</h2>

    <form action="{{ route('admin.quotations.index') }}" method="GET" class="mb-4">        
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by ID or User Name" value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

<div class="card">
    <div class="table-responsive text-nowrap">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Address</th>
                    <th>Event Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($quotations as $index => $quotation)
                    <tr>
                        <td>{{ $quotations->firstItem() + $index }}</td>
                        <td>{{ $quotation->user->name ?? 'N/A' }}</td>
                        <td>{{ $quotation->address }}</td>
                        <td>{{ $quotation->event_date ?? 'N/A' }}</td>
                        <td>
                            <span class="badge 
                                @if($quotation->status == 'Pending') bg-warning 
                                @elseif($quotation->status == 'Confirmed') bg-success 
                                @elseif($quotation->status == 'Cancelled') bg-danger 
                                @endif
                            ">
                                {{ $quotation->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.quotations.show', $quotation->id) }}" 
                               class="btn btn-outline-primary btn-sm">
                                View Quotation
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No quotations found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $quotations->links() }}
        </div>
    </div>
</div>

</div>
@endsection
