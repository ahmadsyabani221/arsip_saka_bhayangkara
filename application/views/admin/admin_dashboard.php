<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            width: 250px;
            height: 100vh;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
            transition: all 0.3s ease;
        }
        .sidebar.show {
            left: 0;
        }
        .content {
            margin-left: 0;
            padding: 20px;
            transition: all 0.3s ease;
        }
        .content.show {
            margin-left: 250px;
        }
        .burger {
            position: fixed;
            top: 20px;
            left: 20px;
            font-size: 24px;
            cursor: pointer;
            z-index: 1000;
        }
        .burger.show {
            left: 270px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .widget {
            transition: transform 0.3s ease;
        }
        .widget:hover {
            transform: scale(1.05);
        }
        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
            }
            .sidebar.show {
                left: 0;
            }
            .burger {
                display: block;
            }
        }
    </style>
</head>
<body>
    <!-- Burger -->
    <div class="burger" id="burger">
        <i class="fas fa-bars"></i>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="text-center mb-4">
            <img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="Logo" style="height: 50px;">
            <h4>Saka Bhayangkara</h4>
        </div>
        <a href="<?php echo site_url('dashboard'); ?>"><i class="fas fa-home"></i> Dashboard</a>
        <a href="<?php echo site_url('profile'); ?>"><i class="fas fa-user"></i> Profil</a>
        <a href="<?php echo site_url('admin/users'); ?>"><i class="fas fa-users"></i> Pengguna</a>
        <a href="<?php echo site_url('admin/kategori'); ?>"><i class="fas fa-list"></i> Kategori</a>
        <a href="<?php echo site_url('arsip'); ?>"><i class="fas fa-archive"></i> Arsip</a>
        <a href="<?php echo site_url('ganti_password'); ?>"><i class="fas fa-key"></i> Ganti Password</a>
        <a href="<?php echo site_url('auth/logout'); ?>"><i class="fas fa-sign-out-alt"></i> Keluar</a>
    </div>

    <!-- Main Content -->
    <div class="content" id="content">
        <div class="container-fluid">
            <!-- Judul Dashboard -->
            <div class="text-center mb-4">
                <h2>Dashboard Admin</h2>
            </div>

            <!-- Widget Informasi -->
            <div class="row">
                <div class="col-md-6">
                    <a href="<?php echo site_url('admin/users'); ?>" class="text-decoration-none">
                        <div class="card bg-primary text-white widget mb-3">
                            <div class="card-body">
                                <h5>Total Pengguna</h5>
                                <h3><?php echo $total_users; ?></h3>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="<?php echo site_url('arsip'); ?>" class="text-decoration-none">
                        <div class="card bg-success text-white widget mb-3">
                            <div class="card-body">
                                <h5>Total Arsip</h5>
                                <h3><?php echo $total_arsip; ?></h3>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Widget Pengumuman -->
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-bullhorn"></i> Pengumuman</h5>
                </div>
                <div class="card-body">
                    <!-- Form untuk menambahkan pengumuman -->
                    <form action="<?php echo site_url('admin/add_announcement'); ?>" method="post" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="announcement" class="form-control" placeholder="Tulis pengumuman baru..." required>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>

                    <!-- Daftar pengumuman -->
                    <?php if (isset($announcements) && is_array($announcements) && count($announcements) > 0): ?>
                        <ul>
                            <?php foreach ($announcements as $announcement): ?>
                                <li>
                                    <?php echo $announcement['text']; ?>
                                    <a href="<?php echo site_url('admin/delete_announcement/' . $announcement['id']); ?>" 
                                       class="text-danger float-end" 
                                       onclick="return confirm('Hapus pengumuman ini?');">
                                       <i class="fas fa-trash-alt"></i>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>Tidak ada pengumuman.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Widget Last Login -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-clock"></i> Pengguna Terakhir Login</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($last_logins) && is_array($last_logins)): ?>
                        <ul>
                            <?php foreach ($last_logins as $login): ?>
                                <li><?php echo $login['username']; ?> - <?php echo $login['last_login']; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>Tidak ada data pengguna yang login terakhir.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script>
        // Membuat sidebar responsif
        const burger = document.getElementById('burger');
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');

        burger.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            content.classList.toggle('show');
            burger.classList.toggle('show');
        });
    </script>
</body>
</html>
