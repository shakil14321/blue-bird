@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header">
    <h5>Edit Sub Category</h5>
  </div>
  <div class="card-body">
    <form action="{{ route('admin.subcategories.update', $subcategory->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group mb-3">
        <label for="category_id">Category</label>
        <select name="category_id" id="category_id" class="form-control" required>
          @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ $subcategory->category_id == $category->id ? 'selected' : '' }}>
              {{ $category->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="form-group mb-3">
        <label for="name">Sub Category Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $subcategory->name) }}" required>
        @error('name')
          <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group mb-3">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control">{{ old('description', $subcategory->description) }}</textarea>
      </div>

      <button type="submit" class="btn btn-success">Update</button>
      <a href="{{ route('admin.subcategories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</div>
@endsection
