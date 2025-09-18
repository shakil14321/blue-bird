@extends('layouts.app')

@section('content')
    <div class="card">
        <h5 class="card-header">All Users</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-dark">
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

                            <td><span class="badge bg-label-primary me-1">
                                    @if ($user->status)
                                        <span>Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </span></td>
                            <td>
                                <div class="dropdown ">
                                    <button type="button" class="  btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">

                                        <a class="dropdown-item text-black"
                                            href="{{ route('admin.users.show', $user->id) }}"><i
                                                class="bx bx-edit-alt me-1 ms-2 text-black"></i> view</a>

                                        <form action="{{ route('admin.users.toggleStatus', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="dropdown-item text-start border-0 bg-transparent">
                                                @if ($user->status)
                                                    <!-- If Active, show deactivate icon -->
                                                    <i class="bx bx-toggle-left text-warning me-1"></i> Deactivate
                                                @else
                                                    <!-- If Inactive, show activate icon -->
                                                    <i class="bx bx-toggle-right text-success me-1"></i> Activate
                                                @endif
                                            </button>
                                        </form>

                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Pagination Links -->
        <div class="d-flex justify-content-center mt-3">
            {{ $users->links() }}
        </div>

        <p>Total users: {{ $users->total() }}</p>

    </div>





    {{-- <div class="card">
  <div class="card-header">
    <h5 class="mb-0">All Users</h5>
  </div>
  <div class="card-body">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
          <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone }}</td>
            <td>
              @if ($user->status)
                <span class="badge bg-success">Active</span>
              @else
                <span class="badge bg-danger">Inactive</span>
              @endif
            </td>
            <td>
              <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info btn-sm">View</a>
              <form action="{{ route('admin.users.toggleStatus', $user->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-warning btn-sm">
                  {{ $user->status ? 'Deactivate' : 'Activate' }}
                </button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div> --}}
@endsection
