<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Peminjaman Proyektor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        :root {
            --primary-color: #4f46e5;
            --primary-light: #6366f1;
            --primary-dark: #4338ca;
            --sidebar-bg: #1e293b;
            --sidebar-text: #f1f5f9;
            --sidebar-hover: #334155;
            --sidebar-active: #4f46e5;
            --border-color: rgba(255, 255, 255, 0.1);
            --transition-speed: 0.3s;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #f8fafc;
            color: #334155;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            transition: all var(--transition-speed) ease;
            position: relative;
            z-index: 100;
        }

        .sidebar-header {
            padding: 1.5rem 1.5rem 1.2rem;
            border-bottom: 1px solid var(--border-color);
            text-align: center;
            background: rgba(0, 0, 0, 0.2);
        }

        .sidebar-header h3 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .sidebar-header small {
            font-size: 0.8rem;
            color: #94a3b8;
            letter-spacing: 0.5px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 1.5rem 0.75rem;
            flex-grow: 1;
            overflow-y: auto;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-menu::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
        }

        .sidebar-menu li {
            margin-bottom: 0.5rem;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .sidebar-menu li:hover:not(.active) {
            background-color: var(--sidebar-hover);
        }

        .sidebar-menu li.active {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .sidebar-menu li.active a {
            color: white;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            padding: 0.85rem 1.25rem;
            text-decoration: none;
            color: #cbd5e1;
            font-weight: 500;
            transition: all 0.2s;
            position: relative;
        }

        .sidebar-menu li a:hover {
            color: white;
            transform: translateX(5px);
        }

        .sidebar-menu .icon {
            font-size: 1.2rem;
            width: 24px;
            display: flex;
            justify-content: center;
            margin-right: 0.75rem;
            transition: transform 0.2s;
        }

        .sidebar-menu li:hover .icon {
            transform: scale(1.1);
        }

        .sidebar-menu li.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 40%;
            background: white;
            border-radius: 0 4px 4px 0;
        }

        .sidebar-footer {
            padding: 1.25rem 1.5rem;
            border-top: 1px solid var(--border-color);
            background: rgba(0, 0, 0, 0.2);
        }

        .logout {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem;
            text-decoration: none;
            color: #cbd5e1;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .logout:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(239, 68, 68, 0.2);
        }

        .logout .icon {
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .content-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .content-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--sidebar-bg);
            margin-bottom: 0.5rem;
        }

        .content-header p {
            color: #64748b;
            font-size: 1rem;
        }

        /* Dashboard Cards */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .card-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.5rem;
            color: white;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        }

        .card h3 {
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 0.5rem;
            letter-spacing: 0.5px;
        }

        .card .value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--sidebar-bg);
            margin-bottom: 0.5rem;
        }

        .card .trend {
            font-size: 0.85rem;
            color: #10b981;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .card .trend.down {
            color: #ef4444;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: sticky;
                top: 0;
                z-index: 1000;
            }

            .sidebar-menu {
                display: flex;
                overflow-x: auto;
                padding: 1rem 0.5rem;
            }

            .sidebar-menu li {
                flex: 0 0 auto;
                margin: 0 0.25rem;
            }

            .sidebar-menu li a {
                padding: 0.75rem 1rem;
                flex-direction: column;
                text-align: center;
            }

            .sidebar-menu .icon {
                margin-right: 0;
                margin-bottom: 0.25rem;
            }

            .sidebar-menu .text {
                font-size: 0.8rem;
            }

            .main-content {
                padding: 1.5rem;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }

        /* User Profile in Sidebar */
        .user-profile {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            background: rgba(0, 0, 0, 0.1);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 0.75rem;
            font-size: 1rem;
        }

        .user-info h4 {
            font-size: 0.95rem;
            font-weight: 600;
            color: white;
            margin-bottom: 0.15rem;
        }

        .user-info span {
            font-size: 0.8rem;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-video"></i> Sistem Peminjaman</h3>
            <small>Proyektor</small>
        </div>

        <!-- User Profile Section -->
        <div class="user-profile">
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="user-info">
                <h4>Admin</h4>
                <span>Administrator</span>
            </div>
        </div>

        <ul class="sidebar-menu">
            <li data-menu="dashboard">
                <a href="../dashboard/index.php">
                    <span class="icon"><i class="fas fa-home"></i></span>
                    <span class="text">Dashboard</span>
                </a>
            </li>

            <li data-menu="user">
                <a href="../user/index.php">
                    <span class="icon"><i class="fas fa-users"></i></span>
                    <span class="text">Data User</span>
                </a>
            </li>

            <li data-menu="barang">
                <a href="../barang/index.php">
                    <span class="icon"><i class="fas fa-video"></i></span>
                    <span class="text">Data Proyektor</span>
                </a>
            </li>

            <li data-menu="peminjaman">
                <a href="../peminjaman/index.php">
                    <span class="icon"><i class="fas fa-clipboard-list"></i></span>
                    <span class="text">Peminjaman</span>
                </a>
            </li>

            <!-- Additional Menu Items -->
            <li data-menu="laporan">
                <a href="../laporan/index.php">
                    <span class="icon"><i class="fas fa-chart-bar"></i></span>
                    <span class="text">Laporan</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <a href="../../auth/login.php" class="logout">
                <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                <span class="text">Logout</span>
            </a>
        </div>
    </aside>

    
    <script>
        // Sidebar interaction
        document.addEventListener('DOMContentLoaded', function() {
            // Function to set active menu based on current page
            function setActiveMenu() {
                // Get current URL
                const currentPath = window.location.pathname;
                
                // Extract the menu identifier from URL
                let currentMenu = 'dashboard'; // default
                
                if (currentPath.includes('/user/')) {
                    currentMenu = 'user';
                } else if (currentPath.includes('/barang/')) {
                    currentMenu = 'barang';
                } else if (currentPath.includes('/peminjaman/')) {
                    currentMenu = 'peminjaman';
                } else if (currentPath.includes('/laporan/')) {
                    currentMenu = 'laporan';
                } else if (currentPath.includes('/kategori/')) {
                    currentMenu = 'kategori';
                }
                
                // Remove active class from all items
                const menuItems = document.querySelectorAll('.sidebar-menu li');
                menuItems.forEach(item => {
                    item.classList.remove('active');
                });
                
                // Add active class to current menu item
                const activeItem = document.querySelector(`[data-menu="${currentMenu}"]`);
                if (activeItem) {
                    activeItem.classList.add('active');
                }
            }
            
            // Set active menu on page load
            setActiveMenu();
            
            // Add click event to menu items
            const menuLinks = document.querySelectorAll('.sidebar-menu li a');
            menuLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Don't prevent default - let the link work normally
                    // We'll handle active state via URL detection
                    
                    // Get the menu item
                    const menuItem = this.closest('li');
                    const menuType = menuItem.dataset.menu;
                    
                    // Store in sessionStorage for immediate feedback
                    sessionStorage.setItem('activeMenu', menuType);
                    
                    // For demonstration, we'll set active class immediately
                    // In real implementation, this would be handled by the server
                    const allItems = document.querySelectorAll('.sidebar-menu li');
                    allItems.forEach(item => item.classList.remove('active'));
                    menuItem.classList.add('active');
                });
            });
            
            // Check for stored active menu (for immediate feedback)
            const storedMenu = sessionStorage.getItem('activeMenu');
            if (storedMenu) {
                const allItems = document.querySelectorAll('.sidebar-menu li');
                allItems.forEach(item => item.classList.remove('active'));
                
                const storedItem = document.querySelector(`[data-menu="${storedMenu}"]`);
                if (storedItem) {
                    storedItem.classList.add('active');
                }
            }

            // Mobile sidebar toggle
            function toggleSidebar() {
                const sidebar = document.querySelector('.sidebar');
                const currentHeight = sidebar.style.height;
                
                if (window.innerWidth <= 768) {
                    if (currentHeight === '60px' || !currentHeight) {
                        sidebar.style.height = 'auto';
                        sidebar.style.position = 'absolute';
                        sidebar.style.left = '0';
                        sidebar.style.right = '0';
                        sidebar.style.zIndex = '1000';
                    } else {
                        sidebar.style.height = '60px';
                        sidebar.style.overflow = 'hidden';
                    }
                }
            }

            // Handle window resize
            window.addEventListener('resize', function() {
                const sidebar = document.querySelector('.sidebar');
                if (window.innerWidth > 768) {
                    sidebar.style.height = 'auto';
                    sidebar.style.position = 'relative';
                }
            });
            
            // Add visual feedback for active state changes
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                        const target = mutation.target;
                        if (target.classList.contains('active')) {
                            // Add animation for newly active item
                            target.style.animation = 'none';
                            setTimeout(() => {
                                target.style.animation = 'fadeIn 0.3s ease';
                            }, 10);
                        }
                    }
                });
            });
            
            // Observe all menu items for class changes
            const menuItems = document.querySelectorAll('.sidebar-menu li');
            menuItems.forEach(item => {
                observer.observe(item, { attributes: true });
            });
        });

        // Smooth hover effects
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    </script>
</body>
</html>