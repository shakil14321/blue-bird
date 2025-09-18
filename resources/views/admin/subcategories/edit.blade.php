@extends('layouts.app')

@section('content')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<div class="card">
  <div class="card-header">
    <h5>Edit Sub Category</h5>
  </div>
  <div class="card-body">
    <form action="{{ route('admin.subcategories.update', $subcategory->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <!-- Category -->
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

      <!-- Name -->
      <div class="form-group mb-3">
        <label for="name">Sub Category Name</label>
        <input type="text" name="name" id="name" class="form-control" 
               value="{{ old('name', $subcategory->name) }}" required>
        @error('name')
          <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      <!-- Description -->
      <div class="form-group mb-3">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control">{{ old('description', $subcategory->description) }}</textarea>
      </div>

      <!-- Existing Images -->
      <div class="form-group mb-3">
        <label>Existing Images</label>
        <div class="d-flex flex-wrap gap-2">
          @forelse ($subcategory->media->where('media_type','image') as $media)
            <img src="{{ $media->url }}" alt="Image" 
                 style="width:80px; height:80px; object-fit:cover; border-radius:5px;">
          @empty
            <span class="text-muted">No images</span>
          @endforelse
        </div>
      </div>

      <!-- Upload New Images -->
      <div class="form-group mb-3">
        <label for="images">Upload New Images</label>
        <input type="file" name="images[]" id="images" class="form-control" multiple>
      </div>

      <!-- Existing YouTube Links -->
      <div class="form-group mb-3">
        <label>Existing YouTube Links</label>
        <ul>
          @forelse ($subcategory->media->where('media_type','youtube') as $media)
            <li><a href="{{ $media->url }}" target="_blank">{{ $media->url }}</a></li>
          @empty
            <li class="text-muted">No YouTube links</li>
          @endforelse
        </ul>
      </div>

      <!-- Add New YouTube Links -->
      <div class="form-group mb-3">
        <label>YouTube Links</label>
        <div id="youtube-links">
          <div class="input-group mb-2">
            <input type="url" name="youtube_links[]" class="form-control" placeholder="Enter YouTube URL">
            <button type="button" class="btn btn-success add-link">+</button>
          </div>
        </div>
      </div>

      <button type="submit" class="btn btn-success">Update</button>
      <a href="{{ route('admin.subcategories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</div>

<script>
    ClassicEditor.create(document.querySelector('#description')).catch(error => console.error(error));

    // Dynamic YouTube link fields
    document.addEventListener("click", function(e) {
      if (e.target.classList.contains("add-link")) {
        let container = document.getElementById("youtube-links");
        let div = document.createElement("div");
        div.classList.add("input-group", "mb-2");
        div.innerHTML = `
          <input type="url" name="youtube_links[]" class="form-control" placeholder="Enter YouTube URL">
          <button type="button" class="btn btn-danger remove-link">-</button>
        `;
        container.appendChild(div);
      }
      if (e.target.classList.contains("remove-link")) {
        e.target.parentElement.remove();
      }
    });
</script>
@endsection
