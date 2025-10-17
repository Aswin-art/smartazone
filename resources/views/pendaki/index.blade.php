<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaki Dashboard - Mountain System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #7367F0;
            --success: #28C76F;
        }
        
        .sidebar {
            background: var(--primary);
            color: white;
            min-height: 100vh;
            position: fixed;
            width: 260px;
        }
        
        .main-content {
            margin-left: 260px;
            background: #F8F8F8;
            min-height: 100vh;
        }
        
        .navbar-custom {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .user-badge {
            background: var(--success);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="p-4">
            <h4><i class="mdi mdi-account-circle"></i> Mountain System</h4>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link text-white" href="#"><i class="mdi mdi-view-dashboard"></i> Dashboard</a>
            <a class="nav-link text-white" href="#"><i class="mdi mdi-terrain"></i> Mountain Info</a>
            <a class="nav-link text-white" href="#"><i class="mdi mdi-hiking"></i> My Hikes</a>
            <a class="nav-link text-white" href="#"><i class="mdi mdi-account"></i> Profile</a>
        </nav>
    </div>
    
    <div class="main-content">
        <nav class="navbar navbar-custom">
            <div class="container-fluid">
                <span class="navbar-brand">Pendaki Dashboard</span>
                <div class="d-flex align-items-center">
                    <span class="user-badge me-3">Pendaki</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="mdi mdi-logout"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </nav>
        
        <div class="container-fluid p-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Welcome, Pendaki!</h5>
                            <p class="card-text">Explore mountains and manage your hiking activities.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>