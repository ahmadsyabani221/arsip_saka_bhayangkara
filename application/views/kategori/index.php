<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kategori</title>
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
            <img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="Logo" style=" height: 50px;">
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
                <h2>Manajemen Kategori</h2>
            </div>

            <!-- Tombol Tambah Kategori di sebelah kanan -->
            <div class="mb-3 text-end">
                <a href="<?php echo site_url('admin/add_category'); ?>" class="btn btn-primary">Tambah Kategori</a>
            </div>

            <!-- Search dan Entries -->
            <div class="mb-3">
                <div class="row align-items-center">
                    <!-- Entries -->
                    <div class="col-md-6 text-md-start">
                        <div class="form-group d-flex align-items-center">
                            <label for="entries" class="me-2 mb-0">Tampilkan:</label>
                            <select class="form-control w-auto" id="entries">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <span class="ms-2">Entries</span>
                        </div>
                    </div>
                    <!-- Search -->
                    <div class="col-md-6 text-md-end">
                        <div class="form-group d-flex justify-content-md-end">
                            <input type="text" class="form-control w-auto" id="search" placeholder="Cari kategori...">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Data -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($categories)): ?>
                        <?php $index = 1; ?>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?php echo $index++; ?></td>
                                <td><?php echo $category->nama; ?></td>
                                <td><?php echo $category->keterangan; ?></td>
                                <td>
                                    <a href="<?php echo site_url('admin/edit_category/' . $category->id); ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="<?php echo site_url('admin/delete_category/' . $category->id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus kategori ini?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada kategori ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script>
        // Toggle Sidebar
        const burger = document.getElementById('burger');
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');

        burger.addEventListener('click', function () {
            sidebar.classList.toggle('show');
            content.classList.toggle('show');
            burger.classList.toggle('show');
        });

        // Search
        const searchInput = document.getElementById('search');
        searchInput.addEventListener('keyup', function() {
            const searchValue = searchInput.value.toLowerCase();
            const tableRows = document.querySelectorAll('table tbody tr');
            tableRows.forEach(function (row) {
                const rowText = row.textContent.toLowerCase();
                if (rowText.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Entries
        const entriesSelect = document.getElementById('entries');
        entriesSelect.addEventListener('change', function() {
            const entriesValue = parseInt(entriesSelect.value);
            const tableRows = document.querySelectorAll('table tbody tr');
            tableRows.forEach(function(row, index) {
                row.style.display = index < entriesValue ? '' : 'none';
            });
        });
    </script>
</body>
</html>