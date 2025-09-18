@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header">
    <h5>Edit Category</h5>
  </div>
  <div class="card-body">
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group mb-3">
        <label for="name">Category Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" required>
        @error('name')
          <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      <button type="submit" class="btn btn-success">Update</button>
      <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</div>
@endsection
