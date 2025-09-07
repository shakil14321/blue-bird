@extends('layouts.app')

@section('content')
<div class="card " style="width: 500px; margin-left: 30%; margin-top: 50px">
  <div class="card-header">
    <h5 class="mb-0">Add Category</h5>
  </div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label for="name" class="form-label">Category Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
      </div>
      <button type="submit" class="btn btn-primary">Create</button>
      {{-- <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Add Category</a> --}}

    </form>
  </div>
</div>
@endsection
