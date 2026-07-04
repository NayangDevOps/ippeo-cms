<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }} Admin</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Summernote WYSIWYG -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

    <style>
        .note-editor .note-toolbar { background: #f8f9fa !important; }
        .note-editor.note-frame { border-color: #dee2e6 !important; border-radius: 8px !important; }
    </style>

    @stack('styles')
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-leaf me-2"></i>Admin</h3>
                <button type="button" id="sidebarClose" class="btn btn-sm btn-outline-light d-lg-none" style="border:none;color:rgba(255,255,255,0.5)">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="sidebar-menu">
                <div class="menu-label">Main</div>

                <div class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </div>

                <div class="menu-label">Content</div>

                <div class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.products.index') }}">
                        <i class="fas fa-box"></i> Products
                    </a>
                </div>

                <div class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.categories.index') }}">
                        <i class="fas fa-list"></i> Categories
                    </a>
                </div>

                <div class="nav-item {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.blogs.index') }}">
                        <i class="fas fa-blog"></i> Blog
                    </a>
                </div>

                <div class="nav-item {{ request()->routeIs('admin.cms-pages.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.cms-pages.index') }}">
                        <i class="fas fa-file-alt"></i> CMS Pages
                    </a>
                </div>

                <div class="nav-item {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.faqs.index') }}">
                        <i class="fas fa-question-circle"></i> FAQs
                    </a>
                </div>

                <div class="menu-label">Marketing</div>

                <div class="nav-item {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.banners.index') }}">
                        <i class="fas fa-image"></i> Banners
                    </a>
                </div>

                <div class="nav-item {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.testimonials.index') }}">
                        <i class="fas fa-quote-left"></i> Testimonials
                    </a>
                </div>

                <div class="nav-item {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.tags.index') }}">
                        <i class="fas fa-tags"></i> Tags
                    </a>
                </div>

                <div class="nav-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.reviews.index') }}">
                        <i class="fas fa-star"></i> Reviews
                    </a>
                </div>

                <div class="nav-item {{ request()->routeIs('admin.homepage-sections.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.homepage-sections.index') }}">
                        <i class="fas fa-home"></i> Homepage Sections
                    </a>
                </div>

                <div class="menu-label">Management</div>

                <div class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users"></i> Users
                    </a>
                </div>

                <div class="nav-item {{ request()->routeIs('admin.contact-inquiries.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.contact-inquiries.index') }}">
                        <i class="fas fa-envelope"></i> Contact Inquiries
                    </a>
                </div>

                <div class="nav-item {{ request()->routeIs('admin.newsletters.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.newsletters.index') }}">
                        <i class="fas fa-paper-plane"></i> Newsletter
                    </a>
                </div>

                <div class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.settings.index') }}">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                </div>
            </div>

            <div class="sidebar-footer">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="user-info">
                        <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                        <div>
                            <div class="user-name">{{ auth()->user()->name }}</div>
                            <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
                        </div>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-sm logout-btn p-1" title="Logout">
                            <i class="fas fa-sign-out-alt fa-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div id="content">
            <!-- Top Navbar -->
            <nav class="top-navbar">
                <div class="d-flex align-items-center gap-3">
                    <button type="button" id="sidebarToggle" class="hamburger">
                        <i class="fas fa-bars"></i>
                    </button>
                    <span class="page-title">@yield('title', 'Dashboard')</span>
                </div>
                <div class="navbar-actions">
                    <a href="{{ route('home') }}" class="btn btn-outline-success btn-sm" target="_blank">
                        <i class="fas fa-eye me-1"></i> View Site
                    </a>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="page-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show shadow-sm">
                        <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle text-danger me-2"></i>Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Are you sure you want to delete this item? This action cannot be undone.</p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-danger" id="deleteConfirmBtn">
                        <i class="fas fa-trash me-1"></i>Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Spinner -->
    <div class="spinner-overlay" id="loadingSpinner">
        <div class="spinner-border text-success" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (required for Summernote) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- Summernote WYSIWYG -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>

    <script>
        // Sidebar toggle
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            if (window.innerWidth <= 992) {
                document.getElementById('sidebar').classList.toggle('show');
            } else {
                document.getElementById('sidebar').classList.toggle('collapsed');
                document.getElementById('content').classList.toggle('expanded');
            }
        });

        document.getElementById('sidebarClose')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('show');
        });

        // Delete confirmation modal
        let deleteUrl = '';
        function confirmDelete(url) {
            deleteUrl = url;
            var modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }
        document.getElementById('deleteConfirmBtn')?.addEventListener('click', function() {
            if (deleteUrl) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteUrl;
                form.style.display = 'none';
                var csrf = document.createElement('input');
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);
                var method = document.createElement('input');
                method.name = '_method';
                method.value = 'DELETE';
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
            }
        });

        // Auto-hide alerts after 5 seconds
        document.querySelectorAll('.alert-dismissible').forEach(function(alert) {
            setTimeout(function() {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });

        // Show loading spinner on form submits
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function() {
                if (!form.querySelector('button[type="submit"]')?.disabled) {
                    document.getElementById('loadingSpinner')?.classList.add('show');
                }
            });
        });

        // Initialize Summernote on all textareas with class 'wysiwyg'
        $(document).ready(function() {
            $('.wysiwyg').summernote({
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
