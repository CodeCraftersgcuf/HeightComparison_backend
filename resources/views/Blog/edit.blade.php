@extends('welcome')

@section('title', 'Edit Blog')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Edit Blog Post</h2>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Add PUT method for updating the blog post -->

                <!-- Title Input -->
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $blog->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Meta Title Input -->
                <div class="mb-3">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" class="form-control @error('meta_title') is-invalid @enderror" value="{{ old('meta_title', $blog->meta_title) }}" required>
                    @error('meta_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description Input -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="summernote form-control @error('description') is-invalid @enderror" rows="10" placeholder="Description">{{ old('description', $blog->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Meta Description Input -->
                <div class="mb-3">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" class="summernote form-control @error('meta_description') is-invalid @enderror" rows="10" placeholder="Meta Description">{{ old('meta_description', $blog->meta_description) }}</textarea>
                    @error('meta_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Featured Image Input -->
                <div class="mb-3">
                    <label for="featured_image" class="form-label">Featured Image</label>
                    <input type="file" name="featured_image" id="featured_image" class="form-control @error('featured_image') is-invalid @enderror">
                    @if($blog->featured_image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/images/' . $blog->featured_image) }}" alt="Featured Image" width="150px">
                        </div>
                    @endif
                    @error('featured_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tags Input -->
                <div class="mt-3 mb-3">
                    <label for="tags" class="form-label">Tags</label>
                    <select name="tags[]" id="tags" class="form-control @error('tags') is-invalid @enderror" multiple="multiple">
                        <!-- Populating the existing tags in the blog -->
                        @foreach($existingTags as $tag)
                        <option value="{{ $tag }}" selected>{{ $tag }}</option>
                    @endforeach
                        {{-- @foreach(['electronics', 'gaming', 'laptop'] as $tag)
                            <option value="{{ $tag }}" {{ in_array($tag, old('tags', explode(',', $blog->tags))) ? 'selected' : '' }}>
                                {{ ucfirst($tag) }}
                            </option>
                        @endforeach --}}
                    </select>
                    @error('tags')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Update Blog</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {

        // Initialize Select2 on the tags input field
        $('#tags').select2({
            placeholder: "Select or Add Tags",
            tags: true,  // Allow the user to add custom tags
            tokenSeparators: [',', ' '],  // Allow commas or spaces to separate tags
            maximumSelectionLength: 5  // Optional: Limit the number of tags a user can select
        });
    });
</script>
@endpush
