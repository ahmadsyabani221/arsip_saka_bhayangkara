<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirim Arsip</title>
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
        .card {
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .alert {
            margin-top: 20px;
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
            <h1 class="text-center mt-4">Kirim Arsip</h1>

            <!-- Tampilkan pesan sukses atau gagal -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success" id="flash-message">
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger" id="flash-message">
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <!-- Form untuk memilih user -->
            <form action="<?php echo site_url('arsip/proses_kirim/' . $arsip->id); ?>" method="post">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5>Detail Arsip</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_arsip">Nama Arsip:</label>
                            <input type="text" name="nama_arsip" id="nama_arsip" class="form-control" value="<?php echo $arsip->nama_arsip; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori:</label>
                            <input type="text" name="kategori" id="kategori" class="form-control" value="<?php echo $arsip->kategori; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="user_ids">Pilih User:</label>
                            <select name="user_ids[]" id="user_ids" class="form-control" multiple required>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?php echo $user->id; ?>"><?php echo $user->username; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-muted">Gunakan Ctrl (Windows) atau Command (Mac) untuk memilih beberapa user.</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?php echo site_url('arsip'); ?>" class="btn btn-primary">Batal</a>
                        <button type="submit" class="btn btn-success">Kirim Arsip</button>
                        
                    </div>
                </div>
            </form>
        </div>
    </div>

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

    // Menghilangkan pesan setelah 1 detik
    setTimeout(function() {
        var flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            flashMessage.style.transition = "opacity 0.5s ease";
            flashMessage.style.opacity = 0;
            setTimeout(function() {
                flashMessage.remove();
            }, 500);
        }
    }, 1000);
</script>
</body>
</html>