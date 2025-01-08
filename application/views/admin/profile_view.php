<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
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
        .profile-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 30px;
            justify-content: center;
            align-items: center;
        }
        .profile-picture img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .profile-data {
            max-width: 400px;
            width: 100%;
        }
        .profile-data form {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .profile-data h5 {
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
        .form-control {
            margin-bottom: 15px;
        }
        .btn-primary {
            width: 100%;
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
        <div class="container">
            <h2 class="text-center">Profil</h2>

            <!-- Tampilkan pesan sukses atau error -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
            <?php elseif ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?php echo $this->session->flashdata ('error'); ?></div>
            <?php endif; ?>

            <!-- Kontainer Profil -->
            <div class="profile-container">
                <!-- Foto Profil -->
                <div class="profile-picture">
                    <?php 
                    if (isset($user) && isset($user->profile_picture) && !empty($user->profile_picture)) {
                        $profile_picture = base_url('uploads/profile_pics/' . $user->profile_picture);
                    } else {
                        $profile_picture = base_url('assets/images/default_profile.png');
                    }
                    ?>
                    <img src="<?php echo $profile_picture; ?>" alt="Foto Profil" class="img-thumbnail">
                </div>

                <!-- Data Diri -->
                <div class="profile-data">
                    <h5>Data Diri</h5>
                    <form action="<?php echo site_url('profile/update_profile/' . $user->id); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" id="username" value="<?php echo $user->username; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="<?php echo $user->email; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="profile_picture">Foto Profil</label>
                            <input type="file" class="form-control" name="profile_picture" id="profile_picture">
                        </div>
                        <button type="submit" class="btn btn-primary">Perbarui Profil</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script>
        // Script untuk toggle sidebar
        document.getElementById('burger').onclick = function() {
            document.getElementById('sidebar').classList.toggle('show');
            document.getElementById('content').classList.toggle('show');
            this.classList.toggle('show');
        };

        // Menghilangkan pesan alert setelah 1 detik
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                alert.style.display = 'none';
            });
        }, 1000);
    </script>
</body>
</html>