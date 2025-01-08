<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Arsip</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
</head>
<body>
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

    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
</body>
</html>