@extends('welcome')

@section('title', 'Blog List')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Blog Posts</h2>

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Create Blog Button -->
    <div class="text-end mb-4">
        <a href="{{ route('blogs.create') }}" class="btn btn-primary">Create New Blog</a>
    </div>

    <!-- Blog List -->

    <div class="blog-post mb-4">
        <h3>{{ $blog->title }}</h3>
        <p><strong>{{ $blog->meta_title }}</strong></p>

        <!-- Featured Image -->
        @if ($blog->featured_image)
            <img src="{{ asset('storage/images/' . $blog->featured_image) }}" alt="Featured Image" class="img-fluid mb-3">
        @endif

        <!-- Description -->
        <p><strong>Description:</strong> {!! $blog->description !!}</p>

        <!-- Meta Description -->
        <p style="white-space: pre-wrap"><strong>Meta Description:</strong> {!! $blog->meta_description !!}</p>

        <!-- Tags -->
        <div>
            <strong>Tags:</strong>
            {{-- @foreach ($blog->tags as $tag)
                <span class="badge bg-secondary">{{ $tag->name }}</span>
            @endforeach --}}
        </div>

        <div class="mt-3">
            <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </div>
    </div>

 

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{-- {{ $blog->links() }} <!-- Laravel pagination links --> --}}
    </div>
</div>
@endsection
@push('js')
@endpush