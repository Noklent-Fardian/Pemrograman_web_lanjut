<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PWL POS - Point of Sale System</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>
    <section class="hero">
        <div class="background-elements">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
        </div>
        
        <div class="content">
            <div class="text-content">
                <h1>PWL <span>Point of Sale</span> Nokurento</h1>
                <p>Effortlessly manage your inventory, track sales, and streamline your business operations with our comprehensive POS solution.</p>
                
                <div class="features">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="feature-text">
                            <h3>Real-time Analytics</h3>
                            <p>Monitor your sales and inventory with powerful dashboard analytics (Under Maintenance).</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="feature-text">
                            <h3>Inventory Management</h3>
                            <p>Track your stock.</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div class="feature-text">
                            <h3>Sales Processing</h3>
                            <p>Process transactions. (Under Maintenante)</p>
                        </div>
                    </div>
                </div>
                
                <div class="buttons">
                    <a href="{{ url('login') }}" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i>
                        Login
                    </a>
                </div>
            </div>
            
        </div>
    </section>
</body>
</html>