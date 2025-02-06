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

    <!-- Blog Table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Meta Title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($blogs as $blog)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $blog->title }}</td>
                        <td>{{ $blog->meta_title }}</td>
                        <td>
                            <!-- Edit Button -->
                            <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="{{ route('blogs.show', $blog->id) }}" class="btn btn-warning btn-sm">Show</a>

                            <!-- Delete Button with Confirmation -->
                            <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $blogs->links() }} <!-- Laravel pagination links -->
    </div>
</div>
@endsection
