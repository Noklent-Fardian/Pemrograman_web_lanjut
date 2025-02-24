<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="container-fluid px-4">
  
    <div class="hero-section text-center py-5 mb-5 rounded-lg bg-gradient position-relative overflow-hidden">
        <div class="hero-overlay"></div>
        <div class="position-relative">
            <h1 class="display-3 fw-bold text-white mb-3">POS System Noklent FArdian</h1>
            <p class="lead text-white-50">Streamline your business operations with modern solutions</p>
        </div>
    </div>

   
    <div class="row g-4 mb-5">
        <div class="col-md-6 col-lg-3">
            <div class="dashboard-card h-100 rounded-4 border-0">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-circle bg-primary-subtle">
                            <i class="fas fa-box text-primary fs-4"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-3">Products</h5>
                    <p class="text-muted small mb-4">Manage your inventory efficiently</p>
                    <a href="{{ route('product.index') }}" class="btn btn-primary w-100 btn-modern">
                        <span>Go to Products</span>
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="dashboard-card h-100 rounded-4 border-0">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-circle bg-success-subtle">
                            <i class="fas fa-shopping-cart text-success fs-4"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-3">Sales</h5>
                    <p class="text-muted small mb-4">Track your transactions seamlessly</p>
                    <a href="{{ route('sales.index') }}" class="btn btn-success w-100 btn-modern">
                        <span>Go to Sales</span>
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="dashboard-card h-100 rounded-4 border-0">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-circle bg-info-subtle">
                            <i class="fas fa-users text-info fs-4"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-3">Users</h5>
                    <p class="text-muted small mb-4">Manage user accounts</p>
                    <a href="{{ route('users.index') }}" class="btn btn-info w-100 btn-modern">
                        <span>Go to Users</span>
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient {
            background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            padding: 4rem 0;
            position: relative;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="rgba(255,255,255,0.05)"/></svg>') center/cover;
            opacity: 0.1;
        }
    
        .dashboard-card {
            background: #fff;
            transition: all 0.3s ease;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
    
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.15);
        }
    
        .icon-circle {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            transition: all 0.3s ease;
        }
    
        .dashboard-card:hover .icon-circle {
            transform: scale(1.1);
        }

        .bg-primary-subtle { background-color: rgba(67, 97, 238, 0.1); }
        .bg-success-subtle { background-color: rgba(16, 185, 129, 0.1); }
        .bg-info-subtle { background-color: rgba(59, 130, 246, 0.1); }
    
        .btn-modern {
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
    
        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
    
        .display-3 {
            font-size: 3.75rem;
            letter-spacing: -1px;
            font-weight: 800;
        }

        .lead {
            font-size: 1.375rem;
            font-weight: 400;
        }
    </style>
</div>
