<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blog Application')</title>
    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Custom CSS (If you had it, optional) -->
    {{-- <!-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --> --}}
</head>
@stack('css')
<body>
    <!-- Header -->
    <header class="bg-dark text-white py-3">
        <div class="container d-flex justify-content-between">
            <div class="logo">
                <a href="{{ url('/') }}" class="text-white text-decoration-none fs-3">BlogApp</a>
            </div>
            <nav>
                <ul class="nav">
                    <li class="nav-item"><a href="{{ route('blogs.index') }}" class="nav-link text-white">Home</a></li>
                    <li class="nav-item"><a href="{{ route('blogs.create') }}" class="nav-link text-white">Create Blog</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container py-4">
        @yield('content') <!-- Content from individual pages will be inserted here -->
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2025 BlogApp. All Rights Reserved.</p>
    </footer>

    <!-- Bootstrap 5 JS & Popper.js (Optional but needed for some components like dropdowns, modals) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
               }
           });
       });
       
           $(document).ready(function(){
               $('.summernote').summernote({
                   height:250
               });
              
           });
       </script>
        @stack('js')
</body>
</html>
