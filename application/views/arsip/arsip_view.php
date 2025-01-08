<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Arsip</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
</head>
<body>
    <div class="container mt-5">
        <h2>Daftar Arsip</h2>

        <!-- Tampilkan pesan sukses atau error -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Arsip</th>
                    <th>Tanggal Upload</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($arsip)): ?>
                    <?php foreach ($arsip as $item): ?>
                        <tr>
                            <td><?php echo $item->id; ?></td>
                            <td><?php echo $item->nama_arsip; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($item->created_at)); ?></td>
                            <td>
                                <a href="<?php echo site_url('arsip/view/' . $item->id); ?>" class="btn btn-info">View</a>
                                <!-- Tambahkan tombol edit dan delete jika diperlukan -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada arsip ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
</body>
</html>