<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Detail Arsip</title>  
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
        <div class="container mt-5">  
            <h2>Detail Arsip</h2>  
            <div class="row">  
                <!-- Kolom Kiri: Informasi Arsip -->  
                <div class="col-md-4">  
                    <div class="card">  
                        <div class="card-body">  
                            <p><strong>Nama Arsip:</strong> <?php echo $arsip->nama_arsip; ?></p>  
                            <p><strong>Kategori:</strong> <?php echo $arsip->kategori; ?></p>  
                            <p><strong>Diunggah oleh:</strong> <?php echo $arsip->uploaded_by; ?></p>  
                            <?php if (isset($arsip->created_at)): ?>  
                                <p><strong>Tanggal Unggah:</strong> <?php echo date('d-m-Y', strtotime($arsip->created_at)); ?></p>  
                            <?php else: ?>  
                                <p><strong>Tanggal Unggah:</strong> Tidak tersedia</p>  
                            <?php endif; ?>  
                            <p><strong>File:</strong>   
                                <a href="<?php echo base_url('uploads/' . $arsip->file_path); ?>" target="_blank">Download</a>  
                            </p>  
                        </div>  
                    </div>  
                    <!-- Tombol Kembali -->  
                    <button onclick="window.history.back();" class="btn btn-primary mt-3">Kembali</button>  
                </div>  
  
                <!-- Kolom Kanan: Pratinjau Dokumen -->  
                <div class="col-md-8">  
                    <div class="card">  
                        <div class="card-body">  
                            <h5>Pratinjau Dokumen</h5>  
                            <iframe src="<?php echo base_url('uploads/' . $arsip->file_path); ?>" style="width: 100%; height: 500px;" frameborder="0"></iframe>  
                        </div>  
                    </div>  
                </div>  
            </div>  
        </div>  
    </div>  
  
    <script>  
        const burger = document.getElementById('burger');  
        const sidebar = document.getElementById('sidebar');  
        const content = document.getElementById('content');  
  
        burger.addEventListener('click', () => {  
            sidebar.classList.toggle('show');  
            content.classList.toggle('show');  
            burger.classList.toggle('show');  
        });  
    </script>  
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>  
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>  
</body>  
</html>  
