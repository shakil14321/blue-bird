@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header">
    <h5>Edit Category</h5>
  </div>
  <div class="card-body">
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="form-group mb-3">
        <label for="name">Category Name</label>
        <input type="text" name="name" id="name" class="form-control"
               value="{{ old('name', $category->name) }}" required>
        @error('name')
          <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group mb-3">
        <label>Existing Images</label>
        <div class="d-flex flex-wrap gap-2 mb-2">
            @forelse ($category->media as $media)
                <img src="{{ asset($media->url) }}" alt="Category Image"
                     style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
            @empty
                <span class="text-muted">No images</span>
            @endforelse
        </div>
      </div>

      <div class="form-group mb-3">
        <label for="images">Upload New Images</label>
        <input type="file" name="images[]" id="images" class="form-control" multiple>
        @error('images.*')
          <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      <button type="submit" class="btn btn-success">Update</button>
      <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</div>
@endsection
