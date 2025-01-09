<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Arsip</title>
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
                <h2>Managemen Arsip</h2>
            </div>

            <!-- Kontainer untuk tombol -->
            <div class="button-container text-end">
                <a href="<?php echo site_url('arsip/add'); ?>" class="btn btn-primary">Tambah Arsip</a>
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
                        <span>entries</span>
                    </div>
                    <div class="search-container">
                        <label for="search">Search</label>
                        <input type="text" id="search" placeholder="" class="form-control" onkeyup="searchArsip()">
                    </div>
                </div>
            </div>

            <!-- Tabel Data -->
            <table id="arsipTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Arsip</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($arsip)): ?>
                        <?php $index = 1; // Inisialisasi index untuk nomor arsip ?>
                        <?php foreach ($arsip as $item): ?>
                            <tr>
                                <td><?php echo $index++; // Tampilkan nomor arsip dan increment index ?></td>
                                <td><?php echo $item->nama_arsip; ?></td>
                                <td><?php echo $item->kategori; ?></td>
                                <td>
                                    <a href="<?php echo site_url('arsip/edit/' . $item->id); ?>" class="btn btn-primary">Edit</a>
                                    <a href="<?php echo site_url('arsip/view/' . $item->id); ?>" class="btn btn-info">View</a>
                                    <a href="<?php echo site_url('arsip/delete/' . $item->id); ?>" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus arsip ini?');">Hapus</a>
                                    <a href="<?php echo site_url('arsip/kirim/' . $item->id); ?>" class="btn btn-success">Kirim</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="no-arsip">Tidak ada arsip ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script>
        function searchArsip() {
            const input = document.getElementById('search');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('arsipTable');
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
            console.log("Entries to show: " + selectedValue);
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