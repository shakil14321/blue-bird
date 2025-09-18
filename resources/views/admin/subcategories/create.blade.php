@extends('layouts.app')

@section('content')

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<div class="card" style="width: 600px; margin-left: 25%; margin-top: 40px">
  <div class="card-header">
    <h5 class="mb-0">Add Sub Category</h5>
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

    <form action="{{ route('admin.subcategories.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="mb-3">
        <label for="category_id" class="form-label">Parent Category</label>
        <select name="category_id" id="category_id" class="form-control" required>
          <option value="">-- Select Category --</option>
          @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label for="name" class="form-label">Sub Category Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
      </div>

      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
      </div>

      <!-- Multiple Images -->
      <div class="mb-3">
        <label for="images" class="form-label">Upload Images</label>
        <input type="file" name="images[]" id="images" class="form-control" multiple>
      </div>

      <!-- Dynamic YouTube Links -->
      <div class="mb-3">
        <label class="form-label">YouTube Links</label>
        <div id="youtube-links">
          <div class="input-group mb-2">
            <input type="url" name="youtube_links[]" class="form-control" placeholder="Enter YouTube URL">
            <button type="button" class="btn btn-success add-link">+</button>
          </div>
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Create</button>
      <a href="{{ route('admin.subcategories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</div>

<script>
    // CKEditor for description
    ClassicEditor.create(document.querySelector('#description')).catch(error => { console.error(error); });

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
