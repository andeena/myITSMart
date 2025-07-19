<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Admin Panel myITS Mart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
        .sidebar {
            position: fixed; top: 0; bottom: 0; left: 0; z-index: 100;
            padding: 48px 0 0; box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }
        .main-content { margin-left: 220px; }
    </style>
</head>
<body>
    <header class="navbar navbar-dark sticky-top bg-primary flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">myITS Mart Admin</a>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt fa-fw me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.products.index') }}">
                                <i class="fas fa-box-open fa-fw me-2"></i> Manajemen Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.orders.index') }}">
                                <i class="fas fa-receipt fa-fw me-2"></i> Manajemen Pesanan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.users.index') }}">
                                <i class="fas fa-users fa-fw me-2"></i> Manajemen Pengguna
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('title')</h1>
                </div>
                
                @yield('content')
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>