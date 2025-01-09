<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna</title>
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
            overflow-y: hidden;
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
                <h2>Managemen Pengguna</h2>
            </div>

            <!-- Kontainer untuk tombol -->
            <div class="button-container text-end">
                <a href="<?php echo site_url('admin/add_user'); ?>" class="btn btn-primary">Tambah Pengguna</a>
            </div>

            <!-- Kontainer untuk teks "Show ... entries" dan dropdown pilihan entries -->
            <div class="entries-container">
                <div class="d-flex justify-content-between">
                    <div>
                        <span>Show</span>
                        <select id="entriesSelect" onchange="updateEntries()">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span>Entries</span>
                    </div>
                    <div class="search-container">
                        <label for="search">Search</label>
                        <input type="text" id="search" placeholder="" class="form-control" onkeyup="searchUsers()">
                    </div>
                </div>
            </div>

            <!-- Tabel Data -->
            <table id="userTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th> 
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php $index = 1; // Inisialisasi index untuk nomor pengguna ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo $index++; // Tampilkan nomor pengguna dan increment index ?></td>
                                <td><?php echo $user->username; ?></td>
                                <td><?php echo $user->email; ?></td>
                                <td><?php echo $user->role; ?></td>
                                <td>
                                    <a href="<?php echo site_url('admin/edit_user/' . $user->id); ?>" class="btn btn-primary">Edit</a>
                                    <a href="<?php echo site_url('admin/delete_user/' . $user->id); ?>" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus pengguna ini?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="no-users">Tidak ada pengguna ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script>
        function searchUsers() {
            const input = document.getElementById('search');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('userTable');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td');
                let found = false;
                for (let j = 0; j < td.length - 1; j++) {
                    if (td[j]) {
                        const txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }
                tr[i].style.display = found ? "" : "none";
            }
        }

        function updateEntries() {
            const select = document.getElementById('entriesSelect');
            const selectedValue = select.value;
            const tableRows = document.querySelectorAll('#userTable tbody tr');
            tableRows.forEach((row, index) => {
                row.style.display = index < selectedValue ? '' : 'none';
            });
        }
    </script>
    <!-- Script untuk toggle sidebar -->
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
</body>
</html>