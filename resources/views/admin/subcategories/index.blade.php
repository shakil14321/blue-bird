@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Sub Categories</h5>
            <a href="{{ route('admin.subcategories.create') }}" class="btn btn-primary">Add Sub Category</a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($subcategories->count())
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Images</th>
                                <th>YouTube Links</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subcategories as $sub)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sub->category->name }}</td>
                                    <td>{{ $sub->name }}</td>
                                    <td>{!! $sub->description !!}</td>

                                    <!-- Show Images -->
                                    <td>
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($sub->media->where('media_type', 'image') as $media)
                                                <img src="{{ $media->url }}"
                                                    style="width:50px; height:50px; object-fit:cover; border-radius:4px;">
                                            @endforeach
                                        </div>
                                    </td>

                                    <!-- Show YouTube Links -->
                                    <td>
                                        <ul class="mb-0">
                                            @foreach ($sub->media->where('media_type', 'youtube') as $media)
                                                <li><a href="{{ $media->url }}" target="_blank">Link</a></li>
                                            @endforeach
                                        </ul>
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.subcategories.edit', $sub->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('admin.subcategories.destroy', $sub) }}" method="POST"
                                            style="display:inline" onsubmit="return confirm('Delete this subcategory?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">No subcategories found.</p>
            @endif
        </div>

        <div class="d-flex justify-content-center mt-3">
            {!! $subcategories->links('pagination::bootstrap-5') !!}
        </div>
    </div>
@endsection
