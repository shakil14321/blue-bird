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

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Quotation Details #</h5>
            @if($quotation->quotationDetails && count($quotation->quotationDetails) > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quotation->quotationDetails as $item)
                            @php
                                $subcategories = $item->subcategory;
                            @endphp
                            <tr>
                                <td>{{ $subcategories->name ?? 'N/A' }}</td>
                                <td>{{ $subcategories->description ?? 'N/A' }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>
                                    <input type="number" class="form-control" value="{{ number_format($item['unit_price'], 2) }}">
                                </td>
                                <td>${{ number_format($item['quantity'] * $item['unit_price'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No items found for this quotation.</p>
            @endif
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.quotations.index') }}" class="btn btn-secondary">← Back to Quotations</a>
    </div>
</div>
@endsection
