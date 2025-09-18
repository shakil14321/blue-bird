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

    <div class="card">
        <h5 class="card-header">All Users</h5>
        <div class="table-responsive text-nowrap">
            <table class="table ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($users as $user)
                        <tr>
                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $user->id }}</strong>
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>

                            <td>
                                @if ($user->status)
                                    <span class="badge-status badge-active">Active</span>
                                @else
                                    <span class="badge-status badge-inactive">Inactive</span>
                                @endif
                            </td>

                            <td>
                                <div>
                                    <a class="dropdown-item" href="{{ route('admin.users.show', $user->id) }}">
                                        <i class="bx bx-edit-alt me-1 ms-2"></i> view
                                    </a>

                                    <form action="{{ route('admin.users.toggleStatus', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="dropdown-item text-start border-0 bg-transparent">
                                            @if ($user->status)
                                                <i class="bx bx-toggle-left icon-lg text-warning me-1"></i>Deactivate
                                            @else
                                                <i class="bx bx-toggle-right icon-lg text-success me-1"></i> Activate
                                            @endif
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center mt-3">
            {!! $users->links('pagination::bootstrap-5') !!}
        </div>


    </div>
@endsection
